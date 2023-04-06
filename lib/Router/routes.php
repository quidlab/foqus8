<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use LIB\Router\Router;
use LIB\Request\Request;

$_SESSION['uname'] = 'jj';
$router = new Router();

$router->get('/admin/login',[AuthController::class,'login'])->auth('uname');
$router->get('/admin/dashboard',[DashboardController::class,'index'])->auth('uname');


$router->post('/admin/login',[AuthController::class,'auth']);
$router->post('/admin/logout',[AuthController::class,'logout']);
 
$router->run();
