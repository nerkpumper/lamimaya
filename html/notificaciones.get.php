<?php



//define('FOLDER_INCLUDE', '../include/');

define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');



define('FOLDER_HTML', './');

define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");

define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");



//define("URL_BASE","http://localhost:8080/galvamex/codigogalvamex/html/");
define("URL_BASE","http://app.galvamex.com.mx/");



require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';

require_once LIB_CONEXION;


require_once FOLDER_MODEL . "model.usuario.inc.php";



require_once FOLDER_MODEL. "model.notificacion.inc.php";


if (!isset($_POST["_IDUSUARIO"]))

{

	echo json_encode(array('error' => true,

			'debug' => "No se recibe parametro :(",

			'numeroNotificaciones' => "777"));

	return;

}



function contains ($needle, $haystack)

{

	return strpos($haystack, $needle) !== false;

}



$_IDUSUARIO = $_POST["_IDUSUARIO"];

//obtenemos numero de notificaciones

$noti = new ModeloNotificacion();


$lstNotificaciones = $noti->getAll("idNotificacion, tema, contenido, fecha",

		"",

		" idPara = " . $_IDUSUARIO . " and leido = 'NO' and borrar = 'NO' ",

		" idNotificacion desc ");


$noNotificaciones = count($lstNotificaciones);



//ahora a obtener las notificaciones



$i = 0;

$notificaciones = "";

foreach ($lstNotificaciones as $itemNotificacion)

{



	$notificaciones .= "<li>";

	$notificaciones .= "<a href='".URL_BASE."notificaciones'>";

	$notificaciones .= "<div>";

	$notificaciones .= "<i class='fa ". ( contains("ALTA PRODUCTO", strtoupper($itemNotificacion["tema"]))  ? "fa-barcode": "fa-shopping-cart") ." fa-fw'></i> " .  $itemNotificacion["tema"];

	// 				                     			echo "<span class='pull-right text-muted small'>".$itemNotificacion["fecha"]. "  ". $dias . " dias " .$minutos." minutos</span>";

	$notificaciones .= "</div>";

	$notificaciones .= "</a>";

	$notificaciones .= "</li>";

	$notificaciones .= "<li class='divider'></li>";



	$i++;



	if ($i >= 3)

	{

		break;

	}

}


$notificaciones .= "<li>";

$notificaciones .= "   <div class='text-center link-block'>";

$notificaciones .= "     <a href='".URL_BASE."notificaciones'>";

$notificaciones .= "       <strong>Ver todas las Notificaciones</strong>";

$notificaciones .= "       <i class='fa fa-angle-right'></i>";

$notificaciones .= "   </a>";

$notificaciones .= "   </div>";

$notificaciones .= "</li>";



$debug = "bien";

echo json_encode(array('error' => false,

					   'debug' => $debug,

		               'numeroNotificaciones' => $noNotificaciones,

		               'notificaciones' => $notificaciones

	));

return;

