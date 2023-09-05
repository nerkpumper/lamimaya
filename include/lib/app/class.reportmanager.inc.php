<?php

/*
 |--------------------------------------------------------------------------
 | ReportManager
 |--------------------------------------------------------------------------
 |Clase manejadora de listado de reportes
 |  -Controla el acceso a cada uno de los reportes
 */
class ReportManager
{
	#------------------------------------------------------------------------------------------------------#
	#----------------------------------------------Static--------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	private static $lstReportManager = NULL;
	private static $currentNodo = "";

	#------------------------------------------------------------------------------------------------------#
	#----------------------------------------------Propiedades---------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	#------------------------------------------------------------------------------------------------------#
	#--------------------------------------------Inicializacion--------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Setter------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	#------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------Unsetter-----------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Getter------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	public static function getParents()
	{
		return self::$lstReportManager;
	}

	public static function getChildren($parent)
	{
		return self::$lstReportManager[$parent]["children"];
	}

	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Querys------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Otras-------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#

	private static function addNodo($nodo, $nombre, $icon, $permisos = "")
	{
		if (!isset(self::$lstReportManager[$nodo]))
		{
			// 			self::$lstReportManager[$nodo] = $permisos;
			self::$lstReportManager[$nodo] = array(
					"id"       => $nodo,
					"nombre"   => $nombre,
					"icon"     => $icon,
					"permisos" => $permisos,
					"children" => array()
			);
			self::$currentNodo = $nodo;
		}
	}

	private static function addChildren($nodo, $nombre, $icon, $permisos = "")
	{
		if (isset(self::$lstReportManager[self::$currentNodo]))
		{
			if (!isset(self::$lstReportManager[self::$currentNodo]["children"][$nodo]))
			{
				// 			self::$lstReportManager[$nodo] = $permisos;
// 				self::$lstReportManager[self::$currentNodo]["children"][$nodo] = $permisos;
				self::$lstReportManager[self::$currentNodo]["children"][$nodo] = $permisos;
				self::$lstReportManager[self::$currentNodo]["children"][$nodo] = array(
						"id"       => $nodo,
						"nombre"   => $nombre,
						"icon"     => $icon,
						"permisos" => $permisos						
				);
			}
		}
	}

