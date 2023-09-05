<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pesomt.inc.php";	

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

	function cargarTablaPesoMT()
	{
		$r = new xajaxResponse();
				
		$mt = new ModeloPesomt();
		
		$lst = $mt->getAll();
		
		$pushes = "";
		
		foreach ($lst as $row)
		{
			$pushes .= "
					
					 app.datos.push ({id: ".$row["idPesoMt"].", 
					                  calibre: '".$row["calibre"]."',
					                  pies2: '".$row["pies2"]."',
					                  pies3: '".$row["pies3"]."',
					                  pies4: '".$row["pies4"]."',
					                  apies2: '".$row["pies2"]."',
					                  apies3: '".$row["pies3"]."',
					                  apies4: '".$row["pies4"]."'					                     
					});
					
					";
		}
		
		$r->script("
				
					app.datos.splice(0, app.datos.length	);
				
					". $pushes	);
	
	
		return $r;
	}
	$xajax->registerFunction("cargarTablaPesoMT");

	function guardarTablaPesoMT($datos)
	{
		$r = new xajaxResponse();
		
		$blnDoCommit = true;
		
		$mt = new ModeloPesomt();
		
		$mt->transaccionIniciar();
		
		$errores = "";
		
		foreach ($datos as $item)
		{
			if ($item["pies2"] != $item["apies2"] || 
				$item["pies3"] != $item["apies3"] ||
				$item["pies4"] != $item["apies4"])
			{
				$mtsave = new ModeloPesomt();
					
				$mtsave->setIdPesoMt($item["id"]);
				
				if ($mtsave->getIdPesoMt() <= 0)
				{
					$errores .= "No se pudo cargar un elemento de la tabla para actualizarlo.";
					$blnDoCommit = false;
				}
				else
				{
					$mtsave->setPies2($item["pies2"]);					
					$mtsave->setPies3($item["pies3"]);
					$mtsave->setPies4($item["pies4"]);
					
					$mtsave->setDateAndUser("modificacion");
					
					$mtsave->Guardar();
					
					if ($mtsave->getError())
					{
						$blnDoCommit = false;
						$errores .= $mtsave->getStrError();
					}
				}
			}

		}
		
		if ($blnDoCommit)
		{
			$r->saSuccess("Los cambios se han realizado con Éxito.");
			$r->script("xajax_cargarTablaPesoMT();");
			$mt->transaccionCommit();
		}
		else
		{
			$r->saError($errores);
			$mt->transaccionRollback();
		}
			
	
		return $r;
	}
	$xajax->registerFunction("guardarTablaPesoMT");
		
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
	