<?php
include 'connect.php';
?>

<html lang="en" dir="ltr">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration</title>
	
	<link rel="stylesheet" href="agm_style/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="agm_style/style.css">
		<script src="https://code.jquery.com/jquery-latest.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>	 -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="agm_style/bootstrap/js/popper.min.js"></script>
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>

    
	
<!-- <script src="jsgrid/src/jsgrid.core.js"></script>
    <script src="jsgrid/src/jsgrid.load-indicator.js"></script>
    <script src="jsgrid/src/jsgrid.load-strategies.js"></script>
    <script src="jsgrid/src/jsgrid.sort-strategies.js"></script>
    <script src="jsgrid/src/jsgrid.field.js"></script>
    <script src="jsgrid/src/fields/jsgrid.field.text.js"></script>
    <script src="jsgrid/src/fields/jsgrid.field.number.js"></script>
    <script src="jsgrid/src/fields/jsgrid.field.select.js"></script>
    <script src="jsgrid/src/fields/jsgrid.field.checkbox.js"></script>
    <script src="jsgrid/src/fields/jsgrid.field.control.js"></script>	 -->

  </head>
<body>
<form>
<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* 	$sql = "SELECT * FROM egm";
	$query = sqlsrv_query($conn, $sql);
	$checkattended = "SELECT * FROM egm  where Attended='Y'";
	$check_attended = sqlsrv_query($conn, $checkattended); */

