<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.usuario.inc.php";
require_once FOLDER_MODEL. "model.cliente.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


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

function cargarPromotor($idPromotor)
{
    $r = new xajaxResponse();
    
    $usuario = new ModeloUsuario();
    
    $lst = $usuario->getAll("idUsuario, username, upper(concat(nombre, ' ' , apellidoPaterno, ' ', apellidoMaterno)) as nombreUsuario",
        "",
        " idUsuario =  " . $idPromotor);
    
    $strPromotores = "";
    
    $idClienteFromDB = "0";
    
    
    
    
    foreach ($lst as $row)
    {
        
        $idClienteFromDB = $row["idUsuario"];
        $strPromotores .= "
		                     app.promotorUsuario = '".mb_strtoupper($row["username"])."';
		                     app.promotorNombre = '".$row["nombreUsuario"]."';
					                                      ";
    }
    
    if ($strPromotores == "")
    {
        $r->script("app.idUsuario = 0; app.seleccionandoPromotor = true;");
        $r->saError("No se ha podido obtener la informaci�n del Promotor. Verifique o seleccione algun otro.");
        return $r;
    }
    
    //ahora obtenemos totales en pedidos
    $query = "SELECT IFNULL(SUM(1), 0) as totalPedidos, IFNULL(SUM(IF(saldo = 0, 1, 0)),0)  as saldados, IFNULL(SUM(IF(saldo > 0, 1, 0)),0)  as porSaldar, IFNULL(SUM(IF(pedido.estado = 'CANCELADO', 1, 0)),0)  as cancelados
                    FROM pedido
                    inner join cliente
                    on cliente.idCliente = pedido.idCliente
                    inner join usuario
                    on usuario.idUsuario = cliente.idUsuarioPromotor
                   WHERE cliente.idUsuarioPromotor =  ".$idPromotor;
    
    
    $datosPedidos = $usuario->getDataSet($query);
    
    if (count($datosPedidos) > 0)
    {
        if ($idClienteFromDB == "0")
        {
            $r->script("app.seleccionandoPromotor = true;");
            $r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
        }
        else
        {
            $imagenPromotor = "img/noimage.png";
            
            if (file_exists ("img/" . $idPromotor . ".jpg" ))
            {
                $imagenPromotor = "img/" . $idPromotor . ".jpg";
            }
            
            //set totales en pedidos
            $totalesPedidos = "
					app.pedidosTotal = ".$datosPedidos[0]["totalPedidos"].";
					app.pedidosSaldados = ".$datosPedidos[0]["saldados"].";
					app.pedidosSinSaldar = ".$datosPedidos[0]["porSaldar"].";
					app.pedidosCancelados = ".$datosPedidos[0]["cancelados"].";
					app.promotorImg = '".$imagenPromotor."';
					";
            
            
            
            //ahora obtenemos los totales de cargos y abonos
            $query = "SELECT getTotalCargosPromotor (".$idPromotor.") as totalCargos, getTotalAbonosPromotor(".$idPromotor.") as totalAbonos";
            
            $montos = $usuario->getDataSet($query);
            if (count($montos) > 0)
            {
                $cargosAbonos = "
								app.totalCargos = ".$montos[0]["totalCargos"].";
								app.totalAbonos = ".$montos[0]["totalAbonos"].";
								app.cargarPedidosTodos();
								";
                
                
                $r->script($totalesPedidos.
                    $strPromotores . $cargosAbonos);
            }
            else
            {
                $r->script("app.seleccionandoPromotor = true;");
                $r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
            }
        }
        
        
        
    }
    else
    {
        $r->script("app.seleccionandoPromotor = true;");
        $r->saError("Ocurrió un error al intentar obtener la información del Promotor.");
    }
    
    return $r;
}
$xajax->registerFunction("cargarPromotor");


