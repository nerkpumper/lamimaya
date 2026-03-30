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

    $lst = $pedido->getAll("if(pedido.idpedido < 1571 and cliente.idusuariopromotor = 18, 10, cliente.idusuariopromotor) as idusuariopromotor, if(pedido.idpedido < 1571 and cliente.idusuariopromotor = 18, 'YoanaPinedo', usuario.username) as username, 
                         if(pedido.idpedido < 1571 and cliente.idusuariopromotor = 18, 'Yoana Alejandra Pinedo M.', concat(usuario.nombre,' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno) ) as  promotor, 
                        date_format(pedido.fecha_capturado, '%m') as mes, sum(pedido.total) as total ",
        "inner join cliente
            on cliente.idcliente = pedido.idcliente
            inner join usuario
            on usuario.idusuario = cliente.idusuariopromotor",
        " date_format(pedido.fecha_capturado, '%Y') = ".$anio." and pedido.estado <> 'CANCELADO'  ",
        " 4, 3",
        " 1,2,3, 4 ");

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
        
                chart.setTitle({text: '".mb_convert_encoding("Compras de Clientes agrupado por Promotor ", 'UTF-8', 'ISO-8859-1').$anio."'});                

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

function cargardetalleventas($anio)
	{
		$r = new xajaxResponse();
		$pedido = new ModeloPedido();
		
				
        //$r->mostrarAviso("Hola chava");
       
		$movimientos = "";
		//
	// 	 $lstMovimientos = $pedido->getAll("date_format(pedido.fecha_capturado, '%m') as mes,
    //      IF(date_format(pedido.fecha_capturado, '%m')=01,'Enero',
    //  IF(date_format(pedido.fecha_capturado, '%m')=02,'Febrero',
    //  IF(date_format(pedido.fecha_capturado, '%m')=03,'Marzo',
    //  IF(date_format(pedido.fecha_capturado, '%m')=04,'Abril', 
    //  IF(date_format(pedido.fecha_capturado, '%m')=05,'Mayo',
    //  IF(date_format(pedido.fecha_capturado, '%m')=06,'Junio',
    //  IF(date_format(pedido.fecha_capturado, '%m')=07,'Julio',
    //  IF(date_format(pedido.fecha_capturado, '%m')=08,'Agosto', 
    //  IF(date_format(pedido.fecha_capturado, '%m')=09,'Septiembre',
    //  IF(date_format(pedido.fecha_capturado, '%m')=10,'Octubre',
    //  IF(date_format(pedido.fecha_capturado, '%m')=11,'Noviembre',
    //  IF(date_format(pedido.fecha_capturado, '%m')=12,'Diciembre',    
    //    date_format(pedido.fecha_capturado, '%m')))))))))))))as mesDes,
    //      SUM(if(pedidodetalle.idProducto <> 386 ,pedidodetalle.partida * pedidodetalle.cantidad * (rollo.pesocu* rollo.pesokgmt *1.16),0))as costoDerivados, 
    //      SUM(if(pedidodetalle.idRolloBase=1 ,pedidodetalle.partida * pedidodetalle.cantidad * producto.costo,0))as costoStock, 
    //      SUM(if(pedidodetalle.idProducto = 386 ,rollo.pesocu * rollo.pesokgmt* 1.16 * pedidodetalle.partida * (pedidodetalle.cantidad/(round((rollo.pies*30.5)/ pedidodetalle.desarrollo))),0))as costoMolduras 
    //       ",
         
    //      "INNER JOIN pedidodetalle ON pedido.idPedido = pedidodetalle.IdPedido 
    //       INNER JOIN producto on pedidodetalle.idProducto = producto.idProducto 
    //       INNER JOIN rollo on pedidodetalle.idRolloBase = rollo.idRollo ",
    //      "date_format(pedido.fecha_capturado, '%Y') = ".$anio."
        
    //       and pedido.estado <> 'CANCELADO'",
    //      "",
    //      "1");


		//($recibos-getAll);	
		   
        //return $r;
        
        $lstMovimientos = $pedido->getAll(
          "  date_format(pedido.fecha_capturado, '%m') as mes, 
        IF(date_format(pedido.fecha_capturado, '%m')=01,'Enero',
        IF(date_format(pedido.fecha_capturado, '%m')=02,'Febrero',
        IF(date_format(pedido.fecha_capturado, '%m')=03,'Marzo',
        IF(date_format(pedido.fecha_capturado, '%m')=04,'Abril', 
        IF(date_format(pedido.fecha_capturado, '%m')=05,'Mayo',
        IF(date_format(pedido.fecha_capturado, '%m')=06,'Junio',
        IF(date_format(pedido.fecha_capturado, '%m')=07,'Julio',
        IF(date_format(pedido.fecha_capturado, '%m')=08,'Agosto', 
        IF(date_format(pedido.fecha_capturado, '%m')=09,'Septiembre',
        IF(date_format(pedido.fecha_capturado, '%m')=10,'Octubre',
        IF(date_format(pedido.fecha_capturado, '%m')=11,'Noviembre',
        IF(date_format(pedido.fecha_capturado, '%m')=12,'Diciembre',    
        date_format(pedido.fecha_capturado, '%m')))))))))))))as mesDes,
         
         SUM(if(pedidodetalle.idProducto <> 386 AND pedidodetalle.idRolloBase>1 ,pedidodetalle.costoProducto,0))as costoDerivados, 
         SUM(if(pedidodetalle.idRolloBase=1 ,pedidodetalle.costoProducto,0))as costoStock, 
         SUM(if(pedidodetalle.idProducto = 386 ,pedidodetalle.costoProducto,0))as costoMolduras,
         SUM(pedidodetalle.costoProducto)as totalcosto",

         "INNER JOIN pedidodetalle ON pedido.idPedido = pedidodetalle.IdPedido 
         INNER JOIN producto on pedidodetalle.idProducto = producto.idProducto 
         INNER JOIN rollo on pedidodetalle.idRolloBase = rollo.idRollo",
        "date_format(pedido.fecha_capturado, '%Y') = ".$anio."
        
        and pedido.estado <> 'CANCELADO'",
        "",
        "mes"
        );

		foreach ($lstMovimientos as $row)
		{
           $costoTotal = $row["costoDerivados"]+$row["costoStock"]+$row["costoMolduras"];
			$movimientos .= "
	
						app.movimientos.push({
							mes: '".$row["mes"]."',							
							mesDes: '".$row["mesDes"]."',
							costoDerivados: '".$row["costoDerivados"]."',
							costoStock: '".$row["costoStock"]."',
							costoMolduras: '". $row["costoMolduras"] ."',		
							costoTotal: '". $row["totalcosto"] ."'						
						});						
					";
	
		}
		//$r->script($movimientos);
		
		$r->script($movimientos. " app.movimientos.splice(0, app.movimientos.length); " . $movimientos);
		return $r;
	//$r->endDebug();
		//return $r;
	}
	$xajax->registerFunction("cargardetalleventas");
    function cargardetalleventas1($anio)
	{
		$r = new xajaxResponse();
		$pedido1 = new ModeloPedido();
        
        
        //Consulta1 = mes, otrosCargos, descuento, totalPedidos
		 $lstDatosPedido = $pedido1->getAll(
        "date_format(pedido.fecha_capturado, '%m')as mes,SUM(otrosCargos) AS otrosCargos ,SUM(descuento) as descuento, SUM(total)as totalPedidos",
        "",
        "date_format(pedido.fecha_capturado, '%Y') = ".$anio." and estado <> 'CANCELADO'",
        "",
        "mes");
        
        //Consulta2 = mes, ventaDeRollo, ventaStock, ventaMoldura ,ventaMquila
     
        $lstDetallePedido = $pedido1->getAll("date_format(pedido.fecha_capturado, '%m') as mes,
        IF(date_format(pedido.fecha_capturado, '%m')=01,'Enero',
     IF(date_format(pedido.fecha_capturado, '%m')=02,'Febrero',
     IF(date_format(pedido.fecha_capturado, '%m')=03,'Marzo',
     IF(date_format(pedido.fecha_capturado, '%m')=04,'Abril', 
     IF(date_format(pedido.fecha_capturado, '%m')=05,'Mayo',
     IF(date_format(pedido.fecha_capturado, '%m')=06,'Junio',
     IF(date_format(pedido.fecha_capturado, '%m')=07,'Julio',
     IF(date_format(pedido.fecha_capturado, '%m')=08,'Agosto', 
     IF(date_format(pedido.fecha_capturado, '%m')=09,'Septiembre',
     IF(date_format(pedido.fecha_capturado, '%m')=10,'Octubre',
     IF(date_format(pedido.fecha_capturado, '%m')=11,'Noviembre',
     IF(date_format(pedido.fecha_capturado, '%m')=12,'Diciembre',    
       date_format(pedido.fecha_capturado, '%m')))))))))))))as mesDes,
        sum(if(pedidodetalle.idRolloBase<>1 AND pedidodetalle.idProducto <>386 AND pedidodetalle.idProducto <>394,pedidodetalle.partida*pedidodetalle.precioUnitario*pedidodetalle.cantidad,0))as ventaDeRollo,
        sum(if(pedidodetalle.idRolloBase=1,pedidodetalle.partida*pedidodetalle.precioUnitario*pedidodetalle.cantidad,0))as ventaStock,
        sum(if(pedidodetalle.idProducto= 386,pedidodetalle.partida*pedidodetalle.precioUnitario,0))as ventaMoldura,
        sum(if(pedidodetalle.idProducto= 394,pedidodetalle.partida*pedidodetalle.precioUnitario,0))as ventaMaquila
        ",
        "INNER JOIN pedidodetalle ON pedido.idPedido = pedidodetalle.IdPedido  ",
        "date_format(pedido.fecha_capturado, '%Y') = ".$anio."
        and pedido.estado <> 'CANCELADO'",
        "",
        "mes");    
        
    
        foreach($lstDatosPedido as $row){
        $lst1[$row["mes"]]=$row;
        }
        
        foreach($lstDetallePedido as $row){
        $lst2[$row["mes"]]=$row;
        }
        
        $movimientos1 = "";
        for($i=1;$i<count($lst2)+1;$i++){
        $x=0;
        if($i<10){$x=$x.$i;}else{$x=$i;        
         }
         $lst2[$x]["otrosCargos"]=$lst1[$x]["otrosCargos"];
         $lst2[$x]["descuento"]=$lst1[$x]["descuento"];
         $lst2[$x]["totalPedidos"]=$lst1[$x]["totalPedidos"];
         $lst2[$x]["totaldetalle"]=$lst2[$x]["ventaDeRollo"]+$lst2[$x]["ventaStock"]+$lst2[$x]["ventaMoldura"]+$lst2[$x]["ventaMaquila"]+$lst2[$x]["otrosCargos"]-$lst2[$x]["descuento"];
         $lst2[$x]["dif"]=$lst2[$x]["totalPedidos"]-$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeRollo"]=$lst2[$x]["ventaDeRollo"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeStock"]=$lst2[$x]["ventaStock"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeMoldura"]=$lst2[$x]["ventaMoldura"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeMaquila"]=$lst2[$x]["ventaMaquila"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeOtrosCargos"]=$lst2[$x]["otrosCargos"]/$lst2[$x]["totaldetalle"];
         //$lst2[$x]["porcentajeTotal"]=$lst2[$x]["porcentaje1"]+$lst2[$x]["porcentaje2"]+$lst2[$x]["porcentaje3"]+$lst2[$x]["porcentaje4"]+$lst2[$x]["porcentaje5"];
         $lst2[$x]["agregarRollo"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeRollo"];
         $lst2[$x]["agregarStock"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeStock"];
         $lst2[$x]["agregarMoldura"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeMoldura"];
         $lst2[$x]["agregarMaquila"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeMaquila"];
         $lst2[$x]["agregarOtrosCargos"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeOtrosCargos"];
         $lst2[$x]["TotalAgregar"]=$lst2[$x]["agregarStock"]+$lst2[$x]["agregarRollo"]+$lst2[$x]["agregarMoldura"]+$lst2[$x]["agregarMaquila"]+$lst2[$x]["agregarOtrosCargos"];
         $lst2[$x]["ventaDeRolloFinal"]=$lst2[$x]["ventaDeRollo"]+$lst2[$x]["agregarRollo"];
         $lst2[$x]["ventaStockFinal"]=$lst2[$x]["ventaStock"]+$lst2[$x]["agregarStock"];
         $lst2[$x]["ventaMolduraFinal"] = $lst2[$x]["ventaMoldura"]+$lst2[$x]["agregarMoldura"];
         $lst2[$x]["ventaMaquilaFinal"] = $lst2[$x]["ventaMaquila"]+$lst2[$x]["agregarMaquila"];
         $lst2[$x]["ventaOtrosCargosFinal"]= $lst2[$x]["otrosCargos"]+$lst2[$x]["agregarOtrosCargos"];
         $lst2[$x]["totalFinal"] =$lst2[$x]["ventaStockFinal"]+ $lst2[$x]["ventaDeRolloFinal"]+$lst2[$x]["ventaMolduraFinal"]+$lst2[$x]["ventaMaquilaFinal"]+$lst2[$x]["ventaOtrosCargosFinal"]-$lst2[$x]["descuento"];
         //$r->mostrarAviso("Hola chava");return $r;

         $movimientos1 .= "
 
                     app.movimientos1.push({
                        mes: '".$lst2[$x]["mes"]."',
                        mesDes: '".$lst2[$x]["mesDes"]."',						
                        ventaDeRollo: '".$lst2[$x]["ventaDeRolloFinal"]."',
                        ventaStock: '".$lst2[$x]["ventaStockFinal"]."',
                        ventaMoldura: '". $lst2[$x]["ventaMolduraFinal"] ."',		
                        ventaMaquila: '". $lst2[$x]["ventaMaquilaFinal"] ."',
                        ventaOtrosCargos: '". $lst2[$x]["ventaOtrosCargosFinal"] ."',
                        descuento: '". $lst2[$x]["descuento"]."',
                        ventaTotal: '".$lst2[$x]["totalFinal"]."'      					
                     });						
                 ";
 
        }
        
		// foreach ($lstMovimientos1 as $row)
		// {             
          
		// }
		//$r->script($movimientos);
		
		$r->script($movimientos1. " app.movimientos1.splice(0, app.movimientos1.length); " . $movimientos1);
		return $r;
	//$r->endDebug();
		//return $r;
	}
	$xajax->registerFunction("cargardetalleventas1");



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


