<?php
session_start(); 
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$_SESSION['progress_content']="wait";

function send_message($event, $message, $progress = 1) {
    $d = array('message' => $message, 'progress' => $progress);

    echo "event: $event" . PHP_EOL;
    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;

    ob_flush();
    flush();
}

if(!isset($_SESSION['uname'])){ die();}
//sleep(1);
session_write_close();
//sleep(1);


// get contents of a file into a string

//$filename = "progress.txt";
$i=0;
Start: 
$i++;
//sleep(1);
//$handle = fopen($filename, "r");
//$contents = fread($handle, 100);
//$_SESSION['progress_content']='progress';
$contents='close';
//session_start();
$contents = $_SESSION['progress_content'];
//echo($contents);
//session_write_close();
//session_start();
//fclose($handle);

if ($contents == 'close'  ){ send_message('close', 'Process complete');  } else { send_message('progress', "$contents" );sleep(2);  goto Start ;}
//if ($contents == 'close'  ){ send_message('close', 'Process complete');  } else { send_message('progress', "$i" );sleep(2);  goto Start ;}
//send_message('close', 'Process complete');
//if ( connection_aborted() ) break;
//break;
//unlink("progress.txt");
//sleep(10);
//$filename = "progress.txt";
//$f=fopen('progress.txt','w');
//fwrite($f,'Wait');
//fclose($f);
//send_message('close', 'Process complete');
/* session_start();
$_SESSION['progress_content'] = 'close'; 
session_write_close(); */




?>



