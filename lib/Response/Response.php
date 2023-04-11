<?php

namespace LIB\Response;

class Response {

    protected $data = null;
    protected $code = 200;
    public function __construct()
    {
    }



    public function json($data,$code = 200,$headers = []){
        $headers[] = "Content-Type: application/json";
        foreach ($headers as $header) {
            header($header);
        }

        http_response_code($code);
        echo json_encode($data);
    }

}