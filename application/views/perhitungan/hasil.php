<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>
    
    <?php if (!empty($hasil)): ?>
    <a href="<?= base_url('Laporan?id_batch='.$id_batch_aktif.'&id_barang='.$id_barang_aktif); ?>" class="btn btn-primary shadow-sm"> 
        <i class="fa fa-print"></i> Cetak Data 
    </a>
    <?php endif; ?>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter"></i> Pilih Data Hasil Perankingan</h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('Perhitungan/hasil') ?>" method="GET">
            <div class="row">
                <div class="col-md-5 mb-3 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-archive"></i></span>
                        </div>
                        <select name="id_batch" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Slot Batch --</option>
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
                        <i class="fas fa-search"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (empty($hasil)): ?>
    <div class="alert alert-danger shadow-sm text-center py-4">
        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i><br>
        <strong>Hasil Perankingan Kosong!</strong><br>
        Silakan pilih Slot Batch dan Barang di atas lalu klik "Tampilkan", atau pastikan Anda sudah menghitung data tersebut di menu Perhitungan.
    </div>
<?php else: ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Hasil Akhir Perankingan</h6>
            <span class="badge badge-info px-3 py-2">Batch Aktif Ditampilkan</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-info text-white">
                        <tr align="center">
                            <th>Nama Alternatif</th>
                            <th>Nilai Akhir (V)</th>
                            <th width="15%">Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=1;
                            foreach ($hasil as $keys): 
                        ?>
                        <tr align="center">
                            <td align="left" class="font-weight-bold">
                                <?php
                                // Mengambil data alternatif dari model
                                $nama_alternatif = $this->Perhitungan_model->get_hasil_alternatif($keys->id_alternatif);
                                
                                // Pengecekan aman field nama
                                $nama_tampil = isset($nama_alternatif['nama_supplier']) ? $nama_alternatif['nama_supplier'] : (isset($nama_alternatif['nama']) ? $nama_alternatif['nama'] : '-');
                                
                                echo $nama_tampil;
                                ?>
                            </td>
                            <td><?= $keys->nilai ?></td>
                            <td>
                                <?php if($no == 1): ?>
                                    <span class="badge badge-success px-3 py-2">Peringkat 1</span>
                                <?php elseif($no == 2): ?>
                                    <span class="badge badge-primary px-3 py-2">Peringkat 2</span>
                                <?php elseif($no == 3): ?>
                                    <span class="badge badge-info px-3 py-2">Peringkat 3</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary px-3 py-2"><?= $no; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                            $no++;
                            endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php
$this->load->view('layouts/footer_admin');
?>