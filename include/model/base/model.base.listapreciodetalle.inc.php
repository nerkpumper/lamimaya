<?php

	class ModeloBaseListapreciodetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseListapreciodetalle";

		
		var $idListaPrecioDetalle=0;
		var $idListaPrecio=0;
		var $idProducto=0;
		var $costo='0.00';
		var $precio1='0.00';
		var $precio2='0.00';
		var $precio3='0.00';

		var $__s=array("idListaPrecioDetalle",
                       "idListaPrecio",
                       "idProducto",
                       "costo",
                       "precio1",
                       "precio2",
                       "precio3");
				
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

		
		public function setIdListaPrecioDetalle($idListaPrecioDetalle)
		{
			if($idListaPrecioDetalle==0||$idListaPrecioDetalle==""||!is_numeric($idListaPrecioDetalle)|| (is_string($idListaPrecioDetalle)&&!ctype_digit($idListaPrecioDetalle)))return $this->setError("Tipo de dato incorrecto para idListaPrecioDetalle.");
			$this->idListaPrecioDetalle=$idListaPrecioDetalle;
			$this->getDatos();
		}
		public function setIdListaPrecio($idListaPrecio)
		{
			
			$this->idListaPrecio=$idListaPrecio;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setCosto($costo)
		{
			$this->costo=$costo;
		}
		public function setPrecio1($precio1)
		{
			$this->precio1=$precio1;
		}
		public function setPrecio2($precio2)
		{
			$this->precio2=$precio2;
		}
		public function setPrecio3($precio3)
		{
			$this->precio3=$precio3;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdListaPrecioDetalle()
		{
			return $this->idListaPrecioDetalle;
		}
		public function getIdListaPrecio()
		{
			return $this->idListaPrecio;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getCosto()
		{
			return $this->costo;
		}
		public function getPrecio1()
		{
			return $this->precio1;
		}
		public function getPrecio2()
		{
			return $this->precio2;
		}
		public function getPrecio3()
		{
			return $this->precio3;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idListaPrecioDetalle=0;
			$this->idListaPrecio=0;
			$this->idProducto=0;
			$this->costo='0.00';
			$this->precio1='0.00';
			$this->precio2='0.00';
			$this->precio3='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idListaPrecio,
				                                              idProducto,
				                                              costo,
				                                              precio1,
				                                              precio2,
				                                              precio3)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idListaPrecio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseListapreciodetalle::Insertar]");
				
				$this->idListaPrecioDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idListaPrecio='" . mysqli_real_escape_string($this->dbLink,$this->idListaPrecio) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              costo='" . mysqli_real_escape_string($this->dbLink,$this->costo) . "',
	                                              precio1='" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
	                                              precio2='" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
	                                              precio3='" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "'
					WHERE idListaPrecioDetalle=" . $this->idListaPrecioDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseListapreciodetalle::Update]");
				
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
				WHERE idListaPrecioDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idListaPrecioDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseListapreciodetalle::Borrar]");
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
						idListaPrecioDetalle,
						idListaPrecio,
						idProducto,
						costo,
						precio1,
						precio2,
						precio3
					FROM " . $this->__tableName . " 
					WHERE idListaPrecioDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idListaPrecioDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseListapreciodetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idListaPrecioDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>