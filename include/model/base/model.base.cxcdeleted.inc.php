<?php

	class ModeloBaseCxcdeleted extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCxcdeleted";

		
		var $idCxc=0;
		var $idPedido=0;
		var $idCliente=0;
		var $movimiento='CARGO';
		var $monto='0.00';
		var $saldoActual='0.00';
		var $isAnticipo='NO';
		var $cargoPorPedido='NO';
		var $formaPago=0;
		var $referencia='';
		var $fecha_movimiento='0000-00-00 00:00:00';
		var $id_usuario_movimiento=0;

		var $__s=array("idCxc",
                       "idPedido",
                       "idCliente",
                       "movimiento",
                       "monto",
                       "saldoActual",
                       "isAnticipo",
                       "cargoPorPedido",
                       "formaPago",
                       "referencia",
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

		
		public function setIdCxc($idCxc)
		{
			if($idCxc==0||$idCxc==""||!is_numeric($idCxc)|| (is_string($idCxc)&&!ctype_digit($idCxc)))return $this->setError("Tipo de dato incorrecto para idCxc.");
			$this->idCxc=$idCxc;
			$this->getDatos();
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setIdCliente($idCliente)
		{
			
			$this->idCliente=$idCliente;
		}
		public function setMovimiento($movimiento)
		{
			
			$this->movimiento=$movimiento;
		}
		public function setMovimientoCARGO()
		{
			$this->movimiento='CARGO';
		}
		public function setMovimientoABONO()
		{
			$this->movimiento='ABONO';
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setSaldoActual($saldoActual)
		{
			$this->saldoActual=$saldoActual;
		}
		public function setIsAnticipo($isAnticipo)
		{
			
			$this->isAnticipo=$isAnticipo;
		}
		public function setIsAnticipoSI()
		{
			$this->isAnticipo='SI';
		}
		public function setIsAnticipoNO()
		{
			$this->isAnticipo='NO';
		}
		public function setCargoPorPedido($cargoPorPedido)
		{
			
			$this->cargoPorPedido=$cargoPorPedido;
		}
		public function setCargoPorPedidoSI()
		{
			$this->cargoPorPedido='SI';
		}
		public function setCargoPorPedidoNO()
		{
			$this->cargoPorPedido='NO';
		}
		public function setFormaPago($formaPago)
		{
			
			$this->formaPago=$formaPago;
		}
		public function setReferencia($referencia)
		{
			
			$this->referencia=$referencia;
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

		
		public function getIdCxc()
		{
			return $this->idCxc;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getMovimiento()
		{
			return $this->movimiento;
		}
		public function getMonto()
		{
			return $this->monto;
		}
		public function getSaldoActual()
		{
			return $this->saldoActual;
		}
		public function getIsAnticipo()
		{
			return $this->isAnticipo;
		}
		public function getCargoPorPedido()
		{
			return $this->cargoPorPedido;
		}
		public function getFormaPago()
		{
			return $this->formaPago;
		}
		public function getReferencia()
		{
			return $this->referencia;
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
			
			$this->idCxc=0;
			$this->idPedido=0;
			$this->idCliente=0;
			$this->movimiento='CARGO';
			$this->monto='0.00';
			$this->saldoActual='0.00';
			$this->isAnticipo='NO';
			$this->cargoPorPedido='NO';
			$this->formaPago=0;
			$this->referencia='';
			$this->fecha_movimiento='0000-00-00 00:00:00';
			$this->id_usuario_movimiento=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPedido,
				                                              idCliente,
				                                              movimiento,
				                                              monto,
				                                              saldoActual,
				                                              isAnticipo,
				                                              cargoPorPedido,
				                                              formaPago,
				                                              referencia,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->isAnticipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cargoPorPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->formaPago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxcdeleted::Insertar]");
				
				$this->idCxc=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idPedido='" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
	                                              idCliente='" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
	                                              movimiento='" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              saldoActual='" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
	                                              isAnticipo='" . mysqli_real_escape_string($this->dbLink,$this->isAnticipo) . "',
	                                              cargoPorPedido='" . mysqli_real_escape_string($this->dbLink,$this->cargoPorPedido) . "',
	                                              formaPago='" . mysqli_real_escape_string($this->dbLink,$this->formaPago) . "',
	                                              referencia='" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "'
					WHERE idCxc=" . $this->idCxc;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxcdeleted::Update]");
				
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
				WHERE idCxc=" . mysqli_real_escape_string($this->dbLink,$this->idCxc);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxcdeleted::Borrar]");
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
						idCxc,
						idPedido,
						idCliente,
						movimiento,
						monto,
						saldoActual,
						isAnticipo,
						cargoPorPedido,
						formaPago,
						referencia,
						fecha_movimiento,
						id_usuario_movimiento
					FROM " . $this->__tableName . " 
					WHERE idCxc=" . mysqli_real_escape_string($this->dbLink,$this->idCxc);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCxcdeleted::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCxc==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>