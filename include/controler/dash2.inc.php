<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

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
	
// 	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
			
	function cargarInformacionPedidos()
	{
		$r = new xajaxResponse();
					
		$pedido = new ModeloPedido();
		
		$lst = $pedido->getAll("idPedido, explotado, explotadook, estado");
		
		$capturados = 0;
		$autorizados = 0;
		$produccion = 0;
		$terminado = 0;
		$entregado = 0;
		$cancelado = 0;
		$totalPedidos = 0;
			
		$explotadoOK = 0;
		$explotadoFail = 0;
		$sinexplotar = 0;
		
		foreach ($lst as $row)
		{
			$totalPedidos++;
			
			if ($row["explotado"] == "SI")
			{
				if ($row["explotadook"] == "SI")
				{
					$explotadoOK++;	
				}
				else 
				{
					$explotadoFail++;
				}				
			}
			else
			{
				$sinexplotar++;
			}
			
			switch ($row["estado"])
			{
				case "CAPTURADO";
					$capturados++;
					break;
				case "AUTORIZADO";
					$autorizados++;
					break;
				case "PRODUCCION";
					$produccion++;
					break;
				case "TERMINADO";
					$terminado++;
					break;
				case "ENTREGADO";
					$entregado++;
					break;
				case "CANCELADO";
					$cancelado++;
					break;
			}
		}
		
		$r->script("
				
				var index = $('#grPedidos').data('highchartsChart');	
		        var chart = Highcharts.charts[index];
				
				chart.series[0].setData([]);
				
				chart.setTitle(null,{text: 'Total Pedidos: ".$totalPedidos."'});
				chart.series[0].addPoint({color: \"#f8ac59\",  y: ".$capturados."});
				chart.series[0].addPoint({color: \"#d1dade\", y: ".$autorizados."});
				chart.series[0].addPoint({color: \"#23c6c8\", y: ".$produccion."});
				chart.series[0].addPoint({color: \"#1ab394\", y: ".$terminado."});
				chart.series[0].addPoint({color: \"#1c84c6\", y: ".$entregado."});
				chart.series[0].addPoint({color: \"#ed5565\", y: ".$cancelado."});
				
				chart.redraw();
				
				index = $('#grPedidosPie').data('highchartsChart');	
		        chart = Highcharts.charts[index];
				
				chart.series[0].setData([]);
				
				chart.setTitle(null,{text: 'Total Pedidos: ".$totalPedidos."'});
				chart.series[0].addPoint({name: 'CAPTURADOS', color: \"#f8ac59\",  y: ".$capturados."});
				chart.series[0].addPoint({name: 'AUTORIZADOS', color: \"#d1dade\", y: ".$autorizados."});
				chart.series[0].addPoint({name: 'PRODUCCION', color: \"#23c6c8\", y: ".$produccion."});
				chart.series[0].addPoint({name: 'TERMINADO', color: \"#1ab394\", y: ".$terminado."});
				chart.series[0].addPoint({name: 'ENTREGADO', color: \"#1c84c6\", y: ".$entregado."});
				chart.series[0].addPoint({name: 'CANCELADO', color: \"#ed5565\", y: ".$cancelado."});
				
				chart.redraw();
				
				index = $('#grPedidosExplotados').data('highchartsChart');	
		        chart = Highcharts.charts[index];
				
				chart.setTitle(null,{text: 'Total Pedidos: ".$totalPedidos."'});				
				chart.series[0].addPoint({color: \"#1ab394\", y: ".$explotadoOK."});
				chart.series[0].addPoint({color: \"#f8ac59\", y: ".$explotadoFail."});
				chart.series[0].addPoint({color: \"#ed5565\", y: ".$sinexplotar."});
				
				chart.redraw();
				
				index = $('#grPedidosExplotadosPie').data('highchartsChart');	
		        chart = Highcharts.charts[index];
				
				chart.series[0].setData([]);
				
				chart.setTitle(null,{text: 'Total Pedidos: ".$totalPedidos."'});				
				chart.series[0].addPoint({name: 'EXPLOSIONADOS CON EXITO', color: \"#1ab394\", y: ".$explotadoOK."});
				chart.series[0].addPoint({name: 'EXPLOSIONADOS SIN EXITO', color: \"#f8ac59\", y: ".$explotadoFail."});
				chart.series[0].addPoint({name: 'SIN EXPLOSIONAR', color: \"#ed5565\", y: ".$sinexplotar."});
				
				chart.redraw();
				
				
				");
	
		return $r;
	}
	$xajax->registerFunction("cargarInformacionPedidos");
	
	
	
	
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
		