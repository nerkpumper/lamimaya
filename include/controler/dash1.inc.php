<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.rollo.inc.php";	
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	
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
			
	function cargarInformacionRollos()
	{
		$r = new xajaxResponse();
					
		$rollo = new ModeloRollo();
		
		$lst = $rollo->getAll("", "", "idRollo > 1");
		
		$categorias = "";
		$datos = "";
		$apartados = "";
		
		foreach ($lst as $row)
		{
			$categorias .= (trim($categorias) == "" ? "" : "," ) . "'".$row["codigo"]."'";
			$datos .= " chart.series[0].addPoint({idRollo: " .$row["idRollo"]. ", codigo: '".$row["codigo"]."', y: ".$row["existencia"]."}); ";
			$datos .= " chart.series[1].addPoint({idRollo: " .$row["idRollo"]. ", codigo: '".$row["codigo"]."', y: ".$row["apartado"]."}); ";
		}
		
		$r->script("
				
				var index = $('#grRollos').data('highchartsChart');	
				var chart = Highcharts.charts[index];
				
				chart.xAxis[0].setCategories([".$categorias."]); " . 
				
				$datos
				
				. "
				
				
				
				");
	
		return $r;
	}
	$xajax->registerFunction("cargarInformacionRollos");
	
	function cargarInformacionProductos()
	{
		$r = new xajaxResponse();
			
		$productos = new ModeloViewproductos();
	
		$lst = $productos->getAll("", "", "shortUnidad = 'PZA'");
	
		$categorias = "";
		$datos = "";
		$apartados = "";
	
		foreach ($lst as $row)
		{
			$categorias .= (trim($categorias) == "" ? "" : "," ) . "'".$row["codigo"] . " - ". $row["tipoProducto"] . " " .($row["aplicacion"] != "--NO APLICA--" ? $row["aplicacion"] : "" ). " ". ($row["material"] != "--NO APLICA--" ? $row["material"] : "" )."'";
			$datos .= " chart.series[0].addPoint({idProducto: " .$row["idProducto"]. ", codigo: '".$row["codigo"]."', y: ".$row["existencia"]."}); ";
			$datos .= " chart.series[1].addPoint({idProducto: " .$row["idProducto"]. ", codigo: '".$row["codigo"]."', y: ".$row["apartado"]."}); ";
		}
	
		$r->script("
	
				var index = $('#grProductos').data('highchartsChart');
				var chart = Highcharts.charts[index];
	
				chart.xAxis[0].setCategories([".$categorias."]); " .
	
				$datos
	
				. "
	
	
	
				");
	
				return $r;
	}
	$xajax->registerFunction("cargarInformacionProductos");
	
	
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
		