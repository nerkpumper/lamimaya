<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.otroscargospedido.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetallecolocacion.inc.php";
	require_once FOLDER_MODEL. "model.sucursal.inc.php";
	
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
		
		
	function cargarPedido($idPedido)
	{
		$r = new xajaxResponse();
// 		$r->starDebug();
		$pedido = new ModeloPedido();
		
		$pedido->getPedido($idPedido);
		
		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se pudo cargar informaci�n del Pedido.");
			$r->script(" mdlExitWait(); ");
			return $r;			
		}
		
		$datosEstatus = "";
		
		$image = "";
		
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_capturado") . ".jpg" )) {
		    $image = "img/" . $pedido->getPedidoDato("id_usuario_capturado") . ".jpg";
		} else {
		    $image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.capturadoImage = '".$image."';";
		$datosEstatus .= "app.capturadoPor = '".trim($pedido->getPedidoDato("capturadoNombre")." ".$pedido->getPedidoDato("capturadoAPaterno")." ".$pedido->getPedidoDato("capturadoAMaterno"))."';";
		$datosEstatus .= "app.capturadoFecha = '".$pedido->getPedidoDato("fecha_capturado")."';";
		$datosEstatus .= "app.capturaObservacion = '".$pedido->getPedidoDato("observacionCaptura")."';";
		
		$image = "";
		
		if (file_exists ("img/" . $pedido->getPedidoDato("cteIdPromotor") . ".jpg" )) {
		    $image = "img/" . $pedido->getPedidoDato("cteIdPromotor") . ".jpg";
		} else {
		    $image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.promotorImage = '".$image."';";
		
		$datosEstatus .= "app.estado = '".$pedido->getPedidoDato("estado")."';";
		
		$datosCliente = "";
		
		$datosCliente .= "app.cteNombre = '".$pedido->getPedidoDato("cteNombre")."';";
		$datosCliente .= "app.cteApellidos = '".$pedido->getPedidoDato("cteApellidos")."';";
		$datosCliente .= "app.cteEmpresa = '".$pedido->getPedidoDato("cteEmpresa")."';";
		$datosCliente .= "app.cteDomicilio1 = '".$pedido->getPedidoDato("cteDomicilio1")."';";
		$datosCliente .= "app.cteDomicilio2 = '".$pedido->getPedidoDato("cteDomicilio2")."';";
		$datosCliente .= "app.cteNumero = '".$pedido->getPedidoDato("cteNumero")."';";
		$datosCliente .= "app.cteColonia = '".$pedido->getPedidoDato("cteColonia")."';";
		$datosCliente .= "app.cteCiudad = '".$pedido->getPedidoDato("cteCiudad")."';";
		$datosCliente .= "app.cteTelefonos = '".$pedido->getPedidoDato("cteTelefonos")."';";
		$datosCliente .= "app.cteEMail = '".$pedido->getPedidoDato("cteEMail")."';";
		$datosCliente .= "app.cteRFC = '".$pedido->getPedidoDato("cteRFC")."';";
		
		$datosCliente .= "app.promoNombre = '".$pedido->getPedidoDato("promoNombre")."';";
		$datosCliente .= "app.promoAPaterno = '".$pedido->getPedidoDato("promoAPaterno")."';";
		$datosCliente .= "app.promoAMaterno = '".$pedido->getPedidoDato("promoAMaterno")."';";
		
		
		$datosCliente .= "app.sucursalPreferente = '".$pedido->getPedidoDato("sucursalPreferente")."';";
		
		//falta poner una persona
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
		
		
		
// 		prodescripcion
// 		detpartida
// 		detcantidad
// 		detcantidadreal
// 		detdesarrollo
// 		detdobleces
// 		detpreciounitario
// 		dettipoprecio
// 		dettotal
// 		listo_para_producir
		
		$idProductoMoldura = 9;
		$idProductoMaquila = 10; 

		$productos = "";
		foreach ($pedido->__rsPedidoWDetalle as $row)
		{		    
		    $desc = "";
		    $auxCodigo = "";
		    $idmolproductolisa = 0;
		    
		    $moldura = " molidproductolisa: 0,
                             molcodigolisa: '',
	       	                 moldescripcionlisa: '',
		        
                    ";
		    
		    if ($row["detIdProducto"] == $idProductoMoldura || $row["detIdProducto"] == $idProductoMaquila)
		    {
		        //   		        $auxCodigo = "LLOSACERO RGA224NTERG37";
		        //   		        $auxCodigo = "12345678911234567892123456789312345";
		        if ($row["detIdProducto"] == $idProductoMoldura)
		        {
		            $auxCodigo = $row["proCodigo"] . " " . $row["rolloMolduraCodigo"];
		            
		            $mol = new ModeloViewproductos();
		            
		            $mollisa = $mol->getAll("idproducto, codigo, descauto",
		                "",
		                "idrollo = ".$row["idRolloBase"]." and idaplicacion = 2 and estado = 'ACTIVO' and idUnidad = 4",
		                "");
		            
// 		            $r->mostrarAviso($mol->getAllQUERY("idproducto, codigo, descauto",
// 		                "",
// 		                "idrollo = ".$row["idRolloBase"]." and idaplicacion = 2 and estado = 'ACTIVO' and idUnidad = 4",
// 		                ""));
		            
		           
		            
		            if (count($mollisa) > 0)
		            {
		                $idmolproductolisa = $mollisa[0]["idProducto"];
		                
		                $moldura = " molidproductolisa: ".$idmolproductolisa.",
                             molcodigolisa: '".$mollisa[0]["codigo"]."',
	       	                 moldescripcionlisa: '".$mollisa[0]["descauto"]."',
	       	                     
                    ";
		            }
		            
		        }
		        else
		        {
		            $auxCodigo = $row["proCodigo"] . " " . $row["molDescMaquila"];
		        }
		        
		        
		        
		        
		    }
		    else
		    {
		        //   		        $item["proCodigo"] = "LLOSACERO RGA224NTERG37";
		        $auxCodigo = $row["proCodigo"];
		        
		       
		        
		    }
		    
		    
            $desc = $row["proTipoProducto"] . " " . $row["proAplicacion"] . " " . $row["proMaterial"] . " " . "CAL " . $row["proCalibre"];
            
            if ($row["proShortUnidad"] != 'PZA' && $row["proShortUnidad"] != 'KG') {
                if ($row["proShortUnidad"] == 'ML') {
                    $desc .= " de " . $row["detCantidad"] . " " . $row["proShortUnidad"];
                } else {
                    $desc .= " de " . $row["detCantidad"] . " ML (" . $row["detCantidadReal"] . " " . $row["proShortUnidad"] . ")";
                }
            } else {
                if ($row["proShortUnidad"] == 'KG') {
                    $desc = "[KG] " . $desc;
                } else {
                    if ($row["proLongitud"] != "") {
                        $desc .= " de " . $row["proLongitud"] . " METRO LINEAL";
                    }
                }
            }
            
            // if ($item["detDesarrollo"] != "0" && $item["detDobleces"] != "0")
            // {
            // $desc .= " {Des: " .$item["detDesarrollo"]. " - Dbl: ".$item["detDobleces"]."}";
            // }
            
            if ($row["detIdProducto"] == $idProductoMoldura) {
                // $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
                $desc = "MOLDURA ";
                if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0") {
                    $desc .= " de " . $row["detCantidad"] . " " . $row["proShortUnidad"];
                    $desc .= " {Des: " . $row["detDesarrollo"] . " - Dbl: " . $row["detDobleces"] . "}";
                }
            }
            
            if ($row["detIdProducto"] == $idProductoMaquila) {
                // $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
                $desc = "MAQUILA DE MOLDURA ";
                if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0") {
                    $desc .= " de " . $row["detCantidad"] . " " . $row["proShortUnidad"];
                    $desc .= " {Des: " . $row["detDesarrollo"] . " - Dbl: " . $row["detDobleces"] . "}";
                }
            }
            
            if ($row["proIdTipoProducto"] == "4") {
                $desc = $row["proDescAuto"];
            }
            
            // $item["proMaterial"] . " de ".$item["detCantidad"] . " (" . $item["detCantidadReal"] . " ". $item["proUnidad"] . ")";
            
            $desc = mb_strtoupper($desc);
            $desc = str_replace("--NO APLICA--", "", $desc);
            $desc = str_replace("-- NO APLICA --", "", $desc);
            $desc = str_replace("CAL 0", "", $desc);
            $desc = str_replace("   ", " ", $desc);
            $desc = str_replace("  ", " ", $desc);
//             $desc = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');
            
            if ($row["curvar"] == 'SI') {
                $desc = $desc . " (Combar: " . $row["curvatura"] . ")";
            }
            
            
//             select s.idsucursal, s.nombre, ifnull(pdc.idpedidodetallecolocacion,0) pdcid, ifnull(pdc.cantidad,0) pdccantidad, ifnull(pdc.cantidadsurtida,0) pdccantidadsurtida, invs.idinventariosucursal, invs.existencia inventarioexistencia, invs.apartado inventarioapartado
//             from sucursal s
//             left join pedidodetallecolocacion pdc on s.idsucursal = pdc.idsucursal and pdc.idpedidodetalle = 2305
//             inner join inventariosucursal invs on s.idsucursal = invs.idsucursal and invs.idproducto =  191;

            
            $sesacade = "";
            if ($row["proIdUnidad"] == 4 || $row["detIdProducto"] == $idProductoMoldura || $row["detIdProducto"] == $idProductoMaquila || ($row["proIdUnidad"] == 1 && $row["proIdAplicacion"] == 6))
            {
                $sesacade ="INVENTARIO";
//                 $query = "
//                     select s.idsucursal, s.nombre, ifnull(pdc.idpedidodetallecolocacion,0) pdcid,
//                            ifnull(pdc.cantidad,0) pdccantidad, ifnull(pdc.cantidadsurtida,0) pdccantidadsurtida,
//                            invs.idinventariosucursal, invs.existencia inventarioexistencia, invs.apartado inventarioapartado
//                     from sucursal s
//                     left join pedidodetallecolocacion pdc on s.idsucursal = pdc.idsucursal and pdc.idpedidodetalle = ".$row["idPedidoDetalle"]."
//                     inner join inventariosucursal invs on s.idsucursal = invs.idsucursal and invs.idproducto =  ". ($idmolproductolisa > 0 ? $idmolproductolisa : $row["detIdProducto"]).";
//                 ";
                
                $query = "
                    select s.idsucursal, s.nombre, ifnull(pdc.idpedidodetallecolocacion,0) pdcid,
                           ifnull(pdc.cantidad,0) pdccantidad, ifnull(pdc.cantidadsurtida,0) pdccantidadsurtida,
                           invs.idinventariosucursal, invs.existencia inventarioexistencia, invs.apartado inventarioapartado
                    from sucursal s
                    left join pedidodetallecolocacion pdc on s.idsucursal = pdc.idsucursal and pdc.idpedidodetalle = ".$row["idPedidoDetalle"]."
					inner join inventariosucursal invs on s.idsucursal = invs.idsucursal and invs.idproducto =  ". ($idmolproductolisa > 0 ? $row["detIdProducto"] : $row["detIdProducto"])." 
					where s.visible = 'SI';
                ";
                
                
            }
            else 
            {
                $sesacade ="ROLLO";
                $query = "
                    select s.idsucursal, s.nombre, ifnull(pdc.idpedidodetallecolocacion,0) pdcid,
                           ifnull(pdc.cantidad,0) pdccantidad, ifnull(pdc.cantidadsurtida,0) pdccantidadsurtida,
                           0 idinventariosucursal, ifnull(getExistenciasRolloSucursal(s.idSucursal, ".$row["proIdRollo"]."),0) inventarioexistencia,
                           0 inventarioapartado   
                    from sucursal s
					left join pedidodetallecolocacion pdc on s.idsucursal = pdc.idsucursal and pdc.idpedidodetalle = ".$row["idPedidoDetalle"]."
					WHERE s.visible = 'SI'
                    
                ";
            }
            
            
            $invsucursal = $pedido->getDataSet($query);
            
            $pushInventarioSucursal = "[";
            foreach ($invsucursal as $invs)
            {               
                $pushInventarioSucursal .= "

                {

                    idsucursal: ".$invs["idsucursal"].",
                    nombre: '".$invs["nombre"]."',
                    pdcid: ".$invs["pdcid"].",
                    pdccantidad: ".$invs["pdccantidad"].",
                    pdccantidadsurtida: ".$invs["pdccantidadsurtida"].",
                    idinventariosucursal: ".$invs["idinventariosucursal"].",
                    inventarioexistencia: ".$invs["inventarioexistencia"].",
                    inventarioapartado: ".$invs["inventarioapartado"].",
                    kg: 0,
                    asignar: ".$invs["pdccantidad"]."

                },

                ";
            }
            
            $pushInventarioSucursal.="]";
            str_replace(",]", "]", $pushInventarioSucursal);
            
            /* INVENTARIO INFORMATIVO*/
            $pushInventarioInformativo = "[]";
            
            if ($row["detIdProducto"] == $idProductoMoldura || $row["detIdProducto"] == $idProductoMaquila)
            {
                if ($idmolproductolisa > 0)
                {
                    $query = "
                        select s.idsucursal, s.nombre, 
                               invs.idinventariosucursal, invs.existencia inventarioexistencia, invs.apartado inventarioapartado
                        from sucursal s                        
						inner join inventariosucursal invs on s.idsucursal = invs.idsucursal and invs.idproducto =  ". $idmolproductolisa." 
						WHERE s.visible = 'SI';
                    ";
                }
                else
                {
                    $query = "
                        select s.idsucursal, s.nombre, 
                               0 idinventariosucursal, ifnull(getExistenciasRolloSucursal(s.idSucursal, ".$row["idRolloBase"]."),0) inventarioexistencia,
                               0 inventarioapartado
						from sucursal s
						where s.visible = 'SI'                            
                    ";
                }
                
                $invsucursal = $pedido->getDataSet($query);
                
                $pushInventarioInformativo = "[";
                foreach ($invsucursal as $invs)
                {
                    $pushInventarioInformativo .= "                        
                            {
                                    
                                idsucursal: ".$invs["idsucursal"].",
                                nombre: '".$invs["nombre"]."',                                
                                idinventariosucursal: ".$invs["idinventariosucursal"].",
                                inventarioexistencia: ".$invs["inventarioexistencia"].",
                                inventarioapartado: ".$invs["inventarioapartado"]."
                                
                                    
                            },
                        
                          ";
                }
                
                $pushInventarioInformativo.="]";
                str_replace(",]", "]", $pushInventarioInformativo);
                
            }
            
            
            
            
            
            /* FIN INVENTARIO INFORMATIVO */
            
// 		    echo $moldura . "<br><br>";
			$productos .= "
					app.productos.push({
						idPedidoDetalle: '".$row["idPedidoDetalle"]."',
                        detIdProducto: ".$row["detIdProducto"].",
                        sesacade: '".$sesacade."',
                        codigo: '".$auxCodigo."',
						proDescripcion: '".$desc."', 
						detPartida: '".$row["detPartida"]."',
						detPartidaDespachada: '".$row["partidaDespachada"]."',
                        detPartidaAApartar: '".($row["detIdProducto"] == $idProductoMoldura ? $row["detPartida"] : $row["detPartida"])."',
                        molLaminasATomar: ".($row["detIdProducto"] == $idProductoMoldura ? $row["molLaminasATomar"] : $row["detPartida"]).",
                        molcodigorollo: '".$row["rolloMolduraCodigo"]."',                         							
						detCantidad: '".$row["detCantidad"]."',
						detCantidadReal: '".$row["detCantidadReal"]."',
						proShortUnidad: '".$row["proShortUnidad"]."',
                        proIdRollo: ".$row["proIdRollo"].",
                        proIdTipoProducto: ".$row["proIdTipoProducto"].",
						detDesarrollo: '".$row["detDesarrollo"]."',
						detDobleces: '".$row["detDobleces"]."',
						detPrecioUnitario: '".$row["detPrecioUnitario"]."',
						detTipoPrecio: '".$row["detTipoPrecio"]."',
						detTotal: '".$row["detTotal"]."',
						listo_para_producir: '".$row["listo_para_producir"]."',
						despachado: '".$row["despachado"]."',
						explotado: '".$row["explotado"]."',
						explotadook: '".$row["explotadook"]."',
                        pesokiloml: ".$row["pesoKiloML"].",
                        ".$moldura."
                        inventariosucursal: ".$pushInventarioSucursal .",
                        inventarioinformativo: ".$pushInventarioInformativo .",
                        errInventarioSucursal: '',
                        apartadoValido: false
                        
					});
					
					";		
			
		}
		
