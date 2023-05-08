<?php

namespace Lib\Services\Validation\Rules;

class ContainsLowercase extends Rule
{
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'contains-lowercase';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return in_array($key, array_keys($data))
            && preg_match('/[a-z]/', $data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('contains-lowercase-message');
    }
}
