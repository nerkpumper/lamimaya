<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.valesalida.inc.php";


// cliente MDM 137


function salir(){
	echo "<script>

					window.close();
		</script>";
}

$idValeSalida = 0;
$imprimeTotales = false;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$idValeSalida = $_GET["id"];
}
else
{
	$idValeSalida = -666;
	//salir();
	//exit();
}

if (isset($_GET["it"]) && $_GET["it"] !== "") {
	$imprimeTotales = ($_GET["it"] == "1" ? true : false);
}

class PDF extends PDFNerk
{
	var $isMDM = false;
	
	var $_totalHojas = 1;
	var $_rowsByHoja = 25;

	var $__imprimeTotales = false;
	
	var $yInicial = 10; 

	var $idProductoMoldura = 9;
	var $idProductoMaquila = 10;
	
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

	var $__pagoVSEntrega = "NO";
	
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
	    $this->Image('img/Lamimayagoldshort.png',5,$yInicial-10,30);
	    // Arial bold 15
	    $this->SetFont('Arial','B',11);
	    
// 	    $this->setCurrentY($this->GetPageHeight()/2);
// 	    $this->putText(10, "mita");  

	    
	    
	    $this->setCurrentY($yInicial);
	    
	    // $this->SetTextColor(71,171,235);
	    // $this->SetDrawColor(71,171,235);
		// $this->SetFillColor(224,238,254);
		$this->SetFillColor(125,125,125);
	    
	    // $this->putTextCenter("GALVA MEX, S.A. DE C.V.", -10);
	    
	    $this->SetFont('Arial','',8);
	    
	    $this->SetFont('Arial','B',12);

	    $this->nextRow();
	    $this->putText(55, "LAMIMAYA");
	    $this->SetFont('Arial','',9);
	    $this->nextRow();
	    $this->putText(55, "C. 21 272, entre 18 Y 23");
	    $this->nextRow();
	    $this->putText(55, "Cd Industrial");
	    $this->nextRow();
	    $this->putText(55, "97255 Mérida, Yuc.");
	    
	    $this->SetFont('Arial','',7);
	    
	    $this->nextRow();
	    $this->putTextCenter($this->__sucursales, -10);
	    
	    // $this->SetFont('Arial','B',13);
	    
	    // $this->setCurrentY($yInicial );
	    // $this->putTextCenter("RECIBO DE MATERIAL", 65);
	    
	    
	    // $this->putTextRight("COTIZACION", 20);
	    
	    // $this->Rect(157, $this->currentY - 5, 7, 7, "D");
	    // $this->Rect(197, $this->currentY - 5, 7, 7, "D");
	
	    $this->SetFont('Arial','',8);
	    
	    $this->setCurrentY($yInicial + 3);
	    $this->putTextCenter(clsUtilerias::formatoFecha(date("Y-m-d")), 65);
	    
	    
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
		
		$this->SetFont('Arial','',10);
		$this->nextRow();
		$this->nextRow();
		$this->putTextCenter("RecibÍ de GALVAMEX S.A. de C.V. el siguiente material", -30);
		
		if ($this->__pagoVSEntrega == "SI")
		{
			$this->putTextRight("PAGO VS ENTREGA", 10);

		}
	    
// 	    if ($this->isMDM)
// 	    {
	    	$this->RoundedRect(10, $yInicial + 52, 192, 7, 3, '', 'DF');
	    	$this->RoundedRect(10, $yInicial + 52, 192, 132, 3, '', 'D');
	    	 
	    	
	    	// $this->Line(57.5, $yInicial+52, 57.5, $yInicial+42+142);
	    	// $this->Line(67, $yInicial+52, 67, $yInicial+42+142);
			$this->Line(184, $yInicial+52, 184, $yInicial+42+142);
			

			//lineas nuevas, de vale salida
			$this->Line(16, $yInicial+52, 16, $yInicial+42+142);
			$this->Line(31, $yInicial+52, 31, $yInicial+42+142);

			$this->Line(196, $yInicial+52, 196, $yInicial+42+142);

			// $this->Line(172, $yInicial+52, 172, $yInicial+42+142);

			


