<?php

	class ModeloBaseCambiopreciodobles extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCambiopreciodobles";

		
		var $idCambioPrecioDobles=0;
		var $fecha='';
		var $cambioPrecioDobles_precioXDobles_idPrecioXDobles=0;
		var $dobleces=0;
		var $precioAnterior='0';
		var $precio='0';
		var $idUsuario=0;

		var $__s=array("idCambioPrecioDobles",
                       "fecha",
                       "cambioPrecioDobles_precioXDobles_idPrecioXDobles",
                       "dobleces",
                       "precioAnterior",
                       "precio",
                       "idUsuario");
				
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

		
		public function setIdCambioPrecioDobles($idCambioPrecioDobles)
		{
			if($idCambioPrecioDobles==0||$idCambioPrecioDobles==""||!is_numeric($idCambioPrecioDobles)|| (is_string($idCambioPrecioDobles)&&!ctype_digit($idCambioPrecioDobles)))return $this->setError("Tipo de dato incorrecto para idCambioPrecioDobles.");
			$this->idCambioPrecioDobles=$idCambioPrecioDobles;
			$this->getDatos();
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}
		public function setCambioPrecioDobles_precioXDobles_idPrecioXDobles($cambioPrecioDobles_precioXDobles_idPrecioXDobles)
		{
			
			$this->cambioPrecioDobles_precioXDobles_idPrecioXDobles=$cambioPrecioDobles_precioXDobles_idPrecioXDobles;
		}
		public function setDobleces($dobleces)
		{
			
			$this->dobleces=$dobleces;
		}
		public function setPrecioAnterior($precioAnterior)
		{
			$this->precioAnterior=$precioAnterior;
		}
		public function setPrecio($precio)
		{
			$this->precio=$precio;
		}
		public function setIdUsuario($idUsuario)
		{
			
			$this->idUsuario=$idUsuario;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCambioPrecioDobles()
		{
			return $this->idCambioPrecioDobles;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getCambioPrecioDobles_precioXDobles_idPrecioXDobles()
		{
			return $this->cambioPrecioDobles_precioXDobles_idPrecioXDobles;
		}
		public function getDobleces()
		{
			return $this->dobleces;
		}
		public function getPrecioAnterior()
		{
			return $this->precioAnterior;
		}
		public function getPrecio()
		{
			return $this->precio;
		}
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCambioPrecioDobles=0;
			$this->fecha='';
			$this->cambioPrecioDobles_precioXDobles_idPrecioXDobles=0;
			$this->dobleces=0;
			$this->precioAnterior='0';
			$this->precio='0';
			$this->idUsuario=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (fecha,
				                                              cambioPrecioDobles_precioXDobles_idPrecioXDobles,
				                                              dobleces,
				                                              precioAnterior,
				                                              precio,
				                                              idUsuario)
						VALUES(" . mysqli_real_escape_string($this->dbLink,"now()") . ",
				               '" . mysqli_real_escape_string($this->dbLink,$this->cambioPrecioDobles_precioXDobles_idPrecioXDobles) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->dobleces) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precioAnterior) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCambiopreciodobles::Insertar]");
				
				$this->idCambioPrecioDobles=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              cambioPrecioDobles_precioXDobles_idPrecioXDobles='" . mysqli_real_escape_string($this->dbLink,$this->cambioPrecioDobles_precioXDobles_idPrecioXDobles) . "',
	                                              dobleces='" . mysqli_real_escape_string($this->dbLink,$this->dobleces) . "',
	                                              precioAnterior='" . mysqli_real_escape_string($this->dbLink,$this->precioAnterior) . "',
	                                              precio='" . mysqli_real_escape_string($this->dbLink,$this->precio) . "',
	                                              idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "'
					WHERE idCambioPrecioDobles=" . $this->idCambioPrecioDobles;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCambiopreciodobles::Update]");
				
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
				WHERE idCambioPrecioDobles=" . mysqli_real_escape_string($this->dbLink,$this->idCambioPrecioDobles);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCambiopreciodobles::Borrar]");
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
						idCambioPrecioDobles,
						fecha,
						cambioPrecioDobles_precioXDobles_idPrecioXDobles,
						dobleces,
						precioAnterior,
						precio,
						idUsuario
					FROM " . $this->__tableName . " 
					WHERE idCambioPrecioDobles=" . mysqli_real_escape_string($this->dbLink,$this->idCambioPrecioDobles);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCambiopreciodobles::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCambioPrecioDobles==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>