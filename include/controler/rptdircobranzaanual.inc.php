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


function cargarCobranzaAnual($anio)
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
    
    $lst = $pedido->getAll("cliente.idusuariopromotor, usuario.username, 
        concat(usuario.nombre,' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno) as promotor, 
        date_format(pedido.fecha_capturado, '%m') as mes, sum(pedido.total - pedido.saldo) as total ",
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
        
        //         if ($promo != $promoaux)
        //         {
        //             echo $promo;
        //             $promoaux = $promo;
        //         }
        
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
        
                var index = $('#chartAnio').data('highchartsChart');
                chart = Highcharts.charts[index];
				chart.setTitle({text: '".utf8_encode("cobranza Galvamex ").$anio."'});    
                chart.xAxis[0].setCategories([]);
                chart.xAxis[0].setCategories([".$categorias."]);
        
                ".$series."
				while(chart.series.length > 0)
                chart.series[0].remove(true);
        
                chart.redraw();
        
        
    ");
    
    //         $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarCobranzaAnual");

function cargarVentasVSCobranzaAnual()
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
    
    $lst = $pedido->getAll("cliente.idusuariopromotor, usuario.username,
        concat(usuario.nombre,' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno) as promotor,
        date_format(pedido.fecha_capturado, '%m') as mes, sum(pedido.total) as ventas, sum(pedido.total - pedido.saldo) as cobrado ",
        "inner join cliente
            on cliente.idcliente = pedido.idcliente
            inner join usuario
            on usuario.idusuario = cliente.idusuariopromotor",
        " pedido.estado <> 'CANCELADO'  ",
        " 4, 3",
        " 1,2,3, 4 ");
    
    
    
    $promotores = array();
    
    
    $promo = "";
    $username = "";
    foreach ($lst as $row)
    {
        $vmes[$row["mes"]] = $row["ventas"];
        
        $promo = strtoupper($row["promotor"]);
        $username = strtoupper($row["username"]);
        
        //         if ($promo != $promoaux)
        //         {
        //             echo $promo;
        //             $promoaux = $promo;
        //         }
        
        if (!isset($promotores[$username]))
        {
            $promotores[$username] = array(
                
                "nombre" => $promo,
                "v01"     => 0,
                "v02"     => 0,
                "v03"     => 0,
                "v04"     => 0,
                "v05"     => 0,
                "v06"     => 0,
                "v07"     => 0,
                "v08"     => 0,
                "v09"     => 0,
                "v10"     => 0,
                "v11"     => 0,
                "v12"     => 0,
                "c01"     => 0,
                "c02"     => 0,
                "c03"     => 0,
                "c04"     => 0,
                "c05"     => 0,
                "c06"     => 0,
                "c07"     => 0,
                "c08"     => 0,
                "c09"     => 0,
                "c10"     => 0,
                "c11"     => 0,
                "c12"     => 0,
                
            );
        }
        
        $promotores[$username]["v". $row["mes"]] = $row["ventas"];
        $promotores[$username]["c". $row["mes"]] = $row["cobrado"];
        
        
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
    
    $colors = ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'];
    
    $series = "";
    $dataSerie = "";
    $idColor = -1;
    foreach ($promotores as $p)
    {
        
        $idColor++;
        
        if($idColor == 9)
        {
            $idColor = 0;
        }
        
        $dataSerie = "";
        $dataSerieC = "";
        for($i = 1 ; $i <= 12 ; $i++)
        {
            if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
            {
                $dataSerie .= ($dataSerie == "" ? "" : "," ) . $p["v".($i < 10 ? "0" : "") . $i] ;
                $dataSerieC .= ($dataSerieC == "" ? "" : "," ) . $p["c".($i < 10 ? "0" : "") . $i] ;
            }
        }
        
        $series .= "
            
                chart.addSeries({
                    name: '".$p["nombre"]."',
                    data: [".$dataSerie."],
                    stack: 'ventas',
                    color: '".$colors[$idColor]."'
                }, false);

                chart.addSeries({
                    name: '".$p["nombre"]."',
                    data: [".$dataSerieC."],
                    stack: 'cobranza',
                    color: '".$colors[$idColor]."',
                    showInLegend: false,     
                }, false);
                        
                        
            ";
        
    }
    
    
    $r->script("
        
                var index = $('#chartvevsco').data('highchartsChart');
                chart = Highcharts.charts[index];
        
                chart.xAxis[0].setCategories([]);
                chart.xAxis[0].setCategories([".$categorias."]);
        
                ".$series."
        
                chart.redraw();
        
        
    ");
    
    //         $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarVentasVSCobranzaAnual");










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


