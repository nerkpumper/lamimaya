<?php

/*
 |--------------------------------------------------------------------------
 | Permisos
 |--------------------------------------------------------------------------
 |Clase manejadora de permisos
 |  -Controla el acceso a cada una de las p�ginas
 */
class Permisos
{
	#------------------------------------------------------------------------------------------------------#
	#----------------------------------------------Static--------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	 
	public static $idROOTUSER = 1;
	
	//Roles existentes del sistema               "000000000000000000000000"
	public static $rol_ALL                     = "111111111111111111111111";
	public static $rol_ROOT                    = "000000000000000000000001";
	public static $rol_ADMINISTRADOR           = "000000000000000000000010";
	public static $rol_PRODUCCION              = "000000000000000000000100";
	public static $rol_PROMOTOR                = "000000000000000000001000";
	public static $rol_VENTAS                  = "000000000000000000010000";
	public static $rol_CXC                     = "000000000000000000100000";
	public static $rol_CXCVENTAS               = "000000000000000001000000";
	public static $rol_PROMOTORPRODUCCION      = "000000000000000010000000";
	public static $rol_PRODUCTOR               = "000000000000000100000000";
	public static $rol_CXCVIEW                 = "000000000000001000000000";
	public static $rol_PROMOTORPLUSPRODUCCION  = "000000000000010000000000";
	public static $rol_PROMOTOREXTERNO		   = "000000000000100000000000";
	
	//si se agrega alguna compa�ia, ponerla en el orden de los public static anteriores
	private static $lstPermisosModulos = NULL;
	
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
	
	//si se crea un permiso mas (rol), entonces mapearlo aqu�
	public static function getRolInBinary()
	{
		$rol = "000000000000000000000000";
		
		$rolUsuario = ModeloUsuario::getObjSession()->getIdRol();
// 		echo "<br>getRolInBinary() :  " . $rolUsuario;
		switch ($rolUsuario)
		{
			case 1:
				$rol = self::$rol_ROOT ;
				break;
			case 2:
				$rol = self::$rol_ADMINISTRADOR;
				break;
			case 3:
				$rol = self::$rol_PRODUCCION;
				break;					
			case 4:
				$rol = self::$rol_PROMOTOR;
				break;
			case 5:
				$rol = self::$rol_VENTAS;
				break;
			case 6:
				$rol = self::$rol_CXC;
				break;
			case 7:
				$rol = self::$rol_CXCVENTAS;
				break;
			case 8:
				$rol = self::$rol_PROMOTORPRODUCCION;
				break;
			case 9:
				$rol = self::$rol_PRODUCTOR;
				break;
			case 10:
			    $rol = self::$rol_CXCVIEW;
				break;
			case 11:
				$rol = self::$rol_PROMOTORPLUSPRODUCCION;
			break;
			case 12:
				$rol = self::$rol_PROMOTOREXTERNO;
			
		}
		
		return $rol;
	}
	
	public static function userIsThisRol($rol)
	{		
		return ($rol == self::getRolInBinary());
	}
		
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Querys------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	#------------------------------------------------------------------------------------------------------#
	#------------------------------------------------Otras-------------------------------------------------#
	#------------------------------------------------------------------------------------------------------#
	
	private static function addItem($modulo, $permisos = "")
	{
		if (!isset(self::$lstPermisosModulos[$modulo]))
		{
			self::$lstPermisosModulos[$modulo] = $permisos;
		}
				
	}
	
