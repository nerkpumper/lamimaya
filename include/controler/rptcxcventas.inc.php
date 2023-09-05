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
// $r->starDebug();

		$ped = new ModeloPedido();

		$desde = $filtro["fechaInicio"];
		$hasta = $filtro["fechaFin"];
		
		$addWhereAll ="";

		if ($desde != "" && $hasta != "")
		{
			$desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
			$hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);

			
			$addWhereAll .= "  date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
		}

	
	   $lst = $ped->getAll("pedido.idpedido, concat(c.nombre,' ', c.apellidos) as nombreCliente, concat(u.nombre, ' ' , u.apellidopaterno, ' ' , u.apellidomaterno) promotor  ,
                            pedido.fecha_capturado, pedido.total, pedido.estado, pedido.despachado as surtido,pedido.factura, 
                            pedido.saldada, pedido.saldo  ",
						"inner join cliente c on pedido.idcliente = c.idcliente
                         inner join usuario u on c.idusuariopromotor = u.idusuario
						",
						$addWhereAll,
						"pedido.idPedido");

// 						echo $ped->getAllQUERY("pedido.idpedido, concat(c.nombre,' ', c.apellidos) as nombreCliente, concat(u.nombre, ' ' , u.apellidopaterno, ' ' , u.apellidomaterno) promotor  ,
//                             pedido.fecha_capturado, pedido.total, pedido.estado, pedido.despachado as surtido,
//                             pedido.saldada, pedido.saldo  ",
// 						    "inner join cliente c on pedido.idcliente = c.idcliente
//                          inner join usuario u on c.idusuariopromotor = u.idusuario
// 						",
// 						    $addWhereAll,
// 						    "pedido.idPedido");




		$detalle = "";
		$entra = false;
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

			$detalle .= "<td>" . $row ["idpedido"] . "</td>";
			$detalle .= "<td>" . $row ["nombreCliente"] . "</td>";
			$detalle .= "<td>" . $row ["promotor"] . "</td>";
			$detalle .= "<td>" . clsUtilerias::formatoFecha( $row ["fecha_capturado"]) . "</td>";
			$detalle .= "<td ".$color.">" . $row ["total"] . "</td>";
			$detalle .= "<td>" . $row ["estado"] . "</td>";
			$detalle .= "<td>" . $row ["surtido"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["saldada"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["saldo"] . "</td>";
			$detalle .= "<td ".$color.">" . $row ["factura"] . "</td>";
			
			

			$detalle .= "</tr>";
		}

		$r->assign("tblReporteBody", "innerHTML", $detalle);

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

	