<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Perhitungan_model extends CI_Model {
       
        public function get_kriteria()
        {
            $query = $this->db->get('kriteria');
            return $query->result();
        }

        public function get_alternatif()
        {
            $query = $this->db->get('alternatif');
            return $query->result();
        }
        
        // ====================================================================
        // UPDATE: Tambahkan parameter $id_batch untuk mengambil nilai spesifik
        // ====================================================================
        public function data_nilai($id_alternatif, $id_kriteria, $id_batch = null)
        {
            $this->db->select('*');
            $this->db->from('penilaian');
            $this->db->join('sub_kriteria', 'penilaian.nilai=sub_kriteria.id_sub_kriteria');
            $this->db->where('penilaian.id_alternatif', $id_alternatif);
            $this->db->where('penilaian.id_kriteria', $id_kriteria);
            
            // Filter berdasarkan Batch
            if ($id_batch != null) {
                $this->db->where('penilaian.id_batch', $id_batch);
            }
            
            return $this->db->get()->row_array();
        }
                
        // UPDATE: Tambahkan parameter $id_batch
        public function get_nilai($id_kriteria, $id_batch = null)
        {
            $this->db->select('sub_kriteria.nilai');
            $this->db->from('penilaian');
            $this->db->join('sub_kriteria', 'penilaian.nilai=sub_kriteria.id_sub_kriteria');
            $this->db->where('penilaian.id_kriteria', $id_kriteria);
            
            // Filter berdasarkan Batch
            if ($id_batch != null) {
                $this->db->where('penilaian.id_batch', $id_batch);
            }
            
            return $this->db->get()->result_array();
        }

        // ====================================================================
        // PERBAIKAN 1: Mencari Nilai Max/Min KHUSUS untuk BATCH yang dipilih
        // ====================================================================
        public function get_max_min($id_kriteria, $id_batch = null)
        {
            $this->db->select('max(sub_kriteria.nilai) as max, min(sub_kriteria.nilai) as min, kriteria.jenis');
            $this->db->from('penilaian');
            $this->db->join('sub_kriteria', 'penilaian.nilai=sub_kriteria.id_sub_kriteria');
            $this->db->join('kriteria', 'penilaian.id_kriteria=kriteria.id_kriteria');
            
            $this->db->where('penilaian.id_kriteria', $id_kriteria);
            
            // Perbandingan Max/Min HANYA dilakukan pada supplier di batch yang sama
            if ($id_batch != null) {
                $this->db->where('penilaian.id_batch', $id_batch);
            }
            
            return $this->db->get()->row_array();
        }
        
        // ====================================================================
        // PERBAIKAN 2: Menampilkan hasil (ranking) KHUSUS BATCH yang dipilih
        // ====================================================================
        public function get_hasil($id_batch = null)
        {
            $this->db->select('hasil.*');
            $this->db->from('hasil');
            
            // Filter hanya hasil dari batch yang dipilih
            if ($id_batch != null) {
                $this->db->where('hasil.id_batch', $id_batch);
            }

            $this->db->order_by('hasil.nilai', 'DESC');
            return $this->db->get()->result();
        }
        
        public function get_hasil_alternatif($id_alternatif)
        {
            $this->db->where('id_alternatif', $id_alternatif);
            return $this->db->get('alternatif')->row_array();    
        }
        
        public function insert_nilai_hasil($hasil_akhir = [])
        {
            $result = $this->db->insert('hasil', $hasil_akhir);
            return $result;
        }
        
        // ====================================================================
        // PERBAIKAN 3: Jangan TRUNCATE, Hapus hanya hasil pada BATCH tersebut
        // ====================================================================
        public function hapus_hasil($id_batch = null)
        {
            // Hapus (reset) perhitungan HANYA milik batch ini agar tidak mengganggu batch lain
            if ($id_batch != null) {
                $this->db->where('id_batch', $id_batch);
                $this->db->delete('hasil');
            } else {
                // Fallback (jika karena suatu alasan id_batch kosong)
                $this->db->truncate('hasil');
            }
        }
    }
?>