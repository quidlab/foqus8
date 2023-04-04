<?php  
include "inc/main.php";  
if(isset($_SESSION['uname'])){
include "inc/meta.php"; ?> 
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
<?php include "inc/preloader.php"; ?>
<?php include "inc/popuplogout.php"; ?>
<?php include "inc/nav.php"; ?>
<?php include "inc/sidebar.php"; ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<?php include "inc/company_name_header.php"; ?> 
    <!-- /.content-header -->
 
<?php 
$egmData2="select count(*) as notApproved from EGM where ApprovedForOnline='N'";
$params2 = array();


$CountData2= $FoQusdatabase ->Select($egmData2,$params2);
$egmData3="select count(*) as Approved from EGM where ApprovedForOnline='Y'";
$params3 = array();

$CountData3= $FoQusdatabase ->Select($egmData3,$params3);

$egmData4="select count(*) as totalcount, sum(q_share) as totalvotes from EGM ";
$params4 = array();

$CountData4= $FoQusdatabase ->Select($egmData4,$params4);


$TotCoowners=$CountData4[0]['totalcount'];
$TotCoownerVotes=$CountData4[0]['totalvotes'];
?>
<script>
var yes= <?php echo $CountData3[0]['Approved'];?>;
var no= <?php echo $CountData2[0]['notApproved'];?>;
var totalcoowners=<?php echo $TotCoowners;?>;
var totalcoownerVotes=<?php echo $TotCoownerVotes;?>;
</script>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
       <div id="AGM-Activation">
          <div class="row">
            <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Login Chart</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
                  </div>
				  <hr/>
				  <span><script>document.write("Approved: "+yes+" | Not Approved: "+no);</script></span><br>
				  <span><script>document.write("Total Units: "+totalcoowners.toLocaleString()+" | Total Votes: "+totalcoownerVotes.toLocaleString());</script></span>
                  <hr/>
					<button type="submit" id="updateButton" data-egmid="updateEGMData" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" >Update Data</button>
				  
					<a href="" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-spinner fa-sm text-white-50"></i> Refresh Data</a>
				  <!--</form>-->
                </div>
              </div>
            </div>
			
			
			<div id="tableEGM" class="col-xl-8 col-lg-8">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
					<div class="col-sm-6 text-left">
						<h6 class="m-0 font-weight-bold text-primary">EGM Table</h6>
					</div>
					<div class="col-sm-6 text-right">
						<div class="sendEmailContainer">
							<button class="m-0 font-weight-bold text-primary sendingEmail">Send 1000 Emails <i class='fa fa-paper-plane'></i></button>
							
						</div>
					</div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						  <thead>
							<tr>
							  <th>Username</th>
							  <th>Password</th>
							  <th>i_holder</th>
							  <th>Login</th>
							  <th>Email</th>
							  <th>Edit</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>Username</th>
							  <th>Password</th>
							  <th>i_holder</th>
							  <th>Login</th>
							  <th>Email</th>
							  <th>Edit</th>
							</tr>
						  </tfoot>
						  
						</table>
					  </div>
					</div>
              </div>
            </div>
			<!-- Modal -->
		  <div class="modal fade myModal_values" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
		  <form id="egmForm" class="user" method="POST">
			<div class="modal-dialog" role="document">
			  <div class="modal-content">
				<div class="modal-body">
				<!-- User form -->
				<div class="col-lg-12">
					<div class="p-10">
					  <div class="text-center">
						<h1 class="h4 text-gray-900 mb-4">Update Profile</h1>
					  </div>
						<div class="form-group row">
						  <div class="col-sm-12 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="title" placeholder="Title" required="required" name="title" readonly value="">
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-12 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="first" placeholder="First Name" required="required" name="fname" readonly value="">
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-12">
							<input type="text" class="form-control form-control-user" id="last" placeholder="Last Name" required="required" name="lname" readonly value="">
						  </div>
						</div>
						<div class="form-group">
						  <input type="email" class="form-control form-control-user" id="email" placeholder="Email Address" required="required" name="email" value="">
						</div>
						<div class="form-group row">
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="phone" placeholder="Mobile No" name="mobile" value="">
						  </div>
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<select name="proxy" class="form-control" id="proxy" required="required">
							  <option value="">Set Proxy</option>
							  <option value="N">No</option>
							  <option value="Y">Yes</option>
							</select>
						  </div>
						</div>
						<div class="form-group row">
						  <div class="col-sm-6 mb-3 mb-sm-0">
							<input type="text" class="form-control form-control-user" id="proxy_name" placeholder="Proxy Name" name="proxy_name" value="">
						  </div>
						  <div class="col-sm-6">
							<select name="proxy_type" class="form-control" id="proxy_type">
							  <option value="">Type of Proxy</option>
							  <option value="A">A</option>
							  <option value="B">B</option>
							</select>
						  </div>
						</div>
					</div>
				</div>
				<!-- User form End -->	
				</div>
				<div>
					<input type="hidden" name="CSRFToken" value="<?php  echo(bin2hex(openssl_random_pseudo_bytes(24))); ?>" />
					</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				  <input type="hidden" value="" name="id" id="egmid">
				  <input type="submit" id="updateEGM" class="btn btn-primary" name="submitProfile" value="Save"/>
				</div>
			  </div>
			</div>
			</form>
		  </div>
		  
		<!-- Modal End -->
          </div>	   
	   </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
 

  
<?php include "inc/footer.php"; ?>
<script type="module">
	
	var table1;
	window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 10000);
	
	/*$('#dataTable').dataTable( {
	  "lengthMenu": [ 10, 25, 50, 75, 100, 200, 400, 500, 1000 , 4000],
	} );
	*/
	renderTable();
	function renderTable(){
		if(table1){
			table1.clear();
			table1.destroy();
		}
	table1 = $('#dataTable').DataTable({
		"order": [[ 0, "desc" ]],
		retrieve: true,
		dom: 'lBfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
		"lengthChange": true,
		"lengthMenu": [ [5, 10, 25, 50, 75, 100, 200, 400, 500, -1], [5, 10, 25, 50, 75, 100, 200, 400, 500, "All"] ],
		"bProcessing": true,
		"serverSide": true,
		"scrollY": false,
		"scrollX": true,
		"ajax":{
			url :"egm_list_fetch.php", // json datasource
			type: "post",  // type of method  ,GET/POST/DELETE
			//data: { CSRF: CSRFP-Token},
			error: function(){
				$("#dataError").css("display","none");
			}
		}
	}); 	
		
	}
	
	$('.myModal_values').on('show.bs.modal', function(event) {
		var egmaction = $(event.relatedTarget)
		var title = egmaction.data('title')
		var egmid = egmaction.data('egmid')
		var first = egmaction.data('first')
		var last = egmaction.data('last')
		var email = egmaction.data('email')
		var phone = egmaction.data('phone')
		var proxy = egmaction.data('proxy')
		var proxy_name = egmaction.data('proxy_name')
		var proxy_type = egmaction.data('proxytype')
		
		//var pass = egmaction.data('pass')
		console.log(proxy_name)
		$('#title').val(title);
		$('#egmid').val(egmid);
		$('#first').val(first);
		$('#last').val(last);
		$('#email').val(email);
		$('#phone').val(phone);
		$('#proxy').val(proxy);
		$('#proxy_name').val(proxy_name);
		$('#proxy_type').val(proxy_type);
		//$('#pass1').val(pass);
		//$('#pass2').val(pass);
	});
</script>

<script src="js/custom.js"></script>
</body>
</html>
<?php 
}
else{
	?>
	
	<script>
		window.location.href="logout.php"; 
	</script>
	<?php
}
?>