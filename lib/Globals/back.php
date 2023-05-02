<?php

use LIB\Request\Request;

function back(){
    $request = new Request();
    return $request->back();
}