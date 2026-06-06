<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Supplier</h1>
    <a href="<?= base_url('Alternatif/create'); ?>" class="btn btn-success shadow-sm"> 
        <i class="fa fa-plus fa-sm text-white-50"></i> Tambah Data 
    </a>
</div>

<?php if ($this->session->flashdata('message')): ?>
    <?= $this->session->flashdata('message'); ?>
    <?php $this->session->unset_userdata('message'); ?>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-lg-6">
        <form action="<?= base_url('Alternatif/index'); ?>" method="GET">
            <div class="input-group shadow-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-box text-gray-500"></i></span>
                </div>
                <select name="id_barang" class="form-control border-left-0" onchange="this.form.submit()" required>
                    <?php if(empty($list_barang)): ?>
                        <option value="" disabled selected>Belum ada data barang di database...</option>
                    <?php endif; ?>
                    
                    <?php foreach($list_barang as $brg): ?>
                        <option value="<?= $brg->id_barang ?>" <?= ($id_barang_aktif == $brg->id_barang) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brg->nama_barang) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if(!empty($id_barang_aktif)): ?>
<div class="card shadow mb-4 border-bottom-info">
    <div class="card-header py-3 bg-white">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fa fa-table"></i> Daftar Supplier untuk Barang: <span class="text-dark"><?= htmlspecialchars($nama_barang_aktif); ?></span>
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-info text-white text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Supplier</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($list)): ?>
                        <?php $no = 1; foreach ($list as $value): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($value->nama) ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="<?= base_url('Alternatif/edit/'.$value->id_alternatif) ?>" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="<?= base_url('Alternatif/destroy/'.$value->id_alternatif) ?>" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?')" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-danger font-weight-bold py-4">
                                <i class="fas fa-exclamation-circle mb-2"></i><br>
                                Belum ada supplier yang ditambahkan untuk barang ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $this->load->view('layouts/footer_admin'); ?>