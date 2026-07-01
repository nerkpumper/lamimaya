<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";

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
// 		$r->starDebug();
		$ped = new ModeloPedido();
		
		$desde = $filtro["fechaInicio"];
		$hasta = $filtro["fechaFin"];
		$addWhere ="";
		
		
		if ($desde != "" && $hasta != "")
		{
		    $desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
		    $hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);
		    
		    $addWhere .= " AND date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
		    
		}
		
		
			if ($filtro["idCliente"] != "0")
			{


				$lst = $ped->getAll("
                                       date_format(pedido.fecha_capturado, '%d-%m-%Y') as fecha, pedido.idpedido pedido, 
                                       pedido.estado, pedido.saldada, pedido.total totalpedido, 
                                       pedido.saldo, pd.idproducto, pd.renglon,
                                	   pd.partida as PZAS, if (pd.idproducto = 9,  concat('MOLDURA ', replace(rollomol.descauto, 'ROLLO ', '')), vp.descauto) as descripcion, 
                                       (pd.total / pd.partida) as precioXPieza,
                                       (pd.total / if( vp.mlpieza > 0 , vp.mlpieza * pd.partida, pd.cantidad * pd.partida)) as precioXML,
                                       if( vp.mlpieza > 0 , vp.mlpieza * pd.partida, pd.cantidad * pd.partida) as ML, 
                                       cast((pd.preciounitario * pd.cantidad) as decimal(15,2) ) preciovta, pd.total                                    
                                    ",
						"
                            inner join cliente as c
                            on c.idcliente = pedido.idcliente
                            inner join pedidodetalle as pd
                            on pd.idpedido = pedido.idpedido
                            inner join viewproductos as vp
                            on vp.idproducto = pd.idproducto
                            inner join viewrollos as rollomol
                            on rollomol.idrollo = pd.idrollobase
						",
				    " pedido.idcliente =  ".$filtro["idCliente"] . " " . $addWhere,
						"pedido.idPedido");
				
				

				
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

	

		$detalle = "";
		$fPZAS = 0;
		$fML = 0;
		$fprecioXPieza = 0;
		$fprecioXML = 0;
		$ftotal = 0;      
		
		$entra = false;
		foreach ($lst as $row)
		{
			$entra = true;
			$color = "";

			if ($row ["saldada"] == "SI")
			{
				$color = "class='text-success ";
			}
			else
			{
				$color = "class='text-danger ";
			}

			$detalle .= "<tr>";

			$detalle .= "<td>" . $row ["fecha"] . "</td>";
			$detalle .= "<td>" . $row ["estado"] . "</td>";			
			$detalle .= "<td class='text-right'>" . $row ["pedido"] . "</td>";			
			$detalle .= "<td class='text-right'>" . $row ["renglon"] . "</td>";
			$detalle .= "<td>" . $row ["descripcion"] . "</td>";
			
			$detalle .= "<td ".$color." text-right'>$" . $row ["totalpedido"] . "</td>";
// 			$ftotalpedido += $row ["totalpedido"];
			
			$detalle .= "<td ".$color." text-right'>$" . $row ["saldo"] . "</td>";
// 			$fsaldo += $row ["saldo"];
			
			$detalle .= "<td ".$color." text-right'>" . $row ["saldada"] . "</td>";
			$detalle .= "<td class='text-right'>" . $row ["PZAS"] . "</td>";
			$fPZAS += $row ["PZAS"];
						
			$detalle .= "<td ".$color." text-right'>" .round($row ["ML"],2)	 . "</td>";
			$fML += round($row ["ML"],2);
			
			$detalle .= "<td ".$color." text-right'>$" .round($row ["precioXPieza"],2) . "</td>";
			$fprecioXPieza += round($row ["precioXPieza"],2);
			
			$detalle .= "<td ".$color." text-right'>$" .round($row ["precioXML"],2) . "</td>";
			$fprecioXML += round($row ["precioXML"],2);
			
			$detalle .= "<td ".$color." text-right'>$" .round($row ["total"],2) . "</td>";
			$ftotal += round($row ["total"],2);

			$detalle .= "</tr>";
		}
		
		$color = "class='text-navy ";
		
		$foot = "<tr>";
		
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		$foot .= "<td class='text-right'><strong>" . $fPZAS . "</strong> </td>";
		
		
		$foot .= "<td ".$color." text-right'><strong>" .($fML)	 . "</strong></td>";
		$foot .= "<td ".$color." text-right'><strong>$ " .number_format($fprecioXPieza,2) . "</strong></td>";
		$foot .= "<td ".$color." text-right'><strong>$ " .number_format($fprecioXML,2) . "</strong></td>";
		$foot .= "<td ".$color." text-right'><strong>$ " .number_format($ftotal,2) . "</strong></td>";
		
		$foot .= "</tr>";
		
		
// 		$r->endDegug(); return $r;
// 		$r->mostrarAviso($detalle); return $r;

		$r->assign("tblReporteBody", "innerHTML", $detalle);
		$r->assign("tblReporteFoot", "innerHTML", $foot);

		if (!$entra)
		{
			$r->saInfo("No se encontr� informaci�n.");
		}

		return $r;
	}
	$xajax->registerFunction("obtenerReporte");
	
	function cargarClientes()
	{
	    $r = new xajaxResponse();
	    
	    $clientes = new ModeloCliente();
	    
	    $lst = $clientes->getAll("cliente.idUsuarioPromotor, cliente.idCliente, cliente.nombre, cliente.apellidos, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
	        " INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
	        "estado = 'ACTIVO'");
	    
	    $strClientes = "";
	    
	    foreach ($lst as $row)
	    {
	        
	        $strClientes .= "app.clientes.push({ id: ".$row["idCliente"].",
											   idUsuarioPromotor: ".$row["idUsuarioPromotor"].",
		                                       nombre: '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."',
		                                       domicilio1: '".mb_strtoupper($row["domicilio1"]). "',
		                                       domicilio2: '".mb_strtoupper($row["domicilio2"]). "',
		                                       numero: '".mb_strtoupper($row["numero"]). "',
		                                       colonia: '".mb_strtoupper($row["colonia"]). "',
		                                       ciudad: '".mb_strtoupper($row["ciudad"]). "',
		                                       telefonos: '".mb_strtoupper($row["telefonos"]). "',
		                                       porDescuento: '".mb_strtoupper($row["pordescuento"]). "',
		                                       promotor: '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."'
					                                      });";
	    }
	    
	    $r->script("
				  app.clientes.splice(0, app.clientes.length);
				" .
	        $strClientes);
	    
	    return $r;
	}
	$xajax->registerFunction("cargarClientes");


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

// 	$promotor = new ModeloUsuario();

// 	$lstPromotores = $promotor->getOptionForSelect($promotor->getForSelect("idUsuario", "upper(concat(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno))", "idrol IN (2,4, 8) AND estatus = 'activo' "), "0", "-- TODOS --");


// 	$mostrarListado = (Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) ? "false" : "true");
