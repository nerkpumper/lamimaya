<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
    require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cortecomisionroofing.inc.php";
	require_once FOLDER_MODEL. "model.cxccuentacomisionroofing.inc.php";
	require_once FOLDER_MODEL. "model.incentivo.inc.php";

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();

  	 // ob_start();
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

    function cargarTablaIncentivos()
    {
        $r = new xajaxResponse();

        $incentivo = new ModeloIncentivo();

        $lst = $incentivo->getAll("inicio, fin, porcentaje",
                                 "",
								 "",
								 "idIncentivo");

        $pushes = "";
        
        foreach ($lst as $item)
        {
            $pushes .= "
                    app.incentivos.push({inicio: ".$item["inicio"].",
                                     fin: ".$item["fin"].",
                                        porcentaje: ".$item["porcentaje"]."});

                ";

        
        }

        $r->script(" app.incentivos.splice(0, app.incentivos.length); ". $pushes);
        

        return $r;

    }
    $xajax->registerFunction("cargarTablaIncentivos");

    function cargarPromotores()
    {
        $r = new xajaxResponse();

        $promotor = new ModeloUsuario();

        $lst = $promotor->getAll("idUsuario, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno ) as nombrePromotor",
                                 "",
                                 "idrol IN (4) and estatus ='activo' OR estatus ='activo' and cobracomision = 'SI'");

        $pushes = "";
        $idPromotor = 0;
        $index = -1;
        $indexPromotor = -1;

        foreach ($lst as $pro)
        {
            $index++;
            $image = "";

            if (file_exists ("img/" . $pro["idUsuario"] . ".jpg" )) {
                $image = "img/" . $pro["idUsuario"] . ".jpg";
            } else {
                $image = 'img/noimage.png';
            }
// $r->mostrarAviso($image);

            $pushes .= "
                    app.promotores.push({id: ".$pro["idUsuario"].",
                                     nombre: '".$pro["nombrePromotor"]."',
                                        img: '".$image."'});

                ";

            if ($idPromotor == $pro["idUsuario"])
            {
                $indexPromotor = $index;
            }
        
        }

        $r->script(" app.promotores.splice(0, app.promotores.length); ". $pushes);
        if ($indexPromotor >= 0)
        {
            $r->script(" app.preparePromotor(".$indexPromotor."); ");
        }

        return $r;

    }
    $xajax->registerFunction("cargarPromotores");

    function obtenerReporte($filtro)
	{
		global $objSession;
		$r = new xajaxResponse();
// $r->starDebug();

		$ped = new ModeloPedido();

        $fechaPrimerPedido = "";
		$desde = $filtro["fechaInicio"];
		$hasta = $filtro["fechaFin"];
		
        $desdeOriginal = $desde;
        $hastaOriginal = $hasta;

		$addWhere ="";
		$addWhereAll ="";
		
		$elIdPromotor = 0;

		if ($desde != "" && $hasta != "")
		{
			$desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
			$hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);

			$addWhere .= " AND getTotalPedidoRoofing(pedido.idpedido) > 0  AND pedido.estado <> 'CANCELADO' AND date_format(pedido.fecha_saldada, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
			$addWhereAll .= "  AND pedido.estado <> 'CANCELADO' AND  date_format(pedido.fecha_saldada, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
		}
		
		if (!Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) )
		{
			if ($filtro["promotor"] != "0")
			{
				$lst = $ped->getAll("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
                                     pedido.id_usuario_capturado, cliente.idusuariopromotor,
                                    concat(cliente.nombre, ' ', cliente.apellidos) as cliente, getTotalPedidoRoofing(pedido.idpedido) total, 
                                    getComisionesPedido(pedido.idPedido) as comisionesOld ,
                                    getComisionesPedidoUsuarioRoofing(pedido.idPedido, ".$filtro["promotor"].") as comisiones , 
                                    pedido.idCCRoofing,pedido.idCCRoofingVendedor, pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
						"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
                        INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
						",
				    " (idUsuarioPromotor = ".$filtro["promotor"] ." OR pedido.id_usuario_capturado = " . $filtro["promotor"] ." ) " . $addWhere ,
						"idPedido");
				
				$elIdPromotor = $filtro["promotor"] ;
				
// 				$r->mostrarAviso($ped->getAllQUERY("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
//                                      pedido.id_usuario_capturado, cliente.idusuariopromotor,
//                                     concat(cliente.nombre, ' ', cliente.apellidos) as cliente, pedido.total,
//                                     getComisionesPedido(pedido.idPedido) as comisionesOld ,
//                                     getComisionesPedidoUsuario(pedido.idPedido, ".$filtro["promotor"].") as comisiones ,
//                                     pedido.idCorteComision, pedido.idCorteComisionVendedor, pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
// 				    "INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
//                         INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
// 						",
// 				    "idUsuarioPromotor = ".$filtro["promotor"] ." OR pedido.id_usuario_capturado = " . $filtro["promotor"] . $addWhere ,
// 				    "idPedido"));

//                     $r->mostrarMsgs($ped->getAllQUERY("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
//                                         concat(cliente.nombre, ' ', cliente.apellidos) as cliente, pedido.total, getComisionesPedido(pedido.idPedido) as comisiones ,
//                                         pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
//     						"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
//                             INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
//     						",
//     						"idUsuarioPromotor = ".$filtro["promotor"] . $addWhere ,
//     						"idPedido"));


			}
			else
			{


				$lst = $ped->getAll("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
                                
                                    concat(cliente.nombre, ' ', cliente.apellidos) as cliente, getTotalPedidoRoofing(pedido.idpedido) total, 
                                    getComisionesPedido(pedido.idPedido) as comisiones ,
                                    pedido.idCCRoofing,pedido.idCCRoofingVendedor, pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, 
                                    pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
						"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
                        INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
						",
						$addWhereAll,
						"pedido.idPedido");
			}

		}
		else
		{
			$lst = $ped->getAll("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
                                pedido.id_usuario_capturado, cliente.idusuariopromotor,
                                concat(cliente.nombre, ' ', cliente.apellidos) as cliente, getTotalPedidoRoofing(pedido.idpedido) total, 
                                getComisionesPedido(pedido.idPedido) as comisionesOld ,
                                getComisionesPedidoUsuarioRoofing(pedido.idPedido, ".$objSession->getIdUsuario() .") as comisiones , 
                                pedido.idCCRoofing,pedido.idCCRoofingVendedor, pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, 
                                pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
					"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
                    INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
						",
			    " (idUsuarioPromotor = ".$objSession->getIdUsuario() ." OR pedido.id_usuario_capturado = ". $objSession->getIdUsuario() . ") " . $addWhere,
					"idPedido");

			$r->script(" app.filtro.promotor = " . $objSession->getIdUsuario());
			
			$elIdPromotor = $objSession->getIdUsuario();
		}

		$pushes = "";
		$entra = false;
		
        $nombrePromotor = "";

        $comisionTotalComisiones = 0;
        $comisionTotalPagadas = 0;
        $comisionTotalPorPagar = 0;
        $comisionTotalPendiente = 0;
        $totalPedidos = 0;

		foreach ($lst as $row)
		{
			$entra = true;

            if ($fechaPrimerPedido == "")
            {
                $fechaPrimerPedido = substr($row ["fechacaptura"], 0,10);
                // $r->mostrarMsgs($fechaPrimerPedido);
                $fechaPrimerPedido = substr($fechaPrimerPedido, 6, 10) . "-" . substr($fechaPrimerPedido, 3, 2) . "-" . substr($fechaPrimerPedido, 0, 2);
                // $r->mostrarMsgs($fechaPrimerPedido);
            }

            if ($nombrePromotor == "")
            {
                $nombrePromotor = $row ["nombrepromotor"];

            }

            $comisionTotalComisiones += $row["comisiones"];

            //$totalPedidos += $row["total"];
            if($row["saldada"] == "SI")
            {
                $miCliente = ($row["idusuariopromotor"] == $elIdPromotor ? 'SI' : 'NO');
                
                
//                 if($row["comisionpagada"] == "SI")
//                 {
//                     $comisionTotalPagadas += $row["comisiones"];
//                 }
//                 else
//                 {
// 					if($row["comisionpagada"] == "NO" && $row["idCorteComision"] == 0)
// 					{
// 						$comisionTotalPorPagar += $row["comisiones"];
// 					}

//                 }

                if($row["idCCRoofing"] == 0 && $miCliente == 'SI')
				{
					$comisionTotalPorPagar += $row["comisiones"];
					$totalPedidos += $row["total"];
				}
				else if ($row["idCCRoofingVendedor"] == 0 && $miCliente == 'NO')
				{
				    $comisionTotalPorPagar += $row["comisiones"];
				    $totalPedidos += $row["total"];
				}

                $pushes .= "
                        app.pedidos.push({
                            idPedido: ".$row["idpedido"].",
                            idCliente: ".$row["idcliente"].",
                            miCliente: '".$miCliente."',
                            nombreCliente: '".$row["cliente"]."',
                            total: '".$row["total"]."',
                            comisiones: '".$row["comisiones"]."',
                            estado: '".$row["estado"]."',
                            fechaCaptura: '".$row ["fechacaptura"]."',
                            saldada: '".$row["saldada"]."',
                            fechaSaldada: '".$row ["fechasaldada"]."',
                            saldo: '".$row["saldo"]."',
							idCorteComision: ".$row["idCCRoofing"].",
                            idCorteComisionVendedor: ".$row["idCCRoofingVendedor"].",
                            comisionpagada: '".$row["comisionpagada"]."'

                        });
                ";
            }
            else
            {
                $comisionTotalPendiente += $row["comisiones"];
            }



		}
		
        $r->script(" app.pedidos.splice(0, app.pedidos.length); " . $pushes . "
            app.comisionTotalComisiones = ".$comisionTotalComisiones.";
            app.comisionTotalPagadas = ".$comisionTotalPagadas.";
            app.comisionTotalPorPagar = ".$comisionTotalPorPagar.";
            app.comisionTotalPendiente = ".$comisionTotalPendiente.";
            app.totalPedidos = ".$totalPedidos.";
            

        ");

		if (!$entra)
		{
// 			$r->saInfo("No se encontró información.");

            $r->script("

             var index = $('#container').data('highchartsChart');
             chart = Highcharts.charts[index];

             chart.setTitle({text: 'Reporte de Pedidos'});
             chart.setTitle(null, { text: ''});

             chart.xAxis[0].setCategories([]);

             chart.series[0].setData([]);

             chart.series[1].setData([]);

             chart.series[2].setData([]);

             chart.series[3].setData([]);

             chart.redraw();





            ");

            // return $r;
		}

        $addWhere = " AND getTotalPedidoRoofing(pedido.idpedido) > 0 AND date_format(pedido.fecha_capturado, '%Y-%m-%d') BETWEEN '".$fechaPrimerPedido."' AND '".$hasta."' ";

        $lstForChart = $ped->getDataSet("
                            SELECT nofechacaptura,fechacaptura, sum(1) as nopedidos, sum(if(saldada = 'SI', 1, 0)) as saldados, sum(if(saldada = 'NO', 1, 0)) as porsaldar, sum(if(comisionpagada = 'SI', 1, 0)) as comisionpagada
                            FROM (
                            SELECT  date_format(pedido.fecha_capturado, '%Y%m%d') as nofechacaptura, date_format(pedido.fecha_capturado, '%d/%m/%Y') as fechacaptura, idpedido, pedido.saldada, pedido.comisionpagada
                            FROM pedido
                            INNER JOIN cliente ON cliente.idCliente = pedido.idCliente
                            INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
                            WHERE  idUsuarioPromotor = ".$filtro["promotor"]."
                            ".$addWhere.") as datos
                            group by nofechacaptura, fechacaptura
                            order by nofechacaptura, fechacaptura;
                    ");

        // $r->mostrarMsgs("
        //                     SELECT nofechacaptura,fechacaptura, sum(1) as nopedidos, sum(if(saldada = 'SI', 1, 0)) as saldados, sum(if(saldada = 'NO', 1, 0)) as porsaldar, sum(if(comisionpagada = 'SI', 1, 0)) as comisionpagada
        //                     FROM (
        //                     SELECT  date_format(pedido.fecha_capturado, '%Y%m%d') as nofechacaptura, date_format(pedido.fecha_capturado, '%d/%m/%Y') as fechacaptura, idpedido, pedido.saldada, pedido.comisionpagada
        //                     FROM pedido
        //                     INNER JOIN cliente ON cliente.idCliente = pedido.idCliente
        //                     INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
        //                     WHERE  idUsuarioPromotor = ".$filtro["promotor"]."
        //                     ".$addWhere.") as datos
        //                     group by nofechacaptura, fechacaptura
        //                     order by nofechacaptura, fechacaptura;
        //             ");
        
        $categorias = "";
        $nopedidos = "";
        $saldados = "";
        $porsaldar = "";
        $comisionpagada = "";

        $totalnopedidos = 0;
        $totalsaldados = 0;
        $totalporsaldar = 0;
        $totalcomisionpagada = 0;

        foreach ($lstForChart as $item)
        {
            // $r->mostrarMsgs( $item["porsaldar"]);
            $categorias .= ($categorias == "" ? "" : "," ) . "'" .$item["fechacaptura"] . "'";
            $nopedidos .= ($nopedidos == "" ? "" : "," )  .$item["nopedidos"];
            $saldados .= ($saldados == "" ? "" : "," )  .$item["saldados"];
            $porsaldar .= ($porsaldar == "" ? "" : "," )  .$item["porsaldar"];
            $comisionpagada .= ($comisionpagada == "" ? "" : "," )  .$item["comisionpagada"];

            $totalnopedidos += intVal($item["nopedidos"]);
            $totalsaldados += intVal($item["saldados"]);
            $totalporsaldar += intVal($item["porsaldar"]);
            $totalcomisionpagada += intVal($item["comisionpagada"]);
        }
        
        
        $r->script("

         var index = $('#container').data('highchartsChart');
         chart = Highcharts.charts[index];

         chart.setTitle({text: 'Reporte de Pedidos ROOFING de ".$desdeOriginal." a ".$hastaOriginal."'});
         chart.setTitle(null, { text: '".$nombrePromotor."'});

         chart.xAxis[0].setCategories([".$categorias."]);

         chart.series[0].setData([]);
         chart.series[0].setData([".$nopedidos."], false);

         chart.series[1].setData([]);
         chart.series[1].setData([".$saldados."], false);

         chart.series[2].setData([]);
         chart.series[2].setData([".$comisionpagada."], false);

         chart.series[3].setData([]);
         chart.series[3].setData([".$porsaldar."], false);

         nopedidos.attr({text: 'Total Pedidos: ".$totalnopedidos."'});
         saldados.attr({text: 'Saldados: ".$totalsaldados."'});
         porsaldar.attr({text: 'Por Saldar: ".$totalporsaldar."'});
         comisionpagada.attr({text: 'Comisión Pagada: ".$totalcomisionpagada."'});

         chart.redraw();


        setTimeout(function() {app.cargarComisionesAnticipadasSinComision();}, 200);


        ");
//         $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("obtenerReporte");
	
	function pruebautf ()
	{
	    $r = new xajaxResponse();
	    
// 	    $r->saSuccess("holis");
	    $r->saSuccess("No se pudo cargar la informaci�n de Comisi�n Adelantada �����");
	    
	    return $r;
	}
	$xajax->registerFunction("pruebautf");
	
	function generarCorteComisionV2($promotor, $pedidos)
	{
	    $r = new xajaxResponse();
	    
	    $r->mostrarAviso("bien");
	    return $r;
	}
	$xajax->registerFunction("generarCorteComisionV2");

	function generarCorteComision($promotor, $pedidos, $deducciones, $totalAPagar, $totalDeducciones, $netoAPagar, $incentivo)
	{
		$r = new xajaxResponse();
// 		$r->starDebug();
		
// 		$r->mostrarAviso("bien");
// 		return $r;
		
// 		$r->starDebug();
		$doCommit = true;
		$errores = "";
		
// 		echo "ekjekj";
		
		
		
// 		$r->endDegug(); return $r;
		
		
		$cc = new ModeloCortecomisionroofing();

		$cc->transaccionIniciar();
		$cc->setIdPromotor($promotor["promotor"]);
		$cc->setFechaInicio($promotor["fechaInicio"]);
		$cc->setFechaFin($promotor["fechaFin"]);
		$cc->setTotal($totalAPagar);
		$cc->setIncentivo($incentivo);
		$cc->setComisionAdelantada($totalDeducciones);
		$cc->setAPagar($cc->getTotal() + $cc->getIncentivo() - $cc->getComisionAdelantada());
		$cc->setDateAndUser("creacion");
		
// 		echo "<br>guardamos cortecomision";
		$cc->Guardar();
		
// 		if (false)
		if ($cc->getError())
		{
			$errores .= "[cortecom]" .$cc->getStrError();
			$doCommit = false;
		}
		else
		{
// 		    echo "<br>le ponemos idcortecomision a pedidos";
		    
		    
			foreach($pedidos as $item)
			{
				$ped = new ModeloPedido();
				
// 				var_dump($item);

				$ped->setIdPedido($item["idPedido"]);
				$ped->getDatos();

				if ($ped->getIdPedido() <= 0)
				{
				    $r->mostrarAviso("no se cargo pedido"); return $r;
				    $errores .= "No se pudo cargar la informaci�n del Pedido ". $item["idPedido"].".";
					$doCommit = false;
				}
				else
				{
// 				    $r->mostrarAviso($item["idPedido"]);
// 				    $r->mostrarAviso("El pedido ". $ped->getIdPedido() ." trai de idcortecomision " . $ped->getIdCorteComision()); return $r;
				    
				    
				    if ($item["miCliente"] == "SI")
				    {
				        $ped->setIdCCRoofing($cc->getIdCorteComisionRoofing());
				    }
				    else
				    {
				        $ped->setIdCCRoofingVendedor($cc->getIdCorteComisionRoofing());
				    }
				    
					
					
// 				    $ped->setIdCorteComision(11);
// 					$r->mostrarAviso("se le pone la comision ". $cc->getIdCorteComision() ." al pedido"); return $r;
// 					$ped->setComisionpagadaSI();

					$ped->Guardar();
		      
					if ($ped->getError())
					{
					    $errores .= "[pedido]" . $ped->getStrError();
					    $doCommit = false;
					}
					
				}
// 				$r->mostrarMsgs("Pedido: " . $item["idPedido"] . " Total: " . $item["total"]);
			}
			
// 			return $r;
			
// 			echo "<br>registramos cxccuentacomision";
			foreach($deducciones as $de)
			{			    
			    $cxccc = new ModeloCxccuentacomisionroofing();
			    
			    $cxccc->setIdCxcCuentaComisionRoofing($de["idcxccuentacomision"]);
			    			    
			    if ($cxccc->getIdCxcCuentaComisionRoofing() <= 0)
			    {
			        $errores .= "No se pudo cargar la informaci�n de Comisi�n Adelantada". $de["idcxccuentacomision"].".";
			        $doCommit = false;
			    }
			    else
			    {
			        $cxccc->setIdCorteComisionRoofing($cc->getIdCorteComisionRoofing());
			        
			        $cxccc->Guardar();
			        
			        if ($cxccc->getError())
			        {
			            $errores .="[cxccuentacomision]" . $cxccc->getStrError();
			            $doCommit = false;
			        }
			    }
// 			    $r->mostrarMsgs("Pedido: " . $item["idPedido"] . " Total: " . $item["total"]);
			}
			
			
// 			echo "<br>otra vez cxccuentacomision";
			$cxccomision = new ModeloCxccuentacomisionroofing();
			
			$cxccomision->setIdUsuario($promotor["promotor"]);
			$cxccomision->setTipoPAGAR();
			$cxccomision->setIdConceptoGasto(1);
			$cxccomision->setDateAndUser("creacion");
			$cxccomision->setMonto($totalAPagar);
			$cxccomision->setObservacion(mb_convert_encoding("CORTE COMISI�N, MONTO GENERADO", 'UTF-8', 'ISO-8859-1');
			$cxccomision->setIdCorteComisionRoofing($cc->getIdCorteComisionRoofing());
			
			$cxccomision->Guardar();
			
			if ($cxccomision->getError())
			{
			    $errores .= "Ocurri� un error al intentar registrar la Comisi�n Anticipada que se ha generado.";
             $doCommit = false;
			}


			//se mete el incentivo
			
			$cxccomision = new ModeloCxccuentacomisionroofing();
			
			$cxccomision->setIdUsuario($promotor["promotor"]);
			$cxccomision->setTipoINCENTIVO();
			$cxccomision->setIdConceptoGasto(1);
			$cxccomision->setDateAndUser("creacion");
			$cxccomision->setMonto($incentivo);
			$cxccomision->setObservacion(mb_convert_encoding("INCENTIVO DE COMISI�N", 'UTF-8', 'ISO-8859-1');
			$cxccomision->setIdCorteComisionRoofing($cc->getIdCorteComisionRoofing());
			
			$cxccomision->Guardar();
			
			if ($cxccomision->getError())
			{
			    $errores .= "Ocurri� un error al intentar registrar el incentivo de la Comisi�n Anticipada que se ha generado.";
	             $doCommit = false;
			}
			
			if ($netoAPagar < 0)
			{
			    echo "<br>un negativo";
			    $cxcarrastrar = new ModeloCxccuentacomisionroofing($link);
			    
			    $cxcarrastrar->setIdUsuario($promotor["promotor"]);
			    $cxcarrastrar->setTipoDEDUCIR();
			    $cxcarrastrar->setIdConceptoGasto(1);
			    $cxcarrastrar->setDateAndUser("creacion");
			    $cxcarrastrar->setMonto($netoAPagar * -1);
			    $cxcarrastrar->setObservacion(mb_convert_encoding("CORTE COMISI�N ANTERIOR NEGATIVO", 'UTF-8', 'ISO-8859-1');
			    
			    $cxcarrastrar->Guardar();
			    
			    if ($cxcarrastrar->getError())
			    {
			        $errores .= "Ocurri� un error al intentar registrar la Comisi�n Anticipada que se ha generado.";
             $doCommit = false;
			    }
			    
			}

			
		}
// 		$r->mostrarAviso("todo bien"); return $r;
		if ($doCommit)
//         if (false)
		{
		    $cc->transaccionCommit();
		    $r->saSuccess("Se ha generado el Corte de Comision Roofing: " . $cc->getIdCorteComisionRoofing());
		    
		    // 			$debug = ob_get_clean();
		    // 			 	$r->mostrarMsgs($debug);
		    // return $r;
		    $r->script(" app.mostrarBotonGeneraCorteComision = true; setTimeout( function() { app.obtenerReporte(); }, 200 );");
		}
		else
		{
		    $cc->transaccionRollback();
// 		    $r->mostrarAviso("rollback");
		    $r->saError($errores);
		    
		}
// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("generarCorteComision");

	
	function cargarComisionesAnticipadasSinComision($idPromotor, $fechaInicio, $fechaFin)
	{
	    $r = new xajaxResponse();
	    
	    $ccc = new ModeloCxccuentacomisionroofing();
	    
	    $addWhere = "";
	    $desde = $fechaInicio;
	    $hasta = $fechaFin;
	    
	    if ($desde != "" && $hasta != "")
	    {
	        $desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
	        $hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);
	        
	        $addWhere .= "  AND date_format(cxccuentacomisionroofing.fecha_creacion, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
	        
	    }
	    
	    $lst = $ccc->getAll("cxccuentacomisionroofing.idcxccuentacomisionroofing, cxccuentacomisionroofing.tipo, conceptogasto.nombre as concepto, cxccuentacomisionroofing.fecha_creacion, cxccuentacomisionroofing.monto, cxccuentacomisionroofing.observacion ",
	        "inner join conceptogasto on conceptogasto.idConceptoGasto = cxccuentacomisionroofing.idConceptoGasto",
    	        " cxccuentacomisionroofing.tipo = 'DEDUCIR' AND cxccuentacomisionroofing.idcortecomisionroofing = 0 AND cxccuentacomisionroofing.idUsuario = " . $idPromotor . $addWhere,
	        " idCxcCuentaComisionRoofing");
	    
// 	    $r->mostrarAviso($ccc->getAllQUERY("cxccuentacomisionroofing.idcxccuentacomisionroofing, cxccuentacomisionroofing.tipo, conceptogasto.nombre as concepto, cxccuentacomisionroofing.fecha_creacion, cxccuentacomisionroofing.monto, cxccuentacomisionroofing.observacion ",
// 	        "inner join conceptogasto on conceptogasto.idConceptoGasto = cxccuentacomisionroofing.idConceptoGasto",
// 	        " cxccuentacomisionroofing.tipo = 'DEDUCIR' AND cxccuentacomisionroofing.idcortecomisionroofing = 0 AND cxccuentacomisionroofing.idUsuario = " . $idPromotor . $addWhere,
// 	        " idCxcCuentaComisionRoofing")); 
// 	    return $r;
	   	    
	    $pushes = "";
	    $total = 0;
	    foreach ($lst as $item)
	    {
	        $pushes .= "
	            
            app.comisionesanticipadas.push (
        		{
                    idcxccuentacomision: ".$item["idcxccuentacomisionroofing"].",
        			tipo: '".$item["tipo"]."',
        			concepto: '".$item["concepto"]."',
        			fecha: '".clsUtilerias::formatoFecha($item["fecha_creacion"])."',
        			monto: ".$item["monto"].",
        			observacion: '".$item["observacion"]."'
        		});
        			    
            ";
	        
	        $total += $item["monto"];
	    }
	    
	    
	    $r->script(" app.comisionesanticipadas.splice(0, app.comisionesanticipadas.length); app.totalDeducciones = ".$total."; " . $pushes);
	    
	    
	    return $r;
	}
	$xajax->registerFunction("cargarComisionesAnticipadasSinComision");


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
