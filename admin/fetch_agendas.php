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
$sql = "SELECT * FROM Agendas ORDER BY Sort_ID ";
$params=array();
$results = $FoQusdatabase ->Select($sql,$params);
//$output[] = array();
//$results = $FoQusdatabase -> get_results($query ,'array');
if($results) {
foreach($results as $row)
 {
//	if ($row['Constant_Value']) {$row['Constant_Value']='Y' ;} else {$row['Constant_Value']='N';}
	
  $output[] = array(
   'ID'    => $row['ID'], 
//	'BTN'    => '+', 
   'Sort_ID'  => $row['Sort_ID'],
  // $login_date = $getStat['Login_allowed_time']->format('Y-m-d\Th:i:s');
   'AGENDA_ID'   => $row['AGENDA_ID'],
   'Special_Formula'    => $row['Special_Formula'],
   'Voting_Required'    => $row['Voting_Required'],
   'Reverse_Vote'    => $row['Reverse_Vote'],
   'Approval_Percent'    => $row['Approval_Percent'],
   'NumberOfDirectorsToEleect'    => $row['NumberOfDirectorsToEleect'],
   'Voting_Started'    => $row['Voting_Started'],
   'Percent_Based_On_FullShares'    => $row['Percent_Based_On_FullShares']
 //  'control' => ' '
  );
 }
 
}else{ $output = (array) null;}
 header("Content-Type: application/json");
 echo json_encode($output);
}


if($method == 'PUT')
{
parse_str(file_get_contents("php://input"), $_PUT);
$sql= "UPDATE Agendas set Sort_ID = ? ,AGENDA_ID= ?,Special_Formula=?,Voting_Required=?,Reverse_Vote=?,Approval_Percent=?,NumberOfDirectorsToEleect=?,Voting_Started=?,Percent_Based_On_FullShares=? where ID=? ";
//$results = $FoQusdatabase -> update('translations' ,$what ,$where );
//$results = $FoQusdatabase -> query($sql,false);
$params=array($_PUT['Sort_ID'],$_PUT['AGENDA_ID'],$_PUT['Special_Formula'],$_PUT['Voting_Required'],$_PUT['Reverse_Vote'],$_PUT['Approval_Percent'],$_PUT['NumberOfDirectorsToEleect'],$_PUT['Voting_Started'],$_PUT['Percent_Based_On_FullShares'],$_PUT['ID']);
$results = $FoQusdatabase ->Run($sql,$params);
//header("Content-Type: application/json");
//echo json_encode($results);
}

if($method == 'POST')
{

$sql= "INSERT INTO Agendas (Sort_ID, AGENDA_ID,Special_Formula,Voting_Required,Reverse_Vote,Approval_Percent,NumberOfDirectorsToEleect,Voting_Started,Percent_Based_On_FullShares  ) Values( ?,?,?,?,?,?,?,?,?  ) ;";

$params=array($_POST['Sort_ID'],$_POST['AGENDA_ID'],$_POST['Special_Formula'],$_POST['Voting_Required'],$_POST['Reverse_Vote'],$_POST['Approval_Percent'],$_POST['NumberOfDirectorsToEleect'],$_POST['Voting_Started'],$_POST['Percent_Based_On_FullShares']);
$results = $FoQusdatabase ->InsertAndGetPK($sql,$params);
//$conn=$FoQusdatabase ->db;
//$sql="SELECT SCOPE_IDENTITY() as id";
//$lastagendapk=$FoQusdatabase ->Select($sql);
//echo json_encode($lastagendapk);
$pk=$results;
//$pk=implode(" ",$lastagendapk);
//header("Content-Type: application/json");
//echo json_encode($results);

$sql= "INSERT INTO Agendas_Text (AGENDAID,Agenda_Name,Agenda_Info,Approve_Text,DisApprove_Text,Abstain_Text,NoVote_Text,Language) Select '" . $pk . "' ,'Agenda','info',Approve ,DisApprove ,Abstain ,NoVote, Language_ID from Languages";
//echo json_encode($sql);
$results = $FoQusdatabase ->Run($sql);
//header("Content-Type: application/json");
//echo json_encode($results);
// insert directors in case agenda is C or S 
if ($_POST['Voting_Required']=='C' || $_POST['Voting_Required']=='S'){
$sql="INSERT INTO Directors (Agenda_ID,Director_Name,Language,Director_ID) Select '" . $pk . "'  , 'diurectorname',  Language_ID , SN from Serials,Languages";
$results = $FoQusdatabase ->Run($sql);
}

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