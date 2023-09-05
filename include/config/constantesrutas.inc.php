<?php



#------------------------------------------------------------------------------------------#

#------------------------------------------LUGAR-------------------------------------------#

#------------------------------------------------------------------------------------------#



define("LUGAR_PERFIL","0000");

define("LUGAR_REGISTROACTIVIDADES","0001");



define("LUGAR_HOME","1000");



/*

 |--------------------------------------------------------------------------

 | Administraci�n

 |--------------------------------------------------------------------------

 | M�dulos para administrar el sistema

 |

 */



define("LUGAR_ADMINISTRACION",                               "2000" . (Permisos::$rol_ADMINISTRADOR |
																		Permisos::$rol_CXCVENTAS		
																		));


define("LUGAR_ADMINISTRACION_USUARIO",                       "2100" . (Permisos::$rol_ADMINISTRADOR));


define("LUGAR_ADMINISTRACION_CONFIGURACION",                 "2200" . (Permisos::$rol_ADMINISTRADOR));


define("LUGAR_ADMINISTRACION_DESCTOSCTES",                   "2300" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINISTRACION_DESCTOPEDIDO",                  "2400" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINISTRACION_DESCTOCOTIZACION",			"2500" . (Permisos::$rol_ADMINISTRADOR));


define("LUGAR_ADMINISTRACION_CREDITOCLIENTES",               "2600" . (Permisos::$rol_ADMINISTRADOR |
																		Permisos::$rol_CXCVENTAS));

define("LUGAR_ADMINISTRACION_CREDITOPROMOTORES",             "2700" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINISTRACION_CATEGORIZARCLIENTES",             "2800" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINNISTRACION_APORTACIONESMENDEZ",             "2900" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINISTRACION_DASHBOARDS",                    "2500" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINISTRACION_DASHBOARDS_MONITORESTATUS",     "2510" . (Permisos::$rol_ADMINISTRADOR));

define("LUGAR_ADMINISTRACION_DASHBOARDS_MONITOREXISTENCIAS", "2520" . (Permisos::$rol_ADMINISTRADOR));



/*

 |--------------------------------------------------------------------------

 | Cat�logos

 |--------------------------------------------------------------------------

 | Maneja los catalogos del sistema

 |

 */



define("LUGAR_CATALOGOS",              "3000" . (Permisos::$rol_ADMINISTRADOR |

		                                        Permisos::$rol_PRODUCCION |

		                                        Permisos::$rol_PROMOTOR |
							
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
   												 Permisos::$rol_CXCVENTAS |
												Permisos::$rol_CXCVIEW |
		                                        Permisos::$rol_PROMOTORPRODUCCION));
						


define("LUGAR_CATALOGOS_MATERIAL",     "3100" . (Permisos::$rol_ADMINISTRADOR |
							Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		                                        Permisos::$rol_PRODUCCION));
							



define("LUGAR_CATALOGOS_PROVEEDOR",    "3200" . (Permisos::$rol_ADMINISTRADOR |
							Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
		                                        Permisos::$rol_PRODUCCION));
							



define("LUGAR_CATALOGOS_TIPOPRODUCTO", "3300" . (Permisos::$rol_ADMINISTRADOR |
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
    											Permisos::$rol_CXCVENTAS |
		                                        Permisos::$rol_PRODUCCION));
							



define("LUGAR_CATALOGOS_APLICACION",   "3400" . (Permisos::$rol_ADMINISTRADOR |

		                                        Permisos::$rol_PRODUCCION));



define("LUGAR_CATALOGOS_CLIENTE",      "3500" . (Permisos::$rol_ADMINISTRADOR |

		                                        Permisos::$rol_VENTAS |

		                                        Permisos::$rol_PROMOTOR |

												Permisos::$rol_PROMOTORPLUSPRODUCCION |					
												Permisos::$rol_CXCVENTAS |

                                                Permisos::$rol_CXCVIEW |

		                                        Permisos::$rol_PROMOTORPRODUCCION));


