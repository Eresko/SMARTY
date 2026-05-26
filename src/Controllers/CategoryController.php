<?php
namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use Smarty;

class CategoryController extends BaseController{

    public function show(): void {
        $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $category = Category::getById($categoryId);

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            echo "Категория не найдена";
            return;
        }

        $allowedSorts = [
            'date' => 'created_at',
            'views' => 'views_count'
        ];
        $sortKey = $_GET['sort'] ?? 'date';
        $sortField = $allowedSorts[$sortKey] ?? 'created_at';

        $perPage = 6;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;


        $totalPosts = Post::countByCategoryId($categoryId);
        $totalPages = ceil($totalPosts / $perPage);


        $posts = Post::getByCategoryId($categoryId, $sortField, $currentPage, $perPage);


        $this->smarty->assign('category', $category);
        $this->smarty->assign('posts', $posts);
        $this->smarty->assign('sortKey', $sortKey);
        $this->smarty->assign('currentPage', $currentPage);
        $this->smarty->assign('totalPages', $totalPages);

        $this->smarty->display('category.tpl');
    }
}
