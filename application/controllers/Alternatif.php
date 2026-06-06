<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->model('Alternatif_model');

        // Pengecekan sesi login
        if ($this->session->userdata('id_user_level') != "1") {
        ?>
            <script type="text/javascript">
                alert('Anda tidak berhak mengakses halaman ini!');
                window.location='<?php echo base_url("Login/home"); ?>'
            </script>
        <?php
        }
    }

    public function index()
    {
        $data['page'] = "Alternatif";

        // 1. Ambil daftar barang dari database untuk Dropdown
        $this->db->select('id_barang, nama_barang');
        $this->db->from('barang');
        $this->db->order_by('nama_barang', 'ASC');
        $list_barang = $this->db->get()->result();
        $data['list_barang'] = $list_barang;

        // 2. Logika Session (Mengingat Barang Terakhir Dibuka agar Sinkron dengan Menu Lain)
        $id_barang = $this->input->get('id_barang');
        
        if (!empty($id_barang)) {
            $this->session->set_userdata('last_opened_barang', $id_barang);
        } else {
            $id_barang = $this->session->userdata('last_opened_barang');
            if (empty($id_barang) && !empty($list_barang)) {
                $id_barang = $list_barang[0]->id_barang;
                $this->session->set_userdata('last_opened_barang', $id_barang);
            }
        }
        
        $data['id_barang_aktif'] = $id_barang;

        // 3. Dapatkan nama barang aktif untuk ditampilkan di Judul Tabel
        $nama_barang_aktif = "";
        foreach($list_barang as $b) {
            if($b->id_barang == $id_barang) {
                $nama_barang_aktif = $b->nama_barang;
                break;
            }
        }
        $data['nama_barang_aktif'] = $nama_barang_aktif;

        // 4. Logika untuk menampilkan data Supplier
        if (!empty($id_barang)) {
            $this->db->select('alternatif.*');
            $this->db->from('alternatif');
            $this->db->join('katalog', 'katalog.id_alternatif = alternatif.id_alternatif');
            $this->db->where('katalog.id_barang', $id_barang);
            $this->db->group_by('alternatif.id_alternatif'); 
            
            $data['list'] = $this->db->get()->result();
        } else {
            $data['list'] = []; 
        }

        $this->load->view('alternatif/index', $data);
    }
    
    // menampilkan view create
    public function create()
    {
        $data['page'] = "Alternatif";

        $this->db->select('nama_barang');
        $this->db->distinct();
        $this->db->from('barang');
        $this->db->where('nama_barang !=', ''); 
        $this->db->order_by('nama_barang', 'ASC'); 
        $data['list_barang'] = $this->db->get()->result();

        $this->load->view('alternatif/create', $data);
    }

    // menambahkan data ke database (Alternatif & Barang)
    public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');              

        if ($this->form_validation->run() != false) {
            
            // 1. Simpan ke tabel 'alternatif'
            $data_alternatif = ['nama' => $this->input->post('nama')];
            $this->db->insert('alternatif', $data_alternatif);
            
            // 2. Dapatkan ID Alternatif yang baru saja di-generate
            $id_alternatif = $this->db->insert_id(); 

            // 3. Tangkap array nama barang dari input form dinamis
            $nama_barang_array = $this->input->post('nama_barang');

            // 4. Looping dan simpan relasi ke tabel 'katalog'
            if (!empty($nama_barang_array)) {
                foreach ($nama_barang_array as $barang) {
                    if (!empty(trim($barang))) {
                        $this->db->select('id_barang');
                        $this->db->where('nama_barang', trim($barang));
                        $data_brg = $this->db->get('barang')->row();

                        if ($data_brg) {
                            $this->db->insert('katalog', [
                                'id_alternatif' => $id_alternatif,
                                'id_barang'     => $data_brg->id_barang
                            ]);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Supplier beserta Barang berhasil disimpan!</div>');
            redirect('Alternatif');
            
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan! Pastikan form diisi dengan benar.</div>');
            redirect('Alternatif/create');
        }
    }

    public function edit($id_alternatif)
    {
        $data['page'] = "Alternatif";
        $data['alternatif'] = $this->Alternatif_model->show($id_alternatif);

        // 1. Ambil daftar semua barang untuk dropdown pilihan (Sama seperti create)
        $this->db->select('nama_barang');
        $this->db->distinct();
        $this->db->from('barang');
        $this->db->where('nama_barang !=', '');
        $this->db->order_by('nama_barang', 'ASC');
        $data['list_barang'] = $this->db->get()->result();

        // 2. Ambil daftar barang yang SUDAH DIMILIKI supplier ini
        $this->db->select('barang.nama_barang');
        $this->db->from('katalog');
        $this->db->join('barang', 'barang.id_barang = katalog.id_barang');
        $this->db->where('katalog.id_alternatif', $id_alternatif);
        $data['barang_supplier'] = $this->db->get()->result();

        $this->load->view('alternatif/edit', $data);
    }

    public function update($id_alternatif = null)
    {
        // Menggunakan param $id_alternatif dari form post
        $id_alternatif_post = $this->input->post('id_alternatif');
        $nama_supplier = $this->input->post('nama');
        $nama_barang_array = $this->input->post('nama_barang');

        // 1. Update nama supplier menggunakan Model
        $this->Alternatif_model->update($id_alternatif_post, ['nama' => $nama_supplier]);

        // 2. Bersihkan (Hapus) relasi lama di tabel katalog khusus untuk supplier ini
        $this->db->where('id_alternatif', $id_alternatif_post);
        $this->db->delete('katalog');

        // 3. Masukkan relasi barang baru (Mirip dengan logika di fungsi store)
        if (!empty($nama_barang_array)) {
            foreach ($nama_barang_array as $barang) {
                if (!empty(trim($barang))) {
                    
                    // Cari id_barang berdasarkan namanya
                    $this->db->select('id_barang');
                    $this->db->where('nama_barang', trim($barang));
                    $data_brg = $this->db->get('barang')->row();

                    // Jika barang ada, insert relasi baru
                    if ($data_brg) {
                        $this->db->insert('katalog', [
                            'id_alternatif' => $id_alternatif_post,
                            'id_barang'     => $data_brg->id_barang
                        ]);
                    }
                }
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Supplier dan Barang berhasil diupdate!</div>');
        redirect('Alternatif');
    }

    public function destroy($id_alternatif)
    {
        $this->Alternatif_model->delete($id_alternatif);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');
        redirect('Alternatif');
    }
}