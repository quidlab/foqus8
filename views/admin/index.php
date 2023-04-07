<?php include __DIR__."/../layouts/meta.php"; ?>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <!-- Logout Modal-->

<div class="wrapper">
<?php include __DIR__."/../layouts/preloader.php"; ?>
<?php include __DIR__."/../layouts/popuplogout.php"; ?>
<?php include __DIR__."/../layouts/nav.php"; ?>
<?php include __DIR__."/../layouts/sidebar.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <?php include 'dashboard.php'; ?>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <?php include __DIR__."/../layouts/footer.php"; ?>
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