?>
<div class="container"> <!-- Modal for add register to database -->
<div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">

	<h4 class="modal-title" id="myModalLabel"> Attended Sharedialog</h4>
	</div>
	<div class="modal-body" id="getCode" >
	<div class="container">  
	<div class="row">
	Proxy Form:
		<div class="col-sm-2">
			<select name="cbo1" id="proxytype_modal" style="padding: 10px;width: 60px;font-size:16px;border: 0;border-bottom: 3px solid teal;">
			<option value=""></option>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			</select>
		</div>
	Share Attended:	
		<div class="col-sm-5">
			<input type="text" readonly="" id="idHolder"  name="eventId"/>
		</div>
	</div>
	<span id="showCBO1" style="padding: 10px;font-size:20px;border: 0;color:red"></span>
	<div class="row">
		Proxy Name:
		
		<div class="col-sm-2" >
			<input type="text" name="cbo2" id="proxyname_modal" list="proxyname_modal" style="padding: 10px;width: 400px;font-size:16px;border: 0;border-bottom: 3px solid teal;" />
			<datalist id="proxyname_modal">
			<option></option>


		
			<!-- <select name="cbo2"  id="proxyname_modal" style="padding: 10px;width: 400px;font-size:16px;border: 0;border-bottom: 3px solid teal;">
			<option value=""></option> -->
			<?php
			$showProxy = "SELECT * FROM Proxy_names";
			$showProxyname = sqlsrv_query($conn, $showProxy);			
			while($showPN = sqlsrv_fetch_array($showProxyname, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$showPN['Proxy_Name']."'>".$showPN['Proxy_Name']."</option>";
			}
			 ?>
			</datalist> 
		<!--	</select> -->
		</div>
	</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary" id="btnOK"data-dismiss="modal">OK</button>
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>   
	</div>
       </div>
    </div>
   </div>
 </div>
</div>

<div class="container"> <!-- Modal after click search -->
<div class="modal fade" id="search_TSD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
	<h4 class="modal-title" id="myModalLabel"> Form Search TSD</h4>	
	</div>	
	<div class="modal-body" id="getCode" >
	
	<div id="jsGrid"></div>

	<div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnClose" data-dismiss="modal">Close</button>
      </div>
       </div>
    </div>
   </div>
 </div>
</div>

<div class="maincontainer">
<div class="container">
      <div class="row">
      TSD Registration Number:
      <div class="col-sm-2">
	  <input type="text" class="form-control form-control-sm" list="datalistOptions" id="i_holder" placeholder="TSD Registration No." name="i_holder" autocomplete="off">
		  <datalist id="abc">
			<?php 
			while($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$d['i_holder']."'></option>";
			}
			?>
		  </datalist>		  
      </div>
      ID Number:
      <div class="col-sm-2">
      <input readonly type="text" class="form-control form-control-sm"  id="I_ref" name="I_ref"placeholder="ID Number" autocomplete="off">
		  <datalist id="abc2">
			<?php 
			while($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$d['I_ref']."'></option>";
			}
			?>
		  </datalist>	  
      </div>
	  Show Print preview Before Printing
	  <div class="col">
	  <div class="form-check">
	  <input class="form-check-input" type="checkbox" value="" id="print" checked>
	  </div>
	  </div>
	  Custodian First
	  <div class="col">
	  <div class="form-check">
	  <input class="form-check-input" type="checkbox" value="" id="custodian_check">
	  </div>
	  </div>
      </div>
</div>

<div class="container">
	<div class="row">
	SN:
	<div class="col-2">
	<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="SN" name="SN" placeholder="SN">
	</div>
	TSD Reg. No.:
	<div class="col-3">
	<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="i_holder2" placeholder="TSD Reg. No." autocomplete="off">
		  <datalist id="abc">
			<?php 
			while($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$d['i_holder']."'></option>";
			}
			?>
		  </datalist>		
	</div>
	Shares Held for this Reg. No.:
	<div class="col">
	<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="SH_TSDReg" placeholder="TSD Reg. No.">
	</div>
	</div>
</div>
<div class="container">
      <div class="row">
      Title
      <div class="col-sm-1">
	  <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="titleName" placeholder="" name="titleName" autocomplete="off">
		  <datalist id="abc">
			<?php 
			while($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$d['i_holder']."'></option>";
			}
			?>
		  </datalist>		  
      </div>
      Name
      <div class="col-sm-3">
      <input readonly type="text" class="form-control form-control-sm"  id="f_name" name="f_name"placeholder="Name" autocomplete="off">
		  <datalist id="abc2">
			<?php 
			while($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$d['I_ref']."'></option>";
			}
			?>
		  </datalist>	  
      </div>
      Last Name
      <div class="col-sm-5">
      <input readonly type="text" class="form-control form-control-sm"  id="L_name" name="L_name"placeholder="Last Name" autocomplete="off">
		  <datalist id="abc2">
			<?php 
			while($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
				echo "<option value='".$d['I_ref']."'></option>";
			}
			?>
		  </datalist>	  
      </div>
      </div>
</div> 

<div hidden class="container">
	<div class="row">
	Address line 1:
	<div class="col">
	<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="address1" placeholder="Address">
	</div>
	</div>
</div>


<div hidden class="container">
	<div class="row">
	Address line 2:
	<div class="col">
	<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="address2" placeholder="Address">
	</div>
	</div>
</div>



<div hidden class="container">
	<div class="row">
	Zip Code:
	<div class="col">
	<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="i_zip" placeholder="Zip Code">
	</div>
	</div>
</div>


<div class="container">
	<div class="row">
	Attended:
	<div class="col-1">
    <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="attended" placeholder=" ">
	</div>
	Shares Attended:
	<div class="col">
    <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="sh_attended" placeholder="Shares Attended">
    </div>
	Custodian:
	<div class="col-1">
    <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="custodian" placeholder="">
    </div>
    </div>
</div>


<div class="container">
      <div class="row">
        Proxy:
        <div class="col-1">
		<input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="proxy" placeholder="">
      </div>

      Proxy Form:
      <div class="col-2">
      <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="proxytype" placeholder="Proxy Form">
      </div>

      Proxy Name:
      <div class="col">
      <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="proxyname" placeholder="Proxy Name">
      </div>
      </div></div>


<div class="container">
	<div class="row">
	Ballot Paper Printed:
    <div class="col-2">
    <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="ballotpaper" placeholder="">
    </div>
	Group ID:
    <div class="col-2">
    <input readonly type="text" class="form-control form-control-sm" list="datalistOptions" id="groupid" placeholder="Group ID">
    </div>
    </div>
</div>


<div class="container button_container">
	<button type="button" class="btn btn-primary btn-sm btn-margin" id="button_print">Print Full Ballot Paper</button>
    <button type="button" class="btn btn-primary btn-sm btn-margin" id="button_search">Search TSD No. by Name or ID</button>
    <button type="button" class="btn btn-primary btn-sm btn-margin" id="button_ungroup">Un Group</button>
    <button type="button" class="btn btn-primary btn-sm btn-margin" id="button_changegroup">Change Group Settings</button>
</div>

<div class="container back_frame" >
<?php 
$sql2 = "SELECT (Select count(*) from EGM )as TotalShareHolders ,(Select sum(q_share) from EGM) as TotalShares, (Select count(*) from EGM where (Attended='Y')) as SHAttended,(Select Sum(q_share) from EGM where (Attended='Y')) as SHAttendedShares,(Select count(*) from EGM where (Attended='Y' and Proxy='Y')) as ProxyAttended,(Select Sum(q_share) from EGM where (Attended='Y' and Proxy='Y')) as ProxySharesAttended";
$query2 = sqlsrv_query($conn, $sql2);
?>

	<br>
	<table style="font-size: 13.5px;text-align: right;" id="f_refresh">
	<tr>
	<td>Total No. of Share Holders As per TSD:</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
			<?php 
			while($d = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC)){
				echo number_format($d['TotalShareHolders']);
			?>	
	</td>
	<td>&nbsp;&nbsp;</td>
	<td>Persons</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>Total No. of Shares As per TSD:</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
			<?php 			
				echo number_format($d['TotalShares']);			
			?>
	</td>
	<td>&nbsp;</td>
	<td style="font-size: 15px;text-align: left;">Shares</td>
	</tr>

	<tr>
	<td>Share Holders Attended (include proxies):</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
			<?php 
				echo number_format($d['SHAttended']);
			?>	
	</td>
	<td>&nbsp;&nbsp;</td>
	<td>Persons</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>Total Number of Shares Attended:</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
			<?php 			
				echo number_format($d['SHAttendedShares']);			
			?>
	</td>
	<td>&nbsp;&nbsp;</td>
	<td>Shares &nbsp;&nbsp;</td>
	<td>
	<?php 
	echo (number_format($d['SHAttendedShares']/$d['TotalShares']*100,4,".",",")."%");			
	?>	
	</td>
	</tr>
	<tr>
	<td>No. of Proxy Attended:</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
			<?php 
				echo number_format($d['ProxyAttended']);
			?>	
	</td>
	<td>&nbsp;&nbsp;</td>
	<td>Persons</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>Total Number of Proxy Shares:</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
			<?php 			
				echo number_format($d['ProxySharesAttended']);		
			?>
	</td>
	<td>&nbsp;</td>
	<td style="font-size: 15px;text-align: left;">Shares</td>
	</tr>

</table>
<br>
			<?php } ?>
