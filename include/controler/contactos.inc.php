<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";	

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
		
		
	function cargarUsuarios()
	{
		$r = new xajaxResponse();
		
		$usuario = new ModeloUsuario();
		
		$lst = $usuario->getAll("usuario.idusuario, usuario.tokendevice, usuario.username, usuario.email, usuario.nombre, usuario.apellidoPaterno, usuario.apellidoMaterno, r.nombre as rol",
				                "inner join rol as r on usuario.idrol = r.idrol",
				                "idUsuario > 1 order by usuario.idusuario");
		
		$contactos = "";
		
		foreach ($lst as $row)
		{
			$image = "";
			if (file_exists ("img/" . $row["idusuario"] . ".jpg" )) {
				$image = "img/" . $row["idusuario"] . ".jpg";
			} else {
				$image = 'img/noimage.png';
			}
			
			$image = URL_BASE.$image;
			$contactos .= "
					      	app.contactos.push({
								idusuario: ".$row["idusuario"].",
								username: '".$row["username"]."',
								email: '".$row["email"]."',
								image: '".$image."',
								nombre: '".$row["nombre"]."',
								apellidoPaterno: '".$row["apellidoPaterno"]."',
								apellidoMaterno: '".$row["apellidoMaterno"]."',
								rol: '".$row["rol"]."',
                                token: '".$row["tokendevice"]."'						  
							});					
					";
		}
						
		$r->script("
					app.contactos.splice(0, app.contactos.length);
				" . $contactos);
		
		return $r;
	}	
	$xajax->registerFunction("cargarUsuarios");
	
	function enviaMsg($idPara, $asunto, $msg)
	{
	    $r = new xajaxResponse();
	    
// 	    $r->starDebug();
// 	    echo "dfsdfads   ".$idPara;
	    NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_MSG, $idPara, $asunto, $msg);
	    
// 	    $r->endDegug();
	    // 
	    $r->saInfo("El mensaje ha sido enviado.");
	    
	    
	    return $r;
	    
	}	
	$xajax->registerFunction("enviaMsg");

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
