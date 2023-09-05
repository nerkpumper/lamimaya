<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.cortecaja.inc.php";

function salir(){
    echo "<script>
        
					window.close();
		</script>";
}

$idCorteCaja = 0;

if (isset($param1))
{
    $idCorteCaja = $param1;
}

class PDF extends PDFNerk
{    
    var $yInicial = 10;
    var $idCorteCaja = 0;
    
    var $fechaInicial = '';
    var $fechaFinal = '';
    VAR $sucursal = '';
    
    var $relizaCierre = '';

    var $ventas = 0;
    var $abonos = 0;
    var $entradas = 0;
    var $salidas = 0;
    var $fondoApertura = 0;
    var $fondoCierre = 0;

    var $totalRetirar = 0;
    
    var $saldo = 0;
      
    // Cabecera de p�gina
    function Header()
    {
        $yInicial = $this->yInicial;
        
        $this->printFormat($yInicial);
//         $this->setCurrentY($this->GetPageHeight()/2);
//         $this->putText(10, "param: " . $this->idCorteCaja);
        $this->printFormat($yInicial + ($this->GetPageHeight()/2));
    }
    
    private function printFormat ($yInicial)
    {
        // Logo
        $this->Image('img/galvalogo.jpeg',5,$yInicial-10,50);
        // Arial bold 15
        $this->SetFont('Arial','B',11);
        
//         $this->setCurrentY($this->GetPageHeight()/2);
//         $this->putText(10, "param: " . $this->idCorteCaja);
        
        
        
        $this->setCurrentY($yInicial);
        
        $this->SetTextColor(71,171,235);
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
        
        
        $this->SetFont('Arial','B',11);
        
        $this->setCurrentY($yInicial + 2);
        $this->putTextRight("CORTE DE CAJA", 20);
        
        
        
        $this->SetTextColor(255,0,0);
        
        $this->setCurrentY($yInicial + 8);
        $this->putTextCenter($this->sucursal, 60);
        $this->nextRow();

        $this->setCurrentY($yInicial + 12);
        $this->putTextCenter("Folio: " . $this->idCorteCaja, 60);
        $this->nextRow();
        
        $this->SetFont('Arial','',10);
        $this->putTextCenter("FECHAS", 60);
        
        $this->SetFont('Arial','B',10);        
        $this->setCurrentY($yInicial + 16);
        $this->nextRow();
        $this->putTextCenter($this->fechaInicial.' - '.$this->fechaFinal, 60);
        
        $this->SetTextColor(71,171,235);
        
        $this->SetFont('Arial','',8);
        $this->setCurrentY($yInicial + 25);
        
        $this->putText(10, "RECOJE:");        
        $this->nextRow(-3);
        $this->putText(28, "___________________________________________________________________________________________________________");

        $this->setCurrentY($yInicial + 25);
        $this->SetFont('Arial','B',10);
        $this->putText(30, $this->relizaCierre);
        
        
        $this->SetFont('Arial','',8);
               
        // 	    if ($this->isMDM)
        // 	    {
        $this->RoundedRect(10, $yInicial + 28, 192, 5, 3, '', 'DF');
        $this->RoundedRect(10, $yInicial + 28, 192, 70, 3, '', 'D');
        
        $this->RoundedRect(130, $yInicial + 98, 40, 6, 3, '', 'DF');
        $this->RoundedRect(170, $yInicial + 98, 32, 6, 3, '', 'D');
        
        
        $this->SetFont('Arial','B',10);
        
        $this->setCurrentY($yInicial + 32);      
        // $this->putText(12, "TIPO");
        $this->putText(40, "CONCEPTO");
//         $this->putText(100, "MOVIMIENTO");
        $this->putTextRight("MONTO", 20);
        
        $this->setCurrentY($yInicial + 102);
        $this->putTextRight("TOTAL A RETIRAR", 50);
        
        
        $this->setCurrentY($yInicial + 112);
//         $this->putTextRight("NOMBRE:");
//         $this->nextRow(-3);
        $this->putTextRight("__________________________________________", 27);
        $this->nextRow();
        $this->putTextCenter($this->relizaCierre, 42);
        
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
    
    function printDetalle()
    {
        $yInicial = $this->yInicial;
        
        
        $this->SetTextColor(73,139,235);

        $this->totalRetirar = 
                $this->ventas
                + $this->abonos
                + $this->entradas
                - $this->salidas
                + $this->fondoApertura
                - $this->fondoCierre;        
        
        $this->printData($yInicial);
        $this->printData($yInicial + ($this->GetPageHeight()/2));
    }
    
    private function printData($yInicial)
    {        
        $this->setCurrentY($yInicial + 38);

        $this->SetFont('Arial','',10);
     
        $this->putText(32, "+");
        $this->putText(40, "FONDO DE CAJA");
        $this->putTextRight(number_format(floatVal($this->fondoApertura),2), 15);
        $this->nextRow(1);

        $this->putText(32, "+");
        $this->putText(40, "VENTAS EN EFECTIVO");
        $this->putTextRight(number_format(floatVal($this->ventas),2), 15);
        $this->nextRow(1);

        $this->putText(32, "+");
        $this->putText(40, "ABONOS EN EFECTIVO");
        $this->putTextRight(number_format(floatVal($this->abonos),2), 15);
        $this->nextRow(1);

        $this->putText(32, "+");
        $this->putText(40, "ENTRADAS");
        $this->putTextRight(number_format(floatVal($this->entradas),2), 15);
        $this->nextRow(4);

        $this->putText(32, "-");
        $this->putText(40, "SALIDAS");
        $this->putTextRight(number_format(floatVal($this->salidas),2), 15);
        $this->nextRow(1);

        $this->putText(32, "-");
        $this->putText(40, "DEJAR EN CAJA CHICA PROXIMO CORTE");
        $this->putTextRight(number_format(floatVal($this->fondoCierre),2), 15);
        $this->nextRow(1);

        $this->SetFont('Arial','B',10);

        $this->setCurrentY($yInicial + 102);
        $this->putTextRight(number_format($this->totalRetirar,2), 15);
        
    }
}

// Creaci�n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");

if ($idCorteCaja > 0)
{
    $pdf->idCorteCaja = $idCorteCaja;
    
    $cc = new ModeloCortecaja();
    
    $query = "SELECT cortecaja.fondoCajaApertura, cortecaja.ventas, cortecaja.abonos, cortecaja.entradas, cortecaja.salidas, cortecaja.fondoCajaAlCorte, 
                    DATE_FORMAT(cortecaja.fecha_apertura, '%d/%m/%Y %h:%i:%s') fecha_apertura, DATE_FORMAT(cortecaja.fecha_corte, '%d/%m/%Y %h:%i:%s') fecha_corte,
                    sucursal.nombre sucursal, concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuarioCorte
                FROM cortecaja 
                INNER JOIN sucursal ON cortecaja.idSucursal = sucursal.idSucursal
                INNER JOIN usuario ON cortecaja.id_usuario_corte = usuario.idUsuario
                WHERE cortecaja.idCorteCaja = " . $idCorteCaja. " AND cortecaja.estado = 'REALIZADO' ";

    $rs = $cc->getDataSet($query);

    if (count($rs) > 0)
    {
        $corte = $rs[0];

        $pdf->sucursal = $corte["sucursal"];
        $pdf->ventas = $corte["ventas"];
        $pdf->abonos = $corte["abonos"];
        $pdf->entradas = $corte["entradas"];
        $pdf->salidas = $corte["salidas"];
        $pdf->fondoApertura = $corte["fondoCajaApertura"];
        $pdf->fondoCierre = $corte["fondoCajaAlCorte"];

        $pdf->fechaInicial = $corte["fecha_apertura"];
        $pdf->fechaFinal = $corte["fecha_corte"];

        $pdf->relizaCierre = $corte["usuarioCorte"];

        $pdf->AddPage();

        $pdf->printDetalle();
    }
    

    
    
    
}



 
//$pdf->Cell(0,10,'Imprimiendo l�nea n�mero '.$i,0,1);
// $pdf->Output('D','filename.pdf');
$pdf->Output();