</div>
<div class="container button_container">
	<button type="button" id="button_refresh" class="btn btn-primary btn-sm btn-margin" >Refresh Information</button>
</div>


</div>
</form>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){ //show i_holder detail after enter
var input = document.getElementById("i_holder");
	input.addEventListener("keypress", function(event) {
	if (event.key === "Enter") {
		event.preventDefault();
	$.ajax({ 
		url: "returnRegistration.php" ,
		type: "POST",
		async: false,
		data: 'siholder=' +$("#i_holder").val()
		
	})
	.success(function(result) {
		
		var obj = jQuery.parseJSON(result);
		if(obj.length>1){
			let text = "It has more than one account do you want to do grouping?";
			if (confirm(text) == true) {
    js_popup('groupingdialog.php?siholder='+$("#i_holder").val(),800,600); return false;
  } 
			
		}
		if(obj == ''){
			$('input[type=text]').val('');
		}else{
			$.each(obj, function(key, inval) {
				if(inval["i_holder"] != $("#i_holder").val() ){ return; }
			if(inval["Attended"] == 'N' ){
			$("#getCodeModal").modal("show");
			$("#proxytype_modal").val("");
			$('#proxyname_modal').val("");
			$('#proxyname_modal').attr("disabled", true);
			$("#i_holder").val(inval["i_holder"]);
			$("#i_holder2").val(inval["i_holder"]);
			$("#I_ref").val(inval["I_ref"]);
			$('#idHolder').val(inval["q_share"]);
			$('#SN').val(inval["ID"]);
			$('#SH_TSDReg').val(inval["q_share"]);
			$('#titleName').val(inval["n_title"]);
			$('#f_name').val(inval["n_first"]);
			$('#L_name').val(inval["n_last"]);
			$('#address1').val(inval["a_holder_1"]);
			$('#address2').val(inval["a_holder_2"]);
			$('#i_zip').val(inval["i_zip"]);
			$('#attended').val(inval["Attended"]);
			$('#sh_attended').val(inval["Shares_Attended"]);
			$('#custodian').val(inval["Custodian"]);
			$('#proxy').val(inval["Proxy"]);
			$('#proxytype').val(inval["ProxyType"]);
			$('#proxyname').val(inval["Proxy_name"]);
			$('#ballotpaper').val(inval["BallotPaperPrinted"]);
			$('#groupid').val(inval["Group_id"]);	
			}else{
 let text1 = "has already registed once. do you want to print his bollotpaper again?";
 let text2 = "has already registed once. do you want to change Proxy name etc?";
 let text3 = "has already registed once. do you want to DELETE his bollotpaper?";
  if (confirm(text1) == true) {
    js_popup('bollot6_2.php?siholder='+$("#i_holder").val(),800,600); return false;
  } 
  else {
  if (confirm(text2) == true) {
			$("#getCodeModal").modal("show");
			$("#i_holder").val(inval["i_holder"]);
			$("#i_holder2").val(inval["i_holder"]);
			$("#proxytype_modal").val(inval["ProxyType"]);
			$('#proxyname_modal').val(inval["Proxy_name"]);
			$("#I_ref").val(inval["I_ref"]);
			$('#idHolder').val(inval["q_share"]);
			$('#SN').val(inval["ID"]);
			$('#SH_TSDReg').val(inval["q_share"]);
			$('#titleName').val(inval["n_title"]);
			$('#f_name').val(inval["n_first"]);
			$('#L_name').val(inval["n_last"]);
			$('#address1').val(inval["a_holder_1"]);
			$('#address2').val(inval["a_holder_2"]);
			$('#i_zip').val(inval["i_zip"]);
			$('#attended').val(inval["Attended"]);
			$('#sh_attended').val(inval["Shares_Attended"]);
			$('#custodian').val(inval["Custodian"]);
			$('#proxy').val(inval["Proxy"]);
			$('#proxytype').val(inval["ProxyType"]);
			$('#proxyname').val(inval["Proxy_name"]);
			$('#ballotpaper').val(inval["BallotPaperPrinted"]);
			$('#groupid').val(inval["Group_id"]);
  } else {
  if (confirm(text3) == true) { 
  let pw = prompt("Please enter password", "");
  if (pw == '1234'){
  //window.location = 'delete.php?siholder='+$("#i_holder").val();
	alert("Deleted registration already");
  }else{alert("Password not correct!!");}  
  }
  }
  }			

			}});
		}});
	}
	});
});

