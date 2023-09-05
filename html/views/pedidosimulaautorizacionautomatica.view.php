<?php
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.cliente.inc.php";
require_once FOLDER_MODEL. "model.clientedatosfacturacion.inc.php";


function salir(){
	echo "<script>

					window.close();
		</script>";
}

function myLog($msg = "")

{

    echo "<br>".$msg;

}

$idPedido = 0;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
	$idPedido = $_GET["id"];
}

if ($idPedido > 0)
{    
    $p = new ModeloPedido();
    $p->__isDebugging = true;
    $p->procesaAutorizacionAutomatica($idPedido, true);


}
else{
    echo "Debe indicar Pedido";
}

