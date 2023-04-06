<?php
namespace LIB\Request;

class Request{

    public function back($data = null){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        return $this;
    }

    public function withMessage($message){
        $_SESSION['messagesBag'][] = $message;
    }
}