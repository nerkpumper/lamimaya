<?php

	class ModeloBaseTransferenciastockdetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTransferenciastockdetalle";

		
		var $idTransferenciaStockDetalle=0;
		var $idTransferenciaStock=0;
		var $idProducto=0;
		var $cantidad=0;

		var $__s=array("idTransferenciaStockDetalle",
                       "idTransferenciaStock",
                       "idProducto",
                       "cantidad");
				
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

		
		public function setIdTransferenciaStockDetalle($idTransferenciaStockDetalle)
		{
			if($idTransferenciaStockDetalle==0||$idTransferenciaStockDetalle==""||!is_numeric($idTransferenciaStockDetalle)|| (is_string($idTransferenciaStockDetalle)&&!ctype_digit($idTransferenciaStockDetalle)))return $this->setError("Tipo de dato incorrecto para idTransferenciaStockDetalle.");
			$this->idTransferenciaStockDetalle=$idTransferenciaStockDetalle;
			$this->getDatos();
		}
		public function setIdTransferenciaStock($idTransferenciaStock)
		{
			
			$this->idTransferenciaStock=$idTransferenciaStock;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setCantidad($cantidad)
		{
			
			$this->cantidad=$cantidad;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTransferenciaStockDetalle()
		{
			return $this->idTransferenciaStockDetalle;
		}
		public function getIdTransferenciaStock()
		{
			return $this->idTransferenciaStock;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTransferenciaStockDetalle=0;
			$this->idTransferenciaStock=0;
			$this->idProducto=0;
			$this->cantidad=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idTransferenciaStock,
				                                              idProducto,
				                                              cantidad)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaStock) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciastockdetalle::Insertar]");
				
				$this->idTransferenciaStockDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idTransferenciaStock='" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaStock) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "'
					WHERE idTransferenciaStockDetalle=" . $this->idTransferenciaStockDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciastockdetalle::Update]");
				
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
				WHERE idTransferenciaStockDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaStockDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciastockdetalle::Borrar]");
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
						idTransferenciaStockDetalle,
						idTransferenciaStock,
						idProducto,
						cantidad
					FROM " . $this->__tableName . " 
					WHERE idTransferenciaStockDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaStockDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTransferenciastockdetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTransferenciaStockDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>