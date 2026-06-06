<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-edit"></i> Edit Barang</h1>
    
    <a href="<?= base_url('Barang'); ?>" class="btn btn-secondary btn-icon-split shadow-sm">
        <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
        <span class="text">Kembali</span>
    </a>
</div>

<div class="card shadow mb-4 border-bottom-info">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-edit"></i> Form Edit Data Barang</h6>
    </div>
    <div class="card-body">
        <?= form_open('Barang/update'); ?>
            
            <input type="hidden" name="id_barang" value="<?= $barang->id_barang; ?>">

            <div class="form-group">
                <label class="font-weight-bold">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="<?= $barang->nama_barang; ?>" placeholder="Masukkan nama barang" required>
            </div>

            <hr>

            <button type="submit" class="btn btn-success shadow-sm"><i class="fa fa-save"></i> Update Data</button>
            <button type="reset" class="btn btn-secondary"><i class="fa fa-sync-alt"></i> Reset</button>

        <?= form_close(); ?>
    </div>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>