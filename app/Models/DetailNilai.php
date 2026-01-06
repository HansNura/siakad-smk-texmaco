<?php
namespace App\Models;

require_once __DIR__ . '/Model.php';

class DetailNilai extends Model
{
    protected $table = 'detail_nilai';
    protected $primaryKey = 'detail_id';

    /**
     * Hapus semua detail nilai berdasarkan ID Header (Untuk proses Revisi)
     */
    public static function deleteByHeaderId($nilai_id)
    {
        $instance = new static();
        $sql = "DELETE FROM {$instance->table} WHERE nilai_id = :nilai_id";
        $stmt = $instance->conn->prepare($sql);
        return $stmt->execute([':nilai_id' => $nilai_id]);
    }
}