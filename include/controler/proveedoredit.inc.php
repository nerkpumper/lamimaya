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
	
//ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function guardarProveedor($idProveedor, $nombre, $clave)
	{
		$r = new xajaxResponse();
		$proveedor = new ModeloProveedor();
		$isInsert = false;
		$regresar = false;
		
				
		if ($proveedor->existeField("nombre", $nombre, $idProveedor))
		{
			$r->script("app.errNombre = \"". mb_convert_encoding("Este nombre de proveedor ya está siendo utilizado. Debe especificar uno diferente.", 'UTF-8', 'ISO-8859-1') . "\"; ");
			$regresar = true;
		}
		
		if ($proveedor->existeField("clave", $clave, $idProveedor))
		{
			$r->script("app.errClave = \"" .mb_convert_encoding("Esta clave de proveedor ya está siendo utilizada. Debe especificar una diferente.", 'UTF-8', 'ISO-8859-1') ."\"; ");
			$regresar = true;
		}
		
		if ($regresar)
		{
			return $r;
		}
		
		if ($idProveedor == 0)
		{
			$isInsert = true;
			$proveedor->setDateUserCreating();
		}
		else
		{
			$proveedor->setIdProveedor($idProveedor);
			$proveedor->setDateUserUpdating();
		}
		
		$proveedor->setNombre($nombre); 
		$proveedor->setClave($clave);
		
		$proveedor->Guardar();
		
		if ($proveedor->getError())
		{
			$r->saError($proveedor->getStrError());
			return $r;
		}
				
		if ($isInsert)
		{
			$r->saSuccess("El Proveedor " .mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8') . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "proveedor",2);
		}
		else
		{
			$r->saSuccess("El Proveedor " .mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8') . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "proveedor",2);
		}
		
		
		
		return $r;
	}
	$xajax->registerFunction("guardarProveedor");
	
	function cargarProveedor($idProveedor)
	{
		$r = new xajaxResponse();
		
		$proveedor = new ModeloProveedor();
				
		if ($idProveedor <= 0)
		{
			$r->saError("No se han podido cargar los datos del material.");
			$r->redirect(URL_BASE . "material", 2);
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
		
		$r->script("
				    app.nombre = '" . $proveedor->getNombre() . "';
                    app.clave = '" . $proveedor->getClave() . "';                    
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarProveedor");

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
	