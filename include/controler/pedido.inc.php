<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	
 	require_once FOLDER_MODEL. "model.cliente.inc.php";
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	function obtenerTabla($noPedido = "", $estatus = "0", $cliente = "")
	{		
		
		$strHTML = "";
		
		$strHTML .= "<table id='tblListado' class='footable table table-striped table-bordered' data-page-size='50'>";
		$strHTML .= "  <thead>";
		$strHTML .= "    <tr>";		
		$strHTML .= "      <th>Pedido</th>";
		$strHTML .= "      <th data-hide='phone'>Cliente</th>";
		$strHTML .= "      <th data-hide='phone'>Total</th>";
		$strHTML .= "      <th data-hide='phone'>Fecha</th>";
// 		<!-- 							<th data-hide='phone,tablet'>Date modified</th> -->
		$strHTML .= "      <th data-hide='phone'>Estatus</th>";
		$strHTML .= "      <th data-hide='phone'>Sucursal</th>";
		
		$strHTML .= "      <th data-hide='phone'>Vales Salida</th>";
		
		
		
		if(Permisos::userIsThisRol(Permisos::$rol_CXC) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR)  || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS))
		{
			$strHTML .= "      <th data-hide='phone'>Obs. Autorizaci&oacute;n</th>";
		}
		
		$strHTML .= "      <th class='text-left'>Acci&oacute;n</th>";	
		$strHTML .= "    </tr>";
		$strHTML .= "  </thead>";
		$strHTML .= "  <tbody>";
		
		$pedido = new ModeloPedido();
		
		$where = "";
		
		if ($noPedido != "" || $estatus != "0" || $cliente != "")
		{
		    if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !ModeloUsuario::isUsuarioMostrador())
		    {
		        $where .= " AND (c.idUsuarioPromotor = " . ModeloUsuario::getObjSession()->getIdUsuario() . " OR pedido.id_usuario_capturado = " . ModeloUsuario::getObjSession()->getIdUsuario() . ") " ;
		    }
		}
		else 
		{
		    if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) )
		    {
		        $where .= " AND (c.idUsuarioPromotor = " . ModeloUsuario::getObjSession()->getIdUsuario() . " OR pedido.id_usuario_capturado = " . ModeloUsuario::getObjSession()->getIdUsuario() . ") " ;
		    }
		}
		
		
		
		if ($noPedido != "")
		{
			$where .= " AND pedido.idPedido = " . $noPedido;	
		}
		else
		{
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
				$where .= " AND pedido.estado IN ('CAPTURADO','AUTORIZADO', 'PRODUCCION') ";
				// 			}
			}
			
			if ($cliente != "")
			{
				$where .= " AND UPPER(concat(c.nombre, ' ' ,c.apellidos)) LIKE '%".trim($cliente)."%'";
			}
		}
				
		if (substr($where, 0,4) == " AND")
		{
			$where = substr($where, 5);
		}
		//pedidos por mes por promotor
