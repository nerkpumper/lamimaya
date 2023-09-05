<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.viewrollos.inc.php";
	require_once FOLDER_MODEL. "model.rollo.inc.php";

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

	
	function cargarRollo($idRollo)
	{
		$r = new xajaxResponse();
		
		$rollo = new ModeloViewrollos();
				
		if ($idRollo <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}			
		
		$rollo->getView($idRollo);
		
		//verifica si el material fue cargado
		if ($rollo->getIdRollo()<= 0)
		{
			$r->saError("No se han podido cargar los datos del Rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}		
		
		if ($rollo->getEstado() == "ACTIVO")
		{
			$r->script("
			
				app.codigo = '".$rollo->getCodigo()."';				
				app.material = '".$rollo->getMaterial()."';
				app.proveedor =  '".$rollo->getProveedor()."';
				app.calibre = '".$rollo->getCalibre()."';
				app.pies = '".$rollo->getPies()."';
				app.descripcion = '".$rollo->getDescripcion()."';
				app.existencia = '".$rollo->getExistencia()."';				
           
				  ");
			
			
		}
		else
		{
			$r->script("
			
				app.rolloEliminado = true;
			
				  ");
			
		}
			

		
		
		return $r;
	}	
	$xajax->registerFunction("cargarRollo");
	
	function eliminarRollo($idRollo)
	{
		$r = new xajaxResponse();
	
		$rollo = new ModeloRollo();
		
		if ($idRollo <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}
	
		$rollo->setIdRollo($idRollo);
	
		//verifica si el material fue cargado
		if ($rollo->getIdRollo() <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}
	
		$rollo->setEstadoBAJA();
		$rollo->setDateAndUser("baja");
		$rollo->Guardar();
		
		if (!$rollo->getError())
		{
			$r->saSuccess("El rollo ha sido borrado. Redireccionando.");
			$r->redirect(URL_BASE . "rollo", 2);
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar el rollo. " . $rollo->getStrError());
		}
		
		return $r;
	}
	$xajax->registerFunction("eliminarRollo");
	
	
	
	
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
		