<?php

namespace App\Exceptions;

use Throwable;

class ValidationException extends CustomException
{
    public $errorsBag;
    public function __construct(array $errorsBag = [], $code = 422, Throwable $previous = null)
    {
        $this->errorsBag = $errorsBag;
        parent::__construct($this->error(), $code);
    }

    public function __toString()
    {
        return $this->error();
    }

    public function error()
    {
        return count($this->errorsBag) > 0 ? array_values($this->errorsBag)[0] : NULL;
    }
}
