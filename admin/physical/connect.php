
<?php
   $serverName = "tcp:foqus.database.windows.net,1433";
   $userName = "foqusdbadmin";
   $userPassword = "123Prod1$456";
   $dbName = "trial1";
  
   $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');

   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false ) {
      die( print_r( sqlsrv_errors(), true));
   }
$stmt = "SELECT TOP (10) * FROM EGM";
$query = sqlsrv_query($conn, $stmt);

/* while($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
	echo $result["i_holder"];
}  */

?>