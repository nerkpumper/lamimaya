<?php

	require FOLDER_MODEL_BASE . "model.base.usuario.inc.php";
	require_once FOLDER_MODEL . "model.rol.inc.php";

	class ModeloUsuario extends ModeloBaseUsuario
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseUsuario";
		var $Rol;
		
		private static $__Rol = null;

		var $__ss=array("Rol");
		
		var $__primaryKey="idUsuario";
		var $__tableName="usuario";
		var $__tableEdit="usuarioedit";
		var $__tableDelete="usuariodelete";

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
			$this->Rol=new ModeloRol();
			if($this->idRol!=0)
			{
				$this->Rol->setIdRol($this->idRol);
			}
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public static function getObjSession()
		{
			$objSession = null;
				
			//obtenemos objeto de Session
			if (isset($_SESSION["_lmobjSession"]))
			{
				$objSession = unserialize($_SESSION['_lmobjSession']);
				$objSession->__construct();
			}
				
			return $objSession;
		}
		
		public static function getRol()
		{
			if (self::$__Rol == null)
			{
				self::$__Rol = new ModeloRol();
				
				if (self::getObjSession()->getIdRol() > 0)
				{
						
					self::$__Rol->setIdRol(self::getObjSession()->getIdRol());
				}
			}
			
			return self::$__Rol;
		}
		
		
		
		
		public function getDatos()
		{
			parent::getDatos();
			$this->Rol=new ModeloRol();
			if($this->idRol!=0)
			{
				$this->Rol->setIdRol($this->idRol);				
			}
		
		}

		public function getFullName()
		{
// 			return utf8_encode($this->getNombre() . ' ' . $this->getApellidoPaterno() . ' ' . $this->getApellidoMaterno());
			return $this->getNombre() . ' ' . $this->getApellidoPaterno() . ' ' . $this->getApellidoMaterno();
		}


		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public static function amIRoot()
		{		
			if (self::getObjSession()->getIdRol() == Permisos::$idROOTUSER)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public static function isUsuarioMostrador()
		{
		    $result = true;
		    
		    
		    switch(self::getObjSession()->getIdUsuario())
		    {
		        case 1:
		        case 9:
		        case 18:
		        case 11:
		            $result = true;
		            break;
		        default:
		            $result = false;
		        
		    }
		    
		    return $result;
		}
		
		private function existeEmail($email="")
		{
			if($email=="")
				$email=$this->email;
			if($this->idUsuario==0)
				$query="SELECT count(*) As cuenta FROM usuario WHERE email='" . mysqli_real_escape_string($this->dbLink,$email) . "'";
			else
				$query="SELECT count(*) As cuenta FROM usuario WHERE idUsuario<>" . $this->idUsuario . " AND email='" . mysqli_real_escape_string($this->dbLink,$email) . "'";
				$result=mysqli_query($this->dbLink, $query);
			if(!$result)
			{
				return $this->setSystemError("Ocurrio un error en la cuenta de email.", "[" . $this->_nombreClase . "][" . $query . "][" . mysqli_error($this->dbLink) . "]");				
			}
			$row=mysqli_fetch_assoc($result);
			return $row["cuenta"]>0;
		}
		
		public function getCantidadNotificaciones()
		{
			return "3";
			
		}
		
		public function validarDatos()
		{
			return true;
		}
		
		public function getByBinaryUser($user)
		{
		    try
		    {
		        $SQL="SELECT
						idUsuario,
						username,
						email,
						password,
						salt,
						nombre,
						apellidoPaterno,
						apellidoMaterno,
						estatus,
						idRol,
						rangoComisiones,
						credito,
						usado
					FROM " . $this->__tableName . "
					WHERE username = BINARY '" . mysqli_real_escape_string($this->dbLink,$user) . "'";
		        
		        $result=mysqli_query($this->dbLink,$SQL);
		        if(!$result)
// 		             echo "error en la obtencion";
		            return $this->setSystemError  ("Error en la obtencion de detalles de registro.","[ModeloBaseUsuario::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
		            
		            
		            if(mysqli_num_rows($result)==0)
		            {
		                $this->limpiarPropiedades();
		            }
		            else
		            {
		                $datos=mysqli_fetch_assoc($result);
		                foreach($datos as $k=>$v)
		                {
		                    $campo="" . $k;
		                    $this->$campo=$v;
		                }
		            }
		            return true;
		    }
		    catch (Exception $e)
		    {
		        return $this->setErrorCatch($e);
		    }
		}


	}

