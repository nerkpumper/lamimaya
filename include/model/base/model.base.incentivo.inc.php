<?php

	class ModeloBaseIncentivo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseIncentivo";

		
		var $idIncentivo=0;
		var $inicio='0';
		var $fin='0';
		var $porcentaje='0';

		var $__s=array("idIncentivo",
                       "inicio",
                       "fin",
                       "porcentaje");
				
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

		
		public function setIdIncentivo($idIncentivo)
		{
			if($idIncentivo==0||$idIncentivo==""||!is_numeric($idIncentivo)|| (is_string($idIncentivo)&&!ctype_digit($idIncentivo)))return $this->setError("Tipo de dato incorrecto para idIncentivo.");
			$this->idIncentivo=$idIncentivo;
			$this->getDatos();
		}
		public function setInicio($inicio)
		{
			$this->inicio=$inicio;
		}
		public function setFin($fin)
		{
			$this->fin=$fin;
		}
		public function setPorcentaje($porcentaje)
		{
			$this->porcentaje=$porcentaje;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdIncentivo()
		{
			return $this->idIncentivo;
		}
		public function getInicio()
		{
			return $this->inicio;
		}
		public function getFin()
		{
			return $this->fin;
		}
		public function getPorcentaje()
		{
			return $this->porcentaje;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idIncentivo=0;
			$this->inicio='0';
			$this->fin='0';
			$this->porcentaje='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (inicio,
				                                              fin,
				                                              porcentaje)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porcentaje) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseIncentivo::Insertar]");
				
				$this->idIncentivo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET inicio='" . mysqli_real_escape_string($this->dbLink,$this->inicio) . "',
	                                              fin='" . mysqli_real_escape_string($this->dbLink,$this->fin) . "',
	                                              porcentaje='" . mysqli_real_escape_string($this->dbLink,$this->porcentaje) . "'
					WHERE idIncentivo=" . $this->idIncentivo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseIncentivo::Update]");
				
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
				WHERE idIncentivo=" . mysqli_real_escape_string($this->dbLink,$this->idIncentivo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseIncentivo::Borrar]");
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
						idIncentivo,
						inicio,
						fin,
						porcentaje
					FROM " . $this->__tableName . " 
					WHERE idIncentivo=" . mysqli_real_escape_string($this->dbLink,$this->idIncentivo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseIncentivo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idIncentivo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>