	private static function fillListaPermisos()
	{
		if (count(self::$lstPermisosModulos) == NULL)
		{
			self::$lstPermisosModulos = array();		
				
			//aqu� se agregan los permisos para cada uno de los m�dulos
			//bastar� con poner el nombre del archivo de la carpeta html
			//sin la extensi�n .php
			//posteriormente poner como segundo parametro los permisos
			//se agrega cada usuario concatenado con un pipe |
			//
			//estructura
			//
			//  self::addItem("nombreDelModuloSinPuntoPHP", 
			//	      self::$rol_ROOT <- indica que el ROOT tiene permisos
			//		   | self::$rol_CLIENTE_ADMIN <- si lo descomentamos, entonces tambien el ADMIN esta permitido
			//		   | self::$rol_CLIENTE_USUARIO <- si lo descomentamos, entonces tambien el USER esta permitido
			//		  );
			
			
			/*
			 |--------------------------------------------------------------------------
			 | app
			 |--------------------------------------------------------------------------
			 | 
			 | 
			 */
			
			self::addItem("app",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Clientes
			 |--------------------------------------------------------------------------
			 | Maneja los catalogos de clientes 
			 |
			 */
			
			self::addItem("clientes",
					        self::$rol_ROOT
                          //| self::$rol_CLIENTE_ADMIN
                          //| self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("clientesedit",
					        self::$rol_ROOT
                          //| self::$rol_CLIENTE_ADMIN
                          //| self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("clienteseditdet",
					        self::$rol_ROOT
                          //| self::$rol_CLIENTE_ADMIN
                          //| self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("clienteslista",
					        self::$rol_ROOT
                          //| self::$rol_CLIENTE_ADMIN
                          //| self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Configuracion
			 |--------------------------------------------------------------------------
			 | Catalogos de Energ�a, Subtipo Energ�a y Tipo de Configuraci�n 
			 |
			 */
			
			self::addItem("configuracion",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Creador de consultas
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("consultas",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("consultasedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Daschboards
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("dashboardconsumos",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dashboardestadisticos",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dashboardgeneracion",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dashboardprincipal",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dashboardtarifas",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | M�dulos de dispositivos
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("dispositivos",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosclientes",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
						
			self::addItem("dispositivosconfig",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosconfigeditentrada",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosconfigeditr",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosconfigeditv",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosconfigversionmanager",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivosfile",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
							
			self::addItem("dispositivosfileviewresults",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("dispositivossensores",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
									
			/*
			 |--------------------------------------------------------------------------
			 | index
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("index",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Pantalla de inicio
			 |--------------------------------------------------------------------------
			 | A este m�dulo, todos tienen permiso puesto que aqu� los mandamos
			 | cuando no hay permiso a alg�n otro m�dulo
			 */
			
			self::addItem("inicio",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Lecturas
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("lecturaedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("lecturaorigenes",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			
			/*
			 |--------------------------------------------------------------------------
			 | Creador de reportes
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("reportes",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("reportesedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("reportesview",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Salir
			 |--------------------------------------------------------------------------
			 | Todos deben tener permiso a este m�dulo
			 |
			 */
			
			self::addItem("salir",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			
			/*
			 |--------------------------------------------------------------------------
			 | Manejo de Sensores
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("sensoredit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("sensorlecturas",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("sensorvariables",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Cat�logo de subtipo de energ�a
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("subtipoenergia",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("subtipoenergiaadd",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Cat�logo de tarifas por regi�n
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("tarifaregion",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("tarifaregionedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Time
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("time",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Cat�logo de tipo de configuraci�n
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("tipoconfiguracion",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("tipoconfiguracionadd",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Cat�logo de tipo de energ�a
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("tipoenergia",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("tipoenergiaadd",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Cat�logo de unidad de producci�n
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("unidadproduccion",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("unidadproduccionedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | Cat�logo de Usuarios
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("usuarios",
					        self::$rol_ROOT
                          //| self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
			self::addItem("usuariosedit",
					        self::$rol_ROOT
                          //| self::$rol_CLIENTE_ADMIN
                          //| self::$rol_CLIENTE_USUARIO
					     );
			
			/*
			 |--------------------------------------------------------------------------
			 | variableedit
			 |--------------------------------------------------------------------------
			 |
			 |
			 */
			
			self::addItem("variableedit",
					        self::$rol_ROOT
                          | self::$rol_CLIENTE_ADMIN
                          | self::$rol_CLIENTE_USUARIO
					     );
			
				
				
			
			
		}
	}
	
	//esta funcion nos indica si tiene permiso o no
	//por default, si no encuentra permisos, le niega el acceso
	private static function hasPermisoEnModulo($modulo)
	{
		//por default, si no existe configuraci�n de m�dulo, se deja pasar
		$result = true; 
		
		$userRol = self::getRolInBinary();
		
		if ( $userRol == self::$rol_ROOT || //si es root, tiene acceso a todo				
			 $modulo == "testclass" || //clase de pruebas, probablemente no exista en el proyecto, era local
			 $modulo == "inicio" //como es a donde mandamos a los que no tienen permisos, no se verifica permiso de este m�dulo
			)
		{		
			return true;
		}
	
		self::fillListaPermisos();
		
		if (isset(self::$lstPermisosModulos[$modulo]))
		{
			$userRol = self::getRolInBinary();
			//echo $userRol . "   -   " . self::$lstPermisosModulos[$modulo] . "   -   " . (self::$lstPermisosModulos[$modulo] & $userRol );
			
			$result = ((self::$lstPermisosModulos[$modulo] & $userRol ) == $userRol);
			
		}
		
		return $result;
	}
}