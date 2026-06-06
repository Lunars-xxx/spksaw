<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Laporan extends CI_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Perhitungan_model');
            // Load juga model Penilaian agar bisa mengambil nama barang
            $this->load->model('Penilaian_model'); 
        }

        public function index()
        {
            // 1. Menangkap parameter dari URL (dikirim dari tombol Cetak di hasil.php)
            $id_batch  = $this->input->get('id_batch');
            $id_barang = $this->input->get('id_barang');

            // 2. Mengambil data hasil berdasarkan ID Batch yang dipilih
            $data['hasil'] = $this->Perhitungan_model->get_hasil($id_batch);

            // 3. Mengambil nama barang untuk judul laporan
            // Gunakan query builder untuk mengambil nama barang
            $barang = $this->db->get_where('barang', ['id_barang' => $id_barang])->row_array();
            $data['nama_barang'] = isset($barang['nama_barang']) ? $barang['nama_barang'] : 'Semua Barang';

            // 4. Load view langsung ke file 'laporan.php' (tanpa masuk ke dalam folder)
            $this->load->view('laporan', $data);
        } 
    }
?>