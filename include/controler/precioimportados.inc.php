<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

 	require_once FOLDER_MODEL. "model.precioxdobles.inc.php";
 	require_once LIB_CONEXION_MYSQL;
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

 	function mapeaIndex($desarrollo)
 	{
 		$index = -1;
 		
 		switch ($desarrollo)
 		{
 			case "1-15":
 				$index = 0;
 				break;
			case "16-20":
				$index = 1;
				break;
			case "21-30":
				$index = 2;
				break;
			case "31-40":
				$index = 3;
				break;
			case "41-61":
				$index = 4;
				break;
			case "62-1.22":
				$index = 5;
				break;
 			
 		}
 		
 		return $index;
 	}

	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	//$xajax->de decodeUTF8InputOn();
	
// ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
			
	function probarArreglo($precios)
	{
		$r = new xajaxResponse();
		
		foreach ($precios as $p)
		{
			echo "<br>" . $p["desarrollo"] . "<br>";
			
			echo "<br>  --->> " . $p["calibre26"][0]["precio1"];
			
			foreach ($p["calibre26"][0] as $key=>$p26)
			{
				echo "<br> " . $key . " --->> " . $p26 . "  ===   " . $p["calibre26"][0][$key];
			}
		}
		
// 		$debug = ob_get_clean();
// 		$r->mostrarExito($debug);
		
		return $r;
	}	
	$xajax->registerFunction("probarArreglo");
	
	function guardarPrecios($tipo, $precios)
	{
		global $objSession;
		$r = new xajaxResponse();
		$hasError = false;	
			
		
 		foreach ($precios as $p)
		{
			for($calibre = 26 ; $calibre >= 24 ; $calibre-=2)
			{
				$pd = new ModeloPrecioxdobles();
					
				$idPrecioXDobles = $p["calibre" . $calibre][0]["id"];
				if ($idPrecioXDobles > 0)
				{
					$pd->setIdPrecioXDobles($idPrecioXDobles);
				}
					
				$desarrollo = $p["desarrollo"];
					
				$pd->setTipoPrecio($tipo);
				$pd->setDesarrollo($desarrollo);
				$pd->setIdUsuario($objSession->getIdUsuario());
				
				$pd->setCalibre($calibre);
				foreach ( $p ["calibre" . $calibre] [0] as $key => $precioCalibre )
				{
					$idPrecio = str_replace("precio", "", $key);
					$pd->setPrecioById($idPrecio, $precioCalibre);
					// 				echo "<br> " . $key . " --->> " . $p26 . "  ===   " . $p ["calibre26"] [0] [$key];
				}
					
				$pd->Guardar();
				
				if ($pd->getError())
				{
					$hasError = true;
					$r->saError($pd->getStrError());
				}
			}		
		}
	
		
		if (!$hasError)
		{
			$r->saSuccess("Los Precios han sido almacenados correctamente.");
			$r->redirect(URL_BASE . "precioimportados",2);
		}
		
	
		return $r;
	}
	$xajax->registerFunction("guardarPrecios");
	
	function cargarPrecios($tipo)
	{
		$r = new xajaxResponse();
		$cnn = new clsConexionMySQL();
		$js = "";
						
		$query = "SELECT idPrecioXDobles, tipoPrecio, desarrollo, calibre, 
				         precio1, precio2, precio3, precio4, precio5, 
				         precio6, precio7, precio8, precio9, precio10 
                    FROM precioxdobles 
                   WHERE tipoPrecio = '".$tipo."'
                   ORDER BY idPrecioXDobles";
		
		$rs = $cnn->getDataSet($query);
		
		foreach ($rs as $row)
		{
			$index = mapeaIndex($row["desarrollo"]);
			
			if ($index >= 0)
			{

				$js .= " app.precios[".$index."].calibre".$row["calibre"]."[0].id = ".$row["idPrecioXDobles"]."; ";

				for($i=1 ; $i <= 10 ; $i++)
				{
					$js .= " app.precios[".$index."].calibre".$row["calibre"]."[0].precio".$i." = ".$row["precio" . $i]."; ";
				}
				
				
				
			}
		}
		
		$r->script($js);
		
// 		$r->mostrarExito($js);
	
// 		$r->script("
				
// 					app.precios[0].calibre24[0].precio2 = 2;
				
// 				");
		
		return $r;
	}
	$xajax->registerFunction("cargarPrecios");

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
	