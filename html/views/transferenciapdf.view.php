<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.transferenciarollo.inc.php";
// require_once FOLDER_MODEL. "model.valesalida.inc.php";


// cliente MDM 137


function salir(){
	echo "<script>

					window.close();
		</script>";
}

$idTransferencia = 0;
$imprimeTotales = false;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$idTransferencia = $_GET["id"];
}
else
{
	$idTransferencia = -666;
	//salir();
	//exit();
}


class PDF extends PDFNerk
{
	var $isMDM = false;
	
	var $_totalHojas = 1;
    var $_rowsByHoja = 25;
    
    var $__almacenDestino = "";
    var $__almacenOrigen = "";

	var $__imprimeTotales = false;
	
	var $yInicial = 10; 
	
	var $__recogeEntrega = "";
	var $__rangoCliente = "";
	
	var $__agente = "";
	var $__agenteVendedor = "";	

	
	var $__folio = "";
	var $__idPedido = "";
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
	
	var $__sucursales = "";
	
	
	
	// Cabecera de p?gina
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
	    
	    // $this->SetTextColor(71,171,235);
	    // $this->SetDrawColor(71,171,235);
		// $this->SetFillColor(224,238,254);
		$this->SetFillColor(125,125,125);
	    
	    $this->putTextCenter("GALVA MEX, S.A. DE C.V.", -10);
	    
	    $this->SetFont('Arial','',8);
	    
	    $this->nextRow();
	    $this->putTextCenter("BLVD. JUAN JOSE TORRES LANDA No. 2807", -10);
	    
	    $this->nextRow();
	    $this->putTextCenter("COL. LAS AMALIAS C.P. 37438", -10);
	    
	    $this->nextRow();
	    $this->putTextCenter("TELS. (477) 778-03-41 Y 778-02-73", -10);
	    
	    $this->nextRow();
	    $this->putTextCenter("LEON, GTO. MEXICO", -10);
	    
	    $this->SetFont('Arial','',7);
	    
	    $this->nextRow();
	    $this->putTextCenter($this->__sucursales, -10);
	    
	    $this->SetFont('Arial','B',13);
	    
	    $this->setCurrentY($yInicial );
	    $this->putTextCenter("TRANSFERENCIAS ROLLOS ", 65);
	    
	    
	    // $this->putTextRight("COTIZACION", 20);
	    
	    // $this->Rect(157, $this->currentY - 5, 7, 7, "D");
	    // $this->Rect(197, $this->currentY - 5, 7, 7, "D");
	
	    $this->SetFont('Arial','',8);
	    
	    $this->setCurrentY($yInicial + 3);
	    // $this->putTextCenter(clsUtilerias::formatoFecha(date("Y-m-d")), 65);
        
        $this->setCurrentY($yInicial + 25);
	    
	    $this->putText(10, "GENERÓ:");
	    $this->putText(150, "FECHA:");
	    $this->nextRow(-3);
	    $this->putText(25, "_______________________________________________________________________________                 ________________________");

	    
	    // $this->setCurrentY($yInicial + 25);
	    
	    // $this->putText(10, "NOMBRE:");
	    // $this->putText(150, "FECHA:");
	    // $this->nextRow(-3);
	    // $this->putText(25, "_______________________________________________________________________________                 ________________________");
	    
	    // $this->nextRow(2);
	    // $this->putText(10, "DOMICILIO:");
	    // $this->nextRow(-3);
	    // $this->putText(28, "______________________________________________________________________________________________________________");
	    
	    // $this->nextRow(2);
	    // $this->putText(10, "CIUDAD:");
	    // $this->putTextCenter("R.F.C.", -10);
	    // $this->putTextRight("TEL.", 60);
	    // $this->nextRow(-3);
	    // $this->putText(24, "__________________________________________            ____________________________         ________________________________");
        
        
		$this->SetFont('Arial','',10);
		$this->nextRow();
        $this->nextRow();
        $this->nextRow();
        $this->nextRow();
        $this->nextRow();
        // $this->putTextCenter("ORIGEN: " . $this->__almacenOrigen."          DESTINO: " . $this->__almacenDestino, -10);
        $this->putText(10, "ORIGEN:");
        $this->putTextRight("DESTINO:", 60);
        $this->SetFont('Arial','B',10);
        // $this->previousRow();
        $this->putText(30, $this->__almacenOrigen);
        $this->putText(160, $this->__almacenDestino);
        
        
        $this->SetFont('Arial','',10);

// 	    if ($this->isMDM)
// 	    {
	    	$this->RoundedRect(10, $yInicial + 52, 192, 7, 3, '', 'DF');
	    	$this->RoundedRect(10, $yInicial + 52, 192, 132, 3, '', 'D');
	    	 
	    	
	    	// $this->Line(57.5, $yInicial+52, 57.5, $yInicial+42+142);
	    	// $this->Line(67, $yInicial+52, 67, $yInicial+42+142);
            
