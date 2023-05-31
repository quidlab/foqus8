<?php


namespace Lib\Services\Validation\Rules;

class NumberRule extends Rule
{
    protected $data;
    protected $key;

    /* 
    
    */
    public function name(): string
    {
        return 'number';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        $this->key = $key;
        return is_numeric($data[$key]);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('number-rule-message', [
            'name' => $this->key
        ]);
    }
}