// 		Otros Servicios
        $otrosCargosPushes = "";
		$ocp = new ModeloOtroscargospedido();
		
		$lstOcp = $ocp->getAll("otroscargospedido.monto, oc.descripcion",
		    "inner join otrocargo as oc
                        on oc.idotrocargo = otroscargospedido.idotrocargo",
		    "idpedido = " . $idPedido);
		
		foreach ($lstOcp as $item)
		{
		    $otrosCargosPushes .= "

                        app.otrosServicios.push ({
                                descripcion: '".$item["descripcion"]."',
                                monto: ".$item["monto"]."        
                        });

                    ";
		    
		    
		}
		
// 		print_r($productos);
		
// 		Fin Otros Servicios
		
		$totales = "";
				
		$totales .= "app.subtotal = '".$pedido->getPedidoDato("subtotal")."';";
		$totales .= "app.descuento = '".$pedido->getPedidoDato("descuento")."';";
		$totales .= "app.total = '".$pedido->getPedidoDato("total")."';";
		
		$views = "";
		
// 		if (Permisos::userIsThisRol(Permisos::$rol_PRODUCTOR))
// 		{
// 			$views .= " app.mostrarEstatus = false; ";
// 			$views .= " app.verMontos = false; ";
// 			$views .= " app.verListoProducit = false; ";
// 			$views .= " app.verDespachado = false; ";
			
