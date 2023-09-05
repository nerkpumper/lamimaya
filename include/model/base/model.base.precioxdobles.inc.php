<?php

	class ModeloBasePrecioxdobles extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePrecioxdobles";

		
		var $idPrecioXDobles=0;
		var $tipoPrecio='';
		var $desarrollo='0';
		var $calibre=0;
		var $precio1='0';
		var $precio2='0';
		var $precio3='0';
		var $precio4='0';
		var $precio5='0';
		var $precio6='0';
		var $precio7='0';
		var $precio8='0';
		var $precio9='0';
		var $precio10='0';
		var $idUsuario=0;

		var $__s=array("idPrecioXDobles",
                       "tipoPrecio",
                       "desarrollo",
                       "calibre",
                       "precio1",
                       "precio2",
                       "precio3",
                       "precio4",
                       "precio5",
                       "precio6",
                       "precio7",
                       "precio8",
                       "precio9",
                       "precio10",
                       "idUsuario");
				
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

		
		public function setIdPrecioXDobles($idPrecioXDobles)
		{
			if($idPrecioXDobles==0||$idPrecioXDobles==""||!is_numeric($idPrecioXDobles)|| (is_string($idPrecioXDobles)&&!ctype_digit($idPrecioXDobles)))return $this->setError("Tipo de dato incorrecto para idPrecioXDobles.");
			$this->idPrecioXDobles=$idPrecioXDobles;
			$this->getDatos();
		}
		public function setTipoPrecio($tipoPrecio)
		{
			$this->tipoPrecio=$tipoPrecio;
		}
		public function setDesarrollo($desarrollo)
		{
			
			$this->desarrollo=$desarrollo;
		}
		public function setCalibre($calibre)
		{
			
			$this->calibre=$calibre;
		}
		public function setPrecio1($precio1)
		{
			$this->precio1=$precio1;
		}
		public function setPrecio2($precio2)
		{
			$this->precio2=$precio2;
		}
		public function setPrecio3($precio3)
		{
			$this->precio3=$precio3;
		}
		public function setPrecio4($precio4)
		{
			$this->precio4=$precio4;
		}
		public function setPrecio5($precio5)
		{
			$this->precio5=$precio5;
		}
		public function setPrecio6($precio6)
		{
			$this->precio6=$precio6;
		}
		public function setPrecio7($precio7)
		{
			$this->precio7=$precio7;
		}
		public function setPrecio8($precio8)
		{
			$this->precio8=$precio8;
		}
		public function setPrecio9($precio9)
		{
			$this->precio9=$precio9;
		}
		public function setPrecio10($precio10)
		{
			$this->precio10=$precio10;
		}
		public function setIdUsuario($idUsuario)
		{
			
			$this->idUsuario=$idUsuario;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPrecioXDobles()
		{
			return $this->idPrecioXDobles;
		}
		public function getTipoPrecio()
		{
			return $this->tipoPrecio;
		}
		public function getDesarrollo()
		{
			return $this->desarrollo;
		}
		public function getCalibre()
		{
			return $this->calibre;
		}
		public function getPrecio1()
		{
			return $this->precio1;
		}
		public function getPrecio2()
		{
			return $this->precio2;
		}
		public function getPrecio3()
		{
			return $this->precio3;
		}
		public function getPrecio4()
		{
			return $this->precio4;
		}
		public function getPrecio5()
		{
			return $this->precio5;
		}
		public function getPrecio6()
		{
			return $this->precio6;
		}
		public function getPrecio7()
		{
			return $this->precio7;
		}
		public function getPrecio8()
		{
			return $this->precio8;
		}
		public function getPrecio9()
		{
			return $this->precio9;
		}
		public function getPrecio10()
		{
			return $this->precio10;
		}
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPrecioXDobles=0;
			$this->tipoPrecio='';
			$this->desarrollo='0';
			$this->calibre=0;
			$this->precio1='0';
			$this->precio2='0';
			$this->precio3='0';
			$this->precio4='0';
			$this->precio5='0';
			$this->precio6='0';
			$this->precio7='0';
			$this->precio8='0';
			$this->precio9='0';
			$this->precio10='0';
			$this->idUsuario=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (tipoPrecio,
				                                              desarrollo,
				                                              calibre,
				                                              precio1,
				                                              precio2,
				                                              precio3,
				                                              precio4,
				                                              precio5,
				                                              precio6,
				                                              precio7,
				                                              precio8,
				                                              precio9,
				                                              precio10,
				                                              idUsuario)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->desarrollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio5) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio6) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio7) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio8) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio9) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio10) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePrecioxdobles::Insertar]");
				
				$this->idPrecioXDobles=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET tipoPrecio='" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
	                                              desarrollo='" . mysqli_real_escape_string($this->dbLink,$this->desarrollo) . "',
	                                              calibre='" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
	                                              precio1='" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
	                                              precio2='" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
	                                              precio3='" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
	                                              precio4='" . mysqli_real_escape_string($this->dbLink,$this->precio4) . "',
	                                              precio5='" . mysqli_real_escape_string($this->dbLink,$this->precio5) . "',
	                                              precio6='" . mysqli_real_escape_string($this->dbLink,$this->precio6) . "',
	                                              precio7='" . mysqli_real_escape_string($this->dbLink,$this->precio7) . "',
	                                              precio8='" . mysqli_real_escape_string($this->dbLink,$this->precio8) . "',
	                                              precio9='" . mysqli_real_escape_string($this->dbLink,$this->precio9) . "',
	                                              precio10='" . mysqli_real_escape_string($this->dbLink,$this->precio10) . "',
	                                              idUsuario='" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "'
					WHERE idPrecioXDobles=" . $this->idPrecioXDobles;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePrecioxdobles::Update]");
				
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
				WHERE idPrecioXDobles=" . mysqli_real_escape_string($this->dbLink,$this->idPrecioXDobles);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePrecioxdobles::Borrar]");
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
						idPrecioXDobles,
						tipoPrecio,
						desarrollo,
						calibre,
						precio1,
						precio2,
						precio3,
						precio4,
						precio5,
						precio6,
						precio7,
						precio8,
						precio9,
						precio10,
						idUsuario
					FROM " . $this->__tableName . " 
					WHERE idPrecioXDobles=" . mysqli_real_escape_string($this->dbLink,$this->idPrecioXDobles);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePrecioxdobles::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPrecioXDobles==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>