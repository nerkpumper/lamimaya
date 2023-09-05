<?php

	class ModeloBaseMovrecibodinero extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseMovrecibodinero";

		
		var $idmovReciboDinero=0;
		var $idCliente=0;
		var $idReciboDinero=0;
		var $idPedido=0;
		var $saldoAnterior='0';
		var $saldoActual='0';
		var $monto='0.00';
		var $fecha_movimiento='0';
		var $id_usuario_movimiento=0;
		var $observaciones='0';
		var $movimiento='0';

		var $__s=array("idmovReciboDinero",
                       "idCliente",
                       "idReciboDinero",
                       "idPedido",
                       "saldoAnterior",
                       "saldoActual",
                       "monto",
                       "fecha_movimiento",
                       "id_usuario_movimiento",
                       "observaciones",
                       "movimiento");
				
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

		
		public function setIdmovReciboDinero($idmovReciboDinero)
		{
			if($idmovReciboDinero==0||$idmovReciboDinero==""||!is_numeric($idmovReciboDinero)|| (is_string($idmovReciboDinero)&&!ctype_digit($idmovReciboDinero)))return $this->setError("Tipo de dato incorrecto para idmovReciboDinero.");
			$this->idmovReciboDinero=$idmovReciboDinero;
			$this->getDatos();
		}
		public function setIdCliente($idCliente)
		{
			
			$this->idCliente=$idCliente;
		}
		public function setIdReciboDinero($idReciboDinero)
		{
			
			$this->idReciboDinero=$idReciboDinero;
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setSaldoAnterior($saldoAnterior)
		{
			$this->saldoAnterior=$saldoAnterior;
		}
		public function setSaldoActual($saldoActual)
		{
			$this->saldoActual=$saldoActual;
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setFecha_movimiento($fecha_movimiento)
		{
			$this->fecha_movimiento=$fecha_movimiento;
		}
		public function setId_usuario_movimiento($id_usuario_movimiento)
		{
			
			$this->id_usuario_movimiento=$id_usuario_movimiento;
		}
		public function setObservaciones($observaciones)
		{
			
			$this->observaciones=$observaciones;
		}
		public function setMovimiento($movimiento)
		{
			
			$this->movimiento=$movimiento;
		}
		public function setMovimientoGENERARECIBO()
		{
			$this->movimiento='GENERARECIBO';
		}
		public function setMovimientoUSADOENPEDIDO()
		{
			$this->movimiento='USADOENPEDIDO';
		}
		public function setMovimientoREGRESARDINEROACLIENTE()
		{
			$this->movimiento='REGRESARDINEROACLIENTE';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdmovReciboDinero()
		{
			return $this->idmovReciboDinero;
		}
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getIdReciboDinero()
		{
			return $this->idReciboDinero;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getSaldoAnterior()
		{
			return $this->saldoAnterior;
		}
		public function getSaldoActual()
		{
			return $this->saldoActual;
		}
		public function getMonto()
		{
			return $this->monto;
		}
		public function getFecha_movimiento()
		{
			return $this->fecha_movimiento;
		}
		public function getId_usuario_movimiento()
		{
			return $this->id_usuario_movimiento;
		}
		public function getObservaciones()
		{
			return $this->observaciones;
		}
		public function getMovimiento()
		{
			return $this->movimiento;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idmovReciboDinero=0;
			$this->idCliente=0;
			$this->idReciboDinero=0;
			$this->idPedido=0;
			$this->saldoAnterior='0';
			$this->saldoActual='0';
			$this->monto='0.00';
			$this->fecha_movimiento='0';
			$this->id_usuario_movimiento=0;
			$this->observaciones='0';
			$this->movimiento='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCliente,
				                                              idReciboDinero,
				                                              idPedido,
				                                              saldoAnterior,
				                                              saldoActual,
				                                              monto,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento,
				                                              observaciones,
				                                              movimiento)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idReciboDinero) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldoAnterior) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMovrecibodinero::Insertar]");
				
				$this->idmovReciboDinero=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idCliente='" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
	                                              idReciboDinero='" . mysqli_real_escape_string($this->dbLink,$this->idReciboDinero) . "',
	                                              idPedido='" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
	                                              saldoAnterior='" . mysqli_real_escape_string($this->dbLink,$this->saldoAnterior) . "',
	                                              saldoActual='" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
	                                              movimiento='" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "'
					WHERE idmovReciboDinero=" . $this->idmovReciboDinero;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMovrecibodinero::Update]");
				
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
				WHERE idmovReciboDinero=" . mysqli_real_escape_string($this->dbLink,$this->idmovReciboDinero);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseMovrecibodinero::Borrar]");
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
						idmovReciboDinero,
						idCliente,
						idReciboDinero,
						idPedido,
						saldoAnterior,
						saldoActual,
						monto,
						fecha_movimiento,
						id_usuario_movimiento,
						observaciones,
						movimiento
					FROM " . $this->__tableName . " 
					WHERE idmovReciboDinero=" . mysqli_real_escape_string($this->dbLink,$this->idmovReciboDinero);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseMovrecibodinero::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idmovReciboDinero==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>