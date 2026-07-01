<?php

	require FOLDER_MODEL_BASE . "model.base.cotizacion.inc.php";

	require_once FOLDER_MODEL. "model.pesomt.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.cotizacion.inc.php";
	require_once FOLDER_MODEL. "model.cotizaciondetalle.inc.php";

	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.rollo.inc.php";
	

	class ModeloCotizacion extends ModeloBaseCotizacion
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBaseCotizacion";

		var $__ss=array();
		var $__primaryKey="idCotizacion";				
		var $__tableName="cotizacion";
		var $__tableEdit="cotizacionedit";
		var $__tableDelete="cotizaciondelete";				

		var $__isDebugging= false;				

		var $lstProductos = array();
		var $lstRenglones = array();

		public $__rsCotizacionWDetalle;

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



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function validarDatos()
		{
			return true;
		}

		public function getDetalleCotizacion()
		{
			$result = array();

			try
			{
				$SQL="SELECT
						cd.idCotizacionDetalle,
						cd.renglon, cd.idRolloBase, cd.tipoPrecio, cd.partida, cd.cantidad, cd.cantidadReal, cd.desarrollo, cd.dobleces,
						cd.curvar, cd.curvatura, cd.pesoKiloML, cd.molLaminasATomar, cd.molPrecioDobleces, cd.molPrecioCorte, cd.molIsScrap, 
						cd.molTotalcmScrap, cd.molDescMaquila, cd.molLongitudinal,
						v.idProducto, v.codigo,	v.longitud,	v.mlpieza,	v.idTipoProducto, v.tipoProducto,
						v.shortTipoProducto,v.idAplicacion,v.aplicacion,v.idMaterial,v.material,v.idRollo,
						v.rolloCodigo,	v.rolloIdMaterial,	v.rolloMaterial,v.rolloShortMaterial,v.rolloIdProveedor,
						v.rolloProveedor,v.rolloShortProveedor,v.rolloCalibre,v.rolloPies,v.rolloPesokiloml,
						v.rolloDescripcion,v.idUnidad,v.unidad,v.shortUnidad,	v.calibre,v.descripcion,
						v.existencia,v.tipoPrecio,v.isRango,v.tipoRango,v.isRollo,v.precio1,v.precio2,v.precio3,
                        v.preciomendez,v.estado,v.apartado,v.apartadoReal,v.descauto
					FROM  cotizaciondetalle cd
					INNER JOIN viewproductos v ON cd.idProducto = v.idProducto
					WHERE cd.idCotizacion = " . $this->idCotizacion . "
					ORDER BY cd.renglon ";

// 				(tipoprecio = 'G' and precio1 > 0) or tipoprecio = 'T' or tipoprecio = 'I'
				
				// return mysqli_query($this->dbLink,$SQL);
				$result=mysqli_query($this->dbLink,$SQL);

				if($result)
				{
					while($row=mysqli_fetch_assoc($result))
					{
						$renglon = new ModeloCotizaciondetalle();

						$renglon->setIdCotizacionDetalle($row["idCotizacionDetalle"]);
						

						array_push($this->lstRenglones, $renglon);

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

		public function pasarCotizacionAPedido($idCotizacion)
		{
			global $objSession;
			$blnCommit = true;

			$pedido = new ModeloPedido();
			// $cotizacion = new ModeloCotizacion();

			// $this->transaccionIniciar();

			$this->setIdCotizacion($idCotizacion);

			$pedido->setIdCliente($this->getIdCliente());
			$pedido->setSubtotal($this->getSubtotal());
			$pedido->setIva($this->getIva());
			$pedido->setDescuento($this->getDescuento());
			$pedido->setTotal($this->getTotal());
			$pedido->setSaldo($this->getTotal());

			$pedido->setPersonaEntrega($this->getPersonaEntrega());
			$pedido->setRecogeentrega($this->getRecogeentrega());
			$pedido->setDomicilioEntrega($this->getDomicilioEntrega());
			$pedido->setNumeroEntrega($this->getNumeroEntrega());
			$pedido->setColoniaEntrega($this->getColoniaEntrega());
			$pedido->setCiudadEntrega($this->getCiudadEntrega());
			$pedido->setTipo($this->getTipo());
			$pedido->setIdSucursalPreferenciaRecoge($this->getIdSucursalPreferenciaRecoge());
			$pedido->setObservacionCaptura($this->getObservacionCaptura());

			$pedido->setPorDescuento($this->getPorDescuento());

			$pedido->setMaxDescuentoIndividual($this->getMaxDescuentoIndividual());
			$pedido->setDescuentoIndividual($this->getDescuentoIndividual());
			$pedido->setOtrosCargos($this->getOtrosCargos());
			$pedido->setIdUsoCfdi($this->getIdUsoCfdi());
						
						
			$pedido->setRangosString($this->getRangosString());
						
			$pedido->setFecha_limitepago($this->getFecha_limitepago());
			$pedido->setFechaCompromiso($this->getFechaCompromiso());
						
					
			$pedido->setFechaEntregaPorDefinir($this->getFechaEntregaPorDefinir());


			$pedido->setTipoObra($this->getTipoObra());
			$pedido->setHoraRecibe($this->getHoraRecibe());
			$pedido->setFechaAbierta($this->getFechaAbierta());

			$pedido->setPedidoExpress($this->getPedidoExpress());
					
			$pedido->setDateAndUser("capturado");

			if ($pedido->getIdCliente() == 137)
            {
                $pedido->setEstadoAUTORIZADO();
                $pedido->setDateAndUser("autorizado");
                $pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO MDM");
                
                
                
            }

			$pedido->setIdcotizacion($idCotizacion);
			$pedido->Guardar();

			if (!$pedido->getError())
			{
				$det = new ModeloPedidodetalle();
				$cd = new ModeloCotizaciondetalle();

				$lstOtrosCargos = $this->getDataSet("Select idOtrosCargosCotizacion from otroscargoscotizacion where idCotizacion = ".$this->getIdCotizacion()." order by idOtrosCargosCotizacion");
				foreach ($lstOtrosCargos as $row)
                {
					$oc = new ModeloOtroscargoscotizacion();
					$oc->setIdOtrosCargosCotizacion($row["idOtrosCargosCotizacion"]);
				
                    $ocp = new ModeloOtroscargospedido();
                                
                	$ocp->setIdPedido($pedido->getIdPedido());
                    $ocp->setIdOtroCargo($oc->getIdotrocargo());
                                //                             cantidad
                    $ocp->setCantidadIngreso($oc->getCantidadIngreso());
                    $ocp->setMonto($oc->getMonto());
                                
                    $ocp->Guardar();
                                
                    if ($ocp->getError())
                    {                          
                    	$blnCommit = false;
                        break;
                    }
                        
                        
                        
                }

				$lstRenglonesCotizacion = $this->getDataSet("Select idCotizacionDetalle from cotizaciondetalle where idCotizacion = ".$this->getIdCotizacion()." order by idCotizacionDetalle");
				
				foreach ($lstRenglonesCotizacion as $row) 
				{
					
					$cd = new ModeloCotizaciondetalle();
					$cd->setIdCotizacionDetalle($row["idCotizacionDetalle"]);

					// echo "A guardar ".$cd->getIdCotizacionDetalle()."<br>";

					$det = new ModeloPedidodetalle();

					$det->setIdPedido($pedido->getIdPedido());
					$det->setRenglon($cd->getRenglon());
					$det->setIdProducto($cd->getIdProducto());
					
					$det->setTipoPrecio($cd->getTipoPrecio());
					$det->setPartida($cd->getPartida());
					$det->setCantidad($cd->getCantidad());
					$det->setCantidadReal($cd->getCantidadReal());
					
					$det->setPesoKiloML($cd->getPesoKiloML());
					
					$det->setMolIsScrap($cd->getMolIsScrap());
						
					$det->setMolTotalcmScrap($cd->getMolTotalcmScrap());
					$det->setMolLongitudinal($cd->getMolLongitudinal());
					
					//Molduras
					$det->setMolLaminasATomar($cd->getMolLaminasATomar());
					$det->setMolPrecioDobleces($cd->getMolPrecioDobleces());
					$det->setMolPrecioCorte($cd->getMolPrecioCorte());
						
					//Maquila
					
					$det->setMolDescMaquila($cd->getMolDescMaquila());
					
					$det->setExplotarUnidad($cd->getExplotarUnidad());
					$det->setTotalExplotar($cd->getTotalExplotar());
					
					$det->setCurvar($cd->getCurvar());
					$det->setCurvatura($cd->getCurvatura());
										
					//Molduras
					$det->setIdRolloBase($cd->getIdRolloBase());			
											
					$det->setDesarrollo($cd->getDesarrollo());    
					$det->setDobleces($cd->getDobleces());
					
					$det->setPrecioUnitario($cd->getPrecioUnitario());
					$det->setTotal($cd->getTotal());

					$det->Guardar();

					if ($det->getError())
					{
						// echo "NO guardado <br>";
						$blnCommit = false;
						break;
					}
					else
					{
						// echo "guardado <br>";
					}

					
				}

				$this->setIdPedido($pedido->getIdPedido());

				$this->Guardar();

				if ($this->getError())
				{
					// echo "errorCotizacionUpdatePedido";
					$blnCommit = false;
				}
			}
			else 
			{
				$blnCommit = false;
			}

			if ($blnCommit)
			{
				$pedido->NotificaAltaPedido();
				// $this->transaccionCommit();    
			}
			else 
			{
				// $this->transaccionRollback();    
			}

			return $blnCommit;
		}
		
		public function getCotizacion($idCotizacion, $limit = "")
		{
			
			$query = "SELECT  c.idPedido, c.subtotal, c.iva, c.descuento, c.pordescuento, c.total, c.anticipo, c.saldada, 
							c.fechaAbierta, c.pedidoExpress, c.idUsoCfdi,
							c.tipoObra, c.fechaEntregaPorDefinir,
							c.estado, c.observaciones,                          
							c.recogeentrega, c.personaEntrega, c.domicilioEntrega, c.numeroEntrega, c.coloniaEntrega, c.ciudadEntrega, c.horaRecibe, c.fechaCompromiso, c.tipo,
							c.idCliente, cl.nombre as cteNombre, cl.apellidos as cteApellidos, 
							cl.empresa as cteEmpresa, cl.razonsocial as cteRazonSocial, cl.domicilio1 as cteDomicilio1, cl.domicilio2 as cteDomicilio2,
							cl.numero as cteNumero, cl.colonia as cteColonia, cl.ciudad as cteCiudad,cl.domiciliofiscal as cteDomicilioFiscal,cl.codigopostalfiscal as cteCPFiscal,
							cl.telefonos as cteTelefonos, cl.email as cteEMail, cl.rfc as cteRFC, cl.estado as cteEstado,
							cl.numerofiscal as cteNumeroFiscal, cl.coloniafiscal as cteColoniaFiscal, cl.ciudadfiscal as cteCiudadFiscal, cl.idUsoCfdi as cteUsoCfdi,
							cl.rangoCliente, 
							cl.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
					c.fecha_capturado, c.id_usuario_capturado, capturado.nombre as capturadoNombre, capturado.apellidoPaterno as capturadoAPaterno, capturado.apellidoMaterno as capturadoAMaterno, c.observacionCaptura,						 
							cd.idCotizacionDetalle, cd.renglon as detRenglon,
							cd.idProducto as detIdProducto,
							vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto, 
							vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
							vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial, 
							vp.medidaespecial as proMedidaEspecial,
							vp.material as proMaterial, vp.idColor, vp.color,
							vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
							vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion, vp.rollodescauto, 
							vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
							vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
							vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
							cd.tipoPrecio as detTipoPrecio, cd.partida as detPartida, cd.cantidad as detCantidad, cd.cantidadReal as detCantidadReal, cd.desarrollo as detDesarrollo,
							cd.dobleces as detDobleces, cd.precioUnitario as detPrecioUnitario, cd.total as detTotal,
							cd.explotarUnidad as detExplotarUnidad, cd.totalExplotar as detTotalExplotar,
					cd.curvar, cd.curvatura, cd.molDescMaquila,
							cd.molLaminasATomar, cd.molIsScrap, cd.molTotalcmScrap, cd.molLongitudinal, cd.pesoKiloML, cd.idRolloBase,
							ifnull(sucpreferente.idsucursal,0) idSucursalPreferente, ifnull(sucpreferente.nombre,'POR CONFIRMAR') sucursalPreferente							
						FROM cotizacion as c
						LEFT JOIN cotizaciondetalle as cd
						ON cd.IdCotizacion = c.idCotizacion
						LEFT JOIN viewproductos as vp
						ON vp.idProducto = cd.idProducto
				LEFT JOIN viewrollos as vrmol
						ON vrmol.idRollo = cd.idRolloBase
						INNER JOIN cliente as cl
						ON cl.idCliente = c.idCliente
						INNER JOIN usuario as promotor
						ON promotor.idUsuario = cl.idUsuarioPromotor
						INNER JOIN usuario as capturado
						ON capturado.idUsuario = c.id_usuario_capturado
						LEFT JOIN sucursal sucpreferente
                       ON c.idSucursalPreferenciaRecoge = sucpreferente.idSucursal
					WHERE c.idCotizacion = " . $idCotizacion . " " . $limit;
									
			$this->__rsCotizacionWDetalle = $this->getDataSet($query);
		}

		public function getPedidoDato($column)
		{
			$dato = "";
		
			if (count($this->__rsCotizacionWDetalle) > 0)
			{
				if (isset($this->__rsCotizacionWDetalle[0][$column]))
				{
					$dato = $this->__rsCotizacionWDetalle[0][$column];
				}
			}
		
			return $dato;
		}

		private function logDebug($msg = "")
		{
          if ($this->__isDebugging) echo $msg . "<br>";
		}



		public function verificarSiCotizacionPuedeSurtirseParaPasarAPedido($idCotizacion)
		 {

			$this->logDebug("Comenzando con Cotizacion: " . $idCotizacion);
						
			$resultado = array(
				"surteInventario" => false,
				"surteRollos" => false,
				"surteAmbos" => false,
				"soloInventario" => true,
				"soloRollos" => true,
				"Surtir" => array(),
				"NoSurtir" => array()				
				);

			// return $resultado;}

			$idProductoMoldura = 9;

			$idProductoMaquilaMoldura = 10;

			$idProductoISOCOP = 439;





			$pesomt = new ModeloPesomt();

			$pesosCalibresPies = array();

			$cotizacionProcesando = new ModeloCotizacion($idCotizacion);
			// $pedidoProcesando = new ModeloPedido();		
			// $idPedidoProcesando = $idPedidoToCheck;
			$idCotizacionProcesando = $idCotizacion;

			//$pedidoProcesando->setIdPedido($idPedidoProcesando);
			$this->logDebug("Cargando Cotizacion: " . $idCotizacion);
			$cotizacionProcesando->setIdCotizacion($idCotizacion);		

			// $cotizacionProcesando->dumpObj();
		
			$idSucursal = 0;			
		
			// $idSucursal = $pedidoProcesando->getIdSucursalPreferenciaRecoge();
		
			
		
			// if ($idSucursal <= 0)
		
			// {
		
			// 	$idSucursal = $pedidoProcesando->getIdSucursalCapturado();
		
			// }
		
						
		
			$pedidoDetalle = new ModeloPedidodetalle();
			$cotizacionDetalle = new ModeloCotizaciondetalle();
				
			// if ($pedidoProcesando->getIdPedido() > 0)
			if ($cotizacionProcesando->getIdCotizacion() > 0)
		
			{
		
				$this->logDebug("\t\t---------------------------------------------------------");
		
				$this->logDebug("\t\tVerificando Inventarios de Cotizacion: <strong style='color: blue'>" . $idCotizacionProcesando . "</strong>");
		
				$this->logDebug();
		
		
				//Obtenemos el detalle de la cotizacion
		
				$lstCotizacionDetalle = $cotizacionDetalle->getAll("idCotizacionDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, partida totalExplotado",
		
					"",
		
					"idcotizacion = " . $idCotizacionProcesando . " ");
		
				
		
				//echo $pedidoDetalle->getAllQUERY("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir", "", "idPedido = " . $idPedidoProcesando);
		
				// 		$pedidoProcesando->transaccionIniciar();
		
				$cuantosRenglones = count($lstCotizacionDetalle);
				
				$this->logDebug("\t\t ___");
				$this->logDebug("\t\tRenglones Pedido: <span style='color: blue'>" . $cuantosRenglones . "</span>");
				
				if ($cuantosRenglones > 0)
				{
					
					$doCommitPedido = true;
				}
				else
				{
					$doCommitPedido = false;
				}
				
		
				
		
				$this->logDebug();
		
				$this->logDebug("\t\t// + + + + +");
		
				$this->logDebug("\t\t//  Comenzamos Analisis de inventarios");
		
				$this->logDebug("\t\t// + + + + +");
		
				$this->logDebug();
		
				
		
				////$arrColocaciones = array();
		
				
		
				// $pedidoProcesando->transaccionIniciar();
		
				
		
				foreach ($lstCotizacionDetalle as $det)
		
				{
		
					// 		echo "<br>".$det["idPedidoDetalle"]."  -  ".$det["renglon"]."  -  ".$det["idProducto"];
		
					$this->logDebug();
		
					$this->logDebug("\t\tR E N G L O N: " .$det["renglon"]."          -idPedidoDetalle: ".$det["idCotizacionDetalle"]."    -idProducto: ".$det["idProducto"]."    -partida: ".$det["partida"]."    -cantidad: ".$det["cantidad"]."    -cantidadReal: ".$det["cantidadReal"]);
		
					$this->logDebug();
		
					
		
					$idCotizacionDetalle = $det["idCotizacionDetalle"];
		
					$updateCotizacionDetalle = new ModeloCotizaciondetalle();
		
					
		
					$updateCotizacionDetalle->setIdCotizacionDetalle($idCotizacionDetalle);
		
					
		
					$viewProducto = new ModeloViewproductos();
		
					// $viewProducto->getViewSucursal($det["idProducto"], $idSucursal);
					$viewProducto->getView($det["idProducto"]);
		
					
		
					if (!isset($productosApartados["pieza".$viewProducto->getIdProducto()]))
		
					{
		
						// $this->logCliente("\t\t                -                -  Se crea objeto: pieza" . $viewProducto->getIdProducto());
		
						$productosApartados["pieza".$viewProducto->getIdProducto()] = $viewProducto->getExistencia() - $viewProducto->getApartado();
		
					}
		
					
		
					if (!isset($productosApartados["rollo".$viewProducto->getIdRollo()]))
		
					{
		
						// $this->logCliente("\t\t                -                -  Se crea objeto: rollo" . $viewProducto->getIdRollo());
		
						$productosApartados["rollo".$viewProducto->getIdRollo()] = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();
		
					}
		
					
		
					$totalAExplotar = $updateCotizacionDetalle->getPartida() ; //$updatePedidoDetalle->getTotalExplotar();
		
					// 			$partida = $det["partida"];
		
					// 			$cantidad = $det["cantidad"];
		
					// 			$cantidadReal = $det["cantidadReal"];
		
					
		
					// 		$viewProducto->dumpAsTable();
		
					$this->logDebug();
		
					$this->logDebug("\t\tProducto: ". $viewProducto->getFullDescripcion());
		
					$this->logDebug("\t\t idRollo => " . $viewProducto->getIdRollo());
		
					// 		$producto->dumpObj();
		
					
		
					// 			$calibreProducto = $viewProducto->getRolloCalibre();
		
					
		
					$calibreProducto = $viewProducto->getRolloCalibre();
		
					$piesProducto = $viewProducto->getRolloPies();
		
					//                         $piesProductosinpunto = str_replace(".00", "", $piesProducto);
		
					//                         $piesProductosinpunto = str_replace(".", "", $piesProductosinpunto);
		
					
		
					
		
					$deDondeDescontar = 0;
		
					$idProductoToCheck = 0;
		
										
		
					if ($viewProducto->getIdProducto() != $idProductoMoldura  && $viewProducto->getIdProducto() != $idProductoMaquilaMoldura && $viewProducto->getIdProducto() != $idProductoISOCOP)
		
					{
		
						if ($viewProducto->getShortUnidad() == "PZA" || $viewProducto->getShortUnidad() == "KG" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1))
		
						{
		
							if ($viewProducto->getShortUnidad() == "PZA" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1))
		
							{
		
								$idProductoToCheck = $viewProducto->getIdProducto();

								$resultado["soloRollos"] = false;
		
								
		
								if (!isset($productosNegados["pn".$idProductoToCheck]))
		
								{
		
									$this->logDebug();
		
									$this->logDebug("\t\tSACAR DE   I N V E N T A R I O ");
		
									$this->logDebug("\t\t   Producto Existencia: " . $viewProducto->getExistencia() . "        Apartado: " . $viewProducto->getApartado());
		
									$this->logDebug("\t\t   SACAR => " . $totalAExplotar);
		
									$this->logDebug("\t\t    =>=>  Quitamos(Simulacro) de Inventario ");
		
									
		
									
									$deDondeDescontar = $productosApartados["pieza".$viewProducto->getIdProducto()];
		
									
		
									// $this->logCliente("\t\t --- --- => DeDondeSacar: " . $deDondeDescontar);
		
									
		
									if($deDondeDescontar >= $totalAExplotar)
		
									{
		
		
										$this->logDebug("\t\t ---------------->>>>>>> Listo para Asignar SI");
		
									
										array_push($resultado["Surtir"], $det);
										
		
										// $coloca = new ModeloPedidodetallecolocacion();
		
										
		
										// $coloca->setIdPedidoDetalle($updateCotizacionDetalle->getIdCotizacionDetalle());
		
										// $coloca->setIdSucursal($idSucursal);
		
										// $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
		
										
		
										// $coloca->setCantidad($totalAExplotar);
		
										
		
										// array_push($arrColocaciones, $coloca);
		
										
		
									}
		
									else
		
									{
		
										$this->logDebug("\t\t <strong style='color: red'>**------- >  no alcanza a salir la mercancia, no se puede proceder con este Pedido</strong>");
		
										$doCommitPedido = false;
		
										// $this->logCliente("\t\t   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");
		
										array_push($resultado["NoSurtir"], $det);
		
									}
		
								}
		
								else
		
								{
		
									$this->logClogDebugliente("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanzo a surtirse, no se verifica producto</strong>");
		
									$doCommitPedido = false;
		
								}
		
								
		
								
		
								
		
							}
		
							else
		
							{
		
								
		
								$idProductoToCheck = $viewProducto->getIdProducto();
		
								$resultado["soloInventario"] = false;
		
								if (!isset($productosNegados["pn".$idProductoToCheck]))
		
								{
		
									$this->logDebug();
		
									$this->logDebug("\t\tSACAR DE     R O L L O");
		
									$this->logDebug("\t\t Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());
		
									
		
									$sacarRollo = new ModeloRollo();
		
									$sacarRollo->setIdRollo($viewProducto->getIdRollo());
		
									
		
									$this->logDebug("\t\t   SACAR DE CALIBRE ".$viewProducto->getRolloCalibre()." => ". $totalAExplotar);
		
									$this->logDebug("\t\t    =>=>  Quitamos(Simulacro) de Rollo AA");
		
									
		
									
		
									$deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];
		
									
		
									$this->logDebug("\t\t --- --- => DeDondeSacar: " . $deDondeDescontar);
		
									
		
									if($deDondeDescontar >= $totalAExplotar)
		
									{
		
										$this->logDebug("\t\t ---------------->>>>>>> Listo para Asignar SI");
		
										array_push($resultado["Surtir"], $det);
										
		
										// $coloca = new ModeloPedidodetallecolocacion();
		
										
		
										// $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
		
										// $coloca->setIdSucursal($idSucursal);
		
										// $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
		
										
		
										// $coloca->setCantidad($totalAExplotar);
		
										
		
										// array_push($arrColocaciones, $coloca);
		
									}
		
									else
		
									{
		
										$this->logDebug("\t\t <strong style='color: red'>------- >  no alcanza a salir la mercancía, no se puede proceder con este Pedido</strong>");
		
										$doCommitPedido = false;
		
										// $this->logDebug("\t\t   }}}}}}}}}}}}}}}}}}      Se Negará Producto para futura Explosión</strong>");
										array_push($resultado["NoSurtir"], $det);
										
		
									}
		
									
		
								}
		
								else
		
								{
		
									$this->logDebug("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto</strong>");
		
									$doCommitPedido = false;
		
								}
		
								
		
							}
		
							
		
						}
		
						else
		
						{
		
							$idProductoToCheck = $viewProducto->getIdProducto();
		
							$resultado["soloInventario"] = false;
		
							if (!isset($productosNegados["pn".$idProductoToCheck]))
		
							{
		
								$this->logDebug();
		
								$this->logDebug("\t\tSACAR DE    R O L L O");
		
								$this->logDebug("\t\t Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());
		
								
		
								
		
								$this->logDebug("\t\t   SACAR DE CALIBRE ".$calibreProducto." => ". $totalAExplotar);
		
								$this->logDebug("\t\t    =>=>  Quitamos(Simulacro) de Rollo BB");
		
								
		
								// 					$deDondeDescontar = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();
		
								$deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];
		
								$this->logDebug("\t\t --- --- => DeDondeSacar: " . $deDondeDescontar);
		
								$kilosAExplotar = $updateCotizacionDetalle->getTotalExplotar();
		
								$this->logDebug("\t\t     --- ===> " . $kilosAExplotar);
		
								
		
								
		
								if ($totalAExplotar > 0)
		
								{
		
									$sacarRollo = new ModeloRollo();
		
									$sacarRollo->setIdRollo($viewProducto->getIdRollo());
		
									
		
									//                             if($deDondeDescontar >= $totalAExplotar)
		
									if($deDondeDescontar >= $kilosAExplotar)
		
									{
		
										$this->logDebug("\t\t ---------------->>>>>>> Listo para Asignar SI");
				
										// $coloca = new ModeloPedidodetallecolocacion();
		
										array_push($resultado["Surtir"], $det);
											
		
										// 	$coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
		
										// 	$coloca->setIdSucursal($idSucursal);
		
										// 	$coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
		
											
		
										// 	$coloca->setCantidad($totalAExplotar);
		
											
		
										// 	array_push($arrColocaciones, $coloca);
		
									}
		
									else
		
									{
		
										$this->logDebug("\t\t <strong style='color: red'>------- >  no alcanza a salir la mercancía, no se puede proceder con este Pedido</strong>");
		
										$doCommitPedido = false;
		
										// $this->logDebug("\t\t   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");
										array_push($resultado["NoSurtir"], $det);
										
		
									}
		
								}
		
								else
		
								{
		
									$this->logDebug("\t\t ------- >  Total a Surtir = 0, no puede ser");
		
									$doCommitPedido = false;
		
								}
		
							}
		
							else
		
							{
		
								$this->logDebug("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto</strong>");
		
								$doCommitPedido = false;
		
							}
		
						}
		
					}
		
					else //MOLDURAS
		
					{
		
						$this->logDebug();
		
						$this->logDebug("\t\tMOLDURAS/MAQUILAS, NO SE SACAN DE ALGUN LADO ");
		
						$this->logDebug("\t\t   No se manejan existencias");
		
						$this->logDebug("\t\t   SOLICITADAS => " . $totalAExplotar);
		
						$this->logDebug("\t\t    =>=>  MOLDURAS/MAQUILAS no gestionan Inventario ");
		
						
		
						
		
						//$updatePedidoDetalle->setTotalExplotar($partida);
		
						$this->logDebug("\t\t ---------------->>>>>>> Listo para Producir SI");

						array_push($resultado["Surtir"], $det);
						
		
						//                 $updatePedidoDetalle->setListo_para_producir("SI");
		
						//                 $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
		
						
		
						
		
						// 							$this->logDebug();
		
						$this->logDebug("\t\t<strong style='color: green'>=============== Se manejarán ".$totalAExplotar."  MOLDURAS/MAQUILAS</strong>" );
		
						$this->logDebug();
		
						
		
						// 							$updatePedidoDetalle->Guardar();
		
						
		
						// $coloca = new ModeloPedidodetallecolocacion();
		
						
		
						// $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
		
						// $coloca->setIdSucursal($idSucursal);
		
						// $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
		
						
		
						// $coloca->setCantidad($totalAExplotar);
		
						
		
						// array_push($arrColocaciones, $coloca);
		
					}
		
					
		
					
		
				}
		
				return $resultado;
		
				//         		$doCommitPedido = false;
		
				/*  
					Si tiene un 25% de abono, se autoriza
					si no, se debe checar que solo tenga productos de stock				
				*/ 

				// if ($porcentaje == 0)
				// {
				// 	if ($resultado["soloInventario"] == false)
				// 	{
				// 		$doCommitPedido = false;
				// 		$this->logCliente("\t\t<strong style='color: red'>Con 0% de Abono, se autorizaria si solo hubiera mercancía de Stock, pero este Pedido no es el caso.</strong>");
				// 	}
				// }

		
			// 	if ($doCommitPedido)
		
			// 	{
		
			// 		// 			$this->logCliente();
		
			// 		$this->logCliente();
		
			// 		$this->logCliente("\t\t\t\t <strong style='color: green'>************ EL PEDIDO PASA VALIDACIÓN PARA   A U T O R I Z A R S E  en automático ***********</strong>");
		
			// 		//             $pedidoProcesando->setExplotado("SI");
		
			// 		//             $pedidoProcesando->setListo_para_producir("SI");
		
			// 		//             $pedidoProcesando->setExplotadook("SI");
		
			// 		//             $pedidoProcesando->Guardar();
		
					
		
			// 		foreach ($arrColocaciones as $col)
		
			// 		{
		
			// 			// $this->logCliente();
		
			// 			// $this->logCliente();
		
			// 			$this->logCliente("Colocando:   ");
		
			// 			// $this->logCliente();
		
						
		
			// 			// $col->dumpObj("<br>\n");
		
			// 			// $col->Guardar();
		
						
		
			// 			// if ($col->getError())
		
			// 			// {
		
			// 			// 	$doCommitPedido = false;
		
			// 			// 	$this->logCliente($col->getStrError());
		
			// 			// 	break;
		
			// 			// }
		
						
		
			// 			//                 $col->Guardar();
		
						
		
			// 			// $this->logCliente();
		
			// 			// $this->logCliente();
		
			// 		}
		
			// 		$_NOW_=date("Y-m-d H:i:s");
		
			// 		if ($doCommitPedido)
		
			// 		{
		
			// 			$pedidoProcesando->setColocadoSI();
		
			// 			$pedidoProcesando->setEstadoAUTORIZADO();
			// 			$pedidoProcesando->setFecha_autorizado($_NOW_);
			// 			$pedidoProcesando->setId_usuario_autorizado(2);
		
			// 			$pedidoProcesando->setColocadoAutomaticoSI();
		
						
			// 			$pedidoProcesando->Guardar();		
			// 			$pedidoProcesando->NotificaAutorizacionAutomaticaPedido();
						
			// 			$this->logCliente("\t\t <strong style='color: blue'>- - - - - - - -    VAMOS A ver si se GENERAN V A L E S  D E   S A L I D A </strong>");
		
			// 			$this->logCliente();
			// 			if ($pedidoProcesando->getRecogeentrega() == "RECOGE")
			// 			{
			// 				$this->logCliente("\t\tSe generaran los vales en automatico");
			// 				$msg = "";
			// 				$pedidoProcesando->generarValesSalidaAutomatico($pedidoProcesando->getIdPedido(), $msg);
			// 			}
		
						
		
			// 			// $pedidoProcesando->transaccionCommit();
		
			// 			$this->logCliente();
		
			// 			$this->logCliente("\t\tFIN Pedido: <span style='color: blue'>" . $idPedidoProcesando . "</span>");
		
			// 			$this->logCliente("\t\t-------------------------------------------------------------------------------------------------------");
		
			// 		}
		
			// 		else
		
			// 		{
		
			// 			$this->logCliente();
		
			// 			$this->logCliente("\t\tFIN Pedido ... ERA COMMIT PERO HUBO ERROR: <span style='color: red'> " . $idPedidoProcesando . "</span>");
		
			// 			$this->logCliente("\t\t--------------------------------------------------------------------------------------------");
		
			// 		}
		
					
		
					
		
			// 	}
		
			// 	else
		
			// 	{
		
			// 		// 			$this->logCliente();
		
			// 		$this->logCliente();
		
			// 		// $this->logCliente("\t\t - - - - - R O L L B A C K  - - - - -");
		
			// 		// $this->logCliente("\t\t - - - - - BUENO YA NO ES ROLLBACK  - - - - -");
		
			// 		// $pedidoProcesando->transaccionRollback();
		
					
		
					
		
			// 		// 			$pedidoProcesando->transaccionRollback();
		
					
		
			// 		// ya no se guarda lo del pedido, porque ya se guard�, al no haber ya
		
			// 		//rollback, se queda guardado
		
					
		
			// 		// foreach ($arrColocaciones as $col)
		
			// 		// {
		
			// 		// 	//                 $this->logCliente();
		
			// 		// 	$this->logCliente();
		
			// 		// 	// $this->logCliente("\t\tLo que se guardaria:   ");
		
			// 		// 	$this->logCliente();
		
						
		
			// 		// 	// $col->dumpObj("<br>\n");
		
						
		
			// 		// 	//                 $detalleAActualizarSiEstaListo->Guardar();
		
						
		
			// 		// 	//                 $this->logCliente();
		
			// 		// 	$this->logCliente();
		
			// 		// }
		
					
		
			// 		// //             $pedidoProcesando->setExplotado("SI");
		
			// 		// //             $pedidoProcesando->Guardar();
		
			// 		// //             $pedidoProcesando->transaccionCommit();
		
					
		
			// 		// // 			$this->logCliente();
		
			// 		// $this->logCliente("\t\t - ASIGNADO NO ROLLBACK -");
		
			// 		// $this->logCliente();
		
			// 		// $this->logCliente("\t\tFIN Pedido: <h1>" . $idPedidoProcesando . "</h1>");
		
			// 		// $this->logCliente("\t\t--------------------------------------------------------------------------------------");
		
			// 		// // 			$this->logCliente();
		
			// 	}
		
				
		
				
		
			// 	// 		$this->logCliente();
		
			// 	$this->logCliente();
		
			}
		
			
		
			
		
		}

	}

