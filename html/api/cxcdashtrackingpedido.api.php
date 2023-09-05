<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.pedidostracking.inc.php";

class APICxcDashTrackingPedido extends APIBase{

    public function loadPedido(){
      $idPedido = $_GET["idPedido"];
        
      $query = "            
          SELECT pedido.total, pedido.saldo, concat(cliente.nombre, ' ', cliente.apellidos) nombreCliente
        FROM pedido
      INNER JOIN cliente ON pedido.idCliente = cliente.idCliente
      WHERE pedido.idPedido = ". $idPedido;

      $pt = new ModeloPedidostracking();

      $rs = $pt->getDataSet($query);
      
      if (count($rs) == 0){
        $this->throwError("No se encontró información del Pedido");
      }

      $this->addResponse("error", false);        
      $this->addResponse("pedido", $rs[0]);              
    }

    public function getEstatusPage(){
        $idPedido = $_GET["idPedido"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];

        $query = "
            SELECT IFNULL(trace, json) trace, IF(trace is null, '', json) json, tipo, fecha
              FROM pedidostracking ptrack
              LEFT JOIN pedidotrace ptrace ON ptrack.idPedidoTrace = ptrace.idPedidoTrace 
              WHERE idPedido = ".$idPedido."
               AND track = 'PEDIDO'
        ";

        $pt = new ModeloPedidostracking();

        $rs = $pt->getDataSet($query);

        $totalReg = count($rs);

        $query = "
            SELECT IFNULL(trace, json) trace, IF(trace is null, '', json) json, tipo, fecha
              FROM pedidostracking ptrack
              LEFT JOIN pedidotrace ptrace ON ptrack.idPedidoTrace = ptrace.idPedidoTrace
              WHERE idPedido = ".$idPedido."
               AND track = 'PEDIDO'
               ORDER BY idPedidosTracking DESC
              LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $track = $pt->getDataSet($query);
                
        $this->addResponse("error", false);  
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("track", $track);          
    }

    public function getValesPage(){
        $idPedido = $_GET["idPedido"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];

        $query = "
            SELECT IFNULL(trace, json) trace, IF(trace is null, '', json) json, tipo, fecha
              FROM pedidostracking ptrack
              LEFT JOIN pedidotrace ptrace ON ptrack.idPedidoTrace = ptrace.idPedidoTrace
             WHERE idPedido = ".$idPedido."
               AND track = 'VALESALIDA'
        ";

        $pt = new ModeloPedidostracking();

        $rs = $pt->getDataSet($query);

        $totalReg = count($rs);

        $query = "
            SELECT IFNULL(trace, json) trace, IF(trace is null, '', json) json, tipo, fecha
              FROM pedidostracking ptrack
              LEFT JOIN pedidotrace ptrace ON ptrack.idPedidoTrace = ptrace.idPedidoTrace
              WHERE idPedido = ".$idPedido."
               AND track = 'VALESALIDA'
               ORDER BY idPedidosTracking DESC
              LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $track = $pt->getDataSet($query);
                
        $this->addResponse("error", false);  
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("track", $track);          
    }

}

$api = new APICxcDashTrackingPedido();
$api->run();