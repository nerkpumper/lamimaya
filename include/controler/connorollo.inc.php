<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";

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
//$debug = ob_get_clean();
//$r->mostrarMsgs($debug);

	function cargarNoRemisiones($noRollo)
	{
		$r = new xajaxResponse();
		
		$remisionRollo = new ModeloRemisionrollo();
		
		$lst = $remisionRollo->getAll("idRemisionRollo, noRollo, fecha, remision, almacen, kilos, remisionrollo.existencia, idRollo, codigo, descripcion, remisionrollo.estado ", 
				                           "INNER JOIN rollo ON rollo.idRollo = remisionRollo_rollo_idRollo", 
				                           "noRollo = '".$noRollo."'", "idRollo");
		
// 		idNoRollo: hijos, noRollo: 'no rollo' + hijos, fecha: hijos, remision: hijos, almacen: hijos, kilos: hijos, disponible: hijos
		$idRolloAnterior = 0;
		$idRolloActual = 0;
		$indexRollo = -1;
		$pushes = "";
		
		if (count($lst)>0)
		{
			foreach ($lst as $row)
			{
				$idRolloActual = $row["idRollo"];
					
				if ($idRolloActual != $idRolloAnterior)
				{
					$pushes .= "app.rollos.push({idRollo: ".$row["idRollo"].", codigo: '".$row["codigo"]."', descripcion: '".$row["descripcion"]."', noRollos: []});";
					$idRolloAnterior = $idRolloActual;
					$indexRollo++;
				}
					
				$pushes .= "app.rollos[".$indexRollo."].noRollos.push({ idRemisionRollo: ".$row["idRemisionRollo"].", noRollo: '".$row["noRollo"]."', fecha: '".$row["fecha"]."', remision: '".$row["remision"]."', almacen: '".$row["almacen"]."', kilos: '".$row["kilos"]."', disponible: '".$row["existencia"]."', estado: '". $row["estado"] ."' });";
					
			}
			
			$r->script(" app.rollos.splice(0, app.rollos.length); ".$pushes);
		}
		else
		{
			$r->script("app.msgError = '".mb_convert_encoding("No se encontró información del Numero de Rollo solicitado.", 'UTF-8', 'ISO-8859-1') ."';");
		}
		
		
		
	
		return $r;
	}
	$xajax->registerFunction("cargarNoRemisiones");

																																																																																																										
		
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
	
	