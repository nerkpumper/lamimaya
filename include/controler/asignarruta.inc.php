<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.ruta.inc.php";
	require_once FOLDER_MODEL. "model.rutaenvio.inc.php";
	require_once FOLDER_MODEL. "model.rutaenviodetalle.inc.php";
	require_once FOLDER_MODEL. "model.rutaenviovehiculo.inc.php";
	require_once FOLDER_MODEL. "model.vehiculo.inc.php";
	require_once FOLDER_MODEL. "model.valesalida.inc.php";
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	function getNombreDia($intDia)
	{
		$res = "";

		switch($intDia)
		{
			case 1:
				$res = "LUNES";
				break;
			case 2:
				$res = "MARTES";
				break;
			case 3:
				$res = "MIERCOLES";
				break;
			case 4:
				$res = "JUEVES";
				break;
			case 5:
				$res = "VIERNES";
				break;
			case 6:
				$res = "SABADO";
				break;
			case 7:
				$res = "DOMINGO";
				break;

		}


		return $res;
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
		
	function obtenerRutas()
	{
		$r = new xajaxResponse();
	// $r->starDebug();
        $rutas = new ModeloRuta();

        $lstRutas = $rutas->getAll();

        $pushes = "app.rutas.splice(0, app.rutas.length);";
		
        foreach($lstRutas as $row)
        {
			// $r->mostrarAviso($row["nombre"]);
            $pushes .= " app.rutas.push({
                    id: ".$row["idRuta"].",
                    nombre: '".$row["nombre"]."',
                    descripcion: '".$row["descripcion"]."',
                    pedidos: 0
                });";
        }
		// $r->mostrarAviso($row["nombre"]);
		// $r->mostrarAviso($pushes);
        $r->script($pushes);
        // $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("obtenerRutas");

	function getIdRutaEnvio($dia, $mes, $anio, $idRuta, $turno)
	{
		$r = new xajaxResponse();
	
		$mes = $mes + 1;
		
		// $r->script(" setTimeout(function() { mdlExitWait(); } , 1000);");
		// $r->mostrarAviso(date("Y-m-d", strtotime($anio . '-' . $mes . '-'. $dia)));
		$rutaenvio = new ModeloRutaenvio();
			
		$fecha = date("Y-m-d", strtotime($anio . '-' . $mes . '-'. $dia));
		$rutaenvio->getDatosByFecha($fecha, $idRuta, $turno);

		if($rutaenvio->getIdRutaEnvio() == 0)
		{

			$rutaenvio->setidRuta($idRuta);
			$rutaenvio->setFecha($fecha);
			$rutaenvio->setTurno($turno);
			$rutaenvio->setDateAndUser("enviado");
			$rutaenvio->Guardar();

			if ($rutaenvio->getError())
			{
				$r->mostrarError($rutaenvio->getStrError());
				return $r;

			}
		}

		$rutaenvio->getDatosByFecha($fecha, $idRuta, $turno);

		if($rutaenvio->getIdRutaEnvio() == 0)
		{
			$r->mostrarAviso("No se pudo obtener ni generar un registro para la Ruta de Envio");
		}
		else
		{
			$r->script("app.idRutaEnvio = " . $rutaenvio->getIdRutaEnvio());
			
		}


		$r->script(" app.cargarRutaEnvioDetalle(); mdlExitWait(); ");
		return $r;
	}
	$xajax->registerFunction("getIdRutaEnvio");

	function getEnvioRutasMes($anio, $mes)
	{
		$r = new xajaxResponse();
		$mes = $mes + 1;
		// $r->starDebug();
		// $r->script(" setTimeout(function() { mdlExitWait(); } , 1000);");
		// $r->mostrarAviso(date("Y-m-d", strtotime($anio . '-' . $mes . '-'. $dia)));
		$rutaenvio = new ModeloRutaenvio();

		$query = "select idRutaEnvio, rutaenvio.idRuta, concat(ruta.nombre, ' - ', ruta.descripcion) ruta,CONVERT(DATE_FORMAT(fecha, '%d'),UNSIGNED INTEGER) dia, turno, 
maxml, maxpeso, estado, nopedidos, fecha
					from rutaenvio
					inner join ruta on rutaenvio.idRuta = ruta.idRuta
					where DATE_FORMAT(fecha, '%Y-%m')  = '".$anio."-".($mes < 10 ? "0" . $mes : $mes)."'
					order by 4, turno";

		// $r->mostrarAviso($query); return $r;

		$pushes = "app.rutasenviomes.splice(0, app.rutasenviomes.length); ";
		
		$lst = $rutaenvio->getDataSet($query);
		// $r->mostrarAviso($query); return $r;
		// $r->mostrarAviso("Regs: " . count($lst)); return $r;
		$hoy = date("Y-m-d");
		foreach ($lst as  $re) {
			// $fecha = new DateTime($row["fecha"]); 
			$fecha = $re["fecha"]; 
			// $fecha = "dsfds";

			$pushesOE = "";	
			if ($re["estado"] != "CREADA"){
				$query = "select rev.idRutaEnvioVehiculo, rev.estatus, v.placas, v.descripcion 
							from rutaenviovehiculo rev
							inner join vehiculo v on rev.idVehiculo = v.idVehiculo
							where rev.idrutaenvio = ". $re["idRutaEnvio"] ;

				$lstOE = $rutaenvio->getDataSet($query);
				foreach ($lstOE as  $oe) {
					$pushesOE .= "
							{
								idRutaEnvioVehiculo: ".$oe["idRutaEnvioVehiculo"].",
								estatus: '".$oe["estatus"]."',
								vehiculo: '".$oe["placas"] . " - " . $oe["descripcion"]."'
							},
					";
				}

			}

			$pushes .= " app.rutasenviomes.push({
					idRutaEnvio: ".$re["idRutaEnvio"].",
					idRuta: ".$re["idRuta"].",
					ruta: '".$re["ruta"]."',
					dia: ".$re["dia"].",
					turno: '".$re["turno"]."',
					maxml: ".$re["maxml"].",
					maxpeso: ".$re["maxpeso"].",
					estado: '".$re["estado"]."',					
					nopedidos: ".$re["nopedidos"].",
					puedeEditarse: ".($fecha < $hoy ? 'false' : 'true').",
					oe: [".$pushesOE."]
					
				
				});";
		}

		$r->script($pushes);
		
		$r->script(" setTimeout(function(){ app.ponerRutasEnvioEnCalendario(); }, 100);  ");
		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("getEnvioRutasMes");

	
	function cargarPedidosParaAsignar()
	{
		$r = new xajaxResponse();
		
		// $r->starDebug();
		// $r->script(" setTimeout(function() { mdlExitWait(); } , 1000);");
		// $r->mostrarAviso(date("Y-m-d", strtotime($anio . '-' . $mes . '-'. $dia)));
		$rutaenvio = new ModeloRutaenvio();

		// $query = "	select p.idPedido, p.estado, p.recogeentrega, concat(c.nombre, ' ', c.apellidos) cliente,
		// 				getMaxKGPedido(p.idPedido) maxkg, getMaxMLPedido(p.idPedido) maxml, p.tipoRuta,
		// 				p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega,
		// 				c.idUsuarioPromotor, p.id_usuario_capturado
		// 			from pedido p
		// 			inner join cliente c on p.idcliente = c.idcliente
		// 			where p.estado not in ('ENTREGADO', 'CANCELADO', 'ENRUTA')
		// 			and p.recogeentrega = 'ENTREGA'
		// 			and p.tipoRuta in ('SINRUTA', 'REENRUTAR')
		// 			and p.colocado = 'SI'
		
		// ";

		$query = "	select p.idPedido, p.estado, p.recogeentrega, DATE(p.fechaCompromiso)as fechaCompromiso, p.fechaAbierta, p.horaRecibe, concat(c.nombre, ' ', c.apellidos) cliente,
						getTotalKGValeSalida(vs.idValeSalida) maxkg, getMaxMLValeSalida(vs.idValeSalida) maxml, vs.idvalesalida, vs.tipoRuta,
						p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega,
						c.idUsuarioPromotor, p.id_usuario_capturado,
						if(vs.yaImpreso = 'SI' or vs.chkImprimirPedidoNoSaldado = 'SI' or vs.pagoVSEntrega = 'SI', 'SI', 'NO') listoParaSalir
					from pedido p
                    inner join valesalida vs on p.idpedido = vs.idpedido
					inner join cliente c on p.idcliente = c.idcliente
					where p.estado not in ('ENTREGADO', 'CANCELADO', 'ENRUTA')
					and p.recogeentrega = 'ENTREGA'
					and vs.tipoRuta in ('SINRUTA', 'REENRUTAR')
					and p.colocado = 'SI' ";

		// $r->mostrarAviso($query); return $r;

		$pushes = "app.pedidos.splice(0, app.pedidos.length); ";
		
		$lst = $rutaenvio->getDataSet($query);
		// $r->mostrarAviso($query); return $r;
		// $r->mostrarAviso("Regs: " . count($lst)); return $r;
		
		foreach ($lst as  $row) {
			$pushes .= " app.pedidos.push({
					idPedido: ".$row["idPedido"].", 
					idValeSalida: ".$row["idvalesalida"].",
					estado: '".$row["estado"]."', 
					recogeentrega: '".$row["recogeentrega"]."', 
					cliente: '".$row["cliente"]."',
					tipoRuta: '".$row["tipoRuta"]."',
					maxkg: ".$row["maxkg"].", 
					maxml: ".$row["maxml"].",
					fechaAbierta: '".$row["fechaAbierta"]."',
					fechaCompromiso: '".$row["fechaCompromiso"]."',
					personaEntrega: '".$row["personaEntrega"]."',
					horaRecibe: '".$row["horaRecibe"]."', 					
					domicilioEntrega: '".$row["domicilioEntrega"]."', 
					numeroEntrega: '".$row["numeroEntrega"]."', 
					coloniaEntrega: '".$row["coloniaEntrega"]."', 
					ciudadEntrega: '".$row["ciudadEntrega"]."',
					idUsuarioVenta: ".$row["id_usuario_capturado"].",
					idPromotor: ".$row["idUsuarioPromotor"].",
					listoParaSalir: '".$row["listoParaSalir"]."'
				
				});";
		}

		
		$r->script($pushes);		
		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarPedidosParaAsignar");

	
	function asignarValeSalidaARutaEnvio($index, $idRutaEnvio, $idValeSalida, $idPedido, $maxml, $maxkg, $fecha, $dia, $cliente, $turno, $nombreRuta, $idUsuarioVenta, $idPromotor )
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		// $r->mostrarAviso($idPedido. " - " . $maxml. " - " . $maxkg. " - " . $fecha. " - " . $cliente. " - " . $turno. " - " . $nombreRuta. " - " . $idUsuarioVenta. " - " . $idPromotor);
		// return $r;

		$red = new ModeloRutaenviodetalle();

		$red->setIdRutaEnvio($idRutaEnvio);
		$red->setIdValeSalida($idValeSalida);
		$red->setIdPedido($idPedido);
		$red->setMaxml($maxml);
		$red->setMaxpeso($maxkg);


		//para el promotor
		NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,$idPromotor, 
											"Vale Salida " . $idValeSalida." de Pedido " . $idPedido . " asignado a Ruta", 
											"El Vale de Salida " . $idValeSalida . " del pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido asignado a la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

		//para quien asigna/desasigna		
		NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
											"Vale Salida " . $idValeSalida." de Pedido " . $idPedido . " asignado a Ruta", 
											"Has asignado el Vale de Salida " . $idValeSalida . " del pedido " . $idPedido . " del Cliente '" . $cliente . "' a la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
		
		if ($idUsuarioVenta != $idPromotor)
		{
			//para el vendedor
			NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
											"Vale Salida " . $idValeSalida." de Pedido " . $idPedido . " asignado a Ruta", 
											"El Vale de Salida " . $idValeSalida . " del pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido asignado a la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
		}



		$red->Guardar();

		if ($red->getError())
		{
			$r->mostrarError($red->getStrError());
		}
		else
		{
			$r->script(" app.pedidos.splice(".$index.", 1);  mdlExitWait(); setTimeout(function(){ app.cargarRutaEnvioDetalle(); }, 100); ");
		}
		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("asignarValeSalidaARutaEnvio");

	
	function cargarRutaEnvioDetalle($idRutaEnvio)
	{
		$r = new xajaxResponse();
		
		// $r->starDebug();
		// $r->script(" setTimeout(function() { mdlExitWait(); } , 1000);");
		// $r->mostrarAviso(date("Y-m-d", strtotime($anio . '-' . $mes . '-'. $dia)));
		$rutaenvio = new ModeloRutaenvio();


		$query = "	select red.idRutaEnvioDetalle, p.idPedido, p.estado, DATE(p.fechaCompromiso) as fechaCompromiso, fechaAbierta, p.recogeentrega, concat(c.nombre, ' ', c.apellidos) cliente,
						red.maxml, red.maxpeso, red.orden,
						p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega,
						c.idUsuarioPromotor, p.id_usuario_capturado, 
						re.maxml hmaxml, re.maxpeso hmaxpeso, re.fecha, re.estado, red.idValeSalida,
						if(vs.yaImpreso = 'SI' or vs.chkImprimirPedidoNoSaldado = 'SI' or vs.pagoVSEntrega = 'SI', 'SI', 'NO') listoParaSalir,
						ifnull(rev.idRutaEnvioVehiculo ,0) idRutaEnvioVehiculo,
						ifnull(rev.idVehiculo,0) idVehiculo, ifnull(red.ordenVehiculo, 0) ordenVehiculo
					from rutaenviodetalle red
					inner join rutaenvio re on red.idRutaEnvio = re.idRutaEnvio
					left join rutaenviovehiculo rev on red.idRutaEnvioVehiculo = rev.idRutaEnvioVehiculo
					inner join pedido p on red.idPedido = p.idPedido
					inner join valesalida vs on red.idValeSalida = vs.idValeSalida
					inner join cliente c on p.idcliente = c.idcliente
					where red.idrutaenvio = " . $idRutaEnvio . " ORDER BY red.orden, red.idRutaEnvioDetalle";

		// $r->mostrarAviso($query); return $r;

		$pushes = "app.rutaenviodetalle.splice(0, app.rutaenviodetalle.length); ";
		
		$lst = $rutaenvio->getDataSet($query);
		// $r->mostrarAviso($query); return $r;
		// $r->mostrarAviso("Regs: " . count($lst)); return $r;
		
		$hmaxml = 0;
		$hmaxpeso = 0;
		$hoy = date("Y-m-d");
		$fecha = "";
		$estado = "CREADA";
		if (count($lst) > 0)
		{
			foreach ($lst as  $row) {

				$hmaxml = $row["hmaxml"];
				$hmaxpeso = $row["hmaxpeso"];
				$fecha = $row["fecha"];
				$estado = $row["estado"];


				$pushes .= " app.rutaenviodetalle.push({
						key: '".$row["idValeSalida"] . date_timestamp_get(date_create()) .rand().rand().rand()."',
						idRutaEnvioDetalle: ".$row["idRutaEnvioDetalle"].",	
						idPedido: ".$row["idPedido"].", 
						idValeSalida: ".$row["idValeSalida"].", 
						orden: ".$row["orden"].", 
						estado: '".$row["estado"]."', 
						recogeentrega: '".$row["recogeentrega"]."', 
						cliente: '".$row["cliente"]."',					
						maxkg: ".$row["maxpeso"].", 
						maxml: ".$row["maxml"].",
						personaEntrega: '".$row["personaEntrega"]."', 
						domicilioEntrega: '".$row["domicilioEntrega"]."', 
						numeroEntrega: '".$row["numeroEntrega"]."', 
						coloniaEntrega: '".$row["coloniaEntrega"]."', 
						ciudadEntrega: '".$row["ciudadEntrega"]."',
						idUsuarioVenta: ".$row["id_usuario_capturado"].",
						idPromotor: ".$row["idUsuarioPromotor"].",
						listoParaSalir: '".$row["listoParaSalir"]."',
						idRutaEnvioVehiculo: ".$row["idRutaEnvioVehiculo"].",
						vehiculoAsignado: ". $row["idVehiculo"] ." ,
						ordenVehiculoAsignado: ". $row["ordenVehiculo"] ." ,
						idRutaEnvioVehiculoOriginal: ".$row["idRutaEnvioVehiculo"].",
						vehiculoAsignadoOriginal: ". $row["idVehiculo"] ." ,
					
					});";
			}
		} 

		
		$r->script("app.rutaEnvioMaxML = " . $hmaxml);
		$r->script("app.rutaEnvioMaxKG = " . $hmaxpeso);
		if($fecha != "")
		{
			// $r->script("alert ('".$fecha." - " . $hoy . "')");
			// if ($fecha < $hoy)				
			// 	$r->script("alert ('fecha < hoy = SI')");
			// else
			// 	$r->script("alert ('fecha < hoy = NO')");

			$r->script("app.rutaEnvioEnviado = " . ($estado != 'CREADA' ? 'true' : 'false'));
			// $r->script("app.blnPuedeAsignarPedidos = " . ($fecha < $hoy || $estado != 'CREADA'? 'false' : 'true'));
			$r->script("app.blnPuedeAsignarPedidos = " . ($fecha < $hoy ? 'false' : 'true'));
			// $r->mostrarAviso("fecha != '' ");
		}
		else
		{

			// $r->mostrarAviso("fecha == '' ");
			$r->script("app.rutaEnvioEnviado = false");
			// if (count($lst) == 0)
			// 	$r->script("app.blnPuedeAsignarPedidos = false");
			// else
				$r->script("app.blnPuedeAsignarPedidos = true");
		}

		if ($estado != 'CREADA'){
			$r->script(" setTimeout( function(){ xajax_obtenerVehiculosRutaEnvio(".$idRutaEnvio.");}, 500) ");
		} 
		
		$r->script($pushes);		
		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarRutaEnvioDetalle");

	function desAsignarPedidoDeRuta($idRutaEnvio, $idRutaEnvioDetalle, $idValeSalida, $idPedido, $fecha, $dia, $cliente, $turno, $nombreRuta, $idUsuarioVenta, $idPromotor)
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		

		$red = new ModeloRutaenviodetalle();

		$red->setIdRutaEnvioDetalle($idRutaEnvioDetalle);
		$orden = $red->getOrden();		
		$red->Borrar();

		if ($red->getError())
		{
			$r->mostrarError($red->getStrError());
		}
		else
		{
			$query = "update rutaenviodetalle set orden = orden - 1 where idRutaEnvio =  " . $idRutaEnvio . " and orden >= " . $orden;

			$red->executeRaw($query);

			if ($red->getError())
			{
				$r->mostrarError($red->getStrError());
			}
			else
			{
				// $query = "	update rutaenvio re
				// 			LEFT join (select idRutaEnvio, max(maxml) maxml, sum(maxpeso) peso
				// 					from rutaenviodetalle
				// 					where idRutaEnvio = ".$idRutaEnvio." group by idRutaEnvio) d
				// 			set re.maxml = IFNULL(d.maxml,0 ), re.maxpeso = IFNULL(d.peso,0), re.noPedidos = IFNULL(re.noPedidos, 1) - 1
				// 			where re.idRutaEnvio = " . $idRutaEnvio;

				// $red->executeRaw($query);

				// if ($red->getError())
				// {
				// 	$r->mostrarError($red->getStrError());
				// }
				// else
				// {
					//para el promotor
					NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
											"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " retirado de Ruta", 
											"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido retirado de la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					
					//para quien lo asigna/desasigna
					NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
														"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " retirado de Ruta", 
														"Has retirado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' de la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					if ($idUsuarioVenta != $idPromotor)
					{
						//para el que vende
						NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
														"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " retirado a Ruta", 
														"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido retirado de la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					}
					
					$r->script(" setTimeout(function(){ app.cargarRutaEnvioDetalle(); app.cargarPedidosParaAsignar(); mdlExitWait(); }, 100); ");
				// }
				
			}

		}
		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("desAsignarPedidoDeRuta");

	function ordenMas($actual, $areemplazar)
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		$origen = new ModeloRutaenviodetalle();
		$destino = new ModeloRutaenviodetalle();

		$origen->setIdRutaEnvioDetalle($actual);
		$destino->setIdRutaEnvioDetalle($areemplazar);

		if ($origen->getIdRutaEnvioDetalle() > 0 && $destino->getIdRutaEnvioDetalle() > 0)
		{
			$aux = $origen->getOrden();
			$origen->setOrden($destino->getOrden());
			$destino->setOrden($aux);

			$origen->Guardar();
			$destino->Guardar();		

			if ($origen->getError() || $destino->getError())
			{
				$r->mostrarError($origen->getError() . ' ' . $destino->getError());
			}
			else
			{
				$r->script(" setTimeout(function(){ app.cargarRutaEnvioDetalle(); a }, 100); ");
			}	
		}


		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("ordenMas");

	function obtenerVehiculos()
	{
		$r = new xajaxResponse();
	// $r->starDebug();
        $vehiculos = new ModeloVehiculo();

        $lstVehiculos = $vehiculos->getAll();

        $pushes = "app.vehiculos.splice(0, app.vehiculos.length);";
		
        foreach($lstVehiculos as $row)
        {
			// $r->mostrarAviso($row["nombre"]);
            $pushes .= " app.vehiculos.push({
                    id: ".$row["idVehiculo"].",
					selected: false,
                    placa: '".$row["placas"]."',
                    descripcion: '".$row["descripcion"]."',
					km: '',
					vs: [],
					vsid: [],
					maxml: 0,
					kg: 0
                });";
        }
		// $r->mostrarAviso($row["nombre"]);
		// $r->mostrarAviso($pushes);
        $r->script($pushes);
		// $r->script(" setTimeout(function() {
		// 					$('.i-checks').iCheck({
		// 					checkboxClass: 'icheckbox_square-green',
		// 					radioClass: 'iradio_square-green'
		// 				});
		// 		}, 1000);
		// 	");
        // $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("obtenerVehiculos");

	function asignarVehiculos($detalleEnvio, $nombreRuta, $dia, $fecha, $turno)
	{
		$r = new xajaxResponse();
		// $r->starDebug();
		$vehiculoTr = new ModeloRutaenviovehiculo();
		$idRutaEnvio = $detalleEnvio["idRutaEnvio"];	
		$blnDoCommit = true;	
		
		$vehiculoTr->transaccionIniciar();

		foreach($detalleEnvio["vehiculos"] as $v){
			$vehiculo = new ModeloRutaenviovehiculo();

			$placa = $v["placa"];
			$idVehiculo = $v["id"];
			$actualIdRutaEnvioVehiculo = $v["idRutaEnvioVehiculo"];
			$selected = $v["selected"];
			

			if ($actualIdRutaEnvioVehiculo > 0)
			{
				$vehiculo->setIdRutaEnvioVehiculo($actualIdRutaEnvioVehiculo);

				// $r->mostrarAviso("Vehiculo " . $placa . " Se actualizará");
			}
			else
			{
				// $r->mostrarAviso("Vehiculo " . $placa . " Nuevo");
			}

			$vehiculo->setIdRutaEnvio($idRutaEnvio);
			$vehiculo->setIdVehiculo($idVehiculo);
			$vehiculo->setKilometrajeInicial($v["km"]);
			$vehiculo->setEstatusASIGNADO();
			$vehiculo->setDateAndUser("asignado");
			
			if ($selected)
			{
			    $vehiculo->Guardar();
			}
			else
			{
			    if ($vehiculo->getIdRutaEnvioVehiculo() > 0)
				{
				    $vehiculo->Borrar();
					continue;
				}
			}

			// $r->mostrarAviso($placa . " Selected " . $v["selected"]);
			// continue;

			if (!$vehiculo->getError())
			{

				$ordenVehiculo = 1;
				foreach($v["vs"] as $vs){				
					$idRutaEnvioDetalle = $vs["idRutaEnvioDetalle"];
					$idPromotor = $vs["idPromotor"];
					$idUsuarioVenta = $vs["idUsuarioVenta"];
					$idPedido = $vs["idPedido"];
					$idValeSalida = $vs["idValeSalida"];
					$cliente = $vs["cliente"];
					$vehiculoAsignado = $vs["vehiculoAsignado"];
					$vehiculoAsignadoOriginal = $vs["vehiculoAsignadoOriginal"];

					

					// //para el administrador
					// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 						"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 						"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					
					// //para quien lo asigna/desasigna
					// NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"Has Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					// if (true || $idUsuarioVenta != $idPromotor)
					// {
					// 	//para el que vende
					// 	NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					// }

					// //para el administrador
					// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 						"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 						"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					
					// //para quien lo asigna/desasigna
					// NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"Has Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					// if (true || $idUsuarioVenta != $idPromotor)
					// {
					// 	//para el que vende
					// 	NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					// }


					
					$rutaEnvioDetalle = new ModeloRutaenviodetalle();
					$rutaEnvioDetalle->setIdRutaEnvioDetalle($idRutaEnvioDetalle);

					if ($rutaEnvioDetalle->getIdRutaEnvioDetalle() > 0)
					{
						$rutaEnvioDetalle->setEnRutaSI();						
						$rutaEnvioDetalle->setIdRutaEnvioVehiculo($vehiculo->getIdRutaEnvioVehiculo());												
						$rutaEnvioDetalle->setOrdenVehiculo($ordenVehiculo);

						$rutaEnvioDetalle->Guardar();

						if ($rutaEnvioDetalle->getError())
						{
							$r->mostrarError("No se pudo actualizar el detalle del envio. ". $rutaEnvioDetalle->getStrError());
							$blnDoCommit = false;
							break;
						}
					}
					else
					{
						$r->mostrarError("No se pudo obtener el detalle de la ruta de envio");
						$blnDoCommit = false;
						break;
					}



					// VALE SE SALIDA
					$valeSalida = new ModeloValesalida();
					// $r->mostrarAviso("bien " . __LINE__); return $r;							
					$valeSalida->setIdValeSalida($idValeSalida);

					if ($valeSalida->getIdValeSalida() > 0)
					{
						$valeSalida->setIdRutaEnvio($idRutaEnvio);
						$valeSalida->setDateAndUser("enruta");
						$valeSalida->setEstadoENRUTA();

						$valeSalida->Guardar();

						if ($valeSalida->getError())
						{
							$r->mostrarError("No se pudo actualizar el Vale de Salida. ". $valeSalida->getStrError());
							$blnDoCommit = false;
							break;
						}
					}
					else
					{
						$r->mostrarError("No se pudo obtener el dato de Vale de Salida");
						$blnDoCommit = false;
						break;
					}

					$ordenVehiculo++;
				}
			}
			else
			{
				$r->mostrarError("No se pudo almacenar el registro del Vehículo para la Ruta de Envio. " . $vehiculo->getStrError());
				$blnDoCommit = false;
				break;
			}

			
		}

		if ($blnDoCommit)
		{
			foreach($detalleEnvio["vsNoEnviados"] as $vsne){
				
				$idPromotor = $vs["idPromotor"];
				$idUsuarioVenta = $vs["idUsuarioVenta"];
				$idPedido = $vs["idPedido"];
				$idValeSalida = $vs["idValeSalida"];

				// VALE SE SALIDA
				$valeSalida = new ModeloValesalida();
				// $r->mostrarAviso("bien " . __LINE__); return $r;							
				$valeSalida->setIdValeSalida($idValeSalida);

				if ($valeSalida->getIdValeSalida() > 0)
				{
					$valeSalida->setIdRutaEnvio(0);					
					$valeSalida->setTipoRutaREENRUTAR();

					$valeSalida->Guardar();

					if ($valeSalida->getError())
					{
						$r->mostrarError("No se pudo actualizar el Vale de Salida. ". $valeSalida->getStrError());
						$blnDoCommit = false;
						break;
					}
				}
				else
				{
					$r->mostrarError("No se pudo obtener dato de Vale de Salida");
					$blnDoCommit = false;
					break;
				}

				//para el promotor
				NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
										"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO será Enviado", 
										"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' NO ha sido Enviado en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío");

				
				//para quien lo asigna/desasigna
				NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
													"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO será Enviado", 
													"NO se Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío.");

				if ($idUsuarioVenta != $idPromotor)
				{
					//para el que vende
					NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
													"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " No será Enviado", 
													"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' NO ha sido Enviado en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío.");
				}


				
			}

			$rutaEnvio = new ModeloRutaenvio();

			$rutaEnvio->setIdRutaEnvio($idRutaEnvio);

			if ($rutaEnvio->getIdRutaEnvio() > 0)
			{				
				if ($rutaEnvio->getEstado() == "CREADA" )
				{
					$rutaEnvio->setEstadoVEHICULOASIGNADO();
					// $rutaEnvio->setDateAndUser("enviado");

					$rutaEnvio->Guardar();

					if ($rutaEnvio->getError())
					{
						$r->mostrarError($rutaEnvio->getStrError());
						$blnDoCommit = false;
					}
				}
			}
			else
			{
				$r->mostrarError("No se pudo obtener la ruta de envio");
				$blnDoCommit = false;
			}
		}

		if ($blnDoCommit)
		{
			$r->saSuccess("La Ruta esta lista para ser Enviada a su(s) destino(s).");
			$r->script(" setTimeout( function() { app.cargarRutaEnvioDetalle(); app.cargarPedidosParaAsignar(); } , 500); ");
			$vehiculoTr->transaccionCommit();
		}
		else
		{
			$r->mostrarError("Han ocurrido algunos errores al intentar realizar el envio de Ruta.");
			$vehiculoTr->transaccionRollback();
		}

		$r->script(" mdlExitWait();  ");

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("asignarVehiculos");


	function obtenerVehiculosRutaEnvio($idRutaEnvio, $objeto = "vehiculosParaEnviar")
	{
		$r = new xajaxResponse();
	// $r->starDebug();
        $vehiculos = new ModeloVehiculo();

		$sql = "select ifnull(rev.idRutaEnvioVehiculo, 0) idRutaEnvioVehiculo, v.idVehiculo, v.placas, v.descripcion, rev.kilometrajeInicial, rev.kilometrajeFinal, rev.cargoGasolina, 
					rev.estatus, rev.litros, rev.tipoCombustible,
					getTotalKGRutaEnvioVehiculo(rev.idRutaEnvioVehiculo) totalkg,
					getMaxMLRutaEnvioVehiculo(rev.idRutaEnvioVehiculo) maxml,
					rev.fecha_envio,
					rev.fecha_regreso,
					v.disponibilidad
				from vehiculo v 
				left join rutaenviovehiculo rev on v.idVehiculo = rev.idVehiculo
				and rev.idRutaEnvio = " . $idRutaEnvio;

        $lstVehiculos = $vehiculos->getDataSet($sql);

        $pushes = "app.".$objeto.".splice(0, app.".$objeto.".length);";
		$selected = "true";
		
        foreach($lstVehiculos as $row)
        {

			$idRutaEnvioVehiculo = $row["idRutaEnvioVehiculo"];

			$vss = "[";

			if ($idRutaEnvioVehiculo > 0)
			{
				$sql = "
							select red.idRutaEnvioDetalle, p.idPedido, p.estado, p.recogeentrega, concat(c.nombre, ' ', c.apellidos) cliente,     
							red.maxml, red.maxpeso, red.orden, 
							p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega,
							c.idUsuarioPromotor, p.id_usuario_capturado, 
							vs.estado vsestado,
							re.maxml hmaxml, re.maxpeso hmaxpeso, re.fecha, re.estado, red.idValeSalida,
							if(vs.yaImpreso = 'SI' or vs.chkImprimirPedidoNoSaldado = 'SI' or vs.pagoVSEntrega = 'SI', 'SI', 'NO') listoParaSalir,
							ifnull(rev.idRutaEnvioVehiculo ,0) idRutaEnvioVehiculo ,
							ifnull(rev.idVehiculo,0) idVehiculo, ifnull(red.ordenVehiculo,0) ordenVehiculo
						from rutaenviodetalle red
						inner join rutaenvio re on red.idRutaEnvio = re.idRutaEnvio
						left join rutaenviovehiculo rev on red.idRutaEnvioVehiculo = rev.idRutaEnvioVehiculo
						inner join pedido p on red.idPedido = p.idPedido
						inner join valesalida vs on red.idValeSalida = vs.idValeSalida
						inner join cliente c on p.idcliente = c.idcliente
						where red.idrutaenvio = ".$idRutaEnvio." and red.idRutaEnvioVehiculo = ".$idRutaEnvioVehiculo." ORDER BY red.orden, red.idRutaEnvioDetalle                
				";
				
				$lstvs = $vehiculos->getDataSet($sql);
				
				foreach($lstvs as $vs){
					$vss .= " {
							key: '".$vs["idValeSalida"] . date_timestamp_get(date_create()) .rand().rand().rand()."',
							idRutaEnvioDetalle: ".$vs["idRutaEnvioDetalle"].",	
							idPedido: ".$vs["idPedido"].", 
							idValeSalida: ".$vs["idValeSalida"].", 
							orden: ".$vs["orden"].", 
							estado: '".$vs["estado"]."', 
							vsestado: '".$vs["vsestado"]."', 
							recogeentrega: '".$vs["recogeentrega"]."', 
							cliente: '".$vs["cliente"]."',					
							maxkg: ".$vs["maxpeso"].", 
							maxml: ".$vs["maxml"].",
							personaEntrega: '".$vs["personaEntrega"]."', 
							domicilioEntrega: '".$vs["domicilioEntrega"]."', 
							numeroEntrega: '".$vs["numeroEntrega"]."', 
							coloniaEntrega: '".$vs["coloniaEntrega"]."', 
							ciudadEntrega: '".$vs["ciudadEntrega"]."',
							idUsuarioVenta: ".$vs["id_usuario_capturado"].",
							idPromotor: ".$vs["idUsuarioPromotor"].",
							listoParaSalir: '".$vs["listoParaSalir"]."',
							idRutaEnvioVehiculo: ".$vs["idRutaEnvioVehiculo"].",
							vehiculoAsignado: ".$vs["idVehiculo"].",
							ordenVehiculoAsignado: ". $vs["ordenVehiculo"] ." ,
							idRutaEnvioVehiculoOriginal: ".$vs["idRutaEnvioVehiculo"].",
							vehiculoAsignadoOriginal: ".$vs["idVehiculo"].",
						
						},";
				
				}
			}
			


			

			$vss .= "]";
			
			// $r->mostrarAviso($row["nombre"]);
            $pushes .= " app.".$objeto.".push({
                    id: ".$row["idVehiculo"].",
					idRutaEnvioVehiculo: ".$row["idRutaEnvioVehiculo"].",
					disponibilidad: '".$row["disponibilidad"]."',
					selected: ".($idRutaEnvioVehiculo > 0 ? "true" : "false").",
                    placa: '".$row["placas"]."',
                    descripcion: '".$row["descripcion"]."',
					estatus: '".$row["estatus"]."',
					km: '". intval($row["kilometrajeInicial"])."',
					kmfinal: '".intval($row["kilometrajeFinal"])."',
					cargogasolina: ".($row["cargoGasolina"] == 'SI' ? 'true' : 'false').",
					litros: '".$row["litros"]."',
					tipocombustible: '".$row["tipoCombustible"]."',					
					vs: ".$vss.",					
					maxml: ".$row["maxml"].",
					kg: ".$row["totalkg"]."
                });";

			// $selected = "true";
        }
		// $r->mostrarAviso($row["nombre"]);
		// $r->mostrarAviso($pushes);
        $r->script($pushes);
		// $r->script(" setTimeout(function() {
		// 					$('.i-checks').iCheck({
		// 					checkboxClass: 'icheckbox_square-green',
		// 					radioClass: 'iradio_square-green'
		// 				});
		// 		}, 1000);
		// 	");
        // $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("obtenerVehiculosRutaEnvio");

	function enviarVehiculo($detalleEnvio, $nombreRuta, $dia, $fecha, $turno, $kmsalida)
	{
		$r = new xajaxResponse();
		// $r->starDebug();
		$vehiculoTr = new ModeloRutaenviovehiculo();
		// $idRutaEnvio = $detalleEnvio["idRutaEnvio"];	
		$blnDoCommit = true;	
		
		$vehiculoTr->transaccionIniciar();

		// foreach($detalleEnvio["vehiculos"] as $v)
		{
			$vehiculo = new ModeloRutaenviovehiculo();

			$placa = $detalleEnvio["placa"];
			$idVehiculo = $detalleEnvio["id"];

			$vehiculo->setIdRutaEnvioVehiculo($detalleEnvio["idRutaEnvioVehiculo"]);
			
			$vehiculo->setKilometrajeInicial($kmsalida);
			$vehiculo->setEstatusENRUTA();
			$vehiculo->setDateAndUser("envio");
			
			$vehiculo->Guardar();

			if (!$vehiculo->getError())
			{

				$ordenVehiculo = 1;
				foreach($detalleEnvio["vs"] as $vs){				
					$idRutaEnvioDetalle = $vs["idRutaEnvioDetalle"];
					$idPromotor = $vs["idPromotor"];
					$idUsuarioVenta = $vs["idUsuarioVenta"];
					$idPedido = $vs["idPedido"];
					$idValeSalida = $vs["idValeSalida"];
					$cliente = $vs["cliente"];
					$ordenVehiculoAsignado = $vs["ordenVehiculoAsignado"];
					

					

					// //para el administrador
					// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 						"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 						"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					
					// //para quien lo asigna/desasigna
					// NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"Has Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					// if (true || $idUsuarioVenta != $idPromotor)
					// {
					// 	//para el que vende
					// 	NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					// }

					//para el administrador
					// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
					// 						"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 						"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
											"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
											"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta asignada en el orden #". $ordenVehiculoAsignado.",+ para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					
					//para quien lo asigna/desasigna
					// NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"Has Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
														"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
														"Has Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en el Vehículo '".$placa."' en la Ruta asignada en el orden #". $ordenVehiculoAsignado.", para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					if ($idUsuarioVenta != $idPromotor)
					{
						//para el que vende
						// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
						// 								"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
						// 								"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

						NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
														"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
														"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta asignada en el orden #". $ordenVehiculoAsignado.", para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					}


					
					// $rutaEnvioDetalle = new ModeloRutaenviodetalle();
					// $rutaEnvioDetalle->setIdRutaEnvioDetalle($idRutaEnvioDetalle);

					// if ($rutaEnvioDetalle->getIdRutaEnvioDetalle() > 0)
					// {
					// 	$rutaEnvioDetalle->setEnRutaSI();						
					// 	$rutaEnvioDetalle->setIdRutaEnvioVehiculo($vehiculo->getIdRutaEnvioVehiculo());												
					// 	$rutaEnvioDetalle->setOrdenVehiculo($ordenVehiculo);

					// 	$rutaEnvioDetalle->Guardar();

					// 	if ($rutaEnvioDetalle->getError())
					// 	{
					// 		$r->mostrarError("No se pudo actualizar el detalle del envio. ". $rutaEnvioDetalle->getStrError());
					// 		$blnDoCommit = false;
					// 		break;
					// 	}
					// }
					// else
					// {
					// 	$r->mostrarError("No se pudo obtener el detalle de la ruta de envio");
					// 	$blnDoCommit = false;
					// 	break;
					// }



					// VALE SE SALIDA
					$valeSalida = new ModeloValesalida();
					// $r->mostrarAviso("bien " . __LINE__); return $r;							
					$valeSalida->setIdValeSalida($idValeSalida);

					if ($valeSalida->getIdValeSalida() > 0)
					{
						// $valeSalida->setIdRutaEnvio($idRutaEnvio);
						$valeSalida->setDateAndUser("salida");
						$valeSalida->setEstadoSALIDA();

						$valeSalida->Guardar();

						if ($valeSalida->getError())
						{
							$r->mostrarError("No se pudo actualizar el Vale de Salida. ". $valeSalida->getStrError());
							$blnDoCommit = false;
							break;
						}
					}
					else
					{
						$r->mostrarError("No se pudo obtener el dato de Vale de Salida");
						$blnDoCommit = false;
						break;
					}

					$ordenVehiculo++;
				}
			}
			else
			{
				$r->mostrarError("No se pudo almacenar el registro del Vehículo para la Ruta de Envio. " . $vehiculo->getStrError());
				$blnDoCommit = false;
				// break;
			}

			
		}

		if ($blnDoCommit)
		{
			// foreach($detalleEnvio["vsNoEnviados"] as $vsne){
				
			// 	$idPromotor = $vs["idPromotor"];
			// 	$idUsuarioVenta = $vs["idUsuarioVenta"];
			// 	$idPedido = $vs["idPedido"];
			// 	$idValeSalida = $vs["idValeSalida"];

			// 	// VALE SE SALIDA
			// 	$valeSalida = new ModeloValesalida();
			// 	// $r->mostrarAviso("bien " . __LINE__); return $r;							
			// 	$valeSalida->setIdValeSalida($idValeSalida);

			// 	if ($valeSalida->getIdValeSalida() > 0)
			// 	{
			// 		$valeSalida->setIdRutaEnvio(0);					
			// 		$valeSalida->setTipoRutaREENRUTAR();

			// 		$valeSalida->Guardar();

			// 		if ($valeSalida->getError())
			// 		{
			// 			$r->mostrarError("No se pudo actualizar el Vale de Salida. ". $valeSalida->getStrError());
			// 			$blnDoCommit = false;
			// 			break;
			// 		}
			// 	}
			// 	else
			// 	{
			// 		$r->mostrarError("No se pudo obtener dato de Vale de Salida");
			// 		$blnDoCommit = false;
			// 		break;
			// 	}

			// 	//para el promotor
			// 	NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
			// 							"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO será Enviado", 
			// 							"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' NO ha sido Enviado en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío");

				
			// 	//para quien lo asigna/desasigna
			// 	NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
			// 										"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO será Enviado", 
			// 										"NO se Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío.");

			// 	if (true || $idUsuarioVenta != $idPromotor)
			// 	{
			// 		//para el que vende
			// 		NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
			// 										"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " No será Enviado", 
			// 										"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' NO ha sido Enviado en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío.");
			// 	}


				
			// }

			// $rutaEnvio = new ModeloRutaenvio();

			// $rutaEnvio->setIdRutaEnvio($idRutaEnvio);

			// if ($rutaEnvio->getIdRutaEnvio() > 0)
			// {
			// 	$rutaEnvio->setEstadoENRUTA();
			// 	// $rutaEnvio->setDateAndUser("enviado");

			// 	$rutaEnvio->Guardar();

			// 	if ($rutaEnvio->getError())
			// 	{
			// 		$r->mostrarError($rutaEnvio->getStrError());
			// 		$blnDoCommit = false;
			// 	}
			// }
			// else
			// {
			// 	$r->mostrarError("No se pudo obtener la ruta de envio");
			// 	$blnDoCommit = false;
			// }
		}

		if ($blnDoCommit)
		{
			$r->saSuccess("El Vehículo ha sido enviado");
			$r->script(" setTimeout( function() { app.cargarRutaEnvioDetalle(); } , 500); ");
			$vehiculoTr->transaccionCommit();
		}
		else
		{
			$r->mostrarError("Han ocurrido algunos errores al intentar realizar el envio de Ruta.");
			$vehiculoTr->transaccionRollback();
		}

		$r->script(" mdlExitWait();  ");

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("enviarVehiculo");

	function regresoDeVehiculo($detalleEnvio, $nombreRuta, $dia, $fecha, $turno)
	{
		$r = new xajaxResponse();
		// $r->starDebug();
		$vehiculoTr = new ModeloRutaenviovehiculo();
		// $idRutaEnvio = $detalleEnvio["idRutaEnvio"];	
		$blnDoCommit = true;	
		
		$vehiculoTr->transaccionIniciar();

		// foreach($detalleEnvio["vehiculos"] as $v)
		{
			$vehiculo = new ModeloRutaenviovehiculo();

			$placa = $detalleEnvio["placa"];
			$idVehiculo = $detalleEnvio["id"];

			$vehiculo->setIdRutaEnvioVehiculo($detalleEnvio["idRutaEnvioVehiculo"]);			
			$vehiculo->setKilometrajeFinal($detalleEnvio["kmfinal"]);
			if ($detalleEnvio["cargogasolina"])
			{
				$vehiculo->setCargoGasolinaSI();
				$vehiculo->setLitros($detalleEnvio["litros"]);
				$vehiculo->setTipoCombustible($detalleEnvio["tipocombustible"]);
			}
			else
			{
				$vehiculo->setCargoGasolinaNO();
			}


			$vehiculo->setEstatusCOMPLETADO();
			$vehiculo->setDateAndUser("regreso");
			
			$vehiculo->Guardar();

			if (!$vehiculo->getError())
			{

				$ordenVehiculo = 1;
				foreach($detalleEnvio["vs"] as $vs){				
					$idRutaEnvioDetalle = $vs["idRutaEnvioDetalle"];
					$idPromotor = $vs["idPromotor"];
					$idUsuarioVenta = $vs["idUsuarioVenta"];
					$idPedido = $vs["idPedido"];
					$idValeSalida = $vs["idValeSalida"];
					$cliente = $vs["cliente"];


					$vehiculoAsignado = $vs["vehiculoAsignado"];

					

					// //para el administrador
					// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 						"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 						"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					
					// //para quien lo asigna/desasigna
					// NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"Has Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

					// if (true || $idUsuarioVenta != $idPromotor)
					// {
					// 	//para el que vende
					// 	NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
					// 									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Enviado", 
					// 									"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido Enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
					// }


					if ($vehiculoAsignado > 0)
					{
						//para el Promotor
						NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
												"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Entregado", 
												"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' que salió en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . " ha regresado de Entregar la mercancía. Horario " . $turno);

						
						//para quien lo asigna/desasigna
						NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
															"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Entregado", 
															"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' que salió en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . " ha regresado de Entregar la mercancía. Horario " . $turno);

						if ($idUsuarioVenta != $idPromotor)
						{
							//para el que vende
							NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
															"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " Entregado", 
															"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' enviado en el Vehículo '".$placa."' en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . " ha regresado de Entregar la mercancía. Horario " . $turno);
						}
						// VALE SE SALIDA
						$valeSalida = new ModeloValesalida();
						
						$valeSalida->setIdValeSalida($idValeSalida);

						if ($valeSalida->getIdValeSalida() > 0)
						{
						
							// $valeSalida->setIdRutaEnvio($idRutaEnvio);
							$valeSalida->setDateAndUser("entrega");
							$valeSalida->setEstadoENTREGADO();
	// $r->mostrarAviso("bien " . __LINE__); return $r;							
							$valeSalida->Guardar();

							if ($valeSalida->getError())
							{
								$r->mostrarError("No se pudo actualizar el Vale de Salida. ". $valeSalida->getStrError());
								$blnDoCommit = false;
								break;
							}
						}
						else
						{
							$r->mostrarError("No se pudo obtener el dato de Vale de Salida");
							$blnDoCommit = false;
							break;
						}

						$ordenVehiculo++;
					}
					else
					{
						//el vs no se entregó con el vehiculo que ha regresado
						$red = new ModeloRutaenviodetalle();

						$red->setIdRutaEnvioDetalle($idRutaEnvioDetalle);
						// $orden = $red->getOrden();		
						$red->Borrar();

						//para el promotor
						NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
												"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO Entregado", 
												"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' se envió en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ", pero NO FUE ENTREGADO. Horario " . $turno.". Se debe Reasignar a otra Ruta/Vehículo");

						
						//para quien lo asigna/desasigna
						NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
															"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO Entregado", 
															"Se ha retirado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' que se envió la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ", porque NO FUE ENTREGADO. Horario " . $turno.". Se debe Reasignar a otra Ruta/Vehículo");

						if ($idUsuarioVenta != $idPromotor)
						{
							//para el que vende
							NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
															"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO Entregado", 
															"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' se envió en la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ", pero NO FUE ENTREGADO. Horario " . $turno.". Se debe Reasignar a otra Ruta/Vehículo");
						}
					}

				
				}
			}
			else
			{
				$r->mostrarError("No se pudo almacenar el registro del Vehículo para la Ruta de Envio. " . $vehiculo->getStrError());
				$blnDoCommit = false;
				// break;
			}

			
		}

		if ($blnDoCommit)
		{
			// foreach($detalleEnvio["vsNoEnviados"] as $vsne){
				
			// 	$idPromotor = $vs["idPromotor"];
			// 	$idUsuarioVenta = $vs["idUsuarioVenta"];
			// 	$idPedido = $vs["idPedido"];
			// 	$idValeSalida = $vs["idValeSalida"];

			// 	// VALE SE SALIDA
			// 	$valeSalida = new ModeloValesalida();
			// 	// $r->mostrarAviso("bien " . __LINE__); return $r;							
			// 	$valeSalida->setIdValeSalida($idValeSalida);

			// 	if ($valeSalida->getIdValeSalida() > 0)
			// 	{
			// 		$valeSalida->setIdRutaEnvio(0);					
			// 		$valeSalida->setTipoRutaREENRUTAR();

			// 		$valeSalida->Guardar();

			// 		if ($valeSalida->getError())
			// 		{
			// 			$r->mostrarError("No se pudo actualizar el Vale de Salida. ". $valeSalida->getStrError());
			// 			$blnDoCommit = false;
			// 			break;
			// 		}
			// 	}
			// 	else
			// 	{
			// 		$r->mostrarError("No se pudo obtener dato de Vale de Salida");
			// 		$blnDoCommit = false;
			// 		break;
			// 	}

			// 	//para el promotor
			// 	NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
			// 							"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO será Enviado", 
			// 							"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' NO ha sido Enviado en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío");

				
			// 	//para quien lo asigna/desasigna
			// 	NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
			// 										"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " NO será Enviado", 
			// 										"NO se Enviado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío.");

			// 	if (true || $idUsuarioVenta != $idPromotor)
			// 	{
			// 		//para el que vende
			// 		NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO ,2, 
			// 										"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " No será Enviado", 
			// 										"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' NO ha sido Enviado en la Ruta Asignada. El Vale de Salida deberá ser reasignado a una nueva Ruta de Envío.");
			// 	}


				
			// }

			// $rutaEnvio = new ModeloRutaenvio();

			// $rutaEnvio->setIdRutaEnvio($idRutaEnvio);

			// if ($rutaEnvio->getIdRutaEnvio() > 0)
			// {
			// 	$rutaEnvio->setEstadoENRUTA();
			// 	// $rutaEnvio->setDateAndUser("enviado");

			// 	$rutaEnvio->Guardar();

			// 	if ($rutaEnvio->getError())
			// 	{
			// 		$r->mostrarError($rutaEnvio->getStrError());
			// 		$blnDoCommit = false;
			// 	}
			// }
			// else
			// {
			// 	$r->mostrarError("No se pudo obtener la ruta de envio");
			// 	$blnDoCommit = false;
			// }
		}

		if ($blnDoCommit)
		{
			$r->saSuccess("El envío de este Vehículo se ha completado");
			$r->script(" setTimeout( function() { app.cargarRutaEnvioDetalle(); } , 500); ");
			$vehiculoTr->transaccionCommit();
		}
		else
		{
			$r->mostrarError("Han ocurrido algunos errores al intentar realizar el envio de Ruta.");
			$vehiculoTr->transaccionRollback();
		}

		$r->script(" mdlExitWait();  ");

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("regresoDeVehiculo");
	

	function moverDetalle($desde, $hasta, $estoyEnCalendario = true)
	{
		$r = new xajaxResponse();

		$rutaenvio = new ModeloRutaenvio();

		

		$sql = "select red.idPedido, red.idValeSalida, dayofweek(fecha) dia, DATE_FORMAT(fecha, '%d-%m-%Y') fecha, turno, concat(c.nombre, ' ', c.apellidos) as cliente,
					r.nombre ruta, c.idUsuarioPromotor idPromotor, p.id_usuario_capturado idVendedor
				from rutaenviodetalle red
				inner join rutaenvio re on red.idRutaEnvio = re.idRutaEnvio
				inner join pedido p on red.idPedido = p.idPedido
				inner join cliente c on p.idCliente = c.idCliente
				inner join ruta r on re.idRuta = r.idRuta
				where red.idRutaEnvio = " . $desde;

		$lstDesde = $rutaenvio->getDataSet($sql);

		$sql = "select dayofweek(fecha) dia,DATE_FORMAT(fecha, '%d-%m-%Y') fecha, turno, 
					r.nombre ruta 
				from rutaenvio re 
				inner join ruta r on re.idRuta = r.idRuta
				where re.idRutaEnvio = " . $hasta;

		$lstHasta = $rutaenvio->getDataSet($sql)[0];

		$nombreRutaHasta = $lstHasta["ruta"];
		$diaHasta = getNombreDia($lstHasta["dia"]);
		$fechaHasta = $lstHasta["fecha"];
		$turnoHasta = $lstHasta["turno"];

		$rutaenvio->executeRaw("CALL spMoverRutaDetalle(". $desde .", ".$hasta.")");

		foreach($lstDesde as $d)
		{
			$idValeSalida = $d["idValeSalida"];
			$idPedido = $d["idPedido"];
			$cliente = $d["cliente"];
			$nombreRuta = $d["ruta"];
			$dia = getNombreDia($d["dia"]);
			$fecha = $d["fecha"];
			$turno = $d["turno"];
			$idPromotor = $d["idPromotor"];
			$idUsuarioVenta  = $d["idVendedor"];

			

			//se quitan de aqui
			//para el promotor
			NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
									"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " retirado de Ruta", 
									"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido retirado de la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

			
			//para quien lo asigna/desasigna
			NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
												"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " retirado de Ruta", 
												"Has retirado el Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' de la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);

			if ($idUsuarioVenta != $idPromotor)
			{
				//para el que vende
				NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
												"Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " retirado a Ruta", 
												"El Vale de Salida ".$idValeSalida." del Pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido retirado de la Ruta '" . $nombreRuta . "' para el dia " . $dia . " " . $fecha . ". Horario " . $turno);
			}

			//se pasan aqui

			//para el promotor
			NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idPromotor, 
												"Vale Salida " . $idValeSalida." de Pedido " . $idPedido . " asignado a Ruta", 
												"El Vale de Salida " . $idValeSalida . " del pedido " . $idPedido . " de su Cliente '" . $cliente . "' ha sido asignado a la Ruta '" . $nombreRutaHasta . "' para el dia " . $diaHasta . " " . $fechaHasta . ". Horario " . $turnoHasta);

			//para quien asigna/desasigna		
			NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO ,
												"Vale Salida " . $idValeSalida." de Pedido " . $idPedido . " asignado a Ruta", 
												"Has asignado el Vale de Salida " . $idValeSalida . " del pedido " . $idPedido . " del Cliente '" . $cliente . "' a la Ruta '" . $nombreRutaHasta . "' para el dia " . $diaHasta . " " . $fechaHasta . ". Horario " . $turnoHasta);
			
			if ($idUsuarioVenta != $idPromotor)
			{
				//para el vendedor
				NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO , $idUsuarioVenta, 
												"Vale Salida " . $idValeSalida." de Pedido " . $idPedido . " asignado a Ruta", 
												"El Vale de Salida " . $idValeSalida . " del pedido " . $idPedido . " del Cliente '" . $cliente . "' ha sido asignado a la Ruta '" . $nombreRutaHasta . "' para el dia " . $diaHasta . " " . $fechaHasta . ". Horario " . $turnoHasta);
			}					
		}



		$r->script(" app.moverValesDeAqui = 0;  app.moverValesAAqui = 0;  ");

		if ($estoyEnCalendario)
		{
			$r->script(" setTimeout(function(){ app.showCalendario(); }, 200);  ");
		}
		else
		{
			$r->script(" setTimeout( function() { app.cargarRutaEnvioDetalle(); } , 500); ");
		}

		$r->script(" mdlExitWait();  ");

		
		return $r;
	}
	$xajax->registerFunction("moverDetalle");

	function getLastKm($idVehiculo)
	{
		$r = new xajaxResponse();

		// $r->starDebug();

		$rutaenvio = new ModeloRutaenvio();

		$sql = " SELECT IFNULL(MAX(kilometrajeFinal),0) lastkm FROM rutaenviovehiculo WHERE idVehiculo = ".$idVehiculo." ORDER BY kilometrajeFinal DESC LIMIT 1 " ;

		$rs = $rutaenvio->getDataSet( $sql );	

		// $r->mostrarAviso("lastkm: " . $rs[0]["lastkm"]);

		$r->script(" app.vehiculoSalidaLastKm =  " . $rs[0]["lastkm"]);

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("getLastKm");

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