<?php

namespace Lib\Hash;

class Hash
{

    static function make(string $needle): string
    {
        return  password_hash($needle, PASSWORD_BCRYPT);
    }



    /* 
    
    */
    static function encrypt(string $needle, string $key): string
    {
        return  openssl_encrypt($needle, "AES-128-ECB", $key);
    }


    /* 
    
    */
    static function decrypt(string $needle, string $key): string
    {
        if ($dec = openssl_decrypt($needle, "AES-128-ECB", $key)) {
            return $dec;
        } else {
            return $needle;
        }
    }


    /* 
    
    */
    static function otp(int $length = 6): string
    {
        return substr(str_shuffle('1234567890'), 1, $length);
    }

    /* 
    
    */
    static function randString(int $length = 6): string
    {
        return substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWZY'), 1, $length);
    }



    /* 
    
    */
    static function randomPassword($len = 8)
    {

        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';
        $sets[]  = '~!@#$%^&*(){}[],./?';

        $password = '';

        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        while (strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];

            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        return str_shuffle($password);
    }
}
