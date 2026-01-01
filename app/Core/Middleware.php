<?php
namespace App\Core;

class Middleware
{
  /**
   * Mapper: Menghubungkan kata kunci string ke method
   */
  public static function resolve($key, $param = null)
  {
    switch ($key) {
      case "auth":
        self::auth();
        break;
      case "guest":
        self::guest();
        break;
      case "role":
        self::role($param);
        break;
    }
  }

  /**
   * Cek apakah user SUDAH login
   */
  public static function auth()
  {
    if (!isset($_SESSION["user_id"])) {
      // Simpan pesan error ke session (opsional, jika punya flash message)
      $_SESSION["flash"] = [
        "type" => "danger",
        "message" => "Silakan login terlebih dahulu.",
      ];
      header("Location: /login");
      exit();
    }
  }

  /**
   * Cek apakah user BELUM login (misal: untuk halaman login/register)
   */
  public static function guest()
  {
    if (isset($_SESSION["user_id"])) {
      header("Location: /dashboard");
      exit();
    }
  }

/**
     * Cek Role user (Support multi role).
     * Contoh penggunaan di route: 'role:Admin|Guru|Siswa'
     */
    public static function role($allowedRolesString)
    {
        // 1. Pastikan user sudah login dulu
        self::auth();

        // 2. Ambil role user saat ini dari session
        $currentUserRole = $_SESSION['role'] ?? '';

        // 3. Pecah string parameter menjadi array
        // Input: "Admin|Guru" -> Output: ["Admin", "Guru"]
        // Kita gunakan explode dengan delimiter pipa (|) sesuai request Anda
        $allowedRoles = explode('|', $allowedRolesString);

        // 4. Cek apakah role user saat ini ADA di dalam array role yang diizinkan
        if (!in_array($currentUserRole, $allowedRoles)) {
            http_response_code(403);
            
            // Tampilan Error 403 Sederhana
            echo "<h1>403 - Forbidden</h1>";
            echo "<p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>";
            echo "<p>Role Anda: <strong>$currentUserRole</strong></p>";
            echo "<p>Halaman ini khusus untuk: <strong>" . implode(', ', $allowedRoles) . "</strong></p>";
            echo "<a href='/dashboard'>Kembali ke Dashboard</a>";
            exit;
        }
    }
}
