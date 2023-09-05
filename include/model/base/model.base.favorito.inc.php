<?php

	class ModeloBaseFavorito extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseFavorito";

		
		var $idFavorito=0;
		var $idUsuario=0;
		var $idProducto=0;
		var $favorito='NO';

		var $__s=array("idFavorito",
                       "idUsuario",
                       "idProducto",
                       "favorito");
				
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

		
		public function setIdFavorito($idFavorito)
		{
			if($idFavorito==0||$idFavorito==""||!is_numeric($idFavorito)|| (is_string($idFavorito)&&!ctype_digit($idFavorito)))return $this->setError("Tipo de dato incorrecto para idFavorito.");
			$this->idFavorito=$idFavorito;
			$this->getDatos();
		}
		public function setIdUsuario($idUsuario)
		{
			
			$this->idUsuario=$idUsuario;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setFavorito($favorito)
		{
			
			$this->favorito=$favorito;
		}
		public function setFavoritoSI()
		{
			$this->favorito='SI';
		}
		public function setFavoritoNO()
		{
			$this->favorito='NO';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdFavorito()
		{
			return $this->idFavorito;
		}
		public function getIdUsuario()
		{
			return $this->idUsuario;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getFavorito()
		{
			return $this->favorito;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idFavorito=0;
			$this->idUsuario=0;
			$this->idProducto=0;
			$this->favorito='NO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idUsuario,
				                                              idProducto,
				                                              favorito)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idUsuario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->favorito) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseFavorito::Insertar]");
				
				$this->idFavorito=mysqli_insert_id($this->dbLink);
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
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              favorito='" . mysqli_real_escape_string($this->dbLink,$this->favorito) . "'
					WHERE idFavorito=" . $this->idFavorito;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseFavorito::Update]");
				
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
				WHERE idFavorito=" . mysqli_real_escape_string($this->dbLink,$this->idFavorito);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseFavorito::Borrar]");
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
						idFavorito,
						idUsuario,
						idProducto,
						favorito
					FROM " . $this->__tableName . " 
					WHERE idFavorito=" . mysqli_real_escape_string($this->dbLink,$this->idFavorito);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseFavorito::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idFavorito==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>