<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.usuario.inc.php";	
	require_once FOLDER_MODEL. "model.cliente.inc.php";
	
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
	
	function obtenerReporte($filtro)
	{
		global $objSession;
		$r = new xajaxResponse();
		$reserva = 20;
		
		$cte = new ModeloCliente();
		
		if (!Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) && !Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) )
		{   
			if ($filtro["promotor"] != "0")
			{
				
				
				$lst = $cte->getAll("upper(concat(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno)) as promotor, cliente.idCliente, cliente.nombre,
				               cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.numero,
				               cliente.colonia, cliente.ciudad, cliente.telefonos, cliente.email, cliente.rfc, cliente.estado  ",
						"inner join usuario as u on u.idUsuario = cliente.idUsuarioPromotor",
						" idUsuarioPromotor = ".$filtro["promotor"],
						"idUsuarioPromotor");
				
				
			}
			else
			{
				
				$lst = $cte->getAll("upper(concat(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno)) as promotor, cliente.idCliente, cliente.nombre,
				               cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.numero,
				               cliente.colonia, cliente.ciudad, cliente.telefonos, cliente.email, cliente.rfc, cliente.estado  ",
						"inner join usuario as u on u.idUsuario = cliente.idUsuarioPromotor",
						"",
						"idUsuarioPromotor");
			}
			
		}
		else
		{
			$lst = $cte->getAll("upper(concat(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno)) as promotor, cliente.idCliente, cliente.nombre,
				               cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.numero,
				               cliente.colonia, cliente.ciudad, cliente.telefonos, cliente.email, cliente.rfc, cliente.estado  ",
					"inner join usuario as u on u.idUsuario = cliente.idUsuarioPromotor",
					" idUsuarioPromotor = ".$objSession->getIdUsuario(),
					"idUsuarioPromotor");
			
			$r->script(" app.filtro.promotor = " . $objSession->getIdUsuario());
		}
				
		
		
		
						           
		
		$detalle = "";
		foreach ($lst as $row)
		{
			$detalle .= "<tr>";
			
			$detalle .= "<td>" . $row ["promotor"] . "</td>";
			$detalle .= "<td>" . $row ["idCliente"] . "</td>";
			$detalle .= "<td>" . $row ["nombre"] . "</td>";
			$detalle .= "<td>" . $row ["apellidos"] . "</td>";
			$detalle .= "<td>" . $row ["empresa"] . "</td>";
			$detalle .= "<td>" . $row ["domicilio1"] . "</td>";
			$detalle .= "<td>" . $row ["domicilio2"] . "</td>";
			$detalle .= "<td>" . $row ["numero"] . "</td>";
			$detalle .= "<td>" . $row ["colonia"] . "</td>";
			$detalle .= "<td>" . $row ["ciudad"] . "</td>";
			$detalle .= "<td>" . $row ["telefonos"] . "</td>";
			$detalle .= "<td>" . $row ["email"] . "</td>";
			$detalle .= "<td>" . $row ["rfc"] . "</td>";
			$detalle .= "<td>" . $row ["estado"] . "</td>";
			
			$detalle .= "</tr>";				
		}
		
		$r->assign("tblReporteBody", "innerHTML", $detalle);

		
		return $r;
	}	
	$xajax->registerFunction("obtenerReporte");

	

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
	
	$lstPromotores = $promotor->getOptionForSelect($promotor->getForSelect("idUsuario", "upper(concat(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno))", "idrol IN (2,4)  AND estatus = 'activo' "), "0", "-- TODOS --");

	
	$mostrarListado = (Permisos::userIsThisRol(Permisos::$rol_PROMOTOR) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) ? "false" : "true");
	