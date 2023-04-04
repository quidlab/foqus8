<?php
session_start();
$doc_root = $_SERVER["DOCUMENT_ROOT"];
include_once ($doc_root."/admin/inc/main.php");
use \SendGrid\Mail\Mail;	
$link=rtrim(MC_AGM_LINK);
if(!isset($_SESSION['uname'])){
	if(isset($_SESSION['loginId'])){
		$loginId = $_SESSION['loginId'];
		if(!isset($_SESSION['otp'])){

			$_SESSION['var']=0;
			$otp_gen=substr(str_shuffle('1234567890'),1,6);
			$ref_gen=substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWZY'),1,6);
			$message='OTP for ' . MC_SYMBOL . ' Expire 5 Minutes OTP: '.$otp_gen .' (REF :'.$ref_gen .')';
			if ( MC_REQUIRE_EMAIL_OTP == true ) {
			


$email = new Mail();
$email->setFrom("info@quidlab.com","Quidlab");
$email->setSubject("OTP For ADMIN LOGIN");
$email->addTo($loginId,"abcd");
$email->addContent("text/plain",$message);
$sendgrid = new \SendGrid(MC_SENDGRID_KEY);
try {
    $response = $sendgrid->send($email);
/*     printf("Response status: %d\n\n", $response->statusCode());

    $headers = array_filter($response->headers());
    echo "Response Headers\n\n";
    foreach ($headers as $header) {
        echo '- ' . $header . "\n";
    } */
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
			
		

			}
			// oTP for mobile
			if ( MC_REQUIRE_PHONE_OTP == true) {
				
				require_once "../thaibulksms-api/sms.php";

				$apiKey = '19QHezxEEjPkNWHTflAvJKsx2-2C4L';
				$apiSecretKey = 'WOzofOXa5rSkPfpP6RzF4WGFK6PH7y';

				$sms = new \THAIBULKSMS_API\SMS\SMS($apiKey, $apiSecretKey); 
				//$message='OTP for '.$FetchInfo['SYMBOL'] .' Expire 5 Minutes OTP: '.$otp_gen .'(REF :'.$ref_gen .')';
				$body = [
					'msisdn' => $_SESSION['usermobile'],
					'message' => $message ,
					'sender' => 'QUIDLAB',
					'force' => 'corporate'
					// 'scheduled_delivery' => '',
					// 'force' => ''
				];
				$res = $sms->sendSMS($body);

				if ($res->httpStatusCode == 201) {
					//echo "Succes";
					//var_dump($res);
					$OTP_Phone_Success = 'OTP Sent Successfully on Phone ending with ' . substr($_SESSION['usermobile'], -4);
				} else {
					//echo "Error";
					//var_dump($res);
					$OTP_Phone_Success = 'Error Sending OTP on Phone';
				}
			
			
		
			}
			
			
			$_SESSION['otp']=$otp_gen;
			$_SESSION['ref_gen']=$ref_gen;

	// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';		
			
		}
	//
?>
<? include "inc/meta.php"; ?>

<body class="hold-transition dark-mode login-page">
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h2 class="h4 text-gray-900 mb-4"> <? if ( MC_REQUIRE_EMAIL_OTP==true){ echo('OTP sent on Email!');} ?> </h2>
					<h2 class="h4 text-gray-900 mb-4"> <? if ( MC_REQUIRE_PHONE_OTP==true){ echo($OTP_Phone_Success);} ?> </h2>
					<h2 class="h4 text-gray-900 mb-4"> <? //echo("Enter OTP For Ref: $_SESSION['ref_gen']);" ?> </h2>
                  </div>
                  
				  <form class="user" action="" method="POST">
					<div class="form-group">
                      <input type="text" class="form-control form-control-user" name="otp" placeholder="Enter OTP" required="required">
                    </div>
					
					<input type="submit" class="btn btn-primary btn-user btn-block" name="submit_otp" value="Confirm">
                  </form>
				  
                  <hr>
                  <div class="text-center">
             <!--       <a class="small" href="forgot-password.php">Forgot Password?</a> -->
                  </div>
				  <?php
					//after submit otp value
					if(isset($_POST['submit_otp']) && isset($_POST['otp'])){
						 $input_otp = $_POST['otp'];
						$input_otp = trim($input_otp);
						if($_SESSION['otp'] == $input_otp){
							 $selectUser2="SELECT top(1) * from Users where email=? ";
							 $params=array($_SESSION['loginId']);
							 $fetchUser2=$FoQusdatabase ->Select($selectUser2,$params);
							// print_r($fetchUser2);
							$_SESSION['uname']=$fetchUser2[0]['USER_ID'];
							$_SESSION['ROLE_ID']=$fetchUser2[0]['Role_ID'];
							$_SESSION['email']=$fetchUser2[0]['email'];
							unset($_SESSION['loginId']);
							unset($_SESSION['otp']);
							unset($_SESSION['ref_gen']);  
							?>
						<div class="text-center alert alert-success mt-5" role="alert">
							Login Success.
						</div>
						<script>
							window.location.href="index.php";
						</script>
						<?php
						}
						else{
							//if ( !isset($_SESSION['var']) ) { $_SESSION['var']=0); };
							$_SESSION['var']=$_SESSION['var']+1;
							if($_SESSION['var'] > '3'){
								unset($_SESSION['var']);
								unset($_SESSION['loginId']);
								unset($_SESSION['otp']);
								unset($_SESSION['ref_gen']);
								?>
								<script>
									window.location.href="login.php";
								</script>
								<?php
							}
						?>
						<div class="text-center alert alert-danger mt-5" role="alert">
							Please enter correct OTP.
						</div>
						<?php 
							
						}
					}
				  ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>


  
  <script>
	var myVar;
	//console.log(<?php echo $_SESSION['otp'];?>);
	
	myVar = setTimeout(alertFunc, 300000);

	function alertFunc(){
	  window.location.href="login.php";
	}
  </script>
  <?php include "inc/footer.php"; ?>
</body>

</html>
<?php 
	}
	else{
		?>
	<script>
		window.location.href="login.php"; 
	</script>
		<?php
	}
}
else{
	?>
	<script>
		window.location.href="index.php"; 
	</script>
	<?php
}
?>	