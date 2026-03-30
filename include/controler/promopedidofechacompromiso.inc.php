<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	function obtenerTabla($noPedido = "", $estatus = "0", $cliente = "")
	{		
		
		$strHTML = "";
		
		$strHTML .= "<table class='footable table table-stripped toggle-arrow-tiny' data-page-size='50'>";
		$strHTML .= "  <thead>";
		$strHTML .= "    <tr>";		
		$strHTML .= "      <th>Pedido</th>";
		$strHTML .= "      <th data-hide='phone'>Cliente</th>";
		$strHTML .= "      <th data-hide='phone'>Total</th>";
		$strHTML .= "      <th data-hide='phone'>Fecha Captura</th>";
// 		<!-- 							<th data-hide='phone,tablet'>Date modified</th> -->
		$strHTML .= "      <th data-hide='phone'>Estatus</th>";
		$strHTML .= "      <th data-hide='phone'>Fecha Entrega</th>";
// 		$strHTML .= "      <th data-hide='phone'>Factura(s)</th>";
		
// 		if(Permisos::userIsThisRol(Permisos::$rol_CXC) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR))
// 		{
// 			$strHTML .= "      <th data-hide='phone'>Obs. Autorizaci&oacute;n</th>";
// 		}
		
		$strHTML .= "      <th class='text-left'>Acci&oacute;n</th>";	
		$strHTML .= "    </tr>";
		$strHTML .= "  </thead>";
		$strHTML .= "  <tbody>";
		
		$pedido = new ModeloPedido();
		
		$where = "";
		if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION)  )
		{
// 			$where .= " AND (c.idUsuarioPromotor = " . ModeloUsuario::getObjSession()->getIdUsuario() . " OR pedido.id_usuario_capturado = " . ModeloUsuario::getObjSession()->getIdUsuario() . ") " ;
			$where .= " AND (c.idUsuarioPromotor = " . ModeloUsuario::getObjSession()->getIdUsuario() . " ) " ;
		}
		
		if ($noPedido == "" && $estatus == "0" && $cliente == "")
		{
		    $where .= " AND pedido.fechaEntregaPorDefinir = 'SI' ";
		}
		
		if ($noPedido != "")
		{
			$where .= " AND pedido.idPedido = " . $noPedido;	
		}		
		
		if ($estatus != "0")
		{
			if ($estatus == "CAPTURADOAUTORIZADO")
			{
				$where .= " AND pedido.estado IN ('CAPTURADO','AUTORIZADO') ";
			}
			else
			{
				$where .= " AND pedido.estado = '".$estatus."'";
			}
			
		}
		else
		{
// 			if(Permisos::userIsThisRol(Permisos::$rol_CXC))
// 			{
// 				$where .= " AND pedido.estado IN ('CAPTURADO','AUTORIZADO') ";
// 			}
		}
		
		if ($cliente != "")
		{
			$where .= " AND UPPER(concat(c.nombre, ' ' ,c.apellidos)) LIKE '%".$cliente."%'";
		}
		
		
		
		
		
		if (substr($where, 0,4) == " AND")
		{
			$where = substr($where, 5);
		}
		
		$lstPedidos = $pedido->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado,
                                       pedido.recogeentrega,  
				                       pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, 
				                       pedido.solicitaFactura, pedido.facturado, pedido.factura, pedido.fechaEntregaPorDefinir,
                                       pedido.fechaCompromiso, 
				                       pedido.despachado, 
				                        
				                       pedido.fecha_capturado, pedido.recogeentrega,
		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente", 
		                  " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
				          $where, "idPedido desc limit 500");
		
