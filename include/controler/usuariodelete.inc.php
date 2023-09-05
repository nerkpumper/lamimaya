<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	require_once FOLDER_MODEL. "model.rol.inc.php";

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
// 	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
	
	
	function cargarUsuario($idUsuario)
	{
		$r = new xajaxResponse();
		
		$usuario= new ModeloUsuario();
				
		if ($idUsuario <= 0)
		{
			$r->saError("No se han podido cargar los datos del usuario.");
			$r->redirect(URL_BASE . "usuario", 2);
			return $r;
		}			
		
		$usuario->setIdUsuario($idUsuario);
		
		//verifica si el usuario fue cargado
		if ($usuario->getIdUsuario() <= 0)
		{
			$r->saError("No se han podido cargar los datos del usuario.");
			$r->redirect(URL_BASE . "usuario", 2);
			return $r;
		}			
		
		
		
		$r->script("
				    app.username = '" . $usuario->getUsername() . "';
                    app.email = '" . $usuario->getEmail() . "';
                    app.nombre = '" . $usuario->getNombre() . "';       
                    app.apellidoPaterno = '" . $usuario->getApellidoPaterno() . "';
                    app.apellidoMaterno = '" . $usuario->getApellidoMaterno() . "';
                     
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarUsuario");
	
	function eliminarUsuario($idUsuario)
	{
		$r = new xajaxResponse();
	
		$usuario= new ModeloUsuario();
	
		if ($idUsuario <= 0)
		{
			$r->saError("No se han podido cargar los datos del usuario.");
			$r->redirect(URL_BASE . "usuario", 2);
			return $r;
		}			
		
		$usuario->setIdUsuario($idUsuario);
		
		//verifica si el usuario fue cargado
		if ($usuario->getIdUsuario() <= 0)
		{
			$r->saError("No se han podido cargar los datos del usuario.");
			$r->redirect(URL_BASE . "usuario", 2);
			return $r;
		}			
			
		$usuario->Borrar();
		
		if (!$usuario->getError())
		{
			$r->saSuccess("El usuario ha sido borrado. Redireccionando.");
			$r->redirect(URL_BASE . "usuario", 2);			
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar al usuario. " . $usuario->getStrError());			
		}
	
		return $r;
	}
	$xajax->registerFunction("eliminarUsuario");

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
		