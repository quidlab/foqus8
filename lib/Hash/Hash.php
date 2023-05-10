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
        return openssl_decrypt($needle, "AES-128-ECB", $key);
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
}
