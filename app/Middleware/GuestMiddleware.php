<?php
namespace App\Middleware;

use Exception;
use LIB\Router\Router;

class GuestMiddleware extends Middleware{
    protected $auth = [];
    
    public function __construct(string ...$auth)
    {
        $this->auth = $auth;
    }
    public function handler(){

        foreach ($this->auth as $value) {
            if (isset($_SESSION[$value])) {
                return redirect(Router::HOME());
            }
        }
        // if the user not auth
        return true;
    }

}