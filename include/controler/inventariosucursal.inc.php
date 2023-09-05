<?php


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.viewproductos.inc.php";
require_once FOLDER_MODEL. "model.inventariosucursal.inc.php";

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


$producto = new ModeloInventariosucursal();

// 	$producto->__fillable=array("codigo", "tipoProducto", "aplicacion", "material", "rollo" ,"calibre", "descauto", "shortUnidad" ,"exisPoducto", "apartadoReal", "existenciaReal");
$producto->__fillable=array("Id","Codigo","Descripcion","Sucursal","Proveedor","Existencia","Apartado" );
// 	$producto->__fillableHeader=array("Codigo", "Tipo Producto" , "Aplicacion", "Material", "Rollo" ,"Calibre", "Descripcion", "Unidad", "Existencia", "Apartado", "Existencia Real");
$producto->__fillableHeader=array("id", "Codigo" , "Sucursal","Proveedor", "Existencia","Apartado" );
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


$lst = $producto->getAll("(producto.idProducto)as Id, (producto.codigo) as Codigo,if(producto.isRoofing= 'SI', 'Roofing','otro' )as Proveedor, (producto.descripcion)as Descripcion, (inventariosucursal.existencia)as Existencia, (inventariosucursal.apartado)as Apartado, if(inventariosucursal.idSucursal = 1, 'Torres',' Delta') as Sucursal",
		"INNER JOIN producto on producto.idProducto = inventariosucursal.idProducto",
		" 1 ");


// 	echo  $producto->getAllQUERY("idProducto, idrollo, tipoProducto, aplicacion, material, REPLACE(rollocodigo, '-- NO APLICA --', '-') as rollo, codigo, REPLACE(REPLACE(calibre, '0', '-'),'2-','20') AS calibre, descauto, idUnidad,
// 			           shortUnidad, IF(idUnidad = 4, (existencia), '-')  as existencia,IF(idUnidad = 4, (apartadoReal), '-')  as apartado,  IF(idUnidad = 4, (existencia - apartadoReal), '-')  as disponible ",
// 	    "",
// 	    " estado = 'ACTIVO'");

// 	echo $producto->getAllQUERY("idProducto, tp.nombre as tipoproducto, ml.nombreAplicacion, m.nombre as material, REPLACE(r.codigo, '-- NO APLICA --', '-') as rollo, producto.codigo, REPLACE(producto.calibre, '0', '-') AS calibre, producto.descripcion, producto.producto_unidad_idUnidad, IF(producto.producto_unidad_idUnidad = 4, producto.existencia, '-') as exisPoducto, u.clave as shortUnidad, apartado, (existencia - apartadoReal) as existenciaReal ",
// 			        " inner join tipoproducto as tp on tp.idTipoProducto = producto_tipoProducto_idTipoProducto
// 			          inner join aplicacion as ml on ml.idAplicacion = producto_aplicacion_idAplicacion
// 			          inner join material as m on m.idMaterial = producto_material_idMaterial
// 			          inner join rollo as r on r.idRollo = producto_rollo_idRollo
// 			          inner join unidad as u on u.idUnidad = producto_unidad_idUnidad",
// 					" producto.estado = 'ACTIVO'");



//$lst = $producto->getAll("idRollo, codigo, m.nombre as  material, calibre, pies, descripcion", "inner join material as m on m.idMaterial = rollo_material_idMaterial ");




$strTablaListado1 = $producto->getTableHTMLProductos($lst, "tblListado", false, false,"Producto");