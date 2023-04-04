<?php
 session_start(); 
 include_once('../lib/db.php');
 mb_internal_encoding("UTF-8");
if(isset($_POST['deleteRow'])){
	$id= $_POST['deleteRow'];
	$query = "SELECT * FROM presenter WHERE id = '$id'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query,$params);
	$count =  count($statement);
	if($count == 0){  	 
		$status = "User details not found in database.";
		$message ='0';
	}
	else{
		$sql_update = "DELETE presenter where id= ? ";
		$params3 = array(&$id);
		$stmt3= $FoQusdatabase ->run($sql_update,$params3);
		if($stmt3 === TRUE ) {
		$status = "presenter removed from database.";
		$message ='1';
		}
	}
	$value = array(
    "message"=> $message,
	"status" => $status
	);
	$loginDetails = json_encode($value);
	echo($loginDetails);
 }
 
if(isset($_POST['deleteAllRows'])){
	$query = "TRUNCATE TABLE presenter";
	$statement = $FoQusdatabase ->run($query);
	if($statement === TRUE){
		$status = "presenter data is removed from database.";
		$message ='1';
	}
	$value = array(
    "message"=> $message,
	"status" => $status
	);
	$loginDetails = json_encode($value); 
	echo($loginDetails);
}
 
if(isset($_POST['uuid'])){
	$uuid = $_POST['uuid'];
	$pass = $_POST['pass'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$title = $_POST['title'];
	// $role = $_POST['role'];
	$preid = $_POST['preid'];
	$phone = $_POST['phone'];
	$message = '0';
	$status = "User not found";
	$query1 = "SELECT * FROM presenter WHERE id = '$preid'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query1,$params);
	$count =  count($statement);
	if($count == 0)  
	{
		$status = "User details not exists in database.";
		$message ='0';
	}
	else{
		$query2 = "UPDATE presenter set pid = N'$uuid', fname = N'$fname', lname = N'$lname', pwd = '$pass', status = '1', email= '$email', title = N'$title', mobile = '$phone' where id = '$preid'";
		//$paramsUser = array(&$uuid, &$fname, &$lname, &$pass, '1', &$email, &$role, &$title, &$preid);
		$stmtUser = $FoQusdatabase ->run($query2);
        if($stmtUser === TRUE ) {
			$status = "presenter details updated";
			$message ='1';
		}
		else{
			$status= "presenter updation failed";
			$message ='0';
		}
	}
	$value = array(
    "message"=> $message,
	"status" => $status
	);
	$loginDetails = json_encode($value);
	echo($loginDetails);
}

if(isset($_POST['uid'])){
	$uid 	= $_POST['uid'];
	$pass 	= $_POST['pass'];
	$fname 	= $_POST['fname'];
	$lname 	= $_POST['lname'];
	$email 	= $_POST['email'];
	$title 	= $_POST['title'];
	$phone 	= $_POST['phone'];
	// $role 	= $_POST['role'];
	$message = '0';
	$status = "User not found";
	$query = "SELECT * FROM presenter WHERE pid = '$uid' AND pwd = '$pass'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query,$params);
	$count =  count($statement);
	if($count > 0)  
	{  	 
		$status = "User details already in database.";
		$message ='0';
	}
	else{
		$query1 = "SELECT * FROM presenter WHERE pid = '$uid'";
		$statement1 = $FoQusdatabase ->Select($query1,$params);
		$count1 = count($statement1);
		if($count1 > 0)  
		{
			$status= "Username is already exists.";
			$message ='0';
		}
		else{
			$query2 = "INSERT INTO presenter (pid, fname, lname, pwd, reg_date, status, email, title, mobile) 
			VALUES(N'$uid', N'$fname', N'$lname', '$pass', GETDATE(), '1', '$email', N'$title', '$phone')";
			if ($FoQusdatabase ->run($query2)) {
				$status = "presenter Created Successfully";
				$message ='1';
			}
			else{
				$status= "presenter Creation failed";
				$message ='0';
			}
		}
	}
	$value = array(
    "message"=> $message,
	"status" => $status
	); 
	$loginDetails = json_encode($value); 
	echo($loginDetails);
}

// Update presenter Email Sent Column Start
if(isset($_POST['presenterId'])){
	$gid = $_POST['presenterId'];
	
	if($gid > 0){
		$query2 = "UPDATE presenter set Email_sent = 'Y' where id = '$gid'";

		$stmtUser = $FoQusdatabase ->run($query2);
        if($stmtUser === TRUE ) {
			$status = "presenter Email updated";
			$message ='1';
		}
		else{
			$status= "presenter Email updation failed";
			$message ='0';
		}
	}
	$value = array(
    "message"=> $message,
	"status" => $status
	);
	$loginDetails = json_encode($value);
	echo($loginDetails);
}
// Update presenter Email Sent Column End
else{
	header("location: index.php");
}
?>