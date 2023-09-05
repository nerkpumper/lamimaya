<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.rollo.inc.php";
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
	
// 	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function cargarInformacionRollos()
	{
		$r = new xajaxResponse();
		
		$rollo = new ModeloRollo();
		
		$lst = $rollo->getAll("idRollo, codigo, rollo_material_idMaterial as idMaterial, m.nombre as material, rollo_proveedor_idProveedor as idProveedor, p.nombre as proveedor, calibre, pies, descripcion, observaciones, rollo.estado, existencia, apartado, (if(existencia > 0, (apartado*100)/existencia,0)) as porcentajeapartado  ", 
				              " inner join material as m on m.idmaterial = rollo_material_idmaterial
						        inner join proveedor as p on p.idproveedor = rollo_proveedor_idproveedor",
				              "idrollo > 1 ",
				              "idrollo");
		
		$pushes = "";
		foreach ($lst as $row)
		{
			$pushes .= "
						app.infoRollos.push({
							idRollo: ".$row["idRollo"].",
							codigo: '".$row["codigo"]."',	 
							idMaterial: ".$row["idMaterial"].", 
							material: '".$row["material"]."', 
							idProveedor: ".$row["idProveedor"].", 
							proveedor: '".$row["proveedor"]."', 
							calibre: '".$row["calibre"]."', 
							pies: '".$row["pies"]."', 
							descripcion: '".$row["descripcion"]."', 
							observaciones: '".$row["observaciones"]."', 
							estado: '".$row["estado"]."', 
							existencia: ".$row["existencia"].", 
							apartado: ".$row["apartado"].",
							porcentajeapartado: ".$row["porcentajeapartado"]."
						});
					
					";
		}
		
		$r->script("app.infoRollos.splice(0, app.infoRollos.length); ".$pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarInformacionRollos");
	
	function cargarInformacionProductos()
	{
		$r = new xajaxResponse();
	
		$vp = new ModeloViewproductos();
	
		$lst = $vp->getAll("idProducto, codigo, aplicacion, material, calibre, pies, descripcion, estado, existencia, apartadoReal, (if(existencia > 0, (apartadoReal*100)/existencia,0)) as porcentajeapartado  ",
				"",
				"shortUnidad = 'PZA' ",
				"idProducto");
	
		$pushes = "";
		foreach ($lst as $row)
		{
			$aplicacion = $row["aplicacion"];
			$material = $row["material"];
			
			$aplicacion = str_replace("--NO APLICA--", "-", $aplicacion);
			$aplicacion = str_replace("-- NO APLICA --", "-", $aplicacion);
			
			$material = str_replace("--NO APLICA--", "-", $material);
			$material = str_replace("-- NO APLICA --", "-", $material	);
			
			$pushes .= "
						app.infoProductos.push({
							idProducto: ".$row["idProducto"].",
							codigo: '".$row["codigo"]."',							
							material: '".$material."',							
							aplicacion: '".$aplicacion."',
							calibre: '".$row["calibre"]."',
							pies: '".$row["pies"]."',
							descripcion: '".$row["descripcion"]."',							
							estado: '".$row["estado"]."',
							existencia: ".$row["existencia"].",
							apartado: ".$row["apartadoReal"].",
							porcentajeapartado: ".$row["porcentajeapartado"]."
						});
			
					";
		}
	
		$r->script("app.infoProductos.splice(0, app.infoProductos.length); ".$pushes);
	
		return $r;
	}
	$xajax->registerFunction("cargarInformacionProductos");

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

	