<?php

	class ModeloBasePedidodetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePedidodetalle";

		
		var $idPedidoDetalle=0;
		var $IdPedido=0;
		var $renglon=0;
		var $idProducto=0;
		var $idRolloBase=0;
		var $tipoPrecio='PRECIO';
		var $tipoPrecioOriginal='PRECIO';
		var $comision='0.00';
		var $comisionOriginal='0';
		var $partida='0.00';
		var $cantidad='0.00';
		var $cantidadReal='0.00';
		var $desarrollo='';
		var $dobleces=0;
		var $curvar='NO';
		var $curvatura='';
		var $precioUnitario='0.00';
		var $precioUnitarioOriginal='0';
		var $total='0';
		var $explotarUnidad='0.00';
		var $totalExplotar='0.00';
		var $totalExplotado='0.00';
		var $explotadoReal='0.00';
		var $partidaDespachada='0';
		var $mlDespachado='0.00';
		var $partidaenvale='0.00';
		var $listo_para_producir='NO';
		var $despachado='NO';
		var $fecha_despachado='0000-00-00 00:00:00';
		var $id_usuario_despachado=0;
		var $idSucursalDespachado=0;
		var $pesoKiloML='0';
		var $molLaminasATomar=0;
		var $molPrecioDobleces='0.00';
		var $molPrecioCorte='0.00';
		var $molIsScrap='NO';
		var $molTotalcmScrap='0.00';
		var $molDescMaquila='';
		var $molLongitudinal='L';
		var $costoProducto='0';

		var $__s=array("idPedidoDetalle",
                       "IdPedido",
                       "renglon",
                       "idProducto",
                       "idRolloBase",
                       "tipoPrecio",
                       "tipoPrecioOriginal",
                       "comision",
                       "comisionOriginal",
                       "partida",
                       "cantidad",
                       "cantidadReal",
                       "desarrollo",
                       "dobleces",
                       "curvar",
                       "curvatura",
                       "precioUnitario",
                       "precioUnitarioOriginal",
                       "total",
                       "explotarUnidad",
                       "totalExplotar",
                       "totalExplotado",
                       "explotadoReal",
                       "partidaDespachada",
                       "mlDespachado",
                       "partidaenvale",
                       "listo_para_producir",
                       "despachado",
                       "fecha_despachado",
                       "id_usuario_despachado",
                       "idSucursalDespachado",
                       "pesoKiloML",
                       "molLaminasATomar",
                       "molPrecioDobleces",
                       "molPrecioCorte",
                       "molIsScrap",
                       "molTotalcmScrap",
                       "molDescMaquila",
                       "molLongitudinal",
                       "costoProducto");
				
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

		
		public function setIdPedidoDetalle($idPedidoDetalle)
		{
			if($idPedidoDetalle==0||$idPedidoDetalle==""||!is_numeric($idPedidoDetalle)|| (is_string($idPedidoDetalle)&&!ctype_digit($idPedidoDetalle)))return $this->setError("Tipo de dato incorrecto para idPedidoDetalle.");
			$this->idPedidoDetalle=$idPedidoDetalle;
			$this->getDatos();
			$this->SaveOriginalValues();
		}
		public function setIdPedido($IdPedido)
		{
			
			$this->IdPedido=$IdPedido;
		}
		public function setRenglon($renglon)
		{
			
			$this->renglon=$renglon;
		}
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setIdRolloBase($idRolloBase)
		{
			
			$this->idRolloBase=$idRolloBase;
		}
		public function setTipoPrecio($tipoPrecio)
		{
			
			$this->tipoPrecio=$tipoPrecio;
		}
		public function setTipoPrecioPRECIO()
		{
			$this->tipoPrecio='PRECIO';
		}
		public function setTipoPrecioRANGO1()
		{
			$this->tipoPrecio='RANGO1';
		}
		public function setTipoPrecioRANGO2()
		{
			$this->tipoPrecio='RANGO2';
		}
		public function setTipoPrecioRANGO3()
		{
			$this->tipoPrecio='RANGO3';
		}
		public function setTipoPrecioIMPORTADO()
		{
			$this->tipoPrecio='IMPORTADO';
		}
		public function setTipoPrecioTERNIUM()
		{
			$this->tipoPrecio='TERNIUM';
		}
		public function setTipoPrecioMENDEZ()
		{
			$this->tipoPrecio='MENDEZ';
		}
		public function setTipoPrecioRANGO4()
		{
			$this->tipoPrecio='RANGO4';
		}
		public function setTipoPrecioOriginal($tipoPrecioOriginal)
		{
			
			$this->tipoPrecioOriginal=$tipoPrecioOriginal;
		}
		public function setTipoPrecioOriginalPRECIO()
		{
			$this->tipoPrecioOriginal='PRECIO';
		}
		public function setTipoPrecioOriginalRANGO1()
		{
			$this->tipoPrecioOriginal='RANGO1';
		}
		public function setTipoPrecioOriginalRANGO2()
		{
			$this->tipoPrecioOriginal='RANGO2';
		}
		public function setTipoPrecioOriginalRANGO3()
		{
			$this->tipoPrecioOriginal='RANGO3';
		}
		public function setTipoPrecioOriginalIMPORTADO()
		{
			$this->tipoPrecioOriginal='IMPORTADO';
		}
		public function setTipoPrecioOriginalTERNIUM()
		{
			$this->tipoPrecioOriginal='TERNIUM';
		}
		public function setTipoPrecioOriginalMENDEZ()
		{
			$this->tipoPrecioOriginal='MENDEZ';
		}
		public function setTipoPrecioOriginalRANGO4()
		{
			$this->tipoPrecioOriginal='RANGO4';
		}
		public function setComision($comision)
		{
			$this->comision=$comision;
		}
		public function setComisionOriginal($comisionOriginal)
		{
			$this->comisionOriginal=$comisionOriginal;
		}
		public function setPartida($partida)
		{
			$this->partida=$partida;
		}
		public function setCantidad($cantidad)
		{
			$this->cantidad=$cantidad;
		}
		public function setCantidadReal($cantidadReal)
		{
			$this->cantidadReal=$cantidadReal;
		}
		public function setDesarrollo($desarrollo)
		{
			
			$this->desarrollo=$desarrollo;
		}
		public function setDobleces($dobleces)
		{
			
			$this->dobleces=$dobleces;
		}
		public function setCurvar($curvar)
		{
			
			$this->curvar=$curvar;
		}
		public function setCurvarSI()
		{
			$this->curvar='SI';
		}
		public function setCurvarNO()
		{
			$this->curvar='NO';
		}
		public function setCurvatura($curvatura)
		{
			
			$this->curvatura=$curvatura;
		}
		public function setPrecioUnitario($precioUnitario)
		{
			$this->precioUnitario=$precioUnitario;
		}
		public function setPrecioUnitarioOriginal($precioUnitarioOriginal)
		{
			$this->precioUnitarioOriginal=$precioUnitarioOriginal;
		}
		public function setTotal($total)
		{
			$this->total=$total;
		}
		public function setExplotarUnidad($explotarUnidad)
		{
			$this->explotarUnidad=$explotarUnidad;
		}
		public function setTotalExplotar($totalExplotar)
		{
			$this->totalExplotar=$totalExplotar;
		}
		public function setTotalExplotado($totalExplotado)
		{
			$this->totalExplotado=$totalExplotado;
		}
		public function setExplotadoReal($explotadoReal)
		{
			$this->explotadoReal=$explotadoReal;
		}
		public function setPartidaDespachada($partidaDespachada)
		{
			$this->partidaDespachada=$partidaDespachada;
		}
		public function setMlDespachado($mlDespachado)
		{
			$this->mlDespachado=$mlDespachado;
		}
		public function setPartidaenvale($partidaenvale)
		{
			$this->partidaenvale=$partidaenvale;
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
		public function setFecha_despachado($fecha_despachado)
		{
			$this->fecha_despachado=$fecha_despachado;
		}
		public function setId_usuario_despachado($id_usuario_despachado)
		{
			
			$this->id_usuario_despachado=$id_usuario_despachado;
		}
		public function setIdSucursalDespachado($idSucursalDespachado)
		{
			
			$this->idSucursalDespachado=$idSucursalDespachado;
		}
		public function setPesoKiloML($pesoKiloML)
		{
			$this->pesoKiloML=$pesoKiloML;
		}
		public function setMolLaminasATomar($molLaminasATomar)
		{
			
			$this->molLaminasATomar=$molLaminasATomar;
		}
		public function setMolPrecioDobleces($molPrecioDobleces)
		{
			$this->molPrecioDobleces=$molPrecioDobleces;
		}
		public function setMolPrecioCorte($molPrecioCorte)
		{
			$this->molPrecioCorte=$molPrecioCorte;
		}
		public function setMolIsScrap($molIsScrap)
		{
			
			$this->molIsScrap=$molIsScrap;
		}
		public function setMolIsScrapNO()
		{
			$this->molIsScrap='NO';
		}
		public function setMolIsScrapSI()
		{
			$this->molIsScrap='SI';
		}
		public function setMolTotalcmScrap($molTotalcmScrap)
		{
			$this->molTotalcmScrap=$molTotalcmScrap;
		}
		public function setMolDescMaquila($molDescMaquila)
		{
			
			$this->molDescMaquila=$molDescMaquila;
		}
		public function setMolLongitudinal($molLongitudinal)
		{
			
			$this->molLongitudinal=$molLongitudinal;
		}
		public function setMolLongitudinalL()
		{
			$this->molLongitudinal='L';
		}
		public function setMolLongitudinalA()
		{
			$this->molLongitudinal='A';
		}
		public function setCostoProducto($costoProducto)
		{
			$this->costoProducto=$costoProducto;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPedidoDetalle()
		{
			return $this->idPedidoDetalle;
		}
		public function getIdPedido()
		{
			return $this->IdPedido;
		}
		public function getRenglon()
		{
			return $this->renglon;
		}
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getIdRolloBase()
		{
			return $this->idRolloBase;
		}
		public function getTipoPrecio()
		{
			return $this->tipoPrecio;
		}
		public function getTipoPrecioOriginal()
		{
			return $this->tipoPrecioOriginal;
		}
		public function getComision()
		{
			return $this->comision;
		}
		public function getComisionOriginal()
		{
			return $this->comisionOriginal;
		}
		public function getPartida()
		{
			return $this->partida;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}
		public function getCantidadReal()
		{
			return $this->cantidadReal;
		}
		public function getDesarrollo()
		{
			return $this->desarrollo;
		}
		public function getDobleces()
		{
			return $this->dobleces;
		}
		public function getCurvar()
		{
			return $this->curvar;
		}
		public function getCurvatura()
		{
			return $this->curvatura;
		}
		public function getPrecioUnitario()
		{
			return $this->precioUnitario;
		}
		public function getPrecioUnitarioOriginal()
		{
			return $this->precioUnitarioOriginal;
		}
		public function getTotal()
		{
			return $this->total;
		}
		public function getExplotarUnidad()
		{
			return $this->explotarUnidad;
		}
		public function getTotalExplotar()
		{
			return $this->totalExplotar;
		}
		public function getTotalExplotado()
		{
			return $this->totalExplotado;
		}
		public function getExplotadoReal()
		{
			return $this->explotadoReal;
		}
		public function getPartidaDespachada()
		{
			return $this->partidaDespachada;
		}
		public function getMlDespachado()
		{
			return $this->mlDespachado;
		}
		public function getPartidaenvale()
		{
			return $this->partidaenvale;
		}
		public function getListo_para_producir()
		{
			return $this->listo_para_producir;
		}
		public function getDespachado()
		{
			return $this->despachado;
		}
		public function getFecha_despachado()
		{
			return $this->fecha_despachado;
		}
		public function getId_usuario_despachado()
		{
			return $this->id_usuario_despachado;
		}
		public function getIdSucursalDespachado()
		{
			return $this->idSucursalDespachado;
		}
		public function getPesoKiloML()
		{
			return $this->pesoKiloML;
		}
		public function getMolLaminasATomar()
		{
			return $this->molLaminasATomar;
		}
		public function getMolPrecioDobleces()
		{
			return $this->molPrecioDobleces;
		}
		public function getMolPrecioCorte()
		{
			return $this->molPrecioCorte;
		}
		public function getMolIsScrap()
		{
			return $this->molIsScrap;
		}
		public function getMolTotalcmScrap()
		{
			return $this->molTotalcmScrap;
		}
		public function getMolDescMaquila()
		{
			return $this->molDescMaquila;
		}
		public function getMolLongitudinal()
		{
			return $this->molLongitudinal;
		}
		public function getCostoProducto()
		{
			return $this->costoProducto;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPedidoDetalle=0;
			$this->IdPedido=0;
			$this->renglon=0;
			$this->idProducto=0;
			$this->idRolloBase=0;
			$this->tipoPrecio='PRECIO';
			$this->tipoPrecioOriginal='PRECIO';
			$this->comision='0.00';
			$this->comisionOriginal='0';
			$this->partida='0.00';
			$this->cantidad='0.00';
			$this->cantidadReal='0.00';
			$this->desarrollo='';
			$this->dobleces=0;
			$this->curvar='NO';
			$this->curvatura='';
			$this->precioUnitario='0.00';
			$this->precioUnitarioOriginal='0';
			$this->total='0';
			$this->explotarUnidad='0.00';
			$this->totalExplotar='0.00';
			$this->totalExplotado='0.00';
			$this->explotadoReal='0.00';
			$this->partidaDespachada='0';
			$this->mlDespachado='0.00';
			$this->partidaenvale='0.00';
			$this->listo_para_producir='NO';
			$this->despachado='NO';
			$this->fecha_despachado='0000-00-00 00:00:00';
			$this->id_usuario_despachado=0;
			$this->idSucursalDespachado=0;
			$this->pesoKiloML='0';
			$this->molLaminasATomar=0;
			$this->molPrecioDobleces='0.00';
			$this->molPrecioCorte='0.00';
			$this->molIsScrap='NO';
			$this->molTotalcmScrap='0.00';
			$this->molDescMaquila='';
			$this->molLongitudinal='L';
			$this->costoProducto='0';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (IdPedido,
				                                              renglon,
				                                              idProducto,
				                                              idRolloBase,
				                                              tipoPrecio,
				                                              tipoPrecioOriginal,
				                                              comision,
				                                              comisionOriginal,
				                                              partida,
				                                              cantidad,
				                                              cantidadReal,
				                                              desarrollo,
				                                              dobleces,
				                                              curvar,
				                                              curvatura,
				                                              precioUnitario,
				                                              precioUnitarioOriginal,
				                                              total,
				                                              explotarUnidad,
				                                              totalExplotar,
				                                              totalExplotado,
				                                              explotadoReal,
				                                              partidaDespachada,
				                                              mlDespachado,
				                                              partidaenvale,
				                                              listo_para_producir,
				                                              despachado,
				                                              fecha_despachado,
				                                              id_usuario_despachado,
				                                              idSucursalDespachado,
				                                              pesoKiloML,
				                                              molLaminasATomar,
				                                              molPrecioDobleces,
				                                              molPrecioCorte,
				                                              molIsScrap,
				                                              molTotalcmScrap,
				                                              molDescMaquila,
				                                              molLongitudinal,
				                                              costoProducto)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->IdPedido) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->renglon) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idRolloBase) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecioOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comision) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->partida) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->cantidadReal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->desarrollo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->dobleces) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->curvar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->curvatura) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precioUnitario) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precioUnitarioOriginal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->total) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->explotarUnidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalExplotar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalExplotado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->explotadoReal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->partidaDespachada) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->mlDespachado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->partidaenvale) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->listo_para_producir) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->despachado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_despachado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_despachado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->idSucursalDespachado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoKiloML) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molLaminasATomar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molPrecioDobleces) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molPrecioCorte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molIsScrap) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molTotalcmScrap) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molDescMaquila) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molLongitudinal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costoProducto) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidodetalle::Insertar]");
				
				$this->idPedidoDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET IdPedido='" . mysqli_real_escape_string($this->dbLink,$this->IdPedido) . "',
	                                              renglon='" . mysqli_real_escape_string($this->dbLink,$this->renglon) . "',
	                                              idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
	                                              idRolloBase='" . mysqli_real_escape_string($this->dbLink,$this->idRolloBase) . "',
	                                              tipoPrecio='" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
	                                              tipoPrecioOriginal='" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecioOriginal) . "',
	                                              comision='" . mysqli_real_escape_string($this->dbLink,$this->comision) . "',
	                                              comisionOriginal='" . mysqli_real_escape_string($this->dbLink,$this->comisionOriginal) . "',
	                                              partida='" . mysqli_real_escape_string($this->dbLink,$this->partida) . "',
	                                              cantidad='" . mysqli_real_escape_string($this->dbLink,$this->cantidad) . "',
	                                              cantidadReal='" . mysqli_real_escape_string($this->dbLink,$this->cantidadReal) . "',
	                                              desarrollo='" . mysqli_real_escape_string($this->dbLink,$this->desarrollo) . "',
	                                              dobleces='" . mysqli_real_escape_string($this->dbLink,$this->dobleces) . "',
	                                              curvar='" . mysqli_real_escape_string($this->dbLink,$this->curvar) . "',
	                                              curvatura='" . mysqli_real_escape_string($this->dbLink,$this->curvatura) . "',
	                                              precioUnitario='" . mysqli_real_escape_string($this->dbLink,$this->precioUnitario) . "',
	                                              precioUnitarioOriginal='" . mysqli_real_escape_string($this->dbLink,$this->precioUnitarioOriginal) . "',
	                                              total='" . mysqli_real_escape_string($this->dbLink,$this->total) . "',
	                                              explotarUnidad='" . mysqli_real_escape_string($this->dbLink,$this->explotarUnidad) . "',
	                                              totalExplotar='" . mysqli_real_escape_string($this->dbLink,$this->totalExplotar) . "',
	                                              totalExplotado='" . mysqli_real_escape_string($this->dbLink,$this->totalExplotado) . "',
	                                              explotadoReal='" . mysqli_real_escape_string($this->dbLink,$this->explotadoReal) . "',
	                                              partidaDespachada='" . mysqli_real_escape_string($this->dbLink,$this->partidaDespachada) . "',
	                                              mlDespachado='" . mysqli_real_escape_string($this->dbLink,$this->mlDespachado) . "',
	                                              partidaenvale='" . mysqli_real_escape_string($this->dbLink,$this->partidaenvale) . "',
	                                              listo_para_producir='" . mysqli_real_escape_string($this->dbLink,$this->listo_para_producir) . "',
	                                              despachado='" . mysqli_real_escape_string($this->dbLink,$this->despachado) . "',
	                                              fecha_despachado='" . mysqli_real_escape_string($this->dbLink,$this->fecha_despachado) . "',
	                                              id_usuario_despachado='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_despachado) . "',
	                                              idSucursalDespachado='" . mysqli_real_escape_string($this->dbLink,$this->idSucursalDespachado) . "',
	                                              pesoKiloML='" . mysqli_real_escape_string($this->dbLink,$this->pesoKiloML) . "',
	                                              molLaminasATomar='" . mysqli_real_escape_string($this->dbLink,$this->molLaminasATomar) . "',
	                                              molPrecioDobleces='" . mysqli_real_escape_string($this->dbLink,$this->molPrecioDobleces) . "',
	                                              molPrecioCorte='" . mysqli_real_escape_string($this->dbLink,$this->molPrecioCorte) . "',
	                                              molIsScrap='" . mysqli_real_escape_string($this->dbLink,$this->molIsScrap) . "',
	                                              molTotalcmScrap='" . mysqli_real_escape_string($this->dbLink,$this->molTotalcmScrap) . "',
	                                              molDescMaquila='" . mysqli_real_escape_string($this->dbLink,$this->molDescMaquila) . "',
	                                              molLongitudinal='" . mysqli_real_escape_string($this->dbLink,$this->molLongitudinal) . "',
	                                              costoProducto='" . mysqli_real_escape_string($this->dbLink,$this->costoProducto) . "'
					WHERE idPedidoDetalle=" . $this->idPedidoDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidodetalle::Update]");
				
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
				WHERE idPedidoDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePedidodetalle::Borrar]");
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
						idPedidoDetalle,
						IdPedido,
						renglon,
						idProducto,
						idRolloBase,
						tipoPrecio,
						tipoPrecioOriginal,
						comision,
						comisionOriginal,
						partida,
						cantidad,
						cantidadReal,
						desarrollo,
						dobleces,
						curvar,
						curvatura,
						precioUnitario,
						precioUnitarioOriginal,
						total,
						explotarUnidad,
						totalExplotar,
						totalExplotado,
						explotadoReal,
						partidaDespachada,
						mlDespachado,
						partidaenvale,
						listo_para_producir,
						despachado,
						fecha_despachado,
						id_usuario_despachado,
						idSucursalDespachado,
						pesoKiloML,
						molLaminasATomar,
						molPrecioDobleces,
						molPrecioCorte,
						molIsScrap,
						molTotalcmScrap,
						molDescMaquila,
						molLongitudinal,
						costoProducto
					FROM " . $this->__tableName . " 
					WHERE idPedidoDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idPedidoDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePedidodetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPedidoDetalle==0)
				$this->Insertar();
			else
			{
				$this->Actualizar();
				$this->AfterUpdate();
			}
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>