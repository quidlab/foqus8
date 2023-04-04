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
	if(!isset($_GET['ID'])) {$_GET['ID']='0';}
//	$_GET['ID']='1';
$sql = "SELECT * FROM Agendas_Text where AGENDAID=? and Language in ( select Language_ID from Languages where active=1)";
$params=array($_GET['ID']);
$results = $FoQusdatabase ->Select($sql,$params);
//$output[] = array();
if($results) {
 foreach($results as $row)
 {

	
  $output[] = array(
   'ID'    => $row['ID'], 
   'AGENDAID'  => $row['AGENDAID'],
   'Agenda_Name'   => $row['Agenda_Name'],
   'Agenda_Info'   => $row['Agenda_Info'],
   'Approve_Text'    => $row['Approve_Text'],
   'DisApprove_Text'    => $row['DisApprove_Text'],
   'Abstain_Text'    => $row['Abstain_Text'],
   'NoVote_Text'    => $row['NoVote_Text'],
   'Language'    => $row['Language']
     );
 }
} else{ $output = (array) null;}
  header("Content-Type: application/json");
 echo json_encode($output);

}


if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE Agendas_Text set AGENDAID = ? ,Agenda_Name= ?,Agenda_Info=?,Approve_Text=?,DisApprove_Text=?,Abstain_Text=?,NoVote_Text=? where ID=? ";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_PUT['AGENDAID'],$_PUT['Agenda_Name'],$_PUT['Agenda_Info'],$_PUT['Approve_Text'],$_PUT['DisApprove_Text'],$_PUT['Abstain_Text'],$_PUT['NoVote_Text'],$_PUT['ID']);
$results = $FoQusdatabase ->Run($sql,$params);
//header("Content-Type: application/json");
//echo json_encode($results);
}

if($method == 'POST')
{
//parse_str(file_get_contents("php://input"), $_POST);
$sql= "INSERT INTO Agendas (Sort_ID, AGENDA_ID,Special_Formula,Voting_Required,Reverse_Vote,Approval_Percent,NumberOfDirectorsToEleect,Voting_Started,Percent_Based_On_FullShares  ) Values( ?,?,?,?,?,?,?,?,?,?  ) ";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_POST['Sort_ID'],$_POST['AGENDA_ID'],$_POST['Special_Formula'],$_POST['Voting_Required'],$_POST['Reverse_Vote'],$_POST['Approval_Percent'],$_POST['NumberOfDirectorsToEleect'],$_POST['Voting_Started'],$_POST['Percent_Based_On_FullShares']);
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
$sql="DELETE FROM AGENDAS_TEXT WHERE AGENDAID=?";
$params=array($_DELETE['ID']);
$results1 = $FoQusdatabase ->Run($sql,$params);
$sql="DELETE FROM DIRECTORS WHERE Agenda_ID=?";
$params=array($_DELETE['ID']);
$results2 = $FoQusdatabase ->Run($sql,$params);
$sql="DELETE FROM AGENDAS WHERE ID=?";
$params=array($_DELETE['ID']);
$results3 = $FoQusdatabase ->Run($sql,$params);
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