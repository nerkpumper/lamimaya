<?php

	class ModeloBasePedidostracking extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePedidostracking";

		
		var $idPedidosTracking=0;
		var $idPedido=0;
		var $idPedidoTrace=0;
		var $json='';
		var $tipo='INFO';
		var $fecha='CURRENT_TIMESTAMP';
		var $track='PEDIDO';

		var $__s=array("idPedidosTracking",
                       "idPedido",
                       "idPedidoTrace",
                       "json",
                       "tipo",
                       "fecha",
                       "track");
				
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

		
		public function setIdPedidosTracking($idPedidosTracking)
		{
			if($idPedidosTracking==0||$idPedidosTracking==""||!is_numeric($idPedidosTracking)|| (is_string($idPedidosTracking)&&!ctype_digit($idPedidosTracking)))return $this->setError("Tipo de dato incorrecto para idPedidosTracking.");
			$this->idPedidosTracking=$idPedidosTracking;
			$this->getDatos();
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setIdPedidoTrace($idPedidoTrace)
		{
			
			$this->idPedidoTrace=$idPedidoTrace;
		}
		public function setJson($json)
		{
			
			$this->json=$json;
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoINFO()
		{
			$this->tipo='INFO';
		}
		public function setTipoWARNING()
		{
			$this->tipo='WARNING';
		}
		public function setTipoSUCCESS()
		{
			$this->tipo='SUCCESS';
		}
		public function setTipoERROR()
		{
			$this->tipo='ERROR';
		}
		public function setFecha($fecha)
		{
			$this->fecha=$fecha;
		}
		public function setTrack($track)
		{
			
			$this->track=$track;
		}
		public function setTrackPEDIDO()
		{
			$this->track='PEDIDO';
		}
		public function setTrackVALESALIDA()
		{
			$this->track='VALESALIDA';
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPedidosTracking()
		{
			return $this->idPedidosTracking;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getIdPedidoTrace()
		{
			return $this->idPedidoTrace;
		}
		public function getJson()
		{
			return $this->json;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getFecha()
		{
			return $this->fecha;
		}
		public function getTrack()
		{
			return $this->track;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPedidosTracking=0;
			$this->idPedido=0;
			$this->idPedidoTrace=0;
			$this->json='';
			$this->tipo='INFO';
			$this->fecha='CURRENT_TIMESTAMP';
			$this->track='PEDIDO';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPedido,
				                                              idPedidoTrace,
				                                              json,
				                                              tipo,
				                                              fecha,
				                                              track)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedidoTrace) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->json) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->track) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidostracking::Insertar]");
				
				$this->idPedidosTracking=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idPedido='" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
	                                              idPedidoTrace='" . mysqli_real_escape_string($this->dbLink,$this->idPedidoTrace) . "',
	                                              json='" . mysqli_real_escape_string($this->dbLink,$this->json) . "',
	                                              tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              fecha='" . mysqli_real_escape_string($this->dbLink,$this->fecha) . "',
	                                              track='" . mysqli_real_escape_string($this->dbLink,$this->track) . "'
					WHERE idPedidosTracking=" . $this->idPedidosTracking;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidostracking::Update]");
				
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
				WHERE idPedidosTracking=" . mysqli_real_escape_string($this->dbLink,$this->idPedidosTracking);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidostracking::Borrar]");
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
						idPedidosTracking,
						idPedido,
						idPedidoTrace,
						json,
						tipo,
						fecha,
						track
					FROM " . $this->__tableName . " 
					WHERE idPedidosTracking=" . mysqli_real_escape_string($this->dbLink,$this->idPedidosTracking);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePedidostracking::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPedidosTracking==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>