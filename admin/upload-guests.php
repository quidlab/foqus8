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
       <div id="Upload-Guest">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Upload Guests</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form id="presentersTable" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" action="upload-guests-action.php">
                                <input type="hidden" name="action" value="upload_guests">
                                <div class="item form-group">
                                    <label for="file" class="col-form-label col-md-3 col-sm-3 label-align">Upload File </label>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input type="file" name="fileUpload" id="fileUpload" class="form-control" required="" accept=".xls,.xlsx,.csv">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-12 offset-md-3">
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <input type="submit" id="submitFile" name="createFile" class="show btn btn-success" value="Submit" />
                                    </div>
                                </div>
                            </form>
                        </div>
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
