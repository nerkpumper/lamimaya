<?php

	class ModeloBaseCotizaciondetalle extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseCotizaciondetalle";

		
		var $idCotizacionDetalle=0;
		var $IdCotizacion=0;
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
		var $pesoKiloML='0';
		var $precio1='0.00';
		var $precio2='0.00';
		var $precio3='0.00';
		var $precio4='0.00';
		var $preciomendez='0.00';
		var $molLaminasATomar=0;
		var $molPrecioDobleces='0.00';
		var $molPrecioCorte='0.00';
		var $molIsScrap='NO';
		var $molTotalcmScrap='0.00';
		var $molDescMaquila='';
		var $molLongitudinal='L';
		var $molCalibre='';
		var $molIdMaterial=0;

		var $__s=array("idCotizacionDetalle",
                       "IdCotizacion",
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
                       "pesoKiloML",
                       "precio1",
                       "precio2",
                       "precio3",
                       "precio4",
                       "preciomendez",
                       "molLaminasATomar",
                       "molPrecioDobleces",
                       "molPrecioCorte",
                       "molIsScrap",
                       "molTotalcmScrap",
                       "molDescMaquila",
                       "molLongitudinal",
                       "molCalibre",
                       "molIdMaterial");
				
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

		
		public function setIdCotizacionDetalle($idCotizacionDetalle)
		{
			if($idCotizacionDetalle==0||$idCotizacionDetalle==""||!is_numeric($idCotizacionDetalle)|| (is_string($idCotizacionDetalle)&&!ctype_digit($idCotizacionDetalle)))return $this->setError("Tipo de dato incorrecto para idCotizacionDetalle.");
			$this->idCotizacionDetalle=$idCotizacionDetalle;
			$this->getDatos();
		}
		public function setIdCotizacion($IdCotizacion)
		{
			
			$this->IdCotizacion=$IdCotizacion;
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
		public function setPesoKiloML($pesoKiloML)
		{
			$this->pesoKiloML=$pesoKiloML;
		}
		public function setPrecio1($precio1)
		{
			$this->precio1=$precio1;
		}
		public function setPrecio2($precio2)
		{
			$this->precio2=$precio2;
		}
		public function setPrecio3($precio3)
		{
			$this->precio3=$precio3;
		}
		public function setPrecio4($precio4)
		{
			$this->precio4=$precio4;
		}
		public function setPreciomendez($preciomendez)
		{
			$this->preciomendez=$preciomendez;
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
		public function setMolCalibre($molCalibre)
		{
			
			$this->molCalibre=$molCalibre;
		}
		public function setMolIdMaterial($molIdMaterial)
		{
			
			$this->molIdMaterial=$molIdMaterial;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdCotizacionDetalle()
		{
			return $this->idCotizacionDetalle;
		}
		public function getIdCotizacion()
		{
			return $this->IdCotizacion;
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
		public function getPesoKiloML()
		{
			return $this->pesoKiloML;
		}
		public function getPrecio1()
		{
			return $this->precio1;
		}
		public function getPrecio2()
		{
			return $this->precio2;
		}
		public function getPrecio3()
		{
			return $this->precio3;
		}
		public function getPrecio4()
		{
			return $this->precio4;
		}
		public function getPreciomendez()
		{
			return $this->preciomendez;
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
		public function getMolCalibre()
		{
			return $this->molCalibre;
		}
		public function getMolIdMaterial()
		{
			return $this->molIdMaterial;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idCotizacionDetalle=0;
			$this->IdCotizacion=0;
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
			$this->pesoKiloML='0';
			$this->precio1='0.00';
			$this->precio2='0.00';
			$this->precio3='0.00';
			$this->precio4='0.00';
			$this->preciomendez='0.00';
			$this->molLaminasATomar=0;
			$this->molPrecioDobleces='0.00';
			$this->molPrecioCorte='0.00';
			$this->molIsScrap='NO';
			$this->molTotalcmScrap='0.00';
			$this->molDescMaquila='';
			$this->molLongitudinal='L';
			$this->molCalibre='';
			$this->molIdMaterial=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (IdCotizacion,
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
				                                              pesoKiloML,
				                                              precio1,
				                                              precio2,
				                                              precio3,
				                                              precio4,
				                                              preciomendez,
				                                              molLaminasATomar,
				                                              molPrecioDobleces,
				                                              molPrecioCorte,
				                                              molIsScrap,
				                                              molTotalcmScrap,
				                                              molDescMaquila,
				                                              molLongitudinal,
				                                              molCalibre,
				                                              molIdMaterial)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->IdCotizacion) . "',
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
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoKiloML) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->precio4) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->preciomendez) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molLaminasATomar) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molPrecioDobleces) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molPrecioCorte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molIsScrap) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molTotalcmScrap) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molDescMaquila) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molLongitudinal) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molCalibre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->molIdMaterial) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizaciondetalle::Insertar]");
				
				$this->idCotizacionDetalle=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET IdCotizacion='" . mysqli_real_escape_string($this->dbLink,$this->IdCotizacion) . "',
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
	                                              pesoKiloML='" . mysqli_real_escape_string($this->dbLink,$this->pesoKiloML) . "',
	                                              precio1='" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
	                                              precio2='" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
	                                              precio3='" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
	                                              precio4='" . mysqli_real_escape_string($this->dbLink,$this->precio4) . "',
	                                              preciomendez='" . mysqli_real_escape_string($this->dbLink,$this->preciomendez) . "',
	                                              molLaminasATomar='" . mysqli_real_escape_string($this->dbLink,$this->molLaminasATomar) . "',
	                                              molPrecioDobleces='" . mysqli_real_escape_string($this->dbLink,$this->molPrecioDobleces) . "',
	                                              molPrecioCorte='" . mysqli_real_escape_string($this->dbLink,$this->molPrecioCorte) . "',
	                                              molIsScrap='" . mysqli_real_escape_string($this->dbLink,$this->molIsScrap) . "',
	                                              molTotalcmScrap='" . mysqli_real_escape_string($this->dbLink,$this->molTotalcmScrap) . "',
	                                              molDescMaquila='" . mysqli_real_escape_string($this->dbLink,$this->molDescMaquila) . "',
	                                              molLongitudinal='" . mysqli_real_escape_string($this->dbLink,$this->molLongitudinal) . "',
	                                              molCalibre='" . mysqli_real_escape_string($this->dbLink,$this->molCalibre) . "',
	                                              molIdMaterial='" . mysqli_real_escape_string($this->dbLink,$this->molIdMaterial) . "'
					WHERE idCotizacionDetalle=" . $this->idCotizacionDetalle;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizaciondetalle::Update]");
				
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
				WHERE idCotizacionDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idCotizacionDetalle);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseCotizaciondetalle::Borrar]");
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
						idCotizacionDetalle,
						IdCotizacion,
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
						pesoKiloML,
						precio1,
						precio2,
						precio3,
						precio4,
						preciomendez,
						molLaminasATomar,
						molPrecioDobleces,
						molPrecioCorte,
						molIsScrap,
						molTotalcmScrap,
						molDescMaquila,
						molLongitudinal,
						molCalibre,
						molIdMaterial
					FROM " . $this->__tableName . " 
					WHERE idCotizacionDetalle=" . mysqli_real_escape_string($this->dbLink,$this->idCotizacionDetalle);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseCotizaciondetalle::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idCotizacionDetalle==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>