<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.cortecomisionroofing.inc.php";
require_once FOLDER_MODEL. "model.cxccuentacomisionroofing.inc.php";
require_once FOLDER_MODEL. "model.cxccortecomisionroofing.inc.php";


// cliente MDM 137


function salir(){
    echo "<script>
        
					window.close();
		</script>";
}

$idCorteComision = 0;

if (isset($param1))
{
    $idCorteComision = $param1;
}

class PDF extends PDFNerk
{    
    var $yInicial = 10;
    var $idCorteComision = 0;
    
    var $fechaInicial = '';
    var $fechaFinal = '';
    
    var $promotor = '';
    
    var $saldo = 0;
      
    // Cabecera de página
    function Header()
    {
        $yInicial = $this->yInicial;
        
        $this->printFormat($yInicial);
//         $this->setCurrentY($this->GetPageHeight()/2);
//         $this->putText(10, "param: " . $this->idCorteComision);
        $this->printFormat($yInicial + ($this->GetPageHeight()/2));
    }
    
    private function printFormat ($yInicial)
    {
        // Logo
        $this->Image('img/galvalogo.jpeg',5,$yInicial-10,50);
        // Arial bold 15
        $this->SetFont('Arial','B',11);
        
//         $this->setCurrentY($this->GetPageHeight()/2);
//         $this->putText(10, "param: " . $this->idCorteComision);
        
        
        
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
        $this->putTextRight("PAGO DE COMISIONES ROOFING", 20);
        
        
        
        $this->SetTextColor(255,0,0);
        
        $this->setCurrentY($yInicial + 12);
        $this->putTextCenter("Folio: " . $this->idCorteComision, 65);
        $this->nextRow();
        
        $this->SetFont('Arial','',10);
        $this->putTextCenter("FECHAS", 65);
        
        $this->SetFont('Arial','B',10);        
        $this->setCurrentY($yInicial + 16);
        $this->nextRow();
        $this->putTextCenter($this->fechaInicial.' - '.$this->fechaFinal, 65);
        
        $this->SetTextColor(71,171,235);
        
        $this->SetFont('Arial','',8);
        $this->setCurrentY($yInicial + 25);
        
        $this->putText(10, "PROMOTOR:");        
        $this->nextRow(-3);
        $this->putText(28, "___________________________________________________________________________________________________________");

        $this->setCurrentY($yInicial + 25);
        $this->SetFont('Arial','B',10);
        $this->putText(30, $this->promotor);
        
        
        $this->SetFont('Arial','',8);
               
        // 	    if ($this->isMDM)
        // 	    {
        $this->RoundedRect(10, $yInicial + 28, 192, 5, 3, '', 'DF');
        $this->RoundedRect(10, $yInicial + 28, 192, 70, 3, '', 'D');
        
        $this->RoundedRect(140, $yInicial + 98, 30, 6, 3, '', 'DF');
        $this->RoundedRect(170, $yInicial + 98, 32, 6, 3, '', 'D');
        
//         $this->RoundedRect(10, $yInicial + 40, 90, 5, 3, '', 'DF');
        
//         $this->RoundedRect(102, $yInicial + 28, 90, 5, 3, '', 'DF');
//         $this->RoundedRect(102, $yInicial + 28, 90, 70, 3, '', 'D');
        
        
//         $this->Line(57.5, $yInicial+42, 57.5, $yInicial+42+70);
//         $this->Line(67, $yInicial+42, 67, $yInicial+42+70);
//         $this->Line(182, $yInicial+42, 182, $yInicial+42+70);
        
        
        $this->SetFont('Arial','B',10);
        
        $this->setCurrentY($yInicial + 32);      
        $this->putText(12, "TIPO");
        $this->putText(40, "CONCEPTO");
//         $this->putText(100, "MOVIMIENTO");
        $this->putTextRight("MONTO", 20);
        
        $this->setCurrentY($yInicial + 102);
        $this->putTextRight("SALDO", 50);
        
        
        $this->setCurrentY($yInicial + 112);
//         $this->putTextRight("NOMBRE:");
//         $this->nextRow(-3);
        $this->putTextRight("__________________________________________", 27);
        $this->nextRow();
        $this->putTextCenter($this->promotor, 42);
        
    }
    
