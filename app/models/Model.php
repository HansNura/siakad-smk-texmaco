<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Model
{
    protected $table;
    protected $primaryKey = 'id';

    public $conn;

    public function __construct()
    {
        $database   = new Database();
        $this->conn = $database->getConnection();
    }

    public static function getAll()
    {
        $instance = new static();
        $stmt     = $instance->conn->prepare("SELECT * FROM " . $instance->table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $instance = new static();
        $stmt     = $instance->conn->prepare("SELECT * FROM " . $instance->table . " WHERE " . $instance->primaryKey . " = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi CRUD (Create, Read, Update, Delete)
    // Untuk Memenuhi Sequence Diagram SIA-003 dan SIA-011

    // Fungsi 1: Create($data)
    public static function create($data)
    {
        $instance = new static();

        try {
            $columns      = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));

            $query = "INSERT INTO " . $instance->table . " ($columns) VALUES ($placeholders)";

            $stmt = $instance->conn->prepare($query);
            $stmt->execute($data);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Fungsi 2: Update($id, $data)
    public static function update($id, $data)
    {
        $instance = new static();

        try {
            $sets = [];
            foreach (array_keys($data) as $key) {
                $sets[] = "$key = :$key";
            }
            $setString = implode(", ", $sets);

            $query = "UPDATE " . $instance->table . " SET $setString WHERE " . $instance->primaryKey . " = :_primary_id";

            $data['_primary_id'] = $id;

            $stmt = $instance->conn->prepare($query);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Fungsi 3: Delete($id)
    public static function delete($id)
    {
        $instance = new static();
        try {
            $query = "DELETE FROM " . $instance->table . " WHERE " . $instance->primaryKey . " = :_primary_id";
            $stmt  = $instance->conn->prepare($query);

            $stmt->bindParam(":_primary_id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}