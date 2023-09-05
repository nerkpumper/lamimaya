<?php

	class ModeloBaseObjetivopromotor extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseObjetivopromotor";

		
		var $idObjetivoPromotor=0;
		var $idPromotor=0;
		var $anio=0;
		var $mes=0;
		var $objetivo='0.00';

		var $__s=array("idObjetivoPromotor",
                       "idPromotor",
                       "anio",
                       "mes",
                       "objetivo");
				
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

		
		public function setIdObjetivoPromotor($idObjetivoPromotor)
		{
			if($idObjetivoPromotor==0||$idObjetivoPromotor==""||!is_numeric($idObjetivoPromotor)|| (is_string($idObjetivoPromotor)&&!ctype_digit($idObjetivoPromotor)))return $this->setError("Tipo de dato incorrecto para idObjetivoPromotor.");
			$this->idObjetivoPromotor=$idObjetivoPromotor;
			$this->getDatos();
		}
		public function setIdPromotor($idPromotor)
		{
			
			$this->idPromotor=$idPromotor;
		}
		public function setAnio($anio)
		{
			
			$this->anio=$anio;
		}
		public function setMes($mes)
		{
			
			$this->mes=$mes;
		}
		public function setObjetivo($objetivo)
		{
			$this->objetivo=$objetivo;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdObjetivoPromotor()
		{
			return $this->idObjetivoPromotor;
		}
		public function getIdPromotor()
		{
			return $this->idPromotor;
		}
		public function getAnio()
		{
			return $this->anio;
		}
		public function getMes()
		{
			return $this->mes;
		}
		public function getObjetivo()
		{
			return $this->objetivo;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idObjetivoPromotor=0;
			$this->idPromotor=0;
			$this->anio=0;
			$this->mes=0;
			$this->objetivo='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPromotor,
				                                              anio,
				                                              mes,
				                                              objetivo)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->objetivo) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseObjetivopromotor::Insertar]");
				
				$this->idObjetivoPromotor=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idPromotor='" . mysqli_real_escape_string($this->dbLink,$this->idPromotor) . "',
	                                              anio='" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
	                                              mes='" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
	                                              objetivo='" . mysqli_real_escape_string($this->dbLink,$this->objetivo) . "'
					WHERE idObjetivoPromotor=" . $this->idObjetivoPromotor;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseObjetivopromotor::Update]");
				
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
				WHERE idObjetivoPromotor=" . mysqli_real_escape_string($this->dbLink,$this->idObjetivoPromotor);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseObjetivopromotor::Borrar]");
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
						idObjetivoPromotor,
						idPromotor,
						anio,
						mes,
						objetivo
					FROM " . $this->__tableName . " 
					WHERE idObjetivoPromotor=" . mysqli_real_escape_string($this->dbLink,$this->idObjetivoPromotor);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseObjetivopromotor::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idObjetivoPromotor==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>