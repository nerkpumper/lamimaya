<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.producto.inc.php";
require_once FOLDER_MODEL. "model.viewproductos.inc.php";
require_once FOLDER_MODEL. "model.invzmov.inc.php";
require_once FOLDER_MODEL. "model.sucursal.inc.php";
require_once FOLDER_MODEL. "model.inventariosucursal.inc.php";

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
 $xajax = new xajax();
// // 	$xajax->setCharEncoding('ISO-8859-1');
// //$xajax->de decodeUTF8InputOn();

// // 	ob_start();
// // 	echo "hola mundito";
// // 	$debug = ob_get_clean();
// // 	$r->mostrarMsgs($debug);


function obtenerReporte($idProducto, $idSucursal, $reportMovimientos, $desde, $hasta)
{
    $r = new xajaxResponse();
    
    $movimientos = new ModeloInvzmov();
    
    $addWhere = "";
    
    if ($reportMovimientos == "ES")
    {
        $addWhere .= "movimiento IN ('ENTRADA','SALIDA') ";
    }
    elseif ($reportMovimientos == "E")
    {
        $addWhere .= "movimiento IN ('ENTRADA') ";
    }
    else
    {
        $addWhere .= "movimiento IN ('SALIDA') ";
    }
    
    
    if ($desde != "" && $hasta != "")
    {
        $desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
        $hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);
        
        $addWhere .= " AND date_format(fecha_movimiento, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
    }
    
    
    // 		$r->mostrarAviso($movimientos->getAllQUERY("movimiento, fecha_movimiento, id_usuario_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, cantidad, observaciones",
    // 				" INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento ", "idProducto = " . $idProducto ." AND " . $addWhere, " idInvzmov "));
    
    // 		return $r;
    
    $lst = $movimientos->getAll("invzmov.documento, invzmov.referencia, invzmov.movimiento, invzmov.fecha_movimiento, 
             invzmov.id_usuario_movimiento, concat(u.nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, existenciaProductoSucursal, invzmov.cantidad, IF(movimiento = 'ENTRADA', existenciaProductoSucursal + cantidad, existenciaProductoSucursal - cantidad) as saldo, observaciones, 
                                 sucursal.nombre as sucursal ",
        " INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento
          INNER JOIN sucursal on invzmov.idsucursal = sucursal.idsucursal ", 
        "idProducto = " . $idProducto ." and invzmov.idSucursal = " . $idSucursal." AND " . $addWhere, " idInvzmov desc");
    
    $datosTabla = "";
    
    foreach ($lst as $row)
    {
        $observa = $row["observaciones"];
        
        if ($row["documento"] != "NINGUNO")
        {
            $observa .=  " [".$row["documento"]." : ". $row["referencia"]." ]";
        }
        
        $datosTabla .= "<tr>";
        $datosTabla .= " <td>".substr(clsUtilerias::formatoFecha( $row["fecha_movimiento"]), 0, 16)."</td>";
        $datosTabla .= " <td>".$row["usrMovimiento"]."</td>";
        $datosTabla .= " <td>".$row["existenciaProductoSucursal"]."</td>";
        $datosTabla .= " <td>".($row["movimiento"] == "SALIDA" ? "-" : "").$row["cantidad"]."</td>";
        $datosTabla .= " <td>".$row["saldo"]."</td>";
        $datosTabla .= " <td>".$row["sucursal"]."</td>";
        $datosTabla .= " <td>".$observa."</td>";
        $datosTabla .= "</tr>";
    }
    
    $r->assign("tblMovimientosTodosBody", "innerHTML", ($datosTabla != "" ? $datosTabla : "No se encontraron coincidencias" ));
    
    return $r;
}
$xajax->registerFunction("obtenerReporte");

