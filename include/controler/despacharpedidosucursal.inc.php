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

	require_once FOLDER_MODEL. "model.inventariosucursal.inc.php";
	require_once FOLDER_MODEL. "model.registroproduccion.inc.php";
	require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";
	require_once FOLDER_MODEL. "model.pesomt.inc.php";

	

	





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

		global $objSession;

		

		$idSucursal = $objSession->getIdSucursal();

		

        $idProductoMoldura = 386;

        $idProductoMaquilaMoldura = 394;

		$pedido = new ModeloPedido();



		$pedido->getPedidoParaSurtir($idPedido, $idSucursal	);



		if ($pedido->getPedidoDato("idPedido") <= 0)

		{

			$r->saError("No se ha encontrado un Pedido con el folio indicado. Verifique que el Pedido ya ha sido asignado.");

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



		$r->script("app.pedidoRecogeEntrega = '".$pedido->getPedidoDato("recogeentrega")."';");





		$pedidoDetalle = "";



		foreach ($pedido->__rsPedidoWDetalle as $row)

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

// 					$desc = mb_convert_encoding($desc, 'ISO-8859-1', 'UTF-8');



// 			$pedidoDetalle .= "this.pedidoDetalle.push({

// 								idPedidoDetalle: ".mb_convert_encoding($row["idPedidoDetalle"], 'ISO-8859-1', 'UTF-8').",

// 								codigo: \"".mb_convert_encoding($row["proCodigo"], 'ISO-8859-1', 'UTF-8')."\",

// 								fullName: \"".$desc."\",

// 								partida: ".mb_convert_encoding($row["detPartida"], 'ISO-8859-1', 'UTF-8').",

// 								listoDespachar: \"".mb_convert_encoding($row["listo_para_producir"], 'ISO-8859-1', 'UTF-8')."\",

// 								despachado: \"".mb_convert_encoding($row["despachado"], 'ISO-8859-1', 'UTF-8')."\"

// 							});";



					$pedidoDetalle .= "app.pedidoDetalle.push({

								idPedidoDetalle: ".mb_convert_encoding($row["idPedidoDetalle"], 'ISO-8859-1', 'UTF-8').",

                                idProducto: ".$row["detIdProducto"].",

                                idrollo: ".$row["proIdRollo"].",

								codigo: \"".mb_convert_encoding($row["proCodigo"], 'ISO-8859-1', 'UTF-8')."\",

								shortTipoProducto: \"".mb_convert_encoding($row["proShortTipoProducto"], 'ISO-8859-1', 'UTF-8')."\",

								fullName: \"".$desc."\",

								unidad: \"".mb_convert_encoding($row["proUnidad"], 'ISO-8859-1', 'UTF-8')."\",

								shortUnidad: \"".mb_convert_encoding($row["proShortUnidad"], 'ISO-8859-1', 'UTF-8')."\",

								partida: ".mb_convert_encoding($row["detPartida"], 'ISO-8859-1', 'UTF-8').",

                                ml: ".mb_convert_encoding($row["detCantidadReal"], 'ISO-8859-1', 'UTF-8').",    

								listoDespachar: \"".mb_convert_encoding($row["listo_para_producir"], 'ISO-8859-1', 'UTF-8')."\",

								despachado: \"".mb_convert_encoding($row["despachado"], 'ISO-8859-1', 'UTF-8')."\",

								despachando: false,

                                idSucursal: ".$row["idSucursal"].",

                                isParcial: '".$row["detIsParcial"]."', 

                                sucursalNombre: '".$row["sucursalNombre"]."',

                                colocaCantidad: ".$row["colocaCantidad"]."

							});";



		}



		$r->script(" app.pedidoProduccion = true; app.pedidoDetalle.splice(0, app.pedidoDetalle.length); " . $pedidoDetalle);



		return $r;

	}

	$xajax->registerFunction("cargarPedido");



	function cargarPedidoDetalle($idPedidoDetalle, $idSucursal, $cerrarsa = true, $isRPUsandoStock = false)

	{

		$r = new xajaxResponse();

		// $r->starDebug();

		$idProductoMoldura = 386;

		$idProductoMaquilaMoldura = 394;



		$pedido = new ModeloPedido();



// 		$moldura = " app.molIdProductoLisa = 22;

//                      app.molCodigoLisa = 'Code';

// 		             app.molDescripcionLisa = 'Desc';            



//                 ";

        $moldura = "";

        

        

        

        $row = $pedido->getPedidoDetalleSucursal($idPedidoDetalle, $idSucursal, $isRPUsandoStock);

        

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

		

		$_molIdProducto = 0;

		$_molExistencia = 0;

		$_molApartado = 0;
		
		
		
		
		if ($row["detIdProducto"] == $idProductoMoldura)

		{

		    $mol = new ModeloViewproductos();

		    if($row['detCantidadReal'] < 3.06 ){

		    $mollisa = $mol->getAll("idproducto, codigo, descauto",

		                            "",

		                            "idrollo = ".$row["molIdRollo"]." and idaplicacion = 2 and estado = 'ACTIVO' and idUnidad = 4",

		                            "");
		    }else{
		    	$mollisa = $mol->getAll("idproducto, codigo, descauto",
		    	
		    			"",
		    	
		    			"idrollo = ".$row["molIdRollo"]." and idaplicacion = 2 and estado = 'ACTIVO' and idUnidad = 4 AND longitud > 3.05" ,
		    	
		    			"");
		    	
		    }

		    

		    if (count($mollisa) > 0)

		    {	        

		        

		        $moldura = " app.molIdProductoLisa = ".$mollisa[0]["idProducto"].";

                             app.molCodigoLisa = '".$mollisa[0] ["codigo"]."';

	       	                 app.molDescripcionLisa = '".$mollisa[0]["descauto"]."';

		            

                    ";

		        

		        

		        $_inventarioMol = new ModeloInventariosucursal();

		        $_inventarioMol->getDatosProductoSucursal($mollisa[0]["idProducto"], $idSucursal);

		        

		        if ($_inventarioMol->getIdProducto() > 0)

		        {

		            $_molIdProducto = $_inventarioMol->getIdProducto() ;

		            $_molExistencia = $_inventarioMol->getExistencia() ;

		            $_molApartado = $_inventarioMol->getApartado() ;

		        }

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

		        $desc = $row["detPartida"]." MAQUILA DE MOLDURA " . $row["molDescMaquila"] . " " . $row["rolloMolduraDesc"];

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

		
		
		

		if (!$isRPUsandoStock)
		{
			
			if ($row["proShortUnidad"] != "PZA" && $row["detIdProducto"] != $idProductoMoldura)
	
			{
	
				//si entramos aqui es porque hay que sacar de rollo
	
				$inv = new ModeloInvzmovrollo(); 
	
				$lstInvRollo = $inv->getAll("fecha_movimiento, remisionrollo.norollo, cantidad, observaciones",
	
											"inner join remisionrollo on remisionrollo.idremisionrollo = invzmovrollo.idremisionrollo", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' ");
	
	
	
				
	
	// 			$r->mostrarAviso($inv->getAllQUERY("fecha_movimiento, cantidad", "", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' "));
	
	// 			return $r;
	
	
	
	// 			$r->mostrarAviso("bien bien"); return $r;
	
				
	
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
	
						"left join remisionrollo on remisionrollo.idremisionrollo = invzmov.idremisionrollo", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' AND idSucursal = " . $idSucursal);
	
	
	
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
		}


				

		$r->script($moldura. "

		app.detIdProducto = ".$row["detIdProducto"].";
		app.idPedidoDetalle = ".$row["idPedidoDetalle"].";
		app.proCodigo = '".$row["proCodigo"]."';
		app.proFullname = '".$desc."';
		app.proTipoProducto = '".$row["proTipoProducto"]."';
		app.proAplicacion = '".$row["proAplicacion"]."';
		app.proMaterial = '".$row["proMaterial"]."';
		app.proIdTipoProducto = ".$row["proIdTipoProducto"].";
		app.proIdUnidad = ".$row["proIdUnidad"].";
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
		app.proLongitud = '".$row["proLongitud"]."';


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



		app.idSucursal = ".$row["idSucursal"].";

		app.sucursalNombre = '".$row["sucursalNombre"]."';

		app.sucursalExistencia = ".($_molIdProducto > 0 ? $_molExistencia : $row["sucursalExistencia"]).";

		app.sucursalApartado = ". ($_molIdProducto > 0 ? $_molApartado : $row["sucursalApartado"]).";

		app.sucursalCantidadSacar = 0;

		app.colocaCantidad = ".$row["colocaCantidad"].";

		app.colocaCantidadSurtida = ".$row["colocaCantidadSurtida"].";

		app.isParcial = '".$row["isParcial"]."';



		".($cerrarsa ? "swal.close();" : "")."



				");

				// $r->mostrarAviso("bien ". __LINE__); return $r;	

        // $r->endDegug();

		return $r;

	}

	$xajax->registerFunction("cargarPedidoDetalle");



	function darSalidaAInventario($idPedidoDetalle, $idProducto, $idPedido, $cantidad, $idSucursal)

	{

		$r = new xajaxResponse();

		$producto = new ModeloProducto();



		$producto->setIdProducto($idProducto);



		if ($producto->getIdProducto() <= 0)

		{

			$r->script("saError(\"No se pudo obtener informaci�n del Producto.\");");

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

 		$inv->setIdSucursal($idSucursal);



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

 					    

 						setTimeout(function() {alert('antes de recargar detalle');xajax_cargarPedidoDetalle(".$idPedidoDetalle.", ".$idSucursal.", false);}, 10);

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

			$r->script("saError(\"No se pudo obtener informaci�n del Rollo.\");");

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

			$r->script("saError(\"No se pudo obtener informaci�n del Stock de No Rollo.\");");

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



	function darSalidaARollo($idRollo,$idRemisionRollo, $cantidad, $idPedidoDetalle, $idPedido, $idSucursal)

	{

		$r = new xajaxResponse();



		$remisionRollo = new ModeloRemisionrollo();



		$remisionRollo->setIdRemisionRollo($idRemisionRollo);



		if ($remisionRollo->getIdRemisionRollo() <= 0)

		{

			$r->script("saError(\"No se pudo obtener informaci�n del Rollo.\");");

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

		$inv->setIdSucursal($idSucursal);

		



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

 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", ".$idSucursal.",false);}, 10);

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



	function marcarComoDespachado($idPedidoDetalle, $idSucursal)

	{

		$r = new xajaxResponse();

		$errores = "";

		$pedidoDetalle = new ModeloPedidodetalle();



		$pedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);



		if ($pedidoDetalle->getIdPedidoDetalle() <= 0)

		{

			$r->script("saError(\"No se pudo obtener informaci�n del Detalle de Pedido.\");");

			return $r;

		}



		$pedidoDetalle->setDespachadoSI();

		$pedidoDetalle->setIdSucursalDespachado($idSucursal);

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

	

	function marcarMaquilaRealizada($idPedidoDetalle, $idSucursal)

	{

	    $r = new xajaxResponse();

	    $errores = "";

	    $pedidoDetalle = new ModeloPedidodetalle();

	    

	    $pedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);

	    

	    if ($pedidoDetalle->getIdPedidoDetalle() <= 0)

	    {

	        $r->script("saError(\"No se pudo obtener informaci�n del Detalle de Pedido.\");");

	        return $r;

	    }

	    

	    $pedidoDetalle->setIdSucursalDespachado($idSucursal);

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



	function darSalidaAInventarioFromStockNoRollo($idPedidoDetalle, $idProducto, $idPedido, $cantidad, $idRemisionRollo, $proIdTipoProducto, $proIdUnidad, $proIdRollo, $detCantidadReal, $idSucursal)

	{

		$r = new xajaxResponse();



		$producto = new ModeloProducto();



		$producto->setIdProducto($idProducto);



		if ($producto->getIdProducto() <= 0)

		{

			$r->script("saError(\"No se pudo obtener informaci�n del Producto.\");");

			return $r;

		}



		if ($producto->getExistencia() < $cantidad)

		{

			$r->script("saError(\"No se puede descontar de Inventario, no hay Existencia suficiente para realizarlo. Existencia: " . $producto->getExistencia() . " A surtir: ". $cantidad ." \");");

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

		if ($proIdTipoProducto == 1 && $proIdRollo == 1 && $proIdUnidad == 1)

		{

		    $inv->setCantidad($cantidad * $detCantidadReal);

// 		    $inv->setCantidad($cantidad);

		}

		else

		{

		    $inv->setCantidad($cantidad);

		}

		

		$inv->setObservaciones("Despacho de pedido");

		$inv->setIdPedidoDetalle($idPedidoDetalle);

		$inv->setDateAndUser("movimiento");

		$inv->setIdRemisionRollo($idRemisionRollo);

		$inv->setIdSucursal($idSucursal);



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

				    $pd->setIdSucursalDespachado($idSucursal);

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

 					    

 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", ".$idSucursal." , false);}, 10);

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

	

	

	function darSalidaAInventarioFromStockNoRolloScrap($idPedidoDetalle, $idPedido, $cantidad, $idSucursal)

	{

	    $r = new xajaxResponse();

	    $idProductoMoldura = 386;

	    

// 	    $producto = new ModeloProducto();

	    

// 	    $producto->setIdProducto($idProducto);

	    

// 	    if ($producto->getIdProducto() <= 0)

// 	    {

// 	        $r->script("saError(\"No se pudo obtener informaci�n del Producto.\");");

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

	    $inv->setIdSucursal($idSucursal);

	    

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

	                $pd->setIdSucursalDespachado($idSucursal);

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

	            

 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", ".$idSucursal." , false);}, 10);

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

	

	function darSalidaAInventarioFromStockNoRolloLaminaYScrap($idPedidoDetalle, $idProducto, $idPedido, $cantidad, $idRemisionRollo, $noMolduras, $idSucursal)

	{

	    $r = new xajaxResponse();

	    $idProductoMoldura = 386;

	    

	    $producto = new ModeloProducto();

	    

	    $producto->setIdProducto($idProducto);

	    

	    if ($producto->getIdProducto() <= 0)

	    {

	        $r->script("saError(\"No se pudo obtener informaci�n del Producto.\");");

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

	    $inv->setObservaciones(mb_convert_encoding("L�minas tomadas para desarrollar ".$noMolduras." Molduras", 'UTF-8', 'ISO-8859-1');

	    $inv->setIdPedidoDetalle($idPedidoDetalle);

	    $inv->setDateAndUser("movimiento");

	    $inv->setIdRemisionRollo($idRemisionRollo);

	    $inv->setIdSucursal($idSucursal);

	    

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

	        $invMol->setObservaciones(mb_convert_encoding("Surtido de Pedido Molduras (de Lámina, 'UTF-8', 'ISO-8859-1')"));

	        $invMol->setIdPedidoDetalle($idPedidoDetalle);

	        $invMol->setDateAndUser("movimiento");

	        $invMol->setIdRemisionRollo(0);

	        $invMol->setIdSucursal($idSucursal);

	        

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

	                    $pd->setIdSucursalDespachado($idSucursal);

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

	            

 						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", ".$idSucursal.", false);}, 10);

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


	function cargarRegistrosProduccion($idRollo)

	{

		$r = new xajaxResponse();
		// $r->starDebug();

		
		$remisionRollo = new ModeloRemisionrollo();

		// $sql = "
		// 		SELECT rp.idRegistroProduccion, rp.idRemisionRollo, rr.noRollo, rp.kilos, rp.kilosMaquilados, rp.terminado,
		// 			rr.almacen, if(rr.almacen = 'DELTA', 2, if(rr.almacen = 'OBRA', 0, 1)) idSucursal
		// 		FROM registroproduccion rp
		// 		INNER JOIN remisionrollo rr	
		// 		ON rr.idRemisionRollo = rp.idRemisionRollo
		// 		INNER JOIN rollo r
		// 		ON r.idRollo = rr.remisionRollo_rollo_idRollo
		// 		AND rp.terminado = 'NO'
		// 		AND r.idRollo = ".$idRollo."
		// 		AND rr.estado <> 'BAJA'";

		$sql = "
		SELECT DISTINCT rp.idRegistroProduccion, rp.idRemisionRollo, r.idRollo, r.codigo, rr.noRollo, rp.kilos, rp.kilosMaquilados, rp.terminado,
				rr.almacen, if(rr.almacen = 'LAGOS', 3, if(rr.almacen = 'DELTA', 2, if(rr.almacen = 'OBRA', 0, 1))) idSucursal
		FROM registroproduccion rp
		INNER JOIN remisionrollo rr	
		ON rr.idRemisionRollo = rp.idRemisionRollo
		INNER JOIN rollo rgetcal
		ON rgetcal.idRollo = ".$idRollo."
		INNER JOIN rollo r
		ON  r.rollo_material_idMaterial = rgetcal.rollo_material_idMaterial 
		AND r.pies = rgetcal.pies
		AND r.rollo_proveedor_idProveedor = rgetcal.rollo_proveedor_idProveedor
		AND r.grado = rgetcal.grado
		AND r.estado = 'ACTIVO'
		AND r.rollo_color_idColor = rgetcal.rollo_color_idColor
		AND rp.terminado = 'NO'
		AND rr.estado <> 'BAJA' 
		ORDER BY r.codigo";

		// $r->mostrarAviso($sql);	 return $r;

		$lst = $remisionRollo->getDataSet($sql);

		// $r->mostrarAviso(count($lst));	 return $r;

		
		$pushes = "";
		foreach ($lst as $row)
		{
			$pushes .= "
				app.rpRegistrosDeProduccion.push({
						idRegistroProduccion: ".$row["idRegistroProduccion"].",
						idRollo: ".$row["idRollo"].",
						rollo: '".$row["codigo"]."',								
						rpIdRemisionRollo: ".$row["idRemisionRollo"].",
						noRollo: '".$row["noRollo"]."',
						kilos: ".$row["kilos"].",
						kilosMaquilados: ".$row["kilosMaquilados"].",
						terminado: '".$row["terminado"]."',
						almacen: '".$row["almacen"]."',
						idSucursal: ".$row["idSucursal"]." 
					});
			
			";
		}

		// $r->mostrarAviso($pushes); return $r;

		$r->script("
				app.rpRegistrosDeProduccion.splice (0, app.rpRegistrosDeProduccion.length); " . $pushes ."
					

				");



		// $r->endDegug();

		return $r;

	}

	$xajax->registerFunction("cargarRegistrosProduccion");

	function cargarDetalleRegistroProduccion($idRegistroProduccion)
	{
		$r = new xajaxResponse();
	
		if($idRegistroProduccion <= 0)
		{
			$r->saError("No se ha especificado datos para cargar la informaci�n del Registro de Producci�n.");
			return $r;
		}
		
		$rp = new ModeloRegistroproduccion();
		
		$rp->setIdRegistroProduccion($idRegistroProduccion);
		
		
		
		if ($rp->getIdRegistroProduccion() <= 0)
		{
			$r->saError("No se ha especificado datos para cargar la informaci�n del Registro de Producci�n.");
			return $r;
		}
		

		
		$rpd = new ModeloRegistroproducciondetalle();
		
		$lst = $rpd->getAll(" idregistroproduccion, idregistroproducciondetalle, registroproducciondetalle.tipo, ifnull(pedido.idpedido, registroproducciondetalle.tipo) as nopedido , ifnull(concat(nombre, ' ', apellidos), 
								if(registroproducciondetalle.tipo = 'STOCK', 'GALVAMEX', 'PYC')) as nombrecliente, registroproducciondetalle.partida, longitud, 
								(registroproducciondetalle.partida * longitud) as totalml, totalkg ",
				            " left join pedidodetalle on pedidodetalle.idpedidodetalle = registroproducciondetalle.idpedidodetalle
							 left join pedido on pedido.idpedido = pedidodetalle.idpedido
							 left join cliente on cliente.idcliente = pedido.idcliente ",
				            " idregistroproduccion = " . $idRegistroProduccion,
				            " idregistroproducciondetalle");
		

		$pushes = "";
		foreach ($lst as $row)
		{
			$pushes .= "
					   app.rpRegistroProduccionDetalle.push({
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

		$lst = $rp->getAll("idregistroproduccion, rollo.calibre, rollo.pies ",
				" inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
                  inner join rollo on remisionRollo_rollo_idRollo = idRollo",
				" registroproduccion.idRegistroProduccion = ".$idRegistroProduccion, "");
		
		
		if (count($lst)>0)
		{
			$calibre = $lst[0]["calibre"];
			$pies = $lst[0]["pies"];
			
			
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
				
                $r->script(" app.rpPesoEstimadoXKiloRolloSeleccionado = ".$pesoXCalibre.";"); 
			}
		}
		
		
		
		$r->script("
				    
					app.rpRegistroProduccionDetalle.splice(0, app.rpRegistroProduccionDetalle.length);
				
				" . $pushes);
		
	
		return $r;
	}
	$xajax->registerFunction("cargarDetalleRegistroProduccion");

	function registrarRPPedido($idRollo, $idRemisionRollo, $idRegistroProduccion, $idPedidoDetalle, $idProducto, $piezas, $ml, $kgml, $totalkg, $idPedidoDetalleColocacion, $idSucursal, $noMolduras, $isMoldura = false)
	{
	    $r = new xajaxResponse();
// 	    $r->starDebug();
		// $r->mostrarAviso($ml); return;

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
	        
			if (!$isMoldura) $pd->setPartidaDespachada($pd->getPartidaDespachada() + $piezas);	
	        
	        if ($isMoldura) $pd->setMlDespachado($pd->getMlDespachado() + ($ml*$piezas));
	        // 			$r->mostrarAviso("despues de setPartidaDespachada");
	        $pd->setIdSucursalDespachado($idSucursal);
	        // 			$r->mostrarAviso("despues de set idsucursaldespachado"); return $r;
	        
	        // if ($pd->getPartidaDespachada() >= $pd->getPartida())
	        // {
	        //     $pd->setDespachadoSI();
	        //     $pd->setDateAndUser("despachado");
	        // }
	        
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
				if ($isMoldura)
				{
					$inv->setIsRPParaMolduraSI();
				}
				else
				{
					$inv->setDescontarDePiezasSI();
				}
	            $inv->setReferencia($pd->getIdPedido());
	            $inv->setMovimientoSALIDA();
	            $inv->setSalidaDespachoSI();
	            $inv->setCantidad($totalkg);
	            $inv->setObservaciones("Registro de Produccion a Medida");
	            $inv->setIdPedidoDetalle($idPedidoDetalle);
	            $inv->setDateAndUser("movimiento");
	            $inv->setIdRegistroProduccion($idRegistroProduccion);
	            $inv->setIdRegistroProduccionDetalle($rpd->getIdRegistroProduccionDetalle());
	            $inv->setIdSucursal($idSucursal);
				// $inv->setPiezas($ml);
				$inv->setPiezas($piezas);
				
	            
	            				// $r->mostrarAviso("todo bien antes de guardar invzmovrollo"); return $r;
	            $inv->Guardar();
	            
	            if (!$inv->getError())
	            {
					if ($isMoldura)
					{

					
						$invMol = new ModeloInvzmov();
			
						$idProductoMoldura = 386;

						$invMol->setIdProducto($idProductoMoldura);
						$invMol->setDocumentoPEDIDO();
						$invMol->setReferencia($pd->getIdPedido());
						$invMol->setMovimientoSALIDA();
						$invMol->setSalidaDespachoSI();
						$invMol->setCantidad($noMolduras);
						$invMol->setObservaciones(mb_convert_encoding("Surtido de Pedido Molduras (de Lámina, 'UTF-8', 'ISO-8859-1')"));
						$invMol->setIdPedidoDetalle($idPedidoDetalle);
						$invMol->setDateAndUser("movimiento");
						$invMol->setIdRemisionRollo(0);
						$invMol->setIdSucursal($idSucursal);					

						$invMol->Guardar();
					}
	            }
	            else
	            {
	                $blnDoCommit = false;
	                $strErrores .= $inv->getStrError() . ".";
	            }
	            
	            
				//Obtenemos el pedidodetalle de nuevo, para marcarlo como surtido si aplica
				$pd = new ModeloPedidodetalle();

		        $pd->setIdPedidoDetalle($idPedidoDetalle);
				
	        	$pd->setIdSucursalDespachado($idSucursal);
	        	        
				if ($pd->getPartidaDespachada() >= $pd->getPartida())
				{
					$pd->setDespachadoSI();
					$pd->setDateAndUser("despachado");
				}
	        
	        
		        $pd->Guardar();
	        
	        
				if ($pd->getError())
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
	        $r->script(" mdlExitWait();  setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", ".$idSucursal." , false);}, 10);  setTimeout(function () { app.seleccionarRegistroProduccion(app.rpIdRegistroProduccion, app.rpIdRemisionRollo, app.rpIndex);}, 1000); ");
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

