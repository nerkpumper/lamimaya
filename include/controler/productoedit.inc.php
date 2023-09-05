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
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	
	//$xajax->de decodeUTF8InputOn();
	
//   	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function guardarProducto($idProducto, $codigo, $idTipoProducto, $idAplicacion, $idMaterial, $idRollo, $calibre, $pies, $descripcion, $longitud, $mlpieza, $unidad, $listaPrecio, $isRango, $isRollo, $precio1, $precio2, $precio3)
	{
		global $objSession;
		$r = new xajaxResponse();
		$producto = new ModeloProducto();
		$isInsert = false;
		$regresar = false;
		
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
		
		
		if ($producto->existeField("codigo", $codigo, $idProducto))
		{
			if ($isRollo)
			{
				$r->script("app.errProductoRollo = \"". utf8_encode("Este Rollo ya est� siendo utilizado como Producto. Debe seleccionar uno diferente.") ."\"; ");
			}
			else 
			{
				
				$r->script("app.errCodigo = \"". utf8_encode("Este C�digo ya est� siendo utilizado. Se debe armar uno diferente.") ."\"; ");
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
		
		if ($idRollo == 1 &&  $calibre == "0")
		{
			if ($idTipoProducto != 4)
			{
				if ($idMaterial != 6 && $idMaterial != 7)
				{
					if ($unidad != 4)
					{
						$r->mostrarAviso("Favor de ingresar Calibre");
						return $r;
					}
					
				}
			}
		}
		
		$producto->setCodigo($codigo);
		$producto->setProducto_tipoProducto_idTipoProducto($idTipoProducto);
		$producto->setProducto_aplicacion_idAplicacion($idAplicacion);
		$producto->setProducto_material_idMaterial($idMaterial);
		$producto->setProducto_rollo_idRollo($idRollo);
		$producto->setCalibre($calibre);
		$producto->setPies($pies);		
		
		$producto->setLongitud($longitud);
		$producto->setMlpieza($mlpieza);
		$producto->setTipoPrecio($listaPrecio);
		$producto->setIsRango($isRango ? '1' : '0');
		$producto->setIsRollo($isRollo ? '1' : '0');
		$producto->setProducto_unidad_idUnidad($unidad);
		
		$producto->setDescripcion(nl2br($descripcion));
		
		$producto->setPrecio1($precio1);
		$producto->setPrecio2($precio2);
		$producto->setPrecio3($precio3);
		
		
// 		$r->mostrarExito("hola mundo"); return $r;
// 		ob_start();
		$producto->Guardar();
// 		$debug = ob_get_clean();
// 		$r->mostrarAviso($debug); return $r;
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
		return $r;
	}
	$xajax->registerFunction("guardarProducto");
	
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
// 		echo "antes de getDatosRef";
		$producto->getDatosReferencia();
		
// 		$producto->TipoProducto->dumpObj();
// 		$producto->Aplicacion->dumpObj();
// 		$producto->Material->dumpObj();
// 		$producto->Rollo->dumpObj();
		
		
// 		echo "despues de getDatosRef";
// 		$debug = ob_get_clean();
// 		$r->mostrarAviso($debug);return $r;
		
		$desc=str_replace(chr(13),'', utf8_decode($producto->getDescripcion()));
		$desc=str_replace('<br />','\n', $desc);
		$desc=str_replace(chr(10),'', $desc);
		$desc=utf8_encode($desc);
		
		//$r->mostrarExito($val);
		
		$r->script("
					app.isLoading = true;
				    app.sucCodigo = '".utf8_encode("El c�digo ya es correcto y no debe cambiar")."';
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
				
		
					app.precio1 = '" . $producto->getPrecio1() . "';
				    app.precio2 = '" . $producto->getPrecio2() . "';
				    app.precio3 = '" . $producto->getPrecio3() . "';
				
				
				    app.unidad = " . $producto->getProducto_unidad_idUnidad() . ";
					app.listaPrecio = '" . $producto->getTipoPrecio() . "';				 
				    app.isRango = " . ($producto->getIsRango() == "1" ? "true" : "false") . ";
				
					app.descripcion = '" . $desc . "';
					setTimeout(function(){app.verificaIsPieza();}, 500);
					setTimeout(function() { app.calibre = '" . $producto->getCalibre() . "'; }, 1000);
				    
				
					
                    
				  ");
		
// 					$debug = ob_get_clean();
// 					$r->mostrarExito($debug);
		return $r;
	}	
	$xajax->registerFunction("cargarProducto");

	function obtenerClaveMaterial($clave)
	{
		$r = new xajaxResponse();
		
		$datos = explode("=>", $clave);
		
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
					   app.calibre = 0;
					   app.pies = 0;
					
					");
			return $r;
		}
		
		
		$rollo = new ModeloRollo();
		$rollo->setIdRollo($idRollo);
		
		$r->script("
				 app.calibre = ".$rollo->getCalibre().";
				 app.pies = ".$rollo->getPies().";
				
				");
	
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
			
	$lstMateriales = $material->getForSelect("concat(idMaterial, '=>' ,clave)", "nombre", "idMaterial > 1");
	
	$tipoProducto = new ModeloTipoproducto();
		
	$lstTiposProducto = $tipoProducto->getForSelect("concat(idTipoProducto, '=>' ,clave)", "nombre");	
	
		
	$aplicacion = new ModeloAplicacion();
	
	$lstModelosLamina = $aplicacion->getForSelect("concat(idAplicacion, '=>' ,nombreAplicacion)", "nombreAplicacion", "idAplicacion > 1");
	
	$rollo = new ModeloRollo();
	
	$lstRollos = $rollo->getForSelect("idRollo", "concat(codigo, ' - ', descripcion)");
	$lstRollosRollo = $rollo->getForSelect("idRollo", "concat(codigo, ' - ', descripcion)", "idRollo > 1");
	
			
	$lstCalibres = array (
			              array("value" => "0", "theoption" => "-- NO APLICA --" ),
						  array("value" => "20", "theoption" => "20" ),
			              array("value" => "22", "theoption" => "22" ),
			              array("value" => "24", "theoption" => "24" ),
			              array("value" => "26", "theoption" => "26" ),
			              array("value" => "28", "theoption" => "28" )
			            );
	
	$lstPies = array (						  
						  
			              array("value" => "2", "theoption" => "2" ),
			              array("value" => "3", "theoption" => "3" ),
			              array("value" => "4", "theoption" => "4" )		
	                     );
	
	$lstListaPrecio = array (
			array("value" => "G", "theoption" => "Galvamex" ),
			array("value" => "I", "theoption" => "Importados" ),
			array("value" => "T", "theoption" => "Ternium" )			
		);
	
		
	$disableSelect = false;
	
	if (isset($param1))
	{
		if ($param1 > 0)
		{
			$disableSelect = true;
		}
		
	}
		
	