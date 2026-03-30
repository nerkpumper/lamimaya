<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cxcpromotor.inc.php";
	require_once FOLDER_MODEL. "model.valesalida.inc.php";
	
	
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

	function cargarDatosValeYPedido($idPedido, $idValeSalida)
	{
	    $r = new xajaxResponse();
	    // 		$r->starDebug();
	    $pedido = new ModeloPedido();
	    $vs = new ModeloValesalida();
	    
	    $pedido->getPedido($idPedido);
	    	    
	    if (count($pedido->__rsPedidoWDetalle) <= 0)
	    {
	        $r->saError("No se pudo cargar informaci�n del Pedido.");
	        $r->script(" mdlExitWait(); ");
	        return $r;
	    }
	    
	    $vs->setIdValeSalida($idValeSalida);
	    
	    if ($vs->getIdValeSalida() <= 0)
	    {
	        $r->saError("No se pudo cargar informaci�n del Vale de Salida.");
	        $r->script(" mdlExitWait(); ");
	        return $r;
	    }
	    
	    $datosConsignacion = "";
	    
	    $datosConsignacion .= "app.personaEntrega = '".$pedido->getPedidoDato("personaEntrega")."';";
	    $datosConsignacion .= "app.recogeentrega = '".$pedido->getPedidoDato("recogeentrega")."';";
	    $datosConsignacion .= "app.domicilioEntrega = '".$pedido->getPedidoDato("domicilioEntrega")."';";
	    $datosConsignacion .= "app.numeroEntrega = '".$pedido->getPedidoDato("numeroEntrega")."';";
	    $datosConsignacion .= "app.coloniaEntrega = '".$pedido->getPedidoDato("coloniaEntrega")."';";
	    $datosConsignacion .= "app.ciudadEntrega = '".$pedido->getPedidoDato("ciudadEntrega")."';";
	    
	    $datosConsignacion .= "app.tipoObra = '".$pedido->getPedidoDato("tipoObra")."';";
	    $datosConsignacion .= "app.fechaEntregaPorDefinir = '".$pedido->getPedidoDato("fechaEntregaPorDefinir")."';";
	    $fechaCompromiso = clsUtilerias::formatoFecha($pedido->getPedidoDato("fechaCompromiso"));
	    $fechaCompromiso = str_replace("00:00:00", "", $fechaCompromiso);
	    $datosConsignacion .= "app.fechaEntrega = '". $fechaCompromiso ."';";
	    $datosConsignacion .= "app.fechaAbierta = '".$pedido->getPedidoDato("fechaAbierta")."';";
	    
	    $datosValeSalida = "";
	    
	    $datosValeSalida .= "app.chkPedidoSaldado = '".$pedido->getPedidoDato("saldada")."';";
	    
	    $datosValeSalida .= "app.chkDireccionCorrecta = ".($vs->getChkDireccionCorrecta() == 'SI' ? 'true' : 'false').";";
	    $datosValeSalida .= "app.chkDiaCorrecto = ".($vs->getChkDiaCorrecto() == 'SI' ? 'true' : 'false').";";
	    $datosValeSalida .= "app.chkHorarioCorrecto = ".($vs->getChkHorarioCorrecto() == 'SI' ? 'true' : 'false').";";
	    $datosValeSalida .= "app.chkEquipoListo = ".($vs->getChkEquipoListo() == 'SI' ? 'true' : 'false').";";
	    $datosValeSalida .= "app.chkPersonaCorrecta = ".($vs->getChkPersonaCorrecta() == 'SI' ? 'true' : 'false').";";
	    $datosValeSalida .= "app.chkHayEspacio = ".($vs->getChkHayEspacio() == 'SI' ? 'true' : 'false').";";
	    
	    $datosValeSalida .= "app.chkImprimirPedidoNoSaldado = ".($vs->getChkImprimirPedidoNoSaldado() == 'SI' ? 'true' : 'false').";";
	    
	    
	    
	    $r->script($datosConsignacion . $datosValeSalida);
	    
	    // 		$r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("cargarDatosValeYPedido");

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
		$objSession->getIdUsuario();
		
		
		$pedido = new ModeloPedido();
		
		$pushes = "";
		if ($filtro["noPedido"] == "")
		{
			$whereCliente = "";
			
			if ($filtro["idCliente"] != "0")
			{
				$whereCliente =" and pedido.idCliente = " . $filtro["idCliente"] . " ";
			}
			
			
// 			$lst = $pedido->getAll("pedido.idPedido, concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente, pedido.total, pedido.fecha_capturado ",
// 					               "inner join cliente 
// 									  on cliente.idCliente = pedido.idCliente",
// 					               " cliente.idUsuarioPromotor = " . $objSession->getIdUsuario() . " AND pedido.estado = 'CAPTURADO' " . $whereCliente,
// 					               " idPedido");
			
			$lst = $pedido->getAll("pedido.idPedido, v.idValeSalida, v.observacion_aunno, v.generarvalesalida, 
                        concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente, 
                        getTotalPedidoByValeSalida(v.idValeSalida) totalValeSalida,
                        pedido.total, pedido.fecha_capturado, pedido.saldada, cliente.saldarpedidoparavalesalida  ",
			    "inner join valesalida v on v.idPedido = pedido.idPedido
                  inner join cliente  on cliente.idCliente = pedido.idCliente",
			    " pedido.estado IN ('PRODUCCION', 'TERMINADO') AND v.generarvalesalida <> 'SI' AND recogeentrega <> 'RECOGE' " . $whereCliente,
			    " pedido.idPedido");
			
// 			$r->mostrarAviso($pedido->getAllQUERY("pedido.idPedido,pedido.observacion_aunno, pedido.generarvalesalida, concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente, pedido.total, pedido.fecha_capturado, pedido.saldada, cliente.saldarpedidoparavalesalida ",
// 			    "inner join cliente
// 									  on cliente.idCliente = pedido.idCliente",
// 			    " pedido.estado IN ('PRODUCCION', 'TERMINADO') AND generarvalesalida <> 'SI' " . $whereCliente,
// 			    " idPedido"));
			
			foreach ($lst as $item)
			{
				$pushes .= "
						  
						app.pedidos.push({
							idPedido: ".$item["idPedido"].",
                            idValeSalida: ".$item["idValeSalida"].",
						    nombreCliente: '".$item["nombrecliente"]."',
						    total: '".$item["totalValeSalida"]."',
						    fecha: '".clsUtilerias::formatoFecha($item["fecha_capturado"])."',
                            generarVale: '".$item["generarvalesalida"]."',
                            observacionaunno: '".$item["observacion_aunno"]."',
                            saldada: '".$item["saldada"]."',
                            saldarpedidoparavalesalida: '".$item["saldarpedidoparavalesalida"]."'
						});
						
						";
			}
			
			$r->script(" app.pedidos.splice(0, app.pedidos.length); " . $pushes); 
			
		}
		else 
		{		
		    
			
			$lst = $pedido->getAll("pedido.idPedido, v.idValeSalida, v.observacion_aunno, v.generarvalesalida, 
                        cliente.idUsuarioPromotor, pedido.estado, concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente, 
                        getTotalPedidoByValeSalida(v.idValeSalida) totalValeSalida, pedido.fecha_capturado, pedido.saldada, cliente.saldarpedidoparavalesalida
",
			    "inner join valesalida v on v.idPedido = pedido.idPedido
                  inner join cliente  on cliente.idCliente = pedido.idCliente",
					" pedido.idPedido = " . $filtro["noPedido"],
					" pedido.idPedido");
			
// 			$r->mostrarAviso($pedido->getAllQUERY("pedido.idPedido, v.idValeSalida, v.observacion_aunno, v.generarvalesalida,
//                         getTotalPedidoByValeSalida(v.idValeSalida) totalValeSalida,
//                         concat(cliente.nombre, ' ', cliente.apellidos) as nombrecliente,
//                         pedido.total, pedido.fecha_capturado, pedido.saldada, cliente.saldarpedidoparavalesalida  ",
// 			    "inner join valesalida v on v.idPedido = pedido.idPedido
//                   inner join cliente  on cliente.idCliente = pedido.idCliente",
// 			    " pedido.idPedido = " . $filtro["noPedido"],
// 			    " pedido.idPedido"));
			
// 			return $r;
// 			$noExiste = true;
// 			$r->mostrarAviso("sfsdfsdfdsfsdfdasfsdafsdfsd"); return $r;
			foreach ($lst as $item)
			{
				$noExiste = false;

				if ($item["idUsuarioPromotor"] == $objSession->getIdUsuario() || ModeloUsuario::amIRoot() || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR))
				{
				    
				    if ($item["estado"] == "PRODUCCION" || $item["estado"] == "TERMINADO")
					{
					    if ($item["generarvalesalida"] != "SI")
					    {
					        
					        $pushes .= "
					            
        						app.pedidos.push({
        							idPedido: ".$item["idPedido"].",
                                    idValeSalida: ".$item["idValeSalida"].",
        						    nombreCliente: '".$item["nombrecliente"]."',
        						    total: '".$item["totalValeSalida"]."',
        						    fecha: '". clsUtilerias::formatoFecha($item["fecha_capturado"])."',
                                    generarVale: '".$item["generarvalesalida"]."',
                                    observacionaunno: '".$item["observacion_aunno"]."',
                                    saldada: '".$item["saldada"]."',
                                    saldarpedidoparavalesalida: '".$item["saldarpedidoparavalesalida"]."'          
        						});
                                        
        						";
					    }
// 					    else
// 					    {
// 					        $r->saInfo("El Pedido ". $item["idPedido"] . " YA tiene autorizado imprimir Vale de Salida.");
// 					    }
					    
						
					}		
					else
					{
						$r->saInfo("El Pedido ". $item["idPedido"] . " tiene estatus ". $item["estado"] .". Para este proceso el estatus debe ser CAPTURADO.");
					}
				}
				else
				{
					$r->saError("El Pedido ". $item["idPedido"] . " no pertenere a alguno de sus Clientes.");
				}
				
				
			}
			
			if ($noExiste)
			{
				
				$r->saError("El Pedido ". $filtro["noPedido"] . " no ha sido encontrado.");
			}
				
			$r->script(" app.yaSeFiltro = true; app.pedidos.splice(0, app.pedidos.length); " . $pushes);
			
		}
	
		return $r;
	}
	$xajax->registerFunction("filtrarPedidos");
	
	
	function pedidoSiValeSalida ($idValeSalida, $index, $pedidoPagado, $chkDireccionCorrecta, $chkDiaCorrecto, $chkHorarioCorrecto, $chkEquipoListo, $chkPersonaCorrecta, $chkHayEspacio, $chkImprimirPedidoNoSaldado)
	{	    
	    $r = new xajaxResponse();
	    
	    $vs = new ModeloValesalida();
	    
// 	    $r->mostrarAviso($index); return $r;
	    
	    $vs->setIdValeSalida($idValeSalida);
	    
	    
	    if ($vs->getIdValeSalida() <= 0)
	    {
	        $r->saError("No se ha podido obtener la informacion del Vale de Salida.");
	        return $r;
	    }
	    
	    $blnGeneraVale = false;
	    
	    if ($chkDireccionCorrecta)
	    {
	       $vs->setChkDireccionCorrectaSI();    
	    }
	    else
	    {
	        $vs->setChkDireccionCorrectaNO();
	    }
	    
	    if ($chkDiaCorrecto)
	    {
	       $vs->setChkDiaCorrectoSI();    
	    }
	    else
	    {
	        $vs->setChkDiaCorrectoNO();
	    }
	    
	    
	    if($chkHorarioCorrecto)
	    {
	       $vs->setChkHorarioCorrectoSI();    
	    }
	    else
	    {
	        $vs->setChkHorarioCorrectoNO();
	    }
	    
	    
	    if($chkEquipoListo)
	    {
	        $vs->setChkEquipoListoSI();
	    }
	    else
	    {
	        $vs->setChkEquipoListoNO();
	    }
	    
	    if( $chkPersonaCorrecta)
	    {
	        $vs->setChkPersonaCorrectaSI();
	    }
	    else
	    {
	        $vs->setChkPersonaCorrectaNO();
	    }
	        
	    if($chkHayEspacio)
	    {
	       $vs->setChkHayEspacioSI();    
	    }
	    else
	    {
	        $vs->setChkHayEspacioNO();
	    }
	    
	    if ($chkImprimirPedidoNoSaldado)
	    {
	       $vs->setChkImprimirPedidoNoSaldadoSI();    
	    }
	    else 
	    {
	        $vs->setChkImprimirPedidoNoSaldadoNO();
	    }
	     
	    if (($chkDireccionCorrecta && 
	        $chkDiaCorrecto &&
	        $chkHorarioCorrecto && 
	        $chkEquipoListo &&
	        $chkPersonaCorrecta &&
	        $chkHayEspacio && 
	        $pedidoPagado == 'SI') ||
	        $chkImprimirPedidoNoSaldado)
	    {
	        $vs->setGenerarValeSalidaSI();
	        $blnGeneraVale = true;
	    }
        
	    
        
//         $r->saSuccess("Se ha indicado que se permite el Generar Vale de Salida. El Pedido se quitar� de la lista."); return $r;
        $vs->Guardar();
        
        
//         $r->script("saSuccess('Se ha indicado que se permite el Generar Vale de Salida. El Pedido se quitar� de la lista.')");
        if (!$vs->getError())
	    {

	        if ($blnGeneraVale)
	        {
    	        $r->script("setTimeout(function(){app.pedidos.splice(".$index.", 1);}, 500);");
     	        
    	        $r->saSuccess("Se ha indicado que se permite el Imprimir el Vale de Salida. El Vale de Salida se quitar� de la lista.");
	            
	        }
	        else
	        {
	            $r->saInfo("Se han almacenado datos del Vale de Salida, pero no se ha marcado para Permitir su Impresi�n, no ha cumplico con los requisitos.");
	        }
	    }
	    else
	    {
	        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($vs->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
	    }
	    

	    
	    return $r;
	    
	    
	}
	$xajax->registerFunction("pedidoSiValeSalida");
	
	
	function setValeSalidaAunNo ($idValeSalida, $observacion, $index)
	{
	    $r = new xajaxResponse();
	    
	    $vs = new ModeloValesalida();
	    
	    $vs->setIdValeSalida($idValeSalida);
	    
	    if ($vs->getIdValeSalida() <= 0)
	    {
	        $r->saError("No se ha podido obtener la informacion del Vale de Salida.");
	        return $r;
	    }
	    
	    
	    
	    // 	    if ($pedido->getEstado() != "PRODUCCION" && $pedido->getEstado() != "PRODUCCION")
	        // 	    {
	        // 	        $r->saInfo("El Pedido no se puede Autorizar, dado su Estado actual. Verifique.");
	        // 	        return $r;
	        // 	    }
	    
	    $vs->setGenerarValeSalidaAUNNO();	    
	    $vs->setObservacion_aunno($observacion);
	    //         $r->saSuccess("Se ha indicado que se permite el Generar Vale de Salida. El Pedido se quitar� de la lista."); return $r;
	    $vs->Guardar();
	    
	    
	    //         $r->script("saSuccess('Se ha indicado que se permite el Generar Vale de Salida. El Pedido se quitar� de la lista.')");
	    if (!$vs->getError())
	    {
	        
	        $r->script("setTimeout(function(){app.pedidos[".$index."].generarVale = 'AUN NO'; app.pedidos[".$index."].observacionaunno = '".$observacion."';}, 500);");
	        
	        $r->saSuccess("Se ha indicado que A�N NO se permite el Imprimir Vale de Salida.");
	    }
	    else
	    {
	        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($vs->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
	    }
	    
	    
	    
	    return $r;
	    
	    
	}
	$xajax->registerFunction("setValeSalidaAunNo");
		
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
	