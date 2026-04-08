<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.pedido.inc.php";


// cliente MDM 137


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
	var $isMDM = false;
	
	var $yInicial = 10; 
	
	var $__recogeEntrega = "";
	
	var $__agente = "";
	
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
	
	var $__horaRecibe = "";
	var $__fechaCompromiso = "";
	
	var $_recibePersona = "";
	var $_recibeDomicilio = "";
	var $_recibeNumero = "";
	var $_recibeColonia = "";
	var $_recibeCiudad = "";
	
	var $_observacionPedido = "";
	
	
	
	// Cabecera de p�gina
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
	    
	    $this->SetTextColor(160,120,74);
	    $this->SetDrawColor(160,120,74);
	    $this->SetFillColor(245,236,215);
	    
	    $this->putTextCenter("GALVA MEX, S.A. DE C.V.", -10);
	    
	    $this->SetFont('Arial','B',12);
	    
	    $this->nextRow();
	    $this->putText(55, "LAMIMAYA");
	    $this->SetFont('Arial','',9);
	    $this->nextRow();
	    $this->putText(55, "C. 21 272, entre 18 Y 23");
	    $this->nextRow();
	    $this->putText(55, "Cd Industrial");
	    $this->nextRow();
	    $this->putText(55, "97255 Merida, Yuc.");
	    
	    $this->SetFont('Arial','B',11);
	    
	    $this->setCurrentY($yInicial + 2);
// 	    $this->putTextRight("PEDIDO", 60);
// 	    $this->putTextRight("COTIZACION", 20);
	    
// 	    $this->Rect(157, $this->currentY - 5, 7, 7, "D");
// 	    $this->Rect(197, $this->currentY - 5, 7, 7, "D");
	
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
	    
	    
// 	    if ($this->isMDM)
// 	    {
	    	$this->RoundedRect(10, $yInicial + 42, 192, 7, 3, '12', 'DF');
	    	$this->RoundedRect(10, $yInicial + 42, 192, 135, 3, '1234', 'D');
	    	 
	    	
	    	$this->Line(57.5, $yInicial+42, 57.5, $yInicial+42+135);
	    	$this->Line(67, $yInicial+42, 67, $yInicial+42+135);
	    	
// 	    	$this->Line(182, $yInicial+42, 182, $yInicial+42+135);
	    	
	    	//observaciones
	    	$this->RoundedRect(10, $yInicial + 206, 192, 4, 3, '', 'DF');
	    	$this->RoundedRect(10, $yInicial + 206, 192, 11, 3, '', 'D');
	    	
	    	$this->SetFont('Arial','B',9);
	    	$this->setCurrentY($yInicial + 209);
	    	$this->putTextCenter("O B S E R V A C I O N E S");
	    	
	    	//Consignaci�n
	    	if ($this->__recogeEntrega == "ENTREGA")
	    	{
	    		$this->RoundedRect(10, $yInicial + 219, 192, 4, 3, '', 'DF');
	    		$this->RoundedRect(10, $yInicial + 219, 192, 35, 3, '', 'D');
	    		
	    		$this->SetFont('Arial','B',9);
	    		$this->setCurrentY($yInicial + 222);
	    		$this->putTextCenter("C O N S I G N A C I � N");
	    		
	    		$this->SetFont('Arial','',8);
	    		$this->setCurrentY($yInicial + 230);
	    		 
	    		$this->putText(12, "PERSONA RECIBE:");
	    		$this->nextRow(-3);
	    		$this->putText(38, "_______________________________________________________________________________________________________");
	    		
	    		$this->nextRow(2);
	    		$this->putText(12, "DOMICILIO:");
	    		$this->nextRow(-3);
	    		$this->putText(28, "_____________________________________________________________________________________________________________");
	    		
	    		$this->nextRow(2);
	    		$this->putText(12, "N�MERO:");
	    		$this->putTextCenter("COLONIA:", -30);
	    		$this->putTextRight("CIUDAD:", 67);
	    		$this->nextRow(-3);
	    		$this->putText(27, "__________________________                   ______________________________                  ___________________________________");
	    		
	    		$this->nextRow(2);
	    		$this->putText(12, "HORA ENTREGA:");
	    		$this->putTextCenter("FECHA ENTREGA:", 30);
	    		$this->nextRow(-3);
	    		$this->putText(37, "_____________________________________________________                                     ________________________________");
	    	}
	    	
	    	
	    	
// 	    	var $_recibePersona = "";
// 	    	var $_recibeDomicilio = "";
// 	    	var $_recibeNumero = "";
// 	    	var $_recibeColonia = "";
// 	    	var $_recibeCiudad = "";	    	
	    	
	    	
	    	//Fin de Consignaci�n
	    	
	    	
	    	
