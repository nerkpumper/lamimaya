<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

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

	function cargarCliente($idCliente)
	{
		$r = new xajaxResponse();
	
		$clientes = new ModeloCliente();
	
		$lst = $clientes->getAll("cliente.idCliente, getSaldoReciboDinero(cliente.idCliente) disponibleRD, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.email, cliente.estado, cliente.rfc, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" cliente.idCliente = " . $idCliente);
	
		$strClientes = "";
		
		$idClienteFromDB = "0";
		
	
		foreach ($lst as $row)
		{
	
			$idClienteFromDB = $row["idCliente"];
			$strClientes .= "
							 app.rdDisponible = ".$row["disponibleRD"].";
		                     app.nombre = '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."';
		                     app.domicilio1 = '".mb_strtoupper($row["domicilio1"]). "';
		                     app.domicilio2 = '".mb_strtoupper($row["domicilio2"]). "';
		                     app.numero = '".mb_strtoupper($row["numero"]). "';
		                     app.colonia = '".mb_strtoupper($row["colonia"]). "';
		                     app.ciudad = '".mb_strtoupper($row["ciudad"]). "';
		                     app.telefonos = '".mb_strtoupper($row["telefonos"]). "';		                     
		                     app.email = '".($row["email"]). "';
		                     app.estado = '".$row["estado"]. "';
		                     app.rfc = '".mb_strtoupper($row["rfc"]). "';
		                     app.promotor = '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."';
					                                      ";
		}
		
		if ($strClientes == "")
		{
			$r->script("app.idCliente = 0; app.seleccionandoCliente = true;");
			$r->saError("No se ha podido obtener la información del Cliente. Verifique o seleccione algun otro.");
			return $r;
		}
		
		//ahora obtenemos totales en pedidos
		$query = "SELECT IFNULL(SUM(1), 0) as totalPedidos, IFNULL(SUM(IF(saldo = 0, 1, 0)),0)  as saldados, IFNULL(SUM(IF(saldo > 0, 1, 0)),0)  as porSaldar, IFNULL(SUM(IF(estado = 'CANCELADO', 1, 0)),0)  as cancelados
                    FROM pedido
                   WHERE idCliente = ".$idCliente;
		
				
		$datosPedidos = $clientes->getDataSet($query);
		
		if (count($datosPedidos) > 0)
		{
			if ($idClienteFromDB == "0")
			{
				$r->script("app.seleccionandoCliente = true;");
				$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
			}
			else
			{
				//set totales en pedidos
				$totalesPedidos = "
					app.pedidosTotal = ".$datosPedidos[0]["totalPedidos"].";
					app.pedidosSaldados = ".$datosPedidos[0]["saldados"].";
					app.pedidosSinSaldar = ".$datosPedidos[0]["porSaldar"].";
					app.pedidosCancelados = ".$datosPedidos[0]["cancelados"].";
			
					";
					
					
				
				//ahora obtenemos los totales de cargos y abonos
				$query = "SELECT getTotalCargosCliente (".$idCliente.") as totalCargos, getTotalAbonosCliente(".$idCliente.") as totalAbonos";
								
				$montos = $clientes->getDataSet($query);
				if (count($montos) > 0)
				{
					$cargosAbonos = "
								app.totalCargos = ".$montos[0]["totalCargos"].";
								app.totalAbonos = ".$montos[0]["totalAbonos"].";								
								app.cargarPedidosTodos();								
								";
					
					
					$r->script($totalesPedidos.
							$strClientes . $cargosAbonos);
				}
				else
				{
					$r->script("app.seleccionandoCliente = true;");
					$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
				}
			}
			
			
			
		}
		else
		{
			$r->script("app.seleccionandoCliente = true;");
			$r->saError("Ocurrió un error al intentar obtener la información del Cliente.");
		}
		
		return $r;
	}
	$xajax->registerFunction("cargarCliente");
		
		
	function cargarClientes($page, $pageSize, $filtroNombreCliente)
	{
		global $objSession;
		$r = new xajaxResponse();
		
		$cliente = new ModeloCliente();
		
		// $lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos", 
		// 		"", 
		// 		" idUsuarioPromotor = " .  $objSession->getIdUsuario(), 
		// 		" idCliente desc");
				
		$queryCount = "SELECT COUNT(*) cuantos
					FROM cliente 
					WHERE idUsuarioPromotor = " .  $objSession->getIdUsuario() .
					($filtroNombreCliente !== "" ? " AND CONCAT(cliente.nombre, cliente.apellidos) LIKE '%".$filtroNombreCliente."%' " : "") . "
					ORDER BY idCliente asc";
		
		$query = "SELECT cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos
					FROM cliente 
					WHERE idUsuarioPromotor = " .  $objSession->getIdUsuario() .
					($filtroNombreCliente !== "" ? " AND CONCAT(cliente.nombre, cliente.apellidos) LIKE '%".$filtroNombreCliente."%' " : "") . "
					ORDER BY idCliente asc 
					LIMIT ". $pageSize ." OFFSET " . ($page * $pageSize);
		

		$noRows = $cliente->getDataSet($queryCount)[0]["cuantos"];		
		$lst = $cliente->getDataSet($query);		


		$pushes = "";
		
		foreach ($lst as $c)
		{
			$pushes .= "
					
						app.clientes.push({
							idCliente: ".$c["idCliente"].",
							nombre: '". mb_strtoupper( $c["nombre"]). " " . mb_strtoupper( $c["apellidos"])."',							
							empresa: '".$c["empresa"]."', 
							domicilio1: '".$c["domicilio1"]."', 
							domicilio2: '".$c["domicilio2"]."', 
							email: '".$c["email"]."', 
							telefonos: '".$c["telefonos"]."'
						});
					
					";
		}
		
		$r->script("
					app.totalCliReg = ".$noRows.";
					app.clientes.splice(0, app.clientes.length);
							
				" . $pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarClientes");
	
	function cargarPedidos($idCliente, $quePedidos, $page, $pageSize)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();

		
		$queryFrom = "FROM pedido
						WHERE idCliente = " . $idCliente;

		$queryCount = "SELECT COUNT(*) cuantos 
						FROM (
							SELECT pedido.idCliente " .$queryFrom;
							

		$queryPage = "SELECT datos.*, getTotalCargosPedido(idPedido) as cargos, 
					              getTotalAbonosPedido(idPedido) as abonos, 
					              getSaldoPedido(idPedido) as saldo, 
					              getTotalCargosPedidoPromotor(idPedido) as cargospromotor, 
					              getTotalAbonosPedidoPromotor(idPedido) as abonospromotor, 
					              getSaldoPromotorPedido(idPedido) as saldopromotor
						FROM (
							SELECT idCliente, idPedido, fecha_capturado,  factura, 
					              estado, total, descuento  " .$queryFrom;

		
                            
		$queryWhereAnd = "";
		if ($quePedidos == "SALDADOS")
		{	
			$queryWhereAnd .= " AND saldo = 0";
		}
		else if ($quePedidos == "PORSALDAR")
		{
			$queryWhereAnd .= " AND saldo > 0";
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
							idPedido: ".$ped["idPedido"].",
							factura: '".$ped["factura"]."', 
							fecha_capturado: '".clsUtilerias::formatoFecha($ped["fecha_capturado"])."', 
							cargos: '".$ped["cargos"]."', 
							abonos: '".$ped["abonos"]."', 
							saldo: '".$ped["saldo"]."',		 
							cargospromotor: '".$ped["cargospromotor"]."', 
							abonospromotor: '".$ped["abonospromotor"]."', 
							saldopromotor: '".$ped["saldopromotor"]."',
							estado: '".$ped["estado"]."',
							lblEstado: '".$lblEstado."'
						});
			
					";

					
		}		

			$r->script("
				app.loading = false;
					app.totalReg = ".$noRows.";
					app.pedidos.splice(0, app.pedidos.length);
				"
				.$pushes);
	
		
	
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

	
	