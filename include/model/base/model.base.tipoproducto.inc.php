<?php

	class ModeloBaseTipoproducto extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTipoproducto";

		
		var $idTipoProducto=0;
		var $nombre='0';
		var $clave='0';
		var $estado='ACTIVO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $idUsuarioCrea=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $idUsuarioModifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $idUsuarioBaja=0;

		var $__s=array("idTipoProducto",
                       "nombre",
                       "clave",
                       "estado",
                       "fecha_creacion",
                       "idUsuarioCrea",
                       "fecha_modifica",
                       "idUsuarioModifica",
                       "fecha_baja",
                       "idUsuarioBaja");
				
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

		
		public function setIdTipoProducto($idTipoProducto)
		{
			if($idTipoProducto==0||$idTipoProducto==""||!is_numeric($idTipoProducto)|| (is_string($idTipoProducto)&&!ctype_digit($idTipoProducto)))return $this->setError("Tipo de dato incorrecto para idTipoProducto.");
			$this->idTipoProducto=$idTipoProducto;
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
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setIdUsuarioCrea($idUsuarioCrea)
		{
			
			$this->idUsuarioCrea=$idUsuarioCrea;
		}
		public function setFecha_modifica($fecha_modifica)
		{
			$this->fecha_modifica=$fecha_modifica;
		}
		public function setIdUsuarioModifica($idUsuarioModifica)
		{
			
			$this->idUsuarioModifica=$idUsuarioModifica;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setIdUsuarioBaja($idUsuarioBaja)
		{
			
			$this->idUsuarioBaja=$idUsuarioBaja;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTipoProducto()
		{
			return $this->idTipoProducto;
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
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getIdUsuarioCrea()
		{
			return $this->idUsuarioCrea;
		}
		public function getFecha_modifica()
		{
			return $this->fecha_modifica;
		}
		public function getIdUsuarioModifica()
		{
			return $this->idUsuarioModifica;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getIdUsuarioBaja()
		{
			return $this->idUsuarioBaja;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTipoProducto=0;
			$this->nombre='0';
			$this->clave='0';
			$this->estado='ACTIVO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->idUsuarioCrea=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->idUsuarioModifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->idUsuarioBaja=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              clave,
				                                              estado,
				                                              fecha_creacion,
				                                              idUsuarioCrea,
				                                              fecha_modifica,
				                                              idUsuarioModifica,
				                                              fecha_baja,
				                                              idUsuarioBaja)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->clave) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTipoproducto::Insertar]");
				
				$this->idTipoProducto=mysqli_insert_id($this->dbLink);
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
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              idUsuarioCrea='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              idUsuarioModifica='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              idUsuarioBaja='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "'
					WHERE idTipoProducto=" . $this->idTipoProducto;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTipoproducto::Update]");
				
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
				WHERE idTipoProducto=" . mysqli_real_escape_string($this->dbLink,$this->idTipoProducto);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTipoproducto::Borrar]");
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
						idTipoProducto,
						nombre,
						clave,
						estado,
						fecha_creacion,
						idUsuarioCrea,
						fecha_modifica,
						idUsuarioModifica,
						fecha_baja,
						idUsuarioBaja
					FROM " . $this->__tableName . " 
					WHERE idTipoProducto=" . mysqli_real_escape_string($this->dbLink,$this->idTipoProducto);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTipoproducto::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTipoProducto==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>