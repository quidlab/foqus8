<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quidlab paper</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <script src="https://kit.fontawesome.com/4d2395bd18.js" crossorigin="anonymous"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"> </script>

<!-- ADD styles -->
  <style>

  h6{
    font-size: 14px;
  }
  h5{
    font-size: 15px;
    line-height: auto;
  }
  p, h6,h5{
    margin-block-start: 0;
    margin-block-end: 0;
  }

  hr{
    margin: 0;
  }

  body{
    margin: 50px;
  }
  .container_first{
    height: 135px;
	
  }
  .head-height{
    height: 90px;
    overflow: visible;
  }
  .box-height{
    height:440px ;
	overflow: visible;
    border: .5px solid grey;
    padding: 1px;
    margin: 5px;
    max-width: calc(50% - 10px);
	display: inline-block;
  }
  .row{
    margin: 1px;
  }
  header{
    padding-top: 2px;
  }
  .flex_box{
    margin: 5px 0 0 0;
    display: flex;
    text-align: center;
  }
  .center{
    text-align: center;
  }
  .flex_box_space{
    display: flex;
    justify-content: space-between;
    line-height: auto;
  }
  .txt_box{
    width:150px;
    height: 25px;
    border: .5px solid black;
    margin: 0 3px;
  }

  .flex-direction-column{
    flex-direction: column;
  }

  .agenda_nr{
    font-size: 80px;
    color: #dfd8d8;
    position: absolute;
    z-index: -1;
    text-align: right;
    top: 9%;
    right: 2%;
  }

/* --------- BOX TO HIDE ---------- */
  .hide_box{
  }


/* ----------MEDIA start ---------------*/

    @media print {
      @page {
        size: 210mm 297mm;
         margin: 14mm 14mm 12mm 14mm;
		 transform: scale(1);
		transform-origin: 0 0;
      }
      body{
        margin: 0;
      }
      .box-height{
        padding-top: 0mm;
        height:119mm ;
        overflow: visible;
      }
      .box-height {
        padding: 3mm;
      }
      .head-height{
        height: 24mm;
        overflow: visible;
      }
      .flex_box_space{
        line-height: 5mm;
      }
      .txt_box{
        width:25mm;
      }

    }
  /*---------MEDIA finish --------------*/

  </style>
<script>
//var i=14;

