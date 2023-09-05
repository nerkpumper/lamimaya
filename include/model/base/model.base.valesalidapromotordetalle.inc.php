<?php

	class ModeloBaseValesalidapromotordetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseValesalidapromotordetalle";

		
		var $idValeSalidaPromotorDetalle=0;
		var $idValeSalidaPromotor=0;
		var $idPedidoDetalle=0;
		var $idPedido=0;
		var $idPedidoDetalleColocacion=0;
		var $idProducto=0;
		var $cantidad='0';
		var $fecha_despacho='0000-00-00 00:00:00';
		var $id_usuario_despacho='0';
		var $idSucursalDespachado=0;

		var $__s=array("idValeSalidaPromotorDetalle",
                       "idValeSalidaPromotor",
                       "idPedidoDetalle",
                       "idPedido",
                       "idPedidoDetalleColocacion",
                       "idProducto",
                       "cantidad",
                       "fecha_despacho",
                       "id_usuario_despacho",
                       "idSucursalDespachado");
				
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

		
		public function setIdValeSalidaPromotorDetalle($idValeSalidaPromotorDetalle)
		{
			if($idValeSalidaPromotorDetalle==0||$idValeSalidaPromotorDetalle==""||!is_numeric($idValeSalidaPromotorDetalle)|| (is_string($idValeSalidaPromotorDetalle)&&!ctype_digit($idValeSalidaPromotorDetalle)))return $this->setError("Tipo de dato incorrecto para idValeSalidaPromotorDetalle.");
			$this->idValeSalidaPromotorDetalle=$idValeSalidaPromotorDetalle;
			$this->getDatos();
		}
		public function setIdValeSalidaPromotor($idValeSalidaPromotor)
		{
			
			$this->idValeSalidaPromotor=$idValeSalidaPromotor;
		}
		public function setIdPedidoDetalle($idPedidoDetalle)
		{
			
			$this->idPedidoDetalle=$idPedidoDetalle;
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setIdPedidoDetalleColocacion($idPedidoDetalleColocacion)
		{
			
			$this->idPedidoDetalleColocacion=$idPedidoDetalleColocacion;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setCantidad($cantidad)
		{
			$this->cantidad=$cantidad;
		}
		public function setFecha_despacho($fecha_despacho)
		{
			$this->fecha_despacho=$fecha_despacho;
		}
		public function setId_usuario_despacho($id_usuario_despacho)
		{
			
			$this->id_usuario_despacho=$id_usuario_despacho;
		}
		public function setIdSucursalDespachado($idSucursalDespachado)
		{
			
			$this->idSucursalDespachado=$idSucursalDespachado;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdValeSalidaPromotorDetalle()
		{
			return $this->idValeSalidaPromotorDetalle;
		}
		public function getIdValeSalidaPromotor()
		{
			return $this->idValeSalidaPromotor;
		}
		public function getIdPedidoDetalle()
		{
			return $this->idPedidoDetalle;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getIdPedidoDetalleColocacion()
		{
			return $this->idPedidoDetalleColocacion;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}
		public function getFecha_despacho()
		{
			return $this->fecha_despacho;
		}
		public function getId_usuario_despacho()
		{
			return $this->id_usuario_despacho;
		}
		public function getIdSucursalDespachado()
		{
			return $this->idSucursalDespachado;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idValeSalidaPromotorDetalle=0;
			$this->idValeSalidaPromotor=0;
			$this->idPedidoDetalle=0;
			$this->idPedido=0;
			$this->idPedidoDetalleColocacion=0;
			$this->idProducto=0;
			$this->cantidad='0';
			$this->fecha_despacho='0000-00-00 00:00:00';
			$this->id_usuario_despacho='0';
			$this->idSucursalDespachado=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idValeSalidaPromotor,
				                                              idPedidoDetalle,
				                                              idPedido,
				                                              idPedidoDetalleColocacion,
				                                              idProducto,
				                                              cantidad,
				                                              fecha_despacho,
				                                              id_usuario_despacho,
				                                              idSucursalDespachado)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idValeSalidaPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalleColocacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_despacho) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_despacho) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursalDespachado) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseValesalidapromotordetalle::Insertar]");
				
				$this->idValeSalidaPromotorDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idValeSalidaPromotor='" . mysqli_real_escape_string($this->dbLink,$this->idValeSalidaPromotor) . "',
	                                              idPedidoDetalle='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
	                                              idPedido='" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
	                                              idPedidoDetalleColocacion='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalleColocacion) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
	                                              fecha_despacho='" . mysqli_real_escape_string($this->dbLink,$this->fecha_despacho) . "',
	                                              id_usuario_despacho='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_despacho) . "',
	                                              idSucursalDespachado='" . mysqli_real_escape_string($this->dbLink,$this->idSucursalDespachado) . "'
					WHERE idValeSalidaPromotorDetalle=" . $this->idValeSalidaPromotorDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseValesalidapromotordetalle::Update]");
				
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
				WHERE idValeSalidaPromotorDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idValeSalidaPromotorDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseValesalidapromotordetalle::Borrar]");
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
						idValeSalidaPromotorDetalle,
						idValeSalidaPromotor,
						idPedidoDetalle,
						idPedido,
						idPedidoDetalleColocacion,
						idProducto,
						cantidad,
						fecha_despacho,
						id_usuario_despacho,
						idSucursalDespachado
					FROM " . $this->__tableName . " 
					WHERE idValeSalidaPromotorDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idValeSalidaPromotorDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseValesalidapromotordetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idValeSalidaPromotorDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>