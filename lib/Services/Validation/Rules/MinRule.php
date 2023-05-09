<?php

namespace Lib\Services\Validation\Rules;

use Exception;
use Lib\Services\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;

class MinRule extends Rule
{
    protected $data;
    protected $length;


    public function __construct($length)
    {
        if ($length && is_numeric($length)) {
            $this->length = $length;
        } else {
            throw new Exception("Min Rule Excpects parameter of type int " . gettype($length) . " given");
        }
    }
    /* 
    
    */
    public function name(): string
    {
        return 'min';
    }


    /* 
    
    */
    public function validate(array $data, $key): bool
    {
        return in_array($key, array_keys($data))
            && isset($data[$key])
            && strlen($data[$key]) >= $this->length;
    }


    /* 
    
    */
    public function message(): string
    {
        return __('min-message') . " " .$this->length;
    }
}
