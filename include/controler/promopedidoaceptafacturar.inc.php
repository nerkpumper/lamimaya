<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.notificacion.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";

	require_once FOLDER_MODEL. "model.usocfdi.inc.php";
	require_once FOLDER_MODEL. "model.regimenfiscal.inc.php";
	
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
		$strHTML .= "      <th data-hide='phone'>RFC</th>";
		$strHTML .= "      <th data-hide='phone'>Promotor</th>";
		$strHTML .= "      <th data-hide='phone'>Total</th>";
		$strHTML .= "      <th data-hide='phone'>Fecha</th>";
// 		<!-- 							<th data-hide='phone,tablet'>Date modified</th> -->
		$strHTML .= "      <th data-hide='phone'>Estatus</th>";
		$strHTML .= "      <th data-hide='phone'>Facturaci&oacute;n</th>";
		$strHTML .= "      <th data-hide='phone'>Factura(s)</th>";
		
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
		
		if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION)  )
		{
			$where .= " AND (c.idUsuarioPromotor = " . ModeloUsuario::getObjSession()->getIdUsuario() . " OR pedido.id_usuario_capturado = " . ModeloUsuario::getObjSession()->getIdUsuario() . ") " ;
		}
		
		if ($noPedido != "")
		{
			$where .= " AND pedido.idPedido = " . $noPedido;	
		}		
		else
		{
		    $where.=" AND pedido.solicitaFactura='SI' AND pedido.facturado='NO' ";
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
		
		//SOLO PEDIDOS PARA FACTURAR
// 		$where.=" AND pedido.solicitaFactura='SI' AND pedido.facturado='NO' ";
		
		
		if (substr($where, 0,4) == " AND")
		{
			$where = substr($where, 5);
		}
		
		$lstPedidos = $pedido->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, 
				                       pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, 
				                       pedido.solicitaFactura, pedido.facturado, pedido.factura,
				                       pedido.despachado, 
				                       pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida,
				                       pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, 
				                       pedido.fecha_capturado, pedido.recogeentrega,
		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, c.rfc, 
                           concat(u.nombre, ' ' ,u.apellidoPaterno, ' ', u.apellidoMaterno) as nombrePromotor", 
		                  " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
                            INNER JOIN usuario as u ON c.idUsuarioPromotor = u.idUsuario ",
				          $where, "idPedido desc");
		
