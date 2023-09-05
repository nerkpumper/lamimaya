<?php

	class ModeloBaseRecibodinero extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRecibodinero";

		
		var $idReciboDinero=0;
		var $idCliente=0;
		var $monto='0';
		var $disponible='0';
		var $formaPago=0;
		var $referencia='0';
		var $fecha_captura='0';
		var $id_usuario_captura=0;

		var $__s=array("idReciboDinero",
                       "idCliente",
                       "monto",
                       "disponible",
                       "formaPago",
                       "referencia",
                       "fecha_captura",
                       "id_usuario_captura");
				
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

		
		public function setIdReciboDinero($idReciboDinero)
		{
			if($idReciboDinero==0||$idReciboDinero==""||!is_numeric($idReciboDinero)|| (is_string($idReciboDinero)&&!ctype_digit($idReciboDinero)))return $this->setError("Tipo de dato incorrecto para idReciboDinero.");
			$this->idReciboDinero=$idReciboDinero;
			$this->getDatos();
		}
		public function setIdCliente($idCliente)
		{
			
			$this->idCliente=$idCliente;
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setDisponible($disponible)
		{
			$this->disponible=$disponible;
		}
		public function setFormaPago($formaPago)
		{
			
			$this->formaPago=$formaPago;
		}
		public function setReferencia($referencia)
		{
			
			$this->referencia=$referencia;
		}
		public function setFecha_captura($fecha_captura)
		{
			$this->fecha_captura=$fecha_captura;
		}
		public function setId_usuario_captura($id_usuario_captura)
		{
			
			$this->id_usuario_captura=$id_usuario_captura;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdReciboDinero()
		{
			return $this->idReciboDinero;
		}
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getMonto()
		{
			return $this->monto;
		}
		public function getDisponible()
		{
			return $this->disponible;
		}
		public function getFormaPago()
		{
			return $this->formaPago;
		}
		public function getReferencia()
		{
			return $this->referencia;
		}
		public function getFecha_captura()
		{
			return $this->fecha_captura;
		}
		public function getId_usuario_captura()
		{
			return $this->id_usuario_captura;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idReciboDinero=0;
			$this->idCliente=0;
			$this->monto='0';
			$this->disponible='0';
			$this->formaPago=0;
			$this->referencia='0';
			$this->fecha_captura='0';
			$this->id_usuario_captura=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCliente,
				                                              monto,
				                                              disponible,
				                                              formaPago,
				                                              referencia,
				                                              fecha_captura,
				                                              id_usuario_captura)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->disponible) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->formaPago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_captura) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRecibodinero::Insertar]");
				
				$this->idReciboDinero=mysqli_insert_id($this->dbLink);
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
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              disponible='" . mysqli_real_escape_string($this->dbLink,$this->disponible) . "',
	                                              formaPago='" . mysqli_real_escape_string($this->dbLink,$this->formaPago) . "',
	                                              referencia='" . mysqli_real_escape_string($this->dbLink,$this->referencia) . "',
	                                              fecha_captura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_captura) . "',
	                                              id_usuario_captura='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_captura) . "'
					WHERE idReciboDinero=" . $this->idReciboDinero;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRecibodinero::Update]");
				
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
				WHERE idReciboDinero=" . mysqli_real_escape_string($this->dbLink,$this->idReciboDinero);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRecibodinero::Borrar]");
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
						idReciboDinero,
						idCliente,
						monto,
						disponible,
						formaPago,
						referencia,
						fecha_captura,
						id_usuario_captura
					FROM " . $this->__tableName . " 
					WHERE idReciboDinero=" . mysqli_real_escape_string($this->dbLink,$this->idReciboDinero);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRecibodinero::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idReciboDinero==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>