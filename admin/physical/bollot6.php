<?php
require('fpdf/fpdf.php');
class PDF extends FPDF
{
protected $col = 0; // Current column
// Page header
function Header()
{
    // Logo
    $this->Image('logo.jpg',10,10,24,13);
    // Arial bold 15
	$this->SetFont('THSarabunNew','',12);
    $this->Cell(28);
    $this->Cell(140,2,'Companyname THAI',0,'L');
	$this->Ln(5);
	$this->Cell(28);
	$this->Cell(140,2,'Companyname ENG',0,'L');
	$this->Ln(5);
	$this->Cell(28);
	$this->SetFont('THSarabunNew','',9); 
	$this->Cell(140,2,'Detail info Thai',0,'L');
	$this->Ln(5);
	$this->Cell(28);
	$this->Cell(140,2,'Detail info ENG',0,'L');
	$this->Ln(5);
}

function SetCol($col)
{
    // Move position to a column
    $this->col = $col;
    $x = 10+$col*46.7;
    $this->SetLeftMargin($x);
    $this->SetX($x);
	
}
function AcceptPageBreak()
{
    if($this->col<2)
    {
        // Go to next column
        $this->SetCol($this->col+2);
		$this->SetY(30.3);
        return false;
    }
    else
    {
        // Go back to first column and issue page break
        $this->SetCol(0);
        return true;
    }
}
}

$pdf = new PDF();
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10);  
 for($i=1; $i<=4; $i++){
$pdf->SetFont('THSarabunNew','',9);	
$pdf->Ln(0.3);
$pdf->MultiCell( 93  , 27 , iconv( 'UTF-8','cp874' , 'Agenda name' ) , 1, 2  );
$pdf->SetFont('THSarabunNew','B',7);
$pdf->cell( 93  , 4 , iconv( 'UTF-8','cp874' , 'Name sahreholder' ) ,  'LR', 1,'L');
$pdf->SetFont('THSarabunNew','',6);
$pdf->cell( 93  , 5 , iconv( 'UTF-8','cp874' , 'จำนวนหุ้นที่ลงคะแนน                                                                                                                                          100 shares' ) , 'LR', 1,'L');
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , 'No. of Shares Attended' ) ,  'LR', 1,'L');
$pdf->SetFont('THSarabunNew','',8);
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '    	เห็นด้วย                                                                    BARCODE' ) ,  'LR', 2,'L');
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '      Approve                                                                    number barcode' ) ,  'LR', 2,'L');
$pdf->cell( 93  , 5 , iconv( 'UTF-8','cp874' , '                    ') ,  'LR', 1,'L');
$pdf->SetFont('THSarabunNew','',8);
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '    	ไม่เห็นด้วย        BARCODE' ) ,  'LR', 2,'L');
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '      Disapprove        number barcode' ) ,  'LR', 2,'L');
$pdf->cell( 93  , 5 , iconv( 'UTF-8','cp874' , '                    ') ,  'LR', 1,'L');
$pdf->SetFont('THSarabunNew','',8);
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '    	งดออกเสียง                                                                     BARCODE' ) ,  'LR', 2,'L');
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '      Abstain                                                                     number barcode' ) ,  'LR', 2,'L');
$pdf->SetFont('THSarabunNew','',6);
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , 'กรณีที่ผู้ถือหุ้นไม่ลงคะแนนในช่องใด ๆ จะถือว่าเห็นด้วยในวาระนั้น ๆ                                                                                AGENDA' ) ,  'LR', 1,'L');
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , 'กรุณาคืนบัตรลงคะแนนทุกครั้งก่อนออกจากห้อง' ) ,  'LR', 1,'L');
$pdf->cell( 93  , 2 , iconv( 'UTF-8','cp874' , '     ' ) ,  'LR', 1,'L');
$pdf->cell( 93  , 5 , iconv( 'UTF-8','cp874' , '                    ลายมือชื่อ_____________________                                                                                                          #Number' ) ,  'LR', 1,'L');
$pdf->cell( 93  , 3 , iconv( 'UTF-8','cp874' , '                    Signature (Name of shareholder)                                                                                                    Datetime' ) ,  'LR', 1,'L');
$pdf->cell( 93  , 2 , iconv( 'UTF-8','cp874' , '                    ') ,  'LRB', 1,'L');


 }
$pdf->Output();
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,1,1,'L');


?>