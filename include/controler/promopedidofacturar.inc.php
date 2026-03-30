<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
		
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.invzmov.inc.php";
	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.cxc.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";

	
	require_once FOLDER_MODEL. "model.notificacion.inc.php";
	
	require_once FOLDER_MODEL. "model.usocfdi.inc.php";
	require_once FOLDER_MODEL. "model.regimenfiscal.inc.php";


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
			$r->saError("No se pudo cargar informaci�n del Pedido.");
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
		$datosEstatus .= "app.cancelaObservacion = '".$pedido->getPedidoDato("observacionCancela")."';";
		
		$datosEstatus .= "app.estado = '".$pedido->getPedidoDato("estado")."';";
		
		$datosCliente = "";
		
		$datosCliente .="app.idCliente='". $pedido->getPedidoDato("idCliente") ."';";
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
			$productos .= "
					app.productos.push({
						idPedidoDetalle: '".$row["idPedidoDetalle"]."',
						proDescripcion: '".$row["proDescripcion"]."', 
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
		
		$totales = "";
				
		$totales .= "app.subtotal = '".$pedido->getPedidoDato("subtotal")."';";
		$totales .= "app.descuento = '".$pedido->getPedidoDato("descuento")."';";
		$totales .= "app.total = '".$pedido->getPedidoDato("total")."';";
		
		
		if($pedido->getPedidoDato("estado") != "CAPTURADO" &&  $pedido->getPedidoDato("estado") != "AUTORIZADO" && $pedido->getPedidoDato("estado") != "CANCELADO")
		{
			$r->script(" app.estatusIncorrecto = true; ");
		}
		else
		{
			if($pedido->getPedidoDato("estado") == "CANCELADO")
			{
				$r->script(" app.pedidoCancelado = true; ");
			}
			else
			{
				$r->script(" app.puedeCancelarse = true; ");
			}
				
			
		}
		
		$idClienteDatoFacturacion = $pedido->getPedidoDato("idClienteDatosFacturacion");

		$r->script(" app.idClienteDatoFacturacion = ".$idClienteDatoFacturacion. ";");

		
// 		$r->mostrarAviso( $pedido->getPedidoDato("cteUsoCfdi"));
		$r->script(" app.facRazonSocial ='". $pedido->getPedidoDato("cteRazonSocial") ."'; 
					app.facRFC = '".$pedido->getPedidoDato("cteRFC")."';
					app.facDomicilio = '".$pedido->getPedidoDato("cteDomicilioFiscal")."';
					app.facCP = '".$pedido->getPedidoDato("cteCPFiscal")."';
					app.facTelefono = '".$pedido->getPedidoDato("cteTelefonos")."';
					app.facNumero = '".$pedido->getPedidoDato("cteNumeroFiscal")."';
					app.facCiudad = '".$pedido->getPedidoDato("cteCiudadFiscal")."';
					app.facColonia = '".$pedido->getPedidoDato("cteColoniaFiscal")."';
					app.facTelefono = '".$pedido->getPedidoDato("cteTelefonos")."';
					app.facCFDI = ".$pedido->getPedidoDato("cteUsoCfdi").";
					app.facRegimenFiscal = ".$pedido->getPedidoDato("idRegimenFiscal").";
					app.facEmail = '".$pedido->getPedidoDato("cteEMail")."';");
			
	
		$ValidaPedirFactura=true;
		
		if ( $idClienteDatoFacturacion == 0){$ValidaPedirFactura=false;}
		
		
		if ($ValidaPedirFactura)
		{		    
		    $r->script(" app.mostrarSolfactura = true; ");
		    if ($pedido->getPedidoDato("solicitaFactura")=="SI")
		    {
		        $r->script(" app.mostrarSolfactura = false;
                             app.facturaSolicitada='Ya fue solicitada una factura'; ");
		       
		    }
		}
		else
		{
			$r->script(" app.mostrarSolfactura = false;
						app.facturaSolicitada='Necesita seleccionar un RFC';  ");
		}
	
		
		
		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosEstatus . $datosCliente . $datosConsignacion. 
				" app.productos.splice(0, app.productos.length);" . $productos . $totales);
		
		return $r;
	}	
	$xajax->registerFunction("cargarPedido");
	
	
	
	function solicitarFactura($idPedido, $cfdi)
	{
	    
		$r = new xajaxResponse();
// 		$r->starDebug();
		$pedido = new ModeloPedido();
		$noti = new ModeloNotificacion();
		
		$pedido->setIdPedido($idPedido);
		$pedido->getPedido($idPedido);
		
				
		$noti->setIdProvoca($pedido->getPedidoDato("cteIdPromotor"));
		$noti->setIdPara(11);
		$noti->setTema("Solicita Factura");
		$noti->setContenido("Solicita la Factura del pedido No.".$idPedido);
		$noti->setLeidoNO();
		$noti->setBorrarNO();
		$noti->setDateUserCreating();
	
		// $pedido->dumpObj();
		// $pedido->varDump($pedido);
		
		$pedido->transaccionIniciar();
		$blnDoCommit = true;
		
			$pedido->setSolicitaFacturaSI();
			$pedido->setIdUsoCfdi($cfdi);
			$pedido->setDateAndUser("solicitafactura");
			//$pedido->setFecha_solicitafactura(date("Y-m-d H:i:s"));
			
			$pedido->Guardar();
		
			if ($pedido->getError())			   
			{
			    $r->saSuccess($pedido->getStrSystemError());
			    return $r;
				$blnDoCommit = false;
			}
			

		if ($blnDoCommit)
		{
		    $noti->Guardar();
		    
		    if ($noti->getError())
		    {
		        $r->saInfo("Ourri� un error al generar la Notificaci�n");
		    $r->script(" app.mostrarSolfactura=true ;");
		    
		    
		    $pedido->transaccionRollback();
		    return $r;
		    }			
			
			$pedido->transaccionCommit();
						
			NotificationManager::SendNotificationMySelf(NotificationManager::$NOTIFICACIONES_PEDIDO, "Solicita Factura a Pedido " . $pedido->getIdPedido(), "Usted ha solicitado se realice una factura para el Pedido ".$pedido->getIdPedido(), $pedido->getIdPedido(), "");
			NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 21, "Solicita Factura a Pedido " . $pedido->getIdPedido(), "El Promotor ha solicitado se realice una factura para el Pedido ".$pedido->getIdPedido(), $pedido->getIdPedido(), "");
			
			
			
			
			$r->saSuccess("La Factura ha sido solicitada");
			$r->redirect(URL_BASE. "promopedidoafacturar",1);
// 			echo "<br><br>Commit";
		}
		else
		{
			$r->saInfo("No se pudo realizar la solicitud.");
			$r->script(" app.mostrarSolfactura=true;");
			$pedido->transaccionRollback();
// 			echo "<br><br>RollBack";
		}		
// 	$r->endDegug();
		return $r;
	}
	$xajax->registerFunction("solicitarFactura");

	function cambiarIdClienteDatosFacturacion($idPedido, $idClienteDatoFacturacion)
	{
	    
		$r = new xajaxResponse();
// 		$r->starDebug();
		$pedido = new ModeloPedido();
		
		$pedido->setIdPedido($idPedido);
		
		$pedido->setIdClienteDatosFacturacion($idClienteDatoFacturacion);

		$pedido->Guardar();
	
		if ($pedido->getError())			   
		{
			$r->saSuccess($pedido->getStrSystemError());
			
			$r->script(" app.mostrarSolfactura=true;");
			return $r;
		}
		

		$r->script(" setTimeout( function(){  app.cargarDatosPedido(); }, 1000); ");
			
// 	$r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cambiarIdClienteDatosFacturacion");
	
	
	function guardarEdicionFactura($idCliente,$facRazonSocial, 
	    $facDomicilio,
	    $facNumero,
	    $facCP,
	    $facColonia,
	    $facCiudad,
	    $facTelefono,
	    $facEmail,
	    $facRFC,
	    $facCFDI,$idPedido)
	{
	    global $_NOW_;
	    global $objSession;
	    
	  
	    $r = new xajaxResponse();
	    
	    
	    
	    
// 	   $r->starDebug();
	    $cliente = new ModeloCliente();
	    $isInsert = false;
	    $regresar = false;
	   
	    
	    
	    if ($facEmail != "")
	    {        
	       
	        if ($cliente->existeField("email", $facEmail, $idCliente))
	        {
	           
	            $r->script("app.errFacEmail = \"". mb_convert_encoding("Este email ya esta siendo utilizado. Debe especificar uno diferente.", 'UTF-8', 'ISO-8859-1') ."\"; ");
	            $regresar = true;
	        }
	    }
// 	    $r->saSuccess("bien"); return $r;
	    
	    if ($regresar)
	    {
// 	        $r->endDegug();
	        return $r;
	    }
	    
	    if ($idCliente == 0)
	    {
	        $isInsert = true;
	        $cliente->setDateUserCreating();
	    }
	    else
	    {
	        
	        $cliente->setIdCliente($idCliente);	        
	        $cliente->setDateUserUpdating();
	       
	    }
	    

	    $cliente->setFacturableSI();	    
	    $cliente->setRazonsocial($facRazonSocial);
	    $cliente->setRfc($facRFC);
	    $cliente->setDomiciliofiscal($facDomicilio);
	    $cliente->setCodigopostalfiscal($facCP);
	    $cliente->setTelefonos($facTelefono);
	    $cliente->setEmail($facEmail);
	    $cliente->setNumerofiscal($facNumero);
	    $cliente->setColoniafiscal($facColonia);
	    $cliente->setCiudadfiscal($facCiudad);
	    $cliente->setIdUsoCfdi($facCFDI);
	    
	    $cliente->Guardar();
	      
	    
	    if ($cliente->getError())
	    {
	        //$r->saSuccess("El Cliente " );
	        $r->saError($cliente->getStrError() );
	        return $r;
	    }
	    
	    if ($isInsert)
	    {
	        $r->saSuccess("El Cliente se ha almacenado satisfactoriamente. id: " .$cliente->getIdCliente() );
	    //    $r->redirect(URL_BASE . "cliente",1);
	    }
	    else
	    {
	        $r->saSuccess("El Cliente se ha modificado satisfactoriamente." );
	        $r->redirect(URL_BASE . "promopedidofacturar/".$idPedido,1);
	    }
// 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("guardarEdicionFactura");
	
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

	
	$uso = new ModeloUsocfdi();
	
	$lstUsoCFDI = $uso->getForSelect("idUsoCfdi", "concat(clave,' - ',descripcion)", "");

	$rf = new ModeloRegimenFiscal();
	$lstRegimenFiscal = $rf->getForSelect("idRegimenFiscal", "concat(codigo,' - ',descripcion)", "");