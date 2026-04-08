<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.otroscargospedido.inc.php";

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
	
	var $_totalHojas = 1;
	var $_rowsByHoja = 25;
	
	var $__rangoCliente = "";
	var $__PlanProteccion = "";
	
	var $yInicial = 10; 
	var $idProductoMoldura = 386; 
	var $idProductoMaquila = 394; 
	
	var $__idUsoCfdi = 0;
	
	var $__recogeEntrega = "";
	
	var $__agente = "";
	
	var $__folio = "";
	var $__idCotizacion = "";
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
	var $__descuento = 0;
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
	
	var $__fechaAbierta;
	var $__pedidoExpress;
	
	
	var $__sucursales = "";
	
	// Cabecera de p�gina
	function Header()
	{
		$yInicial = $this->yInicial;
		
	    // Logo
	    $this->Image('img/galvalogo.jpeg',8,$yInicial-3 ,50);
	    // Arial bold 15
	    $this->SetFont('Arial','B',13);
	    
// 	    $this->setCurrentY($this->GetPageHeight()/2);
// 	    $this->putText(10, "mita");  

	    
	    
	    $this->setCurrentY($yInicial-5);
	    
	    $this->SetTextColor(160,120,74);
	    $this->SetDrawColor(160,120,74);
	    $this->SetFillColor(245,236,215);
	    
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
	    
	    $this->SetFont('Arial','B',11);
	    
	    $this->setCurrentY($yInicial + 2);
	    $this->putTextRight("PEDIDO", 60);
	    $this->putTextRight("COTIZACION", 20);
	    
	    $this->Rect(157, $this->currentY - 5, 7, 7, "D");
	    $this->Rect(197, $this->currentY - 5, 7, 7, "D");
	    
	    
	
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
	    	 
	    	
			$this->Line(23, $yInicial+42, 23, $yInicial+42+135);
			$this->Line(62, $yInicial+42, 62, $yInicial+42+135);
			$this->Line(164, $yInicial+42, 164, $yInicial+42+135);
	    	$this->Line(182, $yInicial+42, 182, $yInicial+42+135);
	    	
	    	//observaciones
	    	$this->RoundedRect(10, $yInicial + 205, 192, 4, 3, '', 'DF');
	    	$this->RoundedRect(10, $yInicial + 205, 192, 11, 3, '', 'D');
	    	
	    	$this->SetFont('Arial','B',9);
	    	$this->setCurrentY($yInicial + 208);
	    	$this->putTextCenter("O B S E R V A C I O N E S");
	    	
	    	//Consignaci�n
	    	if ($this->__recogeEntrega == "ENTREGA")
	    	{
	    		$this->RoundedRect(10, $yInicial + 217, 192, 4, 3, '', 'DF');
	    		$this->RoundedRect(10, $yInicial + 217, 192, 35, 3, '', 'D');
	    		
	    		$this->SetFont('Arial','B',9);
	    		$this->setCurrentY($yInicial + 220);
	    		$this->putTextCenter("C O N S I G N A C I Ó N");
	    		
	    		$this->SetFont('Arial','',8);
	    		$this->setCurrentY($yInicial + 228);
	    		 
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
	    		$this->putTextCenter("FECHA ENTREGA:", -32);
	    		$this->putTextCenter("FECHA ABIERTA:", 28);
	    		$this->putTextCenter("EXPRESS:", 70);
	    		$this->nextRow(-3);
	    		$this->putText(37, "_______________                                     ____________________                                    __________                          _________");
	    		
	    		$this->SetFont('Arial','',7);
	    		$this->nextRow(1);
// 	    		$this->setCurrentY($yInicial + 221);
	    		$this->putText(10,"La salida del pedido de la planta se realiza después del pago total.");
	    		$this->nextRow(-1);
	    		$this->putText(10,"No nos hacemos responsables por los daños sufridos a la mercancía a consecuencia de un mal transporte, almacenaje e instalación.");
	    		$this->nextRow(-1);
	    		$this->putText(10,"Favor de consultar el FOLLETO GALVAMEX en la sección Manejo de Materiales para ver recomendaciones.");
	    	}
	    	else
	    	{
	    	    $this->SetFont('Arial','',7);
	    	    $this->setCurrentY($yInicial + 221);
	    	    $this->putText(10,"La salida del pedido de la planta se realiza después del pago total.");
	    	    $this->nextRow(-1);
	    	    $this->putText(10,"No nos hacemos responsables por los daños sufridos a la mercancía a consecuencia de un mal transporte, almacenaje e instalación.");
	    	    $this->nextRow(-1);
	    	    $this->putText(10,"Favor de consultar el FOLLETO GALVAMEX en la sección Manejo de Materiales para ver recomendaciones.");
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
		 $this->putText(11, "CANT.");
		 $this->putText(35, "CÓDIGO");
		 $this->putText(100,"CONCEPTO");
		 $this->putTextRight("PRECIO",36 );
		 $this->putTextRight("IMPORTE", 16);
	    
	    $this->RoundedRect(155, $yInicial + 178, 27, 26, 3, '14', 'DF');    
	    $this->RoundedRect(182, $yInicial + 178, 20, 26, 3, '23', 'D');
	    $this->Line(155, $yInicial + 184, 202, $yInicial+184);
	    $this->Line(155, $yInicial + 190.5, 202, $yInicial+190.5);
	    $this->Line(155, $yInicial + 197, 202, $yInicial+197);
	    
	    $this->SetFont('Arial','',10);
	    
	    $this->setCurrentY($yInicial + 182);
	    $this->putTextRight("SUB TOTAL", 35);
	    $this->nextRow(3);
	    $this->putTextRight("I. V. A.", 35);
	    $this->nextRow(2.5);
	    
	    if ($this->__idUsoCfdi == "99")
	    {
	        $this->SetFont('Arial','',8);
	        
	        $this->putTextRight("DESCTO. BUEN FIN", 34);
	        
	        $this->SetFont('Arial','',10);
	    }
	    else
	    {
	        $this->putTextRight("DESCUENTO", 35);
	    }
	    
	    
// 	    $this->putTextRight("OTROS", 35);
	    
	    $this->SetFont('Arial','B',10);    
	    
	    $this->nextRow(3);
	    $this->putTextRight("T O T A L  $", 35);
	    
	    
	    
	    //leyendas lado izquierdo
	    $this->SetFont('Arial','',8);
	    $this->setCurrentY($yInicial + 183);
	     
	    $this->putText(10, "Recibimos la cantidad $");	    
	    $this->nextRow(-3);
	    $this->putText(41, "________________________________________________________________");
	    
	    $this->nextRow();	    
	    $this->putText(10, "(");
	    $this->putText(141, ")");
	    $this->nextRow(-3);
	    $this->putText(11, "___________________________________________________________________________________");
	    
	    $this->nextRow();	    
	    $this->putText(10, "Por concepto de anticipo $");
	    $this->nextRow(-3);
	    $this->putText(44, "______________________________________________________________");
	    
	    $this->nextRow();	    
	    $this->putText(10, "Saldo $");
	    $this->nextRow(-3);
	    $this->putText(21, "_____________________________________________________________________________");
	    
	    $this->SetFont('Arial','B',8);
	    $this->nextRow();
	    $this->putText(10, "Nota: Una vez confirmado el pedido no hay cambios ni devoluciones.");
	    
	    if ($this->__recogeEntrega == "ENTREGA")
	    {
	    	$this->setCurrentY($yInicial + 256);
	    }
	    else
	    {	    
	    	$this->setCurrentY($yInicial + 235);
	    }
	    
	    $this->SetFont('Arial','',8);
	    $this->nextRow(5);
	    $this->putText(15, "Agente:                                                                                                   Cliente:                     ");	    
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
	
	function printDatosPedido($rsDetalle, $rsOcp, $hoja)
	{
		$yInicial = $this->yInicial;
		
		$this->setCurrentY($yInicial + 2);
		
		$this->SetDrawColor(200,169,110);
		
		if ($this->__isPedido)
		{
			$this->Line(157, $this->currentY - 5, 164, $this->currentY + 2);
			$this->Line(157, $this->currentY + 2, 164, $this->currentY - 5);
		}
		else
		{
			$this->Line(197, $this->currentY - 5, 204, $this->currentY + 2);
			$this->Line(197, $this->currentY + 2, 204, $this->currentY - 5);
		}
		
		$this->SetFont('Arial','B',11);
		
		$this->SetTextColor(255,0,0);
		$this->setCurrentY($yInicial + 14);
		$this->putTextRight("No.", 40);
		$this->putText(182, $this->__folio);
		
		$this->setCurrentY($yInicial + 10);
		//$this->putTextRight("No.", 40);
		$this->putText(145, $this->__recogeEntrega);
		
		$this->setCurrentY($yInicial + 20);
		//$this->putTextRight("No.", 40);
		$this->putText(10, $this->__rangoCliente . $this->__PlanProteccion);
		
		
		$this->SetTextColor(200,169,110);
		$this->SetFont('Arial','',7);

		$this->setCurrentY($yInicial + 5);
		$this->putText(172, $this->__idCotizacion);

		
		$this->SetFont('Arial','',8);
		$this->setCurrentY($yInicial + 25);
		
		 
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
 		
 		if ($this->_totalHojas > 1)
 		{
     		$this->setCurrentY($yInicial + 18);
     		$this->putTextRight("Hoja: ", 40);
     		$this->putText(182,($hoja+1) ." / " .$this->_totalHojas); 		    
 		}
 		
 		
  		
  		$this->setCurrentY($yInicial + 53);
  		$this->SetFont('Arial','',10);
  		$this->SetTextColor(200,169,110);
  		
//   		for($iii = 0 ; $iii < 40 ; $iii++)
//   		{
//   			$this->putText(29, $iii);
//   			$this->nextRow();
//   		}
  		
        $rowInicial = $this->_rowsByHoja * $hoja;
        $rowFinal= $this->_rowsByHoja * ($hoja + 1);
        $index = -1;

  		$auxCodigo = "";
  		
  		foreach ($rsDetalle as $item)
  		{
  		    $index++;
  		    
  		    if ($index >= $rowInicial && $index < $rowFinal)
  		    {
  		        if ($item["detIdProducto"] != "")
  		        {
  		            $this->SetFont('Arial','',7);
  		            
  		            if ($item["detIdProducto"] == $this->idProductoMoldura || $item["detIdProducto"] == $this->idProductoMaquila)
  		            {
  		                //   		        $auxCodigo = "LLOSACERO RGA224NTERG37";
  		                //   		        $auxCodigo = "12345678911234567892123456789312345";
  		                if ($item["detIdProducto"] == $this->idProductoMoldura)
  		                {
  		                   $auxCodigo = $item["proCodigo"] . " " . $item["rolloMolduraCodigo"];
  		                }
  		                else
  		                {
  		                   $auxCodigo = $item["proCodigo"] . "" .substr($item["molDescMaquila"], 0, 25).'..'; ;
  		                }
  		                
  		                
  		                if (strlen($auxCodigo) > 20 && strlen($auxCodigo) <= 27)
  		                {
  		                    $this->SetFont('Arial','',7);
  		                }
  		                else
  		                {
  		                    if (strlen($auxCodigo) > 27 && strlen($auxCodigo) <= 30)
  		                    {
  		                        $this->SetFont('Arial','',7);
  		                    }
  		                    else
  		                    {
  		                        if (strlen($auxCodigo) > 30 )
  		                        {
  		                            $this->SetFont('Arial','',6);
  		                        }
  		                    }
  		                }
  		                
  		                $this->putText(24, $auxCodigo);
  		                
  		            }
  		            else
  		            {
  		                //   		        $item["proCodigo"] = "LLOSACERO RGA224NTERG37";
  		                $auxCodigo = $item["proCodigo"];
  		                
  		                if (strlen($auxCodigo) > 20 && strlen($auxCodigo) <= 27)
  		                {
  		                    $this->SetFont('Arial','',7);
  		                }
  		                else
  		                {
  		                    if (strlen($auxCodigo) > 27 && strlen($auxCodigo) <= 30)
  		                    {
  		                        $this->SetFont('Arial','',7);
  		                    }
  		                    else
  		                    {
  		                        if (strlen($auxCodigo) > 30 )
  		                        {
  		                            $this->SetFont('Arial','',6);
  		                        }
  		                    }
  		                }
  		                
  		                $this->putText(24, $auxCodigo);
  		                
  		            }
  		            
  		            $this->putText(11, $item["detPartida"]);
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
  		            
					$desc2 = "";
  		            $desc = $item["proTipoProducto"] . " " .
  		  		            $item["proAplicacion"] . " " .
								$item["proMaterial"] . " " .							
								($item["rolloProveedor"] == "TERNIUM" ? $item["rolloProveedor"] : "") . " " .	
  		  		            "CAL ". $item["proCalibre"]. " ";
  		  		            
	

  		  		            if ($item["proShortUnidad"] != 'PZA' && $item["proShortUnidad"] != 'KG' )
  		  		            {
  		  		                if ($item["proShortUnidad"] == 'ML')
  		  		                {
									// $desc .=" ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  ." de ".$item["detCantidad"] . " " . $item["proShortUnidad"];
									if ($this->__recogeEntrega == 'OBRA' && $item["mlDespachado"] != $item["detCantidad"] )
									{
										$desc2 = " ML Original ". $item["detCantidad"] . " " ;							
									}

									if ($this->__recogeEntrega == 'OBRA')
									{
										$desc .=" ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  ." de ".$item["mlDespachado"] . " " . $item["proShortUnidad"];								
									}
									elseif($item["proAplicacion"] != 'PANEL' )
									{
										$desc .=" ". $item["rolloPies"]. " PIES ". ( $item["idColor"] > 1 ? $item["color"] : "")  ." de ".$item["detCantidad"] . " " . $item["proShortUnidad"];								
									}else				
									{
									 	$desc .= " " .$item["proMedidaEspecial"] ." PULGADAS DE " .$item["detCantidad"]." ML";
									} 
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
  		  		                    $desc = "[KG] ". $desc." ".$item["rolloPies"]. " PIES" ;
  		  		                }
  		  		                else
  		  		                {
									if ($item["proShortUnidad"] == 'PZA' )
									{
										if ($item["proMedidaEspecial"] != "")
										{
											$desc .= " " .$item["proMedidaEspecial"];

											if($item["proMaterial"] == "HIASA MURO" || $item["proMaterial"] == "HIASA CUBIERTA")
											{
												$desc .= " MM" ;
											}
											else
											{

												switch($item["proIdMaterial"])
													{
													case "29": 
													case "17": 
													case "28": 
													case "31": 
													case "30": 
													case "11": 
													case "35": 
													case "36": 
													case "37": 
													case "38":
														$desc .= " PULGADAS";
														break;
												}
											}
										}
									}

  		  		                    if ($item["proLongitud"] != "" )
  		  		                    {
  		  		                        $desc .=" de ".$item["proLongitud"] ." ML";
  		  		                    }
									
									if ($item["rolloPies"] != "" && $item["rolloPies"] > "0")
  		  		                    {
  		  		                        $desc .= " ".$item["rolloPies"]. " PIES" ;
  		  		                    }
  		  		                }
  		  		            }
  		  		            
  		  		            //   			if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
  		  		            //   			{
  		  		            //   				$desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
  		  		            //   			}
  		  		            
  		  		            if ($item["detIdProducto"] == $this->idProductoMoldura)
  		  		            {
  		  		                //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
  		  		                $desc = "MOLDURA ";
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
  		  		            
  		  		            if ($item["detIdProducto"] == $this->idProductoMaquila)
  		  		            {
  		  		                //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
  		  		                $desc = "MAQUILA DE MOLDURA ";
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
  		  		            $desc = ($desc);
  		  		            
  		  		            if ($item["curvar"] == 'SI')
  		  		            {
  		  		                $desc = $desc . " (Combar: " . $item["curvatura"] . ")";
  		  		            }
  		  		            
  		  		            $this->putText(63, ($desc));
  		  		            //   		  		        if ($item["detIdProducto"] == null)
  		  		                //   		  		        {
  		  		                //   		  		            $this->putText(67.5, "NULL");
  		  		                //   		  		        }
  		  		            //   		  		        else
  		  		                //   		  		        {
  		  		                //   		  		            $this->putText(67.5, "no null");
  		  		                //   		  		        }
  		  		            
							$detPrecioUnitario =$item["detPrecioUnitario"]/1.16;
							$detTotalSinIva = $item["detTotal"];
							$detTotalSinIva = $detTotalSinIva / 1.16;
  		  		            $this->putTextRight('$'.number_format($detPrecioUnitario,2), 35);
  		  		            $this->putTextRight('$'.number_format($detTotalSinIva,2), 14.5);

  		  		            $this->nextRow();

							if ($desc2 != '')
							{
								$this->SetFont('Arial','',8);
								$this->putText(125.5, $desc2);
								$this->SetFont('Arial','',10);
								$this->nextRow();
							}

							
  		        }
  		    }
  		    
  		    
  		    
  		    
  		    
  		    
  		}
  		
  		if (($hoja+1)  == $this->_totalHojas)
  		{
  		    $this->nextRow();
  		    $this->nextRow();
  		}
  		
  		
  		    $sumOtrosCargos = 0;
  		    
  		    foreach ($rsOcp as $item)
  		    {
  		        $sumOtrosCargos += $item["monto"];
  		        
  		        
  		        if (($hoja+1)  == $this->_totalHojas)
  		        {
  		            
  		            
      		        if ($item["ingreso"] == "OTRO")
      		        {
      		            $this->putTextRight($item["cantidadIngreso"], 150);
      		            $this->putText(67.5, ( $item["descripcion"]) . " (" . $item["solicitar"] .")");
      		        }
      		        else
      		        {
      		            $this->putText(67.5, ( $item["descripcion"]));
      		        }
      		        
      		        
      		        
      		        
      		        
      		        $this->putTextRight(number_format($item["monto"]/1.16,2), 14.5);
      		        $this->nextRow();
  		        }
  		    }
  		
  		
  		
  		
  		
  		
//   		$this->putText(10, "LR-101 RPP264NTER ");
//   		$this->putTextRight("1234", 160);
  		
  		
  		
  		$this->SetFont('Arial','',10);
  		
  		$this->setCurrentY($yInicial + 182);
  		$this->putTextRight(number_format($this->__subtotal + ($sumOtrosCargos/1.16), 2), 14.5);
  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__iva+ ($sumOtrosCargos/1.16)*.16, 2), 14.5);
//   		$this->putTextRight(number_format($sumOtrosCargos, 2), 14.5);

  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__descuento, 2), 14.5);
  		
  		$this->SetFont('Arial','B',10);
  		
  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__total, 2), 14.5);
  		
  		$this->SetDrawColor(200,169,110);
  		$this->SetTextColor(200,169,110);
  		
  		$this->SetFont('Arial','',8);
  		
  		if ($this->__recogeEntrega == "ENTREGA")
  		{
  			$this->setCurrentY($yInicial + 228);
  			$this->putText(40, mb_strtoupper($this->_recibePersona));
  			
  			$this->nextRow();
  			$this->nextRow(-1);
  			$this->putText(30, mb_strtoupper($this->_recibeDomicilio));
  			
  			$this->nextRow();
  			$this->nextRow(-1);
  			$this->putText(28, mb_strtoupper($this->_recibeNumero));
  			$this->putText(87, mb_strtoupper($this->_recibeColonia));
  			$this->putText(152, mb_strtoupper($this->_recibeCiudad));
  			
  			
  			$this->setCurrentY($yInicial + 249);
  			
  			
  			$this->__fechaCompromiso = str_replace("0000-00-00", "", $this->__fechaCompromiso);
  			$this->__fechaCompromiso = str_replace("00:00:00", "", $this->__fechaCompromiso);
  			
  			//   	$this->putTextRight(substr($this->__fechaCompromiso, 0, 10) . "  " . $this->__horaRecibe, 35);
  			$this->putText(40, $this->__horaRecibe);
  			$this->putText(93, $this->__fechaCompromiso);
  			$this->putText(153, $this->__fechaAbierta);
  			$this->putText(190, $this->__pedidoExpress);
  			
  			$this->setCurrentY($yInicial + 265);
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

$ocp = new ModeloOtroscargospedido();

$lstOcp = $ocp->getAll("otroscargospedido.*, oc.descripcion, oc.ingreso, oc.solicitar",
                       "inner join otrocargo as oc
                        on oc.idotrocargo = otroscargospedido.idotrocargo",
                       "idpedido = " . $idPedido);

if ($pedido->getPedidoDato("idCliente") == "137")
{
	$pdf->isMDM = true;
}

$pdf->__idUsoCfdi = doubleval($pedido->getPedidoDato("idUsoCfdi"));
$pdf->__recogeEntrega = $pedido->getPedidoDato("recogeentrega");

$lstSucursales = $pedido->getDataSet("
    
                    select distinct pedidodetallecolocacion.idsucursal, sucursal.nombre
                    from pedidodetalle
                    inner join pedidodetallecolocacion on pedidodetalle.idpedidodetalle = pedidodetallecolocacion.idpedidodetalle
                    inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal
                    where pedidodetalle.idpedido = ".$idPedido." and pedidodetallecolocacion.cantidad > 0;
    
                ");



$arrSuc = array();
foreach ($lstSucursales as $suc)
{
    
    array_push($arrSuc, $suc["nombre"]);
}



$pdf->__sucursales = implode(",", $arrSuc);

$pdf->AddPage();



$pdf->__folio = $idPedido;
$pdf->__idCotizacion = $pedido->getPedidoDato("idcotizacion");
$pdf->__nombre =mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteNombre", 'ISO-8859-1', 'UTF-8') . " " . $pedido->getPedidoDato("cteApellidos")));
$pdf->__fecha = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("fecha_capturado", 'ISO-8859-1', 'UTF-8')));
$pdf->__domicilio = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteDomicilio1", 'ISO-8859-1', 'UTF-8') . " " . $pedido->getPedidoDato("cteDomicilio2") . " " . $pedido->getPedidoDato("cteNumero") . " " . $pedido->getPedidoDato("cteColonia")));
$pdf->__ciudad = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteCiudad", 'ISO-8859-1', 'UTF-8')));
$pdf->__rfc = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("cteRfc", 'ISO-8859-1', 'UTF-8')));
$pdf->__telefono = $pedido->getPedidoDato("cteTelefonos");
$pdf->__totalTexto = "";
$pdf->__conceptoAnticipo = "";
$pdf->__saldo = "";	


