<?

$logContainer = constant('MC_AZURE_LOGS_CONTAINER_NAME') ;
$blob_name = $dbname .'\Admin.log';
//$blob_name = Mssql::GetDBfromURL(); .'\Admin.log';
$connection = "DefaultEndpointsProtocol=https;AccountName= " . constant('MC_AZURE_STORAGE_ACCOUNT') . ";AccountKey=" . constant('MC_AZURE_STORAGE_ACCOUNT_KEY') ;
//echo $blob_name;
$client =  \MicrosoftAzure\Storage\Blob\BlobRestProxy::createBlobService($connection);

try {

$blob = $client->createAppendBlob($logContainer, $blob_name);

} catch(Exception $e) {
 // echo 'Message: ' .$e->getMessage();
 // echo 'Code: ' .$e->getCode();
}

$logger = new \Monolog\Logger('Admin');

$handler = new \Blue32a\Monolog\Handler\AzureBlobStorageHandler($client, $logContainer, $blob_name);
$logger->pushHandler($handler);

// Write to Append Blob
//$logger->Info('Test  ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);


?>