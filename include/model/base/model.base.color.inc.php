<?php

	class ModeloBaseColor extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseColor";

		
		var $idColor=0;
		var $nombre='';
		var $clave='';
		var $estado='ACTIVO';
		var $fecha_crea='0000-00-00 00:00:00';
		var $id_usuario_crea=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $id_usuario_modifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $id_usuario_baja=0;

		var $__s=array("idColor",
                       "nombre",
                       "clave",
                       "estado",
                       "fecha_crea",
                       "id_usuario_crea",
                       "fecha_modifica",
                       "id_usuario_modifica",
                       "fecha_baja",
                       "id_usuario_baja");
				
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

		
		public function setIdColor($idColor)
		{
			if($idColor==0||$idColor==""||!is_numeric($idColor)|| (is_string($idColor)&&!ctype_digit($idColor)))return $this->setError("Tipo de dato incorrecto para idColor.");
			$this->idColor=$idColor;
			$this->getDatos();
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setClave($clave)
		{
			
			$this->clave=$clave;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoACTIVO()
		{
			$this->estado='ACTIVO';
		}
		public function setEstadoBAJA()
		{
			$this->estado='BAJA';
		}
		public function setFecha_crea($fecha_crea)
		{
			$this->fecha_crea=$fecha_crea;
		}
		public function setId_usuario_crea($id_usuario_crea)
		{
			
			$this->id_usuario_crea=$id_usuario_crea;
		}
		public function setFecha_modifica($fecha_modifica)
		{
			$this->fecha_modifica=$fecha_modifica;
		}
		public function setId_usuario_modifica($id_usuario_modifica)
		{
			
			$this->id_usuario_modifica=$id_usuario_modifica;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setId_usuario_baja($id_usuario_baja)
		{
			
			$this->id_usuario_baja=$id_usuario_baja;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdColor()
		{
			return $this->idColor;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getClave()
		{
			return $this->clave;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getFecha_crea()
		{
			return $this->fecha_crea;
		}
		public function getId_usuario_crea()
		{
			return $this->id_usuario_crea;
		}
		public function getFecha_modifica()
		{
			return $this->fecha_modifica;
		}
		public function getId_usuario_modifica()
		{
			return $this->id_usuario_modifica;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getId_usuario_baja()
		{
			return $this->id_usuario_baja;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idColor=0;
			$this->nombre='';
			$this->clave='';
			$this->estado='ACTIVO';
			$this->fecha_crea='0000-00-00 00:00:00';
			$this->id_usuario_crea=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->id_usuario_modifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->id_usuario_baja=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              clave,
				                                              estado,
				                                              fecha_crea,
				                                              id_usuario_crea,
				                                              fecha_modifica,
				                                              id_usuario_modifica,
				                                              fecha_baja,
				                                              id_usuario_baja)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->clave) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_baja) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseColor::Insertar]");
				
				$this->idColor=mysqli_insert_id($this->dbLink);
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
	                                              clave='" . mysqli_real_escape_string($this->dbLink,$this->clave) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_crea='" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
	                                              id_usuario_crea='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              id_usuario_modifica='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              id_usuario_baja='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_baja) . "'
					WHERE idColor=" . $this->idColor;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseColor::Update]");
				
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
				WHERE idColor=" . mysqli_real_escape_string($this->dbLink,$this->idColor);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseColor::Borrar]");
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
						idColor,
						nombre,
						clave,
						estado,
						fecha_crea,
						id_usuario_crea,
						fecha_modifica,
						id_usuario_modifica,
						fecha_baja,
						id_usuario_baja
					FROM " . $this->__tableName . " 
					WHERE idColor=" . mysqli_real_escape_string($this->dbLink,$this->idColor);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseColor::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idColor==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>