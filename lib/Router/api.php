

<?php
use App\Middleware\AuthMiddleware;
use LIB\Router\Router;
use App\Controllers\API\TranslationsController;


/* Translations */

$router->get("/api/admin/translations", [TranslationsController::class, 'index'], new AuthMiddleware('uname'));
// $router->put("/api/admin/translations", [TranslationsController::class, 'update'], new AuthMiddleware('uname'));
$router->post("/api/admin/translations", [TranslationsController::class, 'store'], new AuthMiddleware('uname'));
$router->delete("/api/admin/translations", [TranslationsController::class, 'truncate'], new AuthMiddleware('uname'));
