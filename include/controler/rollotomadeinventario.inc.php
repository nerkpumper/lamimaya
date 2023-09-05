<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
	require_once FOLDER_MODEL. "model.viewrollos.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL . "model.tomainventario.inc.php";
	require_once FOLDER_MODEL . "model.tomainventariodetalle.inc.php";
	
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
// 	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
// 	function guardarRollo($idRollo, $codigo, $idMaterial, $calibre, $pies, $idProveedor, $descripcion, $observaciones)
// 	{
// 		$r = new xajaxResponse();
// 		$rollo = new ModeloRollo();
// 		$isInsert = false;
// 		$regresar = false;
		
		
// 		if ($rollo->existeField("codigo", $codigo, $idRollo))
// 		{
// 			$r->script("app.errCodigo = \"Este C�digo ya est� siendo utilizado. Se debe armar uno diferente.\"; ");
// 			$regresar = true;
// 		}		
		
// 		if ($regresar)
// 		{
// 			return $r;
// 		}
		
// 		if ($idRollo == 0)
// 		{
// 			$isInsert = true;
// 		}
// 		else
// 		{
// 			$rollo->setIdRollo($idRollo);
// 		}
		
// 		$rollo->setCodigo($codigo);
// 		$rollo->setRollo_material_idMaterial($idMaterial);
// 		$rollo->setCalibre($calibre);
// 		$rollo->setPies($pies);
// 		$rollo->setRollo_proveedor_idProveedor($idProveedor);
// 		$rollo->setDescripcion(nl2br($descripcion));
// 		$rollo->setObservaciones(nl2br($observaciones));
// 		$rollo->Guardar();
		
// 		if ($rollo->getError())
// 		{
// 			$r->mostrarError($rollo->getStrError());
// 			return $r;
// 		}
				
