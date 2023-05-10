<?php

use App\Controllers\API\IPAddressesController;
use App\Controllers\API\LanguagesController;
use App\Controllers\API\PresentersController;
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


/* Presenters */
$router->get('/api/admin/presenters', [PresentersController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/presenters', [PresentersController::class, 'store'], new AuthMiddleware('uname'));
$router->post('/api/admin/presenters/create-many', [PresentersController::class, 'storeMany'], new AuthMiddleware('uname'));
$router->delete('/api/admin/presenters', [PresentersController::class, 'destroy'], new AuthMiddleware('uname'));
$router->put('/api/admin/presenters', [PresentersController::class, 'update'], new AuthMiddleware('uname'));
$router->post('/api/admin/presenters/import', [PresentersController::class, 'import'], new AuthMiddleware('uname'));

/* Addresses */
$router->get('/api/admin/ipaddresses', [IPAddressesController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/ipaddresses', [IPAddressesController::class, 'store'], new AuthMiddleware('uname'));
$router->delete('/api/admin/ipaddresses', [IPAddressesController::class, 'destroy'], new AuthMiddleware('uname'));