// 		return $pedido->getAllQUERY("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado,
// 				                       pedido.observacionAutoriza, pedido.explotado, pedido.explotadook,
// 				                       pedido.solicitaFactura, pedido.facturado, pedido.factura,
// 				                       pedido.despachado,
// 				                       pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida,
// 				                       pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse,
// 				                       pedido.fecha_capturado, pedido.recogeentrega,
// 		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente",
// 		    " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
// 		    $where, "idPedido desc");
		
		$cambiaEstatusButton = "";
		
		foreach ($lstPedidos as $row)
		{
			$cambiaEstatusButton = "";
			
			$strHTML .= "    <tr>";
			$strHTML .= "      <td>" . $row["idPedido"] . "</td>";
			$strHTML .= "      <td>". $row["nombreCliente"]."</td>";
			$strHTML .= "      <td>$". number_format($row["total"], 2) ."</td>";
			$strHTML .= "      <td>" . clsUtilerias::formatoFecha(substr($row["fecha_capturado"], 0)) . "</td>";
			$strHTML .= "      <td>";
						
			switch ($row["estado"])
			{
				case "CAPTURADO";
					$strHTML .= "<p><span class='text-warning'>CAPTURADO</span></p>";
					
					break;
				case "AUTORIZADO";
					$strHTML .= "<p><span class=''>AUTORIZA CxC</span></p>";
					
					break;
				case "PRODUCCION";
					$strHTML .= "<p><span class='text-info'>PRODUCCI&Oacute;N</span></p>";
				
					break;
				case "TERMINADO";
					$strHTML .= "<p><span class='text-navy'>TERMINADO</span></p>";
					
					break;
				case "ENTREGADO";
					$strHTML .= "<p><span class='text-success'>ENTREGADO</span></p>";
					break;
				case "CANCELADO";
					$strHTML .= "<p><span class='text-danger'>CANCELADO</span></p>";
					break;
			}
			
			
			
			$btnSetFechaEntrega = "";
			
			if (($row["estado"] == "AUTORIZADO" || $row["estado"] == "CAPTURADO") && $row["fechaEntregaPorDefinir"] == "SI")
			{
			    $btnSetFechaEntrega = "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnSolicitarObservacionAutorizacion(".$row["idPedido"].");'><i class='fa fa-calendar'></i> Fecha de Entrega</button>";
			}
			
			
			
			$strHTML .= "      </td>";
			
			$strHTML .= "<td>";
			if ($row["fechaEntregaPorDefinir"] == 'SI')
			{
			    $strHTML .=  "<span class='badge badge-warning'>POR DEFINIR</span>";
			}	
			else
			{
			    if ($row["recogeentrega"] == "RECOGE")
			    {
			        $strHTML .=  "<span class='badge badge-info'>CLIENTE RECOGE</span>";
			    }
			    else
			    {
			        $strHTML .= clsUtilerias::formatoFecha($row["fechaCompromiso"]);
			    }
			    
			    
			}
			
			$strHTML .= "</td>";
			
			
// 			$strHTML .= "<td>";
// 			$strHTML .= $row["factura"];
// 			$strHTML .= "</td>";
			
			
			
			$strHTML .= "      <td class='text-left'>";
											
			$strHTML .= "<a class='btn btn-info btn-xs' href='pedidodetalleview/" .  $row["idPedido"]."' alt='Ver detalle' target='_blank'><span class='fa fa-eye'></span></a>";
			$strHTML .= $btnSetFechaEntrega;
			
			$strHTML .= "      </td>";
			$strHTML .= "    </tr>";
		}
		
		
		
		
		$strHTML .= "  </tbody>";
		$strHTML .= "  <tfoot>";
		$strHTML .= "    <tr>";
		$strHTML .= "      <td colspan='7'>";
		$strHTML .= "        <ul class='pagination pull-right'></ul>";
		$strHTML .= "      </td>";
		$strHTML .= "    </tr>";
		$strHTML .= "  </tfoot>";
		$strHTML .= "</table>";
		
		
		return $strHTML;
	}


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

	function preparePage(){
		$r = new xajaxResponse();
		
		
		if(Permisos::userIsThisRol(Permisos::$rol_CXC))
		{
			$r->script(" app.estatus = \"CAPTURADOAUTORIZADO\";");
		}
		
		
		return $r;
	}
	$xajax->registerFunction("preparePage");
		
	function llenarListado($noPedido = "", $estatus = "0", $cliente = "")
	{
		$r = new xajaxResponse();
		
// 		$r->mostrarAviso(obtenerTabla($noPedido, $estatus, $cliente)); return $r;
		
		$r->assign("listadoPedidos", "innerHTML", obtenerTabla($noPedido, $estatus, $cliente));
		$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		$r->script(" mdlExitWait(); ");
		//$r->script("$('#openmodal').modal('hide');");
		return $r;
	}
	$xajax->registerFunction("llenarListado");
	
	function autorizarPedido($idPedido, $fechaCompromiso)
	{
		$r = new xajaxResponse();
		
		$pedido = new ModeloPedido();
		
		$pedido->setIdPedido($idPedido);
		
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
		
		// if ($pedido->getRecogeentrega() == "RECOGE")
		// {
		// 	$r->saInfo("Al Pedido no se le puede poner Fecha Entrega, lo RECOGE el cliente.");
		// 	return $r;
		// }
		
		$pedido->setFechaCompromiso($fechaCompromiso);
		$pedido->setFechaEntregaPorDefinirNO();
		
		$pedido->Guardar();
		
		if (!$pedido->getError())
		{
			$r->script("saSuccess('Se ha colocado la Fecha de Entrega de manera correcta.')");
			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
			
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("autorizarPedido");
	
	function actualizarAutorizacionPedido($idPedido, $observacion)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
	
// 		if ($pedido->getEstado() != "CAPTURADO")
// 		{
// 			$r->saInfo("El Pedido no se puede Autorizar, dado su Estado actual. Verifique.");
// 			return $r;
// 		}
	
// 		$pedido->setEstadoAUTORIZADO();
// 		$pedido->setDateAndUser("autorizado");
		$pedido->setObservacionAutoriza($observacion);
	
		$pedido->Guardar();
	
		if (!$pedido->getError())
		{
			
			$r->saSuccess("Se ha cambiado la Observaci�n de Autorizaci�n de forma correcta.");
			
			$r->script(" $(\"#obsAutoriza".$idPedido."\").html(\"".$observacion."\"); ");
// 			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
// 			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("actualizarAutorizacionPedido");
	
	function producirPedido($idPedido)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
	
		if ($pedido->getEstado() != "AUTORIZADO")
		{
			$r->saInfo("El Pedido no puede cambiar a PRODUCCION, dado su Estado actual. Verifique.");
			return $r;
		}
		
		$pedido->transaccionIniciar();
	
		$pedido->setEstadoPRODUCCION();
		$pedido->setDateAndUser("produccion");
	
		$pedido->Guardar();
		
		$blnDoCommit = true;
		
// 		//Inicio sacar de inventario el detalle stock
		
// 		if (!$pedido->getError())
// 		{
// 			$pd = new ModeloPedidodetalle();
			
// 			//agregar validaci�n para despachar solo LISTOS PARA PRODUCIR
// 			$lstDetalle = $pd->getAll("idPedidoDetalle, idPedido, pedidodetalle.idProducto, partida, cantidad, cantidadReal, producto.producto_unidad_idUnidad as idUnidad",
// 					"inner join producto on producto.idProducto = pedidodetalle.idProducto",
// 					"idpedido = ".$idPedido." AND producto_unidad_idUnidad = 4",
// 					"");
			
// 			$blnDoCommit = true;
// 			$errores = "";
			
			
// 			foreach ($lstDetalle as $pedidodetalle)
// 			{
// 				// 			echo "<br><br>";
// 				// 			print_r($pedidodetalle);
			
// 				$inv = new ModeloInvzmov();
			
// 				$idPedidoDetalle = $pedidodetalle["idPedidoDetalle"];
			
// 				$inv->setIdProducto($pedidodetalle["idProducto"]);
// 				$inv->setDocumentoPEDIDO();
// 				$inv->setReferencia($idPedido);
// 				$inv->setMovimientoSALIDA();
// 				$inv->setSalidaDespachoSI();
// 				$inv->setCantidad($pedidodetalle["partida"]);
// 				$inv->setObservaciones("Despacho de pedido");
// 				$inv->setIdPedidoDetalle($idPedidoDetalle);
// 				$inv->setDateAndUser("movimiento");
			
// 				$inv->Guardar();
			
// 				if (!$inv->getError())
// 				{
// 					$pd = new ModeloPedidodetalle();
			
// 					$pd->setIdPedidoDetalle($idPedidoDetalle);
			
// 					if ($pd->getIdPedidoDetalle() <= 0)
// 					{
// 						$errores .= "No se pudo obtener el detalle del pedido.";
// 						$blnDoCommit = false;
// 					}
// 					else
// 					{
// 						if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
// 						{
// 							$pd->setDespachadoSI();
// 							$pd->setDateAndUser("despachado");
// 							// 						echo "<br><br>Despachado";
// 							$pd->Guardar();
			
// 							if ($pd->getError())
// 							{
// 								$blnDoCommit = false;
// 								$errores .= $pd->getStrError();
// 							}
// 						}
// 					}
			
// 				}
// 				else
// 				{
// 					$blnDoCommit = false;
// 				}
// 			}
// 		}
// 		else
// 		{
// 			$blnDoCommit = false;
// 		}
		
		
		
// 		//Fin sacar de inventario el detalle stock
		
		if ($blnDoCommit)
		{
			$pedido->transaccionCommit();
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$pedido->transaccionRollback();	
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("producirPedido");
	
	function terminarPedido($idPedido)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
	
		if ($pedido->getEstado() != "PRODUCCION")
		{
			$r->saInfo("El Pedido no puede cambiar a TERMINADO, dado su Estado actual. Verifique.");
			return $r;
		}
	
		$pedido->setEstadoTERMINADO();
		$pedido->setDateAndUser("terminado");
	
		$pedido->Guardar();
	
		if (!$pedido->getError())
		{
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("terminarPedido");
	
	function entregarPedido($idPedido)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
	
		if ($pedido->getEstado() != "TERMINADO")
		{
			$r->saInfo("El Pedido no puede cambiar a ENTREGADO, dado su Estado actual. Verifique.");
			return $r;
		}
	
		$pedido->setEstadoENTREGADO();
		$pedido->setDateAndUser("entregado");
	
		$pedido->Guardar();
	
		if (!$pedido->getError())
		{
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("entregarPedido");
	
	function terminarYEntregarPedido($idPedido)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$pedido->setIdPedido($idPedido);
	
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
	
		if ($pedido->getEstado() != "PRODUCCION")
		{
			$r->saInfo("El Pedido no puede cambiar a TERMINADO, dado su Estado actual. Verifique.");
			return $r;
		}
	
		
		$pedido->setDateAndUser("terminado");
		$pedido->setDateAndUser("entregado");
		$pedido->setEstadoENTREGADO();
	
		$pedido->Guardar();
	
		if (!$pedido->getError())
		{
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("terminarYEntregarPedido");
	
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

	$listaEstatus = "";
	
	if(Permisos::userIsThisRol(Permisos::$rol_CXC))
	{
		$listaEstatus .= "<option value='CAPTURADOAUTORIZADO'>CAPTURADO Y AUTORIZADO</option>";	
	}
	
	$listaEstatus .= "<option value='CAPTURADO'>CAPTURADO</option>";
	$listaEstatus .= "<option value='AUTORIZADO'>AUTORIZADO</option>";
	$listaEstatus .= "<option value='PRODUCCION'>PRODUCCION</option>";
	$listaEstatus .= "<option value='TERMINADO'>TERMINADO</option>";
	$listaEstatus .= "<option value='ENTREGADO'>ENTREGADO</option>";
	$listaEstatus .= "<option value='CANCELADO'>CANCELADO</option>";