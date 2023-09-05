<?php

	class ModeloBaseComproduccionstockback extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseComproduccionstockback";

		
		var $idComProduccionStock=0;
		var $idProducto=0;
		var $fecha='0';
		var $anio=0;
		var $mes=0;
		var $dia=0;
		var $cantidad='0.00';

		var $__s=array("idComProduccionStock",
                       "idProducto",
                       "fecha",
                       "anio",
                       "mes",
                       "dia",
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

		
		public function setIdComProduccionStock($idComProduccionStock)
		{
			if($idComProduccionStock==0||$idComProduccionStock==""||!is_numeric($idComProduccionStock)|| (is_string($idComProduccionStock)&&!ctype_digit($idComProduccionStock)))return $this->setError("Tipo de dato incorrecto para idComProduccionStock.");
			$this->idComProduccionStock=$idComProduccionStock;
			$this->getDatos();
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}
		public function setAnio($anio)
		{
			
			$this->anio=$anio;
		}
		public function setMes($mes)
		{
			
			$this->mes=$mes;
		}
		public function setDia($dia)
		{
			
			$this->dia=$dia;
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

		
		public function getIdComProduccionStock()
		{
			return $this->idComProduccionStock;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getAnio()
		{
			return $this->anio;
		}
		public function getMes()
		{
			return $this->mes;
		}
		public function getDia()
		{
			return $this->dia;
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
			
			$this->idComProduccionStock=0;
			$this->idProducto=0;
			$this->fecha='0';
			$this->anio=0;
			$this->mes=0;
			$this->dia=0;
			$this->cantidad='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idProducto,
				                                              fecha,
				                                              anio,
				                                              mes,
				                                              dia,
				                                              cantidad)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->dia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComproduccionstockback::Insertar]");
				
				$this->idComProduccionStock=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              anio='" . mysqli_real_escape_string($this->dbLink,$this->anio) . "',
	                                              mes='" . mysqli_real_escape_string($this->dbLink,$this->mes) . "',
	                                              dia='" . mysqli_real_escape_string($this->dbLink,$this->dia) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "'
					WHERE idComProduccionStock=" . $this->idComProduccionStock;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComproduccionstockback::Update]");
				
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
				WHERE idComProduccionStock=" . mysqli_real_escape_string($this->dbLink,$this->idComProduccionStock);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseComproduccionstockback::Borrar]");
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
						idComProduccionStock,
						idProducto,
						fecha,
						anio,
						mes,
						dia,
						cantidad
					FROM " . $this->__tableName . " 
					WHERE idComProduccionStock=" . mysqli_real_escape_string($this->dbLink,$this->idComProduccionStock);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseComproduccionstockback::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idComProduccionStock==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>