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
	
//ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function guardarMaterial($idMaterial, $nombre, $clave)
	{
		$r = new xajaxResponse();
		$material = new ModeloMaterial();
		$isInsert = false;
		$regresar = false;
		
				
		if ($material->existeField("nombre", $nombre, $idMaterial))
		{
			$r->script("app.errNombre = \"". mb_convert_encoding("Este nombre de material ya está siendo utilizado. Debe especificar uno diferente.", 'UTF-8', 'ISO-8859-1') . "\"; ");
			$regresar = true;
		}
		
		if ($material->existeField("clave", $clave, $idMaterial))
		{
			$r->script("app.errClave = \"". mb_convert_encoding("Esta clave de material ya está siendo utilizada. Debe especificar una diferente.", 'UTF-8', 'ISO-8859-1') ."\"; ");
			$regresar = true;
		}
		
		if ($regresar)
		{
			return $r;
		}
		
		if ($idMaterial == 0)
		{
			$isInsert = true;
			$material->setDateUserCreating();
		}
		else
		{
			$material->setIdMaterial($idMaterial);
			$material->setDateUserUpdating();
		}
		
		$material->setNombre($nombre); 
		$material->setClave($clave);
		
		$material->Guardar();
		
		if ($material->getError())
		{
			$r->saError($material->getStrError());
			return $r;
		}
				
		if ($isInsert)
		{
			$r->saSuccess("El Material " .$nombre . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "material",2);
		}
		else
		{
			$r->saSuccess("El Material " .$nombre . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "material",2);
		}
		
		
		
		return $r;
	}
	$xajax->registerFunction("guardarMaterial");
	
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
		
		//verifica si el usuario fue cargado
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
	