<?php

	class ModeloBaseCliente extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCliente";

		
		var $idCliente=0;
		var $nombre='';
		var $apellidos='';
		var $empresa='';
		var $domicilio1='';
		var $domicilio2='';
		var $numero='';
		var $colonia='';
		var $ciudad='';
		var $telefonos='';
		var $email='';
		var $rfc='';
		var $idUsuarioPromotor=0;
		var $idPromotorAnterior=0;
		var $estado='ACTIVO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $idUsuarioCrea=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $idUsuarioModifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $idUsuarioBaja=0;
		var $porDescuento='0';
		var $idUsoCfdi=0;
		var $credito='0.00';
		var $sumacreditorfc='0.00';
		var $capacidadPago='25000.00';
		var $sumacapacidadpagorfc='0.00';
		var $usado='0';
		var $creditopromotor='0';
		var $facturable='NO';
		var $razonsocial='';
		var $domiciliofiscal='';
		var $codigopostal='';
		var $codigopostalfiscal='';
		var $coloniafiscal='';
		var $numerofiscal='';
		var $ciudadfiscal='';
		var $saldarpedidoparaautorizar='SI';
		var $saldarpedidoparavalesalida='NO';
		var $samedata='NO';
		var $rangoCliente='REGULAR';
		var $enviarPlanProteccion='NO';
		var $procesarCreditos='NO';
		var $fecha_ultimo_proceso='0000-00-00 00:00:00';

		var $__s=array("idCliente",
                       "nombre",
                       "apellidos",
                       "empresa",
                       "domicilio1",
                       "domicilio2",
                       "numero",
                       "colonia",
                       "ciudad",
                       "telefonos",
                       "email",
                       "rfc",
                       "idUsuarioPromotor",
                       "idPromotorAnterior",
                       "estado",
                       "fecha_creacion",
                       "idUsuarioCrea",
                       "fecha_modifica",
                       "idUsuarioModifica",
                       "fecha_baja",
                       "idUsuarioBaja",
                       "porDescuento",
                       "idUsoCfdi",
                       "credito",
                       "sumacreditorfc",
                       "capacidadPago",
                       "sumacapacidadpagorfc",
                       "usado",
                       "creditopromotor",
                       "facturable",
                       "razonsocial",
                       "domiciliofiscal",
                       "codigopostal",
                       "codigopostalfiscal",
                       "coloniafiscal",
                       "numerofiscal",
                       "ciudadfiscal",
                       "saldarpedidoparaautorizar",
                       "saldarpedidoparavalesalida",
                       "samedata",
                       "rangoCliente",
                       "enviarPlanProteccion",
                       "procesarCreditos",
                       "fecha_ultimo_proceso");
				
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

		
		public function setIdCliente($idCliente)
		{
			if($idCliente==0||$idCliente==""||!is_numeric($idCliente)|| (is_string($idCliente)&&!ctype_digit($idCliente)))return $this->setError("Tipo de dato incorrecto para idCliente.");
			$this->idCliente=$idCliente;
			$this->getDatos();
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setApellidos($apellidos)
		{
			
			$this->apellidos=$apellidos;
		}
		public function setEmpresa($empresa)
		{
			
			$this->empresa=$empresa;
		}
		public function setDomicilio1($domicilio1)
		{
			
			$this->domicilio1=$domicilio1;
		}
		public function setDomicilio2($domicilio2)
		{
			
			$this->domicilio2=$domicilio2;
		}
		public function setNumero($numero)
		{
			
			$this->numero=$numero;
		}
		public function setColonia($colonia)
		{
			
			$this->colonia=$colonia;
		}
		public function setCiudad($ciudad)
		{
			
			$this->ciudad=$ciudad;
		}
		public function setTelefonos($telefonos)
		{
			
			$this->telefonos=$telefonos;
		}
		public function setEmail($email)
		{
			
			$this->email=$email;
		}
		public function setRfc($rfc)
		{
			
			$this->rfc=$rfc;
		}
		public function setIdUsuarioPromotor($idUsuarioPromotor)
		{
			
			$this->idUsuarioPromotor=$idUsuarioPromotor;
		}
		public function setIdPromotorAnterior($idPromotorAnterior)
		{
			
			$this->idPromotorAnterior=$idPromotorAnterior;
		}
		public function setEstado($estado)
		{
			
			$this->estado=$estado;
		}
		public function setEstadoACTIVO()
		{
			$this->estado='ACTIVO';
		}
		public function setEstadoBAJA()
		{
			$this->estado='BAJA';
		}
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setIdUsuarioCrea($idUsuarioCrea)
		{
			
			$this->idUsuarioCrea=$idUsuarioCrea;
		}
		public function setFecha_modifica($fecha_modifica)
		{
			$this->fecha_modifica=$fecha_modifica;
		}
		public function setIdUsuarioModifica($idUsuarioModifica)
		{
			
			$this->idUsuarioModifica=$idUsuarioModifica;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setIdUsuarioBaja($idUsuarioBaja)
		{
			
			$this->idUsuarioBaja=$idUsuarioBaja;
		}
		public function setPorDescuento($porDescuento)
		{
			$this->porDescuento=$porDescuento;
		}
		public function setIdUsoCfdi($idUsoCfdi)
		{
			
			$this->idUsoCfdi=$idUsoCfdi;
		}
		public function setCredito($credito)
		{
			$this->credito=$credito;
		}
		public function setSumacreditorfc($sumacreditorfc)
		{
			$this->sumacreditorfc=$sumacreditorfc;
		}
		public function setCapacidadPago($capacidadPago)
		{
			$this->capacidadPago=$capacidadPago;
		}
		public function setSumacapacidadpagorfc($sumacapacidadpagorfc)
		{
			$this->sumacapacidadpagorfc=$sumacapacidadpagorfc;
		}
		public function setUsado($usado)
		{
			$this->usado=$usado;
		}
		public function setCreditopromotor($creditopromotor)
		{
			$this->creditopromotor=$creditopromotor;
		}
		public function setFacturable($facturable)
		{
			
			$this->facturable=$facturable;
		}
		public function setFacturableSI()
		{
			$this->facturable='SI';
		}
		public function setFacturableNO()
		{
			$this->facturable='NO';
		}
		public function setRazonsocial($razonsocial)
		{
			
			$this->razonsocial=$razonsocial;
		}
		public function setDomiciliofiscal($domiciliofiscal)
		{
			
			$this->domiciliofiscal=$domiciliofiscal;
		}
		public function setCodigopostal($codigopostal)
		{
			
			$this->codigopostal=$codigopostal;
		}
		public function setCodigopostalfiscal($codigopostalfiscal)
		{
			
			$this->codigopostalfiscal=$codigopostalfiscal;
		}
		public function setColoniafiscal($coloniafiscal)
		{
			
			$this->coloniafiscal=$coloniafiscal;
		}
		public function setNumerofiscal($numerofiscal)
		{
			
			$this->numerofiscal=$numerofiscal;
		}
		public function setCiudadfiscal($ciudadfiscal)
		{
			
			$this->ciudadfiscal=$ciudadfiscal;
		}
		public function setSaldarpedidoparaautorizar($saldarpedidoparaautorizar)
		{
			
			$this->saldarpedidoparaautorizar=$saldarpedidoparaautorizar;
		}
		public function setSaldarpedidoparaautorizarSI()
		{
			$this->saldarpedidoparaautorizar='SI';
		}
		public function setSaldarpedidoparaautorizarNO()
		{
			$this->saldarpedidoparaautorizar='NO';
		}
		public function setSaldarpedidoparavalesalida($saldarpedidoparavalesalida)
		{
			
			$this->saldarpedidoparavalesalida=$saldarpedidoparavalesalida;
		}
		public function setSaldarpedidoparavalesalidaSI()
		{
			$this->saldarpedidoparavalesalida='SI';
		}
		public function setSaldarpedidoparavalesalidaNO()
		{
			$this->saldarpedidoparavalesalida='NO';
		}
		public function setSamedata($samedata)
		{
			
			$this->samedata=$samedata;
		}
		public function setSamedataSI()
		{
			$this->samedata='SI';
		}
		public function setSamedataNO()
		{
			$this->samedata='NO';
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
		public function setEnviarPlanProteccion($enviarPlanProteccion)
		{
			
			$this->enviarPlanProteccion=$enviarPlanProteccion;
		}
		public function setEnviarPlanProteccionSI()
		{
			$this->enviarPlanProteccion='SI';
		}
		public function setEnviarPlanProteccionNO()
		{
			$this->enviarPlanProteccion='NO';
		}
		public function setProcesarCreditos($procesarCreditos)
		{
			
			$this->procesarCreditos=$procesarCreditos;
		}
		public function setProcesarCreditosSI()
		{
			$this->procesarCreditos='SI';
		}
		public function setProcesarCreditosNO()
		{
			$this->procesarCreditos='NO';
		}
		public function setFecha_ultimo_proceso($fecha_ultimo_proceso)
		{
			$this->fecha_ultimo_proceso=$fecha_ultimo_proceso;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCliente()
		{
			return $this->idCliente;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getApellidos()
		{
			return $this->apellidos;
		}
		public function getEmpresa()
		{
			return $this->empresa;
		}
		public function getDomicilio1()
		{
			return $this->domicilio1;
		}
		public function getDomicilio2()
		{
			return $this->domicilio2;
		}
		public function getNumero()
		{
			return $this->numero;
		}
		public function getColonia()
		{
			return $this->colonia;
		}
		public function getCiudad()
		{
			return $this->ciudad;
		}
		public function getTelefonos()
		{
			return $this->telefonos;
		}
		public function getEmail()
		{
			return $this->email;
		}
		public function getRfc()
		{
			return $this->rfc;
		}
		public function getIdUsuarioPromotor()
		{
			return $this->idUsuarioPromotor;
		}
		public function getIdPromotorAnterior()
		{
			return $this->idPromotorAnterior;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getIdUsuarioCrea()
		{
			return $this->idUsuarioCrea;
		}
		public function getFecha_modifica()
		{
			return $this->fecha_modifica;
		}
		public function getIdUsuarioModifica()
		{
			return $this->idUsuarioModifica;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getIdUsuarioBaja()
		{
			return $this->idUsuarioBaja;
		}
		public function getPorDescuento()
		{
			return $this->porDescuento;
		}
		public function getIdUsoCfdi()
		{
			return $this->idUsoCfdi;
		}
		public function getCredito()
		{
			return $this->credito;
		}
		public function getSumacreditorfc()
		{
			return $this->sumacreditorfc;
		}
		public function getCapacidadPago()
		{
			return $this->capacidadPago;
		}
		public function getSumacapacidadpagorfc()
		{
			return $this->sumacapacidadpagorfc;
		}
		public function getUsado()
		{
			return $this->usado;
		}
		public function getCreditopromotor()
		{
			return $this->creditopromotor;
		}
		public function getFacturable()
		{
			return $this->facturable;
		}
		public function getRazonsocial()
		{
			return $this->razonsocial;
		}
		public function getDomiciliofiscal()
		{
			return $this->domiciliofiscal;
		}
		public function getCodigopostal()
		{
			return $this->codigopostal;
		}
		public function getCodigopostalfiscal()
		{
			return $this->codigopostalfiscal;
		}
		public function getColoniafiscal()
		{
			return $this->coloniafiscal;
		}
		public function getNumerofiscal()
		{
			return $this->numerofiscal;
		}
		public function getCiudadfiscal()
		{
			return $this->ciudadfiscal;
		}
		public function getSaldarpedidoparaautorizar()
		{
			return $this->saldarpedidoparaautorizar;
		}
		public function getSaldarpedidoparavalesalida()
		{
			return $this->saldarpedidoparavalesalida;
		}
		public function getSamedata()
		{
			return $this->samedata;
		}
		public function getRangoCliente()
		{
			return $this->rangoCliente;
		}
		public function getEnviarPlanProteccion()
		{
			return $this->enviarPlanProteccion;
		}
		public function getProcesarCreditos()
		{
			return $this->procesarCreditos;
		}
		public function getFecha_ultimo_proceso()
		{
			return $this->fecha_ultimo_proceso;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCliente=0;
			$this->nombre='';
			$this->apellidos='';
			$this->empresa='';
			$this->domicilio1='';
			$this->domicilio2='';
			$this->numero='';
			$this->colonia='';
			$this->ciudad='';
			$this->telefonos='';
			$this->email='';
			$this->rfc='';
			$this->idUsuarioPromotor=0;
			$this->idPromotorAnterior=0;
			$this->estado='ACTIVO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->idUsuarioCrea=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->idUsuarioModifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->idUsuarioBaja=0;
			$this->porDescuento='0';
			$this->idUsoCfdi=0;
			$this->credito='0.00';
			$this->sumacreditorfc='0.00';
			$this->capacidadPago='25000.00';
			$this->sumacapacidadpagorfc='0.00';
			$this->usado='0';
			$this->creditopromotor='0';
			$this->facturable='NO';
			$this->razonsocial='';
			$this->domiciliofiscal='';
			$this->codigopostal='';
			$this->codigopostalfiscal='';
			$this->coloniafiscal='';
			$this->numerofiscal='';
			$this->ciudadfiscal='';
			$this->saldarpedidoparaautorizar='SI';
			$this->saldarpedidoparavalesalida='NO';
			$this->samedata='NO';
			$this->rangoCliente='REGULAR';
			$this->enviarPlanProteccion='NO';
			$this->procesarCreditos='NO';
			$this->fecha_ultimo_proceso='0000-00-00 00:00:00';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (nombre,
				                                              apellidos,
				                                              empresa,
				                                              domicilio1,
				                                              domicilio2,
				                                              numero,
				                                              colonia,
				                                              ciudad,
				                                              telefonos,
				                                              email,
				                                              rfc,
				                                              idUsuarioPromotor,
				                                              idPromotorAnterior,
				                                              estado,
				                                              fecha_creacion,
				                                              idUsuarioCrea,
				                                              fecha_modifica,
				                                              idUsuarioModifica,
				                                              fecha_baja,
				                                              idUsuarioBaja,
				                                              porDescuento,
				                                              idUsoCfdi,
				                                              credito,
				                                              sumacreditorfc,
				                                              capacidadPago,
				                                              sumacapacidadpagorfc,
				                                              usado,
				                                              creditopromotor,
				                                              facturable,
				                                              razonsocial,
				                                              domiciliofiscal,
				                                              codigopostal,
				                                              codigopostalfiscal,
				                                              coloniafiscal,
				                                              numerofiscal,
				                                              ciudadfiscal,
				                                              saldarpedidoparaautorizar,
				                                              saldarpedidoparavalesalida,
				                                              samedata,
				                                              rangoCliente,
				                                              enviarPlanProteccion,
				                                              procesarCreditos,
				                                              fecha_ultimo_proceso)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apellidos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->empresa) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domicilio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->telefonos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioPromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idPromotorAnterior) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->sumacreditorfc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->capacidadPago) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->sumacapacidadpagorfc) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->creditopromotor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->facturable) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->razonsocial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->domiciliofiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->codigopostal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->codigopostalfiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->coloniafiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->numerofiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->ciudadfiscal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldarpedidoparaautorizar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->saldarpedidoparavalesalida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->samedata) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rangoCliente) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->enviarPlanProteccion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->procesarCreditos) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_ultimo_proceso) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Insertar]");
				
				$this->idCliente=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET nombre='" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',
	                                              apellidos='" . mysqli_real_escape_string($this->dbLink,$this->apellidos) . "',
	                                              empresa='" . mysqli_real_escape_string($this->dbLink,$this->empresa) . "',
	                                              domicilio1='" . mysqli_real_escape_string($this->dbLink,$this->domicilio1) . "',
	                                              domicilio2='" . mysqli_real_escape_string($this->dbLink,$this->domicilio2) . "',
	                                              numero='" . mysqli_real_escape_string($this->dbLink,$this->numero) . "',
	                                              colonia='" . mysqli_real_escape_string($this->dbLink,$this->colonia) . "',
	                                              ciudad='" . mysqli_real_escape_string($this->dbLink,$this->ciudad) . "',
	                                              telefonos='" . mysqli_real_escape_string($this->dbLink,$this->telefonos) . "',
	                                              email='" . mysqli_real_escape_string($this->dbLink,$this->email) . "',
	                                              rfc='" . mysqli_real_escape_string($this->dbLink,$this->rfc) . "',
	                                              idUsuarioPromotor='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioPromotor) . "',
	                                              idPromotorAnterior='" . mysqli_real_escape_string($this->dbLink,$this->idPromotorAnterior) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              idUsuarioCrea='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioCrea) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              idUsuarioModifica='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioModifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              idUsuarioBaja='" . mysqli_real_escape_string($this->dbLink,$this->idUsuarioBaja) . "',
	                                              porDescuento='" . mysqli_real_escape_string($this->dbLink,$this->porDescuento) . "',
	                                              idUsoCfdi='" . mysqli_real_escape_string($this->dbLink,$this->idUsoCfdi) . "',
	                                              credito='" . mysqli_real_escape_string($this->dbLink,$this->credito) . "',
	                                              sumacreditorfc='" . mysqli_real_escape_string($this->dbLink,$this->sumacreditorfc) . "',
	                                              capacidadPago='" . mysqli_real_escape_string($this->dbLink,$this->capacidadPago) . "',
	                                              sumacapacidadpagorfc='" . mysqli_real_escape_string($this->dbLink,$this->sumacapacidadpagorfc) . "',
	                                              usado='" . mysqli_real_escape_string($this->dbLink,$this->usado) . "',
	                                              creditopromotor='" . mysqli_real_escape_string($this->dbLink,$this->creditopromotor) . "',
	                                              facturable='" . mysqli_real_escape_string($this->dbLink,$this->facturable) . "',
	                                              razonsocial='" . mysqli_real_escape_string($this->dbLink,$this->razonsocial) . "',
	                                              domiciliofiscal='" . mysqli_real_escape_string($this->dbLink,$this->domiciliofiscal) . "',
	                                              codigopostal='" . mysqli_real_escape_string($this->dbLink,$this->codigopostal) . "',
	                                              codigopostalfiscal='" . mysqli_real_escape_string($this->dbLink,$this->codigopostalfiscal) . "',
	                                              coloniafiscal='" . mysqli_real_escape_string($this->dbLink,$this->coloniafiscal) . "',
	                                              numerofiscal='" . mysqli_real_escape_string($this->dbLink,$this->numerofiscal) . "',
	                                              ciudadfiscal='" . mysqli_real_escape_string($this->dbLink,$this->ciudadfiscal) . "',
	                                              saldarpedidoparaautorizar='" . mysqli_real_escape_string($this->dbLink,$this->saldarpedidoparaautorizar) . "',
	                                              saldarpedidoparavalesalida='" . mysqli_real_escape_string($this->dbLink,$this->saldarpedidoparavalesalida) . "',
	                                              samedata='" . mysqli_real_escape_string($this->dbLink,$this->samedata) . "',
	                                              rangoCliente='" . mysqli_real_escape_string($this->dbLink,$this->rangoCliente) . "',
	                                              enviarPlanProteccion='" . mysqli_real_escape_string($this->dbLink,$this->enviarPlanProteccion) . "',
	                                              procesarCreditos='" . mysqli_real_escape_string($this->dbLink,$this->procesarCreditos) . "',
	                                              fecha_ultimo_proceso='" . mysqli_real_escape_string($this->dbLink,$this->fecha_ultimo_proceso) . "'
					WHERE idCliente=" . $this->idCliente;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Update]");
				
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
				WHERE idCliente=" . mysqli_real_escape_string($this->dbLink,$this->idCliente);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCliente::Borrar]");
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
						idCliente,
						nombre,
						apellidos,
						empresa,
						domicilio1,
						domicilio2,
						numero,
						colonia,
						ciudad,
						telefonos,
						email,
						rfc,
						idUsuarioPromotor,
						idPromotorAnterior,
						estado,
						fecha_creacion,
						idUsuarioCrea,
						fecha_modifica,
						idUsuarioModifica,
						fecha_baja,
						idUsuarioBaja,
						porDescuento,
						idUsoCfdi,
						credito,
						sumacreditorfc,
						capacidadPago,
						sumacapacidadpagorfc,
						usado,
						creditopromotor,
						facturable,
						razonsocial,
						domiciliofiscal,
						codigopostal,
						codigopostalfiscal,
						coloniafiscal,
						numerofiscal,
						ciudadfiscal,
						saldarpedidoparaautorizar,
						saldarpedidoparavalesalida,
						samedata,
						rangoCliente,
						enviarPlanProteccion,
						procesarCreditos,
						fecha_ultimo_proceso
					FROM " . $this->__tableName . " 
					WHERE idCliente=" . mysqli_real_escape_string($this->dbLink,$this->idCliente);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCliente::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCliente==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>