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
	            //             //echo "<br><br><br>" . $fecha. "    <br><br><br>sflñkjsdakljfjslfjsñd<br><br><br>";
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

	function saludar()
	{
	    $r = new xajaxResponse();
	    
	    $r->mostrarAviso("Saludo");
	    
	    return $r;
	}
	$xajax->registerFunction("verificaPromotor");
	
	function verificaPromotor()
	{
		global $objSession;
		$r = new xajaxResponse();

// 		if ($objSession->getIdUsuario() == 10 || $objSession->getIdUsuario() == 15)
        if ($objSession->getIdUsuario() == 15)
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
	    	    
	    $lst = $oc->getAll("","","");
	    
	    $strOC = "";
	    
	    
	    foreach ($lst as $row)
	    {
	        
	        $strOC .= "app.otrosCargos.push({ 
                        id: ".$row["idOtroCargo"].",
					descripcion: '".mb_strtoupper($row["descripcion"])."',
                    monto: 0
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
			$r->saError("No se ha podido obtener la Configuraciï¿½n de Rangos.");
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

				app.rango1FinAcryOpa = ".$con->getRangoMetros1AcryOpaFin() .";
				app.rango2InicioAcryOpa = ".$con->getRangoMetros2AcryOpaInicio().";
				app.rango2FinAcryOpa = ".$con->getRangoMetros2AcryOpaFin().";
				app.rango3InicioAcryOpa = ".$con->getRangoMetros3AcryOpaInicio().";
                
		        app.rango1FinGalvateja = 300;
		        app.rango2InicioGalvateja = 301;
		        app.rango2FinGalvateja = 600;
		        app.rango3InicioGalvateja = 601;

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
						descripcion:  '" . $descProducto . "',
						existencia:  '" .$productos->lstProductos[$i]->getExistencia() . "',
                        tipoPrecioComision: 'PRECIO',
						tipoPrecio:  '" .$productos->lstProductos[$i]->getTipoPrecio() . "',
						isRango:  '" .$productos->lstProductos[$i]->getIsRango() . "',
						tipoRango:  '" .$productos->lstProductos[$i]->getTipoRango() . "',
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
                        molTotalCMScrap: 0               

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


	function cargarListaRollos()
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		$rollos = new ModeloViewrollos();

		$lstRollos = $rollos->getAll("idrollo, codigo, descauto, existencia, calibre, pies, idmaterial,
                                      totalpreciovta, totalpreciovtar2, totalpreciovtar3,
									  IF(apartado >= 0, apartado, 0) as apartado, 
									  (existencia - IF(apartado >= 0, apartado, 0)) disponible ", 
									 "", 
									 " estado = 'ACTIVO' and idrollo > 1",
									 " descauto ");


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
                        molTotalCMScrap: 0



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

				$r->saError("No se encuentra el producto que intenta ingresar, o estï¿½ dado de Baja.");
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



	function levantarPedido($idClienteSeleccionado, $subtotalPedido, $ivaPedido, $descuentoPedido, $totalPedido, $tipoPrecioGalvamex ,$detalle, $recogeRecibe,$strPersona, $strDireccion, $strNumero, $strColonia, $strCiudad, $fechaEntrega, $horaEntrega, $tipoPedido, $porDescuento, $maxDescuentoIndividual, $descuentoIndividual, $observacionPedido, $totalOtrosCargos, $otrosCargos, $molCostoDobles, $molCostoCorte)
	{
		global $objSession;
		$r = new xajaxResponse();
		$blnDoCommit=true;
		$idProductoMoldura = 386;
		$idProductoMaquila = 394;
		$r->mostrarAviso("inicio"); return $r;
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
		$pedido->setOtrosCargos($totalOtrosCargos);
		
		
		$_fecha = date("Y-m-d");		
		$fechaLimite  = addDays($_fecha, 30, true);
		
		$pedido->setFecha_limitepago($fechaLimite);
		

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
        $r->mostrarAviso("antes de recorrer renglones"); return $r;
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
					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding("No se ha podido obtener la informaciï¿½n del Producto ".$item["fullDescripcion"].".", 'UTF-8', 'ISO-8859-1');
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

				// 					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1');
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
				$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1');
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
// 							$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding("No se ha podido obtener la informaciï¿½n del Producto ".$item["fullDescripcion"].".", 'UTF-8', 'ISO-8859-1');
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

// 						// 					$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($pedido->getStrError(), 'UTF-8', 'ISO-8859-1');
// 					}





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
						$strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($det->getStrError(), 'UTF-8', 'ISO-8859-1');
						$blnDoCommit = false;
						break;
					}


				}
				// 			$r->mostrarAviso("salir for " .$blnDoCommit);
				
// 				Otros Cargos
// 				$id_pedido
// $r->starDebug();

				
				
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
                            $ocp->setMonto($montooc);
                            
                            $ocp->Guardar();
                            
                            if ($ocp->getError())
                            {
                                // 					$r->saError($det->getStrError());
                                $strErrores .= ($strErrores == "" ? "" : "<br>") . mb_convert_encoding($ocp->getStrError(), 'UTF-8', 'ISO-8859-1');
                                $blnDoCommit = false;
                                break;
                            }
                            
                            
                        }
                    }
                    
                    
                    
                }
// 				$r->endDegug(); return $r;
// 				Fin Otros Cargos

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
	        $r->script("app.errUsername = \"". mb_convert_encoding("Al parecer este Cliente ya esta en el sistema. Favor de verificar.", 'UTF-8', 'ISO-8859-1') ."\"; ");
	        $regresar = true;
	    }
	    
	    
	    if ($email != "")
	    {
	        if ($cliente->existeField("email", $email, $idCliente))
	        {
	            $r->script("app.errEmail = \"". mb_convert_encoding("Este email ya esta siendo utilizado. Debe especificar uno diferente.", 'UTF-8', 'ISO-8859-1') ."\"; ");
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
	
	


//     Fin Alta Cliente
	
	
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
	
	
	
	$uso = new ModeloUsocfdi();
	
	$lstUsoCFDI = $uso->getForSelect("idUsoCfdi", "concat(clave,' - ',descripcion)", "");
	
	
// 	$fecha = date_create();
// 	echo date_timestamp_get($fecha);