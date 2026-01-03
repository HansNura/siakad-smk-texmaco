<?php

$host = '127.0.0.1';
$db_name = 'db_siakad_texmaco';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
    DROP TABLE IF EXISTS `nilai`;
    CREATE TABLE `nilai` (
      `nilai_id` int(11) NOT NULL AUTO_INCREMENT,
      `siswa_id` int(11) NOT NULL,
      `mapel_id` int(11) NOT NULL,
      `tahun_id` int(11) NOT NULL, -- Diambil dari Tahun Ajaran Aktif
      `nilai_tugas` decimal(5,2) DEFAULT 0.00,
      `nilai_uts` decimal(5,2) DEFAULT 0.00,
      `nilai_uas` decimal(5,2) DEFAULT 0.00,
      `nilai_akhir` decimal(5,2) DEFAULT 0.00 COMMENT 'Hasil (Tugas*20%)+(UTS*30%)+(UAS*50%)',
      `status_validasi` enum('Draft','Final') DEFAULT 'Draft',
      PRIMARY KEY (`nilai_id`),
      -- Mencegah Duplikasi: Satu siswa hanya punya satu nilai per mapel per tahun
      UNIQUE KEY `unique_nilai` (`siswa_id`, `mapel_id`, `tahun_id`),
      FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE, -- Sesuaikan nama kolom ID siswa Anda
      FOREIGN KEY (`mapel_id`) REFERENCES `mata_pelajaran` (`mapel_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $conn->exec($sql);
    echo "Table 'nilai' created successfully.";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}

