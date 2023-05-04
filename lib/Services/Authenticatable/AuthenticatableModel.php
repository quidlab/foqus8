<?php

namespace Lib\Services\Authenticatable;

use App\Models\Model;

class AuthenticatableModel extends Model
{
    static $attemptStatus = false;
    static function attemptByUserId($userID, $password)
    {
        $user = self::findByColName('user-id', $userID);

        if ($user && password_verify($password, $user->password)) {
            static::$attemptStatus = true;
            $_SESSION[static::$guardKey] = $user->{'user-id'};
            $_SESSION['ROLE_ID'] = $user->{'role-id'};
            return $user;

        } else {
            static::$attemptStatus = false;
            return false;
        }
    }
}
