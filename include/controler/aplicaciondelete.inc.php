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
	
// 	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
	
	
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
			$r->saError("No se han podido cargar los datos de la Aplicación.");
			$r->redirect(URL_BASE . "aplicacion", 2);
			return $r;
		}			
		
		$aplicacion->setIdAplicacion($idAplicacion);
		
		//verifica si el material fue cargado
		if ($aplicacion->getIdAplicacion() <= 0)
		{
			$r->saError("No se han podido cargar los datos de la Aplicación.");
			$r->redirect(URL_BASE . "aplicacion", 2);
			return $r;
		}			

		$r->script("
				    app.nombreAplicacion = '" . $aplicacion->getNombreAplicacion() . "';                    
                     
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarAplicacion");
	
	function eliminarAplicacion($idAplicacion)
	{
		$r = new xajaxResponse();
	
		$aplicacion = new ModeloAplicacion();
	
		if ($idAplicacion <= 0)
		{
			$r->saError("No se han podido cargar los datos de la Aplicación.");
			$r->redirect(URL_BASE . "aplicacion", 2);
			return $r;
		}			
		
		$aplicacion->setIdAplicacion($idAplicacion);
		
		//verifica si el dato fue cargado
		if ($aplicacion->getIdAplicacion() <= 0)
		{
			$r->saError("No se han podido cargar los datos de la Aplicacion.");
			$r->redirect(URL_BASE . "aplicacion", 2);
			return $r;
		}	
	
			
		$aplicacion->AplicaBaja();
		
		if (!$aplicacion->getError())
		{
			$r->saSuccess("La Aplicación ha sido borrada. Redireccionando.");
			$r->redirect(URL_BASE . "aplicacion", 2);			
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar la Aplicación. " . $aplicacion->getStrError());			
		}
	
		return $r;
	}
	$xajax->registerFunction("eliminarAplicacion");

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
		