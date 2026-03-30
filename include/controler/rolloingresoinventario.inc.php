<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
	require_once FOLDER_MODEL. "model.viewrollos.inc.php";
	
	
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
// 			$r->script("app.errCodigo = \"Este Código ya está siendo utilizado. Se debe armar uno diferente.\"; ");
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

	function registrarIngresos($idRollo, $almacen, $comprador, $strremision, $ingresos)
	{
		$r = new xajaxResponse();
		
// 		$r->starDebug();
		if ($idRollo <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}
		
// 		$r->mostrarAviso("Remision: " . $remision);
		
		$idUsuario = ModeloUsuario::getObjSession()->getIdUsuario();
		
		
		
		$remision = new ModeloRemisionrollo();
		
// 		$r->script("
// 					    var i2;
// 					    for (i2 = 0 ; i2 < app.ingresos.length ; i2++)
// 					    {
// 					         app.ingresos[i2].estatusLabel = \"<span class='label label-info'>Enlistado</span>\";
// 					    }					
			
// 					   ");
		
// 		$blnHayRepetidos = false;
// 		$strLabelRepetidos = "";
// 		$blnListoParaGuardar = true;
		
// 		//se verifica que no haya repetidos en la lista
// 		foreach ($ingresos as $key=>$item)
// 		{		
// 			foreach ($ingresos as $key2=>$item2)
// 			{
// 				if (trim($item["noRollo"]) == trim($item2["noRollo"]) && $key != $key2)
// 				{
// 					$blnHayRepetidos = true;
// 					$blnListoParaGuardar = false;
// 					$strLabelRepetidos .= "app.ingresos[" . $key . "].estatusLabel = \"<span class='label label-warning'>" . mb_convert_encoding("Número de rollo repetido en lista.", 'UTF-8', 'ISO-8859-1') . "</span>\";";
// 				}	
// 			} 			
// 		}
		
// 		if ($blnHayRepetidos)
// 		{
// 			$r->script("app.blnNoRegistrados = true;" . $strLabelRepetidos);
// 		}
		
// 		//se verifica que no hayan registrado previamente el numero de rollo
// 		foreach ($ingresos as $key=>$item)
// 		{
// 			if ($remision->existeField("noRollo", $item["noRollo"]))
// 			{
// 				$blnHayRepetidos = true;
// 				$blnListoParaGuardar = false;
// 				$strLabelRepetidos .= "app.ingresos[" . $key . "].estatusLabel = \"<span class='label label-danger'>" . mb_convert_encoding("Número de rollo ya ha sido ingresado previamente.", 'UTF-8', 'ISO-8859-1') . "</span>\";";
// 			}
// 		}
		
// 		if ($blnHayRepetidos)
// 		{
// 			$r->script("app.blnNoRegistrados = true;" . $strLabelRepetidos);
// 		}
		
		
// 		if (!$blnListoParaGuardar)
// 		{
// 			return $r;
// 		}
		
    
		//comenzamos la transacción para meter toda la lista
		$remision->transaccionIniciar();
		
		$doCommit = true;
		
		foreach ($ingresos as $item)
		{			
			$remision = new ModeloRemisionrollo();
			$remision->setRemisionRollo_rollo_idRollo($idRollo);
			$remision->setRemision($strremision);			
			$remision->setNoRollo($item["norollo"]);
			$remision->setKilos($item["kilos"]);
			$remision->setExistencia($item["kilos"]);
			
			$remision->setAlmacen($almacen);
			$remision->setComprador($comprador);
			
// 			echo $idUsuario;
			
			$remision->setRemisionRollo_usuario_idUsuario($idUsuario);
// 			echo $remision;
			
			
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
					         app.ingresos[i].insertado = 'SI';
					    }
					
						window.location = URL_BASE + \"rolloremisionlastinsert/" . $idRollo . "\";
					
					   ");
		}
		else
		{
			$remision->transaccionRollback();
			$r->mostrarError("No se han podido registrar los ingresos.");
		}
		
// 		$r->endDegug();
		return $r;
	}
	$xajax->registerFunction("registrarIngresos");
	
	
	function verificaExistenciaRolloEnSistema($index, $norollo)
	{
	    $r = new xajaxResponse();
	    	    	    
	    $remision = new ModeloRemisionrollo();
	    
// 	    $r->script(" console.log('estoy en xajax');");
	    
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
		
	
		
	