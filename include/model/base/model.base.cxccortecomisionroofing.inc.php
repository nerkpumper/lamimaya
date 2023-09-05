<?php

	class ModeloBaseCxccortecomisionroofing extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCxccortecomisionroofing";

		
		var $idCxcCorteComisionRoofing=0;
		var $idCorteComisionRoofing=0;
		var $idPromotor=0;
		var $movimiento='PORPAGAR';
		var $monto='0.00';
		var $saldoActual='0.00';
		var $observacion='';
		var $fecha_movimiento='0000-00-00 00:00:00';
		var $id_usuario_movimiento=0;

		var $__s=array("idCxcCorteComisionRoofing",
                       "idCorteComisionRoofing",
                       "idPromotor",
                       "movimiento",
                       "monto",
                       "saldoActual",
                       "observacion",
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

		
		public function setIdCxcCorteComisionRoofing($idCxcCorteComisionRoofing)
		{
			if($idCxcCorteComisionRoofing==0||$idCxcCorteComisionRoofing==""||!is_numeric($idCxcCorteComisionRoofing)|| (is_string($idCxcCorteComisionRoofing)&&!ctype_digit($idCxcCorteComisionRoofing)))return $this->setError("Tipo de dato incorrecto para idCxcCorteComisionRoofing.");
			$this->idCxcCorteComisionRoofing=$idCxcCorteComisionRoofing;
			$this->getDatos();
		}
		public function setIdCorteComisionRoofing($idCorteComisionRoofing)
		{
			
			$this->idCorteComisionRoofing=$idCorteComisionRoofing;
		}
		public function setIdPromotor($idPromotor)
		{
			
			$this->idPromotor=$idPromotor;
		}
		public function setMovimiento($movimiento)
		{
			
			$this->movimiento=$movimiento;
		}
		public function setMovimientoPORPAGAR()
		{
			$this->movimiento='PORPAGAR';
		}
		public function setMovimientoPAGO()
		{
			$this->movimiento='PAGO';
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setSaldoActual($saldoActual)
		{
			$this->saldoActual=$saldoActual;
		}
		public function setObservacion($observacion)
		{
			
			$this->observacion=$observacion;
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

		
		public function getIdCxcCorteComisionRoofing()
		{
			return $this->idCxcCorteComisionRoofing;
		}
		public function getIdCorteComisionRoofing()
		{
			return $this->idCorteComisionRoofing;
		}
		public function getIdPromotor()
		{
			return $this->idPromotor;
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
		public function getObservacion()
		{
			return $this->observacion;
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
			
			$this->idCxcCorteComisionRoofing=0;
			$this->idCorteComisionRoofing=0;
			$this->idPromotor=0;
			$this->movimiento='PORPAGAR';
			$this->monto='0.00';
			$this->saldoActual='0.00';
			$this->observacion='';
			$this->fecha_movimiento='0000-00-00 00:00:00';
			$this->id_usuario_movimiento=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCorteComisionRoofing,
				                                              idPromotor,
				                                              movimiento,
				                                              monto,
				                                              saldoActual,
				                                              observacion,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionRoofing) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxccortecomisionroofing::Insertar]");
				
				$this->idCxcCorteComisionRoofing=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idCorteComisionRoofing='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionRoofing) . "',
	                                              idPromotor='" . mysqli_real_escape_string($this->dbLink,$this->idPromotor) . "',
	                                              movimiento='" . mysqli_real_escape_string($this->dbLink,$this->movimiento) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              saldoActual='" . mysqli_real_escape_string($this->dbLink,$this->saldoActual) . "',
	                                              observacion='" . mysqli_real_escape_string($this->dbLink,$this->observacion) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "'
					WHERE idCxcCorteComisionRoofing=" . $this->idCxcCorteComisionRoofing;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxccortecomisionroofing::Update]");
				
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
				WHERE idCxcCorteComisionRoofing=" . mysqli_real_escape_string($this->dbLink,$this->idCxcCorteComisionRoofing);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxccortecomisionroofing::Borrar]");
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
						idCxcCorteComisionRoofing,
						idCorteComisionRoofing,
						idPromotor,
						movimiento,
						monto,
						saldoActual,
						observacion,
						fecha_movimiento,
						id_usuario_movimiento
					FROM " . $this->__tableName . " 
					WHERE idCxcCorteComisionRoofing=" . mysqli_real_escape_string($this->dbLink,$this->idCxcCorteComisionRoofing);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCxccortecomisionroofing::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCxcCorteComisionRoofing==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>