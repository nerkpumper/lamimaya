<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.material.inc.php";

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
	
	
	function cargarMaterial($idMaterial)
	{
		$r = new xajaxResponse();
		
		$material = new ModeloMaterial();
				
		if ($idMaterial <= 0)
		{
			$r->saError("No se han podido cargar los datos del material.");
			$r->redirect(URL_BASE . "material", 2);
			return $r;
		}			
		
		$material->setIdMaterial($idMaterial);
		
		//verifica si el material fue cargado
		if ($material->getIdMaterial() <= 0)
		{
			$r->saError("No se han podido cargar los datos del material.");
			$r->redirect(URL_BASE . "material", 2);
			return $r;
		}			

		$r->script("
				    app.nombre = '" . $material->getNombre() . "';
                    app.clave = '" . $material->getClave() . "';
                     
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarMaterial");
	
	function eliminarMaterial($idMaterial)
	{
		$r = new xajaxResponse();
	
		$material = new ModeloMaterial();
	
		if ($idMaterial <= 0)
		{
			$r->saError("No se han podido cargar los datos del material.");
			$r->redirect(URL_BASE . "material", 2);
			return $r;
		}			
		
		$material->setIdMaterial($idMaterial);
		
		//verifica si el usuario fue cargado
		if ($material->getIdMaterial() <= 0)
		{
			$r->saError("No se han podido cargar los datos del material.");
			$r->redirect(URL_BASE . "material", 2);
			return $r;
		}	
				
		$material->AplicaBaja();
		
		if (!$material->getError())
		{
			$r->saSuccess("El material ha sido borrado. Redireccionando.");
			$r->redirect(URL_BASE . "material", 2);			
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar el material. " . $material->getStrError());			
		}
	
		return $r;
	}
	$xajax->registerFunction("eliminarMaterial");

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
		