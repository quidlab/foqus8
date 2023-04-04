<?php include 'connect.php';  ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Group Non Related SH</title>

   <!-- STYLE -->
   <!-- bootstrap 5.1.3 -->
   <link rel="stylesheet" href="agm_style/bootstrap/css/bootstrap.css">
   <link rel="stylesheet" href="agm_style/style.css">
      <link rel="stylesheet" href="agm_style/table.css">

   <!-- Bootstrap JS ver5.1.3-->
   <script src="agm_style/bootstrap/js/popper.min.js"</script>
   <script src="agm_style/bootstrap/js/bootstrap.min.js"</script>


    <!-- TABLE -->
	
     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	 <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
	<style>
	.courses {
  display: flex;
  flex-direction: column; /* control the flex direction ROW|COLUMN */
  margin-bottom: 20px; /* for spacing only */
}

.courses label {
  margin: 5px 0; /* for spacing only*/
}

.courses input[type="checkbox"] {
  margin-right: 10px; /* for spacing only*/
}
	</style>

         <script type="text/javascript">
          $(document).ready( function () {
           $('#table_id').dataTable( {
			order: [[ 1, 'asc' ]]	
           } );
         } ); 
          $(document).ready( function () {
           $('#table_2').dataTable( {
             "bFilter": true
           } );
         } ); 

function getCheckedValues() {
	return Array.from(document.querySelectorAll('input[name="check[]"]'))
  .filter((checkbox) => checkbox.checked)
  .map((checkbox) => checkbox.value);
}


	 
         </script>

  </head>
  <body>
<form method="post">
<div class="maincontainer">

  <div class="container">
        <div class="row">

        <div class="txt">
          First Name:
          </div>
          <div class="col-3">
        <input type="text" class="form-control form-control-sm" list="datalistOptions" id="search_Fname" name="search_Fname" placeholder="Proxy Name">
        </div>

        <div class="txt">
          Last Name:
          </div>
        <div class="col-3">
        <input type="text" class="form-control form-control-sm" list="datalistOptions" id="search_Lname" name="search_Lname"placeholder="Proxy Name">
        </div>

        <div class="col">
        <input type="submit" class="btn btn-primary btn-sm" id="button_search_name" name="button_search_name"value="Search"/>
        </div>

        <div class="col">
        <button type="button" class="btn btn-primary btn-sm" id="button_getall">Get All Shareholders</button>
        </div>
        </div></div>

  <div class="container">
      <div class="row">
      <div class="txt">ID Card No.:</div>
        <div class="col">
        <input type="text" class="form-control form-control-sm" list="datalistOptions" id="search_IDCard" placeholder="ID Card No.">
        </div>
        <div class="col">
        <button type="button" class="btn btn-primary btn-sm" id="button_search_IDCard">Serch By ID Card</button>
        </div>

      <div class="txt">TSD No.:</div>
        <div class="col">
        <input type="text" class="form-control form-control-sm" list="datalistOptions" id="search_TSD" placeholder="ID Card No.">
        </div>
        <div class="col">
        <button type="button" class="btn btn-primary btn-sm" id="button_search_TSD">Serch By TSD Number</button>
        </div>
      </div>
    </div>
<?php 

$n_first = $_POST["search_Fname"];
$n_last = $_POST["search_Lname"];
$IDcard = $_POST["search_IDCard"];
$q_share = $_POST["search_Share"];
$title = $_POST["search_Title"];
$tsd = $_POST["search_TSD"];


if($_POST['button_search_name']=="Search"){
	if($n_first != "" && $n_last == "" ){
	$search = "SELECT * FROM EGM WHERE n_first LIKE N'%".$n_first."%' ";
	}
	if($n_last != "" && $n_first == "" ){
	$search = "SELECT * FROM EGM WHERE n_last LIKE N'%".$n_last."%' ";
	}	
}
$result = sqlsrv_query($conn, $search);	
?>

  <div class="container">
      <div class="row">
        <div class="txt">  Title:</div>
            <div class="col">
            <input type="text" class="form-control form-control-sm" list="datalistOptions" id="search_Title" placeholder="ID Card No.">
            </div>
            <div class="col">
            <button type="button" class="btn btn-primary btn-sm" id="button_search_Title">Serch By Title</button>
            </div>

          <div class="txt">Shares:</div>
            <div class="col">
            <input type="text" class="form-control form-control-sm" list="datalistOptions" id="search_Share" placeholder="ID Card No.">
            </div>
            <div class="col">
            <button type="button" class="btn btn-primary btn-sm" id="button_search_Share">Serch By Shares</button>
            </div>
          </div>
        </div>




