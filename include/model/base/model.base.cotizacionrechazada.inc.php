<?php

	class ModeloBaseCotizacionrechazada extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCotizacionrechazada";

		
		var $idCotizacionRechazada=0;
		var $idCotizacion=0;
		var $idMotivoRechazo=0;
		var $fecha_rechazo='0';

		var $__s=array("idCotizacionRechazada",
                       "idCotizacion",
                       "idMotivoRechazo",
                       "fecha_rechazo");
				
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

		
		public function setIdCotizacionRechazada($idCotizacionRechazada)
		{
			if($idCotizacionRechazada==0||$idCotizacionRechazada==""||!is_numeric($idCotizacionRechazada)|| (is_string($idCotizacionRechazada)&&!ctype_digit($idCotizacionRechazada)))return $this->setError("Tipo de dato incorrecto para idCotizacionRechazada.");
			$this->idCotizacionRechazada=$idCotizacionRechazada;
			$this->getDatos();
		}
		public function setIdCotizacion($idCotizacion)
		{
			
			$this->idCotizacion=$idCotizacion;
		}
		public function setIdMotivoRechazo($idMotivoRechazo)
		{
			
			$this->idMotivoRechazo=$idMotivoRechazo;
		}
		public function setFecha_rechazo($fecha_rechazo)
		{
			$this->fecha_rechazo=$fecha_rechazo;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCotizacionRechazada()
		{
			return $this->idCotizacionRechazada;
		}
		public function getIdCotizacion()
		{
			return $this->idCotizacion;
		}
		public function getIdMotivoRechazo()
		{
			return $this->idMotivoRechazo;
		}
		public function getFecha_rechazo()
		{
			return $this->fecha_rechazo;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCotizacionRechazada=0;
			$this->idCotizacion=0;
			$this->idMotivoRechazo=0;
			$this->fecha_rechazo='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCotizacion,
				                                              idMotivoRechazo,
				                                              fecha_rechazo)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCotizacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idMotivoRechazo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_rechazo) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizacionrechazada::Insertar]");
				
				$this->idCotizacionRechazada=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idCotizacion='" . mysqli_real_escape_string($this->dbLink,$this->idCotizacion) . "',
	                                              idMotivoRechazo='" . mysqli_real_escape_string($this->dbLink,$this->idMotivoRechazo) . "',
	                                              fecha_rechazo='" . mysqli_real_escape_string($this->dbLink,$this->fecha_rechazo) . "'
					WHERE idCotizacionRechazada=" . $this->idCotizacionRechazada;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizacionrechazada::Update]");
				
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
				WHERE idCotizacionRechazada=" . mysqli_real_escape_string($this->dbLink,$this->idCotizacionRechazada);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizacionrechazada::Borrar]");
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
						idCotizacionRechazada,
						idCotizacion,
						idMotivoRechazo,
						fecha_rechazo
					FROM " . $this->__tableName . " 
					WHERE idCotizacionRechazada=" . mysqli_real_escape_string($this->dbLink,$this->idCotizacionRechazada);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCotizacionrechazada::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCotizacionRechazada==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>