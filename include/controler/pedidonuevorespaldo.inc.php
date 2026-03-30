<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.precioxdobles.inc.php";
	require_once FOLDER_MODEL. "model.pedido.inc.php";
	require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
	require_once FOLDER_MODEL. "model.configuracion.inc.php";

// 	require_once FOLDER_MODEL. "model.pedido.inc.php";

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

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

	function verificaPromotor()
	{
		global $objSession;
		$r = new xajaxResponse();

		if ($objSession->getIdUsuario() == 10 || $objSession->getIdUsuario() == 15)
		{
			// $r->mostrarAviso("validar");
			$valores = " app.calcularRangosPrecios = false; ";
			if ($objSession->getIdUsuario() == 15)
			{
				$valores .= " app.maxTipoPrecioGalvamex = 3; ";
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
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
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
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
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
		                                       promotor: '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."'
					                                      });";
		}

		$r->script("
				  app.clientes.splice(0, app.clientes.length);
				" .
				$strClientes . " app.cargarRangos(); setTimeout(function(){ app.setClienteSelected(".$idCliente."); }, 50); ");

		return $r;
	}
	$xajax->registerFunction("cargarClienteMostador");

	function cargarClienteById($idCliente)
	{
		$r = new xajaxResponse();


		$clientes = new ModeloCliente();

		$lst = $clientes->getAll("cliente.idUsuarioPromotor, cliente.idCliente, cliente.nombre, cliente.apellidos, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
				                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" idCliente = " . $idCliente);

		$strClientes = "";

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
		                    app.promotorClienteSeleccionado = '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."';";
		}

