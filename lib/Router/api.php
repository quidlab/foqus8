<?php

use App\Controllers\API\CouponsController;
use App\Controllers\API\IPAddressesController;
use App\Controllers\API\LanguagesController;
use App\Controllers\API\PresentersController;
use App\Controllers\API\ProxyNamesController;
use App\Controllers\API\ShareholdersController;
use App\Controllers\API\StakeHoldersController;
use App\Middleware\AuthMiddleware;
use LIB\Router\Router;
use App\Controllers\API\TranslationsController;
use App\Controllers\API\UsersController;
use App\Controllers\API\UploadFilesController;

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
$router->post('/api/admin/presenters/export', [PresentersController::class, 'export'], new AuthMiddleware('uname'));
$router->post('/api/admin/presenters/mail', [PresentersController::class, 'sendMail'], new AuthMiddleware('uname'));

/* Addresses */
$router->get('/api/admin/ipaddresses', [IPAddressesController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/ipaddresses', [IPAddressesController::class, 'store'], new AuthMiddleware('uname'));
$router->delete('/api/admin/ipaddresses', [IPAddressesController::class, 'destroy'], new AuthMiddleware('uname'));

/* Upload Files */
$router->get('/api/admin/upload-files', [UploadFilesController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/upload-files', [UploadFilesController::class, 'store'], new AuthMiddleware('uname'));
$router->post('/api/admin/upload-files/update', [UploadFilesController::class, 'update'], new AuthMiddleware('uname'));
$router->delete('/api/admin/upload-files', [UploadFilesController::class, 'destroy'], new AuthMiddleware('uname'));


/* StakeHolders */
$router->get('/api/admin/stakeholders', [StakeHoldersController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/stakeholders', [StakeHoldersController::class, 'store'], new AuthMiddleware('uname'));
$router->put('/api/admin/stakeholders', [StakeHoldersController::class, 'update'], new AuthMiddleware('uname'));
$router->delete('/api/admin/stakeholders', [StakeHoldersController::class, 'destroy'], new AuthMiddleware('uname'));



/* Proxy_Name */
$router->get('/api/admin/proxy-name', [ProxyNamesController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/proxy-name', [ProxyNamesController::class, 'store'], new AuthMiddleware('uname'));
$router->delete('/api/admin/proxy-name', [ProxyNamesController::class, 'destroy'], new AuthMiddleware('uname'));



/* Coupons */
$router->get('/api/admin/coupons', [CouponsController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/coupons', [CouponsController::class, 'store'], new AuthMiddleware('uname'));
$router->put('/api/admin/coupons', [CouponsController::class, 'update'], new AuthMiddleware('uname'));
$router->delete('/api/admin/coupons', [CouponsController::class, 'destroy'], new AuthMiddleware('uname'));


/* Shareholders */
$router->get('/api/admin/shareholders', [ShareholdersController::class, 'index'], new AuthMiddleware('uname'));
$router->post('/api/admin/shareholders/import', [ShareholdersController::class, 'import'], new AuthMiddleware('uname'));

