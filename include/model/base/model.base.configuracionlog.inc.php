<?php

	class ModeloBaseConfiguracionlog extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseConfiguracionlog";

		
		var $idConfiguracionLog=0;
		var $rangoMetros1Inicio='0';
		var $rangoMetros1Fin='0';
		var $rangoMetros2Inicio='0';
		var $rangoMetros2Fin='0';
		var $rangoMetros3Inicio='0';
		var $rangoMetros3Fin='0';
		var $pesoXCalibre22='0';
		var $pesoXCalibre24='0';
		var $pesoXCalibre26='0';
		var $pesoXCalibre28='0';
		var $pedidoDescuento='0';
		var $comision1R1='0';
		var $comision1R2='0';
		var $comision1R3='0';
		var $comision2R1='0';
		var $comision2R2='0';
		var $comision2R3='0';
		var $comision3R1='0';
		var $comision3R2='0';
		var $comision3R3='0';
		var $fecha_modificacion='0000-00-00 00:00:00';
		var $id_usuario_modificacion=0;

		var $__s=array("idConfiguracionLog",
                       "rangoMetros1Inicio",
                       "rangoMetros1Fin",
                       "rangoMetros2Inicio",
                       "rangoMetros2Fin",
                       "rangoMetros3Inicio",
                       "rangoMetros3Fin",
                       "pesoXCalibre22",
                       "pesoXCalibre24",
                       "pesoXCalibre26",
                       "pesoXCalibre28",
                       "pedidoDescuento",
                       "comision1R1",
                       "comision1R2",
                       "comision1R3",
                       "comision2R1",
                       "comision2R2",
                       "comision2R3",
                       "comision3R1",
                       "comision3R2",
                       "comision3R3",
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

		
		public function setIdConfiguracionLog($idConfiguracionLog)
		{
			if($idConfiguracionLog==0||$idConfiguracionLog==""||!is_numeric($idConfiguracionLog)|| (is_string($idConfiguracionLog)&&!ctype_digit($idConfiguracionLog)))return $this->setError("Tipo de dato incorrecto para idConfiguracionLog.");
			$this->idConfiguracionLog=$idConfiguracionLog;
			$this->getDatos();
		}
		public function setRangoMetros1Inicio($rangoMetros1Inicio)
		{
			$this->rangoMetros1Inicio=$rangoMetros1Inicio;
		}
		public function setRangoMetros1Fin($rangoMetros1Fin)
		{
			$this->rangoMetros1Fin=$rangoMetros1Fin;
		}
		public function setRangoMetros2Inicio($rangoMetros2Inicio)
		{
			$this->rangoMetros2Inicio=$rangoMetros2Inicio;
		}
		public function setRangoMetros2Fin($rangoMetros2Fin)
		{
			$this->rangoMetros2Fin=$rangoMetros2Fin;
		}
		public function setRangoMetros3Inicio($rangoMetros3Inicio)
		{
			$this->rangoMetros3Inicio=$rangoMetros3Inicio;
		}
		public function setRangoMetros3Fin($rangoMetros3Fin)
		{
			$this->rangoMetros3Fin=$rangoMetros3Fin;
		}
		public function setPesoXCalibre22($pesoXCalibre22)
		{
			$this->pesoXCalibre22=$pesoXCalibre22;
		}
		public function setPesoXCalibre24($pesoXCalibre24)
		{
			$this->pesoXCalibre24=$pesoXCalibre24;
		}
		public function setPesoXCalibre26($pesoXCalibre26)
		{
			$this->pesoXCalibre26=$pesoXCalibre26;
		}
		public function setPesoXCalibre28($pesoXCalibre28)
		{
			$this->pesoXCalibre28=$pesoXCalibre28;
		}
		public function setPedidoDescuento($pedidoDescuento)
		{
			$this->pedidoDescuento=$pedidoDescuento;
		}
		public function setComision1R1($comision1R1)
		{
			$this->comision1R1=$comision1R1;
		}
		public function setComision1R2($comision1R2)
		{
			$this->comision1R2=$comision1R2;
		}
		public function setComision1R3($comision1R3)
		{
			$this->comision1R3=$comision1R3;
		}
		public function setComision2R1($comision2R1)
		{
			$this->comision2R1=$comision2R1;
		}
		public function setComision2R2($comision2R2)
		{
			$this->comision2R2=$comision2R2;
		}
		public function setComision2R3($comision2R3)
		{
			$this->comision2R3=$comision2R3;
		}
		public function setComision3R1($comision3R1)
		{
			$this->comision3R1=$comision3R1;
		}
		public function setComision3R2($comision3R2)
		{
			$this->comision3R2=$comision3R2;
		}
		public function setComision3R3($comision3R3)
		{
			$this->comision3R3=$comision3R3;
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

		
		public function getIdConfiguracionLog()
		{
			return $this->idConfiguracionLog;
		}
		public function getRangoMetros1Inicio()
		{
			return $this->rangoMetros1Inicio;
		}
		public function getRangoMetros1Fin()
		{
			return $this->rangoMetros1Fin;
		}
		public function getRangoMetros2Inicio()
		{
			return $this->rangoMetros2Inicio;
		}
		public function getRangoMetros2Fin()
		{
			return $this->rangoMetros2Fin;
		}
		public function getRangoMetros3Inicio()
		{
			return $this->rangoMetros3Inicio;
		}
		public function getRangoMetros3Fin()
		{
			return $this->rangoMetros3Fin;
		}
		public function getPesoXCalibre22()
		{
			return $this->pesoXCalibre22;
		}
		public function getPesoXCalibre24()
		{
			return $this->pesoXCalibre24;
		}
		public function getPesoXCalibre26()
		{
			return $this->pesoXCalibre26;
		}
		public function getPesoXCalibre28()
		{
			return $this->pesoXCalibre28;
		}
		public function getPedidoDescuento()
		{
			return $this->pedidoDescuento;
		}
		public function getComision1R1()
		{
			return $this->comision1R1;
		}
		public function getComision1R2()
		{
			return $this->comision1R2;
		}
		public function getComision1R3()
		{
			return $this->comision1R3;
		}
		public function getComision2R1()
		{
			return $this->comision2R1;
		}
		public function getComision2R2()
		{
			return $this->comision2R2;
		}
		public function getComision2R3()
		{
			return $this->comision2R3;
		}
		public function getComision3R1()
		{
			return $this->comision3R1;
		}
		public function getComision3R2()
		{
			return $this->comision3R2;
		}
		public function getComision3R3()
		{
			return $this->comision3R3;
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
			
			$this->idConfiguracionLog=0;
			$this->rangoMetros1Inicio='0';
			$this->rangoMetros1Fin='0';
			$this->rangoMetros2Inicio='0';
			$this->rangoMetros2Fin='0';
			$this->rangoMetros3Inicio='0';
			$this->rangoMetros3Fin='0';
			$this->pesoXCalibre22='0';
			$this->pesoXCalibre24='0';
			$this->pesoXCalibre26='0';
			$this->pesoXCalibre28='0';
			$this->pedidoDescuento='0';
			$this->comision1R1='0';
			$this->comision1R2='0';
			$this->comision1R3='0';
			$this->comision2R1='0';
			$this->comision2R2='0';
			$this->comision2R3='0';
			$this->comision3R1='0';
			$this->comision3R2='0';
			$this->comision3R3='0';
			$this->fecha_modificacion='0000-00-00 00:00:00';
			$this->id_usuario_modificacion=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (rangoMetros1Inicio,
				                                              rangoMetros1Fin,
				                                              rangoMetros2Inicio,
				                                              rangoMetros2Fin,
				                                              rangoMetros3Inicio,
				                                              rangoMetros3Fin,
				                                              pesoXCalibre22,
				                                              pesoXCalibre24,
				                                              pesoXCalibre26,
				                                              pesoXCalibre28,
				                                              pedidoDescuento,
				                                              comision1R1,
				                                              comision1R2,
				                                              comision1R3,
				                                              comision2R1,
				                                              comision2R2,
				                                              comision2R3,
				                                              comision3R1,
				                                              comision3R2,
				                                              comision3R3,
				                                              fecha_modificacion,
				                                              id_usuario_modificacion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1Inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1Fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2Inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2Fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3Inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3Fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre22) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre24) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre26) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre28) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pedidoDescuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modificacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modificacion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracionlog::Insertar]");
				
				$this->idConfiguracionLog=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET rangoMetros1Inicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1Inicio) . "',
	                                              rangoMetros1Fin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1Fin) . "',
	                                              rangoMetros2Inicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2Inicio) . "',
	                                              rangoMetros2Fin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2Fin) . "',
	                                              rangoMetros3Inicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3Inicio) . "',
	                                              rangoMetros3Fin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3Fin) . "',
	                                              pesoXCalibre22='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre22) . "',
	                                              pesoXCalibre24='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre24) . "',
	                                              pesoXCalibre26='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre26) . "',
	                                              pesoXCalibre28='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre28) . "',
	                                              pedidoDescuento='" . mysqli_real_escape_string($this->dbLink,$this->pedidoDescuento) . "',
	                                              comision1R1='" . mysqli_real_escape_string($this->dbLink,$this->comision1R1) . "',
	                                              comision1R2='" . mysqli_real_escape_string($this->dbLink,$this->comision1R2) . "',
	                                              comision1R3='" . mysqli_real_escape_string($this->dbLink,$this->comision1R3) . "',
	                                              comision2R1='" . mysqli_real_escape_string($this->dbLink,$this->comision2R1) . "',
	                                              comision2R2='" . mysqli_real_escape_string($this->dbLink,$this->comision2R2) . "',
	                                              comision2R3='" . mysqli_real_escape_string($this->dbLink,$this->comision2R3) . "',
	                                              comision3R1='" . mysqli_real_escape_string($this->dbLink,$this->comision3R1) . "',
	                                              comision3R2='" . mysqli_real_escape_string($this->dbLink,$this->comision3R2) . "',
	                                              comision3R3='" . mysqli_real_escape_string($this->dbLink,$this->comision3R3) . "',
	                                              fecha_modificacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modificacion) . "',
	                                              id_usuario_modificacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modificacion) . "'
					WHERE idConfiguracionLog=" . $this->idConfiguracionLog;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracionlog::Update]");
				
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
				WHERE idConfiguracionLog=" . mysqli_real_escape_string($this->dbLink,$this->idConfiguracionLog);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracionlog::Borrar]");
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
						idConfiguracionLog,
						rangoMetros1Inicio,
						rangoMetros1Fin,
						rangoMetros2Inicio,
						rangoMetros2Fin,
						rangoMetros3Inicio,
						rangoMetros3Fin,
						pesoXCalibre22,
						pesoXCalibre24,
						pesoXCalibre26,
						pesoXCalibre28,
						pedidoDescuento,
						comision1R1,
						comision1R2,
						comision1R3,
						comision2R1,
						comision2R2,
						comision2R3,
						comision3R1,
						comision3R2,
						comision3R3,
						fecha_modificacion,
						id_usuario_modificacion
					FROM " . $this->__tableName . " 
					WHERE idConfiguracionLog=" . mysqli_real_escape_string($this->dbLink,$this->idConfiguracionLog);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseConfiguracionlog::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idConfiguracionLog==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>