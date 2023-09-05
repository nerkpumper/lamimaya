<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.notificacion.inc.php";
		

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	function getTotalNotificaciones ()
	{
		$noti = new ModeloNotificacion();
		
		$totales = $noti->getAll("sum(if(leido = 'NO' and borrar = 'NO', 1, 0)) as sinleer,  
	                              sum(if(leido = 'SI' and borrar = 'NO', 1, 0)) as leidos, 
                                  sum(if(borrar = 'SI', 1, 0)) as borrados",
				                 "",
				                 "idPara = " . ModeloUsuario::getObjSession()->getIdUsuario())[0];
		
		$result = "app.totalSinLeer = ". $totales["sinleer"] .";  app.totalLeidas = ". $totales["leidos"] .";  app.totalBorradas = ". $totales["borrados"] . ";";
		
		return $result;
	}

	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
//   ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
		
	function cargarNotificaciones($cuales)
	{			
		$r = new xajaxResponse();
		
// 		ModeloUsuario::getObjSession()->getIdUsuario()
		$notificaciones = new ModeloNotificacion();
		
		if ($cuales == "SINLEER")
		{			
			$lst = $notificaciones->getAll("idNotificacion, idProvoca, concat(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) as usuario, tema, contenido, fecha",
					"inner join usuario as u on u.idUsuario = idProvoca",
					"idPara = " . ModeloUsuario::getObjSession()->getIdUsuario(). " AND leido = 'NO' AND borrar = 'NO' ",
					"idNotificacion");
		}
		else if($cuales == "LEIDAS" )
		{
			$lst = $notificaciones->getAll("idNotificacion, idProvoca, concat(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) as usuario, tema, contenido, fecha",
					"inner join usuario as u on u.idUsuario = idProvoca",
					"idPara = " . ModeloUsuario::getObjSession()->getIdUsuario(). " AND leido = 'SI' AND borrar = 'NO' ",
					"idNotificacion");
		}
		else 
		{
			$lst = $notificaciones->getAll("idNotificacion, idProvoca, concat(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) as usuario, tema, contenido, fecha",
					"inner join usuario as u on u.idUsuario = idProvoca",
					"idPara = " . ModeloUsuario::getObjSession()->getIdUsuario(). " AND borrar = 'SI' ",
					"idNotificacion");
		}
		
		
		$notis = "";
		
		foreach ($lst as $row)
		{
			$image = "";
			
			if (file_exists ("img/" . $row["idProvoca"] . ".jpg" )) {
				$image = "img/" . $row["idProvoca"] . ".jpg";
			} else {
				$image = 'img/noimage.png';
			}
			
			$notis .= "
						app.notificaciones.push({
							
							idNotificacion: ".$row["idNotificacion"].",
							idProvoca: ".$row["idProvoca"].",
					 		usuario: '".$row["usuario"]."',
					 		imagen: '". $image ."',
							tema: '".$row["tema"]."',
							contenido: '". ModeloNotificacion::parseaContenido($row["contenido"])."', 
							fecha: '".$row["fecha"]."'
					
						});
					
					";
		}
		
		
		
 		$r->script(" app.notificaciones.splice(0, app.notificaciones.length); " . $notis . getTotalNotificaciones());
		
		return $r;
	}
	$xajax->registerFunction("cargarNotificaciones");
	
		
	function marcarComo($index, $idNotificacion, $marca)
	{
		$r = new xajaxResponse();
	
		// 		ModeloUsuario::getObjSession()->getIdUsuario()
		$notificacion = new ModeloNotificacion();
		
		$notificacion->setIdNotificacion($idNotificacion);
		$msg = "";		
		if ($marca == "SINLEER")
		{
			$msg = utf8_encode("El mensaje ha sido marcado como No Leído");
			$notificacion->setLeidoNO();
			$notificacion->setBorrarNO();
		}
		else if($marca	 == "LEIDA" )
		{
			$msg = utf8_encode("El mensaje ha sido marcado como Leído");
			$notificacion->setLeidoSI();
			$notificacion->setBorrarNO();
		}
		else
		{			
			$msg = utf8_encode("El mensaje será borrado poseriormente");
// 			$r->mostrarAviso("a borrar: ".$index); return $r;
			$notificacion->setBorrarSI();
		}
	
		$notificacion->Guardar();
		
		if (!$notificacion->getError())
		{			
			$r->script("toastr.success('".$msg."','Notificaciones');  app.notificaciones.splice(".$index.", 1);". getTotalNotificaciones() . " globalHeaderNotificaciones();");
		}
		else
		{
			$r->saError("Ocurrió un error al intentar cambiar el estatus de la notificación.");
		}
	
		 		
	
		return $r;
	}
	$xajax->registerFunction("marcarComo");
	
	
	
	

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

	
	