            // $this->Line(184, $yInicial+52, 184, $yInicial+42+142);
			

			//lineas nuevas, de vale salida
			$this->Line(16, $yInicial+52, 16, $yInicial+42+142);
			$this->Line(39, $yInicial+52, 39, $yInicial+42+142);

			$this->Line(75, $yInicial+52, 75, $yInicial+42+142);

			// $this->Line(172, $yInicial+52, 172, $yInicial+42+142);

			


			$iLine = 0;
			$this->setCurrentY($yInicial + 63);
			for ($iLine = 0 ; $iLine < 25 ; $iLine ++)
			{
				$this->line(10, $yInicial + 64 + ($iLine * 5), 202, $yInicial + 64 + ($iLine * 5));
				$this->putText(11,""+$iLine+1);				
				$this->setCurrentY($yInicial + 63 + (($iLine + 1) * 5));
			}
			
	    	
	    	// //observaciones
	    	// $this->RoundedRect(10, $yInicial + 206, 192, 4, 3, '', 'DF');
	    	// $this->RoundedRect(10, $yInicial + 206, 192, 11, 3, '', 'D');
	    	
	    	// $this->SetFont('Arial','B',9);
			// $this->setCurrentY($yInicial + 209);
			// $this->SetTextColor(255,255,255);
			// $this->putTextCenter("O B S E R V A C I O N E S");
			// $this->SetTextColor(0,0,0);
	    	
	    	//Consignaci?n
	    	// if ($this->__recogeEntrega == "ENTREGA")
	    	// {
	    	// 	$this->RoundedRect(10, $yInicial + 219, 192, 4, 3, '', 'DF');
	    	// 	$this->RoundedRect(10, $yInicial + 219, 192, 35, 3, '', 'D');
	    		
	    	// 	$this->SetFont('Arial','B',9);
			// 	$this->setCurrentY($yInicial + 222);
			// 	$this->SetTextColor(255,255,255);
			// 	$this->putTextCenter("C O N S I G N A C I Ó N");
			// 	$this->SetTextColor(0,0,0);
	    		
	    	// 	$this->SetFont('Arial','',8);
	    	// 	$this->setCurrentY($yInicial + 230);
	    		 
	    	// 	$this->putText(12, "PERSONA RECIBE:");
	    	// 	$this->nextRow(-3);
	    	// 	$this->putText(38, "_______________________________________________________________________________________________________");
	    		
	    	// 	$this->nextRow(2);
	    	// 	$this->putText(12, "DOMICILIO:");
	    	// 	$this->nextRow(-3);
	    	// 	$this->putText(28, "_____________________________________________________________________________________________________________");
	    		
	    	// 	$this->nextRow(2);
	    	// 	$this->putText(12, "NÚMERO:");
	    	// 	$this->putTextCenter("COLONIA:", -30);
	    	// 	$this->putTextRight("CIUDAD:", 67);
	    	// 	$this->nextRow(-3);
	    	// 	$this->putText(27, "__________________________                   ______________________________                  ___________________________________");
	    		
	    	// 	$this->nextRow(2);
	    	// 	$this->putText(12, "HORA ENTREGA:");
	    	// 	$this->putTextCenter("FECHA ENTREGA:", 30);
	    	// 	$this->nextRow(-3);
	    	// 	$this->putText(37, "_____________________________________________________                                     ________________________________");
	    	// }
	    	
	    	
	    	
// 	    	var $_recibePersona = "";
// 	    	var $_recibeDomicilio = "";
// 	    	var $_recibeNumero = "";
// 	    	var $_recibeColonia = "";
// 	    	var $_recibeCiudad = "";	    	
	    	
	    	
	    	//Fin de Consignaci?n
	    	
	    	
	    	
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
	    
		$this->setCurrentY($yInicial + 57);
		$this->SetTextColor(255,255,255);
		$this->putText(10.5, "PT");    
	    $this->putText(17, "Remisión");    
        // $this->putText(172.5, "MED");
        $this->putText(40,"Rollo");
	    $this->putTextCenter("Material",-7);
		

