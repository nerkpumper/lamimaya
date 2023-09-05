<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.rutaenviovehiculo.inc.php";



// cliente MDM 137

function salir(){
	echo "<script>

					window.close();
		</script>";
}

$idRutaEnvioVehiculo = 0;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$idRutaEnvioVehiculo = $_GET["id"];
}
else
{
	$idRutaEnvioVehiculo = -666;
	//salir();
	//exit();
}

class PDF extends PDFNerk
{
	var $isMDM = false;
	
	var $_totalHojas = 1;
	var $_rowsByHoja = 6;
	
	var $yInicial = 10; 

	var $_estatus = '';
    var $_unidad = '';
    var $_fechaSalida = '';
    var $_horaSalida = '';    
    var $_fechaLlegada = '';
    var $_horaLlegada = '';
    var $_kmInicial = '';
    var $_kmFinal = '';
    var $_litros = '';
    var $_tipoCombustible = '';

    var $_folio = "";
	
	
	// Cabecera de p�gina
	function Header()
	{
		$yInicial = $this->yInicial;
		
	    // Logo
	    $this->Image('img/galvalogo.jpeg',10,$yInicial-5,50);
	    // Arial bold 15
	    $this->SetFont('Arial','B',11);
	    
// 	    $this->setCurrentY($this->GetPageHeight()/2);
// 	    $this->putText(10, "mita");  

	    
	    
	    $this->setCurrentY($yInicial);
	    
	    // $this->SetTextColor(71,171,235);
        $this->SetTextColor(0,0,0);
	    $this->SetDrawColor(71,171,235);
	    $this->SetFillColor(224,238,254);
	    
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
	    
	    // $this->nextRow();
	    // $this->putTextCenter($this->__sucursales, -10);
	    
	    $this->SetFont('Arial','B',11);
	    
	    $this->setCurrentY($yInicial + 2);
	    $this->putTextRight("ORDEN DE EMBARQUE", 30);
	    // $this->putTextRight("COTIZACION", 20);
	    
	    // $this->Rect(157, $this->currentY - 5, 7, 7, "D");
	    // $this->Rect(197, $this->currentY - 5, 7, 7, "D");
	    
        // $this->SetTextColor(0,0,0);
	    
	
	    $this->SetFont('Arial','',8);
	    $this->setCurrentY($yInicial + 25);
	    
	    $this->putText(10, "UNIDAD:");
        $this->putText(90, "FECHA DE OE:");
        $this->putText(150, "HORA DE SALIDA:");        
	    $this->nextRow(-3);
        $this->putText(25, "_______________________________________");
        $this->putText(122, "_______________");
        $this->putText(178, "_______________");

        $this->SetFont('Arial','B',8);
        $this->previousRow();        
        $this->putText(25, $this->_unidad);
        $this->putText(127, $this->_fechaSalida);
        $this->putText(182, $this->_horaSalida);

        // $this->putText(90, "FECHA DE OE:");
        // $this->putText(150, "HORA DE SALIDA:");        
	    // $this->putText(25, "_______________________________________________________________________________                 ________________________");
	    
        $this->SetFont('Arial','',8);
	    $this->nextRow(2);
	    $this->putText(90, "FECHA DE LLEGADA:");
	    $this->putText(150, "HORA DE LLEGADA:");
	    $this->nextRow(-3);
	    $this->putText(122, "_______________");
        $this->putText(178, "_______________");

		if ($this->_estatus == 'COMPLETADO')
		{
			$this->SetFont('Arial','B',8);
			$this->previousRow();                
			$this->putText(127, $this->_fechaLlegada);
			$this->putText(182, $this->_horaLlegada);
		}
	    
        $this->SetFont('Arial','',8);
	    $this->nextRow(2);
	    $this->putText(10, "KM INICIAL:");
	    $this->putText(50, "KM FINAL:");
        $this->putText(90, "LITROS:");
        $this->putText(130, "TIPO COMBUSTIBLE:");
	    $this->nextRow(-3);
	    $this->putText(27, "_____________");
        $this->putText(67, "_____________");
        $this->putText(103, "_____________");
        $this->putText(161, "__________________________");

        $this->SetFont('Arial','B',8);
        $this->previousRow();                
        $this->putText(30, $this->_kmInicial);

		if ($this->_estatus == 'COMPLETADO')
		{
			$this->putText(70, $this->_kmFinal);
			$this->putText(105, $this->_litros);
			$this->putText(163, $this->_tipoCombustible);
		}
	    
	    
	    
	
	}
	
