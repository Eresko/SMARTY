<?php
namespace Core;

use Smarty;
class Router {
    private array $routes = [];


    public function add(string $route, string $controller, string $method): void {
        $this->routes[$route] = [
            'controller' => $controller,
            'method' => $method
        ];
    }


    public function dispatch(string $currentRoute, Smarty $smarty): void {

        if (!isset($this->routes[$currentRoute])) {
            header("HTTP/1.0 404 Not Found");
            echo "Страница не найдена (404)";
            return;
        }

        $controllerName = $this->routes[$currentRoute]['controller'];
        $methodName = $this->routes[$currentRoute]['method'];


        if (class_exists($controllerName)) {
            $controller = new $controllerName($smarty);

            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
                return;
            }
        }

        header("HTTP/1.0 500 Internal Server Error");
        echo "Ошибка сервера: метод или контроллер не найден";
    }
}