// 	    }
// 	    else
// 	    {
// 	    	//recuadro piezas, concepto etc
// 	    	$this->RoundedRect(10, $yInicial + 42, 192, 7, 3, '12', 'DF');
// 	    	$this->RoundedRect(10, $yInicial + 42, 192, 28, 3, '1234', 'D');
	    	 
// 	    	//mdm
// 	    	$this->RoundedRect(10, $yInicial + 71, 33, 7, 3, '1', 'DF');
// 	    	$this->RoundedRect(10, $yInicial + 71, 192, 31, 3, '1234', 'D');
	    	 
// 	    	$this->Line(28, $yInicial+42, 28, $yInicial+42+28);
// 	    	$this->Line(182, $yInicial+42, 182, $yInicial+42+28);
// 	    	$this->SetFont('Arial','B',10);
	    	 
// 	    	$this->setCurrentY($yInicial + 76);
// 	    	$this->putText(11, "OBSERVACIONES");
// 	    }
	    
	    
	    $this->SetFont('Arial','B',10);
	    
	    $this->setCurrentY($yInicial + 48);
	    $this->putText(11, "C�DIGO");    
	    $this->putText(57.5, "PZAS");
	    $this->putTextCenter("CONCEPTO");
// 	    $this->putTextRight("TOTAL", 17);
	    
	    
// 	    $this->RoundedRect(155, $yInicial + 182, 27, 22, 3, '14', 'DF');    
// 	    $this->RoundedRect(182, $yInicial + 182, 20, 22, 3, '23', 'D');
// 	    $this->Line(155, $yInicial + 190, 202, $yInicial+190);
// 	    $this->Line(155, $yInicial + 197, 202, $yInicial+197);
	    
// 	    $this->SetFont('Arial','',10);
	    
// 	    $this->setCurrentY($yInicial + 188);
// 	    $this->putTextRight("SUB TOTAL", 35);
// 	    $this->nextRow(3);
// 	    $this->putTextRight("I.V.A", 35);
	    
// 	    $this->SetFont('Arial','B',10);    
	    
// 	    $this->nextRow(3);
// 	    $this->putTextRight("T O T A L  $", 35);
	    
	    
	    
	    //leyendas lado izquierdo
// 	    $this->SetFont('Arial','',8);
// 	    $this->setCurrentY($yInicial + 183);
	     
// 	    $this->putText(10, "Recibimos la cantidad $");	    
// 	    $this->nextRow(-3);
// 	    $this->putText(41, "________________________________________________________________");
	    
// 	    $this->nextRow();	    
// 	    $this->putText(10, "(");
// 	    $this->putText(141, ")");
// 	    $this->nextRow(-3);
// 	    $this->putText(11, "___________________________________________________________________________________");
	    
// 	    $this->nextRow();	    
// 	    $this->putText(10, "Por concepto de anticipo $");
// 	    $this->nextRow(-3);
// 	    $this->putText(44, "______________________________________________________________");
	    
// 	    $this->nextRow();	    
// 	    $this->putText(10, "Saldo $");
// 	    $this->nextRow(-3);
// 	    $this->putText(21, "_____________________________________________________________________________");
	    
