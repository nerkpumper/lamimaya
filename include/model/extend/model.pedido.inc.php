<?php

	require FOLDER_MODEL_BASE . "model.base.pedido.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	
	require_once FOLDER_MODEL. "model.valesalidapromotor.inc.php";
	require_once FOLDER_MODEL. "model.valesalidapromotordetalle.inc.php";
		
	require_once FOLDER_MODEL. "model.cxc.inc.php";
	
	require_once FOLDER_MODEL. "model.recibodinero.inc.php";
	require_once FOLDER_MODEL. "model.movrecibodinero.inc.php";

	require_once FOLDER_MODEL. "model.cotizacion.inc.php";	
	require_once FOLDER_MODEL. "model.cotizaciondetalle.inc.php";	
	require_once FOLDER_MODEL. "model.clientedatosfacturacion.inc.php";	
	require_once FOLDER_MODEL. "model.datosfacturacion.inc.php";	

	class ModeloPedido extends ModeloBasePedido
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBasePedido";

		var $__ss=array();
		var $__primaryKey="idPedido";				
		var $__tableName="pedido";
		var $__tableEdit="pedidoedit";
		var $__tableDelete="pedidodelete";	
		var $__filename = "";
		var $__idClienteCC = 0;

		var $_Old;

		var $lstProductos = array();
		var $lstRenglones = array();
		
		var $__isDebugging= false;				

		public $__rsPedidoWDetalle;

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

		public function setPedidoCAPTURADO()
		{
			$this->setEstadoCAPTURADO();
			$this->setDateAndUser("capturado");			
		}
		public function setPedidoAUTORIZADO()
		{
			$this->setEstadoAUTORIZADO();
			$this->setDateAndUser("autorizado");			
		}
		public function setPedidoPRODUCCION()
		{
			$this->setEstadoAUTORIZADO();
			$this->setDateAndUser("produccion");
		}
		public function setPedidoTERMINADO()
		{
			$this->setEstadoAUTORIZADO();
			$this->setDateAndUser("terminado");			
		}
		public function setPedidoENTREGADO()
		{
			$this->setEstadoAUTORIZADO();
			$this->setDateAndUser("entregado");			
		}
		public function setPedidoCANCELADO()
		{
			$this->setEstadoAUTORIZADO();
			$this->setDateAndUser("cancelado");			
		}


		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		public function getDetallePedido()
		{
			$result = array();

			try
			{
				$SQL="SELECT
						pd.idPedidoDetalle,
						pd.renglon, pd.idRolloBase, pd.tipoPrecio, pd.partida, pd.cantidad, pd.cantidadReal, pd.desarrollo, pd.dobleces,
						pd.curvar, pd.curvatura, pd.pesoKiloML, pd.molLaminasATomar, pd.molPrecioDobleces, pd.molPrecioCorte, pd.molIsScrap, 
						pd.molTotalcmScrap, pd.molDescMaquila, pd.molLongitudinal,
						v.idProducto, v.codigo,	v.longitud,	v.mlpieza,	v.idTipoProducto, v.tipoProducto,
						v.shortTipoProducto,v.idAplicacion,v.aplicacion,v.idMaterial,v.material,v.idRollo,
						v.rolloCodigo,	v.rolloIdMaterial,	v.rolloMaterial,v.rolloShortMaterial,v.rolloIdProveedor,
						v.rolloProveedor,v.rolloShortProveedor,v.rolloCalibre,v.rolloPies,v.rolloPesokiloml,
						v.rolloDescripcion,v.idUnidad,v.unidad,v.shortUnidad,	v.calibre,v.descripcion,
						v.existencia,v.tipoPrecio,v.isRango,v.tipoRango,v.isRollo,v.precio1,v.precio2,v.precio3,
                        v.preciomendez,v.estado,v.apartado,v.apartadoReal,v.descauto
					FROM  pedidodetalle pd
					INNER JOIN viewproductos v ON pd.idProducto = v.idProducto
					WHERE pd.idPedido = " . $this->idPedido . "
					ORDER BY pd.renglon ";

// 				(tipoprecio = 'G' and precio1 > 0) or tipoprecio = 'T' or tipoprecio = 'I'
				
				// return mysqli_query($this->dbLink,$SQL);
				$result=mysqli_query($this->dbLink,$SQL);

				if($result)
				{
					while($row=mysqli_fetch_assoc($result))
					{
						$renglon = new ModeloPedidodetalle();

						$renglon->setIdPedidoDetalle($row["idPedidoDetalle"]);
						

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
		
		public function getPedidoDetalle($idPedidoDetalle)
		{		
			if($idPedidoDetalle==0)
				return $this->setError("No se especifico el Id del Pedido Detalle.");
		
			$query="SELECT pd.idPedido, pd.idPedidoDetalle, pd.renglon as detRenglon,
						 pd.idProducto as detIdProducto,
						 vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto, 
					     vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
						 vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial, 
					     vp.material as proMaterial,
						 vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
						 vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion,
						 vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descauto as proDescripcion,
						 vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
                         pd.idRolloBase molIdRollo, vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
						 pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
					     pd.listo_para_producir, pd.despachado,
                         pd.totalExplotar, pd.totalExplotado, pd.explotadoReal,
                         pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                         pd.molLaminasATomar, pd.molIsScrap, pd.molTotalcmScrap, pd.molDescMaquila
					FROM pedidodetalle as pd					   
					INNER JOIN viewproductos as vp
					   ON vp.idProducto = pd.idProducto		
			        LEFT JOIN viewrollos as vrmol
					   ON vrmol.idRollo = pd.idRolloBase
					LEFT JOIN usuario as despachado
					   ON despachado.idUsuario = pd.id_usuario_despachado
					WHERE pd.idPedidoDetalle = " . $idPedidoDetalle;
						
			$result=mysqli_query($this->dbLink,$query);
			
			if(!$result)
			{
				return $this->setSystemError("Ocurrio  un error en la busqueda de Detalle de Pedido.", "[" . $this->_nombreClase . ":ln61][" . $query . "][" . mysqli_error($this->dbLink) . "]");
			}
						
			
			while($row=mysqli_fetch_assoc($result))
				return $row;
			
			//return $r;		
		}
		
		/* Get Pedido Detalle Sucursal */
		
		public function getPedidoDetalleSucursal($idPedidoDetalle, $idSucursal, $isRPUsingStock = false)
		{
		    if($idPedidoDetalle==0)
		        return $this->setError("No se especifico el Id del Pedido Detalle.");
		        
		        $query="SELECT pd.idPedido, pd.idPedidoDetalle, pd.renglon as detRenglon,
						 pd.idProducto as detIdProducto,
						 vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto,
					     vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
						 vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial,
					     vp.material as proMaterial,						 
						 vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
						 vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion,
						 vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descauto as proDescripcion,
						 vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
                         pd.idRolloBase molIdRollo, vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
						 pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
					     pd.listo_para_producir, pd.despachado,
                         pd.totalExplotar, pd.totalExplotado, pd.explotadoReal,
                         pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                         pd.molLaminasATomar, pd.molIsScrap, pd.molTotalcmScrap, pd.molDescMaquila,
                         isPedidodetalleParcial(pd.idPedidoDetalle) isParcial,
                         pdc.idPedidoDetalleColocacion, pdc.idinventariosucursal colocaIdInventarioSucursal, s.idSucursal, s.nombre sucursalNombre, 
   						 pdc.cantidad colocaCantidad, pdc.cantidadsurtida colocaCantidadSurtida, invsuc.existencia sucursalExistencia, invsuc.apartado sucursalApartado
					FROM pedidodetalle as pd
					INNER JOIN viewproductos as vp
					   ON vp.idProducto = pd.idProducto
			        LEFT JOIN viewrollos as vrmol
					   ON vrmol.idRollo = pd.idRolloBase
					LEFT JOIN usuario as despachado
					   ON despachado.idUsuario = pd.id_usuario_despachado
                    INNER JOIN pedidodetallecolocacion pdc 
                       ON pd.idpedidodetalle = pdc.idpedidodetalle
					INNER JOIN sucursal s 
                       ON pdc.idsucursal = s.idsucursal
                    ". ($isRPUsingStock ? " LEFT " : " INNER ")." join inventariosucursal invsuc 
                       ON pd.idproducto = invsuc.idproducto   
                      AND invsuc.idSucursal = " .$idSucursal ."                   
					WHERE pd.idPedidoDetalle = " . $idPedidoDetalle . " AND pdc.idSucursal = " .$idSucursal . " ";
				
				// echo $query;

		        $result=mysqli_query($this->dbLink,$query);
		        
		        if(!$result)
		        {
		            return $this->setSystemError("Ocurrio  un error en la busqueda de Detalle de Pedido.", "[" . $this->_nombreClase . ":ln61][" . $query . "][" . mysqli_error($this->dbLink) . "]");
		        }
		        
		        
		        while($row=mysqli_fetch_assoc($result))
		            return $row;
		            
		            //return $r;
		}
		
		/* Fin Get Pedido Detalle Sucursal */
		
	
		public function getPedido($idPedido, $limit = "")
		{
			
			$query = "SELECT p.liberaVales, p.idPedido, p.subtotal, p.iva, p.descuento, p.pordescuento, p.total, p.anticipo, p.saldo, p.saldada, 
						p.planProteccion, p.idcotizacion,
                        p.fechaAbierta, p.pedidoExpress, p.idUsoCfdi,
                        p.colocadoAutomatico, p.tipoObra, p.fechaEntregaPorDefinir,
					     p.estado, p.explotado, p.explotadook, p.factura, p.observaciones, 
                         p.generarValeSalida, p.observacion_aunno,
					     p.recogeentrega, p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega, p.horaRecibe, p.fechaCompromiso, p.tipo,
						 p.idCliente, 
						 c.nombre as cteNombre, c.apellidos as cteApellidos, 
					     c.empresa as cteEmpresa,  c.domicilio1 as cteDomicilio1, c.domicilio2 as cteDomicilio2,
					     c.numero as cteNumero, c.colonia as cteColonia, 
						 c.ciudad as cteCiudad,

						IF(df.idDatosFacturacion > 0, df.razonSocial, c.razonsocial) as cteRazonSocial,
						IF(df.idDatosFacturacion > 0, df.domicilio, c.domiciliofiscal) as cteDomicilioFiscal,
						IF(df.idDatosFacturacion > 0, df.codigoPostal, c.codigopostalfiscal) as cteCPFiscal,
						c.telefonos as cteTelefonos, 
						IF(df.idDatosFacturacion > 0, df.email, c.email) as cteEMail, 
						IF(df.idDatosFacturacion > 0, df.rfc, c.rfc) as cteRFC, 
						c.estado as cteEstado,
						IF(df.idDatosFacturacion > 0, df.numero, c.numerofiscal) as cteNumeroFiscal, 
						IF(df.idDatosFacturacion > 0, df.colonia, c.coloniafiscal) as cteColoniaFiscal, 
						IF(df.idDatosFacturacion > 0, df.ciudad, c.ciudadfiscal) as cteCiudadFiscal, 
						IF(df.idDatosFacturacion > 0, df.idUsoCfdi, c.idUsoCfdi) as cteUsoCfdi,	

                         c.rangoCliente, 
						 c.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
                         p.fecha_descuento, 
						 p.fecha_capturado, p.id_usuario_capturado, capturado.nombre as capturadoNombre, capturado.apellidoPaterno as capturadoAPaterno, capturado.apellidoMaterno as capturadoAMaterno, p.observacionCaptura,
						 p.fecha_autorizado, p.id_usuario_autorizado, IFNULL(autorizado.nombre,'') as autorizadoNombre, IFNULL(autorizado.apellidoPaterno,'') as autorizadoAPaterno, IFNULL(autorizado.apellidoMaterno,'') as autorizadoAMaterno, p.observacionAutoriza,  
						 p.fecha_produccion, p.id_usuario_produccion, IFNULL(produccion.nombre,'') as produccionNombre, IFNULL(produccion.apellidoPaterno,'') as produccionAPaterno, IFNULL(produccion.apellidoMaterno,'') as produccionAMaterno,
						 p.fecha_terminado, p.id_usuario_terminado, IFNULL(terminado.nombre,'') as terminadoNombre, IFNULL(terminado.apellidoPaterno,'') as terminadoAPaterno, IFNULL(terminado.apellidoMaterno,'') as terminadoAMaterno,
						 p.fecha_entregado, p.id_usuario_entregado, IFNULL(entregado.nombre,'') as entregadoNombre, IFNULL(entregado.apellidoPaterno,'') as entregadoAPaterno, IFNULL(entregado.apellidoMaterno,'') as entregadoAMaterno,
						 p.fecha_cancelado, p.id_usuario_cancelado, IFNULL(cancelado.nombre,'') as canceladoNombre, IFNULL(cancelado.apellidoPaterno,'') as canceladoAPaterno, IFNULL(cancelado.apellidoMaterno,'') as canceladoAMaterno, p.observacionCancela,
						 pd.idPedidoDetalle, pd.renglon as detRenglon,
						 pd.idProducto as detIdProducto,
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
						 pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
					     pd.listo_para_producir, pd.despachado, pd.partidaDespachada, pd.explotarUnidad as detExplotarUnidad, pd.totalExplotar as detTotalExplotar,
                         pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                         pd.curvar, pd.curvatura, pd.molDescMaquila,p.solicitaFactura, pd.mlDespachado,
                         pd.molLaminasATomar, pd.molIsScrap, pd.molTotalcmScrap, pd.molLongitudinal, pd.pesoKiloML, pd.idRolloBase,
                         ifnull(sucpreferente.idsucursal,0) idSucursalPreferente, ifnull(sucpreferente.nombre,'POR CONFIRMAR') sucursalPreferente,
						 pedidoBloqueadoXPrecios(p.idPedido) pedidoBloqueado,
						 p.idClienteDatosFacturacion, IFNULL(df.idRegimenFiscal,1) idRegimenFiscal, 
                         CONCAT(IFNULL(rf.codigo, ''), ' - ', IFNULL(rf.descripcion, '')) regimenfiscal
					FROM pedido as p
					LEFT JOIN pedidodetalle as pd
					   ON pd.idPedido = p.idPedido
					LEFT JOIN clientedatosfacturacion cdf
                       ON p.idClienteDatosFacturacion = cdf.idClienteDatosFacturacion	
					LEFT JOIN datosfacturacion df
                       ON cdf.idDatosFacturacion = df.idDatosFacturacion
					LEFT JOIN regimenfiscal rf
                       ON df.idRegimenFiscal = rf.idRegimenFiscal
					LEFT JOIN viewproductos as vp
					   ON vp.idProducto = pd.idProducto
                    LEFT JOIN viewrollos as vrmol
					   ON vrmol.idRollo = pd.idRolloBase
					INNER JOIN cliente as c
					   ON c.idCliente = p.idCliente
					INNER JOIN usuario as promotor
					   ON promotor.idUsuario = c.idUsuarioPromotor
					INNER JOIN usuario as capturado
					   ON capturado.idUsuario = p.id_usuario_capturado
					LEFT JOIN usuario as autorizado
					   ON autorizado.idUsuario = p.id_usuario_autorizado
					LEFT JOIN usuario as produccion
					   ON produccion.idUsuario = p.id_usuario_produccion
					LEFT JOIN usuario as terminado
					   ON terminado.idUsuario = p.id_usuario_terminado
					LEFT JOIN usuario as entregado
					   ON entregado.idUsuario = p.id_usuario_entregado
					LEFT JOIN usuario as cancelado
					   ON cancelado.idUsuario = p.id_usuario_cancelado
					LEFT JOIN usuario as despachado
					   ON despachado.idUsuario = pd.id_usuario_despachado
                    LEFT JOIN sucursal sucpreferente
                       ON p.idSucursalPreferenciaRecoge = sucpreferente.idSucursal
					WHERE p.idPedido = " . $idPedido . " " . $limit;
				

		

			$this->__rsPedidoWDetalle = $this->getDataSet($query);
		}
		
		
		/* Get Pedido para Surtir */
		
		public function getPedidoParaSurtir($idPedido, $idSucursal = 0, $limit = "")
		{
		    
		    $query = "SELECT p.idPedido, p.subtotal, p.iva, p.descuento, p.pordescuento, p.total, p.anticipo, p.saldo,
                        p.fechaAbierta, p.pedidoExpress, p.idUsoCfdi,
					     p.estado, p.explotado, p.explotadook, p.factura, p.observaciones,
                         p.generarValeSalida, p.observacion_aunno,
					     p.recogeentrega, p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega, p.horaRecibe, p.fechaCompromiso, p.tipo,
						 p.idCliente, c.nombre as cteNombre, c.apellidos as cteApellidos,  c.rangoCliente,
					     c.empresa as cteEmpresa, c.razonsocial as cteRazonSocial, c.domicilio1 as cteDomicilio1, c.domicilio2 as cteDomicilio2,
					     c.numero as cteNumero, c.colonia as cteColonia, c.ciudad as cteCiudad,c.domiciliofiscal as cteDomicilioFiscal,c.codigopostalfiscal as cteCPFiscal,
						 c.telefonos as cteTelefonos, c.email as cteEMail, c.rfc as cteRFC, c.estado as cteEstado,
						 c.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
                         p.fecha_descuento,
						 p.fecha_capturado, p.id_usuario_capturado, capturado.nombre as capturadoNombre, capturado.apellidoPaterno as capturadoAPaterno, capturado.apellidoMaterno as capturadoAMaterno, p.observacionCaptura,
						 p.fecha_autorizado, p.id_usuario_autorizado, IFNULL(autorizado.nombre,'') as autorizadoNombre, IFNULL(autorizado.apellidoPaterno,'') as autorizadoAPaterno, IFNULL(autorizado.apellidoMaterno,'') as autorizadoAMaterno, p.observacionAutoriza,
						 p.fecha_produccion, p.id_usuario_produccion, IFNULL(produccion.nombre,'') as produccionNombre, IFNULL(produccion.apellidoPaterno,'') as produccionAPaterno, IFNULL(produccion.apellidoMaterno,'') as produccionAMaterno,
						 p.fecha_terminado, p.id_usuario_terminado, IFNULL(terminado.nombre,'') as terminadoNombre, IFNULL(terminado.apellidoPaterno,'') as terminadoAPaterno, IFNULL(terminado.apellidoMaterno,'') as terminadoAMaterno,
						 p.fecha_entregado, p.id_usuario_entregado, IFNULL(entregado.nombre,'') as entregadoNombre, IFNULL(entregado.apellidoPaterno,'') as entregadoAPaterno, IFNULL(entregado.apellidoMaterno,'') as entregadoAMaterno,
						 p.fecha_cancelado, p.id_usuario_cancelado, IFNULL(cancelado.nombre,'') as canceladoNombre, IFNULL(cancelado.apellidoPaterno,'') as canceladoAPaterno, IFNULL(cancelado.apellidoMaterno,'') as canceladoAMaterno, p.observacionCancela,
						 pd.idPedidoDetalle, pd.renglon as detRenglon, isPedidodetalleParcial(pd.idPedidoDetalle) detIsParcial,
						 pd.idProducto as detIdProducto,
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
						 pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
					     pd.listo_para_producir, pd.despachado, pd.partidaDespachada, pd.mlDespachado,
                         if(p.recogeentrega = 'OBRA', pd.explotarUnidad, pd.explotarUnidad) as detExplotarUnidad, pd.totalExplotar as detTotalExplotar,
                         pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                         pd.curvar, pd.curvatura, pd.molDescMaquila,p.solicitaFactura,
                         pd.molLaminasATomar, pd.molIsScrap, pd.molTotalcmScrap, pd.molLongitudinal, pd.pesoKiloML, pd.idRolloBase,
                         ifnull(sucpreferente.idsucursal,0) idSucursalPreferente, ifnull(sucpreferente.nombre,'POR CONFIRMAR') sucursalPreferente,
                         pdc.idPedidoDetalleColocacion, pdc.idinventariosucursal colocaIdInventarioSucursal, s.idSucursal, s.nombre sucursalNombre, 
						 pdc.cantidad colocaCantidad, pdc.cantidadsurtida colocaCantidadSurtida
					FROM pedido as p
					LEFT JOIN pedidodetalle as pd
					   ON pd.idPedido = p.idPedido
					LEFT JOIN viewproductos as vp
					   ON vp.idProducto = pd.idProducto
                    LEFT JOIN viewrollos as vrmol
					   ON vrmol.idRollo = pd.idRolloBase
					INNER JOIN cliente as c
					   ON c.idCliente = p.idCliente
					INNER JOIN usuario as promotor
					   ON promotor.idUsuario = c.idUsuarioPromotor
					INNER JOIN usuario as capturado
					   ON capturado.idUsuario = p.id_usuario_capturado
					LEFT JOIN usuario as autorizado
					   ON autorizado.idUsuario = p.id_usuario_autorizado
					LEFT JOIN usuario as produccion
					   ON produccion.idUsuario = p.id_usuario_produccion
					LEFT JOIN usuario as terminado
					   ON terminado.idUsuario = p.id_usuario_terminado
					LEFT JOIN usuario as entregado
					   ON entregado.idUsuario = p.id_usuario_entregado
					LEFT JOIN usuario as cancelado
					   ON cancelado.idUsuario = p.id_usuario_cancelado
					LEFT JOIN usuario as despachado
					   ON despachado.idUsuario = pd.id_usuario_despachado
                    LEFT JOIN sucursal sucpreferente
                       ON p.idSucursalPreferenciaRecoge = sucpreferente.idSucursal
                    INNER JOIN pedidodetallecolocacion pdc 
                       ON pd.idpedidodetalle = pdc.idpedidodetalle
					INNER JOIN sucursal s 
                       ON pdc.idsucursal = s.idsucursal
					WHERE p.idPedido = " . $idPedido . " AND pdc.cantidad > 0 "  . ($idSucursal > 0 ? " and pdc.idSucursal = " . $idSucursal : "") . " " . $limit;
		    
// 		    echo $query;
		    
		    $this->__rsPedidoWDetalle = $this->getDataSet($query);
		}
		
		
		/* Fin Get Pedido para Surtir */
		
		
		/* Pedido despiece */
		
		public function getPedidoDespiece($idPedido, $limit = "")
		{
		    
		    $query = "SELECT p.idPedido, p.subtotal, p.iva, p.descuento, p.pordescuento, p.total, p.anticipo, p.saldo,
                        p.fechaAbierta, p.pedidoExpress, p.idUsoCfdi,
					     p.estado, p.explotado, p.explotadook, p.factura, p.observaciones,
                         p.generarValeSalida, p.observacion_aunno,
					     p.recogeentrega, p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega, p.horaRecibe, p.fechaCompromiso, p.tipo,
						 p.idCliente, c.nombre as cteNombre, c.apellidos as cteApellidos,
					     c.empresa as cteEmpresa, c.razonsocial as cteRazonSocial, c.domicilio1 as cteDomicilio1, c.domicilio2 as cteDomicilio2,
					     c.numero as cteNumero, c.colonia as cteColonia, c.ciudad as cteCiudad,c.domiciliofiscal as cteDomicilioFiscal,c.codigopostalfiscal as cteCPFiscal,
						 c.telefonos as cteTelefonos, c.email as cteEMail, c.rfc as cteRFC, c.estado as cteEstado,
						 c.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
                         p.fecha_descuento,
						 p.fecha_capturado, p.id_usuario_capturado, capturado.nombre as capturadoNombre, capturado.apellidoPaterno as capturadoAPaterno, capturado.apellidoMaterno as capturadoAMaterno, p.observacionCaptura,
						 p.fecha_autorizado, p.id_usuario_autorizado, IFNULL(autorizado.nombre,'') as autorizadoNombre, IFNULL(autorizado.apellidoPaterno,'') as autorizadoAPaterno, IFNULL(autorizado.apellidoMaterno,'') as autorizadoAMaterno, p.observacionAutoriza,
						 p.fecha_produccion, p.id_usuario_produccion, IFNULL(produccion.nombre,'') as produccionNombre, IFNULL(produccion.apellidoPaterno,'') as produccionAPaterno, IFNULL(produccion.apellidoMaterno,'') as produccionAMaterno,
						 p.fecha_terminado, p.id_usuario_terminado, IFNULL(terminado.nombre,'') as terminadoNombre, IFNULL(terminado.apellidoPaterno,'') as terminadoAPaterno, IFNULL(terminado.apellidoMaterno,'') as terminadoAMaterno,
						 p.fecha_entregado, p.id_usuario_entregado, IFNULL(entregado.nombre,'') as entregadoNombre, IFNULL(entregado.apellidoPaterno,'') as entregadoAPaterno, IFNULL(entregado.apellidoMaterno,'') as entregadoAMaterno,
						 p.fecha_cancelado, p.id_usuario_cancelado, IFNULL(cancelado.nombre,'') as canceladoNombre, IFNULL(cancelado.apellidoPaterno,'') as canceladoAPaterno, IFNULL(cancelado.apellidoMaterno,'') as canceladoAMaterno, p.observacionCancela,
						 pd.idPedidoDetalle, pd.renglon as detRenglon, isPedidodetalleParcial(pd.idPedidoDetalle) detIsParcial,
						 pd.idProducto as detIdProducto,
						 vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto,
					     vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
						 vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial,
					     vp.material as proMaterial, vp.idColor, vp.color,
						 vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
						 vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion, vp.rollodescauto,
                         vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
						 vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
						 vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
						 pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
						 pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
					     pd.listo_para_producir, pd.despachado, pd.partidaDespachada, 
                         if(p.recogeentrega = 'OBRA', pd.cantidadReal, pd.explotarUnidad) as detExplotarUnidad, pd.totalExplotar as detTotalExplotar,
                         pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                         pd.curvar, pd.curvatura, pd.molDescMaquila,p.solicitaFactura,
                         pd.molLaminasATomar, pd.molIsScrap, pd.molTotalcmScrap, pd.molLongitudinal, pd.pesoKiloML, pd.idRolloBase,
                         rpd.partida rpdPiezas, rpd.longitud rpdLongitud, rpd.kgml rpdkgml, rpd.totalKg rpdTotalKg                         
					FROM pedido as p
					LEFT JOIN pedidodetalle as pd
					   ON pd.idPedido = p.idPedido
					LEFT JOIN viewproductos as vp
					   ON vp.idProducto = pd.idProducto
                    LEFT JOIN viewrollos as vrmol
					   ON vrmol.idRollo = pd.idRolloBase
					INNER JOIN cliente as c
					   ON c.idCliente = p.idCliente
					INNER JOIN usuario as promotor
					   ON promotor.idUsuario = c.idUsuarioPromotor
					INNER JOIN usuario as capturado
					   ON capturado.idUsuario = p.id_usuario_capturado
					LEFT JOIN usuario as autorizado
					   ON autorizado.idUsuario = p.id_usuario_autorizado
					LEFT JOIN usuario as produccion
					   ON produccion.idUsuario = p.id_usuario_produccion
					LEFT JOIN usuario as terminado
					   ON terminado.idUsuario = p.id_usuario_terminado
					LEFT JOIN usuario as entregado
					   ON entregado.idUsuario = p.id_usuario_entregado
					LEFT JOIN usuario as cancelado
					   ON cancelado.idUsuario = p.id_usuario_cancelado
					LEFT JOIN usuario as despachado
					   ON despachado.idUsuario = pd.id_usuario_despachado                       
					INNER JOIN registroproducciondetalle rpd
				       ON pd.idPedidoDetalle = rpd.idPedidoDetalle                   
					WHERE p.idPedido = " . $idPedido . "  " . $limit;
		    
// 		     		    echo $query;
		    
		    $this->__rsPedidoWDetalle = $this->getDataSet($query);
		}
		
		
		/* Fin pedido despiece */
		
		public function getPedidoDato($column)
		{
			$dato = "";
		
			if (count($this->__rsPedidoWDetalle) > 0)
			{
				if (isset($this->__rsPedidoWDetalle[0][$column]))
				{
					$dato = $this->__rsPedidoWDetalle[0][$column];
				}
			}
		
			return $dato;
		}

		public function esPrimerPedido($idCliente, $idPedido)
		{			
			$query = "SELECT idPedido FROM pedido WHERE idCliente = " . $idCliente . " ORDER BY idPedido ASC LIMIT 1";
			
			$rs = $this->getDataSet($query);

			if ($rs != null)
			{
				if ($idPedido == intval($rs[0]["idPedido"]))
				{
					return true;
				}
			}			
		
			return false;
		}

		public function getValeSalida($idValeSalida, $limit = "")
		{
			
// 			$query = "SELECT vsd.cantidad as valedeCantidad,p.idPedido, p.subtotal, p.iva, p.descuento, p.pordescuento, p.total, p.anticipo, p.saldo, 
// 								p.estado, p.explotado, p.explotadook, p.factura, p.observaciones, 
//                                 p.generarValeSalida, p.observacion_aunno,
// 								p.recogeentrega, p.personaEntrega, p.domicilioEntrega, p.numeroEntrega, p.coloniaEntrega, p.ciudadEntrega, p.horaRecibe, p.fechaCompromiso, p.tipo,
// 								p.idCliente, c.nombre as cteNombre, c.apellidos as cteApellidos, 
// 								c.empresa as cteEmpresa, c.domicilio1 as cteDomicilio1, c.domicilio2 as cteDomicilio2,
// 								c.numero as cteNumero, c.colonia as cteColonia, c.ciudad as cteCiudad,
// 								c.telefonos as cteTelefonos, c.email as cteEMail, c.rfc as cteRfc, c.estado as cteEstado,
// 								c.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
// 								pd.idPedidoDetalle, pd.renglon as detRenglon,
// 								pd.idProducto as detIdProducto,
// 								vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto, 
// 								vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
// 								vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial, 
// 								vp.material as proMaterial,
// 								vp.idRollo as proIdRollo, 
//                                 vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
// 								vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
// 								vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
// 								pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
// 								pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
// 								pd.listo_para_producir, pd.despachado, pd.partidaDespachada, pd.explotarUnidad as detExplotarUnidad, pd.totalExplotar as detTotalExplotar,
// 								pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno
// 						FROM valesalida as vs
// 						inner join valesalidadetalle as vsd
// 							on vsd.idvalesalida = vs.idvalesalida
// 						INNER JOIN pedidodetalle as pd
// 							ON pd.idPedidoDetalle = vsd.idPedidoDetalle
// 						INNER JOIN pedido as p
// 							ON p.idpedido = pd.idpedido
// 						INNER JOIN viewproductos as vp
// 							ON vp.idProducto = pd.idProducto
//                         INNER JOIN viewrollos as vrmol
// 					        ON vrmol.idRollo = pd.idRolloBase
// 						INNER JOIN cliente as c
// 							ON c.idCliente = p.idCliente
// 						INNER JOIN usuario as promotor
// 							ON promotor.idUsuario = c.idUsuarioPromotor					
// 						LEFT JOIN usuario as despachado
// 							ON despachado.idUsuario = pd.id_usuario_despachado
// 						WHERE vs.idvalesalida = " . $idValeSalida . " " . $limit;

		    $query = "SELECT vsd.cantidad as valedeCantidad, ifnull(s.nombre, '') sucursalNombre,
p.idPedido, p.subtotal, p.iva, p.descuento, p.pordescuento, p.total, p.anticipo, p.saldo, 
 								p.estado, p.explotado, p.explotadook, p.factura, p.observaciones, 
                                 p.generarValeSalida, p.observacion_aunno, p.despieceTerminado,
 								p.recogeentrega, 
                                vs.personaEntrega, vs.domicilioEntrega, vs.numeroEntrega, 
                                vs.coloniaEntrega, vs.ciudadEntrega, vs.horaRecibe, vs.fechaCompromiso, 
								vs.pagoVSEntrega,
                                p.tipo,
 								p.idCliente, c.nombre as cteNombre, c.apellidos as cteApellidos, 
 								c.empresa as cteEmpresa, c.domicilio1 as cteDomicilio1, c.domicilio2 as cteDomicilio2,
 								c.numero as cteNumero, c.colonia as cteColonia, c.ciudad as cteCiudad,
                                c.rangoCliente, 
 								c.telefonos as cteTelefonos, c.email as cteEMail, c.rfc as cteRfc, c.estado as cteEstado,
 								c.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
 								vendedor.nombre as vendeNombre, vendedor.apellidoPaterno as vendeAPaterno, vendedor.apellidoMaterno as vendeAMaterno,
								 pd.idPedidoDetalle, pd.renglon as detRenglon,
 								pd.idProducto as detIdProducto,
 								vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto, 
 								vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
 								vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial, 
 								vp.material as proMaterial, vp.idColor, vp.color,
 								vp.idRollo as proIdRollo,   								                                
 								vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
 								vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
                                vrmol.codigo rolloMolduraCodigo, 
 								pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
 								pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal,
 								pd.listo_para_producir, pd.despachado, pd.partidaDespachada, pd.explotarUnidad as detExplotarUnidad, pd.totalExplotar as detTotalExplotar,
 								pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                                pd.molDescMaquila,
								vrmol.pies rolloPies,
								vp.idColor, vp.color
 						FROM valesalida as vs
 						inner join (select idValeSalida, idPedidoDetalle, sum(cantidad) cantidad from valesalidadetalle group by idValeSalida, idPedidoDetalle)  as vsd
 							on vsd.idvalesalida = vs.idvalesalida
 						INNER JOIN pedidodetalle as pd
 							ON pd.idPedidoDetalle = vsd.idPedidoDetalle
 						INNER JOIN pedido as p
 							ON p.idpedido = pd.idpedido
 						INNER JOIN viewproductos as vp
 							ON vp.idProducto = pd.idProducto
                         LEFT JOIN rollo as vrmol
 					        ON vrmol.idRollo = pd.idRolloBase
 						INNER JOIN cliente as c
 							ON c.idCliente = p.idCliente
 						INNER JOIN usuario as promotor
 							ON promotor.idUsuario = c.idUsuarioPromotor	
						INNER JOIN usuario as vendedor
 							ON vendedor.idUsuario = p.id_usuario_capturado				
 						LEFT JOIN usuario as despachado
 							ON despachado.idUsuario = pd.id_usuario_despachado
                        LEFT JOIN sucursal s 
                           ON vs.idsucursal = s.idsucursal
 						WHERE vs.idvalesalida = " . $idValeSalida . " order by pd.renglon " . $limit;
									
			$this->__rsPedidoWDetalle = $this->getDataSet($query);
		}
		
		public function getValeSalidaDato($column)
		{
			$dato = "";
		
			if (count($this->__rsPedidoWDetalle) > 0)
			{
				if (isset($this->__rsPedidoWDetalle[0][$column]))
				{
					$dato = $this->__rsPedidoWDetalle[0][$column];
				}
			}
		
			return $dato;
		}
		
		public function getPedidoDetalleParaDespachar($idPedido)
		{
			$query = "SELECT c.nombre as cteNombre, c.apellidos as cteApellidos,
						c.empresa as cteEmpresa,
						pd.idPedidoDetalle, pd.renglon as detRenglon,
						pd.idProducto as detIdProducto,
						vp.codigo as proCodigo,
						vp.idRollo as proIdRollo,
						vp.descauto as proDescripcion,vp.shortUnidad,	
						pd.listo_para_producir, pd.despachado, pd.partida, pd.cantidad, pd.cantidadReal, pd.explotarUnidad, pd.totalExplotar, pd.totalExplotado, pd.partidaDespachada,
						pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno
						FROM pedido as p
						INNER JOIN pedidodetalle as pd
						ON pd.idPedido = p.idPedido
						INNER JOIN viewproductos as vp
						ON vp.idProducto = pd.idProducto
						INNER JOIN cliente as c
						ON c.idCliente = p.idCliente
						LEFT JOIN usuario as despachado
						ON despachado.idUsuario = pd.id_usuario_despachado
						WHERE p.idPedido = " . $idPedido;
				
			$this->__rsPedidoWDetalle = $this->getDataSet($query);
		}
		
		
		public function getPedidoDetalleParaDespacharSucursal($idPedido, $idSucursal)
		{
		    $query = "SELECT c.nombre as cteNombre, c.apellidos as cteApellidos,
						c.empresa as cteEmpresa,
						pd.idPedidoDetalle, pd.renglon as detRenglon,
						pd.idProducto as detIdProducto,
						vp.codigo as proCodigo,
						vp.idRollo as proIdRollo,
						vp.descauto as proDescripcion,vp.shortUnidad,
						pd.listo_para_producir, pd.despachado, pd.partida, pd.cantidad, pd.cantidadReal, 
                        pd.explotarUnidad, pd.totalExplotar, pd.totalExplotado, pd.partidaDespachada, pd.mlDespachado,
						pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno,
                        pdc.idPedidoDetalleColocacion, pdc.idinventariosucursal colocaIdInventarioSucursal, s.idSucursal, s.nombre sucursalNombre, 
						 pdc.cantidad colocaCantidad, pdc.cantidadsurtida colocaCantidadSurtida, isPedidodetalleParcial(pd.idPedidoDetalle) isParcial                        
						FROM pedido as p
						INNER JOIN pedidodetalle as pd
						ON pd.idPedido = p.idPedido
						INNER JOIN viewproductos as vp
						ON vp.idProducto = pd.idProducto
						INNER JOIN cliente as c
						ON c.idCliente = p.idCliente
						LEFT JOIN usuario as despachado
						ON despachado.idUsuario = pd.id_usuario_despachado
                        INNER JOIN pedidodetallecolocacion pdc 
                        ON pd.idpedidodetalle = pdc.idpedidodetalle
					   INNER JOIN sucursal s 
                        ON pdc.idsucursal = s.idsucursal
						WHERE p.idPedido = " . $idPedido .  ($idSucursal > 0 ? " and pdc.idSucursal = " . $idSucursal : " ") ;
		    
		    $this->__rsPedidoWDetalle = $this->getDataSet($query);
		}


		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		//Consulta para obtener los pedidodetalle que corresponden a un idRollo
// 		SELECT c.nombre as cteNombre, c.apellidos as cteApellidos,
// 		c.empresa as cteEmpresa,
// 		pd.idPedidoDetalle, pd.renglon as detRenglon,
// 		pd.idProducto as detIdProducto,
// 		vp.codigo as proCodigo,
// 		vp.idRollo as proIdRollo,
// 		vp.descripcion as proDescripcion,
// 		pd.listo_para_producir, pd.despachado, pd.partida, pd.cantidad, pd.cantidadReal, pd.explotarUnidad, pd.totalExplotar, pd.totalExplotado, pd.partidaDespachada,
// 		pd.fecha_despachado, pd.id_usuario_despachado, IFNULL(despachado.nombre,'') as despachadoNombre, IFNULL(despachado.apellidoPaterno,'') as despachadoAPaterno, IFNULL(despachado.apellidoMaterno,'') as despachadoAMaterno
// 		FROM pedido as p
// 		INNER JOIN pedidodetalle as pd
// 		ON pd.idPedido = p.idPedido
// 		INNER JOIN viewproductos as vp
// 		ON vp.idProducto = pd.idProducto
// 		INNER JOIN cliente as c
// 		ON c.idCliente = p.idCliente
// 		LEFT JOIN usuario as despachado
// 		ON despachado.idUsuario = pd.id_usuario_despachado
// 		WHERE p.idPedido = 64;
		
		//consulta para obtener pedido, pedidodetalle y los datos asociados a estas tablas
// 		SELECT p.idPedido, p.subtotal, p.iva, p.descuento, p.total, p.anticipo, p.saldo, p.estado, p.explotado, p.factura, p.observaciones,
// 		p.idCliente, c.nombre as cteNombre, c.apellidos as cteApellidos, c.empresa as cteEmpresa, c.domicilio1 as cteDomicilio1, c.domicilio2 as cteDomicilio2,
// 		c.telefonos as cteTelefonos, c.email as cteEMail, c.rfc as cteRfc, c.estado as cteEstado,
// 		c.idUsuarioPromotor as cteIdPromotor, promotor.nombre as promoNombre, promotor.apellidoPaterno as promoAPaterno, promotor.apellidoMaterno as promoAMaterno,
// 		p.fecha_capturado, p.id_usuario_capturado, capturado.nombre as capturadoNombre, capturado.apellidoPaterno as capturadoAPaterno, capturado.apellidoMaterno as capturadoAMaterno,
// 		p.fecha_autorizado, p.id_usuario_autorizado, IFNULL(autorizado.nombre,'') as autorizadoNombre, IFNULL(autorizado.apellidoPaterno,'') as autorizadoAPaterno, IFNULL(autorizado.apellidoMaterno,'') as autorizadoAMaterno,
// 		p.fecha_produccion, p.id_usuario_produccion, IFNULL(produccion.nombre,'') as produccionNombre, IFNULL(produccion.apellidoPaterno,'') as produccionAPaterno, IFNULL(produccion.apellidoMaterno,'') as produccionAMaterno,
// 		p.fecha_terminado, p.id_usuario_terminado, IFNULL(terminado.nombre,'') as terminadoNombre, IFNULL(terminado.apellidoPaterno,'') as terminadoAPaterno, IFNULL(terminado.apellidoMaterno,'') as terminadoAMaterno,
// 		p.fecha_entregado, p.id_usuario_entregado, IFNULL(entregado.nombre,'') as entregadoNombre, IFNULL(entregado.apellidoPaterno,'') as entregadoAPaterno, IFNULL(entregado.apellidoMaterno,'') as entregadoAMaterno,
// 		p.fecha_cancelado, p.id_usuario_cancelado, IFNULL(cancelado.nombre,'') as canceladoNombre, IFNULL(cancelado.apellidoPaterno,'') as canceladoAPaterno, IFNULL(cancelado.apellidoMaterno,'') as canceladoAMaterno,
// 		pd.renglon as detRenglon,
// 		pd.idProducto as detIdProducto,
// 		vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto, vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
// 		vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial, vp.material as proMaterial,
// 		vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
// 		vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion,
// 		vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion,
// 		vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
// 		pd.tipoPrecio as detTipoPrecio, pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
// 		pd.dobleces as detDobleces, pd.precioUnitario as detPrecioUnitario, pd.total as detTotal
// 		FROM pedido as p
// 		INNER JOIN pedidodetalle as pd
// 		ON pd.idPedido = p.idPedido
// 		INNER JOIN viewproductos as vp
// 		ON vp.idProducto = pd.idProducto
// 		INNER JOIN cliente as c
// 		ON c.idCliente = p.idCliente
// 		INNER JOIN usuario as promotor
// 		ON promotor.idUsuario = c.idUsuarioPromotor
// 		INNER JOIN usuario as capturado
// 		ON capturado.idUsuario = p.id_usuario_capturado
// 		LEFT JOIN usuario as autorizado
// 		ON autorizado.idUsuario = p.id_usuario_autorizado
// 		LEFT JOIN usuario as produccion
// 		ON produccion.idUsuario = p.id_usuario_produccion
// 		LEFT JOIN usuario as terminado
// 		ON terminado.idUsuario = p.id_usuario_terminado
// 		LEFT JOIN usuario as entregado
// 		ON entregado.idUsuario = p.id_usuario_entregado
// 		LEFT JOIN usuario as cancelado
// 		ON cancelado.idUsuario = p.id_usuario_cancelado
// 		WHERE p.idPedido = 18;

		public function BorrarCXC()
		{
			
			
			if($this->getError())
				return false;

			try
			{
				$SQL="
						SET sql_safe_updates = 0;
						
						DELETE FROM cxc 
					WHERE idPedido=" . mysqli_real_escape_string($this->dbLink,$this->idPedido) . "; 
						
						SET sql_safe_updates = 1;
							
							";
				
				echo $SQL;
					
				$result=mysqli_query($this->dbLink,$SQL);
					
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloPedido::BorrarCXC]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		
		public function validarDatos()
		{
			return true;
		}
		
		
// 		Enviar Notificaciones
		//NOTIFICACIONES WHATSAPP

		 public function NotificaAltaPedido()
		 {
			$idsToSend = array();
			$cliente = new ModeloCliente();
			
			$cliente->setIdCliente($this->getIdCliente());
			
		//  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " CAPTURADO", "Se ha capturado un pedido para el Cliente ". $cliente->getNombre() . " " . $cliente->getApellidos() ." con número de pedido ".$this->getIdPedido());
			array_push($idsToSend, $this->getId_usuario_capturado());
			if ($this->getId_usuario_capturado() != 15)
			{
			//  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 15, "Pedido " . $this->getIdPedido() . " CAPTURADO", "Se ha capturado un pedido para el Cliente ". $cliente->getNombre() . " " . $cliente->getApellidos() ." con número de pedido ".$this->getIdPedido());
				array_push($idsToSend, 15);
			}
			
			if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
			{
			//  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido(). " CAPTURADO", "Se ha capturado un pedido para el Cliente ". $cliente->getNombre() . " " . $cliente->getApellidos() ." con número de pedido ".$this->getIdPedido());
				array_push($idsToSend, $cliente->getIdUsuarioPromotor());
			}

			NotificationManager::WA_PedidoNuevo($idsToSend, $this->getIdPedido());

			/* 2086 GALVAMEX Consumo Interno */
			if ($cliente->getIdCliente() == 2086){
				sleep(2);
				NotificationManager::WA_EstatusPedido($idsToSend, $this->getIdPedido(), "AUTORIZADO");
			}
    		// IF NEW.idCliente = 2086 THEN
		     
		     
		 }
		 
		 
		 public function NotificaAutorizacionPedido()
		 {
			$idsToSend = array();
			$cliente = new ModeloCliente();
			
			$cliente->setIdCliente($this->getIdCliente());
			
			array_push($idsToSend, $this->getId_usuario_capturado());
			if ($this->getId_usuario_capturado() != 15)
			{
				array_push($idsToSend, 15);
			}
			
			if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
			{
				array_push($idsToSend, $cliente->getIdUsuarioPromotor());
			}

			NotificationManager::WA_EstatusPedido($idsToSend, $this->getIdPedido(), "AUTORIZADO");


		    //  $cliente = new ModeloCliente();
		     
		    //  $cliente->setIdCliente($this->getIdCliente());
		     
		    //  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " AUTORIZADO", "El pedido ".$this->getIdPedido()." ha sido Autorizado para su producci�n.");
		     
		    //  if ($this->getId_usuario_capturado() != 15)
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 15, "Pedido " . $this->getIdPedido() . " AUTORIZADO", "El pedido ".$this->getIdPedido()." ha sido Autorizado para su producci�n.");
		    //  }
		     
		    //  if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido(). " AUTORIZADO", "El pedido ".$this->getIdPedido()." ha sido Autorizado para su producci�n.");
		    //  }
		     
		     
		 }
		 
		 public function NotificaAutorizacionAutomaticaPedido()
		 {
		     $cliente = new ModeloCliente();
		     
		     $cliente->setIdCliente($this->getIdCliente());

		     NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " AUTORIZADO Automático", "El pedido ".$this->getIdPedido()." ha sido Autorizado de manera automática para su producción.");

		     if ($this->getId_usuario_capturado() != 15)
		     {
		         NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 15, "Pedido " . $this->getIdPedido() . " AUTORIZADO Automático", "El pedido ".$this->getIdPedido()." ha sido Autorizado de manera automática para su producción.");
		     }
		     
		     if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		     {
		         NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido(). " AUTORIZADO Automático", "El pedido ".$this->getIdPedido()." ha sido Autorizado de manera automática para su producción.");
		     }
		     
		     
		 }
		 
		 
		 public function NotificaProduccionPedido()
		 {
		 	$idsToSend = array();
			$cliente = new ModeloCliente();
			
			$cliente->setIdCliente($this->getIdCliente());
			
			array_push($idsToSend, $this->getId_usuario_capturado());
			if ($this->getId_usuario_capturado() != 15)
			{
				array_push($idsToSend, 15);
			}
			
			if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
			{
				array_push($idsToSend, $cliente->getIdUsuarioPromotor());
			}

			NotificationManager::WA_EstatusPedido($idsToSend, $this->getIdPedido(), "PRODUCCION");

		    //  $cliente = new ModeloCliente();
		     
		    //  $cliente->setIdCliente($this->getIdCliente());
		     
		    //  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " PRODUCCI�N", "El pedido ".$this->getIdPedido()." ha entrado a producci�n.");
		     
		    //  if ($this->getId_usuario_capturado() != 15)
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 15, "Pedido " . $this->getIdPedido() . " PRODUCCI�N", "El pedido ".$this->getIdPedido()." ha entrado a producci�n.");
		    //  }
		     
		    //  if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido(). " PRODUCCI�N", "El pedido ".$this->getIdPedido()." ha entrado a producci�n.");
		    //  }
		     
		     
		 }
		 
		 
		 public function NotificaTerminaPedido()
		 {
		 	$idsToSend = array();
			$cliente = new ModeloCliente();
			
			$cliente->setIdCliente($this->getIdCliente());
			
			array_push($idsToSend, $this->getId_usuario_capturado());
			if ($this->getId_usuario_capturado() != 15)
			{
				array_push($idsToSend, 15);
			}
			
			if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
			{
				array_push($idsToSend, $cliente->getIdUsuarioPromotor());
			}

			NotificationManager::WA_EstatusPedido($idsToSend, $this->getIdPedido(), "TERMINADO");


		    //  $cliente = new ModeloCliente();
		     
		    //  $cliente->setIdCliente($this->getIdCliente());
		     
		    //  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " TERMINADO", "El pedido ".$this->getIdPedido()." se ha surtido.");
		     
		    //  if ($this->getId_usuario_capturado() != 15)
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 15, "Pedido " . $this->getIdPedido() . " TERMINADO", "El pedido ".$this->getIdPedido()." se ha surtido.");
		    //  }
		     
		    //  if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido(). " TERMINADO", "El pedido ".$this->getIdPedido()." se ha surtido.");
		    //  }
		     
		     
		 }
		 
		 public function NotificaEntregaPedido()
		 {
		    $idsToSend = array();
			$cliente = new ModeloCliente();
			
			$cliente->setIdCliente($this->getIdCliente());
			
			array_push($idsToSend, $this->getId_usuario_capturado());
			if ($this->getId_usuario_capturado() != 15)
			{
				array_push($idsToSend, 15);
			}
			
			if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
			{
				array_push($idsToSend, $cliente->getIdUsuarioPromotor());
			}

			NotificationManager::WA_EstatusPedido($idsToSend, $this->getIdPedido(), "ENTREGADO");

			 
			//  $cliente = new ModeloCliente();
		     
		    //  $cliente->setIdCliente($this->getIdCliente());
		     
		    //  NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " ENTREGADO", "El pedido ".$this->getIdPedido()." ha sido entregado al cliente.");
		     
		    //  if ($this->getId_usuario_capturado() != 15)
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 15, "Pedido " . $this->getIdPedido() . " ENTREGADO", "El pedido ".$this->getIdPedido()." ha sido entregado al cliente.");
		    //  }
		     
		    //  if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		    //  {
		    //      NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido(). " ENTREGADO", "El pedido ".$this->getIdPedido()." ha entregado al cliente.");
		    //  }
		     
		     
		 }
		 
		 public function NotificaFacturacionPedido($facturas)
		 {
		     $cliente = new ModeloCliente();
		     
		     $cliente->setIdCliente($this->getIdCliente());
		     		     
		     NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor() , "Pedido " . $this->getIdPedido() . " Facturado", "Se han asignado la(s) Factura(s) ".$facturas." para el Pedido ".$this->getIdPedido(), $this->getIdPedido(), "");	     
		     
		     
		 }
		 
		 
		 public function RecalcularPedido($idPedido, $doTransaction = false)
		 {
		     $this->setIdPedido($idPedido);
		     
		     if (!$doTransaction) echo "<br> ----------------------------- <h1>". $idPedido ."</h1>  ---------------------------------------------------<br>";
		     
		     if (!$doTransaction) $this->dumpAsTable();
		     
		     $sql = "select idpedidodetalle from pedidodetalle where idpedido = " . $idPedido;
		     
		     $lstpedidodetalle = $this->getDataSet($sql);
		     
		     
		     
// 		     $this->dumpBeginTable();
		     
		     $header = false;
		     $sumPedidoDetalleTotal = 0;
		     foreach($lstpedidodetalle as $pd)
		     {
		         $pedidodetalle = new ModeloPedidodetalle();
		         		         		         
		         $pedidodetalle->setIdPedidoDetalle($pd["idpedidodetalle"]);
		         
		         $sumPedidoDetalleTotal += $pedidodetalle->getTotal();
		         
// 		         if (!$header)
// 		         {
// 		             $pedidodetalle->dumpAsHeaderTable();
// 		             $header = true;
// 		         }
		         		         
// 		         $this->dumpAsRowTable();
		     }
		     
		     if (!$doTransaction) echo "Total (pedidodetallesum): " . $sumPedidoDetalleTotal ;
		     
		     $pedidoOtrosCargos = $this->getOtrosCargos();
		     $pedidoDescuento = $this->getDescuento();
		     
		     $pedidoTotal = $sumPedidoDetalleTotal + $pedidoOtrosCargos - $pedidoDescuento;
		     
		     if (!$doTransaction)
		     {
    		     echo "<br><br> Total: " . $pedidoTotal;
    		     
    		     echo "<br><br>";
		         
		     }
		     
		     $sql = "select idcxc from cxc where idpedido = " . $idPedido . " order by idcxc";
		     
		     $lstcxc = $this->getDataSet($sql);		    
		     
		     $saldoAnterior = 0;
		     $isPrimerCargo = true;
		     foreach ($lstcxc as $c)
		     {
		         $cxc = new ModeloCxc();
		         
		         $cxc->setIdCxc($c["idcxc"]);
		         		         
		         
		         
		         if (!$doTransaction) 
		         {
		             $cxc->dumpAsTable();
		             echo "<br>";
		         }
		         
		         
		         
		         
		         
		         if ($doTransaction)
		         {
		             if ($isPrimerCargo)
		             {
		                 $cxc->setMonto($pedidoTotal);
		                 $isPrimerCargo = false;
		             }
		             else
		             {
		                 $cxc->setSaldoActual($saldoAnterior);
		             }
		             
		             $cxc->Guardar();
		         }
		         
		         if ($cxc->getMovimiento() == "CARGO")
		         {
		             $saldoAnterior += $cxc->getMonto();
		         }
		         else
		         {
		             $saldoAnterior -= $cxc->getMonto();
		         }
		         
		         if (!$doTransaction) echo "<br> como queda saldo = " . $saldoAnterior;
		         
		         if (!$doTransaction) echo "<br>";
		     }
		     
		     if ($doTransaction)
		     {
    		     if ($saldoAnterior <= 0)
    		     {
    		         $saldoAnterior = 0;
    		        
    		         $this->setSaldadaSI();
    		        
    		     }
    		     else
    		     {
    		         $this->setSaldadaNO();
    		     }
    		     
//     		     $pedidoTotal = $sumPedidoDetalleTotal + $pedidoOtrosCargos - $pedidoDescuento;
    		
    		     
    		     $this->setSaldo($saldoAnterior);
    		     $this->setSubtotal($sumPedidoDetalleTotal);
    		     $this->setTotal($pedidoTotal);
    		     
    		     $this->Guardar();
		         
		     }
		    
		    
		    
		 
// 		     $this->dumpEndTable();
		 }

		 public function AllThisPedidoToValeSalida($idPedido)
		 {
		     $idValeSalidaPromotor = 0;
		     $blncommit = true;
		     
		     $this->setIdPedido($idPedido);
		     
		     if ($this->getIdPedido() <= 0)
		     {
		         return 0;
		     }
		     
		     $this->transaccionIniciar();
		     
		     $sql = "select idpedidodetalle, idproducto, (partida - partidaenvale) as cantidadparavale from pedidodetalle where idpedido = " . $this->idPedido;
		     
		     $lstPedidoDetalle = $this->getDataSet($sql);
		     
		     $vp = new ModeloValesalidapromotor();
		     
		     $vp->setIdPedido($this->idPedido);
		     $vp->setEstadoCREADO();
		     $vp->setDateAndUser("creado");
		     
		     $vp->Guardar();
		     
		     if (!$vp->getError())
		     {
    		     foreach ($lstPedidoDetalle as $pd)
    		     {
    		         $vpd = new ModeloValesalidapromotordetalle();
    		             		             		         
    		         $vpd->setIdValeSalidaPromotor($vp->getIdValeSalidaPromotor());
    		         
    		         $vpd->setIdPedidoDetalle($pd["idpedidodetalle"]);
    		         $vpd->setIdPedido($this->idPedido);
    		         $vpd->setIdProducto($pd["idproducto"]);
    		         $vpd->setCantidad($pd["cantidadparavale"]);
    		         
    		         $vpd->setDateAndUser("despacho");
    		         
    		         $vpd->Guardar();
    		         
    		         if ($vpd->getError())
    		         {
    		             $blncommit = false;
    		             break;
    		         }
    		     }
    		     
    		     $idValeSalidaPromotor = $vp->getIdValeSalidaPromotor();
		         
		     }
		     else
		     {
		         $blncommit = false;
		     }
		     
		     
		     
		     if ($blncommit)
		     {
		         $this->transaccionCommit();
		     }
		     else
		     {
		         $idValeSalidaPromotor = 0;
		         $this->transaccionRollback();
		     }
		     
		     
		     
		     return $idValeSalidaPromotor;
		 }
		 
		 
		 public function pagarConReciboDinero($cantidadAPagar, &$msg)
		 {		     
// 		     echo "<br>Vamos a comenzar pagarConReciboDinero, a pagar: ".$cantidadAPagar;
		     		     
// 		     echo "<br>Obtenemos Saldo";
		     $sql = "select getSaldoReciboDinero(".$this->getIdCliente().") saldo";
		     
		     $rs = $this->getDataSet($sql);
		     
		     $saldo = $rs[0]["saldo"];
// 		     echo "<br>Saldo: " .$saldo;
		     
		     if ($cantidadAPagar > $saldo)
		     {
		         $msg = "La cantidad que desea pagar, supera el saldo del Cliente. Disponible del Cliente: " . number_format($saldo, 2);
		         return false;
		     }
		     
		     if ($cantidadAPagar > $this->getSaldo())
		     {
		         $msg = "Se esta intentando pagar mas del saldo del pedido. Saldo del Pedido: " . number_format($this->getSaldo(),2);
		         return false;
		     }
		     
		     $sql = "select * 
                    from recibodinero 
                    where idCliente = ".$this->getIdCliente()."
                    and disponible > 0
                    order by idReciboDinero asc";
		     
		     $rs = $this->getDataSet($sql);
		     
// 		     echo "<br>Se encontraron ".count($rs)." recibos"; 
		     
 		     if (count($rs) == 0)
 		     {
 		         $msg = "No se han encontrado Recibos de Dinero con Disponible para tomar.";
 		         return false;
 		     }
 		     
 		     $cantidadRestante = $cantidadAPagar;
 		     $cantidadATomar = 0;
 		     foreach ($rs as $rd)
 		     {
 		         $recibo = new ModeloRecibodinero();
 		         
 		         $recibo->setIdReciboDinero($rd["idReciboDinero"]);
 		         
 		         if ($recibo->getIdReciboDinero() <= 0)
 		         {
 		             $msg = "No se pudo obtener información de Recibo de Dinero.";
 		             return false;
 		         }
 		         
 		         if ($cantidadRestante <= $recibo->getDisponible())
 		         {
 		             $cantidadATomar = $cantidadRestante;
 		         }
 		         else
 		         {
 		             $cantidadATomar = $recibo->getDisponible();
 		         }
 		         
 		         $cxc = new ModeloCxc();
 		         
//  		         $cxc->transaccionIniciar();
 		         $cxc->setIdPedido($this->getIdPedido());
 		         $cxc->setIdCliente($this->getIdCliente());
 		         $cxc->setMovimientoABONO();
 		         $cxc->setMonto($cantidadATomar);
 		         $cxc->setFormaPago($recibo->getFormaPago());
 		         $cxc->setReferencia("Abono desde Recibo de Dinero ".$recibo->getIdReciboDinero().", ref: ".$recibo->getReferencia());
 		         $cxc->setDateAndUser("movimiento");
 		         $cxc->setIdReciboDinero($recibo->getIdReciboDinero());
 		         
 		         $cxc->Guardar();

//  		         echo "<br><br>Tomar de Recibo de dinero: ".$recibo->getIdReciboDinero()." -> ".$cantidadATomar." <br>";
 		         
 		         if ($cxc->getError())
 		         {
 		             $cxc->transaccionRollback();
 		             $msg = $cxc->getStrError();
 		             return false;
 		         }
 		         else
 		         {
 		             $movrd = new ModeloMovrecibodinero();
 		             
 		             $movrd->setIdReciboDinero($recibo->getIdReciboDinero());
 		             $movrd->setIdPedido($this->getIdPedido());
 		             $movrd->setMonto($cantidadATomar);
 		             $movrd->setDateAndUser("movimiento");
 		             $movrd->setObservaciones("Abono a Pedido");
 		             $movrd->setMovimientoUSADOENPEDIDO();
 		             
 		             $movrd->Guardar();
 		             
 		             if ($movrd->getError())
 		             {
 		                 $msg = $cxc->getStrError();
//  		                 $cxc->transaccionRollback();
 		                 return false;
 		             }
 		             else
 		             {
//  		                 $cxc->transaccionCommit();
 		                 
 		                 $cantidadRestante = $cantidadRestante - $cantidadATomar;
 		                 
 		                 
 		             }
 		             
 		         }
 		         
 		         if ($cantidadRestante <=0 )
 		             break;
 		         
 		     }
		     
 		     if ($this->getSaldo() > $cantidadAPagar)
 		     {
 		         $msg = "Se ha abonado " . number_format($cantidadAPagar,2) . " al pedido.";
 		     }
 		     else
 		     {
 		         if ($this->getSaldo() == $cantidadAPagar)
 		         {
 		             $msg = "Se ha abonado " . number_format($cantidadAPagar,2) . " al pedido. El Pedido se ha saldado";
 		         }
 		     }
		     
		     
		     return true;
		 }
		 
		 
		 public function generarValesSalidaAutomatico($idPedido, &$msg)
		 {
		     $obj = new ModeloPedido();
		     
		     $sql = "Select idSucursal, nombre from sucursal";
		     
		     $dsSucursales = $obj->getDataSet($sql);
		     
		     foreach ($dsSucursales as $suc)
		     {
// 		         echo "<br> " . $suc["idSucursal"] . " - " . $suc["nombre"];
		         
		         $sql = "
            select pd.idpedidodetalle, pd.idproducto detIdProducto, pd.partidaenvale,
                    vp.codigo as proCodigo, vp.longitud as proLongitud, vp.idTipoProducto as proIdTipoProducto,
            		vp.tipoProducto as proTipoProducto, vp.shortTipoProducto as proShortTipoProducto,
            		vp.idAplicacion as proIdAplicacion, vp.aplicacion as proAplicacion, vp.idMaterial as proIdMaterial,
            		vp.material as proMaterial,
            		vp.idRollo as proIdRollo, vp.rolloCodigo, vp.rolloIdMaterial, vp.rolloMaterial, vp.rolloShortMaterial, vp.rolloIdProveedor, vp.rolloProveedor, vp.rolloShortProveedor,
            		vp.rolloCalibre, vp.rolloPies, vp.rolloDescripcion, vp.rollodescauto,
            		vp.idUnidad as proIdUnidad, vp.unidad as proUnidad, vp.shortUnidad as proShortUnidad, vp.calibre as proCalibre, vp.descripcion as proDescripcion, vp.descauto as proDescAuto,
            		vp.existencia as proExistencia, vp.tipoPrecio as proTipoPrecio, vp.isRango as proIsRango, vp.isRollo as proIsRollo, vp.estado as proEstado,
                    pd.partida as detPartida, pd.cantidad as detCantidad, pd.cantidadReal as detCantidadReal, pd.desarrollo as detDesarrollo,
            		pd.dobleces as detDobleces, pd.molDescMaquila  ,
                    vrmol.codigo rolloMolduraCodigo, vrmol.descauto rolloMolduraDesc,
                    pdc.idpedidodetallecolocacion, pdc.idSucursal, pdc.cantidad cantidadcolocada, pdc.cantidadenvale cantidadenvale, s.nombre nombresucursal
                from pedidodetalle pd
                inner join viewproductos as vp on vp.idProducto = pd.idProducto
                LEFT JOIN viewrollos as vrmol ON vrmol.idRollo = pd.idRolloBase
            INNER JOIN pedidodetallecolocacion pdc on pd.idpedidodetalle = pdc.idpedidodetalle
            INNER JOIN sucursal s on pdc.idsucursal = s.idsucursal
                where pd.idpedido = ".$idPedido." and pdc.idsucursal = ".$suc["idSucursal"]." and (pdc.cantidad - pdc.cantidadenvale) > 0 order by pd.renglon
        ";
		         
		         $dcColocacion = $obj->getDataSet($sql);
		         
		         if (count($dcColocacion) > 0)
		         {
		             $valeGenerado = false;
		             $vp = new ModeloValesalidapromotor();
		             
		             $vp->transaccionIniciar();
		             foreach ($dcColocacion as $col)
		             {
		                 $idProducto = $col["detIdProducto"];
		                 $idsucursal = $col["idSucursal"];
		                 $cantidadcolocada = $col["cantidadcolocada"];
		                 $cantidadenvale = $col["cantidadenvale"];
		                 $cantidadAPonerEnVale = $cantidadcolocada - $cantidadenvale;
		                 $idPedidoDetalle = $col["idpedidodetalle"];
		                 $idPedidoDetalleColocacion = $col["idpedidodetallecolocacion"];
// 		                 echo "<br>   idPedidoDetalle = ".$idPedidoDetalle."  idPedidoDetalleColocacion = ".$idPedidoDetalleColocacion   ." -- detidproducto = ".$idProducto." -- idsucursal =  ".$idsucursal." -- cantidadcolocada =  ".$cantidadcolocada." -- cantidadenvale = ".$cantidadenvale."  --       Por Colocar = " . $cantidadAPonerEnVale;
		                 
		                 if (!$valeGenerado)
		                 {
// 		                     echo "<br>A generar Vale";
		                     $vp->setIdPedido($idPedido);
		                     $vp->setEstadoCREADO();
		                     $vp->setDateAndUser("creado");
		                     $vp->setIdSucursal($idsucursal);
		                     
		                     $vp->Guardar();
		                     
		                     if ($vp->getError())
		                     {
		                         $msg = $vp->getStrError();
// 		                         echo "<br> error insertar Vale vale " . $msg;
		                         $vp->transaccionRollback();
		                         return false;
		                     }
		                     
// 		                     echo "<br> Vale Generado: " . $vp->getIdValeSalidaPromotor();
		                     
		                     $valeGenerado = true;
		                 }
		                 
		                 
		                 $vpd = new ModeloValesalidapromotordetalle();
		                 
		                 $vpd->setIdValeSalidaPromotor($vp->getIdValeSalidaPromotor());
		                 
		                 $vpd->setIdPedidoDetalle($idPedidoDetalle);
		                 $vpd->setIdPedido($idPedido);
		                 $vpd->setIdProducto($idProducto);
		                 $vpd->setCantidad($cantidadAPonerEnVale);
		                 $vpd->setIdPedidoDetalleColocacion($idPedidoDetalleColocacion);
		                 $vpd->setIdSucursalDespachado($idsucursal);
		                 
		                 $vpd->setDateAndUser("despacho");
		                 
		                 $vpd->Guardar();
		                 
		                 if ($vpd->getError())
		                 {
		                     
		                     $msg = $vpd->getStrError();
// 		                     echo "<br> error insertar detalle vale " . $msg;
		                     $vp->transaccionRollback();
		                     return false;
		                 }
		                 
		                 //             }
		                 
		                 //             $idValeSalidaPromotor = $vp->getIdValeSalidaPromotor();
		                 
		                 //         }
		                 //         else
		                 //         {
		                 //             $blncommit = false;
		                 //         }
		                 
		                 
		                 
		                 
		                 
		                 
		                 
		             }
		             
// 		             echo "<br> Commit";
		             $vp->transaccionCommit();
		         }
		         else
		         {
// 		             $msg = "<br>No hay mercancia para vale";
// 		             return false;
		         }
		         
		         
		     }
		     
		     
		     $sql = " select idvalesalidapromotor from valesalidapromotor where idpedido = ".$idPedido." and idvalesalida = 0 ";
		     
		     $dsValesPromotor = $obj->getDataSet($sql);
		     
		     foreach ($dsValesPromotor as $v)
		     {
		         $vsp = new ModeloValesalidapromotor();
		         
		         $idValeSalidaPromotor = $v["idvalesalidapromotor"];
		         
		         if (!$vsp->GenerarValeSalidaReal($idValeSalidaPromotor))
		         {
		             $msg = "Error al confirmar el Vale de Salida Promotor: " . $idValeSalidaPromotor;
		             return false;
		         }
		     }
		     
		     $msg = "OK";
		     return true;
		 }

		function getlogCliente($idCliente)
		{
			$this->__idClienteCC = $idCliente;

			if (!file_exists (FOLDER_INCLUDE . "logs/creditos_".$idCliente."_.log"))
			{
				return "No Log found.";
			}

			$this->__filename = FOLDER_INCLUDE . "logs/creditos_".$this->__idClienteCC."_.log";

			$fh = fopen($this->__filename, 'r'); // or die("Se produjo un error al abrir el archivo");
  
			$texto = "<div class=\"ibox float-e-margins\">";
			$texto .= "  <div class=\"ibox-title\">";
			$texto .= "   <h5>Log Creditos Cliente</h5>";				
			$texto .= "  </div>";
			$texto .= "<div class=\"ibox-content\">";
			// $texto .= "  <table class=\"table table-hover margin bottom\">";
			// $texto .= "    <tbody>";
			
			// $texto .= "    <thead>";
			// $texto .= "	      <tr>";
        	// $texto .= "	          <th class=\"text-center\">Date</th>";
			// $texto .= "	          <th class=\"text-center\">Amount</th>";
			// $texto .= "	          <th>Transaction</th>";
			// $texto .= "	      <tr>";
			
			//Mientras haya un línea que obtener, se concatena el contenido de la línea con la variable texto
			while($linea = fgets($fh))
			{
			//    $texto .= $linea. "<br>";
				$texto .= "<tr>";
				// $texto .= $linea;

				if (substr($linea, 0, 3) != "---")
				{
					// $texto .= "<td style=\"width: 15%\"><span style=\"color: gray\"><strong>".substr($linea, 0, 20)."</strong></span></td>";
					 $texto .= "<span style=\"color: gray\"><strong>".substr($linea, 0, 20)."</strong></span>";
					// $texto .= "<td><span class=\"text-danger\"><strong>".substr($linea, 11, 9)."</strong></span></td>";
					// $texto .= "<td><strong>".str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", substr($linea, 20))."</strong></td>";
					$texto .= "<strong>".str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", substr($linea, 20))."</strong>";
					// $texto .= "</tr>";
					$texto .= "<br>";
				}
				else
				{
					// $texto .= "<td style=\"width: 10%\"><span class=\"text-success\"><strong></strong></span></td>";
					$texto .= "<span class=\"text-success\"><strong></strong></span>";
					// $texto .= "<td><span class=\"text-danger\"><strong></strong></span></td>";
					// $texto .= "<td><strong>".str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", substr($linea, 3))."</strong></td>";
					$linea = "\t\t\t\t\t\t\t\t\t\t".substr($linea, 3);
					$texto .= "<strong>".str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", substr($linea, 3))."</strong>";
					// $texto .= "</tr>";
					$texto .= "<br>";
				}


			}

			// $texto .= "    </tbody>";
			// $texto .= "  </table>";
			$texto .= "</div>";
			$texto .= "</div>";
			
		   
			fclose($fh);
			
			return $texto;
		 }

		 function logCliente($mensaje = "", $includeTime=false)
		 {      
			$this->__filename = FOLDER_INCLUDE . "logs/creditos_".$this->__idClienteCC."_.log";

			if($archivo = fopen($this->__filename, "a"))
			{
				fwrite($archivo, ($includeTime ? date("d m Y H:m:s"). " " : "---" ). $mensaje. "\n");
						
				fclose($archivo);
			}
		 }

		 function logClientewTime($mensaje)
		 {      
			$this->logCliente($mensaje, true);
		 }

		 public function procesaCreditoYCapacidadDePago($idCliente)
		 {
			 
			if (file_exists (FOLDER_INCLUDE . "logs/creditos_".$idCliente."_.log"))
			{
				unlink(FOLDER_INCLUDE . "logs/creditos_".$idCliente."_.log");
			}

			$this->__idClienteCC = $idCliente;
			
			$_NOW_=date("Y-m-d H:i:s");

			$this->logClientewTime(" + + + + + + + + + + + Inicia Proceso de Creditos Y Capacidad de Pago + + + + + + + + + + + ");

			

			$cliente = new ModeloCliente();
			$cliente->setIdCliente($idCliente);

			$cliente->setProcesarCreditosNO();
			$cliente->setFecha_ultimo_proceso($_NOW_);

			$cliente->Guardar();



			$sql = "SELECT p.idPedido, p.estado, p.total, p.saldo, c.credito, c.capacidadPago 
					FROM pedido p
					INNER JOIN cliente c ON p.idCliente = c.idCliente 
					WHERE p.idcliente = " . $this->__idClienteCC .  "
                    AND p.saldo > 0 
					ORDER BY p.idPedido";

			$lstPedidos = $this->getDataSet($sql);
			$creditoCliente = 0;
			$capacidadPagoCliente = 0;

			if (count($lstPedidos) > 0)
			{
				$creditoCliente = $lstPedidos[0]["credito"];
				$capacidadPagoCliente = $lstPedidos[0]["capacidadPago"];

				
				foreach ($lstPedidos as $ped)
				{
					PedidoTrackingManager::logInfo($ped["idPedido"], "Inicia proceso de Credito y Capacidad de Pago");
					
					$total = $ped["total"];
					$saldo = $ped["saldo"];

					$this->logCliente();
					$this->logCliente("Disponible \$Crédito:           " . $creditoCliente );
					$this->logCliente("Disponible \$Capacidad de Pago: " . $capacidadPagoCliente);

					
					$this->logClientewTime("\t*Analizando Pedido: <h1><strong style='color: blue'>\t\t\t\t\t" . $ped["idPedido"] . "</strong></h1>\t\t\t\t\t\t\t\t\t\tEstado: <strong style='color: blue'>". $ped["estado"]."</strong>");

					$this->logCliente("\t\t===>Total: " . $total );
					$this->logCliente("\t\t===>Saldo: " . $saldo );

					$porAbono = $saldo * 100 / $total;
					$porAbono = 100 - $porAbono;

					$this->logCliente("\t\t======> % Abono: " . $porAbono );

					$cubreCredito = 0;
					$cubreCapacidadPago = 0;
					$cubiertoPorCredito = false;
					$cubiertoPorCapacidadPago = false;

					if ($creditoCliente >= $saldo)
					{
						$cubreCredito = $saldo;
						$cubiertoPorCredito = true;
					}
					else
					{
						$cubreCredito = $creditoCliente;
					}

					if ($capacidadPagoCliente >= $saldo)
					{
						$cubreCapacidadPago = $saldo;
						$cubiertoPorCapacidadPago = true;
					}
					else
					{
						$cubreCapacidadPago = $capacidadPagoCliente;
					}

					$this->logCliente("\t\t\t==========> Credito cubre: " . $cubreCredito . "\t\t//// Cubierto por Crédito: " .($cubiertoPorCredito ? "*SI*" : "*NO*"));
					$this->logCliente("\t\t\t==========> Capacidad Pago cubre: " . $cubreCapacidadPago . "\t\t//// Cubierto por Capacidad Pago: " .($cubiertoPorCapacidadPago ? "*SI*" : "*NO*"));

					PedidoTrackingManager::logInfo($ped["idPedido"], "Crédito cubre: " . $cubreCredito . " - Cubierto por Crédito?: " .($cubiertoPorCredito ? "*SI*" : "*NO*"));
					
					PedidoTrackingManager::logInfo($ped["idPedido"], "Capacidad Pago cubre: " . $cubreCapacidadPago . " - Cubierto por Capacidad Pago?: " .($cubiertoPorCapacidadPago ? "*SI*" : "*NO*"));
					

					$creditoCliente -= $cubreCredito;
					$capacidadPagoCliente -= $cubreCapacidadPago;

					$this->logCliente("");
					// $this->logCliente("");
					// $this->logCliente("");

					if($cubiertoPorCapacidadPago || $cubiertoPorCredito)
					{
						if ($ped["estado"] == 'CAPTURADO')
						{
							$resultado = $this->checarSurtimientoPedido($ped["idPedido"], $porAbono);
						}
						else
						{
							$this->logCliente("\t\t<strong style='color: green'>\t\t**** NO se analiza Pedido, debe estar capturado pues este es un proceso para autorización automática. ****</strong>");
							PedidoTrackingManager::logWarning($ped["idPedido"], "**** NO se analiza Pedido, debe estar capturado pues este es un proceso para autorización automática. ****");
							
						}

					}
					else
					{
						$this->logCliente("<strong style='color: red'>El Saldo de este Pedido no es cubierto por Capacidad de Pago o Crédito. NO se autorizará.</strong>");
						PedidoTrackingManager::logError($ped["idPedido"], "El Saldo de este Pedido no es cubierto por Capacidad de Pago o Crédito. NO se autorizará.");
						
					}


					// var_dump($resultado);

				}
			}
			



			
			$this->logClientewTime("- - - - - - - - - - - FIN Proceso de Creditos Y Capacidad de Pago - - - - - - - - - - -\n");

		 }

		 private function checarSurtimientoPedido($idPedidoToCheck, $porcentaje)
		 {
			$resultado = array(
				"surteInventario" => false,
				"surteRollos" => false,
				"surteAmbos" => false,
				"soloInventario" => true,
				"soloRollos" => true				
				);

		
			$idProductoMoldura = 386;
			$idProductoMaquilaMoldura = 394;
			$idProductoISOCOP = 439;

			$pesomt = new ModeloPesomt();

			$pesosCalibresPies = array();
			$pedidoProcesando = new ModeloPedido();		
			$idPedidoProcesando = $idPedidoToCheck;
			$pedidoProcesando->setIdPedido($idPedidoProcesando);
		
			$idSucursal = 0;			
		
			$idSucursal = $pedidoProcesando->getIdSucursalPreferenciaRecoge();			
		
			if ($idSucursal <= 0)		
			{		
				$idSucursal = $pedidoProcesando->getIdSucursalCapturado();		
			}				
		
			$pedidoDetalle = new ModeloPedidodetalle();
		
			if ($pedidoProcesando->getIdPedido() > 0)		
			{		
				$this->logCliente("\t\t---------------------------------------------------------");		
				$this->logCliente("\t\tVerificando Inventarios de Pedido: <strong style='color: blue'>" . $idPedidoProcesando . "</strong>");		
				$this->logCliente();								
				//Obtenemos el detalle de cada uno de los Pedidos
		
				$lstPedidoDetalle = $pedidoDetalle->getAll("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir",		
					"",		
					"idPedido = " . $idPedidoProcesando . " ");
		
				$cuantosRenglones = count($lstPedidoDetalle);
				
				$this->logCliente("\t\t ___");
				$this->logCliente("\t\tRenglones Pedido: <span style='color: blue'>" . $cuantosRenglones . "</span>");
				
				if ($cuantosRenglones > 0)
				{					
					$doCommitPedido = true;
				}
				else
				{
					$doCommitPedido = false;
				}
						
				$this->logCliente();		
				$this->logCliente("\t\t// + + + + +");		
				$this->logCliente("\t\t//  Comenzamos Analisis de inventarios de la sucursal");		
				$this->logCliente("\t\t// + + + + +");		
				$this->logCliente();
						
				$arrColocaciones = array();		
				// $pedidoProcesando->transaccionIniciar();
		
				foreach ($lstPedidoDetalle as $det)		
				{		
					// 		echo "<br>".$det["idPedidoDetalle"]."  -  ".$det["renglon"]."  -  ".$det["idProducto"];		
					$this->logCliente();		
					$this->logCliente("\t\tR E N G L O N: " .$det["renglon"]."          -idPedidoDetalle: ".$det["idPedidoDetalle"]."    -idProducto: ".$det["idProducto"]."    -partida: ".$det["partida"]."    -cantidad: ".$det["cantidad"]."    -cantidadReal: ".$det["cantidadReal"]);		
					$this->logCliente();						
		
					$idPedidoDetalle = $det["idPedidoDetalle"];		
					$updatePedidoDetalle = new ModeloPedidodetalle();
					$updatePedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);
		
					$viewProducto = new ModeloViewproductos();		
					$viewProducto->getViewSucursal($det["idProducto"], $idSucursal);						
		
					if (!isset($productosApartados["pieza".$viewProducto->getIdProducto()]))		
					{		
						// $this->logCliente("\t\t                -                -  Se crea objeto: pieza" . $viewProducto->getIdProducto());		
						$productosApartados["pieza".$viewProducto->getIdProducto()] = $viewProducto->getExistencia() - $viewProducto->getApartado();		
					}					
		
					if (!isset($productosApartados["rollo".$viewProducto->getIdRollo()]))		
					{		
						// $this->logCliente("\t\t                -                -  Se crea objeto: rollo" . $viewProducto->getIdRollo());		
						$productosApartados["rollo".$viewProducto->getIdRollo()] = $viewProducto->getRolloExistenciaGlobal() - $viewProducto->getRolloApartado();		
					}
		
					$totalAExplotar = $updatePedidoDetalle->getPartida() ; //$updatePedidoDetalle->getTotalExplotar();
		
					$this->logCliente();
					$this->logCliente("\t\tProducto: ". $viewProducto->getFullDescripcion());
					$this->logCliente("\t\t idRollo => " . $viewProducto->getIdRollo());
		
					$calibreProducto = $viewProducto->getRolloCalibre();
					$piesProducto = $viewProducto->getRolloPies();
		
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
		
									$this->logCliente();
									$this->logCliente("\t\tSACAR DE   I N V E N T A R I O ");
									$this->logCliente("\t\t   Producto Existencia: " . $viewProducto->getExistencia() . "        Apartado: " . $viewProducto->getApartado());
									$this->logCliente("\t\t   SACAR => " . $totalAExplotar);
									$this->logCliente("\t\t    =>=>  Quitamos(Simulacro) de Inventario ");
							
									$deDondeDescontar = $productosApartados["pieza".$viewProducto->getIdProducto()];

									if($deDondeDescontar >= $totalAExplotar)
									{
										$this->logCliente("\t\t ---------------->>>>>>> Listo para Asignar SI");
		
										$coloca = new ModeloPedidodetallecolocacion();
										$coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
										$coloca->setIdSucursal($idSucursal);
										$coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
	
										$coloca->setCantidad($totalAExplotar);
	
										array_push($arrColocaciones, $coloca);
		
									}
									else
									{
										$this->logCliente("\t\t <strong style='color: red'>**------- >  no alcanza a salir la mercancia, no se puede proceder con este Pedido</strong>");
										$doCommitPedido = false;
		
									}		
								}		
								else		
								{		
									$this->logCliente("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanzo a surtirse, no se verifica producto</strong>");		
									$doCommitPedido = false;		
								}
		
							}
							else
							{
		
								$idProductoToCheck = $viewProducto->getIdProducto();
								$resultado["soloInventario"] = false;
								if (!isset($productosNegados["pn".$idProductoToCheck]))
								{
									$this->logCliente();
									$this->logCliente("\t\tSACAR DE     R O L L O");
									$this->logCliente("\t\t Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());
									
									$sacarRollo = new ModeloRollo();
									$sacarRollo->setIdRollo($viewProducto->getIdRollo());
		
									$this->logCliente("\t\t   SACAR DE CALIBRE ".$viewProducto->getRolloCalibre()." => ". $totalAExplotar);
									$this->logCliente("\t\t    =>=>  Quitamos(Simulacro) de Rollo AA");
		
									$deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];
	
									$this->logCliente("\t\t --- --- => DeDondeSacar: " . $deDondeDescontar);
		
									if($deDondeDescontar >= $totalAExplotar)
									{
										$this->logCliente("\t\t ---------------->>>>>>> Listo para Asignar SI");
	
										$coloca = new ModeloPedidodetallecolocacion();
										$coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
										$coloca->setIdSucursal($idSucursal);
										$coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
										$coloca->setCantidad($totalAExplotar);
		
										array_push($arrColocaciones, $coloca);
		
									}
									else
									{
										$this->logCliente("\t\t <strong style='color: red'>------- >  no alcanza a salir la mercancía, no se puede proceder con este Pedido</strong>");
										$doCommitPedido = false;
										// $this->logCliente("\t\t   }}}}}}}}}}}}}}}}}}      Se Negará Producto para futura Explosión</strong>");
									}
		
								}
								else
								{
									$this->logCliente("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto</strong>");
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
								$this->logCliente();
								$this->logCliente("\t\tSACAR DE    R O L L O");
								$this->logCliente("\t\t Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());
	
								$this->logCliente("\t\t   SACAR DE CALIBRE ".$calibreProducto." => ". $totalAExplotar);
								$this->logCliente("\t\t    =>=>  Quitamos(Simulacro) de Rollo BB");
		
								$deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];
								$this->logCliente("\t\t --- --- => DeDondeSacar: " . $deDondeDescontar);
		
								$kilosAExplotar = $updatePedidoDetalle->getTotalExplotar();
								$this->logCliente("\t\t     --- ===> " . $kilosAExplotar);
				
								if ($totalAExplotar > 0)
								{
									$sacarRollo = new ModeloRollo();
									$sacarRollo->setIdRollo($viewProducto->getIdRollo());
				
									if($deDondeDescontar >= $kilosAExplotar)
									{
										$this->logCliente("\t\t ---------------->>>>>>> Listo para Asignar SI");
										$coloca = new ModeloPedidodetallecolocacion();
		
										$coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
										$coloca->setIdSucursal($idSucursal);
										$coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
		
										$coloca->setCantidad($totalAExplotar);
										array_push($arrColocaciones, $coloca);
									}
									else
									{
										$this->logCliente("\t\t <strong style='color: red'>------- >  no alcanza a salir la mercancía, no se puede proceder con este Pedido</strong>");
										$doCommitPedido = false;
		
									}
								}
								else
								{
									$this->logCliente("\t\t ------- >  Total a Surtir = 0, no puede ser");
									$doCommitPedido = false;
								}
							}
							else
							{
								$this->logCliente("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto</strong>");
								$doCommitPedido = false;
							}
						}
		
					}
					else //MOLDURAS
					{
		
						$this->logCliente();
						$this->logCliente("\t\tMOLDURAS/MAQUILAS, NO SE SACAN DE ALGUN LADO ");
						$this->logCliente("\t\t   No se manejan existencias");
						$this->logCliente("\t\t   SOLICITADAS => " . $totalAExplotar);
						$this->logCliente("\t\t    =>=>  MOLDURAS/MAQUILAS no gestionan Inventario ");
		
						$this->logCliente("\t\t ---------------->>>>>>> Listo para Producir SI");
		
						$this->logCliente("\t\t<strong style='color: green'>=============== Se manejarán ".$totalAExplotar."  MOLDURAS/MAQUILAS</strong>" );
		
						$this->logCliente();

						$coloca = new ModeloPedidodetallecolocacion();
		
						$coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
						$coloca->setIdSucursal($idSucursal);
						$coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
						$coloca->setCantidad($totalAExplotar);

						array_push($arrColocaciones, $coloca);
		
					}
				}
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
				// 		PedidoTrackingManager::logError($idPedidoToCheck, "Con 0% de Abono, se autorizaría si solo hubiera mercancía de Stock, pero este Pedido no es el caso.");
						
				// 	}
				// }

		
				if ($doCommitPedido)
		
				{
		
					// 			$this->logCliente();
		
					$this->logCliente();
		
					$this->logCliente("\t\t\t\t <strong style='color: green'>************ EL PEDIDO PASA VALIDACIÓN PARA   A U T O R I Z A R S E  en automático ***********</strong>");
					PedidoTrackingManager::logSuccess($idPedidoToCheck, "************ EL PEDIDO PASA VALIDACIÓN PARA   A U T O R I Z A R S E  en automático ***********");
				
					
		
					foreach ($arrColocaciones as $col)
					{
						$this->logCliente("Colocando:   ");
						$col->Guardar();
		
					}
		
					$_NOW_=date("Y-m-d H:i:s");
		
					if ($doCommitPedido)
		
					{
		
						$pedidoProcesando->setColocadoSI();
		
						$pedidoProcesando->setEstadoAUTORIZADO();
						$pedidoProcesando->setFecha_autorizado($_NOW_);
						$pedidoProcesando->setId_usuario_autorizado(2);
						$pedidoProcesando->setTipoAutorizacionAUTOMATICO();
					
						$pedidoProcesando->setColocadoAutomaticoSI();
			
						$pedidoProcesando->Guardar();		
						$pedidoProcesando->NotificaAutorizacionAutomaticaPedido();
						
						$this->logCliente("\t\t <strong style='color: blue'>- - - - - - - -    VAMOS A ver si se GENERAN V A L E S  D E   S A L I D A </strong>");
		
						$this->logCliente();
						if ($pedidoProcesando->getRecogeentrega() == "RECOGE")
						{
							$this->logCliente("\t\tSe generaran los vales en automatico");
							PedidoTrackingManager::logSuccess($idPedidoToCheck, "Se generarán los vales en automatico");
							
							$msg = "";
							$pedidoProcesando->generarValesSalidaAutomatico($pedidoProcesando->getIdPedido(), $msg);
						}
		
						
		
						// $pedidoProcesando->transaccionCommit();
		
						$this->logCliente();
		
						$this->logCliente("\t\tFIN Pedido: <span style='color: blue'>" . $idPedidoProcesando . "</span>");
		
						$this->logCliente("\t\t-------------------------------------------------------------------------------------------------------");
		
					}
		
					else
		
					{
		
						$this->logCliente();
		
						$this->logCliente("\t\tFIN Pedido ... ERA COMMIT PERO HUBO ERROR: <span style='color: red'> " . $idPedidoProcesando . "</span>");
		
						$this->logCliente("\t\t--------------------------------------------------------------------------------------------");
		
					}
		
					
		
					
		
				}
		
				else
		
				{
		
					$this->logCliente();
		
		
				}
		
		
				$this->logCliente();
		
			}
		
			
		
			
		
		}

		private function logDebug($msg = "")
		{
          if ($this->__isDebugging) echo $msg . "<br>\n\r";
		}

		public function verificarSiPedidoPuedeSurtirse($idPedido)
		 {

			$this->logDebug("Comenzando con Pedido: " . $idPedido);
						
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

			$idProductoMoldura = 386;

			$idProductoMaquilaMoldura = 394;

			$idProductoISOCOP = 439;





			$pesomt = new ModeloPesomt();

			$pesosCalibresPies = array();

			$pedidoProcesando = new ModeloPedido();
			// $pedidoProcesando = new ModeloPedido();		
			// $idPedidoProcesando = $idPedidoToCheck;
			$idPedidoProcesando = $idPedido;

			//$pedidoProcesando->setIdPedido($idPedidoProcesando);
			$this->logDebug("Cargando Pedido: " . $idPedido);
			$pedidoProcesando->setIdPedido($idPedido);		

			// $pedidoProcesando->dumpObj();
		
			$idSucursal = 0;			
		
			$idSucursal = $pedidoProcesando->getIdSucursalPreferenciaRecoge();
		
			
		
			if ($idSucursal <= 0)
		
			{
		
				$idSucursal = $pedidoProcesando->getIdSucursalCapturado();
		
			}
		
						
		
			$pedidoDetalle = new ModeloPedidodetalle();
			// $cotizacionDetalle = new ModeloCotizaciondetalle();
				
			if ($pedidoProcesando->getIdPedido() > 0)
			// if ($pedidoProcesando->getIdCotizacion() > 0)
		
			{
		
				$this->logDebug("\t\t---------------------------------------------------------");
		
				$this->logDebug("\t\tVerificando Inventarios de Cotizacion: <strong style='color: blue'>" . $idPedidoProcesando . "</strong>");
		
				$this->logDebug();
		
		
				//Obtenemos el detalle de la cotizacion
		
				$lstPedidoDetalle = $pedidoDetalle->getAll("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, partida totalExplotado",
		
					"",
		
					"idpedido = " . $idPedidoProcesando . " ");
		
				
		
				//echo $pedidoDetalle->getAllQUERY("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir", "", "idPedido = " . $idPedidoProcesando);
		
				// 		$pedidoProcesando->transaccionIniciar();
		
				$cuantosRenglones = count($lstPedidoDetalle);
				
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
		
				
		
				foreach ($lstPedidoDetalle as $det)
		
				{
		
					// 		echo "<br>".$det["idPedidoDetalle"]."  -  ".$det["renglon"]."  -  ".$det["idProducto"];
		
					$this->logDebug();
		
					$this->logDebug("\t\tR E N G L O N: " .$det["renglon"]."          -idPedidoDetalle: ".$det["idPedidoDetalle"]."    -idProducto: ".$det["idProducto"]."    -partida: ".$det["partida"]."    -cantidad: ".$det["cantidad"]."    -cantidadReal: ".$det["cantidadReal"]);
		
					$this->logDebug();
		
					
		
					$idPedidoDetalle = $det["idPedidoDetalle"];
		
					$updatePedidoDetalle = new ModeloPedidodetalle();
		
					
		
					$updatePedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);
		
					
		
					$viewProducto = new ModeloViewproductos();
		
					$viewProducto->getViewGlobal($det["idProducto"], $idSucursal);
		
					
		
					if (!isset($productosApartados["pieza".$viewProducto->getIdProducto()]))
		
					{
		
						// $this->logCliente("\t\t                -                -  Se crea objeto: pieza" . $viewProducto->getIdProducto());
		
						$productosApartados["pieza".$viewProducto->getIdProducto()] = $viewProducto->getExistencia() - $viewProducto->getApartado();
		
					}
		
					
		
					if (!isset($productosApartados["rollo".$viewProducto->getIdRollo()]))
		
					{
		
						// $this->logCliente("\t\t                -                -  Se crea objeto: rollo" . $viewProducto->getIdRollo());
		
						$productosApartados["rollo".$viewProducto->getIdRollo()] = $viewProducto->getRolloExistenciaGlobal() - $viewProducto->getRolloApartado();
		
					}
		
					
		
					$totalAExplotar = $updatePedidoDetalle->getPartida() ; //$updatePedidoDetalle->getTotalExplotar();
		
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
		
										
		
										// $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdCotizacionDetalle());
		
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
		
									$this->logDebug("\t\t   <strong style='color: red'>--////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanzo a surtirse, no se verifica producto</strong>");
		
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
		
									$this->logDebug("\t\t Existencia: " . $viewProducto->getRolloExistenciaGlobal() . "        Apartado: " . $viewProducto->getRolloApartado());
		
									
		
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
		
								$this->logDebug("\t\t Existencia: " . $viewProducto->getRolloExistenciaGlobal() . "        Apartado: " . $viewProducto->getRolloApartado());
		
								
		
								
		
								$this->logDebug("\t\t   SACAR DE CALIBRE ".$calibreProducto." => ". $totalAExplotar);
		
								$this->logDebug("\t\t    =>=>  Quitamos(Simulacro) de Rollo BB");
		
								
		
								// 					$deDondeDescontar = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();
		
								$deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];
		
								$this->logDebug("\t\t --- --- => DeDondeSacar: " . $deDondeDescontar);
		
								$kilosAExplotar = $updatePedidoDetalle->getTotalExplotar();
		
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
		
				
		
			}
		
			
		
			
		
		}

		public function procesaAutorizacionAutomatica($idPedido, $simulacion = false)
		{
			$pedido = new ModeloPedido();
			$pedido->setIdPedido ($idPedido);

			
			if ($simulacion || $pedido->getEstado() == "CAPTURADO")
			{
				$this->logDebug("<h1>Checar Autorizacion para pedido " . $idPedido."</h1>");
				//RazonAutorizacion[1]='Inicia proceso de Autorización automática del Pedido';
				if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 1, $myJSON);
				 $this->logDebug("<span class='h3 text-info'> INFO => </span> Inicia proceso de Autorización automática del Pedido");

				
				
				 $pedido->__isDebugging = true;
				$r = $pedido->verificarSiPedidoPuedeSurtirse($idPedido);
				
				$necesitaSurtir = (count($r["NoSurtir"]) > 0  ? true : false);
				
				$cdf = new ModeloClientedatosfacturacion();
				$privado = 'SI';
				if ($pedido->getIdClienteDatosFacturacion() > 0)
				{
					$cdf->setIdClienteDatosFacturacion($pedido->getIdClienteDatosFacturacion());
					$df = new ModeloDatosfacturacion();
					$df->setIdDatosFacturacion($cdf->getIdDatosFacturacion());
					$privado = $df->getPrivado();

				}
				$cliente = new ModeloCliente();

				$datosCliente = "";
				
				if ($pedido->getIdClienteDatosFacturacion() == 0 || $privado == 'SI')
				{
					$this->logDebug("Obteniendo datos por el cliente");
					$datosCliente = "Capacidad y Credito obtenidos del Cliente en si";
					$lst = $cliente->getAll("cliente.credito,  cliente.capacidadpago, cliente.idCliente, getDiasPagoVencido(idCliente) as diasVencido,
												getCreditoUsadoClienteDatoFacturacion(cliente.idcliente, 0) creditousado,
												getCreditoUsadoClienteDatoFacturacionEntregados(cliente.idcliente, 0) creditousadoentregados,
												getSaldosMas30DiasClienteRFC(cliente.idcliente, 0) saldomas30dias,
												(SELECT IFNULL(COUNT(idPedido), 0) cantidad FROM pedido WHERE idcliente = cliente.idCliente) nopedidoscliente",
							" ",
							" cliente.idCliente = " . $pedido->getIdCliente());
				}
				else
				{
					$this->logDebug("Obteniendo datos por cliente datos facturacion");
					$datosCliente = "Capacidad y Credito obtenidos por RFC";
					$query = "SELECT idCliente, credito, capacidadpago, 
									getCreditoUsadoClienteDatoFacturacion(idCliente, idClienteDatosFacturacion) creditousado, getDiasPagoVencido(idCliente) as diasVencido,
									getCreditoUsadoClienteDatoFacturacionEntregados(idcliente, idClienteDatosFacturacion) creditousadoentregados,
									getSaldosMas30DiasClienteRFC(idCliente, idClienteDatosFacturacion) saldomas30dias,
									(SELECT IFNULL(COUNT(idPedido), 0) cantidad FROM pedido WHERE idcliente = clientedatosfacturacion.idCliente) nopedidoscliente
								FROM clientedatosfacturacion
								INNER JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
								WHERE idClienteDatosFacturacion = ".$pedido->getIdClienteDatosFacturacion();

					
					$lst = $cdf->getDataSet($query);
				}
				
				$diasVencido = 0;
				$credito = 0;
				$creditoDisponible = 0;
				$capacidadPago = 0;
				$capacidadPagoDisponible= 0;
				$pagado = $pedido->getTotal() - $pedido->getSaldo();
				$saldoPedido = $pedido->getSaldo();
				$creditoUsadoEntregados= 0;
				$capacidadPagoDisponibleEntregados=0;
				foreach($lst as $c)
				{
					$idCliente = $c["idCliente"];
					$credito = doubleval($c["credito"]);
					$capacidadPago = doubleval($c["capacidadpago"]);
					$creditoUsado = doubleval($c["creditousado"]);
					$saldomas30dias = doubleval($c["saldomas30dias"]);
					$nopedidoscliente = intval($c["nopedidoscliente"]);
					$diasVencido = intval($c["diasVencido"]);
					$creditoUsadoEntregados = doubleval($c["creditousadoentregados"]);
				}

				// $capacidadPago = 0;
				// $diasVencido = 0;
				// $creditoUsadoEntregados= 0;
				$clienteNuevo = $nopedidoscliente == 1 ? true : false;
				$creditoUsado = $creditoUsado - $pedido->getSaldo();
		


				// $this->logDebug("idCliente: " . $idCliente);
				// $this->logDebug("credito: " . $credito);
				// $this->logDebug("capacidadPago: " . $capacidadPago);
				// $this->logDebug("creditoUsado: " . $creditoUsado);
				// $this->logDebug("saldomas30dias: " . $saldomas30dias);
				// $this->logDebug("nopedidoscliente: " . $nopedidoscliente);
				
				
				$creditoDisponible = $credito - $creditoUsado;
				$creditoDisponibleEntregados = $credito - $creditoUsadoEntregados;        
				$capacidadPagoDisponibleEntregados = $capacidadPago - $creditoUsadoEntregados;

				$pagado = $pedido->getTotal() - $pedido->getSaldo();
				$saldoPedido = $pedido->getSaldo();
				if ($pedido->getTotal() > 0)
				{
					$porcentaje = $pagado * 100 / $pedido->getTotal();
				}
				else
				{
					$porcentaje = 100;
				}

				// $this->logDebug("creditoDisponible: " . $creditoDisponible);
				// $this->logDebug("creditoDisponibleEntregados: " . $creditoDisponibleEntregados);
				// $this->logDebug("capacidadPagoDisponible: " . $capacidadPagoDisponible);


				$criterioSaldoAprobado = true;
				$opcionNoCriterioAprobado = true;

				$porcentajeSaldoCredito = 100 - ($pagado * 100 / $creditoDisponibleEntregados);

				// $this->logDebug("creditoDisponible: " . $creditoDisponible);
				// $this->logDebug("creditoDisponible+20%: " . $creditodismas20);
				// $this->logDebug("capacidadPagoDisponible: " . $capacidadPagoDisponible);


				$criterioSaldoAprobado = true;
				$opcionNoCriterioAprobado = true;

				// $this->logDebug("porcentaje: " . $porcentaje);
				// $this->logDebug("pagado: " . $pagado);
				// $this->logDebug("saldoPedido: " . $saldoPedido);
				// $this->logDebug("TotalPedido: " . $pedido->getTotal());

				
				$myObj = new stdClass();
				$myObj->idCliente = $idCliente;
				$myObj->datosCliente = $datosCliente;
				$myObj->credito = number_format($credito, 2);
				$myObj->capacidadPago = number_format($capacidadPago, 2);
				//$myObj->creditoUsado = number_format($creditoUsado, 2);
				//$myObj->saldomas30dias = number_format($saldomas30dias, 2);
				$myObj->noPedidoscliente = $nopedidoscliente;
				//$myObj->creditoDisponible = number_format($creditoDisponible, 2);
				//$myObj->creditoDisponibleMas20Porciento = number_format($creditodismas20, 2);
				$myObj->porcentajeSaldoCredito = number_format($porcentajeSaldoCredito, 2);
				//$myObj->capacidadPagoDisponible = number_format($capacidadPagoDisponible, 2);
				$myObj->porcentaje = number_format($porcentaje, 2);
				$myObj->pagado = number_format($pagado, 2);
				$myObj->saldoPedido = number_format($saldoPedido, 2);
				$myObj->TotalPedido = number_format($pedido->getTotal(), 2);
				$myObj->diasVencido = $diasVencido;
				$myObj->creditoDisponibleEntregados= number_format($creditoDisponibleEntregados);
				$myObj->necesitaSurir=$necesitaSurtir; 
				$myObj->capacidadPagoDisponibleEntregados = $capacidadPagoDisponibleEntregados;

				$myJSON = json_encode($myObj);
				$this->logDebug($myJSON);




				// ***************************************************************************************************
				// ***************************************************************************************************
				// ************************************* REGLAS PEDIDO ***********************************************
				// ***************************************************************************************************
				// ***************************************************************************************************



				if ($idCliente > 0) 
				{   
					$this->logDebug("Cliente Existente"); 
					
					if ($credito > 0) 
					{
						$this->logDebug("Con Crédito"); 

						if ($necesitaSurtir) 
						{
							if (!$simulacion) PedidoTrackingManager::logError($idPedido, 2, $myJSON);
							$this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, se requiere adquisición de materiales");
							$this->logDebug("Necesita Surtir");
						}
						else
						{
							if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 7, $myJSON);
							$this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, no requiere adquisición de materiales");
							$this->logDebug("No Necesita Surtir");		
							
								if ($creditoDisponibleEntregados >= $saldoPedido && $diasVencido < 30)
								{	
										$pedido->setEstadoAUTORIZADO();
										$pedido->setTipoAutorizacionAUTOMATICO();
										$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
										$pedido->setId_usuario_autorizado(2);
										$pedido->setObservacionAutoriza("Criterio para liberación aprobado: Saldo de crédito cubre pedido y no tiene pedidos vencidos a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) . "%). Se ha autorizado de manera automática."); 
										if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 70, $myJSON);
										$this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Saldo de crédito cubre pedido y no tiene pedidos vencidos a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");
								}
								else
								{
										if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 71, $myJSON);
										$this->logDebug("<span class='h3 text-warning'> WARNING => </span> Crédito disponible no cubre el saldo del pedido ó tiene pedidos entregados con mas de 30 dias con saldo.");
										$criterioSaldoAprobado = false;
								}

								if(!$criterioSaldoAprobado){
										if($diasVencido <  5 && $creditoDisponibleEntregados > $saldoPedido){
											if (!$simulacion) PedidoTrackingManager::logError($idPedido, 72, $myJSON);
											$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de Crédito y Cobranza libera pedido de forma manual, si el saldo disponible del crédito cubre el valor del pedido, con pedidos hasta con 5 dias de vencido, dando aviso a promotor de la situación.");
										}
										elseif ( $diasVencido < 16 && $creditoDisponibleEntregados > $saldoPedido) 
										{
											if (!$simulacion) PedidoTrackingManager::logError($idPedido, 73, $myJSON);
											$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de Crédito y cobranza libera pedido de forma manual, si el saldo disponible cubre el valor del pedido, con facturas hasta con 15 días de vencido, obteniendo una promesa de pago del cliente, para máximo 1 semana, No se aceptaran promesas de clientes que hayan incumplido anteriormente.");
										} else 
										{
											if (!$simulacion) PedidoTrackingManager::logError($idPedido, 74, $myJSON);
											$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de Crédito y cobranza libera pedido de forma manual, con pago confirmado del cliente, liberando el 80% para materiales requeridos, para clientes con facturas con mas de 15 días de vencido.");
										}
								}		
						}
					}
					else
					{
						$this->logDebug("Sin Crédito");
						if ($necesitaSurtir)
						{  
							if (!$simulacion) PedidoTrackingManager::logWarning($idPedido,16, $myJSON);
								$this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, sin crédito, se requiere adquisición de materiales");
								$this->logDebug("Necesita Surtir");
								$criterioSaldoAprobado = false;
						}
						else
						{
							if (!$simulacion) PedidoTrackingManager::logInfo($idPedido,24, $myJSON);
								$this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, sin crédito, no requiere adquisición de materiales");
						   		$this->logDebug("No Necesita Surtir");
							if ($porcentaje == 100)
							{
								$pedido->setEstadoAUTORIZADO();
								$pedido->setTipoAutorizacionAUTOMATICO();
								$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
								$pedido->setId_usuario_autorizado(2);
								$pedido->setObservacionAutoriza("El pedido se Pago en su totalidad. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%)."); 
								if(!$simulacion) PedidoTrackingManager::logsuccess($idPedido, 76, $myJSON);		
							}else{
							if ($diasVencido < 8 && $capacidadPagoDisponibleEntregados > $saldoPedido)
								{
									$pedido->setEstadoAUTORIZADO();
									$pedido->setTipoAutorizacionAUTOMATICO();
									$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
									$pedido->setId_usuario_autorizado(2);
									$pedido->setObservacionAutoriza("El saldo de su capacidad de pago cubre el valor del pedido y el cliente no tiene pedidos por pagar > 7 dias. ."); 
									if(!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 77, $myJSON);
									 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");
								}
								else
								{
									if(!$simulacion) PedidoTrackingManager::logWarning($idPedido, 78, $myJSON);
										$this->logDebug("<span class='h3 text-warning'> WARNING => </span> El saldo de su capacidad de pago NO cobre el valor del pedido y el cliente no tiene pedidos por pagar > 7 dias");
										$criterioSaldoAprobado = false;
								}
								if(!$criterioSaldoAprobado){
									if($porcentaje >=50){
										if (!$simulacion) PedidoTrackingManager::logError($idPedido, 79, $myJSON);
										$this->logDebug("<span class='h3 text-warning'> WARNING => </span> Persona autorizada de crédito y cobranza libera de forma manual, si se tiene un abono o pago confirmado < 100% del pedido, para su fabricación. El mínimo del anticipo debe ser 50 % y se bloquea el vale de salida para verificar la liquidación del pedido previo a salida de material.");
									}
									 else 
									{
										if (!$simulacion) PedidoTrackingManager::logError($idPedido, 80, $myJSON);
										$this->logDebug("<span class='h3 text-warning'> WARNING => </span> Persona autorizada de crédito y cobranza libera pedido de forma manual, toda eventualidad fuera dela regla establecida, a criterio, tomando en cuenta importancia y comportamiento del cliente.");
									}
								}	
							}
						}
					}		
				} 
			else
			{
				$this->logDebug("No se pudo obtener la información del cliente del pedido.");           
				if (!$simulacion) 
				{
					PedidoTrackingManager::logError($idPedido, 40, $myJSON);
					$pedido->NotificaPedidoNoAutorizadoAutomatico("No se pudo obtener la información del cliente del pedido.");
				}
				 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> No se pudo obtener la información del cliente del pedido.");
			}					
		}


				// ***************************************************************************************************
				// ***************************************************************************************************
				// ************************************* REGLAS  VALE SALIDA *****************************************
				// ***************************************************************************************************
				// ***************************************************************************************************


			$myJSON = '';
			$this->logDebug("Vales . . . ");
			if (true)
			{             
				$this->logDebug("<h1>Checar liberación de Vales para pedido " . $idPedido."</h1>");
				if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 41, $myJSON, false);
				 $this->logDebug("<span class='h3 text-info'> INFO => </span> Inicia proceso de liberación de vales automática del Pedido", false);
				
				 $pedido->__isDebugging = false;
				$r = $pedido->verificarSiPedidoPuedeSurtirse($idPedido);
				$pedido->__isDebugging = true;
				$necesitaSurtir = (count($r["NoSurtir"]) > 0  ? true : false);
				$cdf = new ModeloClientedatosfacturacion();
				$privado = 'SI';
				
				if ($pedido->getIdClienteDatosFacturacion() > 0)
				{
					$cdf->setIdClienteDatosFacturacion($pedido->getIdClienteDatosFacturacion());
					$df = new ModeloDatosfacturacion();
					$df->setIdDatosFacturacion($cdf->getIdDatosFacturacion());
					$privado = $df->getPrivado();
				}
				$cliente = new ModeloCliente();
				$datosCliente = "";
			
				if ($pedido->getIdClienteDatosFacturacion() == 0 || $privado == 'SI')
				{
					$this->logDebug("Obteniendo datos por el cliente");
					$datosCliente = "Capacidad y Credito obtenidos del Cliente en si";
					$lst = $cliente->getAll("cliente.credito,  cliente.capacidadpago, cliente.idCliente, getDiasPagoVencido(idCliente) as diasVencido,
												getCreditoUsadoClienteDatoFacturacion(cliente.idcliente, 0) creditousado,
												getCreditoUsadoClienteDatoFacturacionEntregados(cliente.idcliente, 0) creditousadoentregados,
												getSaldosMas30DiasClienteRFC(cliente.idcliente, 0) saldomas30dias,
												(SELECT IFNULL(COUNT(idPedido), 0) cantidad FROM pedido WHERE idcliente = cliente.idCliente) nopedidoscliente",
							" ",
							" cliente.idCliente = " . $pedido->getIdCliente());
				}
				else
				{
					$this->logDebug("Obteniendo datos por cliente datos facturacion");
					$datosCliente = "Capacidad y Credito obtenidos por RFC";
					$query = "SELECT idCliente, credito, capacidadpago, 
									getCreditoUsadoClienteDatoFacturacion(idCliente, idClienteDatosFacturacion) creditousado, getDiasPagoVencido(idCliente) as diasVencido,
									getCreditoUsadoClienteDatoFacturacionEntregados(idcliente, idClienteDatosFacturacion) creditousadoentregados,
									getSaldosMas30DiasClienteRFC(idCliente, idClienteDatosFacturacion) saldomas30dias,
									(SELECT IFNULL(COUNT(idPedido), 0) cantidad FROM pedido WHERE idcliente = clientedatosfacturacion.idCliente) nopedidoscliente
								FROM clientedatosfacturacion
								INNER JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
								WHERE idClienteDatosFacturacion = ".$pedido->getIdClienteDatosFacturacion();
					$lst = $cdf->getDataSet($query);
				}
				
				$diasVencido = 0;
				$credito = 0;
				$creditoDisponible = 0;
				$capacidadPago = 0;
				$capacidadPagoDisponible= 0;
				$pagado = $pedido->getTotal() - $pedido->getSaldo();
				$saldoPedido = $pedido->getSaldo();
				$creditoUsadoEntregados= 0;
				$capacidadPagoDisponibleEntregados=0;
				foreach($lst as $c)
				{
					$idCliente = $c["idCliente"];
					$credito = doubleval($c["credito"]);
					$capacidadPago = doubleval($c["capacidadpago"]);
					$creditoUsado = doubleval($c["creditousado"]);
					$saldomas30dias = doubleval($c["saldomas30dias"]);
					$nopedidoscliente = intval($c["nopedidoscliente"]);
					$diasVencido = intval($c["diasVencido"]);
					$creditoUsadoEntregados = doubleval($c["creditousadoentregados"]);
				}

				$clienteNuevo = $nopedidoscliente == 1 ? true : false;
				$creditoUsado = $creditoUsado - $pedido->getSaldo();		
				 $creditoDisponible = $credito - $creditoUsado;
				 $creditoDisponibleEntregados = $credito - $creditoUsadoEntregados;        
				 $capacidadPagoDisponibleEntregados = $capacidadPago - $creditoUsadoEntregados;
				 $pagado = $pedido->getTotal() - $pedido->getSaldo();
				 $saldoPedido = $pedido->getSaldo();
				 if ($pedido->getTotal() > 0)
				 {
					 $porcentaje = $pagado * 100 / $pedido->getTotal();
				 }
				 else
				 {
					 $porcentaje = 100;
				 }


				$criterioSaldoAprobado = true;
				$opcionNoCriterioAprobado = true;

				$porcentajeSaldoCredito = 100 - ($pagado * 100 / $creditoDisponibleEntregados);
	
				$myObj = new stdClass();
				$myObj->idCliente = $idCliente;
				$myObj->datosCliente = $datosCliente;
				$myObj->credito = number_format($credito, 2);
				$myObj->capacidadPago = number_format($capacidadPago, 2);
				$myObj->creditoUsado = number_format($creditoUsado, 2);
				$myObj->saldomas30dias = number_format($saldomas30dias, 2);
				$myObj->noPedidoscliente = $nopedidoscliente;
				$myObj->creditoDisponible = number_format($creditoDisponible, 2);
				$myObj->creditoDisponibleMas20Porciento = number_format($creditodismas20, 2);
				$myObj->porcentajeSaldoCredito = number_format($porcentajeSaldoCredito, 2);
				$myObj->capacidadPagoDisponible = number_format($capacidadPagoDisponible, 2);
				$myObj->porcentaje = number_format($porcentaje, 2);
				$myObj->pagado = number_format($pagado, 2);
				$myObj->saldoPedido = number_format($saldoPedido, 2);
				$myObj->TotalPedido = number_format($pedido->getTotal(), 2);
				$myObj->diasVencido = $diasVencido;
				$myObj->creditoDisponibleEntregados= number_format($creditoDisponibleEntregados);
				$myObj->necesitaSurir=$necesitaSurtir; 
				$myObj->capacidadPagoDisponibleEntregados = $capacidadPagoDisponibleEntregados;

				$myJSON = json_encode($myObj);
				$this->logDebug($myJSON);

				if ($idCliente > 0)
				{  
					$this->logDebug("Cliente Existente");
					
					if ($credito > 0)
					{
						$this->logDebug("Con Crédito");
						if ($necesitaSurtir)
						{						
							if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 42, $myJSON,false);
							$this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, se requiere adquisición de materiales");
							$this->logDebug("Necesita Surtir");
						}
						else
						{
							if ($creditoDisponibleEntregados >= $saldoPedido && $diasVencido < 30)
							{	
								$pedido->setLiberaValesSI();                            
								$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
								$pedido->setId_usuario_libera_vales(2);                            
								$pedido->setObservacionLiberaVales("El credito disponible cubre el saldo del pedido y no tiene pedidos vencidos a mas de 30 dias  : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática.");
								if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 83, $myJSON,false);
								$this->logDebug("<span class='h3 text-warning'> WARNING => </span> Vale de salida LIBERADO, Saldo de crédito cubre pedido y no tiene pedidos vencidos a mas de 30 días.");
							}
							else
							{
									if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 84, $myJSON, false);
									$this->logDebug("<span class='h3 text-warning'> WARNING => </span> Crédito disponible no cubre el saldo del pedido ó tiene pedidos vencidos con mas de 30 dias con saldo.");
									$criterioSaldoAprobado = false;
							}	
						}
						if(!$criterioSaldoAprobado){
							if($diasVencido <  5 && $creditoDisponibleEntregados > $saldoPedido){
									if (!$simulacion) PedidoTrackingManager::logError($idPedido, 86, $myJSON,false);
									$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de Crédito y Cobranza libera pedido de forma Manual, si el saldo disponible del crédito cubre el valor del pedido, con pedidos hasta con 5 días de vencido, dando aviso a promotor de la situación.");
								}
								elseif ($diasVencido < 16 && $creditoDisponibleEntregados > $saldoPedido) 
								{
									if (!$simulacion) PedidoTrackingManager::logError($idPedido, 87, $myJSON,false);
									$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de Crédito y cobranza libera pedido de forma manual, si el saldo disponible cubre el valor del pedido, con facturas hasta con 15 días de vencido, obteniendo una promesa de pago del cliente, para máximo 1 semana, No se aceptaran promesas de clientes que hayan incumplido anteriormente.");
								} else 
								{
									if (!$simulacion) PedidoTrackingManager::logError($idPedido, 88, $myJSON,false);
									$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de Crédito y cobranza libera pedido de forma manual, con pago confirmado del cliente, liberando el 80% para materiales requeridos, para clientes con facturas con mas de 15 dias de vencido.");
								}
							}
					}
					else
					{
						$this->logDebug("Sin Crédito, VALE SALIDA");
						if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 89, $myJSON, false);
						if ($necesitaSurtir)
						{
							$this->logDebug("Necesita Surtir, SIN CREDITO");
							if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 82, $myJSON, false);								
						}
						else
						{	
							if ($porcentaje == 100)
							{
							$this->logDebug("<span class='h3 text-succes'> SUCCES => </span> EL PEDIDO SE ABONO EN SU TOTALIDAD, VALE DE SALIDA LIBERADO ");
							$pedido->setLiberaValesSI();                            
							$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
		 					$pedido->setId_usuario_libera_vales(2);                            
		 					$pedido->setObservacionLiberaVales("Pedido tiene abonos por  : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática.");
							 if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 90, $myJSON, false);
 
							}else{
								if ($diasVencido < 8 && $capacidadPagoDisponibleEntregados > $saldoPedido)
								{
									$pedido->setLiberaValesSI();                            
									$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
		 							$pedido->setId_usuario_libera_vales(2);                            
		 							$pedido->setObservacionLiberaVales("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática."); 
									 if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 91, $myJSON, false);
								}
								else
								{				
									 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> criterio no aprobado el cliente tiene pedidos vencidos a mas de 7 dias o su capacidad no cobre el salde del pedido ");
									 if (!$simulacion) PedidoTrackingManager::logWarning($idPedido,92, $myJSON, false);
									$criterioSaldoAprobado = false;
								}
								if(!$criterioSaldoAprobado){
									if($porcentaje >=50){
										$this->logDebug("<span class='h3 text-warning'> WARNING => </span> Persona autorizada de crédito y cobranza libera de forma manual, si se tiene un abono o pago confirmado < 100% del pedido, para su fabricación. El mínimo del anticipo debe ser 50 % y se bloquea el vale de salida para verificar la liquidación del pedido previo a salida de material. .");
										if (!$simulacion) PedidoTrackingManager::logError($idPedido, 93, $myJSON, false);
									}
									 else 
									{
										if (!$simulacion) PedidoTrackingManager::logError($idPedido, 94, $myJSON, false);
										$this->logDebug("<span class='h3 text-error'> ERROR => </span> Persona autorizada de crédito y cobranza libera pedido de forma manual, toda eventualidad fuera dela regla establecida, a criterio, tomando en cuenta importancia y comportamiento del cliente.");
									}
								}			
							} // fin abono al 100 %	
						} // fin necesita surtir
					} // fin Sin credito 			
				} // fin cliente existente
				else
				{     
					$this->logDebug("No se pudo obtener la información del cliente del pedido.");
					if (!$simulacion) PedidoTrackingManager::logError($idPedido, 66, $myJSON);
					 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> No se pudo obtener la información del cliente del pedido.");
				}	
			}

			if (!$simulacion)
			{
				$pedido->setChecarAutorizacionNO();

				$pedido->Guardar();

				if ($pedido->getError())
				{
					$myObj->Guardado = "NO";
					$myObj->ERROR = $pedido->getStrError();
					$myJSON = json_encode($myObj);						
					//RazonAutorizacion[98]='ERROR AL ACTUALIZAR PEDIDO';
					PedidoTrackingManager::logError($idPedido, 98, $myJSON);				
				}
			}
			$this->logDebug();
		}

		public function NotificaPedidoNoAutorizadoAutomatico($msg)
		 {
		     $cliente = new ModeloCliente();
		    //  echo "OK";
		     $cliente->setIdCliente($this->getIdCliente());
		     
		     NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . " No Autorizado", $msg . " Debe solicitar su Autorización.");
				// echo "    ....    ".$cliente->getIdUsuarioPromotor(). "!=". $this->getId_usuario_capturado()		     		     		     ;
		     if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		     {
		        NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido() . " No Autorizado", $msg . " Debe solicitar su Autorización.");
		     }
		     
		     
		 }

		 public function NotificaValesDeSalidaNoLiberados($msg)
		 {
		     $cliente = new ModeloCliente();
		     
		     $cliente->setIdCliente($this->getIdCliente());
		     
		     NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $this->getId_usuario_capturado(), "Pedido " . $this->getIdPedido() . ": Vales no liberados", $msg . " Debe solicitar su Liberación.");
		     
		     
		     if ($cliente->getIdUsuarioPromotor() != $this->getId_usuario_capturado())
		     {
		         NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, $cliente->getIdUsuarioPromotor(), "Pedido " . $this->getIdPedido() . ": Vales no Liberados", $msg . " Debe solicitar su Liberación.");
		     }
		     
		     
		 }


		// **************************************************************************************************
		// **************************************************************************************************
		// **************************************************************************************************

		public function SaveOriginalValues()
		{
			$this->_Old = new stdClass();
			$this->_Old->estado = $this->estado;
			$this->_Old->saldada = $this->saldada;
			$this->_Old->saldo = $this->saldo;
			$this->_Old->total = $this->total;
			$this->_Old->id_usuario_capturado = $this->id_usuario_capturado;
			$this->_Old->colocado = $this->colocado;
			$this->_Old->colocadoAutomatico = $this->colocadoAutomatico;
		}

		public function ProcesarActualizaciones()
		{	
			$cliente = new ModeloCliente();
			$cliente->setIdCliente($this->getIdCliente());
			$idPromotor = $cliente->getIdUsuarioPromotor();

			// echo "Aqui procesaremos datos previo a su actualizacion";
			// print_r($this->_Old);
			if ($this->_Old->estado == "CAPTURADO" && $this->estado == "AUTORIZADO")
			{

				// echo "<br>Promotor: ". $idPromotor;
				$idsToSend = array();
				array_push($idsToSend, $this->id_usuario_capturado);
				if ($this->_Old->saldada == 'NO' && $this->saldada == 'SI')
				{
					if ($idPromotor != $this->id_usuario_capturado)
					{
						array_push($idsToSend, $idPromotor);
					}
					
					NotificationManager::WA_EstatusPedido($idsToSend, $this->idPedido, "AUTORIZADO", " en Automático (Saldado)");
				}
				else
				{
					if ($idPromotor != $this->id_usuario_capturado)
					{
						array_push($idsToSend, $idPromotor);
					}
					
					NotificationManager::WA_EstatusPedido($idsToSend, $this->idPedido, "AUTORIZADO");
				}
				
				
			}
			
			if ($this->_Old->colocado == 'NO' && $this->colocado == 'SI')			
			{
				$query = "select GROUP_CONCAT(distinct sucursal.nombre  SEPARATOR ', ') as sucursales
							from pedidodetallecolocacion
							inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal
							where idpedidodetalle in (select idpedidodetalle from pedidodetalle where idpedido = ".$this->idPedido.")
							AND pedidodetallecolocacion.cantidad > 0;";

				$ds = $this->getDataSet($query);
				if ($ds != null)
				{
					$sucursales = $ds[0]["sucursales"];
					// echo "<br>Sucursales: ".$sucursales;
					// echo "<br>Promotor: ".$idPromotor;
					$idsToSend = array();
					array_push($idsToSend, $this->id_usuario_capturado);

					if ($idPromotor != $this->id_usuario_capturado)
					{
						array_push($idsToSend, $idPromotor);
					}

					if ($sucursales == "TORRES LANDA")
					{
						array_push($idsToSend, 30);
					}
					NotificationManager::WA_PedidoAsignado($idsToSend, $this->idPedido, $sucursales);

				}
			}

			if ($this->_Old->saldo != $this->saldo)
			{
				if ($this->saldo <= 0)
				{
					$idsToSend = array();
					array_push($idsToSend, $this->id_usuario_capturado);

					if ($idPromotor != $this->id_usuario_capturado)
					{
						array_push($idsToSend, $idPromotor);
					}

					NotificationManager::WA_EstatusPedido($idsToSend, $this->idPedido, "SALDADO");
				}
			}
			if ($this->_Old->estado != $this->estado && $this->estado == "CANCELADO")
			{
				$idsToSend = array();
				array_push($idsToSend, 22);
				NotificationManager::WA_EstatusPedido($idsToSend, $this->idPedido, "CANCELADO");
			}

			if ($this->_Old->total != $this->total)
			{
				$idsToSend = array();
				array_push($idsToSend, 22);
				
				$tmpBody = NotificationManager::$WATEMPLATE_PEDIDOTOTALCAMBIADO;
				$tmpBody = str_replace("{{1}}", $this->idPedido, $tmpBody);
				$tmpBody = str_replace("{{2}}", $this->_Old->total, $tmpBody);
				$tmpBody = str_replace("{{3}}", $this->total, $tmpBody);
				$tmpBody = str_replace("{{4}}", $this->factura, $tmpBody);

				NotificationManager::WA_SendMessage($idsToSend, $tmpBody);

			}
			
			if ($this->_Old->colocadoAutomatico != $this->colocadoAutomatico)
			{
				$idsToSend = array();
				array_push($idsToSend, 28);
				
				NotificationManager::WA_EstatusPedido($idsToSend, $this->idPedido, "ASIGNADOAUTOMATICO");

			}

		}
		

	}

