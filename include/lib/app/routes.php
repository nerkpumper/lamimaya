<?php

/*
 |--------------------------------------------------------------------------
 | Application Routes
 |--------------------------------------------------------------------------
 |
 | Route::add(module, template, authRequired);
 |
 |     modulo       -> el m�dulo a rutear
 |     template     -> la plantilla a utilizar
 |                     DEFAULT => masterTemplate
 |     authRequired -> requiere autenticacion?
 |                     DEFAULT => true
 |
 */

require_once 'class.routes.inc.php';
require_once 'class.reportmanager.inc.php';

define("EDITAR_BORRAR", "edit,delete");

Routes::addRoute("login", "masterTemplateVoid", false);
Routes::addRoute("404", "masterTemplateVoid", true, Permisos::$rol_ALL);

Routes::addRoute("index", "", true, Permisos::$rol_ALL);

Routes::addRoute("miperfil", "", true, Permisos::$rol_ALL);

Routes::addRoute("notificaciones", "", true, Permisos::$rol_ALL);

Routes::addRoute("reporteador", "", true, Permisos::$rol_ALL);

Routes::addRoute("reporteadorbytabla", "", true, Permisos::$rol_ALL);

Routes::addRoute("rptmanager", "", true, Permisos::$rol_ALL);

Routes::addRoute("rptkilospagados", "", true, Permisos::$rol_ALL);

Routes::addRoute("salir", "", true, Permisos::$rol_ALL);

/*
 |--------------------------------------------------------------------------
 | Administraci�n
 |--------------------------------------------------------------------------
 | M�dulos para administrar el sistema
 |
 */

Routes::addRoute("usuario", "", true,
		Permisos::$rol_ADMINISTRADOR,
		EDITAR_BORRAR);

