<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['uname'])){die();}
include_once('../lib/db.php');

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET')
{
	if(!isset($_GET['Agenda_ID'])) {$_GET['Agenda_ID']='0';}
//	$_GET['ID']='1';
$sql = "SELECT * FROM Directors where Agenda_ID=? and Language in ( select Language_ID from Languages where active=1)";
$params=array($_GET['Agenda_ID']);
$results = $FoQusdatabase ->Select($sql,$params);
//$output[] = array();
if($results) {
 foreach($results as $row)
 {

	
  $output[] = array(
   'ID'    => $row['ID'], 
   'Agenda_ID'  => $row['Agenda_ID'],
   'Director_ID'   => $row['Director_ID'],
   'Director_Name'    => $row['Director_Name'],
   'Language'    => $row['Language']
     );
 }
  
} 
else{ $output = (array) null;}
header("Content-Type: application/json");
echo json_encode($output);
}


if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE Directors set Director_Name=? where ID=? ";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_PUT['Director_Name'],$_PUT['ID']);
$results = $FoQusdatabase ->Run($sql,$params);
//header("Content-Type: application/json");
//echo json_encode($results);
}

if($method == 'POST')
{
//parse_str(file_get_contents("php://input"), $_POST);
$sql= "INSERT INTO Agendas (Sort_ID, Agenda_ID,Special_Formula,Voting_Required,Reverse_Vote,Approval_Percent,NumberOfDirectorsToEleect,Voting_Started,Percent_Based_On_FullShares  ) Values( ?,?,?,?,?,?,?,?,?,?  ) ";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_POST['Sort_ID'],$_POST['Agenda_ID'],$_POST['Special_Formula'],$_POST['Voting_Required'],$_POST['Reverse_Vote'],$_POST['Approval_Percent'],$_POST['NumberOfDirectorsToEleect'],$_POST['Voting_Started'],$_POST['Percent_Based_On_FullShares']);
$results = $FoQusdatabase ->Run($sql,$params);
//header("Content-Type: application/json");
//echo json_encode($results);
}
if($method == 'DELETE')
{
parse_str(file_get_contents("php://input"), $_DELETE);
//$conn = $FoQusdatabase ->OpenConnection();

/* Begin the transaction. */
/* if ( sqlsrv_begin_transaction( $conn ) === false ) {
     die( print_r( sqlsrv_errors(), true ));
} */
$sql="DELETE FROM Directors WHERE AGENDAID=?";
$params=array($_DELETE['ID']);
$results1 = $FoQusdatabase ->Run($sql,$params);
/* If all queries were successful, commit the transaction. */
/* Otherwise, rollback the transaction. */
/* if( $results1 && $results2 && $results3 ) {
     sqlsrv_commit( $conn );
     //echo "Transaction committed.<br />";
} else {
     sqlsrv_rollback( $conn );
    // echo "Transaction rolled back.<br />";
} */
//header("Content-Type: application/json");
//echo json_encode($results1);
}


?>