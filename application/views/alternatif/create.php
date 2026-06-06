<?php $this->load->view('layouts/header_admin'); ?>

<style>
    .select-barang option:disabled { color: #6c757d; background-color: #e9ecef; font-style: italic; }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Tambah Data Supplier</h1>
    <a href="<?= base_url('Alternatif'); ?>" class="btn btn-secondary btn-icon-split">
        <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
        <span class="text">Kembali</span>
    </a>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4 border-bottom-info">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-fw fa-plus"></i> Form Tambah Supplier & Barang</h6>
    </div>
    
    <form action="<?= base_url('Alternatif/store'); ?>" method="POST" id="form-tambah">
        <div class="card-body">
            <div class="form-group">
                <label class="font-weight-bold">Nama Supplier <span class="text-danger">*</span></label>
                <input autocomplete="off" type="text" name="nama" required class="form-control" placeholder="Masukkan Nama Supplier..."/>
            </div>

            <hr class="mt-4 mb-4">
            
            <h6 class="font-weight-bold text-info mb-3"><i class="fas fa-fw fa-box"></i> Daftar Barang yang Disupply</h6>
            
            <div id="container-barang">
                <div class="row mb-3 baris-barang align-items-center">
                    <div class="col-md-10 col-sm-9 mb-2 mb-sm-0">
                        <select name="nama_barang[]" class="form-control select-barang" required>
                            <option value="">-- Pilih Barang dari Database --</option>
                            <?php if(isset($list_barang)): foreach($list_barang as $brg): ?>
                                <option value="<?= $brg->nama_barang ?>"><?= $brg->nama_barang ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <button type="button" class="btn btn-success btn-block btn-tambah-baris"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card-footer text-right">
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
        </div>
    </form>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 1. Hitung otomatis total barang asli dari database (mengecualikan option pertama yang kosong)
    const maxBarang = $('.select-barang:first option[value!=""]').length;

    // 2. Fungsi ringkas untuk blokir barang yang sudah dipilih
    const perbaruiDropdown = () => {
        const terpilih = $('.select-barang').map((_, el) => $(el).val()).get().filter(v => v);
        
        $('.select-barang option').prop('disabled', false).text(function() {
            return $(this).text().replace(' (Sudah Dipilih)', '');
        });

        $('.select-barang').each(function() {
            const valIni = $(this).val();
            $(this).find('option').each(function() {
                const valOpt = $(this).val();
                if (valOpt && valOpt !== valIni && terpilih.includes(valOpt)) {
                    $(this).prop('disabled', true).text($(this).text() + ' (Sudah Dipilih)');
                }
            });
        });
    };

    // 3. Event Listener Utama
    $('#container-barang')
        .on('change', '.select-barang', perbaruiDropdown)
        .on('click', '.btn-tambah-baris', function() {
            
            // VALIDASI PEMBATASAN INPUT:
            // Cek apakah jumlah baris saat ini sudah sama atau lebih besar dari ketersediaan barang
            if ($('.baris-barang').length >= maxBarang) {
                alert(`⚠️ Batas maksimal tercapai! Hanya ada ${maxBarang} barang di database.`);
                return; // Hentikan script, form baru tidak akan dibuat
            }

            // Jika masih muat, gandakan baris pertama
            let barisBaru = $('.baris-barang:first').clone();
            barisBaru.find('select').val('');
            barisBaru.find('button').removeClass('btn-tambah-baris btn-success')
                     .addClass('btn-danger btn-hapus-baris')
                     .html('<i class="fa fa-trash"></i> Hapus');
            
            $('#container-barang').append(barisBaru);
            perbaruiDropdown();
        })
        .on('click', '.btn-hapus-baris', function() {
            $(this).closest('.baris-barang').remove();
            perbaruiDropdown();
        });

    // 4. Logika Reset
    $('#form-tambah').on('reset', () => {
        $('.baris-barang:not(:first)').remove();
        setTimeout(perbaruiDropdown, 10);
    });
});
</script>