var currentdate = new Date(); 
var datetime = currentdate.getDate()  + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
function AddAgenda(i,agenda_id,agenda_eng,agenda_thai,barcode1,barcode2,barcode3,ProxyType){
//	alert(i);
var header=1;
var agendaprinted = 0;
//var headerhtml='<header id="header' +header+'" class="row head-height"><div class="col-2"><img src="https://quidlab.com/img/logo/logoQ_120.png" alt="Logo"></div><div class="col-10 "><b>Company name Eng</b><br><b>Company name Thai</b><br><h6>Info Eng<br>Info Thai</h6></div></header><div class="wrapper"><section><div id="page1" "class="row"></div></section></div>';
var headerhtml='<header id="header' +header+'"class="row head-height"><div class="col-2"><img src="https://quidlab.com/img/logo/logoQ_120.png" alt="Logo"></div><div class="col-10 "><b>'+Company_Name_Thai+'</b><br><b>'+Company_Name_Eng+'</b><br><h6>'+AGM_ADD_THAI+'<br>'+AGM_ADD_ENG+'</h6></div></header><div class="wrapper"><section><div id="page1" class="row"></div></section></div>';
var headerhtml1='';
//var agendabox='<div class="col-6  box-height"><div class="container_first"><h6><b></b></h6><h6><b></b></h6></div><hr><div><h5 class="font-weight-bold" id="shareholder_name">Name Name</h5><h5>TXT No. of Shares จำนวนหุน้ที่ลงคะแนน: <span id="shares_nr" class="font-weight-bold">100,000,000,000</span> หุน้ shares</h5></div><hr><div class="flex_box"><h5><i class="fa-regular fa-square"></i> เห็นดว้ย Approve<svg id="barcode1"></svg></h5><h5><i class="fa-regular fa-square"></i> ไม่เห็นดว้ย Disapprove<svg id="barcode1"></svg></h5></div><div class="center"><h5><i class="fa-regular fa-square"></i> งดออกเสียง Abstain</h5><svg id="barcode1"></svg></div><hr><h6>กรณีทผี ูถื้อหุน้ ไม่ลงคะแนนในช่องใด ๆ จะถือว่าเห็นดว้ ยในวาระนัน ๆกรุณาคืนบัตรลงคะแนนทุกครัง ก่อนออกจากหอ้ง</h6><div class="flex_box_space"><h6>Signature:__________________</h6><h6>16/6/2563 / 7:40:45</h6></div></div>';
//var agendabox='<div class="col-6  box-height"><div class="container_first"><h6><b>'+agenda_thai+'</b></h6><h6><b>'+agenda_eng+'</b></h6></div><hr><div><h5 class="font-weight-bold" id="shareholder_name">Name Name</h5><h5>TXT No. of Shares จำนวนหุน้ที่ลงคะแนน: <span id="shares_nr" class="font-weight-bold">100,000,000,000</span> หุน้ shares</h5></div><hr><div class="flex_box"><h5><i class="fa-regular fa-square"></i> เห็นดว้ย Approve<svg id="barcode1"></svg></h5><h5><i class="fa-regular fa-square"></i> ไม่เห็นดว้ย Disapprove<svg id="barcode1"></svg></h5></div><div class="center"><h5><i class="fa-regular fa-square"></i> งดออกเสียง Abstain</h5><svg id="barcode1"></svg></div><hr><h6>กรณีทผี ูถื้อหุน้ ไม่ลงคะแนนในช่องใด ๆ จะถือว่าเห็นดว้ ยในวาระนัน ๆกรุณาคืนบัตรลงคะแนนทุกครัง ก่อนออกจากหอ้ง</h6><div class="flex_box_space"><h6>Signature:__________________</h6><h6>16/6/2563 / 7:40:45</h6></div></div>';
if (ProxyType!='C'){
var agendabox='<div class="col-6 box-height"><div class="container_first"><h6><b>'+agenda_thai+'</b></h6><h6><b>'+agenda_eng+'</b></h6></div><hr><div><h5 class="font-weight-bold" id="shareholder_name">'+SHName+'</h5><h5>Shares attended จำนวนหุน้ที่ลงคะแนน: <span id="shares_nr" class="font-weight-bold">'+Shares_Attended+'</span> หุน้  shares</h5></div><hr><div class="agenda_nr">'+agenda_id+'</div><div class="d-flex align-items-center"><div class="col-4"><h5><i class="fa-regular fa-square"></i>เห็นดว้ย Approve</h5></div><div class="col"><svg id="'+barcode1+'"></svg></div></div><div class="d-flex align-items-center"><div class="col-4"><h5><i class="fa-regular fa-square"></i>ไม่เห็นดว้ย Disapprove</h5></div><div class="col"><svg id="'+barcode2+'"></svg></div></div><div class="d-flex align-items-center"><div class="col-4"><h5><i class="fa-regular fa-square"></i>งดออกเสียง Abstain</h5></div><div class="col"><svg id="'+barcode3+'"></svg></div></div><hr><h6>กรณีทผี ูถื้อหุน้ ไม่ลงคะแนนในช่องใด ๆ จะถือว่าเห็นดว้ ยในวาระนัน ๆกรุณาคืนบัตรลงคะแนนทุกครัง ก่อนออกจากหอ้ง</h6><div class="flex_box_space"><h6>Signature:_____________________________</h6><h6>'+datetime+'</h6><h6># <span>'+BallotSerial+'</span></div></div>';
}
else {
var agendabox='<div class="col-6 box-height"><div class="container_first"><h6><b>'+agenda_thai+'</b></h6><h6><b>'+agenda_eng+'</b></h6></div><hr><div><h5 class="font-weight-bold" id="shareholder_name">'+SHName+'</h5><h5>Shares attended จำนวนหุน้ที่ลงคะแนน: <span id="shares_nr" class="font-weight-bold">'+Shares_Attended+'</span> หุน้  shares</h5></div><hr><div class="agenda_nr">'+agenda_id+'</div><div class="d-flex align-items-center"><div class="col-4"><h5><i class="fa-regular fa-square"></i>เห็นดว้ย Approve</h5></div><div class="col hide_box"><div class="txt_box"></div></div><div class="col"><svg id="'+barcode1+'"></svg></div></div><div class="d-flex align-items-center"><div class="col-4"><h5><i class="fa-regular fa-square"></i>ไม่เห็นดว้ย Disapprove</h5></div><div class="col"><svg id="'+barcode2+'"></svg></div><div class="col hide_box"><div class="txt_box"></div></div></div><div class="d-flex align-items-center"><div class="col-4"><h5><i class="fa-regular fa-square"></i>งดออกเสียง Abstain</h5></div><div class="col"><div class="txt_box hide_box"></div></div><div class="col"><svg id="'+barcode3+'"></svg></div></div><hr><h6>กรณีทผี ูถื้อหุน้ ไม่ลงคะแนนในช่องใด ๆ จะถือว่าเห็นดว้ ยในวาระนัน ๆกรุณาคืนบัตรลงคะแนนทุกครัง ก่อนออกจากหอ้ง</h6><div class="flex_box_space"><h6>Signature:_____________________________</h6><h6>'+datetime+'</h6><h6># <span>'+BallotSerial+'</span></div></div>';	
}
//for (let j=0; j<=i; j++){
if ((i % 6) ==0 ) { 
jQuery('body').append(headerhtml,agendabox); 

//jQuery('#page1').append(agendabox);
} 
else { jQuery('body').append(agendabox); }

//}
var barcodeid1= document.getElementById(barcode1);
var barcodeid2= document.getElementById(barcode2);
var barcodeid3= document.getElementById(barcode3);

JsBarcode(barcodeid1, barcode1, {width: 1.5,  height: 32, fontSize: 14, displayValue: true });
JsBarcode(barcodeid2, barcode2, {width: 1.5,  height: 32, fontSize: 14, displayValue: true });
JsBarcode(barcodeid3, barcode3, {width: 1.5,  height: 32, fontSize: 14, displayValue: true });

}
</script>
<script>

