<?php

	class ModeloBaseClientedatosfacturacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseClientedatosfacturacion";

		
		var $idClienteDatosFacturacion=0;
		var $idCliente=0;
		var $idDatosFacturacion=0;
		var $fecha_insert='0000-00-00 00:00:00';
		var $id_usuario_insert=0;
		var $fecha_update='0000-00-00 00:00:00';
		var $id_usuario_update=0;

		var $__s=array("idClienteDatosFacturacion",
                       "idCliente",
                       "idDatosFacturacion",
                       "fecha_insert",
                       "id_usuario_insert",
                       "fecha_update",
                       "id_usuario_update");
				
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

		
		public function setIdClienteDatosFacturacion($idClienteDatosFacturacion)
		{
			if($idClienteDatosFacturacion==0||$idClienteDatosFacturacion==""||!is_numeric($idClienteDatosFacturacion)|| (is_string($idClienteDatosFacturacion)&&!ctype_digit($idClienteDatosFacturacion)))return $this->setError("Tipo de dato incorrecto para idClienteDatosFacturacion.");
			$this->idClienteDatosFacturacion=$idClienteDatosFacturacion;
			$this->getDatos();
		}
		public function setIdCliente($idCliente)
		{
			
			$this->idCliente=$idCliente;
		}
		public function setIdDatosFacturacion($idDatosFacturacion)
		{
			
			$this->idDatosFacturacion=$idDatosFacturacion;
		}
		public function setFecha_insert($fecha_insert)
		{
			$this->fecha_insert=$fecha_insert;
		}
		public function setId_usuario_insert($id_usuario_insert)
		{
			
			$this->id_usuario_insert=$id_usuario_insert;
		}
		public function setFecha_update($fecha_update)
		{
			$this->fecha_update=$fecha_update;
		}
		public function setId_usuario_update($id_usuario_update)
		{
			
			$this->id_usuario_update=$id_usuario_update;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdClienteDatosFacturacion()
		{
			return $this->idClienteDatosFacturacion;
		}
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getIdDatosFacturacion()
		{
			return $this->idDatosFacturacion;
		}
		public function getFecha_insert()
		{
			return $this->fecha_insert;
		}
		public function getId_usuario_insert()
		{
			return $this->id_usuario_insert;
		}
		public function getFecha_update()
		{
			return $this->fecha_update;
		}
		public function getId_usuario_update()
		{
			return $this->id_usuario_update;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idClienteDatosFacturacion=0;
			$this->idCliente=0;
			$this->idDatosFacturacion=0;
			$this->fecha_insert='0000-00-00 00:00:00';
			$this->id_usuario_insert=0;
			$this->fecha_update='0000-00-00 00:00:00';
			$this->id_usuario_update=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCliente,
				                                              idDatosFacturacion,
				                                              fecha_insert,
				                                              id_usuario_insert,
				                                              fecha_update,
				                                              id_usuario_update)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idDatosFacturacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseClientedatosfacturacion::Insertar]");
				
				$this->idClienteDatosFacturacion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idCliente='" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
	                                              idDatosFacturacion='" . mysqli_real_escape_string($this->dbLink,$this->idDatosFacturacion) . "',
	                                              fecha_insert='" . mysqli_real_escape_string($this->dbLink,$this->fecha_insert) . "',
	                                              id_usuario_insert='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_insert) . "',
	                                              fecha_update='" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
	                                              id_usuario_update='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_update) . "'
					WHERE idClienteDatosFacturacion=" . $this->idClienteDatosFacturacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseClientedatosfacturacion::Update]");
				
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
				WHERE idClienteDatosFacturacion=" . mysqli_real_escape_string($this->dbLink,$this->idClienteDatosFacturacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseClientedatosfacturacion::Borrar]");
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
						idClienteDatosFacturacion,
						idCliente,
						idDatosFacturacion,
						fecha_insert,
						id_usuario_insert,
						fecha_update,
						id_usuario_update
					FROM " . $this->__tableName . " 
					WHERE idClienteDatosFacturacion=" . mysqli_real_escape_string($this->dbLink,$this->idClienteDatosFacturacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseClientedatosfacturacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idClienteDatosFacturacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>