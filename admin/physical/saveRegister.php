<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'connect.php';
//////
/* $_POST["proxytype"]='N';
$_POST["idHolder"]='1000';
$_POST["proxyname"]='';
$_POST["siholder"]='4010066951';
$_POST["SN"]='11111115';
 */
//////
//proxy
$proxyYN = $_POST["proxytype"];
if($proxyYN == "A" || $proxyYN == "B" || $proxyYN == "C"){$proxyYN = "Y";}else{$proxyYN = "N";}
$strSQL = "UPDATE EGM SET 
				Attended = 'Y' ,
				BallotPaperPrinted=BallotPaperPrinted+1,
				Registered_Time = GETDATE(), serial = (Select max(serial) from EGM) +1,
				Proxy = '".$proxyYN."' ,
				Shares_Attended = '".$_POST["idHolder"]."' ,
				ProxyType = '".$_POST["proxytype"]."' ,
				Proxy_name = N'".$_POST["proxyname"]."'
				WHERE i_holder = '".$_POST["siholder"]."' ";
$result = sqlsrv_query($conn, $strSQL);

/* if($result){
echo "<script type='text/javascript'>";
echo "window.location = 'registration.php'; ";                 
echo "</script>;";} */
//sqlsrv_close($conn);
//echo json_encode($data);
?>

<?php

/* session_set_cookie_params(0);

session_start();
$SelectMeetingInfo="SELECT TOP(1) SYMBOL + 'Log_'+ CONVERT(nvarchar,login_allowed_time,6) as uploadfolder,use_OTP_email, use_OTP_phone from Co_info" ;
$Query = sqlsrv_query($conn, $SelectMeetingInfo);
$FetchInfo = sqlsrv_fetch_array($Query);
$SYMBOLLog=$FetchInfo['uploadfolder'];
$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
$uploads_dir_Log = $doc_root.'/uploads/'.$SYMBOLLog."/";
$use_otp_email = $FetchInfo['use_OTP_email'];
$use_otp_phone = $FetchInfo['use_OTP_phone'];
require_once($doc_root."/vendor/autoload.php");
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
$logger = new Logger('Login');
$logger->pushHandler(new StreamHandler($uploads_dir_Log . '/userlog.log', Logger::DEBUG));
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
$ipaddress = getUserIP(); */
/* $params2 = array();
$options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

// check if all agendas are closed or if login time is not yet ready
//$HaveValidAgendas = 0 ;
$sqlquery ="Select ID from Agendas where Agenda_Completed= 'N'";
$sqlResult = sqlsrv_query($conn, $sqlquery,$params2, $options2);
$countrows = sqlsrv_num_rows($sqlResult);
//echo ( 'akkk' . $validAgendas);
//$returnValue = sqlsrv_get_field( $validAgendas, 0);
//echo ( 'aaa' . $countrows);
if ($countrows==0) { 
	$response = "การประชุมเสร็จสิ้นแล้ว <BR> Meeting is Finished";  
	$logger->Info('Login after meeting finished',['user'=>$_POST['userLoginId'],'IP'=>$ipaddress]);
    $loginStatus = "0";
	goto SendResultsback;
	} */
	
// end check all agendas closed