		$this->SetFont('Arial','B',8);
		// $this->putTextRight("UNI", 14.5);
		$this->SetTextColor(0,0,0);
	    
	    
	    // $this->RoundedRect(155, $yInicial + 182, 27, 22, 3, '14', 'DF');    
	    // $this->RoundedRect(182, $yInicial + 182, 20, 22, 3, '23', 'D');
	    // $this->Line(155, $yInicial + 190, 202, $yInicial+190);
	    // $this->Line(155, $yInicial + 197, 202, $yInicial+197);
	    
	    // $this->SetFont('Arial','',10);
	    // $this->SetTextColor(255,255,255);
	    // $this->setCurrentY($yInicial + 188);
	    // $this->putTextRight("SUB TOTAL", 35);
	    // $this->nextRow(3);
	    // $this->putTextRight("I.V.A", 35);
	    
	    // $this->SetFont('Arial','B',10);    
	    
	    // $this->nextRow(3);
	    // $this->putTextRight("T O T A L  $", 35);
	    // $this->SetTextColor(0,0,0);
	    
		
	    // //leyendas lado izquierdo
		$this->SetFont('Arial','B',8);
		$this->setCurrentY($yInicial + 200);
		
		// $this->putText(10, "FAVOR DE REVISAR SU MATERIAL POR QUE DESPUÉS NO SE ACEPTAN RECLAMACIONES");	    
	    
	    // //leyendas lado izquierdo
	    $this->SetFont('Arial','',8);
	    $this->setCurrentY($yInicial + 208);
	     
		// $this->putText(10, "PROMOTOR: ");			    
	    // $this->nextRow(-3);
	    // $this->putText(41, "________________________________________________________________");
	    
	    // $this->nextRow();	    
	    // $this->putText(10, "(");
	    // $this->putText(141, ")");
	    // $this->nextRow(-3);
	    // $this->putText(11, "___________________________________________________________________________________");
	    
	    // $this->nextRow();	    
	    // $this->putText(10, "Por concepto de anticipo $");
	    // $this->nextRow(-3);
	    // $this->putText(44, "______________________________________________________________");
	    
	    // $this->nextRow();	    
	    // $this->putText(10, "Saldo $");
	    // $this->nextRow(-3);
	    // $this->putText(21, "_____________________________________________________________________________");
	    
	    // $this->SetFont('Arial','B',8);
	    // $this->nextRow();
	    // $this->putText(10, "Nota: Una vez confirmado el pedido no hay cambios ni devoluciones.");
	    
	    // if ($this->__recogeEntrega == "ENTREGA")
	    // {
	    // 	$this->setCurrentY($yInicial + 253);
	    // }
	    // else
	    // {	    
	    // 	$this->setCurrentY($yInicial + 235);
	    // }
	    
	    $this->SetFont('Arial','',8);
	    $this->nextRow(8);
		// $this->putText(15, "Agente:                                                                                                   Firma de recibido:                     ");	    

