<?php
session_start();
if(!isset($_SESSION['uname'])){die();}
include_once('../lib/db.php');

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
{
$sql = "SELECT * FROM Meeting_Constants_Bool where Constant_Type='Meeting' ORDER BY ID ";
$params=array();
$results = $FoQusdatabase ->Select($sql,$params);
//$results = $FoQusdatabase -> get_results($query ,'array');
 foreach($results as $row)
 {
//	if ($row['Constant_Value']) {$row['Constant_Value']='Y' ;} else {$row['Constant_Value']='N';}
	
  $output[] = array(
   'ID'    => $row['ID'],   
   'Constant_Name'  => $row['Constant_Name'],
  // $login_date = $getStat['Login_allowed_time']->format('Y-m-d\Th:i:s');
   'Constant_Value'   => $row['Constant_Value'],
   'Description'    => $row['Description']
   
  );
 }
 header("Content-Type: application/json");
 echo json_encode($output);
}


if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE Meeting_Constants_Bool set Constant_Value = ? where id= ?";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_PUT['Constant_Value'],$_PUT['ID']);
$results = $FoQusdatabase ->Run($sql,$params);
//header("Content-Type: application/json");
//echo json_encode($results);
}



?>