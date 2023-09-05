<?php

	class ModeloBaseNotificacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseNotificacion";

		
		var $idNotificacion=0;
		var $idProvoca=0;
		var $idPara=0;
		var $tema='';
		var $contenido='';
		var $leido='NO';
		var $borrar='NO';
		var $fecha='0000-00-00 00:00:00';

		var $__s=array("idNotificacion",
                       "idProvoca",
                       "idPara",
                       "tema",
                       "contenido",
                       "leido",
                       "borrar",
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

		
		public function setIdNotificacion($idNotificacion)
		{
			if($idNotificacion==0||$idNotificacion==""||!is_numeric($idNotificacion)|| (is_string($idNotificacion)&&!ctype_digit($idNotificacion)))return $this->setError("Tipo de dato incorrecto para idNotificacion.");
			$this->idNotificacion=$idNotificacion;
			$this->getDatos();
		}
		public function setIdProvoca($idProvoca)
		{
			
			$this->idProvoca=$idProvoca;
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
		public function setLeido($leido)
		{
			
			$this->leido=$leido;
		}
		public function setLeidoSI()
		{
			$this->leido='SI';
		}
		public function setLeidoNO()
		{
			$this->leido='NO';
		}
		public function setBorrar($borrar)
		{
			
			$this->borrar=$borrar;
		}
		public function setBorrarSI()
		{
			$this->borrar='SI';
		}
		public function setBorrarNO()
		{
			$this->borrar='NO';
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

		
		public function getIdNotificacion()
		{
			return $this->idNotificacion;
		}
		public function getIdProvoca()
		{
			return $this->idProvoca;
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
		public function getLeido()
		{
			return $this->leido;
		}
		public function getBorrar()
		{
			return $this->borrar;
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
			
			$this->idNotificacion=0;
			$this->idProvoca=0;
			$this->idPara=0;
			$this->tema='';
			$this->contenido='';
			$this->leido='NO';
			$this->borrar='NO';
			$this->fecha='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idProvoca,
				                                              idPara,
				                                              tema,
				                                              contenido,
				                                              leido,
				                                              borrar,
				                                              fecha)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idProvoca) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPara) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tema) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->contenido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->leido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->borrar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseNotificacion::Insertar]");
				
				$this->idNotificacion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idProvoca='" . mysqli_real_escape_string($this->dbLink,$this->idProvoca) . "',
	                                              idPara='" . mysqli_real_escape_string($this->dbLink,$this->idPara) . "',
	                                              tema='" . mysqli_real_escape_string($this->dbLink,$this->tema) . "',
	                                              contenido='" . mysqli_real_escape_string($this->dbLink,$this->contenido) . "',
	                                              leido='" . mysqli_real_escape_string($this->dbLink,$this->leido) . "',
	                                              borrar='" . mysqli_real_escape_string($this->dbLink,$this->borrar) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "'
					WHERE idNotificacion=" . $this->idNotificacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseNotificacion::Update]");
				
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
				WHERE idNotificacion=" . mysqli_real_escape_string($this->dbLink,$this->idNotificacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseNotificacion::Borrar]");
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
						idNotificacion,
						idProvoca,
						idPara,
						tema,
						contenido,
						leido,
						borrar,
						fecha
					FROM " . $this->__tableName . " 
					WHERE idNotificacion=" . mysqli_real_escape_string($this->dbLink,$this->idNotificacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseNotificacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idNotificacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>