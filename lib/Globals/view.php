<?php


class View
{
    protected $layout = null;
    protected $filePath = null;
    public function __construct(string $filePath, $args = [], $layout = null)
    {
        $root = $_SERVER["DOCUMENT_ROOT"];
        $this->filePath = $filePath;
        if (!file_exists($root . '/../views/' . $filePath . '.php')) {
            throw new Exception("File " . $filePath . '.php Not Found Make Sure it exists inside view folder', 1); // TODO => create a FileNotFound Exception
        }
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }
        $this->layout = $layout;
        $root = $_SERVER["DOCUMENT_ROOT"];
        if ($this->layout) {
            $slot = $root . '/../views/' . $this->filePath . '.php';
            require_once $root . '/../views/' . $this->layout . '.php';
        } else {
            require_once $root . '/../views/' . $this->filePath . '.php';
        }
    }
}


function view(string $name, $args = [], $layout = null)
{
    return new View($name, $args, $layout);
}
