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



    public function getUserIP(){
         $ipaddress = '';
         if($_SERVER['HTTP_X_FORWARDED_FOR']){
            $k= explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ipaddress = reset($k);
         }
         else if ($_SERVER['HTTP_CLIENT_IP'])
             $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
         else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
         else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
         else if($_SERVER['HTTP_FORWARDED'])
             $ipaddress = $_SERVER['HTTP_FORWARDED'];
         else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
         else
            $ipaddress = 'UNKNOWN';

         $ipaddress = explode(':', $ipaddress);
         return $ipaddress[0];
        //return filter_var($ipaddress, FILTER_VALIDATE_IP);
        
    }
    
}
