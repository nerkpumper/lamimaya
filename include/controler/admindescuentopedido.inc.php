<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

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


	function cargarDatosPedido($idPedido)
	{
		$r = new xajaxResponse();

		$pedido = new ModeloPedido();

		$pedido->getPedido($idPedido, " LIMIT 1");

		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se pudo cargar informaci�n del Pedido.");
			$r->script("app.seleccionarOtroPedido();");
			return $r;
		}

		$datosCliente = "";

		$datosCliente .= "app.cteIdCliente = '".$pedido->getPedidoDato("idCliente")."';";
		$datosCliente .= "app.cteNombre = '".$pedido->getPedidoDato("cteNombre")."';";
		$datosCliente .= "app.cteApellidos = '".$pedido->getPedidoDato("cteApellidos")."';";
		$datosCliente .= "app.cteEmpresa = '".$pedido->getPedidoDato("cteEmpresa")."';";
		$datosCliente .= "app.cteDomicilio1 = '".$pedido->getPedidoDato("cteDomicilio1")."';";
		$datosCliente .= "app.cteDomicilio2 = '".$pedido->getPedidoDato("cteDomicilio2")."';";
		$datosCliente .= "app.cteNumero = '".$pedido->getPedidoDato("cteNumero")."';";
		$datosCliente .= "app.cteColonia = '".$pedido->getPedidoDato("cteColonia")."';";
		$datosCliente .= "app.cteCiudad = '".$pedido->getPedidoDato("cteCiudad")."';";
		$datosCliente .= "app.cteTelefonos = '".$pedido->getPedidoDato("cteTelefonos")."';";
		$datosCliente .= "app.cteEMail = '".$pedido->getPedidoDato("cteEMail")."';";
		$datosCliente .= "app.cteRFC = '".$pedido->getPedidoDato("cteRFC")."';";

		$datosCliente .= "app.ctePromotor = '".$pedido->getPedidoDato("promoNombre")." ". $pedido->getPedidoDato("promoAPaterno"). " " . $pedido->getPedidoDato("promoAMaterno")."';";

		$datosCliente .= "app.totalPedido = '".$pedido->getPedidoDato("total")."';";
		$datosCliente .= "app.desctoAplicado = '".$pedido->getPedidoDato("descuento")."';";
		$datosCliente .= "app.porDesctoAplicado = '".$pedido->getPedidoDato("pordescuento")."';";


		$datosCliente .= "app.estado = '".$pedido->getPedidoDato("estado")."';";

		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosCliente);

		return $r;
	}
	$xajax->registerFunction("cargarDatosPedido");

	function cargarMontos($idPedido)
	{
		$r = new xajaxResponse();

		$cxc = new ModeloCxc();

		$montos = $cxc->getAll("pedido.saldada, IFNULL(SUM(IF(movimiento = 'CARGO', monto, 0) ), 0) as cargos, IFNULL(SUM(IF(movimiento = 'ABONO', monto, 0) ),0) as abonos",
				               "inner join pedido on pedido.idpedido = cxc.idpedido",
							   "pedido.idpedido = " . $idPedido)[0];

		$datosMontos = "";
		$datosMontos .= "app.cargos = '".$montos["cargos"]."';";
		$datosMontos .= "app.abonos = '".$montos["abonos"]."';";
		$datosMontos .= "app.saldada = '".$montos["saldada"]."';";

		$movimientos = "";

		$lstMovimientos = $cxc->getAll("fecha_movimiento, id_usuario_movimiento, movimiento, saldoActual, monto, IF(movimiento = 'CARGO', saldoActual + monto, saldoActual - monto) as saldoNuevo ,formapago, IFNULL(clave, '') as clave, IFNULL(descripcion, '') as formadepago, referencia, u.nombre, u.apellidoPaterno, u.apellidoMaterno ",
										"LEFT JOIN formapago ON idformapago = formapago
										INNER JOIN usuario AS u ON u.idusuario = id_usuario_movimiento",
										"idpedido = " . $idPedido,
										"idcxc desc");

		foreach ($lstMovimientos as $row)
		{
			$movimientos .= "

						app.movimientos.push({
							fecha: '".clsUtilerias::formatoFecha($row["fecha_movimiento"])."',
							movimiento: '".$row["movimiento"]."',
							saldoactual: '".$row["saldoActual"]."',
							monto: '".$row["monto"]."',
							saldonuevo: '".$row["saldoNuevo"]."',
							formadepago: '".$row["formadepago"]."',
							referencia: '".$row["referencia"]."',
							usuario: '".$row["nombre"] . " ". $row["apellidoPaterno"] . " ". $row["apellidoMaterno"] ."'
						});


					";
		}


		$r->script($datosMontos . " app.movimientos.splice(0, app.movimientos.length); " . $movimientos);

		return $r;
	}
	$xajax->registerFunction("cargarMontos");


	function registrarDescuento($idPedido, $descto, $porDescto)
	{
	    global $_NOW_;
		$r = new xajaxResponse();
    
// 		$cxc = new ModeloCxc();

// 		$cxc->setIdPedido($idPedido);
// 		$cxc->setIdCliente($cteIdCliente);
// 		$cxc->setMovimiento($abonoMovimiento);
// 		$cxc->setMonto($abonoMonto);
// 		$cxc->setFormaPago($abonoFormaPago);
// 		$cxc->setReferencia($abonoReferencia);
// 		$cxc->setDateAndUser("movimiento");

// 		$cxc->Guardar();

// 		if ($cxc->getError())
// 		{
// 			$r->saError($cxc->getStrError());
// 			return $r;
// 		}
// 		else
// 		{
// 			$r->saSuccess("Movimiento registrado con �xito");
// 			$r->script("app.ingresarMovimiento = false; app.cargarMovimientos();");
// 		}

		$pedido = new ModeloPedido();

		$pedido->setIdPedido($idPedido);
		$strError = "";

		if ($pedido->getIdPedido() <= 0)
		{
			$r->saError("No se pudo cargar informaci�n del Pedido.");
			$r->script("app.seleccionarOtroPedido();");
			return $r;
		}


		$blnDoCommit = true;
		$pedido->transaccionIniciar();

		$pedido->setDescuento($descto);
		$pedido->setPorDescuento($porDescto);
		$pedido->setTotal($pedido->getTotal() - $descto);
		$pedido->setSaldo($pedido->getSaldo() - $descto);
		
		if ($pedido->getSaldo() <= 0)
		{
		    $pedido->setSaldadaSI();
		    $pedido->setFecha_saldada($_NOW_);
		}

		$pedido->setDateAndUser("descuento");

		$pedido->Guardar();


		if ($pedido->getError())
		{
			$strError = "Ocurri� un error al intentar actualizar el Pedido.";
			$blnDoCommit = false;
		}
		else
		{
			$cxcList = new ModeloCxc();

			$lst= $cxcList->getAll("idCxc", "", " idPedido = " . $idPedido . "  ");

			foreach ($lst as $item)
			{
				$cxc = new ModeloCxc();

				$cxc->setIdCxc($item["idCxc"]);


				if ($cxc->getCargoPorPedido() == "SI")
				{
					$cxc->setMonto($cxc->getMonto() - $descto);
				}
				else
				{
					$cxc->setSaldoActual($cxc->getSaldoActual() - $descto);
				}

				$cxc->Guardar();

				if ($cxc->getError())
				{
					$strError .= "Ocurri� un error al intentar actualizar Movimiento cxc.";
					$blnDoCommit = false;
				}
			}
		}

		// Se llama a proceso para autorizacion automática		
		ob_start();
		echo "  ....... ". date("Y-m-d H:i:s"). " START PEDIDO: ". $idPedido;
		echo "";
		$pedido->__isDebugging = true;
		$pedido->procesaAutorizacionAutomatica($idPedido);
		echo "  ....... ". date("Y-m-d H:i:s"). " END PEDIDO: ". $idPedido;
		echo "";
		$fp = fopen(FOLDERLOGS .$idPedido.'.html', 'a');//opens file in append mode.
		$debug = ob_get_clean();

		fwrite($fp, $debug);
		fclose($fp);
		//FIN Se llama a proceso para autorizacion automática		

		if ($blnDoCommit)
		{
			$pedido->transaccionCommit();
			$r->saSuccess("Se ha aplicado el Descuento correctamente.");
			$r->script(" window.location = '".URL_BASE."admindescuentopedido/".$idPedido."';");

		}
		else
		{
			$pedido->transaccionRollback();
			$r->saError($strError);
		}




		return $r;
	}
	$xajax->registerFunction("registrarDescuento");

	function registrarMovimiento($idPedido, $cteIdCliente, $abonoMovimiento, $abonoMonto, $abonoFormaPago, $abonoReferencia)
	{
		$r = new xajaxResponse();

		$cxc = new ModeloCxc();

		$cxc->setIdPedido($idPedido);
		$cxc->setIdCliente($cteIdCliente);
		$cxc->setMovimiento($abonoMovimiento);
		$cxc->setMonto($abonoMonto);
		$cxc->setFormaPago($abonoFormaPago);
		$cxc->setReferencia($abonoReferencia);
		$cxc->setDateAndUser("movimiento");

		$cxc->Guardar();

		if ($cxc->getError())
		{
			$r->saError($cxc->getStrError());
			return $r;
		}
		else
		{
			$r->saSuccess("Movimiento registrado con �xito");
			$r->script("app.ingresarMovimiento = false; app.cargarMovimientos();");
		}



		return $r;
	}
	$xajax->registerFunction("registrarMovimiento");



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

	$fp = new ModeloFormapago();

	$listaFormaPago = $fp->getAll("idFormaPago, concat(clave,' - ', descripcion) as formapago", "", "", "idFormaPago");
