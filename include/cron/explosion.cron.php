<?php



if (isset($_SERVER['HTTP_HOST']))

	define("isCONSOLE",false);

else

	define("isCONSOLE",true);



//define('FOLDER_INCLUDE', '../');

//define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

// define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');

require_once 'configinclude.cron.php';



define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");

define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");



require_once LIB_CONEXION;

require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';



require_once FOLDER_MODEL. "model.configuracion.inc.php";

require_once FOLDER_MODEL. "model.producto.inc.php";

require_once FOLDER_MODEL. "model.rollo.inc.php";

require_once FOLDER_MODEL. "model.pedido.inc.php";

require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

require_once FOLDER_MODEL. "model.viewproductos.inc.php";

require_once FOLDER_MODEL. "model.pesomt.inc.php";
require_once FOLDER_INCLUDE . "lib/explosion.inc.php";



function myLog($msg = "")

{

	echo (isCONSOLE ? "\n" : "<br>").$msg;

}



// myLog("Todos los que son Pieza se sacan del inventario de Productos");

// myLog("Los demas del rollo en si");

// myLog();



$ctx = ExplosionHelper::crearContextoPesos();

// Logs iniciales
myLog();
myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");
myLog();
foreach ($ctx['pesosCalibresPies'] as $datoca) {
    myLog(" Calibre: ".$datoca["calibre"]."  2 pies: " . $datoca["2"]. "  3 pies: " . $datoca["3"]. "  4 pies: " . $datoca["4"]);
}
myLog();

//Obtenemos el listado de Pedidos
$pedido = new ModeloPedido();
$lstPedidosAProcesar = $pedido->getAll("idPedido, estado, explotado, listo_para_producir",
                                       "",
                                       "explotadook = 'NO'
                                           AND (estado = 'AUTORIZADO' OR estado = 'PRODUCCION' )  ",
                                       "idPedido");

$productosNegadosGlobal = array();
foreach ($lstPedidosAProcesar as $row) {
    $idPedidoProcesando = $row["idPedido"];
    myLog("---------------------------------------------------------------------------------------------------------------------------------------------");
    myLog("INICIO Pedido: <h1>" . $idPedidoProcesando . "</h1>");
    myLog();
    $res = ExplosionHelper::procesarExplosionPedido($idPedidoProcesando, $ctx, $productosNegadosGlobal, false);
    myLog("FIN Pedido: <h1>" . $idPedidoProcesando . "</h1>");
    myLog("---------------------------------------------------------------------------------------------------------------------------------------------");
}
