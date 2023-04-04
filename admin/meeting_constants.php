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
       <div id="meetingConstantsGrid"></div>
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
<script>
 
    $("#meetingConstantsGrid").jsGrid({
        width: "100%",
     height: "600px",
     editing: true,
	 deleting: false,
     sorting: true,
     paging: true,
     autoload: true,
     pageSize: 10,
     pageButtonCount: 5,
     deleteConfirm: "Do you really want to delete data?",
	 filtering: false ,	
     controller: {
      loadData: function(filter){
       return $.ajax({
        type: "GET",
        url: "fetch_meeting_constants.php",
        data: filter
       });
      },
      insertItem: function(item){
       return $.ajax({
        type: "POST",
        url: "fetch_meeting_constants.php",
        data:item
       });
      },
      updateItem: function(item){
		  
       return $.ajax({
        type: "PUT",
        url: "fetch_meeting_constants.php",
        data: item
       });
      },
      deleteItem: function(item){
		  
       return $.ajax({
        type: "DELETE",
        url: "fetch_meeting_constants.php",
        data: item
       });
      },
     },

     fields: [
	 
      {
    name: "ID",
    type: "text",
	editing: false,
	visible: false,
    width: 10
      },
      {
       name: "Constant_Name", 
	   title: "Constant Name",
    type: "text", 
	editing: false,
    width: 200,
		
    validate: "required"
      },
      {
       name: "Constant_Value",
	title: "Constant Value",
css: "hideoverflow",	
    type: "text", 
    width: 100, 
    validate: "required"
      },
	  {	
       name: "Description",
title: "Description",	   
    type: "text", 
	width: 200,
	editing: false,
	
      },
      {
       type: "control",
	   editButton: true,                               // show edit button
	deleteButton: false,                             // show delete button
 
      }
     ]

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