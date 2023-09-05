<?php

	class ModeloBaseInvzmov extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseInvzmov";

		
		var $idInvzmov=0;
		var $idProducto=0;
		var $documento='NINGUNO';
		var $referencia='0';
		var $movimiento='0';
		var $salidaDespacho='NO';
		var $existenciaProducto='0.00';
		var $existenciaProductoSucursal='0.00';
		var $cantidad='0.00';
		var $observaciones='';
		var $fecha_movimiento='0000-00-00 00:00:00';
		var $id_usuario_movimiento=0;
		var $idPedidoDetalle=0;
		var $idRemisionRollo=0;
		var $idSucursal=0;
		var $isML='NO';

		var $__s=array("idInvzmov",
                       "idProducto",
                       "documento",
                       "referencia",
                       "movimiento",
                       "salidaDespacho",
                       "existenciaProducto",
                       "existenciaProductoSucursal",
                       "cantidad",
                       "observaciones",
                       "fecha_movimiento",
                       "id_usuario_movimiento",
                       "idPedidoDetalle",
                       "idRemisionRollo",
                       "idSucursal",
                       "isML");
				
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

		
		public function setIdInvzmov($idInvzmov)
		{
			if($idInvzmov==0||$idInvzmov==""||!is_numeric($idInvzmov)|| (is_string($idInvzmov)&&!ctype_digit($idInvzmov)))return $this->setError("Tipo de dato incorrecto para idInvzmov.");
			$this->idInvzmov=$idInvzmov;
			$this->getDatos();
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setDocumento($documento)
		{
			
			$this->documento=$documento;
		}
		public function setDocumentoPEDIDO()
		{
			$this->documento='PEDIDO';
		}
		public function setDocumentoOC()
		{
			$this->documento='OC';
		}
		public function setDocumentoNINGUNO()
		{
			$this->documento='NINGUNO';
		}
		public function setDocumentoREGISTROPRODUCCION()
		{
			$this->documento='REGISTROPRODUCCION';
		}
		public function setDocumentoTRANSFERENCIA()
		{
			$this->documento='TRANSFERENCIA';
		}
		public function setReferencia($referencia)
		{
			
			$this->referencia=$referencia;
		}
		public function setMovimiento($movimiento)
		{
			
			$this->movimiento=$movimiento;
		}
		public function setMovimientoENTRADA()
		{
			$this->movimiento='ENTRADA';
		}
		public function setMovimientoSALIDA()
		{
			$this->movimiento='SALIDA';
		}
		public function setSalidaDespacho($salidaDespacho)
		{
			
			$this->salidaDespacho=$salidaDespacho;
		}
		public function setSalidaDespachoSI()
		{
			$this->salidaDespacho='SI';
		}
		public function setSalidaDespachoNO()
		{
			$this->salidaDespacho='NO';
		}
		public function setExistenciaProducto($existenciaProducto)
		{
			$this->existenciaProducto=$existenciaProducto;
		}
		public function setExistenciaProductoSucursal($existenciaProductoSucursal)
		{
			$this->existenciaProductoSucursal=$existenciaProductoSucursal;
		}
		public function setCantidad($cantidad)
		{
			$this->cantidad=$cantidad;
		}
		public function setObservaciones($observaciones)
		{
			
			$this->observaciones=$observaciones;
		}
		public function setFecha_movimiento($fecha_movimiento)
		{
			$this->fecha_movimiento=$fecha_movimiento;
		}
		public function setId_usuario_movimiento($id_usuario_movimiento)
		{
			
			$this->id_usuario_movimiento=$id_usuario_movimiento;
		}
		public function setIdPedidoDetalle($idPedidoDetalle)
		{
			
			$this->idPedidoDetalle=$idPedidoDetalle;
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setIsML($isML)
		{
			
			$this->isML=$isML;
		}
		public function setIsMLSI()
		{
			$this->isML='SI';
		}
		public function setIsMLNO()
		{
			$this->isML='NO';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdInvzmov()
		{
			return $this->idInvzmov;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getDocumento()
		{
			return $this->documento;
		}
		public function getReferencia()
		{
			return $this->referencia;
		}
		public function getMovimiento()
		{
			return $this->movimiento;
		}
		public function getSalidaDespacho()
		{
			return $this->salidaDespacho;
		}
		public function getExistenciaProducto()
		{
			return $this->existenciaProducto;
		}
		public function getExistenciaProductoSucursal()
		{
			return $this->existenciaProductoSucursal;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}
		public function getObservaciones()
		{
			return $this->observaciones;
		}
		public function getFecha_movimiento()
		{
			return $this->fecha_movimiento;
		}
		public function getId_usuario_movimiento()
		{
			return $this->id_usuario_movimiento;
		}
		public function getIdPedidoDetalle()
		{
			return $this->idPedidoDetalle;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getIsML()
		{
			return $this->isML;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idInvzmov=0;
			$this->idProducto=0;
			$this->documento='NINGUNO';
			$this->referencia='0';
			$this->movimiento='0';
			$this->salidaDespacho='NO';
			$this->existenciaProducto='0.00';
			$this->existenciaProductoSucursal='0.00';
			$this->cantidad='0.00';
			$this->observaciones='';
			$this->fecha_movimiento='0000-00-00 00:00:00';
			$this->id_usuario_movimiento=0;
			$this->idPedidoDetalle=0;
			$this->idRemisionRollo=0;
			$this->idSucursal=0;
			$this->isML='NO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idProducto,
				                                              documento,
				                                              referencia,
				                                              movimiento,
				                                              salidaDespacho,
				                                              existenciaProducto,
				                                              existenciaProductoSucursal,
				                                              cantidad,
				                                              observaciones,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento,
				                                              idPedidoDetalle,
				                                              idRemisionRollo,
				                                              idSucursal,
				                                              isML)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->documento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->salidaDespacho) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existenciaProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existenciaProductoSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isML) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmov::Insertar]");
				
				$this->idInvzmov=mysqli_insert_id($this->dbLink);
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
	                                              documento='" . mysqli_real_escape_string($this->dbLink,$this->documento) . "',
	                                              referencia='" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
	                                              movimiento='" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
	                                              salidaDespacho='" . mysqli_real_escape_string($this->dbLink,$this->salidaDespacho) . "',
	                                              existenciaProducto='" . mysqli_real_escape_string($this->dbLink,$this->existenciaProducto) . "',
	                                              existenciaProductoSucursal='" . mysqli_real_escape_string($this->dbLink,$this->existenciaProductoSucursal) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
	                                              idPedidoDetalle='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
	                                              idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              isML='" . mysqli_real_escape_string($this->dbLink,$this->isML) . "'
					WHERE idInvzmov=" . $this->idInvzmov;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmov::Update]");
				
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
				WHERE idInvzmov=" . mysqli_real_escape_string($this->dbLink,$this->idInvzmov);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmov::Borrar]");
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
						idInvzmov,
						idProducto,
						documento,
						referencia,
						movimiento,
						salidaDespacho,
						existenciaProducto,
						existenciaProductoSucursal,
						cantidad,
						observaciones,
						fecha_movimiento,
						id_usuario_movimiento,
						idPedidoDetalle,
						idRemisionRollo,
						idSucursal,
						isML
					FROM " . $this->__tableName . " 
					WHERE idInvzmov=" . mysqli_real_escape_string($this->dbLink,$this->idInvzmov);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseInvzmov::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idInvzmov==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>