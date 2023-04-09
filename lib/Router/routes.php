<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\RoutesController;
use App\Middleware\AuthMiddleware;
use LIB\Router\Router;
use LIB\Request\Request;

$router = new Router();

$router->get('/',function(){
    redirect(Router::HOME);
});
$router->get('/admin',function(){
    redirect(Router::HOME);
});
$router->get('/admin/login',[AuthController::class,'login']);
$router->get('/admin/dashboard',[DashboardController::class,'index'],new AuthMiddleware('uname'));
$router->get('/admin/admin-tools',[RoutesController::class,'adminTools'],new AuthMiddleware('uname'));


$router->post('/admin/login',[AuthController::class,'auth']);
$router->post('/admin/logout',[AuthController::class,'logout']);
 
$router->run();
