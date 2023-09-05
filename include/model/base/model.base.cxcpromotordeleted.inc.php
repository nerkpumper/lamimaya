<?php

	class ModeloBaseCxcpromotordeleted extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCxcpromotordeleted";

		
		var $idCxcPromotor=0;
		var $idPedido=0;
		var $idCliente=0;
		var $movimiento='CARGO';
		var $monto='0.00';
		var $saldoActual='0.00';
		var $formaPago=0;
		var $referencia='';
		var $fecha_movimiento='0000-00-00 00:00:00';
		var $id_usuario_movimiento=0;

		var $__s=array("idCxcPromotor",
                       "idPedido",
                       "idCliente",
                       "movimiento",
                       "monto",
                       "saldoActual",
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

		
		public function setIdCxcPromotor($idCxcPromotor)
		{
			if($idCxcPromotor==0||$idCxcPromotor==""||!is_numeric($idCxcPromotor)|| (is_string($idCxcPromotor)&&!ctype_digit($idCxcPromotor)))return $this->setError("Tipo de dato incorrecto para idCxcPromotor.");
			$this->idCxcPromotor=$idCxcPromotor;
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

		
		public function getIdCxcPromotor()
		{
			return $this->idCxcPromotor;
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
			
			$this->idCxcPromotor=0;
			$this->idPedido=0;
			$this->idCliente=0;
			$this->movimiento='CARGO';
			$this->monto='0.00';
			$this->saldoActual='0.00';
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
				                                              formaPago,
				                                              referencia,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->formaPago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxcpromotordeleted::Insertar]");
				
				$this->idCxcPromotor=mysqli_insert_id($this->dbLink);
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
	                                              formaPago='" . mysqli_real_escape_string($this->dbLink,$this->formaPago) . "',
	                                              referencia='" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "'
					WHERE idCxcPromotor=" . $this->idCxcPromotor;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxcpromotordeleted::Update]");
				
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
				WHERE idCxcPromotor=" . mysqli_real_escape_string($this->dbLink,$this->idCxcPromotor);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxcpromotordeleted::Borrar]");
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
						idCxcPromotor,
						idPedido,
						idCliente,
						movimiento,
						monto,
						saldoActual,
						formaPago,
						referencia,
						fecha_movimiento,
						id_usuario_movimiento
					FROM " . $this->__tableName . " 
					WHERE idCxcPromotor=" . mysqli_real_escape_string($this->dbLink,$this->idCxcPromotor);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCxcpromotordeleted::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCxcPromotor==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>