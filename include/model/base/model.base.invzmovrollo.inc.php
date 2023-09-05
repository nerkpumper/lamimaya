<?php

	class ModeloBaseInvzmovrollo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseInvzmovrollo";

		
		var $idInvzmovRollo=0;
		var $idRollo=0;
		var $idRemisionRollo=0;
		var $documento='NINGUNO';
		var $referencia='0';
		var $movimiento='0';
		var $salidaDespacho='NO';
		var $existenciaRollo='0.00';
		var $existenciaNoRollo='0.00';
		var $cantidad='0.00';
		var $observaciones='';
		var $fecha_movimiento='0000-00-00 00:00:00';
		var $id_usuario_movimiento=0;
		var $idPedidoDetalle=0;
		var $idRegistroProduccion=0;
		var $idRegistroProduccionDetalle=0;
		var $idSucursal=0;
		var $piezas='0.00';
		var $isRPParaMoldura='NO';
		var $descontarDePiezas='NO';

		var $__s=array("idInvzmovRollo",
                       "idRollo",
                       "idRemisionRollo",
                       "documento",
                       "referencia",
                       "movimiento",
                       "salidaDespacho",
                       "existenciaRollo",
                       "existenciaNoRollo",
                       "cantidad",
                       "observaciones",
                       "fecha_movimiento",
                       "id_usuario_movimiento",
                       "idPedidoDetalle",
                       "idRegistroProduccion",
                       "idRegistroProduccionDetalle",
                       "idSucursal",
                       "piezas",
                       "isRPParaMoldura",
                       "descontarDePiezas");
				
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

		
		public function setIdInvzmovRollo($idInvzmovRollo)
		{
			if($idInvzmovRollo==0||$idInvzmovRollo==""||!is_numeric($idInvzmovRollo)|| (is_string($idInvzmovRollo)&&!ctype_digit($idInvzmovRollo)))return $this->setError("Tipo de dato incorrecto para idInvzmovRollo.");
			$this->idInvzmovRollo=$idInvzmovRollo;
			$this->getDatos();
		}
		public function setIdRollo($idRollo)
		{
			
			$this->idRollo=$idRollo;
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
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
		public function setDocumentoREMISION()
		{
			$this->documento='REMISION';
		}
		public function setDocumentoNINGUNO()
		{
			$this->documento='NINGUNO';
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
		public function setExistenciaRollo($existenciaRollo)
		{
			$this->existenciaRollo=$existenciaRollo;
		}
		public function setExistenciaNoRollo($existenciaNoRollo)
		{
			$this->existenciaNoRollo=$existenciaNoRollo;
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
		public function setIdRegistroProduccion($idRegistroProduccion)
		{
			
			$this->idRegistroProduccion=$idRegistroProduccion;
		}
		public function setIdRegistroProduccionDetalle($idRegistroProduccionDetalle)
		{
			
			$this->idRegistroProduccionDetalle=$idRegistroProduccionDetalle;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setPiezas($piezas)
		{
			$this->piezas=$piezas;
		}
		public function setIsRPParaMoldura($isRPParaMoldura)
		{
			
			$this->isRPParaMoldura=$isRPParaMoldura;
		}
		public function setIsRPParaMolduraSI()
		{
			$this->isRPParaMoldura='SI';
		}
		public function setIsRPParaMolduraNO()
		{
			$this->isRPParaMoldura='NO';
		}
		public function setDescontarDePiezas($descontarDePiezas)
		{
			
			$this->descontarDePiezas=$descontarDePiezas;
		}
		public function setDescontarDePiezasSI()
		{
			$this->descontarDePiezas='SI';
		}
		public function setDescontarDePiezasNO()
		{
			$this->descontarDePiezas='NO';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdInvzmovRollo()
		{
			return $this->idInvzmovRollo;
		}
		public function getIdRollo()
		{
			return $this->idRollo;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
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
		public function getExistenciaRollo()
		{
			return $this->existenciaRollo;
		}
		public function getExistenciaNoRollo()
		{
			return $this->existenciaNoRollo;
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
		public function getIdRegistroProduccion()
		{
			return $this->idRegistroProduccion;
		}
		public function getIdRegistroProduccionDetalle()
		{
			return $this->idRegistroProduccionDetalle;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getPiezas()
		{
			return $this->piezas;
		}
		public function getIsRPParaMoldura()
		{
			return $this->isRPParaMoldura;
		}
		public function getDescontarDePiezas()
		{
			return $this->descontarDePiezas;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idInvzmovRollo=0;
			$this->idRollo=0;
			$this->idRemisionRollo=0;
			$this->documento='NINGUNO';
			$this->referencia='0';
			$this->movimiento='0';
			$this->salidaDespacho='NO';
			$this->existenciaRollo='0.00';
			$this->existenciaNoRollo='0.00';
			$this->cantidad='0.00';
			$this->observaciones='';
			$this->fecha_movimiento='0000-00-00 00:00:00';
			$this->id_usuario_movimiento=0;
			$this->idPedidoDetalle=0;
			$this->idRegistroProduccion=0;
			$this->idRegistroProduccionDetalle=0;
			$this->idSucursal=0;
			$this->piezas='0.00';
			$this->isRPParaMoldura='NO';
			$this->descontarDePiezas='NO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRollo,
				                                              idRemisionRollo,
				                                              documento,
				                                              referencia,
				                                              movimiento,
				                                              salidaDespacho,
				                                              existenciaRollo,
				                                              existenciaNoRollo,
				                                              cantidad,
				                                              observaciones,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento,
				                                              idPedidoDetalle,
				                                              idRegistroProduccion,
				                                              idRegistroProduccionDetalle,
				                                              idSucursal,
				                                              piezas,
				                                              isRPParaMoldura,
				                                              descontarDePiezas)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->documento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->salidaDespacho) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existenciaRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existenciaNoRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccionDetalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->piezas) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isRPParaMoldura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descontarDePiezas) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmovrollo::Insertar]");
				
				$this->idInvzmovRollo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRollo) . "',
	                                              idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
	                                              documento='" . mysqli_real_escape_string($this->dbLink,$this->documento) . "',
	                                              referencia='" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
	                                              movimiento='" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
	                                              salidaDespacho='" . mysqli_real_escape_string($this->dbLink,$this->salidaDespacho) . "',
	                                              existenciaRollo='" . mysqli_real_escape_string($this->dbLink,$this->existenciaRollo) . "',
	                                              existenciaNoRollo='" . mysqli_real_escape_string($this->dbLink,$this->existenciaNoRollo) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
	                                              idPedidoDetalle='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle) . "',
	                                              idRegistroProduccion='" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccion) . "',
	                                              idRegistroProduccionDetalle='" . mysqli_real_escape_string($this->dbLink,$this->idRegistroProduccionDetalle) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              piezas='" . mysqli_real_escape_string($this->dbLink,$this->piezas) . "',
	                                              isRPParaMoldura='" . mysqli_real_escape_string($this->dbLink,$this->isRPParaMoldura) . "',
	                                              descontarDePiezas='" . mysqli_real_escape_string($this->dbLink,$this->descontarDePiezas) . "'
					WHERE idInvzmovRollo=" . $this->idInvzmovRollo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmovrollo::Update]");
				
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
				WHERE idInvzmovRollo=" . mysqli_real_escape_string($this->dbLink,$this->idInvzmovRollo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmovrollo::Borrar]");
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
						idInvzmovRollo,
						idRollo,
						idRemisionRollo,
						documento,
						referencia,
						movimiento,
						salidaDespacho,
						existenciaRollo,
						existenciaNoRollo,
						cantidad,
						observaciones,
						fecha_movimiento,
						id_usuario_movimiento,
						idPedidoDetalle,
						idRegistroProduccion,
						idRegistroProduccionDetalle,
						idSucursal,
						piezas,
						isRPParaMoldura,
						descontarDePiezas
					FROM " . $this->__tableName . " 
					WHERE idInvzmovRollo=" . mysqli_real_escape_string($this->dbLink,$this->idInvzmovRollo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseInvzmovrollo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idInvzmovRollo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>