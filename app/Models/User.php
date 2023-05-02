<?php
namespace App\Models;

class User extends Model {
    static $table = 'Users';
    protected static $primaryKey = 'user-id';
    protected static $readable = [
        'user-id',
        'user-name',
        'role-id',
        'email',
        'mobile'
    ];


    public $role = null;
    public $name = null;
    public $role_id = null;

     
}