define("LUGAR_CATALOGOS_REGIMENFISCAL",      "3600" . (Permisos::$rol_ADMINISTRADOR));												





/*

 |--------------------------------------------------------------------------

 | Productos

 |--------------------------------------------------------------------------

 | Informaci�n de los productos que se manejan en Galvamex

 |

 */

define("LUGAR_PRODUCTOS",              "4000" . (Permisos::$rol_ADMINISTRADOR |
						Permisos::$rol_PROMOTORPLUSPRODUCCION |
						Permisos::$rol_PROMOTORPRODUCCION |
						Permisos::$rol_PROMOTOREXTERNO |
    Permisos::$rol_CXCVENTAS |
		                                Permisos::$rol_PRODUCCION));



define("LUGAR_PRODUCTOS_ROLLO",        "4100" . (Permisos::$rol_ADMINISTRADOR |
						Permisos::$rol_PROMOTORPLUSPRODUCCION |
						Permisos::$rol_PROMOTORPRODUCCION |
    					Permisos::$rol_CXCVENTAS |
		                Permisos::$rol_PRODUCCION));



define("LUGAR_PRODUCTOS_PRODUCTO",     "4200" . (Permisos::$rol_ADMINISTRADOR |
							Permisos::$rol_PROMOTORPLUSPRODUCCION |
							Permisos::$rol_PROMOTORPRODUCCION |
							Permisos::$rol_PROMOTOREXTERNO |
   							Permisos::$rol_CXCVENTAS |
		                   Permisos::$rol_PRODUCCION));


define("LUGAR_PRODUCTOS_ROLLOSTRASPASOS",     "4300" . (Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION));


	define("LUGAR_PRODUCTOS_LISTADOTRANSFERENCIAS",     "4400" . (Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION));


	define("LUGAR_PRODUCTOS_TRANSFERENCIAROLLOS",     "4500" . (Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
	Permisos::$rol_PRODUCCION));
	
	define("LUGAR_PRODUCTOS_LISTADOTRANSFERENCIASSTOCK",     "4600" . (Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION));


	define("LUGAR_PRODUCTOS_TRANSFERENCIASTOCK",     "4700" . (Permisos::$rol_ADMINISTRADOR |
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
	Permisos::$rol_PROMOTORPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PRODUCCION));






		/*

		 |--------------------------------------------------------------------------

		 | Precios Dentro de Productos

		 |--------------------------------------------------------------------------

		 | Informaci�n de los Precios

		 |

		 */

		define("LUGAR_PRECIOS",                "4400" . (Permisos::$rol_ADMINISTRADOR));



		define("LUGAR_PRECIOS_TERNIUM",        "4410" . (Permisos::$rol_ADMINISTRADOR));



		define("LUGAR_PRECIOS_IMPORTADOS",     "4420" . (Permisos::$rol_ADMINISTRADOR));









/*

 |--------------------------------------------------------------------------

 | CXC

 |--------------------------------------------------------------------------

 | Cuentas por Cobrar

 |

 */



define("LUGAR_CXC",                 "5000" . (Permisos::$rol_ADMINISTRADOR |
											Permisos::$rol_CXCVENTAS |
											Permisos::$rol_PROMOTORPLUSPRODUCCION |
											Permisos::$rol_PROMOTOR |
											Permisos::$rol_PROMOTORPRODUCCION |
				                        	Permisos::$rol_CXC | 
											Permisos::$rol_CXCVIEW ));

define("LUGAR_CXC_PEDIDOSCLIENTES", "5100" . (Permisos::$rol_ADMINISTRADOR |
												Permisos::$rol_CXCVENTAS |
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
                                                Permisos::$rol_CXCVIEW |
				                              	Permisos::$rol_CXC));

define("LUGAR_CXC_PEDIDOSPROMOTOR", "5200" . (Permisos::$rol_ADMINISTRADOR |
												Permisos::$rol_CXCVENTAS |
                                            	Permisos::$rol_CXCVIEW |
												Permisos::$rol_CXC));

