<?php
session_start(); 
if ( !isset($_SESSION['uname'])) {die();}
include_once('../../lib/db.php');

if(isset($_POST["action"]) && $_POST["action"] == "delete_record"){
	//session_start();
	//$_SESSION['progress_content']='Now deleting rows  ';
	//sleep(1);
    //session_write_close();
	
	//session_start();
	$sql = "DELETE FROM AgendaResults;Delete from EGM;DBCC CHECKIDENT ('EGM', RESEED, 11111110);";
	$stmt = $FoQusdatabase -> Run($sql);
    if(!$stmt){echo "true";} else { echo($stmt);}
	
}

?>