// ******************************************************************************************************************************************************************
// ******************************************************************************************************************************************************************
// *************************************************** REGLAS ANTERIORES DE AUTORIZACION DE VALES DE SALIDA *********************************************************
// ******************************************************************************************************************************************************************
// ******************************************************************************************************************************************************************




			// 	if (!$clienteNuevo)
				// 	{
				// 		$this->logDebug("Cliente Existente");
				// 		if ($credito > 0)
				// 		{
				// 			$this->logDebug("Con Crédito");
				// 			if ($necesitaSurtir)
				// 			{
				// 				//RazonAutorizacion[42]='Cliente existente, con crédito, se requiere adquisición de materiales';               
				// 				if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 42, $myJSON, false);
				// 				 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, se requiere adquisición de materiales", false);

				// 				$this->logDebug("Necesita Surtir");

				// 				if (floatval($saldoPedido) == 0 || floatval($saldoPedido) == 0.0)
				// 				{
				// 					$pedido->setLiberaValesSI();                            
				// 					$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 					$pedido->setId_usuario_libera_vales(2);                            
				// 					$pedido->setObservacionLiberaVales("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática."); 
									
				// 					//RazonAutorizacion[43]='Criterio para liberación aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante';               
				// 					if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 43, $myJSON, false);
				// 					 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Total del pedido $ ".$pedido->getTotal().", saldo $ ".$saldoPedido.".", false);

									
				// 				}
				// 				else
				// 				{
				// 					//RazonAutorizacion[44]='Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Se debe consultar a crédito y cobranza';               
				// 					if (!$simulacion) 
				// 					{
				// 						PedidoTrackingManager::logError($idPedido, 44, $myJSON, false);
				// 						$pedido->NotificaValesDeSalidaNoLiberados("Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante.");
				// 					}
				// 					 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Se debe consultar a crédito y cobranza.", false);
									

				// 				}
								
								
				// 			}
				// 			else
				// 			{
				// 				//RazonAutorizacion[45]='Cliente existente, con crédito, no requiere adquisición de materiales';               
				// 				if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 45, $myJSON, false);
				// 				 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, no requiere adquisición de materiales", false);

				// 				$this->logDebug("No Necesita Surtir");
								
				// 				$opcionNoCriterioAprobado = false;
								
				// 				if ($saldoPedido == 0 || $creditoDisponibleEntregados >= $saldoPedido)
				// 				{
								
				// 					if ($saldoPedido == 0 || $saldomas30dias == 0)
				// 					{
				// 						$pedido->setLiberaValesSI();                            
				// 						$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 						$pedido->setId_usuario_libera_vales(2);                            
				// 						$pedido->setObservacionLiberaVales("Saldo crédito de pedidos entregados cubre saldo de pedido. Se han liberado los vales de manera automática. ."); 
										
				// 						//RazonAutorizacion[46]='Criterio para liberación aprobado: Saldo de crédito de pedidos entregados cubra el saldo del pedido';               
				// 						if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 46, $myJSON, false);
				// 						 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Saldo de crédito de pedidos entregados cubra el saldo del pedido. Total del pedido $ ".$pedido->getTotal().", saldo $ ".$saldoPedido.", saldo del crédito de pedidos entregados $".$creditoDisponibleEntregados.".", false);
				// 						 $opcionNoCriterioAprobado = true;
				// 					}
				// 					else
				// 					{              
				// 						//RazonAutorizacion[47]='El cliente tiene pedidos vencidos a mas de 30 días';               
				// 						if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 47, $myJSON, false);
				// 						 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.", false);                  

				// 						$opcionNoCriterioAprobado = false;
				// 					}

								
				// 				}
								
				// 				if (!$opcionNoCriterioAprobado)
				// 				{
				// 					//RazonAutorizacion[48]='Criterio para liberación NO aprobado: Saldo de crédito de pedidos entregados cubra el saldo del pedido y no tener pedidos vendidos a mas de 30 días';               
				// 					$opcionNoCriterioAprobado = true;
				// 					if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 48, $myJSON, false);
				// 					 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: Saldo de crédito de pedidos entregados cubra el saldo del pedido y no tener pedidos vendidos a mas de 30 días.", false);


				// 					if ($porcentajeSaldoCredito <= 20 && $creditoDisponibleEntregados>0 )
				// 					{
				// 						if ($saldomas30dias == 0)
				// 						{
				// 							$pedido->setLiberaValesSI();                            
				// 							$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 							$pedido->setId_usuario_libera_vales(2);                            
				// 							$pedido->setObservacionLiberaVales("Saldo del pedido no mayor a 20% al saldo de su crédito de pedidos vencidos y no tener pedidos vencidos a mas de 30 días. Se han liberaro los vales de manera automática."); 
											
				// 							//RazonAutorizacion[49]='Opción en caso de no cumplir criterio, aprobado: Saldo del pedido no mayor a 20% del saldo de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días';               
				// 							if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 49, $myJSON, false);
				// 							 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción en caso de no cumplir criterio, aprobado: Saldo del pedido no mayor a 20% del saldo de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", saldo $ ".$saldoPedido.", saldo del crédito de pedidos entregados $".$creditoDisponibleEntregados.".", false);

				// 						}
				// 						else
				// 						{      
				// 							//RazonAutorizacion[50]='El cliente tiene pedidos vencidos a mas de 30 días';                    
				// 							if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 50, $myJSON, false);
				// 							 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.", false);                     

				// 							$opcionNoCriterioAprobado = false;
				// 						}                       

				// 					}
				// 					else
				// 					{
				// 						//RazonAutorizacion[51]='Saldo de pedido mayor al 20% al saldo disponible de crédito de pedidos entregados';                    
				// 						if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 51, $myJSON, false);
				// 						 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Saldo de pedido mayor al 20% al saldo disponible de crédito de pedidos entregados.", false);

				// 						$opcionNoCriterioAprobado = false;
				// 					}    

				// 					if (!$opcionNoCriterioAprobado)                   
				// 					{
				// 						//RazonAutorizacion[52]='Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días';                    
				// 						if (!$simulacion) 
				// 						{
				// 							PedidoTrackingManager::logError($idPedido, 52, $myJSON, false);
				// 							$pedido->NotificaValesDeSalidaNoLiberados("Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días.");
				// 						}
				// 						 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días.", false);
										
				// 					}

				// 				}
				// 			}
				// 		}
				// 		else
				// 		{
				// 			$this->logDebug("Sin Crédito");
				// 			if ($necesitaSurtir)
				// 			{
				// 				//RazonAutorizacion[53]='Cliente existente, sin crédito, se requiere adquisición de materiales';                    
				// 				if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 53, $myJSON, false);
				// 				 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, sin crédito, se requiere adquisición de materiales", false);

				// 				$this->logDebug("Necesita Surtir");

				// 				if ($saldoPedido == 0)
				// 				{
				// 					$pedido->setLiberaValesSI();                            
				// 					$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 					$pedido->setId_usuario_libera_vales(2);                            
				// 					$pedido->setObservacionLiberaVales("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática."); 
									
				// 					//RazonAutorizacion[54]='Criterio para liberación aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante';                    
				// 					if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 54, $myJSON, false);
				// 					 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Total del pedido $ ".$pedido->getTotal().", saldo $ ".$saldoPedido.".", false);

									
				// 				}
				// 				else
				// 				{
				// 					//RazonAutorizacion[55]='Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Se debe consultar a crédito y cobranza';                    
				// 					if (!$simulacion) 
				// 					{
				// 						PedidoTrackingManager::logError($idPedido, 55, $myJSON, false);
				// 						$pedido->NotificaValesDeSalidaNoLiberados("Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante.");
				// 					}
				// 					 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Se debe consultar a crédito y cobranza.", false);
									
				// 				}
								

								
				// 			}
				// 			else
				// 			{
				// 				//RazonAutorizacion[56]='Cliente existente, sin crédito, no requiere adquisición de materiales';                    
				// 				if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 56, $myJSON, false);
				// 				 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, sin crédito, no requiere adquisición de materiales", false);

				// 				$this->logDebug("No Necesita Surtir");

				// 				if ($saldoPedido == 0)
				// 				{
				// 					$pedido->setLiberaValesSI();                            
				// 					$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 					$pedido->setId_usuario_libera_vales(2);                            
				// 					$pedido->setObservacionLiberaVales("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática."); 
									
				// 					//RazonAutorizacion[57]='Criterio para liberación aprobado: En caso de no requerir adquisición de materiales, cubrir el saldo restante';                    
				// 					if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 57, $myJSON , false);
				// 					 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: En caso de no requerir adquisición de materiales, cubrir el saldo restante. Total del pedido $ ".$pedido->getTotal().", saldo $ ".$saldoPedido.".", false);                            

				// 				}
				// 				else
				// 				{                            
				// 					//RazonAutorizacion[58]='Criterio para liberación NO aprobado: Cubrir el saldo restante del pedido';
				// 					if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 58, $myJSON, false);
				// 					 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: Cubrir el saldo restante del pedido.", false);


				// 					if (($creditoUsadoEntregados  + $saldoPedido) <= 25000 &&  
				// 						($creditoUsadoEntregados  + $saldoPedido) <= $capacidadPagoDisponible)
				// 					{
				// 						if ($saldomas30dias == 0)
				// 						{
											
				// 							$pedido->setLiberaValesSI();                            
				// 							$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 							$pedido->setId_usuario_libera_vales(2);                            
				// 							$pedido->setObservacionLiberaVales("Saldo total de pedidos entregados mas este pedido no mayor a 25 000 y lo cubra su capacidad de pago. Se han liberado los vales de manera automática."); 
											
				// 							//RazonAutorizacion[59]='Opción 2 en caso de no cumplir el criterio principal: Saldo total de pedidos entregados más el saldo de este pedido no mayor a 25 000 y lo cubra de su capadidad de pago disponible y no tener pedidos vencidoas a mas de 30 días';
				// 							if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 59, $myJSON, false);
				// 							 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción 2 en caso de no cumplir el criterio principal: Saldo total de pedidos entregados (incluyendo este saldo) no mayor a 25 000 y lo cubra el saldo de su capadidad de pago y no tener pedidos vencidoas a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).", false);

											
				// 						}
				// 						else
				// 						{              
				// 							//RazonAutorizacion[60]='El cliente tiene pedidos vencidos a mas de 30 días';
				// 							if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 60, $myJSON, false);
				// 							 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.", false);                  

				// 							$opcionNoCriterioAprobado = false;
				// 						}                       

				// 					}
				// 					else
				// 					{
				// 						//RazonAutorizacion[61]='Saldo total de pedidos entregados mas éste, mayor a 25 000 o su capacidad de pago no cubre dicho monto';
				// 						if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 61, $myJSON, false);
				// 						 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Saldo total de pedidos entregados mayor a 25 000 de su capacidad de pago, incluyendo saldo de este pedido.", false);

				// 						$opcionNoCriterioAprobado = false;
				// 					}    

				// 					if (!$opcionNoCriterioAprobado)                   
				// 					{
				// 						//RazonAutorizacion[62]='Opción en caso de no cumplir criterio, NO aprobado: Saldo total de pedidos entregados más el saldo de este pedido mayor a 25 000 o dicho monto no lo cubre su capacidad de pago, no tener saldos vencidos a mas de 30 días. Se debe consultar a crédito y cobranza';
				// 						if (!$simulacion) 
				// 						{
				// 							PedidoTrackingManager::logError($idPedido, 62, $myJSON, false);
				// 							$pedido->NotificaValesDeSalidaNoLiberados("Opción en caso de no cumplir criterio, NO aprobado: Saldo total de pedidos entregados más el saldo de este pedido mayor a 25 000 o dicho monto no lo cubre su capacidad de pago, no tener saldos vencidos a mas de 30 días. Se debe consultar a crédito y cobranza");
				// 						}
				// 						 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Saldo total de pedidos entregados más el saldo de este pedido mayor a 25 000 o dicho monto no lo cubre su capacidad de pago, no tener saldos vencidos a mas de 30 días. Se debe consultar a crédito y cobranza", false);
										
				// 					}
				// 				}

				// 			}
				// 		}
						
				// 	}
				// 	else
				// 	{
				// 		$this->logDebug("Cliente Nuevo");
						
				// 		//RazonAutorizacion[63]='Cliente nuevo';
				// 		if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 63, $myJSON, false);
				// 		 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente nuevo", false);

						
				// 		if ($saldoPedido == 0)
				// 		{
				// 			$pedido->setLiberaValesSI();                            
				// 			$pedido->setFecha_libera_vales(date("Y-m-d H:i:s"));
				// 			$pedido->setId_usuario_libera_vales(2);                            
				// 			$pedido->setObservacionLiberaVales("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se han liberado los vales de manera automática."); 
							
				// 			//RazonAutorizacion[64]='Criterio para liberación aprobado: Debe liquidar el pedido';
				// 			if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 64, $myJSON , false);
				// 			 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Debe liquidar el pedido. Total del pedido $ ".$pedido->getTotal().", saldo $ ".$saldoPedido.".", false);                            

				// 		}
				// 		else
				// 		{                    
				// 			//RazonAutorizacion[65]='Criterio para liberación NO aprobado: Debe liquidar el pedido';        
				// 			if (!$simulacion) 
				// 			{
				// 				PedidoTrackingManager::logError($idPedido, 65, $myJSON, false);
				// 				$pedido->NotificaValesDeSalidaNoLiberados("Criterio para liberación NO aprobado: Debe liquidar el pedido.");
				// 			}
				// 			 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Criterio para liberación NO aprobado: Debe liquidar el pedido.", false);
							

				// 		}              
				// 	}
					
