<?php

namespace LIB\App;

use LIB\Local\Local;

class App
{
    public $local = 'en';
    public function __construct()
    {
        $activeLocales = Local::getInstance()->getLocales();
        $local = $this->local;

        if (array_key_exists('lang', $_GET)) {
            $local = $_GET['lang'];
            $_SESSION['lang'] = $local;
        } elseif (array_key_exists('lang', $_SESSION)) {
            $local = $_SESSION['lang'];
        }
        
        if (count($activeLocales) > 0 && !in_array($local,$activeLocales) ) {
            $local = $activeLocales[0];
        }
        $this->local = $local;
    }



    public function getUserIP()
    {
        $ipaddress = '';
        if (key_exists('HTTP_X_FORWARDED_FOR',$_SERVER))
           //$ipaddress = reset(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])); 
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']; // there is warning here on the server
        else if (key_exists('HTTP_CLIENT_IP',$_SERVER))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (key_exists('HTTP_X_FORWARDED',$_SERVER))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (key_exists('HTTP_FORWARDED_FOR',$_SERVER))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (key_exists('HTTP_FORWARDED',$_SERVER))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (key_exists('REMOTE_ADDR',$_SERVER))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
