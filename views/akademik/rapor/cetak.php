<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor - <?php echo htmlspecialchars(
        $biodata["nama_lengkap"]
    ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            background: #fff; /* Pastikan background putih */
        }
        .header-kop {
            border-bottom: 3px double #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .table-nilai th {
            background-color: #f0f0f0 !important; /* Warna abu muda saat print */
            text-align: center;
            vertical-align: middle;
            -webkit-print-color-adjust: exact; /* Paksa cetak warna background */
        }
        .kotak-ttd {
            margin-top: 40px;
        }
        .box-catatan {
            border: 1px solid #000;
            padding: 10px;
            min-height: 60px;
        }
        
        /* Pengaturan Cetak A4 */
        @media print {
            @page {
                size: A4;
                margin: 1.5cm;
            }
            .no-print {
                display: none !important;
            }
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="fixed-top p-3 no-print">
        <button onclick="window.print()" class="btn btn-primary shadow">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
              <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
              <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
            </svg> Cetak Sekarang
        </button>
        <button onclick="window.close()" class="btn btn-secondary shadow ms-2">Tutup</button>
    </div>

    <div class="container mt-4">
        
        <div class="header-kop text-center">
            <h4 class="fw-bold mb-0">SMK TEXMACO SUBANG</h4>
            <p class="mb-0">Kawasan Industri Perkasa, Jl. Raya Cipeundeuy - Pabuaran No.km 3, RW.5, Karangmukti, Kec. Cipeundeuy, Kabupaten Subang, Jawa Barat 41262</p>
            <p class="mb-0">Website: smktexmaco.sch.id | Email: info@smktexmaco.sch.id</p>
        </div>

        <h5 class="text-center fw-bold mb-4">LAPORAN HASIL BELAJAR SISWA</h5>

        <table class="table table-borderless table-sm mb-4">
            <tr>
                <td width="15%">Nama Siswa</td>
                <td width="1%">:</td>
                <td width="40%"><strong><?php echo htmlspecialchars(
                    $biodata["nama_lengkap"]
                ); ?></strong></td>
                <td width="15%">Kelas</td>
                <td width="1%">:</td>
                <td><?php echo htmlspecialchars(
                    $biodata["nama_kelas"]
                ); ?> (<?php echo htmlspecialchars(
     $biodata["jurusan"]
 ); ?>)</td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>:</td>
                <td><?php echo htmlspecialchars(
                    $biodata["nis"]
                ); ?> / <?php echo htmlspecialchars($biodata["nisn"]); ?></td>
                <td>Semester</td>
                <td>:</td>
                <td><?php echo htmlspecialchars($tahun["semester"]); ?></td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td><?php echo htmlspecialchars($tahun["tahun"]); ?></td>
                <td></td><td></td><td></td>
            </tr>
        </table>

        <table class="table table-bordered table-sm table-nilai">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="50%">Mata Pelajaran</th>
                    <th width="10%">KKM</th>
                    <th width="10%">Nilai</th>
                    <th width="25%">Predikat / Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($nilai["A"])): ?>
                <tr>
                    <td colspan="5" class="fw-bold bg-light ps-3">Kelompok A (Wajib)</td>
                </tr>
                <?php
                $no = 1;
                foreach ($nilai["A"] as $row): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["nama_mapel"]
                        ); ?></td>
                        <td class="text-center"><?php echo $row["kkm"]; ?></td>
                        <td class="text-center fw-bold"><?php echo $row[
                            "nilai_akhir"
                        ]; ?></td>
                        <td class="text-center">
                            <?php // Contoh Logika Predikat Sederhana

                    if ($row["nilai_akhir"] >= 90) {
                                echo "Sangat Baik";
                            } elseif ($row["nilai_akhir"] >= 80) {
                                echo "Baik";
                            } elseif ($row["nilai_akhir"] >= $row["kkm"]) {
                                echo "Cukup";
                            } else {
                                echo "Kurang";
                            } ?>
                        </td>
                    </tr>
                <?php endforeach;
                endif; ?>

                <?php if (!empty($nilai["B"])): ?>
                <tr>
                    <td colspan="5" class="fw-bold bg-light ps-3">Kelompok B (Wajib)</td>
                </tr>
                <?php
                $no = 1;
                foreach ($nilai["B"] as $row): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["nama_mapel"]
                        ); ?></td>
                        <td class="text-center"><?php echo $row["kkm"]; ?></td>
                        <td class="text-center fw-bold"><?php echo $row[
                            "nilai_akhir"
                        ]; ?></td>
                        <td class="text-center">
                            <?php if ($row["nilai_akhir"] >= 90) {
                                echo "Sangat Baik";
                            } elseif ($row["nilai_akhir"] >= 80) {
                                echo "Baik";
                            } elseif ($row["nilai_akhir"] >= $row["kkm"]) {
                                echo "Cukup";
                            } else {
                                echo "Kurang";
                            } ?>
                        </td>
                    </tr>
                <?php endforeach;
                endif; ?>

                <?php if (!empty($nilai["C"])): ?>
                <tr>
                    <td colspan="5" class="fw-bold bg-light ps-3">Kelompok C (Peminatan)</td>
                </tr>
                <?php
                $no = 1;
                foreach ($nilai["C"] as $row): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars(
                            $row["nama_mapel"]
                        ); ?></td>
                        <td class="text-center"><?php echo $row["kkm"]; ?></td>
                        <td class="text-center fw-bold"><?php echo $row[
                            "nilai_akhir"
                        ]; ?></td>
                        <td class="text-center">
                            <?php if ($row["nilai_akhir"] >= 90) {
                                echo "Sangat Baik";
                            } elseif ($row["nilai_akhir"] >= 80) {
                                echo "Baik";
                            } elseif ($row["nilai_akhir"] >= $row["kkm"]) {
                                echo "Cukup";
                            } else {
                                echo "Kurang";
                            } ?>
                        </td>
                    </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-8">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th class="text-start ps-3 bg-light">Catatan Wali Kelas</th>
                    </tr>
                    <tr>
                        <td>
                            <strong>Sikap:</strong><br>
                            <?php echo nl2br(
                                htmlspecialchars($catatan["catatan_sikap"])
                            ); ?>
                            <br><br>
                            <strong>Akademik:</strong><br>
                            <?php echo nl2br(
                                htmlspecialchars($catatan["catatan_akademik"])
                            ); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-4">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th colspan="2" class="text-center bg-light">Ketidakhadiran</th>
                    </tr>
                    <tr>
                        <td>Sakit</td>
                        <td class="text-center"><?php echo $absensi[
                            "Sakit"
                        ]; ?> hari</td>
                    </tr>
                    <tr>
                        <td>Izin</td>
                        <td class="text-center"><?php echo $absensi[
                            "Izin"
                        ]; ?> hari</td>
                    </tr>
                    <tr>
                        <td>Tanpa Keterangan</td>
                        <td class="text-center"><?php echo $absensi[
                            "Alpa"
                        ]; ?> hari</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="kotak-ttd">
            <div class="row text-center">
                <div class="col-4">
                    <br>
                    Orang Tua / Wali
                    <br><br><br><br>
                    (................................)
                </div>
                <div class="col-4">
                    
                </div>
                <div class="col-4">
                    Subang, <?php echo date("d F Y"); ?>
                    <br>Wali Kelas
                    <br><br><br><br>
                    <strong><u><?php echo htmlspecialchars(
                        $catatan["nama_lengkap"] ?? "........................."
                    ); ?></u></strong><br>
                    NIP. <?php echo htmlspecialchars($catatan["nip"] ?? "-"); ?>
                </div>
            </div>
            <div class="row text-center mt-4">
                <div class="col-12">
                    Mengetahui,<br>
                    Kepala Sekolah
                    <br><br><br><br>
                    <strong><u>H. AGUS SYARIFUDIN, S.Pd</u></strong><br> NIP. 19700101 200001 1 001
                </div>
            </div>
        </div>

    </div>

    <script>
        // Otomatis trigger print saat halaman dibuka
        window.onload = function() {
            // Uncomment baris di bawah jika ingin langsung muncul dialog print
            // window.print();
        }
    </script>
</body>
</html>
