<?php

	function nombreLockSurtidoRP($idPedidoDetalle)
	{
		return "rp_surtido_".(int) $idPedidoDetalle;
	}

	function obtenerLockSurtidoRP($modelo, $idPedidoDetalle)
	{
		$nombre = nombreLockSurtidoRP($idPedidoDetalle);
		$lst = $modelo->getDataSet("SELECT GET_LOCK('".$nombre."', 10) AS tomado");
		return is_array($lst) && count($lst) > 0 && (int) $lst[0]["tomado"] === 1;
	}

	function liberarLockSurtidoRP($modelo, $idPedidoDetalle)
	{
		$nombre = nombreLockSurtidoRP($idPedidoDetalle);
		$modelo->getDataSet("SELECT RELEASE_LOCK('".$nombre."') AS liberado");
	}

	function hayCapturaRPDuplicadaReciente($modelo, $idPedidoDetalle, $idRegistroProduccion, $piezas, $totalkg, $idUsuario)
	{
		$idPedidoDetalle = (int) $idPedidoDetalle;
		$idRegistroProduccion = (int) $idRegistroProduccion;
		$idUsuario = (int) $idUsuario;
		$piezas = (float) $piezas;
		$totalkg = (float) $totalkg;

		if ($idPedidoDetalle <= 0 || $idRegistroProduccion <= 0)
		{
			return false;
		}

		$desde = date("Y-m-d H:i:s", time() - 20);
		$filtroUsuario = ($idUsuario > 0) ? " AND id_usuario_captura = ".$idUsuario : "";

		$lst = $modelo->getDataSet(
			"SELECT idRegistroProduccionDetalle
			FROM registroproducciondetalle
			WHERE idPedidoDetalle = ".$idPedidoDetalle."
			  AND idRegistroProduccion = ".$idRegistroProduccion."
			  ".$filtroUsuario."
			  AND partida = ".$piezas."
			  AND ABS(totalKg - ".$totalkg.") < 0.05
			  AND fecha_captura >= '".$desde."'
			LIMIT 1"
		);

		return is_array($lst) && count($lst) > 0;
	}

	function idUsuarioCapturaRP()
	{
		global $objSession;
		return (isset($objSession) && is_object($objSession)) ? (int) $objSession->getIdUsuario() : 0;
	}

	function responderLiberarSurtidoRP($r, $delayMs = 0)
	{
		if (!is_object($r) || !method_exists($r, 'script'))
		{
			return $r;
		}
		$js = "if (typeof mdlExitWait === 'function') { mdlExitWait(); } if (window.app && typeof app.liberarSurtidoRP === 'function') { app.liberarSurtidoRP(); }";
		$delayMs = (int) $delayMs;
		if ($delayMs > 0)
		{
			$r->script("setTimeout(function(){ ".$js." }, ".$delayMs.");");
		}
		else
		{
			$r->script($js);
		}
		return $r;
	}