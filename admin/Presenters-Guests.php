<?php 
include "inc/main.php";
if(isset($_SESSION['uname'])){
include "inc/meta.php";

?>
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
       <div id="Presenters-Guests">
	   
			<div class="card shadow mb-4">
			<div class="card-header py-3">
              	<div class="row m-0">
                    <div class="col-2 p-0">
                    	<h6 class="m-0 font-weight-bold text-primary">Guest List</h6>
                    </div>
					<div class="col-2 p-0">
                    	<a href="../assets/templates/guests.xlsx" class="btn btn-info btn-sm">Sample Data</a>
                    </div>
                    <div class="col-2 p-0">
                    	<a href="upload-guests.php" class="btn btn-success btn-sm">Upload</a>
                    </div>

					<div class="col-6 p-0 text-right">
					<!-- Add Guest: -->
					<form method="post" action="add_guest.php">
						Add Guest: <input type="text" name="add_guest" value="">
						<input type="submit" name="submit" value="Submit" class="btn btn-primary">
						<br/>
					<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="padding: 0px 10px;"> Delete All</button>
					</form>
					</div>				
				</div>
			</div>
					</div>
              </div>
            </div>
			<!-- The Modal -->
			<div class="modal" id="myModal">
			  <div class="modal-dialog">
				<div class="modal-content">

				  <!-- Modal Header -->
				  <div class="modal-header">
					<h4 class="modal-title">Guest List</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>

				  <!-- Modal body -->
				  <div class="modal-body">
					Do you want to remove the list?
				  </div>

				  <!-- Modal footer -->
				  <div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" onclick="deleteAllRows()">Remove All</button>
				  </div>

				</div>
			  </div>
			</div>
			
			
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Title</th>
					  <th>Name</th>
                      <th>Username</th>
					  <th>Email</th>
					<th>Phone</th>
					<!--  <th>Password</th> -->
                      <!-- <th>Reg Date</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Title</th>
					  <th>Name</th>
                      <th>Username</th>
					  <th>Email</th>
					<th>Phone</th>
					<!--  <th>Password</th> -->
                      <!-- <th>Reg Date</th> -->
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   <?php 
						$sql = "SELECT * from guest";
						$param = array();
						$cat_data = $FoQusdatabase ->Select($sql,$param);
						if($cat_data){
							
							
						foreach($cat_data as $cat_check){
					?>
                    <tr id="userRow<?php echo $cat_check['id'];?>">
                      <td><?php echo $cat_check['title'];?></td>
					  <td><?php echo $cat_check['fname']; if($cat_check['lname']!=''){ echo ' '.$cat_check['lname'];}?></td>
					  <td><?php echo $cat_check['loginId'];?></td>
					  <td><?php echo $cat_check['email'];?></td>
					  
					  <td><?php echo $cat_check['mobile'];?></td>
					<!--  <td>< ? php echo $cat_check['pass']; ? > </td> -->
					  <!-- <td><?php if($cat_check['reg_date']!=''){ echo $cat_check['reg_date']->format('d-M-Y h:i:s A');}?></td> --> 
					  <td>
						<!--<i class="fa fa-trash" onclick="deletePresenter(<?php echo $cat_check['id'];?>)"></i>-->
						<a href="guests-edit.php?pid=<?php echo $cat_check['id'];?>"><i class="fa fa-edit"></i></a>&nbsp;
						
						<?php if($cat_check['Email_sent']== 'N') { ?>
						<i title="Email not sent" class="fa fa-paper-plane emailSentGuest pointer alert-danger" aria-hidden="true" data-emailid="<?php echo $cat_check['id']; ?>" onclick="updateGuestRow(this)"></i>&nbsp;
						<?php }else{ ?>
						<i title="Email Sent" class="fa fa-paper-plane emailSentGuest pointer alert-success" aria-hidden="true" data-emailid="<?php echo $cat_check['id']; ?>" onclick="updateGuestRow(this)"></i>&nbsp;
						<?php } ?>
						
						<i class="fa fa-trash pointer" data-toggle="modal" data-remid="<?php echo $cat_check['id']; ?>" data-target="#myDeleteModal"></i>
					  </td>
                    </tr>
<?php }}?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
			<!-- Remove Modal Start -->
			<div class="modal modal_remove_guest" id="myDeleteModal">
			  <div class="modal-dialog">
				<div class="modal-content">

				  <!-- Modal Header -->
				  <div class="modal-header">
					<h4 class="modal-title">Remove Guest</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>

				  <!-- Modal body -->
				  <div class="modal-body">
					Do you want to remove the guest from List?
					<input type="hidden" class="form-control" id="remid" name="remid">
				  </div>

				  <!-- Modal footer -->
				  <div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" data-dismiss="modal" onclick="deleteGuestRow()">Remove Item</button>
				  </div>

				</div>
			  </div>
			</div>
			<!-- Remove Modal End -->
		  <!-- asdaqwd -->
		  
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
  <!-- Bootstrap core JavaScript-->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/pnotify.js"></script>
  <script src="js/pnotify.nonblock.js"></script>

  <!-- Page level plugins -->
  <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/custom.js"></script>
  <script>
  //presenter data delete
	function deleteAllRows(){
		//console.log(actionData);
		//alert(actionData);
		var geVal= 'eData';
		$("tbody").remove();
		$.ajax({
			url: "guests-script.php",
			method: "POST",
			data: {'deleteAllRows': geVal },
			success: function(regResponse){
				let regResponseData = JSON.parse(regResponse);
                if(regResponseData.message == '1'){
					new PNotify({
						title: 'Success!',
						text: regResponseData.status,
						type: 'success',
						nonblock: {
						  nonblock: true
						},
						styling: 'bootstrap3'
					});
                }
				else{
					new PNotify({
						title: 'Command Failed!',
						text: regResponseData.status,
						type: 'danger',
						nonblock: {
						  nonblock: true
						},
						styling: 'bootstrap3'
					});
				}
			},
			error: function(error){
			  new PNotify({
				title: 'Error!',
                text: 'Something went wrong, refresh the page and check later.',
                type: 'error',
				nonblock: {
				  nonblock: true
				},
                styling: 'bootstrap3'
              });
			}
		});
	}
  
	function deletePresenter(actionData){
			//console.log(actionData);
			//alert(actionData);
			var geVal= actionData;
			$("#userRow"+geVal).remove();
			$.ajax({
				url: "guests-script.php",
				method: "POST",
				data: {'deleteRow': geVal },
				success: function(regResponse){
					let regResponseData = JSON.parse(regResponse);
                    if(regResponseData.message == '1'){
						new PNotify({
							title: 'Success!',
							text: regResponseData.status,
							type: 'success',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
                    }
					else{
						new PNotify({
							title: 'Command Failed!',
							text: regResponseData.status,
							type: 'danger',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					}
				},
				error: function(error){
				  new PNotify({
					title: 'Error!',
                    text: 'Something went wrong, refresh the page and check later.',
                    type: 'error',
					nonblock: {
					  nonblock: true
					},
                    styling: 'bootstrap3'
                  });
				}
			});
		}
		
		$('.modal_remove_guest').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var remid = button.data('remid')
			$('#remid').val(remid);
			//$('#stylecode').text(stylecode);
		})
		
		function deleteGuestRow(){
			//console.log(actionData);
			//alert(actionData);
			var geVal= $('#remid').val();
			$("#userRow"+geVal).remove();
			$.ajax({
				url: "guests-script.php",
				method: "POST",
				data: {'deleteRow': geVal },
				success: function(regResponse){
					let regResponseData = JSON.parse(regResponse);
                    if(regResponseData.message == '1'){
						new PNotify({
							title: 'Success!',
							text: regResponseData.status,
							type: 'success',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
                    }
					else{
						new PNotify({
							title: 'Command Failed!',
							text: regResponseData.status,
							type: 'danger',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					}
				},
				error: function(error){
				  new PNotify({
					title: 'Error!',
                    text: 'Something went wrong, refresh the page and check later.',
                    type: 'error',
					nonblock: {
					  nonblock: true
					},
                    styling: 'bootstrap3'
                  });
				}
			});
		}

		// Update Guest Column Email Sent Start
		function updateGuestRow(elem){			
			var emVal = $(elem).data("emailid");
			$.ajax({
				url: "guests-script.php",
				method: "POST",
				data: {'guestId': emVal },
				success: function(regResponse){
					let regResponseData = JSON.parse(regResponse);
                    if(regResponseData.message == '1'){
						new PNotify({
							title: 'Success!',
							text: regResponseData.status,
							type: 'success',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
                    }
					else{
						new PNotify({
							title: 'Command Failed!',
							text: regResponseData.status,
							type: 'danger',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					}
				},
				error: function(error){
				  new PNotify({
					title: 'Error!',
                    text: 'Something went wrong, refresh the page and check later.',
                    type: 'error',
					nonblock: {
					  nonblock: true
					},
                    styling: 'bootstrap3'
                  });
				}
			});
		}
		// Update Guest Column Email Sent End
		
  </script>
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