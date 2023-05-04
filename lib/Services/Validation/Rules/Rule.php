<?php

namespace Lib\Services\Validation\Rules;

abstract class Rule
{

    /* 
    
    */
    abstract public function name(): string;

    /* 
    
    */
    abstract public function validate(array $value, $key): bool;


    /* 
    
    */
    abstract public function message(): string;
}
