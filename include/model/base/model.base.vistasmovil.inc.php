<?php

	class ModeloBaseVistasmovil extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseVistasmovil";

		
		var $idVistasMovil=0;
		var $nombre='0';
		var $estado='Activo';
		var $icono='0';
		var $seccion='0';

		var $__s=array("idVistasMovil",
                       "nombre",
                       "estado",
                       "icono",
                       "seccion");
				
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

		
		public function setIdVistasMovil($idVistasMovil)
		{
			if($idVistasMovil==0||$idVistasMovil==""||!is_numeric($idVistasMovil)|| (is_string($idVistasMovil)&&!ctype_digit($idVistasMovil)))return $this->setError("Tipo de dato incorrecto para idVistasMovil.");
			$this->idVistasMovil=$idVistasMovil;
			$this->getDatos();
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoActivo()
		{
			$this->estado='Activo';
		}
		public function setEstadoDesactivado()
		{
			$this->estado='Desactivado';
		}
		public function setIcono($icono)
		{
			
			$this->icono=$icono;
		}
		public function setSeccion($seccion)
		{
			
			$this->seccion=$seccion;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdVistasMovil()
		{
			return $this->idVistasMovil;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getIcono()
		{
			return $this->icono;
		}
		public function getSeccion()
		{
			return $this->seccion;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idVistasMovil=0;
			$this->nombre='0';
			$this->estado='Activo';
			$this->icono='0';
			$this->seccion='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              estado,
				                                              icono,
				                                              seccion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->icono) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->seccion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseVistasmovil::Insertar]");
				
				$this->idVistasMovil=mysqli_insert_id($this->dbLink);
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
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              icono='" . mysqli_real_escape_string($this->dbLink,$this->icono) . "',
	                                              seccion='" . mysqli_real_escape_string($this->dbLink,$this->seccion) . "'
					WHERE idVistasMovil=" . $this->idVistasMovil;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseVistasmovil::Update]");
				
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
				WHERE idVistasMovil=" . mysqli_real_escape_string($this->dbLink,$this->idVistasMovil);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseVistasmovil::Borrar]");
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
						idVistasMovil,
						nombre,
						estado,
						icono,
						seccion
					FROM " . $this->__tableName . " 
					WHERE idVistasMovil=" . mysqli_real_escape_string($this->dbLink,$this->idVistasMovil);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseVistasmovil::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idVistasMovil==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>