// 		select pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor from pedido INNER JOIN cliente as c ON c.idCliente = pedido.idCliente 
// INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor 
// where pedido.fecha_capturado between '2018-03-01' and '2018-03-31'
		$lstPedidos = $pedido->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.saldo, pedido.estado, 
                                       pedido.colocado, 
                                       getPedidoValesSalida(idPedido) valessalida,
				                       pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, 
				                       pedido.despachado, pedido.fecha_autorizado,
				                       pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida,
				                       pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, 
									   getPedidoSucursalesAsignadas(idPedido) as sucursales,	
				                       pedido.fecha_capturado, pedido.recogeentrega, pedidoBloqueadoXPrecios(pedido.idPedido) bloqueadoPorPrecios,
		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente,
				          IF(pedido.estado = 'AUTORIZADO', 1, IF(pedido.estado = 'PRODUCCION', 2, IF(pedido.estado = 'CAPTURADO', 3, IF(pedido.estado = 'TERMINADO' AND pedido.recogeentrega = 'RECOGE' , 4, 999)))) as ordestatus", 
		                  " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
				          $where, "ordestatus ASC, pedido.fecha_autorizado asc");
		
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
			//se agrega label de saldo solo si saldo > 0
			$strHTML .= "      <td>$". number_format($row["total"], 2) . ($row["saldo"] > 0 ? " <span class='label label-danger'>".number_format($row["saldo"], 2): "")."</span></td>";
			$strHTML .= "      <td>" . clsUtilerias::formatoFecha(substr($row["fecha_capturado"], 0)) . "</td>";
			$strHTML .= "      <td>";
						
			switch ($row["estado"])
			{
				case "CAPTURADO";
					$strHTML .= "<p><span class='text-warning'>CAPTURADO</span></p>";
					if (Permisos::userIsThisRol(Permisos::$rol_CXC) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS))					
					{
						
// 						$cambiaEstatusButton = "&nbsp;<button class='btn btn-default btn-xs' onclick='fnAutorizar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> AUTORIZAR</button>";
						if ($row["bloqueadoPorPrecios"] == 'SI')
						{
						 	$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
							if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) )
							{
								$cambiaEstatusButton .= "&nbsp;<button class='btn btn-warning btn-xs' onclick='fnDesbloquear(".$row["idPedido"].");'><i class='fa fa-exchange'></i> DESBLOQUEAR</button>";
								$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Ver Detalle</a>";
							}
							else
							{
								$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
							}
							$cambiaEstatusButton .= "</span>";
						}
						else
						{
							$cambiaEstatusButton = "&nbsp;<button class='btn btn-default btn-xs' onclick='fnSolicitarObservacionAutorizacion(".$row["idPedido"].");'><i class='fa fa-exchange'></i> AUTORIZAR</button>";
						}
					}
					else
					{
						if ($row["bloqueadoPorPrecios"] == 'SI')
						{
						 	$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
							$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
							$cambiaEstatusButton .= "</span>";
						}
					}
					
					break;
				case "AUTORIZADO";
					$strHTML .= "<p><span class=''>AUTORIZA CxC</span></p>";
										
					if (!Permisos::userIsThisRol(Permisos::$rol_CXC))
					{
						if ($row["explotado"] == "SI")
						{
							if ($row["explotadook"] == "SI")
							{
							    if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION)|| Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS) )
								// if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION))
								{
								    
									if ($row["bloqueadoPorPrecios"] == 'SI')
									{
											$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
											if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) )
											{
												$cambiaEstatusButton .= "&nbsp;<button class='btn btn-warning btn-xs' onclick='fnDesbloquear(".$row["idPedido"].");'><i class='fa fa-exchange'></i> DESBLOQUEAR</button>";
												$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Ver Detalle</a>";
											}
											else
											{
												$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
											}
											$cambiaEstatusButton .= "</span>";
									}
									else
									{
										if ($row["colocado"] == 'SI')
										{
										
											$cambiaEstatusButton = "&nbsp;<button class='btn btn-info btn-xs' onclick='fnProducir(".$row["idPedido"].");'><i class='fa fa-exchange'></i> PRODUCIR</button>&nbsp;<span class='badge badge-success'>LISTO PRODUCIR COMPLETO</span>";								        										
										}
										else 
										{
											$cambiaEstatusButton = "&nbsp;<span class='badge badge-info'>EL PEDIDO NO HA SIDO ASIGNADO A&Uacute;N</span>";
										}
									}

								    
								}
								else
								{
									if ($row["bloqueadoPorPrecios"] == 'SI')
									{
										$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
										$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
										$cambiaEstatusButton .= "</span>";
									}
								}
							}
							else
							{
								//aqu� poner validaci�n pata habilitar cambio de estatus siempre y
								//cuando haya al menos un elemento para despachar
								if ($row["puedeProducirse"] == "SI")
								{
									$cambiaEstatusButton = "";
									if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS) )
									{
									    if ($row["bloqueadoPorPrecios"] == 'SI')
										{
											$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
											if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) )
											{
												$cambiaEstatusButton .= "&nbsp;<button class='btn btn-warning btn-xs' onclick='fnDesbloquear(".$row["idPedido"].");'><i class='fa fa-exchange'></i> DESBLOQUEAR</button>";
												$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Ver Detalle</a>";
											}
											else
											{
												$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
											}
											$cambiaEstatusButton .= "</span>";
										}
										else
										{
									       	if ($row["colocado"] == 'SI')
											{
												$cambiaEstatusButton .= "&nbsp;<button class='btn btn-info btn-xs' onclick='fnProducir(".$row["idPedido"].");'><i class='fa fa-exchange'></i> PRODUCIR</button>";											
											}
											else
											{
												$cambiaEstatusButton = "&nbsp;<span class='badge badge-info'>EL PEDIDO NO HA SIDO ASIGNADO A&Uacute;N</span>";
											}
										}
										
									}
									else
									{
										if ($row["bloqueadoPorPrecios"] == 'SI')
										{
											$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
											$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
											$cambiaEstatusButton .= "</span>";
										}
									}
									$cambiaEstatusButton .= "&nbsp;<span class='badge badge-danger'>LISTO PRODUCIR PARCIAL</span>";
								}
								else
								{
									$cambiaEstatusButton = "&nbsp;<span class='badge badge-danger'>A&Uacute;N NO PUEDE PRODUCIRSE</span>";
								}
								
								
							}
								
						}
						else
						{
							$cambiaEstatusButton = "&nbsp;<span class='badge badge-danger'>VERIFICANDO SI PUEDE PRODUCIRSE, ESPERE</span>";
						}	
					}
					
					
					
					break;
				case "PRODUCCION";
					$strHTML .= "<p><span class='text-info'>PRODUCCI&Oacute;N</span></p>";
					if ($row["despachado"] == "SI")
					{
						if ($row["todosValesSalida"] == "SI")
						{

							if ($row["bloqueadoPorPrecios"] == 'SI')
							{
								$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
								if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) )
								{
									$cambiaEstatusButton .= "&nbsp;<button class='btn btn-warning btn-xs' onclick='fnDesbloquear(".$row["idPedido"].");'><i class='fa fa-exchange'></i> DESBLOQUEAR</button>";
									$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Ver Detalle</a>";
								}
								else
								{
									$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Consultar Nuevo Monto</a>";
								}
								$cambiaEstatusButton .= "</span>";
							}
							else
							{
								if ($row["recogeentrega"] == "RECOGE")
								{
									if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION))
									{
										$cambiaEstatusButton = "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnTerminarYEntregar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> TERMINAR Y ENTREGAR</button>";
									}
										
								}
								else
								{
									if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS)))
									{
										$cambiaEstatusButton = "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnTerminar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> TERMINAR</button>";
									}
										
								}
							}

						}
						else
						{
							$cambiaEstatusButton = "&nbsp;<span class='badge badge-warning'>A&Uacute;N HAY MERCANC&Iacute;A SIN VALE DE SALIDA</span>";
						}
						
											
					}
					else
					{
						if ($row["explotadook"] == "SI")
						{
							$cambiaEstatusButton = "&nbsp;<span class='badge badge-warning'>NO DESPACHADO</span>";
						}
						else
						{
							$cambiaEstatusButton = "&nbsp;<span class='badge badge-danger'>PRODUCCIENDO PARCIALMENTE</span>&nbsp;<span class='badge badge-warning'>NO DESPACHADO</span>";
						}
						
					}					
					break;
				case "TERMINADO";
					$strHTML .= "<p><span class='text-navy'>TERMINADO</span></p>";
					
					if ($row["todosValesSalida"] == "SI")
					{
// 					    if ($row["recogeentrega"] == "RECOGE")
// 					    {
// 					        if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
// 					        {
// 					            $cambiaEstatusButton = "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnTerminarYEntregar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> TERMINAR Y ENTREGAR</button>";
// 					        }
					        
// 					    }
// 					    else
// 					    {
// 					        if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
// 					        {
// 					            $cambiaEstatusButton = "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnTerminar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> TERMINAR</button>";
// 					        }
					        
// 					    }

						if ($row["bloqueadoPorPrecios"] == 'SI')
						{
							$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
							if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) )
							{
								$cambiaEstatusButton .= "&nbsp;<button class='btn btn-warning btn-xs' onclick='fnDesbloquear(".$row["idPedido"].");'><i class='fa fa-exchange'></i> DESBLOQUEAR</button>";
								$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Ver Detalle</a>";
							}
							else
							{
								$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Actualizar Precios</a>";
							}
							$cambiaEstatusButton .= "</span>";
						}
						else
						{
							if (Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION)   || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS)  )
							{
								$cambiaEstatusButton = "&nbsp;<button class='btn btn-success btn-xs' onclick='fnEntregar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> ENTREGADO</button>";
							}
						}
					}
					else
					{
					    $cambiaEstatusButton = "&nbsp;<span class='badge badge-warning'>A&Uacute;N HAY MERCANC&Iacute;A SIN VALE DE SALIDA</span>";
					}
					
					
					
					break;
				case "ENTREGADO";
					$strHTML .= "<p><span class='text-success'>ENTREGADO</span></p>";

					if ($row["bloqueadoPorPrecios"] == 'SI')
					{
						$cambiaEstatusButton = "<br><br><span class='badge badge-danger'><i class='fa fa-lock'></i> Pedido Bloqueado por Cambio de Precios &nbsp;&nbsp;&nbsp;";
						if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) )
						{
							$cambiaEstatusButton .= "&nbsp;<button class='btn btn-warning btn-xs' onclick='fnDesbloquear(".$row["idPedido"].");'><i class='fa fa-exchange'></i> DESBLOQUEAR</button>";
							$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Ver Detalle</a>";
						}
						else
						{
							$cambiaEstatusButton .= "<a target='_blank' href='".URL_BASE."pedidoactualizaprecios/".$row["idPedido"]."' class='btn btn-primary btn-xs m-r-xs'> Actualizar Precios</a>";
						}
						$cambiaEstatusButton .= "</span>";
					}

					break;
				case "CANCELADO";
					$strHTML .= "<p><span class='text-danger'>CANCELADO</span></p>";
					break;
			}
			
			$strHTML .= "      </td>";
			$strHTML .= "      <td>". $row["sucursales"]."</td>";
			
			$strHTML .= " <td>".$row["valessalida"]."</td>";
			
			if(Permisos::userIsThisRol(Permisos::$rol_CXC) || Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR)  || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS))
				{
					// 				$strHTML .= "      <td><button class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></button> <span id='obsAutoriza".$row["idPedido"]."'>".$row["observacionAutoriza"]."</span></td>";
					$strHTML .= "      <td>";
					if(Permisos::userIsThisRol(Permisos::$rol_CXC) && $row["estado"] != "CANCELADO")
					{
						$strHTML .= "      <button onclick=\"fnSolicitarCambioObservacionAutorizacion(".$row["idPedido"].");\" class='btn btn-success btn-xs'><i class='fa fa-pencil'></i></button> ";
					}
				
					$strHTML .= "<span id='obsAutoriza".$row["idPedido"]."'>".$row["observacionAutoriza"]."</span></td>";
				}	
			
			
			
			
			$strHTML .= "      <td class='text-left'>";
			
			if (Permisos::userIsThisRol(Permisos::$rol_CXC) || Permisos::userIsThisRol(Permisos::$rol_ROOT)  || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR))
			{
				if ($row["estado"] != "CANCELADO")
				{
					$strHTML .= "<a target='_blank' href='".URL_BASE."cxcclientepedidos/".$row["idCliente"]."' class='btn btn-primary btn-xs m-r-xs'><i class='fa fa-dollar'></i> CxC</a>";
				}
			}
			
			
			$strHTML .= "<button class='btn btn-success btn-xs m-r-xs' onclick='fnImprimir(".$row["idPedido"].");'><i class='fa fa-print'></i></button>";
			$strHTML .= "<button class='btn btn-success btn-xs m-r-xs' onclick='fnMostrarTracking(".$row["idPedido"].");'><i class='fa fa-pagelines'></i></button>";
			
			
			
			$strHTML .= $cambiaEstatusButton;
