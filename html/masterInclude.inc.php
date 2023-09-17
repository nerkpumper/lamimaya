<?php

	date_default_timezone_set("America/Mexico_City");
	header("Content-Type: text/html;charset=utf-8");
	
	//session_start();
	define("ORIGEN",$_SERVER['HTTP_HOST']);
	switch(ORIGEN)
	{
		default:
			define("LOCAL","1");
			break;
	}

	define('FOLDER_INCLUDE', '../include/');
	define('FOLDER_HTML', './');
	//define('FOLDER_IMG', '../html/img/jdjd');
	
	require_once FOLDER_INCLUDE . 'config/constantes.inc.php';
	//require_once FOLDER_CONTROLLER . "index.inc.php";

	require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';
	require_once LIB_CONEXION;
	//require_once LIB_CONEXION_SQL;
	//require_once LIB_CONEXION_MYSQL;
	require_once FOLDER_LOGIN;
	//require_once FOLDER_PERMISOS;

	sec_session_start();

	#require_once FOLDER_MODEL . "clsSession.inc.php";
	require_once FOLDER_MODEL . "model.usuario.inc.php";
	require_once LIB_XAJAX;



	$f=explode("/",$_SERVER['PHP_SELF']);
	$f=$f[count($f)-1];

	$__FILE_NAME__ = str_replace(array(	"/",".php"), "", $f);


// 	if(defined("LOGIN")&&LOGIN==1)
// 	{
// 		if (login_check($dbLink)&&isset($_SESSION["_lmobjSession"]))
// 		{

// 			$objSession = unserialize($_SESSION['_lmobjSession']);
// 			$objSession->__construct();
// 		}
// 		else
// 		{
// 			header("Location: index.php");
// 			die();
// 		}

// 		//permiso($__FILE_NAME__,'visita','asignado');

// 		//$_menuLateral=generaMenuLateral();
// 		//$_menuTop=generaMenuTop();
// 	}
// 	else
// 	{
// 		$_menuLateral="";
// 		$_menuTop="";
// 	}
	


	if (is_file(FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php"))
		require_once (FOLDER_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php");

	if (! isset($_JAVASCRIPT_CSS))
		$_JAVASCRIPT_CSS = '';

	$_JAVASCRIPT_CSS.='
			<script language="javascript" src="' . URL_JAVASCRIPT_LIB . 'common.js"></script>';
	if (isset($xajax))
		$_JAVASCRIPT_CSS .= $xajax->getJavascript("js/lib/");



	if (is_file(FOLDER_JS . $__FILE_NAME__ . ".js"))
		$_JAVASCRIPT_CSS .= '<script type="text/javascript" src="' . URL_JAVASCRIPT_SYSTEM .
				 $__FILE_NAME__ . '.js"></script>';
	else
		$_JAVASCRIPT_CSS .= '<script type="text/javascript" src="' . URL_JAVASCRIPT_LIB .
		'default.js"></script>';

	if (isset($_JAVASCRIPT_OUT))
		$_JAVASCRIPT_CSS .= '<script type="text/javascript">' . $_JAVASCRIPT_OUT .
				 '</script>';