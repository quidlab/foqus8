<?php

use LIB\Router\Router;

$_SESSION['uname'] = 'jj';

$router = new Router();

$router->get('/login',function(){
    
    $title = "Lol";
    view('logfin',[
        'title' => $title
    ]);
})->auth('uname');





$router->run();