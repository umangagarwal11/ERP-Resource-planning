<?php
include ('db.php');
session_start();
require('./pdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,40);
    // Arial bold 15
    $this->SetFont('Arial','BU',20);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,20,'Payment Reciept','',0,'C');
    //iste-logo
	 $this->Image('iste.jpg',180,12,15);
	// Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
if(isset($_POST['pay'])){
$a=rand(10000000,99999999);
while(mysqli_num_rows(mysqli_query($con,"select * from paid where id='$a'"))!=0){
$a=rand(10000000,99999999);
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetRightMargin(10);
$pdf->AddPage();
$pdf->SetAutoPageBreak(true);
$pdf->SetFont('Times',null,20);
$pdf->Ln(20);
$pdf->Cell(0,10,'Payment for '.$_SESSION['student'].' for the year 2019-20 successful.','',1,'L'); 
$pdf->Cell(0,15,'Transaction id.- '.$a.'.','',1,'L');
$pdf->Cell(0,10,'Keep this for your future reference.','',1,'L');
$pdf->Output();}

?>
<html>
<head>
<meta name="viewport" content="width=device-width initial-scale=1 shrink-to-fit=no">
    
	<title > Admin login and registeration </title>
	<link rel = "stylesheet " type = "text/css" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<form action="" method = "post" class="ml-auto mr-auto mt-auto mb-auto">
<h4>This is supposed to be a payment gateway which returns the transaction id. Click on pay to generate the reciept. (The transaction id displayed would be a random number)</h4>
<div style="margin-left:45%; margin-top:20%;"><button name = "pay" value='1' class = "btn btn-primary"  >  Pay</button>  </div>
</form>

</div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>