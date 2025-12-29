<?php
// create_admin.php

// 1. Panggil file konfigurasi dan model
require_once 'config/database.php';
require_once 'app/models/User.php';

use App\Models\User;

// 2. Inisialisasi Model
$userModel = new User();

// 3. Data Admin Dummy
$username = "admin";
$password = "admin"; // Password yang akan Anda ketik saat login
$role     = "Admin";

echo "Sedang mencoba membuat user admin...<br>";

// 4. Eksekusi
if ($userModel->register($username, $password, $role)) {
    echo "<h1>SUKSES!</h1>";
    echo "Akun Admin berhasil dibuat.<br>";
    echo "Username: <strong>$username</strong><br>";
    echo "Password: <strong>$password</strong><br>";
    echo "<br>Silakan hapus file ini dan lanjutkan coding.";
} else {
    echo "<h1>GAGAL!</h1>";
    echo "Mungkin koneksi database salah atau username '$username' sudah ada.";
}