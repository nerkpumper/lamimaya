<?php

	class ModeloBaseRollo extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseRollo";

		
		var $idRollo=0;
		var $codigo='';
		var $rollo_material_idMaterial=0;
		var $calibre=0;
		var $pies='0.00';
		var $origen='N';
		var $rollo_proveedor_idProveedor=0;
		var $grado=0;
		var $rollo_color_idColor=0;
		var $descripcion='0';
		var $observaciones='0';
		var $estado='ACTIVO';
		var $fecha_creacion='0000-00-00 00:00:00';
		var $id_usuario_creacion=0;
		var $fecha_modifica='0000-00-00 00:00:00';
		var $id_usuario_modifica=0;
		var $fecha_baja='0000-00-00 00:00:00';
		var $id_usuario_baja=0;
		var $existencia='0.00';
		var $apartado='0.00';
		var $iva='0.00';
		var $prodmes='0.00';
		var $porutilidad='0.00';
		var $porcomision='0.00';
		var $descuento='0.00';
		var $costoflete='0.00';
		var $costokg='0.00';
		var $pesokgmt='0.00';
		var $pesocu='0.00';
		var $pesoimporte='0.00';
		var $pesoparti='0.00';
		var $fmod='0.00';
		var $moi='0.00';
		var $gastosfab='0.00';
		var $comisiones='0.00';
		var $gastosventa='0.00';
		var $gastosfinancieros='0.00';
		var $gastosadmon='0.00';
		var $modiva='0.00';
		var $moiiva='0.00';
		var $gastosfabiva='0.00';
		var $comisionesiva='0.00';
		var $gastosventaiva='0.00';
		var $gastosfinancierosiva='0.00';
		var $gastosadmoniva='0.00';
		var $modparti='0.00';
		var $moiparti='0.00';
		var $gastosfabparti='0.00';
		var $comisionesparti='0.00';
		var $gastosventaparti='0.00';
		var $gastosfinancierosparti='0.00';
		var $gastosadmonparti='0.00';
		var $totalessummes='0.00';
		var $totalessumkg='0.00';
		var $totalespeso='0.00';
		var $totalesfab='0.00';
		var $totalcostofab='0.00';
		var $totalpreciovta='0.00';
		var $totalpreciovtar2='0.00';
		var $totalpreciovtar3='0.00';
		var $totalpreciomendez='0.00';
		var $lastUpdate='';

		var $__s=array("idRollo",
                       "codigo",
                       "rollo_material_idMaterial",
                       "calibre",
                       "pies",
                       "origen",
                       "rollo_proveedor_idProveedor",
                       "grado",
                       "rollo_color_idColor",
                       "descripcion",
                       "observaciones",
                       "estado",
                       "fecha_creacion",
                       "id_usuario_creacion",
                       "fecha_modifica",
                       "id_usuario_modifica",
                       "fecha_baja",
                       "id_usuario_baja",
                       "existencia",
                       "apartado",
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
                       "totalessummes",
                       "totalessumkg",
                       "totalespeso",
                       "totalesfab",
                       "totalcostofab",
                       "totalpreciovta",
                       "totalpreciovtar2",
                       "totalpreciovtar3",
                       "totalpreciomendez",
                       "lastUpdate");
				
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
			if($idRollo==0||$idRollo==""||!is_numeric($idRollo)|| (is_string($idRollo)&&!ctype_digit($idRollo)))return $this->setError("Tipo de dato incorrecto para idRollo.");
			$this->idRollo=$idRollo;
			$this->getDatos();
		}
		public function setCodigo($codigo)
		{
			
			$this->codigo=$codigo;
		}
		public function setRollo_material_idMaterial($rollo_material_idMaterial)
		{
			
			$this->rollo_material_idMaterial=$rollo_material_idMaterial;
		}
		public function setCalibre($calibre)
		{
			
			$this->calibre=$calibre;
		}
		public function setPies($pies)
		{
			$this->pies=$pies;
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
		public function setRollo_proveedor_idProveedor($rollo_proveedor_idProveedor)
		{
			
			$this->rollo_proveedor_idProveedor=$rollo_proveedor_idProveedor;
		}
		public function setGrado($grado)
		{
			
			$this->grado=$grado;
		}
		public function setRollo_color_idColor($rollo_color_idColor)
		{
			
			$this->rollo_color_idColor=$rollo_color_idColor;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
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
		public function setFecha_creacion($fecha_creacion)
		{
			$this->fecha_creacion=$fecha_creacion;
		}
		public function setId_usuario_creacion($id_usuario_creacion)
		{
			
			$this->id_usuario_creacion=$id_usuario_creacion;
		}
		public function setFecha_modifica($fecha_modifica)
		{
			$this->fecha_modifica=$fecha_modifica;
		}
		public function setId_usuario_modifica($id_usuario_modifica)
		{
			
			$this->id_usuario_modifica=$id_usuario_modifica;
		}
		public function setFecha_baja($fecha_baja)
		{
			$this->fecha_baja=$fecha_baja;
		}
		public function setId_usuario_baja($id_usuario_baja)
		{
			
			$this->id_usuario_baja=$id_usuario_baja;
		}
		public function setExistencia($existencia)
		{
			$this->existencia=$existencia;
		}
		public function setApartado($apartado)
		{
			$this->apartado=$apartado;
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
		public function setTotalessummes($totalessummes)
		{
			$this->totalessummes=$totalessummes;
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
		public function setTotalpreciomendez($totalpreciomendez)
		{
			$this->totalpreciomendez=$totalpreciomendez;
		}
		public function setLastUpdate($lastUpdate)
		{
			$this->lastUpdate=$lastUpdate;
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
		public function getRollo_material_idMaterial()
		{
			return $this->rollo_material_idMaterial;
		}
		public function getCalibre()
		{
			return $this->calibre;
		}
		public function getPies()
		{
			return $this->pies;
		}
		public function getOrigen()
		{
			return $this->origen;
		}
		public function getRollo_proveedor_idProveedor()
		{
			return $this->rollo_proveedor_idProveedor;
		}
		public function getGrado()
		{
			return $this->grado;
		}
		public function getRollo_color_idColor()
		{
			return $this->rollo_color_idColor;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getObservaciones()
		{
			return $this->observaciones;
		}
		public function getEstado()
		{
			return $this->estado;
		}
		public function getFecha_creacion()
		{
			return $this->fecha_creacion;
		}
		public function getId_usuario_creacion()
		{
			return $this->id_usuario_creacion;
		}
		public function getFecha_modifica()
		{
			return $this->fecha_modifica;
		}
		public function getId_usuario_modifica()
		{
			return $this->id_usuario_modifica;
		}
		public function getFecha_baja()
		{
			return $this->fecha_baja;
		}
		public function getId_usuario_baja()
		{
			return $this->id_usuario_baja;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}
		public function getApartado()
		{
			return $this->apartado;
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
		public function getTotalessummes()
		{
			return $this->totalessummes;
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
		public function getTotalpreciomendez()
		{
			return $this->totalpreciomendez;
		}
		public function getLastUpdate()
		{
			return $this->lastUpdate;
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
			$this->rollo_material_idMaterial=0;
			$this->calibre=0;
			$this->pies='0.00';
			$this->origen='N';
			$this->rollo_proveedor_idProveedor=0;
			$this->grado=0;
			$this->rollo_color_idColor=0;
			$this->descripcion='0';
			$this->observaciones='0';
			$this->estado='ACTIVO';
			$this->fecha_creacion='0000-00-00 00:00:00';
			$this->id_usuario_creacion=0;
			$this->fecha_modifica='0000-00-00 00:00:00';
			$this->id_usuario_modifica=0;
			$this->fecha_baja='0000-00-00 00:00:00';
			$this->id_usuario_baja=0;
			$this->existencia='0.00';
			$this->apartado='0.00';
			$this->iva='0.00';
			$this->prodmes='0.00';
			$this->porutilidad='0.00';
			$this->porcomision='0.00';
			$this->descuento='0.00';
			$this->costoflete='0.00';
			$this->costokg='0.00';
			$this->pesokgmt='0.00';
			$this->pesocu='0.00';
			$this->pesoimporte='0.00';
			$this->pesoparti='0.00';
			$this->fmod='0.00';
			$this->moi='0.00';
			$this->gastosfab='0.00';
			$this->comisiones='0.00';
			$this->gastosventa='0.00';
			$this->gastosfinancieros='0.00';
			$this->gastosadmon='0.00';
			$this->modiva='0.00';
			$this->moiiva='0.00';
			$this->gastosfabiva='0.00';
			$this->comisionesiva='0.00';
			$this->gastosventaiva='0.00';
			$this->gastosfinancierosiva='0.00';
			$this->gastosadmoniva='0.00';
			$this->modparti='0.00';
			$this->moiparti='0.00';
			$this->gastosfabparti='0.00';
			$this->comisionesparti='0.00';
			$this->gastosventaparti='0.00';
			$this->gastosfinancierosparti='0.00';
			$this->gastosadmonparti='0.00';
			$this->totalessummes='0.00';
			$this->totalessumkg='0.00';
			$this->totalespeso='0.00';
			$this->totalesfab='0.00';
			$this->totalcostofab='0.00';
			$this->totalpreciovta='0.00';
			$this->totalpreciovtar2='0.00';
			$this->totalpreciovtar3='0.00';
			$this->totalpreciomendez='0.00';
			$this->lastUpdate='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO " . $this->__tableName . " (codigo,
				                                              rollo_material_idMaterial,
				                                              calibre,
				                                              pies,
				                                              origen,
				                                              rollo_proveedor_idProveedor,
				                                              grado,
				                                              rollo_color_idColor,
				                                              descripcion,
				                                              observaciones,
				                                              estado,
				                                              fecha_creacion,
				                                              id_usuario_creacion,
				                                              fecha_modifica,
				                                              id_usuario_modifica,
				                                              fecha_baja,
				                                              id_usuario_baja,
				                                              existencia,
				                                              apartado,
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
				                                              totalessummes,
				                                              totalessumkg,
				                                              totalespeso,
				                                              totalesfab,
				                                              totalcostofab,
				                                              totalpreciovta,
				                                              totalpreciovtar2,
				                                              totalpreciovtar3,
				                                              totalpreciomendez,
				                                              lastUpdate)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rollo_material_idMaterial) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->origen) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rollo_proveedor_idProveedor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->grado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->rollo_color_idColor) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modifica) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_baja) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->iva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->prodmes) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porutilidad) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->porcomision) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->descuento) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costoflete) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->costokg) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesokgmt) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesocu) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoimporte) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->pesoparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->fmod) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->moi) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfab) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comisiones) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosventa) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancieros) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosadmon) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->modiva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->moiiva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfabiva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionesiva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosventaiva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosiva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosadmoniva) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->modparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->moiparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfabparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->comisionesparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosventaparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->gastosadmonparti) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalessummes) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalessumkg) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalespeso) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalesfab) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalcostofab) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovta) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar2) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar3) . "',
				               '" . mysqli_real_escape_string($this->dbLink,$this->totalpreciomendez) . "',
				               " . mysqli_real_escape_string($this->dbLink,"now()") . ")";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRollo::Insertar]");
				
				$this->idRollo=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE " . $this->__tableName . " SET codigo='" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
	                                              rollo_material_idMaterial='" . mysqli_real_escape_string($this->dbLink,$this->rollo_material_idMaterial) . "',
	                                              calibre='" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
	                                              pies='" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
	                                              origen='" . mysqli_real_escape_string($this->dbLink,$this->origen) . "',
	                                              rollo_proveedor_idProveedor='" . mysqli_real_escape_string($this->dbLink,$this->rollo_proveedor_idProveedor) . "',
	                                              grado='" . mysqli_real_escape_string($this->dbLink,$this->grado) . "',
	                                              rollo_color_idColor='" . mysqli_real_escape_string($this->dbLink,$this->rollo_color_idColor) . "',
	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
	                                              observaciones='" . mysqli_real_escape_string($this->dbLink,$this->observaciones) . "',
	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
	                                              fecha_creacion='" . mysqli_real_escape_string($this->dbLink,$this->fecha_creacion) . "',
	                                              id_usuario_creacion='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_creacion) . "',
	                                              fecha_modifica='" . mysqli_real_escape_string($this->dbLink,$this->fecha_modifica) . "',
	                                              id_usuario_modifica='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_modifica) . "',
	                                              fecha_baja='" . mysqli_real_escape_string($this->dbLink,$this->fecha_baja) . "',
	                                              id_usuario_baja='" . mysqli_real_escape_string($this->dbLink,$this->id_usuario_baja) . "',
	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
	                                              apartado='" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
	                                              iva='" . mysqli_real_escape_string($this->dbLink,$this->iva) . "',
	                                              prodmes='" . mysqli_real_escape_string($this->dbLink,$this->prodmes) . "',
	                                              porutilidad='" . mysqli_real_escape_string($this->dbLink,$this->porutilidad) . "',
	                                              porcomision='" . mysqli_real_escape_string($this->dbLink,$this->porcomision) . "',
	                                              descuento='" . mysqli_real_escape_string($this->dbLink,$this->descuento) . "',
	                                              costoflete='" . mysqli_real_escape_string($this->dbLink,$this->costoflete) . "',
	                                              costokg='" . mysqli_real_escape_string($this->dbLink,$this->costokg) . "',
	                                              pesokgmt='" . mysqli_real_escape_string($this->dbLink,$this->pesokgmt) . "',
	                                              pesocu='" . mysqli_real_escape_string($this->dbLink,$this->pesocu) . "',
	                                              pesoimporte='" . mysqli_real_escape_string($this->dbLink,$this->pesoimporte) . "',
	                                              pesoparti='" . mysqli_real_escape_string($this->dbLink,$this->pesoparti) . "',
	                                              fmod='" . mysqli_real_escape_string($this->dbLink,$this->fmod) . "',
	                                              moi='" . mysqli_real_escape_string($this->dbLink,$this->moi) . "',
	                                              gastosfab='" . mysqli_real_escape_string($this->dbLink,$this->gastosfab) . "',
	                                              comisiones='" . mysqli_real_escape_string($this->dbLink,$this->comisiones) . "',
	                                              gastosventa='" . mysqli_real_escape_string($this->dbLink,$this->gastosventa) . "',
	                                              gastosfinancieros='" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancieros) . "',
	                                              gastosadmon='" . mysqli_real_escape_string($this->dbLink,$this->gastosadmon) . "',
	                                              modiva='" . mysqli_real_escape_string($this->dbLink,$this->modiva) . "',
	                                              moiiva='" . mysqli_real_escape_string($this->dbLink,$this->moiiva) . "',
	                                              gastosfabiva='" . mysqli_real_escape_string($this->dbLink,$this->gastosfabiva) . "',
	                                              comisionesiva='" . mysqli_real_escape_string($this->dbLink,$this->comisionesiva) . "',
	                                              gastosventaiva='" . mysqli_real_escape_string($this->dbLink,$this->gastosventaiva) . "',
	                                              gastosfinancierosiva='" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosiva) . "',
	                                              gastosadmoniva='" . mysqli_real_escape_string($this->dbLink,$this->gastosadmoniva) . "',
	                                              modparti='" . mysqli_real_escape_string($this->dbLink,$this->modparti) . "',
	                                              moiparti='" . mysqli_real_escape_string($this->dbLink,$this->moiparti) . "',
	                                              gastosfabparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosfabparti) . "',
	                                              comisionesparti='" . mysqli_real_escape_string($this->dbLink,$this->comisionesparti) . "',
	                                              gastosventaparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosventaparti) . "',
	                                              gastosfinancierosparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosfinancierosparti) . "',
	                                              gastosadmonparti='" . mysqli_real_escape_string($this->dbLink,$this->gastosadmonparti) . "',
	                                              totalessummes='" . mysqli_real_escape_string($this->dbLink,$this->totalessummes) . "',
	                                              totalessumkg='" . mysqli_real_escape_string($this->dbLink,$this->totalessumkg) . "',
	                                              totalespeso='" . mysqli_real_escape_string($this->dbLink,$this->totalespeso) . "',
	                                              totalesfab='" . mysqli_real_escape_string($this->dbLink,$this->totalesfab) . "',
	                                              totalcostofab='" . mysqli_real_escape_string($this->dbLink,$this->totalcostofab) . "',
	                                              totalpreciovta='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovta) . "',
	                                              totalpreciovtar2='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar2) . "',
	                                              totalpreciovtar3='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciovtar3) . "',
	                                              totalpreciomendez='" . mysqli_real_escape_string($this->dbLink,$this->totalpreciomendez) . "',
	                                              lastUpdate='" . mysqli_real_escape_string($this->dbLink,$this->lastUpdate) . "'
					WHERE idRollo=" . $this->idRollo;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRollo::Update]");
				
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
				WHERE idRollo=" . mysqli_real_escape_string($this->dbLink,$this->idRollo);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseRollo::Borrar]");
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
						idRollo,
						codigo,
						rollo_material_idMaterial,
						calibre,
						pies,
						origen,
						rollo_proveedor_idProveedor,
						grado,
						rollo_color_idColor,
						descripcion,
						observaciones,
						estado,
						fecha_creacion,
						id_usuario_creacion,
						fecha_modifica,
						id_usuario_modifica,
						fecha_baja,
						id_usuario_baja,
						existencia,
						apartado,
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
						totalessummes,
						totalessumkg,
						totalespeso,
						totalesfab,
						totalcostofab,
						totalpreciovta,
						totalpreciovtar2,
						totalpreciovtar3,
						totalpreciomendez,
						lastUpdate
					FROM " . $this->__tableName . " 
					WHERE idRollo=" . mysqli_real_escape_string($this->dbLink,$this->idRollo);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseRollo::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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