function cargarPromotores()
{
    global $objSession;
    $r = new xajaxResponse();
//     $r->starDebug();
    $usuario = new ModeloUsuario();
    
    $lst = $usuario->getAll("idUsuario, username, upper(concat(nombre, ' ' , apellidoPaterno, ' ', apellidoMaterno)) as nombreUsuario",
        "",
        "idrol in (2,4,8) AND estatus = 'activo' ",
        "");
    
    $pushes = "";
    
    foreach ($lst as $c)
    {
        $pushes .= "
            
						app.promotores.push({
							idUsuario: ".$c["idUsuario"].",
						    usuario: '".$c["username"]."',
							nombre: '".$c["nombreUsuario"]."'
							    
						});
							    
					";
    }
    
    $r->script("
					app.promotores.splice(0, app.promotores.length);
        
				" . $pushes);
    
    
    $idPromotor = 0;
    
    if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
    {
        $idPromotor = $objSession->getIdUsuario();
        //             $r->mostrarMsgs("caimos en lo del promotor id= " . $idPromotor);
    }
    
    if ($idPromotor > 0)
    {
        $r->script(" app.seleccionarPromotor(".$idPromotor.");");
    }
//     echo "lksjdkfdskl";
//     $r->endDegug();
    return $r;
}
$xajax->registerFunction("cargarPromotores");

function cargarPedidos($idPromotor, $quePedidos)
{
    $r = new xajaxResponse();
    
    $pedido = new ModeloPedido();
    
    $query = "SELECT *
					  FROM (
							SELECT pedido.idCliente, idPedido, fecha_capturado, getTotalCargosPedido(idPedido) as cargos, getTotalAbonosPedido(idPedido) as abonos, getSaldoPedido(idPedido) as saldo, pedido.estado, total, descuento,
                                   concat(cliente.nombre, ' ', cliente.apellidos) as nombreCliente, cliente.idUsuarioPromotor
							FROM pedido
                            INNER JOIN cliente
                               ON cliente.idCliente = pedido.idCliente
                            ) as datos
					  WHERE idUsuarioPromotor = " . $idPromotor;
    
    if ($quePedidos == "SALDADOS")
    {
        $query .= " AND saldo = 0";
    }
    else if ($quePedidos == "PORSALDAR")
    {
        $query .= " AND saldo > 0";
    }
    
    $lst = $pedido->getDataSet($query  .  "  ORDER BY idPedido desc");
    
    $pushes = "";
    
    foreach ($lst as $ped)
    {
        $lblEstado = "";
        switch($ped["estado"])
        {
            case "CAPTURADO";
            $lblEstado .= "<p><span class=\'badge badge-warning\'>CAPTURADO</span></p>";
            break;
            case "AUTORIZADO";
            $lblEstado .= "<p><span class=\'badge\'>AUTORIZA CxC</span></p>";
            break;
            case "PRODUCCION";
            $lblEstado .= "<p><span class=\'badge badge-info\'>PRODUCCI&Oacute;N</span></p>";
            break;
            case "TERMINADO";
            $lblEstado .= "<p><span class=\'badge badge-primary\'>TERMINADO</span></p>";
            break;
            case "ENTREGADO";
            $lblEstado .= "<p><span class=\'badge badge-success\'>ENTREGADO</span></p>";
            break;
            case "CANCELADO";
            $lblEstado .= "<p><span class=\'badge badge-danger\'>CANCELADO</span></p>";
            break;
        }
        
        $pushes .= "
            
						app.pedidos.push({
							idCliente: ".$ped["idCliente"].",
							nombreCliente: '".$ped["nombreCliente"]."',
							idPedido: ".$ped["idPedido"].",
							fecha_capturado: '".clsUtilerias::formatoFecha($ped["fecha_capturado"])."',
							cargos: '".$ped["cargos"]."',
							abonos: '".$ped["abonos"]."',
							saldo: '".$ped["saldo"]."',
							estado: '".$ped["estado"]."',
							lblEstado: '".$lblEstado."'
						});
							    
					";
    }
    
    $r->script("
					app.pedidos.splice(0, app.pedidos.length);
        
				" . $pushes);
    
    return $r;
}
$xajax->registerFunction("cargarPedidos");





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
