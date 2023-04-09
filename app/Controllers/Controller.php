<?php
namespace App\Controllers;

class Controller{
    protected $DB;
    protected $app;
    function __construct()
    {
        global $FoQusdatabase;
        $this->DB = $FoQusdatabase;

        global $app;
        $this->app = $app;
    }
}