// 		$r->saSuccess($strClientes); return $r;

		$r->script($strClientes . "  toastr.info('Datos del Cliente actualizados','Pedido'); app.cargarRangos(); setTimeout(function() {app.calculaTotales();}, 500); ");

		return $r;
	}
	$xajax->registerFunction("cargarClienteById");

	function cargarTiposProducto()
	{
		$r = new xajaxResponse();

		$tipos = new ModeloTipoproducto();

		$lst = $tipos->getAll();

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

	function cargarRangos($idUsuarioPromotor)
	{
		global $objSession;
		$r = new xajaxResponse();

		$con = new ModeloConfiguracion();
		$usr = new ModeloUsuario();

		$con->setIdConfiguracion(1);

		if ($con->getIdConfiguracion() <= 0)
		{
			$r->saError("No se ha podido obtener la Configuraci�n de Rangos.");
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
		}
		else if($rangoComision == "MEDIO")
		{
			$comisiones .= " app.comisionR1 = '" . $con->getComision2R1() . "'; ";
			$comisiones .= " app.comisionR2 = '" . $con->getComision2R2() . "'; ";
			$comisiones .= " app.comisionR3 = '" . $con->getComision2R3() . "'; ";
		}
		else
		{
			$comisiones .= " app.comisionR1 = " . $con->getComision3R1() . "; ";
			$comisiones .= " app.comisionR2 = " . $con->getComision3R2() . "; ";
			$comisiones .= " app.comisionR3 = " . $con->getComision3R3() . "; ";
		}

		$r->script("

				app.rango1Fin = ".$con->getRangoMetros1Fin().";
				app.rango2Inicio = ".$con->getRangoMetros2Inicio().";
				app.rango2Fin = ".$con->getRangoMetros2Fin().";
				app.rango3Inicio = ".$con->getRangoMetros3Inicio().";

				app.maxDescuentoIndividual = " . $con->getPedidoDescuento() .";

				" . $comisiones);



		return $r;
	}
	$xajax->registerFunction("cargarRangos");


	function cargarListaProductos()
	{
		$r = new xajaxResponse();

		$productos = new ModeloViewproductos();

		$productos->getAllView();

		$strListadoProductos = "";


		for($i = 0 ; $i <count($productos->lstProductos) ; $i++)
		{
			if ($productos->lstProductos[$i]->getEstado() == "ACTIVO")
			{
				$desc=str_replace(chr(13),'', $productos->lstProductos[$i]->getRolloDescripcion());
				$desc=str_replace('<br />','\n', $desc);
				$desc=str_replace(chr(10),'', $desc);

				$descProducto=str_replace(chr(13),'', $productos->lstProductos[$i]->getDescripcion());
				$descProducto=str_replace('<br />','\n', $descProducto);
				$descProducto=str_replace(chr(10),'', $descProducto);



				$strListadoProductos .= "
					app.productos.push({
						idProducto:  '" .$productos->lstProductos[$i]->getIdProducto() . "',
						codigo:  '" .$productos->lstProductos[$i]->getCodigo() . "',
						longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',
						idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',
						tipoProducto:  '" .$productos->lstProductos[$i]->getTipoProducto() . "',
						shortTipoProducto:  '" .$productos->lstProductos[$i]->getShortTipoProducto() . "',
						idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',
						aplicacion:  '" .$productos->lstProductos[$i]->getAplicacion() . "',
						idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',
						material:  '" .$productos->lstProductos[$i]->getMaterial() . "',
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
						rolloDescripcion:  '" .$desc . "',
						idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',
						unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',
						shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',
						calibre:  '" .$productos->lstProductos[$i]->getCalibre() . "',
						descripcion:  '" . $descProducto . "',
						existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',
						tipoPrecio:  '" .$productos->lstProductos[$i]->getTipoPrecio() . "',
						isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
						isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',
						precio1:  '" .$productos->lstProductos[$i]->getPrecio1() . "',
						precio2:  '" .$productos->lstProductos[$i]->getPrecio2() . "',
						precio3:  '" .$productos->lstProductos[$i]->getPrecio3() . "',
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
						debug: ''

		             });


 					";
			}


		}

		$query = "select distinct tipoprecio, desarrollo from precioxdobles order by idPrecioXDobles;";

		$lstDesarrollos = $productos->getDataSet($query);

		foreach ($lstDesarrollos as $row)
		{
			$strListadoProductos .= "

                        app.desarrollos.push({ tipoPrecio: '".$row["tipoprecio"]."', desarrollo: '".$row["desarrollo"]."' });

                    ";
		}

// 		$debug = ob_get_clean();
// 		$r->mostrarAviso($debug); return;

  		$r->script($strListadoProductos );
// 		$r->assign("divdebug", "innerHTML", $strListadoProductos);
// 		$r->mostrarAviso( $strListadoProductos);

// $r->mostrarAviso("Productos Cargados"); return $r;


		return $r;
	}
	$xajax->registerFunction("cargarListaProductos");

	function cargarProductoIndividual($codigo)
	{

		$r = new xajaxResponse();



		$productos = new ModeloViewproductos();



		$productos->getViewProductoByCodigo($codigo);



		$strListadoProductos = "";

		$blnHayProductos = false;

		$blnEntroEnFor = false;



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

						longitud:  '" .$productos->lstProductos[$i]->getLongitud() . "',

						idTipoProducto:  '" .$productos->lstProductos[$i]->getIdTipoProducto() . "',

						tipoProducto:  '" .$productos->lstProductos[$i]->getTipoProducto() . "',

						shortTipoProducto:  '" .$productos->lstProductos[$i]->getShortTipoProducto() . "',

						idAplicacion:  '" .$productos->lstProductos[$i]->getIdAplicacion() . "',

						aplicacion:  '" .$productos->lstProductos[$i]->getAplicacion() . "',

						idMaterial:  '" .$productos->lstProductos[$i]->getIdMaterial() . "',

						material:  '" .$productos->lstProductos[$i]->getMaterial() . "',

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

						rolloDescripcion:  '" .$desc . "',

						idUnidad:  '" .$productos->lstProductos[$i]->getIdUnidad() . "',

						unidad:  '" .$productos->lstProductos[$i]->getUnidad() . "',

						shortUnidad:  '" .$productos->lstProductos[$i]->getShortUnidad() . "',

						calibre:  '" .$productos->lstProductos[$i]->getCalibre() . "',

						descripcion:  '" .$productos->lstProductos[$i]->getDescripcion() . "',

						existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',

						tipoPrecio:  '" .$productos->lstProductos[$i]->getTipoPrecio() . "',

						isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',

						isRollo:  '" .$productos->lstProductos[$i]->getIsRollo() . "',

						precio1:  '" .$productos->lstProductos[$i]->getPrecio1() . "',

						precio2:  '" .$productos->lstProductos[$i]->getPrecio2() . "',

						precio3:  '" .$productos->lstProductos[$i]->getPrecio3() . "',

						estado: '" .$productos->lstProductos[$i]->getEstado() . "',

						existenciaEstimada: '".$productos->lstProductos[$i]->getExistenciaToCero()."',

						fullDescripcion: '".$productos->lstProductos[$i]->getDescauto()."'



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

						debug: ''



		             });





// 					";

				}
			}





		}

		// 		$debug = ob_get_clean();

		// 		$r->mostrarAviso($debug); return;



		$r->script($strListadoProductos);



		if ($blnHayProductos)

		{

			$r->script("app.prepararProducto(); ocultarMensaje();");

		}

		else

		{

			// 			$r->ocultarMensaje();
			if ($blnEntroEnFor)
			{
				$r->script("ocultarMensaje();");

				$r->saError("Verifique que el Producto que esta seleccionando tenga Precio.");
			}
			else
			{
				$r->script("ocultarMensaje();");

				$r->saError("No se encuentra el producto que intenta ingresar, o est� dado de Baja.");
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



	function levantarPedido($idClienteSeleccionado, $subtotalPedido, $ivaPedido, $descuentoPedido, $totalPedido, $tipoPrecioGalvamex ,$detalle, $recogeRecibe,$strPersona, $strDireccion, $strNumero, $strColonia, $strCiudad, $fechaEntrega, $horaEntrega, $tipoPedido, $porDescuento, $maxDescuentoIndividual, $descuentoIndividual, $observacionPedido)
	{
		global $objSession;
		$r = new xajaxResponse();
		$blnDoCommit=true;

		$pedido = new ModeloPedido();

		$strErrores = "";



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

		$pedido->setObservacionCaptura($observacionPedido);

		$pedido->setPorDescuento($porDescuento);

		$pedido->setMaxDescuentoIndividual($maxDescuentoIndividual);
		$pedido->setDescuentoIndividual($descuentoIndividual);

		if ($recogeRecibe == "ENTREGA")
		{
			$pedido->setFechaCompromiso($fechaEntrega);
			$pedido->setHoraRecibe($horaEntrega);
		}

		$pedido->setDateAndUser("capturado");
		$idUsuario = $objSession->getIdUsuario();
// 		4 = Christian 11 = Saul

		if ($idUsuario == 11)
		{
			$pedido->setEstadoAUTORIZADO();
			$pedido->setDateAndUser("autorizado");
			$pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO");
		}

		//MDM se autoriza en automatico
		if ($idClienteSeleccionado == 137)
		{
			$pedido->setEstadoAUTORIZADO();
			$pedido->setDateAndUser("autorizado");
			$pedido->setObservacionAutoriza("AUTORIZADO AUTOMATICO MDM");
		}

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
					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding("No se ha podido obtener la informaci�n del Producto ".$item["fullDescripcion"].".", 'UTF-8', 'ISO-8859-1');
					$blnDoCommit = false;
					break;
				}

				$cantidadSolicitada = $item["cantidad"];
				$existencia = $producto->getExistencia() - $producto->getApartadoReal();

				if ($existencia < $cantidadSolicitada)
				{
					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding("No hay suficiente Stock ( ".$existencia." , 'ISO-8859-1', 'UTF-8') para el Producto ".$item["fullDescripcion"].".");
					$blnDoCommit = false;
					$blnStockInsuficiente = true;
// 					$r->mostrarAviso("commit false no sufi " .($blnDoCommit ? "docommit" : "no commit") . " " . $strErrores);


				}

				// 					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1'));
			}

		}

		//fin de antes de guardar checamos que todo vayase a despacharse



