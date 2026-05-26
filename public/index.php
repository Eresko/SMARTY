<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Core\View;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\PostController;


$smarty = View::getSmarty();


$router = new Router();
$router->add('home', HomeController::class, 'index');
$router->add('category', CategoryController::class, 'show');
$router->add('post', PostController::class, 'show');


$currentRoute = $_GET['route'] ?? 'home';


$router->dispatch($currentRoute, $smarty);
