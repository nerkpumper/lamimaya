<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.viewrollos.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.material.inc.php";
	require_once FOLDER_MODEL. "model.proveedor.inc.php";
	require_once FOLDER_MODEL. "model.pesomt.inc.php";

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
//ob_start();	
// 	echo "hola mundito";
//$debug = ob_get_clean();
//$r->mostrarMsgs($debug);

	function cargarRollos($idMaterial, $idProveedor)
	{
		$r = new xajaxResponse();
				
		$rollo = new ModeloViewrollos();
		
		$where = "";
		
		if ($idMaterial != "0" && $idProveedor != "0")
		{
			$where = " AND idMaterial = " . $idMaterial . " AND idProveedor = " . $idProveedor;
		}
		else if ($idMaterial != "0")
		{
			$where = " AND idMaterial = " . $idMaterial;
		}
		else if ($idProveedor != "0")
		{
			$where = " AND idProveedor = " . $idProveedor;
		}
		
		$lst = $rollo->getAll("idRollo, codigo, origen, descauto ",
				              "",
				              "  idRollo > 1 and estado = 'ACTIVO' " . $where,
				              " idMaterial, calibre, pies, idProveedor");
		
		$pushes = "";
		
		foreach ($lst as $row)
		{
			$pushes .= "
					
					 app.rollos.push ({id: ".$row["idRollo"].", 
					                   codigo: '".$row["codigo"]."',
					                   origen: '".($row["origen"] == "N" ? "NACIONAL" : "IMPORTADO")."',
					                   desc: '".$row["descauto"]."'});
					
					";
		}
		
		$r->script("
				
					app.rollos.splice(0, app.rollos.length	);
				
					". $pushes	);
	
	
		return $r;
	}
	$xajax->registerFunction("cargarRollos");

	function cargarRollo($idRollo)
	{
		$r = new xajaxResponse();
		
		$rollo = new ModeloViewrollos();
		$peso = new ModeloPesomt();
		
		if ($idRollo <= 0)
		{
			$r->saError("No se ha especificado un Rollo para procesar.");
			return $r;
		}
		
		$rollo->setIdRollo($idRollo);
// 		$r->mostrarAviso($rollo->getDatos()); return $r;
		$rollo->getDatos();
		
		if ($rollo->getIdRollo() <= 0)
		{
			$r->saError("No se ha podido obtener la información del Rollo.");
			return $r;
		}
		
		$peso->getDatosByCalibrePies($rollo->getCalibre());
		
		$pesokgmt = "";
		
		if ($rollo->getPies() == 2)
		{
			$pesokgmt = $peso->getPies2();
		}
		else if ($rollo->getPies() == 3)
		{
			$pesokgmt = $peso->getPies3();
		}
		else if ($rollo->getPies() == 4)
		{
			$pesokgmt = $peso->getPies4();
		}	
			
		$r->script(" 
				
				app.seleccionado.idRolloSeleccionado = ".$idRollo.";
				app.seleccionarRollo = false;
				app.debeGuardarPesoKgMt = false;
				app.seleccionado.rollo = \"".$rollo->getCodigo() . " - " . $rollo->getDescauto()."\";
				
				app.campos.recubrimiento = '".$rollo->getMaterial()."';
				app.campos.calibre = '".$rollo->getCalibre()."';
				app.campos.pies = '".$rollo->getPies()."';
				app.campos.origen = '".$rollo->getOrigen()."';
				app.campos.proveedor = '".$rollo->getProveedor()."';
				
				app.campos.iva = '".$rollo->getIva()."';
				app.campos.prodmes = '".$rollo->getProdmes()."';
				app.campos.porutilidad = '".$rollo->getPorutilidad()."';
				app.campos.porcomision = '".$rollo->getPorcomision()."';
				app.campos.descuento = '".$rollo->getDescuento()."';	
				app.campos.costoflete = '".$rollo->getCostoflete()."';
				app.campos.costokg = '".$rollo->getCostokg()."';
				
				app.campos.pesokgmt = '".$rollo->getPesokgmt()."';
				
				app.pesokgmtDeTabla = '".$pesokgmt."';
								
				app.campos.mod = '".$rollo->getFmod()."';
				app.campos.moi = '".$rollo->getMoi()."'; 	
				app.campos.gastosfab = '".$rollo->getGastosfab()."';
				app.campos.comisiones = '0';
				app.campos.gastosventa = '".$rollo->getGastosventa()."';
				app.campos.gastosfinancieros = '".$rollo->getGastosfinancieros()."';
				app.campos.gastosadmon = '".$rollo->getGastosadmon()."';
				
				setTimeout(function(){ app.calcularValores();}, 200);
				
				");
		
		$productos = new ModeloViewproductos();
		
		$lstProductos = $productos->getAll("idProducto, codigo, descauto, idUnidad, mlpieza, shortUnidad, isRollo, isRango, heredarPrecio, precio1, precio2, precio3",
										   "",
										   " idrollo = " .$idRollo . " AND estado = 'ACTIVO'  ",
				                           " idUnidad");
		
		$pushesProductos = "";
		foreach ($lstProductos as $p)
		{
			$pushesProductos .= "
					
							app.productos.push({
								idProducto: ".$p["idProducto"].",
								codigo: '".$p["codigo"]."',
								descripcion: '".$p["descauto"]."',
								unidad: ".$p["idUnidad"].",
								ml: ".$p["mlpieza"].",
								shortunidad: '".$p["shortUnidad"]."',
								isRollo: ".($p["isRollo"] == "1" ? "true" : "false").",
								isRango: ".($p["isRango"] == "1" ? "true" : "false").",
								heredarPrecio: ".($p["heredarPrecio"] == "SI" ? "true" : "false").",
								heredandoPrecio: '".($p["heredarPrecio"] == "SI" ? "1" : "0")."',
								precio1: '".$p["precio1"]."',
								precio2: '".$p["precio2"]."',
								precio3: '".$p["precio3"]."',
								posibleprecio1: '0',
								posibleprecio2: '0',
								posibleprecio3: '0',
								originalprecio1: '".$p["precio1"]."',
								originalprecio2: '".$p["precio2"]."',
								originalprecio3: '".$p["precio3"]."'	
							});
					
					
					";
		}
		
		$r->script(" app.productos.splice(0, app.productos.length); " . $pushesProductos . "  setTimeout(function(){app.setPreciosProductosAll();}, 500);");
	
		return $r;
	}
	$xajax->registerFunction("cargarRollo");
	
	function guardarDatosRollo($idRollo, $datosRollo, $productos)
	{
		$r = new xajaxResponse();
		
		$rollo = new ModeloRollo();
		
		if ($idRollo <= 0)
		{
			$r->saError("No se ha especificado un Rollo para procesar.");
			return $r;
		}
		
		$blnDoCommit = true;
		$strErrores = "";
		
		
		
		$rollo->setIdRollo($idRollo);
		// 		$r->mostrarAviso($rollo->getDatos()); return $r;
		$rollo->getDatos();
	
		if ($rollo->getIdRollo() <= 0)
		{
			$r->saError("No se ha podido obtener la información del Rollo.");
			return $r;
		}
		
		$rollo->transaccionIniciar();
		
		$rollo->setIva($datosRollo["iva"]);		
		$rollo->setProdmes($datosRollo["prodmes"]);
		$rollo->setPorutilidad($datosRollo["porutilidad"]);
		$rollo->setPorcomision($datosRollo["porcomision"]);
		$rollo->setDescuento($datosRollo["descuento"]);		
		$rollo->setCostoflete($datosRollo["costoflete"]);
		$rollo->setCostokg($datosRollo["costokg"]);
		$rollo->setPesokgmt($datosRollo["pesokgmt"]);
		$rollo->setPesocu($datosRollo["pesocu"]);
		$rollo->setPesoimporte($datosRollo["pesoimporte"]);
		$rollo->setPesoparti($datosRollo["pesoparti"]);
		$rollo->setFmod($datosRollo["mod"]);
		$rollo->setMoi($datosRollo["moi"]);
		$rollo->setGastosfab($datosRollo["gastosfab"]);
		$rollo->setComisiones($datosRollo["comisiones"]);
		$rollo->setGastosventa($datosRollo["gastosventa"]);
		$rollo->setGastosfinancieros($datosRollo["gastosfinancieros"]);
		$rollo->setGastosadmon($datosRollo["gastosadmon"]);
		$rollo->setModiva($datosRollo["modiva"]);
		$rollo->setMoiiva($datosRollo["moiiva"]);
		$rollo->setGastosfabiva($datosRollo["gastosfabiva"]);
		$rollo->setComisionesiva($datosRollo["comisionesiva"]);
		$rollo->setGastosventaiva($datosRollo["gastosventaiva"]);
		$rollo->setGastosfinancierosiva($datosRollo["gastosfinancierosiva"]);
		$rollo->setGastosadmoniva($datosRollo["gastosadmoniva"]);
		$rollo->setModparti($datosRollo["modparti"]);
		$rollo->setMoiparti($datosRollo["moiparti"]);		
		$rollo->setGastosfabparti($datosRollo["gastosfabparti"]);
		$rollo->setComisionesparti($datosRollo["comisionesparti"]);
		$rollo->setGastosventaparti($datosRollo["gastosventaparti"]);
		$rollo->setGastosfinancierosparti($datosRollo["gastosfinancierosparti"]);
		$rollo->setGastosadmonparti($datosRollo["gastosadmonparti"]);
		$rollo->setTotalessummes($datosRollo["totalessummes"]);
		$rollo->setTotalessumkg($datosRollo["totalessumkg"]);
		$rollo->setTotalespeso($datosRollo["totalespeso"]);
		$rollo->setTotalesfab($datosRollo["totalesfab"]);
		$rollo->setTotalcostofab($datosRollo["totalcostofab"]);
		$rollo->setTotalpreciovta($datosRollo["totalpreciovta"]);
		$rollo->setTotalpreciovtar2($datosRollo["totalpreciovtaR2"]);
		$rollo->setTotalpreciovtar3($datosRollo["totalpreciovtaR3"]);
		
		$rollo->Guardar();
		
		if ($rollo->getError())
		{
			$blnDoCommit = false;
			$strErrores .= $rollo->getStrError() . ". ";
		}
		else
		{
			foreach ($productos as $item)
			{
				$producto = new ModeloProducto();
				
				$producto->setIdProducto($item["idProducto"]);
				
				if ($producto->getIdProducto() <= 0)
				{
					$blnDoCommit = false;
					$strErrores .= "No se pudo obtener información del Producto (".$item["idProducto"]."). ";
				}
				else
				{
					
					if ($item["heredandoPrecio"] == "1")
					{
// 						$r->mostrarAviso($item["idProducto"] . " - SI hereda");						
						$producto->setHeredarPrecioSI();
					}
					else
					{
// 						$r->mostrarAviso($item["idProducto"] . " - NO hereda");
						$producto->setHeredarPrecioNO();
					}
					
					$item["precio1"] = str_replace(",", "", $item["precio1"]);
					$item["precio1"] = str_replace(" ", "", $item["precio1"]);
					
					$item["precio2"] = str_replace(",", "", $item["precio2"]);
					$item["precio2"] = str_replace(" ", "", $item["precio2"]);
					
					$item["precio3"] = str_replace(",", "", $item["precio3"]);
					$item["precio3"] = str_replace(" ", "", $item["precio3"]);
					
					$producto->setPrecio1($item["precio1"]);
					$producto->setPrecio2($item["precio2"]);
					$producto->setPrecio3($item["precio3"]);
					
					$producto->Guardar();
// 					$r->mostrarAviso($producto->ActualizarSQL());
					
					if ($producto->getError())
					{
						$blnDoCommit = false;
						$strErrores .= $producto->getStrError() . ".";
					}
				}
				
			}
		}
		
		if ($blnDoCommit)
		{
			$rollo->transaccionCommit();
			$r->saSuccess("Datos del Rollo registrados con éxito. Precios de Productos registrados con éxito");
			$r->script(" setTimeout(function(){app.recargarDatosRollo();}, 500);");
		}
		else
		{
			$rollo->transaccionRollback();
			$r->saError("No se han realizado los cambios. ". $strErrores);
		}
		
	
		return $r;
	}
	$xajax->registerFunction("guardarDatosRollo");
		
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
	
// 	$opcionesRollos = "";
	
// 	$rollo = new ModeloViewrollos();
	
// 	$lst = $rollo->getAll("idRollo, concat(codigo, ' - ' , descauto) as des ", 
// 			              "",
// 			              "",
// 			              " idMaterial, calibre, pies, idProveedor");
	
// 	foreach ($lst as $row)
// 	{
// 		$opcionesRollos .= "<option value=\"".$row["idRollo"]."\">".$row["des"]."</option>";
// 	}

	$opcionesMateriales = "";
	
	$mat = new ModeloMaterial();
	
	$lst = $mat->getAll("idMaterial, nombre ",
			"",
			" idMaterial > 1 and estado = 'ACTIVO'",
			" nombre");
	
	foreach ($lst as $row)
	{
		$opcionesMateriales .= "<option value=\"".$row["idMaterial"]."\">".$row["nombre"]."</option>";
	}
	
	$opcionesProveedores = "";
	
	$prov = new ModeloProveedor();
	
	$lst = $prov->getAll("idProveedor, nombre ",
			"",
			" idProveedor > 1 and estado = 'ACTIVO' ",
			" nombre");
	
	foreach ($lst as $row)
	{
		$opcionesProveedores .= "<option value=\"".$row["idProveedor"]."\">".$row["nombre"]."</option>";
	}
	
	
	