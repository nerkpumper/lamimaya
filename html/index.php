<?php

// echo "bien en index.php Linea " . __LINE__; return;

date_default_timezone_set("America/Mexico_City");

header("Content-Type: text/html;charset=utf-8");

define("LOGINPAGE","login");

//session_start();

define("ORIGEN",$_SERVER['HTTP_HOST']);

switch(ORIGEN)
{
	default:
		define("LOCAL","1");
		break;
}

// define('FOLDER_INCLUDE', '../include/');
// define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');
// if (file_exists("configinclude.inc.php"))
// {
// 	echo "si existe file";
// }
// else
// {
// 	echo "NO existe file";
// }

require_once 'configinclude.inc.php';

define('FOLDER_HTML', './');

define('FOLDER_IMG', FOLDER_HTML . '/img/');

require_once FOLDER_INCLUDE . 'config/constantes.inc.php';

require_once LIB_PERMISOS;

require_once FOLDER_INCLUDE . 'config/constantesrutas.inc.php';

//require_once FOLDER_CONTROLLER . "index.inc.php";

require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';
require_once LIB_CONEXION;

//require_once LIB_CONEXION_SQL;
require_once LIB_CONEXION_MYSQL;
require_once FOLDER_LOGIN;
//require_once FOLDER_PERMISOS;

sec_session_start();

#require_once FOLDER_MODEL . "clsSession.inc.php";

require_once FOLDER_MODEL . "model.usuario.inc.php";
require_once FOLDER_MODEL . "model.pedidostracking.inc.php";
require_once FOLDER_MODEL . "model.pushnotifica.inc.php";
require_once LIB_XAJAX;
require_once LIB_ROUTES;
require_once LIB_UTILERIAS;
require_once HELPER_FORMS;
require_once NOTIFICATION_MANAGER;
require_once PEDIDOSTRACKING_MANAGER;




$f=explode("/",$_SERVER['PHP_SELF']);

$f=$f[count($f)-1];





if (empty($_GET['url']))

{

	$url = "index";

}

else

{

	$url = $_GET['url'];

}



// echo "<br> URL : " . $url; return;

$segmentsFromURL = explode('/', $url);



//$controller = array_shift($segments);



//$__FILE_NAME__ = str_replace(array(	"/",".php"), "", $f);

//se obtiene ahora desde la url el primer segmento, que ser� el objeto o vista que queremos mostrar

$__FILE_NAME__ = array_shift($segmentsFromURL); 

//echo $__FILE_NAME__;







if (Routes::authRequired($__FILE_NAME__))

{

	//echo "Definimos LOGIN porque " . $__FILE_NAME__ . "<br>"; 

	define("LOGIN",1);

}





if(defined("LOGIN")&&LOGIN==1)

{	

	if (login_check($dbLink)&&isset($_SESSION["_lmobjSession"]))

	{

		$objSession = unserialize($_SESSION['_lmobjSession']);

		$objSession->__construct();		

	}

	else

	{
// 		echo " Redirigir:   " .  URL_BASE . "login.php";

// 		die();

		header("Location: " . URL_BASE . "login");

		die();

	}



			//permiso($__FILE_NAME__,'visita','asignado');



			//$_menuLateral=generaMenuLateral();

			//$_menuTop=generaMenuTop();

}

else

{

	if ($__FILE_NAME__ == "login")

	{

		if (login_check($dbLink)&&isset($_SESSION["_lmobjSession"]))

		{

			header("Location: " . URL_BASE . "index");

// 			echo "no login";

			die();

		}		

	}

}

// 	else

	// 	{

	// 		$_menuLateral="";

	// 		$_menuTop="";

	// 	}

	



if (!Routes::moduleAllow($__FILE_NAME__))

{   //echo "no entras: " . $__FILE_NAME__;

	{

		if (DEVELOPER)

		{

			$objSession = unserialize($_SESSION['_lmobjSession']);

			$objSession->__construct();

			$objSession->dumpObj();

			echo "modulo no permitido";

		}

		else

		{

			header("Location: " . URL_BASE . "index");

		}

		

				

		die();

	}

}



//$param1 = "hardcodiado";



//los demas segmentos de la URL, ser�n los par�metros

$segmentos = $segmentsFromURL;



$parametros = array();

$parametrosCounter = 1;



//cada uno de los parametros se pondr�n en javascript, en orden

// param1, param2 ... param n

// no he encontrado alguna forma de ponerles el nombre de una variable mas adecuada

// la soluci�n ser�a, paridad en argumentos, por ejemplo

// id/1/numeroDeCatalogo/2

//para as� tener en java y en php las variables

// var id = 1; var numeroDeCatalogo = 2;

// $id = 1; $numeroDeCatalogo = 2

//pero no se me hace que se vea bien

//echo "iniciamos . . . ";

