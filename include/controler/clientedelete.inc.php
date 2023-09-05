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
				    app.nombre = '" . utf8_encode($cliente->getNombre()) . "';
				    app.apellidos = '" . utf8_encode($cliente->getApellidos()) . "';
				    app.empresa = '" . utf8_encode($cliente->getEmpresa()) . "';
				    app.domicilio1 = '" . utf8_encode($cliente->getDomicilio1()) . "';
				    app.domicilio2 = '" . utf8_encode($cliente->getDomicilio2()) . "';
				    app.telefonos = '" . utf8_encode($cliente->getTelefonos()) . "';
                    app.email = '" . utf8_encode($cliente->getEmail()) . "';
				    app.rfc = '" . utf8_encode($cliente->getRfc()) . "';                    
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
		