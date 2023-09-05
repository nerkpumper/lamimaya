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



require_once NOTIFICATION_MANAGER;
require_once PEDIDOSTRACKING_MANAGER;



require_once FOLDER_MODEL . "model.pushnotifica.inc.php";
require_once FOLDER_MODEL . "model.pedidostracking.inc.php";


require_once FOLDER_MODEL. "model.configuracion.inc.php";

require_once FOLDER_MODEL. "model.producto.inc.php";
require_once FOLDER_MODEL. "model.cliente.inc.php";

require_once FOLDER_MODEL. "model.rollo.inc.php";

require_once FOLDER_MODEL. "model.pedido.inc.php";

require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

require_once FOLDER_MODEL. "model.viewproductos.inc.php";

require_once FOLDER_MODEL. "model.pesomt.inc.php";

require_once FOLDER_MODEL. "model.pedidodetallecolocacion.inc.php";



function myLog($msg = "")

{

    echo (isCONSOLE ? "\n" : "<br>").$msg;

}






myLog();

myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");

myLog();



// foreach ($pesosCalibresPies as $datoca)

    // {

    //     myLog(" Calibre: ".$datoca["calibre"]."  2 pies: " . $datoca["2"]. "  3 pies: " . $datoca["3"]. "  4 pies: " . $datoca["4"]);

    // }





$cliente = new ModeloCliente();



$lstClientes = $cliente->getDataSet("SELECT idCliente FROM cliente WHERE procesarCreditos = 'SI'");





foreach ($lstClientes as $row)

{
    $pedido = new ModeloPedido();

    myLog("Procesando idCliente: ". $row["idCliente"]);
    $pedido->procesaCreditoYCapacidadDePago($row["idCliente"]);

}



myLog();

myLog(date("Y-m-d H:i:s"). "    -              -- T E R M I N A  ---------------------------------------------");

myLog();