<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
//  	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

	
	function saveCreditoCliente($idCliente, $credito, $index)
	{
		$r = new xajaxResponse();
	
		$cliente = new ModeloCliente();
		
		$cliente->setIdCliente($idCliente);
		
		if ($cliente->getIdCliente() <= 0)
		{
			$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
			return $r;			
		}
		else
		{
			$r->saSuccess("Si se cargo el cliente");
		}
		
		$cliente->setCredito($credito);
		
		$cliente->Guardar();
		
		if ($cliente->getError())
		{
			$r->saError("Ocurrió un error al intentar guardar los datos del Cliente. " . $cliente->getStrError());
			return $r;
		}
		else 
		{
			$r->saSuccess("El Crédito se a asignado al Cliente correctamente.");
			
			$cred = "-";
			$usado = "-";
			$disponible = "-";
						
			if (doubleval($cliente->getCredito()) > 0)
			{
				$cred = number_format($cliente->getCredito(),2);
				$usado = number_format($cliente->getUsado(),2);
				$disponible = number_format( doubleval($cliente->getCredito()) - doubleval($cliente->getUsado()),2);
			}		
			
			$r->script("
					
					app.clientesFiltradosPorNombre[".$index."].numericcredito = ".$cliente->getCredito().";
					app.clientesFiltradosPorNombre[".$index."].credito = '".$cred."';
					app.clientesFiltradosPorNombre[".$index."].usado = '".$usado."';
					app.clientesFiltradosPorNombre[".$index."].disponible = '".$disponible."';
					
					");
		}
	
	
		return $r;
	}
	$xajax->registerFunction("saveCreditoCliente");
	
	function saveCapacidadPagoCliente($idCliente, $capacidadPago, $index)
	{
	    $r = new xajaxResponse();
	    
	    $cliente = new ModeloCliente();
	    
	    $cliente->setIdCliente($idCliente);
	    
	    if ($cliente->getIdCliente() <= 0)
	    {
	        $r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
	        return $r;
	    }
	    else
	    {
	        $r->saSuccess("Si se cargo el cliente");
	    }
	    
	    $cliente->setCapacidadPago($capacidadPago);
	    
	    $cliente->Guardar();
	    
	    if ($cliente->getError())
	    {
	        $r->saError("Ocurrió un error al intentar guardar los datos del Cliente. " . $cliente->getStrError());
	        return $r;
	    }
	    else
	    {
	        $r->saSuccess("La Capacidad de Pago se a asignado al Cliente correctamente.");
	        
	        
	        
	        $r->script("
	            
					app.clientesFiltradosPorNombre[".$index."].numericcapacidadPago = ".$cliente->getCapacidadPago().";
					app.clientesFiltradosPorNombre[".$index."].capacidadPago = '".number_format($cliente->getCapacidadPago(),2)."';
					
	            
					");
	    }
	    
	    
	    return $r;
	}
	$xajax->registerFunction("saveCapacidadPagoCliente");
	
	function savePropiedadesCliente($idCliente, $rangoCliente, $index)
	{
	    $r = new xajaxResponse();
// 	    $r->starDebug();    
	    $cliente = new ModeloCliente();
	    
	    $cliente->setIdCliente($idCliente);
	    
	    if ($cliente->getIdCliente() <= 0)
	    {
	        $r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
	        return $r;
	    }
// 	    else
// 	    {
// 	        $r->saSuccess("Si se cargo el cliente");
// 	    }
	    
	    $cliente->setRangoCliente($rangoCliente);
	    
	    $cliente->Guardar();
	    
	    if ($cliente->getError())
	    {
	        $r->saError("Ocurrió un error al intentar guardar los datos del Cliente. " . $cliente->getStrError());
	        return $r;
	    }
	    else
	    {
	        $r->saSuccess("El tipo de Cliente ha sido guardado correctamente.");
	                
	        $r->script("
	            app.clientesFiltradosPorNombre[".$index."].rangoCliente = '".$rangoCliente."';
					
					");
	    }
	    
// 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("savePropiedadesCliente");
	

	function cargarCliente($idCliente)
	{
		$r = new xajaxResponse();
	
		$clientes = new ModeloCliente();
	
		$lst = $clientes->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.email, cliente.estado, cliente.rfc, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" cliente.idCliente = " . $idCliente);
	
		$strClientes = "";
		
		$idClienteFromDB = "0";
		
	
		foreach ($lst as $row)
		{
	
			$idClienteFromDB = $row["idCliente"];
			$strClientes .= "
		                     app.nombre = '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."';
		                     app.domicilio1 = '".mb_strtoupper($row["domicilio1"]). "';
		                     app.domicilio2 = '".mb_strtoupper($row["domicilio2"]). "';
		                     app.numero = '".mb_strtoupper($row["numero"]). "';
		                     app.colonia = '".mb_strtoupper($row["colonia"]). "';
		                     app.ciudad = '".mb_strtoupper($row["ciudad"]). "';
		                     app.telefonos = '".mb_strtoupper($row["telefonos"]). "';		                     
		                     app.email = '".($row["email"]). "';
		                     app.estado = '".$row["estado"]. "';
		                     app.rfc = '".mb_strtoupper($row["rfc"]). "';
		                     app.promotor = '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."';
					                                      ";
		}
		
		if ($strClientes == "")
		{
			$r->script("app.idCliente = 0; app.seleccionandoCliente = true;");
			$r->saError("No se ha podido obtener la información del Cliente. Verifique o seleccione algun otro.");
			return $r;
		}
		
		//ahora obtenemos totales en pedidos
		$query = "SELECT IFNULL(SUM(1), 0) as totalPedidos, IFNULL(SUM(IF(saldo = 0, 1, 0)),0)  as saldados, IFNULL(SUM(IF(saldo > 0, 1, 0)),0)  as porSaldar, IFNULL(SUM(IF(estado = 'CANCELADO', 1, 0)),0)  as cancelados
                    FROM pedido
                   WHERE idCliente = ".$idCliente;
		
				
		$datosPedidos = $clientes->getDataSet($query);
		
		if (count($datosPedidos) > 0)
		{
			if ($idClienteFromDB == "0")
			{
				$r->script("app.seleccionandoCliente = true;");
				$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
			}
			else
			{
				//set totales en pedidos
				$totalesPedidos = "
					app.pedidosTotal = ".$datosPedidos[0]["totalPedidos"].";
					app.pedidosSaldados = ".$datosPedidos[0]["saldados"].";
					app.pedidosSinSaldar = ".$datosPedidos[0]["porSaldar"].";
					app.pedidosCancelados = ".$datosPedidos[0]["cancelados"].";
			
					";
					
					
				
				//ahora obtenemos los totales de cargos y abonos
				$query = "SELECT getTotalCargosCliente (".$idCliente.") as totalCargos, getTotalAbonosCliente(".$idCliente.") as totalAbonos";
								
				$montos = $clientes->getDataSet($query);
				if (count($montos) > 0)
				{
					$cargosAbonos = "
								app.totalCargos = ".$montos[0]["totalCargos"].";
								app.totalAbonos = ".$montos[0]["totalAbonos"].";								
								app.cargarPedidosTodos();
								";
					
					
					$r->script($totalesPedidos.
							$strClientes . $cargosAbonos);
				}
				else
				{
					$r->script("app.seleccionandoCliente = true;");
					$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
				}
			}
			
			
			
		}
		else
		{
			$r->script("app.seleccionandoCliente = true;");
			$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
		}
		
		return $r;
	}
	$xajax->registerFunction("cargarCliente");
		
		
	function cargarClientes()
	{
		$r = new xajaxResponse();
// 		$r->starDebug();
		$cliente = new ModeloCliente();
		
		$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, 
cliente.telefonos, cliente.rangoCliente ", 
				"", 
				" cliente.idCliente > 1 ", 
				"");
		
		$pushes = "";
		
		foreach ($lst as $c)
		{
			$credito = "-";
			$usado = "-";
			$disponible = "-";
				
			
			$pushes .= "
					
						app.clientes.push({
							idCliente: ".$c["idCliente"].",
							nombre: '".mb_strtoupper($c["nombre"]). " " . mb_strtoupper($c["apellidos"])."',							
							empresa: '".mb_strtoupper($c["empresa"])."', 
							domicilio1: '".$c["domicilio1"]."', 
							domicilio2: '".$c["domicilio2"]."', 
							email: '".$c["email"]."', 
							telefonos: '".$c["telefonos"]."',
                            rangoCliente: '".$c["rangoCliente"]."'							
							 
						});
					
					";
		}
		
		$r->script("
					app.clientes.splice(0, app.clientes.length);
							
				" . $pushes);
// 		$r->endDegug();
		return $r;
	}	
	$xajax->registerFunction("cargarClientes");
	
	function cargarPedidos($idCliente, $quePedidos)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$query = "SELECT * 
				  FROM (
						SELECT idCliente, idPedido, fecha_capturado, getTotalCargosPedido(idPedido) as cargos, getTotalAbonosPedido(idPedido) as abonos, getSaldoPedido(idPedido) as saldo, estado, total, descuento
						FROM pedido) as datos
				  WHERE idCliente = " . $idCliente  . "  ORDER BY idPedido desc";
		
		if ($quePedidos == "SALDADOS")
		{	
			$query .= " AND saldo = 0";
		}
		else if ($quePedidos == "PORSALDAR")
		{
			$query .= " AND saldo > 0";
		}
		
		$lst = $pedido->getDataSet($query);
	
		$pushes = "";
	
		foreach ($lst as $ped)
		{
			$lblEstado = "";
			switch($ped["estado"])
			{
				case "CAPTURADO";
					$lblEstado .= "<p><span class=\'badge badge-warning\'>CAPTURADO</span></p>";									
					break;
				case "AUTORIZADO";
					$lblEstado .= "<p><span class=\'badge\'>AUTORIZA CxC</span></p>";					
					break;
				case "PRODUCCION";
					$lblEstado .= "<p><span class=\'badge badge-info\'>PRODUCCI&Oacute;N</span></p>";				
					break;
				case "TERMINADO";
					$lblEstado .= "<p><span class=\'badge badge-primary\'>TERMINADO</span></p>";					
					break;
				case "ENTREGADO";
					$lblEstado .= "<p><span class=\'badge badge-success\'>ENTREGADO</span></p>";
					break;
				case "CANCELADO";
					$lblEstado .= "<p><span class=\'badge badge-danger\'>CANCELADO</span></p>";
					break;
			}
			
			$pushes .= "
			
						app.pedidos.push({
							idCliente: ".$ped["idCliente"].", 
							idPedido: ".$ped["idPedido"].", 
							fecha_capturado: '".clsUtilerias::formatoFecha($ped["fecha_capturado"])."', 
							cargos: '".$ped["cargos"]."', 
							abonos: '".$ped["abonos"]."', 
							saldo: '".$ped["saldo"]."',	
							total: '".$ped["total"]."',
							descuento: '".$ped["descuento"]."',
							estado: '".$ped["estado"]."',
							lblEstado: '".$lblEstado."'
						});
			
					";
		}
	
		$r->script("
					app.pedidos.splice(0, app.pedidos.length);
				
				" . $pushes);
	
		return $r;
	}
	$xajax->registerFunction("cargarPedidos");
	
	
	
	

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
