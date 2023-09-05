<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";

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
	
	
	function cargarTipoProducto($idTipoProducto)
	{
		$r = new xajaxResponse();
		
		$tipoProducto = new ModeloTipoProducto();
				
		if ($idTipoProducto <= 0)
		{
			$r->saError("No se han podido cargar los datos del tipo de producto.");
			$r->redirect(URL_BASE . "tipoproducto", 2);
			return $r;
		}			
		
		$tipoProducto->setidTipoProducto($idTipoProducto);
		
		//verifica si el material fue cargado
		if ($tipoProducto->getIdTipoProducto() <= 0)
		{
			$r->saError("No se han podido cargar los datos del tipo producto.");
			$r->redirect(URL_BASE . "tipoproducto", 2);
			return $r;
		}			

		$r->script("
				    app.nombre = '" . $tipoProducto->getNombre() . "';
                    app.clave = '" . $tipoProducto->getClave() . "';
                     
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarTipoProducto");
	
	function eliminarTipoProducto($idTipoProducto)
	{
		$r = new xajaxResponse();
	
		$tipoProducto = new ModeloTipoProducto();
	
		if ($idTipoProducto <= 0)
		{
			$r->saError("No se han podido cargar los datos del tipo producto.");
			$r->redirect(URL_BASE . "tipoproducto", 2);
			return $r;
		}			
		
		$tipoProducto->setIdTipoProducto($idTipoProducto);
		
		//verifica si el usuario fue cargado
		if ($tipoProducto->getIdTipoProducto() <= 0)
		{
			$r->saError("No se han podido cargar los datos del tipo producto.");
			$r->redirect(URL_BASE . "tipoproducto", 2);
			return $r;
		}	
	
			
		$tipoProducto->AplicaBaja();
		
		if (!$tipoProducto->getError())
		{
			$r->saSuccess("El tipo producto ha sido borrado. Redireccionando.");
			$r->redirect(URL_BASE . "tipoproducto", 2);			
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar el tipo producto. " . $tipoProducto->getStrError());			
		}
	
		return $r;
	}
	$xajax->registerFunction("eliminarTipoProducto");

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
		