<?php
namespace LIB\Request;

class Request{

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

    public function withErrors($message){
        $_SESSION['errorsBag']= [];
        $_SESSION['errorsBag'][] = __($message);
    }

}