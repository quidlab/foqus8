<?php

namespace LIB\Request;

use Lib\Traits\IPAddress;
use Lib\Traits\URL;

class Request
{

    use IPAddress, URL;

    public function __construct()
    {
    }



    /* 
    
    */
    public function back($data = null)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        return $this;
    }

    public function withMessage($message, bool $status = true)
    {
        $_SESSION['messagesBag'] = [];
        $_SESSION['messagesBag'][] = __($message);
        if ($status) {
            $this->withSuccess([$message]);
        } else {
            $this->withErrors([$message]);
        }
    }

    public function withSuccess(array $messages)
    {
        $_SESSION['successBag'] = [];
        foreach ($messages as $key => $err) {
            $_SESSION['successBag'][] = __($err);
        }
    }

    public function withErrors(array $errors)
    {
        $_SESSION['errorsBag'] = [];
        foreach ($errors as $key => $err) {
            $_SESSION['errorsBag'][$key] = __($err);
        }
    }



    /* 
    
    */

    public function pagination()
    {
        $page = isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 1;
        $per_page = isset($_GET['pageSize']) ? $_GET['pageSize'] : 10;
        return (object)[
            'per_page' => $per_page,
            'page' => $page,
        ];
    }
}
