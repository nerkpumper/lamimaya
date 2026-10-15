<?php

// Librería compartida para la lógica de explosión de pedidos
// Uso: $ctx = ExplosionHelper::crearContextoPesos(); ExplosionHelper::procesarExplosionPedido($idPedido, $ctx);

class ExplosionHelper
{
    // Crea el arreglo de pesos por calibre y pies (igual a explosion.cron.php)
    public static function crearContextoPesos()
    {
        require_once FOLDER_MODEL . "model.pesomt.inc.php";
        
        $pesomt = new ModeloPesomt();
        $lstPesomt = $pesomt->getAll();
        $pesosCalibresPies = array();
        
        foreach ($lstPesomt as $item) {
            $pesosCalibresPies[$item["calibre"]] = array(
                "calibre" => $item["calibre"],
                "2" => $item["pies2"],
                "3" => $item["pies3"],
                "348" => $item["pies348"],
                "376" => $item["pies376"],
                "4" => $item["pies4"]
            );
        }
        
        return array(
            'pesosCalibresPies' => $pesosCalibresPies,
            'idProductoMoldura' => 9,
            'idProductoMaquilaMoldura' => 10,
            'idProductoISOCOP' => 439
        );
    }
    
    // Procesa la explosión para un solo pedido
    // $productosNegados: array pasado por referencia (para mantener estado entre pedidos si se desea)
    // $logLineas: array pasado por referencia donde se acumulan las líneas de bitácora (para mostrarlas en un popup)
    // Devuelve array('success' => bool, 'commit' => bool, 'msg' => string)
    public static function procesarExplosionPedido($idPedidoProcesando, &$ctx, &$productosNegados = null, $debug = false, &$logLineas = null)
    {
        if ($productosNegados === null) {
            $productosNegados = array();
        }
        
        require_once FOLDER_MODEL . "model.producto.inc.php";
        require_once FOLDER_MODEL . "model.rollo.inc.php";
        require_once FOLDER_MODEL . "model.pedido.inc.php";
        require_once FOLDER_MODEL . "model.pedidodetalle.inc.php";
        require_once FOLDER_MODEL . "model.viewproductos.inc.php";
        
        $log = function($msg) use ($debug, &$logLineas) {
            if ($logLineas !== null) {
                $logLineas[] = $msg;
            }
            if ($debug) {
                echo (defined('isCONSOLE') && isCONSOLE ? "\n" : "<br>") . $msg;
            }
        };
        
        $pesosCalibresPies = $ctx['pesosCalibresPies'];
        $idProductoMoldura = $ctx['idProductoMoldura'];
        $idProductoMaquilaMoldura = $ctx['idProductoMaquilaMoldura'];
        $idProductoISOCOP = $ctx['idProductoISOCOP'];
        
        $pedidoProcesando = new ModeloPedido();
        $pedidoDetalle = new ModeloPedidodetalle();
        $pedidoProcesando->setIdPedido($idPedidoProcesando);
        
        if ($pedidoProcesando->getIdPedido() <= 0) {
            return array('success' => false, 'commit' => false, 'msg' => 'Pedido no encontrado');
        }
        
        $lstPedidoDetalle = $pedidoDetalle->getAll(
            "idPedidoDetalle, renglon, idProducto, tipoPrecio, partida, cantidad, cantidadReal, totalExplotar, totalExplotado, listo_para_producir",
            "",
            "idPedido = " . $idPedidoProcesando . " AND listo_para_producir = 'NO'"
        );
        
        $log("Pedido #" . $idPedidoProcesando . ": " . count($lstPedidoDetalle) . " renglón(es) pendiente(s) de explotar.");
        
        $doCommitPedido = true;
        $detallesProductosAux = array();
        
        // Calcular lo que se debe explotar
        foreach ($lstPedidoDetalle as $det) {
            $idPedidoDetalle = $det["idPedidoDetalle"];
            $updatePedidoDetalle = new ModeloPedidodetalle();
            $updatePedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);
            
            $viewProducto = new ModeloViewproductos();
            $viewProducto->getView($det["idProducto"]);
            
            $partida = $det["partida"];
            $cantidad = $det["cantidad"];
            $cantidadReal = $det["cantidadReal"];
            
            $calibreProducto = $viewProducto->getRolloCalibre();
            $piesProducto = $viewProducto->getRolloPies();
            $piesProductosinpunto = str_replace(".", "", $piesProducto);
            
            if ($viewProducto->getIdProducto() != $idProductoMoldura && 
                $viewProducto->getIdProducto() != $idProductoMaquilaMoldura && 
                $viewProducto->getIdProducto() != $idProductoISOCOP) {
                
                if ($viewProducto->getShortUnidad() == "PZA" || 
                    $viewProducto->getShortUnidad() == "KG" || 
                    ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1)) {
                    
                    if ($viewProducto->getShortUnidad() == "PZA" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1)) {
                        $updatePedidoDetalle->setTotalExplotar($partida * $cantidad);
                        $updatePedidoDetalle->setExplotarUnidad(1);
                        $updatePedidoDetalle->Guardar();
                    } else {
                        $updatePedidoDetalle->setTotalExplotar($partida);
                        $updatePedidoDetalle->setExplotarUnidad(1);
                        $updatePedidoDetalle->Guardar();
                    }
                } else {
                    $kilosRolloApartar = 0;
                    $kilosRollosXUnidad = 0;
                    $pesoAConsiderar = 0;
                    
                    if (isset($pesosCalibresPies[$calibreProducto]) && isset($pesosCalibresPies[$calibreProducto][$piesProductosinpunto])) {
                        $pesoAConsiderar = $pesosCalibresPies[$calibreProducto][$piesProductosinpunto];
                    }
                    
                    if ($pesoAConsiderar > 0) {
                        $kilosRolloApartar = $pesoAConsiderar * $cantidadReal * $partida;
                        $kilosRollosXUnidad = $pesoAConsiderar * $cantidadReal;
                    }
                    
                    if ($kilosRolloApartar > 0) {
                        $updatePedidoDetalle->setTotalExplotar($kilosRolloApartar);
                        $updatePedidoDetalle->setExplotarUnidad($kilosRollosXUnidad);
                        $updatePedidoDetalle->Guardar();
                    }
                }
            } else {
                $updatePedidoDetalle->setTotalExplotar($partida);
                $updatePedidoDetalle->setTotalExplotado($partida);
                $updatePedidoDetalle->setExplotarUnidad(1);
                $updatePedidoDetalle->Guardar();
            }
        }
        
        // Explosión con apartados
        $productosApartados = array();
        $pedidoProcesando->transaccionIniciar();
        
        foreach ($lstPedidoDetalle as $det) {
            $idPedidoDetalle = $det["idPedidoDetalle"];
            $updatePedidoDetalle = new ModeloPedidodetalle();
            $updatePedidoDetalle->setIdPedidoDetalle($idPedidoDetalle);
            
            $viewProducto = new ModeloViewproductos();
            $viewProducto->getView($det["idProducto"]);
            
            if (!isset($productosApartados["pieza" . $viewProducto->getIdProducto()])) {
                $productosApartados["pieza" . $viewProducto->getIdProducto()] = $viewProducto->getExistencia() - $viewProducto->getApartado();
            }
            
            if (!isset($productosApartados["rollo" . $viewProducto->getIdRollo()])) {
                $productosApartados["rollo" . $viewProducto->getIdRollo()] = $viewProducto->getRolloExistencia() - $viewProducto->getRolloApartado();
            }
            
            $totalAExplotar = $updatePedidoDetalle->getTotalExplotar();
            $idProductoToCheck = 0;
            
            $log("  Renglón " . $det["renglon"] . " · Prod " . $viewProducto->getIdProducto() . " " . $viewProducto->getDescripcion() . " · a explotar: " . $totalAExplotar);
            
            if ($viewProducto->getIdProducto() != $idProductoMoldura && 
                $viewProducto->getIdProducto() != $idProductoMaquilaMoldura && 
                $viewProducto->getIdProducto() != $idProductoISOCOP) {
                
                if ($viewProducto->getShortUnidad() == "PZA" || 
                    $viewProducto->getShortUnidad() == "KG" || 
                    ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1)) {
                    
                    if ($viewProducto->getShortUnidad() == "PZA" || ($viewProducto->getShortUnidad() == "ML" && $viewProducto->getIdRollo() == 1)) {
                        $idProductoToCheck = $viewProducto->getIdProducto();
                        if (!isset($productosNegados["pn" . $idProductoToCheck])) {
                            $sacarProducto = new ModeloProducto();
                            $sacarProducto->setIdProducto($viewProducto->getIdProducto());
                            $deDondeDescontar = $productosApartados["pieza" . $viewProducto->getIdProducto()];
                            if ($deDondeDescontar >= $totalAExplotar) {
                                $sacarProducto->addApartar($totalAExplotar);
                                $sacarProducto->Guardar();
                                $updatePedidoDetalle->setListo_para_producir("SI");
                                $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                                $productosApartados["pieza" . $viewProducto->getIdProducto()] = $productosApartados["pieza" . $viewProducto->getIdProducto()] - $totalAExplotar;
                                array_push($detallesProductosAux, $updatePedidoDetalle);
                            } else {
                                $doCommitPedido = false;
                                $productosNegados["pn" . $idProductoToCheck] = "NO";
                                $updatePedidoDetalle->setListo_para_producir("NO");
                                array_push($detallesProductosAux, $updatePedidoDetalle);
                            }
                        } else {
                            $doCommitPedido = false;
                        }
                    } else {
                        $idProductoToCheck = $viewProducto->getIdProducto();
                        if (!isset($productosNegados["pn" . $idProductoToCheck])) {
                            $sacarRollo = new ModeloRollo();
                            $sacarRollo->setIdRollo($viewProducto->getIdRollo());
                            $deDondeDescontar = $productosApartados["rollo" . $viewProducto->getIdRollo()];
                            if ($deDondeDescontar >= $totalAExplotar) {
                                $sacarRollo->addApartar($totalAExplotar);
                                $sacarRollo->Guardar();
                                $updatePedidoDetalle->setListo_para_producir("SI");
                                $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                                $productosApartados["rollo" . $viewProducto->getIdRollo()] = $productosApartados["rollo" . $viewProducto->getIdRollo()] - $totalAExplotar;
                                array_push($detallesProductosAux, $updatePedidoDetalle);
                            } else {
                                $doCommitPedido = false;
                                $productosNegados["pn" . $idProductoToCheck] = "NO";
                                $updatePedidoDetalle->setListo_para_producir("NO");
                                array_push($detallesProductosAux, $updatePedidoDetalle);
                            }
                        } else {
                            $doCommitPedido = false;
                        }
                    }
                } else {
                    $idProductoToCheck = $viewProducto->getIdProducto();
                    if (!isset($productosNegados["pn" . $idProductoToCheck])) {
                        if ($totalAExplotar > 0) {
                            $sacarRollo = new ModeloRollo();
                            $sacarRollo->setIdRollo($viewProducto->getIdRollo());
                            $deDondeDescontar = $productosApartados["rollo" . $viewProducto->getIdRollo()];
                            if ($deDondeDescontar >= $totalAExplotar) {
                                $sacarRollo->addApartar($totalAExplotar);
                                $sacarRollo->Guardar();
                                $updatePedidoDetalle->setListo_para_producir("SI");
                                $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                                $productosApartados["rollo" . $viewProducto->getIdRollo()] = $productosApartados["rollo" . $viewProducto->getIdRollo()] - $totalAExplotar;
                                array_push($detallesProductosAux, $updatePedidoDetalle);
                            } else {
                                $doCommitPedido = false;
                                $productosNegados["pn" . $idProductoToCheck] = "NO";
                                $updatePedidoDetalle->setListo_para_producir("NO");
                                array_push($detallesProductosAux, $updatePedidoDetalle);
                            }
                        } else {
                            $doCommitPedido = false;
                        }
                    } else {
                        $doCommitPedido = false;
                    }
                }
            } else {
                $updatePedidoDetalle->setListo_para_producir("SI");
                $updatePedidoDetalle->setTotalExplotado($totalAExplotar);
                array_push($detallesProductosAux, $updatePedidoDetalle);
            }
            
            $log("     => " . ($updatePedidoDetalle->getListo_para_producir() == "SI" ? "cubierto" : "SIN cubrir (falta material)"));
        }
        
        if ($doCommitPedido) {
            $pedidoProcesando->setExplotado("SI");
            $pedidoProcesando->setListo_para_producir("SI");
            $pedidoProcesando->setExplotadook("SI");
            $pedidoProcesando->Guardar();
            foreach ($detallesProductosAux as $detalleAActualizarSiEstaListo) {
                $detalleAActualizarSiEstaListo->Guardar();
            }
            $pedidoProcesando->transaccionCommit();
            $log("RESULTADO: el Pedido #" . $idPedidoProcesando . " YA PUEDE PRODUCIRSE.");
            return array('success' => true, 'commit' => true, 'msg' => 'Explosión completa');
        } else {
            foreach ($detallesProductosAux as $detalleAActualizarSiEstaListo) {
                $detalleAActualizarSiEstaListo->Guardar();
            }
            $pedidoProcesando->setExplotado("SI");
            $pedidoProcesando->Guardar();
            $pedidoProcesando->transaccionCommit();
            $log("RESULTADO: falta material; el Pedido #" . $idPedidoProcesando . " permanece en 'Sin material'.");
            return array('success' => true, 'commit' => false, 'msg' => 'Explosión parcial - falta material');
        }
    }
}
