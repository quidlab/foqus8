<?php

namespace App\Exceptions;

use \Exception;
use \Throwable;

class CustomException  extends Exception
{
    public function __construct($message = "Server Error", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return "Server Error " . $this->message;
    }
}