//Save register
$(document).on("click", "#btnOK", function () {
	var siholder = $("#i_holder").val();
	var proxytype = $("#proxytype_modal").val();
	var proxyname = $("#proxyname_modal").val();
	var idHolder = $("#idHolder").val();
	var SN=$("#SN").val();
	
	$.ajax({
	 type: "POST",
	 async: false,
	 url: "saveRegister.php",
	 data: {
	 siholder: siholder,
	 idHolder: idHolder,
	 proxytype: proxytype,
	 proxyname: proxyname,
	 SN: SN
	 
	 },
	 cache: false,
	 success: function(data) {
		 
	 $.ajax({ 
		url: "returnRegistration.php" ,
		type: "POST",
		async: false,
		data: 'siholder=' +$("#i_holder").val()
	 })
	 .success(function(result) {
		var obj = jQuery.parseJSON(result);
		$.each(obj, function(key, inval) {
			$('#attended').val(inval["Attended"]);
			$('#sh_attended').val(inval["Shares_Attended"]);
			$('#custodian').val(inval["Custodian"]);
			$('#proxy').val(inval["Proxy"]);
			$('#proxytype').val(inval["ProxyType"]);
			$('#proxyname').val(inval["Proxy_name"]);
			$('#ballotpaper').val(inval["BallotPaperPrinted"]);
			$('#groupid').val(inval["Group_id"]);	
			
		});
		
		});
		
	 },
	 error: function(xhr, status, error) {
	 console.error(xhr);
	 }
	 });
	// alert('gggggg');
	/* window.location = "saveRegister.php?siholder="+$("#i_holder").val()+"&proxytype="+$("#proxytype_modal").val()+"&proxyname="+$("#proxyname_modal").val(); */
	js_popup('bollot6_2.php?siholder='+$("#i_holder").val(),800,600); return false;
});

