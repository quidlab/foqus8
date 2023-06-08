<?php

use App\Controllers\AuthController;
use App\Controllers\CompanyController;
use App\Controllers\ConstantController;
use App\Controllers\DashboardController;
use App\Controllers\DatabaseController;
use App\Controllers\RoutesController;
use App\Controllers\AgendaController;
use App\Controllers\AgendaDetailsController;
use App\Controllers\DirectorController;
use App\Controllers\ProfileController;
use App\Controllers\SystemConstantController;
use App\Exceptions\ValidationException;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;
use LIB\Router\Router;

$router = new Router();


$router->get('/', function () {
    return view('shareholders/login');
});

$router->get('/admin/profile', function () {
    $user = database()->Select("Select TOP(1) * FROM users Where [user-name] = '" . $_SESSION['uname'] . "'")[0];
    return view('/admin/profile', ['user' => $user], 'admin/index');
}, new AuthMiddleware('uname'));

$router->post('/admin/profile', [ProfileController::class, 'update']);

$router->get('/director/login', function () {
    return view('directors/login');
});
$router->get('/director', function () {
    redirect('/directors/login');
});
$router->get('/admin', function () {
    return redirect(Router::HOME);
});

/* AUTH */
$router->get('/admin/login', [AuthController::class, 'login'], new GuestMiddleware('uname'));
$router->get('/auth/otp', [AuthController::class, 'otpForm'], new GuestMiddleware('uname'));
$router->post('/auth/otp', [AuthController::class, 'verifyOTP'], new GuestMiddleware('uname'));
/*  */

$router->get('/admin/dashboard', [DashboardController::class, 'index'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/admin-tools', [RoutesController::class, 'adminTools'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/manage-company', [RoutesController::class, 'manageCompany'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/system-constants', [RoutesController::class, 'systemConstants'], new AuthMiddleware('uname'), new RoleMiddleware(7));
$router->get('/admin/agendas/view', [RoutesController::class, 'agendas'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/translations', [RoutesController::class, 'translations'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/users', [RoutesController::class, 'users'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/presenters', [RoutesController::class, 'presenters'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/upload-files', [RoutesController::class, 'uploadFiles'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/stakeholders', [RoutesController::class, 'stakeholders'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/proxy-names', [RoutesController::class, 'proxyNames'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/coupons', [RoutesController::class, 'coupons'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/import-shareholders', [RoutesController::class, 'importShareholders'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/egm-activation', [RoutesController::class, 'egmActivation'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/join-online-joiners', [RoutesController::class, 'ApproveOnlineJoiners'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/reports', [RoutesController::class, 'reports'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

/* Company */
$router->get('/admin/company', [CompanyController::class, 'getAll'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/company', [CompanyController::class, 'update'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));


/* System Constants */
$router->get('/admin/system-constants/string', [SystemConstantController::class, 'getString'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/system-constants/string', [SystemConstantController::class, 'updateString'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/system-constants/date', [SystemConstantController::class, 'getDate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/system-constants/date', [SystemConstantController::class, 'updateDate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/system-constants/bool', [SystemConstantController::class, 'getBool'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/system-constants/bool', [SystemConstantController::class, 'updateBool'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/system-constants/number', [SystemConstantController::class, 'getNumber'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/system-constants/number', [SystemConstantController::class, 'updateNumber'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/system-constants/select', [SystemConstantController::class, 'getSelect'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

/* Constants */
$router->get('/admin/constants/meeting', [ConstantController::class, 'meetingIndex'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/constants/meeting', [ConstantController::class, 'meetingUpdate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/constants/select', [ConstantController::class, 'getSelect'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/constants/select', [ConstantController::class, 'updateSelect'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));


$router->get('/admin/constants/date', [ConstantController::class, 'dateConstants'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/constants/date', [ConstantController::class, 'dateUpdate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/constants/bool', [ConstantController::class, 'boolConstants'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/constants/bool', [ConstantController::class, 'boolUpdate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->get('/admin/constants/int', [ConstantController::class, 'intConstants'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/constants/int', [ConstantController::class, 'intUpdate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
/* Agendas */
$router->get('/admin/agendas', [AgendaController::class, 'index'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/agendas/create', [RoutesController::class, 'createAgenda'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->get('/admin/agendas/create2', [RoutesController::class, 'createAgenda2'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->post('/admin/agendas', [AgendaController::class, 'store'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/agendas', [AgendaController::class, 'update'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->delete('/admin/agendas', [AgendaController::class, 'truncate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

/* Directors */
$router->get('/admin/directors', [DirectorController::class, 'index'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->post('/admin/directors', [DirectorController::class, 'store'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/directors', [DirectorController::class, 'update'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->delete('/admin/directors', [DirectorController::class, 'truncate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

/* AgendaDetails */
$router->get('/admin/agenda-details', [AgendaDetailsController::class, 'index'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->post('/admin/agenda-details', [AgendaDetailsController::class, 'store'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->put('/admin/agenda-details', [AgendaDetailsController::class, 'update'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->delete('/admin/agenda-details', [AgendaDetailsController::class, 'truncate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));

$router->post('/database/truncate', [DatabaseController::class, 'truncate'], new AuthMiddleware('uname'), new RoleMiddleware(7, 1));
$router->post('/admin/login', [AuthController::class, 'auth']);
$router->post('/admin/logout', [AuthController::class, 'logout']);





require_once 'api.php';
require_once 'display-routes.php';
$router->run();
