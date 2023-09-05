<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	require_once FOLDER_MODEL. "model.invzmovrollo.inc.php";
	require_once FOLDER_MODEL. "model.invzstocknorollo.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	


	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();

//   ob_start();
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

	function cargarPedido($idPedido)
	{
		$r = new xajaxResponse();
        $idProductoMoldura = 386;
        $idProductoMaquilaMoldura = 394;
		$pedido = new ModeloPedido();

		$pedido->getPedido($idPedido);

		if ($pedido->getPedidoDato("idPedido") <= 0)
		{
			$r->saError("No se ha encontrado un Pedido con el folio indicado.");
			$r->script("app.seleccionarPedido = true;");
			return $r;
		}

		$estado = $pedido->getPedidoDato("estado");


		if ($estado != "PRODUCCION" && $estado != "TERMINADO")
		{
			$r->script("app.pedidoEstado = '".$estado."'; app.pedidoNoProduccion = true;");
			return $r;
		}

		if ($estado == "TERMINADO")
		{
			$r->script("app.pedidoTerminado = true;");

		}



		$pedidoDetalle = "";

		foreach ($pedido->__rsPedidoWDetalle as $row)
		{
			$desc = $row["detPartida"]." ";
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
					    $desc = $row["detPartida"]." MOLDURA ". $row["rolloMolduraDesc"];
					    if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
					    {
					        $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
					    }
					}
					else
					{
					    if ($row["detIdProducto"] == $idProductoMaquilaMoldura)
					    {
					        $desc = $row["detPartida"]." MAQUILA DE MOLDURA ". $row["rolloMolduraDesc"];
					        if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
					        {
					            $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
					        }
					    }
					    else
					    {
					        $desc = $row["detPartida"]." ". $row["proDescAuto"];
					    }
					    
					}
					
					
					
					$desc = mb_strtoupper($desc);
					$desc = str_replace("--NO APLICA--", "", $desc);
// 					$desc = utf8_decode($desc);

// 			$pedidoDetalle .= "this.pedidoDetalle.push({
// 								idPedidoDetalle: ".utf8_decode($row["idPedidoDetalle"]).",
// 								codigo: \"".utf8_decode($row["proCodigo"])."\",
// 								fullName: \"".$desc."\",
// 								partida: ".utf8_decode($row["detPartida"]).",
// 								listoDespachar: \"".utf8_decode($row["listo_para_producir"])."\",
// 								despachado: \"".utf8_decode($row["despachado"])."\"
// 							});";

					$pedidoDetalle .= "app.pedidoDetalle.push({
                                idProducto: ".utf8_decode($row["detIdProducto"]).",
								idPedidoDetalle: ".utf8_decode($row["idPedidoDetalle"]).",
								codigo: \"".utf8_decode($row["proCodigo"])."\",
								shortTipoProducto: \"".utf8_decode($row["proShortTipoProducto"])."\",
								fullName: \"".$desc."\",
								unidad: \"".utf8_decode($row["proUnidad"])."\",
								shortUnidad: \"".utf8_decode($row["proShortUnidad"])."\",
								partida: ".utf8_decode($row["detPartida"]).",
								listoDespachar: \"".utf8_decode($row["listo_para_producir"])."\",
								despachado: \"".utf8_decode($row["despachado"])."\",
								despachando: false
							});";

		}

		$r->script(" app.pedidoProduccion = true; app.pedidoDetalle.splice(0, app.pedidoDetalle.length); " . $pedidoDetalle);

		return $r;
	}
	$xajax->registerFunction("cargarPedido");

	function cargarPedidoDetalle($idPedidoDetalle, $cerrarsa = true)
	{
		$r = new xajaxResponse();
		$idProductoMoldura = 386;
		$idProductoMaquilaMoldura = 394;

		$pedido = new ModeloPedido();

// 		$moldura = " app.molIdProductoLisa = 22;
//                      app.molCodigoLisa = 'Code';
// 		             app.molDescripcionLisa = 'Desc';            

//                 ";
        $moldura = "";
        
		$row = $pedido->getPedidoDetalle($idPedidoDetalle);

// 		$desc = $row["detPartida"]." ";

		//$desc .= "<span class='text-navy'>" .$row["proCodigo"] . "</span> " .
		$desc = $row["proTipoProducto"] . " " .
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
		
		if ($row["detIdProducto"] == $idProductoMoldura)
		{
		    $mol = new ModeloViewproductos();
		    
		    $mollisa = $mol->getAll("idproducto, codigo, descauto",
		                            "",
		                            "idrollo = ".$row["molIdRollo"]." and idaplicacion = 2 and estado = 'ACTIVO' and idUnidad = 4",
		                            "");
		    
		    if (count($mollisa) > 0)
		    {
		        $moldura = " app.molIdProductoLisa = ".$mollisa[0]["idProducto"].";
                             app.molCodigoLisa = '".$mollisa[0]["codigo"]."';
	       	                 app.molDescripcionLisa = '".$mollisa[0]["descauto"]."';
		            
                    ";
		    }
		    
		    
		    
		    //   			    $desc = $item["detPartida"]." MOLDURA ". $item["rolloMolduraDesc"];
		    $desc = $row["detPartida"]." MOLDURA " . $row["rolloMolduraDesc"];
		    if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
		    {
		        $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
		    }
		    
		}
		else
		{
		    if ($row["detIdProducto"] == $idProductoMaquilaMoldura)
		    {
		        $desc = $row["detPartida"]."MAQUILA DE MOLDURA " . $row["molDescMaquila"] . " " . $row["rolloMolduraDesc"];
		        if ($row["detDesarrollo"] != "0" && $row["detDobleces"] != "0")
		        {
		            $desc .= " {Des: " .$row["detDesarrollo"]. " - Dbl: ".$row["detDobleces"]."}";
		        }		        
		    }
		    else 
		    {
		        $desc = $row["proDescripcion"];
		    }
		    
		}

		$desc = str_replace("--NO APLICA--", "", $desc);
		$desc = str_replace("-- NO APLICA --", "", $desc);
		$desc = mb_strtoupper($desc);

		$htmlInvHistorial = "";

		if ($row["proShortUnidad"] != "PZA" && $row["detIdProducto"] != $idProductoMoldura)
		{
			//si entramos aqui es porque hay que sacar de rollo
			$inv = new ModeloInvzmovrollo();
			$lstInvRollo = $inv->getAll("fecha_movimiento, remisionrollo.norollo, cantidad, observaciones",
					                    "inner join remisionrollo on remisionrollo.idremisionrollo = invzmovrollo.idremisionrollo", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' ");

// 			$r->mostrarAviso($inv->getAllQUERY("fecha_movimiento, cantidad", "", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' "));
// 			return $r;

			foreach ($lstInvRollo as $item)
			{
				$htmlInvHistorial .= "<br><strong>Fecha:</strong> " . $item["fecha_movimiento"] . "     <strong># Rollo:</strong> " . $item["norollo"] . "     <strong>Cantidad:</strong> " . $item["cantidad"] . "    <strong>Obs: </strong> " . $item["observaciones"];
			}

			if ($htmlInvHistorial != "")
			{
				$htmlInvHistorial = "<strong>Historial de Surtido:</strong><br>" . $htmlInvHistorial;
			}
		}
		else
		{
			//si entramos aqui es porque hay que sacar de rollo
			$invPro = new ModeloInvzmov();
			$lstInvPro = $invPro->getAll("fecha_movimiento, IFNULL(remisionrollo.norollo, '".($row["detIdProducto"] == $idProductoMoldura ? "Moldura" : "--")."') as norollo, cantidad, observaciones",
					"left join remisionrollo on remisionrollo.idremisionrollo = invzmov.idremisionrollo", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' ");

			// 			$r->mostrarAviso($inv->getAllQUERY("fecha_movimiento, cantidad", "", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' "));
			// 			return $r;

			foreach ($lstInvPro as $item)
			{
			    $htmlInvHistorial .= "<br><strong>Fecha:</strong> " . $item["fecha_movimiento"] . "     <strong> Cantidad:</strong> " . $item["cantidad"] . "     <strong> # Rollo:</strong> " . $item["norollo"] ."    <strong>Obs: </strong> " . $item["observaciones"];
			}

			if ($htmlInvHistorial != "")
			{
				$htmlInvHistorial = "<strong>Historial de Surtido:</strong><br>" . $htmlInvHistorial;
			}
		}

				//$r->mostrarAviso($desc); return $r;
		$r->script($moldura. "

				app.detIdProducto = ".$row["detIdProducto"].";
				app.idPedidoDetalle = ".$row["idPedidoDetalle"].";

				app.proCodigo = '".$row["proCodigo"]."';
				app.proFullname = '".$desc."';
				app.proTipoProducto = '".$row["proTipoProducto"]."';
				app.proAplicacion = '".$row["proAplicacion"]."';
				app.proMaterial = '".$row["proMaterial"]."';
				app.proIdRollo = ".$row["proIdRollo"].";
                app.molIdRollo = ".$row["molIdRollo"].";

				app.rolloCodigo = '".$row["rolloCodigo"]."';
				app.rolloMaterial = '".$row["rolloMaterial"]."';
				app.rolloProveedor = '".$row["rolloProveedor"]."';
				app.rolloCalibre = '".$row["rolloCalibre"]."';
				app.rolloPies = '".$row["rolloPies"]."';
				app.rolloDescripcion = '".$row["rolloDescripcion"]."';

				app.proShortUnidad = '".$row["proShortUnidad"]."';
				app.proDescripcion = '".$row["proDescripcion"]."';

				app.detPartida = ".$row["detPartida"].";
				app.detCantidad = ".$row["detCantidad"].";
				app.detCantidadReal = ".$row["detCantidadReal"].";
				app.detDesarrollo = '".$row["detDesarrollo"]."';
				app.detDobleces = ".$row["detDobleces"].";

				app.totalExplotar = ".$row["totalExplotar"].";
				app.totalExplotado = ".$row["totalExplotado"].";
				app.explotadoReal = ".$row["explotadoReal"].";
				app.detProductoDetalleDespachado = " . ($row["despachado"] == 'SI' ? 'true' : 'false') . ";

				app.remisionIdRemisionRollo = 0;
				app.remisionRemision = 0;
				app.remisionNoRollo = '';
				app.remisionExistencia = 0;
				app.remisionCantidadSacar = 0;

				app.stockIdInvzStockNoRollo = 0;
				app.stockIdRemisionRollo = 0;
				app.stockNoRollo = '';
				app.stockNoRolloExistencia = 0;
				app.stockNoRolloCantidadSacar = 0;
                app.molCantidadSurtir = 0;
                app.molCantidadSurtirScrap = 0;
                app.molIsScrap = ".($row["molIsScrap"] == 'SI' ? 'true' : 'false').";
                app.molLaminasATomar = ".$row["molLaminasATomar"].";
				app.remisionHistorial = '';

				app.remisionHistorial = '".$htmlInvHistorial."';

				".($cerrarsa ? "swal.close();" : "")."

				");


		return $r;
	}
	$xajax->registerFunction("cargarPedidoDetalle");

	function darSalidaAInventario($idPedidoDetalle, $idProducto, $idPedido, $cantidad)
	{
		$r = new xajaxResponse();

		$producto = new ModeloProducto();

		$producto->setIdProducto($idProducto);

		if ($producto->getIdProducto() <= 0)
		{
			$r->script("saError(\"No se pudo obtener informaciï¿½n del Producto.\");");
			return $r;
		}

 		if ($producto->getExistencia() < $cantidad)
 		{
			$r->script("saError(\"No se puede descontar de Inventario, no hay Existencia suficiente para realizarlo.\");");
			return $r;
 		}

 		$blnDoCommit = true;
 		$todoDespachado = false;
 		$errores = "";
 		$inv = new ModeloInvzmov();
 		$inv->transaccionIniciar();

 		$inv->setIdProducto($idProducto);
 		$inv->setDocumentoPEDIDO();
 		$inv->setReferencia($idPedido);
 		$inv->setMovimientoSALIDA();
 		$inv->setSalidaDespachoSI();
 		$inv->setCantidad($cantidad);
 		$inv->setObservaciones("Despacho de pedido");
 		$inv->setIdPedidoDetalle($idPedidoDetalle);
 		$inv->setDateAndUser("movimiento");

 		$inv->Guardar();

 		if (!$inv->getError())
 		{
 			$pd = new ModeloPedidodetalle();

 			$pd->setIdPedidoDetalle($idPedidoDetalle);

 			if ($pd->getIdPedidoDetalle() <= 0)
 			{
 				$errores .= "No se pudo obtener el detalle del pedido.";
 				$blnDoCommit = false;
 			}
 			else
 			{
 				if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
 				{
 					$pd->setDespachadoSI();
 					$pd->setDateAndUser("despachado");
 					$todoDespachado = true;

 					$pd->Guardar();

 					if ($pd->getError())
 					{
 						$blnDoCommit = false;
 						$errores .= $pd->getStrError();
 					}
 				}
 			}

 		}
 		else
 		{
 			$blnDoCommit = false;
 		}

 		if ($blnDoCommit)
 		{
 			$inv->transaccionCommit();
 			$r->script(($todoDespachado ? " alert('marcar como despachado'); app.pedidoDetalle[app.indexDespachando].despachado = 'SI'; " : "") . "
 					    
 						setTimeout(function() {alert('antes de recargar detalle');xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El movimiento se ha realizado de manera correcta.\");
 					    ");
 		}
 		else
 		{
 			$inv->transaccionRollback();
 			$r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
 		}

 		$debug = ob_get_clean();
 			$r->mostrarMsgs($debug);

		return $r;
	}
	$xajax->registerFunction("darSalidaAInventario");

	function cargarNoRollos($idRollo)
	{
		$r = new xajaxResponse();

		$remisionRollo = new ModeloRemisionrollo();

		$lst = $remisionRollo->getAll("idRemisionRollo, remision, noRollo, existencia",
				                      "",
				                      " remisionRollo_rollo_idRollo = " . $idRollo . " AND existencia > 0",
				                      " idRemisionRollo");

		$bodyTable = "";
		foreach ($lst as $row)
		{
			$bodyTable .= "<tr>";
			$bodyTable .= "<td>".$row["noRollo"]."</td>";
			$bodyTable .= "<td>".$row["remision"]."</td>";
// 			$bodyTable .= "<td>12</td>";
			$bodyTable .= "<td>";
			$bodyTable .= "<button	onclick=\"app.seleccionarNoRollo(".$row["idRemisionRollo"].")\"";
			$bodyTable .= "class='btn btn-primary btn-xs'>Seleccionar</button>";
			$bodyTable .= "</td>";
			$bodyTable .= "</tr>";
		}

		$r->assign("tblNoRollosBody", "innerHTML", $bodyTable);
		$r->script("
					setTimeout(function(){ $('#tblNoRollos').trigger('footable_redraw')}, 50);
				");

// 		setTimeout(function(){ $('#tblNoRollos').trigger('footable_redraw')}, 5);
		return $r;
	}
	$xajax->registerFunction("cargarNoRollos");

	function cargarStockNoRollos($idProducto)
	{
		$r = new xajaxResponse();

		$isr = new ModeloInvzstocknorollo();

		$lst = $isr->getAll("idInvzStockNoRollo, invzstocknorollo.idRemisionRollo, IFNULL(noRollo, '--') as noRollo, invzstocknorollo.existencia",
				" left join remisionrollo on invzstocknorollo.idRemisionRollo = remisionrollo.idRemisionRollo",
				" invzstocknorollo.idProducto = " . $idProducto ." AND invzstocknorollo.existencia > 0 " ,
				" 2");

		$bodyTable = "";
		foreach ($lst as $row)
		{
			$bodyTable .= "<tr>";
			$bodyTable .= "<td>".$row["noRollo"]."</td>";
			$bodyTable .= "<td>".$row["existencia"]."</td>";
			// 			$bodyTable .= "<td>12</td>";
			$bodyTable .= "<td>";
			$bodyTable .= "<button	onclick=\"app.seleccionarStockNoRollo(".$row["idInvzStockNoRollo"].")\"";
			$bodyTable .= "class='btn btn-primary btn-xs'>Seleccionar</button>";
			$bodyTable .= "</td>";
			$bodyTable .= "</tr>";
		}

		$r->assign("tblStockNoRollosBody", "innerHTML", $bodyTable);
		$r->script("
					setTimeout(function(){ $('#tblStockNoRollos').trigger('footable_redraw')}, 50);
				");

		// 		setTimeout(function(){ $('#tblNoRollos').trigger('footable_redraw')}, 5);
		return $r;
	}
	$xajax->registerFunction("cargarStockNoRollos");

	function cargarDatosRemisionRollo($idRemisionRollo)
	{
		$r = new xajaxResponse();

		$remisionRollo = new ModeloRemisionrollo();

		$remisionRollo->setIdRemisionRollo($idRemisionRollo);

		if ($remisionRollo->getIdRemisionRollo() <= 0)
		{
			$r->script("saError(\"No se pudo obtener informaciï¿½n del Rollo.\");");
			return $r;
		}

		$r->script("
					app.remisionIdRemisionRollo = ".$idRemisionRollo.";
					app.remisionRemision = ".$remisionRollo->getRemision().";
					app.remisionNoRollo = '".$remisionRollo->getNoRollo()."';
					app.remisionExistencia = ".$remisionRollo->getExistencia().";
					app.remisionCantidadSacar = 0;
				");

		// 		setTimeout(function(){ $('#tblNoRollos').trigger('footable_redraw')}, 5);
		return $r;
	}
	$xajax->registerFunction("cargarDatosRemisionRollo");

	function cargarDatosStockRemisionRollo($idInvzStockNoRollo)
	{
		$r = new xajaxResponse();

		$isr = new ModeloInvzstocknorollo();

// 		$isr->setIdInvzStockNoRollo($idInvzStockNoRollo);
// 		$isr = new ModeloInvzstocknorollo();

		$lst = $isr->getAll("idInvzStockNoRollo, invzstocknorollo.idRemisionRollo, IFNULL(noRollo, '--') as noRollo, invzstocknorollo.existencia",
				" left join remisionrollo on invzstocknorollo.idRemisionRollo = remisionrollo.idRemisionRollo",
				" invzstocknorollo.idInvzStockNoRollo = " . $idInvzStockNoRollo ."  " ,
				" 2 ");

		if (count($lst) == 0)
		{
			$r->script("saError(\"No se pudo obtener informaciï¿½n del Stock de No Rollo.\");");
			return $r;
		}

// 		$r->mostrarAviso($lst[0]["existencia"]); return $r;

// 		echo "hola mundito";
// 		$debug = ob_get_clean();
// 		$r->mostrarAviso($debug);
// 		return $r;

		$r->script("
					app.stockIdInvzStockNoRollo = ".$idInvzStockNoRollo.";
					app.stockIdRemisionRollo = ".$lst[0]["idRemisionRollo"].";
					app.stockNoRollo = '".$lst[0]["noRollo"]."';
					app.stockNoRolloExistencia = ".$lst[0]["existencia"].";
					app.stockNoRolloCantidadSacar = 0;
				");

		// 		setTimeout(function(){ $('#tblNoRollos').trigger('footable_redraw')}, 5);
		return $r;
	}
	$xajax->registerFunction("cargarDatosStockRemisionRollo");

	function darSalidaARollo($idRollo,$idRemisionRollo, $cantidad, $idPedidoDetalle, $idPedido)
	{
		$r = new xajaxResponse();

		$remisionRollo = new ModeloRemisionrollo();

		$remisionRollo->setIdRemisionRollo($idRemisionRollo);

		if ($remisionRollo->getIdRemisionRollo() <= 0)
		{
			$r->script("saError(\"No se pudo obtener informaciï¿½n del Rollo.\");");
			return $r;
		}

		if ($remisionRollo->getExistencia() < $cantidad)
		{
			$r->script("saError(\"No se puede descontar del Rollo, no hay Existencia suficiente para realizarlo.\");");
			return $r;
		}

		$blnDoCommit = true;
		$errores = "";
		$inv = new ModeloInvzmovrollo();
		$inv->transaccionIniciar();


		$inv->setIdRollo($idRollo);
		$inv->setIdRemisionRollo($idRemisionRollo);
		$inv->setDocumentoPEDIDO();
		$inv->setReferencia($idPedido);
		$inv->setMovimientoSALIDA();
		$inv->setSalidaDespachoSI();
		$inv->setCantidad($cantidad);
		$inv->setObservaciones("Despacho de pedido");
		$inv->setIdPedidoDetalle($idPedidoDetalle);
		$inv->setDateAndUser("movimiento");

		$inv->Guardar();

		if (!$inv->getError())
		{
// 			$pd = new ModeloPedidodetalle();

// 			$pd->setIdPedidoDetalle($idPedidoDetalle);

// 			if ($pd->getIdPedidoDetalle() <= 0)
// 			{
// 				$errores .= "No se pudo obtener el detalle del pedido.";
// 				$blnDoCommit = false;
// 			}
// 			else
// 			{
// 				if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
// 				{
// 					$pd->setDespachadoSI();
// 					$pd->setDateAndUser("despachado");

// 					$pd->Guardar();

// 					if ($pd->getError())
// 					{
// 						$blnDoCommit = false;
// 						$errores .= $pd->getStrError();
// 					}
// 				}
// 			}

		}
		else
		{
			$blnDoCommit = false;
		}

		if ($blnDoCommit)
		{
			$inv->transaccionCommit();
// 			app.pedidoDetalle[app.indexDespachando].despachado = 'SI';
			$r->script("
 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El movimiento se ha realizado de manera correcta.\");
 					    ");
		}
		else
		{
			$inv->transaccionRollback();
			$r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
		}

		return $r;
	}
	$xajax->registerFunction("darSalidaARollo");

	function marcarComoDespachado($idPedidoDetalle)
	{
		$r = new xajaxResponse();

		$pedidoDetalle = new ModeloPedidodetalle();

		$pedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);

		if ($pedidoDetalle->getIdPedidoDetalle() <= 0)
		{
			$r->script("saError(\"No se pudo obtener informaciï¿½n del Detalle de Pedido.\");");
			return $r;
		}

		$pedidoDetalle->setDespachadoSI();
		$pedidoDetalle->setDateAndUser("despachado");
		

		$pedidoDetalle->Guardar();


		if (!$pedidoDetalle->getError())
		{
			// 			app.pedidoDetalle[app.indexDespachando].despachado = 'SI';
			$r->script("
						app.pedidoDetalle[app.indexDespachando].despachado = 'SI';
 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El Detalle de Pedido ha sido marcado como Despachado.\");
 					    ");
		}
		else
		{
			$r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
		}

		return $r;
	}
	$xajax->registerFunction("marcarComoDespachado");
	
	function marcarMaquilaRealizada($idPedidoDetalle)
	{
	    $r = new xajaxResponse();
	    
	    $pedidoDetalle = new ModeloPedidodetalle();
	    
	    $pedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);
	    
	    if ($pedidoDetalle->getIdPedidoDetalle() <= 0)
	    {
	        $r->script("saError(\"No se pudo obtener información del Detalle de Pedido.\");");
	        return $r;
	    }
	    
	    $pedidoDetalle->setDespachadoSI();
	    $pedidoDetalle->setExplotadoReal($pedidoDetalle->getTotalExplotado());
	    $pedidoDetalle->setPartidaDespachada($pedidoDetalle->getTotalExplotado());
	    $pedidoDetalle->setDateAndUser("despachado");
	    
	    $pedidoDetalle->Guardar();
	    
	    
	    if (!$pedidoDetalle->getError())
	    {
	        // 			app.pedidoDetalle[app.indexDespachando].despachado = 'SI';
	        $r->script("
						app.pedidoDetalle[app.indexDespachando].despachado = 'SI';
 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El Detalle de Pedido ha sido marcado como Realizado.\");
 					    ");
	    }
	    else
	    {
	        $r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("marcarMaquilaRealizada");

	function darSalidaAInventarioFromStockNoRollo($idPedidoDetalle, $idProducto, $idPedido, $cantidad, $idRemisionRollo)
	{
		$r = new xajaxResponse();

		$producto = new ModeloProducto();

		$producto->setIdProducto($idProducto);

		if ($producto->getIdProducto() <= 0)
		{
			$r->script("saError(\"No se pudo obtener información del Producto.\");");
			return $r;
		}

		if ($producto->getExistencia() < $cantidad)
		{
			$r->script("saError(\"No se puede descontar de Inventario, no hay Existencia suficiente para realizarlo.\");");
			return $r;
		}

		$blnDoCommit = true;
		$todoDespachado = false;
		$errores = "";
		$inv = new ModeloInvzmov();
		$inv->transaccionIniciar();

		$inv->setIdProducto($idProducto);
		$inv->setDocumentoPEDIDO();
		$inv->setReferencia($idPedido);
		$inv->setMovimientoSALIDA();
		$inv->setSalidaDespachoSI();
		$inv->setCantidad($cantidad);
		$inv->setObservaciones("Despacho de pedido");
		$inv->setIdPedidoDetalle($idPedidoDetalle);
		$inv->setDateAndUser("movimiento");
		$inv->setIdRemisionRollo($idRemisionRollo);

		$inv->Guardar();

		if (!$inv->getError())
		{
			$pd = new ModeloPedidodetalle();

			$pd->setIdPedidoDetalle($idPedidoDetalle);

			if ($pd->getIdPedidoDetalle() <= 0)
			{
				$errores .= "No se pudo obtener el detalle del pedido.";
				$blnDoCommit = false;
			}
			else
			{
				if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
				{
					$pd->setDespachadoSI();
					$pd->setDateAndUser("despachado");
					$todoDespachado = true;
					$pd->Guardar();

					if ($pd->getError())
					{
						$blnDoCommit = false;
						$errores .= $pd->getStrError();
					}
				}
			}

		}
		else
		{
			$blnDoCommit = false;
		}

		if ($blnDoCommit)
		{
			$inv->transaccionCommit();
			
			$r->script(($todoDespachado ? " app.pedidoDetalle[app.indexDespachando].despachado = 'SI'; " : "") . "
 					    
 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El movimiento se ha realizado de manera correcta.\");

 					    ");
		}
		else
		{
			$inv->transaccionRollback();
			$r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
		}

		return $r;
	}
	$xajax->registerFunction("darSalidaAInventarioFromStockNoRollo");
	
	
	function darSalidaAInventarioFromStockNoRolloScrap($idPedidoDetalle, $idPedido, $cantidad)
	{
	    $r = new xajaxResponse();
	    $idProductoMoldura = 386;
	    
// 	    $producto = new ModeloProducto();
	    
// 	    $producto->setIdProducto($idProducto);
	    
// 	    if ($producto->getIdProducto() <= 0)
// 	    {
// 	        $r->script("saError(\"No se pudo obtener información del Producto.\");");
// 	        return $r;
// 	    }
	    
// 	    if ($producto->getExistencia() < $cantidad)
// 	    {
// 	        $r->script("saError(\"No se puede descontar de Inventario, no hay Existencia suficiente para realizarlo.\");");
// 	        return $r;
// 	    }
	    
	    $blnDoCommit = true;
	    $todoDespachado = false;
	    $errores = "";
	    $inv = new ModeloInvzmov();
	    $inv->transaccionIniciar();
	    
	    $inv->setIdProducto($idProductoMoldura);
	    $inv->setDocumentoPEDIDO();
	    $inv->setReferencia($idPedido);
	    $inv->setMovimientoSALIDA();
	    $inv->setSalidaDespachoSI();
	    $inv->setCantidad($cantidad);
	    $inv->setObservaciones("Surtido de Pedido Molduras (Scrap)");
	    $inv->setIdPedidoDetalle($idPedidoDetalle);
	    $inv->setDateAndUser("movimiento");
	    $inv->setIdRemisionRollo(0);
	    
	    $inv->Guardar();
	    
	    if (!$inv->getError())
	    {
	        $pd = new ModeloPedidodetalle();
	        
	        $pd->setIdPedidoDetalle($idPedidoDetalle);
	        
	        if ($pd->getIdPedidoDetalle() <= 0)
	        {
	            $errores .= "No se pudo obtener el detalle del pedido.";
	            $blnDoCommit = false;
	        }
	        else
	        {
	            if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
	            {
	                $pd->setDespachadoSI();
	                $pd->setDateAndUser("despachado");
	                $todoDespachado = true;
	                $pd->Guardar();
	                
	                if ($pd->getError())
	                {
	                    $blnDoCommit = false;
	                    $errores .= $pd->getStrError();
	                }
	            }
	        }
	        
	    }
	    else
	    {
	        $blnDoCommit = false;
	    }
	    
	    if ($blnDoCommit)
	    {
	        $inv->transaccionCommit();
	        
	        $r->script(($todoDespachado ? " app.pedidoDetalle[app.indexDespachando].despachado = 'SI'; " : "") . "
	            
 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El movimiento se ha realizado de manera correcta.\");
	            
 					    ");
	    }
	    else
	    {
	        $inv->transaccionRollback();
	        $r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("darSalidaAInventarioFromStockNoRolloScrap");
	
	function darSalidaAInventarioFromStockNoRolloLaminaYScrap($idPedidoDetalle, $idProducto, $idPedido, $cantidad, $idRemisionRollo, $noMolduras)
	{
	    $r = new xajaxResponse();
	    $idProductoMoldura = 386;
	    
	    $producto = new ModeloProducto();
	    
	    $producto->setIdProducto($idProducto);
	    
	    if ($producto->getIdProducto() <= 0)
	    {
	        $r->script("saError(\"No se pudo obtener información del Producto.\");");
	        return $r;
	    }
	    
	    if ($producto->getExistencia() < $cantidad)
	    {
	        $r->script("saError(\"No se puede descontar de Inventario, no hay Existencia suficiente para realizarlo.\");");
	        return $r;
	    }
	    
	    $blnDoCommit = true;
	    $todoDespachado = false;
	    $errores = "";
	    $inv = new ModeloInvzmov();
	    $inv->transaccionIniciar();
	    
	    $inv->setIdProducto($idProducto);
	    $inv->setDocumentoPEDIDO();
	    $inv->setReferencia($idPedido);
	    $inv->setMovimientoSALIDA();
	    $inv->setSalidaDespachoSI();
	    $inv->setCantidad($cantidad);
	    $inv->setObservaciones(utf8_encode("Láminas tomadas para desarrollar ".$noMolduras." Molduras"));
	    $inv->setIdPedidoDetalle($idPedidoDetalle);
	    $inv->setDateAndUser("movimiento");
	    $inv->setIdRemisionRollo($idRemisionRollo);
	    
	    $inv->Guardar();
	    
	    if (!$inv->getError())
	    {
	        $invMol = new ModeloInvzmov();
	        
	        
	        $invMol->setIdProducto($idProductoMoldura);
	        $invMol->setDocumentoPEDIDO();
	        $invMol->setReferencia($idPedido);
	        $invMol->setMovimientoSALIDA();
	        $invMol->setSalidaDespachoSI();
	        $invMol->setCantidad($noMolduras);
	        $invMol->setObservaciones(utf8_encode("Surtido de Pedido Molduras (de Lámina)"));
	        $invMol->setIdPedidoDetalle($idPedidoDetalle);
	        $invMol->setDateAndUser("movimiento");
	        $invMol->setIdRemisionRollo(0);
	        
	        $invMol->Guardar();
	        
	        if (!$invMol->getError())
	        {
	            $pd = new ModeloPedidodetalle();
	            
	            $pd->setIdPedidoDetalle($idPedidoDetalle);
	            
	            if ($pd->getIdPedidoDetalle() <= 0)
	            {
	                $errores .= "No se pudo obtener el detalle del pedido.";
	                $blnDoCommit = false;
	            }
	            else
	            {
	                if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
	                {
	                    $pd->setDespachadoSI();
	                    $pd->setDateAndUser("despachado");
	                    $todoDespachado = true;
	                    $pd->Guardar();
	                    
	                    if ($pd->getError())
	                    {
	                        $blnDoCommit = false;
	                        $errores .= $pd->getStrError();
	                    }
	                }
	            }
	        }
	        
	        
	        
	        
	    }
	    else
	    {
	        $blnDoCommit = false;
	    }
	    
	    if ($blnDoCommit)
	    {
	        $inv->transaccionCommit();
	        
	        $r->script(($todoDespachado ? " app.pedidoDetalle[app.indexDespachando].despachado = 'SI'; " : "") . "
	            
 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
 						saSuccess(\"El movimiento se ha realizado de manera correcta.\");
	            
 					    ");
	    }
	    else
	    {
	        $inv->transaccionRollback();
	        $r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("darSalidaAInventarioFromStockNoRolloLaminaYScrap");

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
