<?php
namespace App\Exceptions;

use Exception;
use Throwable;

class NotAuthException extends Exception
{
    public function __construct($message = "Not Authenticated", $code = 0, Throwable $previous = null) {

        parent::__construct($message, $code, $previous);
        redirect('/admin/login');
    }

    public function __toString() {
        return "You Are Not Authenticated " . $this->message;
    }
}