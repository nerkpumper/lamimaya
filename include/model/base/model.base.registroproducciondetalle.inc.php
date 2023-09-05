<?php

	class ModeloBaseRegistroproducciondetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRegistroproducciondetalle";

		
		var $idRegistroProduccionDetalle=0;
		var $idRegistroProduccion=0;
		var $tipo='STOCK';
		var $idProducto=0;
		var $idPedidoDetalle=0;
		var $partida='0';
		var $longitud='0.00';
		var $kgml='0.00';
		var $totalKg='0.00';
		var $totalReal='0.00';
		var $fecha_captura='0000-00-00 00:00:00';
		var $id_usuario_captura=0;
		var $idSucursal=0;

		var $__s=array("idRegistroProduccionDetalle",
                       "idRegistroProduccion",
                       "tipo",
                       "idProducto",
                       "idPedidoDetalle",
                       "partida",
                       "longitud",
                       "kgml",
                       "totalKg",
                       "totalReal",
                       "fecha_captura",
                       "id_usuario_captura",
                       "idSucursal");
				
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

		
		public function setIdRegistroProduccionDetalle($idRegistroProduccionDetalle)
		{
			if($idRegistroProduccionDetalle==0||$idRegistroProduccionDetalle==""||!is_numeric($idRegistroProduccionDetalle)|| (is_string($idRegistroProduccionDetalle)&&!ctype_digit($idRegistroProduccionDetalle)))return $this->setError("Tipo de dato incorrecto para idRegistroProduccionDetalle.");
			$this->idRegistroProduccionDetalle=$idRegistroProduccionDetalle;
			$this->getDatos();
		}
		public function setIdRegistroProduccion($idRegistroProduccion)
		{
			
			$this->idRegistroProduccion=$idRegistroProduccion;
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoSTOCK()
		{
			$this->tipo='STOCK';
		}
		public function setTipoPEDIDO()
		{
			$this->tipo='PEDIDO';
		}
		public function setTipoPYC()
		{
			$this->tipo='PYC';
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setIdPedidoDetalle($idPedidoDetalle)
		{
			
			$this->idPedidoDetalle=$idPedidoDetalle;
		}
		public function setPartida($partida)
		{
			$this->partida=$partida;
		}
		public function setLongitud($longitud)
		{
			$this->longitud=$longitud;
		}
		public function setKgml($kgml)
		{
			$this->kgml=$kgml;
		}
		public function setTotalKg($totalKg)
		{
			$this->totalKg=$totalKg;
		}
		public function setTotalReal($totalReal)
		{
			$this->totalReal=$totalReal;
		}
		public function setFecha_captura($fecha_captura)
		{
			$this->fecha_captura=$fecha_captura;
		}
		public function setId_usuario_captura($id_usuario_captura)
		{
			
			$this->id_usuario_captura=$id_usuario_captura;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRegistroProduccionDetalle()
		{
			return $this->idRegistroProduccionDetalle;
		}
		public function getIdRegistroProduccion()
		{
			return $this->idRegistroProduccion;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getIdPedidoDetalle()
		{
			return $this->idPedidoDetalle;
		}
		public function getPartida()
		{
			return $this->partida;
		}
		public function getLongitud()
		{
			return $this->longitud;
		}
		public function getKgml()
		{
			return $this->kgml;
		}
		public function getTotalKg()
		{
			return $this->totalKg;
		}
		public function getTotalReal()
		{
			return $this->totalReal;
		}
		public function getFecha_captura()
		{
			return $this->fecha_captura;
		}
		public function getId_usuario_captura()
		{
			return $this->id_usuario_captura;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRegistroProduccionDetalle=0;
			$this->idRegistroProduccion=0;
			$this->tipo='STOCK';
			$this->idProducto=0;
			$this->idPedidoDetalle=0;
			$this->partida='0';
			$this->longitud='0.00';
			$this->kgml='0.00';
			$this->totalKg='0.00';
			$this->totalReal='0.00';
			$this->fecha_captura='0000-00-00 00:00:00';
			$this->id_usuario_captura=0;
			$this->idSucursal=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRegistroProduccion,
				                                              tipo,
				                                              idProducto,
				                                              idPedidoDetalle,
				                                              partida,
				                                              longitud,
				                                              kgml,
				                                              totalKg,
				                                              totalReal,
				                                              fecha_captura,
				                                              id_usuario_captura,
				                                              idSucursal)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->partida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->longitud) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kgml) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalKg) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalReal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_captura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRegistroproducciondetalle::Insertar]");
				
				$this->idRegistroProduccionDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idRegistroProduccion='" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccion) . "',
	                                              tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              idPedidoDetalle='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
	                                              partida='" . mysqli_real_escape_string($this->dbLink,$this->partida) . "',
	                                              longitud='" . mysqli_real_escape_string($this->dbLink,$this->longitud) . "',
	                                              kgml='" . mysqli_real_escape_string($this->dbLink,$this->kgml) . "',
	                                              totalKg='" . mysqli_real_escape_string($this->dbLink,$this->totalKg) . "',
	                                              totalReal='" . mysqli_real_escape_string($this->dbLink,$this->totalReal) . "',
	                                              fecha_captura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
	                                              id_usuario_captura='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_captura) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "'
					WHERE idRegistroProduccionDetalle=" . $this->idRegistroProduccionDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRegistroproducciondetalle::Update]");
				
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
				WHERE idRegistroProduccionDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccionDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRegistroproducciondetalle::Borrar]");
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
						idRegistroProduccionDetalle,
						idRegistroProduccion,
						tipo,
						idProducto,
						idPedidoDetalle,
						partida,
						longitud,
						kgml,
						totalKg,
						totalReal,
						fecha_captura,
						id_usuario_captura,
						idSucursal
					FROM " . $this->__tableName . " 
					WHERE idRegistroProduccionDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccionDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRegistroproducciondetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRegistroProduccionDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>