//se definen los css comunes

if (! isset($_JAVASCRIPT_CSS))

	$_JAVASCRIPT_CSS = '';



$_JAVASCRIPT_CSS .= '<script type="text/javascript">';





//Ponemos la ruta inicial del sistema para el enrutamiento

$_JAVASCRIPT_CSS .= "var URL_BASE = '" . URL_BASE . "'; ";

//echo "<br> antes de getobjsession";

$objUsuarioTmp = ModeloUsuario::getObjSession();

//echo "<br> despues de getobjsession";


if ($objUsuarioTmp != null)

{

	$_JAVASCRIPT_CSS .= "var _IDUSUARIO = '" . ModeloUsuario::getObjSession()->getIdUsuario() . "'; ";	
	$_JAVASCRIPT_CSS .= "var _IDSUCURSAL = '" . ModeloUsuario::getObjSession()->getIdSucursal() . "'; ";	
	$_JAVASCRIPT_CSS .= "var _IDROL = '" . ModeloUsuario::getObjSession()->getIdRol() . "'; ";	

	$_JAVASCRIPT_CSS .= "var _IDROL = " . ModeloUsuario::getObjSession()->getIdRol() . "; ";	

}










foreach ($segmentos as $p)

{

	$parametros["param" . $parametrosCounter] = $p;

	$_JAVASCRIPT_CSS .= "var param" . $parametrosCounter . " = '" . $p . "';";

	$parametrosCounter++;

}



$_JAVASCRIPT_CSS .= '</script>';



//extraemos las variables para leerlas desde php

extract($parametros);



//se carga el controlador si es que �ste existe
//echo "<br> antes de ir por el controlador";

//echo "<br>" .FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php -> " . is_file(FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php");

if (is_file(FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php"))
{
//	echo "<br> lo requeriremos .. ";
	require_once (FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php");
}
//echo "<br> despues de ir por el controlador";


//controlador para las notificaciones

// if (is_file(FOLDER_INCLUDE . "controler/headercontroller.inc.php"))

// 		require_once (FOLDER_INCLUDE . "controler/headercontroller.inc.php");









$_JAVASCRIPT_CSS.='

		<script language="javascript" src="' . URL_JAVASCRIPT_LIB . 'common.js"></script>';











//se inserta el ajax
if (isset($xajax))
{
//	echo "<br> Si esta seteado xajax<br<br>";
	$_JAVASCRIPT_CSS .= $xajax->getJavascript(URL_BASE ."js/lib/");
}
else
{
   // echo "<br> NO esta seteado xajax<br<br>";
}




if (Routes::getTemplate($__FILE_NAME__) == "masterTemplate.inc.php")

{

// echo "cargar header";

	if (is_file(FOLDER_JS . "header.js"))

		$_JAVASCRIPT_CSS .= '<script type="text/javascript" src="' . URL_JAVASCRIPT_SYSTEM .

		'header.js"></script>';	

}

// else

// {

// 	echo "no cargar header";

// }







//se carga el js, en caso de existir, sino solo el default	
$versionjs = "202210070103";
if (is_file(FOLDER_JS . $__FILE_NAME__ . ".js"))

	$_JAVASCRIPT_CSS .= '<script type="text/javascript" src="' . URL_JAVASCRIPT_SYSTEM .

				$__FILE_NAME__ . '.js?version='.$versionjs.'"></script>';

else

	$_JAVASCRIPT_CSS .= '<script type="text/javascript" src="' . URL_JAVASCRIPT_LIB .

				'default.js"></script>';



//en caso de tener algun otro script	

if (isset($_JAVASCRIPT_OUT))

	$_JAVASCRIPT_CSS .= '<script type="text/javascript">' . $_JAVASCRIPT_OUT .

					'</script>';





//ahora cargamos la vista, la coloqu� en una carpeta de vista, para separarla de las demas carpetas

//ademas que cada vista deber� tener en el nombre .view.php

if (is_file( "views/"  . $__FILE_NAME__ . ".view.php"))

{

	ob_start();

	

	$__MODULE_NAME__ = $__FILE_NAME__;

	require_once ("views/" . $__FILE_NAME__ . ".view.php");

	

	$view_content = ob_get_clean();

}	

else 

{

	ob_start();

	

	

	require_once ("views/404.view.php");

	$__FILE_NAME__ = "404";

	$__MODULE_NAME__ = $__FILE_NAME__;

	$view_content = ob_get_clean();

	

	

	//exit('No se ha encontrado la vista'); //indicamos que no existe la vista que se desea mostrar

	

}

	



//Se carga el template del m�dulo

require_once Routes::getTemplate($__FILE_NAME__);





//se cargan los scripts

echo $_JAVASCRIPT_CSS;	







//echo htmlspecialchars($_JAVASCRIPT_CSS);

