<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
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

//   	ob_start();
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

	function obtenerReporte($filtro)
	{
		global $objSession;
		$r = new xajaxResponse();


		$ped = new ModeloPedido();

		$promotorReportando = 0;
		$desde = $filtro["fechaInicio"];
		$hasta = $filtro["fechaFin"];
		$addWhere ="";
		$addWhereAll ="";
		$addWhereTotalVenta ="";
		$addWhereAllTotalVenta ="";
		

		if ($desde != "" && $hasta != "")
		{
			$desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
			$hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);

			$addWhere .= " AND pedido.estado <> 'CANCELADO' AND date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
			$addWhereAll .= "  pedido.estado <> 'CANCELADO' AND  date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";

			$addWhereTotalVenta .= " AND pedido.estado not in ('CANCELADO', 'CAPTURADO') AND date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
			$addWhereAllTotalVenta .= "  pedido.estado not in ('CANCELADO', 'CAPTURADO') AND  date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
		}

		if (!Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) )
		{
			if ($filtro["promotor"] != "0")
			{


				$lst = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
                                     pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor  ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
    				    " (pedido.id_usuario_capturado = " .$filtro["promotor"] . " OR  idUsuarioPromotor = ".$filtro["promotor"] ." ) " .$addWhere  ,
						"idPedido");

				$lstTotalVenta = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
										pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor  ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
							INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
						" (pedido.id_usuario_capturado = " .$filtro["promotor"] . " OR  idUsuarioPromotor = ".$filtro["promotor"] ." ) " .$addWhereTotalVenta  ,
						"idPedido");
				
				$promotorReportando = $filtro["promotor"]; 
				
// 				$r->mostrarAviso($ped->getAllQUERY("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
//                                   pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor   ",
// 				    "INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
// 						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
// 						",
// 				    " (pedido.id_usuario_capturado = " .$filtro["promotor"] . " OR  idUsuarioPromotor = ".$filtro["promotor"] ." ) " .$addWhere   ,
// 				    "idPedido"));


			}
			else
			{

				$lst = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
                          pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor   ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
						$addWhereAll,
						"pedido.idPedido");

				$lstTotalVenta = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
						pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor   ",
					  "INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
					   INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
					  ",
					  $addWhereAllTotalVenta,
					  "pedido.idPedido");
			}

		}
		else
		{
			$lst = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
                            pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor  ",
					"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
			    " (pedido.id_usuario_capturado = ".$objSession->getIdUsuario() ." or idUsuarioPromotor = ".$objSession->getIdUsuario().") " . $addWhere,
					"idPedido");

			$lstTotalVenta = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
					pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor  ",
			"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
				INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
				",
		" (pedido.id_usuario_capturado = ".$objSession->getIdUsuario() ." or idUsuarioPromotor = ".$objSession->getIdUsuario().") " . $addWhereTotalVenta,
			"idPedido");
			
			
			$promotorReportando = $objSession->getIdUsuario();

			$r->script(" app.filtro.promotor = " . $objSession->getIdUsuario());
		}






		$detalle = "";
		$entra = false;
		$total = 0;
		$totalMisClientes = 0;
		$totalDeOtrosPromotores = 0;
		$totalAOtrosClientes = 0;
