<?php

require_once FOLDER_MODEL. "model.configuracion.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

function myLog($msg = "")
{
	echo "<br>".$msg;
}

$configuracion = new ModeloConfiguracion();
$pedido = new ModeloPedido();

//obtenemos la configuración, para tener los datos de Peso Estimado
//por calibre
$configuracion->setIdConfiguracion(1);

$pesoXCalibre22 = $configuracion->getPesoXCalibre22();
$pesoXCalibre24 = $configuracion->getPesoXCalibre24();
$pesoXCalibre26 = $configuracion->getPesoXCalibre26();
$pesoXCalibre28 = $configuracion->getPesoXCalibre28();

myLog("peso Calibre 22: " . $pesoXCalibre22);
myLog("peso Calibre 24: " . $pesoXCalibre24);
myLog("peso Calibre 26: " . $pesoXCalibre26);
myLog("peso Calibre 28: " . $pesoXCalibre28);
myLog();


//Obtenemos el listado de Pedidos
//$lstPedidosAProcesar = $pedido->getAll("idPedido, estado, explotado, listo_para_producir", "", "explotado = 'NO'", "idPedido");
$lstPedidosAProcesar = $pedido->getAll("idPedido, estado, explotado, listo_para_producir", "", "idPedido = 21", "idPedido");

foreach ($lstPedidosAProcesar as $row)
{
	$idPedidoProcesando = $row["idPedido"];
	$pedidoDetalle = new ModeloPedidodetalle();
	
	echo "<br>Pedido: ".$idPedidoProcesando."<br><br>";
	
	//Obtenemos el detalle de cada uno de los Pedidos
	$lstPedidoDetalle = $pedidoDetalle->getAll("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir", "", "idPedido = " . $idPedidoProcesando);
			
	foreach ($lstPedidoDetalle as $det)
	{
		echo "<br>".$det["idPedidoDetalle"]."  -  ".$det["renglon"]."  -  ".$det["idProducto"];
	}
}