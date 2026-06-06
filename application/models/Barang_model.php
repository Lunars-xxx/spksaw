<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    // Ambil semua data (Sederhana, hanya fokus ke master barang)
    public function get_all()
    {
        // Mengurutkan dari yang terbaru/terlama
        $this->db->order_by('id_barang', 'ASC');
        return $this->db->get('barang')->result();
    }

    public function get_barang($id_barang)
    {
        $this->db->where('id_barang', $id_barang);
        return $this->db->get('barang')->row();
    }

    // Ambil 1 data berdasarkan ID (Untuk Edit/Detail)
    public function get_by_id($id_barang)
    {
        $this->db->where('id_barang', $id_barang);
        return $this->db->get('barang')->row();
    }

    // Simpan Data
    public function insert($data)
    {
        return $this->db->insert('barang', $data);
    }

    // Update Data
    public function update($id_barang, $data)
    {
        $this->db->where('id_barang', $id_barang);
        return $this->db->update('barang', $data);
    }

    // Hapus Data (PERBAIKAN PENTING: Tetap dipertahankan)
    public function delete($id_barang)
    {
        // 1. Hapus dulu relasinya di tabel pivot 'katalog' agar tidak ada data "hantu"
        $this->db->where('id_barang', $id_barang);
        $this->db->delete('katalog');

        // 2. Baru hapus master barangnya
        $this->db->where('id_barang', $id_barang);
        return $this->db->delete('barang');
    }
}