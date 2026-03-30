<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.material.inc.php";
	require_once FOLDER_MODEL. "model.proveedor.inc.php";
	require_once FOLDER_MODEL. "model.color.inc.php";

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

	function guardarRollo($idRollo, $codigo, $idMaterial, $calibre, $pies, $origen, $idProveedor, $idColor, $grado, $descripcion, $observaciones, $precio1, $precio2, $precio3, $precio4, $preciokg1, $preciokg2, $preciokg3, $preciokg4)
	{
		$r = new xajaxResponse();
		$rollo = new ModeloRollo();
		$isInsert = false;
		$regresar = false;


		if ($rollo->existeField("codigo", $codigo, $idRollo))
		{
			$r->script("app.errCodigo = \"".mb_convert_encoding("Este C�digo ya est� siendo utilizado. Se debe armar uno diferente.", 'UTF-8', 'ISO-8859-1')."\"; ");
			$regresar = true;
		}

		if ($regresar)
		{
			return $r;
		}

		if ($idRollo == 0)
		{
			$isInsert = true;
			$rollo->setDateAndUser("creacion");
			//$rollo->setDateUserCreating();
		}
		else
		{
			$rollo->setIdRollo($idRollo);
			$rollo->setDateAndUser("modifica");
 			//$rollo->setDateUserUpdating();
		}
// $r->mostrarAviso($pies);
		$rollo->setCodigo($codigo);
		$rollo->setRollo_material_idMaterial($idMaterial);
		$rollo->setCalibre($calibre);
		$rollo->setPies($pies);
		$rollo->setOrigen($origen);
		$rollo->setRollo_proveedor_idProveedor($idProveedor);
		$rollo->setTotalpreciovta($precio1);
		$rollo->setTotalpreciovtar2($precio2);
		$rollo->setTotalpreciovtar3($precio3);
		$rollo->setTotalpreciovtar4($precio4);
		
		$rollo->setPreciokg1($preciokg1);
		$rollo->setPreciokg2($preciokg2);
		$rollo->setPreciokg3($preciokg3);
		$rollo->setPreciokg4($preciokg4);

		$rollo->setRollo_color_idColor($idColor);
		$rollo->setGrado($grado);

		$rollo->setDescripcion(nl2br($descripcion));
		$rollo->setObservaciones(nl2br($observaciones));
		$rollo->Guardar();

		if ($rollo->getError())
		{
			$r->saError($rollo->getStrError());
			return $r;
		}

		if ($isInsert)
		{
			$r->saSuccess("El Rollo " . $codigo . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "rollo",2);
		}
		else
		{
			$r->saSuccess("El Rollo " . $codigo . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "rollo",2	);
		}


		return $r;
	}
	$xajax->registerFunction("guardarRollo");

	function cargarRollo($idRollo)
	{
		$r = new xajaxResponse();

		$rollo= new ModeloRollo();
		$color = new ModeloColor();

		if ($idRollo <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}

		$rollo->setIdRollo($idRollo);

		//verifica si el rollo fue cargado
		if ($rollo->getIdRollo() <= 0)
		{
			$r->saError("No se han podido cargar los datos del rollo.");
			$r->redirect(URL_BASE . "rollo", 2);
			return $r;
		}

		$rollo->getDatosReferencia();

		$color->setIdColor($rollo->getRollo_color_idColor());



		$desc=str_replace(chr(13),'', $rollo->getDescripcion());
		$desc=str_replace('<br />','\n', $desc);
		$desc=str_replace(chr(10),'', $desc);

		$obs=str_replace(chr(13),'', $rollo->getObservaciones());
		$obs=str_replace('<br />','\n', $obs);
		$obs=str_replace(chr(10),'', $obs);

		// $r->saSuccess($rollo->getPies()); return $r;
		//$r->mostrarExito($val);

		$r->script("
					app.sucCodigo = '"."El código ya es correcto y no debe cambiar"."';
					app.material = '" . $rollo->getRollo_material_idMaterial() . "=>" . $rollo->Material->getClave() . "';
					app.calibre = '" . $rollo->getCalibre() . "';
					app.origen = '" . $rollo->getOrigen() . "';
					app.color = '" . $rollo->getRollo_color_idColor()."=>".$color->getClave() . "';
					app.grado = '" . $rollo->getGrado() . "';
			 		app.pies = '" . str_replace(".00","",$rollo->getPies()) . "';
			 		app.proveedor = '" . $rollo->getRollo_proveedor_idProveedor() . "=>" . $rollo->Proveedor->getClave() . "';
                    app.codigo = '" . $rollo->getCodigo() . "';
					app.descripcion = '" . $desc . "';
                    app.observaciones = '" . $obs . "';
				  ");


		return $r;
	}
	$xajax->registerFunction("cargarRollo");

	function obtenerClaveMaterial($clave)
	{
		$r = new xajaxResponse();

		$datos = explode("=>", $clave);

		$r->script(" app.idMaterial = " . $datos[0] . "; app.claveMaterial = '" . $datos[1] . "';" );

		return $r;

	}
	$xajax->registerFunction("obtenerClaveMaterial");

	function obtenerClaveColor($clave)
	{
		$r = new xajaxResponse();

		$datos = explode("=>", $clave);

		$r->script(" app.idColor = " . $datos[0] . "; app.claveColor = '" . $datos[1] . "';" );

		return $r;

	}
	$xajax->registerFunction("obtenerClaveColor");

	function obtenerClaveProveedor($clave)
	{
		$r = new xajaxResponse();

		$datos = explode("=>", $clave);

		$r->script(" app.idProveedor = " . $datos[0] . "; app.claveProveedor = '" . $datos[1] . "';" );

		return $r;

	}
	$xajax->registerFunction("obtenerClaveProveedor");

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

	$material = new ModeloMaterial();

	$lstMateriales = $material->getForSelect("concat(idMaterial, '=>' ,clave)", "nombre", "idMaterial > 1 AND estado = 'ACTIVO'");


	$lstCalibres = array (
						  array("value" => "20", "theoption" => "20" ),
			              array("value" => "22", "theoption" => "22" ),
			              array("value" => "24", "theoption" => "24" ),
			              array("value" => "26", "theoption" => "26" ),
			              array("value" => "28", "theoption" => "28" ),
			            );

	$lstPies = array (
			              array("value" => "2", "theoption" => "2" ),
			              array("value" => "3", "theoption" => "3" ),
                    	    array("value" => "3.48", "theoption" => "3.48" ),
                    	    array("value" => "3.76", "theoption" => "3.76" ),
			              array("value" => "4", "theoption" => "4" )
	                     );

	$lstGrados = array (

			              array("value" => "33", "theoption" => "33" ),
			              array("value" => "37", "theoption" => "37" )
	                );

	$lstOrigen = array (
			array("value" => "N", "theoption" => "NACIONAL" ),
			array("value" => "I", "theoption" => "IMPORTADO" )
	);

	$proveedor = new ModeloProveedor();

	$lstProveedores = $proveedor->getForSelect("concat(idProveedor, '=>' ,clave)", "nombre", "idProveedor > 1 AND estado = 'ACTIVO'");

	$color = new ModeloColor();

	$lstColores = $color->getForSelect("concat(idColor, '=>' ,clave)", "nombre", "estado = 'ACTIVO'");

	$disableSelect = false;

	if (isset($param1))
	{
		if ($param1 > 0)
		{
			$disableSelect = true;
		}

	}