// 		return $pedido->getAllQUERY("pedido.idPedido, pedido.total, pedido.estado, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_capturado, pedido.recogeentrega,
// 		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente", 
// 		                  " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
// 				          $where, "idPedido desc");
		
		$cambiaEstatusButton = "";
		
		foreach ($lstPedidos as $row)
		{
			$cambiaEstatusButton = "";
			
			$strHTML .= "    <tr>";
			$strHTML .= "      <td>" . $row["idPedido"] . "</td>";
			$strHTML .= "      <td>". $row["nombreCliente"]."</td>";
			$strHTML .= "      <td>". $row["rfc"]."</td>";
			$strHTML .= "      <td>". $row["nombrePromotor"]."</td>";
			
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
			
			
			$estatusFacturacion = "";
			$btnFactura = "";
			if ($row["solicitaFactura"] == "NO")
			{
				$estatusFacturacion = "<span class='badge badge-danger'>SIN FACTURAR</span>";
// 				$btnFactura = "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnSolicitarFactura(".$row["idPedido"].");'><i class='fa fa-gavel'></i> Soliciturar Factura</button>";
// 				$btnFactura = "&nbsp;<a class='btn btn-primary btn-xs' href='".URL_BASE."promopedidofacturar/".$row["idPedido"]."'><i class='fa fa-gavel'></i> Soliciturar Factura</a>";
// 				$estatusFacturacion = "<span class='badge badge-warning'>FACTURA EN PROCESO</span>";
				$btnFactura="&nbsp;<button type='button'  class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modalIndicaMotivoAutorizacion'  onclick=\"mostrar('".  $row["idPedido"]  . "')\" ><i class='fa fa-gavel'></i> Asignar Factura (Sin solicitud)</button>";
			}
			else 
			{
				if ($row["facturado"] == "NO")
				{
					$estatusFacturacion = "<span class='badge badge-warning'>FACTURA EN PROCESO</span>";
					$btnFactura="&nbsp;<button type='button'  class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modalIndicaMotivoAutorizacion'  onclick=\"mostrar('".  $row["idPedido"]  . "')\" ><i class='fa fa-gavel'></i> Asignar Factura </button>";
				}
				else
				{
					$estatusFacturacion = "<span class='badge badge-success'>FACTURADO</span>";
					$btnFactura="&nbsp;<button type='button'  class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modalIndicaMotivoAutorizacion'  onclick=\"mostrar('".  $row["idPedido"]  . "')\" ><i class='fa fa-pencil'></i> Editar Factura </button>";
				}
			}
			
			$strHTML .= "      </td>";
			
			
			$strHTML .= "<td>";
			$strHTML .= $estatusFacturacion;
			$strHTML .= "</td>";
			
			
			$strHTML .= "<td>";
			$strHTML .= $row["factura"];
			$strHTML .= "</td>";
			
			
			
			$strHTML .= "      <td class='text-left'>";
											
			$strHTML .= "<a class='btn btn-info btn-xs' href='pedidodetalleview/" .  $row["idPedido"]."' alt='Ver detalle' target='_blank'><span class='fa fa-eye'></span></a>";
			$strHTML .= $btnFactura;
			
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
		//$r->script("$('#openmodal').modal('show');");
		$r->assign("listadoPedidos", "innerHTML", obtenerTabla($noPedido, $estatus, $cliente));
		$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		$r->script("$('#openmodal').modal('hide');");
		
		return $r;
	}
	$xajax->registerFunction("llenarListado");
	
	function autorizarPedido($idPedido, $observacion)
	{
		$r = new xajaxResponse();
// 		$r->starDebug();

		global $objSession;
		
		
		$pedido = new ModeloPedido();
		$noti = new ModeloNotificacion();
		
		$pedido->setIdPedido($idPedido);
		$pedido->getPedido($idPedido);
		//$r->saInfo("entra");
		
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
		
		
		
		$idUsuario = $objSession->getIdUsuario();
		
		
		$noti->setIdProvoca($idUsuario);
		$noti->setIdPara($pedido->getPedidoDato("cteIdPromotor"));
		$noti->setTema("Asigna Factura");
		$noti->setContenido("Asigna la Factura del pedido No.".$idPedido);
		$noti->setLeidoNO();
		$noti->setBorrarNO();
		$noti->setDateUserCreating();
		
		//if ($pedido->getEstado() != "CAPTURADO")
		//{
		//	$r->saInfo("El Pedido no se puede Autorizar, dado su Estado actual. Verifique.");
		//	return $r;
		//}
		
		$pedido->setFactura($observacion);
		$pedido->setFacturadoSI();
		
		$pedido->setDateAndUser("factura");
		
		if ($pedido->getSolicitaFactura() == 'NO')
		{
		    $pedido->setDateAndUser("solicitafactura");
		    $pedido->setSolicitaFacturaSI();
		}
				
		$pedido->Guardar();
		
		if (!$pedido->getError())
		{
		    
		    $noti->Guardar();
		    if (!$noti->getError())
		    {
		        NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO, "Factura(s) a Pedido " . $pedido->getIdPedido(), "Haz asignado la(s) Factura(s) " . $observacion . " al Pedido ".$pedido->getIdPedido(), $pedido->getIdPedido(), "");
		        $pedido->NotificaFacturacionPedido($observacion);
		        
// 		        NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 21, "Pedido " . $pedido->getIdPedido() . " Facturado", "Se han asignado la(s) Factura(s) ".$observacion." para el Pedido ".$pedido->getIdPedido(), $pedido->getIdPedido(), "");
		        
		        
		        
		        $r->script("saSuccess('Se autoriza la Factura del pedido.')");
		        $r->assign("listadoPedidos", "innerHTML", obtenerTabla());
		        $r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		        
		        
// 		        $pedido->getPedidoDato("cteIdPromotor")
		        
		    }
		    else
		    {
		        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($noti->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
		    }		    
			
		}	
		else
		{  
		        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
		}
	
// 		$r->endDegug();
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
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("actualizarAutorizacionPedido");
	
	
	function cargarPedido($idPedido)
	{
	    $r = new xajaxResponse();
	    
	    $pedido = new ModeloPedido();
	    
	    $pedido->getPedido($idPedido);
	    
	    if (count($pedido->__rsPedidoWDetalle) <= 0)
	    {
	        $r->saError("No se pudo cargar información del Pedido.");
	        $r->script("app.seleccionarOtroPedido();");
	        return $r;
	    }

	    
	    $r->script(" app.facRazonSocial ='". $pedido->getPedidoDato("cteRazonSocial") ."';
                     app.facRFC = '".$pedido->getPedidoDato("cteRFC")."';	
                     app.facDomicilio = '".$pedido->getPedidoDato("cteDomicilioFiscal")."';
                     app.facCP = '".$pedido->getPedidoDato("cteCPFiscal")."';
                     app.facTelefono = '".$pedido->getPedidoDato("cteTelefonos")."';
                     app.facNumero = '".$pedido->getPedidoDato("cteNumeroFiscal")."';
                     app.facCiudad = '".$pedido->getPedidoDato("cteCiudadFiscal")."';
                     app.facColonia = '".$pedido->getPedidoDato("cteColoniaFiscal")."';
                     app.facTelefono = '".$pedido->getPedidoDato("cteTelefonos")."';
                     app.facCFDI = ".$pedido->getPedidoDato("cteUsoCfdi").";
					 app.facRegimenFiscal = ".$pedido->getPedidoDato("idRegimenFiscal").";
                    app.facTotal = ".$pedido->getPedidoDato("total").";
                     app.factura = '".$pedido->getPedidoDato("factura")."';
                     app.facEmail = '".$pedido->getPedidoDato("cteEMail")."';");
	    
					 

	    
	    return $r;
	}
	$xajax->registerFunction("cargarPedido");
	
		
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
	
	
	$uso = new ModeloUsocfdi();
	
	$lstUsoCFDI = $uso->getForSelect("idUsoCfdi", "concat(clave,' - ',descripcion)", "");

	$rf = new ModeloRegimenFiscal();
	$lstRegimenFiscal = $rf->getForSelect("idRegimenFiscal", "concat(codigo,' - ',descripcion)", "");