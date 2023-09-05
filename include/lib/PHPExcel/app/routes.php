<?php

/*
 |--------------------------------------------------------------------------
 | Application Routes
 |--------------------------------------------------------------------------
 |
 | Route::add(module, template, authRequired);
 | 
 |     modulo       -> el módulo a rutear
 |     template     -> la plantilla a utilizar
 |                     DEFAULT => masterTemplate
 |     authRequired -> requiere autenticacion?
 |                     DEFAULT => true
 |
 */

require_once 'class.routes.inc.php';

define("EDITAR_BORRAR", "edit,delete");

Routes::addRoute("login", "masterTemplateVoid", false);
Routes::addRoute("404", "masterTemplateVoid", true, Permisos::$rol_ALL);	

Routes::addRoute("index", "", true, Permisos::$rol_ALL);

Routes::addRoute("miperfil", "", true, Permisos::$rol_ALL);
Routes::addRoute("salir", "", true, Permisos::$rol_ALL);

/*
 |--------------------------------------------------------------------------
 | Administración
 |--------------------------------------------------------------------------
 | Módulos para administrar el sistema
 |
 */

Routes::addRoute("usuario", "", true,
		Permisos::$rol_ADMINISTRADOR,
		EDITAR_BORRAR);

Routes::addRoute("configuracion", "", true,
		Permisos::$rol_ADMINISTRADOR);


/*
 |--------------------------------------------------------------------------
 | Catálogos
 |--------------------------------------------------------------------------
 | Maneja los catalogos del sistema
 |
 */

Routes::addRoute("material", "", true, 
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION, 
		EDITAR_BORRAR);

Routes::addRoute("proveedor", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("tipoproducto", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("aplicacion", "", true,		
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("cliente", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_VENTAS |
		Permisos::$rol_PROMOTOR,		
		EDITAR_BORRAR);


/*
 |--------------------------------------------------------------------------
 | Productos
 |--------------------------------------------------------------------------
 | Información de los productos que se manejan en Galvamex
 |
 */

Routes::addRoute("rollo", "", true,		
		Permisos::$rol_ADMINISTRADOR | 
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

//reporte hoja de inspección pdf
Routes::addRoute("rolloinspdf", "masterTemplateVoid", true,		
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION);

//reporte hoja de inspección en excel
Routes::addRoute("rolloinsxls", "masterTemplateVoid", true,		
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION);

//ultimos registros de remision/norollo
Routes::addRoute("rolloremisionlastinsert", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION);

Routes::addRoute("rolloinginv", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION);

Routes::addRoute("producto", "", true,		
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

/*
 |--------------------------------------------------------------------------
 | Precios
 |--------------------------------------------------------------------------
 | Lista de Precios que involucran dobleces
 |
 */

Routes::addRoute("precioimportados", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("precioternium", "", true,
		Permisos::$rol_ADMINISTRADOR);

/*
 |--------------------------------------------------------------------------
 | Pedidos
 |--------------------------------------------------------------------------
 | Pedidos
 |
 */

Routes::addRoute("pedidonuevo", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR);

Routes::addRoute("pedido", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR);

Routes::addRoute("despacharpedido", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR);



//_-----------------------------------------------------------------------------------------------

Routes::addRoute("test", "", true, Permisos::$rol_PROMOTOR);

//temporales
Routes::addRoute("tmppedidoprint", "masterTemplateVoid", true);
Routes::addRoute("testpdf", "masterTemplateVoid", true);
Routes::addRoute("tmppdf", "masterTemplateVoid", true);
Routes::addRoute("tmpexcel", "masterTemplateVoid", true);