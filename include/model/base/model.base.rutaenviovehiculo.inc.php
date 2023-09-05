<?php

	class ModeloBaseRutaenviovehiculo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRutaenviovehiculo";

		
		var $idRutaEnvioVehiculo=0;
		var $idRutaEnvio=0;
		var $idVehiculo=0;
		var $kilometrajeInicial='0.00';
		var $kilometrajeFinal='0.00';
		var $cargoGasolina='NO';
		var $litros='0.00';
		var $tipoCombustible='NA';
		var $id_usuario_regreso=0;
		var $fecha_regreso='0000-00-00 00:00:00';
		var $estatus='ASIGNADO';
		var $id_usuario_envio=0;
		var $fecha_envio='0000-00-00 00:00:00';
		var $id_usuario_asignado=0;
		var $fecha_asignado='0000-00-00 00:00:00';

		var $__s=array("idRutaEnvioVehiculo",
                       "idRutaEnvio",
                       "idVehiculo",
                       "kilometrajeInicial",
                       "kilometrajeFinal",
                       "cargoGasolina",
                       "litros",
                       "tipoCombustible",
                       "id_usuario_regreso",
                       "fecha_regreso",
                       "estatus",
                       "id_usuario_envio",
                       "fecha_envio",
                       "id_usuario_asignado",
                       "fecha_asignado");
				
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

		
		public function setIdRutaEnvioVehiculo($idRutaEnvioVehiculo)
		{
			if($idRutaEnvioVehiculo==0||$idRutaEnvioVehiculo==""||!is_numeric($idRutaEnvioVehiculo)|| (is_string($idRutaEnvioVehiculo)&&!ctype_digit($idRutaEnvioVehiculo)))return $this->setError("Tipo de dato incorrecto para idRutaEnvioVehiculo.");
			$this->idRutaEnvioVehiculo=$idRutaEnvioVehiculo;
			$this->getDatos();
		}
		public function setIdRutaEnvio($idRutaEnvio)
		{
			
			$this->idRutaEnvio=$idRutaEnvio;
		}
		public function setIdVehiculo($idVehiculo)
		{
			
			$this->idVehiculo=$idVehiculo;
		}
		public function setKilometrajeInicial($kilometrajeInicial)
		{
			$this->kilometrajeInicial=$kilometrajeInicial;
		}
		public function setKilometrajeFinal($kilometrajeFinal)
		{
			$this->kilometrajeFinal=$kilometrajeFinal;
		}
		public function setCargoGasolina($cargoGasolina)
		{
			
			$this->cargoGasolina=$cargoGasolina;
		}
		public function setCargoGasolinaSI()
		{
			$this->cargoGasolina='SI';
		}
		public function setCargoGasolinaNO()
		{
			$this->cargoGasolina='NO';
		}
		public function setLitros($litros)
		{
			$this->litros=$litros;
		}
		public function setTipoCombustible($tipoCombustible)
		{
			
			$this->tipoCombustible=$tipoCombustible;
		}
		public function setTipoCombustibleNA()
		{
			$this->tipoCombustible='NA';
		}
		public function setTipoCombustibleMAGNA()
		{
			$this->tipoCombustible='MAGNA';
		}
		public function setTipoCombustiblePREMIUM()
		{
			$this->tipoCombustible='PREMIUM';
		}
		public function setTipoCombustibleDIESEL()
		{
			$this->tipoCombustible='DIESEL';
		}
		public function setId_usuario_regreso($id_usuario_regreso)
		{
			
			$this->id_usuario_regreso=$id_usuario_regreso;
		}
		public function setFecha_regreso($fecha_regreso)
		{
			$this->fecha_regreso=$fecha_regreso;
		}
		public function setEstatus($estatus)
		{
			
			$this->estatus=$estatus;
		}
		public function setEstatusASIGNADO()
		{
			$this->estatus='ASIGNADO';
		}
		public function setEstatusENRUTA()
		{
			$this->estatus='ENRUTA';
		}
		public function setEstatusCOMPLETADO()
		{
			$this->estatus='COMPLETADO';
		}
		public function setId_usuario_envio($id_usuario_envio)
		{
			
			$this->id_usuario_envio=$id_usuario_envio;
		}
		public function setFecha_envio($fecha_envio)
		{
			$this->fecha_envio=$fecha_envio;
		}
		public function setId_usuario_asignado($id_usuario_asignado)
		{
			
			$this->id_usuario_asignado=$id_usuario_asignado;
		}
		public function setFecha_asignado($fecha_asignado)
		{
			$this->fecha_asignado=$fecha_asignado;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRutaEnvioVehiculo()
		{
			return $this->idRutaEnvioVehiculo;
		}
		public function getIdRutaEnvio()
		{
			return $this->idRutaEnvio;
		}
		public function getIdVehiculo()
		{
			return $this->idVehiculo;
		}
		public function getKilometrajeInicial()
		{
			return $this->kilometrajeInicial;
		}
		public function getKilometrajeFinal()
		{
			return $this->kilometrajeFinal;
		}
		public function getCargoGasolina()
		{
			return $this->cargoGasolina;
		}
		public function getLitros()
		{
			return $this->litros;
		}
		public function getTipoCombustible()
		{
			return $this->tipoCombustible;
		}
		public function getId_usuario_regreso()
		{
			return $this->id_usuario_regreso;
		}
		public function getFecha_regreso()
		{
			return $this->fecha_regreso;
		}
		public function getEstatus()
		{
			return $this->estatus;
		}
		public function getId_usuario_envio()
		{
			return $this->id_usuario_envio;
		}
		public function getFecha_envio()
		{
			return $this->fecha_envio;
		}
		public function getId_usuario_asignado()
		{
			return $this->id_usuario_asignado;
		}
		public function getFecha_asignado()
		{
			return $this->fecha_asignado;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRutaEnvioVehiculo=0;
			$this->idRutaEnvio=0;
			$this->idVehiculo=0;
			$this->kilometrajeInicial='0.00';
			$this->kilometrajeFinal='0.00';
			$this->cargoGasolina='NO';
			$this->litros='0.00';
			$this->tipoCombustible='NA';
			$this->id_usuario_regreso=0;
			$this->fecha_regreso='0000-00-00 00:00:00';
			$this->estatus='ASIGNADO';
			$this->id_usuario_envio=0;
			$this->fecha_envio='0000-00-00 00:00:00';
			$this->id_usuario_asignado=0;
			$this->fecha_asignado='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRutaEnvio,
				                                              idVehiculo,
				                                              kilometrajeInicial,
				                                              kilometrajeFinal,
				                                              cargoGasolina,
				                                              litros,
				                                              tipoCombustible,
				                                              id_usuario_regreso,
				                                              fecha_regreso,
				                                              estatus,
				                                              id_usuario_envio,
				                                              fecha_envio,
				                                              id_usuario_asignado,
				                                              fecha_asignado)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idVehiculo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilometrajeInicial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->kilometrajeFinal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cargoGasolina) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->litros) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoCombustible) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_regreso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_regreso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_envio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_envio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_asignado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_asignado) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenviovehiculo::Insertar]");
				
				$this->idRutaEnvioVehiculo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idRutaEnvio='" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio) . "',
	                                              idVehiculo='" . mysqli_real_escape_string($this->dbLink,$this->idVehiculo) . "',
	                                              kilometrajeInicial='" . mysqli_real_escape_string($this->dbLink,$this->kilometrajeInicial) . "',
	                                              kilometrajeFinal='" . mysqli_real_escape_string($this->dbLink,$this->kilometrajeFinal) . "',
	                                              cargoGasolina='" . mysqli_real_escape_string($this->dbLink,$this->cargoGasolina) . "',
	                                              litros='" . mysqli_real_escape_string($this->dbLink,$this->litros) . "',
	                                              tipoCombustible='" . mysqli_real_escape_string($this->dbLink,$this->tipoCombustible) . "',
	                                              id_usuario_regreso='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_regreso) . "',
	                                              fecha_regreso='" . mysqli_real_escape_string($this->dbLink,$this->fecha_regreso) . "',
	                                              estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
	                                              id_usuario_envio='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_envio) . "',
	                                              fecha_envio='" . mysqli_real_escape_string($this->dbLink,$this->fecha_envio) . "',
	                                              id_usuario_asignado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_asignado) . "',
	                                              fecha_asignado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_asignado) . "'
					WHERE idRutaEnvioVehiculo=" . $this->idRutaEnvioVehiculo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenviovehiculo::Update]");
				
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
				WHERE idRutaEnvioVehiculo=" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvioVehiculo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenviovehiculo::Borrar]");
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
						idRutaEnvioVehiculo,
						idRutaEnvio,
						idVehiculo,
						kilometrajeInicial,
						kilometrajeFinal,
						cargoGasolina,
						litros,
						tipoCombustible,
						id_usuario_regreso,
						fecha_regreso,
						estatus,
						id_usuario_envio,
						fecha_envio,
						id_usuario_asignado,
						fecha_asignado
					FROM " . $this->__tableName . " 
					WHERE idRutaEnvioVehiculo=" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvioVehiculo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRutaenviovehiculo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRutaEnvioVehiculo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>