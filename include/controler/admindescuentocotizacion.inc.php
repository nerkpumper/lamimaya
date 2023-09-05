<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.cotizacion.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cxc.inc.php";
	require_once FOLDER_MODEL. "model.formapago.inc.php";
	

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


function cargarDatosCotizacion($idCotizacion)
{
	$r = new xajaxResponse();
	
	$cotizacion = new ModeloCotizacion();
	
	$cotizacion->getCotizacion($idCotizacion, " LIMIT 1");

	if (count($cotizacion->__rsCotizacionWDetalle) <= 0)
	{
		$r->saError("No se pudo cargar informaci�n del Pedido.");
		$r->script("app.seleccionarOtraCotizacion();");
		return $r;
	}
	
	$datosCliente = "";
	
	//$datosCliente .= "app.cteIdCliente = '".$pedido->getPedidoDato("idCliente")."';";
	$datosCliente .= "app.cteNombre = '".$cotizacion->getPedidoDato("cteNombre")."';";
	
	
	
	$datosCliente .= "app.cteApellidos = '".$cotizacion->getPedidoDato("cteApellidos")."';";
	$datosCliente .= "app.cteEmpresa = '".$cotizacion->getPedidoDato("cteEmpresa")."';";
	$datosCliente .= "app.cteDomicilio1 = '".$cotizacion->getPedidoDato("cteDomicilio1")."';";
	$datosCliente .= "app.cteDomicilio2 = '".$cotizacion->getPedidoDato("cteDomicilio2")."';";
	$datosCliente .= "app.cteNumero = '".$cotizacion->getPedidoDato("cteNumero")."';";
	$datosCliente .= "app.cteColonia = '".$cotizacion->getPedidoDato("cteColonia")."';";
	$datosCliente .= "app.cteCiudad = '".$cotizacion->getPedidoDato("cteCiudad")."';";
	$datosCliente .= "app.cteTelefonos = '".$cotizacion->getPedidoDato("cteTelefonos")."';";
	$datosCliente .= "app.cteEMail = '".$cotizacion->getPedidoDato("cteEMail")."';";
	$datosCliente .= "app.cteRFC = '".$cotizacion->getPedidoDato("cteRFC")."';";

	$datosCliente .= "app.ctePromotor = '".$cotizacion->getPedidoDato("promoNombre")." ". $cotizacion->getPedidoDato("promoAPaterno"). " " . $cotizacion->getPedidoDato("promoAMaterno")."';";

	$datosCliente .= "app.totalCotizacion = '".$cotizacion->getPedidoDato("total")."';";
	$datosCliente .= "app.desctoAplicado = '".$cotizacion->getPedidoDato("descuento")."';";
	$datosCliente .= "app.porDesctoAplicado = '".$cotizacion->getPedidoDato("pordescuento")."';";


	$datosCliente .= "app.estado = '".$cotizacion->getPedidoDato("estado")."';";

	$r->script($datosCliente);

	return $r;
	
}
$xajax->registerFunction("cargarDatosCotizacion");

	function cargarMontos($idCotizacion)
	{
		$r = new xajaxResponse();
		

		$montos = new ModeloCotizacion();

		$montos = $cotizacion->getAll("total, subtotal",
				               "",
							   "cotizacion.idCotizacion = '.$idCotizacion.'"
);

		$datosMontos = "";
		$datosMontos .= "app.total = '".$montos["total"]."';";
		$datosMontos .= "app.subtotal = '".$montos["subtotal"]."';";
		$datosMontos .= "app.saldada = '".$montos["saldada"]."';";

		//$movimientos = "";

		// $lstMovimientos = $cxc->getAll("fecha_movimiento, id_usuario_movimiento, movimiento, saldoActual, monto, IF(movimiento = 'CARGO', saldoActual + monto, saldoActual - monto) as saldoNuevo ,formapago, IFNULL(clave, '') as clave, IFNULL(descripcion, '') as formadepago, referencia, u.nombre, u.apellidoPaterno, u.apellidoMaterno ",
		// 								"LEFT JOIN formapago ON idformapago = formapago
		// 								INNER JOIN usuario AS u ON u.idusuario = id_usuario_movimiento",
		// 								"idpedido = " . $idPedido,
		// 								"idcxc desc");

		// foreach ($lstMovimientos as $row)
		// {
		// 	$movimientos .= "

		// 				app.movimientos.push({
		// 					fecha: '".clsUtilerias::formatoFecha($row["fecha_movimiento"])."',
		// 					movimiento: '".$row["movimiento"]."',
		// 					saldoactual: '".$row["saldoActual"]."',
		// 					monto: '".$row["monto"]."',
		// 					saldonuevo: '".$row["saldoNuevo"]."',
		// 					formadepago: '".$row["formadepago"]."',
		// 					referencia: '".$row["referencia"]."',
		// 					usuario: '".$row["nombre"] . " ". $row["apellidoPaterno"] . " ". $row["apellidoMaterno"] ."'
		// 				});


		// 			";
		// }

		
		$r->script($montos);
		//$r->saSuccess("Si se cargo el cliente");
		return $r;
	}
	$xajax->registerFunction("cargarMontos");


	function registrarDescuento($idCotizacion, $descto, $porDescto)
	{
	   // global $_NOW_;
		$r = new xajaxResponse();
    
		$cotizacion = new ModeloCotizacion();

		$cotizacion->setIdCotizacion($idCotizacion);
		$strError = "";

		if ($cotizacion->getIdCotizacion() <= 0)
		{
			$r->saError("No se pudo cargar informacion de Cotizacion.");
			$r->script("app.seleccionarOtraCotizacion();");
			return $r;
		}


		//$blnDoCommit = true;
		//$cotizacion->transaccionIniciar();

		if ($cotizacion->getTotal() < $descto)
		{
			$r->saError("El descuento supera al monto de la cotizacion.");
			$r->script("app.seleccionarOtraCotizacion();");
			return $r;
		}

		$cotizacion->setDescuento($descto);
		$cotizacion->setPorDescuento($porDescto);
		$cotizacion->setTotal($cotizacion->getTotal() - $descto);
		$cotizacion->setSubtotal($cotizacion->getSubtotal() - $descto);
	 	//$cotizacion->setDateAndUser("descuento");

		$cotizacion->Guardar();


		// if ($cotizacion->getError())
		// {
		// 	$strError = "Ocurri� un error al intentar actualizar el Pedido.";
		// 	$blnDoCommit = false;
		// }
		// else
		// {
		// 	$cxcList = new ModeloCxc();

		// 	$lst= $cxcList->getAll("idCxc", "", " idPedido = " . $idPedido . "  ");

		// 	foreach ($lst as $item)
		// 	{
		// 		$cxc = new ModeloCxc();

		// 		$cxc->setIdCxc($item["idCxc"]);


		// 		if ($cxc->getCargoPorPedido() == "SI")
		// 		{
		// 			$cxc->setMonto($cxc->getMonto() - $descto);
		// 		}
		// 		else
		// 		{
		// 			$cxc->setSaldoActual($cxc->getSaldoActual() - $descto);
		// 		}

		// 		$cxc->Guardar();

		// 		if ($cxc->getError())
		// 		{
		// 			$strError .= "Ocurri� un error al intentar actualizar Movimiento cxc.";
		// 			$blnDoCommit = false;
		// 		}
		// 	}
		// }

		// if ($blnDoCommit)
		// {
		// 	$cotizacion->transaccionCommit();
		// 	$r->saSuccess("Se ha aplicado el Descuento correctamente.");
		//$r->script(" window.location = '".URL_BASE."admindescuentopedido/".$idPedido."';");

		// }
		// else
		// {
		// 	$pedido->transaccionRollback();
		// 	$r->saError($strError);
		// }
		$r->script("app.cargarDatosCotizacion();");
		return $r;
	}
	$xajax->registerFunction("registrarDescuento");

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

	
