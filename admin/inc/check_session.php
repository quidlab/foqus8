<?php  
 //check_session.php  
 session_start();
 if(isset($_SESSION["uname"]))  
 {  
    //  echo '0';     //session not expired     
echo   ini_get("session.gc_maxlifetime");	
 }  
 else  
 {  
      echo '1';     //session expired  
 }
 ?>