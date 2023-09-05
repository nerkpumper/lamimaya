<?php

	class ModeloBaseUsuariovistasmovil extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseUsuariovistasmovil";

		
		var $idUsuarioVistasMovil=0;
		var $idUsuario=0;
		var $idVistaMovil=0;

		var $__s=array("idUsuarioVistasMovil",
                       "idUsuario",
                       "idVistaMovil");
				
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

		
		public function setIdUsuarioVistasMovil($idUsuarioVistasMovil)
		{
			if($idUsuarioVistasMovil==0||$idUsuarioVistasMovil==""||!is_numeric($idUsuarioVistasMovil)|| (is_string($idUsuarioVistasMovil)&&!ctype_digit($idUsuarioVistasMovil)))return $this->setError("Tipo de dato incorrecto para idUsuarioVistasMovil.");
			$this->idUsuarioVistasMovil=$idUsuarioVistasMovil;
			$this->getDatos();
		}
		public function setIdUsuario($idUsuario)
		{
			
			$this->idUsuario=$idUsuario;
		}
		public function setIdVistaMovil($idVistaMovil)
		{
			
			$this->idVistaMovil=$idVistaMovil;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdUsuarioVistasMovil()
		{
			return $this->idUsuarioVistasMovil;
		}
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}
		public function getIdVistaMovil()
		{
			return $this->idVistaMovil;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idUsuarioVistasMovil=0;
			$this->idUsuario=0;
			$this->idVistaMovil=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idUsuario,
				                                              idVistaMovil)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idVistaMovil) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuariovistasmovil::Insertar]");
				
				$this->idUsuarioVistasMovil=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "',
	                                              idVistaMovil='" . mysqli_real_escape_string($this->dbLink,$this->idVistaMovil) . "'
					WHERE idUsuarioVistasMovil=" . $this->idUsuarioVistasMovil;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuariovistasmovil::Update]");
				
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
				WHERE idUsuarioVistasMovil=" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioVistasMovil);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseUsuariovistasmovil::Borrar]");
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
						idUsuarioVistasMovil,
						idUsuario,
						idVistaMovil
					FROM " . $this->__tableName . " 
					WHERE idUsuarioVistasMovil=" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioVistasMovil);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseUsuariovistasmovil::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idUsuarioVistasMovil==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>