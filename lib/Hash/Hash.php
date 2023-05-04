<?php

namespace Lib\Hash;

class Hash
{

    static function make(string $needle)
    {
        return  password_hash($needle, PASSWORD_BCRYPT);
    }
}
