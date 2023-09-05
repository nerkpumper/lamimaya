<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.recibodinero.inc.php";
	require_once FOLDER_MODEL. "model.formapago.inc.php";
	require_once FOLDER_MODEL. "model.movrecibodinero.inc.php";
	

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

	function cargarClienteDePedido($idPedido)
	{
		$r = new xajaxResponse();

		$pedido = new ModeloPedido();

		$pedido->getPedido($idPedido, " LIMIT 1");

		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se pudo obtener informaci�n del Pedido.");
			// $r->script("app.seleccionarOtroPedido();");
			return $r;
		}

		$datosCliente = "";

		
		$datosCliente .= "app.filtroNombreCliente = '".$pedido->getPedidoDato("cteNombre"). " ". $pedido->getPedidoDato("cteApellidos") ."';";
		
		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosCliente);

		return $r;
	}
	$xajax->registerFunction("cargarClienteDePedido");

	function cargarCliente($idCliente)
	{
		$r = new xajaxResponse();
	
		$clientes = new ModeloCliente();
	
		$lst = $clientes->getAll("cliente.credito, cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.email, cliente.estado, cliente.rfc, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" cliente.idCliente = " . $idCliente);
	
		$strClientes = "";
		
		$idClienteFromDB = "0";
		
	
		foreach ($lst as $row)
		{
	
			$idClienteFromDB = $row["idCliente"];
			$strClientes .= "
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
							 app.cteCredito = ".$row["credito"]. ";
					                                      ";
		}
		
		if ($strClientes == "")
		{
			$r->script("app.idCliente = 0; app.seleccionandoCliente = true;");
			$r->saError("No se ha podido obtener la informaci�n del Cliente. Verifique o seleccione algun otro.");
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
				$r->saError("Ocurri� un error al intentar obtener la informaci�n del Cliente.");
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
				$query = "SELECT getTotalReciboDinero (".$idCliente.") as totalCargos, getSaldoReciboDinero (".$idCliente.") as totalAbonos, getTotalSaldosCliente (".$idCliente.") as totalx";
				
				$montos = $clientes->getDataSet($query);
				if (count($montos) > 0)
				{
					$cargosAbonos = "
								app.totalCargos = ".$montos[0]["totalCargos"].";
								app.totalAbonos = ".$montos[0]["totalAbonos"].";
								app.totalSaldo = ".$montos[0]["totalx"].";								
								
								";
					
					
					$r->script($totalesPedidos.
							$strClientes . $cargosAbonos);
				}
				else
				{
					$r->script("app.seleccionandoCliente = true;");
					$r->saError("Ocurri� un error al intentar obtener la informaci�n del Cliente.");
				}
			}
			
			
			
		}
		else
		{
			$r->script("app.seleccionandoCliente = true;");
			$r->saError("Ocurri� un error al intentar obtener la informaci�n del Cliente.");
		}
		
		return $r;
	}
	$xajax->registerFunction("cargarCliente");
		
		
	function cargarClientes()
	{
		$r = new xajaxResponse();
		
		$cliente = new ModeloCliente();
		
		$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos", 
				"", 
				"", 
				" idCliente desc");
		
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
					app.clientes.splice(0, app.clientes.length);
							
				" . $pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarClientes");
	
	function cargarPedidos($idCliente, $quePedidos)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
			$query = "SELECT * 
					  FROM (
							SELECT idCliente, idPedido, fecha_capturado, getTotalCargosPedido(idPedido) as cargos, getTotalAbonosPedido(idPedido) as abonos, getSaldoPedido(idPedido) as saldo, estado, total, descuento
							FROM pedido) as datos
					  WHERE idCliente = " . $idCliente;
		
		if ($quePedidos == "SALDADOS")
		{	
			$query .= " AND saldo = 0";
		}
		else if ($quePedidos == "PORSALDAR")
		{
			$query .= " AND saldo > 0";
		}
		
		$lst = $pedido->getDataSet($query .  "  ORDER BY idPedido desc");
	
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
							fecha_capturado: '".clsUtilerias::formatoFecha($ped["fecha_capturado"])."', 
							cargos: '".$ped["cargos"]."', 
							abonos: '".$ped["abonos"]."', 
							saldo: '".$ped["saldo"]."',		 
							estado: '".$ped["estado"]."',
							lblEstado: '".$lblEstado."'
						});
			
					";
		}
	
		$r->script("
					app.pedidos.splice(0, app.pedidos.length);
				
				" . $pushes);
	
		return $r;
	}
	$xajax->registerFunction("cargarPedidos");

	
	function guardarReciboDinero($idCliente, $monto, $disponible, $formapago, $referencia)
	{
		$r = new xajaxResponse();
		if ($disponible == '')
			$disponible = 0;
			


// $r->mostrarAviso("bien " . $disponible ." ". __LINE__); return $r;
		//$r->starDebug();
		$recibo = new ModeloRecibodinero();
		$recibo->setIdCliente($idCliente);
		//$recibo->setMonto($monto);
		$recibo->setDisponible($disponible);
		$recibo->setFormaPago($formapago);
		$recibo->setDateAndUser("captura");
		$recibo->setReferencia($referencia);
		$recibo->Guardar();
		$idReciboDinero=$recibo->getIdReciboDinero();
		//$r->endDegug();
		//return $r;
		if ($recibo->getError())
		{
			$r->saError($recibo->getStrError());
			return $r;
		}
		else
		{
			$r->saSuccess("Movimiento registrado con éxito");
			$r->script("app.ingresarMovimiento = false; app.cargarDatosPedido(); app.cargarMovimientos();");
		}
	
		$movrecibodinero = new ModeloMovrecibodinero();
		$movrecibodinero->setIdReciboDinero($recibo->getIdReciboDinero());
		$movrecibodinero->setMonto($monto);
		$movrecibodinero->setDateAndUser("movimiento");
		$movrecibodinero->setObservaciones($referencia);
		$movrecibodinero->setMovimiento("GENERARECIBO");
		$movrecibodinero->Guardar();
		//$r->endDegug();
		
		if ($movrecibodinero->getError())
		{
			$r->saError($movrecibodinero->getStrError());
			return $r;
		}
		else
		{
			$r->saSuccess("Movimiento registrado con éxito");
			$r->script("setTimeout( function() { app.clearForm(); app.seleccionarCliente(app.idCliente); }, 500 );");
		}
		// $r->mostrarAviso("bien " . __LINE__);
		
		//$r->endDebug();
		return $r;
	}
	$xajax->registerFunction("guardarReciboDinero");
	
	
	

	
	function cargarRecibos($idCliente)
	{
		$r = new xajaxResponse();
		$recibo = new ModeloRecibodinero();
		
				
		//$r->starDebug();
		$movimientos = "";
		//
		 $lstMovimientos = $recibo->getAll("recibodinero.idReciboDinero,formapago.descripcion AS formaPago, 
		 		recibodinero.disponible, recibodinero.referencia, recibodinero.monto, recibodinero.fecha_captura",
				"INNER JOIN formapago ON recibodinero.formaPago = formapago.idFormaPago",
				"recibodinero.idCliente = " . $idCliente ,
				"recibodinero.idReciboDinero DESC");
		//($recibos-getAll);	
		   
		//return $r;

		foreach ($lstMovimientos as $row)
		{
			$movimientos .= "
	
						app.movimientos.push({
							idReciboDinero: '".$row["idReciboDinero"]."',							
							disponible: '".$row["disponible"]."',
							formaPago: '".$row["formaPago"]."',
							referencia: '".$row["referencia"]."',
							monto: '". $row["monto"] ."',		
							fecha_captura: '".clsUtilerias::formatoFecha($row["fecha_captura"])."'						
						});						
					";
	
		}
		//$r->script($movimientos);
		
		$r->script($movimientos. " app.movimientos.splice(0, app.movimientos.length); " . $movimientos);
		return $r;
	//$r->endDebug();
		//return $r;
	}
	$xajax->registerFunction("cargarRecibos");
	
	/*function cargarTotales($idCliente)
	{
		$r = new xajaxResponse();
		
		$recibo = new ModeloRecibodinero();
		$r->mostrarAviso(" soy un aviso");
		return $r;
		$montos = $recibo->getAll("sum(monto) as totalrecibo, SUM(disponible) as totaldisponible, (SUM(monto)-SUM(disponible)) totalusado ",
				"",
				"idCliente = " . $idCliente);
			
		$datosMontos = "";
		$datosMontos .= "app.totalrecibo = '".$montos["totalrecibo"]."';";
		$datosMontos .= "app.totalsaldo= '".$montos["totaldisponible"]."';";
		$datosMontos .= "app.totalutilizado = '".$montos["totalusado"]."';";

		return $r;
	}
	$xajax->registerFunction("cargarTotales");*/
	
	
	
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
	$fp = new ModeloFormapago();
	$listaFormaPago = $fp->getAll("idFormaPago, concat(clave,' - ', descripcion) as formapago", "", "", "idFormaPago");
	

	