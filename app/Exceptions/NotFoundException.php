<?php

namespace App\Exceptions;

use Throwable;

class NotFoundException extends CustomException
{
    public function __construct($message = "Not Found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return 'Not Found';
    }
}
