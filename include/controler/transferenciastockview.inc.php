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

function cargarDatosTransferencia($idTransferencia)
{
    $r = new xajaxResponse();

    // $r->starDebug();

    $transferencia = new ModeloTransferenciastock();

    $query = "
                select t.idTransferenciaStock folio, so.nombre origen, t.estatus, sd.nombre destino, t.fecha_crea fecha,  
                concat(u.nombre, ' ' , u.apellidoPaterno, ' ' , u.apellidoMaterno) crea,
                concat(ua.nombre, ' ' , ua.apellidoPaterno, ' ' , ua.apellidoMaterno) acepta,
                vp.idproducto, vp.descauto, td.cantidad
                from transferenciastock t
                inner join transferenciastockdetalle td on t.idTransferenciaStock = td.idTransferenciaStock            
                inner join sucursal so on t.sucursalOrigen = so.idSucursal
                inner join sucursal sd on t.sucursalDestino = sd.idSucursal
                inner join viewproductos vp on td.idProducto = vp.idProducto
                inner join usuario u on t.id_usuario_crea = u.idUsuario
                left join usuario ua on t.id_usuario_acepta = ua.idUsuario
                where t.idTransferenciaStock = " . $idTransferencia;

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
            app.stock.push({
                idProducto: ".$row["idProducto"].",
                producto: '".$row["descauto"]."',                
                cantidad: ".$row["cantidad"]."
            });
        ";
    }

    // $r->mostrarAviso($pushes);

    $r->script(" app.stock.splice (0, app.stock.length); " . $pushes. "
    
        app.sucursalOrigen = '".$origen."';
        app.sucursalDestino = '".$destino."';
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

    $tr = new ModeloTransferenciastock();
    
    $query = "Select idSucursal, nombre from sucursal;";

    $lst = $tr->getDataSet($query);
    $sucursales = array();

    foreach($lst as $s)
    {
        $sucursales[$s["idSucursal"]] = $s["nombre"];
    }

    


    $tr->setIdTransferenciaStock($idTransferencia);

    if ($tr->getIdTransferenciaStock () <= 0)
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

    $query = "select idTransferenciaStockDetalle from transferenciastockdetalle where idTransferenciaStock = " . $idTransferencia;

    $lst = $tr->getDataSet($query);

    $tr->transaccionIniciar();
    $blnCommit = true;

    foreach($lst as $row)
    {
        $trd = new ModeloTransferenciastockdetalle();

        $trd->setIdTransferenciaStockDetalle($row["idTransferenciaStockDetalle"]);

        //Sacando de Transito
        $inv = new ModeloInvzmov();
        
        $inv->setIdProducto($trd->getIdProducto());
        $inv->setDocumentoTRANSFERENCIA();
        $inv->setReferencia("Transferencia " . $tr->getIdTransferenciaStock());
        $inv->setMovimientoSALIDA();
        $inv->setSalidaDespachoNO();
        $inv->setCantidad($trd->getCantidad());
        
        $inv->setObservaciones("Transferencia de Productos de " . $sucursales[$tr->getSucursalOrigen()]." a ".$sucursales[$tr->getSucursalDestino()].". Sacando de Tránsito");
        $inv->setDateAndUser("movimiento");
        $inv->setIdSucursal(ModeloSucursal::$TRANSITOID);
        
        $inv->Guardar();

        if ($inv->getError())
        {
            $blnCommit = false;
            // $r->saError("Ocurrió un Error al generar la Transferencia");
            // return $r;
        }

        //Enviando a Tránsito
        $inv = new ModeloInvzmov();

        $inv->setIdProducto($trd->getIdProducto());
        $inv->setDocumentoTRANSFERENCIA();
        $inv->setReferencia("Transferencia " . $tr->getIdTransferenciaStock());
        $inv->setMovimientoENTRADA();
        $inv->setSalidaDespachoNO();
        $inv->setCantidad($trd->getCantidad());
        $inv->setObservaciones("Transferencia de Productos de " . $sucursales[$tr->getSucursalOrigen()]." a ".$sucursales[$tr->getSucursalDestino()].". Ingresando a Destino");
        $inv->setDateAndUser("movimiento");
        $inv->setIdSucursal($tr->getSucursalDestino());
        
        $inv->Guardar();

        if ($inv->getError())
        {
            $blnCommit = false;
            // $r->saError("Ocurrió un Error al generar la Transferencia");
            // return $r;
        }

        // $inv = new ModeloInvzmov();

        // $inv->setIdRemisionRollo($trd->getIdRemisionRollo());
        // $inv->setAlmacenOrigenTRANSITO();
        // $inv->setAlmacenDestino($tr->getAlmacenDestino());
        // $inv->setDateAndUser("movimiento");

        // $inv->Guardar();

        // if ($inv->getError())
        // {
        //     $blnCommit = false;
        //     // $r->saError("Ocurrió un Error al generar la Transferencia");
        //     // return $r;
        // }
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

