<?php

use App\Models\User;

define('REQUEST_START_TIME', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../lib/SMS/sms.php';
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/Globals/database.php';
require_once __DIR__ . '/../lib/local/local.php';
require_once __DIR__ . '/../lib/AzureBlobStorageHandler.php';

require_once __DIR__ . '/../lib/getmeetingconstants.php';

$timeout = (int)constant("MC_SESSION_TIMEOUT_SECONDS");
ini_set("session.gc_maxlifetime", $timeout);
ini_set("session.cookie_lifetime", $timeout);
session_start();
$session_name = session_name();
//Check the session exists or not
if (isset($_COOKIE[$session_name])) {
    setcookie($session_name, $_COOKIE[$session_name], [
        'expires' => time() + $timeout,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

/* Starting The app */
require_once __DIR__ . '/../lib/app.php';
$app = new LIB\App\App();



require_once __DIR__ . '/../lib/gettranslations.php';
spl_autoload_register(function (string $name) {
    $name = str_replace('\\', '/', $name);
    require_once(dirname(__DIR__) . '/' . $name . '.php');
});


require_once __DIR__ . '/../lib/autoload.php';
