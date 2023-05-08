<?php


namespace Lib\Services\Validation\Rules;

class ContainsDigit extends Rule
{
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'contains-digit';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return in_array($key, array_keys($data))
            && preg_match('/\d/',$data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('contains-digit-message');
    }
}
