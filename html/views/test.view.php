<?php


$ids=array(2);
// NotificationManager::WA_PedidoNuevo($ids, 24889);

NotificationManager::WA_PedidoNuevo($ids, 9697);

// NotificationManager::WA_EstatusPedido($ids, 9629, "ENTREGADO");

return;

require FOLDER_MODEL . "model.cortecaja.inc.php";

$cc = new ModeloCortecaja();

$cc->NotificarPasarPorEfectivo(3);

return;

// date_default_timezone_set("America/Mexico_City");
// date_default_timezone_set("America/Tijuana");

require FOLDER_MODEL . "model.cortecaja.inc.php";
require FOLDER_MODEL . "model.notificacionescortes.inc.php";

$idSucursal = 1;
$sql = "SELECT * FROM cortecaja WHERE idSucursal = " . $idSucursal." AND estado = 'ABIERTO'";

				$corteCaja = new ModeloCortecaja();
				
				$rs = $corteCaja->getDataSet($sql);

				if (!$rs)
				{
					echo "No data";
					return;
				}

				echo "<pre>";
				print_r($rs);
				echo "</pre>";

// $fecha_actual = date("d-m-Y h:i:s");
$hora = intval(date("H"));
echo "<br><br>";
echo $hora;
$turno = "";
if ($hora >= 16)
{
	$turno = "V";
}
else
{
	// if ($hora >= 10)
	{
		$turno = "M";
	}
}

if ($turno == "")
{
	return;
}

echo "<br><br>Turno: ".$turno;


