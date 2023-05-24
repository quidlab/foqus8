<?php


namespace Lib\Services\Validation\Rules;

class EmailRule extends Rule
{
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'email';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return filter_var($data[$key], FILTER_VALIDATE_EMAIL);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('email-rule-message');
    }
}
