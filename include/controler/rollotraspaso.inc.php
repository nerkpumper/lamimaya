<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
require_once FOLDER_MODEL. "model.invzmovnorollo.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();

function cargarNoRemisiones($noRollo)
{
    $r = new xajaxResponse();

    $remisionRollo = new ModeloRemisionrollo();

    $lst = $remisionRollo->getAll("idRemisionRollo, noRollo, fecha, remision, almacen, kilos, remisionrollo.existencia, idRollo, codigo, descripcion, remisionrollo.estado ",
        "INNER JOIN rollo ON rollo.idRollo = remisionRollo_rollo_idRollo",
        "noRollo = '".$noRollo."'", "almacen");

// 		idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos
    $idRolloAnterior = 0;
    $idRolloActual = 0;
    $indexRollo = -1;
    $pushes = "";

    if (count($lst)>0)
    {
        foreach ($lst as $row)
        {
            $idRolloActual = $row["idRollo"];

            if ($idRolloActual != $idRolloAnterior)
            {
                $pushes .= "app.rollos.push({idRollo: ".$row["idRollo"].", codigo: '".$row["codigo"]."', descripcion: '".$row["descripcion"]."', noRollos: []});";
                $idRolloAnterior = $idRolloActual;
                $indexRollo++;
            }

            $pushes .= "app.rollos[".$indexRollo."].noRollos.push({ idRemisionRollo: ".$row["idRemisionRollo"].", noRollo: '".$row["noRollo"]."', fecha: '".$row["fecha"]."', remision: '".$row["remision"]."', almacen: '".$row["almacen"]."', almacendestino: 'SN', kilos: '".$row["kilos"]."', disponible: '".$row["existencia"]."', estado: '". $row["estado"] ."', almacencambiado: false });";

        }

        $r->script(" app.rollos.splice(0, app.rollos.length); ".$pushes);
    }
    else
    {
        $r->script("app.msgError = '".utf8_encode("No se encontrï¿½ informaciï¿½n del Numero de Rollo solicitado.") ."';");
    }

    return $r;
}
$xajax->registerFunction("cargarNoRemisiones");

function cambiarNoRolloAAlmacen($indexRollo, $indexNoRollo, $noRollo)
{
    $r = new xajaxResponse();
    $invzmovnorollo = new ModeloInvzmovnorollo();
        
    $invzmovnorollo->setIdRemisionRollo($noRollo["idRemisionRollo"]);
    $invzmovnorollo->setAlmacenOrigen($noRollo["almacen"]);
    $invzmovnorollo->setAlmacenDestino($noRollo["almacendestino"]);
    $invzmovnorollo->setDateAndUser("movimiento");
    
    $invzmovnorollo->Guardar();
    
    if (!$invzmovnorollo->getError())
    {   
        $r->saSuccess("El No Rollo ha sido cambiado de Almacén con éxito");
        $r->script(" app.rollos[".$indexRollo."].noRollos[".$indexNoRollo."].almacencambiado = true; ");
        
    }
    else
    {
        $r->saError("Ocurrió un error al intentar cambiar de Almacen al No Rollo: " . $invzmovnorollo->getStrError());    
    }
    
    
    return $r;
}
$xajax->registerFunction("cambiarNoRolloAAlmacen");

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

