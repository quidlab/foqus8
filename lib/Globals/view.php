<?php

function view(string $name,$args = []){
    if (!file_exists( __DIR__ . '../../../views/'.$name.'.php')) {
        throw new Exception("File ".$name.'.php Not Found Make Sure it exists inside view folder', 1); // TODO => create a FileNotFound Exception
    }

    foreach ($args as $key => $value) {
        ${$key} = $value;
    }
    require_once __DIR__ . '../../../views/'.$name.'.php';
}
