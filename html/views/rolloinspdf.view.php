<?php

function salir()
{
	echo "<script>
					window.close();
		</script>";
}

if (!isset($param1))
{
	salir();
	return;
}

if ($param1 == "")
{
	salir();
	return;
}

require_once FOLDER_INCLUDE . 'lib/fpdf/fpdf.php';
require_once FOLDER_MODEL. "model.rollo.inc.php";

class PDF extends FPDF
{
	var $_claveRollo = "";
	var $_descripcionRollo = "";
	
	//Cabecera de página
	function Header()
	{
		// Logo
		//$this->Image('logo_pb.png',10,8,33);
		//$this->Image(FOLDER_IMG . '3.jpg',10,8,33,10);
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		$this->Cell(0,10,'Hoja de Inspección',0,0,'C');
		$this->Ln(15);
		
		$this->SetFont('Arial','B',12);
		
		// Movernos a la derecha
		$this->Cell(5);
		$this->Cell(20,10,"Código: ");
		
		$this->Cell(40);
		$this->Cell(30,10,"Descripción: ");
		
		$this->SetFont('Arial','',12);
		
		$this->Cell(-65);
		// Título
		$this->Cell(35,10,$this->_claveRollo);
		$this->Cell(30);
		$this->Cell(180,10,$this->_descripcionRollo);
		
		
		// Salto de línea
		$this->Ln(15);

// 		// Movernos a la derecha
// 		$this->Cell(50);
// 		// Título
// 		$this->Cell(30,10,$this->_claveRollo,1,0,'C');

// 		$this->Cell(10);
// 		$this->SetFont('Arial','B',12);
// 		$this->Cell(30,10,$this->_descripcionRollo);
// 		// Salto de línea
// 		$this->Ln(15);
	}

	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		
		$this->Cell(40);
		
		// Arial italic 8
		$this->SetFont('Arial','',8);
		$this->underline = true;
		// Número de página
		$this->Cell(60,10,'                                                                       ',0,0,'C');
		$this->Ln(5);
		$this->underline = false;
		$this->Cell(40);
		$this->Cell(60,10,'Responsable',0,0,'C');
		
	}

	

	function printHojaInspeccion()
	{
		$this->SetFont('Arial','B',14);
		//totalWidthCell 280
		$this->Cell(30,7,"# Rollo",1);
		$this->Cell(30,7,"D. Interior",1);
		$this->Cell(30,7,"D. Exterior",1);
		$this->Cell(25,7,"Ancho",1);
		$this->Cell(25,7,"Calibre",1);
		$this->Cell(140,7,"Observaciones",1);

		$this->Ln();

		for($i = 0 ; $i < 20 ; $i++)
		{
			$this->Cell(30,7,"",1);
			$this->Cell(30,7,"",1);
			$this->Cell(30,7,"",1);
			$this->Cell(25,7,"",1);
			$this->Cell(25,7,"",1);
			$this->Cell(140,7,"",1);

			$this->Ln();
		}


	}	
}

$pdf = new PDF("L");

$rollo = new ModeloRollo();

$rollo->setIdRollo($param1);

if ($rollo->getIdRollo() == 0)
{
	salir();
}

$pdf->_claveRollo = $rollo->getCodigo();
$pdf->_descripcionRollo = str_replace("<br />", "\n ", $rollo->getDescripcion());

$pdf->AliasNbPages();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->printHojaInspeccion();

//$pdf->Output();
$pdf->Output("D", $pdf->_claveRollo . ".pdf");
