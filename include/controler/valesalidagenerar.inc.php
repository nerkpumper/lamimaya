<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.valesalida.inc.php";
	require_once FOLDER_MODEL. "model.valesalidadetalle.inc.php";

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
			$r->saError("No se ha encontrado informaciï¿½n del Pedido solicitado.");
			$r->script("app.seleccionarOtroPedido();");
			return $r;			
		}
		
		// if ($pedido->getPedidoDato("estado") != "PRODUCCION" && $pedido->getPedidoDato("estado") != "TERMINADO")
		// {
		// 	$r->saInfo("Solo pueden generarse Vales de Salida de los Pedidos que esten en estatus de PRODUCCION. El estatus actual del Pedido es: ". $pedido->getPedidoDato("estado"));
		// 	$r->script("app.seleccionarOtroPedido();");
		// 	return $r;
		// }
		
		
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
		
		$datosCliente .= "app.estado = '".$pedido->getPedidoDato("estado")."';";
		// $datosCliente .= "app.promotorAutorizaValeSalida = '".$pedido->getPedidoDato("generarValeSalida")."';";
		$datosCliente .= "app.promotorAutorizaValeSalida = 'SI';";
		
		
	    
		
		

		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosCliente . "  app.seleccionarPedido = false;	" );
		
		return $r;
	}	
	$xajax->registerFunction("cargarDatosPedido");
	
	function cargarMercanciaSinVale($idPedido)
	{
		$r = new xajaxResponse();
	
		$vsd = new ModeloValesalidadetalle();
				
		$lst = $vsd->getAll(" valesalidadetalle.fecha_despacho, valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto, pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
							 vp.codigo, vp.tipoProducto, vp.aplicacion, vp.material, vp.shortUnidad, vp.calibre, vp.pies, vp.descripcion, pd.molDescMaquila ",
							"inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
                             inner join viewproductos as vp on vp.idProducto = pd.idProducto",
							"valesalidadetalle.idPedido = " . $idPedido . " and idValeSalida = 0",
							"idvalesalidadetalle");
		
		
		
		$mercanciaSinValeSalida = "";
		foreach ($lst as $row)
		{
			$perfil = $row["aplicacion"];
			$material = $row["material"];
			
			$perfil = str_replace("--NO APLICA--","-", $perfil);
			$perfil = str_replace("-- NO APLICA --","-", $perfil);
			
			$material = str_replace("--NO APLICA--","-", $material);
			$material = str_replace("-- NO APLICA --","-", $material);
			
			$calibre = $row["calibre"];
			
  			if ($calibre == "0")
 			{
 				$calibre = "-";
 			}
			
			
			$mercanciaSinValeSalida  .= "					
											
						app.mercanciaSinVale.push ({
								selected:       false,
								fecha_despacho: '".$row["fecha_despacho"]."',
								idValeSalidaDetalle:     ".$row["idValeSalidaDetalle"].",
								cantidad:       '".$row["cantidad"]."',
								idProducto:     ".$row["idProducto"].", 
								mlkg:           '".$row["mlkg"]."',
								m2inml:         '".$row["m2inml"]."',  
								explotarUnidad: '".$row["explotarUnidad"]."', 
								codigo:         '".$row["codigo"]."',
								tipoProducto:   '".$row["tipoProducto"]."',
								aplicacion:     '".$perfil."',
								material:       '".$material."',
								shortUnidad:    '".$row["shortUnidad"]."',
								calibre:        '".$calibre."',
								pies:           ".$row["pies"].",
								descripcion:    '".$row["descripcion"] . " ". $row["molDescMaquila"]."'
							});
					
					";
		}
		
				
		$r->script(" app.mercanciaSinVale.splice(0, app.mercanciaSinVale.length); " . $mercanciaSinValeSalida);
	
		return $r;
	}
	$xajax->registerFunction("cargarMercanciaSinVale");
	
	   
	function cargarSingleValeSalida($idPedido, $idValeSalida)
	{
		$r = new xajaxResponse();
	
		$vsd = new ModeloValesalidadetalle();
		
		$lst = $vsd->getAll(" valesalida.generarValeSalida, valesalida.observacion_aunno, valesalidadetalle.fecha_despacho, valesalidadetalle.idPedido, p.idCliente, concat(c.nombre, ' ', c.apellidos) as nombreCliente , valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto, pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
							 vp.codigo, vp.mlpieza, vp.tipoProducto, vp.aplicacion, vp.material, vp.shortUnidad, vp.calibre, vp.pies, vp.descripcion  ",
				"inner join valesalida on valesalida.idvalesalida = valesalidadetalle.idvalesalida
                inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
                inner join viewproductos as vp on vp.idProducto = pd.idProducto
				inner join pedido as p on p.idpedido = valesalidadetalle.idpedido
				inner join cliente as c on c.idCliente = p.idCliente",
				"valesalidadetalle.idPedido = " . $idPedido . " and valesalidadetalle.idValeSalida = " . $idValeSalida,
				"valesalidadetalle.idvalesalidadetalle");
		
// 		$r->mostrarAviso("bien"); return $r;
		
// 		$r->mostrarAviso($vsd->getAllQUERY(" valesalidadetalle.fecha_despacho, valesalidadetalle.idpedido, p.idCliente, concat(c.nombre, ' ', c.apellidos) as nombreCliente , valesalidadetalle.idValeSalidaDetalle, valesalidadetalle.cantidad, pd.idProducto, pd.cantidad as mlkg, pd.cantidad as m2inml, pd.explotarUnidad,
// 							 vp.codigo, vp.mlpieza, vp.tipoProducto, vp.aplicacion, vp.material, vp.shortUnidad, vp.calibre, vp.pies, vp.descripcion  ",
// 				"inner join pedidodetalle as pd on pd.idPedidoDetalle = valesalidadetalle.idPedidoDetalle
//                 inner join viewproductos as vp on vp.idProducto = pd.idProducto
// 				inner join pedido as p on p.idpedido = valesalidadetalle.idpedido
// 				inner join cliente as c on c.idCliente = p.idCliente",
// 				"valesalidadetalle.idPedido = " . $idPedido . " and idValeSalida = " . $idValeSalida,
// 				"idvalesalidadetalle"));
// 	return $r;
		
	
		$mercanciaValeSalida = "";
		$detalleValeSalida = "";
		$generarValeSalida = "";
		$observacionAunNo = "";
		foreach ($lst as $row)
		{
			$perfil = $row["aplicacion"];
			$material = $row["material"];
				
			$perfil = str_replace("--NO APLICA--","-", $perfil);
			$perfil = str_replace("-- NO APLICA --","-", $perfil);
				
			$material = str_replace("--NO APLICA--","-", $material);
			$material = str_replace("-- NO APLICA --","-", $material);
				
			$calibre = $row["calibre"];
				
			if ($calibre == "0")
			{
				$calibre = "-";
			}
				
				
			$mercanciaValeSalida  .= "
						
						app.mercanciaVale.push ({								
								fecha_despacho: '".$row["fecha_despacho"]."',
								pedido: ".$row["idPedido"].",
								cliente: '".$row["nombreCliente"]."',
								idValeSalidaDetalle:     ".$row["idValeSalidaDetalle"].",
								cantidad:       '".$row["cantidad"]."',
								idProducto:     ".$row["idProducto"].",
								mlkg:           '".$row["mlpieza"]."',
								m2inml:         '".$row["m2inml"]."',
								explotarUnidad: '".$row["explotarUnidad"]."',
								codigo:         '".$row["codigo"]."',
								tipoProducto:   '".$row["tipoProducto"]."',
								aplicacion:     '".$perfil."',
								material:       '".$material."',
								shortUnidad:    '".$row["shortUnidad"]."',
								calibre:        '".$calibre."',
								pies:           ".$row["pies"].",
								descripcion:    '".$row["descripcion"]."'
							});
			
					";
			
// 			$detalleValeSalida .= "
//                     app.valeSalidaDetalle.push ({
//                             piezas: ,
//                             descripcion: '',
//                             total: 1,
//                             unidad: ''        
//                     });
            
//             ";
			
			$generarValeSalida = $row["generarValeSalida"];
			$observacionAunNo = $row["observacion_aunno"];
		}
	
	
// 		$r->script(" app.generarValeSalida = '".$generarValeSalida."'; app.observacionAunNo = '".$observacionAunNo    ."';  
//                      app.mercanciaVale.splice(0, app.mercanciaVale.length); 
//                      app.valeSalidaDetalle.splice(0, app.mercanciaVale.length); " . $mercanciaValeSalida . " " . $detalleValeSalida);
		
		$r->script(" app.generarValeSalida = '".$generarValeSalida."'; app.observacionAunNo = '".$observacionAunNo    ."';
                     app.mercanciaVale.splice(0, app.mercanciaVale.length);" . $mercanciaValeSalida);
	
		return $r;
	}
	$xajax->registerFunction("cargarSingleValeSalida");
	
	function cargarValesSalida($idPedido)
	{
		$r = new xajaxResponse();
	
		$vs = new ModeloValesalida();
	
		$lst = $vs->getAll("idValeSalida, estado", "", "idPedido = " . $idPedido);
	
		
		$vales = "";
		foreach ($lst as $row)
		{				
				
			$estado = $row["estado"];
			
			if ($estado == "CREADO")
			{
				$estado = "POR SALIR";
			}
			
			
			$vales  .= "
						
						app.valesSalida.push({
							idValeSalida: ".$row["idValeSalida"].",
							estado: '".$estado."'
						});
			
					";
		}
	
	
		$r->script(" app.valesSalida.splice(0, app.valesSalida.length); " . $vales);
	
		return $r;
	}
	$xajax->registerFunction("cargarValesSalida");
	
	function generarValeSalida($idPedido, $mercancia)
	{
		$r = new xajaxResponse();
		
		$vale = new ModeloValesalida();
		$blnCommit = true;
		
		$vale->transaccionIniciar();
		
		$vale->setIdPedido($idPedido);
		$vale->setDateAndUser("creado");
		
		$vale->Guardar();
		
		$errores = "";
		
		if ($vale->getError())
		{
			$errores .=mb_convert_encoding("Ocurriï¿½ un error al intentar generar el Vale de Salida\n", 'UTF-8', 'ISO-8859-1');
			$blnCommit = false;
		}

		$idValeSalida = $vale->getIdValeSalida();	
		
		if ($blnCommit)
		{
			foreach ($mercancia as $item)
			{
				if ($item["selected"])
				{
					$vsd = new ModeloValesalidadetalle();
					$vsd->setIdValeSalidaDetalle($item["idValeSalidaDetalle"]);
					
					if ($vsd->getIdValeSalidaDetalle() <= 0)
					{
						$errores .=mb_convert_encoding("Ocurrió un error al intentar generar el Vale de Salida", 'UTF-8', 'ISO-8859-1');
						$blnCommit = false;
						break;
					}
					
					$vsd->setIdValeSalida($idValeSalida);
					
					$vsd->Guardar();
					
					if ($vsd->getError())
					{
						$errores .= mb_convert_encoding("Ocurrió un error al intentar actualizar información de Vale Salida [".$item["idValeSalidaDetalle"]."]\n", 'UTF-8', 'ISO-8859-1');
						$blnCommit = false;
					}
					
				}
			}	
		}		
		
		
		$r->saError($errores);
		
		if ($blnCommit)
		{
			$r->saSuccess("El Vale de Salida se ha generado con ï¿½xito con el folio " . $idValeSalida);
			$r->script("app.mostrarPartidasSinValeSalida(); app.cargarValesSalida();");
			$vale->transaccionCommit();
		}
		else
		{
			$vale->transaccionRollback();
		}
	
		return $r;
	}
	$xajax->registerFunction("generarValeSalida");
	
	

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
