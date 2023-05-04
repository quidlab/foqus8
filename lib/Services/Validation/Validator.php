<?php

namespace Lib\Services\Validation;

use App\Exceptions\ValidationException;
use App\Exceptions\NotFoundException;

class Validator
{

    private $validatedData = [];
    private $errorsBag = [];
    private $data;
    private $rules;
    protected $rulesNames = [
        'required' => 'Lib\Services\Validation\Rules\Required',
        'contains-uppercase' => 'Lib\Services\Validation\Rules\ContainsUppercase'
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
                $ruleInstance = $this->onGoingRule($rule);

                if ($ruleInstance->validate($this->data, $key)) {
                    $this->validatedData[$key] = $this->data[$key];
                } else {
                    $this->errorsBag[$key] = $ruleInstance->message();
                }
            }
        }

        return count($this->errorsBag);
    }


    /* 
    
    */

    protected function onGoingRule($key)
    {
        if (!in_array($key, array_keys($this->rulesNames)))
            throw new NotFoundException('Rule {' . $key . ' } Not Exists');

        return new $this->rulesNames[$key]();
    }
}