<div class="container back_frame tab_frame">
  <table id="table_id" class="display table table-striped table-bordered dataTable" style="width:100%">
  
  
      <thead>
          <tr>
              <th>Select</th>
              <th>ID</th>
              <th>i_holder</th>
              <th>n_title</th>
              <th>n_first</th>
              <th>n_last</th>
              <th>q_share</th>
              <th>i_ref</th>
              <th>Attendance</th>
          </tr>
      </thead>
      <tbody>
<?php 
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{	
?>	  
          <tr>
              <td>
			  <div class="courses">
				  <input class="form-check-input" type="checkbox" value="<?php echo $row['ID']; ?>" id="check" name="check[]">
			  </div>
			  </td>
              <td><?php echo $row['ID']; ?></td>
              <td><?php echo $row['i_holder']; ?></td>
              <td><?php echo $row['n_title']; ?></td>
              <td><?php echo $row['n_first']; ?></td>
              <td><?php echo $row['n_last']; ?></td>
              <td><?php echo $row['q_share']; ?></td>
              <td><?php echo $row['I_ref']; ?></td>
              <td><?php echo $row['Attended']; ?></td>
          </tr>
<?php } ?>
      </tbody>
  </table>
</div>




        <div class="container  leftright">
          <div class="row">
            <input type="submit" class="btn btn-primary btn-sm" id="button_addsh" name="button_addsh" value="Add Selected SH From Top to Bottom Grid For Grouping"/>		
</div>
<?php 
if($_POST["button_addsh"] == "Add Selected SH From Top to Bottom Grid For Grouping"){
$strSQL = "SELECT * FROM EGM WHERE ID IN('".getCheckedValues()."')";
$result = sqlsrv_query($conn, $strSQL);

?>
<div class="row">


          Suggested Common ID:
            <div class="col">
            <input type="text" class="form-control form-control-sm" list="datalistOptions" id="suggestedid" placeholder="QUID180422025935">
            </div>
            </div></div>


<hr>


            <div class="container back_frame tab_frame">
              <table id="table_2" class="stripe row-border order-column" style="width:100%">
                  <thead>
                      <tr>
                          <th>Select</th>
                          <th>ID</th>
                          <th>i_holder</th>
                          <th>n_title</th>
                          <th>n_first</th>
                          <th>n_last</th>
                          <th>q_share</th>
                          <th>i_ref</th>
                          <th>Attendance</th>
                      </tr>
                  </thead>
      <tbody>
<?php 
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{	
?>	  
          <tr>
              <td>
			  <div class="courses">
				  <input class="form-check-input" type="checkbox" value="<?php echo $row['ID']; ?>" id="check" name="check[]">
			  </div>
			  </td>
              <td><?php echo $row['ID']; ?></td>
              <td><?php echo $row['i_holder']; ?></td>
              <td><?php echo $row['n_title']; ?></td>
              <td><?php echo $row['n_first']; ?></td>
              <td><?php echo $row['n_last']; ?></td>
              <td><?php echo $row['q_share']; ?></td>
              <td><?php echo $row['I_ref']; ?></td>
              <td><?php echo $row['Attended']; ?></td>
          </tr>
<?php }} ?>
      </tbody>
              </table>
            </div>


<div class="container  leftright">
<div class="row">
<button type="button" class="btn btn-primary btn-sm" id="button_makeid">Make ID Same for Above Selected Shareholders</button>
</div>

<div class="row">
<p>Total <span id="">0</span> shareholders holding shares selected so fasr for grouping</p>
</div></div>


</div>

</form>

  </body>
</html>
