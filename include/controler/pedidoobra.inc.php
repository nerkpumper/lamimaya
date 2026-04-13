<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
	require_once FOLDER_MODEL. "model.registroproduccion.inc.php";
	require_once FOLDER_MODEL. "model.invzmovnorollo.inc.php";
	require_once FOLDER_MODEL. "model.invzmovrollo.inc.php";
	
	require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";
	require_once FOLDER_MODEL. "model.pesomt.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.valesalidadetalle.inc.php";
	
	
	

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
	
	function cargarNoRolloParaObra($idPedido)
	{
		$r = new xajaxResponse();
	
// 		rollosParaAnadir

		$rem = new ModeloRemisionrollo();
		
		$lst = $rem->getAll("idremisionrollo, remision, noRollo, kilos, existencia, almacen", 
		                    "",
		                    " estado <> 'BAJA' and almacen <> 'OBRA' AND estado <> 'TERMINADO'
                              and remisionrollo_rollo_idrollo in (select idRolloBase from pedidodetalle where idpedido = ".$idPedido.") limit 100 ");
		
		$pushes = "";
		foreach ($lst as $row)
		{
		      $pushes .= "                    
                    app.rollosParaAnadir.push ({
                        idRemisionRollo: '".$row["idremisionrollo"]."',
                        remision: '".$row["remision"]."', 
                        noRollo: '".$row["noRollo"]."',
                        kilos: ".$row["kilos"].",
                        existencia: ".$row["existencia"].",
                        almacen: '".$row["almacen"]."'                        
                    });
                    ";     
		}
		
		$r->script(" app.rollosParaAnadir.splice (0, app.rollosParaAnadir.length); " . $pushes);
	
		return $r;
	}
	$xajax->registerFunction("cargarNoRolloParaObra");
	
	function cargarPedido($idPedido)
	{
	    $r = new xajaxResponse();
	    
	    $pedido = new ModeloPedido();
	    
	    $pedido->setIdPedido($idPedido);
	    
	    if ($pedido->getIdPedido() <= 0)
	    {
	        $r->saError("Ocurrió un error al intentar obtener los datos del Pedido.");
	        return;
	    }
	    
	    $r->script("
                    app.pedidoEstado = '".$pedido->getEstado()."';
              	    app.pedidoRecogeEngrega = '".$pedido->getRecogeentrega()."';
               	    app.pedidoDespieceTerminado = '".$pedido->getDespieceTerminado()."';

                ");
	    
	    if ($pedido->getEstado() == 'PRODUCCION' && $pedido->getRecogeentrega() == 'OBRA' && $pedido->getDespieceTerminado() == 'NO')
	    {
	       $r->script("  setTimeout(function () { app.cargarRollosEnObra();}, 200);  "); 
	    }
	    
	    
	    
// 	    $r->script(" app.rollosParaAnadir.splice (0, app.rollosParaAnadir.length); " . $pushes);
	    
	    return $r;
	}
	$xajax->registerFunction("cargarPedido");
	
	
	function cargarRollosEnObra($idPedido)
	{
	    $r = new xajaxResponse();
	    
	    // 		rollosParaAnadir
	    
	    $rem = new ModeloRemisionrollo();
	    
	    $lst = $rem->getAll("idremisionrollo, remision, noRollo, kilos, existencia, almacen, almacenOriginal",
	        "",
	        " estado <> 'BAJA' and almacen = 'OBRA' and idPedidoObra =  ".$idPedido);
	    
	    $pushes = "";
	    foreach ($lst as $row)
	    {
	        $pushes .= "
                    app.rollosObra.push ({
                        idRemisionRollo: '".$row["idremisionrollo"]."',
                        noRollo: '".$row["noRollo"]."',
                        kilos: ".$row["kilos"].",
						disponible: ".$row["existencia"].",
						almacen: '".$row["almacen"]."',
						almacenOriginal: '".$row["almacenOriginal"]."',
						almacendestino: 'SN'
                        
                    });
                    ";
	    }
	    
	    $r->script(" app.rollosObra.splice (0, app.rollosObra.length); " . $pushes);
	    
	    return $r;
	}
	$xajax->registerFunction("cargarRollosEnObra");
	
	
	function terminarPedido($idPedido)
	{
	    $r = new xajaxResponse();
	    // $r->starDebug();
	    $pd = new ModeloPedidodetalle();
	    
	    $lst = $pd->getAll("idPedidodetalle", 
	                   "", 
	                   "idPedido = " . $idPedido . " and mlDespachado > 0");
	    
// 	    echo $pd->getAllQUERY("idPedidodetalle",
// 	        "",
// 	        "idPedido = " . $idPedido . " and mlDespachado > 0");
	    
	    $blnEntro = false;
	    
	    foreach ($lst as $row)
	    {
	        $blnEntro = true;
	        
	        $pedidodetalle = new ModeloPedidodetalle();
	        
	        $pedidodetalle->setIdPedidoDetalle($row["idPedidodetalle"]);
	        
	        if ($pedidodetalle->getIdPedidoDetalle() > 0)
	        {
	            $pedidodetalle->setTotal( $pedidodetalle->getPrecioUnitario() * $pedidodetalle->getMlDespachado());
	            $pedidodetalle->setDespachadoSI();
	            
	            $pedidodetalle->Guardar();
	            
	            if ($pedidodetalle->getError())
	            {
                 $r->script(" mdlExitWait(); ");
	                $r->saError("Ha ocurrido un error al intentar guardar PedidoDetalle: " . $pedidodetalle->getStrError());
	                return $r;
	            }
	        }
	        
	    }
		
// 	    $r->endDegug();    

	    if ($blnEntro)
	    {
			// echo "bien " . __LINE__;
	        $pedido = new ModeloPedido();        
        
	        $pedido->RecalcularPedido($idPedido, true);
	        
	        $pedido->setIdPedido($idPedido);
	        
	        $pedido->setDespieceTerminadoSI();
	        
	        
	        
	        $pedido->Guardar();
	        
	        if ($pedido->getError())
	        {
             $r->script(" mdlExitWait(); ");
	            $r->saError("Ha ocurrido un error al intentar guardar Pedido: " . $pedido->getStrError());
	            return $r;
	        }
		}
		else
		{
			// echo "bien " . __LINE__;
			// $r->saSuccess("El Despiece del Pedido ha concluido");
			$r->saError("No se ha encontrado ML Despachados en el Pedido, favor de surtir algunos ML.");
			$r->script(" mdlExitWait();  alert('No se ha encontrado ML Despachados en el Pedido, favor de surtir algunos ML.');");	
			
				
				// echo "bien " . __LINE__;
				// $r->endDegug();
				return $r;
		}
		
		// echo "bien " . __LINE__;
	    // $remisiones = new ModeloRemisionrollo();
	    
	    // $lst = $remisiones->getAll("idRemisionRollo, almacen, almacenOriginal",""," almacen = 'OBRA' and idPedidoObra = " . $idPedido);
	    
	    // foreach ($lst as $row)
	    // {	        
	    //     $inv = new ModeloInvzmovnorollo();
	        
	    //     $inv->setIdRemisionRollo($row["idRemisionRollo"]);
	    //     $inv->setAlmacenOrigen($row["almacen"]);
	    //     $inv->setAlmacenDestino($row["almacenOriginal"]);
	    //     $inv->setDateAndUser("movimiento");
	        
	    //     $inv->Guardar();
	        
	    //     if ($inv->getError())	    
	    //     {
	    //         $r->script(" mdlExitWait(); ");
	    //         $r->saError("Ha ocurrido un error al intentar guardar InvzmovNoRollo: " . $inv->getStrError());
	    //     	return $r;
	    //     }
	        
	        
	    // }
	    
	    $r->saSuccess("El Despiece del Pedido ha concluido");
	    
	    $r->script(" mdlExitWait(); app.cargarDatosPedido(); ");
	    // $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("terminarPedido");
	
	function asignarRemisionRolloAObra($idRemisionRollo, $index, $idPedido)
	{
	    $r = new xajaxResponse();
	    
// 	    $r->starDebug();
	    
	    // 		rollosParaAnadir
// 	    $r->mostrarAviso("bien 235"); return $r;
	    $rem = new ModeloRemisionrollo();
	    
	    $rem->setIdRemisionRollo($idRemisionRollo);
	       
	    if ($rem->getIdRemisionRollo() <= 0)
	    {
	        $r->mostrarError("Ocurrió un error al obtener información del rollo");
	        return $r;
	    }
	    
	    
	    $inv = new ModeloInvzmovnorollo();
	    
	    $inv->setIdRemisionRollo($idRemisionRollo);
	    $inv->setAlmacenOrigen($rem->getAlmacen());
	    
// 	    $r->mostrarAviso("bien 253"); return $r;
	    
	    $inv->setAlmacenDestinoOBRA();
	    $inv->setDateAndUser("movimiento");
	    
	    $inv->Guardar();
	    
	    if (!$inv->getError())
	    {
	        $rem->setAlmacenOBRA();
	        $rem->setIdPedidoObra($idPedido);
	        $rem->Guardar();
	        
	        if (!$rem->getError())
	        {
	            $r->script(" setTimeout(function() {app.rollosParaAnadir.splice(".$index.", 1);}, 50); 
                             setTimeout (function(){ app.cargarRollosEnObra();}, 100 ); 
                             setTimeout(function() { mdlExitWait();}, 200); 
                             setTimeout(function() { app.agregarRolloAObra2(); }, 250); ");
	        }
	        else
	        {
	            $r->mostrarError("Ocurrió un error al intentar Asignar el Rollo a la Obra");
	        }
	        
	    }
	    else
	    {
	        $r->mostrarError("Ocurrió un error al intentar Asignar el Rollo a la Obra");
	    }
	    
	    
// 	    $r->endDegug();
	    
	    
	    return $r;
	}
	$xajax->registerFunction("asignarRemisionRolloAObra");
	
	function cargarNoRemision($idRemisionRollo, $idPedido)
	{
	    $r = new xajaxResponse();
// 	    $r->starDebug();
	    $rm = new ModeloRemisionrollo();
	    
	    $lst = $rm->getAll("remisionrollo.idRemisionRollo, remisionrollo.remisionRollo_rollo_idRollo idRollo, rollo.codigo,
            remisionrollo.noRollo, remisionrollo.kilos, remisionrollo.existencia, remisionrollo.almacen, remisionrollo.almacenOriginal  , remisionrollo.idPedidoObra, 
            ifnull(rp.idRegistroProduccion,0) idRegistroProduccion, ifnull(rp.kilosMaquilados,0) kilosMaquilados, ifnull(rp.totalml,0) totalml, ifnull(rp.terminado,'NO') terminado, rollo.calibre, rollo.pies ", 
	        " left join registroproduccion rp on rp.idRemisionRollo = remisionrollo.idRemisionRollo
              inner join rollo on remisionrollo.remisionRollo_rollo_idRollo = rollo.idrollo ",
	        " remisionrollo.idRemisionRollo = " . $idRemisionRollo);
	    
	    $rp = new ModeloRegistroproduccion();
	    
	    $factor = 0;
	    $rendimiento = 0;
	    	    
	    $s = "";
	    foreach ($lst as $row)
	    {
	        $rp->setIdRegistroProduccion($row["idRegistroProduccion"]);
	        $rp->getFactorYRendimiento($factor, $rendimiento);
	        
	        $s = "
                    app.nrIdRemisionRollo = ".$row["idRemisionRollo"].";
                    app.nrCodigoRollo = '".$row["noRollo"]."';
            		app.nrNoRollo = ".$row["idRollo"].";
                    app.nrRollo = '".$row["codigo"]."';
            		app.nrKilos = ".$row["kilos"].";
                    app.nrCalibre = ".$row["calibre"].";
                    app.nrPies = ".$row["pies"].";
            		app.nrExistencia = ".$row["existencia"].";
            		app.nrAlmacen = '".$row["almacen"]."';
                    app.nrAlmacenOriginal = '".$row["almacenOriginal"]."';
                    app.nrSucursalRollo = ".($row["almacenOriginal"] == 'DELTA' ? "2" : "1").";
            		app.nrIdPedidoObra = ".$row["idPedidoObra"].";
            		app.nrIdRegistroProduccion = ".$row["idRegistroProduccion"].";
            		app.nrKilosMaquilados = ".$row["kilosMaquilados"].";
            		app.nrTotalML = ".$row["totalml"].";
                    app.nrTerminado = '".$row["terminado"]."';
                    app.nrFactor = ".$factor.";
                    app.nrRendimiento = ".$rendimiento.";
                ";
	    }
	    
        $r->script($s . " mdlExitWait(); ");	    
// 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("cargarNoRemision");
	
	function crearRegistroProduccion($idRemisionRollo)
	{
	    $r = new xajaxResponse();
	    
	    $remisionRollo = new ModeloRemisionrollo();
	    $rp = new ModeloRegistroproduccion();
	    
	    if ($idRemisionRollo <= 0)
	    {
	        $r->saError("No se ha especificado un Número de Rollo");
	        return $r;
	    }
	    
	    $remisionRollo->setIdRemisionRollo($idRemisionRollo);
	    
	    if ($remisionRollo->getIdRemisionRollo() <= 0)
	    {
	        $r->saError("No se ha podido obtener la información del Número de Rollo");
	        return $r;
	    }
	    
	    if ($remisionRollo->getExistencia() <= 0)
	    {
	        $r->saInfo("El Número de Rollo no cuenta con existencia para generar el Registro de Producción");
	        return $r;
	    }
	    
	    $rp->setIdRemisionRollo($idRemisionRollo);
	    $rp->setDateAndUser("creacion");
	    
	    $rp->Guardar();
	    
	    if (!$rp->getError())
	    {
	        $r->script("
					//alert('antes exit success');
	                   mdlExitWait();
//alert('despues exit success');
                     setTimeout( function() { saSuccess(\"".mb_convert_encoding("Se ha generado el Registro de Producci�n exitosamente", 'UTF-8', 'ISO-8859-1')."\");}, 200);
				//alert('antes volver a cargar rollo');	
					 setTimeout( function() {  app.seleccionarNoRemision(app.nrIdRemisionRollo); }, 100);
					");
	    }
	    else
	    {
	        $r->script("
                    mdlExitWait();
					saError(\"".mb_convert_encoding("Ha ocurrido un error. " . $rp->getStrError(), 'UTF-8', 'ISO-8859-1')."\");
					");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("crearRegistroProduccion");
	
	function cargarPesoEstimadoXCalibrePies($calibre, $pies)
	{
	    $r = new xajaxResponse();
	    
// 	    $rp = new ModeloRegistroproduccion();
	    
// 	    $lst = $rp->getAll("idregistroproduccion, idremisionrollo, consecutivonorollo, kilos, kilosmaquilados, totalml, fecha_creacion, fecha_termina ",
// 	        "",
// 	        "idremisionrollo = '".$idRemisionRollo."'  AND  terminado = 'SI'", " consecutivonorollo");
	    
// 	    // 		idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos
// 	    $pushes = "";
// 	    foreach ($lst as $row)
// 	    {
// 	        $pushes .= "app.registrosProduccion.push({
// 		        	idRegistroProduccion: ".$row["idregistroproduccion"].",
// 		        	idRemisionRollo: ".$row["idremisionrollo"].",
// 		        	consecutivoNoRollo: ".$row["consecutivonorollo"].",
// 		        	kilos: '".$row["kilos"]."',
// 		        	kilosMaquilados: '".$row["kilosmaquilados"]."',
// 		        	totalML: '".$row["totalml"]."',
// 		        	fechaCreacion: '". clsUtilerias::formatoFecha($row["fecha_creacion"])."',
// 		        	fechaTermino: '". clsUtilerias::formatoFecha($row["fecha_termina"])."'
//         		});";
// 	    }
	    
// 	    $r->script("app.registroProduccionDetalle.splice(0, app.registroProduccionDetalle.length); app.registrosProduccion.splice(0, app.registrosProduccion.length); " . $pushes);
	    
// 	    $lst = $rp->getAll("idregistroproduccion, registroproduccion.idremisionrollo, consecutivonorollo, registroproduccion.kilos, kilosmaquilados, totalml, registroproduccion.fecha_creacion, fecha_termina, rollo.calibre, rollo.pies ",
// 	        " inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
//                   inner join rollo on remisionRollo_rollo_idRollo = idRollo",
// 	        " registroproduccion.idremisionrollo = '".$idRemisionRollo."' AND  terminado = 'NO'", " consecutivonorollo");
	    
	    
// 	    if (count($lst)>0)
// 	    {
// 	        $calibre = $lst[0]["calibre"];
// 	        $pies = $lst[0]["pies"];
	        
// 	        $r->script(" app.idRegistroProduccion = " . $lst[0]["idregistroproduccion"].";
// 					     app.calibreRolloSeleccionado = " . $calibre .";
// 					     app.cargarDatosRegistroProduccionAbierto();");
	        
	        if ($calibre > 0)
	        {
	            // 				$config = new ModeloConfiguracion();
	            
	            $pmt = new ModeloPesomt();
	            
	            $pmt->getDatosByCalibrePies($calibre);
	            
	            // 				$config->setIdConfiguracion(1);
	            
	            $pesoXCalibre = 0;
	            
	            if ($pies == 2)
	            {
	                $pesoXCalibre = $pmt->getPies2();
	            }
	            else if ($pies == 3)
	            {
	                $pesoXCalibre = $pmt->getPies3();
	            }
	            else if ($pies == 3.48)
	            {
	                $pesoXCalibre = $pmt->getPies348();
	            }
	            else if ($pies == 3.76)
	            {
	                $pesoXCalibre = $pmt->getPies376();
	            }
	            else if($pies == 4)
	            {
	                $pesoXCalibre = $pmt->getPies4();
	            }
	            
	            $r->script(" app.nrPesoEstimadoXKiloRolloSeleccionado = ".$pesoXCalibre.";");
	        }
// 	    }
// 	    else
// 	    {
// 	        $rm = new ModeloRemisionrollo();
// 	        $rm->setIdRemisionRollo($idRemisionRollo);
	        
// 	        $r->script("app.showBotonCrearRegistroProduccion = true; app.kilosNoRolloSeleccionado = ".$rm->getExistencia().";");
// 	    }
	    
	    
	    return $r;
	}
	$xajax->registerFunction("cargarPesoEstimadoXCalibrePies");
	
	function cargarDatosRegistroProduccionAbierto($idRegistroProduccion)
	{
	    $r = new xajaxResponse();
	    
	    if($idRegistroProduccion <= 0)
	    {
// 	        $r->saError("No se ha especificado datos para cargar la informaci�n del Registro de Producci�n.");
	        return $r;
	    }
	    
// 	    $rp = new ModeloRegistroproduccion();
	    
// 	    $rp->setIdRegistroProduccion($idRegistroProduccion);
	    
	    
	    
// 	    if ($rp->getIdRegistroProduccion() <= 0)
// 	    {
// 	        $r->saError("No se ha especificado datos para cargar la informaci�n del Registro de Producci�n.");
// 	        return $r;
// 	    }
	    
	    
// 	    // 		rpKilosRollo: 0,
// 	    // 		rpKilosMaquilados: 0,
// 	    // 		rpTotalML: 0,
// 	    $r->script("
	        
// 					app.rpKilosRollo = ".$rp->getKilos().";
//  					app.rpKilosMaquilados = ".$rp->getKilosMaquilados().";
// 					app.rpTotalML = ".$rp->getTotalml().";
	        
// 				");
	    
	    $rpd = new ModeloRegistroproducciondetalle();
	    
	    $lst = $rpd->getAll(" idregistroproduccion, idregistroproducciondetalle, registroproducciondetalle.tipo, ifnull(pedido.idpedido, registroproducciondetalle.tipo) as nopedido , ifnull(concat(nombre, ' ', apellidos),
								if(registroproducciondetalle.tipo = 'STOCK', 'GALVAMEX', 'PYC')) as nombrecliente, registroproducciondetalle.partida, longitud,
								(registroproducciondetalle.partida * longitud) as totalml, totalkg ",
	        " left join pedidodetalle on pedidodetalle.idpedidodetalle = registroproducciondetalle.idpedidodetalle
							 left join pedido on pedido.idpedido = pedidodetalle.idpedido
							 left join cliente on cliente.idcliente = pedido.idcliente ",
	        " idregistroproduccion = " . $idRegistroProduccion,
	        " idregistroproducciondetalle");
	    
// 	    $r->mostrarAviso($rpd->getAllQUERY(" idregistroproduccion, idregistroproducciondetalle, registroproducciondetalle.tipo, ifnull(pedido.idpedido, registroproducciondetalle.tipo) as nopedido , ifnull(concat(nombre, ' ', apellidos),
// 								if(registroproducciondetalle.tipo = 'STOCK', 'GALVAMEX', 'PYC')) as nombrecliente, registroproducciondetalle.partida, longitud,
// 								(registroproducciondetalle.partida * longitud) as totalml, totalkg ",
// 	        " left join pedidodetalle on pedidodetalle.idpedidodetalle = registroproducciondetalle.idpedidodetalle
// 							 left join pedido on pedido.idpedido = pedidodetalle.idpedido
// 							 left join cliente on cliente.idcliente = pedido.idcliente ",
// 	        " idregistroproduccion = " . $idRegistroProduccion,
// 	        " idregistroproducciondetalle"));
	    
	    // 		return $r;
	    $pushes = "";
	    foreach ($lst as $row)
	    {
	        $pushes .= "
					   app.registroProduccionDetalle.push({
								tipo: '".$row["tipo"]."',
								nopedido: '".$row["nopedido"]."',
								nombrecliente: '".$row["nombrecliente"]."',
								partida: '".$row["partida"]."',
								longitud: '".$row["longitud"]."',
								totalml: '".$row["totalml"]."',
								totalkg: '".$row["totalkg"]."'
					        	});
								    
					";
	    }
	    
	    
	    
	    $r->script("
	        
					app.registroProduccionDetalle.splice(0, app.registroProduccionDetalle.length);
	        
				" . $pushes);
	    
	    
	    return $r;
	}
	$xajax->registerFunction("cargarDatosRegistroProduccionAbierto");
	
	
	function cargarDatosPedido($idPedido, $idRolloSeleccionado, $idSucursal)
	{
	    $r = new xajaxResponse();
	    
	    // 		global $objSession;
	    
	    // 		$idSucursal = $objSession->getIdSucursal();
	    
	    
	    if ($idPedido <= 0)
	    {
	        $r->saError("No se ha especificado Número de Pedido");
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
	
	function registrarRPPedido($idRollo, $idRemisionRollo, $idRegistroProduccion, $idPedidoDetalle, $idProducto, $piezas, $ml, $kgml, $totalkg, $idPedidoDetalleColocacion, $idSucursal)
	{
	    $r = new xajaxResponse();
// 	    $r->starDebug();
	    $rpd = new ModeloRegistroproducciondetalle();
	    
	    if ($totalkg <= 0)
	    {
	        $r->saError("El total de kg del registro debe ser mayor a cero.");
	        return $r;
	    }
	    
	    $blnDoCommit = true;
	    $strErrores = "";
	    
	    $rpd->transaccionIniciar();
	    
	    $rpd->setIdRegistroProduccion($idRegistroProduccion);
	    $rpd->setTipoPEDIDO();
	    $rpd->setIdPedidoDetalle($idPedidoDetalle);
	    $rpd->setIdProducto($idProducto);
	    $rpd->setPartida($piezas);
	    $rpd->setLongitud($ml);
	    $rpd->setKgml($kgml);
	    $rpd->setTotalKg($totalkg);
	    $rpd->setTotalReal(0);
	    $rpd->setDateAndUser("captura");
	    $rpd->setIdSucursal($idSucursal);
	    
// 	    $r->mostrarAviso("todo bien antes de guardar rpd"); return $r;
	    
	    $rpd->Guardar();
	    
// 	    $r->mostrarAviso("todo bien despues de guardar rpd"); return $r;
	    
	    
	    if (!$rpd->getError())
	    {
	        $pd = new ModeloPedidodetalle();
// 	        			$r->mostrarAviso("antes de pedido detalle set idpedido detalle "); return $r;
	        $pd->setIdPedidoDetalle($idPedidoDetalle);
// 	        			$r->mostrarAviso("despues de set idpedidodetalle"); return $r;
	        
// 	        $pd->setPartidaDespachada($pd->getPartidaDespachada() + $piezas);
	        
	        $pd->setMlDespachado($pd->getMlDespachado() + ($ml*$piezas));
	        // 			$r->mostrarAviso("despues de setPartidaDespachada");
	        $pd->setIdSucursalDespachado($idSucursal);
	        // 			$r->mostrarAviso("despues de set idsucursaldespachado"); return $r;
	        
// 	        if ($pd->getPartidaDespachada() >= $pd->getPartida())
// 	        {
// 	            $pd->setDespachadoSI();
// 	            $pd->setDateAndUser("despachado");
// 	        }
	        
// 	        			$r->mostrarAviso("todo bien al actualizar pedido detalle"); return $r;
	        
	        $pd->Guardar();
	        
// 	        $r->mostrarAviso("todo bien despuess actualizar pedido detalle"); return $r;
	        
	        if (!$pd->getError())
	        {
	            $inv = new ModeloInvzmovrollo();
	            // 				$inv->transaccionIniciar();
	            
// 	            $r->mostrarAviso("en modeloinvzmovrollo"); return $r;
	            $inv->setIdRollo($idRollo);
	            $inv->setIdRemisionRollo($idRemisionRollo);
	            $inv->setDocumentoPEDIDO();
	            $inv->setReferencia($pd->getIdPedido());
	            $inv->setMovimientoSALIDA();
	            $inv->setSalidaDespachoSI();
	            $inv->setCantidad($totalkg);
	            $inv->setObservaciones("Registro de Produccion OBRA");
	            $inv->setIdPedidoDetalle($idPedidoDetalle);
	            $inv->setDateAndUser("movimiento");
	            $inv->setIdRegistroProduccion($idRegistroProduccion);
	            $inv->setIdRegistroProduccionDetalle($rpd->getIdRegistroProduccionDetalle());
	            $inv->setIdSucursal($idSucursal);
	            $inv->setPiezas($ml);
	            
	            // 				$r->mostrarAviso("todo bien antes de guardar invzmovrollo"); return $r;
	            $inv->Guardar();
	            
	            if (!$inv->getError())
	            {
	                
	            }
	            else
	            {
	                $blnDoCommit = false;
	                $strErrores .= $inv->getStrError() . ".";
	            }
	            
	            
	            $vld = new ModeloValesalidadetalle();
	            // 				$inv->transaccionIniciar();
	            
	            // 	            $r->mostrarAviso("en modeloinvzmovrollo"); return $r;
	            
	            $vld->setIdValeSalida(0);
	            $vld->setIdPedidoDetalle($pd->getIdPedidoDetalle());
	            $vld->setIdPedido($pd->getIdPedido());
	            $vld->setIdProducto($idProducto);
	            $vld->setCantidad($piezas);
	            $vld->setDateAndUser("despacho");
	            $vld->setIdSucursalDespachado($idSucursal);
	            
	            // 				$r->mostrarAviso("todo bien antes de guardar invzmovrollo"); return $r;
	            $vld->Guardar();
	            
	            if (!$vld->getError())
	            {
	                
	            }
	            else
	            {
	                $blnDoCommit = false;
	                $strErrores .= $vld->getStrError() . ".";
	            }
	            
	            
	            
	        }
	        else
	        {
	            $strErrores .= $rpd->getStrError() . ".";
	            $blnDoCommit = false;
	        }
	    }
	    else
	    {
	        $strErrores .= $rpd->getStrError() . ".";
	        $blnDoCommit = false;
	    }
	    
	    if ($blnDoCommit)
	    {
	        $rpd->transaccionCommit();
	        // 			$r->script("app.pedidoNoDespachar(); app.cancelarIngresoRegistro(); xajax_cargarDatosRegistroProduccionAbierto(app.idRegistroProduccion);");
	        $r->script(" app.seleccionarNoRemision(app.nrIdRemisionRollo); app.refresh(); ");
	        $r->saSuccess("Se ha registrado la producción satisfactoriamente.");
	        $r->saClose(2);
	        
	    }
	    else
	    {
	        $rpd->transaccionRollback();
	        $r->saError("Ha ocurrido un error. " . $strErrores );
// 	        $r->script(" app.showButtonRegistrarRPPedido = true;");
	    }
	    
// 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("registrarRPPedido");
	
	function concluirRegistroProduccion($idRegistroProduccion)
	{
		$r = new xajaxResponse();
	
		$rp = new ModeloRegistroproduccion();
	
		if ($idRegistroProduccion <= 0)
		{
			$r->saError("No se ha indicado un Registro de Producción.");
			return $r;
		}
	
		$rp->setIdRegistroProduccion($idRegistroProduccion);
	
		if ($rp->getIdRegistroProduccion() <= 0)
		{
			$r->saError("No se ha podido cargar la información de Registro de Producción.");
			return $r;
		}
	
		$rp->setTerminadoSI();
		$rp->setDateAndUser("termina");
	
		$rp->Guardar();
	
		if (!$rp->getError())
		{
			$r->script("app.seleccionarOtroNoRollo();");
			$r->saSuccess("Se ha concluido el Registro de Producción exitosamente.");
			$r->saClose(2);
		}
		else
		{
			$r->saError("Ha ocurrido un error. " );
			// 			$r->script(" app.showButtonRegistrarRPPedido = true;");
		}
	
		return $r;
	}
	$xajax->registerFunction("concluirRegistroProduccion");
	

	function registrarRPPyc($idRollo, $idRemisionRollo, $idRegistroProduccion, $piezas, $ml, $kgml, $totalkg, $idSucursal)
	{
	    $r = new xajaxResponse();
	    
	    $rpd = new ModeloRegistroproducciondetalle();
	    
	    if ($totalkg <= 0)
	    {
	        $r->saError("El total de kg del registro debe ser mayor a cero.");
	        return $r;
	    }
	    
	    $blnDoCommit = true;
	    $strErrores = "";
	    
	    
	    
	    
	    $rpd->transaccionIniciar();
	    
	    $rpd->setIdRegistroProduccion($idRegistroProduccion);
	    $rpd->setTipoPYC();
	    $rpd->setIdPedidoDetalle(0);
	    $rpd->setPartida($piezas);
	    $rpd->setLongitud($ml);
	    $rpd->setKgml($kgml);
	    $rpd->setTotalKg($totalkg);
	    $rpd->setTotalReal(0);
	    $rpd->setDateAndUser("captura");
	    $rpd->setIdSucursal($idSucursal);
	    
	    
	    $rpd->Guardar();
	    
	    
	    
	    if (!$rpd->getError())
	    {
	        $inv = new ModeloInvzmovrollo();
	        
	        
	        $inv->setIdRollo($idRollo);
	        $inv->setIdRemisionRollo($idRemisionRollo);
	        $inv->setDocumentoNINGUNO();
	        $inv->setReferencia("");
	        $inv->setMovimientoSALIDA();
	        $inv->setSalidaDespachoNO();
	        $inv->setCantidad($totalkg);
	        $inv->setObservaciones("Registro de Produccion");
	        $inv->setIdPedidoDetalle(0);
	        $inv->setDateAndUser("movimiento");
	        $inv->setIdRegistroProduccion($idRegistroProduccion);
	        $inv->setIdRegistroProduccionDetalle($rpd->getIdRegistroProduccionDetalle());
	        $inv->setIdSucursal($idSucursal);
	        $inv->setPiezas($piezas);
	        
	        $inv->Guardar();
	        
	        if (!$inv->getError())
	        {
	            
	        }
	        else
	        {
	            $blnDoCommit = false;
	            $strErrores .= $inv->getStrError() . ".";
	        }
	        
	    }
	    else
	    {
	        $blnDoCommit = false;
	        $strErrores .= $rpd->getStrError() . ".";
	    }
	    
	    if ($blnDoCommit)
	    // if (false)
	    {
	        $rpd->transaccionCommit();
// 	        $r->script("app.cancelarIngresoRegistro(); xajax_cargarDatosRegistroProduccionAbierto(app.idRegistroProduccion);");
	        $r->script(" app.seleccionarNoRemision(app.nrIdRemisionRollo); app.refresh();");
	        $r->saSuccess("Se ha registrado la producción satisfactoriamente.");
	        $r->saClose(2);
	    }
	    else
	    {
	        $rpd->transaccionRollback();
	        $r->saError("Ha ocurrido un error. " . $strErrores );
// 	        $r->script(" app.showButtonRegistrarRPSPyc = true;");
	    }
	    
	    
	    
	    
	    return $r;
	}
	$xajax->registerFunction("registrarRPPyc");

	function moverAAlmacen ($idRemisionRollo, $index, $almacenDestino)
	{
		$r = new xajaxResponse();
		$invzmovnorollo = new ModeloInvzmovnorollo();
			
		$invzmovnorollo->setIdRemisionRollo($idRemisionRollo);
		$invzmovnorollo->setAlmacenOrigen("OBRA");
		$invzmovnorollo->setAlmacenDestino($almacenDestino);
		$invzmovnorollo->setDateAndUser("movimiento");
		
		$invzmovnorollo->Guardar();
		
		if (!$invzmovnorollo->getError())
		{   
			$r->saSuccess("El #Rollo ha sido cambiado de Almacén con éxito");
			$r->script(" app.rollosObra.splice(".$index.", 1);  mdlExitWait();  ");
			
		}
		else
		{
			$r->saError("Ocurrió un error al intentar cambiar de Almacen al No Rollo: " . $invzmovnorollo->getStrError());    
		}
		
		
		return $r;

	}
	$xajax->registerFunction("moverAAlmacen");
	
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
