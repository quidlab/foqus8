<?php
	
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 1200);

require_once '../assets/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

session_start();
include_once('../lib/db.php');
include('generate-password.php');

if(isset($_POST["action"]) && $_POST["action"] == "upload_guests"){
    //echo "local<br>";    
    if (isset($_FILES['fileUpload']['name']) && $_FILES['fileUpload']['name'] != "" ) {
         
        $allowedExtensions = array("xls","xlsx");
        // Return the extension of the file
        $ext = pathinfo( $_FILES['fileUpload']['name'] , PATHINFO_EXTENSION );
        if (in_array ($ext, $allowedExtensions)){
            
            //echo "test 4";
            
            $isUploaded = $_FILES['fileUpload']['tmp_name'];
            if ($isUploaded) {
                // include "agm/Classes/PHPExcel/IOFactory.php";
 
                try {
                  // $objPHPExcel = PHPExcel_IOFactory::load($isUploaded);
                  $objPHPExcel = IOFactory::load($isUploaded);
                } catch (Exception $e) {
                    die ( 'Error loading file "' . pathinfo($isUploaded, PATHINFO_BASENAME ) . '": ' . $e->getMessage());
                }
                $sheet = $objPHPExcel->getSheet(0);
                $total_rows = $sheet->getHighestRow();
                $highest_column = $sheet->getHighestColumn();
                echo '<table class=" table responsive" cellpadding="5" cellspacing="0" border="1">';
                
                $headings = $sheet->rangeToArray('A1:' . $highest_column . 1, NULL, TRUE, FALSE);
                $success = 0;
				// added by kamal
					$getPasswordPolicy="SELECT min_pass_len,password_complexity from co_info where ID=1";
					$params1 = array();
					$checkData1= $FoQusdatabase ->Select($getPasswordPolicy,$params1);
					$fetchData1= count($checkData1);
				
				
				
				// end added by kamal
function password_generate($chars) 
{
  $data = '@#$1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
} 				
				
                for ($row = 2 ; $row <= $total_rows; $row++) {
                    
                  // $pass= generateStrongPassword(9,false,'l'); // modified by kamal
					$pass= password_generate(8);
                    $rowData = $sheet-> rangeToArray ('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE);
                    $columnData = $sheet-> rangeToArray ('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE);
                    
                    $title = $columnData[0][1]; // added by kamal
					$fname = $columnData[0][2];
                    $lname = $columnData[0][3];
                    $sql = "insert into guest(loginId,title,fname,lname,email,mobile,pass) values('".$columnData[0][0]."', N'$title', N'$fname', N'$lname', '".$columnData[0][4]."', '".$columnData[0][5]."', '".$pass."')";
                    $qry = $FoQusdatabase ->run($sql);
                    
                    if($qry){
                       $success++;
                    }
                }
                
                if($success > 0) {
                    $_SESSION['msg'] = "File is uploaded Successfully";
                    echo "<script type=\"text/javascript\"> window.location.href='Presenters-Guests.php';</script>";
                }else {
                    $_SESSION['msg'] = "Invalid Value";
                    echo "<script type=\"text/javascript\"> window.location.href='Presenters-Guests.php';</script>";
                }
                echo '</table>';
            } else {
                $_SESSION['msg'] = "File not uploaded";
                echo "<script type=\"text/javascript\"> window.location.href='Presenters-Guests.php';</script>";
            }
        } else {
            $_SESSION['msg'] = "This type of file not allowed!";
            echo "<script type=\"text/javascript\"> window.location.href='Presenters-Guests.php';</script>";
        }
    }
    else {
        $_SESSION['msg'] = "Select an excel file first!";
        echo "<script type=\"text/javascript\"> window.location.href='Presenters-Guests.php';</script>";
    }   
    
    //header('location:upload-guests.php');
}

else{
    echo "invalid";
}
?>