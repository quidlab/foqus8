<?php

namespace Lib\Services\Validation\Rules;

class ContainsSpecialcharacter extends Rule {
    protected $data;

    /* 
    
    */
    public function name(): string
    {
        return 'contains-specialcharacter';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return in_array($key, array_keys($data)) && $data[$key]
            && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('contains-specialcharacter-text');
    }
}