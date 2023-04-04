<?php  //แบบฟอร์มเปล่า
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
       <div id="addfile_upload">
		    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">File Upload Create</h1>
    			<div class="card shadow mb-4">
    				<div class="card-body">
    					<form id="fileCreate" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                
                <div class="item form-group">
                  <label for="descriptionEng" class="col-form-label col-md-3 col-sm-3 label-align">Description English </label>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <input type="text" name="descriptionEng" id="descriptionEng" class="form-control" placeholder="Description English">
                  </div>
                </div>
    					  
    					  <div class="item form-group">
                  <label for="descriptionThai" class="col-form-label col-md-3 col-sm-3 label-align">Description Thai </label>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <input type="text" name="descriptionThai" id="descriptionThai" class="form-control" placeholder="Description Thai">
                  </div>
                </div>

                <div class="item form-group">
                  <label for="file" class="col-form-label col-md-3 col-sm-3 label-align">Upload File </label>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <input type="file" name="fileUpload" id="fileUpload" class="form-control" required="" accept=".xls,.xlsx,.pdf,.doc,.docx,.ppt,.pptx,.png,.jpg,.jpeg">
                  </div>
                </div>
    					  
                <div class="ln_solid"></div>

                <div class="item form-group">
                  <div class="col-lg-6 col-md-6 col-sm-12 offset-md-3">
    	              <button class="btn btn-primary" type="reset">Reset</button>
                    <input type="submit" id="submitFile" name="createFile" class="show btn btn-success" value="Submit"/>
                  </div>
                </div>

              </form>
    				</div>
    			</div>
        </div>
        <!-- /.container-fluid -->
        <!-- /.container-fluid -->	   
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
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/pnotify.js"></script>
  <script src="js/pnotify.nonblock.js"></script>
<script src="js/file-upload.js"></script>
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