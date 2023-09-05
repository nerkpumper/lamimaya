<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.pedido.inc.php";


function salir(){
	echo "<script>

					window.close();
		</script>";
}

$idPedido = 0;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$idPedido = $_GET["id"];
}
else
{
	$idPedido = -666;
	//salir();
	//exit();
}

class PDF extends PDFNerk
{
	var $yInicial = 10; 
	
	var $__recogeEntrega = "";
	
	var $__folio = "";
	var $__nombre = "";
	var $__fecha = "";
	var $__domicilio = "";
	var $__ciudad = "";
	var $__rfc = "";
	var $__telefono = "";
	var $__totalTexto = "";
	var $__conceptoAnticipo = "";
	var $__saldo = "";
	
	var $__subtotal = 0;
	var $__iva = 0;
	var $__total = 0;
	
	var $__isPedido = true;
	
	
	
	// Cabecera de página
	function Header()
	{
		$yInicial = $this->yInicial;
		
	    // Logo
	    $this->Image('img/galvalogo.jpeg',5,$yInicial-10,50);
	    // Arial bold 15
	    $this->SetFont('Arial','B',11);
	    
// 	    $this->setCurrentY($this->GetPageHeight()/2);
// 	    $this->putText(10, "mita");  

	    
	    
	    $this->setCurrentY($yInicial);
	    
	    $this->SetTextColor(71,171,235);
	    $this->SetDrawColor(71,171,235);
	    $this->SetFillColor(224,238,254);
	    
	    $this->putTextCenter("GALVA MEX, S.A. DE C.V.", -10);
	    
	    $this->SetFont('Arial','',8);
	    
	    $this->nextRow();
	    $this->putTextCenter("BLVD. JUAN JOSE TORRES LANDA No. XXX", -10);
	    
	    $this->nextRow();
	    $this->putTextCenter("COL. LAS AMALIAS C.P. 37438", -10);
	    
	    $this->nextRow();
	    $this->putTextCenter("TELS. (477) 778-03-41 Y XXX-XX-XX", -10);
	    
	    $this->nextRow();
	    $this->putTextCenter("LEON, GTO. MEXICO", -10);
	    
	    $this->SetFont('Arial','B',11);
	    
	    $this->setCurrentY($yInicial + 2);
	    $this->putTextRight("PEDIDO", 60);
	    $this->putTextRight("COTIZACION", 20);
	    
	    $this->Rect(152, $this->currentY - 5, 7, 7, "D");
	    $this->Rect(192, $this->currentY - 5, 7, 7, "D");
	
	    $this->SetFont('Arial','',8);
	    $this->setCurrentY($yInicial + 25);
	    
	    $this->putText(10, "NOMBRE:");
	    $this->putText(150, "FECHA:");
	    $this->nextRow(-3);
	    $this->putText(25, "_______________________________________________________________________________                 ________________________");
	    
	    $this->nextRow(2);
	    $this->putText(10, "DOMICILIO:");
	    $this->nextRow(-3);
	    $this->putText(28, "______________________________________________________________________________________________________________");
	    
	    $this->nextRow(2);
	    $this->putText(10, "CIUDAD:");
	    $this->putTextCenter("R.F.C.", -10);
	    $this->putTextRight("TEL.", 60);
	    $this->nextRow(-3);
	    $this->putText(24, "__________________________________________            ____________________________         ________________________________");
	    
	    $this->RoundedRect(10, $yInicial + 42, 192, 7, 3, '12', 'DF');
	    $this->RoundedRect(10, $yInicial + 42, 192, 60, 3, '1234', 'D');
	    $this->Line(28, $yInicial+42, 28, $yInicial+42+60);
	    $this->Line(182, $yInicial+42, 182, $yInicial+42+60);
	    $this->SetFont('Arial','B',10);
	    
	    $this->setCurrentY($yInicial + 48);
	    $this->putText(11, "PARTIDA");    
	    $this->putTextCenter("CONCEPTO");
	    $this->putTextRight("TOTAL", 12);
	    
	    
	    $this->RoundedRect(155, $yInicial + 103, 27, 22, 3, '14', 'DF');    
	    $this->RoundedRect(182, $yInicial + 103, 20, 22, 3, '23', 'D');
	    $this->Line(155, $yInicial + 110, 202, $yInicial+110);
	    $this->Line(155, $yInicial + 117, 202, $yInicial+117);
	    
	    $this->SetFont('Arial','',10);
	    
	    $this->setCurrentY($yInicial + 108);
	    $this->putTextRight("SUB TOTAL", 30);
	    $this->nextRow(3);
	    $this->putTextRight("I.V.A", 30);
	    
	    $this->SetFont('Arial','B',10);    
	    
	    $this->nextRow(3);
	    $this->putTextRight("T O T A L  $", 30);
	    
	    	    
	
	}
	
