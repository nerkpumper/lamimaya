<?php

	class ModeloBaseOtroscargospedido extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseOtroscargospedido";

		
		var $idOtrosCargosPedido=0;
		var $idPedido=0;
		var $idOtroCargo=0;
		var $cantidadIngreso='0.00';
		var $monto='0.00';

		var $__s=array("idOtrosCargosPedido",
                       "idPedido",
                       "idOtroCargo",
                       "cantidadIngreso",
                       "monto");
				
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

		
		public function setIdOtrosCargosPedido($idOtrosCargosPedido)
		{
			if($idOtrosCargosPedido==0||$idOtrosCargosPedido==""||!is_numeric($idOtrosCargosPedido)|| (is_string($idOtrosCargosPedido)&&!ctype_digit($idOtrosCargosPedido)))return $this->setError("Tipo de dato incorrecto para idOtrosCargosPedido.");
			$this->idOtrosCargosPedido=$idOtrosCargosPedido;
			$this->getDatos();
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setIdOtroCargo($idOtroCargo)
		{
			
			$this->idOtroCargo=$idOtroCargo;
		}
		public function setCantidadIngreso($cantidadIngreso)
		{
			$this->cantidadIngreso=$cantidadIngreso;
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdOtrosCargosPedido()
		{
			return $this->idOtrosCargosPedido;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getIdOtroCargo()
		{
			return $this->idOtroCargo;
		}
		public function getCantidadIngreso()
		{
			return $this->cantidadIngreso;
		}
		public function getMonto()
		{
			return $this->monto;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idOtrosCargosPedido=0;
			$this->idPedido=0;
			$this->idOtroCargo=0;
			$this->cantidadIngreso='0.00';
			$this->monto='0.00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPedido,
				                                              idOtroCargo,
				                                              cantidadIngreso,
				                                              monto)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idOtroCargo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidadIngreso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtroscargospedido::Insertar]");
				
				$this->idOtrosCargosPedido=mysqli_insert_id($this->dbLink);
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
	                                              idOtroCargo='" . mysqli_real_escape_string($this->dbLink,$this->idOtroCargo) . "',
	                                              cantidadIngreso='" . mysqli_real_escape_string($this->dbLink,$this->cantidadIngreso) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "'
					WHERE idOtrosCargosPedido=" . $this->idOtrosCargosPedido;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtroscargospedido::Update]");
				
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
				WHERE idOtrosCargosPedido=" . mysqli_real_escape_string($this->dbLink,$this->idOtrosCargosPedido);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtroscargospedido::Borrar]");
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
						idOtrosCargosPedido,
						idPedido,
						idOtroCargo,
						cantidadIngreso,
						monto
					FROM " . $this->__tableName . " 
					WHERE idOtrosCargosPedido=" . mysqli_real_escape_string($this->dbLink,$this->idOtrosCargosPedido);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseOtroscargospedido::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idOtrosCargosPedido==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>