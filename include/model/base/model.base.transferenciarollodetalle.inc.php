<?php

	class ModeloBaseTransferenciarollodetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTransferenciarollodetalle";

		
		var $idTransferenciaRolloDetalle=0;
		var $idTransferenciaRollo=0;
		var $idRemisionRollo=0;

		var $__s=array("idTransferenciaRolloDetalle",
                       "idTransferenciaRollo",
                       "idRemisionRollo");
				
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

		
		public function setIdTransferenciaRolloDetalle($idTransferenciaRolloDetalle)
		{
			if($idTransferenciaRolloDetalle==0||$idTransferenciaRolloDetalle==""||!is_numeric($idTransferenciaRolloDetalle)|| (is_string($idTransferenciaRolloDetalle)&&!ctype_digit($idTransferenciaRolloDetalle)))return $this->setError("Tipo de dato incorrecto para idTransferenciaRolloDetalle.");
			$this->idTransferenciaRolloDetalle=$idTransferenciaRolloDetalle;
			$this->getDatos();
		}
		public function setIdTransferenciaRollo($idTransferenciaRollo)
		{
			
			$this->idTransferenciaRollo=$idTransferenciaRollo;
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTransferenciaRolloDetalle()
		{
			return $this->idTransferenciaRolloDetalle;
		}
		public function getIdTransferenciaRollo()
		{
			return $this->idTransferenciaRollo;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTransferenciaRolloDetalle=0;
			$this->idTransferenciaRollo=0;
			$this->idRemisionRollo=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idTransferenciaRollo,
				                                              idRemisionRollo)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciarollodetalle::Insertar]");
				
				$this->idTransferenciaRolloDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idTransferenciaRollo='" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaRollo) . "',
	                                              idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "'
					WHERE idTransferenciaRolloDetalle=" . $this->idTransferenciaRolloDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciarollodetalle::Update]");
				
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
				WHERE idTransferenciaRolloDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaRolloDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciarollodetalle::Borrar]");
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
						idTransferenciaRolloDetalle,
						idTransferenciaRollo,
						idRemisionRollo
					FROM " . $this->__tableName . " 
					WHERE idTransferenciaRolloDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaRolloDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTransferenciarollodetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTransferenciaRolloDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>