		$this->putTextCenter("______________________________________________________________",-10);
		$this->nextRow(-1);
		$this->putTextCenter("Firma de recibido",-10);
	    // $this->putText(25, "___________________________________________                            ___________________________________________");
	    
	
	}
	
	// Pie de p?gina
	function Footer()
	{
// 	    // Posici?n: a 1,5 cm del final
// 	    $this->SetY(-15);
// 	    // Arial italic 8
// 	    $this->SetFont('Arial','I',8);
// 	    // N?mero de p?gina
// 	    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function printDatosPedido($rsDetalle, $hoja)
	{
		$yInicial = $this->yInicial;
		
		$this->setCurrentY($yInicial + 2);
		
		// $this->SetDrawColor(73,139,235);
		
		// if ($this->__isPedido)
		// {
		// 	$this->Line(157, $this->currentY - 5, 164, $this->currentY + 2);
		// 	$this->Line(157, $this->currentY + 2, 164, $this->currentY - 5);
		// }
		// else
		// {
		// 	$this->Line(197, $this->currentY - 5, 204, $this->currentY + 2);
		// 	$this->Line(197, $this->currentY + 2, 204, $this->currentY - 5);
		// }
		
		$this->SetFont('Arial','B',11);
		
		// $this->SetTextColor(255,0,0);
		$this->setCurrentY($yInicial + 12);
		$this->putTextRight("No Recibo: ", 40);
		$this->putText(182, $this->__folio);

		// $this->SetFont('Arial','',8);
		// $this->setCurrentY($yInicial + 15);
		// $this->putTextRight("No Pedido: ", 40);
		// $this->putText(182, $this->__idPedido);
				
		$this->setCurrentY($yInicial + 18);
		$this->putTextRight("Hoja: ", 40);
		$this->putText(182,($hoja+1) ." / " .$this->_totalHojas);
		
		// $this->SetFont('Arial','B',8);
		// $this->setCurrentY($yInicial + 8);
		// //$this->putTextRight("No.", 40);
		// $this->putTextCenter($this->__recogeEntrega, 65);
		
		// $this->setCurrentY($yInicial + 20);
		// //$this->putTextRight("No.", 40);
		// $this->putText(10, $this->__rangoCliente);
		
		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 25);
		
		// $this->SetTextColor(73,139,235);
		 
		$this->putText(25, $this->__nombre);
		$this->putText(163, $this->__fecha);
		$this->nextRow(-3);
		
		// $this->nextRow(2);
		// $this->putText(28, $this->__domicilio);
		// $this->nextRow(-3);		
		 
		// $this->nextRow(2);
		// $this->putText(24, $this->__ciudad);
 		// $this->putText(105,$this->__rfc);
 		// $this->putTextRight($this->__telefono, 20);
 		
 		// $this->SetFont('Arial','',10);
 		
 		// $this->setCurrentY($yInicial + 188);
 		// $this->putTextRight(number_format($this->__subtotal, 2), 14.5);
  		// $this->nextRow(3);
  		// $this->putTextRight(number_format($this->__iva, 2), 14.5);
 		 
  		// $this->SetFont('Arial','B',10);
 		 
  		// $this->nextRow(3);
  		// $this->putTextRight(number_format($this->__total, 2), 14.5);
  		
  		$this->setCurrentY($yInicial + 63);
  		$this->SetFont('Arial','',10);
  	
		
		$rowInicial = $this->_rowsByHoja * $hoja;
		$rowFinal= $this->_rowsByHoja * ($hoja + 1);
		$index = -1;
		
  		foreach ($rsDetalle as $item)
  		{
  			$index++;
  			$this->SetFont('Arial','',10);
  			if ($index >= $rowInicial && $index < $rowFinal)
  			{
                  $this->putText(17, $item["remision"]);
                  $this->putText(40, $item["norollo"]);

                  $this->SetFont('Arial','',9);

                  $this->putText(76, $item["rollo"]);
  			    
  			    
  			    
  		  			    
  		  			    // $this->putText(31.5, utf8_encode($desc));
  		  			    
  		  			 
  		  			    
  		  			    $this->nextRow();
  		  			    $this->nextRow(-3);
  			}
  			
  			
  			
	    }
		
  		
  		
  		
	}
}

// Creaci?n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");

$tr = new ModeloTransferenciarollo();

$tr->setIdTransferenciaRollo($idTransferencia);

// $pedido = new ModeloPedido();
// $pedido->getValeSalida($idTransferencia);

// if ($pedido->getValeSalidaDato("idCliente") == "137")
// {
// 	$pdf->isMDM = true;
// }

// $pdf->__recogeEntrega = $pedido->getValeSalidaDato("recogeentrega");
// $pdf->__sucursales = $pedido->getValeSalidaDato("sucursalNombre");

// $pdf->__idPedido = $pedido->getValeSalidaDato("idPedido");
// $pdf->__nombre =utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("cteNombre") . " " . $pedido->getValeSalidaDato("cteApellidos")));
// $pdf->__fecha = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("fecha_capturado")));
// $pdf->__domicilio = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("cteDomicilio1") . " " . $pedido->getValeSalidaDato("cteDomicilio2") . " " . $pedido->getValeSalidaDato("cteNumero") . " " . $pedido->getValeSalidaDato("cteColonia")));
// $pdf->__ciudad = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("cteCiudad")));
// $pdf->__rfc = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("cteRfc")));
// $pdf->__telefono = $pedido->getValeSalidaDato("cteTelefonos");
// $pdf->__totalTexto = "";
// $pdf->__conceptoAnticipo = "";


