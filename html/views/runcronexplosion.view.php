<?php
$titlePage = "Explosi&oacute;n";
$breadCum = "Cron";




require_once FOLDER_MODEL. "model.configuracion.inc.php";

require_once FOLDER_MODEL. "model.producto.inc.php";

require_once FOLDER_MODEL. "model.rollo.inc.php";

require_once FOLDER_MODEL. "model.pedido.inc.php";

require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

require_once FOLDER_MODEL. "model.viewproductos.inc.php";

require_once FOLDER_MODEL. "model.pesomt.inc.php";



function myLog($msg = "")

{

	echo  "<br>".$msg;

}



myLog("Todos los que son Pieza se sacan del inventario de Productos");

// myLog("Los demas del rollo en si");

// myLog();



$pesomt = new ModeloPesomt();

$pesosCalibresPies = array();



$lstPesomt = $pesomt->getAll();



// var_dump($lstPesomt);



foreach($lstPesomt as $item)

{

	// myLog("Calibre: " . $item["calibre"]);

	// myLog("    2 pies: " . $item["pies2"]);

	// myLog("    3 pies: " . $item["pies3"]);

	// myLog("    4 pies: " . $item["pies4"]);

	// myLog();



	$pesosCalibresPies[$item["calibre"]] = array(

	               "calibre" => $item["calibre"],

	               "2" => $item["pies2"], 

	               "3" => $item["pies3"],

	               "348" => $item["pies348"],

	               "376" => $item["pies376"],

	               "4" => $item["pies4"]

	               );





}



// echo "pesoAConsiderar = " . $pesosCalibresPies[30][3];





// print_r($pesosCalibresPies);



// return;



$configuracion = new ModeloConfiguracion();

$pedido = new ModeloPedido();



//obtenemos la configuraci�n, para tener los datos de Peso Estimado

//por calibre

// $configuracion->setIdConfiguracion(1);



// $pesoXCalibre20 = $configuracion->getPesoXCalibre20();

// $pesoXCalibre22 = $configuracion->getPesoXCalibre22();

// $pesoXCalibre24 = $configuracion->getPesoXCalibre24();

// $pesoXCalibre26 = $configuracion->getPesoXCalibre26();

// $pesoXCalibre28 = $configuracion->getPesoXCalibre28();



$productosNegados = array();

$productosApartados = array();

$detallesProductosAux = array();



$idProductoMoldura = 386;

$idProductoMaquilaMoldura = 394;

$idProductoISOCOP = 439;



myLog();

myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");

myLog();



foreach ($pesosCalibresPies as $datoca)

{

    myLog(" Calibre: ".$datoca["calibre"]."  2 pies: " . $datoca["2"]. "  3 pies: " . $datoca["3"]. "  4 pies: " . $datoca["4"]);

}

// myLog("peso Calibre 20: " . $pesoXCalibre20);

// myLog("peso Calibre 22: " . $pesoXCalibre22);

// myLog("peso Calibre 24: " . $pesoXCalibre24);

// myLog("peso Calibre 26: " . $pesoXCalibre26);

// myLog("peso Calibre 28: " . $pesoXCalibre28);

myLog();





//Obtenemos el listado de Pedidos

//$lstPedidosAProcesar = $pedido->getAll("idPedido, estado, explotado, listo_para_producir", "", "explotado = 'NO'", "idPedido");

//$lstPedidosAProcesar = $pedido->getAll("idPedido, estado, explotado, listo_para_producir", "", "idPedido in (22,23,24,25)", "idPedido");

$lstPedidosAProcesar = $pedido->getAll("idPedido, estado, explotado, listo_para_producir",

		                               "",

		                               "explotadook = 'NO'

		                                   AND (estado = 'AUTORIZADO' OR estado = 'PRODUCCION' )  ",

		                               "idPedido");



foreach ($lstPedidosAProcesar as $row)

