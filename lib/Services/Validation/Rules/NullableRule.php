<?php

namespace Lib\Services\Validation\Rules;

class NullableRule extends Rule
{
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'nullable';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return true;
    }


    /* 
    
    */
    public function message(): string
    {
        return __('nullable-message');
    }
}
