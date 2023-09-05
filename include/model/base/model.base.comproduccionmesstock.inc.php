<?php

	class ModeloBaseComproduccionmesstock extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseComproduccionmesstock";

		
		var $idComProduccionMesStock=0;
		var $idSucursal=0;
		var $idProducto=0;
		var $anio=0;
		var $mes=0;
		var $cantidad='0.00';

		var $__s=array("idComProduccionMesStock",
                       "idSucursal",
                       "idProducto",
                       "anio",
                       "mes",
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

		
		public function setIdComProduccionMesStock($idComProduccionMesStock)
		{
			if($idComProduccionMesStock==0||$idComProduccionMesStock==""||!is_numeric($idComProduccionMesStock)|| (is_string($idComProduccionMesStock)&&!ctype_digit($idComProduccionMesStock)))return $this->setError("Tipo de dato incorrecto para idComProduccionMesStock.");
			$this->idComProduccionMesStock=$idComProduccionMesStock;
			$this->getDatos();
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setAnio($anio)
		{
			
			$this->anio=$anio;
		}
		public function setMes($mes)
		{
			
			$this->mes=$mes;
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

		
		public function getIdComProduccionMesStock()
		{
			return $this->idComProduccionMesStock;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getAnio()
		{
			return $this->anio;
		}
		public function getMes()
		{
			return $this->mes;
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
			
			$this->idComProduccionMesStock=0;
			$this->idSucursal=0;
			$this->idProducto=0;
			$this->anio=0;
			$this->mes=0;
			$this->cantidad='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idSucursal,
				                                              idProducto,
				                                              anio,
				                                              mes,
				                                              cantidad)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComproduccionmesstock::Insertar]");
				
				$this->idComProduccionMesStock=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              anio='" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
	                                              mes='" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "'
					WHERE idComProduccionMesStock=" . $this->idComProduccionMesStock;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComproduccionmesstock::Update]");
				
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
				WHERE idComProduccionMesStock=" . mysqli_real_escape_string($this->dbLink,$this->idComProduccionMesStock);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComproduccionmesstock::Borrar]");
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
						idComProduccionMesStock,
						idSucursal,
						idProducto,
						anio,
						mes,
						cantidad
					FROM " . $this->__tableName . " 
					WHERE idComProduccionMesStock=" . mysqli_real_escape_string($this->dbLink,$this->idComProduccionMesStock);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseComproduccionmesstock::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idComProduccionMesStock==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>