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
}
