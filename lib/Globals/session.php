<?php

use LIB\Session\Session;

function session($key){
    return Session::get($key);
}