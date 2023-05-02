<?php

namespace App\ViewComposer;


abstract class ViewComposer{
    
    abstract public function attach(string $key);
}