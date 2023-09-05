<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.proveedor.inc.php";

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
	
	
	function cargarProveedor($idProveedor)
	{
		$r = new xajaxResponse();
		
		$proveedor = new ModeloProveedor();
				
		if ($idProveedor <= 0)
		{
			$r->saError("No se han podido cargar los datos del proveedor.");
			$r->redirect(URL_BASE . "proveedor", 2);
			return $r;
		}			
		
		$proveedor->setIdProveedor($idProveedor);
		
		//verifica si el proveedor fue cargado
		if ($proveedor->getIdProveedor() <= 0)
		{
			$r->saError("No se han podido cargar los datos del proveedor.");
			$r->redirect(URL_BASE . "proveedor", 2);
			return $r;
		}			

		$r->script("
				    app.nombre = '" . $proveedor->getNombre() . "';
                    app.clave = '" . $proveedor->getClave() . "';
                     
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarProveedor");
	
	function eliminarProveedor($idProveedor)
	{
		$r = new xajaxResponse();
	
		$proveedor = new ModeloProveedor();
	
		if ($idProveedor <= 0)
		{
			$r->saError("No se han podido cargar los datos del proveedor.");
			$r->redirect(URL_BASE . "proveedor", 2);
			return $r;
		}			
		
		$proveedor->setIdProveedor($idProveedor);
		
		//verifica si el usuario fue cargado
		if ($proveedor->getIdProveedor() <= 0)
		{
			$r->saError("No se han podido cargar los datos del proveedor.");
			$r->redirect(URL_BASE . "proveedor", 2);
			return $r;
		}	
	
			
		$proveedor->AplicaBaja();
		
		if (!$proveedor->getError())
		{
			$r->saSuccess("El proveedor ha sido borrado. Redireccionando.");
			$r->redirect(URL_BASE . "proveedor", 2);			
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar el material. " . $proveedor->getStrError());			
		}
	
		return $r;
	}
	$xajax->registerFunction("eliminarProveedor");

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
		