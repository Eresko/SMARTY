<?php
namespace App\Controllers;

use App\Models\Post;
use Smarty;
use App\Controllers\BaseController;
class HomeController  extends BaseController{

    public function index(): void {
        $categoriesWithPosts = Post::getLatestThreePostsPerCategory();

        $this->smarty->assign('categories', $categoriesWithPosts);
        $this->smarty->display('home.tpl');
    }
}
