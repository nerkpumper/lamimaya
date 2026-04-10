<?php


//  echo " folder include: " . FOLDER_INCLUDE; return;

// define('FOLDER_INCLUDE2', '../../include/');

// define('FOLDER_INCLUDE2', 'C:/xampp/htdocs/appgalvamex/codigogalvamex/include/');
// define('FOLDER_INCLUDE2', 'C:/xampp/htdocs/appgalvamex/codigogalvamex/include/');

// define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');
// define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");
define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

// define("URL_JAVASCRIPT_LIB",URL_BASE . "js/lib/");

// echo FOLDER_INCLUDE2 . 'model/clsBasicCommon.inc.php';
 require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';

 require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
 require_once FOLDER_MODEL. "model.pedido.inc.php";
 require_once FOLDER_INCLUDE . 'lib/mail/class.phpmailer.php';
 


//  $archivo = FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';	
	
//  if (is_file($archivo))
// 	{
//  		$respuesta = array("error" => false, "msg" => "Si existe: " . $archivo);
// // 		$respuesta = array("error" => false, "msg" => "Todo bien");
// 	}
// 	else
// 	{
//  		$respuesta = array("error" => true, "msg" => "Error. No Existe: " . $archivo);
// // 		$respuesta = array("error" => true, "msg" => "Error");
// 	}
	
// 	echo json_encode($respuesta);	
	
// return;	

function salir(){
	echo "<script>

					window.close();
		</script>";
}

$idPedido = 0;

if (isset($_POST["idPedido"]) && $_POST["idPedido"] !== "") {
	$idPedido = $_POST["idPedido"];
}
else
{
	if (isset($_GET["idPedido"]) && $_GET["idPedido"] !== "") {
		$idPedido = $_GET["idPedido"];
	}
	else
	{
		// 	$idPedido = -666;
// 		$idPedido = -666;
		salir();
		exit();
	}

}

class PDF extends PDFNerk
{
	var $isMDM = false;
	
	var $yInicial = 10;
	
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
		 
		$this->SetTextColor(73,139,235);
		$this->SetDrawColor(73,139,235);
		$this->SetFillColor(224,238,254);
		 
		// $this->putTextCenter("GALVA MEX, S.A. DE C.V.", -10);
		 
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
		 
		$this->Line(57.5, $yInicial+42, 57.5, $yInicial+42+135);
	    $this->Line(67, $yInicial+42, 67, $yInicial+42+135);
	    $this->Line(182, $yInicial+42, 182, $yInicial+42+135);
		
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
		$this->putText(48, "PZAS");
		$this->putTextCenter("CONCEPTO");
		$this->putTextRight("TOTAL", 17);
		 
		 
		$this->RoundedRect(155, $yInicial + 182, 27, 22, 3, '14', 'DF');
		$this->RoundedRect(182, $yInicial + 182, 20, 22, 3, '23', 'D');
		$this->Line(155, $yInicial + 190, 202, $yInicial+190);
		$this->Line(155, $yInicial + 197, 202, $yInicial+197);
		 
		$this->SetFont('Arial','',10);
		 
		$this->setCurrentY($yInicial + 188);
		$this->putTextRight("SUB TOTAL", 35);
		$this->nextRow(3);
		$this->putTextRight("I.V.A", 35);
		 
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
		// Posici�n: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// N�mero de p�gina
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	function printDatosPedido($rsDetalle)
	{
		$yInicial = $this->yInicial;
		
		$this->setCurrentY($yInicial + 2);
		
		$this->SetDrawColor(73,139,235);
		
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
 		
 		$this->SetFont('Arial','',10);
 		
 		$this->setCurrentY($yInicial + 188);
 		$this->putTextRight(number_format($this->__subtotal, 2), 14.5);
  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__iva, 2), 14.5);
 		 
  		$this->SetFont('Arial','B',10);
 		 
  		$this->nextRow(3);
  		$this->putTextRight(number_format($this->__total, 2), 14.5);
  		
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
  			
  			$this->putTextRight(number_format($item["detTotal"],2), 14.5);
  			$this->nextRow();
  		}
  		
//   		$this->putText(10, "LR-101 RPP264NTER ");
//   		$this->putTextRight("1234", 160);
  		
  		
  		
  		$this->SetDrawColor(73,139,235);
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

$clienteMail = $pedido->getPedidoDato("cteEMail");
// $pdf->Output();

$bodyMail = "
		

<html>
<head>    
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Galvamex</title>
    
		<style>
	/* -------------------------------------
    GLOBAL
    A very basic CSS reset
------------------------------------- */
* {
    margin: 0;
    padding: 0;
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    box-sizing: border-box;
    font-size: 14px;
}

