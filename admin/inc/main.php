<?php
session_start();
$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
include_once($doc_root. '/lib/getIPAddress.php');
//$ipaddress = getUserIP(); uncomment
mb_internal_encoding("UTF-8");
include_once('errorreporting.php');
include_once($doc_root. '/lib/db.php');
require_once($doc_root."/vendor/autoload.php");
//require_once("../../../vendor/autoload.php");
//include_once($doc_root."/../vendor/sendgrid/sendgrid/sendgrid-php.php");
include_once($doc_root. '/lib/gettranslations.php');
include_once($doc_root. '/lib/getmeetingconstants.php');
$sql= 'select Company_Name,Meeting_Place from Company where Tlang ='."'". $lang ."'";
$params=array();
$company_name = $FoQusdatabase ->Select($sql,$params);
//print_r($company_name);
//echo($company_name[0]['Company_Name']);
//include_once($doc_root. '/lib/azurelogger.php'); uncomment
//$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
include_once ($doc_root. '/csrf/libs/csrf/csrfprotector.php');
csrfProtector::init();

?>

