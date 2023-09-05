<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";	
	require_once FOLDER_MODEL. "model.otroscargospedido.inc.php";
	
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
		
		
	function cargarPedido($idPedido)
	{
		$r = new xajaxResponse();
		
		$pedido = new ModeloPedido();
		
		$pedido->getPedido($idPedido);
		
		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se pudo cargar información del Pedido.");
			$r->script("app.seleccionarOtroPedido();");
			return $r;			
		}
		
		$datosEstatus = "";
		
		$image = "";
				
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_capturado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_capturado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.capturadoImage = '".$image."';";
		$datosEstatus .= "app.capturadoPor = '".trim($pedido->getPedidoDato("capturadoNombre")." ".$pedido->getPedidoDato("capturadoAPaterno")." ".$pedido->getPedidoDato("capturadoAMaterno"))."';";
		$datosEstatus .= "app.capturadoFecha = '".$pedido->getPedidoDato("fecha_capturado")."';";
		$datosEstatus .= "app.capturaObservacion = '".$pedido->getPedidoDato("observacionCaptura")."';";
		
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_autorizado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_autorizado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.autorizadoImage = '".$image."';";
		$datosEstatus .= "app.autorizadoPor = '".trim($pedido->getPedidoDato("autorizadoNombre")." ".$pedido->getPedidoDato("autorizadoAPaterno")." ".$pedido->getPedidoDato("autorizadoAMaterno"))."';";
		$datosEstatus .= "app.autorizadoFecha = '".$pedido->getPedidoDato("fecha_autorizado")."';";
		$datosEstatus .= "app.autorizadoObservacion = '".$pedido->getPedidoDato("observacionAutoriza")."';";
		
		
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_produccion") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_produccion") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.produccionImage = '".$image."';";
		$datosEstatus .= "app.produccionPor = '".trim($pedido->getPedidoDato("produccionNombre")." ".$pedido->getPedidoDato("produccionAPaterno")." ".$pedido->getPedidoDato("produccionAMaterno"))."';";
		$datosEstatus .= "app.produccionFecha = '".$pedido->getPedidoDato("fecha_produccion")."';";
		
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_terminado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_terminado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.terminadoImage = '".$image."';";
		$datosEstatus .= "app.terminadoPor = '".trim($pedido->getPedidoDato("terminadoNombre")." ".$pedido->getPedidoDato("terminadoAPaterno")." ".$pedido->getPedidoDato("terminadoAMaterno"))."';";
		$datosEstatus .= "app.terminadoFecha = '".$pedido->getPedidoDato("fecha_terminado")."';";
		
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_entregado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_entregado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.entregadoImage = '".$image."';";
		$datosEstatus .= "app.entregadoPor = '".trim($pedido->getPedidoDato("entregadoNombre")." ".$pedido->getPedidoDato("entregadoAPaterno")." ".$pedido->getPedidoDato("entregadoAMaterno"))."';";
		$datosEstatus .= "app.entregadoFecha = '".$pedido->getPedidoDato("fecha_entregado")."';";
		
		if (file_exists ("img/" . $pedido->getPedidoDato("id_usuario_cancelado") . ".jpg" )) {
			$image = "img/" . $pedido->getPedidoDato("id_usuario_cancelado") . ".jpg";
		} else {
			$image = 'img/noimage.png';
		}
		
		$image = URL_BASE.$image;
		$datosEstatus .= "app.canceladoImage = '".$image."';";
		$datosEstatus .= "app.canceladoPor = '".trim($pedido->getPedidoDato("canceladoNombre")." ".$pedido->getPedidoDato("canceladoAPaterno")." ".$pedido->getPedidoDato("canceladoAMaterno"))."';";
		$datosEstatus .= "app.canceladoFecha = '".$pedido->getPedidoDato("fecha_cancelado")."';";
		
		$datosEstatus .= "app.estado = '".$pedido->getPedidoDato("estado")."';";
		
		$datosCliente = "";
		
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
		
		//falta poner una persona
		$datosConsignacion = "";
				
		$datosConsignacion .= "app.personaEntrega = '".$pedido->getPedidoDato("personaEntrega")."';";
		$datosConsignacion .= "app.recogeentrega = '".$pedido->getPedidoDato("recogeentrega")."';";
		$datosConsignacion .= "app.domicilioEntrega = '".$pedido->getPedidoDato("domicilioEntrega")."';";
		$datosConsignacion .= "app.numeroEntrega = '".$pedido->getPedidoDato("numeroEntrega")."';";
		$datosConsignacion .= "app.coloniaEntrega = '".$pedido->getPedidoDato("coloniaEntrega")."';";
		$datosConsignacion .= "app.ciudadEntrega = '".$pedido->getPedidoDato("ciudadEntrega")."';";
		
		
