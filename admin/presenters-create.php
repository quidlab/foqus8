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
       <?php
				$sql="SELECT min_pass_len, password_complexity from Co_info WHERE ID='1'";
				$params2 = array();
				$cat_data_co= $FoQusdatabase ->Select($sql,$params2);
                $cat_check_co= count($cat_data_co);
				
				if($cat_data_co){
				$cat_check_co_lim = $cat_check_co['min_pass_len'];
				$cat_check_co_pass = $cat_check_co['password_complexity'];
				$breakComplexity = explode(",", $cat_check_co_pass);
				foreach($breakComplexity as $code){
					if($code == "l"){
						$pc = "(?=.*[a-z])";
					}
					else if($code == "u"){
						
						$pc = "(?=.*[A-Z])";
						
					}
					else if($code == "d"){
						
						$pc = "(?=.*\d)";
						
					}
					else if($code == "s"){
						
						$pc = "(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s)";
					}
					$list[] = $pc;
				}
				$select = implode("", $list);
				}
				?><script>alert(<?php echo $select;?>);</script><?
				//$luds = "(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s).*$";
				//$luds = $select.".*$";
				$luds = "(?=^.{".$cat_check_co_lim.",}$)".$select.".*$";
				
            ?>		
       <div id="preenters-create">
          <h1 class="h3 mb-4 text-gray-800">Presenter's Create</h1>
			<div class="card shadow mb-4">
				<div class="card-body">
					<form id="presenterCreate" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
						  <select id="title" name="title" required="required" class="form-control">
							<option value="">Select</option>
							<option value="นาย">นาย</option>
							<option value="นาง">นาง</option>
							<option value="นางสาว">นางสาว</option>
							<option value="Mr">Mr</option>
							<option value="Mrs">Mrs</option>
							<option value="Miss">Miss</option>
							<option value=" "> </option>
						  </select>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="fname">First Name <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="fname" name="fname" required="required" class="form-control ">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="lname">Last Name <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="lname" name="lname" required="required" class="form-control">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="email" name="email" required="required" class="form-control">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone">Phone <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="phone" name="phone" required="required" class="form-control" value="<?php if($phone != ''){ echo $phone;}?>">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="uid">User Name <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="uid" name="uid" required="required" class="form-control">
                        </div>
                      </div>
					  
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="role">Role <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <select id="role" name="role" required="required" class="form-control">
							<option value="">Select</option>
							<option value="Chairperson">Chairperson</option>
							<option value="Director">Director</option>
							<option value="Company Secretary">Company Secretary</option>
							<option value="Other">Other</option>
						  </select>
                        </div>
                      </div>
					  
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pass">Password <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="password" id="pass" name="pass" required="required" class="form-control" pattern="<?echo $luds;?>" autocomplete="off" placeholder="<?php echo $cat_check_co_pass.'-'.$cat_check_co_lim;?>">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpass">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="password" id="cpass" name="cpass" required="required" class="form-control" autocomplete="off">
                        </div>
                      </div>
					  <div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch"></div>
					  <!--
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="dob">Date of Birth <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="date" id="dob" name="dob" required="required" class="form-control">
                        </div>
                      </div>
					  -->
					  
					  
                      <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 offset-md-3">
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <input type="submit" id="submitPresenter" name="submit-event" class="show btn btn-success" value="Submit"/>
                        </div>
                      </div>
                    </form>
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
<script src="js/custom.js"></script>
  <script>
    function checkPasswordMatch() {
        var password = $("#pass").val();
        var confirmPassword = $("#cpass").val();
        if (password != confirmPassword)
            //$("#CheckPasswordMatch").html("Passwords does not match!");
			$('#submitPresenter').hide();
        else
            //$("#CheckPasswordMatch").html("Passwords match.");
			$('#submitPresenter').show();
    }
    $(document).ready(function () {
       $("#cpass").keyup(checkPasswordMatch);
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