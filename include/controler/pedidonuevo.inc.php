<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.viewrollos.inc.php";
	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.precioxdobles.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.configuracion.inc.php";
	
	
	require_once FOLDER_MODEL. "model.usuario.inc.php";	
	require_once FOLDER_MODEL. "model.usocfdi.inc.php";
	require_once FOLDER_MODEL. "model.otrocargo.inc.php";
	require_once FOLDER_MODEL. "model.otroscargospedido.inc.php";
		
	require_once FOLDER_MODEL. "model.sucursal.inc.php";
	require_once FOLDER_MODEL. "model.inventariosucursal.inc.php";
	
	require_once  FOLDER_MODEL. "model.material.inc.php";
	
	require_once  FOLDER_MODEL. "model.cotizacion.inc.php";
	require_once  FOLDER_MODEL. "model.cotizaciondetalle.inc.php";
	require_once FOLDER_MODEL. "model.otroscargoscotizacion.inc.php";
	
	
// 	require_once FOLDER_MODEL. "model.pedido.inc.php";

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	function addDays($fecha_inicial, $diasToAdd, $descansaDomingos = true)//, $festivos)
	{
	    $diasSumados = 0;
	    
	    $i = 1;
	    $fecha_final = $fecha_inicial;
	    while($diasSumados < $diasToAdd)
	    {
	        $fecha = date('Y-m-d', strtotime($fecha_inicial. ' + ' . $i . ' days'));
	        $fechap = date_create($fecha);
	        
	        $sumar = true;
	        $tipo = "";
	        
	        if ($descansaDomingos)
	        {
	            if (jddayofweek ( cal_to_jd(CAL_GREGORIAN, date_format($fechap, "m"), date_format($fechap, "d"), date_format($fechap, "Y")) , 0 ) == 0)
	            {
	                $sumar = false;
	                $tipo = "Domingo";
	            }
	        }
	        
	        
	        //         if (in_array($fecha, $festivos))
	            //         {
	            //             //echo "<br><br><br>" . $fecha. "    <br><br><br>sfl�kjsdakljfjslfjs�d<br><br><br>";
	            //             $sumar = false;
	            //             $tipo = "Festivo";
	            //         }
	        
	        // 			echo "<br>" . $fecha . "   =>    ";
	        // 			echo date_format($fechap, "m") . "  " . date_format($fechap, "d") . "   " . date_format($fechap, "Y");
	        // 			echo  "    ===>    " . jddayofweek ( cal_to_jd(CAL_GREGORIAN, date_format($fechap, "m"), date_format($fechap, "d"), date_format($fechap, "Y")) , 1);
	        
	        $i++;
	        
	        if ($sumar)
	        {
	            $diasSumados++;
	        }
	        // 			else
	        // 			{
	        // 				echo " ---> " . $tipo;
	        // 			}
	    }
	    
	    return $fecha;
	    
	    //echo "<br>". date('Y-m-d', strtotime($fecha_inicial. ' + ' . $i . ' days'));
	}
	
	
	function getTipoPrecioForDetail($tipoPrecio, $precio, $isRango)
	{
		$result = "";

		if ($tipoPrecio == "G")
		{
			if ($isRango == "0")
			{
				$result = "PRECIO";
			}
			else
			{
				if ($precio == "1")
				{
					$result = "RANGO1";
				}
				else
				{
					if ($precio == "2")
					{
						$result = "RANGO2";
					}
					else
					{
						if ($precio == "3")
						{
							$result = "RANGO3";
						}
						else
						{
							$result = "PRECIO";
						}
					}

				}
			}



		}
		else
		{
			if ($tipoPrecio == "I")
			{
				$result = "IMPORTADO";
			}
			else
			{
				$result = "TERNIUM";
			}
		}

		return $result;

	}

	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
//  	$xajax->setCharEncoding('ISO-8859-1');
// 	$xajax->setCharEncoding('UTF-8');
	//$xajax->de decodeUTF8InputOn();

