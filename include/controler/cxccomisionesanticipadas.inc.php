<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.usuario.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.cortecomision.inc.php";
require_once FOLDER_MODEL. "model.conceptogasto.inc.php";
require_once FOLDER_MODEL. "model.cxccuentacomision.inc.php";
require_once FOLDER_MODEL. "model.cxccortecomision.inc.php";

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
//$xajax->de decodeUTF8InputOn();

// ob_start();
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

function cargarPromotores()
{
    $r = new xajaxResponse();
    
    $promotor = new ModeloUsuario();
    
    $lst = $promotor->getAll("idUsuario, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno ) as nombrePromotor",
        "",
        "idrol IN (4) and estatus ='activo' OR estatus ='activo' and cobracomision = 'SI'");
    
    $pushes = "";
    
    foreach ($lst as $pro)
    {
        $image = "";
        
        if (file_exists ("img/" . $pro["idUsuario"] . ".jpg" )) {
            $image = "img/" . $pro["idUsuario"] . ".jpg";
        } else {
            $image = 'img/noimage.png';
        }
        // $r->mostrarAviso($image);
        
        $pushes .= "
                    app.promotores.push({id: ".$pro["idUsuario"].",
                                     nombre: '".$pro["nombrePromotor"]."',
                                        img: '".$image."'});
                                            
                ";
    }
    
    $r->script(" app.promotores.splice(0, app.promotores.length); ". $pushes);
    
    return $r;
    
}
$xajax->registerFunction("cargarPromotores");



function generarCorteComision($promotor, $pedidos, $totalAPagar)
{
    $r = new xajaxResponse();
    
    $cc = new ModeloCorteComision();
    
    $cc->setIdPromotor($promotor["promotor"]);
    $cc->setFechaInicio($promotor["fechaInicio"]);
    $cc->setFechaFin($promotor["fechaFin"]);
    $cc->setTotal($totalAPagar);
    $cc->setDateAndUser("creacion");
    
    $cc->Guardar();
    
    if ($cc->getError())
    {
        $r->saError("Error");
    }
    else
    {
        foreach($pedidos as $item)
        {
            $ped = new ModeloPedido();
            
            $ped->setIdPedido($item["idPedido"]);
            $ped->getDatos();
            
            if ($ped->getIdPedido() <= 0)
            {
                $r->mostrarError("No se pudo cargar la información del Pedido");
            }
            else
            {
                $ped->setIdCorteComision($cc->getIdCorteComision());
                $ped->setComisionpagadaSI();
                
                $ped->Guardar();
            }
            // $r->mostrarMsgs("Pedido: " . $item["idPedido"] . " Total: " . $item["total"]);
        }
        
        
        $r->saSuccess("Ok id = " . $cc->getIdCorteComision());
        
        // 			$debug = ob_get_clean();
        // 			 	$r->mostrarMsgs($debug);
        // return $r;
        $r->script(" app.mostrarBotonGeneraCorteComision = true; app.obtenerReporte();");
    }
    
    return $r;
}
$xajax->registerFunction("generarCorteComision");


function registrarDeduccion($filtro)
{
    $r = new xajaxResponse();
    
    $ccc = new ModeloCxccuentacomision();
    
    $ccc->setIdUsuario($filtro["promotor"]);
    $ccc->setTipoDEDUCIR();
    $ccc->setIdConceptoGasto($filtro["concepto"]);
    $ccc->setDateAndUser("creacion");
    $ccc->setMonto($filtro["monto"]);
    $ccc->setObservacion($filtro["observacion"]);
    
    $ccc->Guardar();
    
    if ($ccc->getError())
    {
        $r->saError("Ocurri� un error al intentar registrar la Comisi�n Anticipada");
    }
    else
    {
        $r->saSuccess("La Comisi�n Anticipada se ha registrado con �xito.");
        $r->script("app.nuevoRegistro(); setTimeout(function() {app.cargarComisionesAnticipadasSinComision();}, 200);");
    }
    
    
    return $r;
}
$xajax->registerFunction("registrarDeduccion");

