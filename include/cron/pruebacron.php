<?php

require_once('class.phpmailer.php');

$_NOW_=date("Y-m-d H:i:s");
$_NOW_;

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'¡Hola, Mundo! ' . $_NOW_);

$email = new PHPMailer();
$email->From      = 'juan.urrutiar@sabes.edu.mx';
$email->FromName  = 'Nerk Pumper';
$email->Subject   = 'Cron ' . $_NOW_;
$email->Body      = "Hola mundo";
$email->AddAddress( 'juan.urrutiar@outlook.com' );

//$file_to_attach = 'archivo.pdf';

//$email->AddAttachment( $file_to_attach , 'archivo.pdf' );

// $doc=$pdf->Output('S');
// $email->AddStringAttachment($doc, 'filecillo.pdf', 'base64', 'application/pdf');
//$mail->Send();

$email->Send();

