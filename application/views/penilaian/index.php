<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-edit"></i> Data Penilaian</h1>
    <a href="<?= base_url('Penilaian/buat_batch_baru') ?>" class="btn btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Buat Penilaian Baru
    </a>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter"></i> Load Data Penilaian</h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('Penilaian') ?>" method="GET">
            <div class="row">
                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-archive"></i></span>
                        </div>
                        <select name="id_batch" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Penilaian --</option>
                            <?php if (!empty($list_batch)): ?>
                                <?php foreach ($list_batch as $batch): ?>
                                    <option value="<?= $batch->id_batch ?>" <?= (isset($id_batch_aktif) && $id_batch_aktif == $batch->id_batch) ? 'selected' : '' ?>>
                                        <?= $batch->nama_batch ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                        </div>
                        <select name="id_barang" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            <?php if (!empty($list_barang)): ?>
                                <?php foreach ($list_barang as $brg): ?>
                                    <option value="<?= $brg->id_barang ?>" <?= (isset($id_barang_aktif) && $id_barang_aktif == $brg->id_barang) ? 'selected' : '' ?>>
                                        <?= $brg->nama_barang ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                        <i class="fas fa-search"></i> Load
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($id_barang_aktif) && !empty($id_batch_aktif)): ?>
<div class="card shadow mb-4 border-bottom-info">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Daftar Penilaian Supplier (Penilaian Aktif)</h6>
        
        <a href="<?= base_url('Penilaian/hapus_batch/'.$id_batch_aktif) ?>" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus seluruh data pada Penilaian ini? Semua nilai dan hasil perhitungan akan hilang permanen!');">
            <i class="fas fa-trash fa-sm"></i> Hapus Penilaian Ini
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th width="45%">Nama Supplier</th>
                        <th width="25%">Status Penilaian Ini</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alternatif)): ?>
                        <tr>
                            <td colspan="4" align="center" class="text-danger py-4 font-weight-bold">
                                <i class="fas fa-exclamation-circle mb-2"></i><br>
                                Tidak ada data supplier yang terhubung dengan barang ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = 1;
                        foreach ($alternatif as $keys): 
                            $cek_tombol    = $this->Penilaian_model->untuk_tombol($keys->id_alternatif, $id_batch_aktif);
                            $nama_barang   = isset($keys->nama_barang) ? $keys->nama_barang : '-';
                            $nama_supplier = isset($keys->nama_supplier) ? $keys->nama_supplier : (isset($keys->nama) ? $keys->nama : '-');
                        ?>
                        <tr align="center">
                            <td><?= $no ?></td>
                            <td align="left"><?= $nama_supplier ?></td>
                            
                            <td>
                                <?php if ($cek_tombol == 0): ?>
                                    <span class="badge badge-danger px-3 py-2">Belum Dinilai</span>
                                <?php else: ?>
                                    <span class="badge badge-success px-3 py-2">Sudah Dinilai</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($cek_tombol == 0): ?>
                                    <a data-toggle="modal" href="#set<?= $keys->id_alternatif ?>" class="btn btn-primary btn-sm">
                                        <i class="fa fa-plus-circle"></i> Input Nilai
                                    </a>
                                <?php else: ?>
                                    <div class="btn-group" role="group">
                                        <a data-toggle="modal" href="#edit<?= $keys->id_alternatif ?>" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit Nilai
                                        </a>
                                        <a href="<?= base_url('Penilaian/hapus_nilai_supplier/'.$keys->id_alternatif.'/'.$id_batch_aktif.'/'.$id_barang_aktif) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus nilai untuk supplier ini? Data perhitungan akhir untuk supplier ini juga akan direset.');">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                    <?php endif; ?>
                            </td>
                        </tr>

                        <div class="modal fade" id="set<?= $keys->id_alternatif ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa fa-plus-circle text-primary"></i> Input Penilaian Supplier</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <?= form_open('Penilaian/tambah_penilaian') ?>
                                        <input type="hidden" name="filter_id_barang" value="<?= $id_barang_aktif ?>">
                                        <input type="hidden" name="id_batch" value="<?= $id_batch_aktif ?>"> 
                                        
                                        <div class="modal-body">
                                            <div class="alert alert-info">
                                                <strong>Barang:</strong> <?= $nama_barang ?> <br>
                                                <strong>Supplier:</strong> <?= $nama_supplier ?>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <?php foreach ($kriteria as $key): ?>
                                                    <?php $sub_kriteria = $this->Penilaian_model->data_sub_kriteria($key->id_kriteria); ?>
                                                    <?php if (!empty($sub_kriteria)): ?>
                                                        <input type="hidden" name="id_alternatif" value="<?= $keys->id_alternatif ?>">
                                                        <input type="hidden" name="id_kriteria[]" value="<?= $key->id_kriteria ?>">
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold"><?= $key->keterangan ?></label>
                                                                <select name="nilai[]" class="form-control border-primary" required>
                                                                    <option value="" disabled selected>-- Pilih Penilaian --</option>
                                                                    <?php foreach ($sub_kriteria as $subs_kriteria): ?>
                                                                        <option value="<?= $subs_kriteria['id_sub_kriteria'] ?>"><?= $subs_kriteria['deskripsi'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Penilaian</button>
                                        </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit<?= $keys->id_alternatif ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa fa-edit text-warning"></i> Edit Penilaian Supplier</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <?= form_open('Penilaian/update_penilaian') ?>
                                        <input type="hidden" name="filter_id_barang" value="<?= $id_barang_aktif ?>">
                                        <input type="hidden" name="id_batch" value="<?= $id_batch_aktif ?>"> 
                                        
                                        <div class="modal-body">
                                            <div class="alert alert-info">
                                                <strong>Barang:</strong> <?= $nama_barang ?> <br>
                                                <strong>Supplier:</strong> <?= $nama_supplier ?>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <?php foreach ($kriteria as $key): ?>
                                                    <?php $sub_kriteria = $this->Penilaian_model->data_sub_kriteria($key->id_kriteria); ?>
                                                    <?php if (!empty($sub_kriteria)): ?>
                                                        <input type="hidden" name="id_alternatif" value="<?= $keys->id_alternatif ?>">
                                                        <input type="hidden" name="id_kriteria[]" value="<?= $key->id_kriteria ?>">
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold"><?= $key->keterangan ?></label>
                                                                <select name="nilai[]" class="form-control border-warning" required>
                                                                    <option value="" disabled>-- Pilih Penilaian --</option>
                                                                    <?php foreach ($sub_kriteria as $subs_kriteria): ?>
                                                                        <?php $s_option = $this->Penilaian_model->data_penilaian($keys->id_alternatif, $subs_kriteria['id_kriteria'], $id_batch_aktif); ?>
                                                                        <option value="<?= $subs_kriteria['id_sub_kriteria'] ?>" <?= (isset($s_option['nilai']) && $subs_kriteria['id_sub_kriteria'] == $s_option['nilai']) ? "selected" : "" ?>>
                                                                            <?= $subs_kriteria['deskripsi'] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update Penilaian</button>
                                        </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php 
                            $no++;
                        endforeach;
                        endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $this->load->view('layouts/footer_admin'); ?>