//change when select Proxy Type
$('#proxytype_modal').change(function() {
var select = document.getElementById('proxytype_modal').value;
if(select == ""){
	$("#proxyname_modal").val("");
	$('#proxyname_modal').attr("disabled", true);
}else{$('#proxyname_modal').attr("disabled", false);}
if(select == "B"){
$('#showCBO1').html("ไม่ให้บัตรลงคะแนนเสียงสำหรับ Proxy นี้");
}else{$('#showCBO1').html("");}
if(select == "C"){
$('#idHolder').attr('readonly', false);
$('#idHolder').css('background-color', '#FFFF99');
}else{
$('#idHolder').attr('readonly', true);
$('#idHolder').css('background-color', '#FFFFFF');
}
});

//refresh div
$(document).on("click", "#button_refresh", function () {
$( "#f_refresh" ).load( "registration.php #f_refresh" );
});

$(document).on("click", "#button_search", function () {
	$("#search_TSD").modal("show");
});

$(document).ready(function() { //start page show this
 			$("#jsGrid").jsGrid({
				height: "300%",
                width: "100%",
                filtering: true,
                paging: true,
                autoload: true,
                pageSize: 15,
                pageButtonCount: 5,
				rowClick: function(args) {
					var getData = args.item;
					var keys = Object.keys(getData);
					var text = [];
					$.each(keys, function(idx, value) {
					$("#i_holder").val(getData["TSD_Registration"])
					});
				},				
				controller: { 
						loadData: function(filter){
						var d = $.Deferred();
						$.ajax({
						type: "GET",
						async: false,
						url: "SearchTSD.php",
						data: filter
						}).done(function(result) {
						result = $.grep(result, function(item) {
							return (!filter.Shares_Held || item.Shares_Held === filter.Shares_Held)
								&& (!filter.SN || item.SN === filter.SN)
								&& (!filter.TSD_Registration || item.TSD_Registration === filter.TSD_Registration)
								&& (!filter.Title || item.Title === filter.Title)
								&& (!filter.First_Name || item.First_Name.indexOf(filter.First_Name) > -1)
								&& (!filter.Last_Name || item.Last_Name.indexOf(filter.Last_Name) > -1);
						});
						d.resolve(result);
						})

						return d.promise();
						},
				},
                fields: [
                    { name: "Shares_Held", type: "text", width: 100 },
                    { name: "SN", type: "text", width: 100 },
                    { name: "TSD_Registration", type: "text", width: 150 },
					{ name: "Title", type: "text", width: 80 },
					{ name: "First_Name", type: "text", width: 100 },
                    { name: "Last_Name", type: "text", width: 100 },
                    { name: "Address", type: "text", width: 200 ,sorting: false,filtering: false},
					{ type: "control", modeSwitchButton: false, editButton: false ,deleteButton: false}
                ]
            });           					
});	

