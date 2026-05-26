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




        $posts = Post::getByCategoryId($categoryId);


      
    }
}
