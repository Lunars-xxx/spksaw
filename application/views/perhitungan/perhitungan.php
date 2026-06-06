<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Data Perhitungan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter"></i> Load Data Perhitungan</h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('Perhitungan') ?>" method="GET">
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
                        <i class="fas fa-calculator"></i> Hitung
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($id_barang_aktif) && !empty($id_batch_aktif)): ?>
    <?php if (empty($alternatif)): ?>
        <div class="alert alert-danger shadow-sm text-center py-4">
            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i><br>
            <strong>Data Tidak Ditemukan!</strong><br>
            Tidak ada data supplier yang terhubung atau dinilai untuk barang pada Batch ini.
        </div>
    <?php else: ?>
        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Matriks Keputusan (X) - Batch Aktif</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-info text-white">
                            <tr align="center">
                                <th width="5%">No</th>
                                <th>Nama Alternatif</th>
                                <?php foreach ($kriteria as $key): ?>
                                <th><?= $key->kode_kriteria ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                foreach ($alternatif as $keys): ?>
                            <tr align="center">
                                <td><?= $no; ?></td>
                                <td align="left"><?= isset($keys->nama_supplier) ? $keys->nama_supplier : $keys->nama ?></td>
                                <?php foreach ($kriteria as $key): ?>
                                <td>
                                <?php 
                                    // UPDATE: Menambahkan parameter $id_batch_aktif
                                    $data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif, $key->id_kriteria, $id_batch_aktif);
                                    echo isset($data_pencocokan['nilai']) ? $data_pencocokan['nilai'] : 0;
                                ?>
                                </td>
                                <?php endforeach ?>
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Matriks Ternormalisasi (R)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-info text-white">
                            <tr align="center">
                                <th width="5%">No</th>
                                <th>Nama Alternatif</th>
                                <?php foreach ($kriteria as $key): ?>
                                <th><?= $key->kode_kriteria ?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                foreach ($alternatif as $keys): ?>
                            <tr align="center">
                                <td><?= $no; ?></td>
                                <td align="left"><?= isset($keys->nama_supplier) ? $keys->nama_supplier : $keys->nama ?></td>
                                <?php foreach ($kriteria as $key): ?>
                                <td>
                                <?php 
                                    // UPDATE: Menambahkan parameter $id_batch_aktif
                                    $data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif, $key->id_kriteria, $id_batch_aktif);
                                    $min_max = $this->Perhitungan_model->get_max_min($key->id_kriteria, $id_batch_aktif); // Pastikan get_max_min juga diupdate di model
                                    
                                    $nilai_mentah = isset($data_pencocokan['nilai']) ? $data_pencocokan['nilai'] : 0;
                                    
                                    if($min_max['jenis'] == 'Benefit' && !empty($min_max['max'])){
                                        echo number_format(@($nilai_mentah / $min_max['max']), 3);
                                    } elseif ($min_max['jenis'] != 'Benefit' && $nilai_mentah != 0) {
                                        echo number_format(@($min_max['min'] / $nilai_mentah), 3);
                                    } else {
                                        echo 0;
                                    }
                                ?>
                                </td>
                                <?php endforeach ?>
                            </tr>
                            <?php
                                $no++;
                                endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fa fa-table"></i> Bobot Preferensi (W)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-info text-white">
                            <tr align="center">
                                <?php foreach ($kriteria as $key): ?>
                                <th><?= $key->kode_kriteria ?> (<?= $key->jenis ?>)</th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr align="center">
                                <?php foreach ($kriteria as $key): ?>
                                <td>
                                <?php echo $key->bobot; ?>
                                </td>
                                <?php endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Perhitungan Nilai Akhir (V)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-info text-white">
                            <tr align="center">
                                <th width="5%">No</th>
                                <th>Nama Alternatif</th>
                                <th>Perhitungan</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // UPDATE: Hapus hasil spesifik untuk batch ini sebelum insert ulang
                                $this->Perhitungan_model->hapus_hasil($id_batch_aktif);
                                $no=1;
                                foreach ($alternatif as $keys): ?>
                            <tr align="center">
                                <td><?= $no; ?></td>
                                <td align="left"><?= isset($keys->nama_supplier) ? $keys->nama_supplier : $keys->nama ?></td>
                                <td>
                                SUM 
                                <?php
                                $nilai_v = 0;
                                foreach ($kriteria as $key): ?>
                                <?php 
                                    $bobot = $key->bobot;
                                    // UPDATE: Tambah parameter id_batch
                                    $data_pencocokan = $this->Perhitungan_model->data_nilai($keys->id_alternatif, $key->id_kriteria, $id_batch_aktif);
                                    $min_max=$this->Perhitungan_model->get_max_min($key->id_kriteria, $id_batch_aktif);
                                    
                                    $nilai_mentah = isset($data_pencocokan['nilai']) ? $data_pencocokan['nilai'] : 0;
                                    $nilai_r = 0;

                                    if($min_max['jenis'] == 'Benefit' && !empty($min_max['max'])){
                                        $nilai_r = @($nilai_mentah / $min_max['max']);
                                    } elseif ($min_max['jenis'] != 'Benefit' && $nilai_mentah != 0) {
                                        $nilai_r = @($min_max['min'] / $nilai_mentah);
                                    }

                                    $nilai_penjumlahan = $bobot * $nilai_r;
                                    $nilai_v += $nilai_penjumlahan;
                                    echo "(".$bobot." x ".number_format($nilai_r, 3).") ";
                                endforeach; ?>
                                </td>
                                <td>
                                    <?php
                                        echo number_format($nilai_v, 3);
                                        // PENTING: Menyimpan hasil akhir ke database dengan id_batch
                                        $hasil_akhir = [
                                            'id_alternatif' => $keys->id_alternatif,
                                            'id_batch'      => $id_batch_aktif, // Menambahkan ID Batch
                                            'nilai'         => $nilai_v
                                        ];
                                        $this->Perhitungan_model->insert_nilai_hasil($hasil_akhir);
                                    ?>
                                </td>
                            </tr>
                            <?php
                                $no++;
                                endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $this->load->view('layouts/footer_admin'); ?>