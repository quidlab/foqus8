<?php
session_start();
$doc_root = $_SERVER["DOCUMENT_ROOT"];
include_once ($doc_root."/admin/inc/main.php");

//echo(MC_SENDGRID_KEY);
	$message='test';
//	reg_replace('/\s\s+/', ' ', $message);
$link=rtrim(MC_AGM_LINK);
use \SendGrid\Mail\Mail;

//$email = new SendGrid\Mail\Mail();
$email = new Mail();
// Replace the email address and name with your verified sender
$email->setFrom("info@quidlab.com","Quidlab");
$email->setSubject("OTP For ADMIN LOGIN");
// Replace the email address and name with your recipient
$email->addTo("kamaldua@quidlab.com","abcd");
$email->addContent("text/plain",$message);
$sendgrid = new \SendGrid(MC_SENDGRID_KEY);
try {
    $response = $sendgrid->send($email);
    printf("Response status: %d\n\n", $response->statusCode());

    $headers = array_filter($response->headers());
    echo "Response Headers\n\n";
    foreach ($headers as $header) {
        echo '- ' . $header . "\n";
    }
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
				
				
				
				//////////////////////////
			
		