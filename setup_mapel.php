<?php
// setup_mapel.php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db   = new Database();
    $conn = $db->getConnection();

    // Disable foreign key checks
    $conn->exec("SET foreign_key_checks = 0");

    $query = "
    DROP TABLE IF EXISTS `mata_pelajaran`;
    CREATE TABLE `mata_pelajaran` (
      `mapel_id` int(11) NOT NULL AUTO_INCREMENT,
      `kode_mapel` varchar(20) NOT NULL COMMENT 'Unik, Ex: MTK, WEB-1',
      `nama_mapel` varchar(100) NOT NULL,
      `kelompok` ENUM('A','B','C1','C2','C3') NOT NULL COMMENT 'A:Nasional, B:Wilayah, C:Kejuruan',
      `kkm` int(11) NOT NULL DEFAULT 75,
      PRIMARY KEY (`mapel_id`),
      UNIQUE KEY `kode_mapel` (`kode_mapel`)
    ) ENGINE=InnoDB;
    ";

    $conn->exec($query);

    // Re-enable foreign key checks
    $conn->exec("SET foreign_key_checks = 1");

    echo "Tabel 'mata_pelajaran' berhasil dibuat.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
