<?php

define('REQUEST_START_TIME',microtime(true));

session_start();

require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/gettranslations.php';
spl_autoload_register(function(string $name) {
    require_once('../'.$name.'.php'); 
});
require_once __DIR__ . '/../lib/autoload.php';

