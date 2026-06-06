<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan SPK SAW</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif; 
            margin: 40px;
        }

        /* --- PERBAIKAN KOP SURAT SUPAYA CENTER PRESISI --- */
        .kop-surat {
            border-bottom: 3px double black; 
            padding-bottom: 15px;
            margin-bottom: 20px;
            position: relative; /* Wajib ada untuk patokan logo */
            text-align: center; /* Teks otomatis ke tengah kertas */
            width: 100%;
            min-height: 90px; /* Menjaga ruang agar logo tidak nabrak garis bawah */
        }

        .logo-pt {
            position: absolute; /* Logo dibuat melayang, tidak memakan space teks */
            left: 0; /* Tempel di kiri */
            top: 0;
        }

        .logo-pt img {
            width: 90px;
            height: auto;
        }

        .identitas-perusahaan {
            width: 100%; /* Mengambil lebar penuh halaman */
        }

        .nama-pt {
            color: #2e7d32;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .alamat-pt {
            font-size: 14px;
            margin: 5px 0 0 0;
            line-height: 1.4;
        }
        
        /* --- STYLING TABEL --- */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background-color: #f2f2f2;
            padding: 10px;
            text-transform: uppercase;
            font-size: 14px;
        }
        td {
            padding: 8px;
            font-size: 14px;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .judul-laporan {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .sub-judul {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        /* --- TANDA TANGAN --- */
        .ttd-box {
            float: right;
            width: 250px;
            margin-top: 50px;
            text-align: center;
        }
        .ttd-space {
            height: 80px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="logo-pt">
            <img src="<?= base_url('assets/img/ipj.png') ?>" alt="Logo">
        </div>
        
        <div class="identitas-perusahaan">
            <h1 class="nama-pt">CV. INOVASI PRIANGAN JAYA</h1>
            <p class="alamat-pt">
                SING ASRI PLAZA 2, JL. MERPATI RAYA NO.9, Kel. Sawah Lama,<br>
                Kec. Ciputat, Kota Tangerang Selatan, Provinsi Banten, 15413
            </p>
        </div>
    </div>

    <h3 class="judul-laporan">HASIL PERANKINGAN SUPPLIER (METODE SAW)</h3>
    
    <div class="sub-judul">
        <strong>Barang: <?= isset($nama_barang) ? $nama_barang : '-' ?></strong>
    </div>

    <table>
        <thead>
            <tr class="text-center">
                <th width="5%">No</th>
                <th>Nama Supplier</th>
                <th width="20%">Nilai Preferensi (V)</th>
                <th width="15%">Ranking</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($hasil)) {
                $no = 1;
                foreach ($hasil as $keys): 
                    $data_alt = $this->Perhitungan_model->get_hasil_alternatif($keys->id_alternatif);
                    $nama_supplier = isset($data_alt['nama']) ? $data_alt['nama'] : '<em>(Data Terhapus)</em>';
            ?>
            <tr>
                <td class="text-center"><?= $no; ?></td>
                <td class="text-left"><?= $nama_supplier; ?></td>
                <td class="text-center"><?= number_format($keys->nilai, 4); ?></td>
                <td class="text-center">Ranking <?= $no; ?></td>
            </tr>
            <?php
                $no++;
                endforeach;
            } else {
                echo '<tr><td colspan="4" class="text-center">Data hasil tidak ditemukan.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <div class="ttd-box">
        <p>Tangerang Selatan, <?= date('d F Y') ?></p>
        <p>Manager Operasional</p>
        <div class="ttd-space"></div>
        <p><strong>( ......................................... )</strong></p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>