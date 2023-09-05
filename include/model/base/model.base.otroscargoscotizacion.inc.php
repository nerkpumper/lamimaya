<?php

	class ModeloBaseOtroscargoscotizacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseOtroscargoscotizacion";

		
		var $idOtrosCargosCotizacion=0;
		var $idCotizacion=0;
		var $idotrocargo=0;
		var $cantidadIngreso='0.00';
		var $monto='0.00';

		var $__s=array("idOtrosCargosCotizacion",
                       "idCotizacion",
                       "idotrocargo",
                       "cantidadIngreso",
                       "monto");
				
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

		
		public function setIdOtrosCargosCotizacion($idOtrosCargosCotizacion)
		{
			if($idOtrosCargosCotizacion==0||$idOtrosCargosCotizacion==""||!is_numeric($idOtrosCargosCotizacion)|| (is_string($idOtrosCargosCotizacion)&&!ctype_digit($idOtrosCargosCotizacion)))return $this->setError("Tipo de dato incorrecto para idOtrosCargosCotizacion.");
			$this->idOtrosCargosCotizacion=$idOtrosCargosCotizacion;
			$this->getDatos();
		}
		public function setIdCotizacion($idCotizacion)
		{
			
			$this->idCotizacion=$idCotizacion;
		}
		public function setIdotrocargo($idotrocargo)
		{
			
			$this->idotrocargo=$idotrocargo;
		}
		public function setCantidadIngreso($cantidadIngreso)
		{
			$this->cantidadIngreso=$cantidadIngreso;
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdOtrosCargosCotizacion()
		{
			return $this->idOtrosCargosCotizacion;
		}
		public function getIdCotizacion()
		{
			return $this->idCotizacion;
		}
		public function getIdotrocargo()
		{
			return $this->idotrocargo;
		}
		public function getCantidadIngreso()
		{
			return $this->cantidadIngreso;
		}
		public function getMonto()
		{
			return $this->monto;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idOtrosCargosCotizacion=0;
			$this->idCotizacion=0;
			$this->idotrocargo=0;
			$this->cantidadIngreso='0.00';
			$this->monto='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCotizacion,
				                                              idotrocargo,
				                                              cantidadIngreso,
				                                              monto)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCotizacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idotrocargo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidadIngreso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtroscargoscotizacion::Insertar]");
				
				$this->idOtrosCargosCotizacion=mysqli_insert_id($this->dbLink);
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
	                                              idotrocargo='" . mysqli_real_escape_string($this->dbLink,$this->idotrocargo) . "',
	                                              cantidadIngreso='" . mysqli_real_escape_string($this->dbLink,$this->cantidadIngreso) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "'
					WHERE idOtrosCargosCotizacion=" . $this->idOtrosCargosCotizacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtroscargoscotizacion::Update]");
				
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
				WHERE idOtrosCargosCotizacion=" . mysqli_real_escape_string($this->dbLink,$this->idOtrosCargosCotizacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtroscargoscotizacion::Borrar]");
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
						idOtrosCargosCotizacion,
						idCotizacion,
						idotrocargo,
						cantidadIngreso,
						monto
					FROM " . $this->__tableName . " 
					WHERE idOtrosCargosCotizacion=" . mysqli_real_escape_string($this->dbLink,$this->idOtrosCargosCotizacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseOtroscargoscotizacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idOtrosCargosCotizacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>