<?php

	class ModeloBaseCorreo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCorreo";

		
		var $idCorreo=0;
		var $idDe=0;
		var $idPara=0;
		var $tema='';
		var $contenido='';
		var $estatus='UNREAD';
		var $categoria='BUZON';
		var $fecha='0000-00-00 00:00:00';

		var $__s=array("idCorreo",
                       "idDe",
                       "idPara",
                       "tema",
                       "contenido",
                       "estatus",
                       "categoria",
                       "fecha");
				
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

		
		public function setIdCorreo($idCorreo)
		{
			if($idCorreo==0||$idCorreo==""||!is_numeric($idCorreo)|| (is_string($idCorreo)&&!ctype_digit($idCorreo)))return $this->setError("Tipo de dato incorrecto para idCorreo.");
			$this->idCorreo=$idCorreo;
			$this->getDatos();
		}
		public function setIdDe($idDe)
		{
			
			$this->idDe=$idDe;
		}
		public function setIdPara($idPara)
		{
			
			$this->idPara=$idPara;
		}
		public function setTema($tema)
		{
			
			$this->tema=$tema;
		}
		public function setContenido($contenido)
		{
			$this->contenido=$contenido;
		}
		public function setEstatus($estatus)
		{
			
			$this->estatus=$estatus;
		}
		public function setEstatusUNREAD()
		{
			$this->estatus='UNREAD';
		}
		public function setEstatusREAD()
		{
			$this->estatus='READ';
		}
		public function setCategoria($categoria)
		{
			
			$this->categoria=$categoria;
		}
		public function setCategoriaBUZON()
		{
			$this->categoria='BUZON';
		}
		public function setCategoriaIMPORTANTE()
		{
			$this->categoria='IMPORTANTE';
		}
		public function setCategoriaELIMINAR()
		{
			$this->categoria='ELIMINAR';
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCorreo()
		{
			return $this->idCorreo;
		}
		public function getIdDe()
		{
			return $this->idDe;
		}
		public function getIdPara()
		{
			return $this->idPara;
		}
		public function getTema()
		{
			return $this->tema;
		}
		public function getContenido()
		{
			return $this->contenido;
		}
		public function getEstatus()
		{
			return $this->estatus;
		}
		public function getCategoria()
		{
			return $this->categoria;
		}
		public function getFecha()
		{
			return $this->fecha;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCorreo=0;
			$this->idDe=0;
			$this->idPara=0;
			$this->tema='';
			$this->contenido='';
			$this->estatus='UNREAD';
			$this->categoria='BUZON';
			$this->fecha='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idDe,
				                                              idPara,
				                                              tema,
				                                              contenido,
				                                              estatus,
				                                              categoria,
				                                              fecha)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idDe) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPara) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tema) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->contenido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->categoria) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCorreo::Insertar]");
				
				$this->idCorreo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idDe='" . mysqli_real_escape_string($this->dbLink,$this->idDe) . "',
	                                              idPara='" . mysqli_real_escape_string($this->dbLink,$this->idPara) . "',
	                                              tema='" . mysqli_real_escape_string($this->dbLink,$this->tema) . "',
	                                              contenido='" . mysqli_real_escape_string($this->dbLink,$this->contenido) . "',
	                                              estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
	                                              categoria='" . mysqli_real_escape_string($this->dbLink,$this->categoria) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "'
					WHERE idCorreo=" . $this->idCorreo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCorreo::Update]");
				
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
				WHERE idCorreo=" . mysqli_real_escape_string($this->dbLink,$this->idCorreo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCorreo::Borrar]");
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
						idCorreo,
						idDe,
						idPara,
						tema,
						contenido,
						estatus,
						categoria,
						fecha
					FROM " . $this->__tableName . " 
					WHERE idCorreo=" . mysqli_real_escape_string($this->dbLink,$this->idCorreo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCorreo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCorreo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>