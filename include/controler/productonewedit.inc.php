<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.producto.inc.php";
	require_once FOLDER_MODEL. "model.material.inc.php";
	require_once FOLDER_MODEL. "model.aplicacion.inc.php";
	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";
	require_once FOLDER_MODEL. "model.unidad.inc.php";
	require_once FOLDER_MODEL. "model.rollo.inc.php";
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
	
   	 //ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function guardarProducto($idProducto, $codigo, $idTipoProducto, $idAplicacion, $idMaterial, $idRollo, $calibre, $pies, $origen, $descripcion, $longitud, $mlpieza, $unidad, $listaPrecio, $tipoRango, $isRollo, $precio1, $precio2, $precio3, $precio4, $precioMendez, $costo, $medidaespecial)
	{
		global $objSession;
		$r = new xajaxResponse();
		
		$producto = new ModeloProducto();
		$isInsert = false;
		$regresar = false;
 		//$r->starDebug();
		
		
		if ($idTipoProducto == 5)
		{
			$rollo = new ModeloRollo();
			$rollo->setIdRollo($idRollo);
			if ($rollo->getIdRollo() <= 0)
			{
				$r->saError("Ocurri� un error al intentar obtener la informaci�n del Rollo");
				return $r;
			}
			
			$codigo = $rollo->getCodigo();
			
		}
		
		$codigo = str_replace("  ", " ", $codigo);
		$codigo = str_replace("  ", " ", $codigo);
		$codigo = str_replace("  ", " ", $codigo);
		
		
		if ($producto->existeField("codigo", $codigo, $idProducto))
		{
			if ($isRollo)
			{
				$r->script("app.errProductoRollo = \"". mb_convert_encoding("Este Rollo ya está siendo utilizado como Producto. Debe seleccionar uno diferente.", 'UTF-8', 'ISO-8859-1') ."\"; ");
			}
			else
			{

				$r->script("app.errCodigo = \"". mb_convert_encoding("Este Código ya está siendo utilizado. Se debe armar uno diferente.", 'UTF-8', 'ISO-8859-1') ."\"; ");
			}
			
			$regresar = true;
		}
		
		
		
		if ($regresar)
		{
			return $r;
		}
		
		
		
		if ($idProducto == 0)
		{
			$isInsert = true;			
			$producto->setIdUsuarioCrea($objSession->getIdUsuario());
			$producto->setFecha_creacion($producto->NOW());
		}
		else
		{
			$producto->setIdProducto($idProducto);
			$producto->setIdUsuarioModifica($objSession->getIdUsuario());
			$producto->setFecha_modifica($producto->NOW());
			
		}
		
		if ($idAplicacion == 0) $idAplicacion = 1;
		if ($idRollo == 0) $idRollo = 1;
		
// 		if ($idRollo == 1 && $unidad != 4)
// 		{
			// 					if ($unidad != 4)
				// 					{
// 			$r->mostrarAviso("Cuando un producto no es por Pieza, debe seleccionar el Rollo Origen.");
// 			return $r;
			// 					}
					
// 		}
		
// 		if ($idRollo == 1 &&  $calibre == "0")
// 		{
// 			if ($idTipoProducto != 4)
// 			{
// 			    if ($idMaterial != 6 && $idMaterial != 7 && $idMaterial != 16 && $idMaterial != 17 
// 			        && $idMaterial != 18 && $idMaterial != 27  && $idMaterial != 32 && $idMaterial != 33 && $idMaterial = 15)
// 				{
// // 					if ($unidad != 4)
// // 					{
// 						$r->mostrarAviso("Favor de ingresar Calibre");
// 						return $r;
// // 					}
					
// 				}
// 			}
// 		}
		
// 		$r->mostrarAviso($codigo);
		$codigo = str_replace("  ", " ", $codigo);
		$codigo = str_replace("  ", " ", $codigo);
		$codigo = str_replace("  ", " ", $codigo);
// 		$r->mostrarAviso($codigo);
		
		$producto->setCodigo($codigo);
		$producto->setProducto_tipoProducto_idTipoProducto($idTipoProducto);
		$producto->setProducto_aplicacion_idAplicacion($idAplicacion);
		$producto->setProducto_material_idMaterial($idMaterial == 0 ? 1 : $idMaterial);
		$producto->setProducto_rollo_idRollo($idRollo);
		$producto->setCalibre($calibre);
		$producto->setPies($pies);	
		$producto->setOrigen($origen);
		
		$producto->setLongitud($longitud);
		$producto->setMlpieza($mlpieza);
		$producto->setMedidaespecial($medidaespecial);
		$producto->setTipoPrecio('G'); //$listaPrecio);
		$producto->setIsRango($tipoRango == '0' ? '0' : '1');
		$producto->setTipoRango($tipoRango);
		$producto->setIsRollo($isRollo ? '1' : '0');
		$producto->setProducto_unidad_idUnidad($unidad);
		
		$producto->setDescripcion(nl2br($descripcion));
		
		$producto->setPrecio1($precio1);
		$producto->setPrecio2($precio2);
		$producto->setPrecio3($precio3);
		$producto->setPrecio4($precio4);
		$producto->setPreciomendez($precioMendez);
		$producto->setCosto($costo);
		
		
		//		$r->mostrarExito("hola mundo"); return $r;
		//  		ob_start();
		
		//$r->mostrarAviso($producto->Guardar() . __LINE__); return $r;	
		//$rr = $producto->Guardar();
		$producto->Guardar();
		//$r->mostrarExito($rr); return $r;
  		// $debug = ob_get_clean();
  		// $r->mostrarAviso($debug); return $r;
		if ($producto->getError())
		{
			$r->saError($producto->getStrError());
			return $r;
		}
		if ($isInsert)
		{
			$r->saSuccess("El Producto " . $codigo . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "producto",2);
		}
		else
		{
			$r->saSuccess("El Producto " . $codigo . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "producto",2	);
		}

// 			$debug = ob_get_clean();
// 			$r->mostrarExito($debug);
// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("guardarProducto");
	
	function setPreciosByRollo($idRollo)
	{
	    $r = new xajaxResponse();	    
		// $r->starDebug();
		
	    
	    if ($idRollo <=1)
	    {
	        return $r;
		}
		
		
		 
	    $rollo = new ModeloRollo();
	    
	    $rollo->setIdRollo($idRollo);
	    
	    if ($rollo->getIdRollo() <= 1)
	    {
			
	        return $r;
		}
		
		
	    $r->script("
    
                app.precio1 = ".$rollo->getTotalpreciovta().";
                app.precio2 = ".$rollo->getTotalpreciovtar2().";
                app.precio3 = ".$rollo->getTotalpreciovtar3().";
				app.precio4 = ".$rollo->getTotalpreciovtar4().";
	    		
        
                ");
	    
	    return $r;
	}
	$xajax->registerFunction("setPreciosByRollo");
	
	function cargarProducto($idProducto)
	{
		$r = new xajaxResponse();

		$producto = new ModeloProducto();

		if ($idProducto <= 0)
		{
			$r->saError("No se han podido cargar los datos del Producto.");
			$r->redirect(URL_BASE . "producto", 2);
			return $r;
		}

		$producto->setIdProducto($idProducto);

		//verifica si el rollo fue cargado
		if ($producto->getIdProducto() <= 0)
		{
			$r->saError("No se han podido cargar los datos del Producto.");
			$r->redirect(URL_BASE . "producto", 2);
			return $r;
		}

		$producto->getDatosReferencia();

		$desc=str_replace(chr(13),'', mb_convert_encoding($producto->getDescripcion(), 'ISO-8859-1', 'UTF-8'));
		$desc=str_replace('<br />','\n', $desc);
		$desc=str_replace(chr(10),'', $desc);
		$desc=mb_convert_encoding($desc, 'UTF-8', 'ISO-8859-1');

		$r->script("
					app.isLoading = true;
				    app.sucCodigo = '".mb_convert_encoding("El código ya es correcto y no debe cambiar", 'UTF-8', 'ISO-8859-1')."';
				    app.tipoProducto = '" . $producto->getProducto_tipoProducto_idTipoProducto() . "=>" . $producto->TipoProducto->getClave()  . "';
				    app.aplicacion = '" . $producto->getProducto_aplicacion_idAplicacion() . "=>" . $producto->Aplicacion->getNombreAplicacion() . "';
					app.material = '" . $producto->getProducto_material_idMaterial() . "=>" . $producto->Material->getClave() . "';
					app.calibre = '" . $producto->getCalibre() . "';				
				    app.rollo = " . $producto->getProducto_rollo_idRollo() . ";
                    app.codigo = '" . $producto->getCodigo() . "';
				    
				    app.codigoAccesorio = '" . $producto->getCodigo() . "';
				    app.productoRollo = " . $producto->getProducto_rollo_idRollo() . ";
				    app.longitud = '" . $producto->getLongitud() . "';
					app.mlpieza = '" . $producto->getMlpieza() . "';
					app.medidaespecial = '" . $producto->getMedidaespecial() . "';
				
		
					app.precio1 = '" . $producto->getPrecio1() . "';
				    app.precio2 = '" . $producto->getPrecio2() . "';
				    app.precio3 = '" . $producto->getPrecio3() . "';
					app.precio4 = '" . $producto->getPrecio4() . "';
					app.preciomendez = '" . $producto->getPreciomendez() . "';
					app.costo = '" .$producto->getCosto() . "';
					
				
				
				    app.unidad = " . $producto->getProducto_unidad_idUnidad() . ";
					app.listaPrecio = '" . $producto->getTipoPrecio() . "';				 
				    app.isRango = " . ($producto->getIsRango() == "1" ? "true" : "false") . ";
				    app.tipoRango = '" . ($producto->getTipoRango()) . "';
				
					app.descripcion = '" . $desc . "';
					setTimeout(function(){app.verificaIsPieza();}, 500);
				    setTimeout(function() {\$('#unidad').attr('disabled', true); app.rollo = " . $producto->getProducto_rollo_idRollo() . "}, 1000);
					setTimeout(function() { app.origen = '".$producto->getOrigen()."'; app.calibre = '" . $producto->getCalibre() . "'; app.pies = '" . $producto->getPies() . "'; }, 1200);
				    setTimeout(function() { app.idTipoProducto = " . $producto->getProducto_tipoProducto_idTipoProducto() . "; app.claveTipoProducto = '" . $producto->TipoProducto->getClave()  . "'; app.idAplicacion = " . $producto->getProducto_aplicacion_idAplicacion() . "; app.idMaterial = " . $producto->getProducto_material_idMaterial() . "; app.claveMaterial = '" . $producto->Material->getClave() . "'; }, 600);
				    setTimeout(function() {  xajax_setPreciosByRollo(".$producto->getProducto_rollo_idRollo().");}, 1250);
				  ");

		return $r;
	}	
	$xajax->registerFunction("cargarProducto");

	function obtenerClaveMaterial($clave)
	{
		$r = new xajaxResponse();
		
		$datos = explode("=>", $clave);
// 		$r->mostrarAviso("IdMAterial: " . $datos[0]);
		$r->script(" app.idMaterial = " . $datos[0] . "; app.claveMaterial = '" . $datos[1] . "';" );
		
		return $r;
		
	}
	$xajax->registerFunction("obtenerClaveMaterial");
	
	function obtenerClaveAplicacion($clave)
	{
		$r = new xajaxResponse();
	
		$datos = explode("=>", $clave);
	
		$r->script(" app.idAplicacion = " . $datos[0] . "; app.textoAplicacion = '" . $datos[1] . "'; ");
	
		
		return $r;
	
	}
	$xajax->registerFunction("obtenerClaveAplicacion");
	
	function obtenerClaveTipoProducto($clave)
	{
		$r = new xajaxResponse();
	
		$datos = explode("=>", $clave);
	
		$r->script(" app.idTipoProducto = " . $datos[0] . "; ". ($datos[0] == "5" ? "app.unidad = 3; app.listaPrecio = 'G'; app.isRango = false; setTimeout(function(){app.disableListasUnidadesPrecios(true);}, 300); " : ($datos[0] == "4" ? " app.unidad = 4; app.listaPrecio = 'G'; app.isRango = false; setTimeout(function(){app.disableListasUnidadesPrecios(true);}, 300); " : " setTimeout(function(){app.disableListasUnidadesPrecios(false);}, 300); ")) ." app.claveTipoProducto = '" . $datos[1] . "';" );
	
		return $r;
	
	}
	$xajax->registerFunction("obtenerClaveTipoProducto");
	
	function obtenerCalibreRollo($idRollo)
	{
		$r = new xajaxResponse();
		
		if($idRollo <= 1 )
		{
			$r->script("
					   app.rolloCodigo = '';
					   app.calibre = 0;
					   app.pies = 0;
					   app.idMaterial = 0;
					   app.origen = 'N';
					
					");
			return $r;
		}
		
		
		$rollo = new ModeloRollo();
		$rollo->setIdRollo($idRollo);
		
// 		$r->mostrarAviso("codigo rollo " .$rollo->getCodigo());
		
		$r->script("
				 app.rolloCodigo = '".$rollo->getCodigo()."';
				 app.calibre = ".$rollo->getCalibre().";
				 app.pies = ".$rollo->getPies().";
				 app.idMaterial = ".$rollo->getRollo_material_idMaterial().";
                 app.origen = '".$rollo->getOrigen()."';
				
				");
		
// 		$r->mostrarAviso($rollo->getCodigo());
	
		return $r;
	
	}
	$xajax->registerFunction("obtenerCalibreRollo");

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
	
	$unidad = new ModeloUnidad();
		
	$lstUnidades = $unidad->getForSelect("idUnidad", "concat(clave,' - ',descripcion)");
		
	$material = new ModeloMaterial();
			
	$lstMateriales = $material->getForSelect("concat(idMaterial, '=>' ,clave)", "nombre", "idMaterial >= 1 and estado = 'ACTIVO'");
	
	$tipoProducto = new ModeloTipoproducto();
		
	$lstTiposProducto = $tipoProducto->getForSelect("concat(idTipoProducto, '=>' ,clave)", "nombre");	
	
	
	
		
	$aplicacion = new ModeloAplicacion();
	
	$lstModelosLamina = $aplicacion->getForSelect("concat(idAplicacion, '=>' ,nombreAplicacion)", "nombreAplicacion", "idAplicacion > 1 and estado = 'ACTIVO'");
	
	$rollo = new ModeloViewrollos();
	
	$lstRollos = $rollo->getForSelect("idRollo", "concat(codigo, ' - ', descauto)",  " estado = 'ACTIVO'", " shortMaterial, calibre, pies");
	$lstRollosRollo = $rollo->getForSelect("idRollo", "concat(codigo, ' - ', descauto)", "idRollo > 1 and estado = 'ACTIVO'", " shortMaterial, calibre, pies");
	
			
	$lstCalibres = array (
			              array("value" => "0", "theoption" => "-- NO APLICA --" ),
						  array("value" => "20", "theoption" => "20" ),
			              array("value" => "22", "theoption" => "22" ),
			              array("value" => "24", "theoption" => "24" ),
						  array("value" => "2424", "theoption" => "24/24" ),
			              array("value" => "2426", "theoption" => "24/26" ),
						  array("value" => "26", "theoption" => "26"),
						  array("value" => "2626", "theoption" => "26/26"),
			              
			              array("value" => "2628", "theoption" => "26/28"),
			              array("value" => "28", "theoption" => "28" ),
						  array("value" => "2828", "theoption" => "28/28" )
			            );
	
	$lstPies = array (						  
	                      
			              array("value" => "2", "theoption" => "2" ),
			              array("value" => "3", "theoption" => "3" ),
			              array("value" => "4", "theoption" => "4" )		
	                     );
	
	$lstOrigen = array (						  
			              array("value" => "N", "theoption" => "NACIONAL" ),
			              array("value" => "I", "theoption" => "IMPORTADO" )
	                     );
	
	$lstListaPrecio = array (
			array("value" => "G", "theoption" => "Galvamex" ),
			array("value" => "I", "theoption" => "Importados" ),
			array("value" => "T", "theoption" => "Ternium" )			
		);

	$lstListaTipoRango = array (
			// array("value" => "", "theoption" => "- Sin Rango -" ),
			array("value" => "A", "theoption" => "Lámina Metálica" ),
			array("value" => "C", "theoption" => "Panel" ),
			array("value" => "B", "theoption" => "Traslucida" ),			
			array("value" => "R", "theoption" => "Rollo" )			
		);
	

		
	$disableSelect = false;
	
	if (isset($param1))
	{
		if ($param1 > 0)
		{
			$disableSelect = false;
		}
		
	}
		
	