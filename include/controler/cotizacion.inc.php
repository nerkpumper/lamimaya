<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

		require_once FOLDER_MODEL. "model.cotizacion.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	function obtenerTabla($pagina = 0, $paginaSize = 0, &$cuantos, $noCotizacion = "", $estatus = "0", $cliente = "")
	{		
		
		$strHTML = "";
		
		$strHTML .= "<table id='tblListado' class='footable table table-striped table-bordered' data-page-size='50'>";
		$strHTML .= "  <thead>";
		$strHTML .= "    <tr>";		
		$strHTML .= "      <th>Cotizacion</th>";
		$strHTML .= "      <th data-hide='phone'>Cliente</th>";
		$strHTML .= "      <th data-hide='phone'>Promotor</th>";
		$strHTML .= "      <th data-hide='phone'>Total</th>";		
		$strHTML .= "      <th data-hide='phone'>Fecha</th>";
		$strHTML .= "      <th data-hide='phone'>Saldo a Amparar</th>";		
		$strHTML .= "      <th data-hide='phone'>Categoria</th>";		
		// $strHTML .= "      <th data-hide='phone'>Vigencia</th>";
		$strHTML .= "      <th class='text-left'>Acci&oacute;n</th>";	
		$strHTML .= "    </tr>";
		$strHTML .= "  </thead>";
		$strHTML .= "  <tbody>";
		
		
		$cotizacion = new ModeloCotizacion();
		
		$where = "";
		
	
		
		
		if ($noCotizacion != "")
		{
			$where .= " AND cotizacion.idCotizacion = " . $noCotizacion;	
		}
		else
		{
						
			if ($cliente != "")
			{
				$where .= " AND UPPER(concat(c.nombre, ' ' ,c.apellidos)) LIKE '%".trim($cliente)."%'";
			}
		}
				
		if (substr($where, 0,4) == " AND")
		{
			$where = substr($where, 5);
		}
		
		$lstCuantos = $cotizacion->getAll("cotizacion.idCotizacion, cotizacion.idCliente, cotizacion.total,
										getSaldoReciboDineroTotalAmparar(cotizacion.idCliente, DATE_FORMAT(cotizacion.fecha_capturado, '%Y-%m-%d'))  saldoaamparar,
										DATEDIFF(CURDATE(), cotizacion.fecha_capturado) AS days,                                         
				                       cotizacion.fecha_capturado, cotizacion.recogeentrega, cotizacion.id_usuario_autorizaimpresion,
									   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente,
									   concat(u.nombre, ' ' ,u.apellidoPaterno, ' ', u.apellidoMaterno) as nombrePromotor,
									   cotizacion.rangoCliente
				          ", 
						  " INNER JOIN cliente as c ON c.idCliente = cotizacion.idCliente 
						    INNER JOIN usuario as u ON u.idUsuario = cotizacion.id_usuario_capturado	
						  ",
						  $where, "cotizacion.idCotizacion desc");


							  

		
		$cambiaEstatusButton = "";
		$diasParaVencer = 90;

		$cuantos = count($lstCuantos) ;

		if ($cuantos == 0)
		{
			$strHTML .= "<span  class='label label-danger'>No se encontró información</span>";
		}

		
		$lstCotizaciones = $cotizacion->getAll("cotizacion.idCotizacion, cotizacion.idCliente, cotizacion.total,
										getSaldoReciboDineroTotalAmparar(cotizacion.idCliente, DATE_FORMAT(cotizacion.fecha_capturado, '%Y-%m-%d'))  saldoaamparar,
										DATEDIFF(CURDATE(), cotizacion.fecha_capturado) AS days,                                         
				                       cotizacion.fecha_capturado, cotizacion.recogeentrega, cotizacion.id_usuario_autorizaimpresion,
									   concat(c.nombre, ' ' ,c.apellidos) as nombreCliente,
									   concat(u.nombre, ' ' ,u.apellidoPaterno, ' ', u.apellidoMaterno) as nombrePromotor,
									   cotizacion.rangoCliente
				          ", 
						  " INNER JOIN cliente as c ON c.idCliente = cotizacion.idCliente 
						    INNER JOIN usuario as u ON u.idUsuario = cotizacion.id_usuario_capturado	
						  ",
						  $where , "cotizacion.idCotizacion desc  LIMIT ".$paginaSize." OFFSET " . ($paginaSize * $pagina));	

		
		
		foreach ($lstCotizaciones as $row)
		{
			$days = $row["days"];
			$diasRestantes = $diasParaVencer - $days;
			$porcentajeVigencia = 100 - (100 * ($days - 1) / $diasParaVencer);

			if ($porcentajeVigencia > 50.0)
			{
				$tipoProgress = "success";
			}
			else if ($porcentajeVigencia > 25.0) 
			{
				$tipoProgress = "warning";
			}
			else 
			{
				$tipoProgress = "danger";
			}

			if (true || $porcentajeVigencia > 0)
			{

				$cambiaEstatusButton = "";
				
				$strHTML .= "    <tr>";
				$strHTML .= "      <td>" . $row["idCotizacion"] . "</td>";
				$strHTML .= "      <td>". $row["nombreCliente"]."</td>";
				$strHTML .= "      <td>". $row["nombrePromotor"]."</td>";
				
				$strHTML .= "      <td>". $row["total"]."</td>";
				
				$strHTML .= "      <td>" . clsUtilerias::formatoFecha(substr($row["fecha_capturado"], 0)) . "</td>";
	
				$strHTML .= "      <td>". $row["saldoaamparar"]."</td>";
				$strHTML .= "      <td><span id='rc".$row["idCotizacion"]."'>". $row["rangoCliente"]."</span> <button onclick='fnEditRangoCliente(".$row["idCotizacion"].");' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></button>
					
				</td>";

				// $strHTML .= "      <td><div class='progress progress-mini progress-striped active'>
				//                             <div :style=\"'width: ".$porcentajeVigencia."%'\" :class=\"'progress-bar progress-bar-".$tipoProgress."'\"></div>
				//                         </div> </td>";
	
				$strHTML .= "      <td class='text-left'>";
				
				$strHTML .= "<a class='btn btn-info btn-xs' href='cotizacionpdf?id=" .  $row["idCotizacion"]."' alt='Imprimir' target='_blank'><span class='fa fa-print'></span></a>";
				
								
				if ($porcentajeVigencia > 0 && $row["id_usuario_autorizaimpresion"] == 0)
				{
					$cambiaEstatusButton .= "&nbsp;<button class='btn btn-primary btn-xs' onclick='fnAutorizar(".$row["idCotizacion"].");'><i class='fa fa-dollar'></i> AUTORIZAR Pasar a Pedido</button>";			

				}
				// $cambiaEstatusButton = "&nbsp;<button class='btn btn-default btn-xs' onclick='fnSolicitarObservacionAutorizacion(".$row["idPedido"].");'><i class='fa fa-exchange'></i> AUTORIZAR</button>";
				$strHTML .= $cambiaEstatusButton;

				
				if ($porcentajeVigencia <= 0)
				{
					$strHTML .= "&nbsp;<span class='label label-danger'>Cotización ha expirado.</span>";
				}
				
				
	
				$strHTML .= "      </td>";
				$strHTML .= "    </tr>";
			}
			else
			{
				if($noCotizacion != "")
				{
					
		
					$strHTML .= "<tr><span class='label label-danger'>La cotización que esta buscando, ha expirado, no es válida.</span></tr>";
					
					
						
				}
			}
		}
		
		
		
		
		$strHTML .= "  </tbody>";		
		$strHTML .= "</table>";
		
		
		return $strHTML;
	}


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
//ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);

	function preparePage(){
		$r = new xajaxResponse();
		
		
		if(Permisos::userIsThisRol(Permisos::$rol_CXC))
		{
			$r->script(" app.estatus = \"CAPTURADOAUTORIZADO\";");
		}
		
		
		return $r;
	}
	$xajax->registerFunction("preparePage");
	
	
	function llenarListado($pagina= 0, $paginaSize = 0, $noCotizacion = "", $estatus = "0", $cliente = "")
	{
		$r = new xajaxResponse();
		$cuantos = 0;
		$r->assign("listadoPedidos", "innerHTML", obtenerTabla($pagina, $paginaSize, $cuantos, $noCotizacion, $estatus, $cliente));
		$r->script("app.pageTotalRegs = ".$cuantos.";");
				
		return $r;
	}
	$xajax->registerFunction("llenarListado");
	
	function autorizarConvertirAPedido($idCotizacion, $observacion)
	{
		$r = new xajaxResponse();
		
		$cotizacion = new ModeloCotizacion();
		
		$cotizacion->setIdCotizacion($idCotizacion);
		
		if ($cotizacion->getIdCotizacion() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion de la Cotización.");
			return $r;
		}
		
		
		$cotizacion->setDateAndUser("autorizaimpresion");
				
		$cotizacion->Guardar();
		
		if (!$cotizacion->getError())
		{
			
			// $r->mostrarExito("La Cotización ha sido autorizada para convertirse en Pedido.)");
			$r->script("setTimeout(function(){app.loadPage();}, 500);");
			$r->script("setTimeout(function(){ saSuccess(\"La Cotización ha sido autorizada para convertirse en Pedido. Redirigiendo a página para que autorize la Cotización.\") }, 200);");
			$r->script("setTimeout(function(){ window.location = URL_BASE + \"pedidonuevo/loadcotizacion/".$cotizacion->getIdCotizacion()."\"; }, 2000);");
			
			

		}	
		else
		{
			
			$r->script("saError(\"Ha ocurrido un error. " . utf8_encode($cotizacion->getStrError())."\");");
		}
	
		return $r;
	}
	$xajax->registerFunction("autorizarConvertirAPedido");
	