//se desgloza el iva del subtotal, ya que en sistema esta incluido
$pdf->__subtotal = doubleval($pedido->getPedidoDato("subtotal"));
$pdf->__iva = (16 * $pdf->__subtotal / 116); //doubleval($pedido->getPedidoDato("iva"));
$pdf->__subtotal = $pdf->__subtotal - $pdf->__iva;
$pdf->__descuento = doubleval($pedido->getPedidoDato("descuento"));
$pdf->__total = doubleval($pedido->getPedidoDato("total"));

$pdf->__horaRecibe = $pedido->getPedidoDato("horaRecibe");
$pdf->__fechaCompromiso = $pedido->getPedidoDato("fechaCompromiso");

$pdf->__agente = $pedido->getPedidoDato("capturadoNombre") . " " . $pedido->getPedidoDato("capturadoAPaterno") . " " . $pedido->getPedidoDato("capturadoAMaterno");
// $pdf->__agente = $pedido->getPedidoDato("promoNombre") . " " . $pedido->getPedidoDato("promoAPaterno") . " " . $pedido->getPedidoDato("promoAMaterno");

$pdf->_recibePersona = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("personaEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeDomicilio = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("domicilioEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeNumero = mb_convert_encoding(mb_strtoupper( $pedido->getPedidoDato("numeroEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeColonia = mb_convert_encoding(mb_strtoupper($pedido->getPedidoDato("coloniaEntrega", 'ISO-8859-1', 'UTF-8')));
$pdf->_recibeCiudad =mb_convert_encoding(mb_strtoupper( $pedido->getPedidoDato("ciudadEntrega", 'ISO-8859-1', 'UTF-8')));

$pdf->__fechaAbierta = mb_convert_encoding(mb_strtoupper( $pedido->getPedidoDato("fechaAbierta", 'ISO-8859-1', 'UTF-8')));
$pdf->__pedidoExpress = mb_convert_encoding(mb_strtoupper( $pedido->getPedidoDato("pedidoExpress", 'ISO-8859-1', 'UTF-8')));

$pdf->_observacionPedido = $pedido->getPedidoDato("observacionCaptura");

$pdf->__rangoCliente = $pedido->getPedidoDato("rangoCliente");

if ($pdf->__rangoCliente == "REGULAR")
{
    $pdf->__rangoCliente  = "";
}
else
{
    $pdf->__rangoCliente  = "CLIENTE " .$pdf->__rangoCliente ;
}

if ($pedido->getPedidoDato("planProteccion") == "SI")
{
	$pdf->__PlanProteccion = " - PEDIDO BAJO PLAN PROTECCION";
}



$pdf->_totalHojas = ceil(count($pedido->__rsPedidoWDetalle) / $pdf->_rowsByHoja);


$pdf->printDatosPedido($pedido->__rsPedidoWDetalle, $lstOcp, 0);

for($h = 1 ; $h < $pdf->_totalHojas ; $h++)
{
    $pdf->AddPage();
    $pdf->printDatosPedido($pedido->__rsPedidoWDetalle, $lstOcp, $h);
    
    
}

$pdf->Output();