<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.usuario.inc.php";
	require_once FOLDER_MODEL. "model.registroproduccion.inc.php";
	

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
// 		$r->starDebug();

		$rp = new ModeloRegistroproduccion();
		
		$desde = $filtro["fechaInicio"];
		$hasta = $filtro["fechaFin"];
		$addWhere ="";
		
		
;		if ($desde != "" && $hasta != "")
		{
		    $desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
		    $hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);
		    
		    $addWhere .= " AND date_format(registroproduccion.fecha_termina, '%Y-%m-%d') BETWEEN '".$desde."' AND '".$hasta."' ";
		    
		}
		
		

		$lst = $rp->getAll("
                            registroproduccion.idRegistroProduccion,getTotalPycRegistroProduccion(idRegistroProduccion) as totalPyc, 
       registroproduccion.idRemisionRollo, rr.remision, rr.remisionRollo_rollo_idRollo as idRollo, vr.descauto as descrollo, rr.norollo,
	   registroproduccion.kilos, registroproduccion.kilosMaquilados, registroproduccion.totalml, registroproduccion.factor, registroproduccion.rendimiento,
       registroproduccion.terminado, registroproduccion.fecha_creacion, registroproduccion.id_usuario_creacion, registroproduccion.fecha_termina, registroproduccion.id_usuario_termina,
       ter.nombre as nombreTermino, ter.apellidopaterno as apaternoTermino, ter.apellidomaterno as amaternoTermino                                    
                            ",
						"
                            inner join remisionrollo rr
                    on rr.idRemisionRollo = registroproduccion.idRemisionRollo
                    inner join viewrollos vr
                    on vr.idRollo = rr.remisionRollo_rollo_idRollo
                    inner join usuario ter
                    on ter.idUsuario = registroproduccion.id_usuario_termina 
						",
						" registroproduccion.terminado = 'SI' " . $addWhere ,
						"registroproduccion.fecha_termina");
		
// 		$r->mostrarAviso($rp->getAllQUERY("
//                             registroproduccion.idRegistroProduccion,
//        registroproduccion.idRemisionRollo, rr.remision, rr.remisionRollo_rollo_idRollo as idRollo, vr.descauto as descrollo, rr.norollo,
// 	   registroproduccion.kilos, registroproduccion.kilosMaquilados, registroproduccion.totalml, registroproduccion.factor, registroproduccion.rendimiento,
//        registroproduccion.terminado, registroproduccion.fecha_creacion, registroproduccion.id_usuario_creacion, registroproduccion.fecha_termina, registroproduccion.id_usuario_termina,
//        ter.nombre as nombreTermino, ter.apellidopaterno as apaternoTermino, ter.apellidomaterno as amaternoTermino
//                             ",
// 		    "
//                             inner join remisionrollo rr
//                     on rr.idRemisionRollo = registroproduccion.idRemisionRollo
//                     inner join viewrollos vr
//                     on vr.idRollo = rr.remisionRollo_rollo_idRollo
//                     inner join usuario ter
//                     on ter.idUsuario = registroproduccion.id_usuario_termina
// 						",
// 		    " registroproduccion.terminado = 'SI' " . $addWhere ,
// 		    "registroproduccion.fecha_termina"));
				
		
		$fkilosMaquilados = 0;
		foreach ($lst as $row)
		{	
		    $fkilosMaquilados += $row ["kilosMaquilados"];
		}

		$detalle = "";
		$ponderado = 0;
		$sumPonderados = 0;
		$entra = false;
		foreach ($lst as $row)
		{
			$entra = true;
			$color = "";

			if ($row ["rendimiento"] >= 0)
			{
				$color = "class='text-success ";
			}
			else
			{
				$color = "class='text-danger ";
			}
			
			$icono = "";
			
			if ($row ["rendimiento"] > 0)
			{
			    $icono = "<i class='fa fa-level-up'></i>";
			}
			else
			{
			    if ($row ["rendimiento"] < 0)
			    {
			        $icono = "<i class='fa fa-level-down'></i>";
			    }			    
			}
			$pyc = (100/ $row["kilos"]) * ($row["totalPyc"]);
			


			$detalle .= "<tr>";

			$detalle .= "<td><strong>" . $row ["descrollo"] . "</strong></td>";
			$detalle .= "<td class='text-right'>" . $row ["remision"] . "</td>";
			$detalle .= "<td class='text-right'><strong>" . $row ["norollo"] . "</strong></td>";			
			$detalle .= "<td ".$color." text-right'>" . $row ["kilos"] . "</td>";
			$detalle .= "<td ".$color." text-right'>" . $row ["kilosMaquilados"] . "</td>";
			$detalle .= "<td ".$color." text-right'>" . number_format($pyc,2) . "</td>";
			$detalle .= "<td ".$color." text-right'>" . $row ["factor"] . "</td>";
			$detalle .= "<td style='display: none;'".$color." text-right'>" . $row ["rendimiento"] . "</td>";
			
			$ponderado = round($row ["kilosMaquilados"] / $fkilosMaquilados * $row ["rendimiento"],2);
// 			ponderado
			$detalle .= "<td style='display: none;'".$color." text-right'>" . $ponderado . "</td>";
			$sumPonderados += $ponderado;
			
			$detalle .= "<td style='display: none;'>" . clsUtilerias::formatoFecha($row ["fecha_termina"]) . "</td>";
			$detalle .= "<td style='display: none;'>" .$row["nombreTermino"]. " " .$row["apaternoTermino"]. " " . $row["amaternoTermino"]. "</td>";			
			
			$detalle .= "<td ".$color." text-right'>" . $row ["rendimiento"] . " ". $icono. "</td>";
			$detalle .= "<td ".$color." text-right'>" . $ponderado . "</td>";
			$detalle .= "<td>" . clsUtilerias::formatoFecha($row ["fecha_termina"]) . "</td>";			
			$detalle .= "<td>" .$row["nombreTermino"]. " " .$row["apaternoTermino"]. " " . $row["amaternoTermino"]. "</td>";

			$detalle .= "<td><a class='btn btn-primary btn-md' href='".URL_BASE."registroproduccionprint?id=".$row["idRegistroProduccion"]."'><i class='fa fa-file-excel-o'></i></a></td>";

			$detalle .= "</tr>";
		}
		
		
		$color = "class='text-navy ";
		$foot = "<tr>";
				
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		$foot .= "<td ".$color." text-right'>" . $fkilosMaquilados . "</td>";
		$foot .= "<td style='display: none;'></td>";
		$foot .= "<td style='display: none;'><strong>Rendimiento Ponderado:</strong></td>";
				
		$foot .= "<td style='display: none;'".$color." text-right'>" . $sumPonderados . "</td>";
				
		$foot .= "<td style='display: none;'></td>";
		$foot .= "<td></td>";
		
		$foot .= "<td><strong>Rendimiento Ponderado:</strong></td>";
		$foot .= "<td ".$color." text-right'>" . $sumPonderados . "</td>";
		$foot .= "<td></td>";
		$foot .= "<td></td>";
		
		$foot .= "<td></td>";
		
		$foot .= "</tr>";
		
		
// 		$r->endDegug();
// 		$r->mostrarAviso($detalle); return $r;

		$r->assign("tblReporteBody", "innerHTML", $detalle);
		$r->assign("tblReporteFoot", "innerHTML", $foot);

		if (!$entra)
		{
			$r->saInfo("No se encontr� informaci�n.");
		}

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