	// Pie de página
	function Footer()
	{
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function printDatosPedido($rsDetalle)
	{
		$yInicial = $this->yInicial;
		
		$this->setCurrentY($yInicial + 2);
		
		$this->SetDrawColor(73,139,235);
		
		if ($this->__isPedido)
		{
			$this->Line(152, $this->currentY - 5, 159, $this->currentY + 2);
			$this->Line(152, $this->currentY + 2, 159, $this->currentY - 5);
		}
		else
		{
			$this->Line(192, $this->currentY - 5, 199, $this->currentY + 2);
			$this->Line(192, $this->currentY + 2, 199, $this->currentY - 5);
		}
		
		$this->SetFont('Arial','B',11);
		
		$this->SetTextColor(255,0,0);
		$this->setCurrentY($yInicial + 14);
		$this->putTextRight("No.", 40);
		$this->putText(175, $this->__folio);
		
		$this->setCurrentY($yInicial + 10);
		//$this->putTextRight("No.", 40);
		$this->putText(145, $this->__recogeEntrega);
		
		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 25);
		
		$this->SetTextColor(73,139,235);
		 
		$this->putText(25, $this->__nombre);
		$this->putText(163, $this->__fecha);
		$this->nextRow(-3);
		
		$this->nextRow(2);
		$this->putText(28, $this->__domicilio);
		$this->nextRow(-3);		
		 
		$this->nextRow(2);
		$this->putText(24, $this->__ciudad);
 		$this->putText(100,$this->__rfc);
 		$this->putTextRight($this->__telefono, 45);
 		
 		$this->SetFont('Arial','',10);
 		
 		$this->setCurrentY($yInicial + 108);
 		$this->putTextRight(number_format($this->__subtotal, 2), 11);
  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__iva, 2), 11);
 		 
  		$this->SetFont('Arial','B',10);
 		 
  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__total, 2), 11);
  		
  		$this->setCurrentY($yInicial + 53);
  		$this->SetFont('Arial','',10);
  		$this->SetTextColor(73,139,235);
  		
  		foreach ($rsDetalle as $item)
  		{
  			$this->putTextRight($item["detPartida"], 185);
  			//$this->putText(29,"1234567891 1234567892 1234567893 1234567894 1234567895 1234567896 1234567897 1234");
  			$desc = $item["proCodigo"] . " " .  
  			        $item["proTipoProducto"] . " " .
  			        $item["proAplicacion"] . " " .
  			        $item["proMaterial"] ;
  			
  			if ($item["proShortUnidad"] != 'PZA' && $item["proShortUnidad"] != 'KG' )
  			{
  				if ($item["proShortUnidad"] == 'ML')
  				{
  					$desc .= " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  				}
  				else
  				{
  					$desc .= " de ".$item["detCantidad"] . " ML (" . $item["detCantidadReal"] . " ".$item["proShortUnidad"].")";
  				}
  				
  				
  			}
  			else
  			{
  				if ($item["proShortUnidad"] == 'KG' )
  				{
  					$desc = "[KG] " . $desc;
  				}
  				else
  				{
  					if ($item["proLongitud"] != "" )
  					{
  						$desc .=" de ".$item["proLongitud"] ." METRO LINEAL";
  					}
  				}
  			}
  			
  			if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
  			{
  				$desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
  			}
  			
  			        
  			        
//   			        $item["proMaterial"] . "   de ".$item["detCantidad"] . " (" . $item["detCantidadReal"] . " ". $item["proUnidad"] . ")";
  			  			
  			$desc = mb_strtoupper($desc);
  			$desc = str_replace("--NO APLICA--", "", $desc);
  			$desc = str_replace("-- NO APLICA --", "", $desc);
  			$desc = utf8_decode($desc);  
  			
  			$this->putText(29, $desc);
  			
  			$this->putTextRight(number_format($item["detTotal"],2), 11);
  			$this->nextRow();
  		}
  		
//   		for ($i = 0 ; $i < 13 ; $i++)
//   		{
  			
//   		}
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->AddPage();
// $pdf->SetFont('Times','',12);

//$pdf->setCurrentY(5);

$pedido = new ModeloPedido();
$pedido->getPedido($idPedido);


$pdf->__recogeEntrega = $pedido->getPedidoDato("recogeentrega");

$pdf->__folio = $idPedido;
$pdf->__nombre = $pedido->getPedidoDato("cteNombre") . " " . $pedido->getPedidoDato("cteApellidos");
$pdf->__fecha = $pedido->getPedidoDato("fecha_capturado");
$pdf->__domicilio = $pedido->getPedidoDato("cteDomicilio1") . " " . $pedido->getPedidoDato("cteDomicilio2");
$pdf->__ciudad = "";//$pedido->getPedidoDato("cteDomicilio2");
$pdf->__rfc = $pedido->getPedidoDato("cteRfc");
$pdf->__telefono = $pedido->getPedidoDato("cteTelefonos");
$pdf->__totalTexto = "";
$pdf->__conceptoAnticipo = "";
$pdf->__saldo = "";

$pdf->__subtotal = doubleval($pedido->getPedidoDato("subtotal"));
$pdf->__iva = doubleval($pedido->getPedidoDato("iva"));
$pdf->__total = doubleval($pedido->getPedidoDato("total"));

$pdf->printDatosPedido($pedido->__rsPedidoWDetalle);
 
//  //$pdf->SetFillColor(192);
//  $pdf->SetFillColor(164,220,255);
//  $pdf->RoundedRect(60, 30, 68, 46, 5, '123', 'F');
 
//  $pdf->SetTextColor(0,92,235);
//  $pdf->setCurrentY(35);
//  $pdf->putText(65, "Concepto");
 
 
//  $pdf->Line(2, 40, 50, 80);
 
//  $pdf->Rect(50, 40, 0.2, 80, "F");
 
 
     //$pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
//$pdf->Output('D','filename.pdf');
$pdf->Output();
