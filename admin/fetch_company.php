<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['uname'])){die();}
include_once('../lib/db.php');

//$query = "SELECT * FROM company WHERE  Tlang in ( SELECT Language_ID FROM languages WHERE Active=1 ) ORDER BY ID ";
//echo $query;
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
 {
/* $data = array(
  ':Company_Name'   => "'%" . $_GET['Company_Name'] . "%'",
  ':Meeting_Place'   => "'%" . $_GET['Meeting_Place'] . "%'",
  ':Tlang'     => "'%" . $_GET['Tlang'] . "%'"
  
 ); */
 
//echo($data[':Tname']);
 //$query = "SELECT * FROM translations WHERE Tname LIKE ". $data[':Tname'] . " OR Tvalue LIKE " . $data[':Tvalue'] ." AND Tlang LIKE " . $data[':Tlang'] ." ORDER BY ID ";
 //echo $query;
 $sql = "SELECT * FROM company WHERE  Tlang in ( SELECT Language_ID FROM languages WHERE Active=1 ) ORDER BY ID ";
 //echo $query;
//$results = $FoQusdatabase -> get_results($query ,'array');
$params=array();
$results = $FoQusdatabase ->Select($sql,$params);
 foreach($results as $row)
 {
  $output[] = array(
   'ID'    => $row['ID'],   
   'Company_Name'  => $row['Company_Name'],
   'Meeting_Place'   => $row['Meeting_Place'],
   'Tlang'    => $row['Tlang']
   
  );
 }
 header("Content-Type: application/json");
 echo json_encode($results);
}
/* 

if($method == "POST")
{
 $data = array(
  'Tname'  => $_POST['Tname'],
  'Tvalue'  => $_POST['Tvalue'],
  'Tlang'    => $_POST['Tlang']

 );

 $results = $FoQusdatabase -> insert('translations',$data);
} */

if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE Company set Company_Name = ?, Meeting_Place = ? where id= ?";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_PUT['Company_Name'],$_PUT['Meeting_Place'],$_PUT['ID']);
$results = $FoQusdatabase ->Run($sql,$params);
}
/* 
if($method == "DELETE")
{
parse_str(file_get_contents("php://input"), $_DELETE);
$where = array(

  'ID'  => $_DELETE["ID"]
  
 );

 $results = $FoQusdatabase -> delete('translations',$where);
} */

?>