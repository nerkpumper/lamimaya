<?php

	class ModeloBaseAplicacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseAplicacion";

		
		var $idAplicacion=0;
		var $nombreAplicacion='0';
		var $estado='ACTIVO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $idUsuarioCrea=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $idUsuarioModifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $idUsuarioBaja=0;

		var $__s=array("idAplicacion",
                       "nombreAplicacion",
                       "estado",
                       "fecha_creacion",
                       "idUsuarioCrea",
                       "fecha_modifica",
                       "idUsuarioModifica",
                       "fecha_baja",
                       "idUsuarioBaja");
				
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

		
		public function setIdAplicacion($idAplicacion)
		{
			if($idAplicacion==0||$idAplicacion==""||!is_numeric($idAplicacion)|| (is_string($idAplicacion)&&!ctype_digit($idAplicacion)))return $this->setError("Tipo de dato incorrecto para idAplicacion.");
			$this->idAplicacion=$idAplicacion;
			$this->getDatos();
		}
		public function setNombreAplicacion($nombreAplicacion)
		{
			
			$this->nombreAplicacion=$nombreAplicacion;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoACTIVO()
		{
			$this->estado='ACTIVO';
		}
		public function setEstadoBAJA()
		{
			$this->estado='BAJA';
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setIdUsuarioCrea($idUsuarioCrea)
		{
			
			$this->idUsuarioCrea=$idUsuarioCrea;
		}
		public function setFecha_modifica($fecha_modifica)
		{
			$this->fecha_modifica=$fecha_modifica;
		}
		public function setIdUsuarioModifica($idUsuarioModifica)
		{
			
			$this->idUsuarioModifica=$idUsuarioModifica;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setIdUsuarioBaja($idUsuarioBaja)
		{
			
			$this->idUsuarioBaja=$idUsuarioBaja;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdAplicacion()
		{
			return $this->idAplicacion;
		}
		public function getNombreAplicacion()
		{
			return $this->nombreAplicacion;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getIdUsuarioCrea()
		{
			return $this->idUsuarioCrea;
		}
		public function getFecha_modifica()
		{
			return $this->fecha_modifica;
		}
		public function getIdUsuarioModifica()
		{
			return $this->idUsuarioModifica;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getIdUsuarioBaja()
		{
			return $this->idUsuarioBaja;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idAplicacion=0;
			$this->nombreAplicacion='0';
			$this->estado='ACTIVO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->idUsuarioCrea=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->idUsuarioModifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->idUsuarioBaja=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombreAplicacion,
				                                              estado,
				                                              fecha_creacion,
				                                              idUsuarioCrea,
				                                              fecha_modifica,
				                                              idUsuarioModifica,
				                                              fecha_baja,
				                                              idUsuarioBaja)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombreAplicacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseAplicacion::Insertar]");
				
				$this->idAplicacion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET nombreAplicacion='" . mysqli_real_escape_string($this->dbLink,$this->nombreAplicacion) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              idUsuarioCrea='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              idUsuarioModifica='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              idUsuarioBaja='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "'
					WHERE idAplicacion=" . $this->idAplicacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseAplicacion::Update]");
				
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
				WHERE idAplicacion=" . mysqli_real_escape_string($this->dbLink,$this->idAplicacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseAplicacion::Borrar]");
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
						idAplicacion,
						nombreAplicacion,
						estado,
						fecha_creacion,
						idUsuarioCrea,
						fecha_modifica,
						idUsuarioModifica,
						fecha_baja,
						idUsuarioBaja
					FROM " . $this->__tableName . " 
					WHERE idAplicacion=" . mysqli_real_escape_string($this->dbLink,$this->idAplicacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseAplicacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idAplicacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>