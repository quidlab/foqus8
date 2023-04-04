<?php
include "../inc/main.php";

function clear_duplicate_cookies() {
    // If headers have already been sent, there's nothing we can do
    if (headers_sent()) {
        return;
    }

    $cookies = array();
    foreach (headers_list() as $header) {
        // Identify cookie headers
        if (strpos($header, 'Set-Cookie:') === 0) {
            $cookies[] = $header;
        }
    }
    // Removes all cookie headers, including duplicates
    header_remove('Set-Cookie');

    // Restore one copy of each cookie
    foreach(array_unique($cookies) as $cookie) {
        header($cookie, false);
    }
}


if ( !isset($_SESSION['uname'])){ die();}
//session_write_close();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 1200);
//require_once '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//$_SESSION['progress_content'] = "Now importing data" ;	
//include_once('../../lib/db.php');
//$SelectMeetingInfo="SELECT TOP(1) SYMBOL + 'Log_'+ CONVERT(nvarchar,login_allowed_time,6) as uploadfolder from Co_info" ;
//$Query = 
//$FetchInfo = $FoQusdatabase -> Run($Query);
//$SYMBOLLog=$FetchInfo['uploadfolder'];
//$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
$SYMBOLLog=MC_SYMBOL . '_Log_'; //. 'MC_MEETING_TIME';
$uploads_dir_Log = $doc_root.'/uploads/'.$SYMBOLLog."/";
//require_once($doc_root."/vendor/autoload.php");
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
$logger = new Logger('Admin');
$logger->pushHandler(new StreamHandler($uploads_dir_Log . '/adminlog.log', Logger::DEBUG));