$(document).on("click", "#btnClose", function () {
	
var input = document.getElementById("i_holder");
	$.ajax({ 
		url: "returnRegistration.php" ,
		type: "POST",
		async: false,
		data: 'siholder=' +$("#i_holder").val()
	})
	.success(function(result) {
		
		var obj = jQuery.parseJSON(result);
		if(obj == ''){
			$('input[type=text]').val('');
		}else{
			$.each(obj, function(key, inval) {
			if(inval["Attended"] == 'N'){
			$("#getCodeModal").modal("show");
			$("#proxytype_modal").val("");
			$('#proxyname_modal').val("");
			$('#proxyname_modal').attr("disabled", true);
			$("#i_holder").val(inval["i_holder"]);
			$("#i_holder2").val(inval["i_holder"]);
			$("#I_ref").val(inval["I_ref"]);
			$('#idHolder').val(inval["q_share"]);
			$('#SN').val(inval["ID"]);
			$('#SH_TSDReg').val(inval["q_share"]);
			$('#titleName').val(inval["n_title"]);
			$('#f_name').val(inval["n_first"]);
			$('#L_name').val(inval["n_last"]);
			$('#address1').val(inval["a_holder_1"]);
			$('#address2').val(inval["a_holder_2"]);
			$('#i_zip').val(inval["i_zip"]);
			$('#attended').val(inval["Attended"]);
			$('#sh_attended').val(inval["Shares_Attended"]);
			$('#custodian').val(inval["Custodian"]);
			$('#proxy').val(inval["Proxy"]);
			$('#proxytype').val(inval["ProxyType"]);
			$('#proxyname').val(inval["Proxy_name"]);
			$('#ballotpaper').val(inval["BallotPaperPrinted"]);
			$('#groupid').val(inval["Group_id"]);	
			}else{
 let text1 = "has already registed once. do you want to print his bollotpaper again?";
 let text2 = "has already registed once. do you want to change Proxy name etc?";
 let text3 = "has already registed once. do you want to DELETE his bollotpaper?";
  if (confirm(text1) == true) { //Bollot
	js_popup('bollot6_2.php?siholder='+$("#i_holder").val(),800,600); return false;
  } 
  else {
  if (confirm(text2) == true) {
			$("#getCodeModal").modal("show");
			$("#i_holder").val(inval["i_holder"]);
			$("#i_holder2").val(inval["i_holder"]);
			$("#proxytype_modal").val(inval["ProxyType"]);
			$('#proxyname_modal').val(inval["Proxy_name"]);
			$("#I_ref").val(inval["I_ref"]);
			$('#idHolder').val(inval["q_share"]);
			$('#SN').val(inval["ID"]);
			$('#SH_TSDReg').val(inval["q_share"]);
			$('#titleName').val(inval["n_title"]);
			$('#f_name').val(inval["n_first"]);
			$('#L_name').val(inval["n_last"]);
			$('#address1').val(inval["a_holder_1"]);
			$('#address2').val(inval["a_holder_2"]);
			$('#i_zip').val(inval["i_zip"]);
			$('#attended').val(inval["Attended"]);
			$('#sh_attended').val(inval["Shares_Attended"]);
			$('#custodian').val(inval["Custodian"]);
			$('#proxy').val(inval["Proxy"]);
			$('#proxytype').val(inval["ProxyType"]);
			$('#proxyname').val(inval["Proxy_name"]);
			$('#ballotpaper').val(inval["BallotPaperPrinted"]);
			$('#groupid').val(inval["Group_id"]);
  } else {
  if (confirm(text3) == true) { 
  let pw = prompt("Please enter password", "");
  if (pw == '1234'){
  //window.location = 'delete.php?siholder='+$("#i_holder").val();
	alert("Deleted already");
  }else{alert("Password not correct!!");}  
  }
  }
  }			

			}});
		}});
});

function js_popup(theURL,width,height) { // onClick="js_popup('showService.php?id=0001',500,500); return false;"
leftpos = (screen.availWidth - width) / 2;
toppos = (screen.availHeight - height) / 2;
window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>