<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.configuracion.inc.php";	
	
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

	function cargarConfiguracion()
	{
		$r = new xajaxResponse();
		
		$config = new ModeloConfiguracion();
		
		$config->setIdConfiguracion(1);
		
		//verifica si el rollo fue cargado
		if ($config->getIdConfiguracion() <= 0)
		{
			$r->saError("No se han podido cargar los datos de configuración de precios.");
			//$r->redirect(URL_BASE . "lamina", 2);
			return $r;
		}
						
		//$r->mostrarAviso($val);
		
		$r->script("			
					
				    app.configRangoM21Inicio = '" . $config->getRangoMetros1Inicio() . "';
					app.configRangoM21Fin = '" . $config->getRangoMetros1Fin() . "';
					app.configRangoM22Inicio = '" . $config->getRangoMetros2Inicio() . "';
					app.configRangoM22Fin = '" . $config->getRangoMetros2Fin() . "';
					app.configRangoM23Inicio = '" . $config->getRangoMetros3Inicio() . "';
					app.configRangoM23Fin = '" . $config->getRangoMetros3Fin() . "';
				
					app.configPesoCalibre20 = '" . $config->getPesoXCalibre20() . "';
					app.configPesoCalibre22 = '" . $config->getPesoXCalibre22() . "';
				    app.configPesoCalibre24 = '" . $config->getPesoXCalibre24() . "';
				    app.configPesoCalibre26 = '" . $config->getPesoXCalibre26() . "';
				    app.configPesoCalibre28 = '" . $config->getPesoXCalibre28() . "';
				    
                    app.configPedidoDescuento = '". $config->getPedidoDescuento() ."';
				
				
					app.configComision1Rango1 = '". $config->getComision1R1() ."';
				    app.configComision1Rango2 = '". $config->getComision1R2() ."';
				    app.configComision1Rango3 = '". $config->getComision1R3() ."';
				
					app.configComision2Rango1 = '". $config->getComision2R1() ."';
				    app.configComision2Rango2 = '". $config->getComision2R2() ."';
				    app.configComision2Rango3 = '". $config->getComision2R3() ."';
				
					app.configComision3Rango1 = '". $config->getComision3R1() ."';
				    app.configComision3Rango2 = '". $config->getComision3R2() ."';
				    app.configComision3Rango3 = '". $config->getComision3R3() ."';
				
				  ");
		
		
		return $r;
	}	
	$xajax->registerFunction("cargarConfiguracion");

	function guardarConfiguracion($rm1Inicio, $rm1Fin, $rm2Inicio, $rm2Fin, $rm3Inicio, $rm3Fin)
	{
		$r = new xajaxResponse();
	
		$config = new ModeloConfiguracion();
	
		$config->setIdConfiguracion(1);
	
		//verifica si el rollo fue cargado
		if ($config->getIdConfiguracion() <= 0)
		{
			$r->saError("No se han podido actualizar los datos de configuración de precios.");
			//$r->redirect(URL_BASE . "lamina", 2);
			return $r;
		}
	
		$config->setRangoMetros1Inicio($rm1Inicio);
		$config->setRangoMetros1Fin($rm1Fin);
		
		$config->setRangoMetros2Inicio($rm2Inicio);
		$config->setRangoMetros2Fin($rm2Fin);
		
		$config->setRangoMetros3Inicio($rm3Inicio);
		$config->setRangoMetros3Fin($rm3Fin);
		$config->setDateAndUser("modificacion");
		
		
		$config->Guardar();
		
		if ($config->getError())
		{
			$r->saError($config->getStrError());
		}		
		else
		{
			$r->script("
					
					app.editRangoM2 = false;
					swal(\"Rangos M2\", 
					     \"Los cambios han sido realizados correctamente.\", 
					     \"success\");
					 
					
					");
// 			$r->mostrarExito("Los Rangos han sido actualizados de manera exitosa.");
// 			$r->script("setTimeout(function(){ ocultarMensaje();}, 2000);");
		}
	
		return $r;
	}
	$xajax->registerFunction("guardarConfiguracion");
	
	function guardarConfiguracionPrecioXCalibre($precioCal20, $precioCal22, $precioCal24, $precioCal26, $precioCal28)
	{
		$r = new xajaxResponse();
	
		$config = new ModeloConfiguracion();
	
		$config->setIdConfiguracion(1);
	
		//verifica si el rollo fue cargado
		if ($config->getIdConfiguracion() <= 0)
		{
			$r->saError("No se han podido actualizar los datos de configuración de precios.");
			//$r->redirect(URL_BASE . "lamina", 2);
			return $r;
		}
	
		$config->setPesoXCalibre20($precioCal20);
		$config->setPesoXCalibre22($precioCal22);
		$config->setPesoXCalibre24($precioCal24);
		$config->setPesoXCalibre26($precioCal26);
		$config->setPesoXCalibre28($precioCal28);
		
		$config->setDateAndUser("modificacion");
	
	
		$config->Guardar();
	
		if ($config->getError())
		{
			$r->saError($config->getStrError());
		}
		else
		{
			$r->script("
			
					app.editPesoXCalibre = false;
					swal(\"Peso X ML Calibre\",
					     \"Los cambios han sido realizados correctamente.\",
					     \"success\");
	
			
					");
			// 			$r->mostrarExito("Los Rangos han sido actualizados de manera exitosa.");
			// 			$r->script("setTimeout(function(){ ocultarMensaje();}, 2000);");
		}
	
		return $r;
	}
	$xajax->registerFunction("guardarConfiguracionPrecioXCalibre");
	
	
	function guardarConfiguracionPedido($pedidoDescuento)
	{
		$r = new xajaxResponse();
	
		$config = new ModeloConfiguracion();
	
		$config->setIdConfiguracion(1);
	
		//verifica si el rollo fue cargado
		if ($config->getIdConfiguracion() <= 0)
		{
			$r->saError("No se han podido actualizar los datos de configuración de pedido.");
			//$r->redirect(URL_BASE . "lamina", 2);
			return $r;
		}
	
		$config->setPedidoDescuento($pedidoDescuento);		
	
		$config->setDateAndUser("modificacion");
	
	
		$config->Guardar();
	
		if ($config->getError())
		{
			$r->saError($config->getStrError());
		}
		else
		{
			$r->script("
		
					app.editPedido = false;
					swal(\"Datos de Pedido\",
					     \"Los cambios han sido realizados correctamente.\",
					     \"success\");
	
		
					");
			// 			$r->mostrarExito("Los Rangos han sido actualizados de manera exitosa.");
			// 			$r->script("setTimeout(function(){ ocultarMensaje();}, 2000);");
		}
	
		return $r;
	}
	$xajax->registerFunction("guardarConfiguracionPedido");
	
	function guardarConfiguracionComisiones($config1Rango1, $config1Rango2, $config1Rango3, $config2Rango1, $config2Rango2, $config2Rango3, $config3Rango1, $config3Rango2, $config3Rango3)
	{
		$r = new xajaxResponse();
	
		$config = new ModeloConfiguracion();
	
		$config->setIdConfiguracion(1);
	
		//verifica si el rollo fue cargado
		if ($config->getIdConfiguracion() <= 0)
		{
			$r->saError("No se han podido actualizar los datos de configuración de comisiones.");
			//$r->redirect(URL_BASE . "lamina", 2);
			return $r;
		}
	
		$config->setComision1R1($config1Rango1);
		$config->setComision1R2($config1Rango2);
		$config->setComision1R3($config1Rango3);
		
		$config->setComision2R1($config2Rango1);
		$config->setComision2R2($config2Rango2);
		$config->setComision2R3($config2Rango3);
		
		$config->setComision3R1($config3Rango1);
		$config->setComision3R2($config3Rango2);
		$config->setComision3R3($config3Rango3);
	
		$config->setDateAndUser("modificacion");
	
	
		$config->Guardar();
	
		if ($config->getError())
		{
			$r->saError($config->getStrError());
		}
		else
		{
			$r->script("
	
					app.editComisiones = false;
					swal(\"Datos de Comisiones\",
					     \"Los cambios han sido realizados correctamente.\",
					     \"success\");
	
	
					");
			// 			$r->mostrarExito("Los Rangos han sido actualizados de manera exitosa.");
			// 			$r->script("setTimeout(function(){ ocultarMensaje();}, 2000);");
		}
	
		return $r;
	}
	$xajax->registerFunction("guardarConfiguracionComisiones");

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
		