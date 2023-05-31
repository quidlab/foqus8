<?php

namespace LIB\Router;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Middleware\Middleware;
use Exception;
use LIB\Router\Method;


class Router
{
    protected $routes = [];
    public const HOME = '/admin/dashboard';



    public function get(string $path, $handler, Middleware ...$middlewares): object
    {
        return $this->registerRoute($path, Method::GET, $handler, $middlewares);
    }

    public function post(string $path, $handler, Middleware ...$middlewares): object
    {
        return $this->registerRoute($path, Method::POST, $handler, $middlewares);
    }

    public function put(string $path, $handler, Middleware ...$middlewares): object
    {
        return $this->registerRoute($path, Method::PUT, $handler, $middlewares);
    }
    public function delete(string $path, $handler, Middleware ...$middlewares): object
    {
        return $this->registerRoute($path, Method::DELETE, $handler, $middlewares);
    }



    protected function registerRoute(string $path, Method $method, $handler, array $middlewares): object
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
        try {
            $matchedRoute = $this->matchedRoute();
        } catch (\Throwable $th) {
            if (request()->accept() == 'text/html') {
                return view('/errors/404', [
                    'message' => $th->getMessage()
                ]);
            } else {
                return response()->json([
                    "message" => $th->getMessage(),
                    "code" => $th->getCode(),
                    'status' => false,
                ], $th->getCode());
            }
        }


        /* call middlewares */
        foreach ($matchedRoute['middlewares'] as $middleware) {
            try {
                call_user_func([$middleware, 'handler']); // MOSTAFA_TODO add exxception for non existing functions
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        /* call middlewares end */

        try {

            $callback = $matchedRoute['handler'];
            if (!is_callable($callback)) {
                $controller = new $callback[0]();
                $callback = [$controller, $callback[1]];
            }
            $this->dispatchFunction($callback);
        } catch (Exception $th) {
            $accept = explode(',', getallheaders()['Accept'])[0];
            if ($accept  == 'text/html') {
                return back()->withErrors(
                    ['error' =>  $th->getMessage()]
                );
            }
            return response()->json([
                "message" => $th->getMessage(),
                "code" => $th->getCode(),
                'status' => false,
            ], $th->getCode());
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

        if ($matchedRoute == null) {
            throw new NotFoundException("Page NOT Found", 404, null);
        }
        return $matchedRoute;
    }



    protected function dispatchFunction($callback)
    {
        call_user_func_array($callback, [
            array_merge($_GET, $_POST, $_FILES)
        ]);
    }
}
