<?php

// define('FOLDER_INCLUDE', '../include/');
define('FOLDER_INCLUDE2', '/home/galvamex/appgalvamex/include/');
// define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

define("FOLDER_MODEL_BASE2",FOLDER_INCLUDE2 . "model/base/");
define("FOLDER_MODEL2",FOLDER_INCLUDE2 . "model/extend/");

// define("URL_JAVASCRIPT_LIB",URL_BASE . "js/lib/");


require_once FOLDER_INCLUDE2 . 'model/clsBasicCommon.inc.php';

require_once FOLDER_INCLUDE2 . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL2. "model.pedido.inc.php";
require_once FOLDER_INCLUDE2 . 'lib/mail/class.phpmailer.php';





$clienteMail = "juan.urrutiar@outlook.com";
if ($clienteMail != "")
{
    $email = new PHPMailer();
    
    $email->From      = 'noresponder@galvamex.com';
    $email->FromName  = 'Galva Mex';
    $email->Subject   = 'Galva Mex Pedido: ' . $idPedido;
    $email->IsHTML(true);
    $email->Body      = $bodyMail;
    // 	$email->AddAddress( $clienteMail);
    $email->AddAddress( 'juan.urrutiar@outlook.com' );
    $email->AddBCC ( 'juan.urrutiar@outlook.com' );
    
    // 	$email->AddAddress( 'juan.urrutiar@outlook.com');
    
//     $doc=$pdf->Output('S');
//     $email->AddStringAttachment($doc, 'Galvamex_Pedido_'.$idPedido.'.pdf', 'base64', 'application/pdf');
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