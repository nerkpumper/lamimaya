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
		$tipo = $filtro["tipo"];
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

			$addWhereTotalVenta .= " AND pedido.estado <> 'CANCELADO' AND date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
			$addWhereAllTotalVenta .= "  pedido.estado <> 'CANCELADO' AND  date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
		}

		if (!Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) )
		{
			if ($filtro["promotor"] != "0")
			{


				$lst = $ped->getAll("pedido.idCliente, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, SUM(pedido.total) total ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
						",
						($tipo == "O" ? 
							" ( idUsuarioPromotor = ".$filtro["promotor"] ." ) " 
						:
    				    	" (pedido.id_usuario_capturado = " .$filtro["promotor"] . " OR  idUsuarioPromotor = ".$filtro["promotor"] ." ) " 
						)
						.$addWhere  ,
						" 3 DESC ", "1, 2");
			
				
				$promotorReportando = $filtro["promotor"]; 
				



			}
			else
			{

				$lst = $ped->getAll("pedido.idCliente, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, SUM(pedido.total) total  ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente ",
						$addWhereAll,
						 " 3 DESC ", "1, 2");

				
			}

		}
		else
		{
			$lst = $ped->getAll("pedido.idCliente, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, SUM(pedido.total) total ",
					"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
					($tipo == "O" ? 
						" ( idUsuarioPromotor = ".$objSession->getIdUsuario().") " 
					:
			    		" (pedido.id_usuario_capturado = ".$objSession->getIdUsuario() ." or idUsuarioPromotor = ".$objSession->getIdUsuario().") " 
					)
				. $addWhere,
					" 3 DESC ", "1, 2");

		
			
			$promotorReportando = $objSession->getIdUsuario();

			$r->script(" app.filtro.promotor = " . $objSession->getIdUsuario());
		}






		$detalle = "";
		$entra = false;
	
		$porcentaje = 0;
		$porcentajeAcumulado = 0;		

		$totalPedidosDatoVenta = 0;
		foreach ($lst as $row)
		{
			$totalPedidosDatoVenta += $row["total"];		
		}

		foreach ($lst as $row)
		{
			$entra = true;
			$porcentaje = round(floatval($row ["total"]) * 100 / floatval($totalPedidosDatoVenta), 2);
			$porcentajeAcumulado += $porcentaje;

			$detalle .= "<tr>";
			
			$detalle .= "<td>" . $row ["idCliente"] . "</td>";
			$detalle .= "<td>" . $row ["nombreCliente"] . "</td>";
			$detalle .= "<td>" . $row ["total"] . "</td>";
			$detalle .= "<td>" . $porcentaje . "</td>";
			$detalle .= "<td>" . $porcentajeAcumulado . "</td>";
			

			$detalle .= "</tr>";			
		}


		$r->assign("tblReporteBody", "innerHTML", $detalle);
		$r->script(" 
                    app.totalCalculado = ". $totalPedidosDatoVenta." ;
                   
                 ");

		if (!$entra)
		{
			$r->saInfo("No se encontró información.");
		}

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("obtenerReporte");


	
	


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
