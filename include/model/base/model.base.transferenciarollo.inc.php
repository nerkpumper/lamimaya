<?php

	class ModeloBaseTransferenciarollo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTransferenciarollo";

		
		var $idTransferenciaRollo=0;
		var $almacenOrigen='0';
		var $almacenDestino='0';
		var $estatus='CREADA';
		var $fecha_crea='0000-00-00 00:00:00';
		var $id_usuario_crea=0;
		var $fecha_acepta='0000-00-00 00:00:00';
		var $id_usuario_acepta='0';
		var $fecha_cancela='0000-00-00 00:00:00';
		var $id_usuario_cancela=0;

		var $__s=array("idTransferenciaRollo",
                       "almacenOrigen",
                       "almacenDestino",
                       "estatus",
                       "fecha_crea",
                       "id_usuario_crea",
                       "fecha_acepta",
                       "id_usuario_acepta",
                       "fecha_cancela",
                       "id_usuario_cancela");
				
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

		
		public function setIdTransferenciaRollo($idTransferenciaRollo)
		{
			if($idTransferenciaRollo==0||$idTransferenciaRollo==""||!is_numeric($idTransferenciaRollo)|| (is_string($idTransferenciaRollo)&&!ctype_digit($idTransferenciaRollo)))return $this->setError("Tipo de dato incorrecto para idTransferenciaRollo.");
			$this->idTransferenciaRollo=$idTransferenciaRollo;
			$this->getDatos();
		}
		public function setAlmacenOrigen($almacenOrigen)
		{
			
			$this->almacenOrigen=$almacenOrigen;
		}
		public function setAlmacenOrigenALMACENA()
		{
			$this->almacenOrigen='ALMACEN A';
		}
		public function setAlmacenOrigenALMACENB()
		{
			$this->almacenOrigen='ALMACEN B';
		}
		public function setAlmacenOrigenALMACENPRINCIPAL()
		{
			$this->almacenOrigen='ALMACEN PRINCIPAL';
		}
		public function setAlmacenOrigenMCM()
		{
			$this->almacenOrigen='MCM';
		}
		public function setAlmacenOrigenALPES()
		{
			$this->almacenOrigen='ALPES';
		}
		public function setAlmacenOrigenCASA()
		{
			$this->almacenOrigen='CASA';
		}
		public function setAlmacenOrigenNARCISO()
		{
			$this->almacenOrigen='NARCISO';
		}
		public function setAlmacenOrigenOBRA()
		{
			$this->almacenOrigen='OBRA';
		}
		public function setAlmacenOrigenDELTA()
		{
			$this->almacenOrigen='DELTA';
		}
		public function setAlmacenOrigenLAGOS()
		{
			$this->almacenOrigen='LAGOS';
		}
		public function setAlmacenOrigenTRANSITO()
		{
			$this->almacenOrigen='TRANSITO';
		}
		public function setAlmacenDestino($almacenDestino)
		{
			
			$this->almacenDestino=$almacenDestino;
		}
		public function setAlmacenDestinoALMACENA()
		{
			$this->almacenDestino='ALMACEN A';
		}
		public function setAlmacenDestinoALMACENB()
		{
			$this->almacenDestino='ALMACEN B';
		}
		public function setAlmacenDestinoALMACENPRINCIPAL()
		{
			$this->almacenDestino='ALMACEN PRINCIPAL';
		}
		public function setAlmacenDestinoMCM()
		{
			$this->almacenDestino='MCM';
		}
		public function setAlmacenDestinoALPES()
		{
			$this->almacenDestino='ALPES';
		}
		public function setAlmacenDestinoCASA()
		{
			$this->almacenDestino='CASA';
		}
		public function setAlmacenDestinoNARCISO()
		{
			$this->almacenDestino='NARCISO';
		}
		public function setAlmacenDestinoOBRA()
		{
			$this->almacenDestino='OBRA';
		}
		public function setAlmacenDestinoDELTA()
		{
			$this->almacenDestino='DELTA';
		}
		public function setAlmacenDestinoLAGOS()
		{
			$this->almacenDestino='LAGOS';
		}
		public function setAlmacenDestinoTRANSITO()
		{
			$this->almacenDestino='TRANSITO';
		}
		public function setEstatus($estatus)
		{
			
			$this->estatus=$estatus;
		}
		public function setEstatusCREADA()
		{
			$this->estatus='CREADA';
		}
		public function setEstatusACEPTADA()
		{
			$this->estatus='ACEPTADA';
		}
		public function setEstatusCANCELADA()
		{
			$this->estatus='CANCELADA';
		}
		public function setFecha_crea($fecha_crea)
		{
			$this->fecha_crea=$fecha_crea;
		}
		public function setId_usuario_crea($id_usuario_crea)
		{
			
			$this->id_usuario_crea=$id_usuario_crea;
		}
		public function setFecha_acepta($fecha_acepta)
		{
			$this->fecha_acepta=$fecha_acepta;
		}
		public function setId_usuario_acepta($id_usuario_acepta)
		{
			
			$this->id_usuario_acepta=$id_usuario_acepta;
		}
		public function setFecha_cancela($fecha_cancela)
		{
			$this->fecha_cancela=$fecha_cancela;
		}
		public function setId_usuario_cancela($id_usuario_cancela)
		{
			
			$this->id_usuario_cancela=$id_usuario_cancela;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdTransferenciaRollo()
		{
			return $this->idTransferenciaRollo;
		}
		public function getAlmacenOrigen()
		{
			return $this->almacenOrigen;
		}
		public function getAlmacenDestino()
		{
			return $this->almacenDestino;
		}
		public function getEstatus()
		{
			return $this->estatus;
		}
		public function getFecha_crea()
		{
			return $this->fecha_crea;
		}
		public function getId_usuario_crea()
		{
			return $this->id_usuario_crea;
		}
		public function getFecha_acepta()
		{
			return $this->fecha_acepta;
		}
		public function getId_usuario_acepta()
		{
			return $this->id_usuario_acepta;
		}
		public function getFecha_cancela()
		{
			return $this->fecha_cancela;
		}
		public function getId_usuario_cancela()
		{
			return $this->id_usuario_cancela;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idTransferenciaRollo=0;
			$this->almacenOrigen='0';
			$this->almacenDestino='0';
			$this->estatus='CREADA';
			$this->fecha_crea='0000-00-00 00:00:00';
			$this->id_usuario_crea=0;
			$this->fecha_acepta='0000-00-00 00:00:00';
			$this->id_usuario_acepta='0';
			$this->fecha_cancela='0000-00-00 00:00:00';
			$this->id_usuario_cancela=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (almacenOrigen,
				                                              almacenDestino,
				                                              estatus,
				                                              fecha_crea,
				                                              id_usuario_crea,
				                                              fecha_acepta,
				                                              id_usuario_acepta,
				                                              fecha_cancela,
				                                              id_usuario_cancela)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->almacenOrigen) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacenDestino) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_acepta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_acepta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_cancela) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_cancela) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciarollo::Insertar]");
				
				$this->idTransferenciaRollo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET almacenOrigen='" . mysqli_real_escape_string($this->dbLink,$this->almacenOrigen) . "',
	                                              almacenDestino='" . mysqli_real_escape_string($this->dbLink,$this->almacenDestino) . "',
	                                              estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
	                                              fecha_crea='" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
	                                              id_usuario_crea='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "',
	                                              fecha_acepta='" . mysqli_real_escape_string($this->dbLink,$this->fecha_acepta) . "',
	                                              id_usuario_acepta='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_acepta) . "',
	                                              fecha_cancela='" . mysqli_real_escape_string($this->dbLink,$this->fecha_cancela) . "',
	                                              id_usuario_cancela='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_cancela) . "'
					WHERE idTransferenciaRollo=" . $this->idTransferenciaRollo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciarollo::Update]");
				
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
				WHERE idTransferenciaRollo=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaRollo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciarollo::Borrar]");
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
						idTransferenciaRollo,
						almacenOrigen,
						almacenDestino,
						estatus,
						fecha_crea,
						id_usuario_crea,
						fecha_acepta,
						id_usuario_acepta,
						fecha_cancela,
						id_usuario_cancela
					FROM " . $this->__tableName . " 
					WHERE idTransferenciaRollo=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaRollo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTransferenciarollo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTransferenciaRollo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>