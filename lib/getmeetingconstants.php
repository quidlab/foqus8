<?
$sql= 'select ID,Constant_Name,Constant_Value,Description from Meeting_Constants_Str';
$params=array();
$meeting_constants = $FoQusdatabase ->Select($sql,$params);
foreach($meeting_constants as $meeting_constant){
define('MC_'.$meeting_constant['Constant_Name'],$meeting_constant['Constant_Value']);
}
$sql= 'select ID,Constant_Name,Constant_Value,Description from Meeting_Constants_Bool';
$params=array();
$meeting_constants = $FoQusdatabase ->Select($sql,$params);
foreach($meeting_constants as $meeting_constant){
define('MC_'.$meeting_constant['Constant_Name'],$meeting_constant['Constant_Value']);

}
?>