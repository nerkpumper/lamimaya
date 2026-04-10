<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.cortecomision.inc.php";
require_once FOLDER_MODEL. "model.cxccuentacomision.inc.php";
require_once FOLDER_MODEL. "model.cxccortecomision.inc.php";


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
    var $tipo = '';
    var $mes = '';
    var $anio = '';
    
    var $promotor = '';
    
    var $saldo = 0;
      
    // Cabecera de p�gina
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
        
        $this->SetTextColor(73,139,235);
        $this->SetDrawColor(73,139,235);
        $this->SetFillColor(224,238,254);
        
        //         $this->putTextCenter("GALVA MEX, S.A. DE C.V.", -10);
        
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
        $this->putTextRight("PAGO DE COMISIONES", 20);
        
        
        
        $this->SetTextColor(255,0,0);
        
        $this->setCurrentY($yInicial + 12);
        $this->putTextCenter("Folio: " . $this->idCorteComision, 65);
        $this->nextRow();
        
        if ($this->fechaInicial != "")
        {
            $this->SetFont('Arial','',10);
            $this->putTextCenter("Fechas", 65);
            
            $this->SetFont('Arial','B',10);        
            $this->setCurrentY($yInicial + 16);
            $this->nextRow();
            $this->putTextCenter($this->fechaInicial.' - '.$this->fechaFinal, 65);
        }
        else
        {
            $this->SetFont('Arial','b',10);
            if ($this->tipo == "A")
            {
                $this->putTextCenter("Comisión: ANUAL", 65);
                $this->setCurrentY($yInicial + 16);
                $this->nextRow();
                $this->putTextCenter($this->anio, 65);
                
            }
            else if ($this->tipo == "T")
            {
                $this->putTextCenter("Comisión: TRIMESTRAL", 65);
                $strMes = "";
                switch ($this->mes)
                {
                    case 1: $strMes = "ENERO - MARZO"; break;
                    case 2: $strMes = "ABRIL - JUNIO"; break;
                    case 3: $strMes = "JULIO - SEPTIEMBRE"; break;
                    case 4: $strMes = "OCTUBRE - DICIEMBRE"; break;
                }

                $this->setCurrentY($yInicial + 16);
                $this->nextRow();
                $this->putTextCenter($strMes . " " .$this->anio, 65);
            }
            else
            {
                $this->putTextCenter("Comisión: MENSUAL", 65);
                $strMes = "";
                switch ($this->mes)
                {
                    case 1: $strMes = "ENERO"; break;
                    case 2: $strMes = "FEBRERO"; break;
                    case 3: $strMes = "MARZO"; break;
                    case 4: $strMes = "ABRIL"; break;
                    case 5: $strMes = "MAYO"; break;
                    case 6: $strMes = "JUNIO"; break;
                    case 7: $strMes = "JULIO"; break;
                    case 8: $strMes = "AGOSTO"; break;
                    case 9: $strMes = "SEPTIEMBRE"; break;
                    case 10: $strMes = "OCTUBRE"; break;
                    case 11: $strMes = "NOVIEMBRE"; break;
                    case 12: $strMes = "DICIEMBRE"; break;
                    
                }

                $this->setCurrentY($yInicial + 16);
                $this->nextRow();
                $this->putTextCenter($strMes . " " .$this->anio, 65);
            }
            
        }


        
        $this->SetTextColor(73,139,235);
        
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
    
    function printDetalle($rsDetalle, $rsPagos)
    {
        $yInicial = $this->yInicial;
        
        $this->SetFont('Arial','',10);
        $this->SetTextColor(200,169,110);
        
        $this->printData($yInicial, $rsDetalle, $rsPagos);
        $this->printData($yInicial + ($this->GetPageHeight()/2), $rsDetalle, $rsPagos);
    }
    
    private function printData($yInicial, $rsDetalle, $rsPagos)
    {        
        $this->setCurrentY($yInicial + 38);
     
        foreach ($rsDetalle as $item)
        {
            if (mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8') == "CORTE COMISI�N, MONTO GENERADO")
            {
                $this->putText(12, "COMISI�N");
                $this->putText(40, $item["fecha_creacion"] . ' ' . mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8');
                $this->putTextRight(" + " . number_format($item["monto"],2), 15);
                
                $this->nextRow();                
            }            
        }
        
        foreach ($rsDetalle as $item)
        {
            if (mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8') == "INCENTIVO DE COMISI�N")
            {
                $this->putText(12, "INCENTIVO");
                $this->putText(40, $item["fecha_creacion"] . ' ' . mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8');
                $this->putTextRight(" + " . number_format($item["monto"],2), 15);
                
                $this->nextRow();
                $this->nextRow();
            }
        }
        
        
        
        foreach ($rsDetalle as $item)
        {
            if (mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8') != "CORTE COMISI�N, MONTO GENERADO" &&
                mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8') != "INCENTIVO DE COMISI�N" )
            {
                $this->putText(12, "DEDUCCI�N");
                $this->putText(40, $item["fecha_creacion"] . ' ' .mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8');
                $this->putTextRight(" - " . number_format($item["monto"],2), 15);
                
                $this->nextRow();
            }
        }
        
        $this->nextRow();
        
        foreach ($rsPagos as $item)
        {
            
             $this->putText(12, $item["movimiento"]);
             $this->putText(40, $item["fecha_movimiento"] . ' ' .mb_convert_encoding($item["observacion"], 'ISO-8859-1', 'UTF-8');
             $this->putTextRight(" - " . number_format($item["monto"],2), 15);
                
             $this->nextRow();
            
        }
        
        $this->setCurrentY($yInicial + 102);
        $this->putTextRight(number_format($this->saldo,2), 15);
        
    }
}

// Creaci�n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");

if ($idCorteComision > 0)
{
    $pdf->idCorteComision = $idCorteComision;
    
    $cc = new ModeloCortecomision();
    
    $cortecomision = $cc->getAll("cortecomision.idcortecomision, 
                                 cortecomision.tipo, cortecomision.mes, cortecomision.anio,
                                 cortecomision.idpromotor, cortecomision.fecha_creacion, cortecomision.total, cortecomision.comisionadelantada, cortecomision.apagar, cortecomision.saldo, cortecomision.fechainicio, cortecomision.fechafin, cortecomision.pagada, u.nombre, u.apellidopaterno, u.apellidomaterno, cortecomision.saldo,
                                 cortecomision.incentivo ",
                                 " inner join usuario as u on u.idUsuario = cortecomision.idpromotor",
                                 " cortecomision.idcortecomision = " . $idCorteComision,
                                 ""); 
    
    if (count($cortecomision) > 0)
    {
        $cortecomision = $cortecomision[0];
        
        $pdf->promotor = $cortecomision["nombre"] . ' ' . $cortecomision["apellidopaterno"] . ' ' . $cortecomision["apellidomaterno"];
        $pdf->fechaInicial = $cortecomision["fechainicio"];
        $pdf->fechaFinal = $cortecomision["fechafin"];
        $pdf->tipo = $cortecomision["tipo"];
        $pdf->mes = $cortecomision["mes"];
        $pdf->anio = $cortecomision["anio"];
        $pdf->saldo = $cortecomision["saldo"];
        
        
        $pdf->AddPage();
        
        $cxccuentacomision = new ModeloCxccuentacomision();
        
        $lstCxcCuentaComision = $cxccuentacomision->getAll("",
            "",
            "idCorteComision = " . $idCorteComision,
            "");
        
        $cxccortecomision = new ModeloCxccortecomision();
        
        $lstCxCCorteComision = $cxccortecomision->getAll("", "", " movimiento = 'PAGO' AND idcortecomision =  " . $idCorteComision, "idcxccortecomision");
        
        
        $pdf->printDetalle($lstCxcCuentaComision, $lstCxCCorteComision);
    }
    
    
    
}



 
//$pdf->Cell(0,10,'Imprimiendo l�nea n�mero '.$i,0,1);
// $pdf->Output('D','filename.pdf');
$pdf->Output();