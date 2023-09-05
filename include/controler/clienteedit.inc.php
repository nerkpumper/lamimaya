<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	require_once FOLDER_MODEL. "model.usocfdi.inc.php";

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

	function guardarCliente($idCliente, $nombre, $apellidos, $empresa, $domicilio1, $domicilio2, $numero, $colonia, $ciudad, $telefonos, $email, $rfc, $estado, $idUsuarioPromotor, $facturable, $razonSocial, $domicilioFiscal, $cp,$cpfiscal, $usoCFDI,$samedata,$coloniafiscal,$ciudadfiscal,$numerofiscal)
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
		$cliente->setEmpresa($samedata == true ? $razonSocial: $empresa);
		$cliente->setDomicilio1($samedata == true ? $domicilioFiscal: $domicilio1);
		$cliente->setDomicilio2($domicilio2);
		$cliente->setCodigopostal($samedata == true ? $cpfiscal: $cp);
		$cliente->setNumero($samedata == true ? $numerofiscal: $numero);
		$cliente->setColonia($samedata == true ? $coloniafiscal: $colonia);
		$cliente->setCiudad($samedata == true ? $ciudadfiscal: $ciudad);
		$cliente->setTelefonos($telefonos);
		$cliente->setEmail($email);
		$cliente->setRfc($rfc);
		$cliente->setEstado($estado);
		$cliente->setIdUsuarioPromotor($idUsuarioPromotor);
		
		if ($facturable)
		{
		    $cliente->setFacturableSI();
		}
		else
		{
		    $cliente->setFacturableNO();
		}
		
		if ($samedata){
		    $cliente->setSameDataSI();
		}else
		{
		    $cliente->setSameDataNO();
		}
		
		$cliente->setRazonsocial($razonSocial);
		$cliente->setDomiciliofiscal($domicilioFiscal);
		$cliente->setCodigopostalfiscal($cpfiscal);
		$cliente->setIdUsoCfdi($usoCFDI);
		$cliente->setColoniafiscal($coloniafiscal);
		$cliente->setCiudadfiscal($ciudadfiscal);
		$cliente->setNumerofiscal($numerofiscal);
		
		$cliente->Guardar();

		if ($cliente->getError())
		{
			$r->saError($cliente->getStrError());
			return $r;
		}

		if ($isInsert)
		{
			$r->saSuccess("El Cliente " .$nombre . " " . $apellidos . " se ha almacenado satisfactoriamente. id: " .$cliente->getIdCliente() );
			$r->redirect(URL_BASE . "clienteedit/" . $cliente->getIdCliente(),2);
		}
		else
		{
			$r->saSuccess("El Cliente " .$nombre . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "clienteedit/" . $cliente->getIdCliente(),2);
		}
		
		
		
// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("guardarCliente");

	function cargarCliente($idCliente)
	{
		$r = new xajaxResponse();

		$cliente= new ModeloCliente();

		if ($idCliente <= 0)
		{
			$r->saError("No se han podido cargar los datos del Cliente.");
			$r->redirect(URL_BASE . "cliente", 2);
			return $r;
		}

		$cliente->setIdCliente($idCliente);

		//verifica si el usuario fue cargado
		if ($cliente->getIdCliente() <= 0)
		{
			$r->saError("No se han podido cargar los datos del Cliente.");
			$r->redirect(URL_BASE . "cliente", 2);
			return $r;
		}
		
	/*	if ($facturable)
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
		
*/

		$r->script("
				    app.nombre = '" . $cliente->getNombre() . "';
				    app.apellidos = '" . $cliente->getApellidos() . "';
				    app.empresa = '" . $cliente->getEmpresa() . "';
				    app.domicilio1 = '" . $cliente->getDomicilio1() . "';
				    app.domicilio2 = '" . $cliente->getDomicilio2() . "';
                    app.CP = '". $cliente->getCodigopostal() ."';
					app.numero = '" . $cliente->getNumero() . "';
					app.colonia = '" . $cliente->getColonia() . "';
					app.ciudad = '" . $cliente->getCiudad() . "';
				    app.telefonos = '" . $cliente->getTelefonos() . "';
                    app.email = '" . $cliente->getEmail() . "';
				    app.rfc = '" . $cliente->getRfc() . "';
                    app.estatus = '" . $cliente->getEstado() . "';
					app.usuarioPromotor = '" . $cliente->getIdUsuarioPromotor() . "';

                    app.chkFacturable = ". ($cliente->getFacturable() == 'SI' ? "true" : "false") .";
                    app.chkSameData = ". ($cliente->getSameData() == 'SI' ? "true" : "false") .";
                    app.razonSocial = '".$cliente->getRazonsocial()."';
                    app.domicilioFiscal = '".$cliente->getDomiciliofiscal()."';
                    app.CPFiscal = '". $cliente->getCodigopostalfiscal() ."';
                    app.numeroFiscal = '" . $cliente->getNumerofiscal() . "';
					app.coloniaFiscal = '" . $cliente->getColoniafiscal() . "';
					app.ciudadFiscal = '" . $cliente->getCiudadfiscal() . "';
                    app.usoCFDI = '".$cliente->getIdUsoCfdi() ."';

				  ");

		return $r;
	}
	$xajax->registerFunction("cargarCliente");

	function setPromotor()
	{
		$r = new xajaxResponse();

		if (Permisos::getRolInBinary() == Permisos::$rol_PROMOTOR || 
		    Permisos::getRolInBinary() == Permisos::$rol_PROMOTORPRODUCCION || 
		    Permisos::getRolInBinary() == Permisos::$rol_CXCVENTAS ||
		    Permisos::getRolInBinary() == Permisos::$rol_PROMOTORPLUSPRODUCCION)
		{
			$r->script("
					app.usuarioPromotor = '" . ModeloUsuario::getObjSession()->getIdUsuario() . "';
					app.mostrarUsuarioPromotor = false;

				  ");
		}

		return $r;
	}
	$xajax->registerFunction("setPromotor");



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

	$lstPromotores = $promotor->getForSelect("idUsuario", "nombre", "idRol IN (4,2, 7, 8, 11, 10) AND estatus = 'activo' ");

	$lstEstatus = array (
			              array("value" => "ACTIVO", "theoption" => "ACTIVO" ),
			              array("value" => "BAJA", "theoption" => "BAJA" )
			            );
	
	$uso = new ModeloUsocfdi();
	
	$lstUsoCFDI = $uso->getForSelect("idUsoCfdi", "concat(clave,' - ',descripcion)", "");
	
    