<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.material.inc.php";
	require_once FOLDER_MODEL. "model.aplicacion.inc.php";
	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";
	require_once FOLDER_MODEL. "model.unidad.inc.php";
// 	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	
	//$xajax->de decodeUTF8InputOn();
	
//   	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
	
	function obtenerReporte($filtro)
	{
		$r = new xajaxResponse();
		$reserva = 25;
		
		$vp = new ModeloViewproductos();
		
		
		$where = "estado = 'ACTIVO' ";
		
		if ($filtro["tipoProducto"] != "0")
		{
			$where .= ($where != "" ? " AND" : "") . " idTipoProducto = " . $filtro["tipoProducto"];
		}
		
		if ($filtro["aplicacion"] != "0")
		{
			$where .= ($where != "" ? " AND" : "") . " idAplicacion = " . $filtro["aplicacion"];
		}
		
		if ($filtro["material"] != "0")
		{
			$where .= ($where != "" ? " AND" : "") . " idMaterial = " . $filtro["material"];
		}
		
		if ($filtro["unidad"] != "0")
		{
			$where .= ($where != "" ? " AND" : "") . " idUnidad = " . $filtro["unidad"];
		}
		
		
		$semaforo = $filtro["semaforo"];
		
		//getProductosApartadoAutorizados
		
// 		$lst = $vp->getAll("idProducto, codigo, tipoProducto, aplicacion, material, unidad, rolloCalibre, 
// rolloPies, descripcion, existencia, apartado, (existencia - apartado) as existenciaDespuesDespachar",
// 				           "",
// 				           $where,
// 				           "idProducto");


		//(existencia - getProductosApartadoAutorizados(idProducto))
		// se cambia existencia como la existencia menos el apartado real, es decir, sin tomar en cuenta 
		// el estatus del pedido, y sin considerar si se ha explosionado y que este listo para spl_autoload_register
		// 2020 11 05
		$lst = $vp->getAll("idProducto, codigo, tipoProducto, aplicacion, material, unidad, rolloCalibre,
                    rolloPies, descripcion, existencia,getProductosApartadoAutorizados(idProducto) apartado, 
                   (existencia - apartadoReal) as existenciaDespuesDespachar",
		    "",
		    $where,
		    "idProducto");
		
		
		 
		
		$detalle = "";
		foreach ($lst as $row)
		{
			$existenciaDespuesDespachar = $row["existenciaDespuesDespachar"];
			
			$tipoSem = "ALL";
			$imprimir = true;
			
			if ($tipoSem != $semaforo)
			{
				if ($existenciaDespuesDespachar <= 15)
				{
					$tipoSem = "ALERTA";
				}
				else if ($existenciaDespuesDespachar > 15 && $existenciaDespuesDespachar <= $reserva)
				{
					$tipoSem = "ATENCION";
				}
				else
				{
					$tipoSem = "OK";
				}	
			}
			
			if ($tipoSem == $semaforo)
			{
				$detalle .= "<tr>";
					
				$detalle .= "<td>".$row["codigo"]."</td>";
				$detalle .= "<td>".$row["tipoProducto"]."</td>";
				$detalle .= "<td>".$row["aplicacion"]."</td>";
				$detalle .= "<td>".$row["material"]."</td>";
				$detalle .= "<td>".$row["unidad"]."</td>";
				$detalle .= "<td>".$row["rolloCalibre"]."</td>";
				$detalle .= "<td>".$row["rolloPies"]."</td>";
				$detalle .= "<td>".$row["descripcion"]."</td>";
				$detalle .= "<td>".$row["existencia"]."</td>";
				$detalle .= "<td>".$row["apartado"]."</td>";
				$detalle .= "<td>".$row["existenciaDespuesDespachar"]."</td>";
					
					
					
				if ($existenciaDespuesDespachar <= 15)
				{
					$detalle .= "<td><img src='".URL_BASE."img/redled.png' style='width: 24px;'/><span style='display:none;'>ALERTA</span></td>";
				}
				else if ($existenciaDespuesDespachar > 15 && $existenciaDespuesDespachar <= $reserva)
				{
					$detalle .= "<td><img src='".URL_BASE."img/yellowled.png' style='width: 24px;'/><span style='display:none;'>ATENCI&Oacute;N</span></td>";
				}
				else
				{
					$detalle .= "<td><img src='".URL_BASE."img/greenled.png' style='width: 24px;'/><span style='display:none;'>OK</span></td>";
				}
					
					
					
					
					
				$detalle .= "</tr>";
			}
			
			
		}
		
		$r->assign("tblReporteBody", "innerHTML", $detalle);
		
		return $r;
	}	
	$xajax->registerFunction("obtenerReporte");

	

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
	
 	$unidad = new ModeloUnidad();
		
 	$lstUnidades = $unidad->getOptionForSelectOnlyList($unidad->getForSelect("idUnidad", "concat(clave,' - ',descripcion)"));
		
 	$material = new ModeloMaterial();
			
 	$lstMateriales = $material->getOptionForSelect($material->getForSelect("idMaterial", "nombre", "estado = 'ACTIVO'"), "0", "-- TODOS --");
	
	$tipoProducto = new ModeloTipoproducto();
		
	$lstTiposProducto = $tipoProducto->getOptionForSelect($tipoProducto->getForSelect("idTipoProducto", "nombre", "estado = 'ACTIVO'", "1"), "0", "-- TODOS --");
		
 	$aplicacion = new ModeloAplicacion();
	
 	$lstModelosLamina = $aplicacion->getOptionForSelect($aplicacion->getForSelect("idAplicacion", "nombreAplicacion", "estado = 'ACTIVO'"), "0", "-- TODAS --");
	
// 	$rollo = new ModeloRollo();
	
// 	$lstRollos = $rollo->getForSelect("idRollo", "concat(codigo, ' - ', descripcion)");
// 	$lstRollosRollo = $rollo->getForSelect("idRollo", "concat(codigo, ' - ', descripcion)", "idRollo > 1");
	
			
// 	$lstCalibres = array (
// 			              array("value" => "0", "option" => "-- NO APLICA --" ),
// 			              array("value" => "22", "option" => "22" ),
// 			              array("value" => "24", "option" => "24" ),
// 			              array("value" => "26", "option" => "26" ),
// 			              array("value" => "28", "option" => "28" )
// 			            );
	
// 	$lstPies = array (						  
						  
// 			              array("value" => "2", "option" => "2" ),
// 			              array("value" => "3", "option" => "3" ),
// 			              array("value" => "4", "option" => "4" )		
// 	                     );
	
// 	$lstListaPrecio = array (
// 			array("value" => "G", "option" => "Galvamex" ),
// 			array("value" => "I", "option" => "Importados" ),
// 			array("value" => "T", "option" => "Ternium" )			
// 		);
	
		
// 	$disableSelect = false;
	
// 	if (isset($param1))
// 	{
// 		if ($param1 > 0)
// 		{
// 			$disableSelect = true;
// 		}
		
// 	}
		
	