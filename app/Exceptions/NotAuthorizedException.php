<?php

namespace App\Exceptions;

use Throwable;
class NotAuthorizedException extends CustomException
{
    public function __construct($message = "You are not authorized to access this page", $code = 500, Throwable $previous = null)
    {
        return view('/errors/401');
    }

    public function __toString()
    {
        return "You are not authorized to access this page " . $this->message;
    }
}
