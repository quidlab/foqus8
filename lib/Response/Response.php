<?php

namespace LIB\Response;

class Response
{

    protected $data = null;
    protected $code = 200;
    public function __construct()
    {
    }



    public function json($content, $code = 200, $headers = [])
    {
        $headers[] = "Content-Type: application/json";
        foreach ($headers as $header) {
            header($header);
        }

        http_response_code($code);
        echo json_encode($content);
    }

    public function plain($content, $status = 200)
    {
        return print_r($content);
    }
}
