<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Penilaian extends CI_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->library('form_validation');
            $this->load->model('Penilaian_model');

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
            $id_barang_get = $this->input->get('id_barang');
            $id_batch_get  = $this->input->get('id_batch');

            // =========================================================================
            // TRIK ANTI-GAGAL: DETEKSI LOAD BARU & MUNCULKAN ALERT
            // =========================================================================
            if ($id_barang_get !== NULL && $id_batch_get !== NULL) {
                // Cek apakah pilihan dropdown BERBEDA dengan yang sebelumnya dibuka
                if ($this->session->userdata('last_opened_barang') != $id_barang_get || $this->session->userdata('last_opened_batch') != $id_batch_get) {
                    
                    // Simpan ke session agar tidak terjadi infinite loop
                    $this->session->set_userdata('last_opened_barang', $id_barang_get);
                    $this->session->set_userdata('last_opened_batch', $id_batch_get);

                    // Set Notifikasi Sukses
                    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle"></i> Data Penilaian berhasil diload.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                    
                    // Redirect paksa agar alert langsung muncul di layar
                    redirect('Penilaian?id_batch='.$id_batch_get.'&id_barang='.$id_barang_get);
                }
            }

            $list_barang = $this->Penilaian_model->get_all_barang();
            $list_batch  = $this->Penilaian_model->get_all_batch(); 
            
            // 1. Logika & Validasi Session untuk Barang
            if (!empty($id_barang_get)) {
                $id_barang = $id_barang_get;
            } else {
                $id_barang = $this->session->userdata('last_opened_barang');
                
                $barang_valid = false;
                if (!empty($list_barang)) {
                    foreach ($list_barang as $b) {
                        if ($b->id_barang == $id_barang) {
                            $barang_valid = true;
                            break;
                        }
                    }
                }
                
                if (!$barang_valid) {
                    if (!empty($list_barang)) {
                        $id_barang = $list_barang[0]->id_barang;
                        $this->session->set_userdata('last_opened_barang', $id_barang);
                    } else {
                        $id_barang = null;
                        $this->session->unset_userdata('last_opened_barang');
                    }
                }
            }

            // 2. Logika & Validasi Session untuk Penilaian (Ghost Session Handler)
            if (!empty($id_batch_get)) {
                $id_batch = $id_batch_get;
            } else {
                $id_batch = $this->session->userdata('last_opened_batch');
                
                $batch_valid = false;
                if (!empty($list_batch)) {
                    foreach ($list_batch as $b) {
                        if ($b->id_batch == $id_batch) {
                            $batch_valid = true;
                            break;
                        }
                    }
                }
                
                if (!$batch_valid) {
                    $id_batch = null;
                    $this->session->unset_userdata('last_opened_batch');
                }
            }
            
            if ($id_barang) {
                $alternatif = $this->Penilaian_model->get_alternatif_by_barang($id_barang);
            } else {
                $alternatif = [];
            }

            $data = [
                'page'            => "Penilaian",
                'list'            => $this->Penilaian_model->tampil(),
                'list_barang'     => $list_barang, 
                'list_batch'      => $list_batch, 
                'id_barang_aktif' => $id_barang, 
                'id_batch_aktif'  => $id_batch,   
                'kriteria'        => $this->Penilaian_model->get_kriteria(),
                'alternatif'      => $alternatif, 
                'sub_kriteria'    => $this->Penilaian_model->get_sub_kriteria(),
                'perhitungan'     => $this->Penilaian_model->tampil()                
            ];
            $this->load->view('penilaian/index', $data);
        }

        public function buat_batch_baru()
        {
            $this->Penilaian_model->insert_batch_baru();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> Slot Penilaian Baru Berhasil Dibuat! Silakan Load data tersebut.</div>');
            redirect('Penilaian');
        }
        
        public function tambah_penilaian()
        {
            $id_alternatif = $this->input->post('id_alternatif');
            $id_kriteria   = $this->input->post('id_kriteria');
            $nilai         = $this->input->post('nilai');
            
            $filter_id_barang = $this->input->post('filter_id_barang');
            $id_batch         = $this->input->post('id_batch');

            $i = 0;
            foreach ($nilai as $key) {
                $this->Penilaian_model->tambah_penilaian($id_alternatif, $id_kriteria[$i], $key, $id_batch);
                $i++;
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><i class="fas fa-save"></i> Data berhasil disimpan ke Penilaian ini!</div>');
            redirect('Penilaian?id_batch='.$id_batch.'&id_barang='.$filter_id_barang);
        }

        public function update_penilaian()
        {
            $id_alternatif = $this->input->post('id_alternatif');
            $id_kriteria   = $this->input->post('id_kriteria');
            $nilai         = $this->input->post('nilai');

            $filter_id_barang = $this->input->post('filter_id_barang');
            $id_batch         = $this->input->post('id_batch');

            $i = 0;
            foreach ($nilai as $key) {
                $cek = $this->Penilaian_model->data_penilaian($id_alternatif, $id_kriteria[$i], $id_batch);
                
                if ($cek == 0) {
                    $this->Penilaian_model->tambah_penilaian($id_alternatif, $id_kriteria[$i], $key, $id_batch);
                } else {
                    $this->Penilaian_model->edit_penilaian($id_alternatif, $id_kriteria[$i], $key, $id_batch);   
                }
                $i++;
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><i class="fas fa-edit"></i> Data berhasil diupdate pada Penilaian ini!</div>');
            redirect('Penilaian?id_batch='.$id_batch.'&id_barang='.$filter_id_barang);
        }

        // =========================================================================
        // TAMBAHAN: FUNGSI UNTUK MENGHAPUS SATU SLOT BATCH PENILAIAN SECARA PERMANEN
        // =========================================================================
        public function hapus_batch($id_batch)
        {
            $this->Penilaian_model->hapus_batch_permanen($id_batch);
            
            // Hapus ingatan session agar tidak terjadi error ghost session
            $this->session->unset_userdata('last_opened_batch');
            
            // Tampilkan pesan sukses berwarna merah (danger)
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><i class="fas fa-trash"></i> Data Penilaian Berhasil Dihapus!</div>');
            
            redirect('Penilaian');
        }

        // =========================================================================
        // TAMBAHAN: FUNGSI UNTUK MENGHAPUS NILAI SATU SUPPLIER (ALTERNATIF)
        // =========================================================================
        public function hapus_nilai_supplier($id_alternatif, $id_batch, $id_barang)
        {
            $this->Penilaian_model->hapus_nilai_alternatif($id_alternatif, $id_batch);
            
            // Set notifikasi sukses berwarna merah
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><i class="fas fa-trash"></i> Nilai berhasil dihapus!</div>');
            
            // Arahkan kembali ke halaman index sambil membawa parameter barang & batch yang sedang aktif
            redirect('Penilaian?id_batch='.$id_batch.'&id_barang='.$id_barang);
        }
    }
?>