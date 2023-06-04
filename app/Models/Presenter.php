<?php
namespace App\Models;

use Lib\Services\Authenticatable\AuthenticatableModel;

class Presenter extends AuthenticatableModel {

    static $table = 'presenters';
    protected static $guardKey = 'presenter-user-name';
    protected static $primaryKey = 'user-name';
    public static $readable = [
        'user-name',
        'first-name',
        'last-name',
        'title',
        'role',
        'email',
        'mobile',
        'email-sent',
        'preferred-language'
    ];


     
}