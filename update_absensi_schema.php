<?php
// update_absensi_schema.php

require_once 'config/config.php';
require_once 'app/Core/Database.php';

use App\Core\Database;

try {
    $db   = new Database();
    $conn = $db->getConnection();

    // 1. Add column alasan_penolakan
    // Check if column exists first to avoid error if re-run??
    // Or just try-catch. simpler to just run ALTER.
    // However, if we fail halfway it is annoying.

    // Let's assume clean run or manage errors.

    $sql1 = "ALTER TABLE `absensi` ADD COLUMN `alasan_penolakan` TEXT NULL DEFAULT NULL AFTER `status_validasi`";
    try {
        $conn->exec($sql1);
        echo "Column 'alasan_penolakan' added.\n";
    } catch (PDOException $e) {
        echo "Skipping add column (maybe exists): " . $e->getMessage() . "\n";
    }

    // 2. Modify ENUM
    $sql2 = "ALTER TABLE `absensi` MODIFY COLUMN `status_validasi` ENUM('Draft','Valid','Rejected') DEFAULT 'Draft'";
    $conn->exec($sql2);
    echo "ENUM status_validasi updated.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
