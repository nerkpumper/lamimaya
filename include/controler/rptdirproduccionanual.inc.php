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


function cargarProduccionAnual($anio)
{
    $r = new xajaxResponse();
    
    
    
//      $r->starDebug();
     
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
        inner join viewrollos on viewrollos.idrollo = remisionrollo.idrollooriginal ",
        "date_format(registroproducciondetalle.fecha_captura, '%Y') = ".$anio,
        " 4, 1",
        " 1,2,3, 4 ");
    
//     $r->mostrarAviso($rpd->getAllQUERY("viewrollos.idRollo, viewrollos.codigo, viewrollos.descauto, date_format(registroproducciondetalle.fecha_captura, '%m') as mes, sum(registroproducciondetalle.totalkg)  as total ",
//         "inner join registroproduccion on registroproduccion.idregistroproduccion = registroproducciondetalle.idregistroproduccion
//         inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
//         inner join viewrollos on viewrollos.idrollo = remisionrollo.remisionrollo_rollo_idrollo",
//         "date_format(registroproducciondetalle.fecha_captura, '%Y') = ".$anio,
//         " 4, 1",
//         " 1,2,3, 4 ")); return $r;
    
     
    
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
    
    foreach ($lst as $row)
    {
        $vmes[$row["mes"]] = $row["total"];
        
        $rollo = strtoupper($row["codigo"]);
        $codigo = strtoupper($row["codigo"]);
        $idrollo = strtoupper($row["idRollo"]);
        $descauto = strtoupper($row["descauto"]);
        

        

        //         if ($promo != $promoaux)
        //         {
        //             echo $promo;
        //             $promoaux = $promo;
        //         }
        
        if (!isset($rollos[$codigo]))
        {
            $rollos[$codigo] = array(
                
                "nombre" => $rollo,
                "idrollo" => $idrollo,
                "descauto" => $descauto,
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
    
    for($i = 1 ; $i <= 12 ; $i++)
    {
        if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
        {
            $categorias .= ($categorias == "" ? "'" : ",'" ) . getNombreMes($i) . "'";
        }
    }
    
    $series = "";
    $dataSerie = "";
    $pushes = "";
    foreach ($rollos as $p)
    {
        $dataSerie = "";

        $pushes .= " app.rollosyear.push({

                    idRollo: ".$p["idrollo"].",
					codigo: '".$p["nombre"]."',
					descauto: '".$p["descauto"]."',
                    
                    ";
                
        $totalRolloAnio = 0;
        for($i = 1 ; $i <= 12 ; $i++)
        {
            if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
            {
                $dataSerie .= ($dataSerie == "" ? "" : "," ) . $p[($i < 10 ? "0" : "") . $i] ;                
            }

            $pushes .= "m" . (($i < 10 ? "0" : "") . $i) . ": " . $p[($i < 10 ? "0" : "") . $i] . ",";
            $totalRolloAnio +=  $p[($i < 10 ? "0" : "") . $i];
        }

        $pushes.= "total: ".$totalRolloAnio."});
        ";
        
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

                chart.setTitle({text: '".("Producción de Rollos Galvamex ").$anio."'});
        
                chart.xAxis[0].setCategories([]);
                chart.xAxis[0].setCategories([".$categorias."]);

                while(chart.series.length > 0)
                    chart.series[0].remove(true);
        
                ".$series."
        
                chart.redraw();

                app.rollosyear.splice(0, app.rollosyear.length);

                ".$pushes."
        
        
    ");
    
//     $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarProduccionAnual");

function cargarVentaMensual($strmes, $anio)
{
    $r = new xajaxResponse();
    // $r->starDebug();
    $mes = 0;
    // echo "mes: " . $strmes;
    switch($strmes)
    {
        case "ENERO";
            $mes = 1;
            break;
        case "FEBRERO";
            $mes = 2;
            break;
        case "MARZO";
            $mes = 3;
            break;
        case "ABRIL";
            $mes = 4;
            break;
        case "MAYO";
            $mes = 5;
            break;
        case "JUNIO";
            $mes = 6;
            break;
        case "JULIO";
            $mes = 7;
            break;
        case "AGOSTO";
            $mes = 8;
            break;
        case "SEPTIEMBRE";
            $mes = 9;
            break;
        case "OCTUBRE";
            $mes = 10;
            break;
        case "NOVIEMBRE";
            $mes = 11;
            break;
        case "DICIEMBRE";
            $mes = 12;
            break;
        
    }
    
    // echo "<br>".$mes;
    
//      $r->starDebug();
     
    $vmes = array();
    
    $vmes["01"] = 0;
    // $vmes["02"] = 0;
    // $vmes["03"] = 0;
    // $vmes["04"] = 0;
    // $vmes["05"] = 0;
    // $vmes["06"] = 0;
    // $vmes["07"] = 0;
    // $vmes["08"] = 0;
    // $vmes["09"] = 0;
    // $vmes["10"] = 0;
    // $vmes["11"] = 0;
    // $vmes["12"] = 0;
    
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
        inner join viewrollos on viewrollos.idrollo = remisionrollo.idrollooriginal ",
        "date_format(registroproducciondetalle.fecha_captura, '%Y') = ".$anio . " and date_format(registroproducciondetalle.fecha_captura, '%m') = " . $mes,
        " 4, 1",
        " 1,2,3, 4 ");
    
    // $r->mostrarAviso($rpd->getAllQUERY("viewrollos.idRollo, viewrollos.codigo, viewrollos.descauto, date_format(registroproducciondetalle.fecha_captura, '%m') as mes, sum(registroproducciondetalle.totalkg)  as total ",
    //     "inner join registroproduccion on registroproduccion.idregistroproduccion = registroproducciondetalle.idregistroproduccion
    //     inner join remisionrollo on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo
    //     inner join viewrollos on viewrollos.idrollo = remisionrollo.idrollooriginal ",
    //     "date_format(registroproducciondetalle.fecha_captura, '%Y') = ".$anio . " and date_format(registroproducciondetalle.fecha_captura, '%m') = " . $mes,
    //     " 4, 1",
    //     " 1,2,3, 4 "));
     
    
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
    $pushes = "";
    foreach ($lst as $row)
    {
        // $vmes[$row["mes"]] = $row["total"];
        $vmes["01"] = $row["total"];
        
        $rollo = strtoupper($row["codigo"]);
        $codigo = strtoupper($row["codigo"]);
        

        $pushes .= "app.rollos.push({
                    idRollo: ".$row["idRollo"].",
                    codigo: '".$row["codigo"]."',
                    descauto: '".$row["descauto"]."',
                    total: ". $row["total"]." 
                }); ";


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
                // "02"     => 0,
                // "03"     => 0,
                // "04"     => 0,
                // "05"     => 0,
                // "06"     => 0,
                // "07"     => 0,
                // "08"     => 0,
                // "09"     => 0,
                // "10"     => 0,
                // "11"     => 0,
                // "12"     => 0,
                
            );
        }
        
        // $rollos[$codigo][$row["mes"]] = $row["total"];
        $rollos[$codigo]["01"] = $row["total"];
        
        
        //         echo $row["promotor"] . " " . $row["mes"] ;
        //         echo $row["mes"] . " " . $row["total"];
        //         $vmes[$row["mes"]] = $row["total"];
        // $r->mostrarAviso($row["promotor"] . " " . $row["mes"] );
    }
    
    
    //     print_r($promotores);
    //     var_dump($promotores);
    
    //     echo "<br><br>";
    
    //     var_dump($promotores["JAVIERSILVA"]);
    
    $categorias = "'".$strmes."'";
    
    // for($i = 1 ; $i <= 12 ; $i++)
    // {
    //     if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
    //     {
    //         $categorias .= ($categorias == "" ? "'" : ",'" ) . getNombreMes($i) . "'";
    //     }
    // }
    
    $series = "";
    $dataSerie = "";
    foreach ($rollos as $p)
    {
        $dataSerie = "";
        // for($i = 1 ; $i <= 12 ; $i++)
        // {
        //     if ($vmes[($i < 10 ? "0" : "") . $i] > 0)
        //     {
                // $dataSerie .= ($dataSerie == "" ? "" : "," ) . $p[($i < 10 ? "0" : "") . $i] ;
                $dataSerie .= ($dataSerie == "" ? "" : "," ) . $p["01"] ;
        //     }
        // }
        
        $series .= "
            
                chartm.addSeries({
                    name: '".$p["nombre"]."',
                    data: [".$dataSerie."]
                }, false);
                        
                        
            ";
        
    }
    
    // echo "<br>ok " . __LINE__ . ": " . $series;    
    $r->script("
        
                $('#modalWait').modal('hide');

                var index = $('#chartMes').data('highchartsChart');         
                chartm = Highcharts.charts[index];

                chartm.setTitle({text: '".("Producción de Rollos Galvamex "). $strmes. " ".$anio."'});
        
                chartm.xAxis[0].setCategories([]);
                chartm.xAxis[0].setCategories([".$categorias."]);

                while(chartm.series.length > 0)
                    chartm.series[0].remove(true);
        
                ".$series."
        
                chartm.redraw();
        
                app.rollos.splice(0, app.rollos.length);
                    
                ". $pushes."

    ");
    
    // $r->endDegug();
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


