<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Core\Database;

$db = Database::getConnection();

if (file_exists(__DIR__ . '/schema.sql')) {
    echo "Импорт структуры базы данных из schema.sql...\n";
    $sql = file_get_contents(__DIR__ . '/schema.sql');
    $db->exec($sql);
}

$db->exec("SET FOREIGN_KEY_CHECKS = 0; TRUNCATE post_category; TRUNCATE posts; TRUNCATE categories; SET FOREIGN_KEY_CHECKS = 1;");


$categories = ['Технологии', 'Финансы', 'Кулинария', 'Путешествия'];
foreach ($categories as $cat) {
    $stmt = $db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->execute([$cat, "Описание категории $cat"]);
}


for ($i = 1; $i <= 30; $i++) {
    $stmt = $db->prepare("INSERT INTO posts (title, description, content, views_count) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        "Заголовок статьи №$i",
        "Краткое описание для статьи №$i",
        "Полный текст статьи. Бла-бла-бла...",
        rand(10, 1000)
    ]);
    $postId = $db->lastInsertId();

    // Привязываем к 1-2 случайным категориям
    $catIds = array_rand(range(1, 4), rand(1, 2));
    $catIds = is_array($catIds) ? $catIds : [$catIds];
    foreach ($catIds as $catId) {
        $stmt = $db->prepare("INSERT INTO post_category (post_id, category_id) VALUES (?, ?)");
        $stmt->execute([$postId, $catId + 1]); // массив array_rand с нуля, id с 1
    }
}
echo "Сидинг успешно завершен!\n";
