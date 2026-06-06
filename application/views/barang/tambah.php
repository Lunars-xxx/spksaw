<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-box"></i> Tambah Barang</h1>
    
    <a href="<?= base_url('Barang'); ?>" class="btn btn-secondary btn-icon-split shadow-sm">
        <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
        <span class="text">Kembali</span>
    </a>
</div>

<div class="card shadow mb-4 border-bottom-info">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-plus"></i> Form Input Data Barang</h6>
    </div>
    <div class="card-body">
        <?= form_open('Barang/simpan'); ?>
            
            <div class="form-group">
                <label class="font-weight-bold">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>
            </div>

            <hr>

            <button type="submit" class="btn btn-success shadow-sm"><i class="fa fa-save"></i> Simpan Data</button>
            <button type="reset" class="btn btn-secondary"><i class="fa fa-sync-alt"></i> Reset</button>

        <?= form_close(); ?>
    </div>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>