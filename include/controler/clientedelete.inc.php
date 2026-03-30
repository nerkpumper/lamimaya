<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cliente.inc.php";

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
	
	
	function cargarCliente($idCliente)
	{
		$r = new xajaxResponse();
		
		$cliente= new ModeloCliente();
				
		if ($idCliente <= 0)
		{
			$r->saError("No se han podido cargar los datos del Cliente.");
			$r->redirect(URL_BASE . "cliente", 2);
			return $r;
		}			
		
		$cliente->setIdCliente($idCliente);
		
		//verifica si el usuario fue cargado
		if ($cliente->getIdCliente() <= 0)
		{
			$r->saError("No se han podido cargar los datos del Cliente.");
			$r->redirect(URL_BASE . "cliente", 2);
			return $r;
		}
		
		
		$r->script("
				    app.nombre = '" . mb_convert_encoding($cliente->getNombre(, 'UTF-8', 'ISO-8859-1')) . "';
				    app.apellidos = '" . mb_convert_encoding($cliente->getApellidos(, 'UTF-8', 'ISO-8859-1')) . "';
				    app.empresa = '" . mb_convert_encoding($cliente->getEmpresa(, 'UTF-8', 'ISO-8859-1')) . "';
				    app.domicilio1 = '" . mb_convert_encoding($cliente->getDomicilio1(, 'UTF-8', 'ISO-8859-1')) . "';
				    app.domicilio2 = '" . mb_convert_encoding($cliente->getDomicilio2(, 'UTF-8', 'ISO-8859-1')) . "';
				    app.telefonos = '" . mb_convert_encoding($cliente->getTelefonos(, 'UTF-8', 'ISO-8859-1')) . "';
                    app.email = '" . mb_convert_encoding($cliente->getEmail(, 'UTF-8', 'ISO-8859-1')) . "';
				    app.rfc = '" . mb_convert_encoding($cliente->getRfc(, 'UTF-8', 'ISO-8859-1')) . "';                    
                    app.estatus = '" . $cliente->getEstado() . "';
                     
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarCliente");
	
	function eliminarCliente($idCliente)
	{
		$r = new xajaxResponse();
	
		$cliente = new ModeloCliente();
	
		if ($idCliente <= 0)
		{
			$r->saError("No se han podido cargar los datos del Cliente.");
			$r->redirect(URL_BASE . "cliente", 2);
			return $r;
		}			
		
		$cliente->setIdCliente($idCliente);
		
		//verifica si el usuario fue cargado
		if ($cliente->getIdCliente() <= 0)
		{
			$r->saError("No se han podido cargar los datos del Cliente.");
			$r->redirect(URL_BASE . "cliente", 2);
			return $r;
		}	
		
		$cliente->AplicaBaja();
		
		if (!$cliente->getError())
		{
			$r->saSuccess("El Cliente ha sido dado de Baja. Redireccionando.");
			$r->redirect(URL_BASE . "cliente", 2);			
		}
		else
		{
			$r->saError("Ocurri&oacute; un error al intentar dar de baja el Cliente. " . $cliente->getStrError());			
		}
		
		return $r;
	}
	$xajax->registerFunction("eliminarCliente");

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
		