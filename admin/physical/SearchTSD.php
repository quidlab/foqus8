<?php 
include 'connect.php'; 


$method = $_SERVER['REQUEST_METHOD'];
// for read data from database
if($method == 'GET')
{
$query = "SELECT * FROM EGM ORDER BY ID";
$result = sqlsrv_query($conn, $query);
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
   $output[] = array(
   'Shares_Held'    => $row['q_share'],   
   'SN'  => $row['ID'],
   'TSD_Registration'   => $row['i_holder'],
   'Title'   => $row['n_title'],
   'First_Name'   => $row['n_first'],
   'Last_Name'   => $row['n_last'],
   'Address'   => $row['a_holder_1']	
  );	
}
header("Content-Type: application/json");
echo json_encode($output);
sqlsrv_free_stmt($result);
sqlsrv_close($conn);

}

?>
