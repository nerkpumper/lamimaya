<?php

	class ModeloBaseInvzstocknorolloback extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseInvzstocknorolloback";

		
		var $idInvzStockNoRollo=0;
		var $idRemisionRollo=0;
		var $idProducto=0;
		var $existencia='0';

		var $__s=array("idInvzStockNoRollo",
                       "idRemisionRollo",
                       "idProducto",
                       "existencia");
				
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

		
		public function setIdInvzStockNoRollo($idInvzStockNoRollo)
		{
			
			$this->idInvzStockNoRollo=$idInvzStockNoRollo;
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setExistencia($existencia)
		{
			$this->existencia=$existencia;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdInvzStockNoRollo()
		{
			return $this->idInvzStockNoRollo;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idInvzStockNoRollo=0;
			$this->idRemisionRollo=0;
			$this->idProducto=0;
			$this->existencia='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idInvzStockNoRollo,
				                                              idRemisionRollo,
				                                              idProducto,
				                                              existencia)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idInvzStockNoRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzstocknorolloback::Insertar]");
				
				$this->=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idInvzStockNoRollo='" . mysqli_real_escape_string($this->dbLink,$this->idInvzStockNoRollo) . "',
	                                              idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "'
					WHERE =" . $this->;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzstocknorolloback::Update]");
				
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
				WHERE =" . mysqli_real_escape_string($this->dbLink,$this->);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzstocknorolloback::Borrar]");
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
						idInvzStockNoRollo,
						idRemisionRollo,
						idProducto,
						existencia
					FROM " . $this->__tableName . " 
					WHERE =" . mysqli_real_escape_string($this->dbLink,$this->);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseInvzstocknorolloback::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>