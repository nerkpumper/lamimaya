<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.transferenciastock.inc.php";
require_once FOLDER_MODEL. "model.transferenciastockdetalle.inc.php";
require_once FOLDER_MODEL. "model.invzmov.inc.php";
require_once FOLDER_MODEL. "model.sucursal.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();

function cargarStockDeSucursal($idSucursal)
{
    $r = new xajaxResponse();

    // $r->starDebug();

    $sucursal = new ModeloSucursal();

    $query = "select v.idProducto, v.descauto producto, ps.existencia, ps.apartado, (ps.existencia - ps.apartado) disponible
                from viewproductos v
                inner join inventariosucursal ps on ps.idSucursal = ".$idSucursal." and v.idProducto = ps.idProducto
                where v.estado = 'ACTIVO'";

    $lst = $sucursal->getDataSet($query);

    $pushes = "";

    foreach($lst as $row)
    {
        $pushes .= "
            app.stockOrigen.push({
                idProducto: ".$row["idProducto"].",
                producto: '".$row["producto"]."',
                existencia: ".$row["existencia"].",
                apartado: ".$row["apartado"].",
                disponible: ".$row["disponible"].",
                porTransferir: 0                
            });
        ";
    }

    // $r->mostrarAviso($pushes);

    $r->script(" app.stockOrigen.splice (0, app.stockOrigen.length); " . $pushes);

    // $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarStockDeSucursal");

function generarTransferencia($origen, $destino, $detalle)
{
    $r = new xajaxResponse();

    // $r->starDebug();
    
    
    $tr = new ModeloTransferenciastock();
    
    $query = "Select idSucursal, nombre from sucursal;";

    $lst = $tr->getDataSet($query);
    $sucursales = array();

    foreach($lst as $s)
    {
        $sucursales[$s["idSucursal"]] = $s["nombre"];
    }


    
    $tr->setSucursalOrigen($origen);
    $tr->setSucursalDestino($destino);
    $tr->setEstatusCREADA();
    $tr->setDateAndUser("crea");
    
    $tr->Guardar();

    if ($tr->getError())
    {
        $r->saError("Ocurrió un Error al generar la Transferencia");
    }
    else
    {
        foreach($detalle as $d)
        {
            $trd = new ModeloTransferenciastockdetalle();
                       
            $trd->setIdTransferenciaStock($tr->getIdTransferenciaStock());
            $trd->setIdProducto($d["idProducto"]);
            $trd->setCantidad($d["porTransferir"]);
            
            $trd->Guardar();
            
            if ($trd->getError())
            {
                $r->saError("Ocurrió un Error al generar la Transferencia");
                return $r;
            }
            
            //Sacando de origen
            $inv = new ModeloInvzmov();
            // $r->mostrarAviso("bien : " . __LINE__); return $r;
            $inv->setIdProducto($d["idProducto"]);
            $inv->setDocumentoTRANSFERENCIA();
            $inv->setReferencia("Transferencia " . $tr->getIdTransferenciaStock());
            $inv->setMovimientoSALIDA();
            $inv->setSalidaDespachoNO();
            $inv->setCantidad($d["porTransferir"]);
            
            $inv->setObservaciones("Transferencia de Productos de " . $sucursales[$origen]." a ".$sucursales[$destino].". Enviando a Tránsito");
            $inv->setDateAndUser("movimiento");
            $inv->setIdSucursal($origen);
            
            $inv->Guardar();

            if ($inv->getError())
            {
                $r->saError("Ocurrió un Error al generar la Transferencia");
                return $r;
            }

            //Enviando a Tránsito
            $inv = new ModeloInvzmov();

            $inv->setIdProducto($d["idProducto"]);
            $inv->setDocumentoTRANSFERENCIA();
            $inv->setReferencia("Transferencia " . $tr->getIdTransferenciaStock());
            $inv->setMovimientoENTRADA();
            $inv->setSalidaDespachoNO();
            $inv->setCantidad($d["porTransferir"]);
            $inv->setObservaciones("Transferencia de Productos de " . $sucursales[$origen]." a ".$sucursales[$destino].". Ingresando a Tránsito");
            $inv->setDateAndUser("movimiento");
            $inv->setIdSucursal(ModeloSucursal::$TRANSITOID);
            
            $inv->Guardar();

            if ($inv->getError())
            {
                $r->saError("Ocurrió un Error al generar la Transferencia");
                return $r;
            }

            
        }

        $r->saSuccess("Transferencia creada con Éxito. Folio: ".$tr->getIdTransferenciaStock    ());
        $r->script("setTimeout(function(){ app.clearScreen(); }, 250);");
    }

    // $r->endDegug();

    return $r;
}
$xajax->registerFunction("generarTransferencia");



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

$s = new ModeloSucursal();

$query = "Select idSucursal, nombre from sucursal where visible = 'SI'";

$sucursales = $s->getDataSet($query);