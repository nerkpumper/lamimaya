<?php



if (isset($_SERVER['HTTP_HOST']))

    define("isCONSOLE", false);

else

    define("isCONSOLE", true);



// define('FOLDER_INCLUDE', '../');

// define('FOLDER_INCLUDE', '../../include/');

// define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

//define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');

require_once 'configinclude.cron.php';



define("FOLDER_MODEL_BASE", FOLDER_INCLUDE . "model/base/");

define("FOLDER_MODEL", FOLDER_INCLUDE . "model/extend/");

define("LIB_CONEXION", FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

define("LIB_CONEXION_MYSQL", FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");

define("NOTIFICATION_MANAGER",FOLDER_INCLUDE . "lib/app/class.notificationmanager.inc.php");
define("PEDIDOSTRACKING_MANAGER",FOLDER_INCLUDE . "lib/app/class.pedidotracking.inc.php");


define( 'API_ACCESS_KEY', 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA' );



require_once LIB_CONEXION;

require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';

require_once FOLDER_MODEL . "model.usuario.inc.php";




require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';

require_once NOTIFICATION_MANAGER;

require_once FOLDER_MODEL . "model.pushnotifica.inc.php";

 require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
 require_once FOLDER_MODEL. "model.pedido.inc.php";
 require_once FOLDER_MODEL. "model.cliente.inc.php";
 require_once FOLDER_INCLUDE . 'lib/mail/class.phpmailer.php';

 function getMes($mes){
    switch($mes)
    {
        case (1):
            return "ENERO";            
            break;
        case (2):
            return "FEBRERO";            
            break;
        case (3):
            return "MARZO";            
            break;
        case (4):
            return "ABRIL";            
            break;
        case (5):
            return "MAYO";            
            break;
        case (6):
            return "JUNIO";            
            break;
        case (7):
            return "JULIO";            
            break;
        case (8):
            return "AGOSTO";            
            break;
        case (9):
            return "SEPTIEMBRE";            
            break;
        case (10):
            return "OCTUBRE";            
            break;
        case (11):
            return "NOVIEMBRE";            
            break;
        case (12):
            return "DICIEMBRE";            
            break;
        
    }

    return "";
}

// $idPedido = 0;

// if (isset($_POST["idPedido"]) && $_POST["idPedido"] !== "") {
// 	$idPedido = $_POST["idPedido"];
// }
// else
// {
// 	if (isset($_GET["idPedido"]) && $_GET["idPedido"] !== "") {
// 		$idPedido = $_GET["idPedido"];
// 	}
// 	else
// 	{
// 		// 	$idPedido = -666;
// // 		$idPedido = -666;
// 		salir();
// 		exit();
// 	}

// }

class PDF extends PDFNerk
{

    var $yInicial = 10;

    var $__saldoRD = 0;
    var $__saldo030RD = 0;
    var $__saldo3060RD = 0;
    var $__saldoMas60RD = 0;
    var $__AmparaRD = 0;

    var $__dia = 0;
    var $__mes = 0;
    var $__anio = 0;
    var $__folioRD = 0;

    var $__cliente = "Cliente";
    var $__promotor = "Promotor";



		// Cabecera de p�gina
	function Header()
	{
		$yInicial = $this->yInicial;
		
		// Logo
		// $this->Image('img/galvalogo.jpeg',5,$yInicial-10,50);
		// Arial bold 15
		$this->SetFont('Arial','B',24);
		 
		// 	    $this->setCurrentY($this->GetPageHeight()/2);
		// 	    $this->putText(10, "mita");
		
		 
		 
		$this->setCurrentY($yInicial);
		 
		
		
        $this->nextRow();
        $this->nextRow();
        $this->nextRow();
        $this->nextRow();
		$this->putText(20, "Bienvenido");
		 
		$this->SetFont('Arial','',11);

        $this->nextRow(10);        

        $this->putText(20, "Estimado Cliente:");

        $this->nextRow(10);
        
        $this->putText(20, "Te damos la más cordial bienvenida a GALVAMEX, una empresa cien por ciento mexicana con más");
        $this->nextRow(1);
        $this->putText(20, "de   16   años   de   experiencia,   donde nuestro   principal  compromiso  es  brindarte tranquilidad y");
        $this->nextRow(1);
        $this->putText(20, "seguridad en todo momento.");

        $this->nextRow(10);

        $this->putText(20, "A  partir  de  hoy  cuentas  con  todos  los  beneficios que  te brinda  EL PLAN PROTECCION.  Este");
        $this->nextRow(1);
        $this->putText(20, "programa está  totalmente diseñado en tu  beneficio;  si el  precio de nuestros productos sube, para");
        $this->nextRow(1);
        $this->putText(20, "ti permanecerán congelados y si estos bajan, también bajaran para ti.");

        $this->nextRow(10);

        $this->putText(20, "Existe  una  serie  de  reglas  que están  en  función  del  tiempo  y  de  la  cantidad  de  dinero  que");
        $this->nextRow(1);
        $this->putText(20, "invertiste que te presentamos a continuación:");

        $this->nextRow(10);

        // $this->SetTextColor(71,171,235);
		// $this->SetDrawColor(71,171,235);
		// $this->SetFillColor(224,238,254);

        // $this->RoundedRect(44, $this->getCurrentY(), 124, 7, 3, '', 'DF');
		$this->RoundedRect(44, $this->getCurrentY(), 124, 38, 3, '', 'D');
		 
		$this->Line(124, $this->getCurrentY(), 124, $this->getCurrentY()+38);

        //lineas tabla
        $this->Line(44, $this->getCurrentY()+ 8, 168, $this->getCurrentY() + 8);    
        $this->Line(44, $this->getCurrentY()+ 18, 168, $this->getCurrentY() + 18);    
        $this->Line(44, $this->getCurrentY()+ 27, 168, $this->getCurrentY() + 27);    
        // $this->Line(44, $this->getCurrentY()+ 36, 168, $this->getCurrentY() + 36);    
    
        // $this->Line(67, $this->getCurrentY(), 67, $this->getCurrentY()+135);
	    // $this->Line(182, $this->getCurrentY(), 182, $this->getCurrentY()+135);
		
        $this->nextRow(2);
        $this->putText(46, "SALDO DISPONIBLE TOTAL");
        $this->putTextRight("$ " . number_format($this->__saldoRD, 2), 50);

        $this->nextRow(5);
        $this->putText(46, "PEDIDO MÁXIMO DE 0-30 DÍAS");
        $this->putTextRight("$ " . number_format(($this->__saldoRD * 2), 2), 50);

        $this->nextRow(5);
        $this->putText(46, "PEDIDO MÁXIMO DE 31 A 60 DÍAS");
        $this->putTextRight("$ " . number_format(($this->__saldoRD * 1.5), 2), 50);
        
        $this->nextRow(5);
        $this->putText(46, "PEDIDO MÁXIMO DE 61 DÍAS");
        $this->putTextRight("$ " . number_format($this->__saldoRD, 2) , 50);
        
        $this->nextRow(5);
        $this->SetFont('Arial','B',8);
        $this->putTextCenter("TODOS LOS PEDIDOS GENERADOS BAJO ESTE PLAN DEBEN DE ESTAR PAGADOS AL 100% ANTES DE SER ENTREGADOS");


        $this->SetFont('Arial','',11);
        // $this->putTextRight("$ " . $this->__AmparaRD, 50);
		
		// $this->RoundedRect(10, $this->getCurrentY() + 206, 192, 4, 3, '', 'DF');
		// $this->RoundedRect(10, $this->getCurrentY() + 206, 192, 11, 3, '', 'D');


        $this->nextRow(15);

        $this->putText(20, "Fechado  el  día_______ de ___________________  del  año___________.  Hago  constar  que  yo");
        $this->putText(55, $this->__dia);
        $this->putText(75, $this->__mes);
        $this->putText(135, $this->__anio);


        $this->nextRow(1);
        $this->putText(20, "_______________________________________________     recibí    de    parte    del    asesor    de");
        $this->putText(21, $this->__cliente);

        $this->nextRow(1);
        $this->putText(20, "ventas ____________________________________  esta  información,  Condiciones Generales y el");
        $this->putText(35, $this->__promotor);

        $this->nextRow(1);
        $this->putText(20, "alcance del  PLAN PROTECCION.  El dinero  quedó  registrado  con el  folio  del  Recibo  de  Dinero");
        $this->nextRow(1);
        $this->putText(20, "número ________.  Así mismo  declaro, que se me sugirió tener siempre a la mano esta información");
        $this->putText(38, $this->__folioRD);

        $this->nextRow(1);
        $this->putText(20, "para cualquier aclaración o duda respecto al funcionamiento del plan.");

		$this->nextRow(30);
		
        $this->putTextCenter("_________________________", 55);
        $this->nextRow(-4);
        $this->putTextCenter("_________________________", -55);
        $this->nextRow(1);
        $this->putTextCenter("Firma del Asesor de Ventas", 55);
        $this->nextRow(-4);
        $this->putTextCenter("Nombre y Firma del Cliente", -55);
        
		 
		

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


}


$cliente = new ModeloPedido();

// $ctes = $cliente->getDataSet("select idCliente from cliente where idcliente in (762)");
$ctes = $cliente->getDataSet("select idCliente from cliente where enviarPlanProteccion = 'SI'"); 
// echo "seleccionando clientes";
foreach($ctes as $cte)
{
    echo "<br>\n **** Procesando    IDCLIENTE: " . $cte["idCliente"] . "  ****";
    $pdf = new PDF("P", "mm", "Letter");


    $idCliente = $cte["idCliente"];

    $pedido = new ModeloPedido();

    $query = "SELECT getSaldoReciboDinero(idcliente) saldoRD,		
                        (select idReciboDinero from recibodinero where idcliente = " . $idCliente . " order by 1 desc limit 1) idReciboDinero,
                        getSaldoReciboDinero0A30Dias(idcliente, DATE_FORMAT(curdate(), '%Y-%m-%d')) saldoRD030,
                        getSaldoReciboDinero31A60Dias(idcliente, DATE_FORMAT(curdate(), '%Y-%m-%d')) saldoRD3160,
                        getSaldoReciboDineroMas60Dias(idcliente, DATE_FORMAT(curdate(), '%Y-%m-%d')) saldoRDmas60,
                        concat(cliente.nombre, ' ',  cliente.apellidos) nombreCliente,
                        concat(usuario.nombre, ' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno) nombrePromotor,
                        usuario.email, usuario.idUsuario
                from cliente
                inner join usuario on cliente.idUsuarioPromotor = usuario.idUsuario
                where idcliente = " . $idCliente;

    
    $datos = $pedido->getDataSet($query);


    if ($datos)
    {
    
        $row = $datos[0];

        $pdf->__folioRD = $row["idReciboDinero"];

// echo "  antes body " . $row["idReciboDinero"];
        if ($pdf->__folioRD <= 0)
            continue;


        $pdf->__saldoRD = $row["saldoRD"];
        $pdf->__saldo030RD = $row["saldoRD030"];
        $pdf->__saldo3060RD = $row["saldoRD3160"];
        $pdf->__saldoMas60RD = $row["saldoRDmas60"];
        $pdf->__AmparaRD = ($pdf->__saldo030RD * 2) + ($pdf->__saldo3060RD * 1.5) + ($pdf->__saldoMas60RD);

        $pdf->__dia = date("d");
        $pdf->__mes = getMes(intval(date("m"))) ;
        $pdf->__anio = date("Y");
        

        $pdf->__cliente = $row["nombreCliente"];
        $pdf->__promotor = $row["nombrePromotor"];


        $pdf->AddPage();

        $promotorMail = $row["email"];
        $promotorID = $row["idUsuario"];
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
                                    PLAN PROTECCION PARA ". utf8_decode($pdf->__cliente)."
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
                                                Adjunto se encuentra un pdf conteniendo los datos de Plan de Protecci&oacute;n para el Cliente, favor de no responder este correo, ya que se no es gestionado por alguna persona en particular.
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

        
        // $promotorMail = "juan.urrutiar@outlook.com";
        // echo "antes de enviar";
        // $promotorID = 2;
        if ($promotorMail != "")
        {   
            $email = new PHPMailer();
            

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
            $email->Subject   = 'Plan Proteccion: ' . str_replace("Ñ", "N", str_replace("ñ", "n", $pdf->__cliente));
            $email->IsHTML(true);
            $email->Body      = $bodyMail;
            $email->AddAddress( $promotorMail);
            
            $email->AddBCC ( 'juan.urrutiar@outlook.com' );
            

            
            $doc=$pdf->Output('S');
            $email->AddStringAttachment($doc, 'Galvamex_Plan_Proteccion_'.$pdf->__folioRD.'.pdf', 'base64', 'application/pdf');
            //$mail->Send();
            
            $result = $email->Send();
        // 	var_dump($result);
            //$result = 333;
            if ($result == 1)
            {
                //$respuesta = array("error" => false, "msg" => "Todo bien " . $idPedido . " res= " . $result);
                //
            // 	echo "
            // 		<div class=' text-center animated fadeInDown'>
            //     <h1>&Eacute;xito</h1>
            //     <h3 class='font-bold'>Correo enviado a ".$clienteMail."</h3>
            // </div>
                
                
            // 		<script>
            // 				//saTextoAndTitle('Pedido Enviado','Se ha enviado Pedido a Cliente via EMail');
            // 				setTimeout(function(){window.close();}, 3000);
                
            // 	</script>
                
            // 		";
                echo "\n<br>**** pdf sent ". $cte["idCliente"]  ." OK ****";
                NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_NOTIFICACION , $promotorID, "Plan Protección", "Haz recibido documento de Plan Protección para el cliente " . $pdf->__cliente);
                NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_NOTIFICACION , 2, "Plan Protección", "Se ha enviado documento de Plan Protección al Promotor ". $pdf->__promotor." para el cliente " . $pdf->__cliente);
                NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_NOTIFICACION , 6, "Plan Protección", "Se ha enviado documento de Plan Protección al Promotor ". $pdf->__promotor." para el cliente " . $pdf->__cliente);


                $pedido->getDataSet("update cliente set enviarPlanProteccion = 'NO' where idcliente = ".  $idCliente);
                
            }
            else
            {
                //$respuesta = array("error" => true, "msg" => "Errooooroorororororororororororororoororrrrrr");
            // 	echo "
            // 		<div class=' text-center animated fadeInDown'>
            //     <h1>Error</h1>
            //     <h3 class='font-bold'>Ha ocurrido un error al intentar enviar el correo electr&oacutenico.</h3>
            // </div>
            
            
            
                    // ";
                echo "Error";
            }	
        }
        else
        {
            // echo "
            // <div class=' text-center animated fadeInDown'>
            // <h1>Error</h1>
            // <h3 class='font-bold'>No se ha registrado un Correo al Cliente.</h3>
            // </div>
            
            // ";
            echo "NO email";
        }




        // //echo json_encode($respuesta);
    }
    else
    {
        continue;
    }



}


