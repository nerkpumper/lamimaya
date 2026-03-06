<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

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
	
//ob_start();	
// 	echo "hola mundito";
//$debug = ob_get_clean();
//$r->mostrarMsgs($debug);

																																																																																																										
		
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
	
	$strTablaListado = "";
	
	$producto = new ModeloViewproductos();
	
// 	$producto->__fillable=array("codigo", "tipoProducto", "aplicacion", "material", "rollo" ,"calibre", "descauto", "shortUnidad" ,"exisPoducto", "apartadoReal", "existenciaReal");
	$producto->__fillable=array("idProducto", "codigo", "tipoProducto", "aplicacion", "material", "rollo" ,"calibre", "sucursal","descauto", "shortUnidad" ,"existencia", "apartado","disponible");
// 	$producto->__fillableHeader=array("Codigo", "Tipo Producto" , "Aplicacion", "Material", "Rollo" ,"Calibre", "Descripcion", "Unidad", "Existencia", "Apartado", "Existencia Real");
	$producto->__fillableHeader=array("ID","Codigo", "Tipo Producto" , "Aplicacion", "Material", "Rollo" ,"Calibre", "Sucursal", "Descripcion", "Unidad", "Existencia Fisica", "Apartado", "Disponible");
// 	$lst = $producto->getAll("idProducto, tp.nombre as tipoproducto, ml.nombreAplicacion, m.nombre as material, REPLACE(r.codigo, '-- NO APLICA --', '-') as rollo, producto.codigo, REPLACE(REPLACE(producto.calibre, '0', '-'),'2-','20') AS calibre, producto.descripcion, producto.producto_unidad_idUnidad, 
// 			          IF(producto.producto_unidad_idUnidad = 4, producto.existencia, '-') as exisPoducto, u.clave as shortUnidad, IF(producto.producto_unidad_idUnidad = 4, producto.apartadoReal, '-') as apartadoReal, IF(producto.producto_unidad_idUnidad = 4, (producto.existencia - producto.apartadoReal), '-')  as existenciaReal ", 
// 			        " inner join tipoproducto as tp on tp.idTipoProducto = producto_tipoProducto_idTipoProducto
// 			          inner join aplicacion as ml on ml.idAplicacion = producto_aplicacion_idAplicacion
// 			          inner join material as m on m.idMaterial = producto_material_idMaterial 
// 			          inner join rollo as r on r.idRollo = producto_rollo_idRollo 
// 			          inner join unidad as u on u.idUnidad = producto_unidad_idUnidad",
// 					" producto.estado = 'ACTIVO'");

// 	$lst = $producto->getAll("idProducto, tipoProducto, aplicacion, material, REPLACE(rollocodigo, '-- NO APLICA --', '-') as rollo, codigo, REPLACE(REPLACE(calibre, '0', '-'),'2-','20') AS calibre, descauto, idUnidad,
// 			          IF(idUnidad = 4, existencia, '-') as exisPoducto, shortUnidad, IF(idUnidad = 4, apartadoReal, '-') as apartadoReal, IF(idUnidad = 4, (existencia - apartadoReal), '-')  as existenciaReal ",
// 			"",
// 			" estado = 'ACTIVO'");

	
	$lst = $producto->getAll("viewproductos.idProducto, idRollo, tipoProducto, aplicacion, material,   
                    REPLACE(rollocodigo, '-- NO APLICA --', '-') as rollo, 
                    codigo, REPLACE(REPLACE(calibre, '0', '-'),'2-','20') AS calibre, sucursal.nombre sucursal,
                    descauto, idUnidad, shortUnidad, IF(idUnidad = 4 OR idUnidad = 1, (inventariosucursal.existencia), '-') as existencia,IF(idUnidad = 4 OR idUnidad = 1, (inventariosucursal.apartado), '-') as apartado, 
                    IF(idUnidad = 4 OR idUnidad = 1, IF ((inventariosucursal.existencia - inventariosucursal.apartado) >= 0 , (inventariosucursal.existencia - inventariosucursal.apartado), 0), '-') as disponible ",
	    "inner join inventariosucursal on inventariosucursal.idproducto = viewproductos.idproducto
inner join sucursal on sucursal.idsucursal = inventariosucursal.idsucursal",
	    " estado = 'ACTIVO'",
	    " idProducto");
	
	
	
	
	
	
	
	
// 	echo $producto->getAllQUERY("idProducto, tp.nombre as tipoproducto, ml.nombreAplicacion, m.nombre as material, REPLACE(r.codigo, '-- NO APLICA --', '-') as rollo, producto.codigo, REPLACE(producto.calibre, '0', '-') AS calibre, producto.descripcion, producto.producto_unidad_idUnidad, IF(producto.producto_unidad_idUnidad = 4, producto.existencia, '-') as exisPoducto, u.clave as shortUnidad, apartado, (existencia - apartadoReal) as existenciaReal ", 
// 			        " inner join tipoproducto as tp on tp.idTipoProducto = producto_tipoProducto_idTipoProducto
// 			          inner join aplicacion as ml on ml.idAplicacion = producto_aplicacion_idAplicacion
// 			          inner join material as m on m.idMaterial = producto_material_idMaterial 
// 			          inner join rollo as r on r.idRollo = producto_rollo_idRollo 
// 			          inner join unidad as u on u.idUnidad = producto_unidad_idUnidad",
// 					" producto.estado = 'ACTIVO'");
	

	
	//$lst = $producto->getAll("idRollo, codigo, m.nombre as  material, calibre, pies, descripcion", "inner join material as m on m.idMaterial = rollo_material_idMaterial ");
	
	
	
	
	$strTablaListado = $producto->getTableHTMLProductos($lst, "tblListado", true, true,"Producto");
	