<?php

	class ModeloBaseMovsapartado extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseMovsapartado";

		
		var $idMosvApartado=0;
		var $idPedidoDetalle=0;
		var $idProducto=0;
		var $tipo='0';
		var $cantidad='0';
		var $kg='0.00';
		var $fecha_movimiento='0000-00-00 00:00:00';
		var $id_usuario_movimiento=0;

		var $__s=array("idMosvApartado",
                       "idPedidoDetalle",
                       "idProducto",
                       "tipo",
                       "cantidad",
                       "kg",
                       "fecha_movimiento",
                       "id_usuario_movimiento");
				
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

		
		public function setIdMosvApartado($idMosvApartado)
		{
			if($idMosvApartado==0||$idMosvApartado==""||!is_numeric($idMosvApartado)|| (is_string($idMosvApartado)&&!ctype_digit($idMosvApartado)))return $this->setError("Tipo de dato incorrecto para idMosvApartado.");
			$this->idMosvApartado=$idMosvApartado;
			$this->getDatos();
		}
		public function setIdPedidoDetalle($idPedidoDetalle)
		{
			
			$this->idPedidoDetalle=$idPedidoDetalle;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoAPARTADO()
		{
			$this->tipo='APARTADO';
		}
		public function setTipoDESAPARTADO()
		{
			$this->tipo='DESAPARTADO';
		}
		public function setCantidad($cantidad)
		{
			$this->cantidad=$cantidad;
		}
		public function setKg($kg)
		{
			$this->kg=$kg;
		}
		public function setFecha_movimiento($fecha_movimiento)
		{
			$this->fecha_movimiento=$fecha_movimiento;
		}
		public function setId_usuario_movimiento($id_usuario_movimiento)
		{
			
			$this->id_usuario_movimiento=$id_usuario_movimiento;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdMosvApartado()
		{
			return $this->idMosvApartado;
		}
		public function getIdPedidoDetalle()
		{
			return $this->idPedidoDetalle;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}
		public function getKg()
		{
			return $this->kg;
		}
		public function getFecha_movimiento()
		{
			return $this->fecha_movimiento;
		}
		public function getId_usuario_movimiento()
		{
			return $this->id_usuario_movimiento;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idMosvApartado=0;
			$this->idPedidoDetalle=0;
			$this->idProducto=0;
			$this->tipo='0';
			$this->cantidad='0';
			$this->kg='0.00';
			$this->fecha_movimiento='0000-00-00 00:00:00';
			$this->id_usuario_movimiento=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPedidoDetalle,
				                                              idProducto,
				                                              tipo,
				                                              cantidad,
				                                              kg,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kg) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMovsapartado::Insertar]");
				
				$this->idMosvApartado=mysqli_insert_id($this->dbLink);
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
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
	                                              kg='" . mysqli_real_escape_string($this->dbLink,$this->kg) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "'
					WHERE idMosvApartado=" . $this->idMosvApartado;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMovsapartado::Update]");
				
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
				WHERE idMosvApartado=" . mysqli_real_escape_string($this->dbLink,$this->idMosvApartado);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMovsapartado::Borrar]");
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
						idMosvApartado,
						idPedidoDetalle,
						idProducto,
						tipo,
						cantidad,
						kg,
						fecha_movimiento,
						id_usuario_movimiento
					FROM " . $this->__tableName . " 
					WHERE idMosvApartado=" . mysqli_real_escape_string($this->dbLink,$this->idMosvApartado);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseMovsapartado::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idMosvApartado==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>