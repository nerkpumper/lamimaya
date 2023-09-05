<?php

	class ModeloBaseUsuario extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseUsuario";

		
		var $idUsuario=0;
		var $username='';
		var $email='';
		var $password='';
		var $salt='';
		var $nombre='';
		var $apellidoPaterno='';
		var $apellidoMaterno='';
		var $estatus='activo';
		var $idRol=0;
		var $img='';
		var $rangoComisiones='BAJO';
		var $cobracomision='NO';
		var $credito='0';
		var $usado='0';
		var $tokendevice='';
		var $idSucursal=0;
		var $remember_token='0';
		var $api_token='0';
		var $whatsapp='';
		var $whatsappStatus='INACTIVO';
		var $wscode='';

		var $__s=array("idUsuario",
                       "username",
                       "email",
                       "password",
                       "salt",
                       "nombre",
                       "apellidoPaterno",
                       "apellidoMaterno",
                       "estatus",
                       "idRol",
                       "img",
                       "rangoComisiones",
                       "cobracomision",
                       "credito",
                       "usado",
                       "tokendevice",
                       "idSucursal",
                       "remember_token",
                       "api_token",
                       "whatsapp",
                       "whatsappStatus",
                       "wscode");
				
		var $__ss=array();

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			global $dbLink;
			if(is_null($dbLink))
			{
				trigger_error("La coneccion a la base de datos no esta establecida.",E_ERROR);
				return;
			}
			$this->dbLink=$dbLink;
			$this->link=$dbLink;
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function setIdUsuario($idUsuario)
		{
			if($idUsuario==0||$idUsuario==""||!is_numeric($idUsuario)|| (is_string($idUsuario)&&!ctype_digit($idUsuario)))return $this->setError("Tipo de dato incorrecto para idUsuario.");
			$this->idUsuario=$idUsuario;
			$this->getDatos();
		}
		public function setUsername($username)
		{
			
			$this->username=$username;
		}
		public function setEmail($email)
		{
			
			$this->email=$email;
		}
		public function setPassword($password)
		{
			$this->password=$password;
		}
		public function setSalt($salt)
		{
			$this->salt=$salt;
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setApellidoPaterno($apellidoPaterno)
		{
			
			$this->apellidoPaterno=$apellidoPaterno;
		}
		public function setApellidoMaterno($apellidoMaterno)
		{
			
			$this->apellidoMaterno=$apellidoMaterno;
		}
		public function setEstatus($estatus)
		{
			
			$this->estatus=$estatus;
		}
		public function setEstatusActivo()
		{
			$this->estatus='activo';
		}
		public function setEstatusSuspendido()
		{
			$this->estatus='suspendido';
		}
		public function setEstatusBaja()
		{
			$this->estatus='baja';
		}
		public function setIdRol($idRol)
		{
			
			$this->idRol=$idRol;
		}
		public function setImg($img)
		{
			
			$this->img=$img;
		}
		public function setRangoComisiones($rangoComisiones)
		{
			
			$this->rangoComisiones=$rangoComisiones;
		}
		public function setRangoComisionesALTO()
		{
			$this->rangoComisiones='ALTO';
		}
		public function setRangoComisionesMEDIO()
		{
			$this->rangoComisiones='MEDIO';
		}
		public function setRangoComisionesBAJO()
		{
			$this->rangoComisiones='BAJO';
		}
		public function setCobracomision($cobracomision)
		{
			
			$this->cobracomision=$cobracomision;
		}
		public function setCobracomisionSI()
		{
			$this->cobracomision='SI';
		}
		public function setCobracomisionNO()
		{
			$this->cobracomision='NO';
		}
		public function setCredito($credito)
		{
			$this->credito=$credito;
		}
		public function setUsado($usado)
		{
			$this->usado=$usado;
		}
		public function setTokendevice($tokendevice)
		{
			
			$this->tokendevice=$tokendevice;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setRemember_token($remember_token)
		{
			
			$this->remember_token=$remember_token;
		}
		public function setApi_token($api_token)
		{
			
			$this->api_token=$api_token;
		}
		public function setWhatsapp($whatsapp)
		{
			
			$this->whatsapp=$whatsapp;
		}
		public function setWhatsappStatus($whatsappStatus)
		{
			
			$this->whatsappStatus=$whatsappStatus;
		}
		public function setWhatsappStatusACTIVO()
		{
			$this->whatsappStatus='ACTIVO';
		}
		public function setWhatsappStatusINACTIVO()
		{
			$this->whatsappStatus='INACTIVO';
		}
		public function setWscode($wscode)
		{
			
			$this->wscode=$wscode;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}
		public function getUsername()
		{
			return $this->username;
		}
		public function getEmail()
		{
			return $this->email;
		}
		public function getPassword()
		{
			return $this->password;
		}
		public function getSalt()
		{
			return $this->salt;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getApellidoPaterno()
		{
			return $this->apellidoPaterno;
		}
		public function getApellidoMaterno()
		{
			return $this->apellidoMaterno;
		}
		public function getEstatus()
		{
			return $this->estatus;
		}
		public function getIdRol()
		{
			return $this->idRol;
		}
		public function getImg()
		{
			return $this->img;
		}
		public function getRangoComisiones()
		{
			return $this->rangoComisiones;
		}
		public function getCobracomision()
		{
			return $this->cobracomision;
		}
		public function getCredito()
		{
			return $this->credito;
		}
		public function getUsado()
		{
			return $this->usado;
		}
		public function getTokendevice()
		{
			return $this->tokendevice;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getRemember_token()
		{
			return $this->remember_token;
		}
		public function getApi_token()
		{
			return $this->api_token;
		}
		public function getWhatsapp()
		{
			return $this->whatsapp;
		}
		public function getWhatsappStatus()
		{
			return $this->whatsappStatus;
		}
		public function getWscode()
		{
			return $this->wscode;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idUsuario=0;
			$this->username='';
			$this->email='';
			$this->password='';
			$this->salt='';
			$this->nombre='';
			$this->apellidoPaterno='';
			$this->apellidoMaterno='';
			$this->estatus='activo';
			$this->idRol=0;
			$this->img='';
			$this->rangoComisiones='BAJO';
			$this->cobracomision='NO';
			$this->credito='0';
			$this->usado='0';
			$this->tokendevice='';
			$this->idSucursal=0;
			$this->remember_token='0';
			$this->api_token='0';
			$this->whatsapp='';
			$this->whatsappStatus='INACTIVO';
			$this->wscode='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (username,
				                                              email,
				                                              password,
				                                              salt,
				                                              nombre,
				                                              apellidoPaterno,
				                                              apellidoMaterno,
				                                              estatus,
				                                              idRol,
				                                              img,
				                                              rangoComisiones,
				                                              cobracomision,
				                                              credito,
				                                              usado,
				                                              tokendevice,
				                                              idSucursal,
				                                              remember_token,
				                                              api_token,
				                                              whatsapp,
				                                              whatsappStatus,
				                                              wscode)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->username) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->password) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->salt) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apellidoPaterno) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apellidoMaterno) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRol) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->img) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoComisiones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cobracomision) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tokendevice) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->remember_token) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->api_token) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->whatsapp) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->whatsappStatus) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->wscode) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuario::Insertar]");
				
				$this->idUsuario=mysqli_insert_id($this->dbLink);
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		protected function Actualizar()
		{
			try
			{
				$SQL="UPDATE " . $this->__tableName . " SET username='" . mysqli_real_escape_string($this->dbLink,$this->username) . "',
	                                              email='" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
	                                              password='" . mysqli_real_escape_string($this->dbLink,$this->password) . "',
	                                              salt='" . mysqli_real_escape_string($this->dbLink,$this->salt) . "',
	                                              nombre='" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
	                                              apellidoPaterno='" . mysqli_real_escape_string($this->dbLink,$this->apellidoPaterno) . "',
	                                              apellidoMaterno='" . mysqli_real_escape_string($this->dbLink,$this->apellidoMaterno) . "',
	                                              estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
	                                              idRol='" . mysqli_real_escape_string($this->dbLink,$this->idRol) . "',
	                                              img='" . mysqli_real_escape_string($this->dbLink,$this->img) . "',
	                                              rangoComisiones='" . mysqli_real_escape_string($this->dbLink,$this->rangoComisiones) . "',
	                                              cobracomision='" . mysqli_real_escape_string($this->dbLink,$this->cobracomision) . "',
	                                              credito='" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
	                                              usado='" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
	                                              tokendevice='" . mysqli_real_escape_string($this->dbLink,$this->tokendevice) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              remember_token='" . mysqli_real_escape_string($this->dbLink,$this->remember_token) . "',
	                                              api_token='" . mysqli_real_escape_string($this->dbLink,$this->api_token) . "',
	                                              whatsapp='" . mysqli_real_escape_string($this->dbLink,$this->whatsapp) . "',
	                                              whatsappStatus='" . mysqli_real_escape_string($this->dbLink,$this->whatsappStatus) . "',
	                                              wscode='" . mysqli_real_escape_string($this->dbLink,$this->wscode) . "'
					WHERE idUsuario=" . $this->idUsuario;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuario::Update]");
				
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function Borrar()
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="DELETE FROM " . $this->__tableName . "
				WHERE idUsuario=" . mysqli_real_escape_string($this->dbLink,$this->idUsuario);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuario::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function getDatos()
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
						img,
						rangoComisiones,
						cobracomision,
						credito,
						usado,
						tokendevice,
						idSucursal,
						remember_token,
						api_token,
						whatsapp,
						whatsappStatus,
						wscode
					FROM " . $this->__tableName . " 
					WHERE idUsuario=" . mysqli_real_escape_string($this->dbLink,$this->idUsuario);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseUsuario::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
		

		
		public function Guardar()
		{
			if(!$this->validarDatos())
				return false;
			if($this->getError())
				return false;
			if($this->idUsuario==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>