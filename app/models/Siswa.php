<?php
namespace App\Models;

require_once __DIR__ . '/../Models/Model.php';

use PDO;

class Siswa extends Model
{
    protected $table      = "siswa";
    protected $primaryKey = "siswa_id";

    // Kita override getAll untuk join dengan tabel users
    // Agar saat menampilkan daftar siswa, kita bisa lihat usernamenya juga (opsional)
    public static function getAllWithRelasi()
    {
        $instance = new static();
        $query    = "SELECT
                            $instance->table.*,
                            u.status_aktif,
                            k.nama_kelas
                        FROM
                            $instance->table
                            JOIN users u ON $instance->table.user_id = u.user_id
                            LEFT JOIN kelas k ON $instance->table.kelas_id = k.kelas_id
                        ORDER BY
                            $instance->table.kelas_id ASC,
                            $instance->table.nama_lengkap ASC";

        $stmt = $instance->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}