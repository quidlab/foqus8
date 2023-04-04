<?php
 session_start(); 
 include_once('../lib/db.php');
 mb_internal_encoding("UTF-8");
if(isset($_POST['deleteRow'])){
	$id= $_POST['deleteRow'];
	echo "<script type='text/javascript'>";
    echo "alert('TEST');";  
    echo "</script>"; 
	$query = "SELECT * FROM guest WHERE id = '$id'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query,$params);
	$count =  count($statement);
	if($count == 0){  	 
		$status = "User details not found in database.";
		$message ='0';
	}
	else{
		$sql_update = "DELETE guest where id= ? ";
		$params3 = array(&$id);
		$stmt3= $FoQusdatabase ->run($sql_update,$params3);
		if($stmt3 === TRUE ) {
		$status = "Guest removed from database.";
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
	$query = "TRUNCATE TABLE guest";
	$statement = $FoQusdatabase ->run($query);
	if($statement === TRUE){
		$status = "Guest data is removed from database.";
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
	$query1 = "SELECT * FROM guest WHERE id = '$preid'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query1,$params);
	$count =  count($statement);
	if($count == 0)  
	{
		$status = "User details not exists in database.";
		$message ='0';
	}
	else{
		$query2 = "UPDATE guest set loginId = N'$uuid', fname = N'$fname', lname = N'$lname', pass = '$pass', status = '1', email= '$email', title = N'$title', mobile = '$phone' where id = '$preid'";
		//$paramsUser = array(&$uuid, &$fname, &$lname, &$pass, '1', &$email, &$role, &$title, &$preid);
		$stmtUser = $FoQusdatabase ->run($query2);
        if($stmtUser === TRUE ) {
			$status = "Guest details updated";
			$message ='1';
		}
		else{
			$status= "Guest updation failed";
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
	$query = "SELECT * FROM guest WHERE loginId = '$uid' AND pass = '$pass'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query,$params);
	$count =  count($statement);
	if($count > 0)  
	{  	 
		$status = "User details already in database.";
		$message ='0';
	}
	else{
		$query1 = "SELECT * FROM guest WHERE loginId = '$uid'";
		$statement1 = $FoQusdatabase ->Select($query1,$params);
		$count1 = count($statement1);
		if($count1 > 0)  
		{
			$status= "Username is already exists.";
			$message ='0';
		}
		else{
			$query2 = "INSERT INTO guest (loginId, fname, lname, pass, reg_date, status, email, title, mobile) 
			VALUES(N'$uid', N'$fname', N'$lname', '$pass', GETDATE(), '1', '$email', N'$title', '$phone')";
			if ($FoQusdatabase ->run($query2)) {
				$status = "Guest Created Successfully";
				$message ='1';
			}
			else{
				$status= "Guest Creation failed";
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

// Update Guest Email Sent Column Start
if(isset($_POST['guestId'])){
	$gid = $_POST['guestId'];
	
	if($gid > 0){
		$query2 = "UPDATE guest set Email_sent = 'Y' where id = '$gid'";

		$stmtUser = $FoQusdatabase ->run($query2);
        if($stmtUser === TRUE ) {
			$status = "Guest Email updated";
			$message ='1';
		}
		else{
			$status= "Guest Email updation failed";
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
// Update Guest Email Sent Column End
else{
	header("location: index.php");
}
?>