// 		if ($isInsert)
// 		{
// 			$r->mostrarExito("El Rollo " . $codigo . " se ha almacenado satisfactoriamente." );
// 			$r->redirect(URL_BASE . "rollo",2);
// 		}
// 		else
// 		{
// 			$r->mostrarExito("El Rollo " . $codigo . " se ha modificado satisfactoriamente." );
// 			$r->redirect(URL_BASE . "rollo",2	);
// 		}

		
// 		return $r;
// 	}
// 	$xajax->registerFunction("guardarRollo");

	function registrarIngresos($idRollo, $ingresos)
	{
		$r = new xajaxResponse();
		
		if ($idRollo <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}
		
		$idUsuario = ModeloUsuario::getObjSession()->getIdUsuario();
		
		$remision = new ModeloRemisionrollo();
		
		$r->script("
					    var i2;
					    for (i2 = 0 ; i2 < app.ingresos.length ; i2++)
					    {
					         app.ingresos[i2].estatusLabel = \"<span class='label label-info'>Enlistado</span>\";
					    }					
			
					   ");
		
		$blnHayRepetidos = false;
		$strLabelRepetidos = "";
		$blnListoParaGuardar = true;
		
		//se verifica que no haya repetidos en la lista
		foreach ($ingresos as $key=>$item)
		{		
			foreach ($ingresos as $key2=>$item2)
			{
				if (trim($item["noRollo"]) == trim($item2["noRollo"]) && $key != $key2)
				{
					$blnHayRepetidos = true;
					$blnListoParaGuardar = false;
					$strLabelRepetidos .= "app.ingresos[" . $key . "].estatusLabel = \"<span class='label label-warning'>" . utf8_encode("N�mero de rollo repetido en lista.") . "</span>\";";
				}	
			} 			
		}
		
		if ($blnHayRepetidos)
		{
			$r->script("app.blnNoRegistrados = true;" . $strLabelRepetidos);
		}
		
		//se verifica que no hayan registrado previamente el numero de rollo
		foreach ($ingresos as $key=>$item)
		{
			if ($remision->existeField("noRollo", $item["noRollo"]))
			{
				$blnHayRepetidos = true;
				$blnListoParaGuardar = false;
				$strLabelRepetidos .= "app.ingresos[" . $key . "].estatusLabel = \"<span class='label label-danger'>" . utf8_encode("N�mero de rollo ya ha sido ingresado previamente.") . "</span>\";";
			}
		}
		
		if ($blnHayRepetidos)
		{
			$r->script("app.blnNoRegistrados = true;" . $strLabelRepetidos);
		}
		
		
		if (!$blnListoParaGuardar)
		{
			return $r;
		}
		

		//comenzamos la transacci�n para meter toda la lista
		$remision->transaccionIniciar();
		
		$doCommit = true;
		
		foreach ($ingresos as $item)
		{			
			$remision = new ModeloRemisionrollo();
			$remision->setRemisionRollo_rollo_idRollo($idRollo);
			$remision->setRemision($item["remision"]);			
			$remision->setNoRollo($item["noRollo"]);
			$remision->setKilos($item["kilos"]);
			$remision->setExistencia($item["kilos"]);
			
			$remision->setRemisionRollo_usuario_idUsuario($idUsuario);
			
			$remision->Guardar();
			
			if ($remision->getError())
			{
				$r->saError($remision->getStrError());
				$doCommit = false;
			}
		}		
		
		if ($doCommit)
		{
			$remision->transaccionCommit();
			$r->saSuccess("Se han registrado los ingresos de manera correcta.");
			$r->script("
					    app.blnProcesado = true;
					    
					    var i;
					    for (i = 0 ; i < app.ingresos.length ; i++)
					    {
					         app.ingresos[i].estatusLabel = \"<span class='label label-success'>".utf8_encode("N�mero de Rollo registrado.") ."</span>\";
					    }
					
						window.location = URL_BASE + \"rolloremisionlastinsert/" . $idRollo . "\";
					
					   ");
		}
		else
		{
			$remision->transaccionRollback();
			$r->mostrarError("No se han podido registrar los ingresos.");
		}
		
		
		return $r;
	}
	$xajax->registerFunction("registrarIngresos");
	
	
	function verificaExistenciaRolloEnSistema($index, $norollo)
	{
	    $r = new xajaxResponse();
	    	    	    
	    $remision = new ModeloRemisionrollo();
	    
	    $r->script(" console.log('estoy en xajax');");
	    
// 	    $r->mostrarAviso($remision->existeField("noRollo", $norollo)); return $r;
	    
	    if ($remision->existeField("noRollo", $norollo))
	    {
	        $r->script(" app.ingresos[".$index."].oksistema = 'NO'; ");
	    }    
	    else 
	    {
	        $r->script(" app.ingresos[".$index."].oksistema = 'SI'; ");
	    }
	    
	    
	    
	    return $r;	    
	}	
	$xajax->registerFunction("verificaExistenciaRolloEnSistema");
	
	function cargarRollo($idRollo)
	{
		$r = new xajaxResponse();
		
		$rollo= new ModeloViewrollos();
		
		if ($idRollo <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}			
		
		$rollo->setIdRollo($idRollo);
		$rollo->getDatos();
		
		//verifica si el rollo fue cargado
		if ($rollo->getIdRollo() <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}
		
// 		$rollo->getDatosReferencia();
		
		
		$desc=str_replace(chr(13),'', $rollo->getDescauto());
		$desc=str_replace('<br />','\n', $desc);
		$desc=str_replace(chr(10),'', $desc);
				
		$r->script("
					app.codigo = '" . $rollo->getCodigo() . "';
			 		app.proveedor = '';                                      
					app.descripcion = '" . $desc . "';   
                    app.rollocalibre = ".$rollo->getCalibre().";
                    app.rollopies = ".$rollo->getPies().";                  
				  ");
		
		
		return $r;
	}	
	$xajax->registerFunction("cargarRollo");


	function setTomaInventarioID()
	{
		$r = new xajaxResponse();

		$toma = new ModeloTomainventario();

		$r->script(" app.tomaInventario = ".$toma->getTomaInventarioActual()." ; app.loadTomaInventarioActual();"); 

		return $r;

	}
	$xajax->registerFunction("setTomaInventarioID");

	function obtenerRemisionRollo($index, $noRollo)
	{
		$r = new xajaxResponse();

		$rr = new ModeloRemisionrollo();

		$lst = $rr->getAll("remisionrollo.idremisionrollo, remisionrollo.remision, remisionrollo.norollo, 
		remisionrollo.remisionrollo_rollo_idrollo, remisionrollo.kilos, 
		remisionrollo.existencia, remisionrollo.almacen,
		ifnull(registroproduccion.idregistroproduccion, 0) idregistroproduccion, 
		ifnull(registroproduccion.kilosmaquilados,0) kilosmaquilados, 
		ifnull(registroproduccion.terminado, 'SI') terminado,
		rollo.codigo	", 
		"left join registroproduccion on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo 
		inner join rollo on remisionrollo.remisionrollo_rollo_idrollo = rollo.idrollo",
		"remisionrollo.norollo = '".$noRollo."'");


		$r->script("app.ingresos[".$index."].infosistemacargada = true;	");
		

		foreach ($lst as $item) 
		{
			$r->script("			
				
				app.ingresos[".$index."].idremisionrollo = ".$item["idremisionrollo"].";
				app.ingresos[".$index."].idrollo = ".$item["remisionrollo_rollo_idrollo"].";	
				app.ingresos[".$index."].idrollooriginal = ".$item["remisionrollo_rollo_idrollo"].";	
				app.ingresos[".$index."].codigo = '".$item["codigo"]."';
				app.ingresos[".$index."].almacen = '".$item["almacen"]."';	
				app.ingresos[".$index."].almacenoriginal = '".$item["almacen"]."';		
				app.ingresos[".$index."].kilos = ".$item["kilos"].";		
				app.ingresos[".$index."].kilosoriginal = ".$item["kilos"].";	
				app.ingresos[".$index."].existencia = ".$item["existencia"].";	
				app.ingresos[".$index."].idregistroproduccion = ".$item["idregistroproduccion"].";		
				app.ingresos[".$index."].rpterminado = '".$item["terminado"]."';		
				app.ingresos[".$index."].rpmaquilados = ".$item["kilosmaquilados"].";	
				

				
				
			");	

			// $r->mostrarAviso(
			// 	"
			// 	app.ingresos[".$index."].idremisionrollo = ".$item["idremisionrollo"].";
			// 	app.ingresos[".$index."].idrollo = ".$item["remisionrollo_rollo_idrollo"].";	
			// 	app.ingresos[".$index."].idrollooriginal = ".$item["remisionrollo_rollo_idrollo"].";	
			// 	app.ingresos[".$index."].codigo = ".$item["codigo"].";
			// 	app.ingresos[".$index."].almacen = ".$item["almacen"].";	
			// 	app.ingresos[".$index."].almacenoriginal = ".$item["almacen"].";		
			// 	app.ingresos[".$index."].kilosoriginal = ".$item["kilos"].";		
			// 	app.ingresos[".$index."].idregistroproduccion = ".$item["idregistroproduccion"].";		
			// 	app.ingresos[".$index."].rpterminado = ".$item["terminado"].";		
			// 	app.ingresos[".$index."].rpmaquilados = ".$item["kilosmaquilados"].";		
			// "
			// );
		}
		
		

		return $r;

	}
	$xajax->registerFunction("obtenerRemisionRollo");

	function obtenerProducto($index, $codigo)
	{
		$r = new xajaxResponse();
// $r->starDebug();
		$p = new ModeloViewproductos();

		$lst = $p->getAll("idproducto, codigo, descauto descripcion, existencia, idUnidad ", 
		"",
		" codigo = '".$codigo."'");


		$r->script("app.productos[".$index."].infosistemacargada = true;	");
		

		foreach ($lst as $item) 
		{
			
				$r->script("			


				
				app.productos[".$index."].idproducto = ".$item["idProducto"].";				
				app.productos[".$index."].codigo = '".$item["codigo"]."';
				app.productos[".$index."].descripcion = '".$item["descripcion"]."';					
				app.productos[".$index."].existencia = ".$item["existencia"].";			
				app.productos[".$index."].isstock = ".($item["idUnidad"] == "4" ? "true" : "false").";			

				
				
			");	
			
			

		
		}
		
		// $r->endDegug();
		return $r;

	}
	$xajax->registerFunction("obtenerProducto");

	
	function registrarInventario($idTomaInventario, $ingresos, $almacenDestino)
	{
		$r = new xajaxResponse();

		$tid = new ModeloTomainventariodetalle();

		$blnSuccess = true;
		$error = "";

		$tid->transaccionIniciar();

		foreach ($ingresos as $item) 
		{
			$tid = new ModeloTomainventariodetalle();

			$tid->setIdTomaInventario($idTomaInventario);
			$tid->setIdRemisionRollo($item["idremisionrollo"]);
			$tid->setIdProducto(0);
			$tid->setNorollo($item["norollo"]);
			$tid->setIdRolloOriginal($item["idrollooriginal"]);
			$tid->setIdRolloUpdate($item["idrollo"]);
			$tid->setKilosOriginal($item["kilosoriginal"]);
			$tid->setKilosUpdate($item["kilos"]);
			$tid->setAlmacenOriginal($item["almacenoriginal"]);
			$tid->setAlmacenUpdate($almacenDestino);
			$tid->setDateAndUser("captura");
			$tid->setTipoproductoROLLO();

			$tid->Guardar();

			if ($tid->getError())
			{
				$error = $tid->getStrError();
				$blnSuccess = false;				
				break;
			}
		}

		if ($blnSuccess)
		{
			$r->saSuccess("Se ha registrado la toma de inventario y se han realizado los movimientos correspondientes.");

			$tid->transaccionCommit();
			$r->script("mdlExitWait(); app.chkVerCapturados = true; app.setTomaInventarioID();");
		}
		else 
		{
			$tid->transaccionRollback();
			$r->saError("Error: ".$error);
		}

				

		return $r;
	}
	$xajax->registerFunction("registrarInventario");

	function registrarProductos($idTomaInventario, $ingresos)
	{
		$r = new xajaxResponse();

		$tid = new ModeloTomainventariodetalle();

		$blnSuccess = true;
		$error = "";

		$tid->transaccionIniciar();

		foreach ($ingresos as $item) 
		{
			$tid = new ModeloTomainventariodetalle();

			$tid->setIdTomaInventario($idTomaInventario);
			$tid->setIdRemisionRollo(0);
			$tid->setIdProducto($item["idproducto"]);
			$tid->setNorollo('');
			$tid->setIdRolloOriginal(0);
			$tid->setIdRolloUpdate(0);
			$tid->setKilosOriginal(0);
			$tid->setKilosUpdate(0);
			$tid->setAlmacenOriginal("");
			$tid->setAlmacenUpdate("");
			$tid->setExistenciaOriginal($item["existencia"]);
			$tid->setExistenciaUpdate($item["inventario"]);
			$tid->setDateAndUser("captura");
			$tid->setTipoproductoPRODUCTO();

			$tid->Guardar();

			if ($tid->getError())
			{
				$error = $tid->getStrError();
				$blnSuccess = false;				
				break;
			}
		}

		if ($blnSuccess)
		{
			$r->saSuccess("Se ha registrado la toma de inventario de Stock y se han realizado los movimientos correspondientes.");

			$tid->transaccionCommit();
			$r->script("mdlExitWait(); app.chkVerCapturados = true; app.setTomaInventarioID();");
		}
		else 
		{
			$tid->transaccionRollback();
			$r->saError("Error: ".$error);
		}

				

		return $r;
	}
	$xajax->registerFunction("registrarProductos");

	function loadTomaInventarioActual($idTomaInventario)
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		$toma = new ModeloTomainventariodetalle();

		$lst = $toma->getAll("tomainventariodetalle.idtomainventariodetalle, tomainventariodetalle.idremisionrollo, 
		tomainventariodetalle.norollo, tomainventariodetalle.idrollooriginal, 
		tomainventariodetalle.idrolloupdate, tomainventariodetalle.kilosoriginal, tomainventariodetalle.kilosupdate,
		tomainventariodetalle.almacenoriginal, tomainventariodetalle.almacenupdate,
		remisionrollo.idremisionrollo rridremisionrollo, remisionrollo.remision rrremision, remisionrollo.norollo rrnorollo, 
		remisionrollo.remisionrollo_rollo_idrollo rridrollo, remisionrollo.kilos rrkilos, 
		remisionrollo.existencia rrexistencia, remisionrollo.almacen rralmacen,
		ifnull(registroproduccion.idregistroproduccion, 0) idregistroproduccion, 
		ifnull(registroproduccion.kilosmaquilados,0) kilosmaquilados, 
		ifnull(registroproduccion.terminado, 'SI') terminado,
		rollo.codigo",
		"inner join remisionrollo on tomainventariodetalle.idremisionrollo = remisionrollo.idremisionrollo
		left join registroproduccion on remisionrollo.idremisionrollo = registroproduccion.idremisionrollo 
		inner join rollo on remisionrollo.remisionrollo_rollo_idrollo = rollo.idrollo",
		"tomainventariodetalle.idTomaInventario = " . $idTomaInventario);

		

		$push = "";
		foreach ($lst as $item) 
		{
			$push .= "
				app.ingresosCapturados.push({
					idtomainventariodetalle: ".$item["idtomainventariodetalle"].",	
					idremisionrollo: ".$item["idremisionrollo"].",
					norollo: '".$item["norollo"]."',
					idrollo: ".$item["idrolloupdate"].",
					codigo: '".$item["codigo"]."',
					idrollooriginal: ".$item["idrolloupdate"].",
					almacen: '".$item["almacenupdate"]."',
					almacenoriginal: '".$item["almacenupdate"]."',
					kilos: ".$item["kilosupdate"].",
					kilosoriginal: ".$item["kilosupdate"].",
					existencia: ".$item["rrexistencia"].",
					cargadoensistema: true,
					infosistemacargada: true,
					oklista: 'SI',
					idregistroproduccion: ".$item["idregistroproduccion"].",
					rpterminado: '".$item["terminado"]."',
					rpmaquilados: ".$item["kilosmaquilados"]."
				});
			";
		}

		$r->script(" app.ingresosCapturados.splice(0, app.ingresosCapturados.length); ". $push . " mdlExitWait();");

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("loadTomaInventarioActual");


	function loadTomaInventarioStockActual($idTomaInventario)
	{
		$r = new xajaxResponse();
		// $r->starDebug();

		$toma = new ModeloTomainventariodetalle();

		$lst = $toma->getAll("tomainventariodetalle.idtomainventariodetalle, viewproductos.codigo , tomainventariodetalle.idproducto, tomainventariodetalle.existenciaoriginal, tomainventariodetalle.existenciaupdate, 
		         viewproductos.descauto descripcion",
		"inner join viewproductos on tomainventariodetalle.idproducto = viewproductos.idproducto",
		"tomainventariodetalle.idTomaInventario = " . $idTomaInventario);

		

		$push = "";
		foreach ($lst as $item) 
		{
			$push .= "
				app.productosCapturados.push({
					idproducto: ".$item["idproducto"].",
					codigo: '".$item["codigo"]."',
					descripcion: '".$item["descripcion"]."',
					existencia: ".$item["existenciaoriginal"].",
					inventario: ".$item["existenciaupdate"]."
							
					
				});
			";
		}

		$r->script(" app.productosCapturados.splice(0, app.productosCapturados.length); ". $push . " mdlExitWait();");

		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("loadTomaInventarioStockActual");
	
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
		
	
	$rollo = new ModeloRollo();
	
	$lst = $rollo->getAll("idRollo, codigo", "", "idRollo > 1 and estado = 'ACTIVO'", "rollo_material_idMaterial, calibre, pies, grado");

	// echo $rollo->getAllQUERY("idRollo, codigo", "", "idRollo > 1 and estado = 'ACTIVO'", "rollo_material_idMaterial, calibre, pies, grado");
	
	$lstRollos = "<option value=\"1\">-- Seleccione --</option>";
	foreach ($lst as $item) {
		$lstRollos.="<option value=\"".$item["idRollo"]."\">".$item["idRollo"]." - ".$item["codigo"]."</option>";
	}
