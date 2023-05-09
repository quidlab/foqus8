<?php

namespace App\Middleware;

use App\Exceptions\NotAuthorizedException;

class RoleMiddleware extends Middleware{
    protected $role;
    public function __construct($role){
        $this->role = $role;
    }
    
    public function handler()
    {
        if (auth()->user?->{'role-id'} != 7 /*SUPER_ADMIN*/) {
            throw new NotAuthorizedException();
        }
        return true;
    }
}