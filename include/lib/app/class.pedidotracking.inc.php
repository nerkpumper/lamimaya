<?php


class PedidoTrackingManager
{        
    public static $INFO = "INFO";
    public static $WARNING = "WARNING";
    public static $SUCCESS = "SUCCESS";
    public static $ERROR = "ERROR";

    private static $arr = array();

    public static function init()
    {
        self::$arr = array();
    }

    public static function add($idpedido, $idPedidoTrace, $json, $tipo)
    {
        self::$arr[] = array("idpedido" => $idpedido, "tipo" => $tipo, "json" => $json, "idPedidoTrace" => $idPedidoTrace);
    }

    public static function flush($pedido = true)
    {
        foreach(self::$arr as $item)
        {
            self::save($item["idpedido"], $item["idPedidoTrace"], $item["json"], $item["tipo"], $pedido);
        }
        self::init();
    }

    public static function logInfo($idPedido, $idPedidoTrace, $json, $pedido = true)
    {
        self::save($idPedido, $idPedidoTrace, "", "INFO", $pedido);
    }

    public static function logWarning($idPedido, $idPedidoTrace, $json, $pedido = true)
    {
        self::save($idPedido, $idPedidoTrace, $json, "WARNING", $pedido);
    }

    public static function logSuccess($idPedido, $idPedidoTrace, $json, $pedido = true)
    {
        self::save($idPedido, $idPedidoTrace, $json, "SUCCESS", $pedido);
    }

    public static function logError($idPedido, $idPedidoTrace, $json, $pedido = true)
    {
        self::save($idPedido, $idPedidoTrace, $json, "ERROR", $pedido);
    }

    private static function save($idPedido, $idPedidoTrace, $json, $tipo, $pedido = true)
    {
        $pt = new ModeloPedidostracking();

        $pt->setIdPedido($idPedido);
        $pt->setIdPedidoTrace($idPedidoTrace);
        $pt->setJson($json);
        $pt->setTipo($tipo);
        $pt->setFecha(date("Y-m-d H:i:s"));

        if ($pedido)
        {
            $pt->setTrackPEDIDO();
        }
        else
        {
            $pt->setTrackVALESALIDA();
        }

        $pt->Guardar();


    }
}