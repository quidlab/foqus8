<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= assets('/assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= assets('/assets/plugins/jquery-easing/jquery.easing.min.js') ?>"> </script>

<!-- Bootstrap -->
<script src="<?= assets('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= assets('/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= assets('/assets/js/adminlte.js') ?>"></script>
<script src="<?= assets('/assets/js/session-timeout.js') ?>"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= assets('/assets/plugins/jquery-mousewheel/jquery.mousewheel.js') ?>"></script>
<script src="<?= assets('/assets/plugins/raphael/raphael.min.js') ?>"></script>
<script src="<?= assets('/assets/plugins/jquery-mapael/jquery.mapael.min.js') ?>"></script>
<script src="<?= assets('/assets/plugins/jquery-mapael/maps/usa_states.min.js') ?>"></script>
<!-- ChartJS -->
<script src="<?= assets('/assets/plugins/chart.js/Chart.min.js') ?>"></script>
<!-- JSGrid -->
<script src="<?= assets('/assets/plugins/jsgrid/jsgrid.min.js') ?>"></script>
<!-- Toastr -->
<script src="<?= assets('/assets/plugins/toastr/toastr.min.js') ?>"></script>

<script src="<?= assets('/assets/plugins/moment/moment.min.js') ?>"></script>
<script src="https://kit.fontawesome.com/4d2395bd18.js" crossorigin="anonymous"></script>

<script src="<?= assets('/assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= assets('/assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src=" https://cdn.jsdelivr.net/npm/gridjs@6.0.6/dist/gridjs.production.min.js "></script>


<script>
  $(document).ajaxSend(function() {
    $('#globalLoading').fadeIn(0);

  });
  $(document).ajaxComplete(function() {
    $('#globalLoading').fadeOut(0);
  })
</script>



<script>
  function changeLanguage(lang) {
    // Replace "lang" cookie with new language
    document.cookie = "lang=" + lang;
    // Get html of current URI and replace page contents.
    $("body").load(window.location.href);
  }

  // Call this to switch to German, for example
</script>



<!-- AdminLTE for demo purposes
<script src="assets/js/demo.js"></script> -->