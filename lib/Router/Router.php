<?php

namespace LIB\Router;

use App\Middleware\Middleware;
use Exception;
use LIB\Router\Method;


class Router
{
    protected $routes = [];
    public const HOME = '/admin/dashboard';


    
    public function get(string $path, $handler, Middleware ...$middlewares): object
    {
        return $this->addRoute($path, Method::GET, $handler, $middlewares);
    }

    public function post(string $path, $handler, Middleware ...$middlewares): object
    {
        return $this->addRoute($path, Method::POST, $handler, $middlewares);
    }

    protected function addRoute(string $path, Method $method, $handler, array $middlewares): object
    {
        $this->routes[$method->value . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler,
            'middlewares' =>  $middlewares
        ];
        return $this;
    }

    public function run()
    {
        $matchedRoute = $this->matchedRoute();
        if ($matchedRoute == null) {
            $this->notFoundHandler();
        } else {
            /* call middlewares */
            foreach ($matchedRoute['middlewares'] as $middleware) {
                call_user_func([$middleware, 'handler']);
            }
            /* call middlewares end */

            $callback = $matchedRoute['handler'];
            if (is_callable($callback)) {
                call_user_func_array($callback, [
                    array_merge($_GET, $_POST)
                ]);
            } else {
                $controller = new $callback[0]();
                call_user_func_array([$controller, $callback[1]], [
                    array_merge($_GET, $_POST)
                ]);
            }
        }
    }


    protected function matchedRoute()
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $path = $uri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $matchedRoute = null;
        foreach ($this->routes as $key => $route) {
            if ($route['path'] == $path && $method === $route['method']->value) {
                $matchedRoute = $route;
            }
        }
        return $matchedRoute;
    }




    /*     public function guest(...$auth){
        return;
        header('location: /' );
        foreach ($auth as $key => $value) {
            if (isset($_SESSION[$value])) {
            }
        }
    }
 */

    public function notFoundHandler()
    {
        view('errors/404'); // TODO => create a NotFound Exception and add this view function in it's handler
        throw new Exception("NOT Found", 1, null); // TODO => make the second param depends on a env variable called production 
    }
}
