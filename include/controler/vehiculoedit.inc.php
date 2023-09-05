<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.vehiculo.inc.php";
	
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
		
	function guardarVehiculo($idVehiculo, $placa, $descripcion)
	{
		$r = new xajaxResponse();
		$vehiculo = new ModeloVehiculo();
		$isInsert = false;
		$regresar = false;
		
		
		
		if ($vehiculo->existeField("placas", $placa, $idVehiculo))
		{
			$r->script("app.errClave = \"". utf8_encode("Esta placa de vehiculo ya está siendo utilizada. Debe especificar una diferente.") ."\"; ");
			$regresar = true;
		}
		
		if ($regresar)
		{
			return $r;
		}
		
		if ($idVehiculo == 0)
		{
			$isInsert = true;
			$vehiculo->setDateUserCreating();
		}
		else
		{
			$vehiculo->setIdVehiculo($idVehiculo);
			$vehiculo->setDateUserUpdating();
		}
		
		$vehiculo->setPlacas($placa); 
		$vehiculo->setDescripcion($descripcion);
		
		$vehiculo->Guardar();
		
		if ($vehiculo->getError())
		{
			$r->saError($vehiculo->getStrError());
			return $r;
		}
				
		if ($isInsert)
		{
			$r->saSuccess("El Vehiculo " .$placa . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "vehiculo",2);
		}
		else
		{
			$r->saSuccess("El Material " .$placa . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "vehiculo",2);
		}
		
		
		
		return $r;
	}
	$xajax->registerFunction("guardarVehiculo");
	
	function cargarVehiculo($idVehiculo)
	{
		$r = new xajaxResponse();
		
		$vehiculo = new ModeloVehiculo();
		
		if ($idVehiculo <= 0)
		{
			$r->saError("No se han podido cargar los datos del vehiculo.");
			$r->redirect(URL_BASE . "vehiculo", 2);
			return $r;
		}			
		$vehiculo->setIdVehiculo($idVehiculo);
		
		//verifica si el usuario fue cargado
		if ($vehiculo->getIdVehiculo() <= 0)
		{
			$r->saError("No se han podido cargar los datos del vehiculo.");
			$r->redirect(URL_BASE . "vehiculo", 2);
			return $r;
		}
		
		
		$r->script("
				    app.placa = '" . $vehiculo->getPlacas() . "';
                    app.descripcion = '" . $vehiculo->getDescripcion() . "';                    
				  ");
		
		return $r;
	}	
	$xajax->registerFunction("cargarVehiculo");

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
	