<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.recibodinero.inc.php";
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
		
	$filtroConSaldo = '';
	$isAdmin = false;
	$conSaldo = false;

	
	function cargarClientes($conSaldo)
	{
		$r = new xajaxResponse();
		
		$cliente = new ModeloCliente();
		global $_NOW_;
		global $objSession;
		$idUsuario= $objSession->getIdUsuario();
		$idRol= $objSession->getIdRol();

	
		if($idRol == 1 || $idRol == 2 ||$idRol == 7 ||$idRol == 6){
			$isAdmin = true;			
		}
		if($isAdmin){

				if(!$conSaldo){
					$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos, getSaldoReciboDinero(cliente.idCliente) as saldorecibo", 
					"", 
					"", 
					" idCliente desc");
				}else{
					$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos, getSaldoReciboDinero(cliente.idCliente) as saldorecibo", 
					"", 
					"getSaldoReciboDinero(cliente.idCliente) > 0", 
					" idCliente desc");
				}			
		}else{

				if(!$conSaldo){
					$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos, getSaldoReciboDinero(cliente.idCliente) as saldorecibo", 
					"", 
					"idUsuarioPromotor =".$idUsuario, 
					" idCliente desc");
				}else{
					$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos, getSaldoReciboDinero(cliente.idCliente) as saldorecibo", 
					"", 
					"idUsuarioPromotor =".$idUsuario." and getSaldoReciboDinero(cliente.idCliente) > 0" , 
					" idCliente desc");
				}	
		}		
		
		
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
							telefonos: '".$c["telefonos"]."',
							saldoRecibo: '".$c["saldorecibo"]."'
						});
					
					";
		}
		
		$r->script("
					app.clientes.splice(0, app.clientes.length);
							
				" . $pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarClientes");
	
	

	
	function guardarReciboDinero($idCliente, $monto, $disponible, $formapago, $referencia)
	{
		$r = new xajaxResponse();

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
			$r->saSuccess("Movimiento registrado con �xito");
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
			$r->saSuccess("Movimiento registrado con �xito");
			//$r->script("app.ingresarMovimiento = false; app.cargarDatosPedido(); app.cargarMovimientos();");
		}
		
		
		//$r->endDebug();
		return $r;
	}
	$xajax->registerFunction("guardarReciboDinero");
	
	
	

	
	function cargarRecibos($idCliente)
	{
		$r = new xajaxResponse();
		$recibo = new ModeloRecibodinero();
		$modeloMovrecibo = new ModeloMovrecibodinero();
		
				
		
		$movimientos = "";
		
		$lst = $modeloMovrecibo->getAll(" movrecibodinero.idmovReciboDinero, movrecibodinero.idReciboDinero
		,IF(movrecibodinero.idPedido<>0,movrecibodinero.idPedido,'N/A') AS pedido, movrecibodinero.movimiento, 
		movrecibodinero.saldoActual, movrecibodinero.monto, movrecibodinero.observaciones, usuario.nombre",
		"INNER JOIN recibodinero on movrecibodinero.idReciboDinero = recibodinero.idReciboDinero 
		 INNER JOIN cliente on recibodinero.idCliente = cliente.idCliente
		 INNER JOIN usuario on movrecibodinero.id_usuario_movimiento = usuario.idUsuario",
		"cliente.idCliente =".$idCliente);

		foreach ($lst as $row)
		{
			$movimientos .= "
	
						app.movimientos.push({
							idMovReciboDinero: '".$row["idmovReciboDinero"]."',
							movimiento: '".$row["movimiento"]."',							
							idReciboDinero: '".$row["idReciboDinero"]."',
							idPedido: '".$row["pedido"]."',
							saldoActual: '". $row["saldoActual"] ."',
							monto: '". $row["monto"] ."',
							usuario: '". $row["nombre"] ."',
							observaciones: '". $row["observaciones"] ."'		
													
						});						
					";
	
		}
		
		
		$r->script($movimientos. " app.movimientos.splice(0, app.movimientos.length); " . $movimientos);
		return $r;

	}
	$xajax->registerFunction("cargarRecibos");
	
	
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
	

	$strTablaListado = "";

	$modeloMovrecibo = new ModeloMovrecibodinero();
	
	$modeloMovrecibo->__fillable=array("idmovReciboDinero","cliente","idReciboDinero","idPedido","movimiento","monto","observaciones");
	$modeloMovrecibo->__fillableHeader=array("id","Cliente","No Recibo","No Pedido","Movimiento","Monto","Observaciones");
	
	$lst = $modeloMovrecibo->getAll(" movrecibodinero.idmovReciboDinero, CONCAT(cliente.nombre,' ', cliente.apellidos)as cliente
	,movrecibodinero.idReciboDinero, movrecibodinero.idPedido, movrecibodinero.movimiento, movrecibodinero.monto, movrecibodinero.observaciones",
	"INNER JOIN recibodinero on movrecibodinero.idReciboDinero = recibodinero.idReciboDinero 
	INNER JOIN cliente on recibodinero.idCliente = cliente.idCliente",
	"cliente.idCliente = 1573");
			
	$strTablaListado = $modeloMovrecibo->getTableHTML($lst, "tblListado", false, false, "Aplicacion");
	




