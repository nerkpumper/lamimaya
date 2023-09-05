<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.transferenciarollo.inc.php";
require_once FOLDER_MODEL. "model.sucursal.inc.php";
// require_once FOLDER_MODEL. "model.transferenciarollodetalle.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();

function obtenerTransferencias()
{
    $r = new xajaxResponse();

    // $r->starDebug();

    $t = new ModeloTransferenciarollo();

    $query = "    select t.idTransferenciaStock folio, so.nombre origen, sd.nombre destino, t.fecha_crea fecha,  concat(u.nombre, ' ' , u.apellidoPaterno, ' ' , u.apellidoMaterno) crea
                from transferenciastock t
                inner join sucursal so on t.sucursalOrigen = so.idSucursal
                inner join sucursal sd on t.sucursalDestino = sd.idSucursal
                inner join usuario u on t.id_usuario_crea = u.idUsuario
                where t.estatus = 'CREADA' ";

    $lst = $t->getDataSet($query);

    $pushes = "";

    foreach($lst as $row)
    {
        $pushes .= "
            app.transferencias.push({
                folio: ".$row["folio"].",
                origen: '".$row["origen"]."',
                destino: '".$row["destino"]."',
                fecha: '".$row["fecha"]."',
                crea: '".$row["crea"]."'              
            });
        ";
    }

    // $r->mostrarAviso($pushes);

    $r->script(" app.transferencias.splice (0, app.transferencias.length); " . $pushes);

    // $r->endDegug();
    return $r;
}
$xajax->registerFunction("obtenerTransferencias");


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