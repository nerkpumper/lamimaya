<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cliente.inc.php";

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
//ob_start();	
// 	echo "hola mundito";
//$debug = ob_get_clean();
//$r->mostrarMsgs($debug);

																																																																																																										
		
	$xajax->processRequest();

	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Procesamiento de formulario----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#


	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Inicializacion de variables----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	

	#----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------Salida de Javascript-------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	
	$strTablaListado = "";
	
	$material = new ModeloCliente();
	
// 	`idCliente` INT NOT NULL AUTO_INCREMENT,
// 	`nombre` VARCHAR(70) NULL DEFAULT '',
// 	`apellidos` VARCHAR(70) NULL DEFAULT '',
// 	`empresa` VARCHAR(70) NULL DEFAULT '',
// 	`domicilio1` VARCHAR(70) NULL DEFAULT '',
// 	`domicilio2` VARCHAR(70) NULL DEFAULT '',
// 	`telefonos` VARCHAR(70) NULL DEFAULT '',
// 	`email` VARCHAR(70) NULL DEFAULT '',
// 	`rfc` VARCHAR(20) NULL DEFAULT '',

// 	global $objSession;
// 	$material->varDump($objSession);
	
// 	$objSession->dumpObj();
// 	$objSession->getIdUsuario();
	
	
	$andWhere = "";
 	if (Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
 	{
 		$idUsuario = $objSession->getIdUsuario();
//  		$andWhere = " AND idUsuarioPromotor = " . ($idUsuario = 10 ? 1 : $idUsuario);
 		$andWhere = " AND idUsuarioPromotor = " . $idUsuario;
 	}
 	 		
	
	 $material->__fillable=array("idCliente","nombre","apellidos", "username", "empresa", "domicilio1", "telefonos", "email", "rfc");
 	$material->__fillableHeader=array("Id","Nombre", "Apellido","Promotor", "Empresa", "domicilio", "telefonos", "Email", "RFC");
	
	 $lst = $material->getAll(
		"cliente.idCliente, cliente.nombre, cliente.apellidos, usuario.username, cliente.empresa, cliente.domicilio1, cliente.telefonos, cliente.email, cliente.rfc",
	  	"INNER JOIN usuario on usuario.idUsuario = cliente.idUsuarioPromotor ",
	   	"estado = 'ACTIVO' AND idCliente > 1 " . $andWhere,
		"idCliente",
		"");
	
	
	
	$strTablaListado = $material->getTableHTML($lst, "tblListado", true, true, "Cliente");
	