	// Pie de p�gina
	function Footer()
	{
// 	    // Posici�n: a 1,5 cm del final
	    $this->SetY(-55);
        $this->SetFont('Arial','',8);
	    $this->nextRow(4);
	    // $this->putText(15, "Agente:                                                                                                   Recibió:                     ");	    
        $this->putTextCenter("FIRMA CHOFER", -50);
        $this->putTextCenter("INSPECCIÓN EN RECIBO FINAL", 42);
	    $this->nextRow(-8);
	    $this->putText(25, "___________________________________________                            ___________________________________________");
	}
	
	function printDatosDetalle($rsDetalle, $hoja)
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

		
		$this->SetTextColor(255,0,0);
		$this->setCurrentY($yInicial + 14);
		$this->putTextRight("No.", 40);
		$this->putText(182, $this->_folio);
        $this->SetTextColor(0,0,0);
		
		// $this->setCurrentY($yInicial + 10);
		// //$this->putTextRight("No.", 40);
		// $this->putText(145, $this->__recogeEntrega);
		
		// $this->setCurrentY($yInicial + 20);
		// //$this->putTextRight("No.", 40);
		// $this->putText(10, $this->__rangoCliente . $this->__PlanProteccion);
		
		
		
		// $this->SetFont('Arial','',8);
		// $this->setCurrentY($yInicial + 25);
		
		// $this->SetTextColor(73,139,235);
		 
		// $this->putText(25, $this->__nombre);
		// $this->putText(163, $this->__fecha);
		// $this->nextRow(-3);
		
		// $this->nextRow(2);
		// $this->putText(28, $this->__domicilio);
		// $this->nextRow(-3);		
		 
		// $this->nextRow(2);
		// $this->putText(24, $this->__ciudad);
 		// $this->putText(105,$this->__rfc);
 		// $this->putTextRight($this->__telefono, 40);
 		
 		if ($this->_totalHojas > 1)
 		{
            $this->SetFont('Arial','',8);
     		$this->setCurrentY($yInicial + 18);
     		$this->putTextRight("Hoja: ", 40);
     		$this->putText(182,($hoja+1) ." / " .$this->_totalHojas); 		    
 		}
 		
 		
  		$this->SetFont('Arial','B',10);
  		$this->setCurrentY($yInicial + 50);
        $this->nextRow();
        $this->putTextCenter("DATOS DE CARGA");
        $this->nextRow(10);
  		
  		// $this->SetTextColor(73,139,235);
  		
//   		for($iii = 0 ; $iii < 40 ; $iii++)
//   		{
//   			$this->putText(29, $iii);
//   			$this->nextRow();
//   		}
  		
        $rowInicial = $this->_rowsByHoja * $hoja;
        $rowFinal= $this->_rowsByHoja * ($hoja + 1);
        $index = -1;

  		// $auxCodigo = "";
  		
  		foreach ($rsDetalle as $item)
  		{
  		    $index++;
  		    
  		    if ($index >= $rowInicial && $index < $rowFinal)
  		    {

                $this->SetFont('Arial','',8);               
                
                $this->putText(10, "NOM. DEL CLIENTE");
                $this->putText(155, "TEL");                
                $this->nextRow(-3);
                $this->putText(39, "_________________________________________________________________________");
                $this->putText(162, "__________________________");

                $this->SetFont('Arial','B',8);
                $this->previousRow();                
                $this->putText(40, $item["cliente"]);
                $this->putText(162, $item["telefonos"]);
                

                $this->SetFont('Arial','',8);

                $this->nextRow(2);
                $this->putText(10, "NUM. DE PEDIDO");
                $this->putText(70, "NUM. VALE DE SALIDA ");
                $this->putText(144, "KILOS DE CARGA");                
                $this->nextRow(-3);
                $this->putText(36,  "____________________");
                $this->putText(105, "____________________");
                $this->putText(171, "____________________");


                $this->SetFont('Arial','B',8);
                $this->previousRow();                
                $this->putText(40, $item["idPedido"]);
                $this->putText(110, $item["idValeSalida"]);
                $this->putText(175, $item["totalkg"]);


                $this->SetFont('Arial','',8);

                $this->nextRow(2);
                $this->putText(10, "DOMICILIO");
                $this->putText(135, "COLONIA");                
                $this->nextRow(-3);
                $this->putText(28,  "___________________________________________________________________");
                $this->putText(148, "___________________________________");

                $this->SetFont('Arial','B',8);
                $this->previousRow();                
                $this->putText(28, $item["domicilioEntrega"] . ' ' . $item["numeroEntrega"]);
                $this->putText(150, $item["coloniaEntrega"]);

                
                $this->nextRow(12);
                
  		        
  		    }
  		    
  		    
  		    
  		    
  		    
  		    
  		}
  		
  		
  		
  		
  		
  		  		
  		
  		
  		
  		
	}
}

