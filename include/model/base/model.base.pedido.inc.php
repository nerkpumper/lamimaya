<?php

	class ModeloBasePedido extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePedido";

		
		var $idPedido=0;
		var $idCliente=0;
		var $subtotal='0.00';
		var $otrosCargos='0.00';
		var $iva='0.00';
		var $porDecuento='0.00';
		var $descuento='0.00';
		var $total='0.00';
		var $porDescuento='0.00';
		var $maxDescuentoIndividual='0';
		var $descuentoIndividual='0';
		var $anticipo='0';
		var $saldo='0.00';
		var $totalcte='0';
		var $saldocte='0';
		var $totalpromotor='0.00';
		var $saldopromotor='0.00';
		var $estado='CAPTURADO';
		var $explotado='NO';
		var $explotadook='NO';
		var $despachado='NO';
		var $idUsoCfdi=0;
		var $solicitaFactura='NO';
		var $facturado='NO';
		var $fecha_solicitafactura='0000-00-00 00:00:00';
		var $id_usuario_solicitafactura=0;
		var $factura='0';
		var $fecha_factura='0000-00-00 00:00:00';
		var $id_usuario_factura=0;
		var $saldada='NO';
		var $fecha_saldada='0000-00-00 00:00:00';
		var $idComision=0;
		var $idCorteComision=0;
		var $idCorteComisionVendedor=0;
		var $idCorteComisionT=0;
		var $idCorteComisionTVendedor=0;
		var $idCorteComisionA=0;
		var $idCorteComisionAVendedor=0;
		var $comisionpagada='NO';
		var $observaciones='';
		var $fecha_capturado='0000-00-00 00:00:00';
		var $id_usuario_capturado=0;
		var $observacionCaptura='';
		var $autorizacxc='NO';
		var $fecha_autorizado='0000-00-00 00:00:00';
		var $id_usuario_autorizado=0;
		var $tipoAutorizacion='NINGUNO';
		var $observacionAutoriza='';
		var $fecha_produccion='0000-00-00 00:00:00';
		var $id_usuario_produccion=0;
		var $fecha_terminado='0000-00-00 00:00:00';
		var $id_usuario_terminado=0;
		var $fecha_entregado='0000-00-00 00:00:00';
		var $id_usuario_entregado=0;
		var $fecha_cancelado='0000-00-00 00:00:00';
		var $id_usuario_cancelado=0;
		var $observacionCancela='';
		var $fecha_descuento='0000-00-00 00:00:00';
		var $id_usuario_descuento=0;
		var $listo_para_producir='NO';
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
		var $generarValeSalida='NO';
		var $observacion_aunno='';
		var $fecha_limitepago='0000-00-00 00:00:00';
		var $tipocliente='NUEVO';
		var $idcotizacion=0;
		var $idSucursalCapturado=0;
		var $colocado='NO';
		var $colocadoAutomatico='NO';
		var $idSucursalPreferenciaRecoge=0;
		var $idCCRoofing=0;
		var $idCCRoofingVendedor=0;
		var $despieceTerminado='NO';
		var $planProteccion='NO';
		var $checarAutorizacion='NO';
		var $tipoRuta='SINRUTA';
		var $idRutaEnvio=0;
		var $id_usuario_enruta=0;
		var $fecha_enruta='0000-00-00 00:00:00';
		var $rangosString='';
		var $fecha_updateprecios='0000-00-00 00:00:00';
		var $desbloqueadoPreciosAdmin='NO';
		var $apartarMercancia='SI';
		var $idClienteDatosFacturacion=0;
		var $liberaVales='NO';
		var $id_usuario_libera_vales=0;
		var $fecha_libera_vales='0000-00-00 00:00:00';
		var $observacionLiberaVales='';

		var $__s=array("idPedido",
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
                       "saldo",
                       "totalcte",
                       "saldocte",
                       "totalpromotor",
                       "saldopromotor",
                       "estado",
                       "explotado",
                       "explotadook",
                       "despachado",
                       "idUsoCfdi",
                       "solicitaFactura",
                       "facturado",
                       "fecha_solicitafactura",
                       "id_usuario_solicitafactura",
                       "factura",
                       "fecha_factura",
                       "id_usuario_factura",
                       "saldada",
                       "fecha_saldada",
                       "idComision",
                       "idCorteComision",
                       "idCorteComisionVendedor",
                       "idCorteComisionT",
                       "idCorteComisionTVendedor",
                       "idCorteComisionA",
                       "idCorteComisionAVendedor",
                       "comisionpagada",
                       "observaciones",
                       "fecha_capturado",
                       "id_usuario_capturado",
                       "observacionCaptura",
                       "autorizacxc",
                       "fecha_autorizado",
                       "id_usuario_autorizado",
                       "tipoAutorizacion",
                       "observacionAutoriza",
                       "fecha_produccion",
                       "id_usuario_produccion",
                       "fecha_terminado",
                       "id_usuario_terminado",
                       "fecha_entregado",
                       "id_usuario_entregado",
                       "fecha_cancelado",
                       "id_usuario_cancelado",
                       "observacionCancela",
                       "fecha_descuento",
                       "id_usuario_descuento",
                       "listo_para_producir",
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
                       "generarValeSalida",
                       "observacion_aunno",
                       "fecha_limitepago",
                       "tipocliente",
                       "idcotizacion",
                       "idSucursalCapturado",
                       "colocado",
                       "colocadoAutomatico",
                       "idSucursalPreferenciaRecoge",
                       "idCCRoofing",
                       "idCCRoofingVendedor",
                       "despieceTerminado",
                       "planProteccion",
                       "checarAutorizacion",
                       "tipoRuta",
                       "idRutaEnvio",
                       "id_usuario_enruta",
                       "fecha_enruta",
                       "rangosString",
                       "fecha_updateprecios",
                       "desbloqueadoPreciosAdmin",
                       "apartarMercancia",
                       "idClienteDatosFacturacion",
                       "liberaVales",
                       "id_usuario_libera_vales",
                       "fecha_libera_vales",
                       "observacionLiberaVales");
				
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

		
		public function setIdPedido($idPedido)
		{
			if($idPedido==0||$idPedido==""||!is_numeric($idPedido)|| (is_string($idPedido)&&!ctype_digit($idPedido)))return $this->setError("Tipo de dato incorrecto para idPedido.");
			$this->idPedido=$idPedido;
			$this->getDatos();
			$this->SaveOriginalValues();
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
		public function setSaldo($saldo)
		{
			$this->saldo=$saldo;
		}
		public function setTotalcte($totalcte)
		{
			$this->totalcte=$totalcte;
		}
		public function setSaldocte($saldocte)
		{
			$this->saldocte=$saldocte;
		}
		public function setTotalpromotor($totalpromotor)
		{
			$this->totalpromotor=$totalpromotor;
		}
		public function setSaldopromotor($saldopromotor)
		{
			$this->saldopromotor=$saldopromotor;
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
		public function setEstadoENRUTA()
		{
			$this->estado='ENRUTA';
		}
		public function setEstadoENTREGADO()
		{
			$this->estado='ENTREGADO';
		}
		public function setEstadoCANCELADO()
		{
			$this->estado='CANCELADO';
		}
		public function setExplotado($explotado)
		{
			
			$this->explotado=$explotado;
		}
		public function setExplotadoNO()
		{
			$this->explotado='NO';
		}
		public function setExplotadoSI()
		{
			$this->explotado='SI';
		}
		public function setExplotadook($explotadook)
		{
			
			$this->explotadook=$explotadook;
		}
		public function setExplotadookNO()
		{
			$this->explotadook='NO';
		}
		public function setExplotadookSI()
		{
			$this->explotadook='SI';
		}
		public function setDespachado($despachado)
		{
			
			$this->despachado=$despachado;
		}
		public function setDespachadoSI()
		{
			$this->despachado='SI';
		}
		public function setDespachadoNO()
		{
			$this->despachado='NO';
		}
		public function setIdUsoCfdi($idUsoCfdi)
		{
			
			$this->idUsoCfdi=$idUsoCfdi;
		}
		public function setSolicitaFactura($solicitaFactura)
		{
			
			$this->solicitaFactura=$solicitaFactura;
		}
		public function setSolicitaFacturaNO()
		{
			$this->solicitaFactura='NO';
		}
		public function setSolicitaFacturaSI()
		{
			$this->solicitaFactura='SI';
		}
		public function setFacturado($facturado)
		{
			
			$this->facturado=$facturado;
		}
		public function setFacturadoNO()
		{
			$this->facturado='NO';
		}
		public function setFacturadoSI()
		{
			$this->facturado='SI';
		}
		public function setFecha_solicitafactura($fecha_solicitafactura)
		{
			$this->fecha_solicitafactura=$fecha_solicitafactura;
		}
		public function setId_usuario_solicitafactura($id_usuario_solicitafactura)
		{
			
			$this->id_usuario_solicitafactura=$id_usuario_solicitafactura;
		}
		public function setFactura($factura)
		{
			
			$this->factura=$factura;
		}
		public function setFecha_factura($fecha_factura)
		{
			$this->fecha_factura=$fecha_factura;
		}
		public function setId_usuario_factura($id_usuario_factura)
		{
			
			$this->id_usuario_factura=$id_usuario_factura;
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
		public function setIdComision($idComision)
		{
			
			$this->idComision=$idComision;
		}
		public function setIdCorteComision($idCorteComision)
		{
			
			$this->idCorteComision=$idCorteComision;
		}
		public function setIdCorteComisionVendedor($idCorteComisionVendedor)
		{
			
			$this->idCorteComisionVendedor=$idCorteComisionVendedor;
		}
		public function setIdCorteComisionT($idCorteComisionT)
		{
			
			$this->idCorteComisionT=$idCorteComisionT;
		}
		public function setIdCorteComisionTVendedor($idCorteComisionTVendedor)
		{
			
			$this->idCorteComisionTVendedor=$idCorteComisionTVendedor;
		}
		public function setIdCorteComisionA($idCorteComisionA)
		{
			
			$this->idCorteComisionA=$idCorteComisionA;
		}
		public function setIdCorteComisionAVendedor($idCorteComisionAVendedor)
		{
			
			$this->idCorteComisionAVendedor=$idCorteComisionAVendedor;
		}
		public function setComisionpagada($comisionpagada)
		{
			
			$this->comisionpagada=$comisionpagada;
		}
		public function setComisionpagadaSI()
		{
			$this->comisionpagada='SI';
		}
		public function setComisionpagadaNO()
		{
			$this->comisionpagada='NO';
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
		public function setAutorizacxc($autorizacxc)
		{
			
			$this->autorizacxc=$autorizacxc;
		}
		public function setAutorizacxcNO()
		{
			$this->autorizacxc='NO';
		}
		public function setAutorizacxcSI()
		{
			$this->autorizacxc='SI';
		}
		public function setFecha_autorizado($fecha_autorizado)
		{
			$this->fecha_autorizado=$fecha_autorizado;
		}
		public function setId_usuario_autorizado($id_usuario_autorizado)
		{
			
			$this->id_usuario_autorizado=$id_usuario_autorizado;
		}
		public function setTipoAutorizacion($tipoAutorizacion)
		{
			
			$this->tipoAutorizacion=$tipoAutorizacion;
		}
		public function setTipoAutorizacionNINGUNO()
		{
			$this->tipoAutorizacion='NINGUNO';
		}
		public function setTipoAutorizacionAUTOMATICO()
		{
			$this->tipoAutorizacion='AUTOMATICO';
		}
		public function setTipoAutorizacionCXC()
		{
			$this->tipoAutorizacion='CXC';
		}
		public function setTipoAutorizacionPROMO()
		{
			$this->tipoAutorizacion='PROMO';
		}
		public function setTipoAutorizacionPROMO4050()
		{
			$this->tipoAutorizacion='PROMO4050';
		}
		public function setObservacionAutoriza($observacionAutoriza)
		{
			
			$this->observacionAutoriza=$observacionAutoriza;
		}
		public function setFecha_produccion($fecha_produccion)
		{
			$this->fecha_produccion=$fecha_produccion;
		}
		public function setId_usuario_produccion($id_usuario_produccion)
		{
			
			$this->id_usuario_produccion=$id_usuario_produccion;
		}
		public function setFecha_terminado($fecha_terminado)
		{
			$this->fecha_terminado=$fecha_terminado;
		}
		public function setId_usuario_terminado($id_usuario_terminado)
		{
			
			$this->id_usuario_terminado=$id_usuario_terminado;
		}
		public function setFecha_entregado($fecha_entregado)
		{
			$this->fecha_entregado=$fecha_entregado;
		}
		public function setId_usuario_entregado($id_usuario_entregado)
		{
			
			$this->id_usuario_entregado=$id_usuario_entregado;
		}
		public function setFecha_cancelado($fecha_cancelado)
		{
			$this->fecha_cancelado=$fecha_cancelado;
		}
		public function setId_usuario_cancelado($id_usuario_cancelado)
		{
			
			$this->id_usuario_cancelado=$id_usuario_cancelado;
		}
		public function setObservacionCancela($observacionCancela)
		{
			
			$this->observacionCancela=$observacionCancela;
		}
		public function setFecha_descuento($fecha_descuento)
		{
			$this->fecha_descuento=$fecha_descuento;
		}
		public function setId_usuario_descuento($id_usuario_descuento)
		{
			
			$this->id_usuario_descuento=$id_usuario_descuento;
		}
		public function setListo_para_producir($listo_para_producir)
		{
			
			$this->listo_para_producir=$listo_para_producir;
		}
		public function setListo_para_producirNO()
		{
			$this->listo_para_producir='NO';
		}
		public function setListo_para_producirSI()
		{
			$this->listo_para_producir='SI';
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
		public function setIdcotizacion($idcotizacion)
		{
			
			$this->idcotizacion=$idcotizacion;
		}
		public function setIdSucursalCapturado($idSucursalCapturado)
		{
			
			$this->idSucursalCapturado=$idSucursalCapturado;
		}
		public function setColocado($colocado)
		{
			
			$this->colocado=$colocado;
		}
		public function setColocadoSI()
		{
			$this->colocado='SI';
		}
		public function setColocadoNO()
		{
			$this->colocado='NO';
		}
		public function setColocadoAutomatico($colocadoAutomatico)
		{
			
			$this->colocadoAutomatico=$colocadoAutomatico;
		}
		public function setColocadoAutomaticoSI()
		{
			$this->colocadoAutomatico='SI';
		}
		public function setColocadoAutomaticoNO()
		{
			$this->colocadoAutomatico='NO';
		}
		public function setIdSucursalPreferenciaRecoge($idSucursalPreferenciaRecoge)
		{
			
			$this->idSucursalPreferenciaRecoge=$idSucursalPreferenciaRecoge;
		}
		public function setIdCCRoofing($idCCRoofing)
		{
			
			$this->idCCRoofing=$idCCRoofing;
		}
		public function setIdCCRoofingVendedor($idCCRoofingVendedor)
		{
			
			$this->idCCRoofingVendedor=$idCCRoofingVendedor;
		}
		public function setDespieceTerminado($despieceTerminado)
		{
			
			$this->despieceTerminado=$despieceTerminado;
		}
		public function setDespieceTerminadoSI()
		{
			$this->despieceTerminado='SI';
		}
		public function setDespieceTerminadoNO()
		{
			$this->despieceTerminado='NO';
		}
		public function setPlanProteccion($planProteccion)
		{
			
			$this->planProteccion=$planProteccion;
		}
		public function setPlanProteccionSI()
		{
			$this->planProteccion='SI';
		}
		public function setPlanProteccionNO()
		{
			$this->planProteccion='NO';
		}
		public function setChecarAutorizacion($checarAutorizacion)
		{
			
			$this->checarAutorizacion=$checarAutorizacion;
		}
		public function setChecarAutorizacionSI()
		{
			$this->checarAutorizacion='SI';
		}
		public function setChecarAutorizacionNO()
		{
			$this->checarAutorizacion='NO';
		}
		public function setTipoRuta($tipoRuta)
		{
			
			$this->tipoRuta=$tipoRuta;
		}
		public function setTipoRutaSINRUTA()
		{
			$this->tipoRuta='SINRUTA';
		}
		public function setTipoRutaENRUTA()
		{
			$this->tipoRuta='ENRUTA';
		}
		public function setTipoRutaREENRUTAR()
		{
			$this->tipoRuta='REENRUTAR';
		}
		public function setIdRutaEnvio($idRutaEnvio)
		{
			
			$this->idRutaEnvio=$idRutaEnvio;
		}
		public function setId_usuario_enruta($id_usuario_enruta)
		{
			
			$this->id_usuario_enruta=$id_usuario_enruta;
		}
		public function setFecha_enruta($fecha_enruta)
		{
			$this->fecha_enruta=$fecha_enruta;
		}
		public function setRangosString($rangosString)
		{
			
			$this->rangosString=$rangosString;
		}
		public function setFecha_updateprecios($fecha_updateprecios)
		{
			$this->fecha_updateprecios=$fecha_updateprecios;
		}
		public function setDesbloqueadoPreciosAdmin($desbloqueadoPreciosAdmin)
		{
			
			$this->desbloqueadoPreciosAdmin=$desbloqueadoPreciosAdmin;
		}
		public function setDesbloqueadoPreciosAdminSI()
		{
			$this->desbloqueadoPreciosAdmin='SI';
		}
		public function setDesbloqueadoPreciosAdminNO()
		{
			$this->desbloqueadoPreciosAdmin='NO';
		}
		public function setApartarMercancia($apartarMercancia)
		{
			
			$this->apartarMercancia=$apartarMercancia;
		}
		public function setApartarMercanciaSI()
		{
			$this->apartarMercancia='SI';
		}
		public function setApartarMercanciaNO()
		{
			$this->apartarMercancia='NO';
		}
		public function setIdClienteDatosFacturacion($idClienteDatosFacturacion)
		{
			
			$this->idClienteDatosFacturacion=$idClienteDatosFacturacion;
		}
		public function setLiberaVales($liberaVales)
		{
			
			$this->liberaVales=$liberaVales;
		}
		public function setLiberaValesSI()
		{
			$this->liberaVales='SI';
		}
		public function setLiberaValesNO()
		{
			$this->liberaVales='NO';
		}
		public function setId_usuario_libera_vales($id_usuario_libera_vales)
		{
			
			$this->id_usuario_libera_vales=$id_usuario_libera_vales;
		}
		public function setFecha_libera_vales($fecha_libera_vales)
		{
			$this->fecha_libera_vales=$fecha_libera_vales;
		}
		public function setObservacionLiberaVales($observacionLiberaVales)
		{
			
			$this->observacionLiberaVales=$observacionLiberaVales;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPedido()
		{
			return $this->idPedido;
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
		public function getSaldo()
		{
			return $this->saldo;
		}
		public function getTotalcte()
		{
			return $this->totalcte;
		}
		public function getSaldocte()
		{
			return $this->saldocte;
		}
		public function getTotalpromotor()
		{
			return $this->totalpromotor;
		}
		public function getSaldopromotor()
		{
			return $this->saldopromotor;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getExplotado()
		{
			return $this->explotado;
		}
		public function getExplotadook()
		{
			return $this->explotadook;
		}
		public function getDespachado()
		{
			return $this->despachado;
		}
		public function getIdUsoCfdi()
		{
			return $this->idUsoCfdi;
		}
		public function getSolicitaFactura()
		{
			return $this->solicitaFactura;
		}
		public function getFacturado()
		{
			return $this->facturado;
		}
		public function getFecha_solicitafactura()
		{
			return $this->fecha_solicitafactura;
		}
		public function getId_usuario_solicitafactura()
		{
			return $this->id_usuario_solicitafactura;
		}
		public function getFactura()
		{
			return $this->factura;
		}
		public function getFecha_factura()
		{
			return $this->fecha_factura;
		}
		public function getId_usuario_factura()
		{
			return $this->id_usuario_factura;
		}
		public function getSaldada()
		{
			return $this->saldada;
		}
		public function getFecha_saldada()
		{
			return $this->fecha_saldada;
		}
		public function getIdComision()
		{
			return $this->idComision;
		}
		public function getIdCorteComision()
		{
			return $this->idCorteComision;
		}
		public function getIdCorteComisionVendedor()
		{
			return $this->idCorteComisionVendedor;
		}
		public function getIdCorteComisionT()
		{
			return $this->idCorteComisionT;
		}
		public function getIdCorteComisionTVendedor()
		{
			return $this->idCorteComisionTVendedor;
		}
		public function getIdCorteComisionA()
		{
			return $this->idCorteComisionA;
		}
		public function getIdCorteComisionAVendedor()
		{
			return $this->idCorteComisionAVendedor;
		}
		public function getComisionpagada()
		{
			return $this->comisionpagada;
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
		public function getAutorizacxc()
		{
			return $this->autorizacxc;
		}
		public function getFecha_autorizado()
		{
			return $this->fecha_autorizado;
		}
		public function getId_usuario_autorizado()
		{
			return $this->id_usuario_autorizado;
		}
		public function getTipoAutorizacion()
		{
			return $this->tipoAutorizacion;
		}
		public function getObservacionAutoriza()
		{
			return $this->observacionAutoriza;
		}
		public function getFecha_produccion()
		{
			return $this->fecha_produccion;
		}
		public function getId_usuario_produccion()
		{
			return $this->id_usuario_produccion;
		}
		public function getFecha_terminado()
		{
			return $this->fecha_terminado;
		}
		public function getId_usuario_terminado()
		{
			return $this->id_usuario_terminado;
		}
		public function getFecha_entregado()
		{
			return $this->fecha_entregado;
		}
		public function getId_usuario_entregado()
		{
			return $this->id_usuario_entregado;
		}
		public function getFecha_cancelado()
		{
			return $this->fecha_cancelado;
		}
		public function getId_usuario_cancelado()
		{
			return $this->id_usuario_cancelado;
		}
		public function getObservacionCancela()
		{
			return $this->observacionCancela;
		}
		public function getFecha_descuento()
		{
			return $this->fecha_descuento;
		}
		public function getId_usuario_descuento()
		{
			return $this->id_usuario_descuento;
		}
		public function getListo_para_producir()
		{
			return $this->listo_para_producir;
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
		public function getGenerarValeSalida()
		{
			return $this->generarValeSalida;
		}
		public function getObservacion_aunno()
		{
			return $this->observacion_aunno;
		}
		public function getFecha_limitepago()
		{
			return $this->fecha_limitepago;
		}
		public function getTipocliente()
		{
			return $this->tipocliente;
		}
		public function getIdcotizacion()
		{
			return $this->idcotizacion;
		}
		public function getIdSucursalCapturado()
		{
			return $this->idSucursalCapturado;
		}
		public function getColocado()
		{
			return $this->colocado;
		}
		public function getColocadoAutomatico()
		{
			return $this->colocadoAutomatico;
		}
		public function getIdSucursalPreferenciaRecoge()
		{
			return $this->idSucursalPreferenciaRecoge;
		}
		public function getIdCCRoofing()
		{
			return $this->idCCRoofing;
		}
		public function getIdCCRoofingVendedor()
		{
			return $this->idCCRoofingVendedor;
		}
		public function getDespieceTerminado()
		{
			return $this->despieceTerminado;
		}
		public function getPlanProteccion()
		{
			return $this->planProteccion;
		}
		public function getChecarAutorizacion()
		{
			return $this->checarAutorizacion;
		}
		public function getTipoRuta()
		{
			return $this->tipoRuta;
		}
		public function getIdRutaEnvio()
		{
			return $this->idRutaEnvio;
		}
		public function getId_usuario_enruta()
		{
			return $this->id_usuario_enruta;
		}
		public function getFecha_enruta()
		{
			return $this->fecha_enruta;
		}
		public function getRangosString()
		{
			return $this->rangosString;
		}
		public function getFecha_updateprecios()
		{
			return $this->fecha_updateprecios;
		}
		public function getDesbloqueadoPreciosAdmin()
		{
			return $this->desbloqueadoPreciosAdmin;
		}
		public function getApartarMercancia()
		{
			return $this->apartarMercancia;
		}
		public function getIdClienteDatosFacturacion()
		{
			return $this->idClienteDatosFacturacion;
		}
		public function getLiberaVales()
		{
			return $this->liberaVales;
		}
		public function getId_usuario_libera_vales()
		{
			return $this->id_usuario_libera_vales;
		}
		public function getFecha_libera_vales()
		{
			return $this->fecha_libera_vales;
		}
		public function getObservacionLiberaVales()
		{
			return $this->observacionLiberaVales;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPedido=0;
			$this->idCliente=0;
			$this->subtotal='0.00';
			$this->otrosCargos='0.00';
			$this->iva='0.00';
			$this->porDecuento='0.00';
			$this->descuento='0.00';
			$this->total='0.00';
			$this->porDescuento='0.00';
			$this->maxDescuentoIndividual='0';
			$this->descuentoIndividual='0';
			$this->anticipo='0';
			$this->saldo='0.00';
			$this->totalcte='0';
			$this->saldocte='0';
			$this->totalpromotor='0.00';
			$this->saldopromotor='0.00';
			$this->estado='CAPTURADO';
			$this->explotado='NO';
			$this->explotadook='NO';
			$this->despachado='NO';
			$this->idUsoCfdi=0;
			$this->solicitaFactura='NO';
			$this->facturado='NO';
			$this->fecha_solicitafactura='0000-00-00 00:00:00';
			$this->id_usuario_solicitafactura=0;
			$this->factura='0';
			$this->fecha_factura='0000-00-00 00:00:00';
			$this->id_usuario_factura=0;
			$this->saldada='NO';
			$this->fecha_saldada='0000-00-00 00:00:00';
			$this->idComision=0;
			$this->idCorteComision=0;
			$this->idCorteComisionVendedor=0;
			$this->idCorteComisionT=0;
			$this->idCorteComisionTVendedor=0;
			$this->idCorteComisionA=0;
			$this->idCorteComisionAVendedor=0;
			$this->comisionpagada='NO';
			$this->observaciones='';
			$this->fecha_capturado='0000-00-00 00:00:00';
			$this->id_usuario_capturado=0;
			$this->observacionCaptura='';
			$this->autorizacxc='NO';
			$this->fecha_autorizado='0000-00-00 00:00:00';
			$this->id_usuario_autorizado=0;
			$this->tipoAutorizacion='NINGUNO';
			$this->observacionAutoriza='';
			$this->fecha_produccion='0000-00-00 00:00:00';
			$this->id_usuario_produccion=0;
			$this->fecha_terminado='0000-00-00 00:00:00';
			$this->id_usuario_terminado=0;
			$this->fecha_entregado='0000-00-00 00:00:00';
			$this->id_usuario_entregado=0;
			$this->fecha_cancelado='0000-00-00 00:00:00';
			$this->id_usuario_cancelado=0;
			$this->observacionCancela='';
			$this->fecha_descuento='0000-00-00 00:00:00';
			$this->id_usuario_descuento=0;
			$this->listo_para_producir='NO';
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
			$this->generarValeSalida='NO';
			$this->observacion_aunno='';
			$this->fecha_limitepago='0000-00-00 00:00:00';
			$this->tipocliente='NUEVO';
			$this->idcotizacion=0;
			$this->idSucursalCapturado=0;
			$this->colocado='NO';
			$this->colocadoAutomatico='NO';
			$this->idSucursalPreferenciaRecoge=0;
			$this->idCCRoofing=0;
			$this->idCCRoofingVendedor=0;
			$this->despieceTerminado='NO';
			$this->planProteccion='NO';
			$this->checarAutorizacion='NO';
			$this->tipoRuta='SINRUTA';
			$this->idRutaEnvio=0;
			$this->id_usuario_enruta=0;
			$this->fecha_enruta='0000-00-00 00:00:00';
			$this->rangosString='';
			$this->fecha_updateprecios='0000-00-00 00:00:00';
			$this->desbloqueadoPreciosAdmin='NO';
			$this->apartarMercancia='SI';
			$this->idClienteDatosFacturacion=0;
			$this->liberaVales='NO';
			$this->id_usuario_libera_vales=0;
			$this->fecha_libera_vales='0000-00-00 00:00:00';
			$this->observacionLiberaVales='';
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
				                                              saldo,
				                                              totalcte,
				                                              saldocte,
				                                              totalpromotor,
				                                              saldopromotor,
				                                              estado,
				                                              explotado,
				                                              explotadook,
				                                              despachado,
				                                              idUsoCfdi,
				                                              solicitaFactura,
				                                              facturado,
				                                              fecha_solicitafactura,
				                                              id_usuario_solicitafactura,
				                                              factura,
				                                              fecha_factura,
				                                              id_usuario_factura,
				                                              saldada,
				                                              fecha_saldada,
				                                              idComision,
				                                              idCorteComision,
				                                              idCorteComisionVendedor,
				                                              idCorteComisionT,
				                                              idCorteComisionTVendedor,
				                                              idCorteComisionA,
				                                              idCorteComisionAVendedor,
				                                              comisionpagada,
				                                              observaciones,
				                                              fecha_capturado,
				                                              id_usuario_capturado,
				                                              observacionCaptura,
				                                              autorizacxc,
				                                              fecha_autorizado,
				                                              id_usuario_autorizado,
				                                              tipoAutorizacion,
				                                              observacionAutoriza,
				                                              fecha_produccion,
				                                              id_usuario_produccion,
				                                              fecha_terminado,
				                                              id_usuario_terminado,
				                                              fecha_entregado,
				                                              id_usuario_entregado,
				                                              fecha_cancelado,
				                                              id_usuario_cancelado,
				                                              observacionCancela,
				                                              fecha_descuento,
				                                              id_usuario_descuento,
				                                              listo_para_producir,
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
				                                              generarValeSalida,
				                                              observacion_aunno,
				                                              fecha_limitepago,
				                                              tipocliente,
				                                              idcotizacion,
				                                              idSucursalCapturado,
				                                              colocado,
				                                              colocadoAutomatico,
				                                              idSucursalPreferenciaRecoge,
				                                              idCCRoofing,
				                                              idCCRoofingVendedor,
				                                              despieceTerminado,
				                                              planProteccion,
				                                              checarAutorizacion,
				                                              tipoRuta,
				                                              idRutaEnvio,
				                                              id_usuario_enruta,
				                                              fecha_enruta,
				                                              rangosString,
				                                              fecha_updateprecios,
				                                              desbloqueadoPreciosAdmin,
				                                              apartarMercancia,
				                                              idClienteDatosFacturacion,
				                                              liberaVales,
				                                              id_usuario_libera_vales,
				                                              fecha_libera_vales,
				                                              observacionLiberaVales)
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
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalcte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldocte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldopromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->explotado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->explotadook) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->despachado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->solicitaFactura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->facturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_solicitafactura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_solicitafactura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->factura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_factura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_factura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_saldada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idComision) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComision) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionVendedor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionT) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionTVendedor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionA) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionAVendedor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionpagada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_capturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_capturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacionCaptura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->autorizacxc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_autorizado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_autorizado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoAutorizacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacionAutoriza) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_produccion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_produccion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_terminado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_terminado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_entregado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_entregado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_cancelado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_cancelado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacionCancela) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_descuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_descuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->listo_para_producir) . "',
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
				               '" . mysqli_real_escape_string($this->dbLink,$this->generarValeSalida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacion_aunno) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_limitepago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipocliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idcotizacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursalCapturado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->colocado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->colocadoAutomatico) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursalPreferenciaRecoge) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCCRoofing) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idCCRoofingVendedor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->despieceTerminado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->planProteccion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->checarAutorizacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoRuta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_enruta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_enruta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangosString) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_updateprecios) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->desbloqueadoPreciosAdmin) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apartarMercancia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idClienteDatosFacturacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->liberaVales) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_libera_vales) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_libera_vales) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observacionLiberaVales) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedido::Insertar]");
				
				$this->idPedido=mysqli_insert_id($this->dbLink);
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
	                                              saldo='" . mysqli_real_escape_string($this->dbLink,$this->saldo) . "',
	                                              totalcte='" . mysqli_real_escape_string($this->dbLink,$this->totalcte) . "',
	                                              saldocte='" . mysqli_real_escape_string($this->dbLink,$this->saldocte) . "',
	                                              totalpromotor='" . mysqli_real_escape_string($this->dbLink,$this->totalpromotor) . "',
	                                              saldopromotor='" . mysqli_real_escape_string($this->dbLink,$this->saldopromotor) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              explotado='" . mysqli_real_escape_string($this->dbLink,$this->explotado) . "',
	                                              explotadook='" . mysqli_real_escape_string($this->dbLink,$this->explotadook) . "',
	                                              despachado='" . mysqli_real_escape_string($this->dbLink,$this->despachado) . "',
	                                              idUsoCfdi='" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
	                                              solicitaFactura='" . mysqli_real_escape_string($this->dbLink,$this->solicitaFactura) . "',
	                                              facturado='" . mysqli_real_escape_string($this->dbLink,$this->facturado) . "',
	                                              fecha_solicitafactura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_solicitafactura) . "',
	                                              id_usuario_solicitafactura='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_solicitafactura) . "',
	                                              factura='" . mysqli_real_escape_string($this->dbLink,$this->factura) . "',
	                                              fecha_factura='" . mysqli_real_escape_string($this->dbLink,$this->fecha_factura) . "',
	                                              id_usuario_factura='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_factura) . "',
	                                              saldada='" . mysqli_real_escape_string($this->dbLink,$this->saldada) . "',
	                                              fecha_saldada='" . mysqli_real_escape_string($this->dbLink,$this->fecha_saldada) . "',
	                                              idComision='" . mysqli_real_escape_string($this->dbLink,$this->idComision) . "',
	                                              idCorteComision='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComision) . "',
	                                              idCorteComisionVendedor='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionVendedor) . "',
	                                              idCorteComisionT='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionT) . "',
	                                              idCorteComisionTVendedor='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionTVendedor) . "',
	                                              idCorteComisionA='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionA) . "',
	                                              idCorteComisionAVendedor='" . mysqli_real_escape_string($this->dbLink,$this->idCorteComisionAVendedor) . "',
	                                              comisionpagada='" . mysqli_real_escape_string($this->dbLink,$this->comisionpagada) . "',
	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
	                                              fecha_capturado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_capturado) . "',
	                                              id_usuario_capturado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_capturado) . "',
	                                              observacionCaptura='" . mysqli_real_escape_string($this->dbLink,$this->observacionCaptura) . "',
	                                              autorizacxc='" . mysqli_real_escape_string($this->dbLink,$this->autorizacxc) . "',
	                                              fecha_autorizado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_autorizado) . "',
	                                              id_usuario_autorizado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_autorizado) . "',
	                                              tipoAutorizacion='" . mysqli_real_escape_string($this->dbLink,$this->tipoAutorizacion) . "',
	                                              observacionAutoriza='" . mysqli_real_escape_string($this->dbLink,$this->observacionAutoriza) . "',
	                                              fecha_produccion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_produccion) . "',
	                                              id_usuario_produccion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_produccion) . "',
	                                              fecha_terminado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_terminado) . "',
	                                              id_usuario_terminado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_terminado) . "',
	                                              fecha_entregado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_entregado) . "',
	                                              id_usuario_entregado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_entregado) . "',
	                                              fecha_cancelado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_cancelado) . "',
	                                              id_usuario_cancelado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_cancelado) . "',
	                                              observacionCancela='" . mysqli_real_escape_string($this->dbLink,$this->observacionCancela) . "',
	                                              fecha_descuento='" . mysqli_real_escape_string($this->dbLink,$this->fecha_descuento) . "',
	                                              id_usuario_descuento='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_descuento) . "',
	                                              listo_para_producir='" . mysqli_real_escape_string($this->dbLink,$this->listo_para_producir) . "',
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
	                                              generarValeSalida='" . mysqli_real_escape_string($this->dbLink,$this->generarValeSalida) . "',
	                                              observacion_aunno='" . mysqli_real_escape_string($this->dbLink,$this->observacion_aunno) . "',
	                                              fecha_limitepago='" . mysqli_real_escape_string($this->dbLink,$this->fecha_limitepago) . "',
	                                              tipocliente='" . mysqli_real_escape_string($this->dbLink,$this->tipocliente) . "',
	                                              idcotizacion='" . mysqli_real_escape_string($this->dbLink,$this->idcotizacion) . "',
	                                              idSucursalCapturado='" . mysqli_real_escape_string($this->dbLink,$this->idSucursalCapturado) . "',
	                                              colocado='" . mysqli_real_escape_string($this->dbLink,$this->colocado) . "',
	                                              colocadoAutomatico='" . mysqli_real_escape_string($this->dbLink,$this->colocadoAutomatico) . "',
	                                              idSucursalPreferenciaRecoge='" . mysqli_real_escape_string($this->dbLink,$this->idSucursalPreferenciaRecoge) . "',
	                                              idCCRoofing='" . mysqli_real_escape_string($this->dbLink,$this->idCCRoofing) . "',
	                                              idCCRoofingVendedor='" . mysqli_real_escape_string($this->dbLink,$this->idCCRoofingVendedor) . "',
	                                              despieceTerminado='" . mysqli_real_escape_string($this->dbLink,$this->despieceTerminado) . "',
	                                              planProteccion='" . mysqli_real_escape_string($this->dbLink,$this->planProteccion) . "',
	                                              checarAutorizacion='" . mysqli_real_escape_string($this->dbLink,$this->checarAutorizacion) . "',
	                                              tipoRuta='" . mysqli_real_escape_string($this->dbLink,$this->tipoRuta) . "',
	                                              idRutaEnvio='" . mysqli_real_escape_string($this->dbLink,$this->idRutaEnvio) . "',
	                                              id_usuario_enruta='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_enruta) . "',
	                                              fecha_enruta='" . mysqli_real_escape_string($this->dbLink,$this->fecha_enruta) . "',
	                                              rangosString='" . mysqli_real_escape_string($this->dbLink,$this->rangosString) . "',
	                                              fecha_updateprecios='" . mysqli_real_escape_string($this->dbLink,$this->fecha_updateprecios) . "',
	                                              desbloqueadoPreciosAdmin='" . mysqli_real_escape_string($this->dbLink,$this->desbloqueadoPreciosAdmin) . "',
	                                              apartarMercancia='" . mysqli_real_escape_string($this->dbLink,$this->apartarMercancia) . "',
	                                              idClienteDatosFacturacion='" . mysqli_real_escape_string($this->dbLink,$this->idClienteDatosFacturacion) . "',
	                                              liberaVales='" . mysqli_real_escape_string($this->dbLink,$this->liberaVales) . "',
	                                              id_usuario_libera_vales='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_libera_vales) . "',
	                                              fecha_libera_vales='" . mysqli_real_escape_string($this->dbLink,$this->fecha_libera_vales) . "',
	                                              observacionLiberaVales='" . mysqli_real_escape_string($this->dbLink,$this->observacionLiberaVales) . "'
					WHERE idPedido=" . $this->idPedido;
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedido::Update]");
				
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
				WHERE idPedido=" . mysqli_real_escape_string($this->dbLink,$this->idPedido);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedido::Borrar]");
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
						idPedido,
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
						saldo,
						totalcte,
						saldocte,
						totalpromotor,
						saldopromotor,
						estado,
						explotado,
						explotadook,
						despachado,
						idUsoCfdi,
						solicitaFactura,
						facturado,
						fecha_solicitafactura,
						id_usuario_solicitafactura,
						factura,
						fecha_factura,
						id_usuario_factura,
						saldada,
						fecha_saldada,
						idComision,
						idCorteComision,
						idCorteComisionVendedor,
						idCorteComisionT,
						idCorteComisionTVendedor,
						idCorteComisionA,
						idCorteComisionAVendedor,
						comisionpagada,
						observaciones,
						fecha_capturado,
						id_usuario_capturado,
						observacionCaptura,
						autorizacxc,
						fecha_autorizado,
						id_usuario_autorizado,
						tipoAutorizacion,
						observacionAutoriza,
						fecha_produccion,
						id_usuario_produccion,
						fecha_terminado,
						id_usuario_terminado,
						fecha_entregado,
						id_usuario_entregado,
						fecha_cancelado,
						id_usuario_cancelado,
						observacionCancela,
						fecha_descuento,
						id_usuario_descuento,
						listo_para_producir,
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
						generarValeSalida,
						observacion_aunno,
						fecha_limitepago,
						tipocliente,
						idcotizacion,
						idSucursalCapturado,
						colocado,
						colocadoAutomatico,
						idSucursalPreferenciaRecoge,
						idCCRoofing,
						idCCRoofingVendedor,
						despieceTerminado,
						planProteccion,
						checarAutorizacion,
						tipoRuta,
						idRutaEnvio,
						id_usuario_enruta,
						fecha_enruta,
						rangosString,
						fecha_updateprecios,
						desbloqueadoPreciosAdmin,
						apartarMercancia,
						idClienteDatosFacturacion,
						liberaVales,
						id_usuario_libera_vales,
						fecha_libera_vales,
						observacionLiberaVales
					FROM " . $this->__tableName . " 
					WHERE idPedido=" . mysqli_real_escape_string($this->dbLink,$this->idPedido);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePedido::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPedido==0)
				$this->Insertar();
			else
			{
				$this->ProcesarActualizaciones();
				$this->Actualizar();
			}
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>