function cargarComisionesAnticipadasSinComision($idPromotor)
{
    $r = new xajaxResponse();
    
    $ccc = new ModeloCxccuentacomision();
    
    $lst = $ccc->getAll("cxccuentacomision.idcxccuentacomision, cxccuentacomision.tipo, conceptogasto.nombre as concepto, cxccuentacomision.fecha_creacion, cxccuentacomision.monto, cxccuentacomision.observacion ",
                        "inner join conceptogasto on conceptogasto.idConceptoGasto = cxccuentacomision.idConceptoGasto",
                        " cxccuentacomision.tipo = 'DEDUCIR' AND cxccuentacomision.idcortecomision = 0 AND cxccuentacomision.idUsuario = " . $idPromotor,
                        " idCxcCuentaComision");
    
//     $r->mostrarAviso($ccc->getAllQUERY("cxccuentacomision.idcxccuentacomision, cxccuentacomision.tipo, conceptogasto.nombre as concepto, cxccuentacomision.fecha_creacion, cxccuentacomision.monto, cxccuentacomision.observacion ",
//         "inner join conceptogasto on conceptogasto.idConceptoGasto = cxccuentacomision.idConceptoGasto",
//         " cxccuentacomision.tipo = 'DEDUCIR' AND cxccuentacomision.idcortecomision = 0 AND cxccuentacomision.idUsuario = " . $idPromotor,
//         " idCxcCuentaComision"));

    
    $pushes = "";
    $total = 0;
    foreach ($lst as $item)
    {
        $pushes .= "

            app.comisionesanticipadas.push (
        		{
                    idcxccuentacomision: ".$item["idcxccuentacomision"].",
        			tipo: '".$item["tipo"]."',
        			concepto: '".$item["concepto"]."',
        			fecha: '".clsUtilerias::formatoFecha($item["fecha_creacion"])."',
        			monto: ".$item["monto"].",
        			observacion: '".$item["observacion"]."'
        		});

            ";
        
        $total += $item["monto"];
    }
    
//    $r->mostrarAviso($pushes);
    $r->script(" app.comisionesanticipadas.splice(0, app.comisionesanticipadas.length); app.totalComisiones = ".$total."; " . $pushes);
    
    
    return $r;
}
$xajax->registerFunction("cargarComisionesAnticipadasSinComision");

function cargarCortesComision($idPromotor)
{
    $r = new xajaxResponse();
    
    $cc = new ModeloCortecomision();
    
    $lst = $cc->getAll("idcortecomision, date_format(fecha_creacion, '%d/%m/%Y') as fecha_creacion, total, comisionadelantada, (total-comisionadelantada) as neto, pagada",
        "",
        " idPromotor = " . $idPromotor,
        " idcortecomision desc ");

        // $r->mostrarAviso($cc->getAllQUERY("idcortecomision, date_format(fecha_creacion, '%d/%m/%Y') as fecha_creacion, total, comisionadelantada, (total-comisionadelantada) as neto, pagada",
        // "",
        // " idPromotor = " . $idPromotor,
        // " idcortecomision desc "));
    
    $pushes = "";
    
    foreach ($lst as $item)
    {
        $pushes .= "
        
        
            app.cortescomision.push (
        		{
        			idcortecomision: ".$item["idcortecomision"].",
        			fecha: '".$item["fecha_creacion"]."',
        			total: ".$item["total"].",
        			anticipado: ".$item["comisionadelantada"].",
        			neto: ".$item["neto"].",
                    pagada: '".$item["pagada"]."'
                    
        		});
        			    
            ";
        
    
    }
    
    
    $r->script(" app.cortescomision.splice(0, app.cortescomision.length); " . $pushes);
    
    
    return $r;
}
$xajax->registerFunction("cargarCortesComision");

