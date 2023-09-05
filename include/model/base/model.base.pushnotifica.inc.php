<?php

	class ModeloBasePushnotifica extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePushnotifica";

		
		var $idPushNotifica=0;
		var $idProvoca=0;
		var $idPara=0;
		var $tipo=0;
		var $tema='';
		var $contenido='';
		var $acepta='SINRESPUESTA';
		var $refint=0;
		var $refstr='';
		var $fecha='0000-00-00 00:00:00';
		var $enviado='NO';

		var $__s=array("idPushNotifica",
                       "idProvoca",
                       "idPara",
                       "tipo",
                       "tema",
                       "contenido",
                       "acepta",
                       "refint",
                       "refstr",
                       "fecha",
                       "enviado");
				
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

		
		public function setIdPushNotifica($idPushNotifica)
		{
			if($idPushNotifica==0||$idPushNotifica==""||!is_numeric($idPushNotifica)|| (is_string($idPushNotifica)&&!ctype_digit($idPushNotifica)))return $this->setError("Tipo de dato incorrecto para idPushNotifica.");
			$this->idPushNotifica=$idPushNotifica;
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
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTema($tema)
		{
			
			$this->tema=$tema;
		}
		public function setContenido($contenido)
		{
			
			$this->contenido=$contenido;
		}
		public function setAcepta($acepta)
		{
			
			$this->acepta=$acepta;
		}
		public function setAceptaSINRESPUESTA()
		{
			$this->acepta='SINRESPUESTA';
		}
		public function setAceptaSI()
		{
			$this->acepta='SI';
		}
		public function setAceptaNO()
		{
			$this->acepta='NO';
		}
		public function setRefint($refint)
		{
			
			$this->refint=$refint;
		}
		public function setRefstr($refstr)
		{
			
			$this->refstr=$refstr;
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}
		public function setEnviado($enviado)
		{
			
			$this->enviado=$enviado;
		}
		public function setEnviadoNO()
		{
			$this->enviado='NO';
		}
		public function setEnviadoSI()
		{
			$this->enviado='SI';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPushNotifica()
		{
			return $this->idPushNotifica;
		}
		public function getIdProvoca()
		{
			return $this->idProvoca;
		}
		public function getIdPara()
		{
			return $this->idPara;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getTema()
		{
			return $this->tema;
		}
		public function getContenido()
		{
			return $this->contenido;
		}
		public function getAcepta()
		{
			return $this->acepta;
		}
		public function getRefint()
		{
			return $this->refint;
		}
		public function getRefstr()
		{
			return $this->refstr;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getEnviado()
		{
			return $this->enviado;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPushNotifica=0;
			$this->idProvoca=0;
			$this->idPara=0;
			$this->tipo=0;
			$this->tema='';
			$this->contenido='';
			$this->acepta='SINRESPUESTA';
			$this->refint=0;
			$this->refstr='';
			$this->fecha='0000-00-00 00:00:00';
			$this->enviado='NO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idProvoca,
				                                              idPara,
				                                              tipo,
				                                              tema,
				                                              contenido,
				                                              acepta,
				                                              refint,
				                                              refstr,
				                                              fecha,
				                                              enviado)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idProvoca) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPara) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tema) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->contenido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->acepta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->refint) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->refstr) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->enviado) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePushnotifica::Insertar]");
				
				$this->idPushNotifica=mysqli_insert_id($this->dbLink);
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
	                                              tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              tema='" . mysqli_real_escape_string($this->dbLink,$this->tema) . "',
	                                              contenido='" . mysqli_real_escape_string($this->dbLink,$this->contenido) . "',
	                                              acepta='" . mysqli_real_escape_string($this->dbLink,$this->acepta) . "',
	                                              refint='" . mysqli_real_escape_string($this->dbLink,$this->refint) . "',
	                                              refstr='" . mysqli_real_escape_string($this->dbLink,$this->refstr) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              enviado='" . mysqli_real_escape_string($this->dbLink,$this->enviado) . "'
					WHERE idPushNotifica=" . $this->idPushNotifica;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePushnotifica::Update]");
				
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
				WHERE idPushNotifica=" . mysqli_real_escape_string($this->dbLink,$this->idPushNotifica);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePushnotifica::Borrar]");
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
						idPushNotifica,
						idProvoca,
						idPara,
						tipo,
						tema,
						contenido,
						acepta,
						refint,
						refstr,
						fecha,
						enviado
					FROM " . $this->__tableName . " 
					WHERE idPushNotifica=" . mysqli_real_escape_string($this->dbLink,$this->idPushNotifica);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePushnotifica::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPushNotifica==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>