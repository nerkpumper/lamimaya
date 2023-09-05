<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";


class APImolduraproduccion extends APIBase{
     
    
public function getProduccionMoldura(){
    
    IF($_GET["idSucursal"] =="" || $_GET["idSucursal"] == 0){
        $idSucursal = 1;
    }else{
        $idSucursal = $_GET["idSucursal"];
    };

    $query = "SELECT  
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=01,'Enero',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=02,'Febrero',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=03,'Marzo',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=04,'Abril', 
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=05,'Mayo',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=06,'Junio',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=07,'Julio',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=08,'Agosto', 
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=09,'Septiembre',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=10,'Octubre',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=11,'Noviembre',
    IF(date_format(pedidodetalle.fecha_despachado, '%m')=12,'Diciembre',    
    date_format(pedidodetalle.fecha_despachado, '%m')))))))))))))as mes,

sum(pedidodetalle.partida) as cant, sum(pedidodetalle.partida * pedidodetalle.cantidad)as totalml,  sum(pedidodetalle.dobleces * pedidodetalle.partida) as totaldobl FROM `pedidodetalle` 
inner JOIN producto on producto.idProducto = pedidodetalle.idProducto
inner join pedido on pedido.idPedido = pedidodetalle.IdPedido
where pedidodetalle.idProducto in(386, 394) and pedido.estado <> 'CANCELADO'  AND  date_format(pedidodetalle.fecha_despachado, '%Y')= date_format(curdate(), '%Y') and pedidodetalle.idSucursalDespachado= ".$idSucursal."  GROUP BY 1
ORDER BY `pedidodetalle`.`fecha_despachado`  ASC";

    $s = new ModeloRegistroproducciondetalle();

    $lst = $s->getDataSet($query);
    
        if (count($lst) > 0 )
        {
            $this->addResponse("error", false);
            $this->addResponse("lst", $lst);
        }
        else
        {
            $this->throwError("No se pudo obtener dato de la Sucursal");
        }

    }
    
}
 
$api = new APImolduraproduccion();
$api->run();