function actualizarRangoCliente($idCotizacion, $rango)
	{
		$r = new xajaxResponse();
	
		$cotizacion = new ModeloCotizacion();
	
		$cotizacion->setIdCotizacion($idCotizacion);
	
		if ($cotizacion->getIdCotizacion() <= 0)
		{
			$r->saError("No se ha podido obtener la informacion de la Cotización.");
			return $r;
		}
	

		$cotizacion->setRangoCliente($rango	);
	
		$cotizacion->Guardar();
	
		if (!$cotizacion->getError())
		{
			
			$r->saSuccess("Se ha cambiado la Categoria del Cliente para esta Cotización.");
			
			$r->script(" $(\"#rc".$idCotizacion."\").html(\"".$rango."\"); ");
		}
		else
		{
			$r->script("saError(Ha ocurrido un error. " . utf8_encode($cotizacion->getStrError()).");");
		}
	
		return $r;
	}
	$xajax->registerFunction("actualizarRangoCliente");
	
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
	
	
// 	echo clsUtilerias::formatoFecha("2018-02-19");

	// $listaEstatus = "";
	
	// if(Permisos::userIsThisRol(Permisos::$rol_CXC))
	// {
	// 	$listaEstatus .= "<option value='CAPTURADOAUTORIZADO'>CAPTURADO Y AUTORIZADO</option>";	
	// }
	
	// $listaEstatus .= "<option value='CAPTURADO'>CAPTURADO</option>";
	// $listaEstatus .= "<option value='AUTORIZADO'>AUTORIZADO</option>";
	// $listaEstatus .= "<option value='PRODUCCION'>PRODUCCION</option>";
	// $listaEstatus .= "<option value='TERMINADO'>TERMINADO</option>";
	// $listaEstatus .= "<option value='ENTREGADO'>ENTREGADO</option>";
	// $listaEstatus .= "<option value='CANCELADO'>CANCELADO</option>";