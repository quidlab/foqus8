<?php

namespace LIB\Translation;

class Translation
{
    private static $instance = null;
    protected  $lines = [];
    private function __construct()
    {
        $this->loadTranslations();
    }



    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Translation
    {
        if (!isset(self::$instance)) {
            self::$instance = new Translation();
        }

        return self::$instance;
    }

    public function translate(string $text, array $data = [])
    {
        $str = key_exists($text, $this->lines) ? $this->lines[$text] : $text;

        foreach ($data as $key => $value) {
            $str = str_replace(":" . $key, $value, $str);
        }
        return $str;
    }


    protected function loadTranslations()
    {
        global $FoQusdatabase;
        global $app;

        $lang = $app->local;
        $sql = "select ID,Tname,Tvalue from Translations where Tlang =?";

        $params = array($lang);
        $translations = $FoQusdatabase->Select($sql, $params);
        $lines = [];
        foreach ($translations as $translation) {
            $lines[$translation['Tname']] = $translation['Tvalue'];
        }
        return $this->lines  = $lines;
    }
}
