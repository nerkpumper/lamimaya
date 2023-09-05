<?php

require_once "baseapi.inc.php";

require_once FOLDER_MODEL. "model.usocfdi.inc.php";

$cfdi = new ModeloUsocfdi();

$cfdi->setIdUsoCfdi(2);

if (isset($_POST["idPedido"]))
{
	$respuesta = array("error" => false, "msg" => $cfdi->getDescripcion());	
}
else
{
	$respuesta = array("error" => true, "msg" => "Errooooroorororororororororororororoororrrrrr");
}




echo json_encode($respuesta);