define("LUGAR_CXC_ABONOPEDIDO",     "5300" . (Permisos::$rol_ADMINISTRADOR |
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
												Permisos::$rol_CXCVENTAS |
												Permisos::$rol_CXC | 
												Permisos::$rol_CXCVIEW));

define("LUGAR_CXC_ABONOXRECIBODINERO",     "5310" . (Permisos::$rol_ADMINISTRADOR |
													Permisos::$rol_CXCVENTAS ));												
	
define("LUGAR_CXC_RECIBODINERO",     "5320" . (Permisos::$rol_ADMINISTRADOR |
											   Permisos::$rol_CXCVENTAS |
											   Permisos::$rol_CXCVIEW |
											   Permisos::$rol_CXC ));	

define("LUGAR_CXC_RPTMOVRECIBODINERO",     "5330" . (Permisos::$rol_ADMINISTRADOR |
														Permisos::$rol_CXCVENTAS |
														Permisos::$rol_PROMOTORPLUSPRODUCCION |
														Permisos::$rol_PROMOTOR |
														Permisos::$rol_PROMOTORPRODUCCION |
														Permisos::$rol_CXC | 
														Permisos::$rol_CXCVIEW ));


define("LUGAR_CXC_CANCELARPEDIDO", "5400" . (Permisos::$rol_ADMINISTRADOR |

											  Permisos::$rol_CXC));



define("LUGAR_CXC_PROMOCOMISIONES", "5500" . (Permisos::$rol_ADMINISTRADOR |

											  Permisos::$rol_CXC));											  

								
define("LUGAR_CXC_DASHAUTORIZACIONES", "5A00" . (Permisos::$rol_ADMINISTRADOR |

											  Permisos::$rol_CXC));	

define("LUGAR_CXC_DASHTRACKING", "5B00" . (Permisos::$rol_ADMINISTRADOR |

											  Permisos::$rol_CXC));												  


define("LUGAR_CXC_COMISIONESANTICIPADAS", "5600" . (Permisos::$rol_ADMINISTRADOR |

											  Permisos::$rol_CXC));			


define("LUGAR_CXC_PEDIDOSACEPTAFACTURAR",   "5700" . (Permisos::$rol_ADMINISTRADOR |
    
    Permisos::$rol_CXCVIEW |
    Permisos::$rol_CXC));



define("LUGAR_CXC_PROMOCOMISIONESROOFING", "5800" . (Permisos::$rol_ADMINISTRADOR));



define("LUGAR_CXC_COMISIONESANTICIPADASROOFING", "5900" . (Permisos::$rol_ADMINISTRADOR ));

define("LUGAR_CXC_CORTECAJA", "5A00" . (Permisos::$rol_ADMINISTRADOR |
										Permisos::$rol_CXCVENTAS |
										Permisos::$rol_CXC));



/*

 |--------------------------------------------------------------------------

 | Pedidos

 |--------------------------------------------------------------------------

 | Informaci�n de los Precios

 |

 */

