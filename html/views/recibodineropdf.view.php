<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.recibodinero.inc.php";


function salir(){
    echo "<script>
        
					window.close();
		</script>";
}

$idReciboDinero = 0;

if (isset($param1))
{
    $idReciboDinero = $param1;
}
else{
    salir();
}

class PDF extends PDFNerk
{    
    var $yInicial = 10;
    var $idReciboDinero = 0;
    
    var $dia = '';
    var $mes = '';
    var $anio = '';
    var $nombre = '';
    var $direccion = '';
    var $ciudad = '';
    var $telefono = '';
    var $rfc = '';
    var $monto = 0;
    var $disponible = 0;
    var $formaPago = "";
    var $usuarioCaptura = "uc";
    var $referencia = "";

    var $movs = [];
       
      
    // Cabecera de p�gina
    function Header()
    {
        $yInicial = $this->yInicial;
        
        $this->printFormat($yInicial);
//         $this->setCurrentY($this->GetPageHeight()/2);
//         $this->putText(10, "param: " . $this->idReciboDinero);
        $this->printFormat($yInicial + ($this->GetPageHeight()/2));
    }
    
    private function printFormat ($yInicial)
    {
        // Logo
        $this->Image('img/galvalogo.jpeg',5,$yInicial-10,50);
        // Arial bold 15
        $this->SetFont('Arial','B',11);
        
        // $this->setCurrentY($this->GetPageHeight()/2);
        // $this->putText(10, "param: " . $this->idReciboDinero);
        
        
        
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
        $this->putTextRight("RECIBO DE PAGO", 20);
        
        
        
        $this->SetTextColor(255,0,0);
        
        $this->setCurrentY($yInicial + 8);
        $this->putTextCenter("No.  " . $this->idReciboDinero, 75);
        $this->nextRow();
        
        $this->SetTextColor(71,171,235);
        
        $this->SetFont('Arial','',8);
        $this->setCurrentY($yInicial + 23);
        
        $this->putTextRight("León, Gto., a                                                 de                                         de 20", 25);        
        $this->nextRow(-3);
        $this->putTextCenter("_______________________", 22);
        $this->nextRow(-4);
        $this->putTextCenter("___________________", 60);
        $this->nextRow(-4);
        $this->putTextCenter("_______", 89);
        $this->nextRow();       
        
        $this->putTextRight("Orden de Venta No.:", 96);        
        $this->nextRow(-3);
        $this->putTextCenter("___________________________________________________", 54);
        $this->nextRow();


        $this->putText(10, "Nombre o Razón Social:");        
        $this->nextRow(-3);
        $this->putText(42, "______________________________________________________________________________________________________");
        $this->nextRow();
        
        $this->putText(10, "Dirección:");        
        $this->nextRow(-3);
        $this->putText(23, "__________________________________________________________________________________________________________________");
        $this->nextRow();

        $this->putText(10, "Ciudad:");        
        $this->putText(112, "Tel.:");        
        $this->putText(160, "R.F.C.:");        
        $this->nextRow(-3);
        $this->putText(22, "_________________________________________________________");
        $this->putText(118, "__________________________");
        $this->putText(170, "____________________");
        $this->nextRow();

 
        $this->SetFont('Arial','',8);
               
        // 	    if ($this->isMDM)
        // 	    {
        $this->RoundedRect(10, $yInicial + 48, 192, 5, 3, '', 'DF');
        $this->RoundedRect(10, $yInicial + 48, 192, 50, 3, '', 'D');
        
        $this->Line(160, $yInicial+48, 160, $yInicial+48+50);

        $this->RoundedRect(130, $yInicial + 98, 40, 6, 3, '', 'DF');
        $this->RoundedRect(170, $yInicial + 98, 32, 6, 3, '', 'D');
        
        
        $this->SetFont('Arial','B',10);
        
        $this->setCurrentY($yInicial + 52);      
        // $this->putText(12, "TIPO");
        $this->putText(70, "MOVIMIENTOS");
//         $this->putText(100, "MOVIMIENTO");
        $this->putTextRight("MONTO", 25);
        
        $this->setCurrentY($yInicial + 102);
        $this->putTextRight("DISPONIBLE", 50);
        
        
        $this->setCurrentY($yInicial + 112);
//         $this->putTextRight("NOMBRE:");
//         $this->nextRow(-3);
        $this->putTextRight("__________________________________________", 27);
        $this->nextRow();
        $this->putTextCenter($this->usuarioCaptura, 42);
        
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
    var $usado = 0;
    function printDetalle()
    {
        $yInicial = $this->yInicial;
        
        
        $this->SetTextColor(73,139,235);

        $this->usado = 
                $this->monto
                - $this->disponible;        
        
        $this->printData($yInicial);
        $this->printData($yInicial + ($this->GetPageHeight()/2));
    }
    
    private function printData($yInicial)
    {        
        $this->setCurrentY($yInicial + 23);

        $this->SetFont('Arial','',8);
     
        
        $this->putText(115, $this->dia);
        $this->putText(155, $this->mes);
        $this->putText(192, $this->anio);
        
        $this->nextRow(1);
        $this->nextRow(1);
        $this->putText(42, $this->nombre);

        $this->nextRow(1);
        $this->putText(25, $this->direccion);
        
        $this->nextRow(1);
        $this->putText(25, $this->ciudad);
        $this->putText(119, $this->telefono);
        $this->putText(170, $this->rfc);

        $this->nextRow();
        $this->nextRow();
        $this->nextRow(1);
        
        $this->putText(11, "+");
        $this->putText(13, "Abonado:");
        $this->putText(30, "(".$this->formaPago.") (".$this->referencia.")");
        $this->putTextRight(number_format(floatVal($this->monto),2), 15);
        $this->nextRow(1);
        
        foreach($this->movs as $mov)
        {
            $this->putText(11, "-");
            $this->putText(13, $mov["movimiento"] == "USADOENPEDIDO" ? "Usado en Pedido:" : "Devolver a Cliente:");
            // $this->putText(13, "Devolver a Cliente:");
            // $this->putText(13, "Usado en Pedido:");
            $this->putText(38, ($mov["idPedido"] != "0" ? " Pedido: " . $mov["idPedido"] . ($mov["factura"] != "0" ? " (Facturas: ". $mov["factura"].")" : "") : "" ) . " " .$mov["observaciones"]);
            $this->putTextRight("-".number_format(floatVal($mov["monto"]),2), 15);
            $this->nextRow();
        }

        // $this->putText(15, "-");
        // $this->putText(20, "UTILIZADO");
        // $this->putTextRight(number_format(floatVal($this->usado),2), 15);
        // $this->nextRow(1);


        $this->setCurrentY($yInicial + 102);
        $this->SetFont('Arial','B',10);
        $this->putTextRight(number_format($this->disponible,2), 15);
        
    }
}

// Creaci�n del objeto de la clase heredada
$pdf = new PDF("P", "mm", "Letter");

if ($idReciboDinero > 0)
{
    $pdf->idReciboDinero = $idReciboDinero;
        
    $rd = new ModeloReciboDinero();
    
    $query = "SELECT rd.idReciboDinero, rd.idCliente, rd.monto, rd.disponible, rd.referencia,
                        rd.formaPago, fp.clave, fp.descripcion formapago,
                        date_format(rd.fecha_captura, '%y') anio,
                        date_format(rd.fecha_captura, '%M') mes,        
                        date_format(rd.fecha_captura, '%d') dia,
                        CONCAT(c.nombre, ' ' , c.apellidos) cliente,
                        CONCAT(c.domicilio1, ' ' , c.domicilio2, ' ' , c.numero, ' ', c.colonia) domicilio,
                        c.ciudad, c.telefonos, c.rfc,
                        CONCAT (u.nombre, ' ' , u.apellidoPaterno, ' ', u.apellidoMaterno) usuarioCaptura
                FROM recibodinero rd
                INNER JOIN cliente c ON rd.idCliente = c.idCliente
                INNER JOIN formapago fp ON rd.formaPago = fp.idFormaPago
                INNER JOIN usuario u ON rd.id_usuario_captura = u.idUsuario
                WHERE rd.idReciboDinero =" . $idReciboDinero;

    $rs = $rd->getDataSet($query);
    

    $query = "SELECT movimiento, movrecibodinero.idPedido, movrecibodinero.observaciones, monto, fecha_movimiento, pedido.factura
            FROM movrecibodinero 
            LEFT JOIN pedido ON movrecibodinero.idPedido = pedido.idPedido
            WHERE idReciboDinero = ".$idReciboDinero."
            AND movimiento <> 'GENERARECIBO'";

    if (count($rs) > 0)
    {
        $row = $rs[0];

        $pdf->dia = $row["dia"];

        switch($row["mes"]){
            case "January":
                $pdf->mes = "Enero";
                break;
            case "February":
                $pdf->mes = "Febrero";
                break;
            case "March":
                $pdf->mes = "Marzo";
                break;
            case "April":
                $pdf->mes = "Abril";
                break;
            case "May":
                $pdf->mes = "Mayo";
                break;
            case "June":
                $pdf->mes = "Junio";
                break;
            case "July":
                $pdf->mes = "Julio";
                break;
            case "August":
                $pdf->mes = "Agosto";
                break;
            case "September":
                $pdf->mes = "Septiembre";
                break;
            case "October":
                $pdf->mes = "Octubre";
                break;
            case "November":
                $pdf->mes = "Noviembre";
                break;
            case "December":
                $pdf->mes = "Diciembre";
                break;
        }

        // $pdf->mes = $row["mes"];
        $pdf->anio = $row["anio"];
        $pdf->nombre = $row["cliente"];
        $pdf->direccion = $row["domicilio"];
        $pdf->ciudad = $row["ciudad"];
        $pdf->telefono = $row["telefonos"];
        $pdf->rfc = $row["rfc"];
        $pdf->monto = $row["monto"];
        $pdf->disponible = $row["disponible"];
        $pdf->formaPago = $row["clave"] . ' ' . $row["formapago"];
        $pdf->usuarioCaptura = $row["usuarioCaptura"];
        $pdf->referencia = $row["referencia"];

        $pdf->movs = $rd->getDataSet($query);

        $pdf->AddPage();

        $pdf->printDetalle();
    }
    

    
    
    
}



 
//$pdf->Cell(0,10,'Imprimiendo l�nea n�mero '.$i,0,1);
// $pdf->Output('D','filename.pdf');
$pdf->Output();