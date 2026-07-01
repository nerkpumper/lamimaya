<?php

	require FOLDER_MODEL_BASE . "model.base.viewproductos.inc.php";

	define("NOAPLICA", "--NO APLICA--");
	class ModeloViewproductos extends ModeloBaseViewproductos
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseViewproductos";

		var $__ss=array();
// 		var $__primaryKey="";
		var $__tableName="viewproductos";
// 		var $__tableEdit="viewproductosedit";
// 		var $__tableDelete="viewproductosdelete";

		var $__primaryKey="idProducto";
// 		var $__tableName="producto";
		var $__tableEdit="productonewedit";
		var $__tableDelete="productodelete";

		var $lstProductos = array();
		
		var $idinventariosucursal= 0;
		var $rolloExistenciaGlobal=0;
		
		var $favorito= 'NO';
		


		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{

		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#


		public function setIdInventarioSucursal($idInventarioSucursal)
		{
		    
		    $this->idinventariosucursal=$idInventarioSucursal;
		}

		public function setFavorito($favorito)
		{
			
			$this->favorito = $favorito;
		}

		

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		public function getIdInventarioSucursal()
		{
		    
		    return $this->idinventariosucursal;
		}

		public function getFavorito()
		{
			
			return $this->favorito;
		}

		public function getRolloExistenciaGlobal()
		{
			return $this->rolloExistenciaGlobal;
		}

		
		public function getFullDescripcion($mostrarCodigo = true)
		{
			$result ="";

			return ($mostrarCodigo  ? $this->codigo . " - " . " " : "") . $this->getDescripcion();

			if ($this->isRollo == "0")
			{
				if ($this->shortTipoProducto == "AC")
				{
					// es un ACCESORIO
// 					$result = ($mostrarCodigo  ? $this->codigo . " - " . " " : "") .
					$result = $this->codigo . " - " .
					        $this->getDescripcion() .
							" - " . $this->shortUnidad;

				}
				else
				{
					$result = ($mostrarCodigo  ? $this->codigo . " - " . " " : "") .
							" " . $this->getTipoProducto() .
							($this->aplicacion != NOAPLICA ? " " . $this->aplicacion : "") .
							($this->material != NOAPLICA ? " " . $this->material : "") .
							" CALIBRE " .$this->calibre .
							(strlen($this->longitud) > 0 ? " * " . $this->longitud . " ML " : "") .
							" - " . $this->shortUnidad;
				}

			}
			else
			{
				$result = ($mostrarCodigo  ? $this->codigo . " - " . " " : "") .
				" " . $this->getTipoProducto() .
				($this->rolloMaterial != NOAPLICA ? " " . $this->rolloMaterial : "") .
				($this->rolloProveedor != NOAPLICA ? " " . $this->rolloProveedor : "") .
				" CALIBRE " . $this->rolloCalibre . " " . $this->rolloPies . " PIES - " . $this->shortUnidad;
			}

			return mb_strtoupper(trim($result));
		}

		public function getFullDescripcionNoUnidad($mostrarCodigo = true)
		{
			$result ="";

			if ($this->isRollo == "0")
			{
				if ($this->shortTipoProducto == "AC")
				{
					// es un ACCESORIO
					// 					$result = ($mostrarCodigo  ? $this->codigo . " - " . " " : "") .
					$result = $this->codigo . " - " .
							$this->getDescripcion();

				}
				else
				{
					$result = ($mostrarCodigo  ? $this->codigo . " - " . " " : "") .
					" " . $this->getTipoProducto() .
					($this->aplicacion != NOAPLICA ? " " . $this->aplicacion : "") .
					($this->material != NOAPLICA ? " " . $this->material : "") .
					" CALIBRE " .$this->calibre .
					(strlen($this->longitud) > 0 ? " * " . $this->longitud . " ML " : "");
				}

			}
			else
			{
				$result = ($mostrarCodigo  ? $this->codigo . " - " . " " : "") .
				" " . $this->getTipoProducto() .
				($this->rolloMaterial != NOAPLICA ? " " . $this->rolloMaterial : "") .
				($this->rolloProveedor != NOAPLICA ? " " . $this->rolloProveedor : "") .
				" CALIBRE " . $this->rolloCalibre . " " . $this->rolloPies . " PIES";
			}

			return mb_strtoupper(trim($result));
		}

		public function getViewProducto($i)
		{
			return $this->lstProductos[$i];
		}

		public function getExistenciaToCero()
		{
			$existencia = $this->existencia - $this->apartado;
			return ($existencia > 0 ? $existencia : 0);
		}

		public function getAllView($idUsuario = 0, $esParaObra = false)
		{
			$result = array();
			$whereEsParaObra = " AND idRollo > 1 and idUnidad = 1 ";

			try
			{
				$SQL="SELECT
						viewproductos.idProducto,
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
						medidaespecial,
						idRollo,
						rolloCodigo,
						rolloIdMaterial,
						rolloMaterial,
						rolloShortMaterial,
						rolloIdProveedor,
						rolloProveedor,
						rolloShortProveedor,
						rolloCalibre,
						rolloPies,
						rolloPesokiloml,
						rolloDescripcion,
						idUnidad,
						unidad,
						shortUnidad,
						calibre,
						descripcion,
						existencia,
						tipoPrecio,
						isRango,
						tipoRango,
						isRollo,
						precio1,
						precio2,
						precio3,
						precio4,
                        preciomendez,
						estado,
						apartado,
						apartadoReal,
						descauto,
						IFNULL(f.favorito, 'NO') favorito
					FROM " . $this->__tableName . "
					left join favorito f on viewproductos.idproducto = f.idproducto and f.idusuario = ".$idUsuario."
					where precio1 > 0 and estado = 'ACTIVO' ". ($esParaObra ? $whereEsParaObra : "") ."
						ORDER BY aplicacion, material, rolloCalibre, rolloPies";							 
// ORDER BY aplicacion, material, rolloCalibe, rolloPies";
							// ORDER BY codigo";

// 				(tipoprecio = 'G' and precio1 > 0) or tipoprecio = 'T' or tipoprecio = 'I'
				$result=mysqli_query($this->dbLink,$SQL);

				if($result)
				{
					while($row=mysqli_fetch_assoc($result))
					{
						$producto = new ModeloViewproductos();


						$producto->setIdProducto($row["idProducto"]);
						$producto->setCodigo($row["codigo"]);
						$producto->setLongitud($row["longitud"]);
						$producto->setMlpieza($row["mlpieza"]);
						$producto->setIdTipoProducto($row["idTipoProducto"]);
						$producto->setTipoProducto($row["tipoProducto"]);
						$producto->setShortTipoProducto($row["shortTipoProducto"]);
						$producto->setIdAplicacion($row["idAplicacion"]);
						$producto->setAplicacion($row["aplicacion"]);
						$producto->setIdMaterial($row["idMaterial"]);
						$producto->setMaterial($row["material"]);
						$producto->setIdRollo($row["idRollo"]);
						$producto->setRolloCodigo($row["rolloCodigo"]);
						$producto->setRolloIdMaterial($row["rolloIdMaterial"]);
						$producto->setRolloMaterial($row["rolloMaterial"]);
						$producto->setRolloShortMaterial($row["rolloShortMaterial"]);
						$producto->setRolloIdProveedor($row["rolloIdProveedor"]);
						$producto->setRolloProveedor($row["rolloProveedor"]);
						$producto->setRolloShortProveedor($row["rolloShortProveedor"]);
						$producto->setRolloCalibre($row["rolloCalibre"]);
						$producto->setRolloPies($row["rolloPies"]);
						$producto->setRolloPesokiloml($row["rolloPesokiloml"]);
						$producto->setRolloDescripcion($row["rolloDescripcion"]);
						$producto->setIdUnidad($row["idUnidad"]);
						$producto->setUnidad($row["unidad"]);
						$producto->setShortUnidad($row["shortUnidad"]);
						$producto->setCalibre($row["calibre"]);
						$producto->setDescripcion($row["descripcion"]);
						$producto->setDescauto($row["descauto"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setTipoPrecio($row["tipoPrecio"]);
						$producto->setIsRango($row["isRango"]);
						$producto->setTipoRango($row["tipoRango"]);
						$producto->setIsRollo($row["isRollo"]);
						$producto->setPrecio1($row["precio1"]);
						$producto->setPrecio2($row["precio2"]);
						$producto->setPrecio3($row["precio3"]);
						$producto->setPrecio4($row["precio4"]);
						$producto->setPreciomendez($row["preciomendez"]);
						$producto->setEstado($row["estado"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setApartado($row["apartado"]);
						$producto->setApartadoReal($row["apartadoReal"]);

						$me = $row["medidaespecial"];
						if ($me == "") $me = "0";
						$producto->setMedidaespecial($me);
						// $producto->setMedidaespecial("holi");
						$producto->setFavorito($row["favorito"]);

						array_push($this->lstProductos, $producto);
					}
				}

			}
			catch (Exception $e)
			{
				//return $this->setErrorCatch($e);
			}
		}

		public function getAllViewMasVendidos($idUsuario)
		{
			$result = array();

			try
			{
				$SQL="SELECT
						v.idProducto,
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
						rolloIdMaterial,
						rolloMaterial,
						rolloShortMaterial,
						rolloIdProveedor,
						rolloProveedor,
						rolloShortProveedor,
						rolloCalibre,
						rolloPies,
						rolloPesokiloml,
						rolloDescripcion,
						idUnidad,
						unidad,
						shortUnidad,
						calibre,
						descripcion,
						existencia,
						tipoPrecio,
						isRango,
						tipoRango,
						isRollo,
						precio1,
						precio2,
						precio3,
						precio4,
                        preciomendez,
						estado,
						apartado,
						apartadoReal,
						descauto, 
						vendidos,
						IFNULL(f.favorito, 'NO') favorito
					from (select idproducto, count(*) vendidos 
							from pedidodetalle 
							where idproducto not in (9, 10)
							group by idproducto order by 2 desc limit 50) datos
					inner join viewproductos v on datos.idproducto = v.idproducto		
					left join favorito f on v.idproducto = f.idproducto and f.idusuario = ".$idUsuario."	
					where estado = 'ACTIVO'		
						ORDER BY vendidos desc, aplicacion, material, rolloCalibre, rolloPies";							 
// ORDER BY aplicacion, material, rolloCalibe, rolloPies";
							// ORDER BY codigo";

// 				(tipoprecio = 'G' and precio1 > 0) or tipoprecio = 'T' or tipoprecio = 'I'
				$result=mysqli_query($this->dbLink,$SQL);

				if($result)
				{
					while($row=mysqli_fetch_assoc($result))
					{
						$producto = new ModeloViewproductos();

						$producto->setIdProducto($row["idProducto"]);
						$producto->setCodigo($row["codigo"]);
						$producto->setLongitud($row["longitud"]);
						$producto->setMlpieza($row["mlpieza"]);
						$producto->setIdTipoProducto($row["idTipoProducto"]);
						$producto->setTipoProducto($row["tipoProducto"]);
						$producto->setShortTipoProducto($row["shortTipoProducto"]);
						$producto->setIdAplicacion($row["idAplicacion"]);
						$producto->setAplicacion($row["aplicacion"]);
						$producto->setIdMaterial($row["idMaterial"]);
						$producto->setMaterial($row["material"]);
						$producto->setIdRollo($row["idRollo"]);
						$producto->setRolloCodigo($row["rolloCodigo"]);
						$producto->setRolloIdMaterial($row["rolloIdMaterial"]);
						$producto->setRolloMaterial($row["rolloMaterial"]);
						$producto->setRolloShortMaterial($row["rolloShortMaterial"]);
						$producto->setRolloIdProveedor($row["rolloIdProveedor"]);
						$producto->setRolloProveedor($row["rolloProveedor"]);
						$producto->setRolloShortProveedor($row["rolloShortProveedor"]);
						$producto->setRolloCalibre($row["rolloCalibre"]);
						$producto->setRolloPies($row["rolloPies"]);
						$producto->setRolloPesokiloml($row["rolloPesokiloml"]);
						$producto->setRolloDescripcion($row["rolloDescripcion"]);
						$producto->setIdUnidad($row["idUnidad"]);
						$producto->setUnidad($row["unidad"]);
						$producto->setShortUnidad($row["shortUnidad"]);
						$producto->setCalibre($row["calibre"]);
						$producto->setDescripcion($row["descripcion"]);
						$producto->setDescauto($row["descauto"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setTipoPrecio($row["tipoPrecio"]);
						$producto->setIsRango($row["isRango"]);
						$producto->setTipoRango($row["tipoRango"]);
						$producto->setIsRollo($row["isRollo"]);
						$producto->setPrecio1($row["precio1"]);
						$producto->setPrecio2($row["precio2"]);
						$producto->setPrecio3($row["precio3"]);
						$producto->setPrecio4($row["precio4"]);
						$producto->setPreciomendez($row["preciomendez"]);
						$producto->setEstado($row["estado"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setApartado($row["vendidos"]);
						$producto->setApartadoReal($row["apartadoReal"]);

						
						// $producto->setFavorito($row["favorito"]);

						array_push($this->lstProductos, $producto);
					}
				}

			}
			catch (Exception $e)
			{
				//return $this->setErrorCatch($e);
			}
		}

		public function getAllViewFavoritos($idUsuario)
		{
			$result = array();

			try
			{
				$SQL="SELECT
						v.idProducto,
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
						rolloIdMaterial,
						rolloMaterial,
						rolloShortMaterial,
						rolloIdProveedor,
						rolloProveedor,
						rolloShortProveedor,
						rolloCalibre,
						rolloPies,
						rolloPesokiloml,
						rolloDescripcion,
						idUnidad,
						unidad,
						shortUnidad,
						calibre,
						descripcion,
						existencia,
						tipoPrecio,
						isRango,
						tipoRango,
						isRollo,
						precio1,
						precio2,
						precio3,
						precio4,
                        preciomendez,
						estado,
						apartado,
						apartadoReal,
						descauto, 						
						IFNULL(favorito.favorito, 'NO') favorito
					from favorito
					inner join viewproductos v on favorito.idproducto = v.idproducto		
					where favorito.idusuario = ".$idUsuario."	
						and favorito.favorito = 'SI'		
						AND estado = 'ACTIVO'		
						ORDER BY  aplicacion, material, rolloCalibre, rolloPies";							 
// ORDER BY aplicacion, material, rolloCalibe, rolloPies";
							// ORDER BY codigo";

// 				(tipoprecio = 'G' and precio1 > 0) or tipoprecio = 'T' or tipoprecio = 'I'
				$result=mysqli_query($this->dbLink,$SQL);

				if($result)
				{
					while($row=mysqli_fetch_assoc($result))
					{
						$producto = new ModeloViewproductos();

						$producto->setIdProducto($row["idProducto"]);
						$producto->setCodigo($row["codigo"]);
						$producto->setLongitud($row["longitud"]);
						$producto->setMlpieza($row["mlpieza"]);
						$producto->setIdTipoProducto($row["idTipoProducto"]);
						$producto->setTipoProducto($row["tipoProducto"]);
						$producto->setShortTipoProducto($row["shortTipoProducto"]);
						$producto->setIdAplicacion($row["idAplicacion"]);
						$producto->setAplicacion($row["aplicacion"]);
						$producto->setIdMaterial($row["idMaterial"]);
						$producto->setMaterial($row["material"]);
						$producto->setIdRollo($row["idRollo"]);
						$producto->setRolloCodigo($row["rolloCodigo"]);
						$producto->setRolloIdMaterial($row["rolloIdMaterial"]);
						$producto->setRolloMaterial($row["rolloMaterial"]);
						$producto->setRolloShortMaterial($row["rolloShortMaterial"]);
						$producto->setRolloIdProveedor($row["rolloIdProveedor"]);
						$producto->setRolloProveedor($row["rolloProveedor"]);
						$producto->setRolloShortProveedor($row["rolloShortProveedor"]);
						$producto->setRolloCalibre($row["rolloCalibre"]);
						$producto->setRolloPies($row["rolloPies"]);
						$producto->setRolloPesokiloml($row["rolloPesokiloml"]);
						$producto->setRolloDescripcion($row["rolloDescripcion"]);
						$producto->setIdUnidad($row["idUnidad"]);
						$producto->setUnidad($row["unidad"]);
						$producto->setShortUnidad($row["shortUnidad"]);
						$producto->setCalibre($row["calibre"]);
						$producto->setDescripcion($row["descripcion"]);
						$producto->setDescauto($row["descauto"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setTipoPrecio($row["tipoPrecio"]);
						$producto->setIsRango($row["isRango"]);
						$producto->setTipoRango($row["tipoRango"]);
						$producto->setIsRollo($row["isRollo"]);
						$producto->setPrecio1($row["precio1"]);
						$producto->setPrecio2($row["precio2"]);
						$producto->setPrecio3($row["precio3"]);
						$producto->setPrecio4($row["precio4"]);
						$producto->setPreciomendez($row["preciomendez"]);
						$producto->setEstado($row["estado"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setApartado($row["apartado"]);
						$producto->setApartadoReal($row["apartadoReal"]);

						$producto->setFavorito($row["favorito"]);

						array_push($this->lstProductos, $producto);
					}
				}

			}
			catch (Exception $e)
			{
				//return $this->setErrorCatch($e);
			}
		}


		public function getViewProductoByCodigo($codigo, $idProducto = 0)
		{
			$result = array();

			$where = "";

			if ($codigo != "")
			{
				$where = "codigo = '".$codigo."' or descauto like '%".$codigo."%'";
			}
			else
			{
				$where = "idProducto = ".$idProducto;
			}

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
						rolloIdMaterial,
						rolloMaterial,
						rolloShortMaterial,
						rolloIdProveedor,
						rolloProveedor,
						rolloShortProveedor,
						rolloCalibre,
						rolloPies,
						rolloDescripcion,
						idUnidad,
						unidad,
						shortUnidad,
						calibre,
						rolloPesokiloml,
						descripcion,
						existencia,
						tipoPrecio,
						isRango,
						tipoRango,
						isRollo,
						precio1,
						precio2,
						precio3,
						precio4,
                        preciomendez,
						estado,
						apartado,
						apartadoReal,
						descauto
					FROM " . $this->__tableName . "
				   WHERE ".$where." LIMIT 1";


				$result=mysqli_query($this->dbLink,$SQL);

				if($result)
				{
					while($row=mysqli_fetch_assoc($result))
					{
						$producto = new ModeloViewproductos();

						$producto->setIdProducto($row["idProducto"]);
						$producto->setCodigo($row["codigo"]);
						$producto->setLongitud($row["longitud"]);
						$producto->setMlpieza($row["mlpieza"]);
						$producto->setIdTipoProducto($row["idTipoProducto"]);
						$producto->setTipoProducto($row["tipoProducto"]);
						$producto->setShortTipoProducto($row["shortTipoProducto"]);
						$producto->setIdAplicacion($row["idAplicacion"]);
						$producto->setAplicacion($row["aplicacion"]);
						$producto->setIdMaterial($row["idMaterial"]);
						$producto->setMaterial($row["material"]);
						$producto->setIdRollo($row["idRollo"]);
						$producto->setRolloCodigo($row["rolloCodigo"]);
						$producto->setRolloIdMaterial($row["rolloIdMaterial"]);
						$producto->setRolloMaterial($row["rolloMaterial"]);
						$producto->setRolloShortMaterial($row["rolloShortMaterial"]);
						$producto->setRolloIdProveedor($row["rolloIdProveedor"]);
						$producto->setRolloProveedor($row["rolloProveedor"]);
						$producto->setRolloShortProveedor($row["rolloShortProveedor"]);
						$producto->setRolloCalibre($row["rolloCalibre"]);
						$producto->setRolloPies($row["rolloPies"]);
						$producto->setRolloPesokiloml($row["rolloPesokiloml"]);
						$producto->setRolloDescripcion($row["rolloDescripcion"]);
						$producto->setIdUnidad($row["idUnidad"]);
						$producto->setUnidad($row["unidad"]);
						$producto->setShortUnidad($row["shortUnidad"]);
						$producto->setCalibre($row["calibre"]);
						$producto->setDescripcion($row["descripcion"]);
						$producto->setDescauto($row["descauto"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setTipoPrecio($row["tipoPrecio"]);
						$producto->setIsRango($row["isRango"]);
						$producto->setTipoRango($row["tipoRango"]);
						$producto->setIsRollo($row["isRollo"]);
						$producto->setPrecio1($row["precio1"]);
						$producto->setPrecio2($row["precio2"]);
						$producto->setPrecio3($row["precio3"]);
						$producto->setPrecio4($row["precio4"]);
						$producto->setPreciomendez($row["preciomendez"]);
						$producto->setEstado($row["estado"]);
						$producto->setExistencia($row["existencia"]);
						$producto->setApartado($row["apartado"]);
						$producto->setApartadoReal($row["apartadoReal"]);

						array_push($this->lstProductos, $producto);
					}
				}

			}
			catch (Exception $e)
			{
				//return $this->setErrorCatch($e);
			}
		}

		public function getView($idProducto)
		{
			if($idProducto==0||$idProducto==""||!is_numeric($idProducto)|| (is_string($idProducto)&&!ctype_digit($idProducto)))return $this->setError("Tipo de dato incorrecto para idProducto.");
			$this->idProducto=$idProducto;
			$this->getDatos();
		}
		
		public function getViewSucursal($idProducto, $idSucursal)
		{
		    if($idProducto==0||$idProducto==""||!is_numeric($idProducto)|| (is_string($idProducto)&&!ctype_digit($idProducto)))return $this->setError("Tipo de dato incorrecto para idProducto.");
		    $this->idProducto=$idProducto;
		    $this->getDatosSucursal($idSucursal);
		}

		public function getViewGlobal($idProducto)
		{
			if($idProducto==0||$idProducto==""||!is_numeric($idProducto)|| (is_string($idProducto)&&!ctype_digit($idProducto)))return $this->setError("Tipo de dato incorrecto para idProducto.");
			$this->idProducto=$idProducto;
			$this->getDatosGlobal();
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		public function getDatosSucursal($idSucursal)
		{
		    try
		    {
		        $SQL="SELECT
						viewproductos.idProducto,
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
						rolloExistencia rolloExistenciaGlobal,
						getExistenciasRolloSucursal(".$idSucursal.", idRollo) rolloExistencia,
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
						rolloTotalpreciovtar4,
						idUnidad,
						unidad,
						shortUnidad,
						calibre,
						pies,
						descripcion,
                        ifnull(inventariosucursal.idinventariosucursal, 0) idinventariosucursal,
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
						precio4,
                        preciomendez,
						estado,
						descauto
					FROM " . $this->__tableName . "
                    LEFT JOIN inventariosucursal 
                        on viewproductos.idproducto = inventariosucursal.idproducto
                        and inventariosucursal.idsucursal = ". $idSucursal ."
					WHERE viewproductos.idProducto =" . mysqli_real_escape_string($this->dbLink,$this->idProducto);
		        
		        
// ifnull(inventariosucursal.existencia, 0) existencia, 
//                         ifnull(inventariosucursal.apartado,0) apartado,												

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
		        // return $this->setError() setErrorCatch($e);
		    }
		}

		public function getDatosGlobal()
		{
		    try
		    {
		        $SQL="SELECT
						viewproductos.idProducto,
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
						rolloExistencia rolloExistenciaGlobal,
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
						rolloTotalpreciovtar4,
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
						precio4,
                        preciomendez,
						estado,
						descauto
					FROM " . $this->__tableName . "                    
					WHERE viewproductos.idProducto =" . mysqli_real_escape_string($this->dbLink,$this->idProducto);
		        
		        
// ifnull(inventariosucursal.existencia, 0) existencia, 
//                         ifnull(inventariosucursal.apartado,0) apartado,												

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
		        // return $this->setError() setErrorCatch($e);
		    }
		}
		
		
		public function validarDatos()
		{
			return true;
		}


	}
