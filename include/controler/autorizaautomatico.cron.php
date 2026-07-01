<?php

if (isset($_SERVER['HTTP_HOST']))
    define("isCONSOLE", false);
else
    define("isCONSOLE", true);

// define('FOLDER_INCLUDE', '../');
// define('FOLDER_INCLUDE', '../../include/');
// define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

    define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');


define("FOLDER_MODEL_BASE", FOLDER_INCLUDE . "model/base/");
define("FOLDER_MODEL", FOLDER_INCLUDE . "model/extend/");
define("LIB_CONEXION", FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");
define("LIB_CONEXION_MYSQL", FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");
define("NOTIFICATION_MANAGER",FOLDER_INCLUDE . "lib/app/class.notificationmanager.inc.php");

define( 'API_ACCESS_KEY', 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA' );

require_once LIB_CONEXION;
require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';
require_once FOLDER_MODEL . "model.usuario.inc.php";

require_once NOTIFICATION_MANAGER;

require_once FOLDER_MODEL . "model.pushnotifica.inc.php";

require_once FOLDER_MODEL. "model.configuracion.inc.php";
require_once FOLDER_MODEL. "model.producto.inc.php";
require_once FOLDER_MODEL. "model.rollo.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";
require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";
require_once FOLDER_MODEL. "model.viewproductos.inc.php";
require_once FOLDER_MODEL. "model.pesomt.inc.php";
require_once FOLDER_MODEL. "model.pedidodetallecolocacion.inc.php";

function myLog($msg = "")
{
    echo (isCONSOLE ? "\n" : "<br>").$msg;
}


$idProductoMoldura = 9;
$idProductoMaquilaMoldura = 10;
$idProductoISOCOP = 439;


$pesomt = new ModeloPesomt();
$pesosCalibresPies = array();

// $lstPesomt = $pesomt->getAll();

// // var_dump($lstPesomt);

// foreach($lstPesomt as $item)
    // {
    //     // myLog("Calibre: " . $item["calibre"]);
    //     // myLog("    2 pies: " . $item["pies2"]);
    //     // myLog("    3 pies: " . $item["pies3"]);
    //     // myLog("    4 pies: " . $item["pies4"]);
    //     // myLog();

    //     $pesosCalibresPies[$item["calibre"]] = array(
    //         "calibre" => $item["calibre"],
    //         "2" => $item["pies2"],
    //         "3" => $item["pies3"],
    //         "348" => $item["pies348"],
    //         "376" => $item["pies376"],
    //         "4" => $item["pies4"]
    //     );


    // }


myLog();
myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");
myLog();

// foreach ($pesosCalibresPies as $datoca)
    // {
    //     myLog(" Calibre: ".$datoca["calibre"]."  2 pies: " . $datoca["2"]. "  3 pies: " . $datoca["3"]. "  4 pies: " . $datoca["4"]);
    // }


$pedido = new ModeloPedido();

$lstPedidosAProcesar = $pedido->getAll("idPedido, colocado, idSucursalCapturado, idSucursalPreferenciaRecoge ",
    "",
    "estado = 'CAPTURADO' AND explotado = 'NO' AND colocado = 'NO' AND  (idSucursalCapturado <> 0 OR idSucursalPreferenciaRecoge > 0) ",
    "idPedido");

// echo $pedido->getAllQUERY("idPedido, colocado, idSucursalCapturado, idSucursalPreferenciaRecoge ",
//     "",
//     "estado = 'CAPTURADO' AND explotado = 'NO' AND colocado = 'NO' AND  (idSucursalCapturado <> 0 OR idSucursalPreferenciaRecoge > 0) ",
//     "idPedido");

// return;

// var_dump($lstPedidosAProcesar);


foreach ($lstPedidosAProcesar as $row)
{
    $pedidoProcesando = new ModeloPedido();
    $idPedidoProcesando = $row["idPedido"];
    
    $idSucursal = 0;
    
    $idSucursal = $row["idSucursalPreferenciaRecoge"];
    
    if ($idSucursal <= 0)
    {
        $idSucursal = $row["idSucursalCapturado"];
    }
    
    
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
            "idPedido = " . $idPedidoProcesando . " ");
        
        //echo $pedidoDetalle->getAllQUERY("idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir", "", "idPedido = " . $idPedidoProcesando);
        // 		$pedidoProcesando->transaccionIniciar();
        $doCommitPedido = true;
        
        
        myLog();
        myLog("// + + + + +");
        myLog("//  Comenzamos Analisis de inventarios de la sucursal");
        myLog("// + + + + +");
        myLog();
        
        $arrColocaciones = array();
        
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
            $viewProducto->getViewSucursal($det["idProducto"], $idSucursal);
            
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
            
            $totalAExplotar = $updatePedidoDetalle->getPartida() ; //$updatePedidoDetalle->getTotalExplotar();
            // 			$partida = $det["partida"];
            // 			$cantidad = $det["cantidad"];
            // 			$cantidadReal = $det["cantidadReal"];
            
            // 		$viewProducto->dumpAsTable();
            myLog();
            myLog("Producto: ". $viewProducto->getFullDescripcion());
            myLog(" idRollo => " . $viewProducto->getIdRollo());
            // 		$producto->dumpObj();
            
            // 			$calibreProducto = $viewProducto->getRolloCalibre();
            
            $calibreProducto = $viewProducto->getRolloCalibre();
            $piesProducto = $viewProducto->getRolloPies();
            //                         $piesProductosinpunto = str_replace(".00", "", $piesProducto);
            //                         $piesProductosinpunto = str_replace(".", "", $piesProductosinpunto);
            
            
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
                            
                            //                             $sacarProducto = new ModeloProducto();
                            //                             $sacarProducto->setIdProducto($viewProducto->getIdProducto());
                            
                            
                            //$deDondeDescontar = $viewProducto->getExistencia() - $viewProducto->getApartado();
                            $deDondeDescontar = $productosApartados["pieza".$viewProducto->getIdProducto()];
                            
                            myLog(" --- --- => DeDondeSacar: " . $deDondeDescontar);
                            
                            if($deDondeDescontar >= $totalAExplotar)
                            {
                                //                                 myLog(" ------- >  se Realiza la salida");
                                //                                 $sacarProducto->addApartar($totalAExplotar);
                                //                                 $sacarProducto->Guardar();
                                
                                //$updatePedidoDetalle->setTotalExplotar($partida);
                                myLog(" ---------------->>>>>>> Listo para Asignar SI");
                                //                                 $updatePedidoDetalle->setListo_para_producir("SI");
                                //                                 $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                                
                                
                                //                                 myLog();
                                //                                 myLog("??????????????? Disponibles de pieza".$viewProducto->getIdProducto()."  =  ". $productosApartados["pieza".$viewProducto->getIdProducto()] );
                                //                                 myLog();
                                //                                 $productosApartados["pieza".$viewProducto->getIdProducto()] = $productosApartados["pieza".$viewProducto->getIdProducto()] - $totalAExplotar;
                                
                                //                                 // 							myLog();
                                //                                 myLog("=============== Sacando ".$totalAExplotar."  Quedan =  ". $productosApartados["pieza".$viewProducto->getIdProducto()] );
                                //                                 myLog();
                                
                                // 							$updatePedidoDetalle->Guardar();
                                
                                $coloca = new ModeloPedidodetallecolocacion();
                                
                                $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
                                $coloca->setIdSucursal($idSucursal);
                                $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
                                
                                $coloca->setCantidad($totalAExplotar);
                                
                                array_push($arrColocaciones, $coloca);
                                
                            }
                            else
                            {
                                myLog(" **------- >  no alcanza a salir la mercancia, no se puede proceder con este Pedido");
                                $doCommitPedido = false;
                                myLog("   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");
                                //                                 $productosNegados["pn".$idProductoToCheck] = "NO";
                                //                                 $updatePedidoDetalle->setListo_para_producir("NO");
                                
                                //                                 array_push($arrColocaciones, $updatePedidoDetalle);
                                // 						break;
                            }
                        }
                        else
                        {
                            myLog("   --////////////////>  PRODUCTO NEGADO, otro pedido ya no alcanzo a surtirse, no se verifica producto");
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
                                myLog(" ---------------->>>>>>> Listo para Asignar SI");
                                //                                 $sacarRollo->addApartar($totalAExplotar);
                                //                                 $sacarRollo->Guardar();
                                
                                //$updatePedidoDetalle->setTotalExplotar($totalAExplotar);
                                //                                 myLog(" ---------------->>>>>>> Listo para Producir SI");
                                //                                 $updatePedidoDetalle->setListo_para_producir("SI");
                                //                                 $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                                
                                //                                 myLog();
                                //                                 myLog();
                                //                                 myLog("??????????????? Disponibles de rollo".$viewProducto->getIdRollo()."  =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );
                                //                                 myLog();
                                //                                 $productosApartados["rollo".$viewProducto->getIdRollo()] = $productosApartados["rollo".$viewProducto->getIdRollo()] - $totalAExplotar;
                                
                                //                                 myLog();
                                //                                 myLog("=============== Sacando ".$totalAExplotar."  Quedan =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );
                                //                                 myLog();
                                
                                
                                // 							$updatePedidoDetalle->Guardar();
                                
                                $coloca = new ModeloPedidodetallecolocacion();
                                
                                $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
                                $coloca->setIdSucursal($idSucursal);
                                $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
                                
                                $coloca->setCantidad($totalAExplotar);
                                
                                array_push($arrColocaciones, $coloca);
                            }
                            else
                            {
                                myLog(" ------- >  no alcanza a salir la mercanc�a, no se puede proceder con este Pedido");
                                $doCommitPedido = false;
                                myLog("   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");
                                //                                 $productosNegados["pn".$idProductoToCheck] = "NO";
                                //                                 $updatePedidoDetalle->setListo_para_producir("NO");
                                // 						break;
                                
                                //                                 array_push($arrColocaciones, $updatePedidoDetalle);
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
                        $kilosAExplotar = $updatePedidoDetalle->getTotalExplotar();
                        myLog("     --- ===> " . $kilosAExplotar);
                        
                        
                        if ($totalAExplotar > 0)
                        {
                            $sacarRollo = new ModeloRollo();
                            $sacarRollo->setIdRollo($viewProducto->getIdRollo());
                            
                            //                             if($deDondeDescontar >= $totalAExplotar)
                            if($deDondeDescontar >= $kilosAExplotar)
                            {
                                myLog(" ---------------->>>>>>> Listo para Asignar SI");
                                    //                                 $sacarRollo->addApartar($totalAExplotar);
                                    //                                 $sacarRollo->Guardar();
                                
                                    //                                 if ($sacarRollo->getError())
                                        //                                 {
                                        //                                     myLog("    ERROR :  ---   " . $sacarRollo->getStrError());
                                        //                                 }
                                    
                                    //$updatePedidoDetalle->setTotalExplotar($totalAExplotar);
                                    //                                 myLog(" ---------------->>>>>>> Listo para Producir SI");
                                    //                                 $updatePedidoDetalle->setListo_para_producir("SI");
                                    //                                 $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                                    
                                    //                                 myLog();
                                    //                                 myLog();
                                    //                                 myLog("??????????????? Disponibles de rollo".$viewProducto->getIdRollo()."  =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );
                                    //                                 myLog();
                                    //                                 $productosApartados["rollo".$viewProducto->getIdRollo()] = $productosApartados["rollo".$viewProducto->getIdRollo()] - $totalAExplotar;
                                    
                                    //                                 myLog();
                                    //                                 myLog("=============== Sacando ".$totalAExplotar."  Quedan =  ". $productosApartados["rollo".$viewProducto->getIdRollo()] );
                                    //                                 myLog();
                                    
                                    
                                    // 							$updatePedidoDetalle->Guardar();
                                    
                                    $coloca = new ModeloPedidodetallecolocacion();
                                    
                                    $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
                                    $coloca->setIdSucursal($idSucursal);
                                    $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
                                    
                                    $coloca->setCantidad($totalAExplotar);
                                    
                                    array_push($arrColocaciones, $coloca);
                            }
                            else
                            {
                                myLog(" ------- >  no alcanza a salir la mercanc�a, no se puede proceder con este Pedido");
                                $doCommitPedido = false;
                                myLog("   }}}}}}}}}}}}}}}}}}      Se Negar� Producto para futura Explosi�n");
                                //                                 $productosNegados["pn".$idProductoToCheck] = "NO";
                                //                                 $updatePedidoDetalle->setListo_para_producir("NO");
                                // 						break;
                                
                                //                                 array_push($arrColocaciones, $updatePedidoDetalle);
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
                //                 $updatePedidoDetalle->setListo_para_producir("SI");
                //                 $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                
                
                // 							myLog();
                myLog("=============== Se manejar�n ".$totalAExplotar."  MOLDURAS/MAQUILAS" );
                myLog();
                
                // 							$updatePedidoDetalle->Guardar();
                
                $coloca = new ModeloPedidodetallecolocacion();
                
                $coloca->setIdPedidoDetalle($updatePedidoDetalle->getIdPedidoDetalle());
                $coloca->setIdSucursal($idSucursal);
                $coloca->setIdInventarioSucursal($viewProducto->getIdInventarioSucursal());
                
                $coloca->setCantidad($totalAExplotar);
                
                array_push($arrColocaciones, $coloca);
            }
            
            
        }
        
        //         		$doCommitPedido = false;
        
        if ($doCommitPedido)
        {
            // 			myLog();
            myLog();
            myLog(" ************ DO COMMIT ***********");
            //             $pedidoProcesando->setExplotado("SI");
            //             $pedidoProcesando->setListo_para_producir("SI");
            //             $pedidoProcesando->setExplotadook("SI");
            //             $pedidoProcesando->Guardar();
            
            foreach ($arrColocaciones as $col)
            {
                myLog();
                myLog();
                myLog("Lo que se va a guardar:   ");
                myLog();
                
                $col->dumpObj("<br>\n");
                $col->Guardar();
                
                if ($col->getError())
                {
                    $doCommitPedido = false;
                    myLog($col->getStrError());
                    break;
                }
                
                //                 $col->Guardar();
                
                myLog();
                myLog();
            }
            
            if ($doCommitPedido)
            {
                $pedidoProcesando->setColocadoSI();
                $pedidoProcesando->setEstadoAUTORIZADO();
                $pedidoProcesando->setTipoAutorizacionAUTOMATICO();
                $pedidoProcesando->setObservacionAutoriza("Pedido Autorizado en Automático por proceso");
                $pedidoProcesando->setId_usuario_autorizado(2);
                $pedidoProcesando->setFecha_autorizado($pedidoProcesando->NOW());

                $pedidoProcesando->setColocadoAutomaticoSI();
                
                
                
                $pedidoProcesando->Guardar();
                
                $pedidoProcesando->NotificaAutorizacionAutomaticaPedido();
                
                myLog();
                if ($pedidoProcesando->getRecogeentrega() == "RECOGE")
                {
                    myLog("Se generaran los vales en automatico");
                    $msg = "";
                    $pedidoProcesando->generarValesSalidaAutomatico($pedidoProcesando->getIdPedido(), $msg);
                }
                
                $pedidoProcesando->transaccionCommit();
                myLog();
                myLog("FIN Pedido: <h1>" . $idPedidoProcesando . "</h1>");
                myLog("---------------------------------------------------------------------------------------------------------------------------------------------");
            }
            else
            {
                myLog();
                myLog("FIN Pedido ... ERA COMMIT PERO HUBO ER   ROR: <h1>" . $idPedidoProcesando . "</h1>");
                myLog("---------------------------------------------------------------------------------------------------------------------------------------------");
            }
            
            
        }
        else
        {
            // 			myLog();
            myLog();
            myLog(" - - - - - R O L L B A C K  - - - - -");
            myLog(" - - - - - BUENO YA NO ES ROLLBACK  - - - - -");
            $pedidoProcesando->transaccionRollback();
            
            
            // 			$pedidoProcesando->transaccionRollback();
            
            // ya no se guarda lo del pedido, porque ya se guard�, al no haber ya
            //rollback, se queda guardado
            
            foreach ($arrColocaciones as $col)
            {
                //                 myLog();
                myLog();
                myLog("Lo que se guardaria:   ");
                myLog();
                
                $col->dumpObj("<br>\n");
                
                //                 $detalleAActualizarSiEstaListo->Guardar();
                
                //                 myLog();
                myLog();
            }
            
            //             $pedidoProcesando->setExplotado("SI");
            //             $pedidoProcesando->Guardar();
            //             $pedidoProcesando->transaccionCommit();
            
            // 			myLog();
            myLog(" - ASIGNADO NO ROLLBACK -");
            myLog();
            myLog("FIN Pedido: <h1>" . $idPedidoProcesando . "</h1>");
            myLog("---------------------------------------------------------------------------------------------------------------------------------------------");
            // 			myLog();
        }
        
        
        // 		myLog();
        myLog();
    }
    
    
}
