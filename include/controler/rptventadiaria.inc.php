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
	function cargarRecibos()
	{
		$r = new xajaxResponse();
		$recibo = new ModeloPedido();
		
			
		$movimientos = "";

		 $lstMovimientos = $recibo->getAll("pedido.id_usuario_capturado, usuario.nombre, SUM(pedido.total)as total, (SELECT SUM(total) FROM `pedido` where fecha_capturado >= curdate() and pedido.estado <> 'CANCELADO')as totalDia, COUNT(idPedido)numPedidos, COUNT(DISTINCT(idCliente))numClientes",
				"INNER JOIN usuario on pedido.id_usuario_capturado = usuario.idUsuario",
				"fecha_capturado >= curdate() and pedido.estado <> 'CANCELADO'",
                "total desc",
                "usuario.nombre");
		//($recibos-getAll);	
        	
		foreach ($lstMovimientos as $row)
		{
			
			$movimientos .= "
	
						app.movimientos.push({
                            usuarioCaptura: '".$row["nombre"]."',
                            idUsuarioCaptura: '".$row["id_usuario_capturado"]."',
                            pedidoTotal: '".$row["total"]."',
                            porcentaje: '".$row["total"]/$row["totalDia"]."',
							totalDia: '".$row["totalDia"]."',
							numClientes: '".$row["numClientes"]."',
							numPedidos: '".$row["numPedidos"]."',
                            
                            													
						});						
					";
                    //$r->mostrarAviso($row["id_usuario_capturado"]);
                         
        }

		$r->script($movimientos. " app.movimientos.splice(0, app.movimientos.length); " . $movimientos);
	
        return $r;   
        
        
	//$r->endDebug();
		//return $r;
	}
	$xajax->registerFunction("cargarRecibos");

	function cargarTotales()
	{
		$r = new xajaxResponse();
		$pedido = new ModeloPedido();
		$totales = "";
		 
		 $lstTotales = $pedido->getAll("SUM(pedido.total)as totalDia, COUNT(idPedido) as totalPedidos, COUNT(DISTINCT(idCliente))as totalClientes",
				"",
				"fecha_capturado >= curdate()",
				"",
				"");
		
				
	
		foreach ($lstTotales as $row)
		{
			
			$totales .= "
				
                            
                            app.totalClientes = '".$row["totalClientes"].";
                            app.totalPedidos = '".$row["totalPedidos"].";                      															
							"; 
										  			  
		}
		

		$r->script($totales);
		return $r; 
	}
	$xajax->registerFunction("cargarTotales");
	
	
	$xajax->processRequest();


