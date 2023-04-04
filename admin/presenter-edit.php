<?php  
include "inc/main.php";  
if(isset($_SESSION['uname'])){
	if(!isset($_GET['pid'])){
		header('Location: Presenters-list.php');
	}
	else{
		$id = $_GET['pid'];
	}	
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
       <div id="presenter-edit">
       <?php 
				$query1 = "SELECT * FROM presenter WHERE id = '".$id."'";
				$params = array();
				$statement1 = $FoQusdatabase ->Select($query1,$params);
				$count1 =  count($statement1);
				if($count1 > 0)  
				{
				foreach($statement1 as $statement ){
					$fname=$statement['fname'];
					$lname=$statement['lname'];
					$pwd=$statement['pwd'];
					$pid=$statement['pid'];
					$role=$statement['role'];
					$email=$statement['email'];
					$title=$statement['title'];
					$phone=$statement['mobile'];
				}
				}
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
				}}
				$select = implode("", $list);
			?>
<script>alert(<?php echo $select;?>);</script>
<? $luds = "(?=^.{".$cat_check_co_lim.",}$)".$select.".*$";?>	  
<div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Presenter's Update</h1>
			<div class="card shadow mb-4">
				<div class="card-body">
					<form id="presenterEdit" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
						  <select id="title" name="title" required="required" class="form-control">
							<option value="">Select</option>
							<option value="นาย" <?php if($title == 'นาย'){ echo 'selected';}?>>นาย</option>
							<option value="นาง" <?php if($title == 'นาง'){ echo 'selected';}?>>นาง</option>
							<option value="นางสาว" <?php if($title == 'นางสาว'){ echo 'selected';}?>>นางสาว</option>
							<option value="Mr" <?php if($title == 'Mr'){ echo 'selected';}?>>Mr</option>
							<option value="Mrs" <?php if($title == 'Mrs'){ echo 'selected';}?>>Mrs</option>
							<option value="Miss" <?php if($title == 'Miss'){ echo 'selected';}?>>Miss</option>
							<option value=" " <?php if($title == ' '){ echo 'selected';}?>> </option>
						  </select>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="fname">First Name <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="fname" name="fname" required="required" class="form-control" value="<?php if($fname != ''){ echo $fname;}?>">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="lname">Last Name <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="lname" name="lname" required="required" class="form-control" value="<?php if($lname != ''){ echo $lname;}?>">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="email" name="email" required="required" class="form-control" value="<?php if($email != ''){ echo $email;}?>">
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
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="uuid">User Name <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="text" id="uuid" name="uuid" required="required" class="form-control" value="<?php if($pid != ''){ echo $pid;}?>">
                        </div>
                      </div>
					  
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="role">Role <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <select id="role" name="role" required="required" class="form-control">
							<option value="">Select</option>
							<option value="Chairperson" <?php if($role == 'Chairperson'){ echo 'selected';}?>>Chairperson</option>
							<option value="Director" <?php if($role == 'Director'){ echo 'selected';}?>>Director</option>
							<option value="Company Secretary" <?php if($role == 'Company Secretary'){ echo 'selected';}?>>Company Secretary</option>
							<option value="Other" <?php if($role == 'Other'){ echo 'selected';}?>>Other</option>
						  </select>
                        </div>
                      </div>
					  <div class="item form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="hidden" id="preid" name="preid" required="required" class="form-control" value="<?php if($id != ''){ echo $id;}?>">
                        </div>
                      </div>
					  
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pass">Password <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="password" id="pass" name="pass" required="required" class="form-control" pattern="<?echo $luds;?>" autocomplete="off" value="<?php if($pwd != ''){ echo $pwd;}?>" placeholder="<?php echo $cat_check_co_pass.'-'.$cat_check_co_lim;?>">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpass">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                          <input type="password" id="cpass" name="cpass" required="required" class="form-control" autocomplete="off" value="<?php if($pwd != ''){ echo $pwd;}?>">
                        </div>
                      </div>
					  <div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch">
					  
                      <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 offset-md-3">
						  <button class="btn btn-primary" type="reset">Reset</button>
                          <input type="submit" id="editPresenter" name="submit-event" class="show btn btn-success" value="Update"/>
                        </div>
                      </div>
                    </form>
				</div>
			</div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->	   
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
<script>
    function checkPasswordMatch() {
        var password = $("#pass").val();
        var confirmPassword = $("#cpass").val();
        if (password != confirmPassword)
            //$("#CheckPasswordMatch").html("Passwords does not match!");
			$('#editPresenter').hide();
        else
            //$("#CheckPasswordMatch").html("Passwords match.");
			$('#editPresenter').show();
    }
    $(document).ready(function () {
       $("#cpass").keyup(checkPasswordMatch);
    });
    </script>
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