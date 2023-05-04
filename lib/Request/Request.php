<?php
namespace LIB\Request;

use Lib\Traits\IPAddress;
use Lib\Traits\URL;
class Request{

    use IPAddress,URL;

    public function __construct()
    {
        
    }



    /* 
    
    */
    public function back($data = null){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        return $this;
    }

    public function withMessage($message, bool $status = true){
        $_SESSION['messagesBag']= [];
        $_SESSION['messagesBag'][] =__($message);
        if ($status) {
            $this->withSuccess($message);
        }else{
            $this->withErrors($message);
        }
    }

    public function withSuccess($message){
        $_SESSION['successBag']= [];
        $_SESSION['successBag'][] = __($message);
    }

    public function withErrors(array $errors){
        $_SESSION['errorsBag']= [];
        foreach ($errors as $key => $err) {
            $_SESSION['errorsBag'][] = __($err);
        }
    }



    /* 
    
    */

}