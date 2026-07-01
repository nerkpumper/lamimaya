<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.valesalida.inc.php";
	require_once FOLDER_MODEL. "model.valesalidadetalle.inc.php";

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
		
		
	function cargarDatosPedido($idPedido)
	{
		$r = new xajaxResponse();
		
		$pedido = new ModeloPedido();
		
		$pedido->getPedido($idPedido, " LIMIT 1");
		
		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se ha encontrado información del Pedido solicitado.");
			$r->script("app.seleccionarOtroPedido();");
			return $r;			
		}
		
		$r->script("app.pedidoBloqueado = false; ");
		if ($pedido->getPedidoDato("pedidoBloqueado") == 'SI')
		{
			$r->saInfo("El Pedido que esta intentando cargar esta Bloqueado por Precios.");
			$r->script("app.pedidoBloqueado = true; ");
			
		}
		
		// if ($pedido->getPedidoDato("estado") != "PRODUCCION" && $pedido->getPedidoDato("estado") != "TERMINADO")
		// {
		// 	$r->saInfo("Solo pueden generarse Vales de Salida de los Pedidos que esten en estatus de PRODUCCION. El estatus actual del Pedido es: ". $pedido->getPedidoDato("estado"));
		// 	$r->script("app.seleccionarOtroPedido();");
		// 	return $r;
		// }
		
		
		$datosCliente = "";
		
		$datosCliente .= "app.cteIdCliente = '".$pedido->getPedidoDato("idCliente")."';";
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
		
		$datosCliente .= "app.estado = '".$pedido->getPedidoDato("estado")."';";
		// $datosCliente .= "app.promotorAutorizaValeSalida = '".$pedido->getPedidoDato("generarValeSalida")."';";
		$datosCliente .= "app.promotorAutorizaValeSalida = 'SI';";
		$datosCliente .= "app.valesLiberados = ".($pedido->getPedidoDato("liberaVales") == 'SI' ? "true" : "false").";";
		
		
		$r->script($datosCliente . "  app.seleccionarPedido = false;	" );
		
		return $r;
	}	
	$xajax->registerFunction("cargarDatosPedido");
	
	function cargarMercanciaSinVale($idPedido)
	{
		$r = new xajaxResponse();
// 	    $r->starDebug();
	    
	    global $objSession;
	    
	    $idSucursal = $objSession->getIdSucursal();
	    
	    
		$vsd = new ModeloValesalidadetalle();
		$idProductoMoldura = 9;
		$idProductoMaquilaMoldura = 10;
		
// 		$lst = $vsd->getAll(" valesalidadetalle.fecha_despacho, valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto, pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
// 							 vp.codigo, vp.tipoProducto, vp.aplicacion, vp.material, vp.shortUnidad, vp.calibre, vp.pies, vp.descripcion, pd.molDescMaquila ",
// 							"inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
//                              inner join viewproductos as vp on vp.idProducto = pd.idProducto",
// 							"valesalidadetalle.idPedido = " . $idPedido . " and idValeSalida = 0",
// 							"idvalesalidadetalle");

		
		$lst = $vsd->getAll("sucursal.nombre sucursal, valesalidadetalle.fecha_despacho, valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto, pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
		                      vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto,
		vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
		vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial,
		vp.material as proMaterial,
		vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
		vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion, vp.rollodescauto,		
		vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
		vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,					 
        pd.idProducto as detIdProducto,
vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
            pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, 
                             pd.molDescMaquila ",
		    "inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
                             inner join viewproductos as vp on vp.idProducto = pd.idProducto
 LEFT JOIN viewrollos as vrmol
					       ON vrmol.idRollo = pd.idRolloBase
INNER JOIN sucursal ON valesalidadetalle.idSucursalDespachado = sucursal.idSucursal
",
		    "valesalidadetalle.idPedido = " . $idPedido . " and idValeSalida = 0 " . ($idSucursal > 0 ? " and valesalidadetalle.idSucursalDespachado = " . $idSucursal : " ")  ,
		    "idvalesalidadetalle");
		
		
		
		$mercanciaSinValeSalida = "";
		foreach ($lst as $row)
		{
// 			$perfil = $row["aplicacion"];
// 			$material = $row["material"];
		    $perfil = $row["proAplicacion"];
		    $material = $row["proMaterial"];
			
			$perfil = str_replace("--NO APLICA--","-", $perfil);
			$perfil = str_replace("-- NO APLICA --","-", $perfil);
			
			$material = str_replace("--NO APLICA--","-", $material);
			$material = str_replace("-- NO APLICA --","-", $material);
			
			$calibre = $row["proCalibre"];
			
  			if ($calibre == "0")
 			{
 				$calibre = "-";
 			}
 			
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
			
			
			$mercanciaSinValeSalida  .= "					
											
						app.mercanciaSinVale.push ({
								selected:       false,
								fecha_despacho: '".$row["fecha_despacho"]."',
								idValeSalidaDetalle:     ".$row["idValeSalidaDetalle"].",
								cantidad:       '".$row["cantidad"]."',
								idProducto:     ".$row["detIdProducto"].", 
								mlkg:           '".$row["mlkg"]."',
								m2inml:         '".$row["m2inml"]."',  
								explotarUnidad: '".$row["explotarUnidad"]."', 
								codigo:         '".$row["proCodigo"]."',
								tipoProducto:   '".$row["proTipoProducto"]."',
								aplicacion:     '".$perfil."',
								material:       '".$material."',
								shortUnidad:    '".$row["proShortUnidad"]."',
								calibre:        '".$calibre."',
								pies:           ".$row["rolloPies"].",
								descripcion:    '".$desc."',
                                sucursal:       '".$row["sucursal"]."'
							});
					
					";
			
// 			descripcion:    '".$row["descripcion"] . " ". $row["molDescMaquila"]."'
		}
		
				
		$r->script(" app.mercanciaSinVale.splice(0, app.mercanciaSinVale.length); " . $mercanciaSinValeSalida);
// 	    $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarMercanciaSinVale");
	
	   
	function cargarSingleValeSalida($idPedido, $idValeSalida)
	{
		$r = new xajaxResponse();
// 	    $r->starDebug();
		$vsd = new ModeloValesalidadetalle();

			
		$lst = $vsd->getAll(" valesalida.generarValeSalida, valesalida.pagoVSEntrega, valesalida.yaImpreso,  valesalida.observacion_aunno, valesalidadetalle.fecha_despacho, valesalidadetalle.idPedido, p.idCliente, concat(c.nombre, ' ', c.apellidos) as nombreCliente , 
                             valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto, 
                              pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
							 vp.codigo, vp.mlpieza, vp.tipoProducto, vp.aplicacion, vp.material, vp.shortUnidad, vp.calibre, vp.pies, vp.descripcion,
                          p.saldada, valesalida.chkImprimirPedidoNoSaldado  ",
				"inner join valesalida on valesalida.idvalesalida = valesalidadetalle.idvalesalida
                inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
                inner join viewproductos as vp on vp.idProducto = pd.idProducto
				inner join pedido as p on p.idpedido = valesalidadetalle.idpedido
				inner join cliente as c on c.idCliente = p.idCliente",
				"valesalidadetalle.idPedido = " . $idPedido . " and valesalidadetalle.idValeSalida = " . $idValeSalida,
				"valesalidadetalle.idvalesalidadetalle");
				
// 		echo $vsd->getAllQUERY(" valesalida.generarValeSalida, valesalida.observacion_aunno, valesalidadetalle.fecha_despacho, valesalidadetalle.idPedido, p.idCliente, concat(c.nombre, ' ', c.apellidos) as nombreCliente ,
//                              valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto,
//                               pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
// 							 vp.codigo, vp.mlpieza, vp.tipoProducto, vp.aplicacion, vp.material, vp.shortUnidad, vp.calibre, vp.pies, vp.descripcion,
//                           p.saldada, vs.chkImprimirPedidoNoSaldado  ",
// 		    "inner join valesalida on valesalida.idvalesalida = valesalidadetalle.idvalesalida
//                 inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
//                 inner join viewproductos as vp on vp.idProducto = pd.idProducto
// 				inner join pedido as p on p.idpedido = valesalidadetalle.idpedido
// 				inner join cliente as c on c.idCliente = p.idCliente",
// 		    "valesalidadetalle.idPedido = " . $idPedido . " and valesalidadetalle.idValeSalida = " . $idValeSalida,
// 		    "valesalidadetalle.idvalesalidadetalle");
		
	
		$mercanciaValeSalida = "";
		$detalleValeSalida = "";
		$generarValeSalida = "";
		$observacionAunNo = "";
		$imprimirSinSaldar = "";
		$pedidoSaldado = "";
		$yaImpreso = "NO";
		
		foreach ($lst as $row)
		{
			
			$perfil = $row["aplicacion"];
			$material = $row["material"];
				
			$perfil = str_replace("--NO APLICA--","-", $perfil);
			$perfil = str_replace("-- NO APLICA --","-", $perfil);
				
			$material = str_replace("--NO APLICA--","-", $material);
			$material = str_replace("-- NO APLICA --","-", $material);
				
			$calibre = $row["calibre"];
				
			if ($calibre == "0")
			{
				$calibre = "-";
			}
				
				
			$mercanciaValeSalida  .= "
						
						app.mercanciaVale.push ({								
								fecha_despacho: '".$row["fecha_despacho"]."',
								pedido: ".$row["idPedido"].",
								cliente: '".$row["nombreCliente"]."',
								idValeSalidaDetalle:     ".$row["idValeSalidaDetalle"].",
								cantidad:       '".$row["cantidad"]."',
								idProducto:     ".$row["idProducto"].",
								mlkg:           '".$row["mlpieza"]."',
								m2inml:         '".$row["m2inml"]."',
								explotarUnidad: '".$row["explotarUnidad"]."',
								codigo:         '".$row["codigo"]."',
								tipoProducto:   '".$row["tipoProducto"]."',
								aplicacion:     '".$perfil."',
								material:       '".$material."',
								shortUnidad:    '".$row["shortUnidad"]."',
								calibre:        '".$calibre."',
								pies:           ".$row["pies"].",
								descripcion:    '".$row["descripcion"]."',								
							});
			
					";
			
// 			$detalleValeSalida .= "
//                     app.valeSalidaDetalle.push ({
//                             piezas: ,
//                             descripcion: '',
//                             total: 1,
//                             unidad: ''        
//                     });
            
//             ";
			
			$generarValeSalida = $row["generarValeSalida"];
			$pagoVSEntrega = $row["pagoVSEntrega"];
			$observacionAunNo = $row["observacion_aunno"];
			$imprimirSinSaldar = $row["chkImprimirPedidoNoSaldado"];
			$pedidoSaldado = $row["saldada"];
			$yaImpreso = $row["yaImpreso"];
			
			
		}
	
	
// 		$r->script(" app.generarValeSalida = '".$generarValeSalida."'; app.observacionAunNo = '".$observacionAunNo    ."';  
//                      app.mercanciaVale.splice(0, app.mercanciaVale.length); 
//                      app.valeSalidaDetalle.splice(0, app.mercanciaVale.length); " . $mercanciaValeSalida . " " . $detalleValeSalida);
		
		if ($yaImpreso == "SI")
		{
			$r->script(" app.verificandoSurtido = false; ");
		}
		else
		{
			$r->script(" app.verificarSiValePuedeImprimirse(); ");
		}
		
		
		$r->script(" app.generarValeSalida = '".$generarValeSalida."'; 
                     app.observacionAunNo = '".$observacionAunNo    ."';
                     app.pedidoPagado = '".$pedidoSaldado."';
					 app.pagoVSEntrega = '".$pagoVSEntrega."';
					 app.permitirImprimirNoPagado = '".$imprimirSinSaldar."';
					 app.valeSalidaYaImpreso = '".$yaImpreso."';

					 app.mercanciaVale.splice(0, app.mercanciaVale.length);" . $mercanciaValeSalida . "  mdlExitWait(); 
					 app.valeAutorizadoAutomatico = false;
					 

					 					 
					 
					 " );

					//  if (app.pedidoPagado == 'NO' && app.permitirImprimirNoPagado == 'NO')
					//  {
						 
					// 	 setTimeout(function() {app.verificarSiValePuedeAutorizarseEnAutomatico();}, 250);
					//  }

			
// 		$r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarSingleValeSalida");
	
	function cargarValesSalida($idPedido)
	{
		$r = new xajaxResponse();
	
		$vs = new ModeloValesalida();
	
		$lst = $vs->getAll("idValeSalida, estado", "", "idPedido = " . $idPedido);
	
		
		$vales = "";
		foreach ($lst as $row)
		{				
				
			$estado = $row["estado"];
			
			if ($estado == "CREADO")
			{
				$estado = "POR SALIR";
			}
			
			
			$vales  .= "
						
						app.valesSalida.push({
							idValeSalida: ".$row["idValeSalida"].",
							estado: '".$estado."'
						});
			
					";
		}
	
	
		$r->script(" app.valesSalida.splice(0, app.valesSalida.length); " . $vales);
	
		return $r;
	}
	$xajax->registerFunction("cargarValesSalida");
	
	function generarValeSalida($idPedido, $mercancia)
	{
		$r = new xajaxResponse();
		
		$vale = new ModeloValesalida();
		$blnCommit = true;
		
		$vale->transaccionIniciar();
		
		$vale->setIdPedido($idPedido);
		$vale->setDateAndUser("creado");
		
		$vale->Guardar();
		
		$errores = "";
		
		if ($vale->getError())
		{
			$errores .=mb_convert_encoding("Ocurri� un error al intentar generar el Vale de Salida\n", 'UTF-8', 'ISO-8859-1');
			$blnCommit = false;
		}

		$idValeSalida = $vale->getIdValeSalida();	
		$valeSalidaYaEnSucursal = false;
		
		if ($blnCommit)
		{
			foreach ($mercancia as $item)
			{
				if ($item["selected"])
				{
					$vsd = new ModeloValesalidadetalle();
					$vsd->setIdValeSalidaDetalle($item["idValeSalidaDetalle"]);
					
					if ($vsd->getIdValeSalidaDetalle() <= 0)
					{
						$errores .=mb_convert_encoding("Ocurri� un error al intentar generar el Vale de Salida", 'UTF-8', 'ISO-8859-1');
						$blnCommit = false;
						break;
					}
					
					$vsd->setIdValeSalida($idValeSalida);
					
					$vsd->Guardar();
					
					if ($vsd->getError())
					{
						$errores .= mb_convert_encoding("Ocurri� un error al intentar actualizar informaci�n de Vale Salida [".$item["idValeSalidaDetalle"]."]\n", 'UTF-8', 'ISO-8859-1');
						$blnCommit = false;
					}
					
					if (!$valeSalidaYaEnSucursal)
					{
					    
					    $vale->setIdSucursal($vsd->getIdSucursalDespachado());
					    
					    $vale->Guardar();
					    
					    if ($vale->getError())
					    {
					        $errores .= mb_convert_encoding("Ocurri� un error al intentar actualizar informaci�n de Vale Salida [".$item["idValeSalidaDetalle"]."]\n", 'UTF-8', 'ISO-8859-1');
					        $blnCommit = false;
					    }
					    
					    $valeSalidaYaEnSucursal = true;
					}
					
					
					
				}
			}	
		}		
		
		
		$r->saError($errores);
		
		if ($blnCommit)
		{
			$r->saSuccess("El Vale de Salida se ha generado con éxito con el folio " . $idValeSalida);
			$r->script("app.mostrarPartidasSinValeSalida(); app.cargarValesSalida();");
			$vale->transaccionCommit();
		}
		else
		{
			$vale->transaccionRollback();
		}
	
		return $r;
	}
	$xajax->registerFunction("generarValeSalida");

	function verificarSiValePuedeImprimirse($idValeSalida, $idPedido)
	{
		$r = new xajaxResponse();
		
		$vale = new ModeloValesalida();
		// $vale->setIdValeSalida($idValeSalida);

		$query = "
				SELECT 
				IFNULL((SELECT SUM(cantidad) FROM valesalidadetalle WHERE idValeSalida = ".$idValeSalida."), 0) enVale,
				IFNULL((SELECT SUM(partidadespachada) FROM pedidodetalle WHERE idpedido = ".$idPedido."),0) despachado, 
				IFNULL((SELECT SUM(mldespachado) FROM pedidodetalle WHERE idpedido = ".$idPedido."),0) mldespachado, 
				IFNULL((SELECT SUM(vd.cantidad) FROM valesalidadetalle vd INNER JOIN valesalida v ON vd.idValeSalida = v.idValeSalida AND v.yaImpreso = 'SI'
						WHERE vd.idpedido = ".$idPedido."),0) sacado

					";
		
		$datos = $vale->getDataSet($query);

		$enVale = $datos[0]["enVale"];
		$despachado = $datos[0]["despachado"];
		$sacado = $datos[0]["sacado"];
		$mldespachado = $datos[0]["mldespachado"];
		

		// $msg = "";
		// $msg.= "en Vale: ".$enVale."<br>";
		// $msg.= "despachado: ".$despachado."<br>";
		// $msg.= "sacado: ".$sacado."<br>";
		// $msg.= "mlDespachado: ".$mldespachado."<br>";

		// $r->mostrarAviso($msg); 
		if (($despachado + $mldespachado) >= ($enVale + $sacado))
		{
		
			$r->script(" setTimeout(function(){ app.ValeSalidaCubreSurtido = true;}, 201); ");
			
		}

		$r->script(" setTimeout(function(){ app.verificandoSurtido = false;}, 200); ");


		return $r;

	}
	$xajax->registerFunction("verificarSiValePuedeImprimirse");
	
	

	function verificarSiValePuedeAutorizarseEnAutomatico($idValeSalida)
	{
		$r = new xajaxResponse();
		
		$vale = new ModeloValesalida();
		// $vale->setIdValeSalida($idValeSalida);

		$query = " select vs.idPedido, 
							getSaldoPendienteDePago(p.idCliente) saldoPendiente, 
							getPedidosPendienteDePagoMas30Dias(p.idCliente) pedidosConSaldo
					from valesalida vs 
					inner join pedido p on vs.idPedido = p.idpedido
					where vs.idValeSalida  = " . $idValeSalida;
		
		$lst = $vale->getDataSet($query);

		$saldoPendiente = 0;
		$pedidosConSaldo = 0;
		$valeAutorizadoAutomatico = false;

		if (count($lst))
		{
			 $idPedido = $lst[0]["idPedido"];
			 $saldoPendiente = $lst[0]["saldoPendiente"];
			 $pedidosConSaldo = $lst[0]["pedidosConSaldo"];
		}

		PedidoTrackingManager::logWarning($idPedido, "Se comienza a verificar el Vale de Salida ". $idValeSalida. " para verificar si puede Autorizarse su impresión en automático.", false);


		if ($saldoPendiente <= 25000 && $pedidosConSaldo == 0)
		{
			PedidoTrackingManager::logSuccess($idPedido, "El Vale de Salida " . $idValeSalida. " se ha autorizado en automático para su impresión, por que el cliente cumple con un saldo menor o igual a $ 25 000 y no tiene Pedidos pendientes de pago mayores a 30 días.", false);
			$valeAutorizadoAutomatico = true;
		}
		else
		{
			if ($saldoPendiente > 25000)
			{
				PedidoTrackingManager::logError($idPedido, "El Vale de Salida " . $idValeSalida. " no puede autorizarse su impresión porque la suma de su saldo pendiente es de $ ". $saldoPendiente." , mayor a lo permitido ($ 25 000).", false);			
			}
			
			if ($pedidosConSaldo > 0)
			{
				PedidoTrackingManager::logError($idPedido, "El Vale de Salida " . $idValeSalida. " no puede autorizarse su impresión porque el Cliente tiene ".$pedidosConSaldo." Pedidos pendientes de pago mayores a 30 días.", false);			
			}	

		}


		$r->script("
					 app.saldoPendientePago = ".$saldoPendiente.";
					 app.pedidosConSaldo = ".$pedidosConSaldo.";

					 app.valeAutorizadoAutomatico = ". ($valeAutorizadoAutomatico ? "true" : "false") .";
					 
					 
					 " );


		return $r;

	}
	$xajax->registerFunction("verificarSiValePuedeAutorizarseEnAutomatico");

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
