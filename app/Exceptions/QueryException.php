<?php

namespace App\Exceptions;

use Throwable;

class QueryException extends CustomException
{
    public $errorsBag;
    public function __construct(array $errorsBag = [], $code = 502, Throwable $previous = null)
    {
        $this->errorsBag = $errorsBag;
        back()->withErrors($errorsBag);
    }

    public function __toString()
    {
        return $this->errorsBag;
    }
}
