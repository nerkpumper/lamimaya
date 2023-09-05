<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';


class PDF extends PDFNerk
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('img/galvalogo.jpeg',10,8,50);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Title',1,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->setCurrentY(5);
$y = 5;

 for($i=1;$i<=40;$i++)
 { 	
 	$pdf->putText(1, "holis");
 	$pdf->nextRow();
 }
 
 //$pdf->SetFillColor(192);
 $pdf->SetFillColor(164,220,255);
 $pdf->RoundedRect(60, 30, 68, 46, 5, '123', 'F');
 
 $pdf->SetTextColor(0,92,235);
 $pdf->setCurrentY(35);
 $pdf->putText(65, "Concepto");
 
 
 $pdf->Line(2, 40, 50, 80);
 
 $pdf->Rect(50, 40, 0.2, 80, "F");
 
 
     //$pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
// $pdf->Output("D", "prueba.pdf");
$pdf->Output();
