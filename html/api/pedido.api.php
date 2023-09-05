<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";


class APIPedido extends APIBase{

    public function getFechaCompromisoPorVencer(){
        $idUsuarioCapturado = $_GET["idUsuarioCaptura"];

        //$idUsuarioCapturado = 18;
        

        $query = "SELECT pedido.idPedido, concat(cliente.nombre,' ', cliente.apellidos) as cliente , pedido.total, pedido.fecha_capturado, pedido.estado, pedido.fechaCompromiso, pedido.fechaEntregaPorDefinir , DATE_ADD(curdate(),interval 3 DAY) as porVencer FROM `pedido`
        INNER JOIN cliente on pedido.idCliente = cliente.idCliente  
        
        where not pedido.estado IN('CANCELADO', 'ENTREGADO') AND pedido.fechaCompromiso < DATE_ADD(curdate(),interval 2 DAY)  and pedido.fechaEntregaPorDefinir<>'SI' and pedido.recogeentrega <> 'OBRA' and pedido.id_usuario_capturado = " .$idUsuarioCapturado;

        $s = new ModeloPedido();

        $lst = $s->getDataSet($query);
        
        if (count($lst) > 0 )
        {
            $this->addResponse("error", false);
            $this->addResponse("lst", $lst);
        }
        else
        {
            $this->throwError("No se pudo obtener datos");
        }

    }


    public function updateFechaCompromiso(){
        $pedido = new ModeloPedido();
        $idPedido = $_GET["idPedido"];
        $fechaCompromiso = $_GET["fechaCompromiso"];
       //$idPedido = 19202;
        //$fechaCompromiso='2022-07-07 17:39:00';

        
        $pedido->setIdPedido($idPedido);
        

        if ($pedido->getIdpedido() > 0 ){
           

            $pedido->setFechaCompromiso($fechaCompromiso);
            $pedido->Guardar();
		
            if (!$pedido->getError())
            {
                $this->addResponse("error", false); 
            }
            else{
                $this->throwError("Parece que el pedido que ha indicado no existe.");
            }
        }
    }

    public function cerrarPedidosOtrosCargos(){
        $pedido = new ModeloPedido();
        $pedidoDetalle = new ModeloPedidoDetalle();
        $idPedido = $_GET["idPedido"];
        $idUsuario = $_GET["idUsuario"];
        $fechaActual = date('Y-m-d H:i:s');
        
        $pedido->setIdPedido($idPedido);

        if ($pedido->getIdpedido() > 0 ){
           
            
            $pedido->setEstadoENTREGADO();
            $pedido->setFecha_entregado($fechaActual);
            $pedido->setId_usuario_entregado($idUsuario);
            $pedido->Guardar();
		
            if (!$pedido->getError())
            {
                $this->addResponse("error", false); 
            }
            else{
                $this->throwError("Parece que el pedido que ha indicado no existe.");
            }
        }
    }

    public function getPedidoOtrosCargos(){
        $query = "SELECT pedido.idPedido, concat(cliente.nombre,' ', cliente.apellidos)as cliente, getPromotorPedido(idPedido) as promotor, pedido.fecha_capturado, pedido.fechaCompromiso, pedido.estado FROM `pedido` INNER JOIN cliente on cliente.idCliente = pedido.idCliente where otrosCargos > 0 and pedido.estado NOT in('ENTREGADO', 'CANCELADO') and getNumRenglonesPedido(idPedido) = 0";

        $pedido = new ModeloPedido();

        $lst = $pedido->getDataSet($query);
        
        if (count($lst) > 0 )
        {
            $this->addResponse("error", false);
            $this->addResponse("lst", $lst);
        }
        else
        {
            $this->throwError("No se pudo obtener datos");
        }
    }
}

$api = new APIpedido();
$api->run();