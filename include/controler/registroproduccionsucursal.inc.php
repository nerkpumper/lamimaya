<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
	require_once FOLDER_MODEL. "model.registroproduccion.inc.php";
	require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";
	require_once FOLDER_MODEL. "model.configuracion.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	require_once FOLDER_MODEL. "model.invzmovrollo.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
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
	
// ob_start();	
// 	echo "hola mundito";
//$debug = ob_get_clean();
//$r->mostrarMsgs($debug);

	function cargarNoRemisiones($noRollo)
	{
		$r = new xajaxResponse();
		
		global $objSession;
		
		$idSucursal = $objSession->getIdSucursal();
// 		$idSucursal = 2;
		
		$remisionRollo = new ModeloRemisionrollo();
		
		$lst = $remisionRollo->getAll("idRemisionRollo, noRollo, fecha, remision, almacen, kilos, remisionrollo.existencia, idRollo, codigo, descauto as descripcion ", 
				                           "INNER JOIN viewrollos as rollo ON rollo.idRollo = remisionRollo_rollo_idRollo", 
				                           "noRollo = '".$noRollo."'", "idRollo");
		
		
// 		idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos
		$idRolloAnterior = 0;
		$idRolloActual = 0;
		$indexRollo = -1;
		$pushes = "";
		
		$idSucursalRollo = 0;
		
		if (count($lst)>0)
		{
			foreach ($lst as $row)
			{
				$idRolloActual = $row["idRollo"];
					
				if ($idRolloActual != $idRolloAnterior)
				{
					$pushes .= "app.rollos.push({idRollo: ".$row["idRollo"].", codigo: '".$row["codigo"]."', descripcion: '".$row["descripcion"]."', noRollos: []});";
					$idRolloAnterior = $idRolloActual;
					$indexRollo++;
				}
				
				if ($row["almacen"] == "LAGOS")
				{
					$idSucursalRollo = 3;
				}
				else
				{
					if ($row["almacen"] == "DELTA")
					{
						$idSucursalRollo = 2;
					}
					else
					{
						$idSucursalRollo = 1;
					}

				}
					
				$pushes .= "app.rollos[".$indexRollo."].noRollos.push({ idRemisionRollo: ".$row["idRemisionRollo"].", noRollo: '".$row["noRollo"]."', fecha: '".$row["fecha"]."', remision: '".$row["remision"]."', almacen: '".$row["almacen"]."', kilos: '".$row["kilos"]."', disponible: '".$row["existencia"]."', 
						  puedeSeleccionar: '".( $idSucursal == 0 ? 'SI' : ($idSucursal == $idSucursalRollo ? 'SI' : 'NO') )."', idSucursal: ".$idSucursalRollo." });";
				
			}
			
			$r->script(" app.rollos.splice(0, app.rollos.length); ".$pushes);
		}
		else
		{

			$r->script("app.msgError = '".utf8_encode("No se encontró información del Numero de Rollo solicitado.") ."';");

		}
		
		//$r->mostrarAviso(" app.rollos.splice(0, app.rollos.length); ".$pushes);
		
	
		return $r;
	}
	$xajax->registerFunction("cargarNoRemisiones");
	
	
	function cargarRegistrosProduccionTerminados($idRemisionRollo)
	{
		$r = new xajaxResponse();
	
		$rp = new ModeloRegistroproduccion();
	
		$lst = $rp->getAll("idregistroproduccion, idremisionrollo, consecutivonorollo, kilos, kilosmaquilados, totalml, fecha_creacion, fecha_termina ",
				"",
				"idremisionrollo = '".$idRemisionRollo."'  AND  terminado = 'SI'", " consecutivonorollo");
	
		// 		idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos
		$pushes = "";
		foreach ($lst as $row)
		{
			$pushes .= "app.registrosProduccion.push({
		        	idRegistroProduccion: ".$row["idregistroproduccion"].",
		        	idRemisionRollo: ".$row["idremisionrollo"].",
		        	consecutivoNoRollo: ".$row["consecutivonorollo"].",
		        	kilos: '".$row["kilos"]."',
		        	kilosMaquilados: '".$row["kilosmaquilados"]."',
		        	totalML: '".$row["totalml"]."',
		        	fechaCreacion: '". clsUtilerias::formatoFecha($row["fecha_creacion"])."',
					fechaTermino: '". clsUtilerias::formatoFecha($row["fecha_termina"])."'
        		});";
		}
		
		$r->script("app.registroProduccionDetalle.splice(0, app.registroProduccionDetalle.length); app.registrosProduccion.splice(0, app.registrosProduccion.length); " . $pushes);
		
		$lst = $rp->getAll("idregistroproduccion, registroproduccion.idremisionrollo, consecutivonorollo, registroproduccion.kilos, kilosmaquilados, totalml, registroproduccion.fecha_creacion, fecha_termina, rollo.calibre, rollo.pies,registroproduccion.espesor ",
				" inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
                  inner join rollo on remisionRollo_rollo_idRollo = idRollo",
				" registroproduccion.idremisionrollo = '".$idRemisionRollo."' AND  terminado = 'NO'", " consecutivonorollo");
		
		if (count($lst)>0)
		{
			$calibre = $lst[0]["calibre"];
			$pies = $lst[0]["pies"];
			$espesor = $lst[0]["espesor"];
			
			$r->script(" app.idRegistroProduccion = " . $lst[0]["idregistroproduccion"]."; 
						 app.calibreRolloSeleccionado = " . $calibre .";
						 app.espesor = " . $espesor .";
					     app.cargarDatosRegistroProduccionAbierto();");
			
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
				
                $r->script(" app.pesoEstimadoXKiloRolloSeleccionado = ".$pesoXCalibre.";"); 
			}
		}
		else
		{
			$rm = new ModeloRemisionrollo();
			$rm->setIdRemisionRollo($idRemisionRollo);
			
			$r->script("app.showBotonCrearRegistroProduccion = true; app.kilosNoRolloSeleccionado = ".$rm->getExistencia().";");
		}
			
	
		return $r;
	}
	$xajax->registerFunction("cargarRegistrosProduccionTerminados");

	
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
			$r->saInfo("El Número de Rollo no cuenta con existencia para generar el Registro de Producci�n");
			return $r;
		}
	
		$rp->setIdRemisionRollo($idRemisionRollo);
		$rp->setDateAndUser("creacion");
		
		$rp->Guardar();
		
		if (!$rp->getError())
		{
			$r->script("
					 saSuccess(\"".utf8_encode("Se ha generado el Registro de Producción exitosamente")."\");

					 app.idRegistroProduccion = ".$rp->getIdRegistroProduccion().";
					
					 xajax_cargarRegistrosProduccionTerminados(app.idRemisionRolloSeleccionado);
					");
		}			
		else
		{
			$r->script("
					saError(\"".utf8_encode("Ha ocurrido un error. " . $rp->getStrError())."\");
					");
		}
	
		return $r;
	}
	$xajax->registerFunction("crearRegistroProduccion");
	
	
	function cargarDatosRegistroProduccionAbierto($idRegistroProduccion)
	{
		$r = new xajaxResponse();
	
		if($idRegistroProduccion <= 0)
		{

			$r->saError("No se ha especificado datos para cargar la información del Registro de Producción.");
		
			return $r;
		}
		
		$rp = new ModeloRegistroproduccion();
		
		$rp->setIdRegistroProduccion($idRegistroProduccion);
		
		
		
		if ($rp->getIdRegistroProduccion() <= 0)
		{
			$r->saError("No se ha especificado datos para cargar la informaci�n del Registro de Producci�n.");
			return $r;
		}
		

		// 		rpKilosRollo: 0,
		// 		rpKilosMaquilados: 0,
		// 		rpTotalML: 0,
		$r->script("
				
					app.rpKilosRollo = ".$rp->getKilos().";
 					app.rpKilosMaquilados = ".$rp->getKilosMaquilados().";
					app.rpTotalML = ".$rp->getTotalml().";
				
				");
		
		$rpd = new ModeloRegistroproducciondetalle();
		
		$lst = $rpd->getAll(" idregistroproduccion, idregistroproducciondetalle, registroproducciondetalle.tipo, ifnull(pedido.idpedido, registroproducciondetalle.tipo) as nopedido , ifnull(concat(nombre, ' ', apellidos), 
								if(registroproducciondetalle.tipo = 'STOCK', 'GALVAMEX', 'PYC')) as nombrecliente, registroproducciondetalle.partida, longitud, 
								(registroproducciondetalle.partida * longitud) as totalml, totalkg ",
				            " left join pedidodetalle on pedidodetalle.idpedidodetalle = registroproducciondetalle.idpedidodetalle
							 left join pedido on pedido.idpedido = pedidodetalle.idpedido
							 left join cliente on cliente.idcliente = pedido.idcliente ",
				            " idregistroproduccion = " . $idRegistroProduccion,
				            " idregistroproducciondetalle");
		
// 		$r->mostrarAviso($rpd->getAllQUERY(" idregistroproduccion, idregistroproducciondetalle, tipo, ifnull(pedido.idpedido, tipo) as nopedido , 
// 				                  ifnull(concat(nombre, ' ', apellidos), if(tipo = 'STOCK', 'GALVAMEX', 'PYC')) as nombrecliente, 
// 				                  registroproducciondetalle.partida, longitud, (registroproducciondetalle.partida * longitud) as totalml, totalkg",
// 				            " left join pedidodetalle on pedidodetalle.idpedidodetalle = registroproducciondetalle.idpedidodetalle
// 							 left join pedido on pedido.idpedido = pedidodetalle.idpedido
// 							 left join cliente on cliente.idcliente = pedido.idcliente ",
// 				            " idregistroproduccion = " . $idRegistroProduccion,
// 				            " idregistroproducciondetalle"));
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
		
	
	function registrarRPStock($idRollo, $idRemisionRollo, $idRegistroProduccion, $idProducto, $piezas, $ml, $kgml, $totalkg, $idSucursal)
	{
		$r = new xajaxResponse();
	
		$rpd = new ModeloRegistroproducciondetalle();
		
		if ($totalkg <= 0)
		{
			$r->saError("El total de kg del registro debe ser mayor a cero.");
			return $r;
		}
		
		$blnDoCommit = true;
		$strErrores ="";
		
		$rpd->transaccionIniciar();
		$rpd->setIdRegistroProduccion($idRegistroProduccion);
		$rpd->setIdProducto($idProducto);
		$rpd->setTipoSTOCK();
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
			$inv->setObservaciones(utf8_encode("REGISTRO DE PRODUCCI�N"));
			$inv->setIdPedidoDetalle(0);
			$inv->setDateAndUser("movimiento");
			$inv->setIdRegistroProduccion($idRegistroProduccion);
			$inv->setIdRegistroProduccionDetalle($rpd->getIdRegistroProduccionDetalle());
			$inv->setIdSucursal($idSucursal);
			$inv->setPiezas($piezas);
			
			$inv->Guardar();
				
			if (!$inv->getError())
			{
 				$invProducto = new ModeloInvzmov();
 				
 				$invProducto->setIdProducto($idProducto);
 				$invProducto->setDocumentoREGISTROPRODUCCION();
 				$invProducto->setReferencia($idRegistroProduccion);
 				$invProducto->setMovimientoENTRADA();
 				$invProducto->setSalidaDespachoNO();
 				$invProducto->setCantidad($piezas);
 				$invProducto->setObservaciones(utf8_encode("INGRESO A STOCK POR REGISTRO DE PRODUCCI�N"));
 				$invProducto->setDateAndUser("movimiento");
 				$invProducto->setIdPedidoDetalle(0);
 				$invProducto->setIdRemisionRollo($idRemisionRollo);
 				$invProducto->setIdSucursal($idSucursal);
 				
				
				
			
 				$invProducto->Guardar();
				
				if (!$invProducto->getError())
 				{
				
 				}
 				else
 				{
 					$blnDoCommit = false;
 					$strErrores .= $invProducto->getStrError() . ".";
 				}				
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
		{
			$rpd->transaccionCommit();
			$r->script("app.cancelarIngresoRegistro(); xajax_cargarDatosRegistroProduccionAbierto(app.idRegistroProduccion);");
			$r->saSuccess("Se ha registrado la producci�n satisfactoriamente.");
			$r->saClose(2);
		}
		else
		{
			$rpd->transaccionRollback();
			$r->saError("Ha ocurrido un error. " . $strErrores );
			$r->script(" app.showButtonRegistrarRPStock = true;");
		}
		
	
		return $r;
	}
	$xajax->registerFunction("registrarRPStock");
	
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
			$r->script("app.cancelarIngresoRegistro(); xajax_cargarDatosRegistroProduccionAbierto(app.idRegistroProduccion);");
			$r->saSuccess("Se ha registrado la producci�n satisfactoriamente.");
			$r->saClose(2);
		}
		else
		{
			$rpd->transaccionRollback();
			$r->saError("Ha ocurrido un error. " . $strErrores );
			$r->script(" app.showButtonRegistrarRPSPyc = true;");
		}
		
		
	
	
		return $r;
	}
	$xajax->registerFunction("registrarRPPyc");
	
	// para el pedido -------------------------------------------------------------------------
	
	
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

			$porSurtir = $row["colocaCantidad"] - $row["colocaCantidadSurtida"] ;		
			
			$pushes .= "
					app.pedidoPedidoDetalle.push({
							idPedidoDetalle: ".$row["idPedidoDetalle"].",
							proCodigo: '".$row["proCodigo"]."',
							proDescripcion: '".$row["proDescripcion"]."',
							proIdRollo: ".$row["proIdRollo"].",
							shortUnidad: '".$row["shortUnidad"]."',
							partida: ".$row["colocaCantidad"].",
							cantidad: ".$row["cantidad"].",
							cantidadReal: ".$row["cantidadReal"].",
							explotarUnidad: ".$row["explotarUnidad"].",
							partidaDespachada: ".$row["colocaCantidadSurtida"].",
							despachado: '".($porSurtir > 0 ? "NO" : "SI")."',
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
				
				app.pedidoCliente = \"". utf8_encode($pedido->getPedidoDato("cteNombre") . " " . $pedido->getPedidoDato("cteApellidos")) ."\";
				
				app.pedidoPedidoDetalle.splice(0, app.pedidoPedidoDetalle.length);
				
				".$pushes."
				
				
				");

		
		return $r;
	}
	$xajax->registerFunction("cargarDatosPedido");
	
	function registrarRPPedido($idRollo, $idRemisionRollo, $idRegistroProduccion, $idPedidoDetalle, $piezas, $ml, $kgml, $totalkg, $idPedidoDetalleColocacion, $idSucursal)
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
		$rpd->setTipoPEDIDO();
		$rpd->setIdPedidoDetalle($idPedidoDetalle);
		$rpd->setPartida($piezas);
		$rpd->setLongitud($ml);
		$rpd->setKgml($kgml);
		$rpd->setTotalKg($totalkg);
		$rpd->setTotalReal(0);
		$rpd->setDateAndUser("captura");
		$rpd->setIdSucursal($idSucursal);
	   
// 		$r->mostrarAviso("todo bien antes de guardar rpd"); 
	   
		$rpd->Guardar();
	
		if (!$rpd->getError())        
		{
			$pd = new ModeloPedidodetalle();
// 			$r->mostrarAviso("antes de pedido detalle set idpedido detalle "); 
			$pd->setIdPedidoDetalle($idPedidoDetalle);
// 			$r->mostrarAviso("despues de set idpedidodetalle"); 
			
			$pd->setPartidaDespachada($pd->getPartidaDespachada() + $piezas);
// 			$r->mostrarAviso("despues de setPartidaDespachada"); 
			$pd->setIdSucursalDespachado($idSucursal);
// 			$r->mostrarAviso("despues de set idsucursaldespachado"); return $r;
			
			if ($pd->getPartidaDespachada() >= $pd->getPartida())
			{
				$pd->setDespachadoSI();
				$pd->setDateAndUser("despachado");
			}
			
// 			$r->mostrarAviso("todo bien al actualizar pedido detalle"); return $r;
			
			$pd->Guardar();
			
			if (!$pd->getError())
			{
				$inv = new ModeloInvzmovrollo();
// 				$inv->transaccionIniciar();
				
					
				$inv->setIdRollo($idRollo);
				$inv->setIdRemisionRollo($idRemisionRollo);
				$inv->setDocumentoPEDIDO();
				$inv->setReferencia($pd->getIdPedido());
				$inv->setMovimientoSALIDA();
				$inv->setSalidaDespachoSI();
				$inv->setCantidad($totalkg);
				$inv->setObservaciones("Registro de Produccion");
				$inv->setIdPedidoDetalle($idPedidoDetalle);
				$inv->setDateAndUser("movimiento");
				$inv->setIdRegistroProduccion($idRegistroProduccion);
				$inv->setIdRegistroProduccionDetalle($rpd->getIdRegistroProduccionDetalle());
				$inv->setIdSucursal($idSucursal);
				$inv->setPiezas($piezas);
				
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
			$r->script(" app.pedidoNoDespachar(); xajax_cargarDatosRegistroProduccionAbierto(app.idRegistroProduccion); setTimeout(function() {app.cargarPedidoDetalle();}, 200);");
			$r->saSuccess("Se ha registrado la producci�n satisfactoriamente.");
			$r->saClose(2);
			
		}
		else
		{
			$rpd->transaccionRollback();
			$r->saError("Ha ocurrido un error. " . $strErrores );
			$r->script(" app.showButtonRegistrarRPPedido = true;");
		}
	
	
		return $r;
	}
	$xajax->registerFunction("registrarRPPedido");
	
	// Fin para el pedido ---------------------------------------------------------------------
		
	function concluirRegistroProduccion($idRegistroProduccion)
	{
		$r = new xajaxResponse();
	
		$rp = new ModeloRegistroproduccion();
		
		if ($idRegistroProduccion <= 0)
		{
			$r->saError("No se ha indicado un Registro de Producci�n.");
			return $r;
		}
		
		$rp->setIdRegistroProduccion($idRegistroProduccion);
		
		if ($rp->getIdRegistroProduccion() <= 0)
		{
			$r->saError("No se ha podido cargar la informaci�n de Registro de Producci�n.");
			return $r;
		}
		
		$rp->setTerminadoSI();
		$rp->setDateAndUser("termina");
		
		$rp->Guardar();
		
		if (!$rp->getError())	
		{		
			$r->script("app.seleccionarOtroNoRollo();");
			$r->saSuccess("Se ha concluido el Registro de Producci�n exitosamente.");
			$r->saClose(2);		
		}
		else
		{
			$r->saError("Ha ocurrido un error. " . $strErrores );
// 			$r->script(" app.showButtonRegistrarRPPedido = true;");
		}
	
		return $r;
	}
	$xajax->registerFunction("concluirRegistroProduccion");
	
	
	function cargarProductosParaStock($idRollo)
	{
		$r = new xajaxResponse();
	
		$producto = new ModeloProducto();
		
		$lst = $producto->getAll("idProducto, codigo, descripcion, mlpieza", 
				                 "", 
				                 " producto_rollo_idrollo = " . $idRollo . " AND producto_unidad_idunidad = 4");
		
		$opcionesProducto = "<option value='0'>-- Seleccione Producto --</option>";
		$opcionesProductoLong = "<option value='0'>0</option>";
		
		foreach ($lst as $row)
		{
			$opcionesProducto .= "<option value='".$row["idProducto"]."'>".$row["codigo"]." - ".$row["descripcion"]."</option>";
			$opcionesProductoLong .= "<option value='".$row["idProducto"]."'>".$row["mlpieza"]."</option>";
		}
			
		$r->assign("selStockProducto", "innerHTML", $opcionesProducto);
		$r->assign("selLongitudStockProducto", "innerHTML", $opcionesProductoLong);
	
		return $r;
	}
	$xajax->registerFunction("cargarProductosParaStock");

	function guardarEspesor($espesor,$idRegistroProduccion)
	{
		$r = new xajaxResponse();

		$rp = new ModeloRegistroproduccion();
		

		$rp->setIdRegistroProduccion($idRegistroProduccion);

		if ($espesor <= 0)
		{
			$r->saError("El valor ingresado debe ser mayor a 0");
			return $r;
		}
		
		$rp->setEspesor($espesor);

		
		$rp->Guardar();
		
		if (!$rp->getError())
		{
			$r->script("
					 saSuccess(\"".utf8_encode("Movimiento guardado exitosamente")."\");
					 app.showGuardarEspesor = false;
					");
		}			
		else
		{
			$r->script("
					saError(\"".utf8_encode("Ha ocurrido un error. " . $rp->getStrError())."\");
					");
		}
	
		return $r;
	}
	$xajax->registerFunction("guardarEspesor");

	function guardarLargoRollo($largoRollo,$idRegistroProduccion)
	{
		$r = new xajaxResponse();

		$rp = new ModeloRegistroproduccion();
		

		$rp->setIdRegistroProduccion($idRegistroProduccion);

		if ($largoRollo <= 0)
		{
			$r->saError("El valor ingresado debe ser mayor a 0");
			return $r;
		}
		
		$rp->setLargoRollo($largoRollo);

		
		$rp->Guardar();
		
		if (!$rp->getError())
		{
			$r->script("
					 saSuccess(\"".utf8_encode("Movimiento guardado exitosamente")."\");
					 app.showGuardarlargoRollo = false;
					 
					");
		}			
		else
		{
			$r->script("
					saError(\"".utf8_encode("Ha ocurrido un error. " . $rp->getStrError())."\");
					");
		}
	
		return $r;
	}
	$xajax->registerFunction("guardarLargoRollo");
	
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
	
	