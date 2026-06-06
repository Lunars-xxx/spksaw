<?php $this->load->view('layouts/header_admin'); ?>

<?php 
    // Mengambil jumlah baris data
    $total_kriteria = $this->db->count_all('kriteria');         // Sesuaikan nama tabel jika berbeda
    $total_sub_kriteria = $this->db->count_all('sub_kriteria'); // Sesuaikan nama tabel jika berbeda
    $total_supplier = $this->db->count_all('alternatif'); 
    $total_barang = $this->db->count_all('barang'); 
    $total_penilaian = $this->db->count_all('penilaian');       // Sesuaikan nama tabel
    $total_user = $this->db->count_all('user');                 // Sesuaikan nama tabel
?>

<?php if($this->session->userdata('id_user_level') == '1'): ?>
<div class="mb-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard</h1>
    </div>

    <div class="alert alert-success shadow-sm border-0 mb-4">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Selamat datang <span class="text-uppercase font-weight-bold text-success"><?= $this->session->username; ?>!</span> 
        Anda dapat mengelola pemilihan supplier melalui menu ringkas di bawah ini.
    </div>

    <div class="row">
        
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Kriteria'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-primary text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Master Data</div>
                                <div class="h4 mb-0 font-weight-bold">Data Kriteria</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Total: <span class="font-weight-bold bg-white text-primary px-2 py-1 rounded"><?= $total_kriteria ?></span> Kriteria
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cube fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Sub_kriteria'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-success text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Master Data</div>
                                <div class="h4 mb-0 font-weight-bold">Sub Kriteria</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Total: <span class="font-weight-bold bg-white text-success px-2 py-1 rounded"><?= $total_sub_kriteria ?></span> Sub
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Alternatif'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-info text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Master Data</div>
                                <div class="h4 mb-0 font-weight-bold">Data Supplier</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Total: <span class="font-weight-bold bg-white text-info px-2 py-1 rounded"><?= $total_supplier ?></span> Supplier
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Barang'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-secondary text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Master Data</div>
                                <div class="h4 mb-0 font-weight-bold">Data Barang</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Total: <span class="font-weight-bold bg-white text-secondary px-2 py-1 rounded"><?= $total_barang ?></span> Item
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Penilaian'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-warning text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Proses Data</div>
                                <div class="h4 mb-0 font-weight-bold">Data Penilaian</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Total: <span class="font-weight-bold bg-white text-warning px-2 py-1 rounded"><?= $total_penilaian ?></span> Data
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-edit fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Perhitungan'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-danger text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Proses Data</div>
                                <div class="h4 mb-0 font-weight-bold">Perhitungan</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Kalkulasi data metode.
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calculator fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('Perhitungan/hasil'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-dark text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Laporan & Keputusan</div>
                                <div class="h4 mb-0 font-weight-bold">Hasil Akhir</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Lihat peranking & keputusan.
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-pie fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= base_url('User'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-primary text-white shadow h-100 py-4 px-3" style="transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Master User</div>
                                <div class="h4 mb-0 font-weight-bold">Data User</div>
                                <div class="mt-3 h6 mb-0 font-weight-light">
                                    Total: <span class="font-weight-bold bg-white text-primary px-2 py-1 rounded"><?= $total_user ?></span> Akun
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-shield fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
<?php endif; ?>

<?php if($this->session->userdata('id_user_level') == '2'): ?>
<div class="mb-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard User</h1>
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <a href="<?= base_url('Perhitungan/hasil'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-primary text-white shadow h-100 py-4 px-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Laporan</div>
                                <div class="h3 mb-0 font-weight-bold">Data Hasil Akhir</div>
                                <div class="mt-2 h6 mb-0 font-weight-light">Lihat peranking dan hasil penilaian.</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-area fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <a href="<?= base_url('Profile'); ?>" class="text-decoration-none">
                <div class="card border-0 bg-gradient-success text-white shadow h-100 py-4 px-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Pengaturan</div>
                                <div class="h3 mb-0 font-weight-bold">Data Profile</div>
                                <div class="mt-2 h6 mb-0 font-weight-light">Update biodata dan password.</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-cog fa-3x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $this->load->view('layouts/footer_admin'); ?>