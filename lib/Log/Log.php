<?php

namespace LIB\Log;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class  Log
{
    private static $instance = null;
    private  static $path = null;
    private function __construct($name = 'Admin')
    {
    }



    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance($name = 'Admin'): Logger
    {
        if (!isset(self::$instance)) {
            global $FoQusdatabase;
            $SelectMeetingInfo = "SELECT Constant_Value + 'LOG_' as 'uploadfolder'  FROM [Meeting_Constants_Str] Where Constant_Name = 'SYMBOL'";
            $FetchInfo = $FoQusdatabase->Select($SelectMeetingInfo)[0];
            $SYMBOLLog = $FetchInfo['uploadfolder'];
            $doc_root = $_SERVER["DOCUMENT_ROOT"];
            $uploads_dir_Log = str_replace('"\"','/',$doc_root). '/uploads/' . $SYMBOLLog . "/";
    

            self::$instance = new Logger($name);
            self::$instance->pushHandler(new StreamHandler($uploads_dir_Log . '/adminlog.log', Level::Debug));
        }

        return self::$instance;
    }
}
