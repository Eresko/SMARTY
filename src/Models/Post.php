<?php
namespace App\Models; // Не забывайте namespace для работы PSR-4

use Core\Database;
use PDO;

class Post {

    /**
     * @return array
     */
    public static function getLatestThreePostsPerCategory(): array {
        $db = Database::getConnection();
        $sql = " 
            WITH RankedPosts AS ( 
                SELECT p.*, pc.category_id, 
                       ROW_NUMBER() OVER (PARTITION BY pc.category_id ORDER BY p.created_at DESC) as rn 
                FROM posts p 
                JOIN post_category pc ON p.id = pc.post_id 
            ) 
            SELECT rp.*, c.name as category_name 
            FROM RankedPosts rp 
            JOIN categories c ON rp.category_id = c.id 
            WHERE rp.rn <= 3 
        ";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll();

        $categories = [];
        foreach ($result as $row) {
            $catId = $row['category_id'];
            if (!isset($categories[$catId])) {
                $categories[$catId] = [
                    'id' => $catId,
                    'name' => $row['category_name'],
                    'posts' => []
                ];
            }
            $categories[$catId]['posts'][] = $row;
        }
        return $categories;
    }

    /**
     * @param int $postId
     * @param int $limit
     * @return array
     */
    public static function getSimilarPosts(int $postId, int $limit = 3): array {
        $db = Database::getConnection();

        $sql = " 
            SELECT p.*, COUNT(pc2.category_id) as common_categories_count 
            FROM post_category pc1 
            JOIN post_category pc2 ON pc1.category_id = pc2.category_id AND pc2.post_id != pc1.post_id 
            JOIN posts p ON pc2.post_id = p.id 
            WHERE pc1.post_id = :post_id 
            GROUP BY p.id 
            ORDER BY common_categories_count DESC, p.created_at DESC 
            LIMIT :limit 
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        // Важно: в PDO для LIMIT нужно явно указывать PARAM_INT, иначе он обернет число в кавычки '3' и SQL упадет
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    /**
     * @param int $categoryId
     * @return int
     */
    public static function countByCategoryId(int $categoryId): int {
        $db = \Core\Database::getConnection();


        $stmt = $db->prepare("
        SELECT COUNT(*) 
        FROM post_category 
        WHERE category_id = :category_id
    ");
        $stmt->execute(['category_id' => $categoryId]);

        return (int)$stmt->fetchColumn();
    }

    /**
     * @param int $categoryId
     * @param string $sortField
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public static function getByCategoryId(int $categoryId, string $sortField, int $page, int $perPage): array {
        $db = \Core\Database::getConnection();


        $offset = ($page - 1) * $perPage;

        // Строгая проверка поля сортировки (защита от SQL-инъекций)
        if (!in_array($sortField, ['created_at', 'views_count'])) {
            $sortField = 'created_at';
        }


        $sql = "
        SELECT p.* 
        FROM posts p
        JOIN post_category pc ON p.id = pc.post_id
        WHERE pc.category_id = :category_id
        ORDER BY p.{$sortField} DESC
        LIMIT :limit OFFSET :offset
    ";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function getById(int $id): ?array {
        $db = \Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch();
        return $post ? $post : null;
    }

    /**
     * @param int $id
     * @return void
     */
    public static function incrementViews(int $id): void {
        $db = \Core\Database::getConnection();
        $stmt = $db->prepare("UPDATE posts SET views_count = views_count + 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }


}