// 	    $this->SetFont('Arial','B',8);
// 	    $this->nextRow();
// 	    $this->putText(10, "Nota: Una vez confirmado el pedido no hay cambios ni devoluciones.");
	    
	    if ($this->__recogeEntrega == "ENTREGA")
	    {
	    	$this->setCurrentY($yInicial + 253);
	    }
	    else
	    {	    
	    	$this->setCurrentY($yInicial + 235);
	    }
	    
	    $this->SetFont('Arial','',8);
	    $this->nextRow(5);
	    $this->putText(15, "Agente:                                                                                                   Recibi�:                     ");	    
	    $this->nextRow(-3);
	    $this->putText(25, "___________________________________________                            ___________________________________________");
	    
	
	}
	
	// Pie de p�gina
	function Footer()
	{
// 	    // Posici�n: a 1,5 cm del final
// 	    $this->SetY(-15);
// 	    // Arial italic 8
// 	    $this->SetFont('Arial','I',8);
// 	    // N�mero de p�gina
// 	    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function printDatosPedido($rsDetalle)
	{
		$yInicial = $this->yInicial;
		
		$this->setCurrentY($yInicial + 2);
		
		$this->SetDrawColor(200,169,110);
		
// 		if ($this->__isPedido)
// 		{
// 			$this->Line(157, $this->currentY - 5, 164, $this->currentY + 2);
// 			$this->Line(157, $this->currentY + 2, 164, $this->currentY - 5);
// 		}
// 		else
// 		{
// 			$this->Line(197, $this->currentY - 5, 204, $this->currentY + 2);
// 			$this->Line(197, $this->currentY + 2, 204, $this->currentY - 5);
// 		}
		
		$this->SetFont('Arial','B',11);
		
		$this->SetTextColor(255,0,0);
		$this->setCurrentY($yInicial + 14);
		$this->putTextRight("No.", 40);
		$this->putText(182, $this->__folio);
		
		$this->setCurrentY($yInicial + 10);
		//$this->putTextRight("No.", 40);
		$this->putText(145, $this->__recogeEntrega);
		
		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 25);
		
		$this->SetTextColor(200,169,110);
		 
		$this->putText(25, $this->__nombre);
		$this->putText(163, $this->__fecha);
		$this->nextRow(-3);
		
		$this->nextRow(2);
		$this->putText(28, $this->__domicilio);
		$this->nextRow(-3);		
		 
		$this->nextRow(2);
		$this->putText(24, $this->__ciudad);
 		$this->putText(105,$this->__rfc);
 		$this->putTextRight($this->__telefono, 40);
 		
//  		$this->SetFont('Arial','',10);
 		
//  		$this->setCurrentY($yInicial + 188);
//  		$this->putTextRight(number_format($this->__subtotal, 2), 14.5);
//   		$this->nextRow(3);
//   		$this->putTextRight(number_format($this->__iva, 2), 14.5);
 		 
//   		$this->SetFont('Arial','B',10);
 		 
//   		$this->nextRow(3);
//   		$this->putTextRight(number_format($this->__total, 2), 14.5);
  		
  		$this->setCurrentY($yInicial + 53);
  		$this->SetFont('Arial','',10);
  		$this->SetTextColor(200,169,110);
  		
//   		for($iii = 0 ; $iii < 40 ; $iii++)
//   		{
//   			$this->putText(29, $iii);
//   			$this->nextRow();
//   		}
  		
  		
  		
  		foreach ($rsDetalle as $item)
  		{
  			$this->putText(10, $item["proCodigo"]);
  			$this->putTextRight($item["detPartida"], 150);
  			//$this->putText(29,"1234567891 1234567892 1234567893 1234567894 1234567895 1234567896 1234567897 1234");
//   			$desc = $item["proCodigo"] . " " .  
//   			        $item["proTipoProducto"] . " " .
//   			        $item["proAplicacion"] . " " .  			        
// 		  			$item["proMaterial"] ;
  			
// 		  	$desc = $item["proTipoProducto"] . " " .
// 		  			$item["proAplicacion"] . " " .
// 		  			$item["proMaterial"] . " " . 
// 		  			"CAL ". $item["proCalibre"] . " " .
// 		  		    $item["proCodigo"];
		  	
		  	$desc = $item["proTipoProducto"] . " " .
		  	   		$item["proAplicacion"] . " " .
		  	   		$item["proMaterial"] . " " .
		  	   		"CAL ". $item["proCalibre"]; 
		  	   		
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
  			$desc = str_replace("CAL 0", "", $desc);
  			$desc = str_replace("   ", " ", $desc);
  			$desc = str_replace("  ", " ", $desc);  			
  			$desc = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');  
  			
  			$this->putText(67.5, $desc);
  			
//   			$this->putTextRight(number_format($item["detTotal"],2), 14.5);
  			$this->nextRow();
  		}
  		
//   		$this->putText(10, "LR-101 RPP264NTER ");
//   		$this->putTextRight("1234", 160);
  		
  		
  		
  		$this->SetDrawColor(200,169,110);
  		$this->SetTextColor(200,169,110);
  		
  		$this->SetFont('Arial','',8);
  		
  		if ($this->__recogeEntrega == "ENTREGA")
  		{
  			$this->setCurrentY($yInicial + 230);
  			$this->putText(40, mb_strtoupper($this->_recibePersona));
  			
  			$this->nextRow();
  			$this->nextRow(-1);
  			$this->putText(30, mb_strtoupper($this->_recibeDomicilio));
  			
  			$this->nextRow();
  			$this->nextRow(-1);
  			$this->putText(28, mb_strtoupper($this->_recibeNumero));
  			$this->putText(87, mb_strtoupper($this->_recibeColonia));
  			$this->putText(152, mb_strtoupper($this->_recibeCiudad));
  			
  			
  			$this->setCurrentY($yInicial + 251);
  			
  			
  			$this->__fechaCompromiso = str_replace("0000-00-00", "", $this->__fechaCompromiso);
  			$this->__fechaCompromiso = str_replace("00:00:00", "", $this->__fechaCompromiso);
  			
  			//   	$this->putTextRight(substr($this->__fechaCompromiso, 0, 10) . "  " . $this->__horaRecibe, 35);
  			$this->putText(40, $this->__horaRecibe);
  			$this->putText(155, $this->__fechaCompromiso);
  			
  			$this->setCurrentY($yInicial + 262);
  			$this->putText(26, mb_strtoupper($this->__agente));
  		}
  		else
  		{
  			$this->setCurrentY($yInicial + 244);
  			$this->putText(26, mb_strtoupper($this->__agente));
  		}
  		  		
  		$this->setCurrentY($yInicial + 215);
  		$this->putText(11, $this->_observacionPedido);
  		
  		
  		
  		
  		
  		
	}
}