//window.addEventListener("load", JsBarcode("#barcode1", "012547858", {width: 1,  height: 20, fontSize: 8, displayValue: true }) );
window.addEventListener("load", window.print());
</script>
</head>



<body>

<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'connect.php'; 
$query_coinfo="Select Company_Name_Eng,Company_Name_Thai,AGM_ADD_ENG,AGM_ADD_THAI from Co_info";
$coInfo_result = sqlsrv_query($conn, $query_coinfo);
while($Company=sqlsrv_fetch_array($coInfo_result, SQLSRV_FETCH_ASSOC)){
$Company_Name_Eng=$Company['Company_Name_Eng'];
$Company_Name_Thai=$Company['Company_Name_Thai'];
$AGM_ADD_ENG=$Company['AGM_ADD_ENG'];
$AGM_ADD_THAI=$Company['AGM_ADD_THAI'];
?>

<script>
var Company_Name_Eng="<? echo $Company_Name_Eng; ?>";
var Company_Name_Thai="<? echo $Company_Name_Thai; ?>";
var AGM_ADD_ENG="<? echo $AGM_ADD_ENG; ?>";
var AGM_ADD_THAI="<? echo $AGM_ADD_THAI; ?>";

</script>
<?
}

$siholder = $_REQUEST['siholder'];
$query_EGM = "SELECT ID,n_title,n_first,n_last,Shares_Attended,serial,Proxy_name,ProxyType FROM EGM WHERE i_holder = '".$siholder."' ORDER BY ID";
$result1 = sqlsrv_query($conn, $query_EGM);
//$SHName=[];
while($getSH=sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)){
$SHName=$getSH['n_title'].' '.$getSH['n_first'].' '.$getSH['n_last']; 
$Shares_Attended=$getSH['Shares_Attended'];
//$ApproveBarCode='1'.$getSH['ID'].;
$SHQuidID=$getSH['ID'];
$BallotSerial=$getSH['serial'];
$ProxyType=$getSH['ProxyType'];
?>

<script>
var SHName="<? echo $SHName; ?>";
SHName=SHName.substring(0,44);
var Shares_Attended="<? echo number_format($Shares_Attended); ?>";
var BallotSerial="<? echo $BallotSerial; ?>";
var ProxyType="<? echo $ProxyType; ?>";
</script>
<?
}

$query_agenda = "select * from AGENDAS  where Agenda_Completed='N' order by ID";
$result2 = sqlsrv_query($conn, $query_agenda);
$i=0;
while($getAgendas=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)){
//	for($i=1; $i<=$TotalAgendas; $i++){	
	$AgendaID=$getAgendas['ID'];
	$agenda_id = $getAgendas['AGENDA_ID'];
	$agenda_eng=$getAgendas['AGENDA_Name'];
	
	$agenda_eng = str_replace(array("\r", "\n"), '<br/>', $agenda_eng);
	$agenda_thai=$getAgendas['Agenda_Name_Thai'];
	$agenda_thai = str_replace(array("\r", "\n"), '<br/>', $agenda_thai);

?>  
<script type='module'>
var i=<? echo($i); ?>;
var agenda_id="<? echo $agenda_id; ?>";
var agenda_eng="<? echo $agenda_eng; ?>";
//agenda_eng=  agenda_eng.replace(/[\n\r]+\-/g, "<br/>-");
var agenda_thai="<? echo $agenda_thai; ?>";
//agenda_thai=  agenda_thai.replace(/[\n\r]+\-/g, "<br/>-");
var barcode1="<? echo ('1'.$SHQuidID.$AgendaID); ?>"
var barcode2="<? echo ('2'.$SHQuidID.$AgendaID); ?>"
var barcode3="<? echo ('3'.$SHQuidID.$AgendaID); ?>"
AddAgenda(i,agenda_id,agenda_eng,agenda_thai,barcode1,barcode2,barcode3,ProxyType);
/* if (ProxyType!='C'){ 
var BoxToHide = document.getElementsByClassName("txt_box"); //divsToHide is an array
    for(var b = 0; b < BoxToHide.length; i++){
       // divsToHide[i].style.visibility = "hidden"; // or
        BoxToHide[b].style.display = "none"; // depending on what you're doing
//document.getElementsByClassName("txt_box").style.display = 'none'
	}
}; */
</script> 
<?	
	$i++;
	

}


	?>
</body>
</html>



