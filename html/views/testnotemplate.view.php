<?php 
//   	ob_start();
echo "empezamos";
return;
// define('FOLDER_INCLUDE', '../../include/');
//define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');
define('FOLDER_INCLUDE', 'C:/xampp/htdocs/galvamex/codigogalvamex/html/include/');


define('FOLDER_HTML', './');
define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");
define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");
define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';
require_once LIB_CONEXION;

// require_once FOLDER_MODEL . "model.usuario.inc.php";

require_once FOLDER_MODEL. "model.notificacion.inc.php";

$noti = new ModeloNotificacion();



// $lstNotificaciones = $noti->getAll("tema, contenido, fecha",
// 		"",
// 		"idPara = " . ModeloUsuario::getObjSession()->getIdUsuario() . " and leido = 'NO' and borrar = 'NO' ");


echo json_encode(array('error' => false,
		'debug' => "hola mundo " . ModeloUsuario::getObjSession()->getIdUsuario(),
		'numeroNotificaciones' => "122"));
return;

// echo json_encode(array('error' => false,
// 		'debug' => "bien",
// 		'numeroNotificaciones' => "666"));
// return;
 
// $noNotificaciones = count($lstNotificaciones);
$noNotificaciones = "666";


echo "holis";

// $debug = ob_get_clean();
$debug = "bien";
// echo json_encode(array('error' => false,
// 					   'debug' => $debug,
// 		               'numeroNotificaciones' => $noNotificaciones));
// return;
