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
	
//ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function guardarTipoProducto($idTipoProducto, $nombre, $clave)
	{
		$r = new xajaxResponse();
		$tipoProcucto = new ModeloTipoproducto();
		$isInsert = false;
		$regresar = false;
		
				
		if ($tipoProcucto->existeField("nombre", $nombre, $idTipoProducto))
		{
			$r->script("app.errNombre = \"". mb_convert_encoding("Este tipo de producto ya está siendo utilizado. Debe especificar uno diferente.", 'UTF-8', 'ISO-8859-1') . "\"; ");
			$regresar = true;
		}
		
		if ($tipoProcucto->existeField("clave", $clave, $idTipoProducto))
		{
			$r->script("app.errClave = \"" . mb_convert_encoding("Este tipo de producto ya está siendo utilizada. Debe especificar una diferente.", 'UTF-8', 'ISO-8859-1') . "\"; ");
			$regresar = true;
		}
		
		if ($regresar)
		{
			return $r;
		}
		
		if ($idTipoProducto == 0)
		{
			$isInsert = true;
			$tipoProcucto->setDateUserCreating();
		}
		else
		{
			$tipoProcucto->setIdTipoProducto($idTipoProducto);
			$tipoProcucto->setDateUserUpdating();
		}
		
		$tipoProcucto->setNombre($nombre); 
		$tipoProcucto->setClave($clave);
		
		$tipoProcucto->Guardar();
		
		if ($tipoProcucto->getError())
		{
			$r->saError($tipoProcucto->getStrError());
			return $r;
		}
				
		if ($isInsert)
		{
			$r->saSuccess("El Tipo Producto " .mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8') . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "tipoproducto",2);
		}
		else
		{
			$r->saSuccess("El Tipo Producto " . mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8') . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "tipoproducto",2);
		}
		
		
		
		return $r;
	}
	$xajax->registerFunction("guardarTipoProducto");
	
	function cargarTipoProducto($idTipoProducto)
	{
		$r = new xajaxResponse();
		
		$tipoProducto = new ModeloTipoproducto();
				
		if ($idTipoProducto <= 0)
		{
			$r->saError("No se han podido cargar los datos del tipo de producto.");
			$r->redirect(URL_BASE . "tipoproducto", 2);
			return $r;
		}			
		
		$tipoProducto->setIdTipoProducto($idTipoProducto);
		
		//verifica si el usuario fue cargado
		if ($tipoProducto->getIdTipoProducto() <= 0)
		{
			$r->saError("No se han podido cargar los datos del tipo de producto.");
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
	