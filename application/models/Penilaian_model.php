<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Penilaian_model extends CI_Model {

        public function tampil()
        {
            $query = $this->db->get('penilaian');
            return $query->result();
        }

        // =========================================================================
        // CRUD Penilaian dengan Parameter id_batch
        // =========================================================================

        public function tambah_penilaian($id_alternatif, $id_kriteria, $nilai, $id_batch)
        {
            $data = [
                'id_alternatif' => $id_alternatif,
                'id_kriteria'   => $id_kriteria,
                'nilai'         => $nilai,
                'id_batch'      => $id_batch 
            ];
            return $this->db->insert('penilaian', $data);  
        }
       
        public function edit_penilaian($id_alternatif, $id_kriteria, $nilai, $id_batch)
        {
            $data = [
                'nilai' => $nilai
            ];
            $this->db->where('id_alternatif', $id_alternatif);
            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->where('id_batch', $id_batch); 
            return $this->db->update('penilaian', $data);  
        }

        public function delete($id_penilaian)
        {
            $this->db->where('id_penilaian', $id_penilaian);
            $this->db->delete('penilaian');
        }
       
        public function get_kriteria()
        {
            $query = $this->db->get('kriteria');
            return $query->result();
        }

        public function get_alternatif()
        {
            $query = $this->db->query("SELECT * FROM alternatif");
            return $query->result();
        }

        public function get_sub_kriteria()
        {
            $query = $this->db->get('sub_kriteria');
            return $query->result();
        }

        // --- PENGAMANAN EKSTRA UNTUK GHOST SESSION ---
        public function data_penilaian($id_alternatif, $id_kriteria, $id_batch = null)
        {
            if (empty($id_batch)) return null; 

            $this->db->where('id_alternatif', $id_alternatif);
            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->where('id_batch', $id_batch);
            
            $query = $this->db->get('penilaian');
            return $query->row_array();
        }

        public function untuk_tombol($id_alternatif, $id_batch = null)
        {
            if (empty($id_batch)) return 0;

            $this->db->where('id_alternatif', $id_alternatif);
            $this->db->where('id_batch', $id_batch);
            
            $query = $this->db->get('penilaian');
            return $query->num_rows();
        }

        public function data_sub_kriteria($id_kriteria)
        {
            $query = $this->db->query("SELECT * FROM sub_kriteria WHERE id_kriteria='$id_kriteria' ORDER BY nilai DESC;");
            return $query->result_array();
        }

        public function data_nilai($id_alternatif, $id_kriteria, $id_batch = null)
        {
            if (empty($id_batch)) return null;

            $this->db->select('*');
            $this->db->from('penilaian');
            $this->db->join('sub_kriteria', 'penilaian.nilai = sub_kriteria.id_sub_kriteria');
            $this->db->where('penilaian.id_alternatif', $id_alternatif);
            $this->db->where('penilaian.id_kriteria', $id_kriteria);
            $this->db->where('penilaian.id_batch', $id_batch);
            
            $query = $this->db->get();
            return $query->row_array();
        }
        // ---------------------------------------------

        // =========================================================================
        // Filter Berdasarkan Barang
        // =========================================================================

        public function get_all_barang()
        {
            $query = $this->db->get('barang');
            return $query->result();
        }

        public function get_alternatif_by_barang($id_barang)
        {
            $this->db->select('alternatif.*, barang.nama_barang');
            $this->db->from('katalog');
            $this->db->join('alternatif', 'alternatif.id_alternatif = katalog.id_alternatif');
            $this->db->join('barang', 'barang.id_barang = katalog.id_barang');
            $this->db->where('katalog.id_barang', $id_barang);
            
            $this->db->group_by('alternatif.id_alternatif');
            
            $query = $this->db->get();
            return $query->result();
        }

        // =========================================================================
        // Mengelola Batch (Slot Penilaian) & Fitur Hapus
        // =========================================================================

        public function get_all_batch()
        {
            $this->db->order_by('id_batch', 'DESC'); 
            $query = $this->db->get('batch_penilaian');
            return $query->result();
        }

        public function insert_batch_baru()
        {
            $this->db->select_max('id_batch');
            $query = $this->db->get('batch_penilaian')->row_array();
            
            $max_id = ($query['id_batch'] != null) ? $query['id_batch'] : 0;
            $urutan_baru = $max_id + 1;
            
            $nama_batch = "Penilaian " . $urutan_baru;
            
            $data = [
                'nama_batch' => $nama_batch
            ];
            
            $this->db->insert('batch_penilaian', $data);
        }

        public function hapus_batch_permanen($id_batch)
        {
            $this->db->where('id_batch', $id_batch);
            $this->db->delete('penilaian');

            $this->db->where('id_batch', $id_batch);
            $this->db->delete('hasil');

            $this->db->where('id_batch', $id_batch);
            $this->db->delete('batch_penilaian');
        }

        // INILAH FUNGSI YANG DICARI OLEH SISTEM
        public function hapus_nilai_alternatif($id_alternatif, $id_batch)
        {
            $this->db->where('id_alternatif', $id_alternatif);
            $this->db->where('id_batch', $id_batch);
            $this->db->delete('penilaian');

            $this->db->where('id_alternatif', $id_alternatif);
            $this->db->where('id_batch', $id_batch);
            $this->db->delete('hasil');
        }
    }
?>