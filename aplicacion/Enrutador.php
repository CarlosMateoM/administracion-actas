<?php

namespace aplicacion;

require_once './aplicacion/Jwt.php';

use aplicacion\Jwt;

class Enrutador
{
    private static $routes = [];
    private static $middlewares = [];

    public static function group(array $middlewares, callable $callback)
    {
        self::$middlewares = $middlewares;
        $callback();
        self::$middlewares = [];
    }

    public static function get($path, $controller, $action = null)
    {
        self::addRoute('GET', $path, $controller, $action);
    }

    public static function post($path, $controller, $action = null)
    {
        self::addRoute('POST', $path, $controller, $action);
    }

    public static function put($path, $controller, $action = null)
    {
        self::addRoute('PUT', $path, $controller, $action);
    }

    public static function delete($path, $controller, $action = null)
    {
        self::addRoute('DELETE', $path, $controller, $action);
    }

    private static function addRoute($method, $path, $controller, $action)
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'middlewares' => self::$middlewares
        ];
    }

    public static function dispatch()
    {
        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes as $route) {
            $pattern = '#^' . preg_replace('/{([^\/]+)}/', '(?P<$1>\d+)', $route['path']) . '$#siD';

            if ($currentMethod === $route['method'] && preg_match($pattern, $currentUri, $matches)) {
                // Execute middlewares
                
                foreach ($route['middlewares'] as $middleware) {

                    $middlewareInstance = new $middleware(new Jwt($_ENV['SECRET_KEY']));

                    if (!$middlewareInstance->handle()) {
                        exit();
                    }
                }

                // Call the controller action
                if (is_callable($route['controller'])) {
                    $route['controller']($matches);
                } else {
                    require_once __DIR__ . '/../controladores/' . $route['controller'] . '.php';
                    $controller = '\\controladores\\' . $route['controller'];
                    $controllerInstance = new $controller();
                    $requestData = json_decode(file_get_contents('php://input'), true);
                    $controllerInstance->{$route['action']}($requestData);
                }
                exit();
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}
