<?php


namespace Lib\Services\Validation\Rules;

class InRule extends Rule
{
    protected $data;
    protected $key;
    protected $array;

    public function __construct($array)
    {
        $this->array = explode(',', $array);
    }
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
        return in_array($data[$key], $this->array);
    }


    /* 
    
    */
    public function message(): string
    {
        return __('in-rule-message', [
            'name' => $this->key,
            'array' => implode(",", array_slice($this->array, 0, 5))
        ]);
    }
}
