<?php

	class ModeloBaseTomainventario extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTomainventario";

		
		var $idTomaInventario=0;
		var $fecha_inicio='0000-00-00 00:00:00';
		var $id_usuario_inicio=0;
		var $fecha_fin='0000-00-00 00:00:00';
		var $id_usuario_fin=0;
		var $estado='ACTIVO';

		var $__s=array("idTomaInventario",
                       "fecha_inicio",
                       "id_usuario_inicio",
                       "fecha_fin",
                       "id_usuario_fin",
                       "estado");
				
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

		
		public function setIdTomaInventario($idTomaInventario)
		{
			if($idTomaInventario==0||$idTomaInventario==""||!is_numeric($idTomaInventario)|| (is_string($idTomaInventario)&&!ctype_digit($idTomaInventario)))return $this->setError("Tipo de dato incorrecto para idTomaInventario.");
			$this->idTomaInventario=$idTomaInventario;
			$this->getDatos();
		}
		public function setFecha_inicio($fecha_inicio)
		{
			$this->fecha_inicio=$fecha_inicio;
		}
		public function setId_usuario_inicio($id_usuario_inicio)
		{
			
			$this->id_usuario_inicio=$id_usuario_inicio;
		}
		public function setFecha_fin($fecha_fin)
		{
			$this->fecha_fin=$fecha_fin;
		}
		public function setId_usuario_fin($id_usuario_fin)
		{
			
			$this->id_usuario_fin=$id_usuario_fin;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoACTIVO()
		{
			$this->estado='ACTIVO';
		}
		public function setEstadoTOMADO()
		{
			$this->estado='TOMADO';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTomaInventario()
		{
			return $this->idTomaInventario;
		}
		public function getFecha_inicio()
		{
			return $this->fecha_inicio;
		}
		public function getId_usuario_inicio()
		{
			return $this->id_usuario_inicio;
		}
		public function getFecha_fin()
		{
			return $this->fecha_fin;
		}
		public function getId_usuario_fin()
		{
			return $this->id_usuario_fin;
		}
		public function getEstado()
		{
			return $this->estado;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTomaInventario=0;
			$this->fecha_inicio='0000-00-00 00:00:00';
			$this->id_usuario_inicio=0;
			$this->fecha_fin='0000-00-00 00:00:00';
			$this->id_usuario_fin=0;
			$this->estado='ACTIVO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (fecha_inicio,
				                                              id_usuario_inicio,
				                                              fecha_fin,
				                                              id_usuario_fin,
				                                              estado)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->fecha_inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTomainventario::Insertar]");
				
				$this->idTomaInventario=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET fecha_inicio='" . mysqli_real_escape_string($this->dbLink,$this->fecha_inicio) . "',
	                                              id_usuario_inicio='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_inicio) . "',
	                                              fecha_fin='" . mysqli_real_escape_string($this->dbLink,$this->fecha_fin) . "',
	                                              id_usuario_fin='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_fin) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "'
					WHERE idTomaInventario=" . $this->idTomaInventario;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTomainventario::Update]");
				
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
				WHERE idTomaInventario=" . mysqli_real_escape_string($this->dbLink,$this->idTomaInventario);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTomainventario::Borrar]");
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
						idTomaInventario,
						fecha_inicio,
						id_usuario_inicio,
						fecha_fin,
						id_usuario_fin,
						estado
					FROM " . $this->__tableName . " 
					WHERE idTomaInventario=" . mysqli_real_escape_string($this->dbLink,$this->idTomaInventario);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTomainventario::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTomaInventario==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>