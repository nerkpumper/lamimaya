<?php

	class ModeloBaseViewproductos extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseViewproductos";

		
		var $idProducto=0;
		var $codigo='';
		var $longitud='';
		var $mlpieza='';
		var $idTipoProducto=0;
		var $tipoProducto='';
		var $shortTipoProducto='';
		var $idAplicacion=0;
		var $aplicacion='';
		var $idMaterial=0;
		var $material='';
		var $idRollo=0;
		var $rolloCodigo='';
		var $rollodescauto='';
		var $rolloIdMaterial=0;
		var $rolloMaterial='';
		var $rolloShortMaterial='';
		var $rolloIdProveedor=0;
		var $rolloProveedor='';
		var $rolloShortProveedor='';
		var $rolloCalibre=0;
		var $rolloPies=0;
		var $rolloPesokiloml='';
		var $rolloOrigen='N';
		var $rolloExistencia='';
		var $rolloApartado='';
		var $rolloDescripcion='';
		var $rolloIva='';
		var $rolloProdmes='';
		var $rolloPorutilidad='';
		var $rolloPorcomision='';
		var $rolloDescuento='';
		var $rolloCostoflete='';
		var $rolloCostokg='';
		var $rolloPesokgmt='';
		var $rolloPesocu='';
		var $rolloPesoimporte='';
		var $rolloPesoparti='';
		var $rolloFmod='';
		var $rolloMoi='';
		var $rolloGastosfab='';
		var $rolloComisiones='';
		var $rolloGastosventa='';
		var $rolloGastosfinancieros='';
		var $rolloGastosadmon='';
		var $rolloModiva='';
		var $rolloMoiiva='';
		var $rolloGastosfabiva='';
		var $rolloComisionesiva='';
		var $rolloGastosventaiva='';
		var $rolloGastosfinancierosiva='';
		var $rolloGastosadmoniva='';
		var $rolloModparti='';
		var $rolloMoiparti='';
		var $rolloGastosfabparti='';
		var $rolloComisionesparti='';
		var $rolloGastosventaparti='';
		var $rolloGastosfinancierosparti='';
		var $rolloGastosadmonparti='';
		var $rolloTotalessumames='';
		var $rolloTotalessumkg='';
		var $rolloTotalespeso='';
		var $rolloTotalesfab='';
		var $rolloTotalcostofab='';
		var $rolloTotalpreciovta='';
		var $rolloTotalpreciovtar2='';
		var $rolloTotalpreciovtar3='';
		var $idUnidad=0;
		var $unidad='';
		var $shortUnidad='';
		var $calibre=0;
		var $pies=0;
		var $descripcion='';
		var $existencia=0;
		var $apartado='';
		var $apartadoReal='';
		var $tipoPrecio='';
		var $isRango='';
		var $tipoRango='';
		var $isRollo='';
		var $heredarPrecio='SI';
		var $precio1='';
		var $precio2='';
		var $precio3='';
		var $estado='ACTIVO';
		var $descauto='';

		var $__s=array("idProducto",
                       "codigo",
                       "longitud",
                       "mlpieza",
                       "idTipoProducto",
                       "tipoProducto",
                       "shortTipoProducto",
                       "idAplicacion",
                       "aplicacion",
                       "idMaterial",
                       "material",
                       "idRollo",
                       "rolloCodigo",
                       "rollodescauto",
                       "rolloIdMaterial",
                       "rolloMaterial",
                       "rolloShortMaterial",
                       "rolloIdProveedor",
                       "rolloProveedor",
                       "rolloShortProveedor",
                       "rolloCalibre",
                       "rolloPies",
                       "rolloPesokiloml",
                       "rolloOrigen",
                       "rolloExistencia",
                       "rolloApartado",
                       "rolloDescripcion",
                       "rolloIva",
                       "rolloProdmes",
                       "rolloPorutilidad",
                       "rolloPorcomision",
                       "rolloDescuento",
                       "rolloCostoflete",
                       "rolloCostokg",
                       "rolloPesokgmt",
                       "rolloPesocu",
                       "rolloPesoimporte",
                       "rolloPesoparti",
                       "rolloFmod",
                       "rolloMoi",
                       "rolloGastosfab",
                       "rolloComisiones",
                       "rolloGastosventa",
                       "rolloGastosfinancieros",
                       "rolloGastosadmon",
                       "rolloModiva",
                       "rolloMoiiva",
                       "rolloGastosfabiva",
                       "rolloComisionesiva",
                       "rolloGastosventaiva",
                       "rolloGastosfinancierosiva",
                       "rolloGastosadmoniva",
                       "rolloModparti",
                       "rolloMoiparti",
                       "rolloGastosfabparti",
                       "rolloComisionesparti",
                       "rolloGastosventaparti",
                       "rolloGastosfinancierosparti",
                       "rolloGastosadmonparti",
                       "rolloTotalessumames",
                       "rolloTotalessumkg",
                       "rolloTotalespeso",
                       "rolloTotalesfab",
                       "rolloTotalcostofab",
                       "rolloTotalpreciovta",
                       "rolloTotalpreciovtar2",
                       "rolloTotalpreciovtar3",
                       "idUnidad",
                       "unidad",
                       "shortUnidad",
                       "calibre",
                       "pies",
                       "descripcion",
                       "existencia",
                       "apartado",
                       "apartadoReal",
                       "tipoPrecio",
                       "isRango",
                       "tipoRango",
                       "isRollo",
                       "heredarPrecio",
                       "precio1",
                       "precio2",
                       "precio3",
                       "estado",
                       "descauto");
				
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

		
		public function setIdProducto($idProducto)
		{
			
			$this->idProducto=$idProducto;
		}
		public function setCodigo($codigo)
		{
			
			$this->codigo=$codigo;
		}
		public function setLongitud($longitud)
		{
			
			$this->longitud=$longitud;
		}
		public function setMlpieza($mlpieza)
		{
			$this->mlpieza=$mlpieza;
		}
		public function setIdTipoProducto($idTipoProducto)
		{
			
			$this->idTipoProducto=$idTipoProducto;
		}
		public function setTipoProducto($tipoProducto)
		{
			
			$this->tipoProducto=$tipoProducto;
		}
		public function setShortTipoProducto($shortTipoProducto)
		{
			
			$this->shortTipoProducto=$shortTipoProducto;
		}
		public function setIdAplicacion($idAplicacion)
		{
			
			$this->idAplicacion=$idAplicacion;
		}
		public function setAplicacion($aplicacion)
		{
			
			$this->aplicacion=$aplicacion;
		}
		public function setIdMaterial($idMaterial)
		{
			
			$this->idMaterial=$idMaterial;
		}
		public function setMaterial($material)
		{
			
			$this->material=$material;
		}
		public function setIdRollo($idRollo)
		{
			
			$this->idRollo=$idRollo;
		}
		public function setRolloCodigo($rolloCodigo)
		{
			
			$this->rolloCodigo=$rolloCodigo;
		}
		public function setRollodescauto($rollodescauto)
		{
			
			$this->rollodescauto=$rollodescauto;
		}
		public function setRolloIdMaterial($rolloIdMaterial)
		{
			
			$this->rolloIdMaterial=$rolloIdMaterial;
		}
		public function setRolloMaterial($rolloMaterial)
		{
			
			$this->rolloMaterial=$rolloMaterial;
		}
		public function setRolloShortMaterial($rolloShortMaterial)
		{
			
			$this->rolloShortMaterial=$rolloShortMaterial;
		}
		public function setRolloIdProveedor($rolloIdProveedor)
		{
			
			$this->rolloIdProveedor=$rolloIdProveedor;
		}
		public function setRolloProveedor($rolloProveedor)
		{
			
			$this->rolloProveedor=$rolloProveedor;
		}
		public function setRolloShortProveedor($rolloShortProveedor)
		{
			
			$this->rolloShortProveedor=$rolloShortProveedor;
		}
		public function setRolloCalibre($rolloCalibre)
		{
			
			$this->rolloCalibre=$rolloCalibre;
		}
		public function setRolloPies($rolloPies)
		{
			
			$this->rolloPies=$rolloPies;
		}
		public function setRolloPesokiloml($rolloPesokiloml)
		{
			$this->rolloPesokiloml=$rolloPesokiloml;
		}
		public function setRolloOrigen($rolloOrigen)
		{
			
			$this->rolloOrigen=$rolloOrigen;
		}
		public function setRolloOrigenI()
		{
			$this->rolloOrigen='I';
		}
		public function setRolloOrigenN()
		{
			$this->rolloOrigen='N';
		}
		public function setRolloExistencia($rolloExistencia)
		{
			$this->rolloExistencia=$rolloExistencia;
		}
		public function setRolloApartado($rolloApartado)
		{
			$this->rolloApartado=$rolloApartado;
		}
		public function setRolloDescripcion($rolloDescripcion)
		{
			
			$this->rolloDescripcion=$rolloDescripcion;
		}
		public function setRolloIva($rolloIva)
		{
			$this->rolloIva=$rolloIva;
		}
		public function setRolloProdmes($rolloProdmes)
		{
			$this->rolloProdmes=$rolloProdmes;
		}
		public function setRolloPorutilidad($rolloPorutilidad)
		{
			$this->rolloPorutilidad=$rolloPorutilidad;
		}
		public function setRolloPorcomision($rolloPorcomision)
		{
			$this->rolloPorcomision=$rolloPorcomision;
		}
		public function setRolloDescuento($rolloDescuento)
		{
			$this->rolloDescuento=$rolloDescuento;
		}
		public function setRolloCostoflete($rolloCostoflete)
		{
			$this->rolloCostoflete=$rolloCostoflete;
		}
		public function setRolloCostokg($rolloCostokg)
		{
			$this->rolloCostokg=$rolloCostokg;
		}
		public function setRolloPesokgmt($rolloPesokgmt)
		{
			$this->rolloPesokgmt=$rolloPesokgmt;
		}
		public function setRolloPesocu($rolloPesocu)
		{
			$this->rolloPesocu=$rolloPesocu;
		}
		public function setRolloPesoimporte($rolloPesoimporte)
		{
			$this->rolloPesoimporte=$rolloPesoimporte;
		}
		public function setRolloPesoparti($rolloPesoparti)
		{
			$this->rolloPesoparti=$rolloPesoparti;
		}
		public function setRolloFmod($rolloFmod)
		{
			$this->rolloFmod=$rolloFmod;
		}
		public function setRolloMoi($rolloMoi)
		{
			$this->rolloMoi=$rolloMoi;
		}
		public function setRolloGastosfab($rolloGastosfab)
		{
			$this->rolloGastosfab=$rolloGastosfab;
		}
		public function setRolloComisiones($rolloComisiones)
		{
			$this->rolloComisiones=$rolloComisiones;
		}
		public function setRolloGastosventa($rolloGastosventa)
		{
			$this->rolloGastosventa=$rolloGastosventa;
		}
		public function setRolloGastosfinancieros($rolloGastosfinancieros)
		{
			$this->rolloGastosfinancieros=$rolloGastosfinancieros;
		}
		public function setRolloGastosadmon($rolloGastosadmon)
		{
			$this->rolloGastosadmon=$rolloGastosadmon;
		}
		public function setRolloModiva($rolloModiva)
		{
			$this->rolloModiva=$rolloModiva;
		}
		public function setRolloMoiiva($rolloMoiiva)
		{
			$this->rolloMoiiva=$rolloMoiiva;
		}
		public function setRolloGastosfabiva($rolloGastosfabiva)
		{
			$this->rolloGastosfabiva=$rolloGastosfabiva;
		}
		public function setRolloComisionesiva($rolloComisionesiva)
		{
			$this->rolloComisionesiva=$rolloComisionesiva;
		}
		public function setRolloGastosventaiva($rolloGastosventaiva)
		{
			$this->rolloGastosventaiva=$rolloGastosventaiva;
		}
		public function setRolloGastosfinancierosiva($rolloGastosfinancierosiva)
		{
			$this->rolloGastosfinancierosiva=$rolloGastosfinancierosiva;
		}
		public function setRolloGastosadmoniva($rolloGastosadmoniva)
		{
			$this->rolloGastosadmoniva=$rolloGastosadmoniva;
		}
		public function setRolloModparti($rolloModparti)
		{
			$this->rolloModparti=$rolloModparti;
		}
		public function setRolloMoiparti($rolloMoiparti)
		{
			$this->rolloMoiparti=$rolloMoiparti;
		}
		public function setRolloGastosfabparti($rolloGastosfabparti)
		{
			$this->rolloGastosfabparti=$rolloGastosfabparti;
		}
		public function setRolloComisionesparti($rolloComisionesparti)
		{
			$this->rolloComisionesparti=$rolloComisionesparti;
		}
		public function setRolloGastosventaparti($rolloGastosventaparti)
		{
			$this->rolloGastosventaparti=$rolloGastosventaparti;
		}
		public function setRolloGastosfinancierosparti($rolloGastosfinancierosparti)
		{
			$this->rolloGastosfinancierosparti=$rolloGastosfinancierosparti;
		}
		public function setRolloGastosadmonparti($rolloGastosadmonparti)
		{
			$this->rolloGastosadmonparti=$rolloGastosadmonparti;
		}
		public function setRolloTotalessumames($rolloTotalessumames)
		{
			$this->rolloTotalessumames=$rolloTotalessumames;
		}
		public function setRolloTotalessumkg($rolloTotalessumkg)
		{
			$this->rolloTotalessumkg=$rolloTotalessumkg;
		}
		public function setRolloTotalespeso($rolloTotalespeso)
		{
			$this->rolloTotalespeso=$rolloTotalespeso;
		}
		public function setRolloTotalesfab($rolloTotalesfab)
		{
			$this->rolloTotalesfab=$rolloTotalesfab;
		}
		public function setRolloTotalcostofab($rolloTotalcostofab)
		{
			$this->rolloTotalcostofab=$rolloTotalcostofab;
		}
		public function setRolloTotalpreciovta($rolloTotalpreciovta)
		{
			$this->rolloTotalpreciovta=$rolloTotalpreciovta;
		}
		public function setRolloTotalpreciovtar2($rolloTotalpreciovtar2)
		{
			$this->rolloTotalpreciovtar2=$rolloTotalpreciovtar2;
		}
		public function setRolloTotalpreciovtar3($rolloTotalpreciovtar3)
		{
			$this->rolloTotalpreciovtar3=$rolloTotalpreciovtar3;
		}
		public function setIdUnidad($idUnidad)
		{
			
			$this->idUnidad=$idUnidad;
		}
		public function setUnidad($unidad)
		{
			
			$this->unidad=$unidad;
		}
		public function setShortUnidad($shortUnidad)
		{
			
			$this->shortUnidad=$shortUnidad;
		}
		public function setCalibre($calibre)
		{
			
			$this->calibre=$calibre;
		}
		public function setPies($pies)
		{
			
			$this->pies=$pies;
		}
		public function setDescripcion($descripcion)
		{
			
			$this->descripcion=$descripcion;
		}
		public function setExistencia($existencia)
		{
			
			$this->existencia=$existencia;
		}
		public function setApartado($apartado)
		{
			$this->apartado=$apartado;
		}
		public function setApartadoReal($apartadoReal)
		{
			$this->apartadoReal=$apartadoReal;
		}
		public function setTipoPrecio($tipoPrecio)
		{
			$this->tipoPrecio=$tipoPrecio;
		}
		public function setIsRango($isRango)
		{
			$this->isRango=$isRango;
		}
		public function setTipoRango($tipoRango)
		{
			$this->tipoRango=$tipoRango;
		}
		public function setIsRollo($isRollo)
		{
			$this->isRollo=$isRollo;
		}
		public function setHeredarPrecio($heredarPrecio)
		{
			
			$this->heredarPrecio=$heredarPrecio;
		}
		public function setHeredarPrecioSI()
		{
			$this->heredarPrecio='SI';
		}
		public function setHeredarPrecioNO()
		{
			$this->heredarPrecio='NO';
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
		public function setDescauto($descauto)
		{
			
			$this->descauto=$descauto;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdProducto()
		{
			return $this->idProducto;
		}
		public function getCodigo()
		{
			return $this->codigo;
		}
		public function getLongitud()
		{
			return $this->longitud;
		}
		public function getMlpieza()
		{
			return $this->mlpieza;
		}
		public function getIdTipoProducto()
		{
			return $this->idTipoProducto;
		}
		public function getTipoProducto()
		{
			return $this->tipoProducto;
		}
		public function getShortTipoProducto()
		{
			return $this->shortTipoProducto;
		}
		public function getIdAplicacion()
		{
			return $this->idAplicacion;
		}
		public function getAplicacion()
		{
			return $this->aplicacion;
		}
		public function getIdMaterial()
		{
			return $this->idMaterial;
		}
		public function getMaterial()
		{
			return $this->material;
		}
		public function getIdRollo()
		{
			return $this->idRollo;
		}
		public function getRolloCodigo()
		{
			return $this->rolloCodigo;
		}
		public function getRollodescauto()
		{
			return $this->rollodescauto;
		}
		public function getRolloIdMaterial()
		{
			return $this->rolloIdMaterial;
		}
		public function getRolloMaterial()
		{
			return $this->rolloMaterial;
		}
		public function getRolloShortMaterial()
		{
			return $this->rolloShortMaterial;
		}
		public function getRolloIdProveedor()
		{
			return $this->rolloIdProveedor;
		}
		public function getRolloProveedor()
		{
			return $this->rolloProveedor;
		}
		public function getRolloShortProveedor()
		{
			return $this->rolloShortProveedor;
		}
		public function getRolloCalibre()
		{
			return $this->rolloCalibre;
		}
		public function getRolloPies()
		{
			return $this->rolloPies;
		}
		public function getRolloPesokiloml()
		{
			return $this->rolloPesokiloml;
		}
		public function getRolloOrigen()
		{
			return $this->rolloOrigen;
		}
		public function getRolloExistencia()
		{
			return $this->rolloExistencia;
		}
		public function getRolloApartado()
		{
			return $this->rolloApartado;
		}
		public function getRolloDescripcion()
		{
			return $this->rolloDescripcion;
		}
		public function getRolloIva()
		{
			return $this->rolloIva;
		}
		public function getRolloProdmes()
		{
			return $this->rolloProdmes;
		}
		public function getRolloPorutilidad()
		{
			return $this->rolloPorutilidad;
		}
		public function getRolloPorcomision()
		{
			return $this->rolloPorcomision;
		}
		public function getRolloDescuento()
		{
			return $this->rolloDescuento;
		}
		public function getRolloCostoflete()
		{
			return $this->rolloCostoflete;
		}
		public function getRolloCostokg()
		{
			return $this->rolloCostokg;
		}
		public function getRolloPesokgmt()
		{
			return $this->rolloPesokgmt;
		}
		public function getRolloPesocu()
		{
			return $this->rolloPesocu;
		}
		public function getRolloPesoimporte()
		{
			return $this->rolloPesoimporte;
		}
		public function getRolloPesoparti()
		{
			return $this->rolloPesoparti;
		}
		public function getRolloFmod()
		{
			return $this->rolloFmod;
		}
		public function getRolloMoi()
		{
			return $this->rolloMoi;
		}
		public function getRolloGastosfab()
		{
			return $this->rolloGastosfab;
		}
		public function getRolloComisiones()
		{
			return $this->rolloComisiones;
		}
		public function getRolloGastosventa()
		{
			return $this->rolloGastosventa;
		}
		public function getRolloGastosfinancieros()
		{
			return $this->rolloGastosfinancieros;
		}
		public function getRolloGastosadmon()
		{
			return $this->rolloGastosadmon;
		}
		public function getRolloModiva()
		{
			return $this->rolloModiva;
		}
		public function getRolloMoiiva()
		{
			return $this->rolloMoiiva;
		}
		public function getRolloGastosfabiva()
		{
			return $this->rolloGastosfabiva;
		}
		public function getRolloComisionesiva()
		{
			return $this->rolloComisionesiva;
		}
		public function getRolloGastosventaiva()
		{
			return $this->rolloGastosventaiva;
		}
		public function getRolloGastosfinancierosiva()
		{
			return $this->rolloGastosfinancierosiva;
		}
		public function getRolloGastosadmoniva()
		{
			return $this->rolloGastosadmoniva;
		}
		public function getRolloModparti()
		{
			return $this->rolloModparti;
		}
		public function getRolloMoiparti()
		{
			return $this->rolloMoiparti;
		}
		public function getRolloGastosfabparti()
		{
			return $this->rolloGastosfabparti;
		}
		public function getRolloComisionesparti()
		{
			return $this->rolloComisionesparti;
		}
		public function getRolloGastosventaparti()
		{
			return $this->rolloGastosventaparti;
		}
		public function getRolloGastosfinancierosparti()
		{
			return $this->rolloGastosfinancierosparti;
		}
		public function getRolloGastosadmonparti()
		{
			return $this->rolloGastosadmonparti;
		}
		public function getRolloTotalessumames()
		{
			return $this->rolloTotalessumames;
		}
		public function getRolloTotalessumkg()
		{
			return $this->rolloTotalessumkg;
		}
		public function getRolloTotalespeso()
		{
			return $this->rolloTotalespeso;
		}
		public function getRolloTotalesfab()
		{
			return $this->rolloTotalesfab;
		}
		public function getRolloTotalcostofab()
		{
			return $this->rolloTotalcostofab;
		}
		public function getRolloTotalpreciovta()
		{
			return $this->rolloTotalpreciovta;
		}
		public function getRolloTotalpreciovtar2()
		{
			return $this->rolloTotalpreciovtar2;
		}
		public function getRolloTotalpreciovtar3()
		{
			return $this->rolloTotalpreciovtar3;
		}
		public function getIdUnidad()
		{
			return $this->idUnidad;
		}
		public function getUnidad()
		{
			return $this->unidad;
		}
		public function getShortUnidad()
		{
			return $this->shortUnidad;
		}
		public function getCalibre()
		{
			return $this->calibre;
		}
		public function getPies()
		{
			return $this->pies;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
		}
		public function getExistencia()
		{
			return $this->existencia;
		}
		public function getApartado()
		{
			return $this->apartado;
		}
		public function getApartadoReal()
		{
			return $this->apartadoReal;
		}
		public function getTipoPrecio()
		{
			return $this->tipoPrecio;
		}
		public function getIsRango()
		{
			return $this->isRango;
		}
		public function getTipoRango()
		{
			return $this->tipoRango;
		}
		public function getIsRollo()
		{
			return $this->isRollo;
		}
		public function getHeredarPrecio()
		{
			return $this->heredarPrecio;
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
		public function getEstado()
		{
			return $this->estado;
		}
		public function getDescauto()
		{
			return $this->descauto;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idProducto=0;
			$this->codigo='';
			$this->longitud='';
			$this->mlpieza='';
			$this->idTipoProducto=0;
			$this->tipoProducto='';
			$this->shortTipoProducto='';
			$this->idAplicacion=0;
			$this->aplicacion='';
			$this->idMaterial=0;
			$this->material='';
			$this->idRollo=0;
			$this->rolloCodigo='';
			$this->rollodescauto='';
			$this->rolloIdMaterial=0;
			$this->rolloMaterial='';
			$this->rolloShortMaterial='';
			$this->rolloIdProveedor=0;
			$this->rolloProveedor='';
			$this->rolloShortProveedor='';
			$this->rolloCalibre=0;
			$this->rolloPies=0;
			$this->rolloPesokiloml='';
			$this->rolloOrigen='N';
			$this->rolloExistencia='';
			$this->rolloApartado='';
			$this->rolloDescripcion='';
			$this->rolloIva='';
			$this->rolloProdmes='';
			$this->rolloPorutilidad='';
			$this->rolloPorcomision='';
			$this->rolloDescuento='';
			$this->rolloCostoflete='';
			$this->rolloCostokg='';
			$this->rolloPesokgmt='';
			$this->rolloPesocu='';
			$this->rolloPesoimporte='';
			$this->rolloPesoparti='';
			$this->rolloFmod='';
			$this->rolloMoi='';
			$this->rolloGastosfab='';
			$this->rolloComisiones='';
			$this->rolloGastosventa='';
			$this->rolloGastosfinancieros='';
			$this->rolloGastosadmon='';
			$this->rolloModiva='';
			$this->rolloMoiiva='';
			$this->rolloGastosfabiva='';
			$this->rolloComisionesiva='';
			$this->rolloGastosventaiva='';
			$this->rolloGastosfinancierosiva='';
			$this->rolloGastosadmoniva='';
			$this->rolloModparti='';
			$this->rolloMoiparti='';
			$this->rolloGastosfabparti='';
			$this->rolloComisionesparti='';
			$this->rolloGastosventaparti='';
			$this->rolloGastosfinancierosparti='';
			$this->rolloGastosadmonparti='';
			$this->rolloTotalessumames='';
			$this->rolloTotalessumkg='';
			$this->rolloTotalespeso='';
			$this->rolloTotalesfab='';
			$this->rolloTotalcostofab='';
			$this->rolloTotalpreciovta='';
			$this->rolloTotalpreciovtar2='';
			$this->rolloTotalpreciovtar3='';
			$this->idUnidad=0;
			$this->unidad='';
			$this->shortUnidad='';
			$this->calibre=0;
			$this->pies=0;
			$this->descripcion='';
			$this->existencia=0;
			$this->apartado='';
			$this->apartadoReal='';
			$this->tipoPrecio='';
			$this->isRango='';
			$this->tipoRango='';
			$this->isRollo='';
			$this->heredarPrecio='SI';
			$this->precio1='';
			$this->precio2='';
			$this->precio3='';
			$this->estado='ACTIVO';
			$this->descauto='';
		}

		

		
// 		protected function Insertar()
// 		{
// 			try
// 			{
// 				$SQL="INSERT INTO " . $this->__tableName . " (idProducto,
// 				                                              codigo,
// 				                                              longitud,
// 				                                              mlpieza,
// 				                                              idTipoProducto,
// 				                                              tipoProducto,
// 				                                              shortTipoProducto,
// 				                                              idAplicacion,
// 				                                              aplicacion,
// 				                                              idMaterial,
// 				                                              material,
// 				                                              idRollo,
// 				                                              rolloCodigo,
// 				                                              rollodescauto,
// 				                                              rolloIdMaterial,
// 				                                              rolloMaterial,
// 				                                              rolloShortMaterial,
// 				                                              rolloIdProveedor,
// 				                                              rolloProveedor,
// 				                                              rolloShortProveedor,
// 				                                              rolloCalibre,
// 				                                              rolloPies,
// 				                                              rolloPesokiloml,
// 				                                              rolloOrigen,
// 				                                              rolloExistencia,
// 				                                              rolloApartado,
// 				                                              rolloDescripcion,
// 				                                              rolloIva,
// 				                                              rolloProdmes,
// 				                                              rolloPorutilidad,
// 				                                              rolloPorcomision,
// 				                                              rolloDescuento,
// 				                                              rolloCostoflete,
// 				                                              rolloCostokg,
// 				                                              rolloPesokgmt,
// 				                                              rolloPesocu,
// 				                                              rolloPesoimporte,
// 				                                              rolloPesoparti,
// 				                                              rolloFmod,
// 				                                              rolloMoi,
// 				                                              rolloGastosfab,
// 				                                              rolloComisiones,
// 				                                              rolloGastosventa,
// 				                                              rolloGastosfinancieros,
// 				                                              rolloGastosadmon,
// 				                                              rolloModiva,
// 				                                              rolloMoiiva,
// 				                                              rolloGastosfabiva,
// 				                                              rolloComisionesiva,
// 				                                              rolloGastosventaiva,
// 				                                              rolloGastosfinancierosiva,
// 				                                              rolloGastosadmoniva,
// 				                                              rolloModparti,
// 				                                              rolloMoiparti,
// 				                                              rolloGastosfabparti,
// 				                                              rolloComisionesparti,
// 				                                              rolloGastosventaparti,
// 				                                              rolloGastosfinancierosparti,
// 				                                              rolloGastosadmonparti,
// 				                                              rolloTotalessumames,
// 				                                              rolloTotalessumkg,
// 				                                              rolloTotalespeso,
// 				                                              rolloTotalesfab,
// 				                                              rolloTotalcostofab,
// 				                                              rolloTotalpreciovta,
// 				                                              rolloTotalpreciovtar2,
// 				                                              rolloTotalpreciovtar3,
// 				                                              idUnidad,
// 				                                              unidad,
// 				                                              shortUnidad,
// 				                                              calibre,
// 				                                              pies,
// 				                                              descripcion,
// 				                                              existencia,
// 				                                              apartado,
// 				                                              apartadoReal,
// 				                                              tipoPrecio,
// 				                                              isRango,
// 				                                              tipoRango,
// 				                                              isRollo,
// 				                                              heredarPrecio,
// 				                                              precio1,
// 				                                              precio2,
// 				                                              precio3,
// 				                                              estado,
// 				                                              descauto)
// 						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->longitud) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->mlpieza) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idTipoProducto) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoProducto) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->shortTipoProducto) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idAplicacion) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->aplicacion) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idMaterial) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->material) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idRollo) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloCodigo) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rollodescauto) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloIdMaterial) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloMaterial) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloShortMaterial) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloIdProveedor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloProveedor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloShortProveedor) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloCalibre) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPies) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPesokiloml) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloOrigen) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloExistencia) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloApartado) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloDescripcion) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloIva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloProdmes) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPorutilidad) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPorcomision) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloDescuento) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloCostoflete) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloCostokg) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPesokgmt) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPesocu) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPesoimporte) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloPesoparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloFmod) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloMoi) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfab) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloComisiones) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosventa) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfinancieros) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosadmon) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloModiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloMoiiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfabiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloComisionesiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosventaiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfinancierosiva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosadmoniva) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloModparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloMoiparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfabparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloComisionesparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosventaparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfinancierosparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosadmonparti) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalessumames) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalessumkg) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalespeso) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalesfab) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalcostofab) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalpreciovta) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalpreciovtar2) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalpreciovtar3) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->idUnidad) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->unidad) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->shortUnidad) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->apartadoReal) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->isRango) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->tipoRango) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->isRollo) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->heredarPrecio) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
// 				               '" . mysqli_real_escape_string($this->dbLink,$this->descauto) . "')";
// 				$result=mysqli_query($this->dbLink,$SQL);
// 				if(!$result)
// 					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseViewproductos::Insertar]");
				
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
// 				$SQL="UPDATE " . $this->__tableName . " SET idProducto='" . mysqli_real_escape_string($this->dbLink,$this->idProducto) . "',
// 	                                              codigo='" . mysqli_real_escape_string($this->dbLink,$this->codigo) . "',
// 	                                              longitud='" . mysqli_real_escape_string($this->dbLink,$this->longitud) . "',
// 	                                              mlpieza='" . mysqli_real_escape_string($this->dbLink,$this->mlpieza) . "',
// 	                                              idTipoProducto='" . mysqli_real_escape_string($this->dbLink,$this->idTipoProducto) . "',
// 	                                              tipoProducto='" . mysqli_real_escape_string($this->dbLink,$this->tipoProducto) . "',
// 	                                              shortTipoProducto='" . mysqli_real_escape_string($this->dbLink,$this->shortTipoProducto) . "',
// 	                                              idAplicacion='" . mysqli_real_escape_string($this->dbLink,$this->idAplicacion) . "',
// 	                                              aplicacion='" . mysqli_real_escape_string($this->dbLink,$this->aplicacion) . "',
// 	                                              idMaterial='" . mysqli_real_escape_string($this->dbLink,$this->idMaterial) . "',
// 	                                              material='" . mysqli_real_escape_string($this->dbLink,$this->material) . "',
// 	                                              idRollo='" . mysqli_real_escape_string($this->dbLink,$this->idRollo) . "',
// 	                                              rolloCodigo='" . mysqli_real_escape_string($this->dbLink,$this->rolloCodigo) . "',
// 	                                              rollodescauto='" . mysqli_real_escape_string($this->dbLink,$this->rollodescauto) . "',
// 	                                              rolloIdMaterial='" . mysqli_real_escape_string($this->dbLink,$this->rolloIdMaterial) . "',
// 	                                              rolloMaterial='" . mysqli_real_escape_string($this->dbLink,$this->rolloMaterial) . "',
// 	                                              rolloShortMaterial='" . mysqli_real_escape_string($this->dbLink,$this->rolloShortMaterial) . "',
// 	                                              rolloIdProveedor='" . mysqli_real_escape_string($this->dbLink,$this->rolloIdProveedor) . "',
// 	                                              rolloProveedor='" . mysqli_real_escape_string($this->dbLink,$this->rolloProveedor) . "',
// 	                                              rolloShortProveedor='" . mysqli_real_escape_string($this->dbLink,$this->rolloShortProveedor) . "',
// 	                                              rolloCalibre='" . mysqli_real_escape_string($this->dbLink,$this->rolloCalibre) . "',
// 	                                              rolloPies='" . mysqli_real_escape_string($this->dbLink,$this->rolloPies) . "',
// 	                                              rolloPesokiloml='" . mysqli_real_escape_string($this->dbLink,$this->rolloPesokiloml) . "',
// 	                                              rolloOrigen='" . mysqli_real_escape_string($this->dbLink,$this->rolloOrigen) . "',
// 	                                              rolloExistencia='" . mysqli_real_escape_string($this->dbLink,$this->rolloExistencia) . "',
// 	                                              rolloApartado='" . mysqli_real_escape_string($this->dbLink,$this->rolloApartado) . "',
// 	                                              rolloDescripcion='" . mysqli_real_escape_string($this->dbLink,$this->rolloDescripcion) . "',
// 	                                              rolloIva='" . mysqli_real_escape_string($this->dbLink,$this->rolloIva) . "',
// 	                                              rolloProdmes='" . mysqli_real_escape_string($this->dbLink,$this->rolloProdmes) . "',
// 	                                              rolloPorutilidad='" . mysqli_real_escape_string($this->dbLink,$this->rolloPorutilidad) . "',
// 	                                              rolloPorcomision='" . mysqli_real_escape_string($this->dbLink,$this->rolloPorcomision) . "',
// 	                                              rolloDescuento='" . mysqli_real_escape_string($this->dbLink,$this->rolloDescuento) . "',
// 	                                              rolloCostoflete='" . mysqli_real_escape_string($this->dbLink,$this->rolloCostoflete) . "',
// 	                                              rolloCostokg='" . mysqli_real_escape_string($this->dbLink,$this->rolloCostokg) . "',
// 	                                              rolloPesokgmt='" . mysqli_real_escape_string($this->dbLink,$this->rolloPesokgmt) . "',
// 	                                              rolloPesocu='" . mysqli_real_escape_string($this->dbLink,$this->rolloPesocu) . "',
// 	                                              rolloPesoimporte='" . mysqli_real_escape_string($this->dbLink,$this->rolloPesoimporte) . "',
// 	                                              rolloPesoparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloPesoparti) . "',
// 	                                              rolloFmod='" . mysqli_real_escape_string($this->dbLink,$this->rolloFmod) . "',
// 	                                              rolloMoi='" . mysqli_real_escape_string($this->dbLink,$this->rolloMoi) . "',
// 	                                              rolloGastosfab='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfab) . "',
// 	                                              rolloComisiones='" . mysqli_real_escape_string($this->dbLink,$this->rolloComisiones) . "',
// 	                                              rolloGastosventa='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosventa) . "',
// 	                                              rolloGastosfinancieros='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfinancieros) . "',
// 	                                              rolloGastosadmon='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosadmon) . "',
// 	                                              rolloModiva='" . mysqli_real_escape_string($this->dbLink,$this->rolloModiva) . "',
// 	                                              rolloMoiiva='" . mysqli_real_escape_string($this->dbLink,$this->rolloMoiiva) . "',
// 	                                              rolloGastosfabiva='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfabiva) . "',
// 	                                              rolloComisionesiva='" . mysqli_real_escape_string($this->dbLink,$this->rolloComisionesiva) . "',
// 	                                              rolloGastosventaiva='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosventaiva) . "',
// 	                                              rolloGastosfinancierosiva='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfinancierosiva) . "',
// 	                                              rolloGastosadmoniva='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosadmoniva) . "',
// 	                                              rolloModparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloModparti) . "',
// 	                                              rolloMoiparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloMoiparti) . "',
// 	                                              rolloGastosfabparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfabparti) . "',
// 	                                              rolloComisionesparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloComisionesparti) . "',
// 	                                              rolloGastosventaparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosventaparti) . "',
// 	                                              rolloGastosfinancierosparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosfinancierosparti) . "',
// 	                                              rolloGastosadmonparti='" . mysqli_real_escape_string($this->dbLink,$this->rolloGastosadmonparti) . "',
// 	                                              rolloTotalessumames='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalessumames) . "',
// 	                                              rolloTotalessumkg='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalessumkg) . "',
// 	                                              rolloTotalespeso='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalespeso) . "',
// 	                                              rolloTotalesfab='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalesfab) . "',
// 	                                              rolloTotalcostofab='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalcostofab) . "',
// 	                                              rolloTotalpreciovta='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalpreciovta) . "',
// 	                                              rolloTotalpreciovtar2='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalpreciovtar2) . "',
// 	                                              rolloTotalpreciovtar3='" . mysqli_real_escape_string($this->dbLink,$this->rolloTotalpreciovtar3) . "',
// 	                                              idUnidad='" . mysqli_real_escape_string($this->dbLink,$this->idUnidad) . "',
// 	                                              unidad='" . mysqli_real_escape_string($this->dbLink,$this->unidad) . "',
// 	                                              shortUnidad='" . mysqli_real_escape_string($this->dbLink,$this->shortUnidad) . "',
// 	                                              calibre='" . mysqli_real_escape_string($this->dbLink,$this->calibre) . "',
// 	                                              pies='" . mysqli_real_escape_string($this->dbLink,$this->pies) . "',
// 	                                              descripcion='" . mysqli_real_escape_string($this->dbLink,$this->descripcion) . "',
// 	                                              existencia='" . mysqli_real_escape_string($this->dbLink,$this->existencia) . "',
// 	                                              apartado='" . mysqli_real_escape_string($this->dbLink,$this->apartado) . "',
// 	                                              apartadoReal='" . mysqli_real_escape_string($this->dbLink,$this->apartadoReal) . "',
// 	                                              tipoPrecio='" . mysqli_real_escape_string($this->dbLink,$this->tipoPrecio) . "',
// 	                                              isRango='" . mysqli_real_escape_string($this->dbLink,$this->isRango) . "',
// 	                                              tipoRango='" . mysqli_real_escape_string($this->dbLink,$this->tipoRango) . "',
// 	                                              isRollo='" . mysqli_real_escape_string($this->dbLink,$this->isRollo) . "',
// 	                                              heredarPrecio='" . mysqli_real_escape_string($this->dbLink,$this->heredarPrecio) . "',
// 	                                              precio1='" . mysqli_real_escape_string($this->dbLink,$this->precio1) . "',
// 	                                              precio2='" . mysqli_real_escape_string($this->dbLink,$this->precio2) . "',
// 	                                              precio3='" . mysqli_real_escape_string($this->dbLink,$this->precio3) . "',
// 	                                              estado='" . mysqli_real_escape_string($this->dbLink,$this->estado) . "',
// 	                                              descauto='" . mysqli_real_escape_string($this->dbLink,$this->descauto) . "'
// 					WHERE =" . $this->;
				
// 				$result=mysqli_query($this->dbLink,$SQL);
// 				if(!$result)
// 					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseViewproductos::Update]");
				
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
// 					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseViewproductos::Borrar]");
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
						idProducto,
						codigo,
						longitud,
						mlpieza,
						idTipoProducto,
						tipoProducto,
						shortTipoProducto,
						idAplicacion,
						aplicacion,
						idMaterial,
						material,
						idRollo,
						rolloCodigo,
						rollodescauto,
						rolloIdMaterial,
						rolloMaterial,
						rolloShortMaterial,
						rolloIdProveedor,
						rolloProveedor,
						rolloShortProveedor,
						rolloCalibre,
						rolloPies,
						rolloPesokiloml,
						rolloOrigen,
						rolloExistencia,
						rolloApartado,
						rolloDescripcion,
						rolloIva,
						rolloProdmes,
						rolloPorutilidad,
						rolloPorcomision,
						rolloDescuento,
						rolloCostoflete,
						rolloCostokg,
						rolloPesokgmt,
						rolloPesocu,
						rolloPesoimporte,
						rolloPesoparti,
						rolloFmod,
						rolloMoi,
						rolloGastosfab,
						rolloComisiones,
						rolloGastosventa,
						rolloGastosfinancieros,
						rolloGastosadmon,
						rolloModiva,
						rolloMoiiva,
						rolloGastosfabiva,
						rolloComisionesiva,
						rolloGastosventaiva,
						rolloGastosfinancierosiva,
						rolloGastosadmoniva,
						rolloModparti,
						rolloMoiparti,
						rolloGastosfabparti,
						rolloComisionesparti,
						rolloGastosventaparti,
						rolloGastosfinancierosparti,
						rolloGastosadmonparti,
						rolloTotalessumames,
						rolloTotalessumkg,
						rolloTotalespeso,
						rolloTotalesfab,
						rolloTotalcostofab,
						rolloTotalpreciovta,
						rolloTotalpreciovtar2,
						rolloTotalpreciovtar3,
						idUnidad,
						unidad,
						shortUnidad,
						calibre,
						pies,
						descripcion,
						existencia,
						apartado,
						apartadoReal,
						tipoPrecio,
						isRango,
						tipoRango,
						isRollo,
						heredarPrecio,
						precio1,
						precio2,
						precio3,
						estado,
						descauto
					FROM " . $this->__tableName . " 
					WHERE idProducto =" . mysqli_real_escape_string($this->dbLink,$this->idProducto);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseViewproductos::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idProducto==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>