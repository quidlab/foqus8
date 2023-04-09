<?php
namespace LIB\App;

class App{
    public $local = 'en';
    public function __construct()
    {
        if (array_key_exists('lang',$_GET)) {
            $local = $_GET['lang'];
            $_SESSION['lang'] = $local;
            $this->local = $local;
        }elseif (array_key_exists('lang',$_SESSION)) {
            $local = $_SESSION['lang'];
            $this->local = $local;
        }
    }
}