// 		}
// $r->mostrarAviso($productos); return $r;
		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosEstatus . $datosCliente . $datosConsignacion .
		    " app.productos.splice(0, app.productos.length); app.otrosServicios.splice(0, app.otrosServicios.length);"  . $productos  . $otrosCargosPushes . $totales . $views);
		$r->script(" app.setValue(); app.verificarBalanceoSucursales();  mdlExitWait(); ");
// 		$r->endDegug();
		return $r;
	}	
	$xajax->registerFunction("cargarPedido");
	
	
	function obtenerPedidosAutorizados()
	{
	    $r = new xajaxResponse();
	    
	    $pedido = new ModeloPedido();
	    
	    $lstPedidos = $pedido->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado,
				                       pedido.observacionAutoriza, pedido.explotado, pedido.explotadook,
				                       pedido.despachado, pedido.fecha_autorizado,				                       
				                       pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse,
				                       pedido.fecha_capturado, pedido.recogeentrega, pedido.fechaEntregaPorDefinir,
		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente
				          ",
	        " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
	        "pedido.estado = 'AUTORIZADO' AND pedido.colocado = 'NO' ", 
	        "pedido.fecha_autorizado asc");
	    
	    $pushes = "";
	    foreach ($lstPedidos as $row)
	    {
	        $pushes .= "
                    
                    app.pedidos.push({
                        idPedido: " . $row["idPedido"] . ",
                        nombreCliente: '". $row["nombreCliente"]."',
                        explotado: '". $row["explotado"] ."',
                        explotadook: '". $row["explotadook"] ."',
                        puedeProducirse: '". $row["puedeProducirse"] ."',
                        fechaEntregaPorDefinir: '".$row["fechaEntregaPorDefinir"]."'                           

                    });
            
    
                ";
	    }
	    
	    
	    $r->script(" app.pedidos.splice(0, app.pedidos.length); " . $pushes);
	    
	    return $r;
	}
	$xajax->registerFunction("obtenerPedidosAutorizados");
	
	function obtenerPedidosColocados()
	{
	    $r = new xajaxResponse();
	    
	    $pedido = new ModeloPedido();
	    
	    $lstPedidos = $pedido->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado,
				                       pedido.observacionAutoriza, pedido.explotado, pedido.explotadook,
				                       pedido.despachado, pedido.fecha_autorizado,
				                       pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse,
				                       pedido.fecha_capturado, pedido.recogeentrega, pedido.fechaEntregaPorDefinir,
		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, pedidoYaTieneSurtido(pedido.idPedido) pedidoYaTieneSurtido,
                            colocadoautomatico
				          ",
	        " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
	        "pedido.estado IN ('AUTORIZADO', 'PRODUCCION') AND pedido.colocado = 'SI' AND  pedidoYaTieneSurtido(pedido.idPedido) = 'NO' ",
	        "pedido.fecha_autorizado asc");
	    
	    $pushes = "";
	    foreach ($lstPedidos as $row)
	    {
	        if ($row["colocadoautomatico"] == 'NO')
	        {
	            
    	        $pushes .= "
    	            
                        app.pedidosColocados.push({
                            idPedido: " . $row["idPedido"] . ",
                            nombreCliente: '". $row["nombreCliente"]."',
                            estado: '".$row["estado"]."',
                            explotado: '". $row["explotado"] ."',
                            explotadook: '". $row["explotadook"] ."',
                            puedeProducirse: '". $row["puedeProducirse"] ."',
                            fechaEntregaPorDefinir: '".$row["fechaEntregaPorDefinir"]."'
                                
                        });
                                
                                
                    ";
	        }
	        else
	        {
	            
    	        $pushes .= "
    	            
                        app.pedidosColocadosAutomatico.push({
                            idPedido: " . $row["idPedido"] . ",
                            nombreCliente: '". $row["nombreCliente"]."',
                            estado: '".$row["estado"]."',
                            explotado: '". $row["explotado"] ."',
                            explotadook: '". $row["explotadook"] ."',
                            puedeProducirse: '". $row["puedeProducirse"] ."',
                            fechaEntregaPorDefinir: '".$row["fechaEntregaPorDefinir"]."'
                                
                        });
                                
                                
                    ";
	        }
	        
	    }
	    
	    
	    $r->script(" app.pedidosColocados.splice(0, app.pedidosColocados.length); app.pedidosColocadosAutomatico.splice(0, app.pedidosColocadosAutomatico.length); " . $pushes);
	    
	    return $r;
	}
	$xajax->registerFunction("obtenerPedidosColocados");
	
	function colocarPedido($idPedido, $detalle)
	{
	    $r = new xajaxResponse();
// 	    $r->starDebug();    
	    
	    foreach ($detalle as $item)
	    {
// 	        this.detalleAColocar.push({
// 	            idPedidoDetalle: this.productos[i].idPedidoDetalle;
// 	            idsucursal: this.productos[i].inventariosucursal[j].idsucursal;
// 	            pdcid: this.productos[i].inventariosucursal[j].pdcid;
// 	            pdccantidad: this.productos[i].inventariosucursal[j].pdccantidad;
// 	            asignar: this.productos[i].inventariosucursal[j].asignar;
// 	        });

	        $coloca = new ModeloPedidodetallecolocacion();
	        
	        if ($item["pdcid"] != 0)
	        {
	            $coloca->setIdPedidoDetalleColocacion($item["pdcid"]);      
	        }
	        
	        $coloca->setIdPedidoDetalle($item["idPedidoDetalle"]);
	        $coloca->setIdSucursal($item["idsucursal"]);
	        $coloca->setIdInventarioSucursal($item["idinventariosucursal"]);
	        
	        $coloca->setCantidad($item["asignar"]);
	        
	        $coloca->Guardar();
	        
	        
	    }
	    
	    $pedido = new ModeloPedido();
	    
	    $pedido->setIdPedido($idPedido);
	    
	    $pedido->setColocadoSI();
	    
	    $pedido->Guardar();
	    $msg = "";
	    
	    if ($pedido->getRecogeentrega() == "RECOGE" || $pedido->getRecogeentrega() == "ENTREGA"  || $pedido->getIdCliente() == 137)
	    {
    	    if (!$pedido->generarValesSalidaAutomatico($pedido->getIdPedido(), $msg))
    	    {
    	        $r->saError("Error al generar Vales de Salida. " . $msg);
//     	        return $r;
    	    }
			else
			{
				$r->mostrarAviso("Se han generado los Vales de Salida en automático para este Pedido.");
			}
	     	// $r->mostrarAviso("se generaron los vales automaticamente -> " . $msg);   
	    }
	    
//         $r->script(" app.cargarPedido(".$idPedido.");  ");
        $r->script(" app.cargarPedidosAutorizados(); app.idPedido = 0;  mdlExitWait();");        
        $r->saSuccess("La Asignación del Pedido a Sucursal(es) se ha realizado con éxito.");
	    
//         $r->endDegug();
	    return $r;	    
	}
	$xajax->registerFunction("colocarPedido");
	
	
	function reasignarPedido($idPedido, $isAutomatico = false)
	{
	    $r = new xajaxResponse();
	        
	    $pedido = new ModeloPedido();
	    
	    $lstPedidos = $pedido->getAll("pedido.idPedido, pedidoYaTieneSurtido(pedido.idPedido) pedidoYaTieneSurtido
				          ",
	        " ",
	        " pedido.idPedido =  " . $idPedido,
	        "");
	    
	    $yaTieneSurtido = "NO";
	    
	    foreach ($lstPedidos as $row)
	    {
	       if ($row["pedidoYaTieneSurtido"] == "SI")
	       {
	           $yaTieneSurtido = 'SI';
	       }
	    }
	    
	    if ($yaTieneSurtido == 'SI')
	    {
	        $r->saError("El Pedido ya tiene alguna parte Surtida, NO es posible Reasignar.");
	        return $r;
	    }
	    
	    $pedido->setIdPedido($idPedido);
	    
	    $pedido->setEstadoAUTORIZADO();
	    $pedido->setColocadoNO();
	    $pedido->setColocadoAutomaticoNO();
	    
	    $pedido->Guardar();
	    
	    
	    
	    //         $r->script(" app.cargarPedido(".$idPedido.");  ");
	    $r->script(" app.cargarPedidosAutorizados(); app.idPedidoReasignar = 0; app.cargarPedido(".$idPedido."); " . ( !$isAutomatico ? "$('#btnColocados').click(); " : ""));
	    $r->saInfo("Favor de volver a indicar la asignaci�n del Pedido a Sucursales");
	    
	    return $r;
	}
	$xajax->registerFunction("reasignarPedido");
	

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

	$sucursales = new ModeloSucursal();
	
	$lstSucursales = $sucursales->getAll("", "", " visible = 'SI' ");