function obtenerCorteComision($idCorteComision)
{
    $r = new xajaxResponse();
    
    $cc = new ModeloCortecomision();

    if ($idCorteComision <= 0)
    {
        $r->saError("No se ha especificado un id de corte de comisi�n.");
        return $r;
    }
    
    $cc->setIdCorteComision($idCorteComision);
    
    if ($cc->getIdCorteComision() <= 0)
    {
        $r->saError("No se han podido obtener los datos del Corte Comisi�n.");
        return $r;
    }
    
    $r->script("
			
			app.comision.fechainicio = '".$cc->getFechaInicio()."';
			app.comision.fechafin = '".$cc->getFechaFin()."';
			app.comision.total = ".$cc->getTotal().";
			app.comision.comisionadelantada = ".$cc->getComisionAdelantada().";
			app.comision.apagar = ".$cc->getAPagar().";			
			app.comision.pagada = '".$cc->getPagada()."';
		    app.comision.totalpagado = ". floatval($cc->getAPagar() - $cc->getSaldo()) .";
            app.comision.saldo = ". $cc->getSaldo() .";
            app.comision.incentivo = ". $cc->getIncentivo().";
            app.comision.porcentajeVenta = ".$cc->getPorcentajeObjetivoVenta().";

            app.comision.incentivoPorcentaje = Math.round(app.comision.incentivo * 100 / app.comision.total); 


        ");
    
//     $cc->dumpObj();
    
//     $debug = ob_get_clean();
//     	$r->mostrarMsgs($debug);
    
    return $r;
}
$xajax->registerFunction("obtenerCorteComision");

function registrarPagoComision($idcortecomision, $promotor, $monto, $observacion)
{
    $r = new xajaxResponse();
    
    $ccc = new ModeloCxccortecomision();
    
    $ccc->setIdCorteComision($idcortecomision);
    $ccc->setIdPromotor($promotor);
    $ccc->setMovimientoPAGO();
    $ccc->setMonto($monto);
    $ccc->setObservacion($observacion);
    $ccc->setDateAndUser("movimiento");
    
    $ccc->Guardar();
    
    if (!$ccc->getError())
    {
        $r->saSuccess("Se ha registrado el Pago del Corte de Comisi�n.");
        $r->script("swal.close(); app.comision.monto = 0; app.comision.observacion = '';  app.manejarCorteComision(".$idcortecomision.");");
    }
    else
    {
        $r->saError($ccc->getStrError());
    }
    
    
    return $r;
    
}
$xajax->registerFunction("registrarPagoComision");

function cargarcxccortecomision($idcortecomision)
{
    $r = new xajaxResponse();
    
    $cxc = new ModeloCxccortecomision();
    
    
    $movimientos = "";
    
    $lstMovimientos = $cxc->getAll("fecha_movimiento, id_usuario_movimiento, movimiento, saldoActual, monto, IF(movimiento = 'PORPAGAR', saldoActual + monto, saldoActual - monto) as saldoNuevo , observacion, u.nombre, u.apellidoPaterno, u.apellidoMaterno ",
        "	INNER JOIN usuario AS u ON u.idusuario = id_usuario_movimiento",
        "idcortecomision = " . $idcortecomision,
        "idcxccortecomision");
    
   
    
    foreach ($lstMovimientos as $row)
    {
        $movimientos .= "
            
						app.movimientos.push({
							fecha: '".clsUtilerias::formatoFecha($row["fecha_movimiento"])."',
							movimiento: '".$row["movimiento"]."',
							saldoactual: '".$row["saldoActual"]."',
							monto: '".$row["monto"]."',
							saldonuevo: '".$row["saldoNuevo"]."',							
							observacion: '".$row["observacion"]."',
							usuario: '".$row["nombre"] . " ". $row["apellidoPaterno"] . " ". $row["apellidoMaterno"] ."'
						});
							    
							    
					";
    }
    
    
    $r->script(" app.movimientos.splice(0, app.movimientos.length); " . $movimientos);
    
    return $r;
}
$xajax->registerFunction("cargarcxccortecomision");


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


$cg = new ModeloConceptoGasto();

$lstConceptos = $cg->getAll("", "", " idConceptogasto > 2 ","");