// ******************************************************************************************************************************************************************
// ******************************************************************************************************************************************************************
// *************************************************** REGLAS ANTERIORES DE AUTORIZACION DE PEDIDOS *****************************************************************
// ******************************************************************************************************************************************************************
// ******************************************************************************************************************************************************************



				
					// if (!$clienteNuevo)
					// {
						// $this->logDebug("Cliente Existente");
						// if ($credito > 0)
						// {
						// 	$this->logDebug("Con Crédito");
							// if ($necesitaSurtir)
							// {
							// 	//Cliente EXISTENTE, CON CREDITO, NECESITA SURTIR
							// 	//RazonAutorizacion[2]='Cliente existente, con crédito, se requiere adquisición de materiales';
							// 	if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 2, $myJSON);
							// 	 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, se requiere adquisición de materiales");

							// 	$this->logDebug("Necesita Surtir");

							// 	if ($porcentaje >= 50)
							// 	{
							// 		$pedido->setEstadoAUTORIZADO();
							// 		$pedido->setTipoAutorizacionAUTOMATICO();
							// 		$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 		$pedido->setId_usuario_autorizado(2);
									
							// 		$pedido->setObservacionAutoriza("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se ha autorizado de manera automática."); 
									
							// 		//Cliente EXISTENTE, CON CREDITO, NECESITA SURTIR								
							// 		//RazonAutorizacion[3]='Criterio para liberación aprobado: En caso de requerir adquisición de materiales, que se cubra el 50% o más';
							// 		if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 3, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: En caso de requerir adquisición de materiales, que se cubra el 50% o más. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

									
							// 	}
							// 	else
							// 	{
							// 		//Cliente EXISTENTE, CON CREDITO, NECESITA SURTIR								
							// 		//RazonAutorizacion[4]='Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, que se cubra el 50% o más';
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 4, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, que se cubra el 50% o más.");

							// 		if ($porcentaje >= 25)
							// 		{
							// 			$pedido->setEstadoAUTORIZADO();
							// 			$pedido->setTipoAutorizacionAUTOMATICO();
							// 			$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 			$pedido->setId_usuario_autorizado(2);
										
							// 			$pedido->setObservacionAutoriza("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se ha autorizado de manera automática."); 
										
							// 			//Cliente EXISTENTE, CON CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[5]='Opción en caso de no cumplir criterio, aprobado: Cubrir al menos el 25% de anticipo';
							// 			if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 5, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción en caso de no cumplir criterio, aprobado: Cubrir al menos el 25% de anticipo. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

										
							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, CON CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[6]='Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 25% de anticipo. Se debe consultar a crédito y cobranza';
							// 			if (!$simulacion) 
							// 			{
							// 				PedidoTrackingManager::logError($idPedido, 6, $myJSON);
							// 				$pedido->NotificaPedidoNoAutorizadoAutomatico("Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 25% de anticipo.");
							// 			}	
							// 			 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 25% de anticipo. Se debe consultar a crédito y cobranza.");
										

							// 		}
							// 	}
							// }
							// else
							// {
							// 	//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 	//RazonAutorizacion[7]='Cliente existente, con crédito, no requiere adquisición de materiales';
							// 	if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 7, $myJSON);
							// 	 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, con crédito, no requiere adquisición de materiales");

							// 	$this->logDebug("No Necesita Surtir");
								
								
							// 	if ($creditoDisponible >= $saldoPedido)
							// 	{
							// 		if ($saldomas30dias == 0)
							// 		{
							// 			$pedido->setEstadoAUTORIZADO();
							// 			$pedido->setTipoAutorizacionAUTOMATICO();
							// 			$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 			$pedido->setId_usuario_autorizado(2);
										
							// 			$pedido->setObservacionAutoriza("Saldo crédito cubre saldo de pedido y no tiene saldo vencido a mas de 30 días. Se ha autorizado de manera automática. ."); 
										
							// 			//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[8]='Criterio para liberación aprobado: Saldo de crédito cubre pedido y no tiene pedidos vencidos a mas de 30 días';
							// 			if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 8, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Saldo de crédito cubre pedido y no tiene pedidos vencidos a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[9]='El cliente tiene pedidos vencidos a mas de 30 días';
							// 			if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 9, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.");

							// 			$criterioSaldoAprobado = false;
							// 		}
							// 	}
							// 	else
							// 	{
							// 		//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 		//RazonAutorizacion[10]='Crédito disponible no cubre el saldo del pedido';
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 10, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Crédito disponible no cubre el saldo del pedido.");

							// 		$criterioSaldoAprobado = false;
							// 	}

							// 	if (!$criterioSaldoAprobado)
							// 	{
							// 		//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 		//RazonAutorizacion[11]='Criterio para liberación NO aprobado: Saldo de crédito suficiente para cubrir saldo de pedido y no tener pedidos vencidos a mas de 30 días';
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 11, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: Saldo de crédito suficiente para cubrir saldo de pedido y no tener pedidos vencidos a mas de 30 días.");


							// 		if ($saldoPedido == 0 || $saldoPedido <= $creditodismas20)
							// 		{
							// 			if ($saldoPedido == 0 || $saldomas30dias == 0)
							// 			{
							// 				$pedido->setEstadoAUTORIZADO();
							// 				$pedido->setTipoAutorizacionAUTOMATICO();
							// 				$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 				$pedido->setId_usuario_autorizado(2);
											
							// 				$pedido->setObservacionAutoriza("Saldo de Pedido no mayor al 20% del crédito disponible y no tiene saldo vencido a mas de 30 días. Se ha autorizado de manera automática. ."); 
											
							// 				//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 				//RazonAutorizacion[12]='Opción en caso de no cumplir criterio, aprobado: Saldo de Pedido no mayor al 20% del crédito disponible y no tiene saldo vencido a mas de 30 días';
							// 				if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 12, $myJSON);
							// 				 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción en caso de no cumplir criterio, aprobado: Saldo de Pedido no mayor al 20% del crédito disponible y no tiene saldo vencido a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

							// 			}
							// 			else
							// 			{      
							// 				//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 				//RazonAutorizacion[13]='El cliente tiene pedidos vencidos a mas de 30 días';     
							// 				if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 13, $myJSON );
							// 				 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.");                     

							// 				$opcionNoCriterioAprobado = false;
							// 			}                       

							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[14]='Saldo de pedido mayor al 20% al saldo disponible de crédito';     
							// 			if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 14, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Saldo de pedido mayor al 20% al saldo disponible de crédito.");

							// 			$opcionNoCriterioAprobado = false;
							// 		}    

							// 		if (!$opcionNoCriterioAprobado)                   
							// 		{
							// 			//Cliente EXISTENTE, CON CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[15]='Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito y no tener pedidos vencidos a mas de 30 días';     
							// 			if (!$simulacion) 
							// 			{
							// 				PedidoTrackingManager::logError($idPedido, 15, $myJSON);
							// 				$pedido->NotificaPedidoNoAutorizadoAutomatico("Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito y no tener pedidos vencidos a mas de 30 días.");
							// 			}
							// 			 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito y no tener pedidos vencidos a mas de 30 días.");
										

							// 		}

							// 	}
							// }
						// }
						// else
						// {
							// $this->logDebug("Sin Crédito");
							// if ($necesitaSurtir)
							// {
							// 	//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 	//RazonAutorizacion[16]='Cliente existente, sin crédito, se requiere adquisición de materiales';     
							// 	if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 16, $myJSON);
							// 	 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, sin crédito, se requiere adquisición de materiales");

							// 	$this->logDebug("Necesita Surtir");

							// 	if ($porcentaje >= 50)
							// 	{
							// 		if ($saldomas30dias == 0)
							// 		{
							// 			$pedido->setEstadoAUTORIZADO();
							// 			$pedido->setTipoAutorizacionAUTOMATICO();
							// 			$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 			$pedido->setId_usuario_autorizado(2);
										
							// 			$pedido->setObservacionAutoriza("Anticipo cubre al menos 50% y no tiene saldo vencido a mas de 30 días. Se ha autorizado de manera automática. ."); 
										
							// 			//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[17]='Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días';     
							// 			if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 17, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[18]='El cliente tiene pedidos vencidos a mas de 30 días';     
							// 			if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 18, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.");

							// 			$criterioSaldoAprobado = false;
							// 		}
							// 	}
							// 	else
							// 	{
							// 		//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 		//RazonAutorizacion[19]='Anticipo no cubre al menos el 50%';     
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 19, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Anticipo no cubre al menos el 50%.");

							// 		$criterioSaldoAprobado = false;
							// 	}

							// 	if (!$criterioSaldoAprobado)
							// 	{
							// 		//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 		//RazonAutorizacion[20]='Criterio para liberación NO aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días';     
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 20, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días.");


									
							// 		if ($porcentaje >= 25)
							// 		{
										
							// 			$pedido->setEstadoAUTORIZADO();
							// 			$pedido->setTipoAutorizacionAUTOMATICO();
							// 			$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 			$pedido->setId_usuario_autorizado(2);
										
							// 			$pedido->setObservacionAutoriza("Anticipo al menos del 25%. Se ha autorizado de manera automática."); 

							// 			//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[21]='Opción en caso de no cumplir criterio, aprobado: Anticipo al menos del 25%';     
							// 			if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 21, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción en caso de no cumplir criterio, aprobado: Anticipo al menos del 25%. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

														

							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[22]='Anticipo del pedido menor a 25%';     
							// 			if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 22, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Anticipo del pedido menor a 25%.");

							// 			$opcionNoCriterioAprobado = false;
							// 		}    

							// 		if (!$opcionNoCriterioAprobado)                   
							// 		{
							// 			//Cliente EXISTENTE, SIN CREDITO, NECESITA SURTIR								
							// 			//RazonAutorizacion[23]='Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%';     
							// 			if (!$simulacion) 
							// 			{
							// 				PedidoTrackingManager::logError($idPedido, 23, $myJSON);
							// 				$pedido->NotificaPedidoNoAutorizadoAutomatico("Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%.");
							// 			}
							// 			 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%.");
										

							// 		}
							// 	}
								

								
							// }
							// else
							// {
							// 	//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 	//RazonAutorizacion[24]='Cliente existente, sin crédito, no requiere adquisición de materiales';     
							// 	if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 24, $myJSON);
							// 	 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente existente, sin crédito, no requiere adquisición de materiales");

							// 	$this->logDebug("No Necesita Surtir");

							// 	if ($porcentaje >= 50)
							// 	{
							// 		if ($saldomas30dias == 0)
							// 		{
							// 			$pedido->setEstadoAUTORIZADO();
							// 			$pedido->setTipoAutorizacionAUTOMATICO();
							// 			$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 			$pedido->setId_usuario_autorizado(2);
										
							// 			$pedido->setObservacionAutoriza("Anticipo cubre al menos 50% y no tiene saldo vencido a mas de 30 días. Se ha autorizado de manera automática. ."); 
										
							// 			//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[25]='Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días';     
							// 			if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 25, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[26]='El cliente tiene pedidos vencidos a mas de 30 días';     
							// 			if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 26, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.");

							// 			$criterioSaldoAprobado = false;
							// 		}
							// 	}
							// 	else
							// 	{
							// 		//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 		//RazonAutorizacion[27]='Anticipo no cubre al menos el 50%';     
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 27, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Anticipo no cubre al menos el 50%.");

							// 		$criterioSaldoAprobado = false;
							// 	}

							// 	if (!$criterioSaldoAprobado)
							// 	{	
							// 		//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 		//RazonAutorizacion[28]='Criterio para liberación NO aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días';     
							// 		if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 28, $myJSON);
							// 		 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días.");


									
							// 		if ($porcentaje >= 25)
							// 		{
							// 			if ($saldomas30dias == 0)
							// 			{
							// 				if ($capacidadPago >= $saldoPedido)
							// 				{
							// 					$pedido->setEstadoAUTORIZADO();
							// 					$pedido->setTipoAutorizacionAUTOMATICO();
							// 					$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
							// 					$pedido->setId_usuario_autorizado(2);
												
							// 					$pedido->setObservacionAutoriza("Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido. Se ha autorizado de manera automática."); 

							// 					//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 					//RazonAutorizacion[29]='Opción 2 en caso de no cumplir el criterio principal: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido';     
							// 					if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 29, $myJSON);
							// 					 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción 2 en caso de no cumplir el criterio principal: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

							// 				}
							// 				else
							// 				{	
							// 					//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 					//RazonAutorizacion[30]='El saldo de la capacidad de pago no cubre el saldo del pedido';     
							// 					if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 30, $myJSON );
							// 					 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El saldo de la capacidad de pago no cubre el saldo del pedido.");                  

							// 					$opcionNoCriterioAprobado = false;
							// 				}
							// 			}
							// 			else
							// 			{    
							// 				//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 				//RazonAutorizacion[31]='El cliente tiene pedidos vencidos a mas de 30 días';               
							// 				if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 31, $myJSON);
							// 				 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> El cliente tiene pedidos vencidos a mas de 30 días.");                  

							// 				$opcionNoCriterioAprobado = false;
							// 			}                       

							// 		}
							// 		else
							// 		{
							// 			//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[32]='Anticipo del pedido menor a 25%';               
							// 			if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 32, $myJSON);
							// 			 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Anticipo del pedido menor a 25%.");

							// 			$opcionNoCriterioAprobado = false;
							// 		}    

							// 		if (!$opcionNoCriterioAprobado)                   
							// 		{
							// 			//Cliente EXISTENTE, SIN CREDITO, NO NECESITA SURTIR								
							// 			//RazonAutorizacion[33]='Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido';               
							// 			if (!$simulacion) 
							// 			{
							// 				PedidoTrackingManager::logError($idPedido, 33, $myJSON);
							// 				$pedido->NotificaPedidoNoAutorizadoAutomatico("Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido.");
							// 			}
							// 			 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido.");
										

							// 		}
							// 	}

							// }
						// }
						
					// }
					// else
					// {
					// 	$this->logDebug("Cliente Nuevo");
					// 	if ($credito == 0)
					// 	{
					// 		//Cliente NUEVO, SIN CREDITO								
					// 		//RazonAutorizacion[34]='Cliente nuevo, sin crédito';               
					// 		if (!$simulacion) PedidoTrackingManager::logInfo($idPedido, 34, $myJSON);
					// 		 $this->logDebug("<span class='h3 text-info'> INFO => </span> Cliente nuevo, sin crédito");

					// 		$this->logDebug("Sin Crédito");
					
					// 		if ($porcentaje >= 50)
					// 			{
					// 				$pedido->setEstadoAUTORIZADO();
					// 				$pedido->setTipoAutorizacionAUTOMATICO();
					// 				$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
					// 				$pedido->setId_usuario_autorizado(2);
									
					// 				$pedido->setObservacionAutoriza("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se ha autorizado de manera automática."); 
									
					// 				//Cliente NUEVO, SIN CREDITO								
					// 				//RazonAutorizacion[35]='Criterio para liberación aprobado: Anticipo al menos del 50%';               
					// 				if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 35, $myJSON);
					// 				 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Criterio para liberación aprobado: Anticipo al menos del 50%. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

									
					// 			}
					// 			else
					// 			{
					// 				//Cliente NUEVO, SIN CREDITO								
					// 				//RazonAutorizacion[36]='Criterio para liberación NO aprobado: Anticipo al menos del 50%';               
					// 				if (!$simulacion) PedidoTrackingManager::logWarning($idPedido, 36, $myJSON);
					// 				 $this->logDebug("<span class='h3 text-warning'> WARNING => </span> Criterio para liberación NO aprobado: Anticipo al menos del 50%.");

					// 				if ($porcentaje >= 40)
					// 				{
					// 					$pedido->setEstadoAUTORIZADO();
					// 					$pedido->setTipoAutorizacionAUTOMATICO();
					// 					$pedido->setFecha_autorizado(date("Y-m-d H:i:s"));
					// 					$pedido->setId_usuario_autorizado(2);
										
					// 					$pedido->setObservacionAutoriza("Pedido tiene abonos por : ". $pagado ." (". number_format($porcentaje, 2) ."%). Se ha autorizado de manera automática."); 
										
					// 					//Cliente NUEVO, SIN CREDITO								
					// 					//RazonAutorizacion[37]='Opción en caso de no cumplir criterio, aprobado: Cubrir al menos el 40% de anticipo';               
					// 					if (!$simulacion) PedidoTrackingManager::logSuccess($idPedido, 37, $myJSON);
					// 					 $this->logDebug("<span class='h3 text-navy'>SUCCESS => </span> Opción en caso de no cumplir criterio, aprobado: Cubrir al menos el 40% de anticipo. Total del pedido $ ".$pedido->getTotal().", abonado $ ".$pagado." (". number_format($porcentaje, 2) ."%).");

										
					// 				}
					// 				else
					// 				{
					// 					//RazonAutorizacion[38]='Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 40% de anticipo. Se debe consultar a crédito y cobranza';               
					// 					if (!$simulacion) 
					// 					{
					// 						PedidoTrackingManager::logError($idPedido, 38, $myJSON);
					// 						$pedido->NotificaPedidoNoAutorizadoAutomatico("Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 40% de anticipo. Se debe consultar a crédito y cobranza.");
					// 					}
					// 					 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 40% de anticipo. Se debe consultar a crédito y cobranza.");
										

					// 				}
					// 			}

					// 	}
					// 	else
					// 	{
					// 		//RazonAutorizacion[39]='Cliente nuevo, se ha detectado crédito. No se continua con la validación de autorización automática';               
					// 		if (!$simulacion) 
					// 		{
					// 			PedidoTrackingManager::logError($idPedido, 39, $myJSON);
					// 			$pedido->NotificaPedidoNoAutorizadoAutomatico("Cliente nuevo, se ha detectado crédito. No se continua con la validación de autorización automática");
					// 		}
					// 		 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> Cliente nuevo, se ha detectado crédito. No se continua con la validación de autorización automática");
							

					// 	}
					// }
					
					
				// }
				// else
				// {
				// 	$this->logDebug("No se pudo obtener la información del cliente del pedido.");
				// 	//RazonAutorizacion[40]='No se pudo obtener la información del cliente del pedido';               
				// 	if (!$simulacion) 
				// 	{
				// 		PedidoTrackingManager::logError($idPedido, 40, $myJSON);
				// 		$pedido->NotificaPedidoNoAutorizadoAutomatico("No se pudo obtener la información del cliente del pedido.");
				// 	}
				// 	 $this->logDebug("<span class='h3 text-danger'> ERROR => </span> No se pudo obtener la información del cliente del pedido.");
					

				// }

				// $this->checarSurtimientoPedido($idPedido, 0);

		