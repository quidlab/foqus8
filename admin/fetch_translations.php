<?php
session_start();
if(!isset($_SESSION['uname'])){die();}
include_once('../lib/db.php');
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
{
 $data = array(
  ':Tname'   => "'%" . $_GET['Tname'] . "%'",
  ':Tvalue'   => "'%" . $_GET['Tvalue'] . "%'",
  ':Tlang'     => "'%" . $_GET['Tlang'] . "%'"
  
 );
//echo($data[':Tname']);
 //$query = "SELECT * FROM translations WHERE Tname LIKE ". $data[':Tname'] . " OR Tvalue LIKE " . $data[':Tvalue'] ." AND Tlang LIKE " . $data[':Tlang'] ." ORDER BY ID ";
 //echo $query;
 $query = "SELECT * FROM translations WHERE  Tlang LIKE " . $data[':Tlang'] ." ORDER BY ID ";
$results = $FoQusdatabase -> get_results($query ,'array');
 foreach($result as $row)
 {
  $output[] = array(
   'ID'    => $row['ID'],   
   'Tname'  => $row['Tname'],
   'Tvalue'   => $row['Tvalue'],
   'Tlang'    => $row['Tlang']
   
  );
 }
 header("Content-Type: application/json");
 echo json_encode($results);
}


if($method == "POST")
{
 $data = array(
  'Tname'  => $_POST['Tname'],
  'Tvalue'  => $_POST['Tvalue'],
  'Tlang'    => $_POST['Tlang']

 );

 $results = $FoQusdatabase -> insert('translations',$data);
}

if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE translations set Tvalue = " . "N"."'".$_PUT['Tvalue']."'". " where id= " . "'". $_PUT['ID'] ."'";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
$results = $FoQusdatabase -> query($sql,false);
}

if($method == "DELETE")
{
parse_str(file_get_contents("php://input"), $_DELETE);
$where = array(

  'ID'  => $_DELETE["ID"]
  
 );

 $results = $FoQusdatabase -> delete('translations',$where);
}

?>