<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
require_once FOLDER_MODEL. "model.invzmovnorollo.inc.php";

require_once FOLDER_MODEL. "model.transferenciarollo.inc.php";
require_once FOLDER_MODEL. "model.transferenciarollodetalle.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();

function cargarRemisionesRollosDeAlmacen($almacen)
{
    $r = new xajaxResponse();

    //  $r->starDebug();

    $remisionRollo = new ModeloRemisionrollo();

    $query = "select rr.idRemisionRollo, rr.remision, rr.norollo, vr.descauto, rr.existencia
                from remisionrollo rr
                inner join viewrollos vr on rr.remisionRollo_rollo_idRollo = vr.idRollo
                where rr.almacen = '".$almacen."'
                and rr.estado not in ('BAJA', 'TERMINADO') ";

    // $r->mostrarAviso("select rr.idRemisionRollo, rr.remision, rr.norollo, vr.descauto, rr.existencia
    //             from remisionrollo rr
    //             inner join viewrollos vr on rr.remisionRollo_rollo_idRollo = vr.idRollo
    //             where rr.almacen = '".$almacen."'
    //             and rr.estado not in ('BAJA', 'TERMINADO') ");


    $lst = $remisionRollo->getDataSet($query);

    $pushes = "";

    foreach($lst as $row)
    {   
        // echo "<br>".$row["existencia"];
        $pushes .= "
            app.rollosOrigen.push({
                idRemisionRollo: ".$row["idRemisionRollo"].",
                remision: '".trim($row["remision"])."',
                norollo: '".$row["norollo"]."',
                rollo: '".$row["descauto"]."',
                existencia: ".$row["existencia"].",
                added: false                
            });
        
        ";
    }

    // $r->mostrarAviso($pushes);

    $r->script(" app.rollosOrigen.splice (0, app.rollosOrigen.length); " . $pushes);

    //  $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarRemisionesRollosDeAlmacen");

function generarTransferencia($origen, $destino, $detalle)
{
    $r = new xajaxResponse();

    $tr = new ModeloTransferenciarollo();
    
    
    $tr->setAlmacenOrigen($origen);
    $tr->setAlmacenDestino($destino);
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
            $trd = new ModeloTransferenciarollodetalle();
                       
            $trd->setIdTransferenciaRollo($tr->getIdTransferenciaRollo());
            $trd->setIdRemisionRollo($d["idRemisionRollo"]);

            $trd->Guardar();

            if ($trd->getError())
            {
                $r->saError("Ocurrió un Error al generar la Transferencia");
                return $r;
            }

            $inv = new ModeloInvzmovnorollo();

            $inv->setIdRemisionRollo($d["idRemisionRollo"]);
            $inv->setAlmacenOrigen($origen);
            $inv->setAlmacenDestinoTRANSITO();
            $inv->setDateAndUser("movimiento");
            $inv->setObservacion("Transferencia # " . $tr->getIdTransferenciaRollo());

            $inv->Guardar();

            if ($inv->getError())
            {
                $r->saError("Ocurrió un Error al generar la Transferencia");
                return $r;
            }

            
        }

        $r->saSuccess("Transferencia creada con Éxito. Folio: ".$tr->getIdTransferenciaRollo());
        $r->script("setTimeout(function(){ app.clearScreen(); }, 250);");
    }


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

