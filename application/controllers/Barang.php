<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->library('form_validation');
        
        // Cek sesi login
        if($this->session->userdata('id_user_level') == NULL){
            $this->session->set_tempdata('message', '<div class="alert alert-danger">Silakan login terlebih dahulu!</div>', 1);
            redirect('Login/home');
        }
    }

    public function index()
    {
        $data['page'] = "Data Barang";
        $data['barang'] = $this->Barang_model->get_all(); 
        $this->load->view('barang/index', $data);
    }

    public function detail($id_barang)
    {
        $data['page'] = "Detail Barang";
        $data['barang'] = $this->Barang_model->get_by_id($id_barang);
        
        if(empty($data['barang'])) {
            $this->session->set_tempdata('message', '<div class="alert alert-danger">Data barang tidak ditemukan!</div>', 1);
            redirect('Barang');
        }

        $this->load->view('barang/detail', $data);
    }

    public function tambah()
    {
        $data['page'] = "Tambah Data Barang";
        $this->load->view('barang/tambah', $data);
    }

    public function simpan()
    {
        // HANYA memvalidasi nama barang
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim', [
            'required' => 'Nama Barang wajib diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->tambah(); 
        } else {
            // HANYA menyimpan nama barang
            $data = [
                'nama_barang'   => $this->input->post('nama_barang', true)
            ];

            $this->Barang_model->insert($data);
            $this->session->set_tempdata('message', '<div class="alert alert-success">Data berhasil ditambahkan!</div>', 1);
            redirect('Barang');
        }
    }

    public function edit($id_barang)
    {
        $data['page'] = "Edit Data Barang";
        $data['barang'] = $this->Barang_model->get_by_id($id_barang);
        
        if(empty($data['barang'])) {
            $this->session->set_tempdata('message', '<div class="alert alert-danger">Data barang tidak ditemukan!</div>', 1);
            redirect('Barang');
        }

        $this->load->view('barang/edit', $data);
    }

    public function update()
    {
        $id_barang = $this->input->post('id_barang');

        // HANYA memvalidasi nama barang
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim', [
            'required' => 'Nama Barang wajib diisi!'
        ]);
        
        if ($this->form_validation->run() == false) {
            $this->edit($id_barang);
        } else {
            // HANYA mengupdate nama barang
            $data = [
                'nama_barang'   => $this->input->post('nama_barang', true)
            ];

            $this->Barang_model->update($id_barang, $data);
            $this->session->set_tempdata('message', '<div class="alert alert-success">Data berhasil diupdate!</div>', 1);
            redirect('Barang');
        }
    }

    public function hapus($id_barang)
    {
        $data_barang = $this->Barang_model->get_by_id($id_barang);
        
        if (!empty($data_barang)) {
            $this->Barang_model->delete($id_barang);
            $this->session->set_tempdata('message', '<div class="alert alert-success">Data berhasil dihapus!</div>', 1);
        } else {
            $this->session->set_tempdata('message', '<div class="alert alert-danger">Data tidak ditemukan!</div>', 1);
        }

        redirect('Barang');
    }
}