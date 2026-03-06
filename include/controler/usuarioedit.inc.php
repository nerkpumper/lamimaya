<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	require_once FOLDER_MODEL. "model.rol.inc.php";

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

	function guardarUsuario($idUsuario, $username, $email, $nombre, $apaterno, $amaterno, $estatus, $idRol, $password = "", $tipoComision = null, $cobraComision = null)
	{
		global $_NOW_;
		global $objSession;
		$r = new xajaxResponse();
		$Usuario = new ModeloUsuario();
		$isInsert = false;
		$regresar = false;

		if ($Usuario->existeField("username", $username, $idUsuario))
		{
			$r->script(("app.errUsername = \"". "Este usuario ya está siendo utilizado. Debe especificar uno diferente." . "\"; "));
			$regresar = true;
		}

		if ($Usuario->existeField("email", $email, $idUsuario))
		{
			$r->script(("app.errEmail = \"" . "Este email ya esttá siendo utilizado. Debe especificar uno diferente." . "\"; "));
			$regresar = true;
		}

		if ($regresar)
		{
			return $r;
		}

		if ($idUsuario == 0)
		{
			$isInsert = true;
		}
		else
		{
			$Usuario->setIdUsuario($idUsuario);
		}

		$Usuario->setNombre($nombre);
		$Usuario->setUsername($username);
		$Usuario->setApellidoPaterno($apaterno);
		$Usuario->setApellidoMaterno($amaterno);
		$Usuario->setEmail($email);

		if($password!="")
		{
			$passwordHash= $password;
			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
			$passwordSalt = hash('sha512', $passwordHash . $random_salt);
			
			$Usuario->setPassword($passwordSalt);
			$Usuario->setSalt($random_salt);
		}

		$Usuario->setEstatus($estatus);
		$Usuario->setIdRol($idRol);
		$Usuario->setRangoComisiones($tipoComision);
		$Usuario->setCobraComision($cobraComision);
		$Usuario->Guardar();

		if ($Usuario->getError())
		{
			$r->saError($Usuario->getStrError());
			return $r;
		}

		if ($isInsert)
		{
			$r->saSuccess("El Usuario " .$nombre . " se ha almacenado satisfactoriamente." );
			$r->redirect(URL_BASE . "usuario",1);
		}
		else
		{
			$r->saSuccess("El Usuario " .$nombre . " se ha modificado satisfactoriamente." );
			$r->redirect(URL_BASE . "usuario",1);
		}

		return $r;
	}
	$xajax->registerFunction("guardarUsuario");

	function cargarUsuario($idUsuario)
	{
		$r = new xajaxResponse();

		$usuario= new ModeloUsuario();

		if ($idUsuario <= 0)
		{
			$r->saError("No se han podido cargar los datos del usuario.");
			$r->redirect(URL_BASE . "usuario", 2);
			return $r;
		}

		$usuario->setIdUsuario($idUsuario);

		//verifica si el usuario fue cargado
		if ($usuario->getIdUsuario() <= 0)
		{
			$r->saError("No se han podido cargar los datos del usuario.");
			$r->redirect(URL_BASE . "usuario", 2);
			return $r;
		}


		$r->script("
				    app.username = '" . $usuario->getUsername() . "';
                    app.email = '" . $usuario->getEmail() . "';
                    app.nombre = '" . $usuario->getNombre() . "';
                    app.apellidoPaterno = '" . $usuario->getApellidoPaterno() . "';
                    app.apellidoMaterno = '" . $usuario->getApellidoMaterno() . "';
                    app.estatus = '" . $usuario->getEstatus() . "';
                    app.idRol = '" . $usuario->getIdRol() . "';
					app.tipoComision = '". $usuario->getRangoComisiones() ."';
					app.cobraComision = '". $usuario->getCobraComision() ."';
				  ");

		return $r;
	}
	$xajax->registerFunction("cargarUsuario");

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

	$rol = new ModeloRol();

	$lstRol = $rol->getForSelect("idRol", "nombre", "idRol > 1");

	$lstComisiones = array (
			array("value" => "BAJO", "theoption" => "BAJO" ),
			array("value" => "MEDIO", "theoption" => "MEDIO" ),
			array("value" => "ALTO", "theoption" => "ALTO" )
	);

	$lstEstatus = array (
			              array("value" => "activo", "theoption" => "activo" ),
			              array("value" => "suspendido", "theoption" => "suspendido" ),
			              array("value" => "baja", "theoption" => "baja" )
			            );
						
	
						$lstCobraComision = array (
							array("value" => "SI", "theoption" => "SI" ),
							array("value" => "NO", "theoption" => "NO" )			
						  );	


