<?php

	

	#------------------------------------------------------------------------------------------#

	#------------------------------------------FOLDER------------------------------------------#

	#------------------------------------------------------------------------------------------#



	define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");

	define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

	define("FOLDER_JS",FOLDER_HTML . "js/system/");

	define("FOLDER_LOGIN",FOLDER_INCLUDE . "lib/login/loginfunctions.inc.php");

	

	define("FOLDER_APP_WS",FOLDER_INCLUDE . "app/");

	define("FOLDER_LOG",FOLDER_INCLUDE . "log/");



	#------------------------------------------------------------------------------------------#

	#-------------------------------------------LIB--------------------------------------------#

	#------------------------------------------------------------------------------------------#

	define("LIB_XAJAX",FOLDER_INCLUDE . "lib/xajax_core/xajax.inc.php");	

	define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

	//define("LIB_FLASHMSGS",FOLDER_INCLUDE . "lib/msgs/FlashMsgs.inc.php");	

	//define("LIB_CONEXION_SQL",FOLDER_INCLUDE . "lib/Conexion/ConexionSQL.inc.php");

	define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");

	define("LIB_APP_FUNCTIONS",FOLDER_INCLUDE . "lib/app/functions.inc.php");



	define("LIB_PERMISOS",FOLDER_INCLUDE . "lib/app/class.permisos.inc.php");

	define("LIB_LUGAR",FOLDER_INCLUDE . "lib/class.lugar.inc.php");

	define("LIB_ROUTES",FOLDER_INCLUDE . "lib/app/routes.php");
	define("LIB_REPORTEADOR",FOLDER_INCLUDE . "lib/class.reporteador.inc.php");
        define("LIB_NUMEROALETRAS",FOLDER_INCLUDE . "lib/class.numeroaletras.inc.php");
	define("LIB_UTILERIAS",FOLDER_INCLUDE . "lib/class.utilerias.inc.php");

	

	define("HELPER_FORMS",FOLDER_INCLUDE . "lib/app/class.forms.inc.php");

	define("NOTIFICATION_MANAGER",FOLDER_INCLUDE . "lib/app/class.notificationmanager.inc.php");
	define("PEDIDOSTRACKING_MANAGER",FOLDER_INCLUDE . "lib/app/class.pedidotracking.inc.php");
	
	define( 'API_ACCESS_KEY', 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA' );


	

	#------------------------------------------------------------------------------------------#

	#-------------------------------------------URL--------------------------------------------#

	#------------------------------------------------------------------------------------------#



	define("URL_BASE","http://localhost:8080/appgalvamex/galvamexrepo/html/");	

	// define("URL_BASE","http://app.galvamex.com.mx/");

	

	define("URL_JAVASCRIPT",URL_BASE . "js/");

	define("URL_JAVASCRIPT_SYSTEM",URL_BASE . "js/system/");

	define("URL_JAVASCRIPT_LIB",URL_BASE . "js/lib/");

	

	#------------------------------------------------------------------------------------------#

	#------------------------------------------VARIAS------------------------------------------#

	#------------------------------------------------------------------------------------------#



	define("LOGIN_ATTEMPS_LIMIT",5);

	

	define("TIME_TO_RETURN_EDIT",2);

	define("TIME_TO_RETURN_DELETE",2);

			

	define("DEVELOPER",false);	

	$_NOW_=date("Y-m-d H:i:s");

	$_CURDATE_=date("Y-m-d");

	$_CURTIME_=date("H:i:s");

	

	

	

	

	

	