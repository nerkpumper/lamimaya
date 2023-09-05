<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	
	
	

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

	
	function saveCreditoPromotor($idPromotor, $credito, $index)
	{
		$r = new xajaxResponse();
	
		$usuario = new ModeloUsuario();
		
		$usuario->setIdUsuario($idPromotor);
		
		if ($usuario->getIdUsuario() <= 0)
		{
			$r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
			return $r;			
		}
		else
		{
// 			$r->saSuccess("Si se cargo el cliente");
		}
		
		$usuario->setCredito($credito);
		
		$usuario->Guardar();
		
		if ($usuario->getError())
		{
			$r->saError("Ocurrió un error al intentar guardar los datos del Promotor. " . $usuario->getStrError());
			return $r;
		}
		else 
		{
			$r->saSuccess("El Crédito se a asignado al Promotor correctamente.");
			
			$cred = "-";
			$usado = "-";
			$disponible = "-";
						
			if (doubleval($usuario->getCredito()) > 0)
			{
				$cred = number_format($usuario->getCredito(),2);
				$usado = number_format($usuario->getUsado(),2);
				$disponible = number_format( doubleval($usuario->getCredito()) - doubleval($usuario->getUsado()),2);
			}		
			
			$r->script("
					
					app.promotoresFiltradosPorNombre[".$index."].numericcredito = ".$usuario->getCredito().";
					app.promotoresFiltradosPorNombre[".$index."].credito = '".$cred."';
					app.promotoresFiltradosPorNombre[".$index."].usado = '".$usado."';
					app.promotoresFiltradosPorNombre[".$index."].disponible = '".$disponible."';
					
					");
		}
	
	
		return $r;
	}
	$xajax->registerFunction("saveCreditoPromotor");
	

	function cargarPromotor($idPromotor)
	{
		$r = new xajaxResponse();
	
		$promotores = new ModeloPromotor();
	
		$lst = $promotores->getAll("cliente.idPromotor, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.email, cliente.estado, cliente.rfc, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" cliente.idPromotor = " . $idPromotor);
	
		$strPromotores = "";
		
		$idPromotorFromDB = "0";
		
	
		foreach ($lst as $row)
		{
	
			$idPromotorFromDB = $row["idPromotor"];
			$strPromotores .= "
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
		
		if ($strPromotores == "")
		{
			$r->script("app.idPromotor = 0; app.seleccionandoPromotor = true;");
			$r->saError("No se ha podido obtener la información del Promotor. Verifique o seleccione algun otro.");
			return $r;
		}
		
		//ahora obtenemos totales en pedidos
		$query = "SELECT IFNULL(SUM(1), 0) as totalPedidos, IFNULL(SUM(IF(saldo = 0, 1, 0)),0)  as saldados, IFNULL(SUM(IF(saldo > 0, 1, 0)),0)  as porSaldar, IFNULL(SUM(IF(estado = 'CANCELADO', 1, 0)),0)  as cancelados
                    FROM pedido
                   WHERE idPromotor = ".$idPromotor;
		
				
		$datosPedidos = $promotores->getDataSet($query);
		
		if (count($datosPedidos) > 0)
		{
			if ($idPromotorFromDB == "0")
			{
				$r->script("app.seleccionandoPromotor = true;");
				$r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
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
				$query = "SELECT getTotalCargosPromotor (".$idPromotor.") as totalCargos, getTotalAbonosPromotor(".$idPromotor.") as totalAbonos";
								
				$montos = $promotores->getDataSet($query);
				if (count($montos) > 0)
				{
					$cargosAbonos = "
								app.totalCargos = ".$montos[0]["totalCargos"].";
								app.totalAbonos = ".$montos[0]["totalAbonos"].";								
								app.cargarPedidosTodos();
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
		$r = new xajaxResponse();
// 		$r->mostrarAviso("bien"); return $r;
		$promotor = new ModeloUsuario();
		
		$lst = $promotor->getAll("idUsuario, username, email, nombre, apellidoPaterno, apellidoMaterno, credito, usado, (credito - usado) as disponible ", 
				"", 
				" idRol IN (4,2, 8) AND estatus = 'activo' AND idUsuario > 1 ", 
				"");
		
		$pushes = "";
		
		foreach ($lst as $c)
		{
			$credito = "-";
			$usado = "-";
			$disponible = "-";
			
			
			if (doubleval($c["credito"]) > 0)
			{
				$credito = number_format($c["credito"], 2);
				$usado = number_format($c["usado"],2);
				$disponible = number_format($c["disponible"], 2);
			}			
			
			
			$pushes .= "
					
						app.promotores.push({
							idPromotor: ".$c["idUsuario"].",
							nombre: '".mb_strtoupper($c["nombre"]). " " . mb_strtoupper($c["apellidoPaterno"])." ".mb_strtoupper($c["apellidoMaterno"])."',
							username: '".mb_strtoupper($c["username"])."',
							email: '".$c["email"]."',						
							numericcredito: '".$c["credito"]."',
							credito: '".$credito."',
							usado: '".$usado."',
							disponible: '".$disponible."'
						});
					
					";
		}
		
		$r->script("
					app.promotores.splice(0, app.promotores.length);
							
				" . $pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarPromotores");
	
	function cargarPedidos($idPromotor, $quePedidos)
	{
		$r = new xajaxResponse();
	
		$pedido = new ModeloPedido();
	
		$query = "SELECT * 
				  FROM (
						SELECT idPromotor, idPedido, fecha_capturado, getTotalCargosPedido(idPedido) as cargos, getTotalAbonosPedido(idPedido) as abonos, getSaldoPedido(idPedido) as saldo, estado, total, descuento
						FROM pedido) as datos
				  WHERE idPromotor = " . $idPromotor  . "  ORDER BY idPedido desc";
		
		if ($quePedidos == "SALDADOS")
		{	
			$query .= " AND saldo = 0";
		}
		else if ($quePedidos == "PORSALDAR")
		{
			$query .= " AND saldo > 0";
		}
		
		$lst = $pedido->getDataSet($query);
	
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
							idPromotor: ".$ped["idPromotor"].", 
							idPedido: ".$ped["idPedido"].", 
							fecha_capturado: '".clsUtilerias::formatoFecha($ped["fecha_capturado"])."', 
							cargos: '".$ped["cargos"]."', 
							abonos: '".$ped["abonos"]."', 
							saldo: '".$ped["saldo"]."',	
							total: '".$ped["total"]."',
							descuento: '".$ped["descuento"]."',
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
