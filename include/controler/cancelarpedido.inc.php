<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";

	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.cxc.inc.php";

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

		$pedido = new ModeloPedido();

		$pedido->getPedido($idPedido);

		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se pudo cargar informaci�nn del Pedido.");
			$r->script("app.seleccionarOtroPedido();");
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

		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_autorizado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_autorizado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}

		$image = URL_BASE.$image;
		$datosEstatus .= "app.autorizadoImage = '".$image."';";
		$datosEstatus .= "app.autorizadoPor = '".trim($pedido->getPedidoDato("autorizadoNombre")." ".$pedido->getPedidoDato("autorizadoAPaterno")." ".$pedido->getPedidoDato("autorizadoAMaterno"))."';";
		$datosEstatus .= "app.autorizadoFecha = '".$pedido->getPedidoDato("fecha_autorizado")."';";
		$datosEstatus .= "app.autorizadoObservacion = '".$pedido->getPedidoDato("observacionAutoriza")."';";


		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_produccion") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_produccion") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}

		$image = URL_BASE.$image;
		$datosEstatus .= "app.produccionImage = '".$image."';";
		$datosEstatus .= "app.produccionPor = '".trim($pedido->getPedidoDato("produccionNombre")." ".$pedido->getPedidoDato("produccionAPaterno")." ".$pedido->getPedidoDato("produccionAMaterno"))."';";
		$datosEstatus .= "app.produccionFecha = '".$pedido->getPedidoDato("fecha_produccion")."';";

		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_terminado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_terminado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}

		$image = URL_BASE.$image;
		$datosEstatus .= "app.terminadoImage = '".$image."';";
		$datosEstatus .= "app.terminadoPor = '".trim($pedido->getPedidoDato("terminadoNombre")." ".$pedido->getPedidoDato("terminadoAPaterno")." ".$pedido->getPedidoDato("terminadoAMaterno"))."';";
		$datosEstatus .= "app.terminadoFecha = '".$pedido->getPedidoDato("fecha_terminado")."';";

		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_entregado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_entregado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}

		$image = URL_BASE.$image;
		$datosEstatus .= "app.entregadoImage = '".$image."';";
		$datosEstatus .= "app.entregadoPor = '".trim($pedido->getPedidoDato("entregadoNombre")." ".$pedido->getPedidoDato("entregadoAPaterno")." ".$pedido->getPedidoDato("entregadoAMaterno"))."';";
		$datosEstatus .= "app.entregadoFecha = '".$pedido->getPedidoDato("fecha_entregado")."';";

		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_cancelado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_cancelado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}

		$image = URL_BASE.$image;
		$datosEstatus .= "app.canceladoImage = '".$image."';";
		$datosEstatus .= "app.canceladoPor = '".trim($pedido->getPedidoDato("canceladoNombre")." ".$pedido->getPedidoDato("canceladoAPaterno")." ".$pedido->getPedidoDato("canceladoAMaterno"))."';";
		$datosEstatus .= "app.canceladoFecha = '".$pedido->getPedidoDato("fecha_cancelado")."';";
		$datosEstatus .= "app.cancelaObservacion = '".$pedido->getPedidoDato("observacionCancela")."';";

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

		//falta poner una persona
		$datosConsignacion = "";

		$datosConsignacion .= "app.personaEntrega = '".$pedido->getPedidoDato("personaEntrega")."';";
		$datosConsignacion .= "app.recogeentrega = '".$pedido->getPedidoDato("recogeentrega")."';";
		$datosConsignacion .= "app.domicilioEntrega = '".$pedido->getPedidoDato("domicilioEntrega")."';";
		$datosConsignacion .= "app.numeroEntrega = '".$pedido->getPedidoDato("numeroEntrega")."';";
		$datosConsignacion .= "app.coloniaEntrega = '".$pedido->getPedidoDato("coloniaEntrega")."';";
		$datosConsignacion .= "app.ciudadEntrega = '".$pedido->getPedidoDato("ciudadEntrega")."';";


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

		$productos = "";
		foreach ($pedido->__rsPedidoWDetalle as $row)
		{
			$productos .= "
					app.productos.push({
						idPedidoDetalle: '".$row["idPedidoDetalle"]."',
						proDescripcion: '".$row["proDescripcion"]."',
						detPartida: '".$row["detPartida"]."',
						detCantidad: '".$row["detCantidad"]."',
						detCantidadReal: '".$row["detCantidadReal"]."',
						proShortUnidad: '".$row["proShortUnidad"]."',
						detDesarrollo: '".$row["detDesarrollo"]."',
						detDobleces: '".$row["detDobleces"]."',
						detPrecioUnitario: '".$row["detPrecioUnitario"]."',
						detTipoPrecio: '".$row["detTipoPrecio"]."',
						detTotal: '".$row["detTotal"]."',
						listo_para_producir: '".$row["listo_para_producir"]."',
						despachado: '".$row["despachado"]."',
						explotado: '".$row["explotado"]."',
						explotadook: '".$row["explotadook"]."'
					});

					";

		}

		$totales = "";

		$totales .= "app.subtotal = '".$pedido->getPedidoDato("subtotal")."';";
		$totales .= "app.descuento = '".$pedido->getPedidoDato("descuento")."';";
		$totales .= "app.total = '".$pedido->getPedidoDato("total")."';";


		if($pedido->getPedidoDato("estado") != "CAPTURADO" &&  $pedido->getPedidoDato("estado") != "AUTORIZADO" && $pedido->getPedidoDato("estado") != "CANCELADO")
		{
			$r->script(" app.estatusIncorrecto = true; ");
		}
		else
		{
			if($pedido->getPedidoDato("estado") == "CANCELADO")
			{
				$r->script(" app.pedidoCancelado = true; ");
			}
			else
			{
				$r->script(" app.puedeCancelarse = true; ");
			}


		}


		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosEstatus . $datosCliente . $datosConsignacion.
				" app.productos.splice(0, app.productos.length);" . $productos . $totales);

		return $r;
	}
	$xajax->registerFunction("cargarPedido");



	function cancelarPedido($idPedido, $motivoCancelacion)
	{
		$r = new xajaxResponse();
        $idProductoMoldura = 386;

		$pedido = new ModeloPedido();
		
		$pedido->setIdPedido($idPedido);
		
		// $pedido->dumpObj();
		// $pedido->varDump($pedido);

		$pedido->transaccionIniciar();
		$blnDoCommit = true;
		$errores = "";

		if ($pedido->getEstado() == "CAPTURADO")
		{
// 				echo "<br>Cancelar simple, ya que es capturado";
			$pedido->setEstadoCANCELADO();
			$pedido->setDateAndUser("cancelado");
			$pedido->setObservacionCancela($motivoCancelacion);
			$pedido->setSaldo(0);
			$pedido->setSaldopromotor(0);


			$pedido->Guardar();

			if ($pedido->getError())
			{
				$errores .= "(250)".$pedido->getStrError() . ". ";
				$blnDoCommit = false;
			}

			//---
			$cxc = new ModeloCxc();

			$lstCXC = $cxc->getAll("idCxc", "", "idPedido = " . $idPedido );

			foreach ($lstCXC as $itemcxc)
			{
				$delCXC = new ModeloCxc();

				$delCXC->setIdCxc($itemcxc["idCxc"]);

				// 	$cxc->dumpObj();

				$delCXC->Borrar();

				if ($delCXC->getError())
				{
// 					echo "Error";
					$errores .= "(272)".$delCXC->getStrError() . ". ";
					$blnDoCommit = false;
				}
			}
			//---
			
			//los capturados generan un apartadoreal, solamente, hay que quitarlo
			
			if ($blnDoCommit)
			{
			    // 				echo "<br>Cancelar pedido de estao autorizado";
			    $pd = new ModeloPedidodetalle();
			    
			    $lst = $pd->getAll("idPedidoDetalle", "", " idPedido = " . $idPedido);
			    
			    foreach ($lst as $objpd)
			    {
			        $vp = new ModeloViewproductos();
			        $pedidoDetalle = new ModeloPedidodetalle();
			        
			        $pedidoDetalle->setIdPedidoDetalle($objpd["idPedidoDetalle"]);
			        
			        $vp->getView($pedidoDetalle->getIdProducto());
			        
			        // 					echo "<br>";
			        // 					echo "<br>";
			        // 					$vp->dumpAsTable();
			        // 					echo "<br>";
			        
			        if($pedidoDetalle->getListo_para_producir() == "NO")
			        {
			            if($pedidoDetalle->getDespachado() == "SI")
			            {
			                $errores .="(343)". "PedidoDetalle Despachado". ". ";
			                $blnDoCommit = false;
			                // 							echo "<br>despachado, ingresar inventario para que se eleve, solo productos stock";
			            }
			            else
			            {
			                // 							echo "<br>no despachado, solo decrementar apartados de los rollos y productos stock";
			                
			                // if ($vp->getIdRollo() == "1")
			                if ($vp->getIdUnidad() == 4)
			                {
			                    // if ($vp->getIdUnidad() == 4)
			                    // {
			                    // 									echo "<br><br>Des apartar de producto";
			                    $producto = new ModeloProducto();
			                    
			                    $producto->setIdProducto($vp->getIdProducto());
			                    
			                    if ($producto->getIdProducto() <= 0)
			                    {
			                        // 										echo "ocurrio un error";
			                        $errores .= "(363)"."No se pudo obtener Producto" . ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                    
// 			                    $producto->desApartar($pedidoDetalle->getTotalExplotar());
			                    $producto->desApartarReal($pedidoDetalle->getTotalExplotar());
			                    $pedidoDetalle->setListo_para_producirNO();
			                    
			                    $pedidoDetalle->Guardar();
			                    
			                    if ($pedidoDetalle->getError())
			                    {
			                        // 										echo "ocurrio un error";
			                        $errores .= "(377)".$pedidoDetalle->getStrError() . ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                    
			                    $producto->Guardar();
			                    
			                    if ($producto->getError())
			                    {
			                        // 										echo "ocurrio un error";
			                        $errores .= "(387)".$pedido->getStrError() . ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                    
			                    // }
			                    
			                    
			                    
			                    
			                    
			                }
			                else
			                {
			                    if ($vp->getIdRollo() ==  "1"  && $vp->getIdProducto() != $idProductoMoldura)
			                    {
			                        // 									echo "ocurrio un error";
			                        $errores .= "(406)"."No se puede descontar de rollo. Falta informaci�n de rollo (Prod: ".$vp->getIdProducto().")". ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                    
			                    
			                    
			                    // 								echo "<br><br>Des apartar de Rollo: " . $vp->getIdRollo();
			                    $rollo = new ModeloRollo();
			                    
			                    $rollo->setIdRollo($vp->getIdRollo());
			                    
			                    if ($rollo->getIdRollo() <= 0)
			                    {
			                        // 									echo "ocurrio un error";
			                        $errores .= "(419)"."No se pudo obtener la informacion del rollo". ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                    
// 			                    if($pedidoDetalle->getDespachado() == "NO")
// 			                    {
// 			                        $rollo->desApartar($pedidoDetalle->getTotalExplotar());
// 			                        // 							echo "<br>despachado, ingresar inventario para que se eleve, solo productos stock";
// 			                    }
			                    
			                    
			                    
			                    $pedidoDetalle->setListo_para_producirNO();
			                    
			                    
			                    $rollo->Guardar();
			                    
			                    
			                    if ($rollo->getError())
			                    {
			                        // 									echo "ocurrio un error";
			                        $errores .= "(422)".$rollo->getStrError() . ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                    
			                    $pedidoDetalle->Guardar();
			                    
			                    if ($pedidoDetalle->getError())
			                    {
			                        // 									echo "ocurrio un error";
			                        $errores .= "(432)".$pedidoDetalle->getStrError() . ". ";
			                        $blnDoCommit = false;
			                        break;
			                    }
			                }
			                
			            }
			            
			        }
			        else
			        {
			            // 						echo "<br>No esta listo para producirse, no descontar ni nada";
			        }
			        
			        // 		$vp->dumpAsTable();
			    }
			}
			
			//fin apartado real


		}
		else if ($pedido->getEstado() == "AUTORIZADO")
		{
		    
			$pedido->setEstadoCANCELADO();
			$pedido->setDateAndUser("cancelado");
			$pedido->setObservacionCancela($motivoCancelacion);
			$pedido->setSaldo(0);

						
			$pedido->Guardar();

			if ($pedido->getError())
			{
				$errores .= "(291)".$pedido->getStrError() . ". ";
				$blnDoCommit = false;
			}
			else
			{
				$cxc = new ModeloCxc();

				$lstCXC = $cxc->getAll("idCxc", "", "idPedido = " . $idPedido );

				foreach ($lstCXC as $itemcxc)
				{
					$delCXC = new ModeloCxc();

					$delCXC->setIdCxc($itemcxc["idCxc"]);

					// 	$cxc->dumpObj();

					$delCXC->Borrar();

					if ($delCXC->getError())
					{
						// 					echo "Error";
						$errores .= "(313)".$delCXC->getStrError() . ". ";
						$blnDoCommit = false;
					}
				}

				if ($blnDoCommit)
				{
					// 				echo "<br>Cancelar pedido de estao autorizado";
					$pd = new ModeloPedidodetalle();

					$lst = $pd->getAll("idPedidoDetalle", "", " idPedido = " . $idPedido);

					foreach ($lst as $objpd)
					{
						$vp = new ModeloViewproductos();
						$pedidoDetalle = new ModeloPedidodetalle();

						$pedidoDetalle->setIdPedidoDetalle($objpd["idPedidoDetalle"]);
						
						$vp->getView($pedidoDetalle->getIdProducto());
						
						// 					echo "<br>";
						// 					echo "<br>";
						// 					$vp->dumpAsTable();
						// 					echo "<br>";

						if($pedidoDetalle->getListo_para_producir() == "SI")
						{
							if($pedidoDetalle->getDespachado() == "SI")
							{
								$errores .="(343)". "PedidoDetalle Despachado". ". ";
								$blnDoCommit = false;
								// 							echo "<br>despachado, ingresar inventario para que se eleve, solo productos stock";
							}
							else
							{
								// 							echo "<br>no despachado, solo decrementar apartados de los rollos y productos stock";
							    
								// if ($vp->getIdRollo() == "1")
								if ($vp->getIdUnidad() == 4)
								{
									// if ($vp->getIdUnidad() == 4)
									// {
										// 									echo "<br><br>Des apartar de producto";
										$producto = new ModeloProducto();

										$producto->setIdProducto($vp->getIdProducto());

										if ($producto->getIdProducto() <= 0)
										{
											// 										echo "ocurrio un error";
											$errores .= "(363)"."No se pudo obtener Producto" . ". ";
											$blnDoCommit = false;
											break;
										}

										$producto->desApartar($pedidoDetalle->getTotalExplotar());
										$producto->desApartarReal($pedidoDetalle->getTotalExplotar());
										$pedidoDetalle->setListo_para_producirNO();

										$pedidoDetalle->Guardar();

										if ($pedidoDetalle->getError())
										{
											// 										echo "ocurrio un error";
											$errores .= "(377)".$pedidoDetalle->getStrError() . ". ";
											$blnDoCommit = false;
											break;
										}

										$producto->Guardar();

										if ($producto->getError())
										{
											// 										echo "ocurrio un error";
											$errores .= "(387)".$pedido->getStrError() . ". ";
											$blnDoCommit = false;
											break;
										}

									// }





								}
								else
								{
								    if ($vp->getIdRollo() ==  "1"  && $vp->getIdProducto() != $idProductoMoldura) 
									{
										// 									echo "ocurrio un error";
										$errores .= "(406)"."No se puede descontar de rollo. Falta informaci�n de rollo (Prod: ".$vp->getIdProducto().")". ". ";
										$blnDoCommit = false;
										break;
									}

									// 								echo "<br><br>Des apartar de Rollo: " . $vp->getIdRollo();
									$rollo = new ModeloRollo();

									$rollo->setIdRollo($vp->getIdRollo());

									if ($rollo->getIdRollo() <= 0)
									{
										// 									echo "ocurrio un error";
										$errores .= "(419)"."No se pudo obtener la informacion del rollo". ". ";
										$blnDoCommit = false;
										break;
									}



									$rollo->desApartar($pedidoDetalle->getTotalExplotar());
									$pedidoDetalle->setListo_para_producirNO();


									$rollo->Guardar();


									if ($rollo->getError())
									{
										// 									echo "ocurrio un error";
										$errores .= "(422)".$rollo->getStrError() . ". ";
										$blnDoCommit = false;
										break;
									}

									$pedidoDetalle->Guardar();

									if ($pedidoDetalle->getError())
									{
										// 									echo "ocurrio un error";
										$errores .= "(432)".$pedidoDetalle->getStrError() . ". ";
										$blnDoCommit = false;
										break;
									}
								}

							}

						}
						else
						{
							// 						echo "<br>No esta listo para producirse, no descontar ni nada";
						}

						// 		$vp->dumpAsTable();
					}
				}

			}




		}
		else if ($pedido->getEstado() == "CANCELADO")
		{
// 			echo "<br>Pedido no puede Cancelarse";
		}
		else
		{
// 			echo "<br>Pedido Cancelado";
		}

		// $blnDoCommit = false;
		if ($blnDoCommit)
		{
			$r->saSuccess("El movimiento ha sido efectuado con éxito");
			$r->script(" app.cargarDatosPedido(); ");
			$pedido->transaccionCommit();

			if ($pedido->getFactura() != "0")
			{
				NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 
													  21, //Saida 
													  "El Pedido " . $pedido->getIdPedido() . " ha sido CANCELADO. ", 
													  "El pedido ".$pedido->getIdPedido()." ha sido Cancelado y al parecer ha sido facturado. Favor de revisar la(s) Factura(s) ".$pedido->getFactura().".");			
			}

// 			echo "<br><br>Commit";
		}
		else
		{
			$r->saInfo("No se pudo realizar el movimiento. " . mb_convert_encoding($errores, 'UTF-8', 'ISO-8859-1');
			$pedido->transaccionRollback();
// 			echo "<br><br>RollBack";
		}

		return $r;
	}
	$xajax->registerFunction("cancelarPedido");


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
