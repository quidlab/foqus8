<?php
session_start();
if(!isset($_SESSION['uname'])){  die();}
 include('../ajax/connection.php');
 $SelectMeetingInfo="SELECT TOP(1) SYMBOL + 'Log_'+ CONVERT(nvarchar,login_allowed_time,6) as uploadfolder from Co_info" ;
$Query = sqlsrv_query($conn, $SelectMeetingInfo);
$FetchInfo = sqlsrv_fetch_array($Query);
$SYMBOLLog=$FetchInfo['uploadfolder'];
$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
$uploads_dir_Log = $doc_root.'/uploads/'.$SYMBOLLog."/";

require_once($doc_root."/vendor/autoload.php");
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
$logger = new Logger('Admin');
$logger->pushHandler(new StreamHandler($uploads_dir_Log . '/adminlog.log', Logger::DEBUG));
function getUserIP()
	{
		$ipaddress = '';
	if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = reset(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	else if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];    
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
		return $ipaddress;
    //return filter_var($ipaddress, FILTER_VALIDATE_IP);

		
	}
$ipaddress = getUserIP();
 
 mb_internal_encoding("UTF-8");
 
 
 if(isset($_POST['deleteAllRows'])){
	$query = "DELETE FROM AgendaResults";
	$statement = sqlsrv_prepare($conn, $query);
	$execute = sqlsrv_execute($statement);

	$query1 = "UPDATE EGM SET q_share = org_q_share,n_first=org_n_first,n_last=org_n_last,I_ref=org_i_ref";
	$statement1 = sqlsrv_prepare($conn, $query1);
	$execute1 = sqlsrv_execute($statement1);

	$query2 = "UPDATE EGM SET Attended = 'N', Shares_Attended = 0, Proxy = 'N', Proxy_name = '', BallotPaperPrinted = 0, Custodian = 'N', USER_ID = '', Registered_Time = NULL, Out_Time = NULL,org_q_share=q_share,Group_id=NULL,serial=0,coupon1_claimed='N',coupon2_claimed='N',coupon3_claimed='N',feedback_submitted='N',factory_visit_interested='N',org_n_first=n_first,org_n_last=n_last,org_i_ref=I_ref,ProxyType=NULL";
	$statement2 = sqlsrv_prepare($conn, $query2);
	$execute2 = sqlsrv_execute($statement2);

	$query3 = "UPDATE EGM SET e_mail=NULL,m_phone=NULL,username=NULL,password=NULL,ApprovedForOnline='N',IPAddress=NULL,lastlogin=NULL,status=0,active=0,Email_sent='N',doc_received='N',jitsiid='0'";
	$statement3 = sqlsrv_prepare($conn, $query3);
	$execute3 = sqlsrv_execute($statement3);

	$query4 = "DELETE FROM quorums";
	$statement4 = sqlsrv_prepare($conn, $query4);
	$execute4 = sqlsrv_execute($statement4);

	$query5 = "UPDATE AGENDAS SET Agenda_Completed = 'N', Agenda_Completed_Time = NULL";
	$statement5 = sqlsrv_prepare($conn, $query5);
	$execute5 = sqlsrv_execute($statement5);

	$query6 = "UPDATE Co_info SET Last_group_number='0'";
	$statement6 = sqlsrv_prepare($conn, $query6);
	$execute6 = sqlsrv_execute($statement6);

	$query7 = "Truncate table ques_ans";
	$statement7 = sqlsrv_prepare($conn, $query7);
	$execute7 = sqlsrv_execute($statement7);

	$query8 = "TRUNCATE TABLE LOGINLOG";
	$statement8 = sqlsrv_prepare($conn, $query8);
	$execute8 = sqlsrv_execute($statement8);

	$query9 = "TRUNCATE TABLE registrationlog";
	$statement9 = sqlsrv_prepare($conn, $query9);
	$execute9 = sqlsrv_execute($statement9);

	
	if( ($execute && $execute1 && $execute2 && $execute3 && $execute4 && $execute5 && $execute6 && $execute7 && $execute8 && $execute9) === TRUE){
		$status = "Test Data is removed successfully.";
		$message ='1';
		$logger->Info('Test Data Deleted ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);
	}

	$value = array(
    "message"=> $message,
	"status" => $status
	);

	$loginDetails = json_encode($value); 
	echo($loginDetails);
 }
//else{
//	header("location: index.php");
//}

 if(isset($_POST['UpdateDatabase'])){
	 $query = "ALTER TABLE Co_Info ADD jitsi_server nvarchar(500), pubnub_publish_key nvarchar(255),pubnub_subscribe_key nvarchar(255), pubnub_secrect_key  nvarchar(255), db_version nvarchar(10);";
	$statement = sqlsrv_prepare($conn, $query);
	$execute = sqlsrv_execute($statement);
	if( ($execute) === False){
		$status = print_r( sqlsrv_errors(), true);
		$message ='0';
	}
	else{
		$status = "Database updated successfully.";
		$message ='1';
	}

	$value = array(
    "message"=> $message,
	"status" => $status
	);

	$Details = json_encode($value); 
	echo($Details);
	
	 
 }
 


?>