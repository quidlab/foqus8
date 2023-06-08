<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

$router->get('/display', function () {
    return view('/display/index');
}, new AuthMiddleware('uname'), new RoleMiddleware(1, 2, 3, 5, 7));
