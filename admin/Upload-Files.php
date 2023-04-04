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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
       <div id="Upload-Files">Upload Files</div>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
      			<div class="card-header py-3">
      				<div class="row m-0">
      					<div class="col-6 p-0"><h6 class="m-0 font-weight-bold text-primary">File List</h6></div>
      					<div class="col-6 p-0 text-right"><a href="addFiles.php"><button type="button" class="btn btn-primary btn-sm"> Add Files </button></a></div>
      				</div>
      			</div>
              
            <div class="card-body">

              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Description Thai</th>
                      <th>Description English</th>
                      <th>File</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
					            <th>Description Thai</th>
                      <th>Description English</th>
                      <th>File</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      // Get Symbol name from Company Info Table Start
                      $checkFolder = "select SYMBOL from Co_info";
                      $findFolder= $FoQusdatabase ->Select($checkFolder);
					  foreach($findFolder as $getFolder){
						  $folderName = $getFolder['SYMBOL'];
						  }
                      // Get Symbol name from Company Info Table End

						          $query = "select * from downloads where file_name like '%$folderName%'";
          						$cat_data= $FoQusdatabase ->Select($query);
								if($cat_data){
								foreach($cat_data as $cat_check){
								
          					?>
                    <tr id="userRow<?php echo $cat_check['id'];?>">
                      <td><?php echo $cat_check['id'];?></td>
                      <td><?php echo $cat_check['description_thai']; ?></td>
                      <td><?php echo $cat_check['description_eng']; ?></td>
                      <td align="center">
                        <a href="<?php echo $cat_check['file_name'] ?>" download> 
                          <?php 
                            $ext = pathinfo($cat_check['file_name'], PATHINFO_EXTENSION);
                            if($ext == 'pdf'){
                          ?>
                            <i class="fa fa-file-pdf" aria-hidden="true"></i>
                          <?php }elseif( ($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'png') ) { ?>
                            <i class="fa fa-file-image" aria-hidden="true"></i>
                          <?php }elseif( ($ext == 'doc') || ($ext == 'docx') || ($ext == 'xls') || ($ext =='xlsx') || ($ext == 'ppt') || ($ext == 'pptx')) { ?>
                            <i class="fa fa-file" aria-hidden="true"></i>
                          <?php } ?>
                        </a>

                      </td>
					            <td>
          						  <a href="editFiles.php?fid=<?php echo $cat_check['id'];?>"><i class="fa fa-edit"></i></a>
          						  &nbsp;
          						  <i class="fa fa-trash" data-toggle="modal" data-remid="<?php echo $cat_check['id']; ?>" data-target="#myUserModal"></i>
          					  </td>
                    </tr>
								<?php }} ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
		  
      <!-- Remove Modal Start -->
			<div class="modal modal_user_pres" id="myUserModal">
			  <div class="modal-dialog">
				<div class="modal-content">

				  <!-- Modal Header -->
				  <div class="modal-header">
					  <h4 class="modal-title">Remove File</h4>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>

				  <!-- Modal body -->
				  <div class="modal-body">
					  Do you want to remove the File from List?
					  <input type="hidden" class="form-control" id="remid" name="remid">
				  </div>

				  <!-- Modal footer -->
				  <div class="modal-footer">
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="deleteUserRow()">Remove Item</button>
				  </div>

				</div>
			  </div>
			</div>
		  <!-- Remove Modal End -->	   
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
  <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
  <script>
    $('.modal_user_pres').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var remid = button.data('remid')
			$('#remid').val(remid);
			//$('#stylecode').text(stylecode);
		})
		
		function deleteUserRow(){
			//console.log(actionData);
			//alert(actionData);
			var geVal= $('#remid').val();
			$("#userRow"+geVal).remove();
			$.ajax({
				url: "files-script.php",
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