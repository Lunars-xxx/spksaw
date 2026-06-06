<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
        <i class="fas fa-fw fa-box mr-2"></i>Data Barang
    </h1>
    <a href="<?= base_url('Barang/tambah'); ?>" class="btn btn-success btn-icon-split shadow">
        <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
        <span class="text">Tambah Barang</span>
    </a>
</div>

<?php if($this->session->tempdata('message')): ?>
    <?= $this->session->tempdata('message'); ?>
<?php endif; ?>

<div class="card shadow mb-4 border-left-info">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Daftar Data Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th width="5%" class="align-middle">No</th>
                        <th class="align-middle">Nama Barang</th>
                        <th width="20%" class="align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach ($barang as $b) { ?>
                    <tr>
                        <td align="center" class="align-middle font-weight-bold"><?=$no++ ?></td>
                        
                        <td class="align-middle font-weight-bold text-dark">
                            <?= $b->nama_barang ?>
                        </td>
                        
                        <td align="center" class="align-middle">
                            <div class="btn-group" role="group">
                                <a data-toggle="tooltip" title="Edit" href="<?=base_url('Barang/edit/'.$b->id_barang)?>" class="btn btn-warning btn-sm shadow-sm"><i class="fa fa-edit text-white"></i></a>
                                <a data-toggle="tooltip" title="Hapus" href="<?=base_url('Barang/hapus/'.$b->id_barang)?>" onclick="return confirm ('Yakin hapus <?php echo $b->nama_barang; ?>?')" class="btn btn-danger btn-sm shadow-sm"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>