// end check time to allow login



		
		
		//Agenda Submitted in agenda results
		 
		$votingQuery = " select * from AgendaResults where SN='". $_POST['SN']."'";
		//echo $votingQuery;
		$params4 = array();
		$options4 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$fetchVotes = sqlsrv_query($conn, $votingQuery, $params4, $options4);
		$countVotes = sqlsrv_num_rows($fetchVotes);
		//echo $countVotes;
		if($countVotes == 0){
				$shares = $_POST["idHolder"];
				// added q_share in session for easy access by kamal on 29th Jan 2022
				//$_SESSION['q_share']=$userFetch['q_share'];
				// end added q_share as session variable
				$i_holder = $_POST['siholder'];
				$Attend = 'Y';
				$loginCheck = 'Online';
				
				//Modified by kamal
				
				/* $sql_update = "UPDATE EGM SET Attended= ?, Shares_Attended= ?, USER_ID=?, Registered_Time = GETDATE(), serial = (Select max(serial) from EGM) +1 WHERE i_holder = ?";
				$params31 = array(&$Attend, &$shares, &$loginCheck, &$i_holder );
			
				$stmt13= sqlsrv_prepare( $conn, $sql_update, $params31);
				if(sqlsrv_execute( $stmt13 ) === TRUE ) {
					
				} */
				
				$agendaQuery5 = " select * from AGENDAS";
				$params5 = array();
				$options5 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$fetchAgendas5 = sqlsrv_query($conn, $agendaQuery5, $params5, $options5);
				$sql="INSERT INTO AgendaResults (SN, Agenda_ID, Approved, Shares_Approved, NotApproved, Shares_NotApproved, Abstain, Shares_Abstain, i_holder, Attend, VoteCounted) VALUES ";
				while($getAgendas5 = sqlsrv_fetch_array($fetchAgendas5)){
					// Check if Stakeholder
					$getStakeHolderQuery =" SELECT i_holder,Agenda_ID from StakeHolders where i_holder='" . $i_holder ."' and Agenda_ID =' " . $getAgendas5['ID'] . "'";
					$params6 = array();
					$options6 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
					$fetchStakeHolder = sqlsrv_query($conn, $getStakeHolderQuery, $params6, $options6);
					$countSHforThisAgenda = sqlsrv_num_rows($fetchStakeHolder);
					if ($countSHforThisAgenda==0){ $Attend='Y';} else { $Attend='S';}
					
					// End check if Stakeholder
					if($getAgendas5['Voting_Required'] == 'Y' && $getAgendas5['Agenda_Completed'] == 'N'){
						$sn = $_POST['SN'];
						$agenda_id = $getAgendas5['ID'];
						$VoteCounted = '0';
						
						if ($Attend=='S'){Goto StakeHolder;}
						if($getAgendas5['Reverse_Vote'] == 'Approve'){
							$sql .= "('$sn', '$agenda_id', 'Y', '$shares', 'N', '0', 'N', '0', '$i_holder', '$Attend', '$VoteCounted'),";

							//if (sqlsrv_query($conn, $sql)) {}
						}
						else if($getAgendas5['Reverse_Vote'] == 'DisApprove'){
							$sql .= "('$sn', '$agenda_id', 'N', '0', 'Y', '$shares', 'N', '0', '$i_holder', '$Attend', '$VoteCounted'),";

							//if (sqlsrv_query($conn, $sql)) {}
						}
						else if($getAgendas5['Reverse_Vote'] == 'Abstain'){
							$sql .= "('$sn', '$agenda_id', 'N', '0', 'N', '0', 'Y', '$shares', '$i_holder', '$Attend', '$VoteCounted'),";

							//if (sqlsrv_query($conn, $sql)) {}
						}
						else{
							$sql .= "('$sn', '$agenda_id', 'N', '0', 'N', '0', 'N', '0', '$i_holder', 'K', '$VoteCounted'),";

							//if (sqlsrv_query($conn, $sql)) {}
						}
						StakeHolder:
						if ($Attend=='S'){$sql .= "('$sn', '$agenda_id', 'N', '0', 'N', '0', 'N', '0', '$i_holder', 'S', '$VoteCounted'),"; }
					}
					
					//echo('finich check normal ag');
				//}
				
				 
				// end bulk insert
				// cumulative vote started 15th dec 2021
									if($getAgendas5['Voting_Required'] == 'C' && $getAgendas5['Agenda_Completed'] == 'N'){
									//	echo('entered1');
						$sn = $_POST['SN'];
						$agenda_id = $getAgendas5['ID'];
						$VoteCounted = '0';
						$numDirectors = $getAgendas5['NumberOfDirectorsToEleect'];
						//echo($numDirectors);
						if($getAgendas5['Reverse_Vote'] == 'Approve'){
							//echo('entered');
							
							$dirQuery = " select * from Directors where agenda_id = " . $agenda_id ;
							$dirParam = array();
							$dirOptions =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
							$fetchDir = sqlsrv_query($conn, $dirQuery, $dirParam, $dirOptions);
							if($fetchDir){
								//echo('aaaaaaaaaaaaa___');
								$countDir=sqlsrv_num_rows($fetchDir);
								//echo($countDir);
								if($countDir == $numDirectors){
									while($getDir=sqlsrv_fetch_array($fetchDir)){
										
										$Director_ID = $getDir['ID'];
										
										$sqlC = "INSERT INTO Cumulative_Results (SN, Agenda_ID, Approved, Shares_Approved, Not_Approved, Shares_NotApproved, Abstain, Shares_Abstain, i_holder, Attend, VoteCounted, Director_ID) VALUES ('$sn', '$agenda_id', 'Y', '$shares', 'N', '0', 'N', '0', '$i_holder', '$Attend', '$VoteCounted', '$Director_ID')";

										if (sqlsrv_query($conn, $sqlC)) { } else { echo('error');}
									}
								}
							}
						}
						else if($getAgendas5['Reverse_Vote'] == 'DisApprove'){
							$dirQuery = " select * from Directors where agenda_id = " . $agenda_id ;
							$dirParam = array();
							$dirOptions =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
							$fetchDir = sqlsrv_query($conn, $dirQuery, $dirParam, $dirOptions);
							if($fetchDir){
								$countDir=sqlsrv_num_rows($fetchDir);
								if($countDir == $numDirectors){
									while($getDir=sqlsrv_fetch_array($fetchDir)){
										
										$Director_ID = $getDir['ID'];
										
										$sqlC = "INSERT INTO Cumulative_Results (SN, Agenda_ID, Approved, Shares_Approved, Not_Approved, Shares_NotApproved, Abstain, Shares_Abstain, i_holder, Attend, VoteCounted, Director_ID) VALUES ('$sn', '$agenda_id', 'N', '0', 'Y', '$shares', 'N', '0', '$i_holder', '$Attend', '$VoteCounted', '$Director_ID')";

										if (sqlsrv_query($conn, $sqlC)) {}
									}
								}
							}
						}
						else if($getAgendas5['Reverse_Vote'] == 'Abstain'){
							$dirQuery = " select * from Directors where agenda_id = " . $agenda_id ;
							$dirParam = array();
							$dirOptions =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
							$fetchDir = sqlsrv_query($conn, $dirQuery, $dirParam, $dirOptions);
							if($fetchDir){
								$countDir=sqlsrv_num_rows($fetchDir);
								if($countDir == $numDirectors){
									while($getDir=sqlsrv_fetch_array($fetchDir)){
										
										$Director_ID = $getDir['ID'];
										$sqlC = "INSERT INTO Cumulative_Results (SN, Agenda_ID, Approved, Shares_Approved, Not_Approved, Shares_NotApproved, Abstain, Shares_Abstain, i_holder, Attend, VoteCounted, Director_ID) VALUES ('$sn', '$agenda_id', 'N', '0', 'N', '0', 'Y', '$shares', '$i_holder', '$Attend', '$VoteCounted', '$Director_ID')";

										if (sqlsrv_query($conn, $sqlC)) {}
									}
								}
							}
						}
						else{
							$dirQuery = " select * from Directors where agenda_id = " . $agenda_id ;
							$dirParam = array();
							$dirOptions =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
							$fetchDir = sqlsrv_query($conn, $dirQuery, $dirParam, $dirOptions);
							if($fetchDir){
								$countDir=sqlsrv_num_rows($fetchDir);
								if($countDir >= '0'){
									while($getDir=sqlsrv_fetch_array($fetchDir)){
										
										$Director_ID = $getDir['ID'];
										$sqlC = "INSERT INTO Cumulative_Results (SN, Agenda_ID, Approved, Shares_Approved, Not_Approved, Shares_NotApproved, Abstain, Shares_Abstain, i_holder, Attend, VoteCounted, Director_ID) VALUES ('$sn', '$agenda_id', 'N', '0', 'N', '0', 'N', '0', '$i_holder', 'K', '$VoteCounted', '$Director_ID')";

										if (sqlsrv_query($conn, $sqlC)) {}
									}
								}
							}
						}
					}
					
					// cumulative vote end
		}
				// better to insert all at once but should not be more than 1000, assume there are no more than 1000 agendas
				$sql=rtrim($sql,",");
				if (sqlsrv_query($conn, $sql)) {}
			}
 else {
        echo "Error updating record ".$i_holder;
    }

echo json_encode(true);
		
?>