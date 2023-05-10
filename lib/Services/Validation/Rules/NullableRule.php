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
        return in_array($key, array_keys($data));
    }


    /* 
    
    */
    public function message(): string
    {
        return __('nullable-message');// the key does not 
    }
}
