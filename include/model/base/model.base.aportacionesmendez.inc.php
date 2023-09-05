<?php

	class ModeloBaseAportacionesmendez extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseAportacionesmendez";

		
		var $idAportacionMendez=0;
		var $monto='0';
		var $fecha_capturado='0';
		var $referencia='0';
		var $idUsuario=0;

		var $__s=array("idAportacionMendez",
                       "monto",
                       "fecha_capturado",
                       "referencia",
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

		
		public function setIdAportacionMendez($idAportacionMendez)
		{
			if($idAportacionMendez==0||$idAportacionMendez==""||!is_numeric($idAportacionMendez)|| (is_string($idAportacionMendez)&&!ctype_digit($idAportacionMendez)))return $this->setError("Tipo de dato incorrecto para idAportacionMendez.");
			$this->idAportacionMendez=$idAportacionMendez;
			$this->getDatos();
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setFecha_capturado($fecha_capturado)
		{
			$this->fecha_capturado=$fecha_capturado;
		}
		public function setReferencia($referencia)
		{
			
			$this->referencia=$referencia;
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

		
		public function getIdAportacionMendez()
		{
			return $this->idAportacionMendez;
		}
		public function getMonto()
		{
			return $this->monto;
		}
		public function getFecha_capturado()
		{
			return $this->fecha_capturado;
		}
		public function getReferencia()
		{
			return $this->referencia;
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
			
			$this->idAportacionMendez=0;
			$this->monto='0';
			$this->fecha_capturado='0';
			$this->referencia='0';
			$this->idUsuario=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (monto,
				                                              fecha_capturado,
				                                              referencia,
				                                              idUsuario)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_capturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseAportacionesmendez::Insertar]");
				
				$this->idAportacionMendez=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              fecha_capturado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_capturado) . "',
	                                              referencia='" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
	                                              idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "'
					WHERE idAportacionMendez=" . $this->idAportacionMendez;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseAportacionesmendez::Update]");
				
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
				WHERE idAportacionMendez=" . mysqli_real_escape_string($this->dbLink,$this->idAportacionMendez);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseAportacionesmendez::Borrar]");
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
						idAportacionMendez,
						monto,
						fecha_capturado,
						referencia,
						idUsuario
					FROM " . $this->__tableName . " 
					WHERE idAportacionMendez=" . mysqli_real_escape_string($this->dbLink,$this->idAportacionMendez);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseAportacionesmendez::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idAportacionMendez==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>