// 		prodescripcion
// 		detpartida
// 		detcantidad
// 		detcantidadreal
// 		detdesarrollo
// 		detdobleces
// 		detpreciounitario
// 		dettipoprecio
// 		dettotal
// 		listo_para_producir

		$productos = "";
		foreach ($pedido->__rsPedidoWDetalle as $row)
		{
		    $desc = "";
		    
		    if ($row["proCodigo"] == "MOL")
		    {
		        $desc = "MOLDURA " . str_replace("ROLLO ", "", $row["rolloMolduraDesc"]);
		    }
		    else
		    {
		        if ($row["proCodigo"] == "MAQ")
		        {
		            $desc = "MAQUILA DE MOLDURA " . str_replace("ROLLO ", "", $row["rolloMolduraDesc"]);
		        }
		        else 
		        {
		            $desc = $row["proDescAuto"];
		        }
		        
		    }
		  
		    
		    
			$productos .= "
					app.productos.push({
						idPedidoDetalle: '".$row["idPedidoDetalle"]."',
						proDescripcion: '".$desc."', 
						detPartida: '".$row["detPartida"]."',
						detPartidaDespachada: '".$row["partidaDespachada"]."',								
						detCantidad: '".$row["detCantidad"]."',
						detCantidadReal: '".$row["detCantidadReal"]."',
						proShortUnidad: '".$row["proShortUnidad"]."',
						detDesarrollo: '".$row["detDesarrollo"]."',
						detDobleces: '".$row["detDobleces"]."',
						detPrecioUnitario: '".$row["detPrecioUnitario"]."',
						detTipoPrecio: '".$row["detTipoPrecio"]."',
						detTotal: '".$row["detTotal"]."',
						listo_para_producir: '".$row["listo_para_producir"]."',
						despachado: '".$row["despachado"]."',
						explotado: '".$row["explotado"]."',
						explotadook: '".$row["explotadook"]."'
					});
					
					";		
			
		}
		
// 		Otros Servicios
        $otrosCargosPushes = "";
		$ocp = new ModeloOtroscargospedido();
		
		$lstOcp = $ocp->getAll("otroscargospedido.monto, oc.descripcion",
		    "inner join otrocargo as oc
                        on oc.idotrocargo = otroscargospedido.idotrocargo",
		    "idpedido = " . $idPedido);
		
		foreach ($lstOcp as $item)
		{
		    $otrosCargosPushes .= "

                        app.otrosServicios.push ({
                                descripcion: '".$item["descripcion"]."',
                                monto: ".$item["monto"]."        
                        });

                    ";
		    
		    
		}
		
		
// 		Fin Otros Servicios
		
		$totales = "";
				
		$totales .= "app.subtotal = '".$pedido->getPedidoDato("subtotal")."';";
		$totales .= "app.descuento = '".$pedido->getPedidoDato("descuento")."';";
		$totales .= "app.total = '".$pedido->getPedidoDato("total")."';";
		
		$views = "";
		
		if (Permisos::userIsThisRol(Permisos::$rol_PRODUCTOR))
		{
			$views .= " app.mostrarEstatus = false; ";
			$views .= " app.verMontos = false; ";
			$views .= " app.verListoProducit = false; ";
			$views .= " app.verDespachado = false; ";
			
		}
		
		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosEstatus . $datosCliente . $datosConsignacion. 
		    " app.productos.splice(0, app.productos.length); app.otrosServicios.splice(0, app.otrosServicios.length);" . $productos . $otrosCargosPushes . $totales . $views);
		
		return $r;
	}	
	$xajax->registerFunction("cargarPedido");
	

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

	