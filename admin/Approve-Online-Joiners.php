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
       <div id="approveonlinejoiner">
                    <?php
                    if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){
                    // echo $_SESSION['msg'];
                    // unset($_SESSION['msg']);
                    ?>
            
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $_SESSION['msg']; ?></strong> &nbsp;
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <?php 
                      unset($_SESSION['msg']);
                    }
                  ?>
                    
                    
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Approve Online Joiners</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">Srl No.</th>
                                            <th style="width:20%">Description</th>
                                            <th style="width:30%">Download</th>
                                            <th style="width:40%" colspan="2">Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <form action="approve-online-joiners/import.php" enctype="multipart/form-data" id="import_form" method="post">
                                                <td> 1 </td>
                                                <td>
                                                    <p style="font-weight: bold; font-size: 14px;">Without Share</p>
                                                </td>
                                                <td>

                                                    <a href="templates/update-shareholder-sample.xlsx" class="btn btn-info btn-sm">
                                                        <i class="fa fa-download" aria-hidden="true"></i> Sample Data
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="upload-btn-wrapper">

                                                        <input type="hidden" name="action" value="update_record">
                                                        <input type="hidden" name="shorting_field" value="" id="after_shorting">
                                                        <button class="btn btn-success btn-sm"><i class="fa fa-file-excel" aria-hidden="true"></i> Select Excel File</button>
                                                        <input type="file" name="uploadFile" id='without_share_file' accept=".xlsx, .xls, .csv" required style="font-size: 20px;" />

                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="upload-btn-wrapper">
                                                        <button type="submit" class="btn-danger btn-sm" disabled id="without_share_btn"><i class="fa fa-upload" aria-hidden="true"></i> Import</button>
                                                    </div>
                                                </td>
                                            </form>
                                        </tr>

                                        <tr>
                                            <form action="approve-online-joiners/with-share-import.php" enctype="multipart/form-data" id="import_form2" method="post">
                                                <td> 2 </td>
                                                <td>
                                                    <p style="font-weight: bold; font-size: 14px;">With Share</p>
                                                </td>
                                                <td>
                                                    <a href="templates/update-shareholder-with-share-sample.xlsx" class="btn btn-info btn-sm">
                                                        <i class="fa fa-download" aria-hidden="true"></i> Sample Data
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="upload-btn-wrapper">

                                                        <input type="hidden" name="action" value="update_record_with_share">
                                                        <input type="hidden" name="shorting_field" value="" id="after_shorting1">
                                                        <button class="btn btn-success btn-sm"><i class="fa fa-file-excel" aria-hidden="true"></i> Select Excel File</button>
                                                        <input type="file" name="uploadFile" id='with_share_file' accept=".xlsx, .xls, .csv" style="font-size: 20px;" required />

                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="upload-btn-wrapper">
                                                        <button type="submit" class="btn-danger btn-sm" disabled id="with_share_btn"><i class="fa fa-upload" aria-hidden="true"></i> Import</button>
                                                    </div>
                                                </td>
                                            </form>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    <script type="text/javascript">
        $(document).ready(
            function() {
                $('#with_share_btn').attr('disabled', true);
                $('#with_share_file').change(
                    function() {
                        if ($(this).val()) {
                            $('#with_share_btn').removeAttr('disabled');
                        } else {
                            $('#with_share_btn').attr('disabled', true);
                        }
                    });
            });
        
        
        $(document).ready(
            function() {
                $('#without_share_btn').attr('disabled', true);
                $('#without_share_file').change(
                    function() {
                        if ($(this).val()) {
                            $('#without_share_btn').removeAttr('disabled');
                        } else {
                            $('#without_share_btn').attr('disabled', true);
                        }
                    });
            });

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