<?php

	class ModeloBasePesomt extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePesomt";

		
		var $idPesoMt=0;
		var $calibre=0;
		var $pies2='0';
		var $pies3='0';
		var $pies348='0';
		var $pies376='0';
		var $pies4='0';
		var $fecha_modificacion='0000-00-00 00:00:00';
		var $id_usuario_modificacion=0;

		var $__s=array("idPesoMt",
                       "calibre",
                       "pies2",
                       "pies3",
                       "pies348",
                       "pies376",
                       "pies4",
                       "fecha_modificacion",
                       "id_usuario_modificacion");
				
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

		
		public function setIdPesoMt($idPesoMt)
		{
			if($idPesoMt==0||$idPesoMt==""||!is_numeric($idPesoMt)|| (is_string($idPesoMt)&&!ctype_digit($idPesoMt)))return $this->setError("Tipo de dato incorrecto para idPesoMt.");
			$this->idPesoMt=$idPesoMt;
			$this->getDatos();
		}
		public function setCalibre($calibre)
		{
			
			$this->calibre=$calibre;
		}
		public function setPies2($pies2)
		{
			$this->pies2=$pies2;
		}
		public function setPies3($pies3)
		{
			$this->pies3=$pies3;
		}
		public function setPies348($pies348)
		{
			$this->pies348=$pies348;
		}
		public function setPies376($pies376)
		{
			$this->pies376=$pies376;
		}
		public function setPies4($pies4)
		{
			$this->pies4=$pies4;
		}
		public function setFecha_modificacion($fecha_modificacion)
		{
			$this->fecha_modificacion=$fecha_modificacion;
		}
		public function setId_usuario_modificacion($id_usuario_modificacion)
		{
			
			$this->id_usuario_modificacion=$id_usuario_modificacion;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPesoMt()
		{
			return $this->idPesoMt;
		}
		public function getCalibre()
		{
			return $this->calibre;
		}
		public function getPies2()
		{
			return $this->pies2;
		}
		public function getPies3()
		{
			return $this->pies3;
		}
		public function getPies348()
		{
			return $this->pies348;
		}
		public function getPies376()
		{
			return $this->pies376;
		}
		public function getPies4()
		{
			return $this->pies4;
		}
		public function getFecha_modificacion()
		{
			return $this->fecha_modificacion;
		}
		public function getId_usuario_modificacion()
		{
			return $this->id_usuario_modificacion;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPesoMt=0;
			$this->calibre=0;
			$this->pies2='0';
			$this->pies3='0';
			$this->pies348='0';
			$this->pies376='0';
			$this->pies4='0';
			$this->fecha_modificacion='0000-00-00 00:00:00';
			$this->id_usuario_modificacion=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (calibre,
				                                              pies2,
				                                              pies3,
				                                              pies348,
				                                              pies376,
				                                              pies4,
				                                              fecha_modificacion,
				                                              id_usuario_modificacion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies348) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies376) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modificacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modificacion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePesomt::Insertar]");
				
				$this->idPesoMt=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET calibre='" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
	                                              pies2='" . mysqli_real_escape_string($this->dbLink,$this->pies2) . "',
	                                              pies3='" . mysqli_real_escape_string($this->dbLink,$this->pies3) . "',
	                                              pies348='" . mysqli_real_escape_string($this->dbLink,$this->pies348) . "',
	                                              pies376='" . mysqli_real_escape_string($this->dbLink,$this->pies376) . "',
	                                              pies4='" . mysqli_real_escape_string($this->dbLink,$this->pies4) . "',
	                                              fecha_modificacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modificacion) . "',
	                                              id_usuario_modificacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modificacion) . "'
					WHERE idPesoMt=" . $this->idPesoMt;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePesomt::Update]");
				
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
				WHERE idPesoMt=" . mysqli_real_escape_string($this->dbLink,$this->idPesoMt);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePesomt::Borrar]");
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
						idPesoMt,
						calibre,
						pies2,
						pies3,
						pies348,
						pies376,
						pies4,
						fecha_modificacion,
						id_usuario_modificacion
					FROM " . $this->__tableName . " 
					WHERE idPesoMt=" . mysqli_real_escape_string($this->dbLink,$this->idPesoMt);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePesomt::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPesoMt==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>