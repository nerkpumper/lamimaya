<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	

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

	function cargarPromotor($idPromotor)
	{
		$r = new xajaxResponse();
	
		$usuario = new ModeloUsuario();
	
		$lst = $usuario->getAll("idUsuario, username, upper(concat(nombre, ' ' , apellidoPaterno, ' ', apellidoMaterno)) as nombreUsuario",
				"",
				" idUsuario =  " . $idPromotor);
			
		$strPromotores = "";
		
		$idClienteFromDB = "0";
		
	
		foreach ($lst as $row)
		{
	
			$idClienteFromDB = $row["idUsuario"];
			$strPromotores .= "
		                     app.promotorUsuario = '".mb_strtoupper($row["username"])."';
		                     app.promotorNombre = '".$row["nombreUsuario"]."';
					                                      ";
		}
		
		if ($strPromotores == "")
		{
			$r->script("app.idUsuario = 0; app.seleccionandoPromotor = true;");
			$r->saError("No se ha podido obtener la informaci�n del Promotor. Verifique o seleccione algun otro.");
			return $r;
		}
		
		//ahora obtenemos totales en pedidos
		$query = "SELECT IFNULL(SUM(1), 0) as totalPedidos, IFNULL(SUM(IF(saldo = 0, 1, 0)),0)  as saldados, IFNULL(SUM(IF(saldo > 0 and pedido.estado = 'ENTREGADO', 1, 0)),0)  as porSaldarentregados, IFNULL(SUM(IF(saldo > 0 and pedido.estado <> 'ENTREGADO', 1, 0)),0)  as porSaldarporentregar, IFNULL(SUM(IF(pedido.estado = 'CANCELADO', 1, 0)),0)  as cancelados
                    FROM pedido
                    inner join cliente 
                    on cliente.idCliente = pedido.idCliente
                    inner join usuario
                    on usuario.idUsuario = cliente.idUsuarioPromotor
                   WHERE cliente.idUsuarioPromotor = ".$idPromotor;
		
		
		$datosPedidos = $usuario->getDataSet($query);
		
		if (count($datosPedidos) > 0)
		{
			if ($idClienteFromDB == "0")
			{
				$r->script("app.seleccionandoPromotor = true;");
				$r->saError("Ocurri� un error al intentar obtener la informaci�n del Promotor.");
			}
			else
			{
				$imagenPromotor = "img/noimage.png";
				
				if (file_exists ("img/" . $idPromotor . ".jpg" )) 
				{
					 $imagenPromotor = "img/" . $idPromotor . ".jpg";
				}
				
				//set totales en pedidos
				$totalesPedidos = "
					app.pedidosTotal = ".$datosPedidos[0]["totalPedidos"].";
					app.pedidosSaldados = ".$datosPedidos[0]["saldados"].";
					app.pedidosSinSaldarEntregados = ".$datosPedidos[0]["porSaldarentregados"].";
                    app.pedidosSinSaldarNoEntregados = ".$datosPedidos[0]["porSaldarporentregar"].";
					app.pedidosCancelados = ".$datosPedidos[0]["cancelados"].";
					app.promotorImg = '".$imagenPromotor."';
					";
					
					
				
				//ahora obtenemos los totales de cargos y abonos
				$query = "SELECT getTotalCargosPromotor (".$idPromotor.") as totalCargos, 
                                 getTotalAbonosPromotor(".$idPromotor.") as totalAbonos,
                                 getTotalSaldosPorEntregarPromotor(".$idPromotor.") as totalSaldosPorEntregar,
                                 getTotalSaldosEntregadosPromotor(".$idPromotor.") as totalSaldosEntregados";
								
				$montos = $usuario->getDataSet($query);
				if (count($montos) > 0)
				{
					$cargosAbonos = "
								app.totalCargos = ".$montos[0]["totalCargos"].";
								app.totalAbonos = ".$montos[0]["totalAbonos"].";
                                app.totalSaldosPorEntregar = ".$montos[0]["totalSaldosPorEntregar"].";
                                app.totalSaldosEntregados = ".$montos[0]["totalSaldosEntregados"].";								
								//app.cargarPedidosTodos();
								";
					
					
					$r->script($totalesPedidos.
							$strPromotores . $cargosAbonos);
				}
				else
				{
					$r->script("app.seleccionandoPromotor = true;");
					$r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
				}
			}
			
			
			
		}
		else
		{
			$r->script("app.seleccionandoPromotor = true;");
			$r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
		}
		
		return $r;
	}
	$xajax->registerFunction("cargarPromotor");
		
		
	function cargarPromotores()
	{
		global $objSession;
		$r = new xajaxResponse();
		
		$usuario = new ModeloUsuario();
		
		$lst = $usuario->getAll("idUsuario, username, upper(concat(nombre, ' ' , apellidoPaterno, ' ', apellidoMaterno)) as nombreUsuario", 
				"", 
				"(idrol IN (4) or capturaPedido= 'SI') AND estatus = 'activo' ", 
				"");
		
		$pushes = "";
		
		foreach ($lst as $c)
		{
			$pushes .= "
					
						app.promotores.push({
							idUsuario: ".$c["idUsuario"].",
						    usuario: '".$c["username"]."',
							nombre: '".$c["nombreUsuario"]."'						
							
						});
					
					";
		}
		
		$r->script("
					app.promotores.splice(0, app.promotores.length);
							
				" . $pushes);

		$idPromotor = 0;
    
		if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
		{
			$idPromotor = $objSession->getIdUsuario();
			//             $r->mostrarMsgs("caimos en lo del promotor id= " . $idPromotor);
		}
		
		if ($idPromotor > 0)
		{
			$r->script(" app.isPromotor = true; app.seleccionarPromotor(".$idPromotor.");");
		}
		
		return $r;
	}	
	$xajax->registerFunction("cargarPromotores");
	
	function cargarPedidos($idPromotor, $quePedidos, $page, $pageSize)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();

		$queryFrom = "FROM cliente
							INNER JOIN pedido ON cliente.idCliente = pedido.idCliente
							WHERE idUsuarioPromotor = " . $idPromotor;

		$queryCount = "SELECT COUNT(*) cuantos 
						FROM (
							SELECT pedido.idCliente " .$queryFrom;
							

		$queryPage = "SELECT datos.*, getTotalCargosPedido(idPedido) as cargos, getTotalAbonosPedido(idPedido) as abonos, 
						getSaldoPedido(idPedido) as saldo, getDiasPagoVencidoPedido(idPedido) as diasVencido 
						FROM (
							SELECT pedido.idCliente, idPedido, fecha_capturado, pedido.estado, total, descuento, fecha_entregado,
							

											concat(cliente.nombre, ' ', cliente.apellidos) as nombreCliente, 
											cliente.idUsuarioPromotor  " .$queryFrom;

		
                            
		$queryWhereAnd = "";
		if ($quePedidos == "SALDADOS")
		{	
			$queryWhereAnd .= " AND saldo = 0";
		}
		else if ($quePedidos == "PORSALDAR")
		{
			$queryWhereAnd .= " AND saldo > 0 and pedido.estado <> 'ENTREGADO'";
		}
		else if ($quePedidos == "PORSALDARENTREGADOS")
		{
		    $queryWhereAnd .= " AND saldo > 0 and pedido.estado = 'ENTREGADO' ";
		}

		$queryCount .= $queryWhereAnd;
		$queryPage .= $queryWhereAnd;
		
		$queryCount .= " ORDER BY idpedido DESC ) AS datos;";

		$queryPage .= " ORDER BY idpedido DESC LIMIT ".$pageSize." OFFSET ".($page * $pageSize).") AS datos;";

		$noRows = $pedido->getDataSet($queryCount)[0]["cuantos"];		
		
		$lst = $pedido->getDataSet($queryPage);
	
		$pushes = "";
	
		foreach ($lst as $ped)
		{
			$lblEstado = "";
			switch($ped["estado"])
			{
				case "CAPTURADO";
					$lblEstado .= "<p><span class=\'badge badge-warning\'>CAPTURADO</span></p>";									
					break;
				case "AUTORIZADO";
					$lblEstado .= "<p><span class=\'badge\'>AUTORIZA CxC</span></p>";					
					break;
				case "PRODUCCION";
					$lblEstado .= "<p><span class=\'badge badge-info\'>PRODUCCI&Oacute;N</span></p>";				
					break;
				case "TERMINADO";
					$lblEstado .= "<p><span class=\'badge badge-primary\'>TERMINADO</span></p>";					
					break;
				case "ENTREGADO";
					$lblEstado .= "<p><span class=\'badge badge-success\'>ENTREGADO</span></p>";
					break;
				case "CANCELADO";
					$lblEstado .= "<p><span class=\'badge badge-danger\'>CANCELADO</span></p>";
					break;
			}
			
			$pushes .= "
			
						app.pedidos.push({
							idCliente: ".$ped["idCliente"].", 
							nombreCliente: '".$ped["nombreCliente"]."',
							idPedido: ".$ped["idPedido"].", 
							fecha_capturado: '".clsUtilerias::formatoFecha($ped["fecha_capturado"])."',
							fecha_entregado: '".clsUtilerias::formatoFecha($ped["fecha_entregado"])."',  
							cargos: '".$ped["cargos"]."',
							diasVencido: '".$ped["diasVencido"]."', 
							abonos: '".$ped["abonos"]."', 
							saldo: '".$ped["saldo"]."',		 
							estado: '".$ped["estado"]."',
							lblEstado: '".$lblEstado."'
						});
			
					";
		}
	
		$r->script("
					app.loading = false;
					app.totalReg = ".$noRows.";
					app.pedidos.splice(0, app.pedidos.length);
				
				" . $pushes);
	
		return $r;
	}
	$xajax->registerFunction("cargarPedidos");
	
	
	
	

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
