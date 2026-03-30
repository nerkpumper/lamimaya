<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.pedido.inc.php";
 	require_once FOLDER_MODEL. "model.cliente.inc.php";
// 	require_once FOLDER_MODEL. "model.registroproduccion.inc.php";
// 	require_once FOLDER_MODEL. "model.invzmovnorollo.inc.php";
// 	require_once FOLDER_MODEL. "model.invzmovrollo.inc.php";
	
// 	require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";
// 	require_once FOLDER_MODEL. "model.pesomt.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
// 	require_once FOLDER_MODEL. "model.valesalidadetalle.inc.php";

	require_once FOLDER_MODEL. "model.valesalida.inc.php";
	require_once FOLDER_MODEL. "model.valesalidapromotor.inc.php";
	require_once FOLDER_MODEL. "model.valesalidapromotordetalle.inc.php";
	
	require_once FOLDER_MODEL. "model.sucursal.inc.php";
	
	
	

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
	
	
	function saveConsignacion($idValeSalidaPromotor, $idValeSalida, $personaEntregaAux, $domicilioEntregaAux, $numeroEntregaAux, $coloniaEntregaAux, $ciudadEntregaAux, $horaEntregaAux, $fechaEntregaAux)
	{
	    global $objSession;
	    $r = new xajaxResponse();
	    
	    $vs = new ModeloValesalida();
	    	    
	    $vs->setIdValeSalida($idValeSalida);
	    
	    $personaEntrega = $vs->getPersonaEntrega();
	    $domicilioEntrega = $vs->getDomicilioEntrega();
	    $numeroEntrega = $vs->getNumeroEntrega();
	    $coloniaEntrega = $vs->getColoniaEntrega();
	    $ciudadEntrega = $vs->getCiudadEntrega();
	    $horaRecibe = $vs->getHoraRecibe();
	    $fechaCompromiso = $vs->getFechaCompromiso();
	    
	    $cambios = "";
	    
	    if ($personaEntrega != $personaEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Persona";
	    }
	    
	    if ($domicilioEntrega != $domicilioEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Domicilio";
	    }
	    
	    if ($numeroEntrega != $numeroEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Numero";
	    }
	    
	    if ($coloniaEntrega != $coloniaEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Colonia";
	    }
	    
	    if ($ciudadEntrega != $ciudadEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Persona";
	    }
	    
	    if ($horaRecibe != $horaEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Hora";
	    }
	    
	    if ($fechaCompromiso != $fechaEntregaAux)
	    {
	        $cambios .= ($cambios == "" ? "" : ", ") . "Fecha";
	    }
	    
	    
	    $vs->setPersonaEntrega($personaEntregaAux);
	    $vs->setDomicilioEntrega($domicilioEntregaAux);
	    $vs->setNumeroEntrega($numeroEntregaAux);
	    $vs->setColoniaEntrega($coloniaEntregaAux);
	    $vs->setCiudadEntrega($ciudadEntregaAux);
	    $vs->setHoraRecibe($horaEntregaAux);
	    $vs->setFechaCompromiso($fechaEntregaAux);
// 	    $r->mostrarAviso("Fecha Compromiso ".$fechaEntregaAux);
	    $vs->Guardar();
	    
	    if (!$vs->getError())
	    {	       
	        if ($cambios != "")
	        {
	            $usuario = $objSession->getNombre()." ".$objSession->getApellidoPaterno()." ".$objSession->getApellidoMaterno();
	            NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_NOTIFICACION , 15, "Cambio en Consignaci�n",  "El Usuario " . $usuario . " ha cambiado en el vale de salida ".$idValeSalida." los siguientes datos de la consignaci�n:\n".$cambios);
	        }
	        
	        $r->saSuccess("Los datos de consignaci�n han sido actualizados.");
	        $r->script(" app.seleccionarValeSalida(".$idValeSalidaPromotor."); ");
	    }
	    else
	    {
	        $r->saError($vs->getStrError());   
	    }
	    
	    
	    
	    return $r;	    
	}
	$xajax->registerFunction("saveConsignacion");
	
	function cargarPedido($idPedido)
	{
	    $r = new xajaxResponse();
	    
	    	    
	    $pedido = new ModeloPedido();
		$cliente = new ModeloCliente();
		$promotor = new ModeloUsuario();
		$vendedor = new ModeloUsuario();
	    
	    $pedido->setIdPedido($idPedido);
	    
	    if ($pedido->getIdPedido() <= 0)
	    {
	        $r->saError("Al Parecer el Pedido no pudo ser cargado, verifique que exista.");
	        $r->script(" app.seleccionarPedido = true;	");
	        return $r;
	    }
	    
		$cliente->setIdCliente($pedido->getIdCliente());
		$promotor->setIdUsuario($cliente->getIdUsuarioPromotor());
		$vendedor->setIdUsuario($pedido->getId_usuario_capturado());
	    
	    $sql = "select getTotalSaldosClientePedidosEntregados(".$pedido->getIdCliente().") saldoPedidosEntregados, getTotalSaldosCliente(".$pedido->getIdCliente().") saldototal, getSaldosMas30Dias (".$pedido->getIdCliente().") saldototalMas30Dias ";
	    
		$rs = $cliente->getDataSet($sql)[0];

	    $saldoTotalCliente = $rs["saldototal"];
		$saldoPedidosEntregados = $rs["saldoPedidosEntregados"];
		$saldoTotalClienteMas30Dias = $rs["saldototalMas30Dias"];
		$sePuedeSurtir = $pedido->verificarSiPedidoPuedeSurtirse($idPedido);

	    
// 	    if ($pedido->getIdPedido() < 5868)
// 	    {
// 	        $r->saInfo("Solo se pueden hacer Vales de Salida en esta pantalla apartir del Pedido 5868.");
// 	        $r->script(" app.seleccionarPedido = true;	");
// 	        return $r;
// 	    }
	    
	    $r->script("
                    app.pedidoEstado = '".$pedido->getEstado()."';
              	    app.pedidoRecogeEngrega = '".$pedido->getRecogeentrega()."';
               	    app.pedidoDespieceTerminado = '".$pedido->getDespieceTerminado()."';
                    app.pedidoColocado = '".$pedido->getColocado()."';

                    app.pedidoSubtotal = '".$pedido->getSubtotal()."';
	                app.pedidoOtrosCargos = '". $pedido->getOtrosCargos() ."';
	                app.pedidoTotal = '". $pedido->getTotal() ."';
	                app.pedidoSaldo = '". $pedido->getSaldo() ."';
                    app.pedidoSaldoTotal = '". $saldoTotalCliente ."';
					app.pedidoSaldoTotalMas30Dias = '". $saldoTotalClienteMas30Dias ."';
					app.pedidoSaldoEntregados = '".$saldoPedidosEntregados."'
					app.cteCredito = ".$cliente->getCredito().";
					app.cteCapacidadPago = ".$cliente->getCapacidadPago().";
					app.pedidoSurtiraCompleto = ".(count($sePuedeSurtir["NoSurtir"]) > 0 ? "false" : "true").";
					

					app.pedidoCliente = '". $cliente->getNombre() . " " . $cliente->getApellidos() ."';
					
					app.promoNombre = '".$promotor->getNombre()." ".$promotor->getApellidoMaterno(). " ".$promotor->getApellidoPaterno()."';
					app.vendeNombre = '".$vendedor->getNombre()." ".$vendedor->getApellidoMaterno(). " ".$vendedor->getApellidoPaterno()."';

                ");
	    
	    
	    $r->script("  setTimeout(function () { app.cargarValesSalida(); app.cargarMercanciaSinValeSalida(); }, 200);  "); 
	       
	    
// 	    $r->script(" app.rollosParaAnadir.splice (0, app.rollosParaAnadir.length); " . $pushes);
	    
	    return $r;
	}
	$xajax->registerFunction("cargarPedido");
	
	
	function cargarValesSalida($idPedido)
	{
	    $r = new xajaxResponse();
	    
	    // 		rollosParaAnadir
	    
	    $vsp = new ModeloValesalidapromotor();
	    
	    $lst = $vsp->getAll("idValeSalidaPromotor, idPedido, estado, fecha_creado, idValeSalida, valesalidapromotor.idSucursal, sucursal.nombre sucursal",
	        "inner join sucursal on valesalidapromotor.idsucursal = sucursal.idsucursal",
	        " idPedido =  ". $idPedido);
	    
	    $pushes = "";
	    foreach ($lst as $row)
	    {
	        $pushes .= "
                    app.valessalida.push ({
                        idValeSalidaPromotor: ".$row["idValeSalidaPromotor"].",
                        idPedido: ".$row["idPedido"].",
                        estado: '".$row["estado"]."',
                        fecha_creado: '".$row["fecha_creado"]."',
                        idValeSalida: ".$row["idValeSalida"].",                       
                        sucursal: '".$row["sucursal"]."'
                        
                    });
                    ";
	    }
	    
	    $r->script(" app.valessalida.splice (0, app.valessalida.length); " . $pushes);
	    
	    return $r;
	}
	$xajax->registerFunction("cargarValesSalida");
	
	function borrarValeSalida($idValeSalida)
	{
	    $r = new xajaxResponse();
	    
	    $vsp = new ModeloValesalidapromotor();
	    
	    $vsp->setIdValeSalidaPromotor($idValeSalida);
	    
	    $vsp->Borrar();
	    
	    if (!$vsp->getError())
	        {
	            $r->saSuccess("Vale de Salida deshecho.");
	            $r->script(" app.cargarDatosPedido(); ");
	        }
	    else
	    {
	        $r->saError($vsp->getStrError());
	        $r->script(" app.cargarDatosPedido(); ");
	    }
	    
	    
	  
	    return $r;
	}
	$xajax->registerFunction("borrarValeSalida");
	
	function cargarValeSalida($idValeSalidaPromotor)
	{
	    $r = new xajaxResponse();
// 	    	    $r->starDebug();
	    // 		rollosParaAnadir
	    
	    $pd = new ModeloPedidodetalle();
	    
	    
	    $sql = "select pd.idPedido, pd.idpedidodetalle, pd.idproducto detIdProducto,  vspd.cantidad partidaenvale, vsp.idValeSalida,
        vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto,
		vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
		vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial,
		vp.material as proMaterial,		
		vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
		vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion, vp.rollodescauto,
		vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
		vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
        pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces,
                             pd.molDescMaquila  ,
            vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,  sucursal.nombre sucursal, 
getTotalValeSalidaPromotor(vsp.idvalesalidapromotor) totalvalesalidapromotor
                from valesalidapromotor vsp				
                inner join valesalidapromotordetalle vspd on vsp.idvalesalidapromotor = vspd.idvalesalidapromotor
                inner join pedidodetalle pd on vspd.idpedidodetalle = pd.idpedidodetalle
                inner join viewproductos as vp on vp.idProducto = pd.idProducto
                LEFT JOIN viewrollos as vrmol ON vrmol.idRollo = pd.idRolloBase
                inner join sucursal on vsp.idsucursal = sucursal.idsucursal
                where vsp.idvalesalidapromotor = " . $idValeSalidaPromotor . " order by pd.renglon";
	    
// 	    echo $sql;
	    
	    $lst = $pd->getDataSet($sql);
	    
	    $idProductoMoldura = 386;
	    $idProductoMaquilaMoldura = 394;
	    
	    $idValeSalida = 0;
	    $idPedido = 0;
	    $sucursal = "";

		$totalSaldoCliente = 0;
	    
	    $pushes = "";
	    foreach ($lst as $row)
	    {
	        $idValeSalida = $row["idValeSalida"];
	        $idPedido = $row["idPedido"];
	        $sucursal = $row["sucursal"];
	        $totalValeSalida = $row["totalvalesalidapromotor"];
				        	        
	        $desc = "" ;// $row["detPartida"]." ";
	        //$this->putText(29,"1234567891 1234567892 1234567893 1234567894 1234567895 1234567896 1234567897 1234");
	        $desc .= $row["proCodigo"] . " " .
	   	        $row["proTipoProducto"] . " " .
	   	        $row["proAplicacion"] . " " .
	   	        $row["proMaterial"] ;
	   	        
	   	        if ($row["proShortUnidad"] != 'PZA' && $row["proShortUnidad"] != 'KG' )
	   	        {
	   	            if ($row["proShortUnidad"] == 'ML')
	   	            {
	   	                $desc .= " de ".$row["detCantidad"] . " " . $row["proShortUnidad"];
	   	            }
	   	            else
	   	            {
	   	                $desc .= " de ".$row["detCantidad"] . " " .  $row["proShortUnidad"] . " (" . $row["detCantidadReal"] . " ML)";
	   	            }
	   	            
	   	            
	   	        }
	   	        else
	   	        {
	   	            if ($row["proShortUnidad"] == 'KG' )
	   	            {
	   	                $desc = "[KG] " . $desc;
	   	            }
	   	            else
	   	            {
	   	                if ($row["proLongitud"] != "" )
	   	                {
	   	                    $desc .=" de ".$row["proLongitud"] ." METRO LINEAL";
	   	                }
	   	            }
	   	        }
	   	        
	   	        if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
	   	        {
	   	            $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
	   	        }
	   	        
	   	        
	   	        
	   	        //   			        $item["proMaterial"] . "   de ".$item["detCantidad"] . " (" . $item["detCantidadReal"] . " ". $item["proUnidad"] . ")";
	   	        
	   	        if ($row["detIdProducto"] == $idProductoMoldura)
	   	        {
	   	            // 					    $desc = $row["detPartida"]." MOLDURA ". $row["rolloMolduraDesc"];
	   	            $desc = " MOLDURA ". $row["rolloMolduraDesc"];
	   	            if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
	   	            {
	   	                $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
	   	            }
	   	        }
	   	        else
	   	        {
	   	            if ($row["detIdProducto"] == $idProductoMaquilaMoldura)
	   	            {
	   	                // 					        $desc = $row["detPartida"]." MAQUILA DE MOLDURA ". $row["rolloMolduraDesc"];
	   	                $desc = " MAQUILA DE MOLDURA ". $row["rolloMolduraDesc"];
	   	                if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
	   	                {
	   	                    $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
	   	                }
	   	            }
	   	            else
	   	            {
	   	                // 					        $desc = $row["detPartida"]." ". $row["proDescAuto"];
	   	                $desc =  $row["proDescAuto"];
	   	            }
	   	            
	   	        }
	   	        
	   	        
	   	        
	   	        $desc = mb_strtoupper($desc);
	   	        $desc = str_replace("--NO APLICA--", "", $desc);
	   	        
	   	        $pushes .= "
                    app.mercanciaEnVale.push ({
                        idpedidodetalle: ".$row["idpedidodetalle"].",
                        producto: '".$desc."',
                        idproducto: ".$row["detIdProducto"].",
                        partida: ".$row["detPartida"].",
                        partidaenvale: ".$row["partidaenvale"]."
                        
                            
                    });
                    ";
	    }
	    
// 	    $r->script("alert ('idpedido ".$idPedido."' );");
	    
	    $r->script(" app.sucursalValeSalidaSeleccionado = '".$sucursal."'; 
					 app.idValeSalidaSeleccionado = ".$idValeSalida."; 
				
                     app.mercanciaEnVale.splice (0, app.mercanciaEnVale.length); " . $pushes . " 
                     app.valeSalidaTotal = ".$totalValeSalida.";
					 
					 mdlExitWait();
					 
					 if(app.idValeSalidaSeleccionado > 0)
					{
						xajax_getPagoVSEntrega(app.idValeSalidaSeleccionado);
					}

					 
					 
					 ");
	    if ($idValeSalida > 0)
	    {
	        $r->script(" xajax_cargarDatosValeYPedido(".$idPedido.", ".$idValeSalida."); ");
	    }
// 	    	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("cargarValeSalida");
	
	function cargarMercanciaSinValeSalida($idPedido, $idSucursal)
	{
	    $r = new xajaxResponse();
// 	    $r->starDebug();
	    // 		rollosParaAnadir
	    
	    if ($idSucursal == 0)
	    {
	        $r->script(" app.mercanciaSinVale.splice (0, app.mercanciaSinVale.length); ");
	        return $r;	        
	    }
	    
	    $pd = new ModeloPedidodetalle();
	    
	    $sql = "select pd.idpedidodetalle, pd.idproducto detIdProducto, pd.partidaenvale,
        vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto,
		vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
		vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial,
		vp.material as proMaterial,		
		vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
		vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion, vp.rollodescauto,		
		vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
		vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado, 
        pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, 
                             pd.molDescMaquila  ,
vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
pdc.idpedidodetallecolocacion, pdc.idSucursal, pdc.cantidad cantidadcolocada, pdc.cantidadenvale cantidadenvale, s.nombre nombresucursal
                from pedidodetalle pd
                inner join viewproductos as vp on vp.idProducto = pd.idProducto 
LEFT JOIN viewrollos as vrmol
					       ON vrmol.idRollo = pd.idRolloBase
            INNER JOIN pedidodetallecolocacion pdc on pd.idpedidodetalle = pdc.idpedidodetalle
            INNER JOIN sucursal s on pdc.idsucursal = s.idsucursal
                where pd.idpedido = " . $idPedido . " and pdc.idsucursal = ". $idSucursal ." order by pd.renglon";
	    
	    	    
	    $lst = $pd->getDataSet($sql);
	    
	    $idProductoMoldura = 386;
	    $idProductoMaquilaMoldura = 394;
	    
	    $pushes = "";
	    foreach ($lst as $row)
	    {
	        $desc = "" ;// $row["detPartida"]." ";
	        //$this->putText(29,"1234567891 1234567892 1234567893 1234567894 1234567895 1234567896 1234567897 1234");
	        $desc .= $row["proCodigo"] . " " .
	   	        $row["proTipoProducto"] . " " .
	   	        $row["proAplicacion"] . " " .
	   	        $row["proMaterial"] ;
	   	        
	   	        if ($row["proShortUnidad"] != 'PZA' && $row["proShortUnidad"] != 'KG' )
	   	        {
	   	            if ($row["proShortUnidad"] == 'ML')
	   	            {
	   	                $desc .= " de ".$row["detCantidad"] . " " . $row["proShortUnidad"];
	   	            }
	   	            else
	   	            {
	   	                $desc .= " de ".$row["detCantidad"] . " " .  $row["proShortUnidad"] . " (" . $row["detCantidadReal"] . " ML)";
	   	            }
	   	            
	   	            
	   	        }
	   	        else
	   	        {
	   	            if ($row["proShortUnidad"] == 'KG' )
	   	            {
	   	                $desc = "[KG] " . $desc;
	   	            }
	   	            else
	   	            {
	   	                if ($row["proLongitud"] != "" )
	   	                {
	   	                    $desc .=" de ".$row["proLongitud"] ." METRO LINEAL";
	   	                }
	   	            }
	   	        }
	   	        
	   	        if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
	   	        {
	   	            $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
	   	        }
	   	        
	   	        
	   	        
	   	        //   			        $item["proMaterial"] . "   de ".$item["detCantidad"] . " (" . $item["detCantidadReal"] . " ". $item["proUnidad"] . ")";
	   	        
	   	        if ($row["detIdProducto"] == $idProductoMoldura)
	   	        {
	   	            // 					    $desc = $row["detPartida"]." MOLDURA ". $row["rolloMolduraDesc"];
	   	            $desc = " MOLDURA ". $row["rolloMolduraDesc"];
	   	            if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
	   	            {
	   	                $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
	   	            }
	   	        }
	   	        else
	   	        {
	   	            if ($row["detIdProducto"] == $idProductoMaquilaMoldura)
	   	            {
	   	                // 					        $desc = $row["detPartida"]." MAQUILA DE MOLDURA ". $row["rolloMolduraDesc"];
	   	                $desc = " MAQUILA DE MOLDURA ". $row["rolloMolduraDesc"];
	   	                if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
	   	                {
	   	                    $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
	   	                }
	   	            }
	   	            else
	   	            {
	   	                // 					        $desc = $row["detPartida"]." ". $row["proDescAuto"];
	   	                $desc =  $row["proDescAuto"];
	   	            }
	   	            
	   	        }
	   	        
	   	        
	   	        
	   	        $desc = mb_strtoupper($desc);
	   	        $desc = str_replace("--NO APLICA--", "", $desc);
	        
	   	        if ($row["cantidadcolocada"] > 0)
	   	        {
        	        $pushes .= "
                            app.mercanciaSinVale.push ({                
                                idpedidodetalle: ".$row["idpedidodetalle"].",
                                idpedidodetallecolocacion: ".$row["idpedidodetallecolocacion"].",
                                idsucursal: ".$row["idSucursal"].",
                                sucursal: '".$row["nombresucursal"]."',
                                producto: '".$desc."',
                                idproducto: ".$row["detIdProducto"].",
                                partida: ".$row["cantidadcolocada"].",
                                partidaenvale: ".$row["cantidadenvale"].",
                                partidaaagregar: 0
                                    
                            });
                            ";
	   	            
	   	        }
	   	        
	    }
	    
	    $r->script(" app.errCrearValeSalida = \"\"; app.mercanciaSinVale.splice (0, app.mercanciaSinVale.length); " . $pushes);
// 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("cargarMercanciaSinValeSalida");
			
	
	
	
	function cargarDatosPedido($idPedido, $idRolloSeleccionado, $idSucursal)
	{
	    $r = new xajaxResponse();
	    
	    // 		global $objSession;
	    
	    // 		$idSucursal = $objSession->getIdSucursal();
	    
	    
	    if ($idPedido <= 0)
	    {
	        $r->saError("No se ha especificado N�mero de Pedido");
	        return $r;
	    }
	    
	    $pedido = new ModeloPedido();
	    
	    $pedido->setIdPedido($idPedido);
	    
	    if ($pedido->getIdPedido() <= 0)
	    {
	        $r->script("app.pedidoMsgPedido = \"No se ha encontrado el Pedido solicitado\";");
	        return $r;
	    }
	    
	    if ($pedido->getEstado() != "PRODUCCION")
	    {
	        $r->script("app.pedidoMsgPedido = \"El Pedido no puede despacharse, su estado actual es: ".$pedido->getEstado()."\";");
	        return $r;
	    }
	    
	    if ($pedido->getDespachado() == "SI")
	    {
	        $r->script("app.pedidoMsgPedido = \"El Pedido ya ha sido Despachado en su totalidad\";");
	    }
	    
	    
	    $pedido->getPedidoDetalleParaDespacharSucursal($idPedido, $idSucursal);
	    
	    $pushes = "";
	    $noItems = 0;
	    $porSurtir = 0;
	    
	    foreach ($pedido->__rsPedidoWDetalle as $row)
	    {
	        
	        if ($row["proIdRollo"] == $idRolloSeleccionado)
	        {
	            
	            
	            $noItems++;
	        }
	        // 			$pushes .= "
	        // 					app.pedidoPedidoDetalle.push({
	        // 							idPedidoDetalle: ".$row["idPedidoDetalle"].",
	        // 							proCodigo: '".$row["proCodigo"]."',
	        // 							proDescripcion: '".$row["proDescripcion"]."',
	        // 							proIdRollo: ".$row["proIdRollo"].",
	        // 							shortUnidad: '".$row["shortUnidad"]."',
	        // 							partida: ".$row["partida"].",
	        // 							cantidad: ".$row["cantidad"].",
	        // 							cantidadReal: ".$row["cantidadReal"].",
	        // 							explotarUnidad: ".$row["explotarUnidad"].",
	        // 							partidaDespachada: ".$row["partidaDespachada"].",
	        // 							despachado: '".$row["despachado"]."'
	        
	        
	        // 					});
	        
	        // 					";
	        
// 	        $porSurtir = $row["colocaCantidad"] - $row["colocaCantidadSurtida"] ;
// 	        ($porSurtir > 0 ? "NO" : "SI")

// 	        partidaDespachada: ".$row["colocaCantidadSurtida"].",
	        
	        $pushes .= "
					app.pedidoPedidoDetalle.push({
							idPedidoDetalle: ".$row["idPedidoDetalle"].",
                            idProducto: ".$row["detIdProducto"].",
							proCodigo: '".$row["proCodigo"]."',
							proDescripcion: '".$row["proDescripcion"]."',
							proIdRollo: ".$row["proIdRollo"].",
							shortUnidad: '".$row["shortUnidad"]."',
							partida: ".$row["colocaCantidad"].",
							cantidad: ".$row["cantidad"].",
							cantidadReal: ".$row["cantidadReal"].",
                            totalamldespachar: ".$row["totalExplotado"].",
							explotarUnidad: ".$row["explotarUnidad"].",
							partidaDespachada: ".$row["mlDespachado"].",
							despachado: '".$row["despachado"]."',
                            isParcial: '".$row["isParcial"]."',
                            sucursalNombre: '".$row["sucursalNombre"]."',
                            idPedidoDetalleColocacion: ".$row["idPedidoDetalleColocacion"]."
                                
                                
					});
                                
					";
	        
	        // 			despachado: '".$row["despachado"]."',
	        
	        
	    }
	    
	    if ($noItems == 0)
	    {
	        $r->saInfo("El Pedido no cuenta con productos para despachar de este Rollo.");
	    }
	    // 		$r->mostrarMsgs($pushes);
	    $r->script("
	        
				
	        
				app.pedidoPedidoDetalle.splice(0, app.pedidoPedidoDetalle.length);
	        
				".$pushes."
	        
	        
				");
	    
	    
	    return $r;
	}
	$xajax->registerFunction("cargarDatosPedido");
	
	function generarValeSalida($idPedido, $items, $idSucursal)
	{
	    $r = new xajaxResponse();
	    
	    $idValeSalidaPromotor = 0;
	    $blncommit = true;
	    	    
	    $vp = new ModeloValesalidapromotor();
	    
	    $vp->transaccionIniciar();
	    
	    $vp->setIdPedido($idPedido);
	    $vp->setEstadoCREADO();
	    $vp->setDateAndUser("creado");
	    $vp->setIdSucursal($idSucursal);
	    
	    $vp->Guardar();
	    
	    if (!$vp->getError())
	    {
	        foreach ($items as $pd)
	        {
	            $vpd = new ModeloValesalidapromotordetalle();
	            
	            $vpd->setIdValeSalidaPromotor($vp->getIdValeSalidaPromotor());
	            
	            $vpd->setIdPedidoDetalle($pd["idpedidodetalle"]);
	            $vpd->setIdPedido($idPedido);
	            $vpd->setIdProducto($pd["idproducto"]);
	            $vpd->setCantidad($pd["cantidadparavale"]);
	            $vpd->setIdPedidoDetalleColocacion($pd["idpedidodetallecolocacion"]);
	            $vpd->setIdSucursalDespachado($idSucursal);
	            
	            $vpd->setDateAndUser("despacho");
	            
	            $vpd->Guardar();
	            
	            if ($vpd->getError())
	            {
	                $blncommit = false;
	                break;
	            }
	        }
	        
	        $idValeSalidaPromotor = $vp->getIdValeSalidaPromotor();
	        
	    }
	    else
	    {
	        $blncommit = false;
	    }
	    
	    
	    
	    if ($blncommit)
	    {
	        $vp->transaccionCommit();
	        $r->script(" mdlExitWait(); app.cargarDatosPedido(); ");
	        $r->saSuccess("El Vale de Salida ha sido Generado con �xito. Folio: " . $idValeSalidaPromotor);
	    }
	    else
	    {
	        $idValeSalidaPromotor = 0;
	        $vp->transaccionRollback();
	        $r->script(" mdlExitWait(); app.cargarDatosPedido(); ");
	        $r->saError("Ocurri� un error al intentar generar el Vale de Salida.");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("generarValeSalida");
	

	function generarUnSoloValeSalida($idPedido)
	{
	    $r = new xajaxResponse();
	    
	    
	    $pedido = new ModeloPedido();
	    
	    $vsp = $pedido->AllThisPedidoToValeSalida(904);
	    
	    if ($vsp > 0)
	    {
	        
	        $r->script(" mdlExitWait(); app.cargarDatosPedido(); ");
	        $r->saSuccess("El Vale de Salida ha sido Generado con �xito. Folio: " . $vsp);
	    }
	    else
	    {	        
	        $r->script(" mdlExitWait(); app.cargarDatosPedido(); ");
	        $r->saError("Ocurri� un error al intentar generar el Vale de Salida.");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("generarUnSoloValeSalida");
	
	function cargarDatosValeYPedido($idPedido, $idValeSalida)
	{
	    $r = new xajaxResponse();
	    
// 	    $r->mostrarAviso("cargarDatosValeYPedido " .$idPedido . "   ". $idValeSalida); return $r;
	    
	    
// 	    $r->starDebug();
	    
	    
	    $pedido = new ModeloPedido();
	    $vs = new ModeloValesalida();
	    
	    
	    $pedido->getPedido($idPedido);
	    
	    if (count($pedido->__rsPedidoWDetalle) <= 0)
	    {
	        $r->saError("No se pudo cargar informaci�n del Pedido.");
// 	        $r->script(" mdlExitWait(); ");
	        return $r;
	    }
	    
	    $vs->setIdValeSalida($idValeSalida);
// 	    $r->mostrarAviso("Select getTotalValeSalida(".$idValeSalida.") as totalvalesalida"); return $r;
	    $totalValeSalida = $vs->getDataSet("Select getTotalValeSalida(".$idValeSalida.") as totalvalesalida");
	    
	    if ($vs->getIdValeSalida() <= 0)
	    {
	        $r->saError("No se pudo cargar informaci�n del Vale de Salida.");
// 	        $r->script(" mdlExitWait(); ");
	        return $r;
	    }
	    
// 	    if (count($totalValeSalida) <= 0)
// 	    {
// 	        $r->saError("No se pudo cargar informaci�n del Vale de Salida.");
// 	        // 	        $r->script(" mdlExitWait(); ");
// 	        return $r;
// 	    }
	    
	    $datosConsignacion = "";
	    
// 	    $r->mostrarAviso("bien"); return $r;
	    
	    $datosConsignacion .= "app.estado = '".$pedido->getPedidoDato("estado")."';";
	    $datosConsignacion .= "app.personaEntrega = '". $vs->getPersonaEntrega()."';";
	    $datosConsignacion .= "app.recogeentrega = '".$pedido->getPedidoDato("recogeentrega")."';";
	    $datosConsignacion .= "app.domicilioEntrega = '".$vs->getDomicilioEntrega()."';";
	    $datosConsignacion .= "app.numeroEntrega = '".$vs->getNumeroEntrega()."';";
	    $datosConsignacion .= "app.coloniaEntrega = '".$vs->getColoniaEntrega()."';";
	    $datosConsignacion .= "app.ciudadEntrega = '".$vs->getCiudadEntrega()."';";
	    $datosConsignacion .= "app.horaEntrega = '".$vs->getHoraRecibe() ."';";
	    
	    $datosConsignacion .= "app.valeSalidaTotal = '".$totalValeSalida[0]["totalvalesalida"] ."';";
			    
	    
	    
	    
	    
	    
	    $datosConsignacion .= "app.tipoObra = '".$pedido->getPedidoDato("tipoObra")."';";
	    $datosConsignacion .= "app.fechaEntregaPorDefinir = '".$pedido->getPedidoDato("fechaEntregaPorDefinir")."';";
	    $fechaCompromiso = clsUtilerias::formatoFecha($vs->getFechaCompromiso());
	    $fechaCompromiso = str_replace(" 00:00:00", "", $fechaCompromiso);
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
	    
	    $datosValeSalida .= "app.aunno = '".$vs->getObservacion_aunno()."';";
	    
	    $datosValeSalida .= "app.generarValeSalida = '".$vs->getGenerarValeSalida()."';";
	    
	    $datosValeSalida .= "app.chkImprimirPedidoNoSaldado = ".($vs->getChkImprimirPedidoNoSaldado() == 'SI' ? 'true' : 'false').";";
	    
	    
	    
	    $r->script($datosConsignacion . $datosValeSalida);
	    
// 	    		$r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("cargarDatosValeYPedido");
	
	
	function permitirImprimirVale ($idValeSalida, $idValeSalidaPromotor, $pedidoPagado, $chkDireccionCorrecta, $chkDiaCorrecto, $chkHorarioCorrecto, $chkEquipoListo, $chkPersonaCorrecta, $chkHayEspacio, $chkImprimirPedidoNoSaldado, $chkRecibeDinero)
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

		if ($chkRecibeDinero)
		{
			$vs->setChkRecibeDineroSI();
		}
		else
		{
			$vs->setChkRecibeDineroNO();
		}
	    
	    if ($chkDireccionCorrecta &&
	        $chkDiaCorrecto &&
	        $chkHorarioCorrecto &&
	        $chkEquipoListo &&
	        $chkPersonaCorrecta &&
	        $chkHayEspacio 	        )
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
// 	            $r->script("setTimeout(function(){app.pedidos.splice(".$index.", 1);}, 500);");
	            $msgValePagado = ($chkImprimirPedidoNoSaldado ? " El Vale de Salida se imprimirá aun cuando el Pedido no está Saldado." : " El Vale de Salida se imprimirá hasta que el Pedido esté Saldado." );    
	            $r->saSuccess("Se ha indicado que se permite el Imprimir el Vale de Salida." . $msgValePagado);
	            $r->script(" app.seleccionarValeSalida(".$idValeSalidaPromotor."); ");
	        }
	        else
	        {
	            $r->saInfo("Se han almacenado datos del Vale de Salida, pero no se ha marcado para Permitir su Impresión, no ha cumplido con los requisitos.");
	        }
	    }
	    else
	    {
	        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($vs->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
	    }
	    
	    
	    
	    return $r;
	    
	    
	}
	$xajax->registerFunction("permitirImprimirVale");
	
	function confirmarValeSalida($idValeSalidaPromotor)
	{
	    $r = new xajaxResponse();
	    
// 	    $r->starDebug();
	    $vsp = new ModeloValesalidapromotor();
	    
	    $blnSuccess = $vsp->GenerarValeSalidaReal($idValeSalidaPromotor);
// 	    echo "bien bien"; $r->endDegug(); return $r;
	    if ($blnSuccess)
	    {
	      $r->script(" mdlExitWait(); ");
	      $r->script(" app.cargarValesSalida(); ");
	      $r->script(" app.seleccionarValeSalida(".$idValeSalidaPromotor."); ");
	    }
	    else
	    {
	        $r->script("mdlExitWait(); ");
	        $r->saError("No fue posible confirmar el Vale de Salida.");
	    }
	    
// 	    $r->endDegug();
	    
	    return $r;
	}
	$xajax->registerFunction("confirmarValeSalida");
	
	function setValeSalidaAunNo ($idValeSalida, $observacion)
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
            $r->script(" app.aunno = '".$observacion."'; ");
	        $r->saSuccess("Se ha indicado que AÚN NO se permite el Imprimir Vale de Salida.");
	    }
	    else
	    {
	        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($vs->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
	    }
	    
	    
	    
	    return $r;
	    
	    
	}
	$xajax->registerFunction("setValeSalidaAunNo");

	function pagoVSEntrega ($idValeSalida, $pagoVSEntrega, $recogeEntrega)
	{
	    $r = new xajaxResponse();
	    
	    $vs = new ModeloValesalida();
	    
	    $vs->setIdValeSalida($idValeSalida);
		
		$leyendaPagoVSEntrega = "Pago vs Entrega";

		if ($recogeEntrega == 'RECOGE')
		{
			$leyendaPagoVSEntrega = "Liberado por Promotor";
		}
	    
	    if ($vs->getIdValeSalida() <= 0)
	    {
	        $r->saError("No se ha podido obtener la informacion del Vale de Salida.");
	        return $r;
	    }
	    
		if ($pagoVSEntrega)
		{
			$vs->setPagoVSEntregaSI();
			PedidoTrackingManager::logInfo($vs->getIdPedido(), "Se ha marcado el Vale de Salida " . $vs->getIdValeSalida(). " como ".$leyendaPagoVSEntrega."", false);
		}   
		else
		{
			$vs->setPagoVSEntregaNO();
			PedidoTrackingManager::logInfo($vs->getIdPedido(), "Se ha desmarcado el Vale de Salida " . $vs->getIdValeSalida(). " como ".$leyendaPagoVSEntrega."", false);
		}
	    
	    $vs->Guardar();
	    
	    if (!$vs->getError())
	    {

			$r->script(" mdlExitWait(); app.chkPagoVSEntregaAux = " . ($pagoVSEntrega ? "true" : "false") . " ;");

			if ($pagoVSEntrega)
			{
				$r->script("setTimeout( function() { saSuccess(\"El Vale de Salida ha sido marcado como ".$leyendaPagoVSEntrega."\"); }, 150);");
			}
			else
			{
				$r->script("setTimeout( function() { saSuccess(\"El Vale de Salida ha sido desmarcado como ".$leyendaPagoVSEntrega."\"); }, 150);");
			}
	        
	    }
	    else
	    {
	        $r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($vs->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
	    }
	    
	    
	    
	    return $r;
	    
	    
	}
	$xajax->registerFunction("pagoVSEntrega");

	function getPagoVSEntrega ($idValeSalida)
	{
	    $r = new xajaxResponse();
	    
	    $vs = new ModeloValesalida();
	    
	    $vs->setIdValeSalida($idValeSalida);
	    
	    if ($vs->getIdValeSalida() <= 0)
	    {
	        $r->saError("No se ha podido obtener la informacion del Vale de Salida.");
	        return $r;
	    }
	    	    
		$r->script(" mdlExitWait(); 

					app.yaimpreso = '". $vs->getYaImpreso() ."';
					app.chkPagoVSEntrega = " . ($vs->getPagoVSEntrega() == "SI" ? "true" : "false") . " ;
					app.chkPagoVSEntregaAux = " . ($vs->getPagoVSEntrega() == "SI" ? "true" : "false") . " ;
					setTimeout(function(){app.loadingVS = false;}, 500);
					");
	        
	    return $r;
	    
	    
	}
	$xajax->registerFunction("getPagoVSEntrega");
	
	
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

	$suc = new ModeloSucursal();
	
	$lstSucursales = $suc->getForSelect("idSucursal", "nombre");
	
// 	print_r($lstSucursales);