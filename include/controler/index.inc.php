<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.pedido.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


function getNombreMes($mes)
{
    $elmes = "";
    
    if ($mes == 1)
    {
        $elmes = "ENERO";
    }
    else if ($mes == 2)
    {
        $elmes = "FEBRERO";
    }
    else if ($mes == 3)
    {
        $elmes = "MARZO";
    }
    else if ($mes == 4)
    {
        $elmes = "ABRIL";
    }
    else if ($mes == 5)
    {
        $elmes = "MAYO";
    }
    else if ($mes == 6)
    {
        $elmes = "JUNIO";
    }
    else if ($mes == 7)
    {
        $elmes = "JULIO";
    }
    else if ($mes == 8)
    {
        $elmes = "AGOSTO";
    }
    else if ($mes == 9)
    {
        $elmes = "SEPTIEMBRE";
    }
    else if ($mes == 10)
    {
        $elmes = "OCTUBRE";
    }
    else if ($mes == 11)
    {
        $elmes = "NOVIEMBRE";
    }
    else
    {
        $elmes = "DICIEMBRE";
    }
    
    return $elmes;
    
}

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


function cargarVentaAnual($anio)
{
    $r = new xajaxResponse();
    //         $r->starDebug();
    
    $vmes = array();
    
    $vmes["01"] = 0;
    $vmes["02"] = 0;
    $vmes["03"] = 0;
    $vmes["04"] = 0;
    $vmes["05"] = 0;
    $vmes["06"] = 0;
    $vmes["07"] = 0;
    $vmes["08"] = 0;
    $vmes["09"] = 0;
    $vmes["10"] = 0;
    $vmes["11"] = 0;
    $vmes["12"] = 0;
    
    $pedido = new ModeloPedido();
    
//     $lst = $pedido->getAll("cliente.idusuariopromotor, usuario.username, concat(usuario.nombre,' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno) as promotor, date_format(pedido.fecha_capturado, '%m') as mes, sum(pedido.total) as total ",
//         "inner join cliente
//             on cliente.idcliente = pedido.idcliente
//             inner join usuario
//             on usuario.idusuario = cliente.idusuariopromotor",
//         " pedido.estado <> 'CANCELADO'  ",
//         " 4, 3",
//         " 1,2,3, 4 ");

    $lst = $pedido->getAll("(pedido.id_usuario_capturado) as username, 
    concat(usuario.nombre,' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno)  as  promotor, 
    date_format(pedido.fecha_capturado, '%m') as mes,
    SUM(pedido.total) as total,pedido.id_usuario_capturado",
        "inner join usuario on usuario.idusuario = pedido.id_usuario_capturado",
        " date_format(pedido.fecha_capturado, '%Y') = ".$anio." and pedido.estado <> 'CANCELADO'  ",
        " 3,2",
        " 1,2,3");

    $promotores = array();

    $promo = "";
    $username = "";
    foreach ($lst as $row)
    {
        $vmes[$row["mes"]] = $row["total"];
        
        $promo = strtoupper($row["promotor"]);
        $username = strtoupper($row["username"]);
        
        if (!isset($promotores[$username]))
        {
            $promotores[$username] = array(
                
                "nombre" => $promo,
                "01"     => 0,
                "02"     => 0,
                "03"     => 0,
                "04"     => 0,
                "05"     => 0,
                "06"     => 0,
                "07"     => 0,
                "08"     => 0,
                "09"     => 0,
                "10"     => 0,
                "11"     => 0,
                "12"     => 0,
                
            );
        }
        
        $promotores[$username][$row["mes"]] = $row["total"];
        
        
        //         echo $row["promotor"] . " " . $row["mes"] ;
        //         echo $row["mes"] . " " . $row["total"];
        //         $vmes[$row["mes"]] = $row["total"];
        // $r->mostrarAviso($row["promotor"] . " " . $row["mes"] );
    }
    
    
    //     print_r($promotores);
    //     var_dump($promotores);
    
    //     echo "<br><br>";
    
    //     var_dump($promotores["JAVIERSILVA"]);
    
    $categorias = "";
    
    for($i = 1 ; $i <= 12 ; $i++)
    {
        if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
        {
            $categorias .= ($categorias == "" ? "'" : ",'" ) . getNombreMes($i) . "'";
        }
    }
    
    $series = "";
    $dataSerie = "";
    foreach ($promotores as $p)
    {
        $dataSerie = "";
        for($i = 1 ; $i <= 12 ; $i++)
        {
            if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
            {
                $dataSerie .= ($dataSerie == "" ? "" : "," ) . $p[($i < 10 ? "0" : "") . $i] ;
            }
        }
        
        $series .= "
            
                chart.addSeries({
                    name: '".$p["nombre"]."',
                    data: [".$dataSerie."]
                }, false);
                        
                        
            ";
        
    }
    
    
    $r->script("
        
                $('#modalWait').modal('hide');

                var index = $('#chartAnio').data('highchartsChart');
                chart = Highcharts.charts[index];
        
                chart.setTitle({text: '".mb_convert_encoding("Ventas por Promotor ", 'UTF-8', 'ISO-8859-1').$anio."'});                

                chart.xAxis[0].setCategories([]);
                chart.xAxis[0].setCategories([".$categorias."]);


                while(chart.series.length > 0)
                    chart.series[0].remove(true);
        
                ".$series."
        
                chart.redraw();
        
        
    ");
    
    //         $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarVentaAnual");

function cargarVentaAnualResp()
{
    $r = new xajaxResponse();
    //     $r->starDebug();
    
    $vmes = array();
    
    $vmes["01"] = 0;
    $vmes["02"] = 0;
    $vmes["03"] = 0;
    $vmes["04"] = 0;
    $vmes["05"] = 0;
    $vmes["06"] = 0;
    $vmes["07"] = 0;
    $vmes["08"] = 0;
    $vmes["09"] = 0;
    $vmes["10"] = 0;
    $vmes["11"] = 0;
    $vmes["12"] = 0;
    
    $pedido = new ModeloPedido();
    
    $lst = $pedido->getAll("date_format(fecha_capturado, '%m') as mes, sum(total) as total",
        "",
        "  estado <> 'CANCELADO' ",
        "",
        " 1 ");
    
    //     $r->mostrarAviso($pedido->getAllQUERY("date_format(fecha_capturado, '%m') as mes, sum(total) as total",
    //         "",
    //         "  estado <> 'CANCELADO' ",
    //         "",
    //         " 1 "));
    
    foreach ($lst as $row)
    {
        //         echo $row["mes"] . " " . $row["total"];
        $vmes[$row["mes"]] = $row["total"];
    }
    
    
    $r->script("
        
                var index = $('#chartAnio').data('highchartsChart');
                chart = Highcharts.charts[index];
        
                chart.series[0].setData([]);
                chart.series[0].setData([
                ".$vmes["01"].",
                ".$vmes["02"].",
                ".$vmes["03"].",
                ".$vmes["04"].",
                ".$vmes["05"].",
                ".$vmes["06"].",
                ".$vmes["07"].",
                ".$vmes["08"].",
                ".$vmes["09"].",
                ".$vmes["10"].",
                ".$vmes["11"].",
                ".$vmes["12"]."
        
        
        
                ], false);
                chart.redraw();
        
    ");
    
    //     $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarVentaAnualResp");


function cargarVentaMensual($mes, $anio)
{
    $r = new xajaxResponse();
    
    $pedido = new ModeloPedido();
    $mes++;
    
    $lst = $pedido->getAll("date_format(fecha_capturado, '%d-%m-%Y') as fecha, sum(total) as total ",
        "",
        "  estado <> 'CANCELADO' AND date_format(fecha_capturado, '%m') = '".($mes<10 ? '0' : '').$mes."' ",
        " fecha_capturado",
        " 1 ");
    
    
    $categorias = "";
    $totales = "";
    
    foreach ($lst as $row)
    {
        //         echo $row["mes"] . " " . $row["total"];
        $categorias .= ($categorias == "" ? "" : "," ) . "'" .$row["fecha"] . "'";
        $totales .= ($totales == "" ? "" : "," ) . "" .$row["total"] . "";
        //         $vmes[$row["mes"]] = $row["total"];
    }
    
    
    
    $r->script("
        
                app.showAnio = false;
        
                var index = $('#chartMes').data('highchartsChart');
                chart = Highcharts.charts[index];
        
                chart.xAxis[0].setCategories([]);
                chart.xAxis[0].setCategories([".$categorias."]);
        
                chart.series[0].setData([]);
                chart.series[0].setData([".$totales."], false);
                chart.redraw();
        
        
    ");
    
    return $r;
}
$xajax->registerFunction("cargarVentaMensual");

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
          
        
        $totalDia="";
		$movimientos = "";

		 $lstMovimientos = $pedido->getAll("  SUM(total)   as totalDia",
				"",
				"fecha_capturado >= curdate() and pedido.estado <> 'CANCELADO'",
                "",
                "");
		//($recibos-getAll);	
    //     $r->mostraraviso($pedido->getAllQUERY("  SUM(total)   as totalDia",
    //     "",
    //     "fecha_capturado >= curdate() and pedido.estado <> 'CANCELADO'",
    //     "",
    //     ""));
    //    return $r;
		foreach ($lstMovimientos as $row)
		{

            $totalDia = "
            app.totalDia = '".($row["totalDia"]). "';
                                         ";       
        }
      
        $r->script($totalDia);
       // $r->mostrarAviso("Hola");

       return $r;
       
	}
	$xajax->registerFunction("cargarTotales");

    function pedidosDelDia()
	{
		$r = new xajaxResponse();
		$pedido = new ModeloPedido();
          
        $pedidosDelDia="";

		 $pedidosDia = $pedido->getAll(" usuario.nombre, (cliente.nombre)as cliente, pedido.idPedido, date_format(fecha_capturado,'%h:%i')as hora_captura, pedido.estado , (pedido.total)as total",
				"INNER JOIN usuario on pedido.id_usuario_capturado = usuario.idUsuario
                 INNER JOIN cliente on pedido.idCliente = cliente.idCliente",
				"fecha_capturado >= curdate() and pedido.estado <> 'CANCELADO'",
                "`pedido`.`total` DESC",
                "");

		foreach ($pedidosDia as $row)
		{
	       $pedidosDelDia .= "

            app.pedidosDelDia.push({
                usuarioCaptura: '".$row["nombre"]."',
                cliente: '".$row["cliente"]."',
                idPedido: '".$row["idPedido"]."',
                estado: '".$row["estado"]."',
                hora_captura: '".$row["hora_captura"]."',
                total: '".$row["total"]."',                                                                                    
            });						
        ";      
        }
      
        $r->script($pedidosDelDia);
       // $r->mostrarAviso("Hola");

       return $r;
       
	}
	$xajax->registerFunction("pedidosDelDia");
    function acumuladoPromotor()
	{
		$r = new xajaxResponse();
		$pedido = new ModeloPedido();
          
        $acumuladoPromotor="";
        $posicion = 1;

		 $acumulado = $pedido->getAll(" usuario.nombre,  sum(pedido.total)as total",
				"INNER JOIN usuario on pedido.id_usuario_capturado = usuario.idUsuario",
				"date_format(pedido.fecha_capturado, '%Y') = date_format(curdate(), '%Y')and pedido.estado <> 'CANCELADO'",
                "2 DESC",
                "1");

                $total = 'total';
              
                $totalVentaAcumulada = array_sum(array_column($acumulado,$total));
       
		foreach ($acumulado as $row)
		{
            
	       $acumuladoPromotor .= "

            app.acumuladoPromotor.push({
                posicion:'".$posicion++."',
                usuarioCaptura: '".$row["nombre"]."',
                total: '".$row["total"]."', 
                totalVentaAcumulada: '".$totalVentaAcumulada."',                                                                                     
            });						
        ";      
        }
    
        $r->script($acumuladoPromotor);
       
       return $r;
	}
	$xajax->registerFunction("acumuladoPromotor");

    function grafico()
	{
		$r = new xajaxResponse();
		$pedido = new ModeloPedido();
                // Pedidos Recoge se interprera que fueron entregados a tiempo si la fecha_terminado del pedido es igual o menos a la fecha_compromiso
		 $acumulado = $pedido->getAll("  SUM(if(recogeentrega = 'ENTREGA', (if(datediff(fechaCompromiso , fecha_entregado)<0,1,0)), 0))as fueraDeTiempoEntrega,
                                         SUM(if(recogeentrega = 'ENTREGA', (if(datediff(fechaCompromiso, fecha_entregado)=0,1,0)), 0))as aTiempoEntrega,
                                         SUM(if(recogeentrega = 'ENTREGA', (if(datediff(fechaCompromiso, fecha_entregado)>0,1,0)), 0)) as anticipadaEntrega,
                                         SUM(if(recogeentrega = 'RECOGE', (if(datediff(fechaCompromiso , fecha_terminado )<0,1,0)), 0))as fueraDeTiempoRecoge,
                                         SUM(if(recogeentrega = 'RECOGE', (if(datediff(fechaCompromiso, fecha_terminado)=0,1,0)), 0))as aTiempoRecoge,
                                         SUM(if(recogeentrega = 'RECOGE', (if(datediff(fechaCompromiso, fecha_terminado)>0,1,0)), 0)) as anticipadaRecoge",
				"",
				"date_format(pedido.fechaCompromiso, '%Y') = date_format(CURRENT_DATE, '%Y') and pedido.estado = 'ENTREGADO' and recogeentrega<>'OBRA'",
                "",
                "");
                
                $acum = "";
                
                foreach($acumulado as $acum){
                    $fueraDeTiempo = $acum["fueraDeTiempoEntrega"]+$acum["fueraDeTiempoRecoge"];
                    $aTiempo = $acum["aTiempoEntrega"]+$acum["aTiempoRecoge"];
                    $anticipada = $acum["anticipadaEntrega"]+$acum["anticipadaRecoge"];
                    $totalPedidos = $fueraDeTiempo + $aTiempo + $anticipada;
                };

                $r->script("
				
				var index = $('#grPedidos').data('highchartsChart');	
		        var chart = Highcharts.charts[index];
		
				index = $('#grPedidosExplotadosPie').data('highchartsChart');	
		        chart = Highcharts.charts[index];
				
				chart.series[0].setData([]);
				
				chart.setTitle(null,{text: 'Total Pedidos: ".$totalPedidos."'});				
				chart.series[0].addPoint({name: 'A TIEMPO', color: \"#1ab394\", y: ".$aTiempo."});
				chart.series[0].addPoint({name: 'ANTICIPADOS', color: \"#0000FF\", y: ".$anticipada."});
				chart.series[0].addPoint({name: 'ATRASADOS', color: \"#FF8000\", y: ".$fueraDeTiempo."});
				
				chart.redraw();
				
				
				");       
       
                // $r->mostrarAviso("Hola");
                return $r;

       
	}
	$xajax->registerFunction("grafico");

  




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
