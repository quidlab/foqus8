<?php include __DIR__ . "/../layouts/meta.php"; ?>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <!-- Logout Modal-->

  <div class="wrapper">
    <?php include __DIR__ . "/../layouts/preloader.php"; ?>
    <?php include __DIR__ . "/../layouts/popuplogout.php"; ?>
    <?php include __DIR__ . "/../layouts/nav.php"; ?>
    <?php include __DIR__ . "/../layouts/sidebar.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?php include __DIR__ . "/../layouts/company_name_header.php"; ?> <!-- Page Header -->
      <section class="content">


        <?php include $slot; ?> <!-- Page Content -->
      </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->


</body>

</html>