<?php

	class ModeloBaseCotizacion extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCotizacion";

		
		var $idCotizacion=0;
		var $idCliente=0;
		var $subtotal='0';
		var $otrosCargos='0.00';
		var $iva='0';
		var $porDecuento='0';
		var $descuento='0';
		var $total='0.00';
		var $porDescuento='0';
		var $maxDescuentoIndividual='0';
		var $descuentoIndividual='0';
		var $anticipo='0';
		var $estado='CAPTURADO';
		var $idUsoCfdi=0;
		var $saldada='NO';
		var $fecha_saldada='0000-00-00 00:00:00';
		var $observaciones='';
		var $fecha_capturado='0000-00-00 00:00:00';
		var $id_usuario_capturado=0;
		var $observacionCaptura='';
		var $fecha_update='0000-00-00 00:00:00';
		var $fecha_descuento='0000-00-00 00:00:00';
		var $id_usuario_descuento=0;
		var $recogeentrega='RECOGE';
		var $tipoObra='NINGUNO';
		var $personaEntrega='';
		var $domicilioEntrega='';
		var $numeroEntrega='';
		var $coloniaEntrega='';
		var $ciudadEntrega='';
		var $horaRecibe='';
		var $fechaCompromiso='0000-00-00 00:00:00';
		var $fechaEntregaPorDefinir='NS';
		var $fechaAbierta='NO';
		var $pedidoExpress='NO';
		var $tipo='AT';
		var $fecha_limitepago='0000-00-00 00:00:00';
		var $tipocliente='NUEVO';
		var $idPedido=0;
		var $idSucursalCapturado=0;
		var $idSucursalPreferenciaRecoge=0;
		var $rangosString='';
		var $rangoCliente='REGULAR';
		var $fecha_autorizaimpresion='0000-00-00 00:00:00';
		var $id_usuario_autorizaimpresion=0;

		var $__s=array("idCotizacion",
                       "idCliente",
                       "subtotal",
                       "otrosCargos",
                       "iva",
                       "porDecuento",
                       "descuento",
                       "total",
                       "porDescuento",
                       "maxDescuentoIndividual",
                       "descuentoIndividual",
                       "anticipo",
                       "estado",
                       "idUsoCfdi",
                       "saldada",
                       "fecha_saldada",
                       "observaciones",
                       "fecha_capturado",
                       "id_usuario_capturado",
                       "observacionCaptura",
                       "fecha_update",
                       "fecha_descuento",
                       "id_usuario_descuento",
                       "recogeentrega",
                       "tipoObra",
                       "personaEntrega",
                       "domicilioEntrega",
                       "numeroEntrega",
                       "coloniaEntrega",
                       "ciudadEntrega",
                       "horaRecibe",
                       "fechaCompromiso",
                       "fechaEntregaPorDefinir",
                       "fechaAbierta",
                       "pedidoExpress",
                       "tipo",
                       "fecha_limitepago",
                       "tipocliente",
                       "idPedido",
                       "idSucursalCapturado",
                       "idSucursalPreferenciaRecoge",
                       "rangosString",
                       "rangoCliente",
                       "fecha_autorizaimpresion",
                       "id_usuario_autorizaimpresion");
				
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

		
		public function setIdCotizacion($idCotizacion)
		{
			if($idCotizacion==0||$idCotizacion==""||!is_numeric($idCotizacion)|| (is_string($idCotizacion)&&!ctype_digit($idCotizacion)))return $this->setError("Tipo de dato incorrecto para idCotizacion.");
			$this->idCotizacion=$idCotizacion;
			$this->getDatos();
		}
		public function setIdCliente($idCliente)
		{
			
			$this->idCliente=$idCliente;
		}
		public function setSubtotal($subtotal)
		{
			$this->subtotal=$subtotal;
		}
		public function setOtrosCargos($otrosCargos)
		{
			$this->otrosCargos=$otrosCargos;
		}
		public function setIva($iva)
		{
			$this->iva=$iva;
		}
		public function setPorDecuento($porDecuento)
		{
			$this->porDecuento=$porDecuento;
		}
		public function setDescuento($descuento)
		{
			$this->descuento=$descuento;
		}
		public function setTotal($total)
		{
			$this->total=$total;
		}
		public function setPorDescuento($porDescuento)
		{
			$this->porDescuento=$porDescuento;
		}
		public function setMaxDescuentoIndividual($maxDescuentoIndividual)
		{
			$this->maxDescuentoIndividual=$maxDescuentoIndividual;
		}
		public function setDescuentoIndividual($descuentoIndividual)
		{
			$this->descuentoIndividual=$descuentoIndividual;
		}
		public function setAnticipo($anticipo)
		{
			$this->anticipo=$anticipo;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoCAPTURADO()
		{
			$this->estado='CAPTURADO';
		}
		public function setEstadoAUTORIZADO()
		{
			$this->estado='AUTORIZADO';
		}
		public function setEstadoPRODUCCION()
		{
			$this->estado='PRODUCCION';
		}
		public function setEstadoTERMINADO()
		{
			$this->estado='TERMINADO';
		}
		public function setEstadoENTREGADO()
		{
			$this->estado='ENTREGADO';
		}
		public function setEstadoCANCELADO()
		{
			$this->estado='CANCELADO';
		}
		public function setIdUsoCfdi($idUsoCfdi)
		{
			
			$this->idUsoCfdi=$idUsoCfdi;
		}
		public function setSaldada($saldada)
		{
			
			$this->saldada=$saldada;
		}
		public function setSaldadaSI()
		{
			$this->saldada='SI';
		}
		public function setSaldadaNO()
		{
			$this->saldada='NO';
		}
		public function setFecha_saldada($fecha_saldada)
		{
			$this->fecha_saldada=$fecha_saldada;
		}
		public function setObservaciones($observaciones)
		{
			
			$this->observaciones=$observaciones;
		}
		public function setFecha_capturado($fecha_capturado)
		{
			$this->fecha_capturado=$fecha_capturado;
		}
		public function setId_usuario_capturado($id_usuario_capturado)
		{
			
			$this->id_usuario_capturado=$id_usuario_capturado;
		}
		public function setObservacionCaptura($observacionCaptura)
		{
			
			$this->observacionCaptura=$observacionCaptura;
		}
		public function setFecha_update($fecha_update)
		{
			$this->fecha_update=$fecha_update;
		}
		public function setFecha_descuento($fecha_descuento)
		{
			$this->fecha_descuento=$fecha_descuento;
		}
		public function setId_usuario_descuento($id_usuario_descuento)
		{
			
			$this->id_usuario_descuento=$id_usuario_descuento;
		}
		public function setRecogeentrega($recogeentrega)
		{
			
			$this->recogeentrega=$recogeentrega;
		}
		public function setRecogeentregaRECOGE()
		{
			$this->recogeentrega='RECOGE';
		}
		public function setRecogeentregaENTREGA()
		{
			$this->recogeentrega='ENTREGA';
		}
		public function setRecogeentregaOBRA()
		{
			$this->recogeentrega='OBRA';
		}
		public function setTipoObra($tipoObra)
		{
			
			$this->tipoObra=$tipoObra;
		}
		public function setTipoObraNINGUNO()
		{
			$this->tipoObra='NINGUNO';
		}
		public function setTipoObraPISO()
		{
			$this->tipoObra='PISO';
		}
		public function setTipoObraCUBIERTA()
		{
			$this->tipoObra='CUBIERTA';
		}
		public function setPersonaEntrega($personaEntrega)
		{
			
			$this->personaEntrega=$personaEntrega;
		}
		public function setDomicilioEntrega($domicilioEntrega)
		{
			
			$this->domicilioEntrega=$domicilioEntrega;
		}
		public function setNumeroEntrega($numeroEntrega)
		{
			
			$this->numeroEntrega=$numeroEntrega;
		}
		public function setColoniaEntrega($coloniaEntrega)
		{
			
			$this->coloniaEntrega=$coloniaEntrega;
		}
		public function setCiudadEntrega($ciudadEntrega)
		{
			
			$this->ciudadEntrega=$ciudadEntrega;
		}
		public function setHoraRecibe($horaRecibe)
		{
			
			$this->horaRecibe=$horaRecibe;
		}
		public function setFechaCompromiso($fechaCompromiso)
		{
			$this->fechaCompromiso=$fechaCompromiso;
		}
		public function setFechaEntregaPorDefinir($fechaEntregaPorDefinir)
		{
			
			$this->fechaEntregaPorDefinir=$fechaEntregaPorDefinir;
		}
		public function setFechaEntregaPorDefinirNS()
		{
			$this->fechaEntregaPorDefinir='NS';
		}
		public function setFechaEntregaPorDefinirNO()
		{
			$this->fechaEntregaPorDefinir='NO';
		}
		public function setFechaEntregaPorDefinirSI()
		{
			$this->fechaEntregaPorDefinir='SI';
		}
		public function setFechaAbierta($fechaAbierta)
		{
			
			$this->fechaAbierta=$fechaAbierta;
		}
		public function setFechaAbiertaSI()
		{
			$this->fechaAbierta='SI';
		}
		public function setFechaAbiertaNO()
		{
			$this->fechaAbierta='NO';
		}
		public function setPedidoExpress($pedidoExpress)
		{
			
			$this->pedidoExpress=$pedidoExpress;
		}
		public function setPedidoExpressSI()
		{
			$this->pedidoExpress='SI';
		}
		public function setPedidoExpressNO()
		{
			$this->pedidoExpress='NO';
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoAT()
		{
			$this->tipo='AT';
		}
		public function setTipoD()
		{
			$this->tipo='D';
		}
		public function setFecha_limitepago($fecha_limitepago)
		{
			$this->fecha_limitepago=$fecha_limitepago;
		}
		public function setTipocliente($tipocliente)
		{
			
			$this->tipocliente=$tipocliente;
		}
		public function setTipoclienteNUEVO()
		{
			$this->tipocliente='NUEVO';
		}
		public function setTipoclienteCAUTIVO()
		{
			$this->tipocliente='CAUTIVO';
		}
		public function setIdPedido($idPedido)
		{
			
			$this->idPedido=$idPedido;
		}
		public function setIdSucursalCapturado($idSucursalCapturado)
		{
			
			$this->idSucursalCapturado=$idSucursalCapturado;
		}
		public function setIdSucursalPreferenciaRecoge($idSucursalPreferenciaRecoge)
		{
			
			$this->idSucursalPreferenciaRecoge=$idSucursalPreferenciaRecoge;
		}
		public function setRangosString($rangosString)
		{
			
			$this->rangosString=$rangosString;
		}
		public function setRangoCliente($rangoCliente)
		{
			
			$this->rangoCliente=$rangoCliente;
		}
		public function setRangoClienteREGULAR()
		{
			$this->rangoCliente='REGULAR';
		}
		public function setRangoClienteDISTINGUIDO()
		{
			$this->rangoCliente='DISTINGUIDO';
		}
		public function setRangoClienteSELECT()
		{
			$this->rangoCliente='SELECT';
		}
		public function setFecha_autorizaimpresion($fecha_autorizaimpresion)
		{
			$this->fecha_autorizaimpresion=$fecha_autorizaimpresion;
		}
		public function setId_usuario_autorizaimpresion($id_usuario_autorizaimpresion)
		{
			
			$this->id_usuario_autorizaimpresion=$id_usuario_autorizaimpresion;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCotizacion()
		{
			return $this->idCotizacion;
		}
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getSubtotal()
		{
			return $this->subtotal;
		}
		public function getOtrosCargos()
		{
			return $this->otrosCargos;
		}
		public function getIva()
		{
			return $this->iva;
		}
		public function getPorDecuento()
		{
			return $this->porDecuento;
		}
		public function getDescuento()
		{
			return $this->descuento;
		}
		public function getTotal()
		{
			return $this->total;
		}
		public function getPorDescuento()
		{
			return $this->porDescuento;
		}
		public function getMaxDescuentoIndividual()
		{
			return $this->maxDescuentoIndividual;
		}
		public function getDescuentoIndividual()
		{
			return $this->descuentoIndividual;
		}
		public function getAnticipo()
		{
			return $this->anticipo;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getIdUsoCfdi()
		{
			return $this->idUsoCfdi;
		}
		public function getSaldada()
		{
			return $this->saldada;
		}
		public function getFecha_saldada()
		{
			return $this->fecha_saldada;
		}
		public function getObservaciones()
		{
			return $this->observaciones;
		}
		public function getFecha_capturado()
		{
			return $this->fecha_capturado;
		}
		public function getId_usuario_capturado()
		{
			return $this->id_usuario_capturado;
		}
		public function getObservacionCaptura()
		{
			return $this->observacionCaptura;
		}
		public function getFecha_update()
		{
			return $this->fecha_update;
		}
		public function getFecha_descuento()
		{
			return $this->fecha_descuento;
		}
		public function getId_usuario_descuento()
		{
			return $this->id_usuario_descuento;
		}
		public function getRecogeentrega()
		{
			return $this->recogeentrega;
		}
		public function getTipoObra()
		{
			return $this->tipoObra;
		}
		public function getPersonaEntrega()
		{
			return $this->personaEntrega;
		}
		public function getDomicilioEntrega()
		{
			return $this->domicilioEntrega;
		}
		public function getNumeroEntrega()
		{
			return $this->numeroEntrega;
		}
		public function getColoniaEntrega()
		{
			return $this->coloniaEntrega;
		}
		public function getCiudadEntrega()
		{
			return $this->ciudadEntrega;
		}
		public function getHoraRecibe()
		{
			return $this->horaRecibe;
		}
		public function getFechaCompromiso()
		{
			return $this->fechaCompromiso;
		}
		public function getFechaEntregaPorDefinir()
		{
			return $this->fechaEntregaPorDefinir;
		}
		public function getFechaAbierta()
		{
			return $this->fechaAbierta;
		}
		public function getPedidoExpress()
		{
			return $this->pedidoExpress;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getFecha_limitepago()
		{
			return $this->fecha_limitepago;
		}
		public function getTipocliente()
		{
			return $this->tipocliente;
		}
		public function getIdPedido()
		{
			return $this->idPedido;
		}
		public function getIdSucursalCapturado()
		{
			return $this->idSucursalCapturado;
		}
		public function getIdSucursalPreferenciaRecoge()
		{
			return $this->idSucursalPreferenciaRecoge;
		}
		public function getRangosString()
		{
			return $this->rangosString;
		}
		public function getRangoCliente()
		{
			return $this->rangoCliente;
		}
		public function getFecha_autorizaimpresion()
		{
			return $this->fecha_autorizaimpresion;
		}
		public function getId_usuario_autorizaimpresion()
		{
			return $this->id_usuario_autorizaimpresion;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCotizacion=0;
			$this->idCliente=0;
			$this->subtotal='0';
			$this->otrosCargos='0.00';
			$this->iva='0';
			$this->porDecuento='0';
			$this->descuento='0';
			$this->total='0.00';
			$this->porDescuento='0';
			$this->maxDescuentoIndividual='0';
			$this->descuentoIndividual='0';
			$this->anticipo='0';
			$this->estado='CAPTURADO';
			$this->idUsoCfdi=0;
			$this->saldada='NO';
			$this->fecha_saldada='0000-00-00 00:00:00';
			$this->observaciones='';
			$this->fecha_capturado='0000-00-00 00:00:00';
			$this->id_usuario_capturado=0;
			$this->observacionCaptura='';
			$this->fecha_update='0000-00-00 00:00:00';
			$this->fecha_descuento='0000-00-00 00:00:00';
			$this->id_usuario_descuento=0;
			$this->recogeentrega='RECOGE';
			$this->tipoObra='NINGUNO';
			$this->personaEntrega='';
			$this->domicilioEntrega='';
			$this->numeroEntrega='';
			$this->coloniaEntrega='';
			$this->ciudadEntrega='';
			$this->horaRecibe='';
			$this->fechaCompromiso='0000-00-00 00:00:00';
			$this->fechaEntregaPorDefinir='NS';
			$this->fechaAbierta='NO';
			$this->pedidoExpress='NO';
			$this->tipo='AT';
			$this->fecha_limitepago='0000-00-00 00:00:00';
			$this->tipocliente='NUEVO';
			$this->idPedido=0;
			$this->idSucursalCapturado=0;
			$this->idSucursalPreferenciaRecoge=0;
			$this->rangosString='';
			$this->rangoCliente='REGULAR';
			$this->fecha_autorizaimpresion='0000-00-00 00:00:00';
			$this->id_usuario_autorizaimpresion=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (idCliente,
				                                              subtotal,
				                                              otrosCargos,
				                                              iva,
				                                              porDecuento,
				                                              descuento,
				                                              total,
				                                              porDescuento,
				                                              maxDescuentoIndividual,
				                                              descuentoIndividual,
				                                              anticipo,
				                                              estado,
				                                              idUsoCfdi,
				                                              saldada,
				                                              fecha_saldada,
				                                              observaciones,
				                                              fecha_capturado,
				                                              id_usuario_capturado,
				                                              observacionCaptura,
				                                              fecha_update,
				                                              fecha_descuento,
				                                              id_usuario_descuento,
				                                              recogeentrega,
				                                              tipoObra,
				                                              personaEntrega,
				                                              domicilioEntrega,
				                                              numeroEntrega,
				                                              coloniaEntrega,
				                                              ciudadEntrega,
				                                              horaRecibe,
				                                              fechaCompromiso,
				                                              fechaEntregaPorDefinir,
				                                              fechaAbierta,
				                                              pedidoExpress,
				                                              tipo,
				                                              fecha_limitepago,
				                                              tipocliente,
				                                              idPedido,
				                                              idSucursalCapturado,
				                                              idSucursalPreferenciaRecoge,
				                                              rangosString,
				                                              rangoCliente,
				                                              fecha_autorizaimpresion,
				                                              id_usuario_autorizaimpresion)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->subtotal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->otrosCargos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->iva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porDecuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->total) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->maxDescuentoIndividual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descuentoIndividual) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->anticipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_saldada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_capturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_capturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacionCaptura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_descuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_descuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->recogeentrega) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoObra) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->personaEntrega) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilioEntrega) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->numeroEntrega) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->coloniaEntrega) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ciudadEntrega) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->horaRecibe) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fechaCompromiso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fechaEntregaPorDefinir) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fechaAbierta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pedidoExpress) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_limitepago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipocliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursalCapturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursalPreferenciaRecoge) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangosString) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_autorizaimpresion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_autorizaimpresion) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizacion::Insertar]");
				
				$this->idCotizacion=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET idCliente='" . mysqli_real_escape_string($this->dbLink,$this->idCliente) . "',
	                                              subtotal='" . mysqli_real_escape_string($this->dbLink,$this->subtotal) . "',
	                                              otrosCargos='" . mysqli_real_escape_string($this->dbLink,$this->otrosCargos) . "',
	                                              iva='" . mysqli_real_escape_string($this->dbLink,$this->iva) . "',
	                                              porDecuento='" . mysqli_real_escape_string($this->dbLink,$this->porDecuento) . "',
	                                              descuento='" . mysqli_real_escape_string($this->dbLink,$this->descuento) . "',
	                                              total='" . mysqli_real_escape_string($this->dbLink,$this->total) . "',
	                                              porDescuento='" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
	                                              maxDescuentoIndividual='" . mysqli_real_escape_string($this->dbLink,$this->maxDescuentoIndividual) . "',
	                                              descuentoIndividual='" . mysqli_real_escape_string($this->dbLink,$this->descuentoIndividual) . "',
	                                              anticipo='" . mysqli_real_escape_string($this->dbLink,$this->anticipo) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              idUsoCfdi='" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
	                                              saldada='" . mysqli_real_escape_string($this->dbLink,$this->saldada) . "',
	                                              fecha_saldada='" . mysqli_real_escape_string($this->dbLink,$this->fecha_saldada) . "',
	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
	                                              fecha_capturado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_capturado) . "',
	                                              id_usuario_capturado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_capturado) . "',
	                                              observacionCaptura='" . mysqli_real_escape_string($this->dbLink,$this->observacionCaptura) . "',
	                                              fecha_update='" . mysqli_real_escape_string($this->dbLink,$this->fecha_update) . "',
	                                              fecha_descuento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_descuento) . "',
	                                              id_usuario_descuento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_descuento) . "',
	                                              recogeentrega='" . mysqli_real_escape_string($this->dbLink,$this->recogeentrega) . "',
	                                              tipoObra='" . mysqli_real_escape_string($this->dbLink,$this->tipoObra) . "',
	                                              personaEntrega='" . mysqli_real_escape_string($this->dbLink,$this->personaEntrega) . "',
	                                              domicilioEntrega='" . mysqli_real_escape_string($this->dbLink,$this->domicilioEntrega) . "',
	                                              numeroEntrega='" . mysqli_real_escape_string($this->dbLink,$this->numeroEntrega) . "',
	                                              coloniaEntrega='" . mysqli_real_escape_string($this->dbLink,$this->coloniaEntrega) . "',
	                                              ciudadEntrega='" . mysqli_real_escape_string($this->dbLink,$this->ciudadEntrega) . "',
	                                              horaRecibe='" . mysqli_real_escape_string($this->dbLink,$this->horaRecibe) . "',
	                                              fechaCompromiso='" . mysqli_real_escape_string($this->dbLink,$this->fechaCompromiso) . "',
	                                              fechaEntregaPorDefinir='" . mysqli_real_escape_string($this->dbLink,$this->fechaEntregaPorDefinir) . "',
	                                              fechaAbierta='" . mysqli_real_escape_string($this->dbLink,$this->fechaAbierta) . "',
	                                              pedidoExpress='" . mysqli_real_escape_string($this->dbLink,$this->pedidoExpress) . "',
	                                              tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',
	                                              fecha_limitepago='" . mysqli_real_escape_string($this->dbLink,$this->fecha_limitepago) . "',
	                                              tipocliente='" . mysqli_real_escape_string($this->dbLink,$this->tipocliente) . "',
	                                              idPedido='" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "',
	                                              idSucursalCapturado='" . mysqli_real_escape_string($this->dbLink,$this->idSucursalCapturado) . "',
	                                              idSucursalPreferenciaRecoge='" . mysqli_real_escape_string($this->dbLink,$this->idSucursalPreferenciaRecoge) . "',
	                                              rangosString='" . mysqli_real_escape_string($this->dbLink,$this->rangosString) . "',
	                                              rangoCliente='" . mysqli_real_escape_string($this->dbLink,$this->rangoCliente) . "',
	                                              fecha_autorizaimpresion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_autorizaimpresion) . "',
	                                              id_usuario_autorizaimpresion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_autorizaimpresion) . "'
					WHERE idCotizacion=" . $this->idCotizacion;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizacion::Update]");
				
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
				WHERE idCotizacion=" . mysqli_real_escape_string($this->dbLink,$this->idCotizacion);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizacion::Borrar]");
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
						idCotizacion,
						idCliente,
						subtotal,
						otrosCargos,
						iva,
						porDecuento,
						descuento,
						total,
						porDescuento,
						maxDescuentoIndividual,
						descuentoIndividual,
						anticipo,
						estado,
						idUsoCfdi,
						saldada,
						fecha_saldada,
						observaciones,
						fecha_capturado,
						id_usuario_capturado,
						observacionCaptura,
						fecha_update,
						fecha_descuento,
						id_usuario_descuento,
						recogeentrega,
						tipoObra,
						personaEntrega,
						domicilioEntrega,
						numeroEntrega,
						coloniaEntrega,
						ciudadEntrega,
						horaRecibe,
						fechaCompromiso,
						fechaEntregaPorDefinir,
						fechaAbierta,
						pedidoExpress,
						tipo,
						fecha_limitepago,
						tipocliente,
						idPedido,
						idSucursalCapturado,
						idSucursalPreferenciaRecoge,
						rangosString,
						rangoCliente,
						fecha_autorizaimpresion,
						id_usuario_autorizaimpresion
					FROM " . $this->__tableName . " 
					WHERE idCotizacion=" . mysqli_real_escape_string($this->dbLink,$this->idCotizacion);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCotizacion::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCotizacion==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>