// 			$strHTML .= "      <div class='btn-group'>";
// 			$strHTML .= "      <button class='btn-white btn btn-xs'>View</button>";
// 			$strHTML .= "      <button class='btn-white btn btn-xs'>Edit</button>";
// 			$strHTML .= "      <button class='btn-white btn btn-xs'>Delete</button>";
// 			$strHTML .= "      </div>";
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
	
	function getImprimir($idPedido){
	    $r = new xajaxResponse();
	    
	    global $objSession;
	    
	    $idSucursal = $objSession->getIdSucursal();
	    
	    
	    $strHTML = "";
	    $strHTML .= "<a class='btn btn-info  btn-rounded btn-block' href='pedidodetalleview/" . $idPedido."' alt='Ver detalle' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-eye'></span> Ver Pedido</a>";
	    
	    $pedido = new ModeloPedido();
	    $pedido->setIdPedido($idPedido);
	    
	    if ($pedido->getIdPedido() <= 0)
	    {
	        $r->assign("divImpresiones", "innerHTML", "No se ha podido obtener informacion del Pedido");	
	        return $r;
	    }
	    
	    $lstSucursales = $pedido->getAll(" distinct sucursal.idsucursal, sucursal.nombre  ",
	                     "inner join pedidodetalle on pedido.idpedido = pedidodetalle.idpedido
                          inner join pedidodetallecolocacion on pedidodetalle.idpedidodetalle = pedidodetallecolocacion.idpedidodetalle
                          inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal", 
	                     "pedido.idpedido = ".$idPedido. " and pedidodetallecolocacion.cantidad > 0");
	    
	    $strSucursales = "";
	    $variasSucursales = false;
	    
	    if (count($lstSucursales) > 1)
	    {
	        $variasSucursales = true;
	    }
	    
	    
	    $botonesOrdenesProduccion = "";
	    
	    if (count($lstSucursales) == 0)
	    {
	        $botonesOrdenesProduccion = "<a class='btn btn-success btn-rounded btn-block' href='pedidoproduccion?id=" .  $idPedido."' alt='Imprimir' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Orden Producci&oacute;n</a>";
	    }
	    
	    
	    foreach ($lstSucursales as $sucursal)
	    {
	        if ($idSucursal == 0)
	        {
	            $botonesOrdenesProduccion .= "<a  class='btn btn-success btn-rounded btn-block' href='pedidoproduccionsucursal?id=" .  $idPedido."&idsucursal=".$sucursal["idsucursal"]."' alt='Imprimir Orden Produccion' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Orden Producci&oacute;n". ($variasSucursales ? " PARCIAL " : " ") .$sucursal["nombre"]."</a>";
	        }
	        else
	        {
	            if ($idSucursal == $sucursal["idsucursal"])
	            {
	                $botonesOrdenesProduccion .= "<a  class='btn btn-success btn-rounded btn-block' href='pedidoproduccionsucursal?id=" .  $idPedido."&idsucursal=".$sucursal["idsucursal"]."' alt='Imprimir Orden Produccion' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Orden Producci&oacute;n". ($variasSucursales ? " PARCIAL " : " ") .$sucursal["nombre"]."</a>";
	            }
	            
	        }
	        
	    }
	    
	    if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) ||
	        Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) ||
	        Permisos::userIsThisRol(Permisos::$rol_CXC) ||
	        Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS) ||
	        Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) ||
	        Permisos::userIsThisRol(Permisos::$rol_CXCVIEW) ||
	        Permisos::userIsThisRol(Permisos::$rol_ROOT))
	    {	        
	        
	        if ($pedido->getEstado() != "CANCELADO")
	        {
	            if ($pedido->getEstado() != "CAPTURADO")
	            {
	                $strHTML .= "<br><br>";
	                $strHTML .= "<a class='btn btn-primary btn-rounded btn-block' href='pedidopdf?id=" .  $idPedido ."' alt='Imprimir' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Pedido</a>";
	                
	                if (Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS) || Permisos::userIsThisRol(Permisos::$rol_ROOT))
	                {
	                    $strHTML .= "<br><br>";
	                    if ($pedido->getColocado() == "SI")
	                    {
	                       $strHTML .= $botonesOrdenesProduccion;
	                    }
	                        
// 	                    "<a class='btn btn-primary btn-rounded btn-block' href='pedidoproduccion?id=" .  $idPedido."' alt='Imprimir' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Orden Producci&oacute;n</a>";
	                }
	                
	                
	            }
	            
	            
	            $strHTML .= "<br><br>";
	            $strHTML .= "<a class='btn btn-primary btn-rounded btn-block' href='pedidosend?idPedido=" .  $idPedido."' alt='Enviar al Cliente' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-envelope'></span> Enviar al Cliente</a>";
	        }
	        
	    }
	    else
	    {	        
	        if ($pedido->getEstado() != "CAPTURADO" && (Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) ) )
	        {
	            $strHTML .= "<br><br>";
	            $strHTML .= "<a class='btn btn-primary btn-rounded btn-block' href='pedidopdf?id=" .  $idPedido."' alt='Imprimir' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Pedido</a>";
	            
	        }
	        
	        $strHTML .= "<br><br>";
	        if ($pedido->getColocado() == "SI")
	        {
	           $strHTML .= $botonesOrdenesProduccion;
	        }
	            
