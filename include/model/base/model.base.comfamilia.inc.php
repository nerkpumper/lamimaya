<?php

	class ModeloBaseComfamilia extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseComfamilia";

		
		var $idComFamilia=0;
		var $idAplicacion=0;
		var $idMaterial=0;

		var $__s=array("idComFamilia",
                       "idAplicacion",
                       "idMaterial");
				
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

		
		public function setIdComFamilia($idComFamilia)
		{
			if($idComFamilia==0||$idComFamilia==""||!is_numeric($idComFamilia)|| (is_string($idComFamilia)&&!ctype_digit($idComFamilia)))return $this->setError("Tipo de dato incorrecto para idComFamilia.");
			$this->idComFamilia=$idComFamilia;
			$this->getDatos();
		}
		public function setIdAplicacion($idAplicacion)
		{
			
			$this->idAplicacion=$idAplicacion;
		}
		public function setIdMaterial($idMaterial)
		{
			
			$this->idMaterial=$idMaterial;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdComFamilia()
		{
			return $this->idComFamilia;
		}
		public function getIdAplicacion()
		{
			return $this->idAplicacion;
		}
		public function getIdMaterial()
		{
			return $this->idMaterial;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idComFamilia=0;
			$this->idAplicacion=0;
			$this->idMaterial=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idAplicacion,
				                                              idMaterial)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idAplicacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idMaterial) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComfamilia::Insertar]");
				
				$this->idComFamilia=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idAplicacion='" . mysqli_real_escape_string($this->dbLink,$this->idAplicacion) . "',
	                                              idMaterial='" . mysqli_real_escape_string($this->dbLink,$this->idMaterial) . "'
					WHERE idComFamilia=" . $this->idComFamilia;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComfamilia::Update]");
				
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
				WHERE idComFamilia=" . mysqli_real_escape_string($this->dbLink,$this->idComFamilia);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComfamilia::Borrar]");
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
						idComFamilia,
						idAplicacion,
						idMaterial
					FROM " . $this->__tableName . " 
					WHERE idComFamilia=" . mysqli_real_escape_string($this->dbLink,$this->idComFamilia);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseComfamilia::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idComFamilia==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>