			$iLine = 0;
			$this->setCurrentY($yInicial + 63);
			for ($iLine = 0 ; $iLine < 25 ; $iLine ++)
			{
				$this->line(10, $yInicial + 64 + ($iLine * 5), 202, $yInicial + 64 + ($iLine * 5));
				$this->putText(11,"".$iLine+1);				
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
	    	if ($this->__recogeEntrega == "ENTREGA")
	    	{
	    		$this->RoundedRect(10, $yInicial + 219, 192, 4, 3, '', 'DF');
	    		$this->RoundedRect(10, $yInicial + 219, 192, 35, 3, '', 'D');
	    		
	    		$this->SetFont('Arial','B',9);
				$this->setCurrentY($yInicial + 222);
				$this->SetTextColor(255,255,255);
				$this->putTextCenter("C O N S I G N A C I Ó N");
				$this->SetTextColor(0,0,0);
	    		
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
	    		$this->putText(12, "NÚMERO:");
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
	    $this->putText(17, "PIEZAS");    
	    // $this->putText(172.5, "MED");
	    $this->putTextCenter("DESCRIPCIÓN",-7);
		$this->putTextRight("TOTAL", 20);

		$this->SetFont('Arial','B',8);
		$this->putTextRight("UNI", 14.5);
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
		
		$this->putText(10, "FAVOR DE REVISAR SU MATERIAL POR QUE DESPUÉS NO SE ACEPTAN RECLAMACIONES");	    
	    
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
	    
	    if ($this->__recogeEntrega == "ENTREGA")
	    {
	    	$this->setCurrentY($yInicial + 253);
	    }
	    else
	    {	    
	    	$this->setCurrentY($yInicial + 235);
	    }
	    
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


		$this->SetFont('Arial','B',13);
		$this->setCurrentY($yInicial );
	    $this->putTextCenter("RECIBO DE MATERIAL", 65);
		
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

		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 15);
		$this->putTextRight("No Pedido: ", 40);
		$this->putText(182, $this->__idPedido);
				
		$this->setCurrentY($yInicial + 18);
		$this->putTextRight("Hoja: ", 40);
		$this->putText(182,($hoja+1) ." / " .$this->_totalHojas);
		
		$this->SetFont('Arial','B',8);
		$this->setCurrentY($yInicial + 8);
		//$this->putTextRight("No.", 40);
		$this->putTextCenter($this->__recogeEntrega, 65);
		
		$this->setCurrentY($yInicial + 20);
		//$this->putTextRight("No.", 40);
		$this->putText(10, $this->__rangoCliente);
		
		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 25);
		
		// $this->SetTextColor(73,139,235);
		 
		$this->putText(25, $this->__nombre);
		$this->putText(163, $this->__fecha);
		$this->nextRow(-3);
		
		$this->nextRow(2);
		$this->putText(28, $this->__domicilio);
		$this->nextRow(-3);		
		 
		$this->nextRow(2);
		$this->putText(24, $this->__ciudad);
 		$this->putText(105,$this->__rfc);
 		$this->putTextRight($this->__telefono, 20);
 		
 		// $this->SetFont('Arial','',10);
 		
 		// $this->setCurrentY($yInicial + 188);
 		// $this->putTextRight(number_format($this->__subtotal, 2), 14.5);
  		// $this->nextRow(3);
  		// $this->putTextRight(number_format($this->__iva, 2), 14.5);
 		 
  		// $this->SetFont('Arial','B',10);
 		 
  		// $this->nextRow(3);
  		// $this->putTextRight(number_format($this->__total, 2), 14.5);
  		
  		$this->setCurrentY($yInicial + 63);
  		$this->SetFont('Arial','',9);
  		// $this->SetTextColor(73,139,235);
  		
//   		for($iii = 0 ; $iii < 40 ; $iii++)
//   		{
//   			$this->putText(29, $iii);
//   			$this->nextRow();
//   		}
  		
  		
		$totalMetrosLineales = 0;
		$totalMetrosCuadrados = 0;
		$totalKilos = 0;
		$totalPiezas = 0;
		
		$granTotalMetrosLineales = 0;
		$granTotalMetrosCuadrados = 0;
		$granTotalKilos = 0;
		$granTotalPiezas = 0;
		
		$rowInicial = $this->_rowsByHoja * $hoja;
		$rowFinal= $this->_rowsByHoja * ($hoja + 1);
		$index = -1;
		
