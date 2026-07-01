<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.registroproducciondetalle.inc.php";


class APIacanaladoproduccion extends APIBase{
     
    
public function getProduccionAcanaladoMensual(){

        
    IF($_GET["idSucursal"] =="" || $_GET["idSucursal"] == 0){
        $idSucursal = 1;
    }else{
        $idSucursal = $_GET["idSucursal"];
    };
    
    

    $query = "SELECT 
    date_format(registroproducciondetalle.fecha_captura, '%m') as mes, 
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=01,'Enero',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=02,'Febrero',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=03,'Marzo',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=04,'Abril', 
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=05,'Mayo',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=06,'Junio',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=07,'Julio',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=08,'Agosto', 
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=09,'Septiembre',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=10,'Octubre',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=11,'Noviembre',
            IF(date_format(registroproducciondetalle.fecha_captura, '%m')=12,'Diciembre',    
            date_format(registroproducciondetalle.fecha_captura, '%m')))))))))))))as mesDes,
    sum(IF(nombreAplicacion ='R-101', (registroproducciondetalle.totalKg), 0)) as R_101,
    sum(IF(nombreAplicacion ='RN-100',(registroproducciondetalle.totalKg), 0)) as RN_100, 
    sum(IF(nombreAplicacion ='OG-100', (registroproducciondetalle.totalKg), 0)) as OG_100,
    SUM(IF(nombreAplicacion ='LOSACERO', (registroproducciondetalle.totalKg), 0)) as LOSACERO,
    sum(IF(nombreAplicacion ='R-72', (registroproducciondetalle.totalKg), 0)) as R_72,
    sum(IF(nombreAplicacion ='KR-18', (registroproducciondetalle.totalKg), 0)) as KR_18,
    sum(IF(nombreAplicacion ='TEJ GAL', (registroproducciondetalle.totalKg), 0)) as GALVATEJA
    

    

    
    FROM `registroproducciondetalle`
    INNER join pedidodetalle on pedidodetalle.idPedidoDetalle = registroproducciondetalle.idPedidoDetalle
    INNER JOIN pedido on pedidodetalle.IdPedido =  pedido.idPedido
    INNER JOIN registroproduccion  on registroproducciondetalle.idRegistroProduccion = registroproduccion.idRegistroProduccion
    INNER JOIN remisionrollo on remisionrollo.idRemisionRollo = registroproduccion.idRemisionRollo
    INNER JOIN producto on pedidodetalle.idProducto = producto.idProducto
    INNER JOIN aplicacion on producto.producto_aplicacion_idAplicacion = aplicacion.idAplicacion
    WHERE  date_format(registroproducciondetalle.fecha_captura, '%Y')= '2022' and registroproducciondetalle.idProducto
    <> 9 and registroproducciondetalle.idSucursal='".$idSucursal."'
    GROUP BY mes 
    ORDER BY `mes` ASC";

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
    public function getProduccionAcanaladoDiario(){
        $idSucursal = 1;
    
        $query = "SELECT aplicacion.nombreAplicacion as acanalado ,  sum(registroproducciondetalle.totalKg) as kg   FROM `registroproducciondetalle`
        INNER join pedidodetalle on pedidodetalle.idPedidoDetalle = registroproducciondetalle.idPedidoDetalle
        INNER JOIN pedido on pedidodetalle.IdPedido =  pedido.idPedido
        INNER JOIN registroproduccion  on registroproducciondetalle.idRegistroProduccion = registroproduccion.idRegistroProduccion
        INNER JOIN remisionrollo on remisionrollo.idRemisionRollo = registroproduccion.idRemisionRollo
        INNER JOIN producto on pedidodetalle.idProducto = producto.idProducto
        INNER JOIN aplicacion on producto.producto_aplicacion_idAplicacion = aplicacion.idAplicacion
        WHERE  date_format(registroproducciondetalle.fecha_captura, '%Y-%m-%d')= curdate() and registroproducciondetalle.idProducto
        <> 9 and registroproducciondetalle.idSucursal= 1 and aplicacion.nombreAplicacion in('RN-100', 'R-101', 'OG-100', 'R-72', 'LOSACERO')
        
        GROUP BY aplicacion.nombreAplicacion";
    
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
 
$api = new APIacanaladoproduccion();
$api->run();