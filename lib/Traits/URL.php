<?php


namespace Lib\Traits;

trait URL
{


    /* 
    
    */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }


    /* 
    
    */
    public function data(): object
    {
        parse_str(file_get_contents("php://input"), ${'_' . $this->method()});
        return (object) ${'_' . $this->method()};
    }

    /* 
    
    */
    public function only(array|string $keys)
    {
        parse_str(file_get_contents("php://input"), ${'_' . $this->method()});
        if (is_string($keys)) {
            return isset(${'_' . $this->method()}[$keys]) ? ${'_' . $this->method()}[$keys] : null;
        } else {
            return array_filter(${'_' . $this->method()}, function ($one) use ($keys) {
                return in_array($one, $keys) ? 'l' : '';
            }, ARRAY_FILTER_USE_KEY);
        }
    }

    /* 
    
    */
    public function dataArray(): array
    {
        parse_str(file_get_contents("php://input"), ${'_' . $this->method()}); // MOSTAFA_TODO NOT BEST IMPLEMENTATION USE $_POST,$_GET ,... instead
        return ${'_' . $this->method()};
    }
}
