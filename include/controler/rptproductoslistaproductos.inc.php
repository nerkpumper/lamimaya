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
	require_once FOLDER_MODEL. "model.viewrollos.inc.php";
	require_once FOLDER_MODEL. "model.proveedor.inc.php";
	
	// --------------------------------------------------------------------------------------------------------------	--------#
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

		// $r->starDebug();
		
		$vp = new ModeloViewproductos();
		$vr = new ModeloViewrollos();
		
		
		$where = "estado = 'ACTIVO' ";
		
		if ($filtro["tipoProducto"] != "0" && $filtro["tipoProducto"] != "5")
		{
			$where .= ($where != "" ? " AND" : "") . " idTipoProducto = " . $filtro["tipoProducto"];
		}
		
		if ($filtro["aplicacion"] != "0" && $filtro["tipoProducto"] != "5")
		{
			$where .= ($where != "" ? " AND" : "") . " idAplicacion = " . $filtro["aplicacion"];
		}
		
		if ($filtro["material"] != "0")
		{
			$where .= ($where != "" ? " AND" : "") . " idMaterial = " . $filtro["material"];
		}
		
		if ($filtro["unidad"] != "0" && $filtro["tipoProducto"] != "5")
		{
			$where .= ($where != "" ? " AND" : "") . " idUnidad = " . $filtro["unidad"];
		}
		if ($filtro["proveedor"] != "0")
		{
			$where .= ($where != "" ? " AND" : "") . " idProveedor = " . $filtro["proveedor"];
		}
		
		//(existencia-apartado)as existencia 
		// se cambia existencia como la existencia menos el apartado real, es decir, sin tomar en cuenta 
		// el estatus del pedido, y sin considerar si se ha explosionado y que este listo para spl_autoload_register
		// 2020 11 05
		if ($filtro["tipoProducto"] != "5")
		{
			$lst = $vp->getAll("idProducto, estado, codigo, tipoProducto, aplicacion, material, unidad, rolloCalibre, rolloPies, descripcion, precio1, precio2, precio3, precio4,existencia, (existencia-apartadoReal)as disponible",
							   "",
							   $where,
							   "idProducto");

		}
		else
		{
			$where .= ($where != "" ? " AND" : "") . " idRollo > 1 ";

			$lst = $vr->getAll("idrollo idProducto, estado, codigo, 'ROLLO' tipoProducto, '--' aplicacion, material, 'KG' unidad,
							calibre rolloCalibre, pies rolloPies, descripcion,existencia, totalpreciovta precio1, totalpreciovtar2 precio2, totalpreciovtar3 precio3, totalpreciovtar4 precio4
								, (existencia-apartado) as disponible ",
			"",
			$where,
			"idRollo");

			
		}
						   
										           
		
		$detalle = "";
		foreach ($lst as $row)
		{
			$detalle .= "<tr>";
			
			$detalle .= "<td>".$row["idProducto"]."</td>";
			
			$detalle .= "<td>".$row["codigo"]."</td>";
			$detalle .= "<td>".$row["tipoProducto"]."</td>";
			$detalle .= "<td>".$row["aplicacion"]."</td>";
			$detalle .= "<td>".$row["material"]."</td>";
			$detalle .= "<td>".$row["unidad"]."</td>";
			$detalle .= "<td>".$row["rolloCalibre"]."</td>";
			$detalle .= "<td>".$row["rolloPies"]."</td>";
			$detalle .= "<td>".$row["descripcion"]."</td>";
			$detalle .= "<td>".number_format( $row["existencia"], 2 )."</td>";
			$detalle .= "<td>".number_format( $row["disponible"], 2 )."</td>";
			$detalle .= "<td>".$row["precio1"]."</td>";
			$detalle .= "<td>".$row["precio2"]."</td>";
			$detalle .= "<td>".$row["precio3"]."</td>";
			$detalle .= "<td>".$row["precio4"]."</td>";
			
			$detalle .= "</tr>";
		}
		
		$r->assign("tblReporteBody", "innerHTML", $detalle);
		// $r->endDegug();
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
		
 	$lstUnidades = $unidad->getOptionForSelect($unidad->getForSelect("idUnidad", "concat(clave,' - ',descripcion)", ""), "0", "-- TODAS --");
		
 	$material = new ModeloMaterial();
			
 	$lstMateriales = $material->getOptionForSelect($material->getForSelect("idMaterial", "nombre", "estado = 'ACTIVO'"), "0", "-- TODOS --");
	
	$tipoProducto = new ModeloTipoproducto();
		
	$lstTiposProducto = $tipoProducto->getOptionForSelect($tipoProducto->getForSelect("idTipoProducto", "nombre", "estado = 'ACTIVO'", "1"), "0", "-- TODOS --");
		
 	$aplicacion = new ModeloAplicacion();
	
 	$lstModelosLamina = $aplicacion->getOptionForSelect($aplicacion->getForSelect("idAplicacion", "nombreAplicacion", "estado = 'ACTIVO'"), "0", "-- TODAS --");
	
	 $proveedor = new Modeloproveedor();

	 $lstProveedor = $proveedor->getOptionForSelect($proveedor->getForSelect("idProveedor", "nombre", "estado = 'ACTIVO'"), "0", "-- TOD0S --");

	 
	
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
		
	