<?php


class CSRF
{



    static function token()
    {
        if ($_SESSION['token']) {
            return $_SESSION['token'];
        } else {
            $_SESSION['token'] = bin2hex(random_bytes(35));
        }
    }
}
