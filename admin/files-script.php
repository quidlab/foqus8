<?php
 session_start(); 
 include_once('../lib/db.php');

// Delete Row Start
if(isset($_POST['deleteRow'])){
	$id= $_POST['deleteRow'];
	$query = "SELECT * FROM downloads WHERE ID = '$id'";
	$params = array();
	$statement = $FoQusdatabase ->Select($query,$params);
	$count =  count($statement);
	if($count == 0){  	 
		$status = "File not found in database.";
		$message ='0';
	}
	else{
		$sql_update = "DELETE downloads where ID= ? ";
		$params3 = array(&$id);
		$stmt3= $FoQusdatabase ->run($sql_update,$params3);
		if($stmt3 === TRUE ) {
			$status = "File removed from database.";
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
 // Delete Row End

// Edit File Start
else if(isset($_POST['fid'])){

	// Get folder name from Company Info Table
	$checkFolder = "select SYMBOL from Co_info";
  	$findFolder=$FoQusdatabase ->select($checkFolder);
	foreach($findFolder as $getFolder){
  	$folderName = '../uploads/'.$getFolder['SYMBOL'].'/';
	}
  	$new_file='';
  	$img_file = $_FILES["fileUpload"]["name"];

  	if (!file_exists($folderName)) {
    	mkdir($folderName, 0777, true);
	}

	$filePath = $folderName.$img_file;
	move_uploaded_file( $_FILES["fileUpload"]["tmp_name"], $filePath);
	
	$fid = $_POST['fid'];
	
	$descriptionEng = $_POST['descriptionEng'];
	if($descriptionEng == ''){
		$descriptionEng = NULL;
	}

	$descriptionThai = $_POST['descriptionThai'];
	if($descriptionThai == ''){
		$descriptionThai = NULL;
	}

	if($_FILES["fileUpload"]["name"] == ""){
		$new_file = $_POST['file_upload'];
	}else{
		$new_file = $filePath;
	}

	$message = '0';
	$status = "User not found";
		$query2 = "UPDATE downloads SET description_thai = N'$descriptionThai', description_eng = N'$descriptionEng', file_name = N'$new_file' where ID = '$fid'";
		$result=$FoQusdatabase ->run($query2);
		if ($result) {
			$status = "File updated successfully";
			$message ='1';
		}
		else{
			$status= "Something went wrong";
			$message ='0';
		}
	
	$value = array(
    "message"=> $message,
	"status" => $status
	); 
	$loginDetails = json_encode($value); 
	echo($loginDetails);
}
// Edit File End


// Insert File Start
else if(isset($_POST['descriptionEng'])){
	
	// Get folder name from Company Info Table
	$checkFolder = "select SYMBOL from Co_info";
  	$findFolder=$FoQusdatabase ->select($checkFolder);
	foreach($findFolder as $getFolder){
  	$folderName = '../uploads/'.$getFolder['SYMBOL'].'/';
	}

	$img_file = $_FILES["fileUpload"]["name"];
	// $folderName = "sachin/";

	if (!file_exists($folderName)) {
    	mkdir($folderName, 0777, true);
	}

	$filePath = $folderName.$img_file;
	move_uploaded_file( $_FILES["fileUpload"]["tmp_name"], $filePath);

	$descriptionEng = $_POST['descriptionEng'];
	if($descriptionEng == ''){
		$descriptionEng = NULL;
	}

	$descriptionThai = $_POST['descriptionThai'];
	if($descriptionThai == ''){
		$descriptionThai = NULL;
	}

	$message = '0';
	$status = "User not found";

		$query2 = "INSERT INTO downloads (description_thai, description_eng, file_name) 
		VALUES(N'$descriptionThai', N'$descriptionEng', N'$filePath')";
		$result = $FoQusdatabase ->run($query2);
		if ($result) {
			$status = "File Created";
			$message ='1';
		}
		else{
			$status= "Something went wrong";
			$message ='0';
		}
	
	$value = array(
    "message"=> $message,
	"status" => $status
	); 
	$loginDetails = json_encode($value); 
	echo($loginDetails);
}
// Insert File End

else{
	header("location: index.php");
}
?>