//  ob_start();
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarAviso($debug);

	function loadCotizacion($idCotizacion)
	{
		$r = new xajaxResponse();
		global $objSession;
	    // $r->starDebug();
		$cotizacion = new ModeloCotizacion();
		$cliente = new ModeloCliente();
		
		$cotizacion->setIdCotizacion($idCotizacion);
		$cliente->setIdCliente ($cotizacion->getIdCliente());

		if ($objSession->getIdUsuario() != $cotizacion->getId_usuario_capturado() && $objSession->getIdUsuario() != $cliente->getIdUsuarioPromotor() && !ModeloUsuario::amIRoot() )
		{
			$r->saError("La Cotización que está intentanto cargar, no pertenece a sus Clientes o no ha sido creada por usted.");
			$r->script(" mdlExitWait();  ");
			return $r;
		}

		if ($cotizacion->getEstado() != "CAPTURADO")
		{
			$r->saError("La Cotización que está intentanto cargar, ha sido eliminada.");
			$r->script(" mdlExitWait(); app.cargarListaCotizaciones(); ");
			return $r;
		}

		//Cargamos cliente
		$r->script(" app.idClienteSeleccionado = ".$cotizacion->getIdCliente()."; 
					 setTimeout(function() { app.refreshDatosClienteSeleccionado('".$cotizacion->getRangoCliente()."');}, 50);   ");

		//clienteTipoRangoSeleccionado
		//SET NEW.rangoCliente = SELECT rangoCliente FROM cliente WHERE idCliente = NEW.idCliente;

		$rangosString = $cotizacion->getRangosString();
					 
		$datosCotizacion = "setTimeout (function () {
			app.subtotalPedido = ".$cotizacion->getSubtotal()."; 
			app.ivaPedido = ".$cotizacion->getIva()."; 
			app.descuentoPedido = ".$cotizacion->getDescuento()."; 
			app.totalPedido = ".$cotizacion->getTotal()."; 
			app.observacionPedido = '".$cotizacion->getObservacionCaptura()."';
			app.tipoPrecioGalvamex = 1; 
			app.selRecogeRecibe = '".$cotizacion->getRecogeentrega()."'; 
			app.selTipoObra = '".$cotizacion->getTipoObra() ."'; 
			app.selSucursalPreferencia = ".$cotizacion->getIdSucursalPreferenciaRecoge()."; 
			app.ctePersona = '".$cotizacion->getPersonaEntrega()."';
			app.cteDireccion = '".$cotizacion->getDomicilioEntrega()."';
			app.cteNumero = '".$cotizacion->getNumeroEntrega()."';
			app.cteColonia = '".$cotizacion->getColoniaEntrega()."';
			app.cteCiudad = '".$cotizacion->getCiudadEntrega()."';
			app.horaEntrega = '".$cotizacion->getHoraRecibe()."'; 
			app.fechaAbierta = '".$cotizacion->getFechaAbierta()."'; 
			app.pedidoExpress = '".$cotizacion->getPedidoExpress()."'; 
			

			app.clienteTipoRangoSeleccionado = '".$cotizacion->getRangoCliente()."';

			$(\"#dtFechaEntrega\").val('".clsUtilerias::formatoFecha(substr($cotizacion->getFechaCompromiso(), 0, 10))."');
	
			}, 1000);";

		$r->script($datosCotizacion);

		$oc = new ModeloOtrocargo();
	    	    
	    $lst = $oc->getAll("otrocargo.automatico, otrocargo.idOtroCargo, otrocargo.descripcion, otrocargo.ingreso, otrocargo.solicitar, otrocargo.precioIngreso,       
							IFNULL(occ.cantidadIngreso, '') cantidadIngreso, IFNULL(occ.monto, 0) monto ", 
							"LEFT JOIN otroscargoscotizacion occ
							ON occ.idotrocargo = otrocargo.idOtroCargo
							AND occ.idCotizacion = " .$idCotizacion, "" ," idOtroCargo");
	    
	    $strOC = "";
	    $seUsaGrua = "";
	    
	    foreach ($lst as $row)
	    {
	        
	        $strOC .= "app.otrosCargos.push({ 
                        id: ".$row["idOtroCargo"].",
					descripcion: '".mb_strtoupper($row["descripcion"])."',
                    solicitar: '".mb_strtoupper($row["solicitar"])."',
                    precioingreso: '".mb_strtoupper($row["precioIngreso"])."',
                    cantidad: '".mb_strtoupper($row["cantidadIngreso"])."',
                    monto: '".mb_strtoupper($row["monto"])."',
					automatico: '".($row["automatico"])."'
					                                      });";

			if (mb_strtoupper($row["descripcion"]) == "MANIOBRAS EN CUBIERTA")
			{					
				if ($row["monto"] > 0)
				{					
					$seUsaGrua .= "app.chkSeUsaGrua = true; ";	
				}
				else
				{					
					$seUsaGrua .= "app.chkSeUsaGrua = false; ";	
				}
			}
			//app.selTipoObra = '".$cotizacion->getTipoObra() ."'; 
	    }
	    
	    

		$cotizacion->getDetalleCotizacion();

		$strListadoProductos = "";

		for($i = 0 ; $i <count($cotizacion->lstProductos) ; $i++)
		{
			$producto = new ModeloViewproductos();
			$producto = $cotizacion->lstProductos[$i];
			

			if ($producto->getEstado() == "ACTIVO")
			{
				$desc=str_replace(chr(13),'', $producto->getRolloDescripcion());
				$desc=str_replace('<br />','\n', $desc);
				$desc=str_replace(chr(10),'', $desc);

				$descProducto=str_replace(chr(13),'', $producto->getDescripcion());
				$descProducto=str_replace('<br />','\n', $descProducto);
				$descProducto=str_replace(chr(10),'', $descProducto);

				$renglon = new ModeloCotizaciondetalle();
				$renglon = $cotizacion->lstRenglones[$i];
				
				$molIdProducto = 386;
				$molIdMaquila = 394;
				$idProducto = $producto->getIdProducto();

				$rollo = new ModeloRollo();

				

				if ($idProducto != $molIdProducto && $idProducto != $molIdMaquila)
				{
					$strListadoProductos .= "	app.listadoPedido.push({ ";

					$strListadoProductos .= "		idProducto:  '" .$producto->getIdProducto() . "', ";
					$strListadoProductos .= "		codigo:  '" .$producto->getCodigo() . "', ";
					$strListadoProductos .= "        isMoldura: false, ";
					$strListadoProductos .= "		longitud:  '" .$producto->getLongitud() . "', ";
					$strListadoProductos .= "		mlpieza:  " .$producto->getMlpieza() . ", ";
					$strListadoProductos .= "		idTipoProducto:  '" .$producto->getIdTipoProducto() . "', ";
					$strListadoProductos .= "		tipoProducto:  '" .$producto->getTipoProducto() . "', ";
					$strListadoProductos .= "		shortTipoProducto:  '" .$producto->getShortTipoProducto() . "', ";
					$strListadoProductos .= "		idAplicacion:  '" .$producto->getIdAplicacion() . "', ";
					$strListadoProductos .= "		aplicacion:  '" .$producto->getAplicacion() . "', ";
					$strListadoProductos .= "		idMaterial:  '" .$producto->getIdMaterial() . "', ";
					$strListadoProductos .= "		material:  '" .$producto->getMaterial() . "', ";
					$strListadoProductos .= "		curva: '".$renglon->getCurvatura()."', ";
					
					$strListadoProductos .= "		idRollo:  '" .$producto->getIdRollo() . "', ";
					$strListadoProductos .= "		rolloCodigo:  '" .$producto->getRolloCodigo() . "', ";
					$strListadoProductos .= "		rolloIdMaterial:  '" .$producto->getRolloIdMaterial() . "', ";
					$strListadoProductos .= "		rolloMaterial:  '" .$producto->getRolloMaterial() . "', ";
					$strListadoProductos .= "		rolloShortMaterial:  '" .$producto->getRolloShortMaterial() . "', ";
					$strListadoProductos .= "		rolloIdProveedor:  '" .$producto->getRolloIdProveedor() . "', ";
					$strListadoProductos .= "		rolloProveedor:  '" .$producto->getRolloProveedor() . "', ";
					$strListadoProductos .= "		rolloShortProveedor:  '" .$producto->getRolloShortProveedor() . "', ";
					$strListadoProductos .= "		rolloCalibre:  '" .$producto->getRolloCalibre() . "', ";
					$strListadoProductos .= "		rolloPies:  '" .$producto->getRolloPies() . "', ";
					$strListadoProductos .= "		rolloPesokiloml:  " .$producto->getRolloPesokiloml() . ", ";
					$strListadoProductos .= "		rolloDescripcion:  '" .$desc . "', ";
					$strListadoProductos .= "		idUnidad:  '" .$producto->getIdUnidad() . "', ";
					$strListadoProductos .= "		unidad:  '" .$producto->getUnidad() . "', ";
					$strListadoProductos .= "		shortUnidad:  '" .$producto->getShortUnidad() . "', ";
					$strListadoProductos .= "		calibre:  '" .$producto->getCalibre() . "', ";
					$strListadoProductos .= "		descripcion:  '" . $descProducto . "', ";
					$strListadoProductos .= "		existencia:  '" .$producto->getExistencia() . "', ";
					$strListadoProductos .= "        tipoPrecioComision: 'PRECIO', ";
					$strListadoProductos .= "		tipoPrecio:  '" .$producto->getTipoPrecio() . "', ";
					$strListadoProductos .= "		isRango:  '" .$producto->getIsRango() . "', ";
					$strListadoProductos .= "		tipoRango:  '" .$producto->getTipoRango() . "', ";
					$strListadoProductos .= "		isRollo:  '" .$producto->getIsRollo() . "', ";
					$strListadoProductos .= "		precio1:  '" .$renglon->getPrecio1() . "', ";
					$strListadoProductos .= "		precio2:  '" .$renglon->getPrecio2() . "', ";
					$strListadoProductos .= "		precio3:  '" .$renglon->getPrecio3() . "', ";
					$strListadoProductos .= "		precio4:  '" .$renglon->getPrecio4() . "', ";
					$strListadoProductos .= "       preciomendez:  '" .$renglon->getPreciomendez() . "', ";
					$strListadoProductos .= "		estado: '" .$producto->getEstado() . "', ";
					$strListadoProductos .= "		existenciaEstimada: '".$producto->getExistenciaToCero()."', ";
					$strListadoProductos .= "		fullDescripcion: '".$producto->getDescauto()."', ";
					$strListadoProductos .= "		fullDescripcionCode: '". $producto->getCodigo(). " - " . $producto->getDescauto()."', ";	
					
					$strListadoProductos .= "		cantidad: ".$renglon->getPartida() .", ";
					$strListadoProductos .= "		lblUnidad: '', ";
					$strListadoProductos .= "		cantUnidad: ".$renglon->getCantidad().", ";
					$strListadoProductos .= "		cantUnidadReal: ".$renglon->getCantidadReal().", ";
					$strListadoProductos .= "        dobleces: '0', ";
					$strListadoProductos .= "        precioRenglon: '0', ";
					$strListadoProductos .= "		rangoRenglon: '1', ";
					$strListadoProductos .= "        totalRenglon: '0', ";
					$strListadoProductos .= "		desarrolloI: '0', ";
					$strListadoProductos .= "		desarrolloT: '0', ";
					$strListadoProductos .= "		dobleces: '".$renglon->getDobleces()."', ";
					$strListadoProductos .= "		debug: '', ";
					$strListadoProductos .= "		kl: 0, ";
					$strListadoProductos .= "		productoCantidadDisponible: true, ";
					$strListadoProductos .= "       molPrecioLamina: 0, ";
					$strListadoProductos .= "       molMoldurasXLamina: 1, ";
					$strListadoProductos .= "       molMoldurasXLaminaTodos: 1, ";
					$strListadoProductos .= "       molLaminasCobrar: 1, ";
					$strListadoProductos .= "       molLaminasATomar: 1, ";
					$strListadoProductos .= "       molCorte: 0, ";
					$strListadoProductos .= "       molDobles: 0, ";
					$strListadoProductos .= "       molIsScrap: false, ";
					$strListadoProductos .= "       molTotalCMScrap: 0, ";
					$strListadoProductos .= "       molLongitudinal: 'L', ";
					$strListadoProductos .= "       sugerirStock: [], ";
					$strListadoProductos .= "		inventarioSucursal: [], ";
					$strListadoProductos .= "		idPedidoDetalle: 0 ";

					$strListadoProductos .= "     }); ";
				}

				if ($idProducto == $molIdProducto)
				{
					$rollo = new ModeloViewrollos();

					$rollo->getView($renglon->getIdRolloBase());

					$precioMoldura = ($renglon->getPrecioUnitario() - ($renglon->getMolPrecioDobleces() / $renglon->getPartida())  - ($renglon->getMolPrecioCorte() / $renglon->getPartida()) ) / $renglon->getCantidadReal();
					$precioMoldura = round($precioMoldura,2);
					// $r->mostrarAviso($renglon->getPrecioUnitario()); 
					// $r->mostrarAviso(($renglon->getMolPrecioDobleces() / $renglon->getPartida() )); 
					
					// $r->mostrarAviso(($renglon->getMolPrecioCorte() / $renglon->getPartida() )); 
					// $r->mostrarAviso($renglon->getCantidadReal()); 
					
					
					// $r->mostrarAviso($precioMoldura); 
					
					// $r->mostrarAviso($renglon->getMolLaminasATomar());

					$pies = $rollo->getPies();
					$desarrollo = $renglon->getDesarrollo();
					$molMoldurasXLaminas = 0;
					if ($pies == 3)
					{
						$molMoldurasXLaminas = (int)( 91.44 / $desarrollo);	
					}
					
					if ($pies ==  3.76)
					{
						$molMoldurasXLaminas = (int)( 114.6 / $desarrollo);	
					}
					
					if ($pies ==  3.48)
					{
						$molMoldurasXLaminas = (int)( 106.07 / $desarrollo);	
					}
					
					if ($pies ==  4)
					{
						$molMoldurasXLaminas = (int)( 122 / $desarrollo);	
					}

					// return $r;



					$strListadoProductos .= "	app.listadoPedido.push({ ";
				
					$strListadoProductos .= "		idProducto: ".$molIdProducto.", ";
					$strListadoProductos .= "		codigo: 'MOL', ";
					$strListadoProductos .= "		isMoldura: true, ";
					$strListadoProductos .= "		longitud: '', ";
					$strListadoProductos .= "		mlpieza: 0, ";
					$strListadoProductos .= "		idTipoProducto: '3', ";
					$strListadoProductos .= "		tipoProducto: 'MOLDURA', ";
					$strListadoProductos .= "		shortTipoProducto: 'M', ";
					$strListadoProductos .= "		idAplicacion: '1', ";
					$strListadoProductos .= "		aplicacion: '--NO APLICA--', ";
					$strListadoProductos .= "		idMaterial: ".$rollo->getIdMaterial().", "; //this.molIdMaterial
					$strListadoProductos .= "		material: '', ";
					$strListadoProductos .= "		tipoPrecioComision: 'PRECIO', ";
					$strListadoProductos .= "		curva: '', ";
					$strListadoProductos .= "		idRollo: ".$renglon->getIdRolloBase() .", "; //this.molIdRolloV2
					$strListadoProductos .= "		rolloCodigo: '-- NO APLICA --', ";
					$strListadoProductos .= "		rolloIdMaterial: '1', ";
					$strListadoProductos .= "		rolloMaterial: '-- NO APLICA --', ";
					$strListadoProductos .= "		rolloShortMaterial: 'NA', ";
					$strListadoProductos .= "		rolloIdProveedor: '1', ";
					$strListadoProductos .= "		rolloProveedor: '-- NO APLICA --', ";
					$strListadoProductos .= "		rolloShortProveedor: 'NA', ";
					$strListadoProductos .= "		rolloCalibre: '0', ";
					$strListadoProductos .= "		rolloPies: '0', ";
					$strListadoProductos .= "		rolloPesokiloml: 0, ";
					$strListadoProductos .= "		rolloDescripcion: '', ";
					$strListadoProductos .= "		idUnidad: '1', ";
					$strListadoProductos .= "		unidad: 'METRO LINEAL', ";
					$strListadoProductos .= "		shortUnidad: 'ML', ";
					$strListadoProductos .= "		calibre: ".$rollo->getCalibre().", "; //this.molCalibre
					$strListadoProductos .= "		descripcion: 'MOLDURA', ";
					$strListadoProductos .= "		existencia: '0', ";
					$strListadoProductos .= "		tipoPrecio: 'G', ";
					$strListadoProductos .= "		isRango: '0', ";
					$strListadoProductos .= "		tipoRango: '0', ";
					$strListadoProductos .= "		isRollo: '0', ";
					$strListadoProductos .= "		precio1: ".$precioMoldura.", "; //this.molPrecioMetroMoldura
					$strListadoProductos .= "		precio2: '0', ";
					$strListadoProductos .= "		precio3: '0', ";
					$strListadoProductos .= "		precio4: '0', ";
					$strListadoProductos .= "		preciomendez: ".$precioMoldura.", "; //this.molPrecioMetroMoldura
					$strListadoProductos .= "		estado: 'ACTIVO', ";
					$strListadoProductos .= "		existenciaEstimada: '0', ";
					$strListadoProductos .= "		fullDescripcion: 'MOLDURA - ".$rollo->getIdRollo()." - ".$rollo->getDescauto()."', "; // this.molDescripcion
					$strListadoProductos .= "		fullDescripcionCode: 'MOLDURA - ".$rollo->getIdRollo()." - ".$rollo->getDescauto()."', "; // this.molDescripcion
					$strListadoProductos .= "		cantidad: '".$renglon->getPartida()."', "; //this.molCantidad
					$strListadoProductos .= "		lblUnidad: '', ";
					$strListadoProductos .= "		cantUnidad: ".$renglon->getCantidad().", "; //this.molCantUnidad
					$strListadoProductos .= "		cantUnidadReal: ".$renglon->getCantidad().", "; //this.molCantUnidad
					$strListadoProductos .= "		dobleces: ".$renglon->getDobleces().", "; //this.molDoblecesV2
					$strListadoProductos .= "		precioRenglon: ".$renglon->getPrecioUnitario().", ";
					$strListadoProductos .= "		rangoRenglon: 1, ";
					$strListadoProductos .= "		totalRenglon: ".$renglon->getTotal().", ";
					$strListadoProductos .= "		desarrolloI: '0', ";
					$strListadoProductos .= "		desarrolloT: \"".$renglon->getDesarrollo()."\", "; //this.molDesarrolloV2
					$strListadoProductos .= "		debug: '', ";
					$strListadoProductos .= "		kl: 0, ";
					$strListadoProductos .= "		productoCantidadDisponible: true, ";
					$strListadoProductos .= "		molPrecioLamina: 0, "; //this.molPrecioADar
					$strListadoProductos .= "		molMoldurasXLamina: 0, "; //this.molMoldurasXLaminas
					$strListadoProductos .= "		molLaminasCobrar: 1, ";
					$strListadoProductos .= "		molLaminasATomar: ".$renglon->getMolLaminasATomar()	.", ";
					$strListadoProductos .= "		molMoldurasXLaminaTodos: ".$molMoldurasXLaminas.", "; //this.molMoldurasXLaminaTodos
					$strListadoProductos .= "		molCorte: ".$renglon->getMolPrecioCorte()/$renglon->getPartida().", "; //this.molCostoCorte
					$strListadoProductos .= "		molDobles: ".$renglon->getMolPrecioDobleces()/$renglon->getPartida()/$renglon->getDobleces().", "; //this.molCostoDobles
					$strListadoProductos .= "		molIsScrap: ".($renglon->getMolIsScrap() == "SI" ? "true" : "false").", "; //this.molIsScrap
					$strListadoProductos .= "		molTotalCMScrap: ".$renglon->getMolTotalcmScrap() .", "; //this.molTotalCMScrap
					$strListadoProductos .= "		molLongitudinal: '".$renglon->getMolLongitudinal()."', "; //this.molLongitudinal
					$strListadoProductos .= "		sugerirStock: [], ";
					$strListadoProductos .= "		inventarioSucursal: [], ";
					$strListadoProductos .= "		idPedidoDetalle: 0 ";

				$strListadoProductos .= "     }); ";

				}

				if ($idProducto == $molIdMaquila)
				{

					// $rollo = new ModeloViewrollos();

					// $rollo->getView($renglon->getIdRolloBase());

					$precioMoldura = ($renglon->getPrecioUnitario() - ($renglon->getMolPrecioDobleces() / $renglon->getPartida())  - ($renglon->getMolPrecioCorte() / $renglon->getPartida()) ) / $renglon->getCantidadReal();
					$precioMoldura = round($precioMoldura,2);
					// $r->mostrarAviso($renglon->getPrecioUnitario()); 
					// $r->mostrarAviso(($renglon->getMolPrecioDobleces() / $renglon->getPartida() )); 
					
					// $r->mostrarAviso(($renglon->getMolPrecioCorte() / $renglon->getPartida() )); 
					// $r->mostrarAviso($renglon->getCantidadReal()); 
					
					
					// $r->mostrarAviso($precioMoldura); 
					
					// $r->mostrarAviso($renglon->getMolLaminasATomar());

					$pies = $rollo->getPies();
					$desarrollo = $renglon->getDesarrollo();
					$molMoldurasXLaminas = 0;
					if ($pies == 3)
					{
						$molMoldurasXLaminas = (int)( 91.44 / $desarrollo);	
					}
					
					if ($pies ==  3.76)
					{
						$molMoldurasXLaminas = (int)( 114.6 / $desarrollo);	
					}
					
					if ($pies ==  3.48)
					{
						$molMoldurasXLaminas = (int)( 106.07 / $desarrollo);	
					}
					
					if ($pies ==  4)
					{
						$molMoldurasXLaminas = (int)( 122 / $desarrollo);	
					}

					$strListadoProductos .= "	app.listadoPedido.push({ ";

					$strListadoProductos .= "		idProducto: ".$molIdMaquila.", ";
					$strListadoProductos .= "		codigo: 'MAQ', ";
					$strListadoProductos .= "		isMoldura: true, ";
					$strListadoProductos .= "		longitud: '', ";
					$strListadoProductos .= "		mlpieza: 0, ";
					$strListadoProductos .= "		idTipoProducto: '3', ";
					$strListadoProductos .= "		tipoProducto: 'MAQUILA', ";
					$strListadoProductos .= "		shortTipoProducto: 'MQ', ";
					$strListadoProductos .= "		idAplicacion: '1', ";
					$strListadoProductos .= "		aplicacion: '--NO APLICA--', ";
					$strListadoProductos .= "		idMaterial: ".$renglon->getMolIdMaterial() .", ";
					$strListadoProductos .= "		material: '', ";
					$strListadoProductos .= "		tipoPrecioComision: 'PRECIO', ";
					$strListadoProductos .= "		curva: '', ";
					$strListadoProductos .= "		idRollo: 0, ";
					$strListadoProductos .= "		rolloCodigo: '-- NO APLICA --', ";
					$strListadoProductos .= "		rolloIdMaterial: ".$renglon->getMolIdMaterial().", ";
					$strListadoProductos .= "		rolloMaterial: '-- NO APLICA --', ";
					$strListadoProductos .= "		rolloShortMaterial: 'NA', ";
					$strListadoProductos .= "		rolloIdProveedor: '1', ";
					$strListadoProductos .= "		rolloProveedor: '-- NO APLICA --', ";
					$strListadoProductos .= "		rolloShortProveedor: 'NA', ";
					$strListadoProductos .= "		rolloCalibre: ".$renglon->getMolCalibre().", ";
					$strListadoProductos .= "		rolloPies: '0', ";
					$strListadoProductos .= "		rolloPesokiloml: 0, ";
					$strListadoProductos .= "		rolloDescripcion: '', ";
					$strListadoProductos .= "		idUnidad: '1', ";
					$strListadoProductos .= "		unidad: 'METRO LINEAL', ";
					$strListadoProductos .= "		shortUnidad: 'ML', ";
					$strListadoProductos .= "		calibre: ".$renglon->getMolCalibre().", ";
					$strListadoProductos .= "		descripcion: 'MAQUILA', ";
					$strListadoProductos .= "		existencia: '0', ";
					$strListadoProductos .= "		tipoPrecio: 'G', ";
					$strListadoProductos .= "		isRango: '0', ";
					$strListadoProductos .= "		tipoRango: '0', ";
					$strListadoProductos .= "		isRollo: '0', ";
					$strListadoProductos .= "		precio1: 0, "; //this.molPrecioMetroMoldura
					$strListadoProductos .= "		precio2: '0', ";
					$strListadoProductos .= "		precio3: '0', ";
					$strListadoProductos .= "		precio4: '0', ";
					$strListadoProductos .= "		preciomendez: 0, "; //this.molPrecioMetroMoldura
					$strListadoProductos .= "		estado: 'ACTIVO', ";
					$strListadoProductos .= "		existenciaEstimada: '0', ";
					$strListadoProductos .= "		fullDescripcion:	 'MAQUILA - ".$renglon->getMolDescMaquila()."', ";
					$strListadoProductos .= "		fullDescripcionCode: 'MAQUILA - ".$renglon->getMolDescMaquila()."', ";
					$strListadoProductos .= "		cantidad: '".$renglon->getPartida()."', "; //this.molCantidad
					$strListadoProductos .= "		lblUnidad: '', ";
					$strListadoProductos .= "		cantUnidad: ".$renglon->getCantidad().", "; //this.molCantUnidad
					$strListadoProductos .= "		cantUnidadReal: ".$renglon->getCantidad().", "; //this.molCantUnidad
					$strListadoProductos .= "		dobleces: ".$renglon->getDobleces().", "; //this.molDoblecesV2
					$strListadoProductos .= "		precioRenglon: ".$renglon->getPrecioUnitario().", ";
					$strListadoProductos .= "		rangoRenglon: 1, ";
					$strListadoProductos .= "		totalRenglon: ".$renglon->getTotal().", ";
					$strListadoProductos .= "		desarrolloI: '0', ";
					$strListadoProductos .= "		desarrolloT: \"".$renglon->getDesarrollo()."\", "; //this.molDesarrolloV2
					$strListadoProductos .= "		debug: '', ";
					$strListadoProductos .= "		kl: 0, ";
					$strListadoProductos .= "		productoCantidadDisponible: true, ";
					$strListadoProductos .= "		molPrecioLamina: 0, "; //this.molPrecioADar
					$strListadoProductos .= "		molMoldurasXLamina: 0, "; //this.molMoldurasXLaminas
					$strListadoProductos .= "		molLaminasCobrar: 1, ";
					$strListadoProductos .= "		molLaminasATomar: 0, ";
					$strListadoProductos .= "		molMoldurasXLaminaTodos: 1, "; //this.molMoldurasXLaminaTodos
					$strListadoProductos .= "		molCorte: ".$renglon->getMolPrecioCorte()/$renglon->getPartida().", "; //this.molCostoCorte
					$strListadoProductos .= "		molDobles: ".$renglon->getMolPrecioDobleces()/$renglon->getPartida()/$renglon->getDobleces().", "; //this.molCostoDobles
					$strListadoProductos .= "		molIsScrap: ".($renglon->getMolIsScrap() == "SI" ? "true" : "false").", "; //this.molIsScrap
					$strListadoProductos .= "		molTotalCMScrap: ".$renglon->getMolTotalcmScrap() .", "; //this.molTotalCMScrap
					$strListadoProductos .= "		molLongitudinal: '".$renglon->getMolLongitudinal()."', "; //this.molLongitudinal
					$strListadoProductos .= "		sugerirStock: [], ";
					$strListadoProductos .= "		inventarioSucursal: [], ";
					$strListadoProductos .= "		idPedidoDetalle: 0 ";

				$strListadoProductos .= "     }); ";

				}
		
				
                
		        
			}


		}
		
		// $r->mostrarAviso($strOC);
		// $r->mostrarAviso($strListadoProductos );
		$r->script(" app.listadoPedido.splice(0, app.listadoPedido.length); ".$strListadoProductos );
		$r->script(" setTimeout(function() { app.otrosCargos.splice(0, app.otrosCargos.length); " . $strOC . "}, 500);");

		$r->script("setTimeout(function(){ app.calculaTotales(); }, 500); 
					setTimeout(function(){ app.calculaTotales(); mdlStatusWait('Calculando Totales'); 
					console.log('Calling 2nd CalTot'); }, 1500); 
					setTimeout( function(){ app.refreshDatosClienteSeleccionado('".$cotizacion->getRangoCliente()."'); mdlStatusWait('Recuperando Cliente'); 
						console.log('Recuperando de nuevo cliente'); }, 1800); 

						

                    setTimeout(function(){
                        // console.log('aqui refrescamos inventarios');
						app.refreshInventarioSucursal();
						app.secCotizacionAPedido = false;
                    }, 1800);

					setTimeout(function(){
                        // console.log('aqui refrescamos descuento individual');
						app.selDescuentoIndividual = '".$cotizacion->getDescuentoIndividual()."'; 
						app.calculaTotales();
                    }, 1900);

					setTimeout(function(){
                        console.log('De nuevo rango seleccionado line:  ". __LiNE__ ."');
						app.clienteTipoRangoSeleccionado = '".$cotizacion->getRangoCliente()."';
                    }, 2500);
					setTimeout(function(){ console.log('calctot 3'); app.calculaTotales(); }, 2800); 

					setTimeout(function(){

						app.maxTipoPrecioGalvamex = ".$rangosString[0].";
						app.tipoPrecioGalvamex = ".$rangosString[1].";
						app.maxTipoPrecioGalvamexAcryOpa = ".$rangosString[2].";
						app.tipoPrecioGalvamexAcryOpa = ".$rangosString[3].";
						app.maxTipoPrecioGalvamexGalvateja = ".$rangosString[4].";
						app.tipoPrecioGalvamexGalvateja = ".$rangosString[5].";
						app.maxTipoPrecioGalvamexMultipanel = ".$rangosString[6].";
						app.tipoPrecioGalvamexMultipanel = ".$rangosString[7].";
						app.maxTipoPrecioGalvamexRolloKilo = ".$rangosString[8].";
						app.tipoPrecioGalvamexRolloKilo = ".$rangosString[9].";
                        

						}, 2200);	
			
					setTimeout( function() { ". $seUsaGrua." },2400);

					setTimeout( function() {mdlExitWait(); $('.right-sidebar-toggle').click(); },2500);");
		// $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("loadCotizacion");

	function deleteCotizacion($idCotizacion)
	{
		$r = new xajaxResponse();
	    // $r->starDebug();
		$cotizacion = new ModeloCotizacion();
		
		$cotizacion->setIdCotizacion($idCotizacion);

		$cotizacion->setEstadoCANCELADO();

		$cotizacion->Guardar();
		
		$r->script("setTimeout(function(){ saSuccess('Se ha eliminado la Cotización'); mdlExitWait(); app.cargarListaCotizaciones(); }, 100); ");
		// $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("deleteCotizacion");

	function saludar()
	{
	    $r = new xajaxResponse();
	    
	    $r->mostrarAviso("Saludo");
	    
	    return $r;
	}
	$xajax->registerFunction("saludar");
	
	function verificaPromotor()
	{
		global $objSession;
		$r = new xajaxResponse();

// 		if ($objSession->getIdUsuario() == 10 || $objSession->getIdUsuario() == 15)
        if ($objSession->getIdUsuario() == 15999)
		{
			// $r->mostrarAviso("validar");
			$valores = " app.calcularRangosPrecios = false; ";
			if ($objSession->getIdUsuario() == 15999)
			{
				$valores .= " app.maxTipoPrecioGalvamex = 3; ";
				$valores .= " app.maxTipoPrecioGalvamexMultipanel = 3; ";
				$valores .= " app.maxTipoPrecioGalvamexGalvateja = 3; ";
				$valores .= " app.maxTipoPrecioGalvamexAcryOpa = 3; ";
				$valores .= " app.maxTipoPrecioGalvamexRolloKilo = 3; ";
				
			}

			$r->script($valores);
		}
		// else
		// {
		// 	$r->mostrarAviso("todo normal");
		// }


		return $r;
	}
	$xajax->registerFunction("verificaPromotor");

	function cargarClientes()
	{
		$r = new xajaxResponse();

		$clientes = new ModeloCliente();

		$lst = $clientes->getAll("cliente.idUsuarioPromotor, cliente.idCliente, cliente.nombre, cliente.apellidos, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento, rangoCliente ",
				                 " INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
								"estado = 'ACTIVO'");

		$strClientes = "";

		foreach ($lst as $row)
		{

			$strClientes .= "app.clientes.push({ id: ".$row["idCliente"].",
											   idUsuarioPromotor: ".$row["idUsuarioPromotor"].",
		                                       nombre: '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."',
		                                       domicilio1: '".mb_strtoupper($row["domicilio1"]). "',
		                                       domicilio2: '".mb_strtoupper($row["domicilio2"]). "',
		                                       numero: '".mb_strtoupper($row["numero"]). "',
		                                       colonia: '".mb_strtoupper($row["colonia"]). "',
		                                       ciudad: '".mb_strtoupper($row["ciudad"]). "',
		                                       telefonos: '".mb_strtoupper($row["telefonos"]). "',
		                                       porDescuento: '".mb_strtoupper($row["pordescuento"]). "',
                                               rangoCliente: '".$row["rangoCliente"]."',
		                                       promotor: '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."'
					                                      });";
		}

		$r->script("
				  app.clientes.splice(0, app.clientes.length);
				" .
				$strClientes);

		return $r;
	}
	$xajax->registerFunction("cargarClientes");

	function cargarClienteMostador($idCliente)
	{
		$r = new xajaxResponse();

		$clientes = new ModeloCliente();

		$lst = $clientes->getAll("cliente.idUsuarioPromotor, cliente.idCliente, cliente.nombre, cliente.apellidos, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento, rangoCliente ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor", " cliente.idCliente = " . $idCliente);

		$strClientes = "";

		foreach ($lst as $row)
		{

			$strClientes .= "app.clientes.push({ id: ".$row["idCliente"].",
		                                       nombre: '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."',
		                                       domicilio1: '".mb_strtoupper($row["domicilio1"]). "',
		                                       domicilio2: '".mb_strtoupper($row["domicilio2"]). "',
		                                       idUsuarioPromotor: ".$row["idUsuarioPromotor"].",
		                                       numero: '".mb_strtoupper($row["numero"]). "',
		                                       colonia: '".mb_strtoupper($row["colonia"]). "',
		                                       ciudad: '".mb_strtoupper($row["ciudad"]). "',
		                                       telefonos: '".mb_strtoupper($row["telefonos"]). "',
		                                       porDescuento: '".mb_strtoupper($row["pordescuento"]). "',
                                               rangoCliente: '".$row["rangoCliente"]."', 
		                                       promotor: '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."'
					                                      });";
		}

		$r->script("
				  app.clientes.splice(0, app.clientes.length);
				" .
				$strClientes . " app.cargarRangos(); setTimeout(function(){ app.setClienteSelected(".$idCliente."); }, 50); ");

		$r->script("  setTimeout(function(){  mdlExitWait();  }, 2500); ");				


		return $r;
	}
	$xajax->registerFunction("cargarClienteMostador");

	function cargarNoPedidosByIdCliente($idCliente)
	{
		$r = new xajaxResponse();

		$clientes = new ModeloCliente();

		$query = "SELECT IFNULL(COUNT(idPedido), 0) cantidad FROM pedido WHERE idcliente = ". $idCliente;

		$dato = $clientes->getDataSet($query)[0];

		$r->script("app.pedidosDelCliente = ".$dato["cantidad"].";");

		return $r;
	}
	$xajax->registerFunction("cargarNoPedidosByIdCliente");

	function cargarClienteById($idCliente, $rango = "")
	{
		$r = new xajaxResponse();


		$clientes = new ModeloCliente();

		$lst = $clientes->getAll("cliente.idUsuarioPromotor, cliente.idCliente, cliente.nombre, cliente.apellidos, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento, rangoCliente ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" idCliente = " . $idCliente);

		$strClientes = "";

		$rangoCliente = 1;
		foreach ($lst as $row)
		{

			$strClientes = "app.idClienteSeleccionado = ".$row["idCliente"].";
					        app.idUsuarioPromotor =  ".$row["idUsuarioPromotor"].";
		                    app.clienteSeleccionado = '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."';
		                    app.cteSelDomicilio1 = '".mb_strtoupper($row["domicilio1"]). "';
		                    app.cteSelDomicilio2 = '".mb_strtoupper($row["domicilio2"]). "';
		                    app.cteSelNumero = '".mb_strtoupper($row["numero"]). "';
		                    app.cteSelColonia = '".mb_strtoupper($row["colonia"]). "';
		                    app.cteSelCiudad = '".mb_strtoupper($row["ciudad"]). "';
		                    app.cteSelTelefonos = '".mb_strtoupper($row["telefonos"]). "';
		                    app.porDescuento = '".mb_strtoupper($row["pordescuento"]). "';
                            app.clienteTipoRangoSeleccionado = '". ( $rango == "" ? $row["rangoCliente"] : $rango)."';
		                    app.promotorClienteSeleccionado = '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."';";

			switch ($row["rangoCliente"])
			{
			    case "REGULAR":
			        $rangoCliente = 1;
			        break;
			    case "DISTINGUIDO":
			        $rangoCliente = 2;
			        break;
			    case "SELECT":
			        $rangoCliente = 3;
			        break;
			    case "PLATINO":
			        $rangoCliente = 4;
			        break;
			}
		}

// 		$r->saSuccess($strClientes); return $r;
        $r->script("
                    app.tipoPrecioGalvamex = ".$rangoCliente.";
                    app.tipoPrecioGalvamexAcryOpa = ".$rangoCliente.";
                    app.tipoPrecioGalvamexGalvateja = ".$rangoCliente.";
                    app.tipoPrecioGalvamexMultipanel = ".$rangoCliente.";
                    app.tipoPrecioGalvamexRolloKilo = ".$rangoCliente.";
            ");

		$r->script($strClientes . " toastr.options = {			
			\"positionClass\": \"toast-top-right\"			
		  };  toastr.info('Datos del Cliente actualizados','Pedido'); app.cargarRangos(); setTimeout(function() {app.calculaTotales();}, 500); ");

		return $r;
	}
	$xajax->registerFunction("cargarClienteById");

	function cargarTiposProducto()
	{
		$r = new xajaxResponse();

		$tipos = new ModeloTipoproducto();

		$lst = $tipos->getAll("","","idtipoproducto not in (2,3)");
// 		$lst = $tipos->getAll("","","");

		$strTiposProductos = "";
		$strTipo = "";

		foreach ($lst as $row)
		{

			$strTiposProductos .= "app.tiposProducto.push({ id: ".$row["idTipoProducto"].",
					                                       nombre: '".mb_strtoupper($row["nombre"])."'
					                                      });";
		}

 		$r->script($strTiposProductos);

		return $r;
	}
	$xajax->registerFunction("cargarTiposProducto");
	
	function cargarOtrosCargos()
	{
	    $r = new xajaxResponse();
	    
	    $oc = new ModeloOtrocargo();
	    	    
	    $lst = $oc->getAll("","","", "idOtroCargo");
	    
	    $strOC = "";
	    
	    
	    foreach ($lst as $row)
	    {
	        
	        $strOC .= "app.otrosCargos.push({ 
                        id: ".$row["idOtroCargo"].",
					descripcion: '".mb_strtoupper($row["descripcion"])."',
                    solicitar: '".mb_strtoupper($row["solicitar"])."',
                    precioingreso: '".mb_strtoupper($row["precioIngreso"])."',
                    cantidad: '',
                    monto: 0,
					automatico: '".($row["automatico"])."'
					                                      });";
	    }
	    
	    $r->script(" app.otrosCargos.splice(0, app.otrosCargos.length); " . $strOC);
	    
	    return $r;
	}
	$xajax->registerFunction("cargarOtrosCargos");

	function cargarRangos($idUsuarioPromotor)
	{
		global $objSession;
		$r = new xajaxResponse();

		$con = new ModeloConfiguracion();
		$usr = new ModeloUsuario();

		$con->setIdConfiguracion(1);

		if ($con->getIdConfiguracion() <= 0)
		{
			$r->saError("No se ha podido obtener la Configuración de Rangos.");
			return $r;
		}

		$usr->setIdUsuario($idUsuarioPromotor);

		$comisiones = "";

		$rangoComision = $usr->getRangoComisiones() ; //$objSession->getRangoComisiones();



		if ($rangoComision == "ALTO")
		{
			$comisiones .= " app.comisionR1 = '" . $con->getComision1R1() . "'; ";
			$comisiones .= " app.comisionR2 = '" . $con->getComision1R2() . "'; ";
			$comisiones .= " app.comisionR3 = '" . $con->getComision1R3() . "'; ";
			$comisiones .= " app.comisionR4 = '" . $con->getComision1R4() . "'; ";
		}
		else if($rangoComision == "MEDIO")
		{
			$comisiones .= " app.comisionR1 = '" . $con->getComision2R1() . "'; ";
			$comisiones .= " app.comisionR2 = '" . $con->getComision2R2() . "'; ";
			$comisiones .= " app.comisionR3 = '" . $con->getComision2R3() . "'; ";
			$comisiones .= " app.comisionR4 = '" . $con->getComision2R4() . "'; ";
		}
		else
		{
			$comisiones .= " app.comisionR1 = " . $con->getComision3R1() . "; ";
			$comisiones .= " app.comisionR2 = " . $con->getComision3R2() . "; ";
			$comisiones .= " app.comisionR3 = " . $con->getComision3R3() . "; ";
			$comisiones .= " app.comisionR4 = " . $con->getComision3R4() . "; ";
		}

		$r->script("

				app.rango1Fin = ".$con->getRangoMetros1Fin().";
				app.rango2Inicio = ".$con->getRangoMetros2Inicio().";
				app.rango2Fin = ".$con->getRangoMetros2Fin().";
				app.rango3Inicio = ".$con->getRangoMetros3Inicio().";

				app.rango1FinAcryOpa = ".$con->getRangoMetros1AcryOpaFin() .";
				app.rango2InicioAcryOpa = ".$con->getRangoMetros2AcryOpaInicio().";
				app.rango2FinAcryOpa = ".$con->getRangoMetros2AcryOpaFin().";
				app.rango3InicioAcryOpa = ".$con->getRangoMetros3AcryOpaInicio().";
                
		        app.rango1FinGalvateja = 300;
		        app.rango2InicioGalvateja = 301;
		        app.rango2FinGalvateja = 600;
		        app.rango3InicioGalvateja = 601;

                app.rango1FinRolloKilo = 4999;
		        app.rango2InicioRolloKilo = 5000;
		        app.rango2FinRolloKilo = 9999;
		        app.rango3InicioRolloKilo = 10000;

				app.rango1FinMultipanel = ".$con->getRangoMetros1MultipanelFin().";
				app.rango2InicioMultipanel = ".$con->getRangoMetros2MultipanelInicio().";
				app.rango2FinMultipanel = ".$con->getRangoMetros2MultipanelFin().";
				app.rango3InicioMultipanel = ".$con->getRangoMetros3MultipanelInicio().";

				app.maxDescuentoIndividual = " . $con->getPedidoDescuento() .";

				" . $comisiones);



		return $r;
	}
	$xajax->registerFunction("cargarRangos");


	function cargarListaProductos()
	{
        global $objSession;
		$r = new xajaxResponse();
        // $r->startDebug();
		$productos = new ModeloViewproductos();


		$productos->getAllView($objSession->getIdUsuario());

		$strListadoProductos = "";

        $lstAcanalados = array();
        $strAcanalados = "app.lstAcanalados.splice(0, app.lstAcanalados.length); ";
        $lstMateriales = array();
        $strMateriales = "app.lstMateriales.splice(0, app.lstMateriales.length); ";
        $lstCalibres = array();
        $strCalibres = "app.lstCalibres.splice(0, app.lstCalibres.length); ";
        $lstEspesores = array();
        $strEspesores = "app.lstEspesores.splice(0, app.lstEspesores.length); ";
        $lstProveedores = array();
        $strProveedores = "app.lstProveedores.splice(0, app.lstProveedores.length); ";

        $lstAcanaladosComer = array();
        $strAcanaladosComer = "app.lstAcanaladosComer.splice(0, app.lstAcanaladosComer.length); ";
        $lstMaterialesComer = array();
        $strMaterialesComer = "app.lstMaterialesComer.splice(0, app.lstMaterialesComer.length); ";
        $lstCalibresComer = array();
        $strCalibresComer = "app.lstCalibresComer.splice(0, app.lstCalibresComer.length); ";
        $lstMedidaEspecialComer = array();
        $strMedidaEspecialComer = "app.lstMedidaEspecialComer.splice(0, app.lstMedidaEspecialComer.length); ";
        
        $isLaminaMetalica = false;
        $isComercializado = false;
        

		for($i = 0 ; $i <count($productos->lstProductos) ; $i++)
		{
            $isLaminaMetalica = false;
            $isComercializado = false;
			if ($productos->lstProductos[$i]->getEstado() == "ACTIVO")
			{

                if ((($productos->lstProductos[$i]->getIdTipoProducto() == 1 && $productos->lstProductos[$i]->getIdRollo() > 1) || $productos->lstProductos[$i]->getIdTipoProducto() == 5) )
                {
                    $isLaminaMetalica = true;

                    if (!isset($lstAcanalados[$productos->lstProductos[$i]->getIdAplicacion()]))
                    {
                        $lstAcanalados[$productos->lstProductos[$i]->getIdAplicacion()] = $productos->lstProductos[$i]->getIdAplicacion();
                        $aca = $productos->lstProductos[$i]->getAplicacion();
                        switch($aca)
                        {
                            case "--NO APLICA--":
                                $aca = "ROLLOS";
                                break;
                            
                        }
                        $strAcanalados .= "
                                    app.lstAcanalados.push({

                                        id: '".$productos->lstProductos[$i]->getIdAplicacion()."',
                                        value: '".$aca."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstMateriales[$productos->lstProductos[$i]->getRolloIdMaterial()]))
                    {
                        $lstMateriales[$productos->lstProductos[$i]->getRolloIdMaterial()] = $productos->lstProductos[$i]->getRolloIdMaterial();
                        $mat = $productos->lstProductos[$i]->getRolloMaterial();
                        // switch($mat)
                        // {
                        //     case "2626":
                        //         $mat = "26/26";
                        //         break;
                        //     case "2424":
                        //         $mat = "24/24";
                        //         break;
                        //     case "2426":
                        //         $mat = "24/26";
                        //         break;
                        //     case "2828":
                        //         $mat = "28/28";
                        //         break;
                        // }
                        $strMateriales .= "
                                    app.lstMateriales.push({

                                        id: '".$productos->lstProductos[$i]->getRolloIdMaterial()."',
                                        value: '".$mat."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstCalibres[$productos->lstProductos[$i]->getRolloCalibre()]))
                    {
                        $lstCalibres[$productos->lstProductos[$i]->getRolloCalibre()] = $productos->lstProductos[$i]->getRolloCalibre();
                        $cal = $productos->lstProductos[$i]->getRolloCalibre();
                        switch($cal)
                        {
                            case "2626":
                                $cal = "26/26";
                                break;
                            case "2424":
                                $cal = "24/24";
                                break;
                            case "2426":
                                $cal = "24/26";
                                break;
                            case "2828":
                                $cal = "28/28";
                                break;
                        }
                        $strCalibres .= "
                                    app.lstCalibres.push({

                                        id: '".$productos->lstProductos[$i]->getRolloCalibre()."',
                                        value: '".$cal."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstProveedores[$productos->lstProductos[$i]->getRolloIdProveedor()]))
                    {
                        $lstProveedores[$productos->lstProductos[$i]->getRolloIdProveedor()] = $productos->lstProductos[$i]->getRolloIdProveedor();
                        $pro = $productos->lstProductos[$i]->getRolloProveedor();
                        // switch($pro)
                        // {
                        //     case "2626":
                        //         $pro = "26/26";
                        //         break;
                        //     case "2424":
                        //         $pro = "24/24";
                        //         break;
                        //     case "2426":
                        //         $pro = "24/26";
                        //         break;
                        //     case "2828":
                        //         $pro = "28/28";
                        //         break;
                        // }
                        $strProveedores .= "
                                    app.lstProveedores.push({

                                        id: '".$productos->lstProductos[$i]->getRolloIdProveedor()."',
                                        value: '".$pro."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstEspesores[$productos->lstProductos[$i]->getRolloPies()]))
                    {
                        $lstEspesores[$productos->lstProductos[$i]->getRolloPies()] = $productos->lstProductos[$i]->getRolloPies();
                        $espe = $productos->lstProductos[$i]->getRolloPies();

                        $espe = str_replace(".00", "", $espe);
                        // switch($espe)
                        // {
                        //     case "2626":
                        //         $espe = "26/26";
                        //         break;
                        //     case "2424":
                        //         $espe = "24/24";
                        //         break;
                        //     case "2426":
                        //         $espe = "24/26";
                        //         break;
                        //     case "2828":
                        //         $espe = "28/28";
                        //         break;
                        // }
                        $strEspesores .= "
                                    app.lstEspesores.push({

                                        id: '".$productos->lstProductos[$i]->getRolloPies()."',
                                        value: '".$espe."',
                                        checked: false

                                    });
                        ";
                    }

                }

                if ($productos->lstProductos[$i]->getIdTipoProducto() == 1 && $productos->lstProductos[$i]->getIdRollo() == 1)
                {
                    $isComercializado = true;

                    if (!isset($lstAcanaladosComer[$productos->lstProductos[$i]->getIdAplicacion()]))
                    {
                        $lstAcanaladosComer[$productos->lstProductos[$i]->getIdAplicacion()] = $productos->lstProductos[$i]->getIdAplicacion();
                        $aca = $productos->lstProductos[$i]->getAplicacion();
                        switch($aca)
                        {
                            case "--NO APLICA--":
                                $aca = "ROLLOS";
                                break;
                            
                        }
                        $strAcanaladosComer .= "
                                    app.lstAcanaladosComer.push({

                                        id: '".$productos->lstProductos[$i]->getIdAplicacion()."',
                                        value: '".$aca."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstMaterialesComer[$productos->lstProductos[$i]->getIdMaterial()]))
                    {
                        $lstMaterialesComer[$productos->lstProductos[$i]->getIdMaterial()] = $productos->lstProductos[$i]->getIdMaterial();
                        $mat = $productos->lstProductos[$i]->getMaterial();
                        // switch($mat)
                        // {
                        //     case "2626":
                        //         $mat = "26/26";
                        //         break;
                        //     case "2424":
                        //         $mat = "24/24";
                        //         break;
                        //     case "2426":
                        //         $mat = "24/26";
                        //         break;
                        //     case "2828":
                        //         $mat = "28/28";
                        //         break;
                        // }
                        $strMaterialesComer .= "
                                    app.lstMaterialesComer.push({

                                        id: '".$productos->lstProductos[$i]->getIdMaterial()."',
                                        value: '".$mat."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstCalibresComer[$productos->lstProductos[$i]->getCalibre()]))
                    {
                        $lstCalibresComer[$productos->lstProductos[$i]->getCalibre()] = $productos->lstProductos[$i]->getCalibre();
                        $cal = $productos->lstProductos[$i]->getCalibre();
                        switch($cal)
                        {
                            case "0":
                                $cal = "(0) No Aplica";
                                break;
                            case "2626":
                                $cal = "26/26";
                                break;
                            case "2424":
                                $cal = "24/24";
                                break;
                            case "2426":
                                $cal = "24/26";
                                break;
                            case "2828":
                                $cal = "28/28";
                                break;
                        }
                        $strCalibresComer .= "
                                    app.lstCalibresComer.push({

                                        id: '".$productos->lstProductos[$i]->getCalibre()."',
                                        value: '".$cal."',
                                        checked: false

                                    });
                        ";
                    }

                    if (!isset($lstMedidaEspecialComer[$productos->lstProductos[$i]->getMedidaespecial()]))
                    {
                        $lstMedidaEspecialComer[$productos->lstProductos[$i]->getMedidaespecial()] = $productos->lstProductos[$i]->getMedidaespecial();
                        $me = $productos->lstProductos[$i]->getMedidaespecial();
                        switch($me)
                        {
                            case "0":
                            case "":
                                $me = "No Especificado";
                                break;
                            // case "2626":
                            //     $me = "26/26";
                            //     break;
                            // case "2424":
                            //     $me = "24/24";
                            //     break;
                            // case "2426":
                            //     $me = "24/26";
                            //     break;
                            // case "2828":
                            //     $me = "28/28";
                            //     break;
                        }
                        $strMedidaEspecialComer .= "
                                    app.lstMedidaEspecialComer.push({

                                        id: '".$productos->lstProductos[$i]->getMedidaespecial()."',
                                        value: '".$me."',
                                        checked: false

                                    });
                        ";
                    }

                    

                }


                

				$desc=str_replace(chr(13),'', $productos->lstProductos[$i]->getRolloDescripcion());
				$desc=str_replace('<br />','\n', $desc);
				$desc=str_replace(chr(10),'', $desc);

				$descProducto=str_replace(chr(13),'', $productos->lstProductos[$i]->getDescripcion());
				$descProducto=str_replace('<br />','\n', $descProducto);
				$descProducto=str_replace(chr(10),'', $descProducto);

				$strListadoProductos .= "
					app.productosParaFiltro.push({
						idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
						codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
						
						fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."',
						fullDescripcionCode: '". $productos->lstProductos[$i]->getCodigo(). " - " . $productos->lstProductos[$i]->getDescauto()."',
						precio1: ".$productos->lstProductos[$i]->getPrecio1().",
						precio2: ".$productos->lstProductos[$i]->getPrecio2().",
						precio3: ".$productos->lstProductos[$i]->getPrecio3().",
						precio4: ".$productos->lstProductos[$i]->getPrecio4().",
						preciomendez: ".$productos->lstProductos[$i]->getPreciomendez()."

		             });


 					";

				// $strListadoProductos .= "
				// 	app.productos.push({
				// 		idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
				// 		codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
                //         isMoldura: false,
				// 		longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',
				// 		mlpieza:  " .$productos->lstProductos[$i]->getMlpieza() . ",
				// 		idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',
				// 		tipoProducto:  '" .$productos->lstProductos[$i]->getTipoProducto() . "',
				// 		shortTipoProducto:  '" .$productos->lstProductos[$i]->getShortTipoProducto() . "',
				// 		idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',
				// 		aplicacion:  '" .$productos->lstProductos[$i]->getAplicacion() . "',
				// 		idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
				// 		material:  '" .$productos->lstProductos[$i]->getMaterial() . "',
                //         curva: '',
				// 		idRollo:  '" .$productos->lstProductos[$i]->getIdRollo() . "',
				// 		rolloCodigo:  '" .$productos->lstProductos[$i]->getRolloCodigo() . "',
				// 		rolloIdMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
				// 		rolloMaterial:  '" .$productos->lstProductos[$i]->getMaterial() . "',
				// 		rolloShortMaterial:  '" .$productos->lstProductos[$i]->getRolloShortMaterial() . "',
				// 		rolloIdProveedor:  '" .$productos->lstProductos[$i]->getRolloIdProveedor() . "',
				// 		rolloProveedor:  '" .$productos->lstProductos[$i]->getRolloProveedor() . "',
				// 		rolloShortProveedor:  '" .$productos->lstProductos[$i]->getRolloShortProveedor() . "',
				// 		rolloCalibre:  '" .$productos->lstProductos[$i]->getCalibre() . "',
				// 		rolloPies:  '" .$productos->lstProductos[$i]->getPies() . "',
				// 		rolloPesokiloml:  " .$productos->lstProductos[$i]->getRolloPesokiloml() . ",
				// 		rolloDescripcion:  '" .$desc . "',
				// 		idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',
				// 		unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',
				// 		shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',
				// 		calibre:  '" .$productos->lstProductos[$i]->getCalibre() . "',
				// 		descripcion:  '" . $descProducto . "',
				// 		existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',
                //         tipoPrecioComision: 'PRECIO',
				// 		tipoPrecio:  '" .$productos->lstProductos[$i]->getTipoPrecio() . "',
				// 		isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
				// 		tipoRango:  '" .$productos->lstProductos[$i]->getTipoRango() . "',
				// 		isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',
				// 		precio1:  '" .$productos->lstProductos[$i]->getPrecio1() . "',
				// 		precio2:  '" .$productos->lstProductos[$i]->getPrecio2() . "',
				// 		precio3:  '" .$productos->lstProductos[$i]->getPrecio3() . "',
				// 		precio4:  '" .$productos->lstProductos[$i]->getPrecio4() . "',
                //         preciomendez:  '" .$productos->lstProductos[$i]->getPreciomendez() . "',
				// 		estado: '" .$productos->lstProductos[$i]->getEstado() . "',
				// 		existenciaEstimada: '".$productos->lstProductos[$i]->getExistenciaToCero()."',
				// 		fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."',
				// 		fullDescripcionCode: '". $productos->lstProductos[$i]->getCodigo(). " - " . $productos->lstProductos[$i]->getDescauto()."',

                //         favorito: '".$productos->lstProductos[$i]->getFavorito()."',

				// 		cantidad: 1,
				// 		lblUnidad: '',
				// 		cantUnidad: 1,
				// 		cantUnidadReal: 1,
                //         dobleces: '0',
                //         precioRenglon: '0',
				// 		rangoRenglon: '1',
                //         totalRenglon: '0',
				// 		desarrolloI: '0',
				// 		desarrolloT: '0',
				// 		dobleces: '0',
				// 		debug: '',
				// 		kl: 0,
				// 		productoCantidadDisponible: true,
                //         molPrecioLamina: 0,
                //         molMoldurasXLamina: 1,
                //         molMoldurasXLaminaTodos: 1,
                //         molLaminasCobrar: 1,
                //         molLaminasATomar: 1,
                //         molCorte: 0,
                //         molDobles: 0,
                //         molIsScrap: false,
                //         molTotalCMScrap: 0,
                //         molLongitudinal: 'L',
                //         sugerirStock: [],
				// 		inventarioSucursal: [],
				// 		idPedidoDetalle: 0

                        
                                           

		        //      });


 				// 	";


                if ($isLaminaMetalica || $isComercializado || $productos->lstProductos[$i]->getIdTipoProducto() == 4)
                {
                    $strListadoProductos .= "
                        app.". ($isLaminaMetalica ? 'productosNuevoFiltro' : ($isComercializado ? 'productosNuevoFiltroComercializados' : 'productosNuevoFiltroAccesorios') ) .".push({
                            idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
                            codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
                            
                            longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',
                            mlpieza:  " .$productos->lstProductos[$i]->getMlpieza() . ",
                            idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',
                            
                            idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',
                            
                            idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
                            
                            idRollo:  '" .$productos->lstProductos[$i]->getIdRollo() . "',
                            
                            rolloIdProveedor:  '" .$productos->lstProductos[$i]->getRolloIdProveedor() . "',
                            rolloProveedor:  '" .$productos->lstProductos[$i]->getRolloProveedor() . "',
                            
                            rolloCalibre:  '" . ($isComercializado ? $productos->lstProductos[$i]->getCalibre() : $productos->lstProductos[$i]->getRolloCalibre())  . "',
                            rolloPies:  '" . ($isComercializado ? $productos->lstProductos[$i]->getPies() : $productos->lstProductos[$i]->getRolloPies())  . "',
                            
                            
                            rolloDescripcion:  '" .$desc . "',
                            idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',
                            unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',
                            shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',
                            
                            descripcion:  '" . $descProducto . "',
                            existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',
                            
                            isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
                            tipoRango:  '" .$productos->lstProductos[$i]->getTipoRango() . "',
                            isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',
                            
                            existenciaEstimada: '".$productos->lstProductos[$i]->getExistenciaToCero()."',
                            fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."',
                            fullDescripcionCode: '". $productos->lstProductos[$i]->getCodigo(). " - " . $productos->lstProductos[$i]->getDescauto()."',

                            favorito: '".$productos->lstProductos[$i]->getFavorito()."',
                            medidaespecial: '".$productos->lstProductos[$i]->getMedidaespecial()."',
                                            

                        });


                        ";
                }



			}


		}


		$query = "select distinct tipoprecio, desarrollo from precioxdobles order by 1, 2";

		$lstDesarrollos = $productos->getDataSet($query);

		foreach ($lstDesarrollos as $row)
		{
			$strListadoProductos .= "

                        app.desarrollos.push({ tipoPrecio: '".$row["tipoprecio"]."', desarrollo: '".$row["desarrollo"]."' });

                    ";
		}

// 		$debug = ob_get_clean();
		// $r->mostrarAviso(implode(",", $lstProveedores));

  		$r->script($strListadoProductos );
        
        $r->script($strAcanalados);
        $r->script($strMateriales);
        $r->script($strCalibres . " app.lstCalibres = app.lstCalibres.sort(app.compare_item);");
        $r->script($strEspesores . " app.lstEspesores = app.lstEspesores.sort(app.compare_item);");
        $r->script($strProveedores);        
        $r->script($strAcanaladosComer);
        $r->script($strMaterialesComer);
        $r->script($strMedidaEspecialComer);
        $r->script($strCalibresComer . " app.lstCalibresComer = app.lstCalibresComer.sort(app.compare_item);");

        $r->script("  setTimeout(function(){ app.agruparProductosComercializados(); }, 1200);");

        $r->script("  setTimeout(function(){ app.cargarProductosMasVendidos(); }, 1300);");
		// $r->mostrarAviso("cargarlistaproductos: " . __LINE__); return $r;
        $r->script("  setTimeout(function(){ app.cargarProductosFavoritos(); }, 1400);");
		// $r->mostrarAviso ("Bien " . __LINE__); return $r;

        
        

        // $r->script(" app.lstCalibres = [". implode(",", $lstCalibres)."] ");
        // $r->script(" app.lstEspesores = [". implode(",", $lstEspesores)."] ");
        // $r->script(" app.lstProveedores = [". implode(",", $lstProveedores)."] ");

// 		$r->assign("divdebug", "innerHTML", $strListadoProductos);
// 		$r->mostrarAviso( $strListadoProductos);

// $r->mostrarAviso("Productos Cargados"); return $r;

        // $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarListaProductos");

    function cargarListaProductosMasVendidos()
	{
        global $objSession;
		$r = new xajaxResponse();

		$productos = new ModeloViewproductos();

		$productos->getAllViewMasVendidos($objSession->getIdUsuario());

		$strListadoProductos = "app.productosNuevoFiltroMasVendidos.splice(0, app.productosNuevoFiltroMasVendidos.length); ";

        
		for($i = 0 ; $i <count($productos->lstProductos) ; $i++)
		{
            $isLaminaMetalica = false;
            $isComercializado = false;
			if ($productos->lstProductos[$i]->getEstado() == "ACTIVO")
			{  

				$desc=str_replace(chr(13),'', $productos->lstProductos[$i]->getRolloDescripcion());
				$desc=str_replace('<br />','\n', $desc);
				$desc=str_replace(chr(10),'', $desc);

				$descProducto=str_replace(chr(13),'', $productos->lstProductos[$i]->getDescripcion());
				$descProducto=str_replace('<br />','\n', $descProducto);
				$descProducto=str_replace(chr(10),'', $descProducto);



                $strListadoProductos .= "
                    app.productosNuevoFiltroMasVendidos.push({
                        idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
                        codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
                        
                        longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',
                        mlpieza:  " .$productos->lstProductos[$i]->getMlpieza() . ",
                        idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',
                        
                        idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',
                        
                        idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
                        
                        idRollo:  '" .$productos->lstProductos[$i]->getIdRollo() . "',
                        
                        rolloIdProveedor:  '" .$productos->lstProductos[$i]->getRolloIdProveedor() . "',
                        rolloProveedor:  '" .$productos->lstProductos[$i]->getRolloProveedor() . "',
                        
                        rolloCalibre:  '" . ($isComercializado ? $productos->lstProductos[$i]->getCalibre() : $productos->lstProductos[$i]->getRolloCalibre())  . "',
                        rolloPies:  '" . ($isComercializado ? $productos->lstProductos[$i]->getPies() : $productos->lstProductos[$i]->getRolloPies())  . "',
                        
                        
                        rolloDescripcion:  '" .$desc . "',
                        idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',
                        unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',
                        shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',
                        
                        descripcion:  '" . $descProducto . "',
                        existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',


                        vendidos:  '" .$productos->lstProductos[$i]->getApartado() . "',
                        
                        isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
                        tipoRango:  '" .$productos->lstProductos[$i]->getTipoRango() . "',
                        isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',
                        
                        existenciaEstimada: '".$productos->lstProductos[$i]->getExistenciaToCero()."',
                        fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."',
                        fullDescripcionCode: '". $productos->lstProductos[$i]->getCodigo(). " - " . $productos->lstProductos[$i]->getDescauto()."',


                        favorito: '".$productos->lstProductos[$i]->getFavorito()."',    

                    });


                    ";
                

			}


		}

		

  		$r->script($strListadoProductos );
        
        

		return $r;
	}
	$xajax->registerFunction("cargarListaProductosMasVendidos");

    
    function cargarListaProductosFavoritos()
	{
        global $objSession;
		$r = new xajaxResponse();
		// $r->starDebug(); 
		$productos = new ModeloViewproductos();
		$productos->getAllViewFavoritos($objSession->getIdUsuario());

		$strListadoProductos = "app.productosNuevoFiltroFavoritos.splice(0, app.productosNuevoFiltroFavoritos.length); ";
        
        
		for($i = 0 ; $i <count($productos->lstProductos) ; $i++)
		{
            $isLaminaMetalica = false;
            $isComercializado = false;
			if ($productos->lstProductos[$i]->getEstado() == "ACTIVO")
			{  

				$desc=str_replace(chr(13),'', $productos->lstProductos[$i]->getRolloDescripcion());
				$desc=str_replace('<br />','\n', $desc);
				$desc=str_replace(chr(10),'', $desc);

				$descProducto=str_replace(chr(13),'', $productos->lstProductos[$i]->getDescripcion());
				$descProducto=str_replace('<br />','\n', $descProducto);
				$descProducto=str_replace(chr(10),'', $descProducto);



                $strListadoProductos .= "
                    app.productosNuevoFiltroFavoritos.push({
                        idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
                        codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
                        
                        longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',
                        mlpieza:  " .$productos->lstProductos[$i]->getMlpieza() . ",
                        idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',
                        
                        idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',
                        
                        idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
                        
                        idRollo:  '" .$productos->lstProductos[$i]->getIdRollo() . "',
                        
                        rolloIdProveedor:  '" .$productos->lstProductos[$i]->getRolloIdProveedor() . "',
                        rolloProveedor:  '" .$productos->lstProductos[$i]->getRolloProveedor() . "',
                        
                        rolloCalibre:  '" . ($isComercializado ? $productos->lstProductos[$i]->getCalibre() : $productos->lstProductos[$i]->getRolloCalibre())  . "',
                        rolloPies:  '" . ($isComercializado ? $productos->lstProductos[$i]->getPies() : $productos->lstProductos[$i]->getRolloPies())  . "',
                        
                        
                        rolloDescripcion:  '" .$desc . "',
                        idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',
                        unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',
                        shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',
                        
                        descripcion:  '" . $descProducto . "',
                        existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',


                        vendidos:  '" .$productos->lstProductos[$i]->getApartado() . "',
                        
                        isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
                        tipoRango:  '" .$productos->lstProductos[$i]->getTipoRango() . "',
                        isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',
                        
                        existenciaEstimada: '".$productos->lstProductos[$i]->getExistenciaToCero()."',
                        fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."',
                        fullDescripcionCode: '". $productos->lstProductos[$i]->getCodigo(). " - " . $productos->lstProductos[$i]->getDescauto()."',


                        favorito: '".$productos->lstProductos[$i]->getFavorito()."',    

                    });


                    ";
                

			}


		}

		
		// $r->mostrarAviso("estoy en favoritos"); return $r;

  		$r->script($strListadoProductos );
        
        // $r->endDegug();

		return $r;
	}
	$xajax->registerFunction("cargarListaProductosFavoritos");


	function cargarListaRollos()
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		$rollos = new ModeloViewrollos();

		$lstRollos = $rollos->getAll("idrollo, codigo,if(idmaterial = 2, 1, if(idmaterial = 13, 2, if (idmaterial = 5, 3, 4))) om, descauto, existencia, calibre, pies, idmaterial,
                                      totalpreciovta, totalpreciovtar2, totalpreciovtar3, totalpreciovtar4,
									  IF(apartado >= 0, apartado, 0) as apartado, 
									  (existencia - IF(apartado >= 0, apartado, 0)) disponible ", 
									 "", 
									 " estado = 'ACTIVO' and idrollo > 1",
									 " 3, calibre, pies ");
		
		// $r->mostrarAviso($rollos->getAllQUERY("idrollo, codigo,if(idmaterial = 2, 1, if(idmaterial = 13, 2, if (idmaterial = 5, 3, 4))) om, descauto, existencia, calibre, pies, idmaterial,
        //                               totalpreciovta, totalpreciovtar2, totalpreciovtar3,
		// 							  IF(apartado >= 0, apartado, 0) as apartado,
		// 							  (existencia - IF(apartado >= 0, apartado, 0)) disponible ",
		//     "",
		//     " estado = 'ACTIVO' and idrollo > 1",
		//     " 3, calibre, pies "));


		$pushes = "";
		foreach($lstRollos as $item)
		{
			$pushes .= "
				app.rollosExistencias.push({
						idrollo: ".$item["idRollo"].",
						codigo: '".$item["codigo"]."',
                        calibre: ".$item["calibre"].",
                        pies: ".$item["pies"].",
                        idmaterial: ".$item["idMaterial"].",
                        precio1: ".$item["totalpreciovta"].",
                        precio2: ".$item["totalpreciovtar2"].",
                        precio3: ".$item["totalpreciovtar3"].",
						precio4: ".$item["totalpreciovtar4"].",
						descauto: '".$item["idRollo"]." - ".$item["descauto"]."',
						existencia: ".$item["existencia"].",
						apartado: ".$item["apartado"].",
						disponible: ".$item["disponible"].",
						enpedido: 0,
						nosepuede: false,
						rolloenpedido: false
					});
			
			
			";			
		}
// echo $pushes;
		// $r->endDegug();
		// $r->mostrarAviso($pushes);
		
		$r->script(" app.rollosExistencias.splice(0, app.rollosExistencias.length); " . $pushes);

		return $r;
	}
	$xajax->registerFunction("cargarListaRollos");

	function cargarProductoIndividual($codigo, $idProducto = 0)
	{

		$r = new xajaxResponse();

		$productos = new ModeloViewproductos();

		if ($codigo != "")
			$productos->getViewProductoByCodigo($codigo);
		else
			$productos->getViewProductoByCodigo("", $idProducto);



		$strListadoProductos = "";

		$blnHayProductos = false;

		$blnEntroEnFor = false;

		$idProducto = 0;

		for($i = 0 ; $i <count($productos->lstProductos) ; $i++)

		{
			if ($productos->lstProductos[$i]->getEstado() == "ACTIVO")
			{
				$blnEntroEnFor = true;
				if (($productos->lstProductos [$i]->getPrecio1 () > 0 && $productos->lstProductos [$i]->getTipoPrecio () == "G") || $productos->lstProductos [$i]->getTipoPrecio () == "T" || $productos->lstProductos [$i]->getTipoPrecio () == "I")
				{
					$desc=str_replace(chr(13),'', $productos->lstProductos[$i]->getRolloDescripcion());

					$desc=str_replace('<br />','\n', $desc);

					$desc=str_replace(chr(10),'', $desc);



					$blnHayProductos = true;

					$strListadoProductos .= "

					app.productos.push({

						idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
						codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
                        isMoldura: false,
						longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',
						mlpieza:  " .$productos->lstProductos[$i]->getMlpieza() . ",
						idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',
						tipoProducto:  '" .$productos->lstProductos[$i]->getTipoProducto() . "',
						shortTipoProducto:  '" .$productos->lstProductos[$i]->getShortTipoProducto() . "',
						idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',
						aplicacion:  '" .$productos->lstProductos[$i]->getAplicacion() . "',
						idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
						material:  '" .$productos->lstProductos[$i]->getMaterial() . "',
                        curva: '',
						idRollo:  '" .$productos->lstProductos[$i]->getIdRollo() . "',
						rolloCodigo:  '" .$productos->lstProductos[$i]->getRolloCodigo() . "',
						rolloIdMaterial:  '" .$productos->lstProductos[$i]->getRolloIdMaterial() . "',
						rolloMaterial:  '" .$productos->lstProductos[$i]->getRolloMaterial() . "',
						rolloShortMaterial:  '" .$productos->lstProductos[$i]->getRolloShortMaterial() . "',
						rolloIdProveedor:  '" .$productos->lstProductos[$i]->getRolloIdProveedor() . "',
						rolloProveedor:  '" .$productos->lstProductos[$i]->getRolloProveedor() . "',
						rolloShortProveedor:  '" .$productos->lstProductos[$i]->getRolloShortProveedor() . "',
						rolloCalibre:  '" .$productos->lstProductos[$i]->getRolloCalibre() . "',
						rolloPies:  '" .$productos->lstProductos[$i]->getRolloPies() . "',
						rolloPesokiloml:  " .$productos->lstProductos[$i]->getRolloPesokiloml() . ",
						rolloDescripcion:  '" .$desc . "',
						idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',
						unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',
						shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',
						calibre:  '" .$productos->lstProductos[$i]->getCalibre() . "',
						descripcion:  '" .$productos->lstProductos[$i]->getDescripcion() . "',
						existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',
						
                        tipoPrecioComision: 'PRECIO',
						tipoPrecio:  '" .$productos->lstProductos[$i]->getTipoPrecio() . "',
						isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
						tipoRango:  '" .$productos->lstProductos[$i]->getTipoRango() . "',
						isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',
						precio1:  '" .$productos->lstProductos[$i]->getPrecio1() . "',
						precio2:  '" .$productos->lstProductos[$i]->getPrecio2() . "',
						precio3:  '" .$productos->lstProductos[$i]->getPrecio3() . "',
						precio4:  '" .$productos->lstProductos[$i]->getPrecio4() . "',
                        preciomendez:  '" .$productos->lstProductos[$i]->getPreciomendez() . "',
						estado: '" .$productos->lstProductos[$i]->getEstado() . "',
						existenciaEstimada: '".$productos->lstProductos[$i]->getExistenciaToCero()."',
						fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."',
						fullDescripcionCode: '". $productos->lstProductos[$i]->getCodigo(). " - " . $productos->lstProductos[$i]->getDescauto()."',
						cantidad: 1,

						lblUnidad: '',

						cantUnidad: 1,

						cantUnidadReal: 1,

                        dobleces: '0',

                        precioRenglon: '0',

						rangoRenglon: '1',

                        totalRenglon: '0',

						desarrolloI: '0',

						desarrolloT: '0',

						dobleces: '0',

						debug: '',
						kl: 0,
						productoCantidadDisponible: true,
                        molPrecioLamina: 0,
                        molMoldurasXLamina: 1,
                        molMoldurasXLaminaTodos: 1,
                        molLaminasCobrar: 1,
                        molLaminasATomar: 1,
                        molCorte: 0,
                        molDobles: 0,
                        molIsScrap: false,
                        molTotalCMScrap: 0,
                        molLongitudinal: 'L',
                        sugerirStock: [],
						inventarioSucursal: [],
						idPedidoDetalle: 0



		             });





// 					";

				}
			}
		}
		$r->script($strListadoProductos);

		if ($blnHayProductos)
		{
			$r->script("app.prepararProducto(-1, false, ".$idProducto."); //ocultarMensaje();");
		}
		else
		{
			// 			$r->ocultarMensaje();
			if ($blnEntroEnFor)
			{
				// $r->script("ocultarMensaje();");

				$r->saError("Verifique que el Producto que esta seleccionando tenga Precio.");
			}
			else
			{
				// $r->script("ocultarMensaje();");

				$r->saError("No se encuentra el producto que intenta ingresar, o está dado de Baja.");			
			}
		}

		return $r;
	}
	$xajax->registerFunction("cargarProductoIndividual");


	function setPrecioProductoByDobles($index, $calibre, $tipoPrecio, $desarrollo, $dobleces)
	{
		$r = new xajaxResponse();

		$precioXDobles = new ModeloPrecioxdobles();

		$precioXDobles->setTipoPrecio($tipoPrecio);
		$precioXDobles->setDesarrollo($desarrollo);
		$precioXDobles->setCalibre($calibre);
 		$precioXDobles->getPreciosByDesarrolloTipoPrecio();

// 		$r->mostrarAviso($precioXDobles->getPreciosByDesarrolloTipoPrecio()); return $r;

 		$precio = $precioXDobles->getPrecioById($dobleces);

// 		$r->mostrarAviso("index: " . $index);
		$r->script("
				app.listadoPedido[".$index."].precioRenglon = " . $precio . " ;
				app.calculaTotales();
				");

		return $r;
	}
	$xajax->registerFunction("setPrecioProductoByDobles");


	function levantarPedidoV2($idClienteSeleccionado, $subtotalPedido, $ivaPedido, $descuentoPedido, $totalPedido, $tipoPrecioGalvamex,$detalle
// 	    , $recogeRecibe
// 	                          ,$strPersona, $strDireccion, $strNumero, $strColonia, $strCiudad, $fechaEntrega, $horaEntrega, $tipoPedido, $porDescuento, $maxDescuentoIndividual, $descuentoIndividual, $observacionPedido, $totalOtrosCargos, $otrosCargos
	    )
	{
	    $r = new xajaxResponse();
	    
	    $r->script("console.log('saludos desde levantapedidosv2 ". $idClienteSeleccionado . " - ". $tipoPrecioGalvamex ."');");
	    
	    return $r;
	}
	$xajax->registerFunction("levantarPedidoV2");
	
	function lp($idClienteSeleccionado, $subtotalPedido, $ivaPedido, $descuentoPedido, $totalPedido, $tipoPrecioGalvamex ,$detalle, $recogeRecibe,$strPersona, $strDireccion, $strNumero, $strColonia, $strCiudad, $fechaEntrega, $horaEntrega, $fechaAbierta, $pedidoExpress, $tipoPedido, $porDescuento, $maxDescuentoIndividual, $descuentoIndividual, $observacionPedido, $totalOtrosCargos, $otrosCargos, $molCostoDobles, $molCostoCorte, $buenfintipopago
	)
	{
	    $r = new xajaxResponse();
	    
	    $r->mostrarAviso("ok ren 871");
	    
	    return $r;
	    
	}
	$xajax->registerFunction("lp");
	

	function levantarPedido($idClienteSeleccionado, $subtotalPedido, $ivaPedido, $descuentoPedido, $totalPedido, $tipoPrecioGalvamex ,$detalle, $recogeRecibe, $sucursalPreferencia, $strPersona, $strDireccion, $strNumero, $strColonia, $strCiudad, $fechaEntrega, $horaEntrega, $fechaAbierta, $pedidoExpress, $tipoPedido, $porDescuento, $maxDescuentoIndividual, $descuentoIndividual, $observacionPedido, $totalOtrosCargos, $otrosCargos, $molCostoDobles, $molCostoCorte, $buenfintipopago, $fechaEntregaPorDefinir, $tipoObra, $isCotizacion = false, $idCotizacion = 0, $clienteTipoRangoSeleccionado = 0, $getRangosString = "", $pasarAPedidoLaCotizacion = false, $previoAPasarPedidoACotizacion = false, $utilizarReciboDinero = false, $RDAmparaCotizacion = false, $RDATomar = 0, $idClienteDatosFacturacion = 0)
	{
		global $objSession;
		$r = new xajaxResponse();

		// $r->mostrarAviso("error line " . __LINE__); return $r;
		
	// 	if ($isCotizacion)
	// 	{
	// 		$r->mostrarAviso("Is Cotizacion  true " . $isCotizacion ); return $r;
	// 	}
	// 	else
	// {
	// 	$r->mostrarAviso("Is Cotizacion false " . $isCotizacion ); return $r;

	// }
		
		
		// $r->starDebug();
		$blnDoCommit=true;
		$idProductoMoldura = 386;
		$idProductoMaquila = 394;
		
		// $r->mostrarAviso("error line " . __LINE__); return $r;
// 		$r->mostrarAviso("error line 933"); return $r;
		
		$pedido = new ModeloPedido();
		$cotizacion = new ModeloCotizacion();
		if ($isCotizacion && $idCotizacion > 0)
		{
			$cotizacion->setIdCotizacion($idCotizacion);
			$lstDetalleCotizacionBorrar = $cotizacion->getDataSet("Select idCotizacionDetalle from cotizaciondetalle where idCotizacion = " . $idCotizacion);

			foreach ($lstDetalleCotizacionBorrar as $borrarcd) 
			{
				$cotidet = new ModeloCotizaciondetalle();
				$cotidet->setIdCotizacionDetalle($borrarcd["idCotizacionDetalle"]);

				$cotidet->Borrar();
			}

			$lstOtrosCargos = $cotizacion->getDataSet("Select idOtrosCargosCotizacion from otroscargoscotizacion where idCotizacion = ".$idCotizacion." order by idOtrosCargosCotizacion");
			foreach ($lstOtrosCargos as $borraroc)
            {
				$oc = new ModeloOtroscargoscotizacion();
				$oc->setIdOtrosCargosCotizacion($borraroc["idOtrosCargosCotizacion"]);

				$oc->Borrar();
			}
		}
		
		
        
		$strErrores = "";

// 		echo "ren 882";

		$idUsuario = $objSession->getIdUsuario();
		// 		4 = Christian 11 = Saul
		// $isCotizacion = false;
		
		if (!$isCotizacion)
		{
		    $pedido->setIdCliente($idClienteSeleccionado);
		    $pedido->setSubtotal($subtotalPedido);
		    $pedido->setIva($ivaPedido);
		    $pedido->setDescuento($descuentoPedido);
		    $pedido->setTotal($totalPedido);
		    $pedido->setSaldo($totalPedido);
		    
		    $pedido->setPersonaEntrega($strPersona);
		    $pedido->setRecogeentrega($recogeRecibe);
		    $pedido->setDomicilioEntrega($strDireccion);
		    $pedido->setNumeroEntrega($strNumero);
		    $pedido->setColoniaEntrega($strColonia);
		    $pedido->setCiudadEntrega($strCiudad);
		    $pedido->setTipo($tipoPedido);
		    $pedido->setIdSucursalPreferenciaRecoge($sucursalPreferencia);
		    $pedido->setRangosString($getRangosString);
		    
		    $pedido->setIdClienteDatosFacturacion($idClienteDatosFacturacion);
		    
		    if ($buenfintipopago == 99)
		    {
		        $pedido->setObservacionCaptura($observacionPedido . " **DESCUENTO BUEN FIN 2018: $ ". number_format($descuentoPedido,2) . "**");
		    }
		    else
		    {
		        $pedido->setObservacionCaptura($observacionPedido);
		    }
		    
		    
		    $pedido->setPorDescuento($porDescuento);
		    
		    $pedido->setMaxDescuentoIndividual($maxDescuentoIndividual);
		    $pedido->setDescuentoIndividual($descuentoIndividual);
		    $pedido->setOtrosCargos($totalOtrosCargos);
		    $pedido->setIdUsoCfdi($buenfintipopago);
		    
		    
		    
		    
		    $_fecha = date("Y-m-d");
		    
		    // if ($idUsuario == 18)
		    // {
		    //     $r->mostrarAviso(" despues _fecha  ". $_fecha);
	        // return $r;
	        // }
	        
	        //	$fechaLimite  = addDays($_fecha, 1, true);
	        $fechaLimite =$_fecha;
	        
	        // if ($idUsuario == 18)
	        //{
	        //    $r->mostrarAviso("todo bien aqui 950 ". $fechaLimite);
	            //     return $r;
	            // }
	            
            
            $pedido->setFecha_limitepago($fechaLimite);
            // 		echo "ren  922";
            
            if ($recogeRecibe == "RECOGE")
            {
                $pedido->setFechaCompromiso($fechaEntrega);
                // 			$r->mostrarAviso($horaEntrega);
            }
            
            if ($recogeRecibe == "OBRA" || $recogeRecibe == "ENTREGA" )
            {
                if ($fechaEntregaPorDefinir)
                {
                    $pedido->setFechaEntregaPorDefinirSI();
                }
                else
                {
                    $pedido->setFechaEntregaPorDefinirNO();
                    $pedido->setFechaCompromiso($fechaEntrega);
                }
                
                // 			$r->mostrarAviso($horaEntrega);
                $pedido->setTipoObra($tipoObra);
            }
            
            if ($recogeRecibe == "ENTREGA" || $recogeRecibe == "OBRA")
            {
                if ($horaEntrega != "NOSEL")
                {
                    $pedido->setHoraRecibe($horaEntrega);
                }
                
                if ($fechaAbierta == "SI")
                {
                    $pedido->setFechaAbiertaSI();
                }
                else
                {
                    $pedido->setFechaAbiertaNO();
                }
                
                if ($pedidoExpress == "SI")
                {
                    $pedido->setPedidoExpressSI();
                }
                else
                {
                    $pedido->setPedidoExpressNO();
                }
            }
            
            
            
            $pedido->setDateAndUser("capturado");
			$pedido->setFecha_updateprecios($pedido->getFecha_capturado());
            
            // if ($idUsuario == 11)
            // {
            //     $pedido->setEstadoAUTORIZADO();
            //     $pedido->setDateAndUser("autorizado");
            //     $pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO");
            // }
            
            //MDM se autoriza en automatico
            if ($idClienteSeleccionado == 137)
            {
                $pedido->setEstadoAUTORIZADO();
                $pedido->setDateAndUser("autorizado");
                $pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO MDM");
                
                
                
            }
            
            
            
            
            //         $r->mostrarAviso("antes de recorrer renglones"); return $r;
            //antes de guardar checamos que todo vayase a despacharse
            $blnStockInsuficiente = false;
            foreach ($detalle as $item)
            {
                
                
                $checarExistencia = false;
                
                
                if ($tipoPedido == "AT"	 )
                {
                    $checarExistencia = true;
                }
                
                
                
                if ($item["shortUnidad"] == "PZA" && $checarExistencia)
                {
                    $producto = new ModeloProducto();
                    
                    $idProducto = $item["idProducto"];
                    
                    $producto->setIdProducto($idProducto);
                    
                    if ($producto->getIdProducto() <= 0)
                    {
                        $strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode("No se ha podido obtener la informaci�n del Producto ".$item["fullDescripcion"].".");
                        $blnDoCommit = false;
                        break;
                    }
                    
                    $cantidadSolicitada = $item["cantidad"];
                    $existencia = $producto->getExistencia() - $producto->getApartadoReal();
                    
                    if ($existencia < $cantidadSolicitada)
                    {
                        $strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_decode("No hay suficiente Stock ( ".$existencia." ) para el Producto ".$item["fullDescripcion"].".");
                        $blnDoCommit = false;
                        $blnStockInsuficiente = true;
                        // 					$r->mostrarAviso("commit false no sufi " .($blnDoCommit ? "docommit" : "no commit") . " " . $strErrores);
                        
                        
                    }
                    
                    // 					$strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode($pedido->getStrError());
                }
                
            }
            
            //fin de antes de guardar checamos que todo vayase a despacharse
		            
		            
		}
		else //esto es una C O T I Z A C I O N
		{		    
// 		    $r->script("mdlExitWait(); ");
		    
		    
		    
		    $cotizacion->setIdCliente($idClienteSeleccionado);
		    $cotizacion->setSubtotal($subtotalPedido);
		    $cotizacion->setIva($ivaPedido);
		    $cotizacion->setDescuento($descuentoPedido);
		    $cotizacion->setTotal($totalPedido);
// 		    $cotizacion->setSaldo($totalPedido);
		    
		    
		    
		    $cotizacion->setPersonaEntrega($strPersona); 
		    $cotizacion->setRecogeentrega($recogeRecibe);
		    $cotizacion->setDomicilioEntrega($strDireccion);
		    $cotizacion->setNumeroEntrega($strNumero);
		    $cotizacion->setColoniaEntrega($strColonia);
		    $cotizacion->setCiudadEntrega($strCiudad); 
		    $cotizacion->setTipo($tipoPedido);
			$cotizacion->setIdSucursalPreferenciaRecoge($sucursalPreferencia);
			$cotizacion->setRangoCliente($clienteTipoRangoSeleccionado);
			$cotizacion->setRangosString($getRangosString);
		    
		    
		    
		    
		    if ($buenfintipopago == 99)
		    {
		        $cotizacion->setObservacionCaptura($observacionPedido . " **DESCUENTO BUEN FIN 2018: $ ". number_format($descuentoPedido,2) . "**");
		    }
		    else
		    {
		        $cotizacion->setObservacionCaptura($observacionPedido);
		    }
		    
		    
		    $cotizacion->setPorDescuento($porDescuento);
		    
		    $cotizacion->setMaxDescuentoIndividual($maxDescuentoIndividual);
		    $cotizacion->setDescuentoIndividual($descuentoIndividual);
		    $cotizacion->setOtrosCargos($totalOtrosCargos);
		    $cotizacion->setIdUsoCfdi($buenfintipopago);
		    
		    
		    
		    
		    $_fecha = date("Y-m-d");
		    
		    // if ($idUsuario == 18)
		    // {
		    //     $r->mostrarAviso(" despues _fecha  ". $_fecha);
		    // return $r;
		    // }
		    
		    //	$fechaLimite  = addDays($_fecha, 1, true);
		    $fechaLimite =$_fecha;
		    
		    // if ($idUsuario == 18)
		    //{
		    //    $r->mostrarAviso("todo bien aqui 950 ". $fechaLimite);
		        //     return $r;
		        // }
		        
		        
		    $cotizacion->setFecha_limitepago($fechaLimite);
	        // 		echo "ren  922";
	        
	        if ($recogeRecibe == "RECOGE")
	        {
	            $cotizacion->setFechaCompromiso($fechaEntrega);
	            // 			$r->mostrarAviso($horaEntrega);
	        }
	        
	        if ($recogeRecibe == "OBRA" || $recogeRecibe == "ENTREGA" )
	        {
	            if ($fechaEntregaPorDefinir)
	            {
	                $cotizacion->setFechaEntregaPorDefinirSI();
	            }
	            else
	            {
	                $cotizacion->setFechaEntregaPorDefinirNO();
	                $cotizacion->setFechaCompromiso($fechaEntrega);
	            }
	            
	            // 			$r->mostrarAviso($horaEntrega);
	            $cotizacion->setTipoObra($tipoObra);
	        }
	        
	        if ($recogeRecibe == "ENTREGA" || $recogeRecibe == "OBRA")
	        {
	            if ($horaEntrega != "NOSEL")
	            {
	                $cotizacion->setHoraRecibe($horaEntrega);
	            }
	            
	            if ($fechaAbierta == "SI")
	            {
	                $cotizacion->setFechaAbiertaSI();
	            }
	            else
	            {
	                $cotizacion->setFechaAbiertaNO();
	            }
	            
	            if ($pedidoExpress == "SI")
	            {
	                $cotizacion->setPedidoExpressSI();
	            }
	            else
	            {
	                $cotizacion->setPedidoExpressNO();
	            }
	        }
	        
	        
			if ($cotizacion->getIdCotizacion() == 0)
			{
				$cotizacion->setDateAndUser("capturado");
			}
			else
			{
				$cotizacion->setDate("update");
			}
	        
// 	        if ($idUsuario == 11)
// 	        {
// 	            $cotizacion->setEstadoAUTORIZADO();
// 	            $pedido->setDateAndUser("autorizado");
// 	            $pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO");
// 	        }
	        
// 	        //MDM se autoriza en automatico
// 	        if ($idClienteSeleccionado == 137)
// 	        {
// 	            $pedido->setEstadoAUTORIZADO();
// 	            $pedido->setDateAndUser("autorizado");
// 	            $pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO MDM");
	            
	            
	            
// 	        }
	        
	        
			
	        
	        
		}
        
		
		


// 		$r->mostrarAviso($pedido->Guardar()); return $r;
// 		$r->mostrarAviso("checando... err pedido"); return $r;
		if($blnDoCommit)
		{
// 		    echo "ren 1030";
		    
			$pedido->transaccionIniciar();
			// $r->mostrarAviso("Transaccion Iniciar");
// 			echo "<br>ren 1032 antes de guardar";

			$blnGuardarError = false;
			$strGuardarError = "";
			
			if (!$isCotizacion)
			{
    			$pedido->Guardar();	
    			$blnGuardarError = $pedido->getError();
    			$strGuardarError = $pedido->getStrError();
			}
			else
			{
				
				$cotizacion->Guardar();
				
			    $blnGuardarError = $cotizacion->getError();
			    $strGuardarError = $cotizacion->getStrError();
			}

			

			if ($blnGuardarError)
			{
				$strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode($strGuardarError);
				// 			$r->saError($pedido->getStrError());
				$blnDoCommit = false;
			}
			else
			{
				// 			$pedido->transaccionCommit();
				// 			$r->saSuccess("pedido ingresado"); return $r;


			    if (!$isCotizacion)
			    {
			        
    				$id_pedido = $pedido->getIdPedido();
    				$renglon = 0;
       
    				foreach ($detalle as $item)
    				{
    					$renglon++;
    
    					$checarExistencia = false;
    
    
    
    					$det = new ModeloPedidodetalle();
    
    
    
    					$det->setIdPedido($id_pedido);
    					$det->setRenglon($renglon);
    					$det->setIdProducto($item["idProducto"]);
    // 					$det->setTipoPrecio(getTipoPrecioForDetail($item["tipoPrecio"], $tipoPrecioGalvamex, $item["isRango"]));
                        $det->setTipoPrecio($item["tipoPrecioComision"]);
    					$det->setPartida($item["cantidad"]);
    					$det->setCantidad($item["cantUnidad"]);
    					$det->setCantidadReal($item["cantUnidadReal"]);
    					
    					$det->setPesoKiloML($item["rolloPesokiloml"]);
    					
    					if ($item["molIsScrap"] )
    					{
    					    $det->setMolIsScrapSI();
    					}
    					else 
    					{
    					    $det->setMolIsScrapNO();
    					}
    					
    					$det->setMolTotalcmScrap($item["molTotalCMScrap"]);
    					$det->setMolLongitudinal($item["molLongitudinal"]);
    					
    					//Molduras
    					if ($item["idProducto"]  == $idProductoMoldura)
    					{
    					    $det->setMolLaminasATomar($item["molLaminasATomar"]);
    // 					    $det->setMolPrecioDobleces(doubleval($item["cantidad"]) * $molCostoDobles * doubleval($item["dobleces"]));
    // 					    $det->setMolPrecioCorte(doubleval($item["cantidad"]) * $molCostoCorte );
    					    $det->setMolPrecioDobleces(doubleval($item["cantidad"]) * doubleval($item["molDobles"]) * doubleval($item["dobleces"]));
    					    $det->setMolPrecioCorte(doubleval($item["cantidad"]) * doubleval($item["molCorte"]));
    					    
    					}
    					
    					//Maquila
    					if ($item["idProducto"]  == $idProductoMaquila)
    					{
    //// 					    $det->setMolLaminasATomar($item["molLaminasATomar"]);
    // 					    $det->setMolPrecioDobleces(doubleval($item["cantidad"]) * $molCostoDobles * doubleval($item["dobleces"]));
    // 					    $det->setMolPrecioCorte(doubleval($item["cantidad"]) * $molCostoCorte );
    					    $descMaquila = str_replace("MAQUILA - ", "", $item["fullDescripcion"]);
    					    $det->setMolDescMaquila($descMaquila);
    					    $det->setMolPrecioDobleces(doubleval($item["cantidad"]) * doubleval($item["molDobles"]) * doubleval($item["dobleces"]));
    					    $det->setMolPrecioCorte(doubleval($item["cantidad"]) * doubleval($item["molCorte"]) );
    					    
    					}
    					
    					if (doubleval($item["kl"]) > 0)
    					{
    					    $det->setExplotarUnidad(doubleval($item["kl"]) / doubleval($item["cantidad"]));
    					    $det->setTotalExplotar( doubleval($item["kl"]));
    					}
    					else
    					{
    					    $det->setExplotarUnidad(1);
    					    $det->setTotalExplotar($det->getExplotarUnidad() * doubleval($item["cantidad"]));
    					}
    					
    					
    					
    					
     					//Curvar
     					
    					if ($item["curva"] != "")
    					{
    					    $det->setCurvarSI();
    					    $det->setCurvatura($item["curva"]);
    					}
    					
    					//Molduras
						$det->setIdRolloBase($item["idRollo"]);			
						    
    // 					$det->setComision($item["rangoRenglon"]);
    
    
    					if ($item["tipoPrecio"] != "0")
    					{
    						if ($item["tipoPrecio"] == "I")
    						{
    							$det->setDesarrollo($item["desarrolloI"]);
    						}
    						else
    						{
    							$det->setDesarrollo($item["desarrolloT"]);
    						}
    
    						$det->setDobleces($item["dobleces"]);
    					}
    
    					$det->setPrecioUnitario($item["precioRenglon"]);
    					$det->setTotal($item["totalRenglon"]);
    
    
    
    					$det->Guardar();
    					
    					
    					
    
    					// 				$pedido->transaccionRollback();
    					// 				$r->mostrarAviso("rollbackiamos despues guardar det");
    					// 				return $r;
    
    					if ($det->getError())
    					{
    						// 					$r->saError($det->getStrError());
    						$strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode($det->getStrError());
    						$blnDoCommit = false;
    						break;
    					}
    
    					
    				}
    				// 			$r->mostrarAviso("salir for " .$blnDoCommit);
			    }
			    else
			    {  // C O T I Z A C I O N
			        $id_pedido = $cotizacion->getIdCotizacion();
			        $renglon = 0;
			        
			        
			        
			        foreach ($detalle as $item)
			        {
			            $renglon++;
			            
			            $checarExistencia = false;
			            
			            
			            
			            $cdet = new ModeloCotizaciondetalle();
			            
			            
			            
			            $cdet->setIdCotizacion($id_pedido);
			            $cdet->setRenglon($renglon);
			            $cdet->setIdProducto($item["idProducto"]);
			            // 					$det->setTipoPrecio(getTipoPrecioForDetail($item["tipoPrecio"], $tipoPrecioGalvamex, $item["isRango"]));
			            $cdet->setTipoPrecio($item["tipoPrecioComision"]);
			            $cdet->setPartida($item["cantidad"]);
			            $cdet->setCantidad($item["cantUnidad"]);
			            $cdet->setCantidadReal($item["cantUnidadReal"]);
			            
			            $cdet->setPesoKiloML($item["rolloPesokiloml"]);
			            
			            if ($item["molIsScrap"] )
			            {
			                $cdet->setMolIsScrapSI();
			            }
			            else
			            {
			                $cdet->setMolIsScrapNO();
			            }
			            
			            $cdet->setMolTotalcmScrap($item["molTotalCMScrap"]);
			            $cdet->setMolLongitudinal($item["molLongitudinal"]);
			            
			            //Molduras
			            if ($item["idProducto"]  == $idProductoMoldura)
			            {
			                $cdet->setMolLaminasATomar($item["molLaminasATomar"]);
			                // 					    $det->setMolPrecioDobleces(doubleval($item["cantidad"]) * $molCostoDobles * doubleval($item["dobleces"]));
			                // 					    $det->setMolPrecioCorte(doubleval($item["cantidad"]) * $molCostoCorte );
			                $cdet->setMolPrecioDobleces(doubleval($item["cantidad"]) * doubleval($item["molDobles"]) * doubleval($item["dobleces"]));
			                $cdet->setMolPrecioCorte(doubleval($item["cantidad"]) * doubleval($item["molCorte"]));
			                
			            }
			            
			            //Maquila
			            if ($item["idProducto"]  == $idProductoMaquila)
			            {
			                //// 					    $det->setMolLaminasATomar($item["molLaminasATomar"]);
			                // 					    $det->setMolPrecioDobleces(doubleval($item["cantidad"]) * $molCostoDobles * doubleval($item["dobleces"]));
			                // 					    $det->setMolPrecioCorte(doubleval($item["cantidad"]) * $molCostoCorte );
			                $descMaquila = str_replace("MAQUILA - ", "", $item["fullDescripcion"]);
			                $cdet->setMolDescMaquila($descMaquila);
			                $cdet->setMolPrecioDobleces(doubleval($item["cantidad"]) * doubleval($item["molDobles"]) * doubleval($item["dobleces"]));
			                $cdet->setMolPrecioCorte(doubleval($item["cantidad"]) * doubleval($item["molCorte"]) );
			                
						}
						
			            
			            if (doubleval($item["kl"]) > 0)
    					{
    					    $cdet->setExplotarUnidad(doubleval($item["kl"]) / doubleval($item["cantidad"]));
    					    $cdet->setTotalExplotar( doubleval($item["kl"]));
    					}
    					else
    					{							
							$cdet->setExplotarUnidad(1);							
    					    $cdet->setTotalExplotar($cdet->getExplotarUnidad() * doubleval($item["cantidad"]));
    					}
			            
			            
// 			            $r->script("mdlExitWait(); ");
// 			            $r->mostrarAviso("todo bien 1536"); return $r;
			            
			            //Curvar
			            
			            if ($item["curva"] != "")
			            {
			                $cdet->setCurvarSI();
			                $cdet->setCurvatura($item["curva"]);
						}
						
			            
			            //Molduras
						$cdet->setIdRolloBase($item["idRollo"]);
						$cdet->setMolCalibre($item["rolloCalibre"]);
						$cdet->setMolIdMaterial($item["rolloIdMaterial"]);

						// $r->mostrarAviso("TODO BIEN " . __LINE__); return $r;
			            
			            // 					$det->setComision($item["rangoRenglon"]);
			            
			            
			            if ($item["tipoPrecio"] != "0")
			            {
			                if ($item["tipoPrecio"] == "I")
			                {
			                    $cdet->setDesarrollo($item["desarrolloI"]);
			                }
			                else
			                {
			                    $cdet->setDesarrollo($item["desarrolloT"]);
			                }
			                
			                $cdet->setDobleces($item["dobleces"]);
			            }
			            
			            $cdet->setPrecioUnitario($item["precioRenglon"]);
			            $cdet->setTotal($item["totalRenglon"]);
						$cdet->setPrecio1($item["precio1"]);
						$cdet->setPrecio2($item["precio2"]);
						$cdet->setPrecio3($item["precio3"]);
						$cdet->setPrecio4($item["precio4"]);
						$cdet->setPreciomendez($item["preciomendez"]);
			            
			            
			            $cdet->Guardar();
			            
			            
			            
			            
			            // 				$pedido->transaccionRollback();
			            // 				$r->mostrarAviso("rollbackiamos despues guardar det");
			            // 				return $r;
			            
			            if ($cdet->getError())
			            {
			                // 					$r->saError($det->getStrError());
			                $strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode($cdet->getStrError());
			                $blnDoCommit = false;
			                break;
			            }
			            
			            
			        }
			    }
				
// 				Otros Cargos
// 				$id_pedido
// $r->starDebug();
                

				
                if (!$isCotizacion)
                {
                    foreach ($otrosCargos as $oc)
                    {
                        //                     $r->mostrarAviso("oc: " . $oc["id"] . " - " . $oc["monto"]);
                        
                        $montooc = $oc["monto"];
                        if ($montooc != "")
                        {
                            if (doubleval($montooc) > 0)
                            {
                                $ocp = new ModeloOtroscargospedido();
                                
                                $ocp->setIdPedido($id_pedido);
                                $ocp->setIdOtroCargo($oc["id"]);
                                //                             cantidad
                                $ocp->setCantidadIngreso($oc["cantidad"]);
                                $ocp->setMonto($montooc);
                                
                                $ocp->Guardar();
                                
                                if ($ocp->getError())
                                {
                                    // 					$r->saError($det->getStrError());
                                    $strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode($ocp->getStrError());
                                    $blnDoCommit = false;
                                    break;
                                }
                                
                                
                            }
                        }
                        
                        
                        
                    }
                }
                else
                {
					
                    foreach ($otrosCargos as $oc)
                    {
                        //                     $r->mostrarAviso("oc: " . $oc["id"] . " - " . $oc["monto"]);
						
						
                        $montooc = $oc["monto"];
                        if ($montooc != "")
                        {
                            if (doubleval($montooc) > 0)
                            {
                                $ocp = new ModeloOtroscargoscotizacion();
                                
                                $ocp->setIdCotizacion($id_pedido);
                                $ocp->setIdOtroCargo($oc["id"]);
                                //                             cantidad
                                $ocp->setCantidadIngreso($oc["cantidad"]);
                                $ocp->setMonto($montooc);
                                
                                $ocp->Guardar();
                                
                                if ($ocp->getError())
                                {
                                    // 					$r->saError($det->getStrError());
                                    $strErrores .= ($strErrores == "" ? "" : "<br>") . utf8_encode($ocp->getStrError());
                                    $blnDoCommit = false;
                                    break;
                                }
                                
                                
                            }
                        }
                        
                        
                        
                    }
                }
// 				$r->endDegug(); return $r;
// 				Fin Otros Cargos

                
                
                
                
				if ($blnDoCommit)
				{
				    
					if ($pasarAPedidoLaCotizacion)
					{
						if ($cotizacion->pasarCotizacionAPedido($cotizacion->getIdCotizacion()))
						{
							$r->script("
							mdlExitWait();
							
							app.wasCotizacion = true;
							app.wasPedido = true;
							app.isCotiPedido = true;
							app.pedidoFolio = ". $cotizacion->getIdPedido() .";
							app.idCotizacion = ". $id_pedido .";
							app.vistaPedido = false;
							app.secCotizacionAPedido = false;
							app.imprimirPedido = true;
							$('#secImprimirONuevo').show();
							app.mostrarBotonGuardar = true;
							saSuccess(\"La Cotización ha sido Actualizada y se ha convertido como Pedido satisfactoriamente.\");
	
							app.cargarListaCotizaciones();
							

							");

							if ($utilizarReciboDinero)
							{
								if ($RDAmparaCotizacion)
								{
									$r->script("setTimeout(function () { 
										mdlShowWait();
										xajax_pagarConReciboDinero(app.pedidoFolio, ". $RDATomar .", true);
									 }, 1200);");
								}
								else
								{
									$r->script("setTimeout(function () { 
										mdlShowWait();
										xajax_pagarConReciboDinero(app.pedidoFolio, ". $RDATomar .", false);
									 }, 1200);");
									
								}

							}

                            $r->script("setTimeout(function () { app.verificarDisponiblePagoPedido();}, 13  00);");
						}
						else
						{
							$r->script("
							mdlExitWait();
	
							alert('No se pudo convertir la Cotizacion a Pedido, intente de nuevo mas tarde o notifique al Administrador del Sistema.');
							app.wasCotizacion = ".($isCotizacion ? "true" : "false").";
							app.wasPedido = false;
							app.pedidoFolio = ". $id_pedido .";
							app.idCotizacion = ". $id_pedido .";
							app.isCotiPedido =false;
							app.vistaPedido = false;
							app.secCotizacionAPedido = false;
							app.imprimirPedido = true;
							$('#secImprimirONuevo').show();
							app.mostrarBotonGuardar = true;".(!$isCotizacion ? "saSuccess(\"El Pedido ha sido generado satisfactoriamente.\");" : "saSuccess(\"La Cotización ha sido generada satisfactoriamente.\");")."
	
							app.cargarListaCotizaciones();
							

							");
						}

						
					}
					else
					{
						if ($previoAPasarPedidoACotizacion)
						{
							$cotizacionPuedeSurtirse = new ModeloCotizacion();

							// echo $pedido->getlogCliente($param1);

							$cotizacionPuedeSurtirse->__isDebugging =false;
							$cotiSurtir = $cotizacionPuedeSurtirse->verificarSiCotizacionPuedeSurtirseParaPasarAPedido($idCotizacion);					

							$pushPuedeSurtirse = "";
							$RDNoSeSurteTodo = "false";

							
							foreach($cotiSurtir["Surtir"] as $s)
							{
								$pushPuedeSurtirse .= "app.listadoPedidoPuedeSurtirse.push ({renglon: ".$s["renglon"].", puedeSurtirse: 'SI'});";
							}

							foreach($cotiSurtir["NoSurtir"] as $s)
							{
								$pushPuedeSurtirse .= "app.listadoPedidoPuedeSurtirse.push ({renglon: ".$s["renglon"].", puedeSurtirse: 'NO'});";
								$RDNoSeSurteTodo = "true";
							}

							$datosRD = $cotizacionPuedeSurtirse->getDataSet("
										SELECT getSaldoReciboDinero(idcliente) saldoRD,
												id_usuario_autorizaimpresion,
												cotizacionHaCambiadoDePrecio(idcotizacion) haCambiadoPrecioCotizacion, 
												getSaldoReciboDinero0A30Dias(idcliente, DATE_FORMAT(fecha_capturado, '%Y-%m-%d')) saldoRD030,
												getSaldoReciboDinero31A60Dias(idcliente, DATE_FORMAT(fecha_capturado, '%Y-%m-%d')) saldoRD3160,
												getSaldoReciboDineroMas60Dias(idcliente, DATE_FORMAT(fecha_capturado, '%Y-%m-%d')) saldoRDmas60
										FROM cotizacion
										WHERE idcotizacion = " . $idCotizacion);

							$saldosRD = "";

							if (count($datosRD) > 0)
							{
								$saldosRD = "
									app.saldoRD = ".$datosRD[0]["saldoRD"].";	
									app.haCambiadoPrecioCotizacion = '".$datosRD[0]["haCambiadoPrecioCotizacion"]."';
									app.saldoRD030 = ".$datosRD[0]["saldoRD030"].";
									app.saldoRD3160 = ".$datosRD[0]["saldoRD3160"].";
									app.saldoRDmas60 = ".$datosRD[0]["saldoRDmas60"].";		
									app.id_usuario_autorizaimpresion = ".$datosRD[0]["id_usuario_autorizaimpresion"].";
									setTimeout(function() {  app.RDDebeActualizarPrecios = (app.totalPedido > app.RDTotalAAmparar ? true : false); }, 200);
									app.RDNoSeSurteTodo = ".$RDNoSeSurteTodo.";
								";

							}



							$r->script("
							mdlExitWait();
							app.wasCotizacion = ".($isCotizacion ? "true" : "false").";
							app.wasPedido = ".(!$isCotizacion ? "true" : "false").";
							app.pedidoFolio = ". $id_pedido .";
							app.idCotizacion = ". ($isCotizacion ? $id_pedido : "0") .";
							app.vistaPedido = false;
							app.secCotizacionAPedido = true;
							app.imprimirPedido = false;
							//$('#secImprimirONuevo').show();
							app.mostrarBotonGuardar = true; ".(!$isCotizacion ? "saSuccess(\"El Pedido ha sido generado satisfactoriamente.\");" : "saSuccess(\"La Cotización ha sido actualizada satisfactoriamente.\");")."
	
							app.listadoPedidoPuedeSurtirse.splice(0, app.listadoPedidoPuedeSurtirse.length);

							".$pushPuedeSurtirse.  $saldosRD. "
							
							app.cargarListaCotizaciones();
							".(!$isCotizacion ? "setTimeout(function () { app.verificarDisponiblePagoPedido();}, 1000);" : "")."
							setTimeout( function() { app.indicarSiPuedeONoSurtirseCotizacion(); }, 1200);
							");
						}
						else
						{
							$r->script("
								mdlExitWait();
								app.wasCotizacion = ".($isCotizacion ? "true" : "false").";
								app.wasPedido = ".(!$isCotizacion ? "true" : "false").";
								app.pedidoFolio = ". $id_pedido .";
								app.idCotizacion = ". ($isCotizacion ? $id_pedido : "0") .";
							
								
								app.isCotiPedido =false;
								app.vistaPedido = false;
								app.secCotizacionAPedido = false;
								app.imprimirPedido = true;
								$('#secImprimirONuevo').show();

								app.mostrarBotonGuardar = true;".(!$isCotizacion ? "saSuccess(\"El Pedido ha sido generado satisfactoriamente.\");" : "saSuccess(\"La Cotización ha sido generada satisfactoriamente.\");")."
		
								app.cargarListaCotizaciones();
								".(!$isCotizacion ? "setTimeout(function () { app.verificarDisponiblePagoPedido();}, 1000);" : "")."
								");

						}


							
					}


					
				}

			}

			if ($blnDoCommit)
			{
							// $r->mostrarAviso("commit");
				$pedido->transaccionCommit();
			    if (!$isCotizacion) $pedido->NotificaAltaPedido();
			    
			    
				
			}
			else
			{
							// $r->mostrarAviso("rollback");
				$pedido->transaccionRollback();
				$r->script(" mdlExitWait(); app.cargarListaCotizaciones(); app.mostrarBotonGuardar = true;");
				$r->saError($strErrores);

			}

		}
		else
		{
// 			$r->mostrarAviso("checando... voy a ver aqui"); return $r;
			if ($blnStockInsuficiente)
			{
// 				$r->mostrarAviso("checando... stock insuficiente aqui, jo"); return $r;

// 				$r->mostrarAviso("no se que pasa aqui");

				$r->script("mdlExitWait(); app.cargarListaCotizaciones(); app.mostrarBotonGuardar = true;");

// 				$r->mostrarAviso($strErrores);

// 				//$r->saError($strErrores);
				$r->script("
                            
							app.levantarPedidoSinChecarStock(\"".utf8_encode($strErrores)."\");

						");
			}
			else
			{
				$r->script("mdlExitWait(); app.cargarListaCotizaciones(); app.mostrarBotonGuardar = true;");
				$r->saError($strErrores);
			}

		}


// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("levantarPedido");


//     Alta Cliente

	function setPromotor()
	{
	    $r = new xajaxResponse();
	    
	    if (Permisos::getRolInBinary() == Permisos::$rol_PROMOTOR || permisos::getRolInBinary() == Permisos::$rol_PROMOTORPRODUCCION)
	    {
	        $r->script("
					app.usuarioPromotor = '" . ModeloUsuario::getObjSession()->getIdUsuario() . "';
					app.mostrarUsuarioPromotor = false;
	            
				  ");
	    }
	    
	    return $r;
	}
	$xajax->registerFunction("setPromotor");
	
	function guardarCliente($idCliente, $nombre, $apellidos, $empresa, $domicilio1, $domicilio2, $numero, $colonia, $ciudad, $telefonos, $email, $rfc, $estado, $idUsuarioPromotor, $facturable, $razonSocial, $domicilioFiscal, $cp, $usoCFDI)
	{
	    global $_NOW_;
	    global $objSession;
	    
	    $r = new xajaxResponse();
	    
	    // 		$r->starDebug();
	    
	    $cliente = new ModeloCliente();
	    $isInsert = false;
	    $regresar = false;
	    
	    if ($cliente->existeField("concat(nombre,apellidos)", $nombre.$apellidos, $idCliente))
	    {
	        $r->script("app.errUsername = \"". utf8_encode("Al parecer este Cliente ya esta en el sistema. Favor de verificar.") ."\"; ");
	        $regresar = true;
	    }
	    
	    
	    if ($email != "")
	    {
	        if ($cliente->existeField("email", $email, $idCliente))
	        {
	            $r->script("app.errEmail = \"". utf8_encode("Este email ya esta siendo utilizado. Debe especificar uno diferente.") ."\"; ");
	            $regresar = true;
	        }
	    }
	    
	    
	    if ($regresar)
	    {
	        return $r;
	    }
	    
	    if ($idCliente == 0)
	    {
	        $isInsert = true;
	        $cliente->setDateUserCreating();
	    }
	    else
	    {
	        $cliente->setIdCliente($idCliente);
	        $cliente->setDateUserUpdating();
	    }
	    
	    //
	    
	    $cliente->setNombre($nombre);
	    $cliente->setApellidos($apellidos);
	    $cliente->setEmpresa($empresa);
	    $cliente->setDomicilio1($domicilio1);
	    $cliente->setDomicilio2($domicilio2);
	    $cliente->setNumero($numero);
	    $cliente->setColonia($colonia);
	    $cliente->setCiudad($ciudad);
	    $cliente->setTelefonos($telefonos);
	    $cliente->setEmail($email);
	    $cliente->setRfc($rfc);
	    
	    $cliente->setEstadoACTIVO();
	    $cliente->setIdUsuarioPromotor($idUsuarioPromotor);
	    
	    if ($facturable)
	    {
	        $cliente->setFacturableSI();
	    }
	    else
	    {
	        $cliente->setFacturableNO();
	    }
	    
	    $cliente->setRazonsocial($razonSocial);
	    $cliente->setDomiciliofiscal($domicilioFiscal);
	    $cliente->setCodigopostal($cp);
	    $cliente->setIdUsoCfdi($usoCFDI);
	    
	    
	    $cliente->Guardar();
	    
	    if ($cliente->getError())
	    {
	        $r->saError($cliente->getStrError() );
	        return $r;
	    }
	    
	    if ($isInsert)
	    {
	        $r->saSuccess("El Cliente " .$nombre . " " . $apellidos . " se ha almacenado satisfactoriamente. Id: " .$cliente->getIdCliente(). ". Se ha agregado al Pedido." );
// 	        $r->redirect(URL_BASE . "cliente",1);

	        $r->script(" setTimeout(function() {console.log('cargamos clientes de nuevo'); xajax_cargarClientes(); }, 150); setTimeout(function(){ console.log('seleccionamos al cliente pue'); app.setClienteSelected(". $cliente->getIdCliente() .");}, 250);  ");    
	        
	    }
	    else
	    {
	        $r->saSuccess("El Cliente " .$nombre . " se ha modificado satisfactoriamente." );
	        $r->redirect(URL_BASE . "cliente",1);
	    }
	    
	    
	    
	    // $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("guardarCliente");
	
	
	
	
	function verificaSiHayStock($index, $idMaterial, $idAplicacion, $idRollo, $cantUnidad)
	{
	    $r = new xajaxResponse();
	    
	    $vp = new ModeloViewproductos();
	    
// 	    $r->starDebug();
	    
	    $lst = $vp->getAll("idProducto, codigo, mlpieza, descauto, existencia, apartado, (existencia - apartado) as disponible",
	                       "",
	                       "
                                 idmaterial = ".$idMaterial."
                                 and idaplicacion = ".$idAplicacion."
                                 and estado = 'ACTIVO'
                                 AND shortUnidad = 'PZA'
                                 and idRollo = ".$idRollo." 
                                 and mlpieza between (".$cantUnidad." * .95) and (".$cantUnidad." * 1.05) 
                                 and (existencia - apartado) > 0
                            ");
	    
// 	    $r->mostrarAviso($vp->getAllQUERY("idProducto, codigo, mlpieza, descauto, existencia, apartado, (existencia - apartado) as disponible",
// 	        "",
// 	        "
//                                  idmaterial = ".$idMaterial."
//                                  and idaplicacion = ".$idAplicacion."
//                                  and estado = 'ACTIVO'
//                                  AND shortUnidad = 'PZA'
//                                  and idRollo = ".$idRollo."
//                                  and mlpieza between (".$cantUnidad." * .95) and (".$cantUnidad." 1.05)
//                             "));
	    
	    $push = "";
	    
	    foreach ($lst as $row)
	    {
	        
	        $push .= "	        
	                   app.listadoPedido[".$index."].sugerirStock.push({
	        					idProducto: ".$row["idProducto"].",
	        					codigo: '".$row["codigo"]."',
	        					mlpieza: ".$row["mlpieza"].",
	        					descauto: '".$row["descauto"]."',
	        					disponible: ".$row["disponible"]."
	        				});
                    ";
	    }
	    
	    
	    $r->script("app.listadoPedido[".$index."].sugerirStock.splice(0, app.listadoPedido[".$index."].sugerirStock.length); ". $push);
// 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("verificaSiHayStock");
	
	
	function mostrarInventarioStock($index, $idProducto)
	{
	    $r = new xajaxResponse();
	    
	    $invsuc = new ModeloInventariosucursal();
	    
	    // 	    $r->starDebug();
	    
	    $lst = $invsuc->getAll(" sucursal.nombre sucursal, inventariosucursal.existencia, inventariosucursal.apartado, (inventariosucursal.existencia - inventariosucursal.apartado) disponible  ",
	        "inner join sucursal on inventariosucursal.idsucursal = sucursal.idsucursal",
	        " sucursal.visible = 'SI' AND inventariosucursal.idproducto = ". $idProducto ."
                 ");
	    	    
	    $push = "";

	    foreach ($lst as $row)
	    {
	        
	        $push .= "
	                   app.listadoPedido[".$index."].inventarioSucursal.push({
	        					sucursal: '".$row["sucursal"]."',
	        					existencia: ".$row["existencia"].",
	        					apartado: ".$row["apartado"].",
	        					disponible: ".$row["disponible"]."
	        				});
                    ";
	    }

		$query = "
			SELECT ifnull(sum(pd.partida - pd.partidaDespachada),0) noasignados
			FROM pedidodetalle pd 
			INNER join pedido p on p.idpedido = pd.idPedido 
			AND p.apartarMercancia = 'SI' 
			LEFT JOIN pedidodetallecolocacion pdc on pd.idpedidodetalle = pdc.idpedidodetalle and pdc.cantidad > 0 
			INNER JOIN producto on pd.idProducto = producto.idProducto 
			WHERE p.estado in ('CAPTURADO', 'AUTORIZADO', 'PRODUCCION') 
			AND pd.despachado = 'NO' 
			AND pd.idproducto = ".$idProducto ."
			AND pdc.idSucursal is null 
		";

		$noas = $invsuc->getDataSet($query);

		if (count($noas) > 0)
		{
			if (intval($noas[0]["noasignados"]) > 0)
			{
				$push .= "
							app.listadoPedido[".$index."].inventarioSucursal.push({
										sucursal: 'NOASIGNADOS',
										existencia: ".$noas[0]["noasignados"]." ,
										apartado: 0 ,
										disponible: 0
									});
							";
				
			}
		}

	    
	    $r->script("app.listadoPedido[".$index."].inventarioSucursal.splice(0, app.listadoPedido[".$index."].inventarioSucursal.length); ". $push);
	    // 	    $r->endDegug();
	    return $r;
	}
	$xajax->registerFunction("mostrarInventarioStock");

	function cargarListaCotizaciones()
	{
		global $objSession;

		$r = new xajaxResponse();

		$query = "SELECT c.idCotizacion, c.idCliente, c.total, c.id_usuario_capturado, DATE_FORMAT(c.fecha_capturado,'%d/%m/%Y %H:%i') fecha_capturado, DATEDIFF(CURDATE(), c.fecha_capturado) AS days,
					c.recogeentrega, concat(cl.nombre, ' ', cl.apellidos) nombreCliente           
					FROM cotizacion c
					INNER JOIN cliente cl
					ON c.idCliente = cl.idCliente
					WHERE c.id_usuario_capturado = " . $objSession->getIdUsuario() . " AND c.idPedido = 0 AND c.estado = 'CAPTURADO' ";

		$cotizacion = new ModeloCotizacion();

		$lst = $cotizacion->getDataSet($query);

		$pushes = "";
		$diasParaVencer = 90;

		foreach ($lst as $item ) 
		{
			$days = $item["days"];
			$diasRestantes = $diasParaVencer - $days;
			$porcentajeVigencia = 100 - (100 * ($days - 1) / $diasParaVencer);

			if ($porcentajeVigencia > 50.0)
			{
				$tipoProgress = "success";
			}
			else if ($porcentajeVigencia > 25.0) 
			{
				$tipoProgress = "warning";
			}
			else 
			{
				$tipoProgress = "danger";
			}
			
			if ($porcentajeVigencia > 0)
			{
				$pushes .= "
					app.listaCotizaciones.push ({
						idCotizacion: ".$item["idCotizacion"].", 
						idCliente: ".$item["idCliente"].", 
						total: ".$item["total"].", 
						id_usuario_capturado: ".$item["id_usuario_capturado"].", 
						fecha_capturado: '".$item["fecha_capturado"]."', 
						days: ".$item["days"].",
						recogeentrega: '".$item["recogeentrega"]."', 
						nombreCliente: '".$item["nombreCliente"]."',
						diasRestantes: ".$diasRestantes.",
						porcentajeVigencia: ".$porcentajeVigencia.",
						tipoProgress: '".$tipoProgress."'   
	
					});
				
				";

			}
		}

		
		$r->script(" app.listaCotizaciones.splice(0, app.listaCotizaciones.length);  ".$pushes);

		return $r;
	}
	$xajax->registerFunction("cargarListaCotizaciones");
	
	function verificarDisponiblePagoPedido($idPedido)
	{
		$r = new xajaxResponse();

		$pedido = new ModeloPedido();

		$sql = "SELECT idPedido, CONCAT(cliente.nombre, ' ', cliente.apellidos) nombreCliente, pedido.saldo, getSaldoReciboDinero(pedido.idCliente) disponibleRD
				FROM pedido
				INNER JOIN cliente ON cliente.idCliente = pedido.idCliente
				WHERE idPedido = " . $idPedido;

		$ds = $pedido->getDataSet($sql);


		if (count($ds) > 0)
		{
			$script = "
			app.rdDisponible = ".$ds[0]["disponibleRD"].";
			app.rdTotalPedido = ".$ds[0]["saldo"].";			
			app.rdCliente = '".$ds[0]["nombreCliente"]."';
			
			";

			$r->script($script);
		}


		$r->script("mdlExitWait();");

		return $r;
	}
	$xajax->registerFunction("verificarDisponiblePagoPedido");

	function pagarConReciboDinero($idPedido, $abonoMonto, $autorizarAutomatico = false)
	{
		$r = new xajaxResponse();

		$pedido = new ModeloPedido();

		$pedido->setIdPedido($idPedido);
		$msg = "";
		$pagado = $pedido->pagarConReciboDinero($abonoMonto, $msg);

		if ($pagado)
		{
			$r->saSuccess($msg);
		}
		else
		{
			$r->saError($msg);
		}
		
		if ($autorizarAutomatico)
		{
			$pedido->setIdPedido($idPedido);

			// if ($pedido->getEstado() == "CAPTURADO" )
			if ($pedido->getIdPedido() > 0 )
			{
				$pedido->setEstadoAUTORIZADO();
				$pedido->setPlanProteccionSI();
				$pedido->setDateAndUser("autorizado");
				$pedido->setObservacionAutoriza("AUTORIZADO POR PAGO RECIBO DE DINERO");
				$pedido->Guardar();

				$pedido->NotificaAutorizacionAutomaticaPedido();

				// $r->script(" alert('pagado automatico'); ");
			}
		}

		$r->script(" mdlExitWait(); app.verificarDisponiblePagoPedido(); ");

		return $r;
	}
	$xajax->registerFunction("pagarConReciboDinero");

    function handleProductoFavorito($idProducto, $favorito)
	{
        global $objSession;
		$r = new xajaxResponse();
        // $r->starDebug();
        $productos = new ModeloViewproductos();

        $query = "update favorito set favorito = '".$favorito."' where idProducto = ". $idProducto." and idUsuario = " . $objSession->getIdUsuario();

        // $r->mostrarAviso($query); return $r;
        $productos->executeRaw($query);
        // $r->mostrarAviso($query);

        // $r->endDegug();
        return $r;
    }
    $xajax->registerFunction("handleProductoFavorito");
	
	$xajax->processRequest();

	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Procesamiento de formulario----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#


	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Inicializacion de variables----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#


	#----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------Salida de Javascript-------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#

	
	$promotor = new ModeloUsuario();
	
	$lstPromotores = $promotor->getForSelect("idUsuario", "nombre", "idRol IN (4,2, 8) AND estatus = 'activo' ");
	
// 	$material = new ModeloMaterial();
	
// 	$lstMateriales = $material->getForSelect("idMaterial", "concat(clave, ' - ', nombre)", "estado = 'ACTIVO'");
	
	
	
	$uso = new ModeloUsocfdi();
	
	$lstUsoCFDI = $uso->getForSelect("idUsoCfdi", "concat(clave,' - ',descripcion)", "");
	
	$sucursales = new ModeloSucursal();
	
	$lstSucursales = $sucursales->getAll("","","visible = 'SI'");
	
// 	$fecha = date_create();
// 	echo date_timestamp_get($fecha);