<?php
// setup_tahun_ajaran.php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db   = new Database();
    $conn = $db->getConnection();

    $query = "
    DROP TABLE IF EXISTS `tahun_ajaran`;
    CREATE TABLE `tahun_ajaran`  (
      `tahun_id` int(11) NOT NULL AUTO_INCREMENT,
      `tahun` varchar(20) NOT NULL COMMENT 'Contoh: 2024/2025',
      `semester` enum('Ganjil','Genap') NOT NULL,
      `is_active` tinyint(1) NULL DEFAULT 0,
      PRIMARY KEY (`tahun_id`)
    ) ENGINE = InnoDB;
    ";

    $conn->exec($query);
    echo "Tabel 'tahun_ajaran' berhasil dibuat.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}