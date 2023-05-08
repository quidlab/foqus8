<?php

namespace LIB\Auth;

use App\Models\User;

class  Auth
{
    private static $instance = null;
    public $user = null;
    private function __construct()
    {
        if ($_SESSION['uname']) {
            $data =  database()->Select("SELECT * from users where [user-id]=?", [$_SESSION['uname']])[0];
            $user = new User();
/*             $user->role = "super-admin";
            $user->role_id = $data['role-id']; */
            $this->user = $user;
        }
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Auth
    {
        if (!isset(self::$instance)) {
            self::$instance = new Auth();
        }
        return self::$instance;
    }
}