if(isset($_POST["action"]) && $_POST["action"] == "check_record"){  
    $compInfo = "SELECT count(*) AS total FROM EGM";
 // 	$compRes =sqlsrv_query($conn, $compInfo);
  	$getComp=$FoQusdatabase -> Select($compInfo);
    if($getComp['total'] == 0){
     //   echo "empty"; 
    }else{
      //  echo $getComp['total'];
    }
//	$logger->Info('enter action line 57 ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);	
}
//$_POST["action"] = "save_data";
if(isset($_POST["action"]) && $_POST["action"] == "save_data"){
//	$logger->Info('enter action line 59 ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);
//	$_SESSION['progress_content'] = "Now importing data" ;
    if (isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "" ) {
//$logger->Info('enter Upload file line 62 ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);
        $allowedExtensions = array("xls","xlsx");

        $ext = pathinfo( $_FILES['uploadFile']['name'] , PATHINFO_EXTENSION );
        if ( in_array ($ext, $allowedExtensions)){

            $isUploaded = $_FILES['uploadFile']['tmp_name'];
            if ($isUploaded) {
//$logger->Info('enter upload line 70 ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);
				
                try {

				   $objPHPExcel = IOFactory::load($isUploaded);
				  // $logger->Info('enter Try line 76 ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);
                } catch (Exception $e) {
					//$logger->Info('enter Try line 78' . $e->getMessage());
                    die ( 'Error loading file "' . pathinfo($isUploaded, PATHINFO_BASENAME ) . '": ' . $e->getMessage());
                }

                $sheet = $objPHPExcel->getSheet(0);
                $total_rows = $sheet->getHighestRow();
                $highest_column = $sheet->getHighestColumn();
                $headings = $sheet->rangeToArray('A1:' . $highest_column . 1, NULL, TRUE, FALSE);
$countRecords=0;
$rowsleft= $total_rows;
$qry="";
                for ($row = 2 ; $row <= $total_rows; $row++) {
					if ( connection_aborted() ) break;  //sleep(1);
                $rowData = $sheet-> rangeToArray ('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE);
                    $columnData = $sheet-> rangeToArray ('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE);
                    $explode = $_POST['shorting_field'];
                    $explode_result = explode(",",$explode);
                    $account_id='';
                    $n_title='';
                    $n_first='';
                    $n_last='';
                    $a_holder='';
                    $i_zip='';
                    $m_phone='';
                    $q_share='';
                    $i_ref='';
                    for($ak=0; $ak<count($columnData[0]); $ak++){

                        
                        if($explode_result['0'] == $headings[0][$ak]){
                            $account_id = $rowData[0][$ak];
                        }
                        
                        if($explode_result['1'] == $headings[0][$ak]){
                            $n_title = $rowData[0][$ak];
                        }
                        
                        if($explode_result['2'] == $headings[0][$ak]){
                            $n_first = $rowData[0][$ak];
                        }
                        
                        if($explode_result['3'] == $headings[0][$ak]){
                            $n_last = $rowData[0][$ak];
                        }
                        
                        if($explode_result['4'] == $headings[0][$ak]){
                            $a_holder = $rowData[0][$ak];
                        }
                        
                        if($explode_result['5'] == $headings[0][$ak]){
                            $i_zip = $rowData[0][$ak];
                        }
                        
                        if($explode_result['6'] == $headings[0][$ak]){
                            $m_phone = $rowData[0][$ak];
                        }
                        
                        if($explode_result['7'] == $headings[0][$ak]){
                            $q_share = $rowData[0][$ak];
                        }
                        
                        if($explode_result['8'] == $headings[0][$ak]){
                            $i_ref = $rowData[0][$ak];
                        }
                    
					}
					
					$qry1  =  "insert into EGM(i_holder,n_title,n_first,n_last,a_holder_1,i_zip,phone,q_share,I_ref) values ";
					$account_id="'".$account_id."'";
					$n_title="N'".$n_title."'";
					$n_first="N'".$n_first."'";
					$n_last="N'".$n_last."'";
					$a_holder="N'".$a_holder."'";
					$i_zip="'".$i_zip."'";
					$m_phone="'".$m_phone."'";
					$q_share="'".$q_share."'";
					$i_ref="N'".$i_ref."'";
					$qry = $qry . "( $account_id, $n_title,$n_first,$n_last,$a_holder,$i_zip,$m_phone,$q_share,$i_ref),";
					
                $countRecords++; $rowsleft--;
				//$logger->Info('enter 157 ',['countrecord'=>$countRecords,'rowsleft'=>$rowsleft]);
				if ($countRecords==1000 || $rowsleft <=1) {
					//session_start();
					//clear_duplicate_cookies();
					//$_SESSION['progress_content']='Now at '. $row;
					//
					//session_write_close();
					//sleep(1);
					//session_start();
					//	$logger->Info('enter 161 ');
					$qry=rtrim($qry,",");
					//$logger->Info('enter final query line 163 ', ['qry'=>$qry]);
					$finalqry= $qry1.$qry.";"; 
					//$logger->Info('enter final query line 163 ', ['finalqry'=>$finalqry]);
					$countRecords=0; 
echo($finalqry);
					$stmtCompany = $FoQusdatabase -> Run($finalqry);

					//$_SESSION['progress_content']='Now at '. $row.$qry;
					$qry="";
					if (!$stmtCompany) {
						//session_start();
						//$_SESSION['progress_content']= 'Now Updating DataBase, please wait ' ;
						//session_write_close();
						//sleep(2);
						//session_start();
				
					} 
					else
					{ goto AlertNow;}  
				}
				 				
                }
                $qry="UPDATE EGM SET Attended = 'N', Shares_Attended = 0, Proxy = 'N', Proxy_name = '', BallotPaperPrinted = 0, Custodian = 'N', USER_ID = '', Registered_Time = NULL, Out_Time = NULL,org_q_share=q_share,Group_id=NULL,serial=0,coupon1_claimed='N',coupon2_claimed='N',coupon3_claimed='N',feedback_submitted='N',factory_visit_interested='N',org_n_first=n_first,org_n_last=n_last,org_i_ref=I_ref,ProxyType=NULL,e_mail=NULL,m_phone=NULL,username=NULL,password=NULL,ApprovedForOnline='N',IPAddress=NULL,lastlogin=NULL,status=0,active=0,Email_sent='N',doc_received='N',jitsiid='0';";
				echo "Please Wait Some more time running Update Script";
				$stmtCompany = $FoQusdatabase -> Run($qry);
                		//	$logger->Info('enter 182 ');	


	AlertNow:			

				
				if($stmtCompany) {
					//session_start();
					//clear_duplicate_cookies();
					
				//	SendAlert();
					$logger->Info('Shareholders Imported ',['user'=>$_SESSION['uname'],'IP'=>$ipaddress]);
					$_SESSION['progress_content']= "close" ;
					//session_write_close();
					echo "<script type=\"text/javascript\">alert(\"File is uploaded Successfully.\"); </script>";
					
                }else {
					//session_start();
					//clear_duplicate_cookies();
					$_SESSION['progress_content']= "close" ;
                   echo "<script type=\"text/javascript\">alert(\"Invalid Value.\");window.location.href='../agm-import.php';</script>";
				   
                }
              
            } else {
				//session_start();
				//clear_duplicate_cookies();
				$_SESSION['progress_content']= "close" ;
                echo "<script type=\"text/javascript\">alert(\"File not uploaded.\");window.location.href='../agm-import.php';</script>";
            }
        } else {
			//session_start();
			//clear_duplicate_cookies();
			$_SESSION['progress_content']= "close" ;
           echo "<script type=\"text/javascript\">alert(\"This type of file not allowed!.\");window.location.href='../agm-import.php';</script>";
        }
    }
    else { 
	//session_start();
	//clear_duplicate_cookies();
	$_SESSION['progress_content']= "close" ;
        echo "<script type=\"text/javascript\">alert(\"Select an excel file first!.\");window.location.href='../agm-import.php';</script>";
    } 
	$_SESSION['progress_content']= "close" ;
}
//session_start();
//clear_duplicate_cookies();
	
//echo ("all ok");

?>
