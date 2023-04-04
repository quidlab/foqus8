<?php
include('../../ajax/connection.php');

if(isset($_POST["action"]) && $_POST["action"] == "delete_record"){
    $sql = "DELETE FROM AgendaResults;Delete from EGM;DBCC CHECKIDENT ('EGM', RESEED, 11111110);";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query($conn, $sql , $params, $options);
    if($stmt){
        echo "true"; 
    }else{
       echo "Some Error"; 
    }
}

/*if(isset($_POST["action"]) && $_POST["action"] == "delete_record"){
    echo "true";
} */
?>