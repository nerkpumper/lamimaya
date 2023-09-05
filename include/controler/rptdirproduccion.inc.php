<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";


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


function cargarProduccionAnual()
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
    
    $rpd = new ModeloRegistroproducciondetalle();
    
//     select viewrollos.idRollo, viewrollos.codigo, viewrollos.descauto, date_format(registroproducciondetalle.fecha_captura, '%Y%m%d') as ff, date_format(registroproducciondetalle.fecha_captura, '%d-%m-%Y') as fecha, sum(registroproducciondetalle.totalkg)  as total
//     from registroproducciondetalle
//     inner join registroproduccion on registroproduccion.idregistroproduccion = registroproducciondetalle.idregistroproduccion
//     inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
//     inner join viewrollos on viewrollos.idrollo = remisionrollo.remisionrollo_rollo_idrollo
//     group by 1,2,3, 4 ,5
//     order by 4, 1;
    
    $lst = $rpd->getAll("viewrollos.idRollo, viewrollos.codigo, viewrollos.descauto, date_format(registroproducciondetalle.fecha_captura, '%m') as mes, sum(registroproducciondetalle.totalkg)  as total ",
        "inner join registroproduccion on registroproduccion.idregistroproduccion = registroproducciondetalle.idregistroproduccion
        inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
        inner join viewrollos on viewrollos.idrollo = remisionrollo.remisionrollo_rollo_idrollo and viewrollos.idproveedor = 2",
        "",
        " 4, 1",
        " 1,2,3, 4 ");
    
//     $r->mostrarAviso($pedido->getAllQUERY("cliente.idusuariopromotor, usuario.username, concat(usuario.nombre,' ', usuario.apellidopaterno, ' ', usuario.apellidomaterno) as promotor, date_format(pedido.fecha_capturado, '%m') as mes, sum(pedido.total) as total ",
//         "inner join cliente
//             on cliente.idcliente = pedido.idcliente
//             inner join usuario
//             on usuario.idusuario = cliente.idusuariopromotor",
//         " pedido.estado <> 'CANCELADO'  ",
//         " 4, 3",
//         " 1,2,3, 4 "));
    
    $rollos = array();
    
    
    $rollo = "";
    $codigo = "";
    $pushesTabla = "";
    foreach ($lst as $row)
    {
//         1.870389412
        if ($row["mes"] == "03")
        {
            $row["total"] = round(doubleval($row["total"]*1.870389412), 2);
        }
        else if ($row["mes"] == "04")
        {
            $row["total"] = round(doubleval($row["total"]*1.536403689), 2);
        }
        else if ($row["mes"] == "05")
        {
            $row["total"] = round(doubleval($row["total"]*1.932250703), 2);
        }
        
        
        $vmes[$row["mes"]] = $row["total"];
        
        $rollo = strtoupper($row["codigo"]);
        $codigo = strtoupper($row["codigo"]);
        
        
        if (intval($row["mes"]) >=3 && intval($row["mes"]) <=8)
        {
            $pushesTabla .= "
                
                app.datosTabla.push ({
                    idRollo: ".$row["idRollo"].",
                    codigo: '".$row["codigo"]."',
                    descripcion: '".$row["descauto"]."',
                    mes: '".getNombreMes($row["mes"])."',
                    total: ".$row["total"]."
                });
            ";
            
        }
                
        
        //         if ($promo != $promoaux)
        //         {
        //             echo $promo;
        //             $promoaux = $promo;
        //         }
        
        if (!isset($rollos[$codigo]))
        {
            $rollos[$codigo] = array(
                
                "nombre" => $rollo,
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
        
        $rollos[$codigo][$row["mes"]] = $row["total"];
        
        
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
    
    for($i = 3 ; $i <= 8 ; $i++)
    {
        if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
        {
            $categorias .= ($categorias == "" ? "'" : ",'" ) . getNombreMes($i) . "'";
        }
    }
    
    $series = "";
    $dataSerie = "";
    foreach ($rollos as $p)
    {
        $dataSerie = "";
        for($i = 3 ; $i <= 8 ; $i++)
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
        
                chart.xAxis[0].setCategories([]);
                chart.xAxis[0].setCategories([".$categorias."]);
        
                ".$series."
        
                chart.redraw();

                app.datosTabla.splice(0, app.datosTabla.length);
                
                ".$pushesTabla."
        
        
    ");
    
//     $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarProduccionAnual");













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


