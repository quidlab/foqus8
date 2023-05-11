<?php

namespace App\Exceptions;

use Throwable;

class ValidationException extends CustomException
{
    public $errorsBag;
    public function __construct(array $errorsBag = [], $code = 422, Throwable $previous = null)
    {
        $this->errorsBag = $errorsBag;
    }

    public function __toString()
    {
        return print_r($this->errorsBag);
    }

    public function error(){
        return count($this->errorsBag) > 0 ?array_values($this->errorsBag)[0]: NULL;
    }
}
