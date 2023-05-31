<?php

namespace Lib\Services\Validation;

use App\Exceptions\ValidationException;
use App\Exceptions\NotFoundException;

class Validator
{

    private $validatedData = [];
    public $errorsBag = [];
    private $data;
    private $rules;
    protected $rulesNames = [
        'required' => 'Lib\Services\Validation\Rules\Required',
        'contains-uppercase' => 'Lib\Services\Validation\Rules\ContainsUppercase',
        'contains-lowercase' => 'Lib\Services\Validation\Rules\ContainsLowercase',
        'contains-specialcharacter' => 'Lib\Services\Validation\Rules\ContainsSpecialcharacter',
        'contains-digit' => 'Lib\Services\Validation\Rules\ContainsDigit',
        'min' => 'Lib\Services\Validation\Rules\MinRule',
        'nullable' => 'Lib\Services\Validation\Rules\NullableRule',
        'email' => 'Lib\Services\Validation\Rules\EmailRule',
        'number' => 'Lib\Services\Validation\Rules\NumberRule',
        'in' => 'Lib\Services\Validation\Rules\InRule',
    ];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }


    /* 
    
    */
    public function validate()
    {
        if ($this->fails()) {
            print_r($this->errorsBag);die;
            throw new ValidationException($this->errorsBag);
        }

        return $this->validatedData;
    }


    /* 
    
    */
    public function fails()
    {
        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {
                $ruleParts = explode(':', $rule);


                if (count($ruleParts) > 1) {
                    $ruleInstance = $this->onGoingRule($ruleParts[0], $ruleParts[1]);
                } else {
                    $ruleInstance = $this->onGoingRule($ruleParts[0]);
                }

                if ($ruleInstance->validate($this->data, $key)) {
                    $this->validatedData[$key] = $this->data[$key];
                } else {
                    $this->errorsBag[$key] = $ruleInstance->message();
                    break;
                }
            }
        }

        return count($this->errorsBag);
    }


    /* 
    
    */

    protected function onGoingRule($key, $params = null)
    {
        if (!in_array($key, array_keys($this->rulesNames)))
            throw new NotFoundException('Rule {' . $key . ' } Not Exists');

        return new $this->rulesNames[$key]($params);
    }
}
