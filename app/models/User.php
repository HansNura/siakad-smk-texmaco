<?php
// app/models/User.php

namespace App\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/../Models/Model.php';

class User extends Model
{
    protected $table = "users";

    // Fungsi 1: Mengambil data user untuk Login
    // Sesuai Sequence Diagram SIA-001
    public function getCredential($username)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            // Mengembalikan array data user (id, username, password hash, role)
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Fungsi 2: Mendaftarkan User Baru (Untuk Seeder / Admin)
    // Sesuai Sequence Diagram SIA-011
    public static function register($username, $password, $role)
    {
        $instance = new self();
        try {
            // ENKRIPSI PASSWORD (PENTING!)
            // Kita pakai PASSWORD_DEFAULT (Bcrypt) sesuai standar keamanan
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $instance->table . " (username, password, role) VALUES (:username, :pass, :role)";
            $stmt  = $instance->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $hash);
            $stmt->bindParam(":role", $role);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Mengembalikan false jika error (misal: username duplikat)
            return false;
        }
    }
}