define("LUGAR_VENTAS",                 "6000" . (Permisos::$rol_ADMINISTRADOR |

												Permisos::$rol_PRODUCCION |

												Permisos::$rol_CXC |

												Permisos::$rol_PROMOTOREXTERNO |

												Permisos::$rol_CXCVENTAS |
												
							Permisos::$rol_PROMOTORPLUSPRODUCCION |

                                                Permisos::$rol_CXCVIEW |

		                                        Permisos::$rol_PROMOTOR |

		                                        Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_VENTAS_NUEVOPEDIDO",     "6100" . (Permisos::$rol_ADMINISTRADOR |

		                                        Permisos::$rol_PRODUCCION |
							
							Permisos::$rol_PROMOTORPLUSPRODUCCION |

												Permisos::$rol_PROMOTOR |

												Permisos::$rol_PROMOTOREXTERNO |

												Permisos::$rol_CXCVENTAS |

												Permisos::$rol_CXCVIEW |

		                                        Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_VENTAS_LISTADOPEDIDOS",  "6200" . (Permisos::$rol_ADMINISTRADOR |

		                                        Permisos::$rol_PRODUCCION |
					
												Permisos::$rol_PROMOTORPLUSPRODUCCION |

												Permisos::$rol_CXC |

												Permisos::$rol_CXCVENTAS |

                                                Permisos::$rol_CXCVIEW |

												Permisos::$rol_PROMOTOR |

		                                        Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_VENTAS_DASHBOARDPEDIDOS", "6300" . (Permisos::$rol_ADMINISTRADOR |

												Permisos::$rol_PROMOTORPRODUCCION |

												Permisos::$rol_PROMOTORPLUSPRODUCCION |

    											Permisos::$rol_PRODUCCION ));



define("LUGAR_VENTAS_NUEVACOTIZACION",     "6400" . (Permisos::$rol_ADMINISTRADOR |

    Permisos::$rol_PRODUCCION |

    Permisos::$rol_PROMOTOR |

    Permisos::$rol_CXCVENTAS |
					Permisos::$rol_PROMOTORPLUSPRODUCCION |

	Permisos::$rol_PROMOTORPRODUCCION));

	

define("LUGAR_VENTAS_LISTADOCOTIZACION",  "6500" . (Permisos::$rol_ADMINISTRADOR));






define("LUGAR_VENTAS_FECHACOMPROMISO",  "6600" . (Permisos::$rol_ADMINISTRADOR |
    
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTOR |
    Permisos::$rol_PROMOTORPRODUCCION ));

define("LUGAR_VENTAS_ASIGNARPEDIDO",  "6700" . (Permisos::$rol_ADMINISTRADOR |
    
    
    Permisos::$rol_CXCVENTAS |
    Permisos::$rol_PROMOTORPRODUCCION ));

define("LUGAR_VENTAS_FACTURASFILES",  "6800" . (Permisos::$rol_ADMINISTRADOR |
		Permisos::$rol_PROMOTOR|
    Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
	Permisos::$rol_CXCVIEW |
        Permisos::$rol_PROMOTORPRODUCCION));	

define("LUGAR_PEDIDO_PEDIDOSPORENTREGAR",  "6900" . (Permisos::$rol_ADMINISTRADOR |
Permisos::$rol_PROMOTORPRODUCCION));		

		


/*

 |--------------------------------------------------------------------------

 | Reportes

 |--------------------------------------------------------------------------

 | Informaci�n de los productos que se manejan en Galvamex

 |

 */

define("LUGAR_REPORTES",              "7000" . (Permisos::$rol_ADMINISTRADOR |

		                                       Permisos::$rol_PRODUCCION |
							
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
    											Permisos::$rol_CXCVENTAS |
		                                       	Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_REPORTES_INGRESOROLLOS","7100" . (Permisos::$rol_ADMINISTRADOR |
			
						Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |
 	                                        Permisos::$rol_PRODUCCION));



/*

 |--------------------------------------------------------------------------

 | Consultas

 |--------------------------------------------------------------------------

 | Informaci�n de los productos que se manejan en Galvamex

 |

 */

define("LUGAR_CONSULTAS",              "8000" . (Permisos::$rol_ADMINISTRADOR |
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
    											Permisos::$rol_CXCVENTAS |
		                                        Permisos::$rol_PRODUCCION));



define("LUGAR_CONSULTAS_NOROLLO",      "8100" . (Permisos::$rol_ADMINISTRADOR |
												Permisos::$rol_PROMOTORPLUSPRODUCCION |
    											Permisos::$rol_CXCVENTAS |
		                                        Permisos::$rol_PRODUCCION));



/*

 |--------------------------------------------------------------------------

 | Produccion

 |--------------------------------------------------------------------------

 | PRODUCCION

 |

 */

