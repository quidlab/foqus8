<?php
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
//$doc_root = $_SERVER["DOCUMENT_ROOT"]; 
//require_once($doc_root."/../vendor/autoload.php");
require('fpdf/fpdf.php');
//use FPDF;
class PDF extends FPDF
{
//protected $col = 0; // Current column
// Page header


}

$pdf = new PDF();
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10); 


$lastprintedcol=2;
$width=93;
$height=85;
$TotalAgendas= 16;
$currentline =1 ;
$totallines = ceil($TotalAgendas / 2);
//$pdf->setXY($x,$y);
 for($i=1; $i<=$TotalAgendas; $i++){
 $pdf->SetFont('THSarabunNew','',9);	
if ($i %2 !=0){ $pdf->cell( $width  ,$height , iconv( 'UTF-8','cp874' , $i ) ,  1, 0,'L'); } 
else 
{ $pdf->cell( $width  ,$height , iconv( 'UTF-8','cp874' , $i ) ,  1, 1,'L'); }




 }
$pdf->Output();
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,1,1,'L');


?>