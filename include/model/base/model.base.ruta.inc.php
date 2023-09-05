<?php

	class ModeloBaseRuta extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRuta";

		
		var $idRuta=0;
		var $nombre='';
		var $descripcion='';
		var $fecha_crea='0000-00-00 00:0:00';
		var $id_usuario_crea=0;

		var $__s=array("idRuta",
                       "nombre",
                       "descripcion",
                       "fecha_crea",
                       "id_usuario_crea");
				
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

		
		public function setIdRuta($idRuta)
		{
			if($idRuta==0||$idRuta==""||!is_numeric($idRuta)|| (is_string($idRuta)&&!ctype_digit($idRuta)))return $this->setError("Tipo de dato incorrecto para idRuta.");
			$this->idRuta=$idRuta;
			$this->getDatos();
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setFecha_crea($fecha_crea)
		{
			
			$this->fecha_crea=$fecha_crea;
		}
		public function setId_usuario_crea($id_usuario_crea)
		{
			
			$this->id_usuario_crea=$id_usuario_crea;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRuta()
		{
			return $this->idRuta;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getFecha_crea()
		{
			return $this->fecha_crea;
		}
		public function getId_usuario_crea()
		{
			return $this->id_usuario_crea;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRuta=0;
			$this->nombre='';
			$this->descripcion='';
			$this->fecha_crea='0000-00-00 00:0:00';
			$this->id_usuario_crea=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              descripcion,
				                                              fecha_crea,
				                                              id_usuario_crea)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRuta::Insertar]");
				
				$this->idRuta=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET nombre='" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
	                                              fecha_crea='" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
	                                              id_usuario_crea='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "'
					WHERE idRuta=" . $this->idRuta;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRuta::Update]");
				
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
				WHERE idRuta=" . mysqli_real_escape_string($this->dbLink,$this->idRuta);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRuta::Borrar]");
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
						idRuta,
						nombre,
						descripcion,
						fecha_crea,
						id_usuario_crea
					FROM " . $this->__tableName . " 
					WHERE idRuta=" . mysqli_real_escape_string($this->dbLink,$this->idRuta);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRuta::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRuta==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>