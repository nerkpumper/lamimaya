<?php

	class ModeloBaseTransferenciastock extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseTransferenciastock";

		
		var $idTransferenciaStock=0;
		var $sucursalOrigen=0;
		var $sucursalDestino=0;
		var $estatus='CREADA';
		var $fecha_crea='0000-00-00 00:00:00';
		var $id_usuario_crea=0;
		var $fecha_acepta='0000-00-00 00:00:00';
		var $id_usuario_acepta='0';
		var $fecha_cancela='0000-00-00 00:00:00';
		var $id_usuario_cancela=0;

		var $__s=array("idTransferenciaStock",
                       "sucursalOrigen",
                       "sucursalDestino",
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

		
		public function setIdTransferenciaStock($idTransferenciaStock)
		{
			if($idTransferenciaStock==0||$idTransferenciaStock==""||!is_numeric($idTransferenciaStock)|| (is_string($idTransferenciaStock)&&!ctype_digit($idTransferenciaStock)))return $this->setError("Tipo de dato incorrecto para idTransferenciaStock.");
			$this->idTransferenciaStock=$idTransferenciaStock;
			$this->getDatos();
		}
		public function setSucursalOrigen($sucursalOrigen)
		{
			
			$this->sucursalOrigen=$sucursalOrigen;
		}
		public function setSucursalDestino($sucursalDestino)
		{
			
			$this->sucursalDestino=$sucursalDestino;
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

		
		public function getIdTransferenciaStock()
		{
			return $this->idTransferenciaStock;
		}
		public function getSucursalOrigen()
		{
			return $this->sucursalOrigen;
		}
		public function getSucursalDestino()
		{
			return $this->sucursalDestino;
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
			
			$this->idTransferenciaStock=0;
			$this->sucursalOrigen=0;
			$this->sucursalDestino=0;
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
				$SQL="INSERT INTO " . $this->__tableName . " (sucursalOrigen,
				                                              sucursalDestino,
				                                              estatus,
				                                              fecha_crea,
				                                              id_usuario_crea,
				                                              fecha_acepta,
				                                              id_usuario_acepta,
				                                              fecha_cancela,
				                                              id_usuario_cancela)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->sucursalOrigen) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->sucursalDestino) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_acepta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_acepta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_cancela) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_cancela) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciastock::Insertar]");
				
				$this->idTransferenciaStock=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET sucursalOrigen='" . mysqli_real_escape_string($this->dbLink,$this->sucursalOrigen) . "',
	                                              sucursalDestino='" . mysqli_real_escape_string($this->dbLink,$this->sucursalDestino) . "',
	                                              estatus='" . mysqli_real_escape_string($this->dbLink,$this->estatus) . "',
	                                              fecha_crea='" . mysqli_real_escape_string($this->dbLink,$this->fecha_crea) . "',
	                                              id_usuario_crea='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_crea) . "',
	                                              fecha_acepta='" . mysqli_real_escape_string($this->dbLink,$this->fecha_acepta) . "',
	                                              id_usuario_acepta='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_acepta) . "',
	                                              fecha_cancela='" . mysqli_real_escape_string($this->dbLink,$this->fecha_cancela) . "',
	                                              id_usuario_cancela='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_cancela) . "'
					WHERE idTransferenciaStock=" . $this->idTransferenciaStock;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciastock::Update]");
				
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
				WHERE idTransferenciaStock=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaStock);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseTransferenciastock::Borrar]");
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
						idTransferenciaStock,
						sucursalOrigen,
						sucursalDestino,
						estatus,
						fecha_crea,
						id_usuario_crea,
						fecha_acepta,
						id_usuario_acepta,
						fecha_cancela,
						id_usuario_cancela
					FROM " . $this->__tableName . " 
					WHERE idTransferenciaStock=" . mysqli_real_escape_string($this->dbLink,$this->idTransferenciaStock);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseTransferenciastock::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idTransferenciaStock==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>