	private static function fillListaReportes()
	{
		if (self::$lstReportManager == NULL)
		{
			self::$lstReportManager = array();
			
			// |-----------------------------------
			// | DIRECCION
			// |-----------------------------------
			
			self::addNodo("rptdir", "Dirección", "fa fa-line-chart",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PRODUCCION );
			
			self::addChildren("rptdirventasanuales", "Ventas (Compras de Clientes agrupado por Promotor)", "fa fa-pie-chart",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdirproduccionanual", "Producción de Rollos Anual", "fa fa-bullseye",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			
			self::addChildren("rptdirinventariomendez", "Inventario Mendez", "fa fa-dropbox",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdirinventariogalvamex", "Inventario Galvamex", "fa fa-dropbox",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
						
			
// 			self::addChildren("rptdirproduccion", "Producci�n de Rollos Anual", "fa fa-bullseye",
// 			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdircobranzaanual", "Cobranza Anual", "fa fa-money",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			
			self::addChildren("rptdirventasvscobranza", "Ventas vs Cobranza Anual", "fa fa-columns",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdirventasxcliente", "Listado Ventas X Cliente", "fa fa-users",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdirrendimientorollo", "Rendimiento de Rollos", "fa fa-level-up",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdirrolloinventario", "Costo Inventario Rollos", "fa fa-cubes",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			self::addChildren("rptdirinvcont", "Inventario para Contabilidad", "fa fa-book",
				Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
				
			self::addChildren("rptdirrollosbyalmacen", "Existencias Rollo por Almacen", "fa fa-book",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTORPRODUCCION | Permisos::$rol_CXCVENTAS |  Permisos::$rol_PRODUCCION  );
			
			self::addChildren("rptkilospagados", "Reporte kilos pagados", "fa fa-money",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR );
			
			
			
			// |-----------------------------------
			// | PRODUCTOS
			// |-----------------------------------
			
			
			self::addNodo("rptproductos", "Productos", "fa fa-barcode",
					Permisos::$rol_ALL);
			
			self::addChildren("rptproductoslistaproductos", "Listado de Productos", "fa fa-barcode",
					Permisos::$rol_ALL);
			
			self::addNodo("rptinventarios", "Inventarios", "fa fa-codepen",
			    Permisos::$rol_ROOT | Permisos::$rol_PROMOTOR | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_VENTAS | Permisos::$rol_PROMOTORPRODUCCION |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PRODUCCION);
				
			self::addChildren("rptinventarioproductostock", "Inventario Productos Stock", "fa fa-th-list",
				Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_VENTAS | Permisos::$rol_PROMOTORPRODUCCION |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PRODUCCION  );
				
				self::addChildren("rptinventarioproductostocksucursales", "Inventario Productos Sucursales", "fa fa-sitemap",
			    Permisos::$rol_ROOT | Permisos::$rol_PROMOTOR |  Permisos::$rol_ADMINISTRADOR | Permisos::$rol_VENTAS | Permisos::$rol_PROMOTORPRODUCCION |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PRODUCCION  );
			
			
			self::addChildren("rptdirrollosbyalmacen", "Existencias Rollo por Almacen", "fa fa-book",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_VENTAS | Permisos::$rol_PROMOTORPRODUCCION |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PRODUCCION  );
			
			
			
			
			self::addNodo("rptctes", "Clientes", "fa fa-users",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION);
			
			self::addChildren("rptctesListado", "Listado de Clientes X Promotor", "fa fa-users",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR |         Permisos::$rol_PROMOTORPLUSPRODUCCION |  Permisos::$rol_PROMOTORPRODUCCION);
			
			
			// |-----------------------------------
			// | VENTAS
			// |-----------------------------------
			
			self::addNodo("rptvtas", "Ventas", "fa fa-shopping-cart",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR | Permisos::$rol_CXC  |         Permisos::$rol_CXCVENTAS |  			Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION);
				
			self::addChildren("rptvtaspromotor", "Listado de Ventas X Promotor", "fa fa-angellist",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR | Permisos::$rol_CXC |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION);

			self::addChildren("rptvtaspromotorcliente", "Ventas X Promotor Agrupadas por Cliente", "fa fa-angellist",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR | Permisos::$rol_CXC |         Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION);
			
			self::addChildren("rptcomisionespromotor", "Comisiones de Promotor", "fa fa-dollar",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR | Permisos::$rol_CXC |         Permisos::$rol_CXCVENTAS |              Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION);
			
			self::addChildren("rptventadiaria", "Venta Hoy", "fa fa-money",
				Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTOR | Permisos::$rol_CXC |         Permisos::$rol_CXCVENTAS |              Permisos::$rol_PROMOTORPLUSPRODUCCION | Permisos::$rol_PROMOTORPRODUCCION);
				
			self::addChildren("rptdescuentos", "Descuento a pedidos", "fa fa-gift",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_CXC );
			
				
			// |-----------------------------------
			// | CXC
			// |-----------------------------------
			
			self::addNodo("rptcxc", "CxC", "fa fa-dollar",
			    Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_CXC  | Permisos::$rol_CXCVENTAS );
			
			self::addChildren("rptcxcventas", "Listado de Pedidos Total/Estado/Surtido", "fa fa-th-list",
				Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_CXC  | Permisos::$rol_CXCVENTAS );
				self::addChildren("rptdisponiblerecibodinero", "Saldo disponible de clientes", "fa fa-money",
				Permisos::$rol_ROOT | Permisos::$rol_ADMINISTRADOR | Permisos::$rol_CXC);
			
			
			return;
				
			self::addNodo("rptcat", "Cat�logos","fa fa-cubes",
					  Permisos::$rol_ROOT
					| Permisos::$rol_ADMINISTRADOR
					| Permisos::$rol_PRODUCCION
					);
				
			self::addChildren("rptcatmateriales", "Materiales", "", Permisos::$rol_ROOT);
			self::addChildren("rptcatproveedores", "Proveedores", "",Permisos::$rol_ROOT);
			self::addChildren("rptcattipoproducto", "Tipos de Producto", "",Permisos::$rol_ROOT);				
			self::addChildren("rptcataplicaciones", "Aplicaciones", "",Permisos::$rol_ROOT);
			self::addChildren("rptcatclientes", "Clientes", "",Permisos::$rol_ROOT);
			
			
			
			
		}
	}

	private function todo()
	{
		self::fillListaReportes();

		print_r(self::$lstReportManager);
	}
	public static function fillLista()
	{
		self::fillListaReportes();
	}
}