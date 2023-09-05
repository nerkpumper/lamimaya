<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";

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

	
	function cargarProducto($idProducto)
	{
		$r = new xajaxResponse();
		
		$producto = new ModeloViewproductos();
				
		if ($idProducto <= 0)
		{
			$r->saError("No se han podido cargar los datos del producto.");
			$r->redirect(URL_BASE . "producto", 2);
			return $r;
		}			
		
		$producto->getView($idProducto);
		
		//verifica si el material fue cargado
		if ($producto->getIdProducto() <= 0)
		{
			$r->saError("No se han podido cargar los datos del producto.");
			$r->redirect(URL_BASE . "producto", 2);
			return $r;
		}		
		
		if ($producto->getEstado() == "ACTIVO")
		{
			$r->script("
			
				app.codigo = '".$producto->getCodigo()."';
				app.tipoProducto = '".$producto->getTipoProducto()."';
				app.unidad = '".$producto->getShortUnidad()."';
				app.aplicacion = '".$producto->getAplicacion()."';
				app.material = '".$producto->getMaterial()."';
				app.rollo =  '".$producto->getRolloCodigo()."';
				app.calibre = '".$producto->getCalibre()."';
				app.descripcion = '".$producto->getDescripcion()."';
				app.existencia = '".$producto->getExistencia()."';
				app.fullDescripcion = '".$producto->getFullDescripcionNoUnidad()."';
           
				  ");
		}
		else
		{
			$r->script("
			
				app.productoEliminado = true;
			
				  ");
			
		}
			

		
		
		return $r;
	}	
	$xajax->registerFunction("cargarProducto");
	
	function eliminarProducto($idProducto)
	{
		$r = new xajaxResponse();
	
		$producto = new ModeloProducto();
	
		if ($idProducto <= 0)
		{
			$r->saError("No se han podido cargar los datos del producto.");
			$r->redirect(URL_BASE . "producto", 2);
			return $r;
		}
	
		$producto->setIdProducto($idProducto);
	
		//verifica si el material fue cargado
		if ($producto->getIdProducto() <= 0)
		{
			$r->saError("No se han podido cargar los datos del producto.");
			$r->redirect(URL_BASE . "producto", 2);
			return $r;
		}
	
		$producto->AplicaBaja();
		
		if (!$producto->getError())
		{
			$r->saSuccess("El producto ha sido borrado. Redireccionando.");
			$r->redirect(URL_BASE . "producto", 2);
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar borrar el producto. " . $producto->getStrError());
		}
		
		return $r;
	}
	$xajax->registerFunction("eliminarProducto");
	
	
	
	
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
		