<?php

	class ModeloBaseValesalidapromotor extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseValesalidapromotor";

		
		var $idValeSalidaPromotor=0;
		var $idPedido=0;
		var $estado='CREADO';
		var $generarValeSalida='NO';
		var $observacion_aunno='';
		var $fecha_creado='0000-00-00 00:00:00';
		var $id_usuario_creado=0;
		var $fecha_salida='0000-00-00 00:00:00';
		var $id_usuario_salida='0';
		var $idSucursal=0;
		var $chkDireccionCorrecta='NO';
		var $chkDiaCorrecto='NO';
		var $chkHorarioCorrecto='NO';
		var $chkEquipoListo='NO';
		var $chkPersonaCorrecta='NO';
		var $chkHayEspacio='NO';
		var $chkImprimirPedidoNoSaldado='NO';
		var $idValeSalida=0;

		var $__s=array("idValeSalidaPromotor",
                       "idPedido",
                       "estado",
                       "generarValeSalida",
                       "observacion_aunno",
                       "fecha_creado",
                       "id_usuario_creado",
                       "fecha_salida",
                       "id_usuario_salida",
                       "idSucursal",
                       "chkDireccionCorrecta",
                       "chkDiaCorrecto",
                       "chkHorarioCorrecto",
                       "chkEquipoListo",
                       "chkPersonaCorrecta",
                       "chkHayEspacio",
                       "chkImprimirPedidoNoSaldado",
                       "idValeSalida");
				
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

		
		public function setIdValeSalidaPromotor($idValeSalidaPromotor)
		{
			if($idValeSalidaPromotor==0||$idValeSalidaPromotor==""||!is_numeric($idValeSalidaPromotor)|| (is_string($idValeSalidaPromotor)&&!ctype_digit($idValeSalidaPromotor)))return $this->setError("Tipo de dato incorrecto para idValeSalidaPromotor.");
			$this->idValeSalidaPromotor=$idValeSalidaPromotor;
			$this->getDatos();
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoCREADO()
		{
			$this->estado='CREADO';
		}
		public function setEstadoSALIDA()
		{
			$this->estado='SALIDA';
		}
		public function setGenerarValeSalida($generarValeSalida)
		{
			
			$this->generarValeSalida=$generarValeSalida;
		}
		public function setGenerarValeSalidaNO()
		{
			$this->generarValeSalida='NO';
		}
		public function setGenerarValeSalidaAUNNO()
		{
			$this->generarValeSalida='AUNNO';
		}
		public function setGenerarValeSalidaSI()
		{
			$this->generarValeSalida='SI';
		}
		public function setObservacion_aunno($observacion_aunno)
		{
			
			$this->observacion_aunno=$observacion_aunno;
		}
		public function setFecha_creado($fecha_creado)
		{
			$this->fecha_creado=$fecha_creado;
		}
		public function setId_usuario_creado($id_usuario_creado)
		{
			
			$this->id_usuario_creado=$id_usuario_creado;
		}
		public function setFecha_salida($fecha_salida)
		{
			$this->fecha_salida=$fecha_salida;
		}
		public function setId_usuario_salida($id_usuario_salida)
		{
			
			$this->id_usuario_salida=$id_usuario_salida;
		}
		public function setIdSucursal($idSucursal)
		{
			
			$this->idSucursal=$idSucursal;
		}
		public function setChkDireccionCorrecta($chkDireccionCorrecta)
		{
			
			$this->chkDireccionCorrecta=$chkDireccionCorrecta;
		}
		public function setChkDireccionCorrectaSI()
		{
			$this->chkDireccionCorrecta='SI';
		}
		public function setChkDireccionCorrectaNO()
		{
			$this->chkDireccionCorrecta='NO';
		}
		public function setChkDiaCorrecto($chkDiaCorrecto)
		{
			
			$this->chkDiaCorrecto=$chkDiaCorrecto;
		}
		public function setChkDiaCorrectoSI()
		{
			$this->chkDiaCorrecto='SI';
		}
		public function setChkDiaCorrectoNO()
		{
			$this->chkDiaCorrecto='NO';
		}
		public function setChkHorarioCorrecto($chkHorarioCorrecto)
		{
			
			$this->chkHorarioCorrecto=$chkHorarioCorrecto;
		}
		public function setChkHorarioCorrectoSI()
		{
			$this->chkHorarioCorrecto='SI';
		}
		public function setChkHorarioCorrectoNO()
		{
			$this->chkHorarioCorrecto='NO';
		}
		public function setChkEquipoListo($chkEquipoListo)
		{
			
			$this->chkEquipoListo=$chkEquipoListo;
		}
		public function setChkEquipoListoSI()
		{
			$this->chkEquipoListo='SI';
		}
		public function setChkEquipoListoNO()
		{
			$this->chkEquipoListo='NO';
		}
		public function setChkPersonaCorrecta($chkPersonaCorrecta)
		{
			
			$this->chkPersonaCorrecta=$chkPersonaCorrecta;
		}
		public function setChkPersonaCorrectaSI()
		{
			$this->chkPersonaCorrecta='SI';
		}
		public function setChkPersonaCorrectaNO()
		{
			$this->chkPersonaCorrecta='NO';
		}
		public function setChkHayEspacio($chkHayEspacio)
		{
			
			$this->chkHayEspacio=$chkHayEspacio;
		}
		public function setChkHayEspacioSI()
		{
			$this->chkHayEspacio='SI';
		}
		public function setChkHayEspacioNO()
		{
			$this->chkHayEspacio='NO';
		}
		public function setChkImprimirPedidoNoSaldado($chkImprimirPedidoNoSaldado)
		{
			
			$this->chkImprimirPedidoNoSaldado=$chkImprimirPedidoNoSaldado;
		}
		public function setChkImprimirPedidoNoSaldadoSI()
		{
			$this->chkImprimirPedidoNoSaldado='SI';
		}
		public function setChkImprimirPedidoNoSaldadoNO()
		{
			$this->chkImprimirPedidoNoSaldado='NO';
		}
		public function setIdValeSalida($idValeSalida)
		{
			
			$this->idValeSalida=$idValeSalida;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdValeSalidaPromotor()
		{
			return $this->idValeSalidaPromotor;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getGenerarValeSalida()
		{
			return $this->generarValeSalida;
		}
		public function getObservacion_aunno()
		{
			return $this->observacion_aunno;
		}
		public function getFecha_creado()
		{
			return $this->fecha_creado;
		}
		public function getId_usuario_creado()
		{
			return $this->id_usuario_creado;
		}
		public function getFecha_salida()
		{
			return $this->fecha_salida;
		}
		public function getId_usuario_salida()
		{
			return $this->id_usuario_salida;
		}
		public function getIdSucursal()
		{
			return $this->idSucursal;
		}
		public function getChkDireccionCorrecta()
		{
			return $this->chkDireccionCorrecta;
		}
		public function getChkDiaCorrecto()
		{
			return $this->chkDiaCorrecto;
		}
		public function getChkHorarioCorrecto()
		{
			return $this->chkHorarioCorrecto;
		}
		public function getChkEquipoListo()
		{
			return $this->chkEquipoListo;
		}
		public function getChkPersonaCorrecta()
		{
			return $this->chkPersonaCorrecta;
		}
		public function getChkHayEspacio()
		{
			return $this->chkHayEspacio;
		}
		public function getChkImprimirPedidoNoSaldado()
		{
			return $this->chkImprimirPedidoNoSaldado;
		}
		public function getIdValeSalida()
		{
			return $this->idValeSalida;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idValeSalidaPromotor=0;
			$this->idPedido=0;
			$this->estado='CREADO';
			$this->generarValeSalida='NO';
			$this->observacion_aunno='';
			$this->fecha_creado='0000-00-00 00:00:00';
			$this->id_usuario_creado=0;
			$this->fecha_salida='0000-00-00 00:00:00';
			$this->id_usuario_salida='0';
			$this->idSucursal=0;
			$this->chkDireccionCorrecta='NO';
			$this->chkDiaCorrecto='NO';
			$this->chkHorarioCorrecto='NO';
			$this->chkEquipoListo='NO';
			$this->chkPersonaCorrecta='NO';
			$this->chkHayEspacio='NO';
			$this->chkImprimirPedidoNoSaldado='NO';
			$this->idValeSalida=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idPedido,
				                                              estado,
				                                              generarValeSalida,
				                                              observacion_aunno,
				                                              fecha_creado,
				                                              id_usuario_creado,
				                                              fecha_salida,
				                                              id_usuario_salida,
				                                              idSucursal,
				                                              chkDireccionCorrecta,
				                                              chkDiaCorrecto,
				                                              chkHorarioCorrecto,
				                                              chkEquipoListo,
				                                              chkPersonaCorrecta,
				                                              chkHayEspacio,
				                                              chkImprimirPedidoNoSaldado,
				                                              idValeSalida)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->generarValeSalida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacion_aunno) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_salida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_salida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkDireccionCorrecta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkDiaCorrecto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkHorarioCorrecto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkEquipoListo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkPersonaCorrecta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkHayEspacio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->chkImprimirPedidoNoSaldado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idValeSalida) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseValesalidapromotor::Insertar]");
				
				$this->idValeSalidaPromotor=mysqli_insert_id($this->dbLink);
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
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              generarValeSalida='" . mysqli_real_escape_string($this->dbLink,$this->generarValeSalida) . "',
	                                              observacion_aunno='" . mysqli_real_escape_string($this->dbLink,$this->observacion_aunno) . "',
	                                              fecha_creado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creado) . "',
	                                              id_usuario_creado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creado) . "',
	                                              fecha_salida='" . mysqli_real_escape_string($this->dbLink,$this->fecha_salida) . "',
	                                              id_usuario_salida='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_salida) . "',
	                                              idSucursal='" . mysqli_real_escape_string($this->dbLink,$this->idSucursal) . "',
	                                              chkDireccionCorrecta='" . mysqli_real_escape_string($this->dbLink,$this->chkDireccionCorrecta) . "',
	                                              chkDiaCorrecto='" . mysqli_real_escape_string($this->dbLink,$this->chkDiaCorrecto) . "',
	                                              chkHorarioCorrecto='" . mysqli_real_escape_string($this->dbLink,$this->chkHorarioCorrecto) . "',
	                                              chkEquipoListo='" . mysqli_real_escape_string($this->dbLink,$this->chkEquipoListo) . "',
	                                              chkPersonaCorrecta='" . mysqli_real_escape_string($this->dbLink,$this->chkPersonaCorrecta) . "',
	                                              chkHayEspacio='" . mysqli_real_escape_string($this->dbLink,$this->chkHayEspacio) . "',
	                                              chkImprimirPedidoNoSaldado='" . mysqli_real_escape_string($this->dbLink,$this->chkImprimirPedidoNoSaldado) . "',
	                                              idValeSalida='" . mysqli_real_escape_string($this->dbLink,$this->idValeSalida) . "'
					WHERE idValeSalidaPromotor=" . $this->idValeSalidaPromotor;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseValesalidapromotor::Update]");
				
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
				WHERE idValeSalidaPromotor=" . mysqli_real_escape_string($this->dbLink,$this->idValeSalidaPromotor);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseValesalidapromotor::Borrar]");
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
						idValeSalidaPromotor,
						idPedido,
						estado,
						generarValeSalida,
						observacion_aunno,
						fecha_creado,
						id_usuario_creado,
						fecha_salida,
						id_usuario_salida,
						idSucursal,
						chkDireccionCorrecta,
						chkDiaCorrecto,
						chkHorarioCorrecto,
						chkEquipoListo,
						chkPersonaCorrecta,
						chkHayEspacio,
						chkImprimirPedidoNoSaldado,
						idValeSalida
					FROM " . $this->__tableName . " 
					WHERE idValeSalidaPromotor=" . mysqli_real_escape_string($this->dbLink,$this->idValeSalidaPromotor);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseValesalidapromotor::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idValeSalidaPromotor==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>