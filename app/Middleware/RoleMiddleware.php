<?php

namespace App\Middleware;

use App\Exceptions\NotAuthorizedException;

class RoleMiddleware extends Middleware
{
    protected $roles;
    protected $allRoles = [
        1 => 'admin',
        2 => 'registration-staff',
        7 => 'super-admin'
    ];
    public function __construct(...$roles)
    {
        $this->roles = $roles;
    }

    public function handler()
    {
        if (!in_array(auth()->user()?->{'role-id'}, $this->roles) /*SUPER_ADMIN*/) {
            throw new NotAuthorizedException();
        }
        return true;
    }
}