// Creaci�n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");


$pdf->AliasNbPages();

$pdf->SetFont('Times','',12);

$pdf->setCurrentY(5);

$rev = new ModeloRutaenviovehiculo();

$sql = "
        select rev.idRutaEnvioVehiculo, rev.idRutaEnvio, v.idVehiculo, v.placas, v.descripcion, rev.kilometrajeInicial, rev.kilometrajeFinal, rev.cargoGasolina, rev.estatus,
					getTotalKGRutaEnvioVehiculo(rev.idRutaEnvioVehiculo) totalkg,
					getMaxMLRutaEnvioVehiculo(rev.idRutaEnvioVehiculo) maxml,
					rev.fecha_envio, 
					rev.fecha_regreso, rev.litros, rev.tipocombustible
				from rutaenviovehiculo rev
				inner join vehiculo v on rev.idVehiculo = v.idVehiculo
				where rev.idRutaEnvioVehiculo = " . $idRutaEnvioVehiculo;

$row = $rev->getDataSet($sql)[0];

if ($row["estatus"] == 'ASIGNADO')
    salir();

$pdf->_estatus = $row["estatus"];
$pdf->_unidad = $row["placas"];
$pdf->_fechaSalida = date("d/m/Y", strtotime($row["fecha_envio"]));
$pdf->_horaSalida = date("h:i a", strtotime($row["fecha_envio"]));
$pdf->_fechaLlegada = date("d/m/Y", strtotime($row["fecha_regreso"]));
$pdf->_horaLlegada = date("h:i a", strtotime($row["fecha_regreso"]));
$pdf->_kmInicial = $row["kilometrajeInicial"];
$pdf->_kmFinal = $row["kilometrajeFinal"];
$pdf->_litros = $row["litros"];
$pdf->_tipoCombustible = $row["tipocombustible"];

$idRutaEnvio = $row["idRutaEnvio"];
$idRutaEnvioVehiculo = $row["idRutaEnvioVehiculo"];

$pdf->_folio = $idRutaEnvioVehiculo;

$pdf->AddPage();




$sql = " 
        select red.idRutaEnvioDetalle, p.idPedido, p.estado, p.recogeentrega, concat(c.nombre, ' ', c.apellidos) cliente, 
                        c.telefonos, 
						red.maxml, red.maxpeso, red.orden,
						p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega,
						c.idUsuarioPromotor, p.id_usuario_capturado, 
						vs.estado vsestado,
                        getTotalKGRutaEnvioVehiculo(red.idRutaEnvioVehiculo) totalkg,
						re.maxml hmaxml, re.maxpeso hmaxpeso, re.fecha, re.estado, red.idValeSalida,
						if(vs.yaImpreso = 'SI' or vs.chkImprimirPedidoNoSaldado = 'SI' or vs.pagoVSEntrega = 'SI', 'SI', 'NO') listoParaSalir
					from rutaenviodetalle red
					inner join rutaenvio re on red.idRutaEnvio = re.idRutaEnvio
					inner join pedido p on red.idPedido = p.idPedido
					inner join valesalida vs on red.idValeSalida = vs.idValeSalida
					inner join cliente c on p.idcliente = c.idcliente
					where red.idrutaenvio = ".$idRutaEnvio." and red.idRutaEnvioVehiculo = ".$idRutaEnvioVehiculo." ORDER BY red.orden, red.idRutaEnvioDetalle
    ";

$datos = $rev->getDataSet($sql);

$pdf->_totalHojas = ceil(count($datos) / $pdf->_rowsByHoja);


$pdf->printDatosDetalle($datos, 0);

for($h = 1 ; $h < $pdf->_totalHojas ; $h++)
{
    $pdf->AddPage();
    $pdf->printDatosDetalle($datos, $h);
    
    
}




 
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