// Creaci�n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");


//$pdf->AliasNbPages();

// $pdf->SetFont('Times','',12);

//$pdf->setCurrentY(5);

$pedido = new ModeloPedido();
$pedido->getPedido($idPedido);

if ($pedido->getPedidoDato("idCliente") == "137")
{
	$pdf->isMDM = true;
}

$pdf->__recogeEntrega = $pedido->getPedidoDato("recogeentrega");

$pdf->AddPage();



$pdf->__folio = $idPedido;
// $pdf->__nombre = $pedido->getPedidoDato("cteNombre") . " " . $pedido->getPedidoDato("cteApellidos");
// $pdf->__fecha = $pedido->getPedidoDato("fecha_capturado");
// $pdf->__domicilio = $pedido->getPedidoDato("cteDomicilio1") . " " . $pedido->getPedidoDato("cteDomicilio2");
// $pdf->__ciudad = $pedido->getPedidoDato("cteCiudad");
// $pdf->__rfc = $pedido->getPedidoDato("cteRfc");
$pdf->__nombre =mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteNombre", 'ISO-8859-1', 'UTF-8') . " " . $pedido->getPedidoDato("cteApellidos")));
$pdf->__fecha = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("fecha_capturado", 'ISO-8859-1', 'UTF-8')));
$pdf->__domicilio = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteDomicilio1", 'ISO-8859-1', 'UTF-8') . " " . $pedido->getPedidoDato("cteDomicilio2") . " " . $pedido->getPedidoDato("cteNumero") . " " . $pedido->getPedidoDato("cteColonia")));
$pdf->__ciudad = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteCiudad", 'ISO-8859-1', 'UTF-8')));
$pdf->__rfc = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteRfc", 'ISO-8859-1', 'UTF-8')));

$pdf->__telefono = $pedido->getPedidoDato("cteTelefonos");
$pdf->__totalTexto = "";
$pdf->__conceptoAnticipo = "";
$pdf->__saldo = "";	

$pdf->__subtotal = doubleval($pedido->getPedidoDato("subtotal"));
$pdf->__iva = doubleval($pedido->getPedidoDato("iva"));
$pdf->__total = doubleval($pedido->getPedidoDato("total"));

$pdf->__horaRecibe = $pedido->getPedidoDato("horaRecibe");
$pdf->__fechaCompromiso = $pedido->getPedidoDato("fechaCompromiso");

$pdf->__agente = $pedido->getPedidoDato("capturadoNombre") . " " . $pedido->getPedidoDato("capturadoAPaterno") . " " . $pedido->getPedidoDato("capturadoAMaterno");

// $pdf->_recibePersona = $pedido->getPedidoDato("personaEntrega");
// $pdf->_recibeDomicilio = $pedido->getPedidoDato("domicilioEntrega");
// $pdf->_recibeNumero = $pedido->getPedidoDato("numeroEntrega");
// $pdf->_recibeColonia = $pedido->getPedidoDato("coloniaEntrega");
// $pdf->_recibeCiudad = $pedido->getPedidoDato("ciudadEntrega");

$pdf->_recibePersona = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("personaEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeDomicilio = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("domicilioEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeNumero = mb_convert_encoding(mb_strtoupper( $pedido->getPedidoDato("numeroEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeColonia = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("coloniaEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeCiudad =mb_convert_encoding(mb_strtoupper( $pedido->getPedidoDato("ciudadEntrega", 'ISO-8859-1', 'UTF-8')));

$pdf->_observacionPedido = $pedido->getPedidoDato("observacionCaptura");

$pdf->printDatosPedido($pedido->__rsPedidoWDetalle);


 
//  //$pdf->SetFillColor(192);
//  $pdf->SetFillColor(164,220,255);
//  $pdf->RoundedRect(60, 30, 68, 46, 5, '123', 'F');
 
//  $pdf->SetTextColor(0,92,235);
//  $pdf->setCurrentY(35);
//  $pdf->putText(65, "Concepto");
 
 
//  $pdf->Line(2, 40, 50, 80);
 
//  $pdf->Rect(50, 40, 0.2, 80, "F");
 
 
     //$pdf->Cell(0,10,'Imprimiendo l�nea n�mero '.$i,0,1);
// $pdf->Output('D','filename.pdf');
$pdf->Output();