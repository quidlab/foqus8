<?php
session_start();
if(!isset($_SESSION['uname'])){die();}
include_once('../lib/db.php');

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
{
$sql = "SELECT * FROM Meeting_Constants where Constant_Type='Meeting' ORDER BY ID ";
$params=array();
$results = $FoQusdatabase ->Select($sql,$params);
//$results = $FoQusdatabase -> get_results($query ,'array');
 foreach($results as $row)
 {
  $output[] = array(
   'ID'    => $row['ID'],   
   'Constant_Name'  => $row['Constant_Name'],
   'Constant_Value'   => $row['Constant_Value'],
   'Description'    => $row['Description']
   
  );
 }
 header("Content-Type: application/json");
 echo json_encode($results);
}


if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE Meeting_Constants set Constant_Value = ? where id= ?";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_PUT['Constant_Value'],$_PUT['ID']);
$results = $FoQusdatabase ->Run($sql,$params);
}



?>