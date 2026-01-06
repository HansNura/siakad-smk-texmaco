<?php
// setup_absensi.php

require_once 'config/config.php';
require_once 'app/Core/Database.php';

use App\Core\Database;

try {
    $db   = new Database();
    $conn = $db->getConnection();

    // Disable foreign key checks to avoid errors during drop
    $conn->exec("SET foreign_key_checks = 0");

    // Table: absensi
    $sqlAbsensi = "DROP TABLE IF EXISTS `absensi`;
    CREATE TABLE `absensi` (
      `absensi_id` int(11) NOT NULL AUTO_INCREMENT,
      `jadwal_id` int(11) NOT NULL,
      `tanggal` date NOT NULL,
      `status_validasi` enum('Pending','Valid','Rejected') DEFAULT 'Pending',
      `catatan_harian` text,
      PRIMARY KEY (`absensi_id`),
      KEY `idx_jadwal` (`jadwal_id`),
      CONSTRAINT `fk_absensi_jadwal` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_pelajaran` (`jadwal_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    $conn->exec($sqlAbsensi);
    echo "Table 'absensi' created successfully.\n";

    // Table: detail_absensi
    $sqlDetail = "DROP TABLE IF EXISTS `detail_absensi`;
    CREATE TABLE `detail_absensi` (
      `detail_id` int(11) NOT NULL AUTO_INCREMENT,
      `absensi_id` int(11) NOT NULL,
      `siswa_id` int(11) NOT NULL,
      `status_kehadiran` enum('Hadir','Sakit','Izin','Alpa') NOT NULL,
      PRIMARY KEY (`detail_id`),
      KEY `idx_absensi` (`absensi_id`),
      KEY `idx_siswa` (`siswa_id`),
      CONSTRAINT `fk_detail_absensi` FOREIGN KEY (`absensi_id`) REFERENCES `absensi` (`absensi_id`) ON DELETE CASCADE,
      CONSTRAINT `fk_detail_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`) ON DELETE RESTRICT
    ) ENGINE=InnoDB;";

    $conn->exec($sqlDetail);
    echo "Table 'detail_absensi' created successfully.\n";

    // Re-enable foreign key checks
    $conn->exec("SET foreign_key_checks = 1");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
