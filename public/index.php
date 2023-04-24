<?php

define('REQUEST_START_TIME',microtime(true));

session_start();

require __DIR__.'/../vendor/autoload.php';


require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/Globals/database.php';
require_once __DIR__ . '/../lib/local/local.php';
require_once __DIR__ . '/../lib/AzureBlobStorageHandler.php';

/* Starting The app */
require_once __DIR__ . '/../lib/app.php';
$app = new LIB\App\App();
require_once __DIR__ . '/../lib/getmeetingconstants.php';
require_once __DIR__ . '/../lib/gettranslations.php';
spl_autoload_register(function(string $name) {
    $name = str_replace('\\','/',$name);
    require_once(dirname(__DIR__) . '/'.$name.'.php'); 
});
require_once __DIR__ . '/../lib/autoload.php';