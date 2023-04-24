<?php

namespace LIB\Session;

class Session {



    public function get($key = '*'){
        return $key == '*' ? $_SESSION : $_SESSION[$key];
    }
}