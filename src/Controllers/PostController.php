<?php
namespace App\Controllers;

use App\Models\Post;
use Smarty;

class PostController {
    private Smarty $smarty;

    public function __construct(Smarty $smarty) {
        $this->smarty = $smarty;
    }

    public function show(): void {
        $postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Получаем данные статьи
        $post = Post::getById($postId);

        if (!$post) {
            header("HTTP/1.0 404 Not Found");
            echo "Статья не найдена";
            return;
        }

        // Увеличиваем счетчик просмотров (требование ТЗ)
        Post::incrementViews($postId);
        // Обновляем значение в массиве для корректного отображения пользователю сразу
        $post['views_count']++;

        // Получаем 3 похожие статьи по пересечению категорий
        $similarPosts = Post::getSimilarPosts($postId, 3);

        // Передаем данные в шаблон
        $this->smarty->assign('post', $post);
        $this->smarty->assign('similarPosts', $similarPosts);

        $this->smarty->display('post.tpl');
    }
}
