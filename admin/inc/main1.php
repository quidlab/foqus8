<?php
//ini_set('mssql.charset', 'UTF-8');
session_start();
$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
include_once($doc_root. '/lib/getIPAddress.php');
$ipaddress = getUserIP();
mb_internal_encoding("UTF-8");
include_once('errorreporting.php');
//include_once($doc_root. '/lib/db.php');
include_once($doc_root. '/lib/con_mssql.php');
require_once($doc_root."/vendor/autoload.php");
//include_once($doc_root. '/lib/gettranslations.php');
//include_once($doc_root. '/lib/getmeetingconstants.php');
$sql= 'select Company_Name,Meeting_Place from Company where Tlang =?';
$params=array('th');
$com=$FoQusdatabase ->Select($sql,$params);
print_r($com);
//$company_name = $FoQusdatabase -> get_row($sql ,'array');
//include_once($doc_root. '/lib/azurelogger.php');

$sql= 'update company set Company_Name =? where Tlang=?';
//echo $sql;
$comname= 'ズ億園';
$params = array($comname , 'th');
$company_name =$FoQusdatabase ->Run($sql,$params);
echo $company_name;

?>