img {
    max-width: 100%;
}

body {
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: none;
    width: 100% !important;
    height: 100%;
    line-height: 1.6;
}

/* Let's make sure all tables have defaults */
table td {
    vertical-align: top;
}

/* -------------------------------------
    BODY & CONTAINER
------------------------------------- */
body {
    background-color: #f6f6f6;
}

.body-wrap {
    background-color: #f6f6f6;
    width: 100%;
}

.container {
    display: block !important;
    max-width: 600px !important;
    margin: 0 auto !important;
    /* makes it centered */
    clear: both !important;
}

.content {
    max-width: 600px;
    margin: 0 auto;
    display: block;
    padding: 20px;
}

/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.main {
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 3px;
}

.content-wrap {
    padding: 20px;
}

.content-block {
    padding: 0 0 20px;
}

.header {
    width: 100%;
    margin-bottom: 20px;
}

.footer {
    width: 100%;
    clear: both;
    color: #999;
    padding: 20px;
}
.footer a {
    color: #999;
}
.footer p, .footer a, .footer unsubscribe, .footer td {
    font-size: 12px;
}

/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1, h2, h3 {
    font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
    color: #000;
    margin: 40px 0 0;
    line-height: 1.2;
    font-weight: 400;
}

h1 {
    font-size: 32px;
    font-weight: 500;
}

h2 {
    font-size: 24px;
}

h3 {
    font-size: 18px;
}

h4 {
    font-size: 14px;
    font-weight: 600;
}

p, ul, ol {
    margin-bottom: 10px;
    font-weight: normal;
}
p li, ul li, ol li {
    margin-left: 5px;
    list-style-position: inside;
}

/* -------------------------------------
    LINKS & BUTTONS
------------------------------------- */
a {
    color: #1ab394;
    text-decoration: underline;
}

.btn-primary {
    text-decoration: none;
    color: #FFF;
    background-color: #1ab394;
    border: solid #1ab394;
    border-width: 5px 10px;
    line-height: 2;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    display: inline-block;
    border-radius: 5px;
    text-transform: capitalize;
}

/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
    margin-bottom: 0;
}

.first {
    margin-top: 0;
}

.aligncenter {
    text-align: center;
}

.alignright {
    text-align: right;
}

.alignleft {
    text-align: left;
}

.clear {
    clear: both;
}

/* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
------------------------------------- */
.alert {
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    padding: 20px;
    text-align: center;
    border-radius: 3px 3px 0 0;
}
.alert a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
}
.alert.alert-warning {
    background: #f8ac59;
}
.alert.alert-bad {
    background: #ed5565;
}
.alert.alert-good {
    background: #1ab394;
}

/* -------------------------------------
    INVOICE
    Styles for the billing table
------------------------------------- */
.invoice {
    margin: 40px auto;
    text-align: left;
    width: 80%;
}
.invoice td {
    padding: 5px 0;
}
.invoice .invoice-items {
    width: 100%;
}
.invoice .invoice-items td {
    border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 700;
}

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
@media only screen and (max-width: 640px) {
    h1, h2, h3, h4 {
        font-weight: 600 !important;
        margin: 20px 0 5px !important;
    }

    h1 {
        font-size: 22px !important;
    }

    h2 {
        font-size: 18px !important;
    }

    h3 {
        font-size: 16px !important;
    }

    .container {
        width: 100% !important;
    }

    .content, .content-wrap {
        padding: 10px !important;
    }

    .invoice {
        width: 100% !important;
    }
}
   </style>
		
</head>

<body>

<table class='body-wrap'>
    <tr>
        <td></td>
        <td class='container' width='600'>
            <div class='content'>
                <table class='main' width='100%' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td style='background: #1ab394; font-size: 16px;    color: #fff;    font-weight: 500;    padding: 20px;    text-align: center;    border-radius: 3px 3px 0 0;'>
                            Gracias por su preferencia
                        </td>
                    </tr>
                    <tr>
                        <td class='content-wrap'>
                            <table width='100%' cellpadding='0' cellspacing='0'>
								<tr>
									<td>
										<img src='http://app.galvamex.com.mx/img/galvalogo.jpeg'/>
									</td>									
								</tr>
                                <tr>
                                    <td class='content-block'>
                                        Este correo ha sido generado de manera autom&aacute;tica.
                                    </td>
                                </tr>
                                <tr>
                                    <td class='content-block'>
                                        Adjunto se encuentra un pdf conteniendo los datos de su pedido, favor de no responder este correo, ya que se no es gestionado por alguna persona en particular.
                                    </td>
                                </tr>
                               
                              
                            </table>
                        </td>
                    </tr>
                </table>
                <div class='footer'>
                    <table width='100%'>
                        <tr>
                            <td class='aligncenter content-block'><a href='http://galvamex.com.mx'>Galvamex</a></td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
		


		";


