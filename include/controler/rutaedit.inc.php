<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.ruta.inc.php";
	
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
		
	function guardarRuta($idRuta, $nombre, $descripcion)
	{
		$r = new xajaxResponse();
		$ruta = new ModeloRuta();
		$isInsert = false;
		$regresar = false;
		
				
		if ($ruta->existeField("nombre", $nombre, $idRuta))
		{
			$r->script("app.errNombre = \"". mb_convert_encoding("Este nombre de ruta ya está siendo utilizado. Debe especificar uno diferente.", 'UTF-8', 'ISO-8859-1') . "\"; ");
			$regresar = true;
		}
		
		
		
		if ($regresar)
		{
			return $r;
		}
		
		if ($idRuta == 0)
		{
			$isInsert = true;
			$ruta->setDateAndUser("crea");
		}
		else
		{
			$ruta->setIdRuta($idRuta);
			
		}
		
		$ruta->setNombre($nombre); 
		$ruta->setDescripcion($descripcion);
		
		$ruta->Guardar();
		
		if ($ruta->getError())
		{
			$r->saError($ruta->getStrError());
			return $r;
		}
				
		if ($isInsert)
		{
			$r->saSuccess("La Ruta " .$nombre . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "ruta",2);
		}
		else
		{
			$r->saSuccess("La Ruta " .$nombre . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "ruta",2);
		}
		
		$r->script("app.idRuta= ".$ruta->getIdRuta()."; app.saveImage(); setTimeout(function(){ app.removeImage();},250); ");
		
		return $r;
	}
	$xajax->registerFunction("guardarRuta");
	
	function cargarRuta($idRuta)
	{
		$r = new xajaxResponse();
		
		$ruta = new ModeloRuta();
				
		if ($idRuta <= 0)
		{
			$r->saError("No se han podido cargar los datos de la ruta. " . $idRuta);
			$r->redirect(URL_BASE . "ruta", 2);
			return $r;
		}			
		
		$ruta->setIdRuta($idRuta);
		
		
		if ($ruta->getIdRuta() <= 0)
		{
			$r->saError("No se han podido cargar los datos de la ruta. ". $idRuta);
			$r->redirect(URL_BASE . "ruta", 2);
			return $r;
		}
		
		$r->script("
				    app.nombre = '" . $ruta->getNombre() . "';
                    app.descripcion = '" . $ruta->getDescripcion() . "';                    
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarRuta");

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
	