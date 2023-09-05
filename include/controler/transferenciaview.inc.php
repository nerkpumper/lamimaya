<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.transferenciarollo.inc.php";
require_once FOLDER_MODEL. "model.transferenciarollodetalle.inc.php";
require_once FOLDER_MODEL. "model.invzmovnorollo.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();

function cargarDatosTransferencia($idTransferencia)
{
    $r = new xajaxResponse();

    // $r->starDebug();

    $transferencia = new ModeloTransferenciarollo();

    $query = "
            select t.idTransferenciaRollo folio, t.almacenOrigen origen,t.estatus, t.almacenDestino destino, t.fecha_crea fecha,  
            concat(u.nombre, ' ' , u.apellidoPaterno, ' ' , u.apellidoMaterno) crea,
            concat(ua.nombre, ' ' , ua.apellidoPaterno, ' ' , ua.apellidoMaterno) acepta,
            rr.idRemisionRollo, rr.remision, rr.norollo, vr.descauto, rr.existencia
            from transferenciarollo t
            inner join transferenciarollodetalle td on t.idTransferenciaRollo = td.idTransferenciaRollo
            inner join remisionrollo rr on td.idRemisionRollo = rr.idRemisionRollo
            inner join viewrollos vr on rr.remisionRollo_rollo_idRollo = vr.idrollo
            inner join usuario u on t.id_usuario_crea = u.idUsuario
            left join usuario ua on t.id_usuario_acepta = ua.idUsuario
            where t.idTransferenciaRollo =  " . $idTransferencia;

    $lst = $transferencia->getDataSet($query);

    $pushes = "";
    $origen = "";
    $destino = "";
    $por="";
    $aceptadaPor="";
    $estatus="";
    
    foreach($lst as $row)
    {
        $origen= $row["origen"];
        $destino = $row["destino"];
        $por = $row["crea"];
        $aceptadaPor = $row["acepta"];
        $estatus = $row["estatus"];

        $pushes .= "
            app.rollos.push({
                idRemisionRollo: ".$row["idRemisionRollo"].",
                remision: '".$row["remision"]."',
                norollo: '".$row["norollo"]."',
                rollo: '".$row["descauto"]."',
                existencia: ".$row["existencia"]."
            });
        ";
    }

    // $r->mostrarAviso($pushes);

    $r->script(" app.rollos.splice (0, app.rollos.length); " . $pushes. "
    
        app.almacenOrigen = '".$origen."';
        app.almacenDestino = '".$destino."';
        app.generadaPor = '".$por."';
        app.estatus = '".$estatus."';
        app.aceptadaPor = '".$aceptadaPor."';
     ");

    // $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarDatosTransferencia");



function aceptarTransferencia($idTransferencia)
{
    $r = new xajaxResponse();

    $tr = new ModeloTransferenciarollo();
    $tr->setIdTransferenciaRollo($idTransferencia);

    if ($tr->getIdTransferenciaRollo() <= 0)
    {
        $r->saError("No se pudo obtener información de la Transferencia");
        return $r;
    }

    if ($tr->getEstatus() != "CREADA")
    {
        $r->saError("El estatus de la transferencia no permite realizar esta operación");
        $r->script("setTimeout(function(){ app.cargarDatosTransferencia(); }, 250);");
        return $r;
    }

    $query = "select idTransferenciaRolloDetalle from transferenciarollodetalle where idTransferenciaRollo = " . $idTransferencia;

    $lst = $tr->getDataSet($query);

    $tr->transaccionIniciar();
    $blnCommit = true;

    foreach($lst as $row)
    {
        $trd = new ModeloTransferenciarollodetalle();

        $trd->setIdTransferenciaRolloDetalle($row["idTransferenciaRolloDetalle"]);

        $inv = new ModeloInvzmovnorollo();

        $inv->setIdRemisionRollo($trd->getIdRemisionRollo());
        $inv->setAlmacenOrigenTRANSITO();
        $inv->setAlmacenDestino($tr->getAlmacenDestino());
        $inv->setDateAndUser("movimiento");
        $inv->setObservacion("Transferencia # " . $idTransferencia);

        $inv->Guardar();

        if ($inv->getError())
        {
            $blnCommit = false;
            // $r->saError("Ocurrió un Error al generar la Transferencia");
            // return $r;
        }
    }

    if ($blnCommit)
    {
        $tr->setEstatusACEPTADA();
        $tr->setDateAndUser("acepta");

        $tr->Guardar();

        if ($tr->getError())
        {
            $blnCommit = false;
        }
    }


    if ($blnCommit)
    {
        $tr->transaccionCommit();
        $r->saSuccess("Transferencia aceptada");
        $r->script("setTimeout(function(){ app.cargarDatosTransferencia(); }, 250);");


    }
    else
    {
        $tr->transaccionRollback();
        $r->saError("Ocurrió un error al intentar aceptar la Transferencia");
    }


    return $r;
}
$xajax->registerFunction("aceptarTransferencia");


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