define("LUGAR_PRODUCCION",                    "9000" . (Permisos::$rol_ADMINISTRADOR |
			
														Permisos::$rol_PROMOTORPLUSPRODUCCION |

														Permisos::$rol_PRODUCCION |

		                                                Permisos::$rol_PRODUCTOR |

														Permisos::$rol_PROMOTORPRODUCCION |

													    Permisos::$rol_CXCVENTAS ));



define("LUGAR_PRODUCCION_REGISTROPRODUCCION", "9100" . (Permisos::$rol_ADMINISTRADOR |

                                                        Permisos::$rol_PRODUCCION |

		                                                Permisos::$rol_PRODUCTOR |
		
								Permisos::$rol_PROMOTORPLUSPRODUCCION |
    Permisos::$rol_CXCVENTAS |

		                                                Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PRODUCCION_DESPACHARPEDIDO",  "9200" . (Permisos::$rol_ADMINISTRADOR |

														Permisos::$rol_PRODUCCION |

														Permisos::$rol_PRODUCTOR |
					
														Permisos::$rol_PROMOTORPLUSPRODUCCION |
														Permisos::$rol_CXCVENTAS |

														Permisos::$rol_PROMOTORPRODUCCION));
														

define("LUGAR_PRODUCCION_DESPACHARPEDIDOOBRA",  "9300" . (Permisos::$rol_ADMINISTRADOR |

														Permisos::$rol_PRODUCCION |

														Permisos::$rol_PRODUCTOR |

														Permisos::$rol_PROMOTORPLUSPRODUCCION |
														Permisos::$rol_CXCVENTAS |

														Permisos::$rol_PROMOTORPRODUCCION));




define("LUGAR_PRODUCCION_VALESALIDAGENERAR",  "9400" . (Permisos::$rol_ADMINISTRADOR |

		                                        Permisos::$rol_PRODUCCION |

												Permisos::$rol_PROMOTORPLUSPRODUCCION |

												Permisos::$rol_PROMOTORPRODUCCION |

												Permisos::$rol_CXCVENTAS));



define("LUGAR_PRODUCCION_PEDIDOSPRODUCCION",  "9500" . (Permisos::$rol_ADMINISTRADOR |

												Permisos::$rol_PROMOTORPLUSPRODUCCION |

												Permisos::$rol_PRODUCCION |

												Permisos::$rol_PRODUCTOR |
												Permisos::$rol_CXCVENTAS |

												Permisos::$rol_PROMOTORPRODUCCION ));

define("LUGAR_PRODUCCION_PEDIDOOTROSCARGOS",  "9600" . (Permisos::$rol_ADMINISTRADOR |

												Permisos::$rol_PROMOTORPLUSPRODUCCION |

												Permisos::$rol_PRODUCCION |

												Permisos::$rol_PRODUCTOR |
												Permisos::$rol_CXCVENTAS |

												Permisos::$rol_PROMOTORPRODUCCION ));												



/*

 |--------------------------------------------------------------------------

 | Rutas

 |--------------------------------------------------------------------------

 | Opciones para las rutas

 |

 */

define("LUGAR_RUTAS",                   "B000" . (Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTORPRODUCCION));

define("LUGAR_RUTAS_VEHICULOS",                   "B100" . (Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTORPRODUCCION));
define("LUGAR_RUTAS_RUTAS",                   "B200" . (Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTORPRODUCCION ));
define("LUGAR_RUTAS_RUTASENVIO",                   "B300" . (Permisos::$rol_ADMINISTRADOR | Permisos::$rol_PROMOTORPRODUCCION ));


/*

 |--------------------------------------------------------------------------

 | Promotor

 |--------------------------------------------------------------------------

 | Opciones para el Promotor

 |

 */

