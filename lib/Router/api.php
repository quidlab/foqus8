<?php

use App\Controllers\API\LanguagesController;
use App\Middleware\AuthMiddleware;
use LIB\Router\Router;
use App\Controllers\API\TranslationsController;
use App\Controllers\API\UsersController;


/* Translations */

$router->get("/api/admin/translations", [TranslationsController::class, 'index'], new AuthMiddleware('uname'));
$router->put("/api/admin/translations", [TranslationsController::class, 'update'], new AuthMiddleware('uname'));
$router->post("/api/admin/translations", [TranslationsController::class, 'store'], new AuthMiddleware('uname'));
$router->delete("/api/admin/translations", [TranslationsController::class, 'truncate'], new AuthMiddleware('uname'));

/* Languages */

$router->get("/api/admin/languages", [LanguagesController::class, 'index'], new AuthMiddleware('uname'));
$router->put("/api/admin/languages", [LanguagesController::class, 'update'], new AuthMiddleware('uname'));


/* Users */
$router->get('/api/admin/users', [UsersController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/users', [UsersController::class, 'store'], new AuthMiddleware('uname'));
$router->post('/api/admin/users/import', [UsersController::class, 'import'], new AuthMiddleware('uname'));
$router->delete('/api/admin/users', [UsersController::class, 'destroy'], new AuthMiddleware('uname'));
$router->put('/api/admin/users', [UsersController::class, 'update'], new AuthMiddleware('uname'));

