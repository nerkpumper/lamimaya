<?php

	class ModeloBaseInventariosucursal extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseInventariosucursal";

		
		var $idInventarioSucursal=0;
		var $idSucursal=0;
		var $idProducto=0;
		var $existencia='0';
		var $apartado='0';
		var $compraAnual='0.00';
		var $compraPorcentaje='0.00';

		var $__s=array("idInventarioSucursal",
                       "idSucursal",
                       "idProducto",
                       "existencia",
                       "apartado",
                       "compraAnual",
                       "compraPorcentaje");
				
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

		
		public function setIdInventarioSucursal($idInventarioSucursal)
		{
			if($idInventarioSucursal==0||$idInventarioSucursal==""||!is_numeric($idInventarioSucursal)|| (is_string($idInventarioSucursal)&&!ctype_digit($idInventarioSucursal)))return $this->setError("Tipo de dato incorrecto para idInventarioSucursal.");
			$this->idInventarioSucursal=$idInventarioSucursal;
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
		public function setExistencia($existencia)
		{
			$this->existencia=$existencia;
		}
		public function setApartado($apartado)
		{
			$this->apartado=$apartado;
		}
		public function setCompraAnual($compraAnual)
		{
			$this->compraAnual=$compraAnual;
		}
		public function setCompraPorcentaje($compraPorcentaje)
		{
			$this->compraPorcentaje=$compraPorcentaje;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdInventarioSucursal()
		{
			return $this->idInventarioSucursal;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}
		public function getApartado()
		{
			return $this->apartado;
		}
		public function getCompraAnual()
		{
			return $this->compraAnual;
		}
		public function getCompraPorcentaje()
		{
			return $this->compraPorcentaje;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idInventarioSucursal=0;
			$this->idSucursal=0;
			$this->idProducto=0;
			$this->existencia='0';
			$this->apartado='0';
			$this->compraAnual='0.00';
			$this->compraPorcentaje='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idSucursal,
				                                              idProducto,
				                                              existencia,
				                                              apartado,
				                                              compraAnual,
				                                              compraPorcentaje)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->compraAnual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->compraPorcentaje) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInventariosucursal::Insertar]");
				
				$this->idInventarioSucursal=mysqli_insert_id($this->dbLink);
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
	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
	                                              apartado='" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
	                                              compraAnual='" . mysqli_real_escape_string($this->dbLink,$this->compraAnual) . "',
	                                              compraPorcentaje='" . mysqli_real_escape_string($this->dbLink,$this->compraPorcentaje) . "'
					WHERE idInventarioSucursal=" . $this->idInventarioSucursal;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInventariosucursal::Update]");
				
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
				WHERE idInventarioSucursal=" . mysqli_real_escape_string($this->dbLink,$this->idInventarioSucursal);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInventariosucursal::Borrar]");
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
						idInventarioSucursal,
						idSucursal,
						idProducto,
						existencia,
						apartado,
						compraAnual,
						compraPorcentaje
					FROM " . $this->__tableName . " 
					WHERE idInventarioSucursal=" . mysqli_real_escape_string($this->dbLink,$this->idInventarioSucursal);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseInventariosucursal::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idInventarioSucursal==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>