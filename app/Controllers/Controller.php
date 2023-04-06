<?php
namespace App\Controllers;

class Controller{
    protected $DB;
    function __construct()
    {
        global $FoQusdatabase;
        $this->DB = $FoQusdatabase;
    }
}