<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.pedidodetalle.inc.php";

class APIvtakilos extends APIBase{

        
        public function getkilospagados(){

                $fechaInicio = $_GET["fi"];
                $fechaFin = $_GET["ff"];
                // $this->addResponse("fi", $fechaInicio);
                // $this->addResponse("ff", $fechaFin);
                // return;
                // $fechaInicio='2021-05-31';
                // $fechaFin='2021-10-31';
                
                $query = "
                SELECT  rollo.idRollo, rollo.codigo, rollo.descripcion,  
                SUM(if(producto.producto_unidad_idUnidad = 3 ,pedidodetalle.partida,0))as kilosRollo, 
                SUM(if(producto.producto_unidad_idUnidad = 1 or producto.producto_unidad_idUnidad = 4 ,pedidodetalle.partida * pedidodetalle.cantidad * pedidodetalle.pesoKiloML * if(producto.longitud= 0,1,producto.longitud) ,0))kilosAcanalado,
                SUM(if(pedidodetalle.idProducto = 9 , rollo.pesokgmt*  pedidodetalle.partida * (pedidodetalle.cantidad/(round((rollo.pies*30.5)/ pedidodetalle.desarrollo))),0))as kilosMoldura
                FROM `pedidodetalle`
                INNER JOIN producto on producto.idProducto = pedidodetalle.idProducto
                INNER JOIN rollo on pedidodetalle.idRolloBase = rollo.idRollo
                INNER JOIN  pedido on pedido.idPedido = pedidodetalle.IdPedido
                WHERE 
                pedidodetalle.idRolloBase >1 
                and pedido.estado <> 'CANCELADO'

                AND date_format(pedido.fecha_saldada, '%Y-%m-%d') 
                BETWEEN '".$fechaInicio."' and '".$fechaFin."'
                GROUP BY rollo.idRollo";

                 
                $lstpedidodetalle = new ModeloPedidoDetalle();

                $lst = $lstpedidodetalle->getDataSet($query);

               
                //  $this->addResponse ("prueba", $prueba); return;
               
                $lstRollo = array();
               
                $kilosRollo = 'kilosRollo';
                $kilosAcanalado = 'kilosAcanalado';
                $kilosMoldura ='kilosMoldura';
                $totalRollo = array_sum(array_column($lst,$kilosRollo));
                $totalAcanalado = array_sum(array_column($lst,$kilosAcanalado));
                $totalMoldura = array_sum(array_column($lst,$kilosMoldura));
             
                if (count($lst) > 0){
                        
                        $this->addResponse ("error", false);
                        $this->addResponse ("lstRollo", $lst);
                        $this->addResponse ("totalRollo",$totalRollo);
                        $this->addResponse ("totalAcanalado",$totalAcanalado);
                        $this->addResponse ("totalMoldura",$totalMoldura);

                    
                }else {

                        $lst = "";
                        $this->addResponse ("error", true);
                        $this->addResponse ("msg", "No se pudo obtener datos");
                }   
          
        }  
        
       
          
        
}


$api = new APIvtakilos();
$api->run();


  