Routes::addRoute("configuracion", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("adminclientepedidos", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("admindescuentopedido", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("admindescuentocotizacion", "", true,
Permisos::$rol_ADMINISTRADOR);		

Routes::addRoute("dash2", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("adminexistencias", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("admincreditoclientes", "", true,
		Permisos::$rol_ADMINISTRADOR |
    	Permisos::$rol_CXCVENTAS);

Routes::addRoute("admincreditoclientesview", "", true,
		Permisos::$rol_ADMINISTRADOR);		

Routes::addRoute("admincreditopromotores", "", true,
		Permisos::$rol_ADMINISTRADOR);


Routes::addRoute("admintiporangoclientes", "", true,
    Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("aportacionesmendez", "", true,
Permisos::$rol_ADMINISTRADOR);	




/*
 |--------------------------------------------------------------------------
 | Cat�logos
 |--------------------------------------------------------------------------
 | Maneja los catalogos del sistema
 |
 */

Routes::addRoute("material", "", true,
		Permisos::$rol_ADMINISTRADOR |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
    	Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("proveedor", "", true,
		Permisos::$rol_ADMINISTRADOR |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("tipoproducto", "", true,
		Permisos::$rol_ADMINISTRADOR |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("aplicacion", "", true,
		Permisos::$rol_ADMINISTRADOR |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("cliente", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_VENTAS |
		Permisos::$rol_PROMOTOR |
		Permisos::$rol_CXCVENTAS |
        Permisos::$rol_CXCVIEW |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION,
		EDITAR_BORRAR);


/*
 |--------------------------------------------------------------------------
 | Productos
 |--------------------------------------------------------------------------
 | Informaci�n de los productos que se manejan en Galvamex
 |
 */

Routes::addRoute("rollo", "", true,
		Permisos::$rol_ADMINISTRADOR |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
    	Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		"delete");

Routes::addRoute("rollonewedit", "", true,
		Permisos::$rol_ADMINISTRADOR |
    	Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION |
    	Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PRODUCCION);

//lista de remisiones de un rollo
Routes::addRoute("rolloremisiones", "", true,
		Permisos::$rol_ADMINISTRADOR |
   		Permisos::$rol_PROMOTORPLUSPRODUCCION |
   	 	Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

//reporte hoja de inspecci�n pdf
Routes::addRoute("rolloinspdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PRODUCCION);

//reporte hoja de inspecci�n en excel
Routes::addRoute("rolloinsxls", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |
    	Permisos::$rol_PROMOTORPLUSPRODUCCION |
    	Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PRODUCCION);

//ultimos registros de remision/norollo
Routes::addRoute("rolloremisionlastinsert", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PRODUCCION);

Routes::addRoute("rolloinginv", "", true,
		Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PRODUCCION);

Routes::addRoute("producto", "", true,
		Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
	Permisos::$rol_PROMOTORPRODUCCION |
	Permisos::$rol_PROMOTOREXTERNO|
		Permisos::$rol_PRODUCCION,
		"delete");

Routes::addRoute("productonewedit", "", true,
		Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |

		Permisos::$rol_PRODUCCION);

Routes::addRoute("productoinventario", "", true,
		Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PRODUCCION,
		EDITAR_BORRAR);

Routes::addRoute("rollotomadeinventario", "", true,
    Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION,
    EDITAR_BORRAR);

Routes::addRoute("rollotraspaso", "", true,
    Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTORPRODUCCION |
		 Permisos::$rol_PRODUCCION);

Routes::addRoute("rolloingresoinventario", "", true,
    Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION);

	Routes::addRoute("transferenciaslistado", "", true,
    Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS |
		 Permisos::$rol_PRODUCCION);

		 Routes::addRoute("transferenciasrollos", "", true,
    Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS |
		 Permisos::$rol_PRODUCCION);

		 Routes::addRoute("transferenciapdf", "", true,
    Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTORPRODUCCION |
		Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS |
		 Permisos::$rol_PRODUCCION);


		 Routes::addRoute("transferenciaview", "", true,
		 Permisos::$rol_ADMINISTRADOR |
			 Permisos::$rol_PROMOTORPRODUCCION |
			 Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS |
			  Permisos::$rol_PRODUCCION);
	 
	 


		 Routes::addRoute("transferenciasstocklistado", "", true,
		 Permisos::$rol_ADMINISTRADOR |
			 Permisos::$rol_PROMOTORPRODUCCION |
			 Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS |
			  Permisos::$rol_PRODUCCION);
	 
			  Routes::addRoute("transferenciasstock", "", true,
		 Permisos::$rol_ADMINISTRADOR |
			 Permisos::$rol_PROMOTORPRODUCCION |
			 Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS | 
			  Permisos::$rol_PRODUCCION);
	 
			  Routes::addRoute("transferenciastockpdf", "", true,
		 Permisos::$rol_ADMINISTRADOR |
			 Permisos::$rol_PROMOTORPRODUCCION |
			 Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS | 
			  Permisos::$rol_PRODUCCION);

			  Routes::addRoute("transferenciastockview", "", true,
		 Permisos::$rol_ADMINISTRADOR |
			 Permisos::$rol_PROMOTORPRODUCCION |
			 Permisos::$rol_PROMOTORPLUSPRODUCCION |
			 Permisos::$rol_CXCVENTAS | 
			  Permisos::$rol_PRODUCCION);
	 
	 

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
 | CxC
 |--------------------------------------------------------------------------
 | CxC
 |
 */

Routes::addRoute("cxcabonopedido", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC |
								Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_CXCVENTAS | Permisos::$rol_CXCVIEW);

Routes::addRoute("cxcabonorecibodinero", "", true,
Permisos::$rol_ADMINISTRADOR |
Permisos::$rol_CXCVENTAS);	


	
Routes::addRoute("anticipocliente", "", true,
Permisos::$rol_ADMINISTRADOR |
Permisos::$rol_CXCVIEW |
Permisos::$rol_CXCVENTAS |
Permisos::$rol_CXC);

Routes::addRoute("rptmovrecibodinero", "", true,
Permisos::$rol_ADMINISTRADOR |
Permisos::$rol_CXCVIEW |
Permisos::$rol_CXCVENTAS |
Permisos::$rol_PROMOTORPLUSPRODUCCION |
Permisos::$rol_PROMOTOR | 
Permisos::$rol_PROMOTORPRODUCCION |
Permisos::$rol_CXC);
	



Routes::addRoute("cxcclientepedidos", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_PROMOTORPLUSPRODUCCION |
								Permisos::$rol_CXC |
								Permisos::$rol_CXCVENTAS | 
                                Permisos::$rol_CXCVIEW);

Routes::addRoute("cxcpromotorpedidos", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_PROMOTOR | 
								Permisos::$rol_PROMOTORPRODUCCION |
								Permisos::$rol_PROMOTORPLUSPRODUCCION |
								Permisos::$rol_CXC |
								Permisos::$rol_CXCVENTAS | 
                                Permisos::$rol_CXCVIEW);

Routes::addRoute("cancelarpedido", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC
								);


Routes::addRoute("cxccomisionespromotor", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC
								);


Routes::addRoute("cxccomisionesanticipadas", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC
								);

Routes::addRoute("cxcdashpedido", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC
								);				

Routes::addRoute("cxcdashtrackingpedido", "", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC
								);								

Routes::addRoute("pagocomision", "masterTemplateVoid", true,
								Permisos::$rol_ADMINISTRADOR |
								Permisos::$rol_CXC
								);
								
/*
 |--------------------------------------------------------------------------
 | Pedidos
 |--------------------------------------------------------------------------
 | Pedidos
 |
 */


Routes::addRoute("pedido", "", true,
		Permisos::$rol_ALL);

		Routes::addRoute("cotizacion", "", true,
		Permisos::$rol_ALL);

Routes::addRoute("proddashboardpedidos", "", true,
    Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION);




Routes::addRoute("pedidonuevo", "masterTemplatePedido", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR |
		Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("pedidonuevo2", "masterTemplatePedido", true,
		Permisos::$rol_ADMINISTRADOR
		);



// Routes::addRoute("pedidonuevo8", "masterTemplatePedido", true,
//     Permisos::$rol_ADMINISTRADOR|
//     Permisos::$rol_PRODUCCION |
// 	Permisos::$rol_PROMOTOR |
// 	Permisos::$rol_PROMOTOREXTERNO |
//     Permisos::$rol_CXCVENTAS |
//     Permisos::$rol_PROMOTORPLUSPRODUCCION |
//     Permisos::$rol_PROMOTORPRODUCCION);			


Routes::addRoute("pedidoactualizaprecios", "masterTemplate", true,
    Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PRODUCCION |
	Permisos::$rol_PROMOTOR |
	Permisos::$rol_PROMOTOREXTERNO |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_PROMOTORPRODUCCION);				

Routes::addRoute("pedidopdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR |
		Permisos::$rol_CXCVENTAS |
		Permisos::$rol_CXCVIEW |
        Permisos::$rol_CXC |
		Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_CXCVIEW );
		
		Routes::addRoute("cotizacionpdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR |
		Permisos::$rol_CXCVENTAS |
        Permisos::$rol_CXC |
		Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
        Permisos::$rol_CXCVIEW );

Routes::addRoute("pedidodespiece", "masterTemplateVoid", true,
    Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PRODUCCION |
    Permisos::$rol_PROMOTOR |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_CXC |
    Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVIEW );


Routes::addRoute("pedidosend", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PROMOTOR |
		Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("pedidoprintdata", "masterTemplateVoid", true,
    Permisos::$rol_PRODUCCION |         Permisos::$rol_PROMOTORPLUSPRODUCCION |Permisos::$rol_CXCVENTAS | Permisos::$rol_PRODUCTOR );

Routes::addRoute("pedidoproduccion", "masterTemplateVoid", true,
    Permisos::$rol_PRODUCCION | Permisos::$rol_PRODUCTOR |  Permisos::$rol_CXCVENTAS |       Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION );


Routes::addRoute("pedidoproduccionsucursal", "masterTemplateVoid", true,
    Permisos::$rol_PRODUCCION | Permisos::$rol_PRODUCTOR | Permisos::$rol_CXCVENTAS |        Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION );



Routes::addRoute("pedidodetalleview", "", true,
		Permisos::$rol_ALL
		);

Routes::addRoute("pedidoproximoaentrega", "", true,
Permisos::$rol_ADMINISTRADOR|
Permisos::$rol_PROMOTORPRODUCCION);


Routes::addRoute("registroproduccion", "", true,
    Permisos::$rol_ADMINISTRADOR
		);
		
Routes::addRoute("registroproduccionsucursal", "", true,
		Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PRODUCCION |
    Permisos::$rol_PRODUCTOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("registroproduccionprint", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PRODUCTOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("despacharpedido", "", true,
		Permisos::$rol_ADMINISTRADOR);

Routes::addRoute("despacharpedidosucursal", "", true,
    Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PRODUCCION |
    Permisos::$rol_PRODUCTOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("pedidoobra", "", true,
    Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PRODUCCION |
    Permisos::$rol_PRODUCTOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("valesalidagenerar", "", true,
		Permisos::$rol_ADMINISTRADOR);
		
	Routes::addRoute("valesalidagenerarsucursal", "", true,
	    Permisos::$rol_ADMINISTRADOR|
	    Permisos::$rol_PRODUCCION |
	    Permisos::$rol_PROMOTORPRODUCCION |
	    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	    Permisos::$rol_CXCVENTAS);
		
		Routes::addRoute("valesalidapdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		    Permisos::$rol_PROMOTORPRODUCCION |
	    Permisos::$rol_CXCVENTAS);		


Routes::addRoute("prodpedido", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PRODUCTOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);

		Routes::addRoute("pedidootroscargos", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
		Permisos::$rol_PRODUCTOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);		



Routes::addRoute("promopedidofechacompromiso", "", true,
    Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTOR 
    ); 


Routes::addRoute("colocarpedido", "", true,
    Permisos::$rol_ADMINISTRADOR|    
    Permisos::$rol_PROMOTORPRODUCCION);



Routes::addRoute("reportenorollos", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("reportenorollosxrollo", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("reportenorollosalmacen", "", true,
		Permisos::$rol_ADMINISTRADOR|
		Permisos::$rol_PRODUCCION |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);

/*
 |--------------------------------------------------------------------------
 | Consultas
 |--------------------------------------------------------------------------
 | Consultas
 |
 */

Routes::addRoute("connorollo", "", true,
		Permisos::$rol_ADMINISTRADOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PRODUCCION);


/*
 |--------------------------------------------------------------------------
 | Promotor
 |--------------------------------------------------------------------------
 | Promotor
 |
 */

Routes::addRoute("prompedxauth", "", true,
		Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("prompedpermitirvale", "", true,
    Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION | 
    Permisos::$rol_ADMINISTRADOR );

Routes::addRoute("promgeneravale", "", true,
    Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
	Permisos::$rol_PROMOTORPRODUCCION |
	Permisos::$rol_CXCVIEW |
    Permisos::$rol_ADMINISTRADOR );



Routes::addRoute("promoclientepedidos", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
        Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("promopromotorpedidos", "", true,
    Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION);






Routes::addRoute("promomovscxcpedido", "", true,
		Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("promopedidoafacturar", "", true,
		Permisos::$rol_PROMOTOR|
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_CXCVENTAS |
        Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("promopedidofacturar", "", true,
		Permisos::$rol_PROMOTOR|
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("promopedidoaceptafacturar", "", true,
    Permisos::$rol_CXC | 
	Permisos::$rol_CXCVENTAS |
	Permisos::$rol_CXCVIEW);

Routes::addRoute("promodashboardpedidos", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
		Permisos::$rol_PROMOTORPRODUCCION);






/*
 |--------------------------------------------------------------------------
 | Asignar rutas
 |--------------------------------------------------------------------------
 | Asignar rutas
 |
 */


Routes::addRoute("vehiculo", "", true,
		Permisos::$rol_ADMINISTRADOR |		
		Permisos::$rol_PROMOTORPRODUCCION, EDITAR_BORRAR);

Routes::addRoute("ruta", "", true,
		Permisos::$rol_ADMINISTRADOR |		
		Permisos::$rol_PROMOTORPRODUCCION, EDITAR_BORRAR);

Routes::addRoute("asignarruta", "", true,
		Permisos::$rol_ADMINISTRADOR |		
		Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("ordenembarquepdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |		
		Permisos::$rol_PROMOTORPRODUCCION);		



/*
 |--------------------------------------------------------------------------
 | Gastos
 |--------------------------------------------------------------------------
 | Gastos
 |
 */		

Routes::addRoute("gastos", "", true,
					Permisos::$rol_ADMINISTRADOR |
					Permisos::$rol_CXCVENTAS |
					Permisos::$rol_PROMOTORPLUSPRODUCCION |
					Permisos::$rol_CXCVIEW |
						Permisos::$rol_CXC);	

/*
 |--------------------------------------------------------------------------
 | Gastos
 |--------------------------------------------------------------------------
 | Gastos
 |
 */		

Routes::addRoute("cortecaja", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_CXCVENTAS |		
		Permisos::$rol_CXC);

Routes::addRoute("cortecajapdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |	
		Permisos::$rol_CXCVENTAS |	
		Permisos::$rol_CXC);

Routes::addRoute("reportedetallecorte", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |	
		Permisos::$rol_CXCVENTAS |	
		Permisos::$rol_CXC);
			




/*
 |--------------------------------------------------------------------------
 | Reportes
 |--------------------------------------------------------------------------
 | Reportes
 |
 */




// Routes::addRoute("colocarpedido", "", true,
//     Permisos::$rol_ADMINISTRADOR);


ReportManager::fillLista();

$lstPadres = ReportManager::getParents();

foreach ($lstPadres as $parent)
{
// 	echo "<br>" . $parent["id"] . " " . $parent["permisos"];
	Routes::addRoute($parent["id"], "", true, $parent["permisos"]);

	$lstChildren = ReportManager::getChildren($parent["id"]);
	// 	ReportManager::getChildren($parent["id"]);

	foreach ($lstChildren as $permiso)
	{
// 		echo "<br>     " . $permiso["id"] ." " . $permiso["permisos"];
		Routes::addRoute($permiso["id"], "", true, $permiso["permisos"]);
	}
}



Routes::addRoute("pedidoaddfactura", "", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
	Permisos::$rol_CXCVIEW |
        Permisos::$rol_PROMOTORPRODUCCION);






//_-----------------------------------------------------------------------------------------------

Routes::addRoute("prompedxauth", "", true, Permisos::$rol_PROMOTOR | Permisos::$rol_PROMOTORPRODUCCION);

Routes::addRoute("dash3", "", true, Permisos::$rol_ROOT);
Routes::addRoute("test", "", true, Permisos::$rol_ALL);
Routes::addRoute("pedidosimulaautorizacionautomatica", "", true, Permisos::$rol_ALL);
Routes::addRoute("testnotemplate", "masterTemplatevoid", true, Permisos::$rol_ALL);


//temporales
Routes::addRoute("tmppedidoprint", "masterTemplateVoid", true);
Routes::addRoute("testpdf", "masterTemplateVoid", true);
Routes::addRoute("tmppdfmdm", "masterTemplateVoid", true);
Routes::addRoute("pppp", "masterTemplateVoid", true);
// Routes::addRoute("pedidopdf", "masterTemplateVoid", true);


// Routes::addRoute("pedidoprint", "masterTemplateVoid", true);

Routes::addRoute("tmppdf", "masterTemplateVoid", true);
Routes::addRoute("tmpexcel", "masterTemplateVoid", true);

Routes::addRoute("recibodineropdf", "masterTemplateVoid", true,
		Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_CXCVIEW |		
		Permisos::$rol_CXC);

Routes::addRoute("runcronexplosion", "masterTemplate", true, Permisos::$rol_ROOT);
Routes::addRoute("runcronapartadosfix", "masterTemplate", true, Permisos::$rol_ROOT);
Routes::addRoute("runcronprocesapedidos", "masterTemplate", true, Permisos::$rol_ROOT);
Routes::addRoute("contactos", "masterTemplate", true, Permisos::$rol_ROOT);