<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alternatif_model extends CI_Model {

    public function tampil()
    {
        $query = $this->db->get('alternatif');
        return $query->result();
    }

    public function getTotal()
    {
        return $this->db->count_all('alternatif');
    }

    // Fungsi tambahan untuk mengambil barang milik supplier tertentu (Dibutuhkan di halaman Edit)
    public function get_barang_by_alternatif($id_alternatif)
    {
        $this->db->where('id_alternatif', $id_alternatif);
        $query = $this->db->get('katalog');
        return $query->result();
    }

    public function show($id_alternatif)
    {
        $this->db->where('id_alternatif', $id_alternatif);
        $query = $this->db->get('alternatif');
        return $query->row();
    }

    public function insert($data = [])
    {
        // 1. Insert master data ke tabel alternatif
        $data_alternatif = ['nama' => $data['nama']];
        $this->db->insert('alternatif', $data_alternatif);
        
        // Ambil ID yang baru saja digenerate
        $id_alternatif = $this->db->insert_id();

        // 2. Insert data barang ke tabel katalog (jika ada barang yang diinput)
        if (isset($data['nama_barang']) && is_array($data['nama_barang'])) {
            $katalog_data = [];
            foreach ($data['nama_barang'] as $barang) {
                if (!empty($barang)) {
                    $katalog_data[] = [
                        'id_alternatif' => $id_alternatif,
                        'nama_barang'   => $barang
                    ];
                }
            }
            
            // Insert banyak data sekaligus (batch)
            if (!empty($katalog_data)) {
                $this->db->insert_batch('katalog', $katalog_data);
            }
        }
        
        return true;
    }

    public function update($id_alternatif, $data = [])
    {
        // 1. Update data master (tabel alternatif)
        $ubah = array(
            'nama'  => $data['nama']
        );
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->update('alternatif', $ubah);

        // 2. Update relasi barang (tabel katalog)
        if (isset($data['nama_barang']) && is_array($data['nama_barang'])) {
            
            // Cara termudah dan teraman: Hapus semua relasi barang yang lama untuk ID ini
            $this->db->where('id_alternatif', $id_alternatif);
            $this->db->delete('katalog');

            // Kemudian Insert ulang data yang baru dari form
            $katalog_data = [];
            foreach ($data['nama_barang'] as $barang) {
                if (!empty($barang)) {
                    $katalog_data[] = [
                        'id_alternatif' => $id_alternatif,
                        'nama_barang'   => $barang
                    ];
                }
            }

            if (!empty($katalog_data)) {
                $this->db->insert_batch('katalog', $katalog_data);
            }
        }
    }

    public function delete($id_alternatif)
    {
        // 1. Hapus (bersihkan) semua data relasi di tabel perantara (katalog) terlebih dahulu
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->delete('katalog'); 

        // 2. Setelah relasinya bersih, baru hapus master datanya di tabel alternatif
        $this->db->where('id_alternatif', $id_alternatif);
        $this->db->delete('alternatif');
    }
}