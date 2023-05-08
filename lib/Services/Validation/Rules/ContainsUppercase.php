<?php

namespace Lib\Services\Validation\Rules;

class ContainsUppercase extends Rule
{
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'contains-uppercase';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return in_array($key, array_keys($data)) && $data[$key]
            && preg_match('/[A-Z]/', $data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('contains-uppercase-message');// the value should contain uppercase letter
    }
}
