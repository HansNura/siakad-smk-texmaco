<?php
// setup_kelas.php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db   = new Database();
    $conn = $db->getConnection();

    // Disable foreign key checks
    $conn->exec("SET foreign_key_checks = 0");

    $query = "
    DROP TABLE IF EXISTS `kelas`;
    CREATE TABLE `kelas` (
      `kelas_id` int(11) NOT NULL AUTO_INCREMENT,
      `guru_wali_id` int(11) NOT NULL,
      `tahun_id` int(11) NOT NULL COMMENT 'Relasi ke tahun ajaran aktif',
      `nama_kelas` varchar(50) NOT NULL COMMENT 'Contoh: X TKJ 1',
      `tingkat` varchar(10) NOT NULL COMMENT '10, 11, 12',
      `jurusan` varchar(50) NOT NULL COMMENT 'TKJ, RPL, dll',
      PRIMARY KEY (`kelas_id`),
      KEY `idx_guru` (`guru_wali_id`),
      KEY `idx_tahun` (`tahun_id`),
      CONSTRAINT `fk_kelas_guru` FOREIGN KEY (`guru_wali_id`) REFERENCES `guru` (`guru_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
      CONSTRAINT `fk_kelas_tahun` FOREIGN KEY (`tahun_id`) REFERENCES `tahun_ajaran` (`tahun_id`) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB;
    ";

    $conn->exec($query);

    // Re-enable foreign key checks
    $conn->exec("SET foreign_key_checks = 1");

    echo "Tabel 'kelas' berhasil dibuat.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