define("LUGAR_PROMOTOR",                   "A000" . (Permisos::$rol_ADMINISTRADOR |

                                                     Permisos::$rol_PROMOTOR |
			
													 Permisos::$rol_PROMOTORPLUSPRODUCCION |
													 
													 Permisos::$rol_CXCVENTAS |
													 Permisos::$rol_CXCVIEW |
    
			                             			Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_AUTORIZAPEDIDOS",   "A100" . (Permisos::$rol_ADMINISTRADOR |

                                                     Permisos::$rol_PROMOTOR |

						     Permisos::$rol_PROMOTORPLUSPRODUCCION |

			                             Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_PEDIDOSCLIENTES",   "A200" . (Permisos::$rol_ADMINISTRADOR |

		                                     Permisos::$rol_PROMOTOR |

											 Permisos::$rol_CXCVENTAS |

						     Permisos::$rol_PROMOTORPLUSPRODUCCION |

	                                             Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_PEDIDOSPROMOTOR",   "A500" . (Permisos::$rol_ADMINISTRADOR |

                                                    Permisos::$rol_PROMOTOR |

													Permisos::$rol_CXCVENTAS |
	
						    Permisos::$rol_PROMOTORPLUSPRODUCCION |

                                                    Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_MOVTOSCXCPEDIDO",   "A400" . (Permisos::$rol_ADMINISTRADOR |

		                                     Permisos::$rol_PROMOTOR |

											 Permisos::$rol_CXCVENTAS |

					             Permisos::$rol_PROMOTORPLUSPRODUCCION |	

		                                     Permisos::$rol_PROMOTORPRODUCCION));











define("LUGAR_PROMOTOR_PEDIDOSAFACTURAR",   "A600" . (Permisos::$rol_ADMINISTRADOR |

						      Permisos::$rol_PROMOTOR |

							  Permisos::$rol_CXCVENTAS |
				
						      Permisos::$rol_PROMOTORPLUSPRODUCCION |	

						      Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_FACTURARPEDIDO",   "A700" . (Permisos::$rol_ADMINISTRADOR |

							Permisos::$rol_PROMOTORPLUSPRODUCCION |

							Permisos::$rol_CXCVENTAS |

							Permisos::$rol_PROMOTOR |

							Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_DASHBOARDPEDIDOS",   "A800" . (Permisos::$rol_ADMINISTRADOR |

							Permisos::$rol_PROMOTOR |
							
							Permisos::$rol_CXCVENTAS |
	
							Permisos::$rol_PROMOTORPLUSPRODUCCION |

							Permisos::$rol_PROMOTORPRODUCCION));



define("LUGAR_PROMOTOR_PERMITEVALESALIDA",   "A900" . (Permisos::$rol_ADMINISTRADOR |

							 Permisos::$rol_PROMOTOR |

							 Permisos::$rol_PROMOTORPLUSPRODUCCION |

   							 Permisos::$rol_PROMOTORPRODUCCION));


define("LUGAR_PROMOTOR_VALESALIDA",   "A900" . (Permisos::$rol_ADMINISTRADOR |
    
    Permisos::$rol_PROMOTOR |
    
	Permisos::$rol_PROMOTORPLUSPRODUCCION |
	
	Permisos::$rol_CXCVENTAS |
	Permisos::$rol_CXCVIEW |
    
    Permisos::$rol_PROMOTORPRODUCCION));






/*

 |--------------------------------------------------------------------------

 | Gastos

 |--------------------------------------------------------------------------

 | Opciones para el Gastos

 |

 */
define("LUGAR_GASTOS",                   "C000" . (Permisos::$rol_ADMINISTRADOR |
													   Permisos::$rol_CXCVENTAS |
										  Permisos::$rol_PROMOTORPLUSPRODUCCION |
										 			     Permisos::$rol_CXCVIEW |
														Permisos::$rol_CXC));



define("LUGAR_GASTOS_GASTOS",   "C100" . (Permisos::$rol_ADMINISTRADOR |
											  Permisos::$rol_CXCVENTAS |
								 Permisos::$rol_PROMOTORPLUSPRODUCCION |
								 				Permisos::$rol_CXCVIEW |
													Permisos::$rol_CXC));
														
