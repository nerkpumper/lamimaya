<?php

	class ModeloBasePedidodetallecolocacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePedidodetallecolocacion";

		
		var $idPedidoDetalleColocacion=0;
		var $idPedidoDetalle=0;
		var $idInventarioSucursal=0;
		var $idSucursal=0;
		var $cantidad='0.00';
		var $cantidadSurtida='0.00';
		var $cantidadEnVale='0.00';

		var $__s=array("idPedidoDetalleColocacion",
                       "idPedidoDetalle",
                       "idInventarioSucursal",
                       "idSucursal",
                       "cantidad",
                       "cantidadSurtida",
                       "cantidadEnVale");
				
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

		
		public function setIdPedidoDetalleColocacion($idPedidoDetalleColocacion)
		{
			if($idPedidoDetalleColocacion==0||$idPedidoDetalleColocacion==""||!is_numeric($idPedidoDetalleColocacion)|| (is_string($idPedidoDetalleColocacion)&&!ctype_digit($idPedidoDetalleColocacion)))return $this->setError("Tipo de dato incorrecto para idPedidoDetalleColocacion.");
			$this->idPedidoDetalleColocacion=$idPedidoDetalleColocacion;
			$this->getDatos();
		}
		public function setIdPedidoDetalle($idPedidoDetalle)
		{
			
			$this->idPedidoDetalle=$idPedidoDetalle;
		}
		public function setIdInventarioSucursal($idInventarioSucursal)
		{
			
			$this->idInventarioSucursal=$idInventarioSucursal;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setCantidad($cantidad)
		{
			$this->cantidad=$cantidad;
		}
		public function setCantidadSurtida($cantidadSurtida)
		{
			$this->cantidadSurtida=$cantidadSurtida;
		}
		public function setCantidadEnVale($cantidadEnVale)
		{
			$this->cantidadEnVale=$cantidadEnVale;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPedidoDetalleColocacion()
		{
			return $this->idPedidoDetalleColocacion;
		}
		public function getIdPedidoDetalle()
		{
			return $this->idPedidoDetalle;
		}
		public function getIdInventarioSucursal()
		{
			return $this->idInventarioSucursal;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}
		public function getCantidadSurtida()
		{
			return $this->cantidadSurtida;
		}
		public function getCantidadEnVale()
		{
			return $this->cantidadEnVale;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPedidoDetalleColocacion=0;
			$this->idPedidoDetalle=0;
			$this->idInventarioSucursal=0;
			$this->idSucursal=0;
			$this->cantidad='0.00';
			$this->cantidadSurtida='0.00';
			$this->cantidadEnVale='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPedidoDetalle,
				                                              idInventarioSucursal,
				                                              idSucursal,
				                                              cantidad,
				                                              cantidadSurtida,
				                                              cantidadEnVale)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idInventarioSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidadSurtida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidadEnVale) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidodetallecolocacion::Insertar]");
				
				$this->idPedidoDetalleColocacion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idPedidoDetalle='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
	                                              idInventarioSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idInventarioSucursal) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
	                                              cantidadSurtida='" . mysqli_real_escape_string($this->dbLink,$this->cantidadSurtida) . "',
	                                              cantidadEnVale='" . mysqli_real_escape_string($this->dbLink,$this->cantidadEnVale) . "'
					WHERE idPedidoDetalleColocacion=" . $this->idPedidoDetalleColocacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidodetallecolocacion::Update]");
				
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
				WHERE idPedidoDetalleColocacion=" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalleColocacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidodetallecolocacion::Borrar]");
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
						idPedidoDetalleColocacion,
						idPedidoDetalle,
						idInventarioSucursal,
						idSucursal,
						cantidad,
						cantidadSurtida,
						cantidadEnVale
					FROM " . $this->__tableName . " 
					WHERE idPedidoDetalleColocacion=" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalleColocacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePedidodetallecolocacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPedidoDetalleColocacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>