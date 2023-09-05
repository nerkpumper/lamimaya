<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cxcpromotor.inc.php";
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
// ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

	function prepararPedido($idPedido){
		$r = new xajaxResponse();
		
		$pedido = new ModeloPedido(); 
		
		if ($idPedido <= 0)
		{
			$r->saError("No se ha especificado un numero de Pedido.");			
			return $r;
		}		
		
		$datos = $pedido->getAll("pedido.idPedido, concat(c.nombre, ' ', c.apellidos) as nombreCliente, pedido.estado, pedido.autorizacxc ", 
				                 " inner join cliente as c
								   on c.idcliente = pedido.idcliente",
				                 " pedido.idpedido = " . $idPedido)[0];
		
		$r->script("
				
				app.nombreCliente = '".$datos["nombreCliente"]."';
				app.estado = '".$datos["estado"]."';
				app.autorizaCXC = '".$datos["autorizacxc"]."';
								
				");		
		
		return $r;
	}
	$xajax->registerFunction("prepararPedido");
	
	function cargarPedidoCreditos($idPedido){
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		if ($idPedido <= 0)
		{
			$r->saError("No se ha especificado un numero de Pedido.");
			return $r;
		}
	
		$datos = $pedido->getAll("pedido.idPedido, pedido.total, pedido.estado,
				                   c.credito as cteCredito, c.usado as cteUsado,
								  (c.credito - c.usado )as cteDisponible,
				                   u.credito as promoCredito, u.usado as promoUsado,
				                   (u.credito - u.usado) as promoDisponible,
				                   isPromotorBloqueadoXCredito(c.idUsuarioPromotor) promoBloqueado",
				" inner join cliente as c
								   on c.idcliente = pedido.idcliente
								   inner join usuario as u
								   on u.idUsuario = c.idUsuarioPromotor ",
				" pedido.idpedido = " . $idPedido)[0];
	
		$r->script("
	
				app.frmXCredito.idPedido = ".$datos["idPedido"].";
				app.frmXCredito.totalPedido = ".$datos["total"].";
	
	
				app.frmXCredito.cteCredito = ".$datos["cteCredito"].";
				app.frmXCredito.cteUsado = ".$datos["cteUsado"].";
				app.frmXCredito.cteDisponible = ".$datos["cteDisponible"].";
	
				app.frmXCredito.promoCredito = ".$datos["promoCredito"].";
				app.frmXCredito.promoUsado = ".$datos["promoUsado"].";
				app.frmXCredito.promoDisponible = ".$datos["promoDisponible"].";
				app.frmXCredito.promoBloquedado = '".$datos["promoBloqueado"]."';
	
				app.prepararFrmXCredito();
	
				");
	
		return $r;
	}
	$xajax->registerFunction("cargarPedidoCreditos");
	
	
	function autorizarXCreditoCliente($idPedido){
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		if ($idPedido <= 0)
		{
			$r->saError("No se ha especificado un numero de Pedido.");
			return $r;
		}
		
		$pedido->setIdPedido($idPedido);
		
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("Ocurri� un error al obtener la informaci�n del Pedido.");
			return $r;
		}
		
		$pedido->setEstadoAUTORIZADO();
		$pedido->setDateAndUser("autorizado");
		$pedido->setObservacionAutoriza("AUTORIZADO AUTOM�TICO POR CR�DITO DE CLIENTE");
		
		$pedido->Guardar();
		
		if ($pedido->getError())
		{
			
			$r->saError($pedido->getStrError());
		}
		else
		{
			$r->saSuccess("El Pedido ha sido Autorizado con exito.");
			$r->script("setTimeout(function(){ app.prepararPedido(); }, 500);");
		}
		
// 			$debug = ob_get_clean();
// 			$r->mostrarMsgs($debug);
		
		return $r;
	}
	$xajax->registerFunction("autorizarXCreditoCliente");
	
	
	function autorizarXCreditoPromotor($idPedido, $promoATomar){
		$r = new xajaxResponse();
	
		$blnDoCommit = true;
		$strErrores = "";
		$pedido = new ModeloPedido();
	
		if ($idPedido <= 0)
		{
			$r->saError("No se ha especificado un numero de Pedido.");
			return $r;
		}
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("Ocurri� un error al obtener la informaci�n del Pedido.");
			return $r;
		}
	
		$pedido->transaccionIniciar();
		$pedido->setEstadoAUTORIZADO();
		$pedido->setDateAndUser("autorizado");
		$pedido->setObservacionAutoriza("AUTORIZADO AUTOM�TICO CR�DITO DE CLIENTE/APOYO PROMOTOR");
		
		$pedido->setTotalpromotor($promoATomar);
		
		$pedido->Guardar();
	
		if ($pedido->getError())
		{
			$blnDoCommit = false;
			$strErrores .= $pedido->getStrError() . ". ";			
		}
		else
		{
			$cxcpromotor = new ModeloCxcpromotor();
			
			$cxcpromotor->setIdPedido($idPedido);
			$cxcpromotor->setIdCliente($pedido->getIdCliente());
			$cxcpromotor->setMovimientoCARGO();
			$cxcpromotor->setMonto($promoATomar);
			$cxcpromotor->setReferencia("APOYO PARA AUTORIZAR PEDIDO");
			$cxcpromotor->setDateAndUser("movimiento");
			
			$cxcpromotor->Guardar();
			
			if ($cxcpromotor->getError())
			{
				$blnDoCommit = false;
				$strErrores .= $cxcpromotor->getStrError() . ". ";
			}			
		}
		
		if ($blnDoCommit)
		{
			$pedido->transaccionCommit();
			$r->saSuccess("El Pedido ha sido Autorizado con exito.");
			$r->script("setTimeout(function(){ app.prepararPedido(); }, 500);");
		}
		else
		{
			$pedido->transaccionRollback();
			$r->saError($strErrores);
		}
	
		// 			$debug = ob_get_clean();
		// 			$r->mostrarMsgs($debug);
	
		return $r;
	}
	$xajax->registerFunction("autorizarXCreditoPromotor");
	
	
	
	function solicitarAuthPedidoCXC($idPedido){
		$r = new xajaxResponse();
	
		$blnDoCommit = true;
		$strErrores = "";
		$pedido = new ModeloPedido();
	
		if ($idPedido <= 0)
		{
			$r->saError("No se ha especificado un numero de Pedido.");
			return $r;
		}
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("Ocurri� un error al obtener la informaci�n del Pedido.");
			return $r;
		}
	
		$pedido->transaccionIniciar();
		$pedido->setAutorizacxcSI();
		
	
		$pedido->Guardar();
	
		if ($pedido->getError())
		{
			$blnDoCommit = false;
			$strErrores .= $pedido->getStrError() . ". ";
		}
			
		if ($blnDoCommit)
		{
			$pedido->transaccionCommit();
			$r->saSuccess("Se ha notificado a CxC su petici�n.");
			$r->script("setTimeout(function(){ app.prepararPedido(); }, 500);");
		}
		else
		{
			$pedido->transaccionRollback();
			$r->saError($strErrores);
		}
	
		// 			$debug = ob_get_clean();
		// 			$r->mostrarMsgs($debug);
	
		return $r;
	}
	$xajax->registerFunction("solicitarAuthPedidoCXC");
	
	function filtrarPedidos($filtro)
	{
		global $objSession;
		$r = new xajaxResponse();
// 		$objSession->getIdUsuario()
		
		$pedido = new ModeloPedido();
		
		$pushes = "";
		if ($filtro["noPedido"] == "")
		{
			$whereCliente = "";
			
// 			if ($filtro["idCliente"] != "0")
// 			{
// 				$whereCliente =" and pedido.idCliente = " . $filtro["idCliente"] . " ";
// 			}
			
			
			$lst = $pedido->getAll("pedido.idPedido, concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente, pedido.total, pedido.fecha_capturado ",
					               "inner join cliente 
									  on cliente.idCliente = pedido.idCliente",
					               "  pedido.estado = 'PRODUCCION' " . $whereCliente,
					               " idPedido");
			
			foreach ($lst as $item)
			{
				$pushes .= "
						  
						app.pedidos.push({
							idPedido: ".$item["idPedido"].",
						    nombreCliente: '".$item["nombrecliente"]."',
						    
						    fecha: '".$item["fecha_capturado"]."'
						});
						
						";
			}
			
			$r->script(" app.pedidos.splice(0, app.pedidos.length); " . $pushes); 
			
		}
		else 
		{		
			
			
			$lst = $pedido->getAll("pedido.idPedido, cliente.idUsuarioPromotor, pedido.estado, concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente, pedido.total, pedido.fecha_capturado ",
					"inner join cliente
									  on cliente.idCliente = pedido.idCliente",
					" pedido.idPedido = " . $filtro["noPedido"],
					" idPedido");
				
			$noExiste = true;
			
			foreach ($lst as $item)
			{
				$noExiste = false;
				
// 				if ($item["idUsuarioPromotor"] == $objSession->getIdUsuario())
// 				{
					if ($item["estado"] == "PRODUCCION")
					{
						$pushes .= "
						
						app.pedidos.push({
							idPedido: ".$item["idPedido"].",
						    nombreCliente: '".$item["nombrecliente"]."',
						    
						    fecha: '".$item["fecha_capturado"]."'
						});
						
						";
					}		
					else
					{
						$r->saInfo("El Pedido ". $item["idPedido"] . " tiene estatus ". $item["estado"] .". Para este proceso el estatus debe ser PRODUCCION.");
					}
// 				}
// 				else
// 				{
// 					$r->saError("El Pedido ". $item["idPedido"] . " no pertenere a alguno de sus Clientes.");
// 				}
				
				
			}
			
			if ($noExiste)
			{
				
				$r->saError("El Pedido ". $filtro["noPedido"] . " no ha sido encontrado.");
			}
				
			$r->script(" app.pedidos.splice(0, app.pedidos.length); " . $pushes);
			
		}
	
		return $r;
	}
	$xajax->registerFunction("filtrarPedidos");
	
		
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
	
	
// 	echo clsUtilerias::formatoFecha("2018-02-19");
	$cliente = new ModeloCliente();
	
	$lst = $cliente->getForSelect("idCliente", "concat(idCliente, ' - ' , nombre, ' ' ,apellidos)", "");
	
	$lstClientes = "";
	
	foreach ($lst as $row)	
	{
		$lstClientes .= "<option value='".$row["value"]."'>".$row["theoption"]."</option>";
	}
	