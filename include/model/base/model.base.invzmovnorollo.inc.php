<?php

	class ModeloBaseInvzmovnorollo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseInvzmovnorollo";

		
		var $idinvzmovnorollo=0;
		var $idRemisionRollo=0;
		var $almacenOrigen='0';
		var $almacenDestino='0';
		var $fecha_movimiento='0';
		var $id_usuario_movimiento=0;
		var $observacion='';

		var $__s=array("idinvzmovnorollo",
                       "idRemisionRollo",
                       "almacenOrigen",
                       "almacenDestino",
                       "fecha_movimiento",
                       "id_usuario_movimiento",
                       "observacion");
				
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

		
		public function setIdinvzmovnorollo($idinvzmovnorollo)
		{
			if($idinvzmovnorollo==0||$idinvzmovnorollo==""||!is_numeric($idinvzmovnorollo)|| (is_string($idinvzmovnorollo)&&!ctype_digit($idinvzmovnorollo)))return $this->setError("Tipo de dato incorrecto para idinvzmovnorollo.");
			$this->idinvzmovnorollo=$idinvzmovnorollo;
			$this->getDatos();
		}
		public function setIdRemisionRollo($idRemisionRollo)
		{
			
			$this->idRemisionRollo=$idRemisionRollo;
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
		public function setFecha_movimiento($fecha_movimiento)
		{
			$this->fecha_movimiento=$fecha_movimiento;
		}
		public function setId_usuario_movimiento($id_usuario_movimiento)
		{
			
			$this->id_usuario_movimiento=$id_usuario_movimiento;
		}
		public function setObservacion($observacion)
		{
			
			$this->observacion=$observacion;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdinvzmovnorollo()
		{
			return $this->idinvzmovnorollo;
		}
		public function getIdRemisionRollo()
		{
			return $this->idRemisionRollo;
		}
		public function getAlmacenOrigen()
		{
			return $this->almacenOrigen;
		}
		public function getAlmacenDestino()
		{
			return $this->almacenDestino;
		}
		public function getFecha_movimiento()
		{
			return $this->fecha_movimiento;
		}
		public function getId_usuario_movimiento()
		{
			return $this->id_usuario_movimiento;
		}
		public function getObservacion()
		{
			return $this->observacion;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idinvzmovnorollo=0;
			$this->idRemisionRollo=0;
			$this->almacenOrigen='0';
			$this->almacenDestino='0';
			$this->fecha_movimiento='0';
			$this->id_usuario_movimiento=0;
			$this->observacion='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRemisionRollo,
				                                              almacenOrigen,
				                                              almacenDestino,
				                                              fecha_movimiento,
				                                              id_usuario_movimiento,
				                                              observacion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacenOrigen) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->almacenDestino) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmovnorollo::Insertar]");
				
				$this->idinvzmovnorollo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idRemisionRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRemisionRollo) . "',
	                                              almacenOrigen='" . mysqli_real_escape_string($this->dbLink,$this->almacenOrigen) . "',
	                                              almacenDestino='" . mysqli_real_escape_string($this->dbLink,$this->almacenDestino) . "',
	                                              fecha_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_movimiento) . "',
	                                              id_usuario_movimiento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_movimiento) . "',
	                                              observacion='" . mysqli_real_escape_string($this->dbLink,$this->observacion) . "'
					WHERE idinvzmovnorollo=" . $this->idinvzmovnorollo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmovnorollo::Update]");
				
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
				WHERE idinvzmovnorollo=" . mysqli_real_escape_string($this->dbLink,$this->idinvzmovnorollo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseInvzmovnorollo::Borrar]");
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
						idinvzmovnorollo,
						idRemisionRollo,
						almacenOrigen,
						almacenDestino,
						fecha_movimiento,
						id_usuario_movimiento,
						observacion
					FROM " . $this->__tableName . " 
					WHERE idinvzmovnorollo=" . mysqli_real_escape_string($this->dbLink,$this->idinvzmovnorollo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseInvzmovnorollo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idinvzmovnorollo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>