// echo "vamos a enviar correo a : " .$clienteMail;
// echo "<br>".FOLDER_INCLUDE2 . 'lib/mail/class.phpmailer.php'."<br>";

// $clienteMail = "juan.urrutiar@outlook.com";
if ($clienteMail != "")
{   
	$email = new PHPMailer();
	
// 	$email->From      = 'noresponder@galvamex.com';
// 	$email->FromName  = 'Galva Mex';
// 	$email->Subject   = 'Galva Mex Pedido: ' . $idPedido;
// 	$email->IsHTML(true);
// 	$email->Body      = $bodyMail;
// // 	$email->AddAddress( $clienteMail);
// 	$email->AddAddress( 'juan.urrutiar@outlook.com' );

	
// SMTP configuration
$email->isSMTP();
    
//     $email->SMTPDebug = SMTP::DEBUG_SERVER;
    $email->SMTPDebug = 2;
    
    $email->Host = 'SMTP.Office365.com'; //'smtp.gmail.com';
    
    
    $email->SMTPSecure = 'tls';
    $email->Port = 587;
    
    
    //Set the encryption mechanism to use - STARTTLS or SMTPS
//     $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //Whether to use SMTP authentication
    $email->SMTPAuth = true;
    
    
    $email->Username = 'gm191109@outlook.com';
    $email->Password = 'GalvaMailer#12358';
        
    $email->From      = 'gm191109@outlook.com';
    $email->FromName  = 'Galvamex';
    $email->Subject   = 'Galvamex Pedido: ' . $idPedido;
    $email->IsHTML(true);
    $email->Body      = $bodyMail;
    $email->AddAddress( $clienteMail);
    // $email->AddAddress( 'juan.urrutiar@outlook.com' );
    $email->AddBCC ( 'juan.urrutiar@outlook.com' );
	
// SMTP configuration
// 	$email->isSMTP();
	
// 	//     $email->SMTPDebug = SMTP::DEBUG_SERVER;
// 	$email->SMTPDebug = 2;
	
// 	$email->Host = 'SMTP.Office365.com'; //'smtp.gmail.com';
	
	
// 	$email->SMTPSecure = 'tls';
// 	$email->Port = 587;

// 	$email->SMTPAuth = true;
	
	
// 	$email->Username = 'gm191109@outlook.com';
// 	$email->Password = 'GalvaMailer#12358'; //'NerkPotter#12358';
	
// 	$email->From      = 'gm191109@outlook.com';
// 	$email->FromName  = 'Galvamex';
// 	$email->Subject   = 'Galvamex Pedido: ' . $idPedido;
// 	$email->IsHTML(true);
// 	$email->Body      = $bodyMail;
// 	// 	$email->AddAddress( $clienteMail);
// 	$email->AddAddress( 'juan.urrutiar@outlook.com' );
// 	$email->AddBCC ( 'juan.urrutiar@outlook.com' );
	
// 	$email->AddAddress( 'juan.urrutiar@outlook.com');	
	
	$doc=$pdf->Output('S');
	$email->AddStringAttachment($doc, 'Galvamex_Pedido_'.$idPedido.'.pdf', 'base64', 'application/pdf');
	//$mail->Send();
	
	$result = $email->Send();
// 	var_dump($result);
	//$result = 333;
	if ($result == 1)
	{
		//$respuesta = array("error" => false, "msg" => "Todo bien " . $idPedido . " res= " . $result);
		//
		echo "
			<div class=' text-center animated fadeInDown'>
        <h1>&Eacute;xito</h1>
        <h3 class='font-bold'>Correo enviado a ".$clienteMail."</h3>
    </div>
		
		
			<script>
					//saTextoAndTitle('Pedido Enviado','Se ha enviado Pedido a Cliente via EMail');
					setTimeout(function(){window.close();}, 3000);
		
		</script>
		
			";
	}
	else
	{
		//$respuesta = array("error" => true, "msg" => "Errooooroorororororororororororororoororrrrrr");
		echo "
			<div class=' text-center animated fadeInDown'>
        <h1>Error</h1>
        <h3 class='font-bold'>Ha ocurrido un error al intentar enviar el correo electr&oacutenico.</h3>
    </div>
	
	
	
			";
	}	
}
else
{
	echo "
	<div class=' text-center animated fadeInDown'>
	<h1>Error</h1>
	<h3 class='font-bold'>No se ha registrado un Correo al Cliente.</h3>
	</div>
	
	";
}




//echo json_encode($respuesta);