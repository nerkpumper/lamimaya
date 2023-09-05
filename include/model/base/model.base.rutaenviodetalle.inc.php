<?php

	class ModeloBaseRutaenviodetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRutaenviodetalle";

		
		var $idRutaEnvioDetalle=0;
		var $idRutaEnvio=0;
		var $idPedido=0;
		var $idValeSalida=0;
		var $maxml='0.00';
		var $maxpeso='0.00';
		var $enRuta='NO';
		var $orden=0;
		var $idRutaEnvioVehiculo=0;
		var $ordenVehiculo=0;

		var $__s=array("idRutaEnvioDetalle",
                       "idRutaEnvio",
                       "idPedido",
                       "idValeSalida",
                       "maxml",
                       "maxpeso",
                       "enRuta",
                       "orden",
                       "idRutaEnvioVehiculo",
                       "ordenVehiculo");
				
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

		
		public function setIdRutaEnvioDetalle($idRutaEnvioDetalle)
		{
			if($idRutaEnvioDetalle==0||$idRutaEnvioDetalle==""||!is_numeric($idRutaEnvioDetalle)|| (is_string($idRutaEnvioDetalle)&&!ctype_digit($idRutaEnvioDetalle)))return $this->setError("Tipo de dato incorrecto para idRutaEnvioDetalle.");
			$this->idRutaEnvioDetalle=$idRutaEnvioDetalle;
			$this->getDatos();
		}
		public function setIdRutaEnvio($idRutaEnvio)
		{
			
			$this->idRutaEnvio=$idRutaEnvio;
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setIdValeSalida($idValeSalida)
		{
			
			$this->idValeSalida=$idValeSalida;
		}
		public function setMaxml($maxml)
		{
			$this->maxml=$maxml;
		}
		public function setMaxpeso($maxpeso)
		{
			$this->maxpeso=$maxpeso;
		}
		public function setEnRuta($enRuta)
		{
			
			$this->enRuta=$enRuta;
		}
		public function setEnRutaSI()
		{
			$this->enRuta='SI';
		}
		public function setEnRutaNO()
		{
			$this->enRuta='NO';
		}
		public function setOrden($orden)
		{
			
			$this->orden=$orden;
		}
		public function setIdRutaEnvioVehiculo($idRutaEnvioVehiculo)
		{
			
			$this->idRutaEnvioVehiculo=$idRutaEnvioVehiculo;
		}
		public function setOrdenVehiculo($ordenVehiculo)
		{
			
			$this->ordenVehiculo=$ordenVehiculo;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRutaEnvioDetalle()
		{
			return $this->idRutaEnvioDetalle;
		}
		public function getIdRutaEnvio()
		{
			return $this->idRutaEnvio;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getIdValeSalida()
		{
			return $this->idValeSalida;
		}
		public function getMaxml()
		{
			return $this->maxml;
		}
		public function getMaxpeso()
		{
			return $this->maxpeso;
		}
		public function getEnRuta()
		{
			return $this->enRuta;
		}
		public function getOrden()
		{
			return $this->orden;
		}
		public function getIdRutaEnvioVehiculo()
		{
			return $this->idRutaEnvioVehiculo;
		}
		public function getOrdenVehiculo()
		{
			return $this->ordenVehiculo;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRutaEnvioDetalle=0;
			$this->idRutaEnvio=0;
			$this->idPedido=0;
			$this->idValeSalida=0;
			$this->maxml='0.00';
			$this->maxpeso='0.00';
			$this->enRuta='NO';
			$this->orden=0;
			$this->idRutaEnvioVehiculo=0;
			$this->ordenVehiculo=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idRutaEnvio,
				                                              idPedido,
				                                              idValeSalida,
				                                              maxml,
				                                              maxpeso,
				                                              enRuta,
				                                              orden,
				                                              idRutaEnvioVehiculo,
				                                              ordenVehiculo)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idValeSalida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->maxml) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->maxpeso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->enRuta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->orden) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvioVehiculo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ordenVehiculo) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenviodetalle::Insertar]");
				
				$this->idRutaEnvioDetalle=mysqli_insert_id($this->dbLink);
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
	                                              idPedido='" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
	                                              idValeSalida='" . mysqli_real_escape_string($this->dbLink,$this->idValeSalida) . "',
	                                              maxml='" . mysqli_real_escape_string($this->dbLink,$this->maxml) . "',
	                                              maxpeso='" . mysqli_real_escape_string($this->dbLink,$this->maxpeso) . "',
	                                              enRuta='" . mysqli_real_escape_string($this->dbLink,$this->enRuta) . "',
	                                              orden='" . mysqli_real_escape_string($this->dbLink,$this->orden) . "',
	                                              idRutaEnvioVehiculo='" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvioVehiculo) . "',
	                                              ordenVehiculo='" . mysqli_real_escape_string($this->dbLink,$this->ordenVehiculo) . "'
					WHERE idRutaEnvioDetalle=" . $this->idRutaEnvioDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenviodetalle::Update]");
				
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
				WHERE idRutaEnvioDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvioDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRutaenviodetalle::Borrar]");
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
						idRutaEnvioDetalle,
						idRutaEnvio,
						idPedido,
						idValeSalida,
						maxml,
						maxpeso,
						enRuta,
						orden,
						idRutaEnvioVehiculo,
						ordenVehiculo
					FROM " . $this->__tableName . " 
					WHERE idRutaEnvioDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvioDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRutaenviodetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRutaEnvioDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>