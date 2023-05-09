<?php

namespace App\Exceptions;

use Throwable;

class NotFoundException extends CustomException
{
    public function __construct($message = "Not Found", $code = 404, Throwable $previous = null)
    {
        return view('/errors/404', [
            'message' => $message
        ]);
    }

    public function __toString()
    {
        return 'Not Found';
    }
}
