<?php

	class ModeloBaseViewrollos extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseViewrollos";

		
		var $idRollo=0;
		var $codigo='';
		var $idMaterial=0;
		var $material='';
		var $shortMaterial='';
		var $idProveedor=0;
		var $proveedor='';
		var $shortProveedor='';
		var $idColor=0;
		var $color='';
		var $shortColor='';
		var $calibre=0;
		var $pies=0;
		var $pesokiloml='';
		var $origen='N';
		var $grado=0;
		var $existencia='';
		var $apartado='';
		var $descripcion='';
		var $descauto='';
		var $observaciones='';
		var $estado='ACTIVO';
		var $iva='';
		var $prodmes='';
		var $porutilidad='';
		var $porcomision='';
		var $descuento='';
		var $costoflete='';
		var $costokg='';
		var $pesokgmt='';
		var $pesocu='';
		var $pesoimporte='';
		var $pesoparti='';
		var $fmod='';
		var $moi='';
		var $gastosfab='';
		var $comisiones='';
		var $gastosventa='';
		var $gastosfinancieros='';
		var $gastosadmon='';
		var $modiva='';
		var $moiiva='';
		var $gastosfabiva='';
		var $comisionesiva='';
		var $gastosventaiva='';
		var $gastosfinancierosiva='';
		var $gastosadmoniva='';
		var $modparti='';
		var $moiparti='';
		var $gastosfabparti='';
		var $comisionesparti='';
		var $gastosventaparti='';
		var $gastosfinancierosparti='';
		var $gastosadmonparti='';
		var $totalessumames='';
		var $totalessumkg='';
		var $totalespeso='';
		var $totalesfab='';
		var $totalcostofab='';
		var $totalpreciovta='';
		var $totalpreciovtar2='';
		var $totalpreciovtar3='';

		var $__s=array("idRollo",
                       "codigo",
                       "idMaterial",
                       "material",
                       "shortMaterial",
                       "idProveedor",
                       "proveedor",
                       "shortProveedor",
                       "idColor",
                       "color",
                       "shortColor",
                       "calibre",
                       "pies",
                       "pesokiloml",
                       "origen",
                       "grado",
                       "existencia",
                       "apartado",
                       "descripcion",
                       "descauto",
                       "observaciones",
                       "estado",
                       "iva",
                       "prodmes",
                       "porutilidad",
                       "porcomision",
                       "descuento",
                       "costoflete",
                       "costokg",
                       "pesokgmt",
                       "pesocu",
                       "pesoimporte",
                       "pesoparti",
                       "fmod",
                       "moi",
                       "gastosfab",
                       "comisiones",
                       "gastosventa",
                       "gastosfinancieros",
                       "gastosadmon",
                       "modiva",
                       "moiiva",
                       "gastosfabiva",
                       "comisionesiva",
                       "gastosventaiva",
                       "gastosfinancierosiva",
                       "gastosadmoniva",
                       "modparti",
                       "moiparti",
                       "gastosfabparti",
                       "comisionesparti",
                       "gastosventaparti",
                       "gastosfinancierosparti",
                       "gastosadmonparti",
                       "totalessumames",
                       "totalessumkg",
                       "totalespeso",
                       "totalesfab",
                       "totalcostofab",
                       "totalpreciovta",
                       "totalpreciovtar2",
                       "totalpreciovtar3");
				
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

		
		public function setIdRollo($idRollo)
		{
			
			$this->idRollo=$idRollo;
		}
		public function setCodigo($codigo)
		{
			
			$this->codigo=$codigo;
		}
		public function setIdMaterial($idMaterial)
		{
			
			$this->idMaterial=$idMaterial;
		}
		public function setMaterial($material)
		{
			
			$this->material=$material;
		}
		public function setShortMaterial($shortMaterial)
		{
			
			$this->shortMaterial=$shortMaterial;
		}
		public function setIdProveedor($idProveedor)
		{
			
			$this->idProveedor=$idProveedor;
		}
		public function setProveedor($proveedor)
		{
			
			$this->proveedor=$proveedor;
		}
		public function setShortProveedor($shortProveedor)
		{
			
			$this->shortProveedor=$shortProveedor;
		}
		public function setIdColor($idColor)
		{
			
			$this->idColor=$idColor;
		}
		public function setColor($color)
		{
			
			$this->color=$color;
		}
		public function setShortColor($shortColor)
		{
			
			$this->shortColor=$shortColor;
		}
		public function setCalibre($calibre)
		{
			
			$this->calibre=$calibre;
		}
		public function setPies($pies)
		{
			
			$this->pies=$pies;
		}
		public function setPesokiloml($pesokiloml)
		{
			$this->pesokiloml=$pesokiloml;
		}
		public function setOrigen($origen)
		{
			
			$this->origen=$origen;
		}
		public function setOrigenI()
		{
			$this->origen='I';
		}
		public function setOrigenN()
		{
			$this->origen='N';
		}
		public function setGrado($grado)
		{
			
			$this->grado=$grado;
		}
		public function setExistencia($existencia)
		{
			$this->existencia=$existencia;
		}
		public function setApartado($apartado)
		{
			$this->apartado=$apartado;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setDescauto($descauto)
		{
			
			$this->descauto=$descauto;
		}
		public function setObservaciones($observaciones)
		{
			
			$this->observaciones=$observaciones;
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
		public function setIva($iva)
		{
			$this->iva=$iva;
		}
		public function setProdmes($prodmes)
		{
			$this->prodmes=$prodmes;
		}
		public function setPorutilidad($porutilidad)
		{
			$this->porutilidad=$porutilidad;
		}
		public function setPorcomision($porcomision)
		{
			$this->porcomision=$porcomision;
		}
		public function setDescuento($descuento)
		{
			$this->descuento=$descuento;
		}
		public function setCostoflete($costoflete)
		{
			$this->costoflete=$costoflete;
		}
		public function setCostokg($costokg)
		{
			$this->costokg=$costokg;
		}
		public function setPesokgmt($pesokgmt)
		{
			$this->pesokgmt=$pesokgmt;
		}
		public function setPesocu($pesocu)
		{
			$this->pesocu=$pesocu;
		}
		public function setPesoimporte($pesoimporte)
		{
			$this->pesoimporte=$pesoimporte;
		}
		public function setPesoparti($pesoparti)
		{
			$this->pesoparti=$pesoparti;
		}
		public function setFmod($fmod)
		{
			$this->fmod=$fmod;
		}
		public function setMoi($moi)
		{
			$this->moi=$moi;
		}
		public function setGastosfab($gastosfab)
		{
			$this->gastosfab=$gastosfab;
		}
		public function setComisiones($comisiones)
		{
			$this->comisiones=$comisiones;
		}
		public function setGastosventa($gastosventa)
		{
			$this->gastosventa=$gastosventa;
		}
		public function setGastosfinancieros($gastosfinancieros)
		{
			$this->gastosfinancieros=$gastosfinancieros;
		}
		public function setGastosadmon($gastosadmon)
		{
			$this->gastosadmon=$gastosadmon;
		}
		public function setModiva($modiva)
		{
			$this->modiva=$modiva;
		}
		public function setMoiiva($moiiva)
		{
			$this->moiiva=$moiiva;
		}
		public function setGastosfabiva($gastosfabiva)
		{
			$this->gastosfabiva=$gastosfabiva;
		}
		public function setComisionesiva($comisionesiva)
		{
			$this->comisionesiva=$comisionesiva;
		}
		public function setGastosventaiva($gastosventaiva)
		{
			$this->gastosventaiva=$gastosventaiva;
		}
		public function setGastosfinancierosiva($gastosfinancierosiva)
		{
			$this->gastosfinancierosiva=$gastosfinancierosiva;
		}
		public function setGastosadmoniva($gastosadmoniva)
		{
			$this->gastosadmoniva=$gastosadmoniva;
		}
		public function setModparti($modparti)
		{
			$this->modparti=$modparti;
		}
		public function setMoiparti($moiparti)
		{
			$this->moiparti=$moiparti;
		}
		public function setGastosfabparti($gastosfabparti)
		{
			$this->gastosfabparti=$gastosfabparti;
		}
		public function setComisionesparti($comisionesparti)
		{
			$this->comisionesparti=$comisionesparti;
		}
		public function setGastosventaparti($gastosventaparti)
		{
			$this->gastosventaparti=$gastosventaparti;
		}
		public function setGastosfinancierosparti($gastosfinancierosparti)
		{
			$this->gastosfinancierosparti=$gastosfinancierosparti;
		}
		public function setGastosadmonparti($gastosadmonparti)
		{
			$this->gastosadmonparti=$gastosadmonparti;
		}
		public function setTotalessumames($totalessumames)
		{
			$this->totalessumames=$totalessumames;
		}
		public function setTotalessumkg($totalessumkg)
		{
			$this->totalessumkg=$totalessumkg;
		}
		public function setTotalespeso($totalespeso)
		{
			$this->totalespeso=$totalespeso;
		}
		public function setTotalesfab($totalesfab)
		{
			$this->totalesfab=$totalesfab;
		}
		public function setTotalcostofab($totalcostofab)
		{
			$this->totalcostofab=$totalcostofab;
		}
		public function setTotalpreciovta($totalpreciovta)
		{
			$this->totalpreciovta=$totalpreciovta;
		}
		public function setTotalpreciovtar2($totalpreciovtar2)
		{
			$this->totalpreciovtar2=$totalpreciovtar2;
		}
		public function setTotalpreciovtar3($totalpreciovtar3)
		{
			$this->totalpreciovtar3=$totalpreciovtar3;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdRollo()
		{
			return $this->idRollo;
		}
		public function getCodigo()
		{
			return $this->codigo;
		}
		public function getIdMaterial()
		{
			return $this->idMaterial;
		}
		public function getMaterial()
		{
			return $this->material;
		}
		public function getShortMaterial()
		{
			return $this->shortMaterial;
		}
		public function getIdProveedor()
		{
			return $this->idProveedor;
		}
		public function getProveedor()
		{
			return $this->proveedor;
		}
		public function getShortProveedor()
		{
			return $this->shortProveedor;
		}
		public function getIdColor()
		{
			return $this->idColor;
		}
		public function getColor()
		{
			return $this->color;
		}
		public function getShortColor()
		{
			return $this->shortColor;
		}
		public function getCalibre()
		{
			return $this->calibre;
		}
		public function getPies()
		{
			return $this->pies;
		}
		public function getPesokiloml()
		{
			return $this->pesokiloml;
		}
		public function getOrigen()
		{
			return $this->origen;
		}
		public function getGrado()
		{
			return $this->grado;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}
		public function getApartado()
		{
			return $this->apartado;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getDescauto()
		{
			return $this->descauto;
		}
		public function getObservaciones()
		{
			return $this->observaciones;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getIva()
		{
			return $this->iva;
		}
		public function getProdmes()
		{
			return $this->prodmes;
		}
		public function getPorutilidad()
		{
			return $this->porutilidad;
		}
		public function getPorcomision()
		{
			return $this->porcomision;
		}
		public function getDescuento()
		{
			return $this->descuento;
		}
		public function getCostoflete()
		{
			return $this->costoflete;
		}
		public function getCostokg()
		{
			return $this->costokg;
		}
		public function getPesokgmt()
		{
			return $this->pesokgmt;
		}
		public function getPesocu()
		{
			return $this->pesocu;
		}
		public function getPesoimporte()
		{
			return $this->pesoimporte;
		}
		public function getPesoparti()
		{
			return $this->pesoparti;
		}
		public function getFmod()
		{
			return $this->fmod;
		}
		public function getMoi()
		{
			return $this->moi;
		}
		public function getGastosfab()
		{
			return $this->gastosfab;
		}
		public function getComisiones()
		{
			return $this->comisiones;
		}
		public function getGastosventa()
		{
			return $this->gastosventa;
		}
		public function getGastosfinancieros()
		{
			return $this->gastosfinancieros;
		}
		public function getGastosadmon()
		{
			return $this->gastosadmon;
		}
		public function getModiva()
		{
			return $this->modiva;
		}
		public function getMoiiva()
		{
			return $this->moiiva;
		}
		public function getGastosfabiva()
		{
			return $this->gastosfabiva;
		}
		public function getComisionesiva()
		{
			return $this->comisionesiva;
		}
		public function getGastosventaiva()
		{
			return $this->gastosventaiva;
		}
		public function getGastosfinancierosiva()
		{
			return $this->gastosfinancierosiva;
		}
		public function getGastosadmoniva()
		{
			return $this->gastosadmoniva;
		}
		public function getModparti()
		{
			return $this->modparti;
		}
		public function getMoiparti()
		{
			return $this->moiparti;
		}
		public function getGastosfabparti()
		{
			return $this->gastosfabparti;
		}
		public function getComisionesparti()
		{
			return $this->comisionesparti;
		}
		public function getGastosventaparti()
		{
			return $this->gastosventaparti;
		}
		public function getGastosfinancierosparti()
		{
			return $this->gastosfinancierosparti;
		}
		public function getGastosadmonparti()
		{
			return $this->gastosadmonparti;
		}
		public function getTotalessumames()
		{
			return $this->totalessumames;
		}
		public function getTotalessumkg()
		{
			return $this->totalessumkg;
		}
		public function getTotalespeso()
		{
			return $this->totalespeso;
		}
		public function getTotalesfab()
		{
			return $this->totalesfab;
		}
		public function getTotalcostofab()
		{
			return $this->totalcostofab;
		}
		public function getTotalpreciovta()
		{
			return $this->totalpreciovta;
		}
		public function getTotalpreciovtar2()
		{
			return $this->totalpreciovtar2;
		}
		public function getTotalpreciovtar3()
		{
			return $this->totalpreciovtar3;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idRollo=0;
			$this->codigo='';
			$this->idMaterial=0;
			$this->material='';
			$this->shortMaterial='';
			$this->idProveedor=0;
			$this->proveedor='';
			$this->shortProveedor='';
			$this->idColor=0;
			$this->color='';
			$this->shortColor='';
			$this->calibre=0;
			$this->pies=0;
			$this->pesokiloml='';
			$this->origen='N';
			$this->grado=0;
			$this->existencia='';
			$this->apartado='';
			$this->descripcion='';
			$this->descauto='';
			$this->observaciones='';
			$this->estado='ACTIVO';
			$this->iva='';
			$this->prodmes='';
			$this->porutilidad='';
			$this->porcomision='';
			$this->descuento='';
			$this->costoflete='';
			$this->costokg='';
			$this->pesokgmt='';
			$this->pesocu='';
			$this->pesoimporte='';
			$this->pesoparti='';
			$this->fmod='';
			$this->moi='';
			$this->gastosfab='';
			$this->comisiones='';
			$this->gastosventa='';
			$this->gastosfinancieros='';
			$this->gastosadmon='';
			$this->modiva='';
			$this->moiiva='';
			$this->gastosfabiva='';
			$this->comisionesiva='';
			$this->gastosventaiva='';
			$this->gastosfinancierosiva='';
			$this->gastosadmoniva='';
			$this->modparti='';
			$this->moiparti='';
			$this->gastosfabparti='';
			$this->comisionesparti='';
			$this->gastosventaparti='';
			$this->gastosfinancierosparti='';
			$this->gastosadmonparti='';
			$this->totalessumames='';
			$this->totalessumkg='';
			$this->totalespeso='';
			$this->totalesfab='';
			$this->totalcostofab='';
			$this->totalpreciovta='';
			$this->totalpreciovtar2='';
			$this->totalpreciovtar3='';
		}

		

		
// 		protected function Insertar()
// 		{
// 			try
// 			{
// 				$SQL="INSERT INTO " . $this->__tableName . " (idRollo,
// 				                                              codigo,
// 				                                              idMaterial,
// 				                                              material,
// 				                                              shortMaterial,
// 				                                              idProveedor,
// 				                                              proveedor,
// 				                                              shortProveedor,
// 				                                              idColor,
// 				                                              color,
// 				                                              shortColor,
// 				                                              calibre,
// 				                                              pies,
// 				                                              pesokiloml,
// 				                                              origen,
// 				                                              grado,
// 				                                              existencia,
// 				                                              apartado,
// 				                                              descripcion,
// 				                                              descauto,
// 				                                              observaciones,
// 				                                              estado,
// 				                                              iva,
// 				                                              prodmes,
// 				                                              porutilidad,
// 				                                              porcomision,
// 				                                              descuento,
// 				                                              costoflete,
// 				                                              costokg,
// 				                                              pesokgmt,
// 				                                              pesocu,
// 				                                              pesoimporte,
// 				                                              pesoparti,
// 				                                              fmod,
// 				                                              moi,
// 				                                              gastosfab,
// 				                                              comisiones,
// 				                                              gastosventa,
// 				                                              gastosfinancieros,
// 				                                              gastosadmon,
// 				                                              modiva,
// 				                                              moiiva,
// 				                                              gastosfabiva,
// 				                                              comisionesiva,
// 				                                              gastosventaiva,
// 				                                              gastosfinancierosiva,
// 				                                              gastosadmoniva,
// 				                                              modparti,
// 				                                              moiparti,
// 				                                              gastosfabparti,
// 				                                              comisionesparti,
// 				                                              gastosventaparti,
// 				                                              gastosfinancierosparti,
// 				                                              gastosadmonparti,
// 				                                              totalessumames,
// 				                                              totalessumkg,
// 				                                              totalespeso,
// 				                                              totalesfab,
// 				                                              totalcostofab,
// 				                                              totalpreciovta,
// 				                                              totalpreciovtar2,
// 				                                              totalpreciovtar3)
// 						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idRollo) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idMaterial) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->material) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->shortMaterial) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idProveedor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->proveedor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->shortProveedor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idColor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->color) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->shortColor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pesokiloml) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->origen) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->grado) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->descauto) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->iva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->prodmes) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->porutilidad) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->porcomision) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->descuento) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->costoflete) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->costokg) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pesokgmt) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pesocu) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoimporte) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->fmod) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->moi) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfab) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->comisiones) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosventa) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancieros) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosadmon) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->modiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->moiiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfabiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionesiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosventaiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosadmoniva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->modparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->moiparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfabparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionesparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosventaparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosadmonparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalessumames) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalessumkg) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalespeso) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalesfab) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalcostofab) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovta) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar2) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar3) . "')";
// 				$result=mysqli_query($this->dbLink,$SQL);
// 				if(!$result)
// 					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseViewrollos::Insertar]");
				
// 				$this->=mysqli_insert_id($this->dbLink);
// 				return true;
// 			}
// 			catch (Exception $e)
// 			{
// 				return $this->setErrorCatch($e);
// 			}
// 		}
		

		
// 		protected function Actualizar()
// 		{
// 			try
// 			{
// 				$SQL="UPDATE " . $this->__tableName . " SET idRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRollo) . "',
// 	                                              codigo='" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
// 	                                              idMaterial='" . mysqli_real_escape_string($this->dbLink,$this->idMaterial) . "',
// 	                                              material='" . mysqli_real_escape_string($this->dbLink,$this->material) . "',
// 	                                              shortMaterial='" . mysqli_real_escape_string($this->dbLink,$this->shortMaterial) . "',
// 	                                              idProveedor='" . mysqli_real_escape_string($this->dbLink,$this->idProveedor) . "',
// 	                                              proveedor='" . mysqli_real_escape_string($this->dbLink,$this->proveedor) . "',
// 	                                              shortProveedor='" . mysqli_real_escape_string($this->dbLink,$this->shortProveedor) . "',
// 	                                              idColor='" . mysqli_real_escape_string($this->dbLink,$this->idColor) . "',
// 	                                              color='" . mysqli_real_escape_string($this->dbLink,$this->color) . "',
// 	                                              shortColor='" . mysqli_real_escape_string($this->dbLink,$this->shortColor) . "',
// 	                                              calibre='" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
// 	                                              pies='" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
// 	                                              pesokiloml='" . mysqli_real_escape_string($this->dbLink,$this->pesokiloml) . "',
// 	                                              origen='" . mysqli_real_escape_string($this->dbLink,$this->origen) . "',
// 	                                              grado='" . mysqli_real_escape_string($this->dbLink,$this->grado) . "',
// 	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
// 	                                              apartado='" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
// 	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
// 	                                              descauto='" . mysqli_real_escape_string($this->dbLink,$this->descauto) . "',
// 	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
// 	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
// 	                                              iva='" . mysqli_real_escape_string($this->dbLink,$this->iva) . "',
// 	                                              prodmes='" . mysqli_real_escape_string($this->dbLink,$this->prodmes) . "',
// 	                                              porutilidad='" . mysqli_real_escape_string($this->dbLink,$this->porutilidad) . "',
// 	                                              porcomision='" . mysqli_real_escape_string($this->dbLink,$this->porcomision) . "',
// 	                                              descuento='" . mysqli_real_escape_string($this->dbLink,$this->descuento) . "',
// 	                                              costoflete='" . mysqli_real_escape_string($this->dbLink,$this->costoflete) . "',
// 	                                              costokg='" . mysqli_real_escape_string($this->dbLink,$this->costokg) . "',
// 	                                              pesokgmt='" . mysqli_real_escape_string($this->dbLink,$this->pesokgmt) . "',
// 	                                              pesocu='" . mysqli_real_escape_string($this->dbLink,$this->pesocu) . "',
// 	                                              pesoimporte='" . mysqli_real_escape_string($this->dbLink,$this->pesoimporte) . "',
// 	                                              pesoparti='" . mysqli_real_escape_string($this->dbLink,$this->pesoparti) . "',
// 	                                              fmod='" . mysqli_real_escape_string($this->dbLink,$this->fmod) . "',
// 	                                              moi='" . mysqli_real_escape_string($this->dbLink,$this->moi) . "',
// 	                                              gastosfab='" . mysqli_real_escape_string($this->dbLink,$this->gastosfab) . "',
// 	                                              comisiones='" . mysqli_real_escape_string($this->dbLink,$this->comisiones) . "',
// 	                                              gastosventa='" . mysqli_real_escape_string($this->dbLink,$this->gastosventa) . "',
// 	                                              gastosfinancieros='" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancieros) . "',
// 	                                              gastosadmon='" . mysqli_real_escape_string($this->dbLink,$this->gastosadmon) . "',
// 	                                              modiva='" . mysqli_real_escape_string($this->dbLink,$this->modiva) . "',
// 	                                              moiiva='" . mysqli_real_escape_string($this->dbLink,$this->moiiva) . "',
// 	                                              gastosfabiva='" . mysqli_real_escape_string($this->dbLink,$this->gastosfabiva) . "',
// 	                                              comisionesiva='" . mysqli_real_escape_string($this->dbLink,$this->comisionesiva) . "',
// 	                                              gastosventaiva='" . mysqli_real_escape_string($this->dbLink,$this->gastosventaiva) . "',
// 	                                              gastosfinancierosiva='" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosiva) . "',
// 	                                              gastosadmoniva='" . mysqli_real_escape_string($this->dbLink,$this->gastosadmoniva) . "',
// 	                                              modparti='" . mysqli_real_escape_string($this->dbLink,$this->modparti) . "',
// 	                                              moiparti='" . mysqli_real_escape_string($this->dbLink,$this->moiparti) . "',
// 	                                              gastosfabparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosfabparti) . "',
// 	                                              comisionesparti='" . mysqli_real_escape_string($this->dbLink,$this->comisionesparti) . "',
// 	                                              gastosventaparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosventaparti) . "',
// 	                                              gastosfinancierosparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosparti) . "',
// 	                                              gastosadmonparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosadmonparti) . "',
// 	                                              totalessumames='" . mysqli_real_escape_string($this->dbLink,$this->totalessumames) . "',
// 	                                              totalessumkg='" . mysqli_real_escape_string($this->dbLink,$this->totalessumkg) . "',
// 	                                              totalespeso='" . mysqli_real_escape_string($this->dbLink,$this->totalespeso) . "',
// 	                                              totalesfab='" . mysqli_real_escape_string($this->dbLink,$this->totalesfab) . "',
// 	                                              totalcostofab='" . mysqli_real_escape_string($this->dbLink,$this->totalcostofab) . "',
// 	                                              totalpreciovta='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovta) . "',
// 	                                              totalpreciovtar2='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar2) . "',
// 	                                              totalpreciovtar3='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar3) . "'
// 					WHERE =" . $this->;
				
// 				$result=mysqli_query($this->dbLink,$SQL);
// 				if(!$result)
// 					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseViewrollos::Update]");
				
// 				return true;
// 			}
// 			catch (Exception $e)
// 			{
// 				return $this->setErrorCatch($e);
// 			}
// 		}
		

		
// 		public function Borrar()
// 		{
// 			if($this->getError())
// 				return false;
// 			try
// 			{
// 				$SQL="DELETE FROM " . $this->__tableName . "
// 				WHERE =" . mysqli_real_escape_string($this->dbLink,$this->);
// 				$result=mysqli_query($this->dbLink,$SQL);
// 				if(!$result)
// 					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseViewrollos::Borrar]");
// 			}
// 			catch (Exception $e)
// 			{
// 				return $this->setErrorCatch($e);
// 			}
// 		}
		

		
		public function getDatos()
		{
			try
			{
				$SQL="SELECT
						idRollo,
						codigo,
						idMaterial,
						material,
						shortMaterial,
						idProveedor,
						proveedor,
						shortProveedor,
						idColor,
						color,
						shortColor,
						calibre,
						pies,
						pesokiloml,
						origen,
						grado,
						existencia,
						apartado,
						descripcion,
						descauto,
						observaciones,
						estado,
						iva,
						prodmes,
						porutilidad,
						porcomision,
						descuento,
						costoflete,
						costokg,
						pesokgmt,
						pesocu,
						pesoimporte,
						pesoparti,
						fmod,
						moi,
						gastosfab,
						comisiones,
						gastosventa,
						gastosfinancieros,
						gastosadmon,
						modiva,
						moiiva,
						gastosfabiva,
						comisionesiva,
						gastosventaiva,
						gastosfinancierosiva,
						gastosadmoniva,
						modparti,
						moiparti,
						gastosfabparti,
						comisionesparti,
						gastosventaparti,
						gastosfinancierosparti,
						gastosadmonparti,
						totalessumames,
						totalessumkg,
						totalespeso,
						totalesfab,
						totalcostofab,
						totalpreciovta,
						totalpreciovtar2,
						totalpreciovtar3
					FROM " . $this->__tableName . " 
					WHERE idRollo =" . mysqli_real_escape_string($this->dbLink,$this->idRollo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseViewrollos::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idRollo==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>