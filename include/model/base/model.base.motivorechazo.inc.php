<?php

	class ModeloBaseMotivorechazo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseMotivorechazo";

		
		var $idMotivoRechazo=0;
		var $motivo='0';
		var $descripcion='';
		var $estado='ACTIVO';

		var $__s=array("idMotivoRechazo",
                       "motivo",
                       "descripcion",
                       "estado");
				
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

		
		public function setIdMotivoRechazo($idMotivoRechazo)
		{
			if($idMotivoRechazo==0||$idMotivoRechazo==""||!is_numeric($idMotivoRechazo)|| (is_string($idMotivoRechazo)&&!ctype_digit($idMotivoRechazo)))return $this->setError("Tipo de dato incorrecto para idMotivoRechazo.");
			$this->idMotivoRechazo=$idMotivoRechazo;
			$this->getDatos();
		}
		public function setMotivo($motivo)
		{
			
			$this->motivo=$motivo;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
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

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdMotivoRechazo()
		{
			return $this->idMotivoRechazo;
		}
		public function getMotivo()
		{
			return $this->motivo;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getEstado()
		{
			return $this->estado;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idMotivoRechazo=0;
			$this->motivo='0';
			$this->descripcion='';
			$this->estado='ACTIVO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (motivo,
				                                              descripcion,
				                                              estado)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->motivo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMotivorechazo::Insertar]");
				
				$this->idMotivoRechazo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET motivo='" . mysqli_real_escape_string($this->dbLink,$this->motivo) . "',
	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "'
					WHERE idMotivoRechazo=" . $this->idMotivoRechazo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMotivorechazo::Update]");
				
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
				WHERE idMotivoRechazo=" . mysqli_real_escape_string($this->dbLink,$this->idMotivoRechazo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMotivorechazo::Borrar]");
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
						idMotivoRechazo,
						motivo,
						descripcion,
						estado
					FROM " . $this->__tableName . " 
					WHERE idMotivoRechazo=" . mysqli_real_escape_string($this->dbLink,$this->idMotivoRechazo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseMotivorechazo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idMotivoRechazo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>