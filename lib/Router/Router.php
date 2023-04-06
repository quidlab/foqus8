<?php

namespace LIB\Router;


use Exception;
use LIB\Router\Method;


class Router
{
    protected $routes = [];

    public function get(string $path, array $handler): object
    {
        $this->addRoute($path, Method::GET, $handler);
        return $this;
    }

    public function post(string $path, array $handler): object
    {
        $this->addRoute($path, Method::POST, $handler);
        return $this;
    }

    protected function addRoute(string $path, Method $method, array $handler): void
    {
        $this->routes[$method->value . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $path = $uri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;
        foreach ($this->routes as $key => $route) {
            if ($route['path'] == $path && $method === $route['method']->value) {
                $callback = $route['handler'];
            }
        }
        if ($callback == null) {
            $this->notFoundHandler();
        } else {
            $controller = new $callback[0]();
            call_user_func_array([$controller, $callback[1]], [
                array_merge($_GET, $_POST)
            ]);
        }
    }

    public function auth(...$auth)
    {
        foreach ($auth as $key => $value) {
            if (isset($_SESSION[$value])) {
                return true;
            }
        }

        // if the user not auth
        $this->notAuthHandler();
    }


    public function notFoundHandler()
    {
        view('errors/404'); // TODO => create a NotFound Exception and add this view function in it's handler
        throw new Exception("NOT Found", 1, null); // TODO => make the second param depends on a env variable called production 
    }


    public function notAuthHandler()
    {
        view('errors/401'); // TODO => create a NotAuth Exception and add this view function in it's handler
        throw new Exception("NOT Auth", 1, null); // TODO => make the second param depends on a env variable called production 
    }
}
