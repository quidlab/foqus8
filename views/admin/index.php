<?php include __DIR__ . "/../layouts/meta.php"; ?>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div id="globalLoading" class="global-loading"><i id="loading" class="fas fa-2x fa-circle-notch fa-spin"></i></div>
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
<script>
  let alertTime = <?= constant('MC_SESSION_TIMEOUT_WARNING_SECONDS') ?>;
  <?
  $time = substr((((int)constant("MC_SESSION_TIMEOUT_SECONDS") - (int)constant("MC_SESSION_TIMEOUT_WARNING_SECONDS")) / 60), 0, 4) . " min"
  ?>

  let message = <?= "'" . __('session-timeout-warning', [
                  'time' =>  $alertTime 
                ]) . "'" ?>;

  setTimeout(() => {
    alert(message);
  }, time * 1000);
</script>

</html>