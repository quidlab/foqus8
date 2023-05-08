<?php
namespace App\Models;

use Lib\Services\Authenticatable\AuthenticatableModel;

class User extends AuthenticatableModel {

    static $table = 'users';
    protected static $guardKey = 'uname';
    protected static $primaryKey = 'user-id';
    public static $readable = [
        'user-id',
        'user-name',
        'role-id',
        'email',
        'mobile',
        'active',
        'preferred-language'
    ];


     
}