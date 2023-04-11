<?php
namespace LIB\Router;

/* list of all possible methods */
enum Method: string
{
    case POST = 'POST';
    case GET = 'GET';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}