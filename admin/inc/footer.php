<!-- Main Footer -->
  <footer class="main-footer" style="padding:5px;">
    Copyright &copy; <a href="https://quidlab.com">Quidlab FoQus</a>.
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0
    </div>
  </footer>

</div>

  
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script src="../assets/plugins/jquery-easing/jquery.easing.min.js"> </script>

<!-- Bootstrap -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/js/adminlte.js"></script>
<script src="../assets/js/session-timeout.js"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../assets/plugins/raphael/raphael.min.js"></script>
<script src="../assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<!-- JSGrid -->
<script src="../assets/plugins/jsgrid/jsgrid.min.js"></script>
<!-- Toastr -->
<script src="../assets/plugins/toastr/toastr.min.js"></script>
 <script>
      sessionTimeout({
        warnAfter: <?  echo (constant('MC_SESSION_TIMEOUT_WARNING_SECONDS')*1000);   ?>,
        logOutUrl: '/logged-out.php',
        keepAliveUrl: '/index.php',
		logOutUrl: "/logout.php",
		timeOutUrl: "/logout.php",
		timeOutAfter: <? echo (constant('MC_SESSION_TIMEOUT_SECONDS') *1000);   ?>
		//message: 'This is a custom message. You are about to be logged out.',
      });
    </script>
	<script src="../assets/plugins/moment/moment.min.js"></script>
	<script src="https://kit.fontawesome.com/4d2395bd18.js" crossorigin="anonymous"></script>
	
  <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>


	
<!-- AdminLTE for demo purposes
<script src="assets/js/demo.js"></script> -->
