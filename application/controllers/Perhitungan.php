<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Perhitungan extends CI_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('Perhitungan_model');
            
            // Kita load juga Penilaian_model untuk memanggil fungsi list barang & batch
            // karena fungsinya sama persis dengan yang ada di halaman Penilaian
            $this->load->model('Penilaian_model');

            // --- PERBAIKAN HAK AKSES ---
            // Mengambil level user yang sedang login
            $level_user = $this->session->userdata('id_user_level');

            // Jika level user BUKAN 1 (Admin) DAN BUKAN 2 (User), maka tendang ke login!
            // Artinya Admin dan User diizinkan masuk.
            if ($level_user != "1" && $level_user != "2") {
            ?>
                <script type="text/javascript">
                    alert('Anda tidak berhak mengakses halaman ini atau sesi Anda telah habis!');
                    window.location='<?php echo base_url("Login/home"); ?>'
                </script>
            <?php
            }
        }

        public function index()
        {
            // 1. Panggil daftar barang dan daftar batch untuk dropdown filter
            $list_barang = $this->Penilaian_model->get_all_barang();
            $list_batch  = $this->Penilaian_model->get_all_batch(); 

            // 2. Menangkap id dari method GET URL
            $id_barang = $this->input->get('id_barang');
            $id_batch  = $this->input->get('id_batch');
            
            // 3. LOGIKA BARANG & Validasi Ghost Session
            if (!empty($id_barang)) {
                $this->session->set_userdata('last_opened_barang_hitung', $id_barang);
            } else {
                $id_barang = $this->session->userdata('last_opened_barang_hitung');
                
                // Cek apakah barang di session masih ada di database
                $barang_valid = false;
                if (!empty($list_barang)) {
                    foreach ($list_barang as $b) {
                        if ($b->id_barang == $id_barang) {
                            $barang_valid = true;
                            break;
                        }
                    }
                }
                
                // Jika tidak valid/kosong, reset ke barang pertama
                if (!$barang_valid) {
                    if (!empty($list_barang)) {
                        $id_barang = $list_barang[0]->id_barang;
                        $this->session->set_userdata('last_opened_barang_hitung', $id_barang);
                    } else {
                        $id_barang = null;
                        $this->session->unset_userdata('last_opened_barang_hitung');
                    }
                }
            }

            // 4. LOGIKA BATCH/SLOT & Validasi Ghost Session
            if (!empty($id_batch)) {
                $this->session->set_userdata('last_opened_batch_hitung', $id_batch);
            } else {
                $id_batch = $this->session->userdata('last_opened_batch_hitung');
                
                // Cek apakah batch di session masih ada di database
                $batch_valid = false;
                if (!empty($list_batch)) {
                    foreach ($list_batch as $b) {
                        if ($b->id_batch == $id_batch) {
                            $batch_valid = true;
                            break;
                        }
                    }
                }
                
                // Jika data batch sudah dihapus, kosongkan ingatan session
                if (!$batch_valid) {
                    $id_batch = null;
                    $this->session->unset_userdata('last_opened_batch_hitung');
                }
            }
            
            // 5. PERBAIKAN: Hanya muat tabel alternatif JIKA Barang DAN Batch sama-sama terisi & valid
            if ($id_barang && $id_batch) {
                // Kita gunakan fungsi dari Penilaian_model karena sudah ada join ke tabel katalog
                $alternatif = $this->Penilaian_model->get_alternatif_by_barang($id_barang);
            } else {
                $alternatif = [];
            }

            // 6. Mengirim data ke View perhitungan/perhitungan.php
            $data = [
                'page'            => "Perhitungan",
                'list_barang'     => $list_barang, 
                'list_batch'      => $list_batch, 
                'id_barang_aktif' => $id_barang, 
                'id_batch_aktif'  => $id_batch,  
                'kriteria'        => $this->Perhitungan_model->get_kriteria(),
                'alternatif'      => $alternatif
            ];
            
            // Mengarah ke file perhitungan.php di dalam folder perhitungan
            $this->load->view('perhitungan/perhitungan', $data);
        }

        // ====================================================================
        // FUNGSI UNTUK MENAMPILKAN HALAMAN HASIL (RANKING)
        // ====================================================================
        public function hasil()
        {
            // 1. Panggil daftar barang dan daftar batch untuk dropdown filter di View Hasil
            $list_barang = $this->Penilaian_model->get_all_barang();
            $list_batch  = $this->Penilaian_model->get_all_batch(); 

            // 2. Menangkap id dari form filter (jika user memilih dropdown di halaman hasil)
            $get_id_barang = $this->input->get('id_barang');
            $get_id_batch  = $this->input->get('id_batch');

            // 3. Update session jika ada request GET baru dari form, jika tidak gunakan session lama + Validasi
            if (!empty($get_id_barang)) {
                $this->session->set_userdata('last_opened_barang_hitung', $get_id_barang);
                $id_barang = $get_id_barang;
            } else {
                $id_barang = $this->session->userdata('last_opened_barang_hitung');
                
                // Validasi barang di halaman hasil
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
                    $id_barang = (!empty($list_barang)) ? $list_barang[0]->id_barang : null;
                }
            }

            if (!empty($get_id_batch)) {
                $this->session->set_userdata('last_opened_batch_hitung', $get_id_batch);
                $id_batch = $get_id_batch;
            } else {
                $id_batch = $this->session->userdata('last_opened_batch_hitung');
                
                // Validasi batch di halaman hasil
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
                    $this->session->unset_userdata('last_opened_batch_hitung');
                }
            }

            // 4. Jika id_batch kosong (belum hitung data/belum pilih), atur hasil kosong.
            // Jika ada isinya, panggil data dari model.
            if (empty($id_batch)) {
                $hasil_ranking = []; 
            } else {
                // Mengambil data ranking dari database khusus untuk batch tersebut
                $hasil_ranking = $this->Perhitungan_model->get_hasil($id_batch);
            }

            // 5. Mengirim data ke View hasil.php
            $data = [
                'page'            => "Hasil",
                'list_barang'     => $list_barang, // Tambahan untuk dropdown filter
                'list_batch'      => $list_batch,  // Tambahan untuk dropdown filter
                'id_barang_aktif' => $id_barang,
                'id_batch_aktif'  => $id_batch,
                'hasil'           => $hasil_ranking
            ];
            
            // Mengarah ke file hasil.php di dalam folder perhitungan
            $this->load->view('perhitungan/hasil', $data);
        }
        
    }
?>