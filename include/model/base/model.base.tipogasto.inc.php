<?php

	class ModeloBaseTipogasto extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTipogasto";

		
		var $idTipoGasto=0;
		var $descripcion='';
		var $id_usuario_insert=0;
		var $fecha_insert='0000-00-00 00:00:00';
		var $id_usuario_update=0;
		var $fecha_update='0000-00-00 00:00:00';

		var $__s=array("idTipoGasto",
                       "descripcion",
                       "id_usuario_insert",
                       "fecha_insert",
                       "id_usuario_update",
                       "fecha_update");
				
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

		
		public function setIdTipoGasto($idTipoGasto)
		{
			if($idTipoGasto==0||$idTipoGasto==""||!is_numeric($idTipoGasto)|| (is_string($idTipoGasto)&&!ctype_digit($idTipoGasto)))return $this->setError("Tipo de dato incorrecto para idTipoGasto.");
			$this->idTipoGasto=$idTipoGasto;
			$this->getDatos();
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setId_usuario_insert($id_usuario_insert)
		{
			
			$this->id_usuario_insert=$id_usuario_insert;
		}
		public function setFecha_insert($fecha_insert)
		{
			$this->fecha_insert=$fecha_insert;
		}
		public function setId_usuario_update($id_usuario_update)
		{
			
			$this->id_usuario_update=$id_usuario_update;
		}
		public function setFecha_update($fecha_update)
		{
			$this->fecha_update=$fecha_update;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTipoGasto()
		{
			return $this->idTipoGasto;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getId_usuario_insert()
		{
			return $this->id_usuario_insert;
		}
		public function getFecha_insert()
		{
			return $this->fecha_insert;
		}
		public function getId_usuario_update()
		{
			return $this->id_usuario_update;
		}
		public function getFecha_update()
		{
			return $this->fecha_update;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTipoGasto=0;
			$this->descripcion='';
			$this->id_usuario_insert=0;
			$this->fecha_insert='0000-00-00 00:00:00';
			$this->id_usuario_update=0;
			$this->fecha_update='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (descripcion,
				                                              id_usuario_insert,
				                                              fecha_insert,
				                                              id_usuario_update,
				                                              fecha_update)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTipogasto::Insertar]");
				
				$this->idTipoGasto=mysqli_insert_id($this->dbLink);
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
	                                              id_usuario_insert='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
	                                              fecha_insert='" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
	                                              id_usuario_update='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "',
	                                              fecha_update='" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "'
					WHERE idTipoGasto=" . $this->idTipoGasto;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTipogasto::Update]");
				
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
				WHERE idTipoGasto=" . mysqli_real_escape_string($this->dbLink,$this->idTipoGasto);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTipogasto::Borrar]");
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
						idTipoGasto,
						descripcion,
						id_usuario_insert,
						fecha_insert,
						id_usuario_update,
						fecha_update
					FROM " . $this->__tableName . " 
					WHERE idTipoGasto=" . mysqli_real_escape_string($this->dbLink,$this->idTipoGasto);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTipogasto::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTipoGasto==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>