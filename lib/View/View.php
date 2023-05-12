<?php

namespace LIB\View;

use Exception;

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
        $this->layout = $layout;

        $args = array_merge($args, $this->adminArgs());
        $this->render($args);
    }



    private function adminArgs(): array
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        if (str_contains($url['path'], '/admin') || str_contains($url['path'], '/auth')) {
            $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . app()->local . "'";
            $company_name = database()->Select($sql);

            $sql = "select * from Languages where Active=?";
            $languages = database()->Select($sql, ['1']);

            return ['company_name' => $company_name, 'languages' => $languages];
        } else {
            return [];
        }
    }


    private function render(array $args)
    {
        $root = $_SERVER["DOCUMENT_ROOT"];

        foreach ($args as $key => $value) {
            ${$key} = $value;
        }
        
        if ($this->layout) {
            $slot = $root . '/../views/' . $this->filePath . '.php';
            require_once $root . '/../views/' . $this->layout . '.php';
        } else {
            require_once $root . '/../views/' . $this->filePath . '.php';
        }
    }
}
