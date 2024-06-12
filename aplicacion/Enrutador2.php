<?php
namespace aplicacion;

class Enrutador
{

    public static function get($path = '/', $controller = '', $action = null)
    {
        return self::handle('GET', $path, $controller, $action);
    }

    public static function post($path = '/', $controller = '', $action = null)
    {
        return self::handle('POST', $path, $controller, $action);
    }

    public static function put($path = '/', $controller = '', $action = null)
    {
        return self::handle('UPDATE', $path, $controller, $action);
    }

    public static function delete($path = '/', $controller = '', $action = null)
    {
        return self::handle('DELETE', $path, $controller, $action);
    }

    public static function handle($method = 'GET', $path = '/', $controller = '', $action = null)
    {

        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $currentUri = $_SERVER['REQUEST_URI'];
        $currentUri = parse_url($currentUri, PHP_URL_PATH);

        //$root = '(?:\?(?P<query>.+))?';

        $pattern = '#^' . preg_replace('/{([^\/]+)}/', '(?P<$1>\d+)', $path) .     '$#siD';


        if (preg_match($pattern, $currentUri, $matches)) {

            if ($currentMethod != $method) {
                http_response_code(405);
    
                echo json_encode([
                    'error' => 'Method not allowed'
                ]);
    
                exit();
            }

            if (is_callable($controller)) {
                $controller($matches);
            } else {

                require_once __DIR__ . '/../controladores/' . $controller . '.php';
                $controller = '\\controladores\\' . $controller;
                $controller = new $controller();

                $requestData = json_decode(file_get_contents('php://input'), true);
                $controller->$action($requestData);
            }
            exit();
        }
        
    }
}