// 		Los t�tulos para el reporte de ventas podr�an ser los siguientes:
// 		-Ventas a Sus Clientes
// 		-Ventas a Clientes de                             Otros Promotores
// 		-Ventas a sus Clientes Por Otros Promotores.
		

		$totalPedidosDatoVenta = 0;
		foreach ($lstTotalVenta as $row)
		{
			$totalPedidosDatoVenta += $row["total"];
		}

		foreach ($lst as $row)
		{
			$entra = true;
			$color = "";

			if ($row ["saldada"] == "SI")
			{
				$color = "class='text-success'";
			}
			else
			{
				$color = "class='text-danger'";
			}

			$detalle .= "<tr>";

			$detalle .= "<td>" . $row ["idPedido"] . "</td>";
			$detalle .= "<td>" . $row ["idCliente"] . "</td>";
			$detalle .= "<td>" . $row ["nombreCliente"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["total"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["saldada"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["saldo"] . "</td>";
			$detalle .= "<td>" . $row ["estado"] . "</td>";
			$detalle .= "<td>" . clsUtilerias::formatoFecha( $row ["fecha_capturado"]) . "</td>";
			$detalle .= "<td>" . $row ["recogeentrega"]	 . "</td>";
			$detalle .= "<td>" . $row ["nombrePromotor"] . "</td>";

			$detalle .= "</tr>";

			$total += $row ["total"];
			
			
			
// 			$totalMisClientes = 0;
// 			$totalDeOtrosPromotores = 0;
// 			$totalAOtrosClientes = 0;
			
		}


		$r->assign("tblReporteBody", "innerHTML", $detalle);
		$r->script(" 
                    app.totalCalculado = ". $total." ;                    
                 ");

		if (!$entra)
		{
			$r->saInfo("No se encontr� informaci�n.");
		}

		return $r;
	}
	$xajax->registerFunction("obtenerReporte");


	
	function obtenerReportePendientesSaldar($filtro)
	{
		global $objSession;
		$r = new xajaxResponse();

		$ped = new ModeloPedido();
		
		if (!Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) )
		{
			if ($filtro["promotor"] != "0")
			{


				$lst = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo  ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
				    "pedido.saldada = 'NO' AND (pedido.id_usuario_capturado = ".$filtro["promotor"] . " OR idUsuarioPromotor = ".$filtro["promotor"],
						"idPedido");


			}
			else
			{

				$lst = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo  ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
						"pedido.saldada = 'NO' ",
						"pedido.idPedido");
			}

		}
		else
		{
			$lst = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo ",
					"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						 INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
						",
			    "pedido.saldada = 'NO' AND (pedido.id_usuario_capturado = ".$objSession->getIdUsuario()." or idUsuarioPromotor = ".$objSession->getIdUsuario().") ",
					"idPedido");

			$r->script(" app.filtro.promotor = " . $objSession->getIdUsuario());
		}






		$detalle = "";
		$entra = false;
		$total= 0;
		foreach ($lst as $row)
		{
			$entra = true;
			$color = "";

			if ($row ["saldada"] == "SI")
			{
				$color = "class='text-success'";
			}
			else
			{
				$color = "class='text-danger'";
			}

			$detalle .= "<tr>";

			$detalle .= "<td>" . $row ["idPedido"] . "</td>";
			$detalle .= "<td>" . $row ["idCliente"] . "</td>";
			$detalle .= "<td>" . $row ["nombreCliente"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["total"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["saldada"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["saldo"] . "</td>";
			$detalle .= "<td>" . $row ["estado"] . "</td>";
			$detalle .= "<td>" . clsUtilerias::formatoFecha( $row ["fecha_capturado"]) . "</td>";
			$detalle .= "<td>" . $row ["recogeentrega"]	 . "</td>";
			$detalle .= "<td>" . $row ["nombrePromotor"] . "</td>";

			$detalle .= "</tr>";
            $total += $row ["saldo"];
		}

		$r->assign("tblReporteBody", "innerHTML", $detalle);
        $r->script(" app.totalCalculado1 = ".$total." ; ");

		if (!$entra)
		{
			$r->saInfo("No se encontró información.");
		}

		return $r;
	}
	$xajax->registerFunction("obtenerReportePendientesSaldar");


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

	$promotor = new ModeloUsuario();

	$lstPromotores = $promotor->getOptionForSelect($promotor->getForSelect("idUsuario", "upper(concat(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno))", "idrol IN (2,4, 7, 8, 11) AND estatus = 'activo' "), "0", "-- TODOS --");


	$mostrarListado = (Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION ) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION ) ? "false" : "true");
	
//	echo $mostrarListado;
