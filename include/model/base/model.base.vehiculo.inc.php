<?php

	class ModeloBaseVehiculo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseVehiculo";

		
		var $idVehiculo=0;
		var $placas='0';
		var $descripcion='0';
		var $fecha_creacion='';
		var $disponibilidad='DISPONIBLE';

		var $__s=array("idVehiculo",
                       "placas",
                       "descripcion",
                       "fecha_creacion",
                       "disponibilidad");
				
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

		
		public function setIdVehiculo($idVehiculo)
		{
			if($idVehiculo==0||$idVehiculo==""||!is_numeric($idVehiculo)|| (is_string($idVehiculo)&&!ctype_digit($idVehiculo)))return $this->setError("Tipo de dato incorrecto para idVehiculo.");
			$this->idVehiculo=$idVehiculo;
			$this->getDatos();
		}
		public function setPlacas($placas)
		{
			
			$this->placas=$placas;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setDisponibilidad($disponibilidad)
		{
			
			$this->disponibilidad=$disponibilidad;
		}
		public function setDisponibilidadDISPONIBLE()
		{
			$this->disponibilidad='DISPONIBLE';
		}
		public function setDisponibilidadENRUTA()
		{
			$this->disponibilidad='ENRUTA';
		}
		public function setDisponibilidadENREPARACION()
		{
			$this->disponibilidad='ENREPARACION';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdVehiculo()
		{
			return $this->idVehiculo;
		}
		public function getPlacas()
		{
			return $this->placas;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getDisponibilidad()
		{
			return $this->disponibilidad;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idVehiculo=0;
			$this->placas='0';
			$this->descripcion='0';
			$this->fecha_creacion='';
			$this->disponibilidad='DISPONIBLE';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (placas,
				                                              descripcion,
				                                              fecha_creacion,
				                                              disponibilidad)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->placas) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               " . mysqli_real_escape_string($this->dbLink,"now()") . ",
				               '" . mysqli_real_escape_string($this->dbLink,$this->disponibilidad) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseVehiculo::Insertar]");
				
				$this->idVehiculo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET placas='" . mysqli_real_escape_string($this->dbLink,$this->placas) . "',
	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              disponibilidad='" . mysqli_real_escape_string($this->dbLink,$this->disponibilidad) . "'
					WHERE idVehiculo=" . $this->idVehiculo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseVehiculo::Update]");
				
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
				WHERE idVehiculo=" . mysqli_real_escape_string($this->dbLink,$this->idVehiculo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseVehiculo::Borrar]");
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
						idVehiculo,
						placas,
						descripcion,
						fecha_creacion,
						disponibilidad
					FROM " . $this->__tableName . " 
					WHERE idVehiculo=" . mysqli_real_escape_string($this->dbLink,$this->idVehiculo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseVehiculo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idVehiculo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>