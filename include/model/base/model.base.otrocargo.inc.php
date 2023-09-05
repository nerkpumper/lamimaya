<?php

	class ModeloBaseOtrocargo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseOtrocargo";

		
		var $idOtroCargo=0;
		var $descripcion='';
		var $ingreso='PESOS';
		var $solicitar='$';
		var $precioIngreso='1.00';
		var $automatico='NO';

		var $__s=array("idOtroCargo",
                       "descripcion",
                       "ingreso",
                       "solicitar",
                       "precioIngreso",
                       "automatico");
				
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

		
		public function setIdOtroCargo($idOtroCargo)
		{
			if($idOtroCargo==0||$idOtroCargo==""||!is_numeric($idOtroCargo)|| (is_string($idOtroCargo)&&!ctype_digit($idOtroCargo)))return $this->setError("Tipo de dato incorrecto para idOtroCargo.");
			$this->idOtroCargo=$idOtroCargo;
			$this->getDatos();
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setIngreso($ingreso)
		{
			
			$this->ingreso=$ingreso;
		}
		public function setIngresoPESOS()
		{
			$this->ingreso='PESOS';
		}
		public function setIngresoOTRO()
		{
			$this->ingreso='OTRO';
		}
		public function setSolicitar($solicitar)
		{
			
			$this->solicitar=$solicitar;
		}
		public function setPrecioIngreso($precioIngreso)
		{
			$this->precioIngreso=$precioIngreso;
		}
		public function setAutomatico($automatico)
		{
			
			$this->automatico=$automatico;
		}
		public function setAutomaticoSI()
		{
			$this->automatico='SI';
		}
		public function setAutomaticoNO()
		{
			$this->automatico='NO';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdOtroCargo()
		{
			return $this->idOtroCargo;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getIngreso()
		{
			return $this->ingreso;
		}
		public function getSolicitar()
		{
			return $this->solicitar;
		}
		public function getPrecioIngreso()
		{
			return $this->precioIngreso;
		}
		public function getAutomatico()
		{
			return $this->automatico;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idOtroCargo=0;
			$this->descripcion='';
			$this->ingreso='PESOS';
			$this->solicitar='$';
			$this->precioIngreso='1.00';
			$this->automatico='NO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (descripcion,
				                                              ingreso,
				                                              solicitar,
				                                              precioIngreso,
				                                              automatico)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ingreso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->solicitar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precioIngreso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->automatico) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtrocargo::Insertar]");
				
				$this->idOtroCargo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
	                                              ingreso='" . mysqli_real_escape_string($this->dbLink,$this->ingreso) . "',
	                                              solicitar='" . mysqli_real_escape_string($this->dbLink,$this->solicitar) . "',
	                                              precioIngreso='" . mysqli_real_escape_string($this->dbLink,$this->precioIngreso) . "',
	                                              automatico='" . mysqli_real_escape_string($this->dbLink,$this->automatico) . "'
					WHERE idOtroCargo=" . $this->idOtroCargo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtrocargo::Update]");
				
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
				WHERE idOtroCargo=" . mysqli_real_escape_string($this->dbLink,$this->idOtroCargo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtrocargo::Borrar]");
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
						idOtroCargo,
						descripcion,
						ingreso,
						solicitar,
						precioIngreso,
						automatico
					FROM " . $this->__tableName . " 
					WHERE idOtroCargo=" . mysqli_real_escape_string($this->dbLink,$this->idOtroCargo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseOtrocargo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idOtroCargo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>