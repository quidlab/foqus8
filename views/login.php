<?php                  
include "layouts/meta.php";
?>

<body class=" hold-transition dark-mode login-page">
<div>
<!-- <nav class="main-header navbar navbar-expand navbar-dark text-center"> -->

<!--	 </nav> -->
</div>
<div>
<h3 class="text-center"><? echo $company_name[0]['Company_Name'] ?></h3>
<h3 class="text-center"><? echo $company_name[0]['Meeting_Place'] ?><h3>
</div>
<div>

</div>

<div class="login-box ">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h1><b>FoQus </b>Admin</h1>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="User Name" required="required" name="loginID">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" required="required" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
		  <ul class="navbar-nav ">
<li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <!--  <i class="flag-icon flag-icon-us"></i> -->
		<i class="fas fa-language fa-2x"></i>
        </a>
		<div class="dropdown-menu dropdown-menu-right p-0">
            <?=  $languagesHTML ?>

        </div>
      </li>
</ul>
          <!--  <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> -->
          </div>
		  
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<?php
					//$use_otp_email='N';$use_otp_phone='N';
					if(isset($_POST['submit'])){
						//$sql="SELECT * from Users where USER_ID=? and Role_ID=? ";
						//$params = array($_POST['loginID'],'1');
						$sql="SELECT * from Users where USER_ID=?  ";
						$params = array($_POST['loginID']);
						$getUser=$FoQusdatabase ->Select($sql,$params);
						
						if($getUser){ 
							$hash=$getUser[0]['Password'];
							$input=$_POST['password'];
							if(MC_REQUIRE_PHONE_OTP == false && MC_REQUIRE_EMAIL_OTP == false){
								if(password_verify($input, $hash)) {	
								$_SESSION['uname']=$getUser[0]['USER_ID'];
								$_SESSION['ROLE_ID']=$getUser[0]['Role_ID']; 
					?>
							<script>
								window.location.href="index.php";
								//$("body").load(index.php);
							</script>
					<?php
								}
								else{
					?>
					<!--	<div class="text-center alert alert-danger mt-5" role="alert">
							Please enter correct password.
						</div> -->
						<script type="module"> ShowError("Check your password") </script>
					<?php 	
								}
							}
							else{ 
							if(password_verify($input, $hash)) {
							$_SESSION['loginId'] = $getUser[0]['email'];
							$_SESSION['usermobile'] = $getUser[0]['mobile'];
								?>
								<script>
									window.location.href="otp-verify.php";
								</script>
								<?php
							} else {  ?>  <script type="module"> ShowError("Please enter correct details") </script> <?   }								
							}
						}	
						else{
					?>
						
					<!--	<div class="text-center alert alert-danger mt-5" role="alert">
							Please enter correct details.
						</div> -->
						<script type="module"> ShowError("Please enter correct details") </script>
					<?php 
						}
					}
					?>
						





<div>
<!--BANK-->			  
<div class="col-12 text-center" ><p>©<?php echo date('Y');?> <? echo getenv("REGION_NAME");  ?></p>   </div>				
<div class="col-12 text-center" ><a style = "color:black;" href="https://quidlab.com/img/Privacy_policy.pdf" target="blank">นโยบายความเป็นส่วนตัว นโยบายการคุ้มครองข้อมูลและเงื่อนไขการใช้งานของระบบ <br>Quidlab Privacy Policy, Data Protection Policy & Terms of use </a></div>
<div class="col-12 text-center" ><a style = "color:black;" href="https://quidlab.com/img/security_policy.pdf" target="blank">นโยบายความปลอดภัยของข้อมูล Quidlab <br>Quidlab Information Security Management Policy</a></div>
<!--BANK-->	
<div class="col-12 text-center" >

</div>
</div>
</div>
<?php include "layouts/footer.php"; ?>


<script>
function changeLanguage(lang){
    // Replace "lang" cookie with new language
    document.cookie = "lang="+lang;
    // Get html of current URI and replace page contents.
    $("body").load(window.location.href);
}
function ShowError(msg){
   toastr.error(msg);
}
function ShowSuccess(msg){
   toastr.success(msg);
}
// Call this to switch to German, for example

function getCookie(lang) {
  var match = document.cookie.match(new RegExp('(^| )' + lang + '=([^;]+)'));
  if (match) return match[2];
}



</script>
</body>
</html>
