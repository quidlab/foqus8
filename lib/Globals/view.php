<?php

function view(string $name,$args = []){
    $root = $_SERVER["DOCUMENT_ROOT"];
    if (!file_exists( $root . '/../views/'.$name.'.php')) {
        throw new Exception("File ".$name.'.php Not Found Make Sure it exists inside view folder', 1); // TODO => create a FileNotFound Exception
    }

    foreach ($args as $key => $value) {
        ${$key} = $value;
    }
    require_once $root . '/../views/'.$name.'.php';
}
