<?php
include 'connect.php';
ini_set('display_errors', 1);
error_reporting(~0);
//$strSQL = "SELECT * FROM EGM WHERE i_holder = '".$_POST["siholder"]."' ";
$strSQL = "SELECT * FROM EGM WHERE  i_ref = (select i_ref from egm where   i_holder = '".$_POST["siholder"]."') ";
$result = sqlsrv_query($conn, $strSQL);
$resultArray = array();
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
	$resultArray[]=$row;
}

echo json_encode($resultArray);
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>