{

	$pedidoProcesando = new ModeloPedido();

	$idPedidoProcesando = $row["idPedido"];

	$pedidoDetalle = new ModeloPedidodetalle();



	$pedidoProcesando->setIdPedido($idPedidoProcesando);



	if ($pedidoProcesando->getIdPedido() > 0)

	{

		myLog("---------------------------------------------------------------------------------------------------------------------------------------------");

		myLog("INICIO Pedido: <h1>" . $idPedidoProcesando . "</h1>");

		myLog();



		//Obtenemos el detalle de cada uno de los Pedidos

		$lstPedidoDetalle = $pedidoDetalle->getAll("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir",

				                                   "",

				                                   "idPedido = " . $idPedidoProcesando . " AND listo_para_producir = 'NO'");



		//echo $pedidoDetalle->getAllQUERY("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir", "", "idPedido = " . $idPedidoProcesando);

// 		$pedidoProcesando->transaccionIniciar();

		$doCommitPedido = true;



		/*

		 * Primero calculamos lo que se debe explotar de cada pedido

		 */



		foreach ($lstPedidoDetalle as $det)

		{

			// 		echo "<br>".$det["idPedidoDetalle"]."  -  ".$det["renglon"]."  -  ".$det["idProducto"];



			myLog("R E N G L O N : " . $det["renglon"] ."        -idPedidoDetalle: ".$det["idPedidoDetalle"]."    -idProducto: ".$det["idProducto"]."    -partida: ".$det["partida"]."    -cantidad: ".$det["cantidad"]."    -cantidadReal: ".$det["cantidadReal"]);

			myLog();



			$idPedidoDetalle = $det["idPedidoDetalle"];

			$updatePedidoDetalle = new ModeloPedidodetalle();

			$updatePedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);



			$viewProducto = new ModeloViewproductos();

			$viewProducto->getView($det["idProducto"]);



			$partida = $det["partida"];

			$cantidad = $det["cantidad"];

			$cantidadReal = $det["cantidadReal"];



			// 		$viewProducto->dumpAsTable();

			myLog("Producto: " . $viewProducto->getFullDescripcion());

			myLog("idRollo => " . $viewProducto->getIdRollo());

			// 		$producto->dumpObj();



			$calibreProducto = $viewProducto->getRolloCalibre();

			$piesProducto = $viewProducto->getRolloPies();

			$piesProductosinpunto = str_replace(".", "", $piesProducto);

			$deDondeDescontar = 0;

			$idProductoToCheck = 0;

			

			if ($viewProducto->getIdProducto() != $idProductoMoldura && $viewProducto->getIdProducto() != $idProductoMaquilaMoldura && $viewProducto->getIdProducto() != $idProductoISOCOP)

			{

			    if ($viewProducto->getShortUnidad() == "PZA" || $viewProducto->getShortUnidad() == "KG" ||  ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1))

			    {

			        if ($viewProducto->getShortUnidad() == "PZA" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1))

			        {

			            myLog();

			            myLog("MERCANCIA SE SACA DE   I N V E N T A R I O");

			            myLog("   Producto Existencia: " . $viewProducto->getExistencia() . "        Apartado: " . $viewProducto->getApartado());

			            myLog("   SACAR => " . ($partida * $cantidad));

			            myLog("    =>=>  Quitamos de Inventario ");

			            // 					$sacarProducto = new ModeloProducto();

			            // 					$sacarProducto->setIdProducto($viewProducto->getIdProducto());

			            

			            // 					$deDondeDescontar = $viewProducto->getExistencia() - $viewProducto->getApartado();

			            // 					myLog(" --- --- => DeDondeSacar: " . $deDondeDescontar);

			            

			            $updatePedidoDetalle->setTotalExplotar($partida * $cantidad);

			            $updatePedidoDetalle->setExplotarUnidad(1);

			            $updatePedidoDetalle->Guardar();

			        }

			        else

			        {

			            myLog();

			            myLog("SACAR DE   R O L L O");

			            myLog(" Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());

			            

			            // 					$sacarRollo = new ModeloRollo();

			            // 					$sacarRollo->setIdRollo($viewProducto->getIdRollo());

			            

			            myLog("   SACAR DE CALIBRE ".$viewProducto->getRolloCalibre()." => ". $partida);

			            myLog("    =>=>  Quitamos de Rollo ");

			            

			            // 					$deDondeDescontar = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();

			            // 					myLog(" --- --- => DeDondeSacar: " . $deDondeDescontar);

			            

			            $updatePedidoDetalle->setTotalExplotar($partida);

			            $updatePedidoDetalle->setExplotarUnidad(1);

			            $updatePedidoDetalle->Guardar();

			            

			        }

			        

			    }

			    else

			    {

			        myLog();

			        myLog("SACAR DE   R O L L O     SE CALCULAN    K I L O S ");

			        myLog(" Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());

			        

			        $kilosRolloApartar = 0;

			        $kilosRollosXUnidad = 0;

			        

			        $pesoAConsiderar = 0;	        

			        

// 			        $pesoAConsiderar = $pesosCalibresPies[$calibreProducto][$piesProducto];

			        $pesoAConsiderar = $pesosCalibresPies[$calibreProducto][$piesProductosinpunto];

			        

			        

			        myLog("  Calibre: " . $calibreProducto . " Pies: " . $piesProductosinpunto . "  KG = " . $pesoAConsiderar);

			        

			        // 				if ($calibreProducto == 22)

			            // 				{

			            // 					$kilosRolloApartar = $pesoXCalibre22 * $cantidadReal * $partida;

			            // 					$kilosRollosXUnidad = $pesoXCalibre22 * $cantidadReal;

			            // 				}

			        // 				elseif ($calibreProducto == 24)

			        // 				{

			        // 					$kilosRolloApartar = $pesoXCalibre24 * $cantidadReal  * $partida;

			        // 					$kilosRollosXUnidad = $pesoXCalibre24 * $cantidadReal;

			        // 				}

			        // 				elseif ($calibreProducto == 26)

			        // 				{

			        // 					$kilosRolloApartar = $pesoXCalibre26 * $cantidadReal * $partida;

			        // 					$kilosRollosXUnidad = $pesoXCalibre26 * $cantidadReal;

			        // 				}

			        // 				elseif ($calibreProducto == 28)

			        // 				{

			        // 					$kilosRolloApartar = $pesoXCalibre28 * $cantidadReal * $partida;

			        // 					$kilosRollosXUnidad = $pesoXCalibre28 * $cantidadReal;

			        // 				}

			        // 				elseif ($calibreProducto == 20)

			        // 				{

			        // 					$kilosRolloApartar = $pesoXCalibre20 * $cantidadReal * $partida;

			        // 					$kilosRollosXUnidad = $pesoXCalibre20 * $cantidadReal;

			        // 				}

			        // 				else

			            // 				{

			            // 					$kilosRolloApartar = 0;

			            // 				}

			        

			        if ($pesoAConsiderar > 0)

			        {

			            $kilosRolloApartar = $pesoAConsiderar * $cantidadReal * $partida;

			            $kilosRollosXUnidad = $pesoAConsiderar * $cantidadReal;

			        }

			        else

			        {

			            $kilosRolloApartar = 0;

			        }

			        

			        myLog("   SACAR DE CALIBRE ".$calibreProducto." " . $piesProducto ."PIES => ". $kilosRolloApartar);

			        myLog("    =>=>  Quitamos de Rollo ");

			        

			        if ($kilosRolloApartar > 0)

			        {

			            // 					$sacarRollo = new ModeloRollo();

			            // 					$sacarRollo->setIdRollo($viewProducto->getIdRollo());

			            

			            $updatePedidoDetalle->setTotalExplotar($kilosRolloApartar);

			            $updatePedidoDetalle->setExplotarUnidad($kilosRollosXUnidad);

			            $updatePedidoDetalle->Guardar();

			            

			        }

			        

			    }

			

			    

			}

			else 

			{

			    myLog();

			    myLog(" M O L D U R A S / M A Q U I L A S ");

			    myLog("   No se manejan existencias de MOLDURAS / MAQUILAS");

			    myLog("   SACAR => " . $partida);

			    myLog("    =>=>  MANEJO DE MOLDURAS / MAQUILAS");

			    // 					$sacarProducto = new ModeloProducto();

			    // 					$sacarProducto->setIdProducto($viewProducto->getIdProducto());

			    

			    // 					$deDondeDescontar = $viewProducto->getExistencia() - $viewProducto->getApartado();

			    // 					myLog(" --- --- => DeDondeSacar: " . $deDondeDescontar);

			    

			    $updatePedidoDetalle->setTotalExplotar($partida);

			    $updatePedidoDetalle->setTotalExplotado($partida);

			    $updatePedidoDetalle->setExplotarUnidad(1);

			    $updatePedidoDetalle->Guardar();

			}



			

		}



		/*

		 * Luego Explotamos la materia Prima

		 */



		myLog();

		myLog("// + + + + +");

		myLog("//  Comenzamos Explosion");

		myLog("// + + + + +");

		myLog();



		$detallesProductosAux = array();



		$pedidoProcesando->transaccionIniciar();



		foreach ($lstPedidoDetalle as $det)

		{

			// 		echo "<br>".$det["idPedidoDetalle"]."  -  ".$det["renglon"]."  -  ".$det["idProducto"];

			myLog();

			myLog("R E N G L O N: " .$det["renglon"]."          -idPedidoDetalle: ".$det["idPedidoDetalle"]."    -idProducto: ".$det["idProducto"]."    -partida: ".$det["partida"]."    -cantidad: ".$det["cantidad"]."    -cantidadReal: ".$det["cantidadReal"]);

			myLog();



			$idPedidoDetalle = $det["idPedidoDetalle"];

			$updatePedidoDetalle = new ModeloPedidodetalle();

			$updatePedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);



			$viewProducto = new ModeloViewproductos();

			$viewProducto->getView($det["idProducto"]);



			if (!isset($productosApartados["pieza".$viewProducto->getIdProducto()]))

			{

				mylog("                -                -  Se crea objeto: pieza" . $viewProducto->getIdProducto());

				$productosApartados["pieza".$viewProducto->getIdProducto()] = $viewProducto->getExistencia() - $viewProducto->getApartado();

			}



			if (!isset($productosApartados["rollo".$viewProducto->getIdRollo()]))

			{

				mylog("                -                -  Se crea objeto: rollo" . $viewProducto->getIdRollo());

				$productosApartados["rollo".$viewProducto->getIdRollo()] = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();

			}



			$totalAExplotar = $updatePedidoDetalle->getTotalExplotar();

// 			$partida = $det["partida"];

// 			$cantidad = $det["cantidad"];

// 			$cantidadReal = $det["cantidadReal"];



			// 		$viewProducto->dumpAsTable();

			myLog();

			myLog("Producto: ". $viewProducto->getFullDescripcion());

			myLog(" idRollo => " . $viewProducto->getIdRollo());

			// 		$producto->dumpObj();



// 			$calibreProducto = $viewProducto->getRolloCalibre();

			$deDondeDescontar = 0;

			$idProductoToCheck = 0;

			

			if ($viewProducto->getIdProducto() != $idProductoMoldura  && $viewProducto->getIdProducto() != $idProductoMaquilaMoldura && $viewProducto->getIdProducto() != $idProductoISOCOP)

			{

			    if ($viewProducto->getShortUnidad() == "PZA" || $viewProducto->getShortUnidad() == "KG" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1))

			    {

			        if ($viewProducto->getShortUnidad() == "PZA" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1))

			        {

			            $idProductoToCheck = $viewProducto->getIdProducto();

			            

			            if (!isset($productosNegados["pn".$idProductoToCheck]))

			            {

			                myLog();

			                myLog("SACAR DE   I N V E N T A R I O ");

			                myLog("   Producto Existencia: " . $viewProducto->getExistencia() . "        Apartado: " . $viewProducto->getApartado());

			                myLog("   SACAR => " . $totalAExplotar);

			                myLog("    =>=>  Quitamos de Inventario ");

			                

			                $sacarProducto = new ModeloProducto();

			                $sacarProducto->setIdProducto($viewProducto->getIdProducto());

			                

			                

			                //$deDondeDescontar = $viewProducto->getExistencia() - $viewProducto->getApartado();

			                $deDondeDescontar = $productosApartados["pieza".$viewProducto->getIdProducto()];

			                

			                myLog(" --- --- => DeDondeSacar: " . $deDondeDescontar);

			                

			                if($deDondeDescontar >= $totalAExplotar)

			                {

			                    myLog(" ------- >  se Realiza la salida");

			                    $sacarProducto->addApartar($totalAExplotar);

			                    $sacarProducto->Guardar();

			                    

			                    //$updatePedidoDetalle->setTotalExplotar($partida);

			                    myLog(" ---------------->>>>>>> Listo para Producir SI");

			                    $updatePedidoDetalle->setListo_para_producir("SI");

			                    $updatePedidoDetalle->setTotalExplotado($totalAExplotar);

			                    

			                    

			                    myLog();

			                    myLog("??????????????? Disponibles de pieza".$viewProducto->getIdProducto()."  =  ". $productosApartados["pieza".$viewProducto->getIdProducto()] );

			                    myLog();

			                    $productosApartados["pieza".$viewProducto->getIdProducto()] = $productosApartados["pieza".$viewProducto->getIdProducto()] - $totalAExplotar;

			                    

			                    // 							myLog();

			                    myLog("=============== Sacando ".$totalAExplotar."  Quedan =  ". $productosApartados["pieza".$viewProducto->getIdProducto()] );

			                    myLog();

			                    

			                    // 							$updatePedidoDetalle->Guardar();

			                    

			                    array_push($detallesProductosAux, $updatePedidoDetalle);

			                    

			                }

			                else

			                {

			                    myLog(" **------- >  no alcanza a salir la mercanc�a, no se puede proceder con este Pedido");

			                    $doCommitPedido = false;

			                    myLog("   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");

			                    $productosNegados["pn".$idProductoToCheck] = "NO";

			                    $updatePedidoDetalle->setListo_para_producir("NO");

			                    

			                    array_push($detallesProductosAux, $updatePedidoDetalle);

			                    // 						break;

			                }

			            }

			            else

			            {

			                myLog("   --////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto");

			                $doCommitPedido = false;

			            }

			            

			            

			            

			        }

			        else

			        {

			            

			            $idProductoToCheck = $viewProducto->getIdProducto();

			            

			            if (!isset($productosNegados["pn".$idProductoToCheck]))

			            {

			                myLog();

			                myLog("SACAR DE     R O L L O");

			                myLog(" Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());

			                

			                $sacarRollo = new ModeloRollo();

			                $sacarRollo->setIdRollo($viewProducto->getIdRollo());

			                

			                myLog("   SACAR DE CALIBRE ".$viewProducto->getRolloCalibre()." => ". $totalAExplotar);

			                myLog("    =>=>  Quitamos de Rollo AA");

			                

			                // 						$deDondeDescontar = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();

			                $deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];

			                

			                myLog(" --- --- => DeDondeSacar: " . $deDondeDescontar);

			                

			                if($deDondeDescontar >= $totalAExplotar)

			                {

			                    myLog(" ------- >  se Realiza la salida");

			                    $sacarRollo->addApartar($totalAExplotar);

			                    $sacarRollo->Guardar();

			                    

			                    //$updatePedidoDetalle->setTotalExplotar($totalAExplotar);

			                    myLog(" ---------------->>>>>>> Listo para Producir SI");

			                    $updatePedidoDetalle->setListo_para_producir("SI");

			                    $updatePedidoDetalle->setTotalExplotado($totalAExplotar);

			                    

			                    myLog();

			                    myLog();

			                    myLog("??????????????? Disponibles de rollo".$viewProducto->getIdRollo()."  =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );

			                    myLog();

			                    $productosApartados["rollo".$viewProducto->getIdRollo()] = $productosApartados["rollo".$viewProducto->getIdRollo()] - $totalAExplotar;

			                    

			                    myLog();

			                    myLog("=============== Sacando ".$totalAExplotar."  Quedan =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );

			                    myLog();

			                    

			                    

			                    // 							$updatePedidoDetalle->Guardar();

			                    

			                    array_push($detallesProductosAux, $updatePedidoDetalle);

			                }

			                else

			                {

			                    myLog(" ------- >  no alcanza a salir la mercanc�a, no se puede proceder con este Pedido");

			                    $doCommitPedido = false;

			                    myLog("   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");

			                    $productosNegados["pn".$idProductoToCheck] = "NO";

			                    $updatePedidoDetalle->setListo_para_producir("NO");

			                    // 						break;

			                    

			                    array_push($detallesProductosAux, $updatePedidoDetalle);

			                }

			                

			            }

			            else

			            {

			                myLog("   --////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto");

			                $doCommitPedido = false;

			            }

			            

			        }

			        

			    }

			    else

			    {

			        $idProductoToCheck = $viewProducto->getIdProducto();

			        

			        if (!isset($productosNegados["pn".$idProductoToCheck]))

			        {

			            myLog();

			            myLog("SACAR DE    R O L L O");

			            myLog(" Existencia: " . $viewProducto->getRolloExistencia() . "        Apartado: " . $viewProducto->getRolloApartado());

			            

			            

			            myLog("   SACAR DE CALIBRE ".$calibreProducto." => ". $totalAExplotar);

			            myLog("    =>=>  Quitamos de Rollo BB");

			            

			            // 					$deDondeDescontar = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();

			            $deDondeDescontar = $productosApartados["rollo".$viewProducto->getIdRollo()];

			            myLog(" --- --- => DeDondeSacars: " . $deDondeDescontar);

			            

			            

			            if ($totalAExplotar > 0)

			            {

			                $sacarRollo = new ModeloRollo();

			                $sacarRollo->setIdRollo($viewProducto->getIdRollo());

			                

			                if($deDondeDescontar >= $totalAExplotar)

			                {

			                    myLog(" ------- >  se Realiza la salida");

			                    $sacarRollo->addApartar($totalAExplotar);

			                    $sacarRollo->Guardar();

			                    

			                    if ($sacarRollo->getError())

			                    {

			                        myLog("    ERROR :  ---   " . $sacarRollo->getStrError());

			                    }

			                    

			                    //$updatePedidoDetalle->setTotalExplotar($totalAExplotar);

			                    myLog(" ---------------->>>>>>> Listo para Producir SI");

			                    $updatePedidoDetalle->setListo_para_producir("SI");

			                    $updatePedidoDetalle->setTotalExplotado($totalAExplotar);

			                    

			                    myLog();

			                    myLog();

			                    myLog("??????????????? Disponibles de rollo".$viewProducto->getIdRollo()."  =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );

			                    myLog();

			                    $productosApartados["rollo".$viewProducto->getIdRollo()] = $productosApartados["rollo".$viewProducto->getIdRollo()] - $totalAExplotar;

			                    

			                    myLog();

			                    myLog("=============== Sacando ".$totalAExplotar."  Quedan =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );

			                    myLog();

			                    

			                    

			                    // 							$updatePedidoDetalle->Guardar();

			                    

			                    array_push($detallesProductosAux, $updatePedidoDetalle);

			                }

			                else

			                {

			                    myLog(" ------- >  no alcanza a salir la mercanc�a, no se puede proceder con este Pedido");

			                    $doCommitPedido = false;

			                    myLog("   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");

			                    $productosNegados["pn".$idProductoToCheck] = "NO";

			                    $updatePedidoDetalle->setListo_para_producir("NO");

			                    // 						break;

			                    

			                    array_push($detallesProductosAux, $updatePedidoDetalle);

			                }

			            }

			            else

			            {

			                myLog(" ------- >  Total a Explotar = 0, no puede ser");

			                $doCommitPedido = false;

			            }

			        }

			        else

			        {

			            myLog("   --////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanz� a surtirse, no se verifica producto");

			            $doCommitPedido = false;

			        }

			    }

			}

			else //MOLDURAS

			{

			    myLog();

			    myLog("MOLDURAS/MAQUILAS, NO SE SACAN DE ALGUN LADO ");

			    myLog("   No se manejan existencias");

			    myLog("   SOLICITADAS => " . $totalAExplotar);

			    myLog("    =>=>  MOLDURAS/MAQUILAS no gestionan Inventario ");

			   			   

			    

			    //$updatePedidoDetalle->setTotalExplotar($partida);

			    myLog(" ---------------->>>>>>> Listo para Producir SI");

			    $updatePedidoDetalle->setListo_para_producir("SI");

			    $updatePedidoDetalle->setTotalExplotado($totalAExplotar);

			   

			        

			    // 							myLog();

			    myLog("=============== Se manejar�n ".$totalAExplotar."  MOLDURAS/MAQUILAS" );

			    myLog();

			        

			    // 							$updatePedidoDetalle->Guardar();

			        

			    array_push($detallesProductosAux, $updatePedidoDetalle);

			}



			

		}



// 		$doCommitPedido = false;



		if ($doCommitPedido)

		{

// 			myLog();

			myLog();

			myLog(" ************ DO COMMIT ***********");

			$pedidoProcesando->setExplotado("SI");

			$pedidoProcesando->setListo_para_producir("SI");

			$pedidoProcesando->setExplotadook("SI");

			$pedidoProcesando->Guardar();



			foreach ($detallesProductosAux as $detalleAActualizarSiEstaListo)

			{

				myLog();

				// 				myLog();

				// 				myLog("Vamos a Guardar aunque sea si si se podr�a despachar");

				// 				myLog();



				// 				$detalleAActualizarSiEstaListo->dumpObj("<br>\n");



				$detalleAActualizarSiEstaListo->Guardar();



				// 				myLog();

				myLog();

			}



			$pedidoProcesando->transaccionCommit();



			myLog();

			myLog("FIN Pedido: <h1>" . $idPedidoProcesando . "</h1>");

			myLog("---------------------------------------------------------------------------------------------------------------------------------------------");

		}

		else

		{

// 			myLog();

			myLog();

			myLog(" - - - - - R O L L B A C K  - - - - -");

			myLog(" - - - - - BUENO YA NO ES ROLLBACK  - - - - -");

// 			$pedidoProcesando->transaccionRollback();



			// ya no se guarda lo del pedido, porque ya se guard�, al no haber ya

			//rollback, se queda guardado



			foreach ($detallesProductosAux as $detalleAActualizarSiEstaListo)

			{

				myLog();

// 				myLog();

// 				myLog("Vamos a Guardar aunque sea si si se podr�a despachar");

// 				myLog();



// 				$detalleAActualizarSiEstaListo->dumpObj("<br>\n");



				$detalleAActualizarSiEstaListo->Guardar();



// 				myLog();

				myLog();

			}



			$pedidoProcesando->setExplotado("SI");

			$pedidoProcesando->Guardar();

			$pedidoProcesando->transaccionCommit();



// 			myLog();

			myLog(" - Explotado SI, pero sin Exito -");

			myLog();

			myLog("FIN Pedido: <h1>" . $idPedidoProcesando . "</h1>");

			myLog("---------------------------------------------------------------------------------------------------------------------------------------------");

// 			myLog();

		}





// 		myLog();

		myLog();

	}





}

