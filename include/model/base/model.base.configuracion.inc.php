<?php

	class ModeloBaseConfiguracion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseConfiguracion";

		
		var $idConfiguracion=0;
		var $rangoMetros1Inicio='0';
		var $rangoMetros1Fin='0';
		var $rangoMetros2Inicio='0';
		var $rangoMetros2Fin='0';
		var $rangoMetros3Inicio='0';
		var $rangoMetros3Fin='0';
		var $rangoMetros1AcryOpaInicio='0';
		var $rangoMetros1AcryOpaFin='0';
		var $rangoMetros2AcryOpaInicio='0';
		var $rangoMetros2AcryOpaFin='0';
		var $rangoMetros3AcryOpaInicio='0';
		var $rangoMetros3AcryOpaFin='0';
		var $rangoMetros1MultipanelInicio='0';
		var $rangoMetros1MultipanelFin='0';
		var $rangoMetros2MultipanelInicio='0';
		var $rangoMetros2MultipanelFin='0';
		var $rangoMetros3MultipanelInicio='0';
		var $rangoMetros3MultipanelFin='0';
		var $pesoXCalibre20='0';
		var $pesoXCalibre22='0';
		var $pesoXCalibre24='0';
		var $pesoXCalibre26='0';
		var $pesoXCalibre28='0';
		var $pedidoDescuento='0';
		var $comision1R1='0';
		var $comision1R2='0';
		var $comision1R3='0';
		var $comision1R4='0';
		var $comision2R1='0';
		var $comision2R2='0';
		var $comision2R3='0';
		var $comision2R4='0';
		var $comision3R1='0';
		var $comision3R2='0';
		var $comision3R3='0';
		var $comision3R4='0';
		var $lastCheckUpdatePrecios='CURRENT_TIMESTAMP';
		var $lastIdPedidoChecked=0;
		var $rolloprodlastupdate='CURRENT_TIMESTAMP';
		var $fecha_modificacion='0000-00-00 00:00:00';
		var $id_usuario_modificacion=0;

		var $__s=array("idConfiguracion",
                       "rangoMetros1Inicio",
                       "rangoMetros1Fin",
                       "rangoMetros2Inicio",
                       "rangoMetros2Fin",
                       "rangoMetros3Inicio",
                       "rangoMetros3Fin",
                       "rangoMetros1AcryOpaInicio",
                       "rangoMetros1AcryOpaFin",
                       "rangoMetros2AcryOpaInicio",
                       "rangoMetros2AcryOpaFin",
                       "rangoMetros3AcryOpaInicio",
                       "rangoMetros3AcryOpaFin",
                       "rangoMetros1MultipanelInicio",
                       "rangoMetros1MultipanelFin",
                       "rangoMetros2MultipanelInicio",
                       "rangoMetros2MultipanelFin",
                       "rangoMetros3MultipanelInicio",
                       "rangoMetros3MultipanelFin",
                       "pesoXCalibre20",
                       "pesoXCalibre22",
                       "pesoXCalibre24",
                       "pesoXCalibre26",
                       "pesoXCalibre28",
                       "pedidoDescuento",
                       "comision1R1",
                       "comision1R2",
                       "comision1R3",
                       "comision1R4",
                       "comision2R1",
                       "comision2R2",
                       "comision2R3",
                       "comision2R4",
                       "comision3R1",
                       "comision3R2",
                       "comision3R3",
                       "comision3R4",
                       "lastCheckUpdatePrecios",
                       "lastIdPedidoChecked",
                       "rolloprodlastupdate",
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

		
		public function setIdConfiguracion($idConfiguracion)
		{
			if($idConfiguracion==0||$idConfiguracion==""||!is_numeric($idConfiguracion)|| (is_string($idConfiguracion)&&!ctype_digit($idConfiguracion)))return $this->setError("Tipo de dato incorrecto para idConfiguracion.");
			$this->idConfiguracion=$idConfiguracion;
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
		public function setRangoMetros1AcryOpaInicio($rangoMetros1AcryOpaInicio)
		{
			$this->rangoMetros1AcryOpaInicio=$rangoMetros1AcryOpaInicio;
		}
		public function setRangoMetros1AcryOpaFin($rangoMetros1AcryOpaFin)
		{
			$this->rangoMetros1AcryOpaFin=$rangoMetros1AcryOpaFin;
		}
		public function setRangoMetros2AcryOpaInicio($rangoMetros2AcryOpaInicio)
		{
			$this->rangoMetros2AcryOpaInicio=$rangoMetros2AcryOpaInicio;
		}
		public function setRangoMetros2AcryOpaFin($rangoMetros2AcryOpaFin)
		{
			$this->rangoMetros2AcryOpaFin=$rangoMetros2AcryOpaFin;
		}
		public function setRangoMetros3AcryOpaInicio($rangoMetros3AcryOpaInicio)
		{
			$this->rangoMetros3AcryOpaInicio=$rangoMetros3AcryOpaInicio;
		}
		public function setRangoMetros3AcryOpaFin($rangoMetros3AcryOpaFin)
		{
			$this->rangoMetros3AcryOpaFin=$rangoMetros3AcryOpaFin;
		}
		public function setRangoMetros1MultipanelInicio($rangoMetros1MultipanelInicio)
		{
			$this->rangoMetros1MultipanelInicio=$rangoMetros1MultipanelInicio;
		}
		public function setRangoMetros1MultipanelFin($rangoMetros1MultipanelFin)
		{
			$this->rangoMetros1MultipanelFin=$rangoMetros1MultipanelFin;
		}
		public function setRangoMetros2MultipanelInicio($rangoMetros2MultipanelInicio)
		{
			$this->rangoMetros2MultipanelInicio=$rangoMetros2MultipanelInicio;
		}
		public function setRangoMetros2MultipanelFin($rangoMetros2MultipanelFin)
		{
			$this->rangoMetros2MultipanelFin=$rangoMetros2MultipanelFin;
		}
		public function setRangoMetros3MultipanelInicio($rangoMetros3MultipanelInicio)
		{
			$this->rangoMetros3MultipanelInicio=$rangoMetros3MultipanelInicio;
		}
		public function setRangoMetros3MultipanelFin($rangoMetros3MultipanelFin)
		{
			$this->rangoMetros3MultipanelFin=$rangoMetros3MultipanelFin;
		}
		public function setPesoXCalibre20($pesoXCalibre20)
		{
			$this->pesoXCalibre20=$pesoXCalibre20;
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
		public function setComision1R4($comision1R4)
		{
			$this->comision1R4=$comision1R4;
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
		public function setComision2R4($comision2R4)
		{
			$this->comision2R4=$comision2R4;
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
		public function setComision3R4($comision3R4)
		{
			$this->comision3R4=$comision3R4;
		}
		public function setLastCheckUpdatePrecios($lastCheckUpdatePrecios)
		{
			$this->lastCheckUpdatePrecios=$lastCheckUpdatePrecios;
		}
		public function setLastIdPedidoChecked($lastIdPedidoChecked)
		{
			
			$this->lastIdPedidoChecked=$lastIdPedidoChecked;
		}
		public function setRolloprodlastupdate($rolloprodlastupdate)
		{
			$this->rolloprodlastupdate=$rolloprodlastupdate;
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

		
		public function getIdConfiguracion()
		{
			return $this->idConfiguracion;
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
		public function getRangoMetros1AcryOpaInicio()
		{
			return $this->rangoMetros1AcryOpaInicio;
		}
		public function getRangoMetros1AcryOpaFin()
		{
			return $this->rangoMetros1AcryOpaFin;
		}
		public function getRangoMetros2AcryOpaInicio()
		{
			return $this->rangoMetros2AcryOpaInicio;
		}
		public function getRangoMetros2AcryOpaFin()
		{
			return $this->rangoMetros2AcryOpaFin;
		}
		public function getRangoMetros3AcryOpaInicio()
		{
			return $this->rangoMetros3AcryOpaInicio;
		}
		public function getRangoMetros3AcryOpaFin()
		{
			return $this->rangoMetros3AcryOpaFin;
		}
		public function getRangoMetros1MultipanelInicio()
		{
			return $this->rangoMetros1MultipanelInicio;
		}
		public function getRangoMetros1MultipanelFin()
		{
			return $this->rangoMetros1MultipanelFin;
		}
		public function getRangoMetros2MultipanelInicio()
		{
			return $this->rangoMetros2MultipanelInicio;
		}
		public function getRangoMetros2MultipanelFin()
		{
			return $this->rangoMetros2MultipanelFin;
		}
		public function getRangoMetros3MultipanelInicio()
		{
			return $this->rangoMetros3MultipanelInicio;
		}
		public function getRangoMetros3MultipanelFin()
		{
			return $this->rangoMetros3MultipanelFin;
		}
		public function getPesoXCalibre20()
		{
			return $this->pesoXCalibre20;
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
		public function getComision1R4()
		{
			return $this->comision1R4;
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
		public function getComision2R4()
		{
			return $this->comision2R4;
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
		public function getComision3R4()
		{
			return $this->comision3R4;
		}
		public function getLastCheckUpdatePrecios()
		{
			return $this->lastCheckUpdatePrecios;
		}
		public function getLastIdPedidoChecked()
		{
			return $this->lastIdPedidoChecked;
		}
		public function getRolloprodlastupdate()
		{
			return $this->rolloprodlastupdate;
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
			
			$this->idConfiguracion=0;
			$this->rangoMetros1Inicio='0';
			$this->rangoMetros1Fin='0';
			$this->rangoMetros2Inicio='0';
			$this->rangoMetros2Fin='0';
			$this->rangoMetros3Inicio='0';
			$this->rangoMetros3Fin='0';
			$this->rangoMetros1AcryOpaInicio='0';
			$this->rangoMetros1AcryOpaFin='0';
			$this->rangoMetros2AcryOpaInicio='0';
			$this->rangoMetros2AcryOpaFin='0';
			$this->rangoMetros3AcryOpaInicio='0';
			$this->rangoMetros3AcryOpaFin='0';
			$this->rangoMetros1MultipanelInicio='0';
			$this->rangoMetros1MultipanelFin='0';
			$this->rangoMetros2MultipanelInicio='0';
			$this->rangoMetros2MultipanelFin='0';
			$this->rangoMetros3MultipanelInicio='0';
			$this->rangoMetros3MultipanelFin='0';
			$this->pesoXCalibre20='0';
			$this->pesoXCalibre22='0';
			$this->pesoXCalibre24='0';
			$this->pesoXCalibre26='0';
			$this->pesoXCalibre28='0';
			$this->pedidoDescuento='0';
			$this->comision1R1='0';
			$this->comision1R2='0';
			$this->comision1R3='0';
			$this->comision1R4='0';
			$this->comision2R1='0';
			$this->comision2R2='0';
			$this->comision2R3='0';
			$this->comision2R4='0';
			$this->comision3R1='0';
			$this->comision3R2='0';
			$this->comision3R3='0';
			$this->comision3R4='0';
			$this->lastCheckUpdatePrecios='CURRENT_TIMESTAMP';
			$this->lastIdPedidoChecked=0;
			$this->rolloprodlastupdate='CURRENT_TIMESTAMP';
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
				                                              rangoMetros1AcryOpaInicio,
				                                              rangoMetros1AcryOpaFin,
				                                              rangoMetros2AcryOpaInicio,
				                                              rangoMetros2AcryOpaFin,
				                                              rangoMetros3AcryOpaInicio,
				                                              rangoMetros3AcryOpaFin,
				                                              rangoMetros1MultipanelInicio,
				                                              rangoMetros1MultipanelFin,
				                                              rangoMetros2MultipanelInicio,
				                                              rangoMetros2MultipanelFin,
				                                              rangoMetros3MultipanelInicio,
				                                              rangoMetros3MultipanelFin,
				                                              pesoXCalibre20,
				                                              pesoXCalibre22,
				                                              pesoXCalibre24,
				                                              pesoXCalibre26,
				                                              pesoXCalibre28,
				                                              pedidoDescuento,
				                                              comision1R1,
				                                              comision1R2,
				                                              comision1R3,
				                                              comision1R4,
				                                              comision2R1,
				                                              comision2R2,
				                                              comision2R3,
				                                              comision2R4,
				                                              comision3R1,
				                                              comision3R2,
				                                              comision3R3,
				                                              comision3R4,
				                                              lastCheckUpdatePrecios,
				                                              lastIdPedidoChecked,
				                                              rolloprodlastupdate,
				                                              fecha_modificacion,
				                                              id_usuario_modificacion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1Inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1Fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2Inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2Fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3Inicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3Fin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1AcryOpaInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1AcryOpaFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2AcryOpaInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2AcryOpaFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3AcryOpaInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3AcryOpaFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1MultipanelInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1MultipanelFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2MultipanelInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2MultipanelFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3MultipanelInicio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3MultipanelFin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre20) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre22) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre24) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre26) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre28) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pedidoDescuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision1R4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision2R4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision3R4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->lastCheckUpdatePrecios) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->lastIdPedidoChecked) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloprodlastupdate) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modificacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modificacion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracion::Insertar]");
				
				$this->idConfiguracion=mysqli_insert_id($this->dbLink);
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
	                                              rangoMetros1AcryOpaInicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1AcryOpaInicio) . "',
	                                              rangoMetros1AcryOpaFin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1AcryOpaFin) . "',
	                                              rangoMetros2AcryOpaInicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2AcryOpaInicio) . "',
	                                              rangoMetros2AcryOpaFin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2AcryOpaFin) . "',
	                                              rangoMetros3AcryOpaInicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3AcryOpaInicio) . "',
	                                              rangoMetros3AcryOpaFin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3AcryOpaFin) . "',
	                                              rangoMetros1MultipanelInicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1MultipanelInicio) . "',
	                                              rangoMetros1MultipanelFin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros1MultipanelFin) . "',
	                                              rangoMetros2MultipanelInicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2MultipanelInicio) . "',
	                                              rangoMetros2MultipanelFin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros2MultipanelFin) . "',
	                                              rangoMetros3MultipanelInicio='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3MultipanelInicio) . "',
	                                              rangoMetros3MultipanelFin='" . mysqli_real_escape_string($this->dbLink,$this->rangoMetros3MultipanelFin) . "',
	                                              pesoXCalibre20='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre20) . "',
	                                              pesoXCalibre22='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre22) . "',
	                                              pesoXCalibre24='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre24) . "',
	                                              pesoXCalibre26='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre26) . "',
	                                              pesoXCalibre28='" . mysqli_real_escape_string($this->dbLink,$this->pesoXCalibre28) . "',
	                                              pedidoDescuento='" . mysqli_real_escape_string($this->dbLink,$this->pedidoDescuento) . "',
	                                              comision1R1='" . mysqli_real_escape_string($this->dbLink,$this->comision1R1) . "',
	                                              comision1R2='" . mysqli_real_escape_string($this->dbLink,$this->comision1R2) . "',
	                                              comision1R3='" . mysqli_real_escape_string($this->dbLink,$this->comision1R3) . "',
	                                              comision1R4='" . mysqli_real_escape_string($this->dbLink,$this->comision1R4) . "',
	                                              comision2R1='" . mysqli_real_escape_string($this->dbLink,$this->comision2R1) . "',
	                                              comision2R2='" . mysqli_real_escape_string($this->dbLink,$this->comision2R2) . "',
	                                              comision2R3='" . mysqli_real_escape_string($this->dbLink,$this->comision2R3) . "',
	                                              comision2R4='" . mysqli_real_escape_string($this->dbLink,$this->comision2R4) . "',
	                                              comision3R1='" . mysqli_real_escape_string($this->dbLink,$this->comision3R1) . "',
	                                              comision3R2='" . mysqli_real_escape_string($this->dbLink,$this->comision3R2) . "',
	                                              comision3R3='" . mysqli_real_escape_string($this->dbLink,$this->comision3R3) . "',
	                                              comision3R4='" . mysqli_real_escape_string($this->dbLink,$this->comision3R4) . "',
	                                              lastCheckUpdatePrecios='" . mysqli_real_escape_string($this->dbLink,$this->lastCheckUpdatePrecios) . "',
	                                              lastIdPedidoChecked='" . mysqli_real_escape_string($this->dbLink,$this->lastIdPedidoChecked) . "',
	                                              rolloprodlastupdate='" . mysqli_real_escape_string($this->dbLink,$this->rolloprodlastupdate) . "',
	                                              fecha_modificacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modificacion) . "',
	                                              id_usuario_modificacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modificacion) . "'
					WHERE idConfiguracion=" . $this->idConfiguracion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracion::Update]");
				
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
				WHERE idConfiguracion=" . mysqli_real_escape_string($this->dbLink,$this->idConfiguracion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseConfiguracion::Borrar]");
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
						idConfiguracion,
						rangoMetros1Inicio,
						rangoMetros1Fin,
						rangoMetros2Inicio,
						rangoMetros2Fin,
						rangoMetros3Inicio,
						rangoMetros3Fin,
						rangoMetros1AcryOpaInicio,
						rangoMetros1AcryOpaFin,
						rangoMetros2AcryOpaInicio,
						rangoMetros2AcryOpaFin,
						rangoMetros3AcryOpaInicio,
						rangoMetros3AcryOpaFin,
						rangoMetros1MultipanelInicio,
						rangoMetros1MultipanelFin,
						rangoMetros2MultipanelInicio,
						rangoMetros2MultipanelFin,
						rangoMetros3MultipanelInicio,
						rangoMetros3MultipanelFin,
						pesoXCalibre20,
						pesoXCalibre22,
						pesoXCalibre24,
						pesoXCalibre26,
						pesoXCalibre28,
						pedidoDescuento,
						comision1R1,
						comision1R2,
						comision1R3,
						comision1R4,
						comision2R1,
						comision2R2,
						comision2R3,
						comision2R4,
						comision3R1,
						comision3R2,
						comision3R3,
						comision3R4,
						lastCheckUpdatePrecios,
						lastIdPedidoChecked,
						rolloprodlastupdate,
						fecha_modificacion,
						id_usuario_modificacion
					FROM " . $this->__tableName . " 
					WHERE idConfiguracion=" . mysqli_real_escape_string($this->dbLink,$this->idConfiguracion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseConfiguracion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idConfiguracion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>