// 		$r->mostrarAviso($pedido->Guardar()); return $r;
// 		$r->mostrarAviso("checando... err pedido"); return $r;
		if($blnDoCommit)
		{

			$pedido->transaccionIniciar();

			$pedido->Guardar();



			if ($pedido->getError())
			{
				$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1'));
				// 			$r->saError($pedido->getStrError());
				$blnDoCommit = false;
			}
			else
			{
				// 			$pedido->transaccionCommit();
				// 			$r->saSuccess("pedido ingresado"); return $r;


				$id_pedido = $pedido->getIdPedido();
				$renglon = 0;



				foreach ($detalle as $item)
				{
					$renglon++;

					$checarExistencia = false;


// 					if ($tipoPedido == "AT"	 )
// 					{
// 						$checarExistencia = true;
// 					}



// 					if ($item["shortUnidad"] == "PZA" && $checarExistencia)
// 					{
// 						$producto = new ModeloProducto();

// 						$idProducto = $item["idProducto"];

// 						$producto->setIdProducto($idProducto);

// 						if ($producto->getIdProducto() <= 0)
// 						{
// 							$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding("No se ha podido obtener la informaci�n del Producto ".$item["fullDescripcion"].".", 'UTF-8', 'ISO-8859-1');
// 							$blnDoCommit = false;
// 							break;
// 						}

// 						$cantidadSolicitada = $item["cantidad"];
// 						$existencia = $producto->getExistencia() - $producto->getApartadoReal();



// 						if ($existencia < $cantidadSolicitada)
// 						{

// 							$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding("No hay suficiente Stock (~".$existencia.", 'ISO-8859-1', 'UTF-8') para el Producto ".$item["fullDescripcion"].". ");
// 							$blnDoCommit = false;
// 							// 						$r->mostrarAviso("commit false no sufi " .$blnDoCommit);


// 						}

// 						// 					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($pedido->getStrError(, 'UTF-8', 'ISO-8859-1'));
// 					}





					$det = new ModeloPedidodetalle();



					$det->setIdPedido($id_pedido);
					$det->setRenglon($renglon);
					$det->setIdProducto($item["idProducto"]);
					$det->setTipoPrecio(getTipoPrecioForDetail($item["tipoPrecio"], $tipoPrecioGalvamex, $item["isRango"]));
					$det->setPartida($item["cantidad"]);
					$det->setCantidad($item["cantUnidad"]);
					$det->setCantidadReal($item["cantUnidadReal"]);

					$det->setComision($item["rangoRenglon"]);


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
						$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($det->getStrError(, 'UTF-8', 'ISO-8859-1'));
						$blnDoCommit = false;
						break;
					}


				}
				// 			$r->mostrarAviso("salir for " .$blnDoCommit);

				if ($blnDoCommit)
				{
					// 				$r->mostrarAviso("guardado " .$blnDoCommit);
					$r->script("


						app.pedidoFolio = ". $id_pedido .";
						app.vistaPedido = false;
						app.imprimirPedido = true;
						$('#secImprimirONuevo').show();
						app.mostrarBotonGuardar = true;

						saSuccess(\"El Pedido ha sido generado satisfactoriamente.\");



						");


					// 				$r->script("
					// 				swal({
					//                         title: \"".mb_convert_encoding("Pedido " . $id_pedido, 'UTF-8', 'ISO-8859-1')."\",
					//                         text: \"El Pedido ha sido generado satisfactoriamente.\",
					//                         type: \"success\",
					//                         showCancelButton: true,
					//                         confirmButtonColor: \"#DD6B55\",
					//                         confirmButtonText: \"Generar Nuevo Pedido\",
					//                         cancelButtonText: \"Ir al Listado\",
					//                         closeOnConfirm: false,
					//                         closeOnCancel: false },
					//                     function (isConfirm) {
					//                         if (isConfirm) {
					//                             window.location = \"pedidonuevo\";
					//                         } else {

					//                         }
					//                     });
					// 				");
				}

			}

			if ($blnDoCommit)
			{
				// 			$r->mostrarAviso("commit");
				$pedido->transaccionCommit();
			}
			else
			{
				// 			$r->mostrarAviso("rollback");
				$pedido->transaccionRollback();
				$r->script("app.mostrarBotonGuardar = true;");
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

				$r->script("app.mostrarBotonGuardar = true;");

// 				$r->mostrarAviso($strErrores);

// 				//$r->saError($strErrores);
				$r->script("

							app.levantarPedidoSinChecarStock(\"".mb_convert_encoding($strErrores, 'UTF-8', 'ISO-8859-1')."\");

						");
			}
			else
			{
				$r->script("app.mostrarBotonGuardar = true;");
				$r->saError($strErrores);
			}

		}



		return $r;
	}
	$xajax->registerFunction("levantarPedido");



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
