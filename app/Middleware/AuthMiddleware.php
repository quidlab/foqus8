<?php
namespace App\Middleware;

use Exception;

class AuthMiddleware extends Middleware{
    protected $auth = [];
    
    public function __construct(string ...$auth)
    {
        $this->auth = $auth;
    }
    public function handler(){

        foreach ($this->auth as $value) {
            if (isset($_SESSION[$value])) {
                return true;
            }
        }
        // if the user not auth
        throw new Exception("NOT Auth", 1, null); // TODO => make the second param depends on a env variable called production 
    }

}