$sql = "SELECT id 
		FROM notificacionescortes 
		WHERE DATE_FORMAT(fecha, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')
		AND idSucursal = " .$idSucursal . 
		" AND turno = '".$turno."'";


$nc = new ModeloNotificacionescortes();

$regs = $nc->getDataSet($sql);

echo "<br><br>Count: " . count($regs);	

if (count($regs) > 0)
{
	echo "hay datos, regresar";
	return;
}

echo "Sin datos, mandar notificacion y guardar";

echo "<pre>";
print_r($regs);
echo "</pre>";

return;


$nc->setIdSucursal($idSucursal);
$nc->setFecha($nc->NOW());
$nc->setTurno($turno);

$nc->Guardar();

if (!$nc->getError())
{
	echo "<br><br>Todo bien";
}
else
{
	echo $nc->getStrError();
}





return;
require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

// NotificationManager::WA_PedidoAsignado(1,1,""); return;

$pedidoDetalle = new ModeloPedidodetalle();

$pedidoDetalle->setIdPedidoDetalle(66622719);

// $pedidoDetalle->dumpObj();
$pedidoDetalle->setDespachadoSI();
$pedidoDetalle->Guardar();
	
// return;
require_once FOLDER_MODEL. "model.pedido.inc.php";

// NotificationManager::WA_PedidoAsignado(1,1,""); return;

$pedido = new ModeloPedido();

$pedido->setIdPedido(9697);

// $pedido->dumpObj();
$pedido->setEstadoPRODUCCION();
$pedido->Guardar();

return;
// $pedido->NotificaEntregaPedido();

if ($pedido->getIdPedido() <= 0)
		{
			echo "No se ha podido obtener la informacion del Pedido.";
			// return $r;
		}
	
		if ($pedido->getEstado() != "TERMINADO")
		{
			echo "El Pedido no puede cambiar a ENTREGADO, dado su Estado actual. Verifique.";
			// return $r;
		}
	
		$pedido->setEstadoENTREGADO();
		$pedido->setDateAndUser("entregado");
// $pedido->dumpObj();
	
		$pedido->Guardar();
	
		if (!$pedido->getError())
		{
		    $pedido->NotificaEntregaPedido();
		}

return;

// $ids=array(2,3,4,6);
$ids=array(2);
// $ids=array(1,2,3,10,18);

// NotificationManager::WA_test(234, $ids);
// NotificationManager::WA_PedidoNuevo($ids, 9629);
// NotificationManager::WA_EstatusPedido(2, 9629, "CAPTURADO");
// NotificationManager::WA_EstatusPedido($ids, 9629, "AUTORIZADO");
// NotificationManager::WA_EstatusPedido($ids, 9629, "PRODUCCION");
// NotificationManager::WA_EstatusPedido(2, 9629, "TERMINADO");
NotificationManager::WA_EstatusPedido($ids, 9629, "ENTREGADO");

// NotificationManager::WA_PedidoNuevo(2, 9695);
// NotificationManager::WA_PedidoNuevo(2, 9696);
// NotificationManager::WA_PedidoNuevo(2, 9697);
// NotificationManager::WA_PedidoNuevo(2, 9698);
// NotificationManager::WA_PedidoNuevo(2, 9699);
// NotificationManager::WA_PedidoNuevo(2, 9700);
// NotificationManager::WA_PedidoNuevo(2, 9701);
// NotificationManager::WA_PedidoNuevo(2, 9702);
// NotificationManager::WA_PedidoNuevo(2, 9703);
// NotificationManager::WA_PedidoNuevo(2, 9704);
// NotificationManager::WA_PedidoNuevo(2, 9705);
// NotificationManager::WA_PedidoNuevo(2, 9706);
// NotificationManager::WA_PedidoNuevo(2, 9707);
// NotificationManager::WA_PedidoNuevo(2, 9708);
// NotificationManager::WA_PedidoNuevo(2, 9709);
// NotificationManager::WA_PedidoNuevo(2, 9710);

return;
// require_once FOLDER_MODEL. "model.pedido.inc.php";

// $p = new ModeloPedido();

// $p->setIdPedido(9709);


// echo "<pre>";
// print_r($p);
// echo "</pre>";


// return;
require_once FOLDER_INCLUDE . "cron/procesapedidos.cron.php";


return;

$pedido = new ModeloPedido();

$pedido->__isDebugging = true;
$pedido->procesaAutorizacionAutomatica(9639);


return;
require_once FOLDER_MODEL. "model.cortecaja.inc.php";

$cc = new ModeloCortecaja();

$cc->NotificarPasarPorEfectivo(1);

return;

require_once FOLDER_MODEL. "model.pedido.inc.php";

$pedido = new ModeloPedido();

$si = $pedido->esPrimerPedido(1794, 7979);

if ($si)
{
	echo "PRIMER PEDIDO";
}
else
{
	echo "NO ES PRIMER PEDIDO";
}

return;
require_once FOLDER_MODEL. "model.cliente.inc.php";

$cliente = new ModeloCliente ();

$cliente->updateMontoCreditoUsingDatosFacturacion(1);


return;

require_once FOLDER_MODEL. "model.pedido.inc.php";
$pedidoProcesando = new ModeloPedido();
$idPedido = 9015;
$res = $pedidoProcesando->verificarSiPedidoPuedeSurtirse($idPedido);

echo "<pre>";
print_r($res);
echo "</pre>";

echo "<br>";

if (count($res["NoSurtir"]) > 0)
{
	echo "No se surtirá completo";
}
else
{
	echo "Se surtirá completo";
}


return;


require_once FOLDER_MODEL. "model.pedido.inc.php";
$pedidoProcesando = new ModeloPedido();

$msg = "";
$pedidoProcesando->generarValesSalidaAutomatico(9653, $msg);

echo $msg;

return;

require_once FOLDER_MODEL. "model.ruta.inc.php";

$idRuta = 2;
$ruta = new ModeloRuta();
				
		if ($idRuta <= 0)
		{
			$r->saError("No se han podido cargar los datos de la ruta. " . $idRuta);
			$r->redirect(URL_BASE . "ruta", 2);
			return $r;
		}			
		
		echo  $idRuta . "<br>";
		$ruta->setIdRuta($idRuta);




		$ruta->dumpObj();
		return;

$idCotizacion = 1967;

$cotizacionPuedeSurtirse = new ModeloCotizacion();

							// echo $pedido->getlogCliente($param1);
							
							$cotizacionPuedeSurtirse->__isDebugging =true;
							// $r->starDebug();
							$cotiSurtir = $cotizacionPuedeSurtirse->verificarSiCotizacionPuedeSurtirseParaPasarAPedido($idCotizacion);					
// $r->mostrarAviso("todo biiien " . __LINE__ ); return $r;    		
							// $r->endDegug(); return $r;
							$pushPuedeSurtirse = "";


return;

require_once FOLDER_MODEL. "model.viewproductos.inc.php";



$tr = new ModeloViewproductos();

$lst = $tr->getDataSet("call spGetProductosStock()");

echo "<br>[";
foreach($lst[0] as $key=>$value)
{
	echo "{col: '".$key."'},";
}

echo "]<br><br>";
foreach($lst as $row)
{

	echo "<br>[";
	foreach($row as $key=>$value)
	{
		echo "{ dato: '".$value."'	},";
	}
	echo "]";
	// echo "<pre>";
	// print_r($row);
	// echo "</pre>";

	

}



return;

 
$query = "Select idSucursal, nombre from sucursal;";

$lst = $tr->getDataSet($query);
$sucursales = array();

foreach($lst as $s)
{
	$sucursales[$s["idSucursal"]] = $s["nombre"];
}

echo "<pre>";
print_r($sucursales);
echo "</pre>";




echo $sucursales[3];


return;

$vp->getView(77);

$vp->dumpObj();

return;

require_once FOLDER_MODEL. "model.pedido.inc.php";
$idPedido = 6;
$pedido = new ModeloPedido();

if ($idPedido <= 0)
{
	echo "No se ha especificado un numero de Pedido.";
	return $r;
}

$pedido->setIdPedido($idPedido);

if ($pedido->getIdPedido() <= 0)
{
	echo "Ocurri� un error al obtener la informaci�n del Pedido.";
	return $r;
}

$pedido->setEstadoAUTORIZADO();
$pedido->setDateAndUser("autorizado");
$pedido->setObservacionAutoriza("AUTORIZADO AUTOM�TICO POR CR�DITO DE CLIENTE");

$pedido->Guardar();

if ($pedido->getError())
{
		
	echo $pedido->getStrError();
}
else
{
	echo "El Pedido ha sido Autorizado con exito.";
	// 			$r->script("setTimeout(function(){ app.prepararPedido(); }, 500);");
}

return;

$idPedido = 6;

$pedido = new ModeloPedido();

$datos = $pedido->getAll("pedido.idPedido, pedido.total, pedido.estado, c.credito as cteCredito, c.usado as cteUsado, u.credito as promoCredito, u.usado as promoUsado, isPromotorBloqueadoXCredito(c.idUsuarioPromotor) promoBloqueado",
		" inner join cliente as c
          on c.idcliente = pedido.idcliente
		  inner join usuario as u
		  on u.idUsuario = c.idUsuarioPromotor ",
		" pedido.idpedido = " . $idPedido)[0];

var_dump($datos);

return;

require_once FOLDER_MODEL. "model.rollo.inc.php";

$rollo = new ModeloRollo();
$rollo->setIdRollo(7);

$rollo->dumpObj();



return;


$numero = 160.51;

$whole = floor($numero);  
$frac  = round(fmod($numero, 1),2);  

echo "<br><br>Numero: " . $numero;

echo "<br><br>Entero: " . $whole;

echo "<br><br>Fraccip�n: " . $frac;

if (doubleval($frac) == 0)
{
	echo "<br><br><br>No sumar";
	echo "<br><br>Numero: " . $whole;
}
else if (doubleval($frac) > 0 && doubleval($frac) <= 0.5 )
{
	echo "<br><br><br>Sumar solo 0.5";
	echo "<br><br>Numero: " . ($whole + 0.5 );
}
else  if (doubleval($frac) > 0.5 )
{
	echo "<br><br><br>Sumar solo 1";
	echo "<br><br>Numero: " . ($whole + 1 );
}



// require_once FOLDER_MODEL. "model.pedido.inc.php";
// require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
// require_once FOLDER_MODEL. "model.viewproductos.inc.php";
// require_once FOLDER_MODEL. "model.invzmov.inc.php";
// require_once FOLDER_MODEL. "model.rollo.inc.php";
// require_once FOLDER_MODEL. "model.producto.inc.php";
// require_once FOLDER_MODEL. "model.cxc.inc.php";



// $idPedido = 82;

// $pedido = new ModeloPedido();

// $pedido->setIdPedido($idPedido);

// // $pedido->dumpObj();
// // $pedido->varDump($pedido);

// $pedido->transaccionIniciar();
// $blnDoCommit = true;

// if ($pedido->getEstado() == "CAPTURADO")
// {
// 	echo "<br>Cancelar simple, ya que es capturado";
//  	$pedido->setEstadoCANCELADO();
//  	$pedido->setDateAndUser("cancelado");
//  	$pedido->setObservacionCancela("MOTIVO CANCELA XD");
 	
 	
 	
//  	$pedido->Guardar();
 	
//  	if ($pedido->getError())
//  	{
//  		$blnDoCommit = false;
//  	}
// }
// else if ($pedido->getEstado() == "AUTORIZADO")
// {
// // 	echo "vamos......";
	
// 	$pedido->setEstadoCANCELADO();
// // 	echo "cance";
// 	$pedido->setDateAndUser("cancelado");
// // 	echo "dateuse";
// 	$pedido->setObservacionCancela("MOTIVO CANCELA XD");
// // 	echo "obs";

	
	
// 	$pedido->Guardar();
// // 	echo "guard";
// 	if ($pedido->getError())
// 	{
// 		echo "<br>" . $pedido->getStrError();
// 		$blnDoCommit = false;
// 	}
// 	else
// 	{
// 		echo "<br>Cancelar pedido de estao autorizado";
// 		$pd = new ModeloPedidodetalle();
		
// 		$lst = $pd->getAll("idPedidoDetalle", "", " idPedido = " . $idPedido);
		
// 		foreach ($lst as $objpd)
// 		{
// 			$vp = new ModeloViewproductos();
// 			$pedidoDetalle = new ModeloPedidodetalle();
		
// 			$pedidoDetalle->setIdPedidoDetalle($objpd["idPedidoDetalle"]);
		
// 			$vp->getView($pedidoDetalle->getIdProducto());
		
// 			echo "<br>";
// 			echo "<br>";
// 			$vp->dumpAsTable();
// 			echo "<br>";
		
// 			if($pedidoDetalle->getListo_para_producir() == "SI")
// 			{
// 				if($pedidoDetalle->getDespachado() == "SI")
// 				{
// 					echo "<br>despachado, ingresar inventario para que se eleve, solo productos stock";
// 				}
// 				else
// 				{
// 					echo "<br>no despachado, solo decrementar apartados de los rollos y productos stock";
		
// 					if ($vp->getIdRollo() == "1")
// 					{
// 						if ($vp->getIdUnidad() == 4)
// 						{
// 							echo "<br><br>Des apartar de producto";
// 							$producto = new ModeloProducto();
								
// 							$producto->setIdProducto($vp->getIdProducto());
		
// 							if ($producto->getIdProducto() <= 0)
// 							{
// 								echo "ocurrio un error";
// 								$blnDoCommit = false;
// 								break;
// 							}
		
// 							$producto->desApartar($pedidoDetalle->getTotalExplotar());
// 							$producto->desApartarReal($pedidoDetalle->getTotalExplotar());
// 							$pedidoDetalle->setListo_para_producirNO();
							
// 							$pedidoDetalle->Guardar();
							
// 							if ($pedidoDetalle->getError())
// 							{
// 								echo "ocurrio un error";
// 								$blnDoCommit = false;
// 								break;
// 							}
							
// 							$producto->Guardar();
							
// 							if ($producto->getError())
// 							{
// 								echo "ocurrio un error";
// 								$blnDoCommit = false;
// 								break;
// 							}
							
// 						}
						
						
							
							
							
// 					}
// 					else
// 					{
// 						echo "<br><br>Des apartar de Rollo: " . $vp->getIdRollo();
// 						$rollo = new ModeloRollo();
							
// 						$rollo->setIdRollo($vp->getIdRollo());
							
// 						if ($rollo->getIdRollo() <= 0)
// 						{
// 							echo "ocurrio un error";
// 							$blnDoCommit = false;
// 							break;
// 						}
							
// 						$rollo->desApartar($pedidoDetalle->getTotalExplotar());
// 						$pedidoDetalle->setListo_para_producirNO();
						
// 						$rollo->Guardar();
						
// 						if ($rollo->getError())
// 						{
// 							echo "ocurrio un error";
// 							$blnDoCommit = false;
// 							break;
// 						}
						
// 						$pedidoDetalle->Guardar();
						
// 						if ($pedidoDetalle->getError())
// 						{
// 							echo "ocurrio un error";
// 							$blnDoCommit = false;
// 							break;
// 						}
// 					}
		
// 				}
					
// 			}
// 			else
// 			{
// 				echo "<br>No esta listo para producirse, no descontar ni nada";
// 			}
		
// 			// 		$vp->dumpAsTable();
// 		}
// 	}
	
	
	
	
// }
// else if ($pedido->getEstado() == "CANCELADO")
// {
// 	echo "<br>Pedido no puede Cancelarse";
// }
// else
// {
// 	echo "<br>Pedido Cancelado";
// }

// $blnDoCommit = false;
// if ($blnDoCommit)
// {
// 	$pedido->BorrarCXC();
	
// 	if ($pedido->getError())
// 	{
// 		echo "<br>" . $pedido->getStrError();
// 		$blnDoCommit = false;
// 	}
	
	
// 	$pedido->transaccionCommit();
// 	echo "<br><br>Commit";
// }
// else
// {
// 	$cxc = new ModeloCxc();
	
// 	$lstCXC = $cxc->getAll("idCxc", "", "idPedido = " . $idPedido );
	
// 	foreach ($lstCXC as $itemcxc)
// 	{
// 		$delCXC = new ModeloCxc();
		
// 		$delCXC->setIdCxc($itemcxc["idCxc"]);
		
// 		// 	$cxc->dumpObj();
		
// 		$delCXC->Borrar();
		
// 		if ($delCXC->getError())
// 		{
// 			echo "Error";
// 			$blnDoCommit = false;
// 		}	
// 	}
	
	
	
	
// 	$pedido->transaccionRollback();
// 	echo "<br><br>RollBack";
// }


// return;

// if (isset($_SERVER['HTTP_HOST']))
// 	define("isCONSOLE",false);
// 	else
// 		define("isCONSOLE",true);
	
// function myLog($msg = "")
// {
// 	echo (isCONSOLE ? "\n" : "<br>").$msg;
// }		

// define('FOLDER_INCLUDE', '../');
// //define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');
// // define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');


// define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");
// define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");
// define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");
// define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");

// require_once LIB_CONEXION;
// require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';

// require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
// require_once FOLDER_MODEL. "model.invzmov.inc.php";


// $pd = new ModeloPedidodetalle();

// $lstDetalle = $pd->getAll("pedido.id_usuario_capturado, idPedidoDetalle, renglon, pedido.idPedido, pedidodetalle.idProducto, partida, cantidad, cantidadReal, producto.producto_unidad_idUnidad as idUnidad, producto.descripcion as producto ",
// 		                  "inner join pedido on pedidodetalle.idpedido = pedido.idpedido
//                            inner join producto on producto.idProducto = pedidodetalle.idProducto ",
// 		                  " pedido.estado = 'PRODUCCION' 
//                             AND producto_unidad_idUnidad = 4 
//                             AND pedidodetalle.listo_para_producir = 'SI'
//                             AND pedidodetalle.despachado = 'NO'",
// 		                  " pedido.idpedido");

// $idPedido = "0";
// $idPedidoAnterior = "0";

// myLog();
// myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");

// foreach ($lstDetalle as $pedidodetalle)
// {
// // 	echo "<br><br>";
// // 	print_r($pedidodetalle);

// 	$blnDoCommit = true;
// 	$errores = "";
// 	$pd->transaccionIniciar();
	
	
// 	$idPedido = $pedidodetalle["idPedido"];
	
// 	if ($idPedidoAnterior != $idPedido)
// 	{
// 		myLog();
// 		myLog("---------------------------------------------------------------------------------------------------------------------------------------------");
// 		myLog("INICIO Pedido: <h1>" . $idPedido . "</h1>");
// 		myLog();
				
// 		$idPedidoAnterior = $idPedido;
// 	}
	
// 	myLog();
// 	myLog("R E N G L O N : " . $pedidodetalle["renglon"] ."        -idPedidoDetalle: ".$pedidodetalle["idPedidoDetalle"]."    -idProducto: ".$pedidodetalle["idProducto"]."    -partida: ".$pedidodetalle["partida"]."    -cantidad: ".$pedidodetalle["cantidad"]."    -cantidadReal: ".$pedidodetalle["cantidadReal"]);
// 	myLog();
// 	myLog("PRODUCTO: " . $pedidodetalle["producto"]);
	
// 	$inv = new ModeloInvzmov();
	
// 	$idPedidoDetalle = $pedidodetalle["idPedidoDetalle"];
		
// 	$inv->setIdProducto($pedidodetalle["idProducto"]);
// 	$inv->setDocumentoPEDIDO();
// 	$inv->setReferencia($idPedido);
// 	$inv->setMovimientoSALIDA();
// 	$inv->setSalidaDespachoSI();
// 	$inv->setCantidad($pedidodetalle["partida"]);
// 	$inv->setObservaciones("Despacho autom�tico de pedido");
// 	$inv->setIdPedidoDetalle($idPedidoDetalle);
	
// 	$inv->setId_usuario_movimiento($pedidodetalle["id_usuario_capturado"]);
// 	$inv->setFecha_movimiento(date("Y-m-d H:i:s"));
	
		
// 	$inv->Guardar();
		
// 	if (!$inv->getError())
// 	{
// 		$pd = new ModeloPedidodetalle();
	
// 		$pd->setIdPedidoDetalle($idPedidoDetalle);
	
// 		if ($pd->getIdPedidoDetalle() <= 0)
// 		{
// 			$errores .= "No se pudo obtener el detalle del pedido.";
// 			$blnDoCommit = false;
// 		}
// 		else
// 		{
// 			if (($pd->getTotalExplotar() - $pd->getExplotadoReal()) <= 0)
// 			{
// 				$pd->setDespachadoSI();
				
// 				$pd->setId_usuario_despachado($pedidodetalle["id_usuario_capturado"]);
// 				$pd->setFecha_despachado(date("Y-m-d H:i:s"));
	
				
// 				myLog(" --> Producto D E S P A C H A D O");
				
// 				$pd->Guardar();
	
// 				if ($pd->getError())
// 				{
// 					$blnDoCommit = false;
// 					$errores .= $pd->getStrError();
// 				}
// 			}
// 		}
	
// 	}
// 	else
// 	{
// 		$blnDoCommit = false;
// 	}
	
	
// // 	echo "<br><br><br>" . $errores;
	
// 	$blnDoCommit = false;
// 	if ($blnDoCommit)
// 	{		
// 		$pd->transaccionCommit();
// 		myLog("  ==::::::::::::::::::::::::::::> O K  <::::::::::::::::::::::::::::==");
// 		// 	$r->script("
// 		//  					    app.pedidoDetalle[app.indexDespachando].despachado = 'SI';
// 		//  						setTimeout(function() {xajax_cargarPedidoDetalle(".$idPedidoDetalle.", false);}, 10);
// 		//  						saSuccess(\"El movimiento se ha realizado de manera correcta.\");
// 		//  					    ");
// 	}
// 	else
// 	{		
// 		$pd->transaccionRollback();
		
// 		myLog(" :::: Errores: " . $errores);
// 		// 	$r->script("saError(\"Ha ocurrido un error. ".$errores."\");");
// 	}
	
// }
	








// return;
	
// 	$va = "Para el [CLICXC_AI]40[CLICXC_AT]NOMBRE CLIENTE[CLICXC_AF] como tipo D.";
	
// 	$va = str_replace("[CLICXC_AI]","<a target='_blank' href='cxcclientepedidos/", $va);
// 	$va = str_replace("[CLICXC_AT]","'>Cliente ", $va);
// 	$va = str_replace("[CLICXC_AF]","</a>", $va);
	
	
// 	echo  $va . "<br><br>";
	
// 	return;
	
	
// 	//echo "Ha generado el [PEDIDO:27] como tipo D." . "<br><br>";
// 	$va = "Ha generado el [PED_AI]27[PED_AT]27[PED_AF] como tipo D.";
	
// 	$va = str_replace("[PED_AI]","<a href='pedidodetalleview/", $va);
// 	$va = str_replace("[PED_AT]","'>Pedido ", $va);
// 	$va = str_replace("[PED_AF]","</a>", $va);
	
	
// 	echo  $va . "<br><br>";
	
// 	echo "<a href='pedidodetalleview/12'>Pedido 27</a>";
	
	
// 	return ;
	
// 	require_once FOLDER_MODEL. "model.pedido.inc.php";
	
// 	$pedido = new ModeloPedido();
	
// 	$pedido->getPedido(11);
	
// 	foreach ($pedido->__rsPedidoWDetalle as $row)
// 	{
// 		echo "<br>" . $row["idPedidoDetalle"];
// 	}
	
	
	
// 	return;
// 	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	
// 	$pedidoDetalle = new ModeloPedidodetalle();
	
// 	echo $pedidoDetalle->getAllQUERY("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, 
// 			cantidadReal, totalExplotar, totalExplotado, listo_para_producir", "", 
// 			"idPedido = " . "1");
	
	
// 	return;
	
// 	$_oLugar=new Routes();
	
// // 	echo "<br>" . $_lugar;
	
// 	if ($_oLugar->lugarVisible(LUGAR_CATALOGOS))
// 	{
// 		echo "<br>" . "si en catalalogos";
// 	}
	
// 	if (Permisos::userIsThisRol(Permisos::$rol_CXC))
// 	{
// 		echo "<br>" . "eres CXC";
// 	}
// 	else 
// 	{
// 		echo "<br>" . "No eres CXC";
// 	}
	
// 	return;

// 	require_once FOLDER_MODEL. "model.pedido.inc.php";
	
// 	$pedido = new ModeloPedido();
	
// 	$where = "";
// 	if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR))
// 	{
// 		$where .= "AND c.idUsuarioPromotor = " . ModeloUsuario::getObjSession()->getIdUsuario();
// 	}

// echo $where;

// echo "<br><br>";

// if (substr($where, 0,3) == "AND")
// {
// 	$where = substr($where, 4);
// }
// echo substr($where, 0,3);
// echo "<br>";
// echo substr($where, 4);

// echo "<br><br>";


	
	
	
// 	echo $pedido->getAllQUERY("pedido.idPedido, pedido.total, pedido.estado, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_capturado, pedido.recogeentrega,
// 		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente",
// 			" INNER JOIN cliente as c ON c.idCliente = pedido.idCliente",
// 			$where, "idPedido desc");
	
// 	return;
	
	
// 	ModeloUsuario::getObjSession()->dumpObj();
	
// 	return;
	
// 	require_once FOLDER_MODEL. "model.producto.inc.php";
	
// 	$p = new ModeloProducto();
	
// 	$p->Guardar();
	
	
// 	return;
	
	
// 	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	
// 	$htmlInvHistorial = "";
	
// 	$invPro = new ModeloInvzmov();
// 	$lstInvPro = $invPro->getAll("fecha_movimiento, IFNULL(remisionrollo.norollo, '--') as norollo, cantidad",
// 			"left join remisionrollo on remisionrollo.idremisionrollo = invzmov.idremisionrollo", "idPedidoDetalle = 141 AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' ");
	
	
// // 	var_dump($lstInvPro);
	
// 	// 			$r->mostrarAviso($inv->getAllQUERY("fecha_movimiento, cantidad", "", "idPedidoDetalle = " . $row["idPedidoDetalle"]." AND movimiento = 'SALIDA' AND salidaDespacho = 'SI' "));
// 	// 			return $r;
	
// 	foreach ($lstInvPro as $item)
// 	{
// 		$htmlInvHistorial .= "<br><strong>Fecha:</strong> " . $item["fecha_movimiento"] . "     <strong># Rollo:</strong> " . $item["norollo"] . "     <strong>Cantidad:</strong> " . $item["cantidad"];
// 	}
	
// 	if ($htmlInvHistorial != "")
// 	{
// 		$htmlInvHistorial = "<strong>Movimientos:</strong><br>" . $htmlInvHistorial;
// 	}
	
// 	echo $htmlInvHistorial;
	
	
// 	return;
	
// 	$producto = new ModeloProducto();
	
// 	$lst = $producto->getAll("idProducto, codigo, descripcion, longitud",
// 			"",
// 			" producto_rollo_idrollo = 10 AND producto_unidad_idunidad = 4");
	
// 	$opcionesProducto = "<option value='0'>-- Seleccione Producto --</option>";
// 	$opcionesProductoLong = "<option value='0'>-- Seleccione Producto --</option>";
	
// 	foreach ($lst as $row)
// 	{
// 		$opcionesProducto .= "<option value='".$row["idProducto"]."'>".$row["codigo"]." - ".$row["descripcion"]."</option>";
// 		$opcionesProductoLong .= "<option value='".$row["idProducto"]."'>".$row["longitud"]."</option>";
// 	}
	
// 	echo $opcionesProducto;
	
// 	return;
	
	
// 	echo ModeloUsuario::getObjSession()->getIdRol();
// 	echo "<br>";
// 	echo Permisos::getRolInBinary();
	
// 	echo "<br>Pregunto si soy administrador<br>";
// 	if(Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR))
// 		{
// 			echo "Si soy";
// 		}
// 		else
// 		{
// 			echo "no soy";
// 		}
	
// 	echo "<br>";
// 	echo "<br>Pregunto si soy promotor<br>";
// 	if(Permisos::userIsThisRol(Permisos::$rol_PRODUCCION))
// 	{
// 		echo "Si soy";		
// 	}
// 	else 
// 	{
// 		echo "no soy";
// 	}
	
// 	echo "<br>";
// 	echo "<br>Pregunto si soy root<br>";
// 	if(Permisos::userIsThisRol(Permisos::$rol_ROOT))
// 		{
// 			echo "Si soy";
// 		}
// 		else
// 		{
// 			echo "no soy";
// 		}
	
	
// 	return;

// 	require_once FOLDER_MODEL. "model.pedido.inc.php";
	
// 	$pedido = new ModeloPedido();
// echo $pedido->getAllQUERY("pedido.idPedido, pedido.total, pedido.estado, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_capturado,
// 		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente",
// 			" INNER JOIN cliente as c ON c.idCliente = pedido.idCliente","", "idPedido desc");

// $lstPedidos = $pedido->getAll("pedido.idPedido, pedido.total, pedido.estado, pedido.explotado, pedido.explotadook, pedido.despachado, pedido.fecha_capturado,
// 		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente",
// 		" INNER JOIN cliente as c ON c.idCliente = pedido.idCliente","", "idPedido desc");

// $cambiaEstatusButton = "";
// $strHTML = "";
// foreach ($lstPedidos as $row)
// {
// 	$strHTML .= "    <tr>";
// 	$strHTML .= "      <td>" . $row["idPedido"] . "</td>";
// 	$strHTML .= "      <td>". $row["nombreCliente"]."</td>";
// 	$strHTML .= "      <td>$". number_format($row["total"], 2) ."</td>";
// 	$strHTML .= "      <td>" . substr($row["fecha_capturado"], 0, 10) . "</td>";
// 	$strHTML .= "      <td>";

// 	switch ($row["estado"])
// 	{
// 		case "CAPTURADO";
// 		$strHTML .= "<p><span class='label label-warning'>CAPTURADO</span></p>";
// 		$cambiaEstatusButton = "&nbsp;<button class='btn btn-warning' onclick='fnAutorizar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> AUTORIZAR</button>";
// 		break;
// 		case "AUTORIZADO";
// 		$strHTML .= "<p><span class='label'>AUTORIZA CxC</span></p>";
// 		if ($row["explotado"] == "SI")
// 		{
// 			if ($row["explotadook"] == "SI")
// 			{
// 				$cambiaEstatusButton = "&nbsp;<button class='btn btn-info' onclick='fnProducir(".$row["idPedido"].");'><i class='fa fa-exchange'></i> PRODUCIR</button>";
// 			}
// 			else
// 			{
// 				$cambiaEstatusButton = "&nbsp;<span class='label label-danger'>EXPLOSIONADO SIN &Eacute;XITO</span>";
// 			}

// 		}
// 		else
// 		{
// 			$cambiaEstatusButton = "&nbsp;<span class='label label-danger'>NO EXPLOSIONADO</span>";
// 		}
			
// 		break;
// 		case "PRODUCCION";
// 		$strHTML .= "<p><span class='label label-info'>PRODUCCI&Oacute;N</span></p>";
// 		if ($row["despachado"] == "SI")
// 		{
// // 			if ($row["recogeentrega"] == "RECOGE")
// // 			{
// // 				$cambiaEstatusButton = "&nbsp;<button class='btn btn-primary' onclick='fnTerminarYEntregar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> TERMINAR</button>";
// // 			}
// // 			else
// // 			{
// // 				$cambiaEstatusButton = "&nbsp;<button class='btn btn-primary' onclick='fnTerminar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> TERMINAR</button>";
// // 			}
// 		}
// 		else
// 		{
// 			$cambiaEstatusButton = "&nbsp;<span class='label label-warning'>NO DESPACHADO</span>";
// 		}
// 		break;
// 		case "TERMINADO";
// 		$strHTML .= "<p><span class='label label-primary'>TERMINADO</span></p>";
// 		$cambiaEstatusButton = "&nbsp;<button class='btn btn-success' onclick='fnEntregar(".$row["idPedido"].");'><i class='fa fa-exchange'></i> ENTREGAR</button>";
// 		break;
// 		case "ENTREGADO";
// 		$strHTML .= "<p><span class='label label-success'>ENTREGADO</span></p>";
// 		break;
// 		case "CANCELADO";
// 		$strHTML .= "<p><span class='label label-danger'>CANCELADO</span></p>";
// 		break;
// 	}
		
// 	$strHTML .= "      </td>";
// 	$strHTML .= "      <td class='text-right'>";
// 	//$strHTML .=  "<a href='tmppedidoprint?id=" . $row["idPedido"] . "' alt='Ver' target='_blank' class='btn btn-info'><i class='fa fa-eye'></i></a>";
		
// 	$strHTML .= "<div class='btn-group'>";
// 	$strHTML .= "<button data-toggle='dropdown' class='btn btn-success btn-sm dropdown-toggle'><i class='fa fa-eye'></i> <span class='caret'></span></button>";
// 	$strHTML .= "<ul class='dropdown-menu'>";
		
// 	$strHTML .= "<li><a href='pedidoprint?id=" .  $row["idPedido"]."' alt='Imprimir' target='_blank'><span class='fa fa-print'></span> Imprimir</a></li>";
		
// 	$strHTML .= "<li class='divider'></li>";
// 	$strHTML .= "<li><a href='pedidosend?idPedido=" .  $row["idPedido"]."' alt='Enviar al Cliente' target='_blank'><span class='fa fa-envelope'></span> Enviar al Cliente</a></li>";
// 	// 			$strHTML .= "<li><a href='#' onclick='sendPedidoACliente(" .  $row["idPedido"].");' alt='Enviar al Cliente' ><span class='fa fa-envelope'></span> Enviar al Cliente</a></li>";
// 	// 			$strHTML .= "<li onclick='sendPedidoACliente(" .  $row["idPedido"].");' ><span class='fa fa-envelope'></span> Enviar al Cliente</a></li>";
		
// 	$strHTML .= "</ul>";
// 	$strHTML .= "</div>";
		
		
// 	$strHTML .= $cambiaEstatusButton;
// 	// 			$strHTML .= "      <div class='btn-group'>";
// 	// 			$strHTML .= "      <button class='btn-white btn btn-xs'>View</button>";
// 	// 			$strHTML .= "      <button class='btn-white btn btn-xs'>Edit</button>";
// 	// 			$strHTML .= "      <button class='btn-white btn btn-xs'>Delete</button>";
// 	// 			$strHTML .= "      </div>";
// 	$strHTML .= "      </td>";
// 	$strHTML .= "    </tr>";
// }




// $strHTML .= "  </tbody>";
// $strHTML .= "  <tfoot>";
// $strHTML .= "    <tr>";
// $strHTML .= "      <td colspan='6'>";
// $strHTML .= "        <ul class='pagination pull-right'></ul>";
// $strHTML .= "      </td>";
// $strHTML .= "    </tr>";
// $strHTML .= "  </tfoot>";
// $strHTML .= "</table>";


// echo $strHTML;

	
	
// 	return;
	
// /**
//  * Clase que implementa un conversor de n�meros a letras.
// * @author AxiaCore S.A.S
// *
// */
// class NumberToLetterConverter {
// 	private $UNIDADES = array(
// 			'',
// 			'UN ',
// 			'DOS ',
// 			'TRES ',
// 			'CUATRO ',
// 			'CINCO ',
// 			'SEIS ',
// 			'SIETE ',
// 			'OCHO ',
// 			'NUEVE ',
// 			'DIEZ ',
// 			'ONCE ',
// 			'DOCE ',
// 			'TRECE ',
// 			'CATORCE ',
// 			'QUINCE ',
// 			'DIECISEIS ',
// 			'DIECISIETE ',
// 			'DIECIOCHO ',
// 			'DIECINUEVE ',
// 			'VEINTE '
// 	);
// 	private $DECENAS = array(
// 			'VEINTI',
// 			'TREINTA ',
// 			'CUARENTA ',
// 			'CINCUENTA ',
// 			'SESENTA ',
// 			'SETENTA ',
// 			'OCHENTA ',
// 			'NOVENTA ',
// 			'CIEN '
// 	);
// 	private $CENTENAS = array(
// 			'CIENTO ',
// 			'DOSCIENTOS ',
// 			'TRESCIENTOS ',
// 			'CUATROCIENTOS ',
// 			'QUINIENTOS ',
// 			'SEISCIENTOS ',
// 			'SETECIENTOS ',
// 			'OCHOCIENTOS ',
// 			'NOVECIENTOS '
// 	);
// 	private $MONEDAS = array(
// 			array('country' => 'Colombia', 'currency' => 'COP', 'singular' => 'PESO COLOMBIANO', 'plural' => 'PESOS COLOMBIANOS', 'symbol', '$'),
// 			array('country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'D�LAR', 'plural' => 'D�LARES', 'symbol', 'US$'),
// 			array('country' => 'El Salvador', 'currency' => 'USD', 'singular' => 'D�LAR', 'plural' => 'D�LARES', 'symbol', 'US$'),
// 			array('country' => 'Europa', 'currency' => 'EUR', 'singular' => 'EURO', 'plural' => 'EUROS', 'symbol', '�'),
// 			array('country' => 'M�xico', 'currency' => 'MXN', 'singular' => 'PESO MEXICANO', 'plural' => 'PESOS MEXICANOS', 'symbol', '$'),
// 			array('country' => 'Per�', 'currency' => 'PEN', 'singular' => 'NUEVO SOL', 'plural' => 'NUEVOS SOLES', 'symbol', 'S/'),
// 			array('country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'LIBRA', 'plural' => 'LIBRAS', 'symbol', '�'),
// 			array('country' => 'Argentina', 'currency' => 'ARS', 'singular' => 'PESO', 'plural' => 'PESOS', 'symbol', '$')
// 	);
// 	private $separator = '.';
// 	private $decimal_mark = ',';
// 	private $glue = ' CON ';
// 	/**
// 	 * Evalua si el n�mero contiene separadores o decimales
// 	 * formatea y ejecuta la funci�n conversora
// 	 * @param $number n�mero a convertir
// 	 * @param $miMoneda clave de la moneda
// 	 * @return string completo
// 	 */
// 	public function to_word($number, $miMoneda = null) {
// 		if (strpos($number, $this->decimal_mark) === FALSE) {
// 			$convertedNumber = array(
// 					$this->convertNumber($number, $miMoneda, 'entero')
// 			);
// 		} else {
// 			$number = explode($this->decimal_mark, str_replace($this->separator, '', trim($number)));
// 			$convertedNumber = array(
// 					$this->convertNumber($number[0], $miMoneda, 'entero'),
// 					$this->convertNumber($number[1], $miMoneda, 'decimal'),
// 			);
// 		}
// 		return implode($this->glue, array_filter($convertedNumber));
// 	}
// 	/**
// 	 * Convierte n�mero a letras
// 	 * @param $number
// 	 * @param $miMoneda
// 	 * @param $type tipo de d�gito (entero/decimal)
// 	 * @return $converted string convertido
// 	 */
// 	private function convertNumber($number, $miMoneda = null, $type) {

// 		$converted = '';
// 		if ($miMoneda !== null) {
// 			try {

// 				$moneda = array_filter($this->MONEDAS, function($m) use ($miMoneda) {
// 					return ($m['currency'] == $miMoneda);
// 				});
// 					$moneda = array_values($moneda);
// 					if (count($moneda) <= 0) {
// 						throw new Exception("Tipo de moneda inv�lido");
// 						return;
// 					}
// 					($number < 2 ? $moneda = $moneda[0]['singular'] : $moneda = $moneda[0]['plural']);
// 			} catch (Exception $e) {
// 				echo $e->getMessage();
// 				return;
// 			}
// 		}else{
// 			$moneda = '';
// 		}
// 		if (($number < 0) || ($number > 999999999)) {
// 			return false;
// 		}
// 		$numberStr = (string) $number;
// 		$numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
// 		$millones = substr($numberStrFill, 0, 3);
// 		$miles = substr($numberStrFill, 3, 3);
// 		$cientos = substr($numberStrFill, 6);
// 		if (intval($millones) > 0) {
// 			if ($millones == '001') {
// 				$converted .= 'UN MILLON ';
// 			} else if (intval($millones) > 0) {
// 				$converted .= sprintf('%sMILLONES ', $this->convertGroup($millones));
// 			}
// 		}

// 		if (intval($miles) > 0) {
// 			if ($miles == '001') {
// 				$converted .= 'MIL ';
// 			} else if (intval($miles) > 0) {
// 				$converted .= sprintf('%sMIL ', $this->convertGroup($miles));
// 			}
// 		}
// 		if (intval($cientos) > 0) {
// 			if ($cientos == '001') {
// 				$converted .= 'UN ';
// 			} else if (intval($cientos) > 0) {
// 				$converted .= sprintf('%s ', $this->convertGroup($cientos));
// 			}
// 		}
// 		$converted .= $moneda;
// 		return $converted;
// 	}
// 	/**
// 	 * Define el tipo de representaci�n decimal (centenas/millares/millones)
// 	 * @param $n
// 	 * @return $output
// 	 */
// 	private function convertGroup($n) {
// 		$output = '';
// 		if ($n == '100') {
// 			$output = "CIEN ";
// 		} else if ($n[0] !== '0') {
// 			$output = $this->CENTENAS[$n[0] - 1];
// 		}
// 		$k = intval(substr($n,1));
// 		if ($k <= 20) {
// 			$output .= $this->UNIDADES[$k];
// 		} else {
// 			if(($k > 30) && ($n[2] !== '0')) {
// 				$output .= sprintf('%sY %s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
// 			} else {
// 				$output .= sprintf('%s%s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
// 			}
// 		}
// 		return $output;
// 	}
// }


// class NumeroALetras
// {
// 	private static $UNIDADES = [
// 			'',
// 			'UN ',
// 			'DOS ',
// 			'TRES ',
// 			'CUATRO ',
// 			'CINCO ',
// 			'SEIS ',
// 			'SIETE ',
// 			'OCHO ',
// 			'NUEVE ',
// 			'DIEZ ',
// 			'ONCE ',
// 			'DOCE ',
// 			'TRECE ',
// 			'CATORCE ',
// 			'QUINCE ',
// 			'DIECISEIS ',
// 			'DIECISIETE ',
// 			'DIECIOCHO ',
// 			'DIECINUEVE ',
// 			'VEINTE '
// 	];
// 	private static $DECENAS = [
// 			'VEINTI',
// 			'TREINTA ',
// 			'CUARENTA ',
// 			'CINCUENTA ',
// 			'SESENTA ',
// 			'SETENTA ',
// 			'OCHENTA ',
// 			'NOVENTA ',
// 			'CIEN '
// 	];
// 	private static $CENTENAS = [
// 			'CIENTO ',
// 			'DOSCIENTOS ',
// 			'TRESCIENTOS ',
// 			'CUATROCIENTOS ',
// 			'QUINIENTOS ',
// 			'SEISCIENTOS ',
// 			'SETECIENTOS ',
// 			'OCHOCIENTOS ',
// 			'NOVECIENTOS '
// 	];
// 	public static function convertir($number, $moneda = '', $centimos = '', $forzarCentimos = false)
// 	{
// 		$converted = '';
// 		$decimales = '';
// 		if (($number < 0) || ($number > 999999999)) {
// 			return 'No es posible convertir el numero a letras';
// 		}
// 		$div_decimales = explode('.',$number);
// 		if(count($div_decimales) > 1){
// 			$number = $div_decimales[0];
// 			$decNumberStr = (string) $div_decimales[1];
// 			if(strlen($decNumberStr) == 2){
// 				$decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
// 				$decCientos = substr($decNumberStrFill, 6);
// 				$decimales = self::convertGroup($decCientos);
// 			}
// 		}
// 		else if (count($div_decimales) == 1 && $forzarCentimos){
// 			$decimales = 'CERO ';
// 		}
// 		$numberStr = (string) $number;
// 		$numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
// 		$millones = substr($numberStrFill, 0, 3);
// 		$miles = substr($numberStrFill, 3, 3);
// 		$cientos = substr($numberStrFill, 6);
// 		if (intval($millones) > 0) {
// 			if ($millones == '001') {
// 				$converted .= 'UN MILLON ';
// 			} else if (intval($millones) > 0) {
// 				$converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
// 			}
// 		}
// 		if (intval($miles) > 0) {
// 			if ($miles == '001') {
// 				$converted .= 'MIL ';
// 			} else if (intval($miles) > 0) {
// 				$converted .= sprintf('%sMIL ', self::convertGroup($miles));
// 			}
// 		}
// 		if (intval($cientos) > 0) {
// 			if ($cientos == '001') {
// 				$converted .= 'UN ';
// 			} else if (intval($cientos) > 0) {
// 				$converted .= sprintf('%s ', self::convertGroup($cientos));
// 			}
// 		}
// 		if(empty($decimales)){
// 			$valor_convertido = $converted . strtoupper($moneda);
// 		} else {
// 			$valor_convertido = $converted . strtoupper($moneda) . ' CON ' . $decimales . ' ' . strtoupper($centimos);
// 		}
// 		return $valor_convertido;
// 	}
// 	private static function convertGroup($n)
// 	{
// 		$output = '';
// 		if ($n == '100') {
// 			$output = "CIEN ";
// 		} else if ($n[0] !== '0') {
// 			$output = self::$CENTENAS[$n[0] - 1];
// 		}
// 		$k = intval(substr($n,1));
// 		if ($k <= 20) {
// 			$output .= self::$UNIDADES[$k];
// 		} else {
// 			if(($k > 30) && ($n[2] !== '0')) {
// 				$output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
// 			} else {
// 				$output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
// 			}
// 		}
// 		return $output;
// 	}
// }

// $n = new NumberToLetterConverter();

// echo $n->to_word(12345.67);
// echo "<br><br>";
// echo NumeroALetras::convertir(11, "PESOS", "CENTAVOS");

// return;

// require_once FOLDER_MODEL. "model.remisionrollo.inc.php";

// $remisionRollo = new ModeloRemisionrollo();

// $lst = $remisionRollo->getAll("idRemisionRollo, noRollo, fecha, remision, almacen, kilos, remisionrollo.existencia, idRollo, codigo, descripcion ",
// 		"INNER JOIN rollo ON rollo.idRollo = remisionRollo_rollo_idRollo",
// 		"noRollo = '2A487946UP100'", "idRollo");
// var_dump($lst);
// // 		idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos
// $idRolloAnterior = 0;
// $idRolloActual = 0;
// $indexRollo = -1;
// $pushes = "";

// foreach ($lst as $row)
// {
// 	$idRolloActual = $row["idRollo"];
		
// 	if ($idRolloActual != $idRolloAnterior)
// 	{
		
// 		$pushes .= "app.rollos.push({idRollo: ".$row["idRollo"].", codigo: '".$row["codigo"]."', descripcion: '".$row["descripcion"]."', noRollos: []});";

// 		$idRolloAnterior = $idRolloActual;
// 	}
		
// }

// echo $pushes;



// return;
// $idRemisionRollo = 93;
// $remisionRollo = new ModeloRemisionrollo();

// $remisionRollo->setIdRemisionRollo($idRemisionRollo);

// $remisionRollo->varDump($remisionRollo);

// return;


// $rollo= new ModeloRemisionrollo();
// $idRollo = 3;	

// $lst = $rollo->getAll("",""," remisionRollo_rollo_idRollo = ".$idRollo." AND existencia > 0 "," existencia asc " );

// $pushes = "";

// foreach ($lst as $row)
// {
// // 	echo "<br>app.remisiones.push({idRemision: 1, remision: 123, noRollo: 'ABC001', kilos: 100, disponible: 20});";
// 				echo "<br>app.remisiones.push({idRemision: ".$row["idRemisionRollo"].", remision: ".$row["remision"].", noRollo: '".$row["noRollo"]."', kilos: ".$row["kilos"].", disponible: ".$row["existencia"].", fecha: '".$row["ts"]."'});";
// }




// return;

// require_once FOLDER_MODEL. "model.viewrollos.inc.php";

// $rollo = new ModeloViewrollos();

// $rollo->getView(5);

// $rollo->dumpObj();

// return;

// require_once FOLDER_MODEL. "model.pedido.inc.php";

// $pedido = new ModeloPedido();

// $row = $pedido->getPedidoDetalle(92);

// echo "dato: ".$row["proTipoProducto"] . "<br>";

// $pedido->varDump($row);




// return;

// require_once FOLDER_MODEL. "model.remisionrollo.inc.php";

// $remision = new ModeloRemisionrollo();
// $remision->setRemisionRollo_rollo_idRollo(3);
// $remision->setRemision("1234");
// $remision->setNoRollo("A00001");
// $remision->setKilos(200);
// $remision->setExistencia(200);
// $remision->setRemisionRollo_usuario_idUsuario(3);
	
// $remision->Guardar();
	
// if ($remision->getError())
// {
// 	echo $remision->getStrError();
	
// }


// return;

// require_once FOLDER_MODEL. "model.pedido.inc.php";




// $pedido = new ModeloPedido();

// echo $pedido->getAllQUERY("idPedido, explotado, explotadook, estado");

// return;

// $lugar = "2A0011111111";
// $rutita = "2A0011111111";

// $_oLugar=new Routes();
// $_oLugar->setLugar($rutita);

// if ($_oLugar->isPrimero($lugar))
// {
// 	echo "<br>" . $lugar . " si es primero";
// }
// else
// {
// 	echo "<br>" . $lugar . " NOO es primero";
// }

// if ($_oLugar->isSegundo($lugar))
// {
// 	echo "<br>" . $lugar . " si es segundo";
// }
// else
// {
// 	echo "<br>" . $lugar . " NO es segundo";
// }



// return;

// require_once FOLDER_MODEL. "model.pedido.inc.php";

// $pedido = new ModeloPedido();

// $lst = $pedido->getAll("idPedido, estado");

// $capturados = 0;
// $autorizados = 0;
// $produccion = 0;
// $terminado = 0;
// $entregado = 0;
// $cancelado = 0;

// foreach ($lst as $row)
// {
// 	switch ($row["estado"])
// 	{
// 		case "CAPTURADO";
// 		$capturados++;
// 		break;
// 		case "AUTORIZADO";
// 		$autorizados++;
// 		break;
// 		case "PRODUCCION";
// 		$produccion++;
// 		break;
// 		case "TERMINADO";
// 		$terminado++;
// 		break;
// 		case "ENTREGADO";
// 		$entregado++;
// 		break;
// 		case "CANCELADO";
// 		$cancelado++;
// 		break;
// 	}
// }

// return;

// $pedido = new ModeloPedido();
// $pedido->getPedido(26);

// echo "<br>" . 26;
// echo "<br>" . $pedido->getPedidoDato("cteNombre") . " " . $pedido->getPedidoDato("cteApellidos");
// echo "<br>" .  $pedido->getPedidoDato("fecha_capturado");
// echo "<br>" . $pedido->getPedidoDato("cteDomicilio1") . " " . $pedido->getPedidoDato("cteDomicilio2");
// echo "<br>" .  "";//$pedido->getPedidoDato("cteDomicilio2");
// echo "<br>" . $pedido->getPedidoDato("cteRfc");
// echo "<br>" . $pedido->getPedidoDato("cteTelefonos");
// echo "<br>" . "";
// echo "<br>" . "";
// echo "<br>" . "";

//  echo "<br>" . doubleval($pedido->getPedidoDato("subtotal"));
// echo "<br>" . doubleval($pedido->getPedidoDato("iva"));
// echo "<br>" . doubleval($pedido->getPedidoDato("total"));




// return;

// require_once FOLDER_MODEL. "model.invzmov.inc.php";

// $movimientos = new ModeloInvzmov();

// echo $movimientos->getAllQUERY("movimiento, fecha_movimiento, id_usuario_movimiento, concat(nombre, ' ', apellidoPaterno, ' ' , apellidoMaterno) as usrMovimiento, cantidad, observaciones",
// 				                    " INNER JOIN usuario as u ON u.idUsuario = id_usuario_movimiento ", "", "  idInvzmov DESC LIMIT 3 ");

// return;


// require_once FOLDER_MODEL. "model.pedido.inc.php";

// $pedido = new ModeloPedido();
// $pedido->getPedido(18);

// echo "haber<br>";

// echo $pedido->getPedidoDato("cteNombre");



// return;

// $_NOW_=date("Y-m-d H:i:s");
// echo $_NOW_;



// return;

// require_once FOLDER_MODEL. "model.pedido.inc.php";

// $pedido = new ModeloPedido();

// $pedido->setIdPedido(7);
// $pedido->setPedidoAUTORIZADO();

// $pedido->Guardar();

// // echo $pedido->getAllQUERY("pedido.idPedido, pedido.total, pedido.fecha_captura,
// // 		                   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente", 
// // 		                  " INNER JOIN cliente as c ON c.idCliente = pedido.idCliente");

// return;

// require_once FOLDER_MODEL. "model.precioxdobles.inc.php";

// $precioXDobles = new ModeloPrecioxdobles();

// $precioXDobles->setTipoPrecio("I");
// $precioXDobles->setDesarrollo("15");
// $precioXDobles->getPreciosByDesarrolloTipoPrecio();

// $precioXDobles->dumpObj();

// $precio = $precioXDobles->getPrecioById(4);



// return;

// echo "hola mundo mundial";

// require_once FOLDER_MODEL. "model.producto.inc.php";

// $productos = new ModeloProducto();


// $query = "select distinct tipoprecio, desarrollo from precioxdobles order by idPrecioXDobles;";

// $lstDesarrollos = $productos->getDataSet($query);

// var_dump($lstDesarrollos);
		
// foreach ($lstDesarrollos as $row)
// 			{
// 				echo "

// 	                        app.desarrollos.push({ tipoPrecio: '".$row["tipoprecio"]."', desarrollo: '".$row["desarrollo"]."' });

// 	                    ";
// 			}

// return;

// require_once FOLDER_MODEL. "model.cliente.inc.php";

// $clientes = new ModeloCliente();

// echo $clientes->getAllQUERY("cliente.idCliente, cliente.nombre, cliente.apellidos, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno",
// 		" INNER JOIN usuario AS u ON u.idUsuario = cliente.idUsuarioPromotor");



// return ;



// $_oLugar=new Routes();
// //$_oLugar->setLugar($_lugar);

// echo "3000" . (Permisos::$rol_ADMINISTRADOR |
// 		                                        Permisos::$rol_PRODUCCION |
// 		                                        Permisos::$rol_PROMOTOR);

		                                       

// echo "<br><br>";

// echo Permisos::$rol_ADMINISTRADOR |
// Permisos::$rol_PRODUCCION |
// Permisos::$rol_PROMOTOR;

// echo "<br><br>";

// echo $_oLugar->lugarVisible(LUGAR_CATALOGOS);

// return;

// require_once FOLDER_MODEL. "model.producto.inc.php";

// $producto = new ModeloProducto();


// $producto->setIdProducto(30);

// //verifica si el rollo fue cargado

// $producto->getDatosReferencia();

// $producto->dumpObj();

// $producto->TipoProducto->dumpObj();
// $producto->Aplicacion->dumpObj();
// $producto->Material->dumpObj();
// $producto->Rollo->dumpObj();



// return;

// echo "vamos";

// require_once FOLDER_MODEL. "model.viewproductos.inc.php";

// $productos = new ModeloViewproductos();

// $query = "select distinct tipoprecio, desarrollo from precioxdobles order by idPrecioXDobles;";

// $lstDesarrollos = $productos->getDataSet($query);

// foreach ($lstDesarrollos as $r)
// {
// 	echo "tipoPrecio: '".$row["tipoprecio"]."', desarrollo: '".$row["desarrollo"]."'";
// }

// return;

// $productos->getAllView();

// for($i = 0 ; $i <count($productos->lstProductos) ; $i++)
// {
// 	echo "<br>";
	
// // 	echo $productos->getViewProducto($i)->get
// 	echo $productos->lstProductos[$i]->getIdProducto();
// 	echo "<br>";
// 	echo $productos->lstProductos[$i]->getCodigo();
// 	echo "<br>";
// 	echo $productos->lstProductos[$i]->getDescripcion();
// 	echo "<br>";
// 	echo $productos->lstProductos[$i]->getFullDescripcion();
// 	echo "<br>";
// 	echo "Rollo Descripcion: " . $productos->lstProductos[$i]->getRolloDescripcion();
// 	echo "<br><br>";
// }


// return;

// echo "<br>_NOW_ : " . $_NOW_;
// echo "<br>_CURDATE_ : " . $_CURDATE_;
// echo "<br>_CURTIME_ : " . $_CURTIME_;



// return;
// global $objSession;

// echo "<br>idUsuario: " . $objSession->getIdUsuario();

// echo "<br><br><br>";

// $objSession->dumpObj();




// return;

// echo "param1: " . $param1 . " end param1";
// echo "<br>";
// echo "param2: " . $param2 . " end param2";
// echo "<br>";
// echo "param3: " . $param3 . " end param3";
// echo "<br>";
// echo "param4: " . $param4 . " end param4";
// echo "<br>";
// echo "param5: " . $param5 . " end param5";
// echo "<br>";



// return;

// require_once FOLDER_MODEL. "model.rollo.inc.php";

// $rollo = new ModeloRollo();

// $rollo->setIdRollo(1);


// $rollo->dumpObj();


// return;

// $date = new DateTime();
// echo $date->getTimestamp();


// return;


// $idUsuario = ModeloUsuario::getObjSession()->getIdUsuario();

// echo $idUsuario;




// require_once FOLDER_MODEL. "model.remisionrollo.inc.php";

// $remi = new ModeloRemisionrollo();

// $remi->setRemision(19);
// $remi->setRemisionRollo_rollo_idRollo(1);
// $remi->setNoRollo("NRK282");
// $remi->setKilos(90);
// $remi->setRemisionRollo_usuario_idUsuario($idUsuario);

// $remi->Guardar();


// return;

// $_oLugar=new Routes();
// $_oLugar->setLugar(LUGAR_ADMINISTRACION);

// echo "<br>";

// if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION	))
// {
// 	echo "Si visible";
// }
// else
// {
// 	echo "No visible";
// }

// //echo Routes::moduleAllow("test");


// return;

// require_once FOLDER_MODEL. "model.rollo.inc.php";


// $rollo = new ModeloRollo();

// $rollo->setIdRollo(2);

// $rollo->getDatosReferencia();


// $rollo->dumpObj();

// $rollo->Material->dumpObj();

// $rollo->Proveedor->dumpObj();



// echo "<br><br>";

// echo nl2br($rollo->getDescripcion());

// echo "<br><br>";

// echo str_replace(PHP_EOL,'<br/>', $rollo->getDescripcion());

// echo "<br><br>";

// echo str_replace('<br />','beerre', $rollo->getDescripcion());

// echo "<br><br>";

// echo str_replace(chr(13),'trece', str_replace('<br />','beerre', $rollo->getDescripcion()));

// // $arr1 = str_split($rollo->getDescripcion());

// // print_r($arr1);




// return;

// $strTablaListado = "";

// $material = new ModeloMaterial();

// $material->__fillable=array("nombre","clave");
// $material->__fillableHeader=array("Nombre","Clave");
// $lst = $material->getAll();

// var_dump($lst);

// echo "<br><br>";

// $lst = $material->getAll("", "", "nombre");

// var_dump($lst);

// $strTablaListado = $material->getTableHTML($lst, "tblListado", true, "Material");

?>