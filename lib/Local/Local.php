<?php

namespace LIB\Local;


class  Local
{
    private static $instance = null;
    private $locales = [];
    private function __construct()
    {
        $this->locales = $this->loadActiveLocals();
    }



    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Local
    {
        if (!isset(self::$instance)) {

            self::$instance = new Local();
        }

        return self::$instance;
    }

    protected function loadActiveLocals()
    {
        $sql = "select Language_ID from Languages where Active=?";
        $languages = database()->Select($sql, ['1'])??[];
        $locales = [];
        foreach ($languages as $key => $lang) {
            $locales[] = $lang['Language_ID'];
        }
        return $locales;
    }

    public function getLocales(){
        return $this->locales;
    }
}
