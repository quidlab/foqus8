<?php

namespace LIB\Log;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use Blue32a\Monolog\Handler\AzureBlobStorageHandler;

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
            global $dbname;
            $SelectMeetingInfo = "SELECT Constant_Value  as 'uploadfolder'  FROM [Meeting_Constants_Str] Where Constant_Name = 'SYMBOL'";
            $storageType = "SELECT Constant_Value  as 'storageType'  FROM [Meeting_Constants_Str] Where Constant_Name = 'Log_Storage_Type'";

            $FetchInfo = $FoQusdatabase->Select($SelectMeetingInfo)[0];
            $storageType = $FoQusdatabase->Select($storageType)[0];
            $SYMBOLLog = $FetchInfo['uploadfolder'];
            $doc_root = $_SERVER["DOCUMENT_ROOT"];
            $uploads_dir_Log = str_replace('"\"', '/', $doc_root) . '/../storage/logs/' . $SYMBOLLog . "/" . date('Y-m-d') . '/';


            self::$instance = new Logger($name);
            if ($storageType['storageType'] == 'blob') {
                $logContainer = constant('MC_AZURE_LOGS_CONTAINER_NAME');
                $connection = "DefaultEndpointsProtocol=https;AccountName= " . constant('MC_AZURE_STORAGE_ACCOUNT') . ";AccountKey=" . constant('MC_AZURE_STORAGE_ACCOUNT_KEY');
                $client =  BlobRestProxy::createBlobService($connection);
                $blob_name = $dbname . '\Admin.log';
                $handler = new AzureBlobStorageHandler($client, $logContainer, $blob_name);
            } else {
                $handler = new StreamHandler($uploads_dir_Log . '/adminlog.log', Level::Debug);
            }
            self::$instance->pushHandler($handler);
        }

        return self::$instance;
    }
}
