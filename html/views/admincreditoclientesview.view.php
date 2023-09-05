<?php
$titlePage = "Cr&eacute;dito a Clientes";
$breadCum = "Cliente/Cr&eacute;dito a Cliente";
$_lugar = LUGAR_ADMINISTRACION_CREDITOCLIENTES;

require_once FOLDER_MODEL. "model.pedido.inc.php";

$pedido = new ModeloPedido();


echo $pedido->getlogCliente($param1);


