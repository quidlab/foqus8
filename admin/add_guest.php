<?php
	 session_start(); 
 include_once('../lib/db.php');
function password_generate($chars) 
{
  $data = '@#$1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
} 
					$num = $_POST['add_guest'];
					/////////////////////
					$getPasswordPolicy="SELECT min_pass_len,password_complexity from co_info where ID=1";
					$params1 = array();
					$checkData1= $FoQusdatabase ->Select($getPasswordPolicy,$params1);
					$fetchData1= count($checkData1);
					//remove before add new guest
					$truncateGuests="Truncate table guest";
					$checkData2= $FoQusdatabase ->run($truncateGuests);
				
	           		for ($i=1; $i <= $num; $i++)
					{
						$loginId="Guest0".$i;
						$fname=$loginId;
						$pass = password_generate(8);
						$params2=array($loginId,$fname,$pass);
						//print_r($params2);
						$sql="insert into guest (loginId, fname, pass) values(?,?,?)";
						
						$FoQusdatabase ->run($sql,$params2);
					}
echo "<script type='text/javascript'>";
echo "window.location = 'Presenters-Guests.php'; ";
echo "</script>";  					
?>