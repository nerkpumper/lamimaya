<?php
$titlePage = "Procesa Pedidos / Autorizaci&oacute;n Autom&aacute;tica";
$breadCum = "Cron";




require_once NOTIFICATION_MANAGER;
require_once PEDIDOSTRACKING_MANAGER;


require_once FOLDER_MODEL . "model.pushnotifica.inc.php";
require_once FOLDER_MODEL . "model.pedidostracking.inc.php";


require_once FOLDER_MODEL. "model.configuracion.inc.php";

require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.cliente.inc.php";
require_once FOLDER_MODEL. "model.clientedatosfacturacion.inc.php";






function myLog($msg = "")

{

    echo "<br>".$msg;

}






myLog();

myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");

myLog();



// foreach ($pesosCalibresPies as $datoca)

    // {

    //     myLog(" Calibre: ".$datoca["calibre"]."  2 pies: " . $datoca["2"]. "  3 pies: " . $datoca["3"]. "  4 pies: " . $datoca["4"]);

$p = new ModeloPedido();



$lstPedidos = $p->getDataSet("SELECT idPedido FROM pedido WHERE checarAutorizacion = 'SI' AND estado NOT IN ('CANCELADO', 'ENTREGADO')");


foreach ($lstPedidos as $row)
{
    ob_start();
    myLog("  ....... ". date("Y-m-d H:i:s"). " START PEDIDO: ". $row["idPedido"]);
    myLog();
    $p->__isDebugging = true;
    $p->procesaAutorizacionAutomatica($row["idPedido"]);
    myLog("  ....... ". date("Y-m-d H:i:s"). " END PEDIDO: ". $row["idPedido"]);
    myLog();
    $debug = ob_get_clean();

    $fp = fopen(FOLDERLOGS .$row["idPedido"].'.html', 'a');//opens file in append mode.
    fwrite($fp, $debug);
    fclose($fp);
    echo $debug;

}

myLog();

myLog(date("Y-m-d H:i:s"). "    -              -- T E R M I N A  ---------------------------------------------");

myLog();
