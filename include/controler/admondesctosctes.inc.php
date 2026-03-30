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
	
//   	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function cargarClientes($filtroDescuento)
	{
		$r = new xajaxResponse();
		
		$cliente = new ModeloCliente();
		
		$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos, cliente.porDescuento", 
				"", 
				"idCliente > 1 " . ($filtroDescuento == "CONDESCTO" ? " AND porDescuento > 0 " : ($filtroDescuento == "SINDESCTO" ? " AND porDescuento = 0 " : "")), 
				"");
		
		$pushes = "";
		
		foreach ($lst as $c)
		{
			$pushes .= "
					
						app.clientes.push({
							idCliente: ".$c["idCliente"].",
							nombre: '".$c["nombre"]. " " . $c["apellidos"]."',							
							empresa: '".$c["empresa"]."', 
							domicilio1: '".$c["domicilio1"]."', 
							domicilio2: '".$c["domicilio2"]."', 
							email: '".$c["email"]."', 
							telefonos: '".$c["telefonos"]."',
							porDescuento: '".$c["porDescuento"]."'
						});
					
					";
		}
		
		$r->script("
					app.clientes.splice(0, app.clientes.length);
							
				" . $pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarClientes");
	
	
	function asignarDescuento($idCliente, $indexCliente, $descuentoCliente)
	{
		$r = new xajaxResponse();
	
		$cliente = new ModeloCliente();
	
		$cliente->setIdCliente($idCliente);
		
		if ($cliente->getIdCliente() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Cliente.");
			return $r;
		}
		
		$cliente->setPorDescuento($descuentoCliente);
		
		$cliente->Guardar();
		
		if (!$cliente->getError())
		{
// 			$r->saSuccess("chido");
			
// 			$r->mostrarAviso("todo ok"); return $r;
			$r->saSuccess("Se ha asignado el Porcentaje de Descuento al Cliente.");			
			$r->script("app.clientesFiltradosPorNombre[".$indexCliente."].porDescuento = '".$descuentoCliente."';");
		}
		else
		{$r->mostrarAviso("todo mal"); return $r;
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($cliente->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		
	
		return $r;
	}
	$xajax->registerFunction("asignarDescuento");

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
