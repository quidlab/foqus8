<?php 
session_start();
include "inc/main.php";
$_SESSION['uname']='mostafa';
$_SESSION['ROLE_ID']=1;
if(isset($_SESSION['uname'])){

?>
<?php include "inc/meta.php"; ?>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <!-- Logout Modal-->

<div class="wrapper">
<?php include "inc/preloader.php"; ?>
<?php include "inc/popuplogout.php"; ?>
<?php include "inc/nav.php"; ?>
<?php include "inc/sidebar.php"; ?>
  <!-- Content Wrapper. Contains page content -->
<?php include "dashboard.php"; ?>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <?php include "inc/footer.php"; ?>
<script>
function changeLanguage(lang){
    // Replace "lang" cookie with new language
    document.cookie = "lang="+lang;
    // Get html of current URI and replace page contents.
    $("body").load(window.location.href);
}

// Call this to switch to German, for example

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