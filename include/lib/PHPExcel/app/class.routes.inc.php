<?php

require_once 'class.permisos.inc.php';

class Routes
{	
	var $primero;
	var $segundo;
	var $tercero;
	var $cuarto;
	var $permisos = "00000000";
	
	private static $defaultTemplate = "masterTemplate";
	private static $lstRoutes = NULL;
	
	
	
	public static function addRoute ($module, $template = '', $authRequired = true, $roleAuth = "", $herencia = "")
	{   //echo "Se define route para " . $module . "<br>";
		if (trim($template) == "")
		{
			$template = self::$defaultTemplate;
		}
// 		echo "<br>modulo: ".$module . "  -> roleAuth: ". $roleAuth;
		if (!isset(self::$lstRoutes[$module]))
		{
			self::$lstRoutes[$module] = array("module"       => $module,
					                          "template"     => $template,
					                          "authRequired" => $authRequired,
					                          "roleAuth"     => $roleAuth);
		}
		
		if ($herencia != "")
		{
			$modulos = explode(",", $herencia);
			
			foreach ($modulos as $modulo)
			{
				self::addRoute($module.$modulo, $template, $authRequired, $roleAuth);	
			}
		}
	}
	
	public static function getTemplate($module)
	{
		$template = self::$defaultTemplate . ".inc.php";
		
		if (isset(self::$lstRoutes[$module]))
		{
			$template = self::$lstRoutes[$module]["template"] . ".inc.php";
		}
		
		return $template;
	}
	
	public static function authRequired($module)
	{
		$auth = true;
		//echo "Auth Required = False para: " . $module . "<br>";
		if (isset(self::$lstRoutes[$module]))
		{
			$auth = self::$lstRoutes[$module]["authRequired"];
			//echo "Auth Required = " . self::$lstRoutes[$module]["authRequired"] . " para: " . $module . "<br>";
		}
	
		return $auth;
	}
	
	public static function moduleAllow($module)
	{
		$auth = false;
		
		if ($module == "login") return true;
		
// 		echo "Auth Required = False para: " . $module . "<br>"; 
		if (isset(self::$lstRoutes[$module]))
		{
			if (self::$lstRoutes[$module]["roleAuth"] != "")
			{
				$userRol = Permisos::getRolInBinary();
// 				echo "<br><br>".$userRol."<br><br>";
				
// 				var_dump(self::$lstRoutes[$module]);
// 				echo $userRol . "   -   " . self::$lstPermisosModulos[$modulo] . "   -   " . (self::$lstPermisosModulos[$modulo] & $userRol );
				if ($userRol == Permisos::$rol_ROOT) return true;	
				$auth = ((self::$lstRoutes[$module]["roleAuth"] & $userRol ) == $userRol);
								
// 				echo "<br><br>Auth Required = " . self::$lstRoutes[$module]["roleAuth"] . " para: " . $module . "<br>";
			}		
		}
		
		return $auth;
	}
	
	public function setLugar($lugarActual)
	{
		$this->primero=substr($lugarActual,0,1);
		$this->segundo=substr($lugarActual,1,1);
		$this->tercero=substr($lugarActual,2,1);
		$this->cuarto=substr($lugarActual,3,1);
		$this->permisos=substr($lugarActual,4,8);
		
		if (!$this->permisos)
		{
			$this->permisos = "00000000";
		}		
	}
	public function isPrimero($lugar)
	{
		return $this->primero==substr($lugar, 0,1);
	}
	public function isSegundo($lugar)
	{
		if($this->isPrimero($lugar))
			return $this->segundo==substr($lugar, 1,1);
			return false;
	}
	public function isTercero($lugar)
	{
		if($this->isSegundo($lugar))
			return $this->tercero==substr($lugar, 2,1);
			return false;
	}
	public function isCuarto($lugar)
	{
		if($this->isTercero($lugar))
			return $this->cuarto==substr($lugar, 3,1);
			return false;
	}
	
	public function lugarVisibleForMe()
	{
		$visible = false;
				
		$userRol = Permisos::getRolInBinary();
				//echo $userRol . "   -   " . self::$lstPermisosModulos[$modulo] . "   -   " . (self::$lstPermisosModulos[$modulo] & $userRol );
					
		$visible = (($this->permisos & $userRol ) == $userRol);
		
		return $visible;
		
	}
	
	public function lugarVisible($lugar)
	{
		$visible = false;
// 		echo "<br>validar si es root: " . $lugar;
		$userRol = Permisos::getRolInBinary();
// 		echo "<br>userRol: " . $userRol;
		if ($userRol == Permisos::$rol_ROOT) return true;
		
// 		echo $userRol . "   -   " . self::$lstPermisosModulos[$modulo] . "   -   " . (self::$lstPermisosModulos[$modulo] & $userRol );
		$permisosAux=substr($lugar,4,8);
// 		echo "<br>permisos: " . $permisosAux;
		if (!$permisosAux)
		{
			$permisosAux = "00000000";
		}
			
		$visible = (($permisosAux & $userRol ) == $userRol);
		
		return $visible;
	
	}
}	