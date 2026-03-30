<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
    require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cortecomision.inc.php";
	require_once FOLDER_MODEL. "model.cxccuentacomision.inc.php";
	require_once FOLDER_MODEL. "model.incentivo.inc.php";

	require_once FOLDER_MODEL. "model.objetivopromotor.inc.php";

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
		// $desde = $filtro["fechaInicio"];
		// $hasta = $filtro["fechaFin"];
		$tipo = $filtro["tipoComision"];
		$mes = $filtro["mes"];
		$anio = $filtro["anio"];

        // $desdeOriginal = $desde;
        // $hastaOriginal = $hasta;

		$addWhere ="";
		$addWhereAll ="";

		$addWhereTotalVenta ="";
		$addWhereAllTotalVenta ="";
		
		$elIdPromotor = 0;

		$addWhere .= "  AND pedido.estado <> 'CANCELADO'  ";
		$addWhereAll .= "  AND pedido.estado <> 'CANCELADO'  ";
		
		$addWhereTotalVenta .= " AND pedido.estado = 'ENTREGADO' ";
		$addWhereAllTotalVenta .= "  pedido.estado = 'ENTREGADO'  ";

		if ($tipo == "M")
		{			
			$addWhere .= "  AND pedido.estado = 'ENTREGADO' AND date_format(pedido.fecha_saldada, '%Y-%m') = '".$anio."-".($mes < 10 ? "0" : "").$mes."' ";
			$addWhereAll .= "  AND pedido.estado = 'ENTREGADO' AND  date_format(pedido.fecha_saldada, '%Y-%m') = '".$anio."-".($mes < 10 ? "0" : "").$mes."' ";		

			$addWhereTotalVenta .= "  AND date_format(pedido.fecha_saldada, '%Y-%m') = '".$anio."-".($mes < 10 ? "0" : "").$mes."' ";
			$addWhereAllTotalVenta .= "  AND  date_format(pedido.fecha_saldada, '%Y-%m') = '".$anio."-".($mes < 10 ? "0" : "").$mes."' ";
		}
		
		if ($tipo == "T")
		{
			$mesini = "";
			$mesfin = "";
			if ($mes == 1){
				$mesini = "01";
				$mesfin = "03";
			}
			else if ($mes == 2){
				$mesini = "04";
				$mesfin = "06";
			}
			else if ($mes == 3){
				$mesini = "07";
				$mesfin = "09";
			}
			else if ($mes == 4){
				$mesini = "10";
				$mesfin = "12";
			
			}
			$addWhere .= "  AND pedido.estado = 'ENTREGADO' AND date_format(pedido.fecha_saldada, '%Y-%m') BETWEEN '".$anio."-".$mesini."' AND '".$anio."-".$mesfin."'  ";
			$addWhereAll .= "  AND pedido.estado = 'ENTREGADO' AND  date_format(pedido.fecha_saldada, '%Y-%m') BETWEEN '".$anio."-".$mesini."' AND '".$anio."-".$mesfin."' ";		

			$addWhereTotalVenta .= "  AND date_format(pedido.fecha_saldada, '%Y-%m') BETWEEN '".$anio."-".$mesini."' AND '".$anio."-".$mesfin."' ";
			$addWhereAllTotalVenta .= "  AND  date_format(pedido.fecha_saldada, '%Y-%m') BETWEEN '".$anio."-".$mesini."' AND '".$anio."-".$mesfin."' ";
		
		}
		
		if ($tipo == "A")
		{
			$addWhere .= "  AND pedido.estado = 'ENTREGADO' AND date_format(pedido.fecha_saldada, '%Y') = '".$anio."' ";
			$addWhereAll .= "  AND pedido.estado = 'ENTREGADO' AND  date_format(pedido.fecha_saldada, '%Y') = '".$anio."' ";		

			$addWhereTotalVenta .= "  AND date_format(pedido.fecha_saldada, '%Y') = '".$anio."' ";
			$addWhereAllTotalVenta .= "  AND  date_format(pedido.fecha_saldada, '%Y') = '".$anio."' ";
		
		}

		// }

		if (!Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) )
		{
			if ($filtro["promotor"] != "0")
			{
				$lst = $ped->getAll("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
                                     pedido.id_usuario_capturado, cliente.idusuariopromotor,
                                    concat(cliente.nombre, ' ', cliente.apellidos) as cliente, pedido.total, 
                                    getComisionesPedido(pedido.idPedido) as comisionesOld ,
                                    getComisionesPedidoUsuario(pedido.idPedido, ".$filtro["promotor"].") as comisiones , 
                                    pedido.idCorteComision, pedido.idCorteComisionVendedor, 
                                    pedido.idCorteComisionT, pedido.idCorteComisionTVendedor, 
                                    pedido.idCorteComisionA, pedido.idCorteComisionAVendedor, 
									pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
						"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
                        INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
						",
				    " (idUsuarioPromotor = ".$filtro["promotor"] ." OR pedido.id_usuario_capturado = " . $filtro["promotor"] ." ) " . $addWhere ,
						"idPedido");

				$lstTotalVenta = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, 
												pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, 
												pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, 
												concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, 
												pedido.saldada, pedido.saldo,
												pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor  ",
								"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
									INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
								",
								" (idUsuarioPromotor = ".$filtro["promotor"] ." OR pedido.id_usuario_capturado = " . $filtro["promotor"] ." )  " .$addWhereTotalVenta  ,
								"idPedido");
					
				$elIdPromotor = $filtro["promotor"] ;
				
				


			}
			else
			{


				$lst = $ped->getAll("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
                                
                                    concat(cliente.nombre, ' ', cliente.apellidos) as cliente, pedido.total, 
                                    getComisionesPedido(pedido.idPedido) as comisiones ,
                                    pedido.idCorteComision, pedido.idCorteComisionVendedor, 
                                    pedido.idCorteComisionT, pedido.idCorteComisionTVendedor, 
                                    pedido.idCorteComisionA, pedido.idCorteComisionAVendedor, 
									pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, 
									pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
						"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
                        INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
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
			$lst = $ped->getAll("date_format(pedido.fecha_capturado, '%d/%m/%Y %h:%i:%s') as fechacaptura, pedido.idpedido, pedido.idcliente,
                                pedido.id_usuario_capturado, cliente.idusuariopromotor,
                                concat(cliente.nombre, ' ', cliente.apellidos) as cliente, pedido.total, 
                                getComisionesPedido(pedido.idPedido) as comisionesOld ,
                                getComisionesPedidoUsuario(pedido.idPedido, ".$objSession->getIdUsuario() .") as comisiones , 
                                pedido.idCorteComision, pedido.idCorteComisionVendedor, 
                                pedido.idCorteComisionT, pedido.idCorteComisionTVendedor, 
                                pedido.idCorteComisionA, pedido.idCorteComisionAVendedor, 
								pedido.estado, pedido.saldada, date_format(pedido.fecha_saldada, '%d/%m/%Y %h:%i:%s') as fechasaldada, pedido.saldo , pedido.comisionpagada, concat(u.nombre,' ',u.apellidoPaterno,' ',u.apellidoMaterno) as nombrepromotor ",
					"INNER JOIN cliente  ON cliente.idCliente = pedido.idCliente
                    INNER JOIN usuario as u ON u.idUsuario = cliente.idUsuarioPromotor
						",
			    " (idUsuarioPromotor = ".$objSession->getIdUsuario() ." OR pedido.id_usuario_capturado = ". $objSession->getIdUsuario() . ") " . $addWhere,
					"idPedido");

			$lstTotalVenta = $ped->getAll("pedido.idPedido, pedido.idCliente, pedido.total, pedido.estado, pedido.observacionAutoriza, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_autorizado, pedidoPuedeTerminarse(pedido.idPedido) as todosValesSalida, pedidoPuedeProducirse(pedido.idPedido) as puedeProducirse, pedido.fecha_capturado, pedido.recogeentrega, concat(c.nombre, ' ' ,c.apellidos) as nombreCliente, concat(u.nombre, ' ' ,u.apellidoPaterno, ' ' , u.apellidoMaterno) as nombrePromotor, pedido.saldada, pedido.saldo,
								pedido.id_usuario_capturado idUsuarioCaptura, c.idUsuarioPromotor  ",
						"INNER JOIN cliente as c ON c.idCliente = pedido.idCliente
							INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor
							",
					" (idUsuarioPromotor = ".$objSession->getIdUsuario().") " . $addWhereTotalVenta,
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
		$totalPedidosDatoVenta = 0;
		
		
			foreach ($lstTotalVenta as $row)
			{
				 if ($row["idUsuarioPromotor"] == $elIdPromotor || $row["idCliente"] == 1 )
				 {
					$totalPedidosDatoVenta += $row["total"];
				 }
			}
		

		

		

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
                
                
				if ($tipo == "M"){
					if($row["idCorteComision"] == 0 && $miCliente == 'SI')
					{
						$comisionTotalPorPagar += $row["comisiones"];
						$totalPedidos += $row["total"];
					}
					else if ($row["idCorteComisionVendedor"] == 0 && $miCliente == 'NO')
					{
						$comisionTotalPorPagar += $row["comisiones"];
						$totalPedidos += $row["total"];
					}
				}
				else if ($tipo == "T"){
					if($row["idCorteComisionT"] == 0 && $miCliente == 'SI')
					{
						$comisionTotalPorPagar += $row["comisiones"];
						$totalPedidos += $row["total"];
						//$totalPedidosDatoVenta += $row["total"];
					}
					else if ($row["idCorteComisionTVendedor"] == 0 && $miCliente == 'NO')
					{
						$comisionTotalPorPagar += $row["comisiones"];
						$totalPedidos += $row["total"];
						//$totalPedidosDatoVenta += $row["total"];
					}
				}else if ($tipo == "A"){
					if($row["idCorteComisionA"] == 0 && $miCliente == 'SI')
					{
						$comisionTotalPorPagar += $row["comisiones"];
						$totalPedidos += $row["total"];
						//$totalPedidosDatoVenta += $row["total"];
					}
					else if ($row["idCorteComisionAVendedor"] == 0 && $miCliente == 'NO')
					{
						$comisionTotalPorPagar += $row["comisiones"];
						$totalPedidos += $row["total"];
						//$totalPedidosDatoVenta += $row["total"];
					}
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
							idCorteComision: ".$row["idCorteComision"].",
                            idCorteComisionVendedor: ".$row["idCorteComisionVendedor"].",
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
            app.comisionTotalPendiente = ". ($tipo == "M" ? $comisionTotalPendiente: 0 ).";
			app.totalPedidos = ".$totalPedidos.";
			app.totalPedidosDatoVenta = ".$totalPedidosDatoVenta.";
			
            

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

			 setTimeout({ app.calcularIncentivo();}, 1000);





            ");

            // return $r;
		}

        
		
		
		if ($tipo == "M")
		{			
			$addWhere = " AND date_format(pedido.fecha_capturado, '%Y-%m-%d') >= '".$fechaPrimerPedido."' AND date_format(pedido.fecha_capturado, '%Y-%m') <= '".$anio."-".($mes < 10 ? "0" : "").$mes."' ";
		}
		
		if ($tipo == "T")
		{
			$mesini = "";
			$mesfin = "";
			if ($mes == 1){
				$mesini = "01";
				$mesfin = "03";
			}
			else if ($mes == 2){
				$mesini = "04";
				$mesfin = "06";
			}
			else if ($mes == 3){
				$mesini = "07";
				$mesfin = "09";
			}
			else if ($mes == 4){
				$mesini = "10";
				$mesfin = "12";
			
			}
			
			$addWhere = " AND date_format(pedido.fecha_capturado, '%Y-%m-%d') >= '".$fechaPrimerPedido."' AND date_format(pedido.fecha_capturado, '%Y-%m') <= '".$anio."-".$mesfin."' ";			
		
		}
		
		if ($tipo == "A")
		{			
			$addWhere = " AND date_format(pedido.fecha_capturado, '%Y-%m-%d') >= '".$fechaPrimerPedido."' AND date_format(pedido.fecha_capturado, '%Y-%m') <= '".$anio."-12' ";			
		
		}


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

         chart.setTitle({text: 'Reporte de Pedidos de ' + app.strTipoObjetivo});
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
		// $r->endDegug();
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

	function generarCorteComision($promotor, $pedidos, $deducciones, $totalAPagar, $totalDeducciones, $netoAPagar, $incentivo, $objetivoPorcentaje)
	{
		$r = new xajaxResponse();

		$doCommit = true;
		$errores = "";
		
		$cc = new ModeloCorteComision();
		$tipo = $promotor["tipoComision"];
		$mes = $promotor["mes"];
		$anio = $promotor["anio"];


		$cc->transaccionIniciar();
		$cc->setIdPromotor($promotor["promotor"]);
		$cc->setTipo($tipo);
		$cc->setMes($mes);
		$cc->setAnio($anio);
		// $cc->setFechaInicio($promotor["fechaInicio"]);
		// $cc->setFechaFin($promotor["fechaFin"]);
		$cc->setTotal($totalAPagar);
		$cc->setIncentivo($incentivo);
		$cc->setPorcentajeObjetivoVenta($objetivoPorcentaje);
		$cc->setComisionAdelantada($totalDeducciones);
		$cc->setAPagar($cc->getTotal() + $cc->getIncentivo() - $cc->getComisionAdelantada());
		$cc->setDateAndUser("creacion");
		
		$cc->Guardar();
		
		if ($cc->getError())
		{
			$errores .= "[cortecom]" .$cc->getStrError();
			$doCommit = false;
		}
		else
		{
			foreach($pedidos as $item)
			{
				$ped = new ModeloPedido();

				$ped->setIdPedido($item["idPedido"]);
				$ped->getDatos();

				if ($ped->getIdPedido() <= 0)
				{
				    $r->mostrarAviso("no se cargo pedido"); return $r;
				    $errores .= "No se pudo cargar la información del Pedido ". $item["idPedido"].".";
					$doCommit = false;
				}
				else
				{
				    if ($tipo == "M")
					{
						if ($item["miCliente"] == "SI")
						{
							$ped->setIdCorteComision($cc->getIdCorteComision());
						}
						else
						{
							$ped->setIdCorteComisionVendedor($cc->getIdCorteComision());
						}
					}
					else if ($tipo == "T")
					{
						if ($item["miCliente"] == "SI")
						{
							$ped->setIdCorteComisionT($cc->getIdCorteComision());
						}
						else
						{
							$ped->setIdCorteComisionTVendedor($cc->getIdCorteComision());
						}
					
					}else if ($tipo == "A")
					{
						if ($item["miCliente"] == "SI")
						{
							$ped->setIdCorteComisionA($cc->getIdCorteComision());
						}
						else
						{
							$ped->setIdCorteComisionAVendedor($cc->getIdCorteComision());
						}
					}

					$ped->Guardar();
		      
					if ($ped->getError())
					{
					    $errores .= "[pedido]" . $ped->getStrError();
					    $doCommit = false;
					}
					
				}

			}
			foreach($deducciones as $de)
			{			    
			    $cxccc = new ModeloCxccuentacomision();
			    
			    $cxccc->setIdCxcCuentaComision($de["idcxccuentacomision"]);
			    			    
			    if ($cxccc->getIdCxcCuentaComision() <= 0)
			    {
			        $errores .= "No se pudo cargar la información de Comisión Adelantada". $de["idcxccuentacomision"].".";
			        $doCommit = false;
			    }
			    else
			    {
			        $cxccc->setIdCorteComision($cc->getIdCorteComision());
			        
			        $cxccc->Guardar();
			        
			        if ($cxccc->getError())
			        {
			            $errores .="[cxccuentacomision]" . $cxccc->getStrError();
			            $doCommit = false;
			        }
			    }
			}
			$cxccomision = new ModeloCxccuentacomision();
			
			$cxccomision->setIdUsuario($promotor["promotor"]);
			$cxccomision->setTipoPAGAR();
			$cxccomision->setIdConceptoGasto(1);
			$cxccomision->setDateAndUser("creacion");
			$cxccomision->setMonto($totalAPagar);
			$cxccomision->setObservacion(mb_convert_encoding("CORTE COMISIÓN, MONTO GENERADO", 'UTF-8', 'ISO-8859-1');
			$cxccomision->setIdCorteComision($cc->getIdCorteComision());
			
			$cxccomision->Guardar();
			
			if ($cxccomision->getError())
			{
			    $errores .= "Ocurrió un error al intentar registrar la Comisión Anticipada que se ha generado.";
             $doCommit = false;
			}

			//se mete el incentivo

			$cxccomision = new ModeloCxccuentacomision();
			
			$cxccomision->setIdUsuario($promotor["promotor"]);
			$cxccomision->setTipoINCENTIVO();
			$cxccomision->setIdConceptoGasto(1);
			$cxccomision->setDateAndUser("creacion");
			$cxccomision->setMonto($incentivo);
			$cxccomision->setObservacion(mb_convert_encoding("INCENTIVO DE COMISIÓN", 'UTF-8', 'ISO-8859-1');
			$cxccomision->setIdCorteComision($cc->getIdCorteComision());
			
			$cxccomision->Guardar();
			
			if ($cxccomision->getError())
			{
			    $errores .= "Ocurrió un error al intentar registrar el incentivo de la Comisión Anticipada que se ha generado.";
	             $doCommit = false;
			}
			
			if ($netoAPagar < 0)
			{			    
			    $cxcarrastrar = new ModeloCxccuentacomision();
			    
			    $cxcarrastrar->setIdUsuario($promotor["promotor"]);
			    $cxcarrastrar->setTipoDEDUCIR();
			    $cxcarrastrar->setIdConceptoGasto(1);
			    $cxcarrastrar->setDateAndUser("creacion");
			    $cxcarrastrar->setMonto($netoAPagar * -1);
			    $cxcarrastrar->setObservacion(mb_convert_encoding("CORTE COMISIÓN ANTERIOR NEGATIVO", 'UTF-8', 'ISO-8859-1');
			    
			    $cxcarrastrar->Guardar();
			    
			    if ($cxcarrastrar->getError())
			    {
			        $errores .= "Ocurrió un error al intentar registrar la Comisión Anticipada que se ha generado.";
             		$doCommit = false;
			    }
			    
			}

			
		}
		
		if ($doCommit)
		{
		    $cc->transaccionCommit();
		    $r->saSuccess("Se ha generado el Corte de Comision: " . $cc->getIdCorteComision());
		    
		    $r->script(" app.mostrarBotonGeneraCorteComision = true; app.obtenerReporte();");
		}
		else
		{
		    $cc->transaccionRollback();

		    $r->saError($errores);
		    
		}

		return $r;
	}
	$xajax->registerFunction("generarCorteComision");

	
	function cargarComisionesAnticipadasSinComision($idPromotor, $tipo, $mes, $anio)
	{
	    $r = new xajaxResponse();
	    
	    $ccc = new ModeloCxccuentacomision();
	    
	    $addWhere = "";
	    
	    
	    // if ($desde != "" && $hasta != "")
	    // {
	    //     $desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
	    //     $hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);
	        

		if ($tipo == "M")
		{			
	    	$addWhere .= "  AND date_format(cxccuentacomision.fecha_creacion, '%Y-%m') = '".$anio."-".($mes < 10 ? "0" : "").$mes."' ";			
		}
		else
		{
			$r->script(" app.comisionesanticipadas.splice(0, app.comisionesanticipadas.length); ");
			return $r;
		}
		
		if ($tipo == "T")
		{
			$mesini = "";
			$mesfin = "";
			if ($mes == 1){
				$mesini = "01";
				$mesfin = "03";
			}
			else if ($mes == 2){
				$mesini = "04";
				$mesfin = "06";
			}
			else if ($mes == 3){
				$mesini = "07";
				$mesfin = "09";
			}
			else if ($mes == 4){
				$mesini = "10";
				$mesfin = "12";
			
			}
	    	$addWhere .= "  AND date_format(cxccuentacomision.fecha_creacion, '%Y-%m') BETWEEN '".$anio."-".$mesini."' AND '".$anio."-".$mesfin."' ";			

		}
		
		if ($tipo == "A")
		{
	    	$addWhere .= "  AND date_format(cxccuentacomision.fecha_creacion, '%Y') = '".$anio."' ";			
		
		}
		
// 	        $r->mostrarAviso("bien que que que"); return $r;
	    // }
	    
	    $lst = $ccc->getAll("cxccuentacomision.idcxccuentacomision, cxccuentacomision.tipo, conceptogasto.nombre as concepto, cxccuentacomision.fecha_creacion, cxccuentacomision.monto, cxccuentacomision.observacion ",
	        "inner join conceptogasto on conceptogasto.idConceptoGasto = cxccuentacomision.idConceptoGasto",
    	        " cxccuentacomision.tipo = 'DEDUCIR' AND cxccuentacomision.idcortecomision = 0 AND cxccuentacomision.idUsuario = " . $idPromotor . $addWhere,
	        " idCxcCuentaComision");
	   	    
	    $pushes = "";
	    $total = 0;
	    foreach ($lst as $item)
	    {
	        $pushes .= "
	            
            app.comisionesanticipadas.push (
        		{
                    idcxccuentacomision: ".$item["idcxccuentacomision"].",
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
	

	function obtenerObjetivoParaIncentivo($idPromotor)
	{
		$r = new xajaxResponse();

		$op = new ModeloObjetivopromotor();

		$mes = date('n');
		$anio = date('Y'); 
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$mes -= 1;
		
		if ($mes == 0)
		{
			$mes = 12;
			$anio--;
		}

		$dato = $op->getDataSet("SELECT IFNULL(objetivo, 0) objetivo 
								FROM objetivopromotor
								WHERE anio = ".$anio."
								AND mes = ".$mes."
								AND idPromotor = " . $idPromotor );


		$objetivo = 0;

		if (count($dato) > 0)
		{
			$objetivo = $dato[0]["objetivo"];
		}
		

								
		$r->script(" app.objetivoParaIncentivo = ".$objetivo."; 
					app.objetivoMes = '".$meses[$mes-1]."';
					app.objetivoAnio = ".$anio.";
					");

		return $r;
	}
	$xajax->registerFunction("obtenerObjetivoParaIncentivo");
	


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
