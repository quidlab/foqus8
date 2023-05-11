<?php

namespace Lib\Services\Validation\Rules;

class Required extends Rule
{
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'required';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return in_array($key, array_keys($data))
            && isset($data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('required-message');
    }
}
