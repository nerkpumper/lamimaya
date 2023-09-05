<?php

	class ModeloBaseRutaenvio extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRutaenvio";

		
		var $idRutaEnvio=0;
		var $idRuta=0;
		var $fecha='0000-00-00';
		var $turno='MATUTINO';
		var $maxml='0.00';
		var $maxpeso='0.00';
		var $estado='CREADA';
		var $noPedidos=0;

		var $__s=array("idRutaEnvio",
                       "idRuta",
                       "fecha",
                       "turno",
                       "maxml",
                       "maxpeso",
                       "estado",
                       "noPedidos");
				
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

		
		public function setIdRutaEnvio($idRutaEnvio)
		{
			if($idRutaEnvio==0||$idRutaEnvio==""||!is_numeric($idRutaEnvio)|| (is_string($idRutaEnvio)&&!ctype_digit($idRutaEnvio)))return $this->setError("Tipo de dato incorrecto para idRutaEnvio.");
			$this->idRutaEnvio=$idRutaEnvio;
			$this->getDatos();
		}
		public function setIdRuta($idRuta)
		{
			
			$this->idRuta=$idRuta;
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}
		public function setTurno($turno)
		{
			
			$this->turno=$turno;
		}
		public function setTurnoMATUTINO()
		{
			$this->turno='MATUTINO';
		}
		public function setTurnoVESPERTINO()
		{
			$this->turno='VESPERTINO';
		}
		public function setMaxml($maxml)
		{
			$this->maxml=$maxml;
		}
		public function setMaxpeso($maxpeso)
		{
			$this->maxpeso=$maxpeso;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoCREADA()
		{
			$this->estado='CREADA';
		}
		public function setEstadoVEHICULOASIGNADO()
		{
			$this->estado='VEHICULOASIGNADO';
		}
		public function setEstadoENRUTA()
		{
			$this->estado='ENRUTA';
		}
		public function setEstadoTERMINADA()
		{
			$this->estado='TERMINADA';
		}
		public function setNoPedidos($noPedidos)
		{
			
			$this->noPedidos=$noPedidos;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRutaEnvio()
		{
			return $this->idRutaEnvio;
		}
		public function getIdRuta()
		{
			return $this->idRuta;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getTurno()
		{
			return $this->turno;
		}
		public function getMaxml()
		{
			return $this->maxml;
		}
		public function getMaxpeso()
		{
			return $this->maxpeso;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getNoPedidos()
		{
			return $this->noPedidos;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRutaEnvio=0;
			$this->idRuta=0;
			$this->fecha='0000-00-00';
			$this->turno='MATUTINO';
			$this->maxml='0.00';
			$this->maxpeso='0.00';
			$this->estado='CREADA';
			$this->noPedidos=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRuta,
				                                              fecha,
				                                              turno,
				                                              maxml,
				                                              maxpeso,
				                                              estado,
				                                              noPedidos)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRuta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->turno) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->maxml) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->maxpeso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->noPedidos) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenvio::Insertar]");
				
				$this->idRutaEnvio=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idRuta='" . mysqli_real_escape_string($this->dbLink,$this->idRuta) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              turno='" . mysqli_real_escape_string($this->dbLink,$this->turno) . "',
	                                              maxml='" . mysqli_real_escape_string($this->dbLink,$this->maxml) . "',
	                                              maxpeso='" . mysqli_real_escape_string($this->dbLink,$this->maxpeso) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              noPedidos='" . mysqli_real_escape_string($this->dbLink,$this->noPedidos) . "'
					WHERE idRutaEnvio=" . $this->idRutaEnvio;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenvio::Update]");
				
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
				WHERE idRutaEnvio=" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenvio::Borrar]");
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
						idRutaEnvio,
						idRuta,
						fecha,
						turno,
						maxml,
						maxpeso,
						estado,
						noPedidos
					FROM " . $this->__tableName . " 
					WHERE idRutaEnvio=" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRutaenvio::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRutaEnvio==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>