// $pdf->__subtotal = doubleval($pedido->getValeSalidaDato("subtotal"));
// $pdf->__iva = doubleval($pedido->getValeSalidaDato("iva"));
// $pdf->__total = doubleval($pedido->getValeSalidaDato("total"));
// $pdf->__saldo = doubleval($pedido->getValeSalidaDato("saldo"));

// $pdf->__horaRecibe = $pedido->getValeSalidaDato("horaRecibe");
// $pdf->__fechaCompromiso = $pedido->getValeSalidaDato("fechaCompromiso");

// $pdf->__agente = $pedido->getValeSalidaDato("promoNombre") . " " . $pedido->getValeSalidaDato("promoAPaterno") . " " . $pedido->getValeSalidaDato("promoAMaterno");
// $pdf->__agenteVendedor = $pedido->getValeSalidaDato("vendeNombre") . " " . $pedido->getValeSalidaDato("vendeAPaterno") . " " . $pedido->getValeSalidaDato("vendeAMaterno");

// $pdf->_recibePersona = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("personaEntrega")));
// $pdf->_recibeDomicilio = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("domicilioEntrega")));
// $pdf->_recibeNumero = utf8_decode(mb_strtoupper( $pedido->getValeSalidaDato("numeroEntrega")));
// $pdf->_recibeColonia = utf8_decode(mb_strtoupper($pedido->getValeSalidaDato("coloniaEntrega")));
// $pdf->_recibeCiudad =utf8_decode(mb_strtoupper( $pedido->getValeSalidaDato("ciudadEntrega")));

// $pdf->_observacionPedido = $pedido->getValeSalidaDato("observacionCaptura");


// $pdf->__rangoCliente = $pedido->getPedidoDato("rangoCliente");

// if ($pdf->__rangoCliente == "REGULAR")
// {
//     $pdf->__rangoCliente  = "";
// }
// else
// {
//     $pdf->__rangoCliente  = "CLIENTE " .$pdf->__rangoCliente ;
// }



$query = "
    select t.idTransferenciaRollo folio, t.almacenOrigen origen,t.estatus, t.almacenDestino destino, t.fecha_crea fecha,  
    concat(u.nombre, ' ' , u.apellidoPaterno, ' ' , u.apellidoMaterno) crea,
    concat(ua.nombre, ' ' , ua.apellidoPaterno, ' ' , ua.apellidoMaterno) acepta,
    rr.idRemisionRollo, rr.remision, rr.norollo, vr.descauto rollo, rr.existencia
    from transferenciarollo t
    inner join transferenciarollodetalle td on t.idTransferenciaRollo = td.idTransferenciaRollo
    inner join remisionrollo rr on td.idRemisionRollo = rr.idRemisionRollo
    inner join viewrollos vr on rr.remisionRollo_rollo_idRollo = vr.idrollo
    inner join usuario u on t.id_usuario_crea = u.idUsuario
    left join usuario ua on t.id_usuario_acepta = ua.idUsuario
    where t.idTransferenciaRollo = " . $idTransferencia;

$lst = $tr->getDataSet($query);




// $pdf->__imprimeTotales = $imprimeTotales;

$pdf->__folio = $idTransferencia;

$pdf->_totalHojas = ceil(count($lst) / $pdf->_rowsByHoja);

$pdf->__nombre =(mb_strtoupper($lst[0]["crea"]));
$pdf->__fecha = utf8_decode(mb_strtoupper($lst[0]["fecha"]));

$pdf->__almacenOrigen = mb_strtoupper($lst[0]["origen"]);
$pdf->__almacenDestino = mb_strtoupper($lst[0]["destino"]);


$pdf->AddPage();


$pdf->printDatosPedido($lst, 0);

for($h = 1 ; $h < $pdf->_totalHojas ; $h++)
{
    $pdf->AddPage();
    $pdf->printDatosPedido($lst, $h);
    
    
}





 
//  //$pdf->SetFillColor(192);
//  $pdf->SetFillColor(164,220,255);
//  $pdf->RoundedRect(60, 30, 68, 46, 5, '123', 'F');
 
//  $pdf->SetTextColor(0,92,235);
//  $pdf->setCurrentY(35);
//  $pdf->putText(65, "Concepto");
 
 
//  $pdf->Line(2, 40, 50, 80);
 
//  $pdf->Rect(50, 40, 0.2, 80, "F");
 
 
     //$pdf->Cell(0,10,'Imprimiendo l?nea n?mero '.$i,0,1);
// $pdf->Output('D','filename.pdf');
$pdf->Output();