  		foreach ($rsDetalle as $item)
  		{
  			$index++;
  			
  			if ($index >= $rowInicial && $index < $rowFinal)
  			{
  			    $this->putTextRight($item["valedeCantidad"], 188);
  			    // $this->putTextRight($item["detPartida"], 150);
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
  			    
  			    // $this->putText(10.5, "PT");
  			    // 	    $this->putText(17, "PIEZAS");
  			    // 	    $this->putText(174, "MTS");
  			    // 	    $this->putTextCenter("DESCRIPCI?N",-7);
  			    // 		$this->putTextRight("TOTAL", 17);
  			    
  			    $desc = $item["proTipoProducto"] . " " .
  		  			    $item["proAplicacion"] . " " .
  		  			    $item["proMaterial"] . " " .
  		  			    "CAL ". $item["proCalibre"];
  		  			    
  		  			    if ($item["proShortUnidad"] != 'PZA' && $item["proShortUnidad"] != 'KG' )
  		  			    {
  		  			        if ($item["proShortUnidad"] == 'ML')
  		  			        {
  		  			            $desc .= " ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  . " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  		  			        }
  		  			        else
  		  			        {
  		  			            $desc .= " ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  . " de ".$item["detCantidad"] . " ML (" . $item["detCantidadReal"] . " ".$item["proShortUnidad"].")";
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
  		  			    
  		  			    if ($item["proIdTipoProducto"] == "4")
  		  			    {
  		  			        $desc = $item["proDescAuto"];
  		  			    }
  		  			    
  		  			    if ($item["detIdProducto"] == 9)
  		  			    {
  		  			        //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
  		  			        $desc = "MOLDURA " . $item["rolloMolduraCodigo"];
  		  			        if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
  		  			        {
  		  			            $desc .= " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  		  			            $desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
  		  			        }

							if ($item["molLongitudinal"] == "A")
  		  		            {
  		  		            	$desc .= " \"DOBLECES A LO ANCHO\"";
  		  		            }
  		  			    }
  		  			    
  		  			    if ($item["detIdProducto"] == 10)
  		  			    {
  		  			        //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
  		  			        $desc = "MAQUILA DE MOLDURA  " . $item["molDescMaquila"] ." " . $item["rolloMolduraCodigo"];
  		  			        if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
  		  			        {
  		  			            $desc .= " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  		  			            $desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
  		  			        }
							
							if ($item["molLongitudinal"] == "A")
  		  		            {
  		  		                $desc .= " \"DOBLECES A LO ANCHO\"";
  		  		            }
  		  			    }

						if ($item["proIdTipoProducto"] == "4")
  		  		        {
  		  		        	$desc = $item["proDescAuto"];
  		  		        }
  		  			    
  		  			    //   			        $item["proMaterial"] . "   de ".$item["detCantidad"] . " (" . $item["detCantidadReal"] . " ". $item["proUnidad"] . ")";
  		  			    
  		  			    $desc = mb_strtoupper($desc);
  		  			    $desc = str_replace("--NO APLICA--", "", $desc);
  		  			    $desc = str_replace("-- NO APLICA --", "", $desc);
  		  			    $desc = str_replace("CAL 0", "", $desc);
  		  			    $desc = str_replace("   ", " ", $desc);
  		  			    $desc = str_replace("  ", " ", $desc);
  		  			    $desc = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');
  		  			    
  		  			    
  		  			    $totalML = 0;
  		  			    
  		  			    $this->putText(31.5, mb_convert_encoding($desc, 'UTF-8', 'ISO-8859-1');
  		  			    
  		  			    if ($item["proShortUnidad"] == "PZA")
  		  			    {
  		  			        // $this->putTextRight($item["proLongitud"], 33);
  		  			        // $totalML = $item["proLongitud"] * $item["valedeCantidad"];
  		  			        $totalML = $item["valedeCantidad"];
  		  			        $totalPiezas += $totalML;
  		  			    }
  		  			    else
  		  			    {
  		  			        // $this->putTextRight($item["detCantidad"], 33);
  		  			        if ($item["proShortUnidad"] == "ML")
  		  			        {
  		  			            $totalML = $item["detCantidad"] * $item["valedeCantidad"];
  		  			            $totalMetrosLineales += $totalML;
  		  			        }
  		  			        else
  		  			        {
  		  			            if ($item["proShortUnidad"] == "M2")
  		  			            {
  		  			                $totalML = $item["detCantidad"] * $item["valedeCantidad"];
  		  			                $totalMetrosCuadrados += $totalML;
  		  			            }
  		  			            else
  		  			            {
  		  			                $totalML = $item["valedeCantidad"];
  		  			                $totalKilos += $totalML;
  		  			            }
  		  			        }
  		  			        
  		  			    }
  		  			    
  		  			    
  		  			    
  		  			    // $this->putTextRight(number_format($item["detTotal"],2), 14.5);
  		  			    $this->putTextRight(number_format($totalML,2), 20);
  		  			    
  		  			    $this->SetFont('Arial','',7.5);
  		  			    $this->putTextRight($item["proShortUnidad"], 14.2);
  		  			    $this->SetFont('Arial','',9);
  		  			    
  		  			    $this->nextRow();
  		  			    $this->nextRow(-3);
  			}
  			
  			if ($item["proShortUnidad"] == "PZA")
  			{
  			    // $this->putTextRight($item["proLongitud"], 33);
  			    // $totalML = $item["proLongitud"] * $item["valedeCantidad"];
  			    $granTotalML = $item["valedeCantidad"];
  			    $granTotalPiezas += $granTotalML;
  			}
  			else
  			{
  			    // $this->putTextRight($item["detCantidad"], 33);
  			    if ($item["proShortUnidad"] == "ML")
  			    {
  			        $granTotalML = $item["detCantidad"] * $item["valedeCantidad"];
  			        $granTotalMetrosLineales += $granTotalML;
  			    }
  			    else
  			    {
  			        if ($item["proShortUnidad"] == "M2")
  			        {
  			            $granTotalML = $item["detCantidad"] * $item["valedeCantidad"];
  			            $granTotalMetrosCuadrados += $granTotalML;
  			        }
  			        else
  			        {
  			            $granTotalML = $item["valedeCantidad"];
  			            $granTotalKilos += $granTotalML;
  			        }
  			    }
  			    
  			}
  			
	    }
		
		$this->setCurrentY($yInicial+188);
		$this->putTextRight($this->_totalHojas == 1 ? "TOTALES" : "SUBTOTAL", 35);
		  
		$yTotales = 179;
		  
		//Metros Lineales
		if ($totalMetrosLineales > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalMetrosLineales,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("ML", 14.2);
			$this->SetFont('Arial','',10);
		}

		//Metros Cuadrados
		if ($totalMetrosCuadrados > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalMetrosCuadrados,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("M2", 14.2);
			$this->SetFont('Arial','',10);
		}
		
		//PIEZAS
		if ($totalPiezas > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalPiezas,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("PZA", 14.2);
			$this->SetFont('Arial','',10);
		}

		//kilos
		if ($totalKilos > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalKilos,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("KG", 14.2);
			$this->SetFont('Arial','',10);
		}
		
		
		if ($this->_totalHojas > 1 && $this->_totalHojas == ($hoja + 1))
		{
		    $this->setCurrentY(25 + $yTotales);
		    $this->putTextRight("TOTALES", 35);
		    
// 		    $yTotales = 179;
		    $yTotales += 5.5;
		    
		    //Metros Lineales
		    if ($granTotalMetrosLineales > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalMetrosLineales,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("ML", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		    
		    //Metros Cuadrados
		    if ($granTotalMetrosCuadrados > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalMetrosCuadrados,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("M2", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		    
		    //PIEZAS
		    if ($granTotalPiezas > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalPiezas,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("PZA", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		    
		    //kilos
		    if ($granTotalKilos > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalKilos,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("KG", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		}

		
  		
//   		$this->putText(10, "LR-101 RPP264NTER ");
//   		$this->putTextRight("1234", 160);
  		
  		
  		
  		// $this->SetDrawColor(73,139,235);
  		// $this->SetTextColor(73,139,235);
  		
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
  			
  			
  		}
  		else
  		{
  		    $this->SetFont('Arial','',7);
  		    $this->setCurrentY($yInicial + 193);
  		    $this->putText(10,"No nos hacemos responsables por los daños sufridos a la mercancía a consecuencia de un mal transporte, almacenaje e instalación.");
  		    $this->nextRow(-1);
  		    $this->putText(10,"Favor de consultar el FOLLETO GALVAMEX en la sección Manejo de Materiales para ver recomendaciones.");
  		}
		  
		  
		  if ($this->__imprimeTotales)
		  {
			$this->SetFont('Arial','B',8);
			$this->setCurrentY($yInicial + 188);
			$this->putText(11, "Total Pedido: $ " . number_format( $this->__total, 2) . "        Abonos: $ " . (number_format( $this->__total - $this->__saldo, 2))  . "       Saldo: $ " . number_format($this->__saldo,2));
		  }
		  
		  

		  $this->setCurrentY($yInicial + 208);

		  $this->SetFont('Arial','',8);

		  $this->putText(10, "PROMOTOR: ");
		  if ($this->__agente != $this->__agenteVendedor) 		  $this->putText(100, "VENDEDOR: ");		  
		  
		  $this->SetFont('Arial','B',8);
		  $this->putText(30, mb_strtoupper($this->__agente));
		  if ($this->__agente != $this->__agenteVendedor) 		  $this->putText(120, mb_strtoupper($this->__agenteVendedor));



		  $this->SetFont('Arial','B',8);
		  $this->nextRow();
		  $this->putTextCenter("NOTA: TODA DEVOLUCIÓN CAUSARÁ UN 20% DEL COSTO DEL PRODUCTO",-10);
		  $this->nextRow();
		  $this->putTextCenter("NOTA: La descarga va por cuenta del cliente.",-10);
  		  		
  		// $this->setCurrentY($yInicial + 215);
  		// $this->putText(11, $this->_observacionPedido);
  		
  		
  		
  		
  		
  		
	}

	function printDatosPedidoDespiece($rsDetalle,  $hoja, $offset = 0)
	{
		$yInicial = $this->yInicial;

		$this->SetFont('Arial','B',13);
		$this->setCurrentY($yInicial );
	    $this->putTextCenter("DESPIECE DE MATERIAL", 65);
		
		
		$this->SetFont('Arial','B',11);
		
		// $this->SetTextColor(255,0,0);
		$this->setCurrentY($yInicial + 12);
		$this->putTextRight("No Recibo: ", 40);
		$this->putText(182, $this->__folio);

		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 15);
		$this->putTextRight("No Pedido: ", 40);
		$this->putText(182, $this->__idPedido);
				
		$this->setCurrentY($yInicial + 18);
		$this->putTextRight("Hoja: ", 40);
		$this->putText(182,(($hoja+$offset)+1) ." / " .$this->_totalHojas);
		
		$this->SetFont('Arial','B',8);
		$this->setCurrentY($yInicial + 8);
		//$this->putTextRight("No.", 40);
		$this->putTextCenter($this->__recogeEntrega, 65);
		
		$this->setCurrentY($yInicial + 20);
		//$this->putTextRight("No.", 40);
		$this->putText(10, $this->__rangoCliente);
		
		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 25);
		
		// $this->SetTextColor(73,139,235);
		 
		$this->putText(25, $this->__nombre);
		$this->putText(163, $this->__fecha);
		$this->nextRow(-3);
		
		$this->nextRow(2);
		$this->putText(28, $this->__domicilio);
		$this->nextRow(-3);		
		 
		$this->nextRow(2);
		$this->putText(24, $this->__ciudad);
 		$this->putText(105,$this->__rfc);
 		$this->putTextRight($this->__telefono, 20);
 		
 		// $this->SetFont('Arial','',10);
 		
 		// $this->setCurrentY($yInicial + 188);
 		// $this->putTextRight(number_format($this->__subtotal, 2), 14.5);
  		// $this->nextRow(3);
  		// $this->putTextRight(number_format($this->__iva, 2), 14.5);
 		 
  		// $this->SetFont('Arial','B',10);
 		 
  		// $this->nextRow(3);
  		// $this->putTextRight(number_format($this->__total, 2), 14.5);
  		
  		$this->setCurrentY($yInicial + 63);
  		$this->SetFont('Arial','',9);
  		// $this->SetTextColor(73,139,235);
  		
//   		for($iii = 0 ; $iii < 40 ; $iii++)
//   		{
//   			$this->putText(29, $iii);
//   			$this->nextRow();
//   		}
  		
  		
		$totalMetrosLineales = 0;
		$totalMetrosCuadrados = 0;
		$totalKilos = 0;
		$totalPiezas = 0;
		
		$granTotalMetrosLineales = 0;
		$granTotalMetrosCuadrados = 0;
		$granTotalKilos = 0;
		$granTotalPiezas = 0;
		
		$rowInicial = $this->_rowsByHoja * $hoja;
		$rowFinal= $this->_rowsByHoja * ($hoja + 1);
		$index = -1;
		
  		foreach ($rsDetalle as $item)
  		{
  			$index++;
  			
  			if ($index >= $rowInicial && $index < $rowFinal)
  			{
  			    $this->putTextRight($item["rpdPiezas"], 188);
  			    // $this->putTextRight($item["detPartida"], 150);
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
  			    
  			    // $this->putText(10.5, "PT");
  			    // 	    $this->putText(17, "PIEZAS");
  			    // 	    $this->putText(174, "MTS");
  			    // 	    $this->putTextCenter("DESCRIPCI?N",-7);
  			    // 		$this->putTextRight("TOTAL", 17);
  			    
  			    $desc = $item["proTipoProducto"] . " " .
  		  			    $item["proAplicacion"] . " " .
  		  			    $item["proMaterial"] . " " .
  		  			    "CAL ". $item["proCalibre"];
  		  			    
  		  			    if ($item["proShortUnidad"] != 'PZA' && $item["proShortUnidad"] != 'KG' )
  		  			    {
  		  			        if ($item["proShortUnidad"] == 'ML')
  		  			        {
  		  			            $desc .= " ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  . " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  		  			        }
  		  			        else
  		  			        {
  		  			            $desc .= " ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  . " de ".$item["detCantidad"] . " ML (" . $item["detCantidadReal"] . " ".$item["proShortUnidad"].")";
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
  		  			    
  		  			    if ($item["proIdTipoProducto"] == "4")
  		  			    {
  		  			        $desc = $item["proDescAuto"];
  		  			    }
  		  			    
  		  			    if ($item["detIdProducto"] == 9)
  		  			    {
  		  			        //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
  		  			        $desc = "MOLDURA " . $item["rolloMolduraCodigo"];
  		  			        if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
  		  			        {
  		  			            $desc .= " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  		  			            $desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
  		  			        }

							if ($item["molLongitudinal"] == "A")
  		  		            {
  		  		            	$desc .= " \"DOBLECES A LO ANCHO\"";
  		  		            }
  		  			    }
  		  			    
  		  			    if ($item["detIdProducto"] == 10)
  		  			    {
  		  			        //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
  		  			        $desc = "MAQUILA DE MOLDURA  " . $item["molDescMaquila"] ." " . $item["rolloMolduraCodigo"];
  		  			        if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
  		  			        {
  		  			            $desc .= " de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
  		  			            $desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
  		  			        }
							
							if ($item["molLongitudinal"] == "A")
  		  		            {
  		  		                $desc .= " \"DOBLECES A LO ANCHO\"";
  		  		            }
  		  			    }

						if ($item["proIdTipoProducto"] == "4")
  		  		        {
  		  		        	$desc = $item["proDescAuto"];
  		  		        }
  		  			    
  		  			    //   			        $item["proMaterial"] . "   de ".$item["detCantidad"] . " (" . $item["detCantidadReal"] . " ". $item["proUnidad"] . ")";
  		  			    
  		  			    $desc = mb_strtoupper($desc);
  		  			    $desc = str_replace("--NO APLICA--", "", $desc);
  		  			    $desc = str_replace("-- NO APLICA --", "", $desc);
  		  			    $desc = str_replace("CAL 0", "", $desc);
  		  			    $desc = str_replace("   ", " ", $desc);
  		  			    $desc = str_replace("  ", " ", $desc);
  		  			    $desc = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');
  		  			    
  		  			    
  		  			    $totalML = 0;
  		  			    
  		  			    $this->putText(31.5, mb_convert_encoding($desc, 'UTF-8', 'ISO-8859-1');
  		  			    
  		  			    if ($item["proShortUnidad"] == "PZA")
  		  			    {
  		  			        // $this->putTextRight($item["proLongitud"], 33);
  		  			        // $totalML = $item["proLongitud"] * $item["valedeCantidad"];
  		  			        $totalML = $item["valedeCantidad"];
  		  			        $totalPiezas += $totalML;
  		  			    }
  		  			    else
  		  			    {
  		  			        // $this->putTextRight($item["detCantidad"], 33);
  		  			        if ($item["proShortUnidad"] == "ML")
  		  			        {
  		  			            $totalML = $item["detCantidad"] * $item["rpdPiezas"];
  		  			            $totalMetrosLineales += $totalML;
  		  			        }
  		  			        else
  		  			        {
  		  			            if ($item["proShortUnidad"] == "M2")
  		  			            {
  		  			                $totalML = $item["detCantidad"] * $item["rpdPiezas"];
  		  			                $totalMetrosCuadrados += $totalML;
  		  			            }
  		  			            else
  		  			            {
  		  			                $totalML = $item["rpdPiezas"];
  		  			                $totalKilos += $totalML;
  		  			            }
  		  			        }
  		  			        
  		  			    }
  		  			    
  		  			    
  		  			    
  		  			    // $this->putTextRight(number_format($item["detTotal"],2), 14.5);
  		  			    $this->putTextRight(number_format($totalML,2), 20);
  		  			    
  		  			    $this->SetFont('Arial','',7.5);
  		  			    $this->putTextRight($item["proShortUnidad"], 14.2);
  		  			    $this->SetFont('Arial','',9);
  		  			    
  		  			    $this->nextRow();
  		  			    $this->nextRow(-3);
  			}
  			
  			if ($item["proShortUnidad"] == "PZA")
  			{
  			    // $this->putTextRight($item["proLongitud"], 33);
  			    // $totalML = $item["proLongitud"] * $item["valedeCantidad"];
  			    $granTotalML = $item["valedeCantidad"];
  			    $granTotalPiezas += $granTotalML;
  			}
  			else
  			{
  			    // $this->putTextRight($item["detCantidad"], 33);
  			    if ($item["proShortUnidad"] == "ML")
  			    {
  			        $granTotalML = $item["detCantidad"] * $item["rpdPiezas"];
  			        $granTotalMetrosLineales += $granTotalML;
  			    }
  			    else
  			    {
  			        if ($item["proShortUnidad"] == "M2")
  			        {
  			            $granTotalML = $item["detCantidad"] * $item["rpdPiezas"];
  			            $granTotalMetrosCuadrados += $granTotalML;
  			        }
  			        else
  			        {
  			            $granTotalML = $item["rpdPiezas"];
  			            $granTotalKilos += $granTotalML;
  			        }
  			    }
  			    
  			}
  			
	    }
		
		$this->setCurrentY($yInicial+188);
		$this->putTextRight($this->_totalHojas == 1 ? "TOTALES" : "SUBTOTAL", 35);
		  
		$yTotales = 179;
		  
		//Metros Lineales
		if ($totalMetrosLineales > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalMetrosLineales,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("ML", 14.2);
			$this->SetFont('Arial','',10);
		}

		//Metros Cuadrados
		if ($totalMetrosCuadrados > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalMetrosCuadrados,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("M2", 14.2);
			$this->SetFont('Arial','',10);
		}
		
		//PIEZAS
		if ($totalPiezas > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalPiezas,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("PZA", 14.2);
			$this->SetFont('Arial','',10);
		}

		//kilos
		if ($totalKilos > 0)
		{
			$yTotales += 5;
			$this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
			$this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
			$this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
			$this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
			$this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);

			$this->setCurrentY($yInicial+$yTotales+4);
			$this->putTextRight(number_format($totalKilos,2), 20);
			$this->SetFont('Arial','',7.5);
			$this->putTextRight("KG", 14.2);
			$this->SetFont('Arial','',10);
		}
		
		
		if ($this->_totalHojas > 1 && $this->_totalHojas == ($hoja + 1))
		{
		    $this->setCurrentY(25 + $yTotales);
		    $this->putTextRight("TOTALES", 35);
		    
// 		    $yTotales = 179;
		    $yTotales += 5.5;
		    
		    //Metros Lineales
		    if ($granTotalMetrosLineales > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalMetrosLineales,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("ML", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		    
		    //Metros Cuadrados
		    if ($granTotalMetrosCuadrados > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalMetrosCuadrados,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("M2", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		    
		    //PIEZAS
		    if ($granTotalPiezas > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalPiezas,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("PZA", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		    
		    //kilos
		    if ($granTotalKilos > 0)
		    {
		        $yTotales += 5;
		        $this->Line(184, $yInicial+$yTotales, 202, $yInicial+$yTotales);
		        $this->Line(184, $yInicial+$yTotales, 184, $yInicial+$yTotales+5);
		        $this->Line(202, $yInicial+$yTotales, 202, $yInicial+$yTotales+5);
		        $this->Line(196, $yInicial+$yTotales, 196, $yInicial+$yTotales+5);
		        $this->Line(184, $yInicial+$yTotales+5, 202, $yInicial+$yTotales+5);
		        
		        $this->setCurrentY($yInicial+$yTotales+4);
		        $this->putTextRight(number_format($granTotalKilos,2), 20);
		        $this->SetFont('Arial','',7.5);
		        $this->putTextRight("KG", 14.2);
		        $this->SetFont('Arial','',10);
		    }
		}

		
  		
//   		$this->putText(10, "LR-101 RPP264NTER ");
//   		$this->putTextRight("1234", 160);
  		
  		
  		
  		// $this->SetDrawColor(73,139,235);
  		// $this->SetTextColor(73,139,235);
  		
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
  			
  			
  		}
  		else
  		{
  		    $this->SetFont('Arial','',7);
  		    $this->setCurrentY($yInicial + 193);
  		    $this->putText(10,"No nos hacemos responsables por los daños sufridos a la mercancía a consecuencia de un mal transporte, almacenaje e instalación.");
  		    $this->nextRow(-1);
  		    $this->putText(10,"Favor de consultar el FOLLETO GALVAMEX en la sección Manejo de Materiales para ver recomendaciones.");
  		}
		  
		  
		  if ($this->__imprimeTotales)
		  {
			$this->SetFont('Arial','B',8);
			$this->setCurrentY($yInicial + 188);
			$this->putText(11, "Total Pedido: $ " . number_format( $this->__total, 2) . "        Abonos: $ " . (number_format( $this->__total - $this->__saldo, 2))  . "       Saldo: $ " . number_format($this->__saldo,2));
		  }
		  
		  

		  $this->setCurrentY($yInicial + 208);

		  $this->SetFont('Arial','',8);

		  $this->putText(10, "PROMOTOR: ");
		  if ($this->__agente != $this->__agenteVendedor) 		  $this->putText(100, "VENDEDOR: ");		  
		  
		  $this->SetFont('Arial','B',8);
		  $this->putText(30, mb_strtoupper($this->__agente));
		  if ($this->__agente != $this->__agenteVendedor) 		  $this->putText(120, mb_strtoupper($this->__agenteVendedor));



		  $this->SetFont('Arial','B',8);
		  $this->nextRow();
		  $this->putTextCenter("NOTA: TODA DEVOLUCIÓN CAUSARÁ UN 20% DEL COSTO DEL PRODUCTO",-10);
		  $this->nextRow();
		  $this->putTextCenter("NOTA: La descarga va por cuenta del cliente.",-10);
  		
  		
	}
}

// Creaci?n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");


//$pdf->AliasNbPages();

// $pdf->SetFont('Times','',12);

//$pdf->setCurrentY(5);

$pedido = new ModeloPedido();
$despiece = new ModeloPedido();


$pedido->getValeSalida($idValeSalida);
$idPedido = $pedido->getValeSalidaDato("idPedido");
$despieceTerminado = $pedido->getValeSalidaDato("despieceTerminado");

if ($pedido->getValeSalidaDato("idCliente") == "137")
{
	$pdf->isMDM = true;
}

$pdf->__recogeEntrega = $pedido->getValeSalidaDato("recogeentrega");
$pdf->__sucursales = $pedido->getValeSalidaDato("sucursalNombre");

$pdf->__pagoVSEntrega = $pedido->getValeSalidaDato("pagoVSEntrega");

// echo "pedidovsentrega: ". $pedido->getValeSalidaDato("pagoVSEntrega");

$pdf->AddPage();


$pdf->__imprimeTotales = $imprimeTotales;

$pdf->__folio = $idValeSalida;
$pdf->__idPedido = $pedido->getValeSalidaDato("idPedido");
$pdf->__nombre =mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("cteNombre", 'ISO-8859-1', 'UTF-8') . " " . $pedido->getValeSalidaDato("cteApellidos")));
$pdf->__fecha = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("fecha_capturado", 'ISO-8859-1', 'UTF-8')));
$pdf->__domicilio = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("cteDomicilio1", 'ISO-8859-1', 'UTF-8') . " " . $pedido->getValeSalidaDato("cteDomicilio2") . " " . $pedido->getValeSalidaDato("cteNumero") . " " . $pedido->getValeSalidaDato("cteColonia")));
$pdf->__ciudad = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("cteCiudad", 'ISO-8859-1', 'UTF-8')));
$pdf->__rfc = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("cteRfc", 'ISO-8859-1', 'UTF-8')));
$pdf->__telefono = $pedido->getValeSalidaDato("cteTelefonos");
$pdf->__totalTexto = "";
$pdf->__conceptoAnticipo = "";


$pdf->__subtotal = doubleval($pedido->getValeSalidaDato("subtotal"));
$pdf->__iva = doubleval($pedido->getValeSalidaDato("iva"));
$pdf->__total = doubleval($pedido->getValeSalidaDato("total"));
$pdf->__saldo = doubleval($pedido->getValeSalidaDato("saldo"));

$pdf->__horaRecibe = $pedido->getValeSalidaDato("horaRecibe");
$pdf->__fechaCompromiso = $pedido->getValeSalidaDato("fechaCompromiso");

$pdf->__agente = $pedido->getValeSalidaDato("promoNombre") . " " . $pedido->getValeSalidaDato("promoAPaterno") . " " . $pedido->getValeSalidaDato("promoAMaterno");
$pdf->__agenteVendedor = $pedido->getValeSalidaDato("vendeNombre") . " " . $pedido->getValeSalidaDato("vendeAPaterno") . " " . $pedido->getValeSalidaDato("vendeAMaterno");

$pdf->_recibePersona = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("personaEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeDomicilio = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("domicilioEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeNumero = mb_convert_encoding(mb_strtoupper( $pedido->getValeSalidaDato("numeroEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeColonia = mb_convert_encoding(mb_strtoupper($pedido->getValeSalidaDato("coloniaEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeCiudad =mb_convert_encoding(mb_strtoupper( $pedido->getValeSalidaDato("ciudadEntrega", 'ISO-8859-1', 'UTF-8')));



$pdf->_observacionPedido = $pedido->getValeSalidaDato("observacionCaptura");


$pdf->__rangoCliente = $pedido->getPedidoDato("rangoCliente");

if ($pdf->__rangoCliente == "REGULAR")
{
    $pdf->__rangoCliente  = "";
}
else
{
    $pdf->__rangoCliente  = "CLIENTE " .$pdf->__rangoCliente ;
}

$hojasVale = 0;
$hojasDespiece = 0;

if ($despieceTerminado == 'SI')
{
	$despiece->getPedidoDespiece($idPedido);
	$hojasVale = ceil(count($pedido->__rsPedidoWDetalle)  / $pdf->_rowsByHoja);
	$hojasDespiece = ceil(count($despiece->__rsPedidoWDetalle)  / $pdf->_rowsByHoja);
	$pdf->_totalHojas = $hojasVale + $hojasDespiece;
	
}
else
{
	$pdf->_totalHojas = ceil(count($pedido->__rsPedidoWDetalle) / $pdf->_rowsByHoja);
}

$pdf->printDatosPedido($pedido->__rsPedidoWDetalle, 0);

for($h = 1 ; $h < $hojasVale ; $h++)
{
    $pdf->AddPage();
    $pdf->printDatosPedido($pedido->__rsPedidoWDetalle, $h);
    
    
}


// Despiece
if ($despieceTerminado == 'SI')
{
	

	$pdf->AddPage();
	$pdf->printDatosPedidoDespiece($despiece->__rsPedidoWDetalle,  0, $hojasVale);

	for($h = 1 ; $h < $hojasDespiece ; $h++)
	{
		$pdf->AddPage();
		$pdf->printDatosPedidoDespiece($despiece->__rsPedidoWDetalle, $h, $hojasVale);
		
		
	}
}
// Fin despiece


$vs = new ModeloValesalida();

$vs->setIdValeSalida( $idValeSalida);

if ($vs->getIdValeSalida() > 0)
{
	$vs->setYaImpresoSI();

	$vs->Guardar();
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