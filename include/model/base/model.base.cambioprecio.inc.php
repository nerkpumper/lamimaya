<?php

	class ModeloBaseCambioprecio extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCambioprecio";

		
		var $idCambioPrecio=0;
		var $fecha='';
		var $cambioPrecio_producto_idProducto=0;
		var $noPrecio=0;
		var $precioAnterior='0';
		var $precio='0';
		var $idUsuario=0;

		var $__s=array("idCambioPrecio",
                       "fecha",
                       "cambioPrecio_producto_idProducto",
                       "noPrecio",
                       "precioAnterior",
                       "precio",
                       "idUsuario");
				
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

		
		public function setIdCambioPrecio($idCambioPrecio)
		{
			if($idCambioPrecio==0||$idCambioPrecio==""||!is_numeric($idCambioPrecio)|| (is_string($idCambioPrecio)&&!ctype_digit($idCambioPrecio)))return $this->setError("Tipo de dato incorrecto para idCambioPrecio.");
			$this->idCambioPrecio=$idCambioPrecio;
			$this->getDatos();
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}
		public function setCambioPrecio_producto_idProducto($cambioPrecio_producto_idProducto)
		{
			
			$this->cambioPrecio_producto_idProducto=$cambioPrecio_producto_idProducto;
		}
		public function setNoPrecio($noPrecio)
		{
			
			$this->noPrecio=$noPrecio;
		}
		public function setPrecioAnterior($precioAnterior)
		{
			$this->precioAnterior=$precioAnterior;
		}
		public function setPrecio($precio)
		{
			$this->precio=$precio;
		}
		public function setIdUsuario($idUsuario)
		{
			
			$this->idUsuario=$idUsuario;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCambioPrecio()
		{
			return $this->idCambioPrecio;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getCambioPrecio_producto_idProducto()
		{
			return $this->cambioPrecio_producto_idProducto;
		}
		public function getNoPrecio()
		{
			return $this->noPrecio;
		}
		public function getPrecioAnterior()
		{
			return $this->precioAnterior;
		}
		public function getPrecio()
		{
			return $this->precio;
		}
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCambioPrecio=0;
			$this->fecha='';
			$this->cambioPrecio_producto_idProducto=0;
			$this->noPrecio=0;
			$this->precioAnterior='0';
			$this->precio='0';
			$this->idUsuario=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (fecha,
				                                              cambioPrecio_producto_idProducto,
				                                              noPrecio,
				                                              precioAnterior,
				                                              precio,
				                                              idUsuario)
						VALUES(" . mysqli_real_escape_string($this->dbLink,"now()") . ",
				               '" . mysqli_real_escape_string($this->dbLink,$this->cambioPrecio_producto_idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->noPrecio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precioAnterior) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCambioprecio::Insertar]");
				
				$this->idCambioPrecio=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              cambioPrecio_producto_idProducto='" . mysqli_real_escape_string($this->dbLink,$this->cambioPrecio_producto_idProducto) . "',
	                                              noPrecio='" . mysqli_real_escape_string($this->dbLink,$this->noPrecio) . "',
	                                              precioAnterior='" . mysqli_real_escape_string($this->dbLink,$this->precioAnterior) . "',
	                                              precio='" . mysqli_real_escape_string($this->dbLink,$this->precio) . "',
	                                              idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "'
					WHERE idCambioPrecio=" . $this->idCambioPrecio;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCambioprecio::Update]");
				
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
				WHERE idCambioPrecio=" . mysqli_real_escape_string($this->dbLink,$this->idCambioPrecio);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCambioprecio::Borrar]");
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
						idCambioPrecio,
						fecha,
						cambioPrecio_producto_idProducto,
						noPrecio,
						precioAnterior,
						precio,
						idUsuario
					FROM " . $this->__tableName . " 
					WHERE idCambioPrecio=" . mysqli_real_escape_string($this->dbLink,$this->idCambioPrecio);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCambioprecio::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCambioPrecio==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>