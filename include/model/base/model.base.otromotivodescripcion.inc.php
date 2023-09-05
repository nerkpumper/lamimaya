<?php

	class ModeloBaseOtromotivodescripcion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseOtromotivodescripcion";

		
		var $IdOtroMotivoDescripcion=0;
		var $idCotizacionRechazada=0;
		var $descripcion='0';

		var $__s=array("IdOtroMotivoDescripcion",
                       "idCotizacionRechazada",
                       "descripcion");
				
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

		
		public function setIdOtroMotivoDescripcion($IdOtroMotivoDescripcion)
		{
			if($IdOtroMotivoDescripcion==0||$IdOtroMotivoDescripcion==""||!is_numeric($IdOtroMotivoDescripcion)|| (is_string($IdOtroMotivoDescripcion)&&!ctype_digit($IdOtroMotivoDescripcion)))return $this->setError("Tipo de dato incorrecto para IdOtroMotivoDescripcion.");
			$this->IdOtroMotivoDescripcion=$IdOtroMotivoDescripcion;
			$this->getDatos();
		}
		public function setIdCotizacionRechazada($idCotizacionRechazada)
		{
			
			$this->idCotizacionRechazada=$idCotizacionRechazada;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdOtroMotivoDescripcion()
		{
			return $this->IdOtroMotivoDescripcion;
		}
		public function getIdCotizacionRechazada()
		{
			return $this->idCotizacionRechazada;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->IdOtroMotivoDescripcion=0;
			$this->idCotizacionRechazada=0;
			$this->descripcion='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCotizacionRechazada,
				                                              descripcion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCotizacionRechazada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtromotivodescripcion::Insertar]");
				
				$this->IdOtroMotivoDescripcion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idCotizacionRechazada='" . mysqli_real_escape_string($this->dbLink,$this->idCotizacionRechazada) . "',
	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "'
					WHERE IdOtroMotivoDescripcion=" . $this->IdOtroMotivoDescripcion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtromotivodescripcion::Update]");
				
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
				WHERE IdOtroMotivoDescripcion=" . mysqli_real_escape_string($this->dbLink,$this->IdOtroMotivoDescripcion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseOtromotivodescripcion::Borrar]");
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
						IdOtroMotivoDescripcion,
						idCotizacionRechazada,
						descripcion
					FROM " . $this->__tableName . " 
					WHERE IdOtroMotivoDescripcion=" . mysqli_real_escape_string($this->dbLink,$this->IdOtroMotivoDescripcion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseOtromotivodescripcion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->IdOtroMotivoDescripcion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>