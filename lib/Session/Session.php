<?php

namespace LIB\Session;

class Session {
    static function get($key){
        return isset($_SESSION[$key])?$_SESSION[$key]:'';
    }
}