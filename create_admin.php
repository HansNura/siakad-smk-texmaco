<?php
// create_admin.php

// 1. Panggil file konfigurasi dan model
require_once 'config/database.php';
require_once 'app/models/User.php';

use App\Models\User;

// 3. Data Admin Dummy
$username = "admin";
$password = "admin";
$role     = "Admin";
$user     = User::register('admin', 'admin', 'admin');
echo "Sedang mencoba membuat user admin...<br>";

// 4. Eksekusi
if ($user) {
    echo "<h1>SUKSES!</h1>";
    echo "Akun Admin berhasil dibuat.<br>";
    echo "Username: <strong>$username</strong><br>";
    echo "Password: <strong>$password</strong><br>";
    echo "<br>Silakan hapus file ini dan lanjutkan coding.";
} else {
    echo "<h1>GAGAL!</h1>";
    echo "Mungkin koneksi database salah atau username '$username' sudah ada.";
}