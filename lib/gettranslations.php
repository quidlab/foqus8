<?php 
if (!isset($_GET['lang'])){$lang='en';  } else {$lang= $_GET['lang']; }
if (!in_array($lang,['en','th'])) {
    $lang = 'en';
}
$sql= "select ID,Tname,Tvalue from Translations where Tlang =?";
$params=array($lang);
$translations = $FoQusdatabase->Select($sql,$params);
if ($translations) { // added by mostafa
    foreach($translations as $translation){
        define('TR_'.$translation['Tname'],$translation['Tvalue']);
    }
}else{
    echo "Translation Loader faild <br/>";
    die( print_r( sqlsrv_errors(), true));
}
