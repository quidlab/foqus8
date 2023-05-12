<?php

namespace Lib\Services\Validation\Rules;

class Required extends Rule
{
    protected $data;
    protected $key;

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
        $this->key = $key;
        return in_array($key, array_keys($data))
            && isset($data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('required-message',[
            'name' => $this->key
        ]);
    }
}