// 	        "<a class='btn btn-primary btn-rounded btn-block' href='pedidoproduccion?id=" .  $idPedido."' alt='Imprimir' target='_blank' onclick=\"$('#modalImprimir').modal('hide');\"><span class='fa fa-print'></span> Imprimir Orden Producci&oacute;n</a>";
	    }
	    
	    
	    $r->assign("divImpresiones", "innerHTML", $strHTML);	    
	      
	    return $r;
	}
	$xajax->registerFunction("getImprimir");
		
	function llenarListado($noPedido = "", $estatus = "0", $cliente = "")
	{
		$r = new xajaxResponse();
		
		$r->assign("listadoPedidos", "innerHTML", obtenerTabla($noPedido, $estatus, $cliente));
		$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		$r->script("setTimeout(function(){ 

			$('#tblListado').DataTable({
				//\"ordering\": false,
                 dom: '<\"html5buttons\"B>lTfgitp',
                 buttons: [
                     //{extend: 'copy'},
                     //{extend: 'csv'},
                     {extend: 'excel', title: 'Aplicacion'},
                     {extend: 'pdf', title: 'Aplicacion'},

                     /*{extend: 'print',
                      customize: function (win){
                             $(win.document.body).addClass('white-bg');
                             $(win.document.body).css('font-size', '10px');

                             $(win.document.body).find('table')
                                     .addClass('compact')
                                     .css('font-size', 'inherit');
                     	}
                     }*/
                 ]

            });

		 }, 5000);");
		
		return $r;
	}
	$xajax->registerFunction("llenarListado");
	
	function autorizarPedido($idPedido, $observacion)
	{
		$r = new xajaxResponse();
		
		$pedido = new ModeloPedido();
		
		$pedido->setIdPedido($idPedido);
		
		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion del Pedido.");
			return $r;
		}
		
		if ($pedido->getEstado() != "CAPTURADO")
		{
			$r->saInfo("El Pedido no se puede Autorizar, dado su Estado actual. Verifique.");
			return $r;
		}
		
		$pedido->setEstadoAUTORIZADO();
		$pedido->setDateAndUser("autorizado");
		$pedido->setObservacionAutoriza($observacion);
		
		$pedido->setTipoAutorizacionCXC();
		
		$pedido->Guardar();
		
		if (!$pedido->getError())
		{
		    $pedido->NotificaAutorizacionPedido();
		    
		    
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->script("setTimeout(function(){app.filtrar();}, 500);");
// 			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
// 			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}	
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
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
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
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
		    
		    $pedido->NotificaProduccionPedido();
		    
			$pedido->transaccionCommit();
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->script("setTimeout(function(){app.filtrar();}, 500);");
// 			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
// 			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
			
		}
		else
		{
			$pedido->transaccionRollback();	
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
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
			$r->script("setTimeout(function(){app.filtrar();}, 500);");
// 			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
// 			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
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
		    $pedido->NotificaEntregaPedido();
		    
		    
			$r->script("saSuccess('El Pedido ha cambiado su Estado de forma correcta.')");
			$r->script("setTimeout(function(){app.filtrar();}, 500);");
// 			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
// 			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
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
			$r->script("setTimeout(function(){app.filtrar();}, 500);");
// 			$r->assign("listadoPedidos", "innerHTML", obtenerTabla());
// 			$r->script("setTimeout(function(){  $('.footable').footable();}, 500);");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1')).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("terminarYEntregarPedido");

	function desbloquearPedido($idPedido)
	{
		$r = new xajaxResponse();

		$r->mostrarAviso("Pedido " . $idPedido." ha sido desbloqueado");

		$pedido = new ModeloPedido();

		$pedido->setIdPedido($idPedido);

		$pedido->setDesbloqueadoPreciosAdminSI();

		$pedido->Guardar();	

		// $r->redirect("index", 2);
		$r->script("setTimeout(function(){app.filtrar();}, 500);");

		return $r;
	}
	$xajax->registerFunction("desbloquearPedido");

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
	    
	    $sql = "select getTotalSaldosCliente(".$pedido->getIdCliente().") saldototal, getSaldosMas30Dias (".$pedido->getIdCliente().") saldototalMas30Dias ";
	    
	    $saldoTotalCliente = $cliente->getDataSet($sql)[0]["saldototal"];
		$saldoTotalClienteMas30Dias = $cliente->getDataSet($sql)[0]["saldototalMas30Dias"];
		$sePuedeSurtir = $pedido->verificarSiPedidoPuedeSurtirse($idPedido);
	    
// 	    if ($pedido->getIdPedido() < 5868)
// 	    {
// 	        $r->saInfo("Solo se pueden hacer Vales de Salida en esta pantalla apartir del Pedido 5868.");
// 	        $r->script(" app.seleccionarPedido = true;	");
// 	        return $r;
// 	    }
	    
	    $r->script("
                    
                    app.pedidoSubtotal = '".$pedido->getSubtotal()."';
	                app.pedidoOtrosCargos = '". $pedido->getOtrosCargos() ."';
	                app.pedidoTotal = '". $pedido->getTotal() ."';
	                app.pedidoSaldo = '". $pedido->getSaldo() ."';
                    app.pedidoSaldoTotal = '". $saldoTotalCliente ."';
					app.pedidoSaldoTotalMas30Dias = '". $saldoTotalClienteMas30Dias ."';
					app.cteCredito = ".$cliente->getCredito().";
					app.cteCapacidadPago = ".$cliente->getCapacidadPago().";
					app.pedidoSurtiraCompleto = ".(count($sePuedeSurtir["NoSurtir"]) > 0 ? "false" : "true").";
					

					app.pedidoCliente = '". $cliente->getNombre() . " " . $cliente->getApellidos() ."';
					
					app.promoNombre = '".$promotor->getNombre()." ".$promotor->getApellidoMaterno(). " ".$promotor->getApellidoPaterno()."';
					app.vendeNombre = '".$vendedor->getNombre()." ".$vendedor->getApellidoMaterno(). " ".$vendedor->getApellidoPaterno()."';

                ");
	    
	       
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