<?php

	class ModeloBaseCxccuentacomision extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCxccuentacomision";

		
		var $idCxcCuentaComision=0;
		var $idUsuario=0;
		var $tipo='DEDUCIR';
		var $idConceptoGasto=0;
		var $fecha_creacion='0000-00-00 00:00:00';
		var $id_usuario_creacion=0;
		var $monto='0.00';
		var $observacion='';
		var $idCorteComision=0;

		var $__s=array("idCxcCuentaComision",
                       "idUsuario",
                       "tipo",
                       "idConceptoGasto",
                       "fecha_creacion",
                       "id_usuario_creacion",
                       "monto",
                       "observacion",
                       "idCorteComision");
				
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

		
		public function setIdCxcCuentaComision($idCxcCuentaComision)
		{
			if($idCxcCuentaComision==0||$idCxcCuentaComision==""||!is_numeric($idCxcCuentaComision)|| (is_string($idCxcCuentaComision)&&!ctype_digit($idCxcCuentaComision)))return $this->setError("Tipo de dato incorrecto para idCxcCuentaComision.");
			$this->idCxcCuentaComision=$idCxcCuentaComision;
			$this->getDatos();
		}
		public function setIdUsuario($idUsuario)
		{
			
			$this->idUsuario=$idUsuario;
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoDEDUCIR()
		{
			$this->tipo='DEDUCIR';
		}
		public function setTipoPAGAR()
		{
			$this->tipo='PAGAR';
		}
		public function setTipoINCENTIVO()
		{
			$this->tipo='INCENTIVO';
		}
		public function setIdConceptoGasto($idConceptoGasto)
		{
			
			$this->idConceptoGasto=$idConceptoGasto;
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setId_usuario_creacion($id_usuario_creacion)
		{
			
			$this->id_usuario_creacion=$id_usuario_creacion;
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setObservacion($observacion)
		{
			
			$this->observacion=$observacion;
		}
		public function setIdCorteComision($idCorteComision)
		{
			
			$this->idCorteComision=$idCorteComision;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCxcCuentaComision()
		{
			return $this->idCxcCuentaComision;
		}
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getIdConceptoGasto()
		{
			return $this->idConceptoGasto;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getId_usuario_creacion()
		{
			return $this->id_usuario_creacion;
		}
		public function getMonto()
		{
			return $this->monto;
		}
		public function getObservacion()
		{
			return $this->observacion;
		}
		public function getIdCorteComision()
		{
			return $this->idCorteComision;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCxcCuentaComision=0;
			$this->idUsuario=0;
			$this->tipo='DEDUCIR';
			$this->idConceptoGasto=0;
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->id_usuario_creacion=0;
			$this->monto='0.00';
			$this->observacion='';
			$this->idCorteComision=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idUsuario,
				                                              tipo,
				                                              idConceptoGasto,
				                                              fecha_creacion,
				                                              id_usuario_creacion,
				                                              monto,
				                                              observacion,
				                                              idCorteComision)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idConceptoGasto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComision) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxccuentacomision::Insertar]");
				
				$this->idCxcCuentaComision=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "',
	                                              tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              idConceptoGasto='" . mysqli_real_escape_string($this->dbLink,$this->idConceptoGasto) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              id_usuario_creacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              observacion='" . mysqli_real_escape_string($this->dbLink,$this->observacion) . "',
	                                              idCorteComision='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComision) . "'
					WHERE idCxcCuentaComision=" . $this->idCxcCuentaComision;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxccuentacomision::Update]");
				
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
				WHERE idCxcCuentaComision=" . mysqli_real_escape_string($this->dbLink,$this->idCxcCuentaComision);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCxccuentacomision::Borrar]");
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
						idCxcCuentaComision,
						idUsuario,
						tipo,
						idConceptoGasto,
						fecha_creacion,
						id_usuario_creacion,
						monto,
						observacion,
						idCorteComision
					FROM " . $this->__tableName . " 
					WHERE idCxcCuentaComision=" . mysqli_real_escape_string($this->dbLink,$this->idCxcCuentaComision);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCxccuentacomision::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCxcCuentaComision==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>