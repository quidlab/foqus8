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
            $data =  database()->Select("SELECT * from Users where USER_ID=?", [$_SESSION['uname']])[0];
            $user = new User();
            $user->role = "super-admin";
            $user->role_id = $data['Role_ID'];
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
