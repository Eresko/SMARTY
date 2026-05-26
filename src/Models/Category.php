<?php
namespace App\Models;

use Core\Database;
use PDO;

class Category {

    /**
     * @param int $id
     * @return array|null
     */
    public static function getById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();

        return $category ? $category : null;
    }

    /**
     * @return array
     */
    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}