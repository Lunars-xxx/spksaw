<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Sub_kriteria extends CI_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->library('pagination');
            $this->load->library('form_validation');
            $this->load->model('Sub_Kriteria_model');

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
            $data = [
                'page' => "Sub Kriteria",
                'list' => $this->Sub_Kriteria_model->tampil(),
                'kriteria'=> $this->Sub_Kriteria_model->get_kriteria(),
                'count_kriteria'=> $this->Sub_Kriteria_model->count_kriteria(),
                'sub_kriteria' => $this->Sub_Kriteria_model->tampil()
                
            ];
            $this->load->view('sub_kriteria/index', $data);
        }

        //menambahkan data ke database
        public function store()
        {
            $data = [
                'id_kriteria' => $this->input->post('id_kriteria'),
                'deskripsi' => $this->input->post('deskripsi'),
                'nilai' => $this->input->post('nilai')
            ];
            
            $this->form_validation->set_rules('id_kriteria', 'ID Kriteria', 'required');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
            $this->form_validation->set_rules('nilai', 'Nilai', 'required');

            if ($this->form_validation->run() != false) {
                $result = $this->Sub_Kriteria_model->insert($data);
                if ($result) {
                    // Ditambahkan alert-dismissible dan tombol close
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil disimpan! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('sub_kriteria');
                }
            } else {
                // Ditambahkan alert-dismissible dan tombol close
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data gagal disimpan! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                // Ubah redirect agar kembali ke index, sehingga flashdata langsung dieksekusi dan tidak nyangkut
                redirect('sub_kriteria'); 
            }
        }
    
        public function update($id_sub_kriteria)
        {
            $id_sub_kriteria = $this->input->post('id_sub_kriteria');
            $data = array(
                'id_kriteria' => $this->input->post('id_kriteria'),
                'deskripsi' => $this->input->post('deskripsi'),
                'nilai' => $this->input->post('nilai')
            );

            $this->Sub_Kriteria_model->update($id_sub_kriteria, $data);
            // Ditambahkan alert-dismissible dan tombol close
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil diupdate! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('sub_kriteria');
        }
    
        public function destroy($id_sub_kriteria)
        {
            $this->Sub_Kriteria_model->delete($id_sub_kriteria);
            // Ditambahkan alert-dismissible dan tombol close
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('sub_kriteria');
        }
    }