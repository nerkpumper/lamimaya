<?php

	class ModeloBaseGasto extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseGasto";

		
		var $idGasto=0;
		var $idTipoGasto=0;
		var $idSucursal=0;
		var $monto='0.00';
		var $detalle='';
		var $id_usuario_insert=0;
		var $fecha_insert='0000-00-00 00:00:00';
		var $id_usuario_update=0;
		var $fecha_update='0000-00-00 00:00:00';

		var $__s=array("idGasto",
                       "idTipoGasto",
                       "idSucursal",
                       "monto",
                       "detalle",
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

		
		public function setIdGasto($idGasto)
		{
			if($idGasto==0||$idGasto==""||!is_numeric($idGasto)|| (is_string($idGasto)&&!ctype_digit($idGasto)))return $this->setError("Tipo de dato incorrecto para idGasto.");
			$this->idGasto=$idGasto;
			$this->getDatos();
		}
		public function setIdTipoGasto($idTipoGasto)
		{
			
			$this->idTipoGasto=$idTipoGasto;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setMonto($monto)
		{
			$this->monto=$monto;
		}
		public function setDetalle($detalle)
		{
			
			$this->detalle=$detalle;
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

		
		public function getIdGasto()
		{
			return $this->idGasto;
		}
		public function getIdTipoGasto()
		{
			return $this->idTipoGasto;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getMonto()
		{
			return $this->monto;
		}
		public function getDetalle()
		{
			return $this->detalle;
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
			
			$this->idGasto=0;
			$this->idTipoGasto=0;
			$this->idSucursal=0;
			$this->monto='0.00';
			$this->detalle='';
			$this->id_usuario_insert=0;
			$this->fecha_insert='0000-00-00 00:00:00';
			$this->id_usuario_update=0;
			$this->fecha_update='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idTipoGasto,
				                                              idSucursal,
				                                              monto,
				                                              detalle,
				                                              id_usuario_insert,
				                                              fecha_insert,
				                                              id_usuario_update,
				                                              fecha_update)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idTipoGasto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->detalle) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseGasto::Insertar]");
				
				$this->idGasto=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idTipoGasto='" . mysqli_real_escape_string($this->dbLink,$this->idTipoGasto) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              monto='" . mysqli_real_escape_string($this->dbLink,$this->monto) . "',
	                                              detalle='" . mysqli_real_escape_string($this->dbLink,$this->detalle) . "',
	                                              id_usuario_insert='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
	                                              fecha_insert='" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
	                                              id_usuario_update='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "',
	                                              fecha_update='" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "'
					WHERE idGasto=" . $this->idGasto;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseGasto::Update]");
				
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
				WHERE idGasto=" . mysqli_real_escape_string($this->dbLink,$this->idGasto);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseGasto::Borrar]");
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
						idGasto,
						idTipoGasto,
						idSucursal,
						monto,
						detalle,
						id_usuario_insert,
						fecha_insert,
						id_usuario_update,
						fecha_update
					FROM " . $this->__tableName . " 
					WHERE idGasto=" . mysqli_real_escape_string($this->dbLink,$this->idGasto);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseGasto::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idGasto==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>