    // Pie de página
    function Footer()
    {
        // 	    // Posición: a 1,5 cm del final
        // 	    $this->SetY(-15);
        // 	    // Arial italic 8
        // 	    $this->SetFont('Arial','I',8);
        // 	    // Número de página
        // 	    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    
    function printDetalle($rsDetalle, $rsPagos)
    {
        $yInicial = $this->yInicial;
        
        $this->SetFont('Arial','',10);
        $this->SetTextColor(73,139,235);
        
        $this->printData($yInicial, $rsDetalle, $rsPagos);
        $this->printData($yInicial + ($this->GetPageHeight()/2), $rsDetalle, $rsPagos);
    }
    
    private function printData($yInicial, $rsDetalle, $rsPagos)
    {        
        $this->setCurrentY($yInicial + 38);
     
        foreach ($rsDetalle as $item)
        {
            if (utf8_decode($item["observacion"]) == "CORTE COMISIÓN, MONTO GENERADO")
            {
                $this->putText(12, "COMISIÓN");
                $this->putText(40, $item["fecha_creacion"] . ' ' . utf8_decode($item["observacion"]));
                $this->putTextRight(" + " . number_format($item["monto"],2), 15);
                
                $this->nextRow();                
            }            
        }
        
//         foreach ($rsDetalle as $item)
//         {
//             if (utf8_decode($item["observacion"]) == "INCENTIVO DE COMISIÓN")
//             {
//                 $this->putText(12, "INCENTIVO");
//                 $this->putText(40, $item["fecha_creacion"] . ' ' . utf8_decode($item["observacion"]));
//                 $this->putTextRight(" + " . number_format($item["monto"],2), 15);
                
//                 $this->nextRow();
//                 $this->nextRow();
//             }
//         }
        
        
        
        foreach ($rsDetalle as $item)
        {
            if (utf8_decode($item["observacion"]) != "CORTE COMISIÓN, MONTO GENERADO" &&
                utf8_decode($item["observacion"]) != "INCENTIVO DE COMISIÓN" )
            {
                $this->putText(12, "DEDUCCIÓN");
                $this->putText(40, $item["fecha_creacion"] . ' ' .utf8_decode($item["observacion"]));
                $this->putTextRight(" - " . number_format($item["monto"],2), 15);
                
                $this->nextRow();
            }
        }
        
        $this->nextRow();
        
        foreach ($rsPagos as $item)
        {
            
             $this->putText(12, $item["movimiento"]);
             $this->putText(40, $item["fecha_movimiento"] . ' ' .utf8_decode($item["observacion"]));
             $this->putTextRight(" - " . number_format($item["monto"],2), 15);
                
             $this->nextRow();
            
        }
        
        $this->setCurrentY($yInicial + 102);
        $this->putTextRight(number_format($this->saldo,2), 15);
        
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");

if ($idCorteComision > 0)
{
    $pdf->idCorteComision = $idCorteComision;
    
    $cc = new ModeloCortecomisionroofing();
    
    $cortecomision = $cc->getAll("cortecomisionroofing.idcortecomisionroofing, cortecomisionroofing.idpromotor, 
cortecomisionroofing.fecha_creacion, cortecomisionroofing.total, cortecomisionroofing.comisionadelantada, 
cortecomisionroofing.apagar, cortecomisionroofing.saldo, cortecomisionroofing.fechainicio, cortecomisionroofing.fechafin, 
cortecomisionroofing.pagada, u.nombre, u.apellidopaterno, u.apellidomaterno, cortecomisionroofing.saldo,
                                 cortecomisionroofing.incentivo ",
                                 " inner join usuario as u on u.idUsuario = cortecomisionroofing.idpromotor",
                                 " cortecomisionroofing.idcortecomisionroofing = " . $idCorteComision,
                                 ""); 
    
    if (count($cortecomision) > 0)
    {
        $cortecomision = $cortecomision[0];
        
        $pdf->promotor = $cortecomision["nombre"] . ' ' . $cortecomision["apellidopaterno"] . ' ' . $cortecomision["apellidomaterno"];
        $pdf->fechaInicial = $cortecomision["fechainicio"];
        $pdf->fechaFinal = $cortecomision["fechafin"];
        $pdf->saldo = $cortecomision["saldo"];
        
        
        $pdf->AddPage();
        
        $cxccuentacomision = new ModeloCxccuentacomisionroofing();
        
        $lstCxcCuentaComision = $cxccuentacomision->getAll("",
            "",
            "idCorteComisionroofing = " . $idCorteComision,
            "");
        
        $cxccortecomision = new ModeloCxccortecomisionroofing();
        
        $lstCxCCorteComision = $cxccortecomision->getAll("", "", " movimiento = 'PAGO' AND idcortecomisionroofing =  " . $idCorteComision, "idcxccortecomisionroofing");
        
        
        $pdf->printDetalle($lstCxcCuentaComision, $lstCxCCorteComision);
    }
    
    
    
}



 
//$pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
// $pdf->Output('D','filename.pdf');
$pdf->Output();