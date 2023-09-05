<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.aplicacion.inc.php";
	
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
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function guardarAplicacion($idAplicacion, $nombre)
	{
		$r = new xajaxResponse();
		$aplicacion = new ModeloAplicacion();
		$isInsert = false;
		$regresar = false;
		
				
		if ($aplicacion->existeField("nombreAplicacion", $nombre))
		{
			$r->script("app.errNombreAplicacion = \"".utf8_encode("Esta Aplicación ya está siendo utilizado. Debe especificar una diferente.")."\"; ");
			$regresar = true;
		}
		
		if ($regresar)
		{
			return $r;
		}
		
		if ($idAplicacion == 0)
		{
			$isInsert = true;
			$aplicacion->setDateUserCreating();
		}
		else
		{
			$aplicacion->setIdAplicacion($idAplicacion);
			$aplicacion->setDateUserUpdating();
		}
		
		$aplicacion->setNombreAplicacion($nombre); 
				
		$aplicacion->Guardar();
		
		if ($aplicacion->getError())
		{
			$r->saError($aplicacion->getStrError());
			return $r;
		}
				
		if ($isInsert)
		{
			$r->saSuccess("La Aplicación " .$nombre . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "aplicacion",2);
		}
		else
		{
			$r->saSuccess("La Aplicación " .$nombre . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "aplicacion",2);
		}
		
				
		return $r;
	}
	$xajax->registerFunction("guardarAplicacion");
	
	function cargarAplicacion($idAplicacion)
	{
		$r = new xajaxResponse();
		
		$aplicacion = new ModeloAplicacion();
				
		if ($idAplicacion == 1)
		{			
			$r->redirect(URL_BASE . "aplicacion");
			return $r;
		}
		
		if ($idAplicacion <= 0)
		{
			$r->saError("No se han podido cargar los datos de la Aplicaci�n.");
			$r->redirect(URL_BASE . "modelolamina", 2);
			return $r;
		}			
		
		$aplicacion->setIdAplicacion($idAplicacion);
		
		//verifica si el usuario fue cargado
		if ($aplicacion->getIdAplicacion() <= 0)
		{
			$r->saError("No se han podido cargar los datos de la Aplicaci�n.");
			$r->redirect(URL_BASE . "aplicacion", 2);
			return $r;
		}
		
		$r->script("
				    app.nombreAplicacion = '" . utf8_encode($aplicacion->getNombreAplicacion()) . "';                                        
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarAplicacion");

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
	