function cargarUltimosMovimientos($idProducto, $idSucursal)
{
    $r = new xajaxResponse();
//     $r->starDebug();
    
    $movimientos = new ModeloInvzmov();
    
    $lst = $movimientos->getAll("invzmov.documento, invzmov.referencia,invzmov.movimiento, invzmov.fecha_movimiento, 
                       invzmov.id_usuario_movimiento, concat(u.nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, existenciaProductoSucursal, cantidad, IF(movimiento = 'ENTRADA', existenciaProductoSucursal + cantidad, existenciaProductoSucursal - cantidad) as saldo, observaciones,
                       sucursal.nombre as sucursal ",
        " INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento 
        INNER JOIN sucursal on invzmov.idsucursal = sucursal.idsucursal ", 
        "idProducto = " . $idProducto . " and invzmov.idSucursal = " . $idSucursal, " idInvzmov DESC LIMIT 18");
    
//     echo $movimientos->getAllQUERY("invzmov.documento, invzmov.referencia,invzmov.movimiento, invzmov.fecha_movimiento, invzmov.id_usuario_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, existenciaProducto, cantidad, IF(movimiento = 'ENTRADA', existenciaProducto + cantidad, existenciaProducto - cantidad) as saldo, observaciones,
//                        sucursal.nombre as sucursal ",
//         " INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento
//         INNER JOIN sucursal on invzmov.idsucursal = sucursal.idsucursal ", "idProducto = " . $idProducto, " idInvzmov DESC LIMIT 18");
    
    $datosTabla = "";
    
    foreach ($lst as $row)
    {
        $observa = $row["observaciones"];
        
        if ($row["documento"] != "NINGUNO")
        {
            $observa .=  " [".$row["documento"]." : ". $row["referencia"]." ]";
        }
        
        $datosTabla .= "<tr>";
        $datosTabla .= " <td>".substr($row["fecha_movimiento"], 0, 16)."</td>";
        $datosTabla .= " <td>".$row["usrMovimiento"]."</td>";
        $datosTabla .= " <td>".$row["existenciaProductoSucursal"]."</td>";
        $datosTabla .= " <td>".($row["movimiento"] == "SALIDA" ? "-" : "").$row["cantidad"]."</td>";
        $datosTabla .= " <td>".$row["saldo"]."</td>";
        $datosTabla .= " <td>".$row["sucursal"]."</td>";
        $datosTabla .= " <td>".$observa."</td>";
        $datosTabla .= "</tr>";
    }
    
    $r->assign("tblMovimientosBody", "innerHTML", $datosTabla);
    $r->assign("tblMovimientosTodosBody", "innerHTML", "");
//     $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarUltimosMovimientos");

function cargarProducto($idProducto, $idSucursal)
{
    $r = new xajaxResponse();
    // $r->starDebug();
    $producto = new ModeloViewproductos();
    
    if ($idProducto <= 0)
    {
        $r->mostrarError("No se han podido cargar los datos del producto.");
        $r->redirect(URL_BASE . "producto", 2);
        return $r;
    }
    
    $producto->getView($idProducto);
    
    //verifica si el material fue cargado
    if ($producto->getIdProducto() <= 0)
    {
        $r->mostrarError("No se han podido cargar los datos del producto.");
        $r->redirect(URL_BASE . "producto", 2);
        return $r;
    }
    
    $existencia = 0;
    
    if ($idSucursal > 0)
    {
        $exisSuc = new ModeloInventariosucursal();
        
        $exisSuc->getDatosProductoSucursal($idProducto, $idSucursal);
        
        if ($exisSuc->getIdInventarioSucursal() > 0)
        {
            $existencia = $exisSuc->getExistencia();
        }
        else
        {
            $r->script(" app.mostrarDatos = false; ");
            $r->saError("Ocurri� un error al intentar obtener informaci�n de inventario.");
        }
    }
    
    
    $r->script("
        
				app.codigo = '".$producto->getCodigo()."';
				app.tipoProducto = '".$producto->getTipoProducto()."';
				app.unidad = '".$producto->getShortUnidad()."';
				app.aplicacion = '".$producto->getAplicacion()."';
				app.material = '".$producto->getMaterial()."';
                app.idrollo =  ".$producto->getIdRollo().";
				app.rollo =  '".$producto->getRolloCodigo()."';
				app.calibre = '".$producto->getCalibre()."';
				app.descripcion = '".$producto->getDescauto()."';
				app.existencia = '".$existencia."';
				app.fullDescripcion = '".$producto->getDescauto()."';
        
				  ");
    
    		// app.fullDescripcion = '".$producto->getFullDescripcionNoUnidad()."';
    // $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarProducto");

function guardarMovimiento($idProducto, $idSucursal, $movimiento, $cantidad, $observaciones)
{
    $r = new xajaxResponse();
    
    $movto = new ModeloInvzmov();
    
    if ($idProducto <= 0)
    {
        $r->mostrarError("No ha podido generar el movimiento.");
        return $r;
    }
    
    $movto->setIdProducto($idProducto);
    $movto->setMovimiento($movimiento);
    $movto->setDocumentoNINGUNO();
    $movto->setReferencia("");
    $movto->setCantidad($cantidad);
    $movto->setObservaciones($observaciones);
    $movto->setDateAndUser("movimiento");
    $movto->setIdSucursal($idSucursal);
    
    $movto->Guardar();
    
    if (!$movto->getError())
    {
        $r->script("
            
					saSuccess(\"El Movimiento se ha generado exitosamente.\");
					setTimeout(function() { app.limpiaDatos(); app.reload(); }, 500);
            
					");
    }
    else
    {
        $r->saError("Ha ocurrido un error inesperado. " . $movto->getStrError());
    }
    
    
    return $r;
}
$xajax->registerFunction("guardarMovimiento");


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
		
	$lstMovimientos = array (
			array("value" => "ENTRADA", "theoption" => "ENTRADA" ),
			array("value" => "SALIDA", "theoption" => "SALIDA" )			
	);
	

	
$suc = 	new ModeloSucursal();


$lstSucursales = $suc->getAll("idSucursal, nombre");
