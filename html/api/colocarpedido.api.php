<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";


class APIcolocarpedido extends APIBase{

    public function reintentarExplosion(){
        require_once FOLDER_INCLUDE . "lib/explosion.inc.php";

        $idPedido = (int)$_GET["idPedido"];

        $pedido = new ModeloPedido();

        $lst = $pedido->getAll("pedido.idPedido, pedido.estado, pedido.explotado, pedido.explotadook",
            " ",
            "pedido.idPedido = " . $idPedido,
            "");

        $estado = "";
        $explotadook = "";
        foreach ($lst as $row)
        {
            $estado = $row["estado"];
            $explotadook = $row["explotadook"];
        }

        if ($estado == "")
        {
            $this->throwError("No se encontró el Pedido " . $idPedido . ".");
        }

        if ($explotadook != "NO")
        {
            $this->addResponse("error", false);
            $this->addResponse("yaExplotado", true);
            $this->addResponse("msg", "El Pedido " . $idPedido . " ya está explotado con éxito.");
            return;
        }

        if ($estado != "AUTORIZADO" && $estado != "PRODUCCION")
        {
            $this->throwError("El Pedido " . $idPedido . " no está en un estado que permita re-explosionar (estado: " . $estado . ").");
        }

        $ctx = ExplosionHelper::crearContextoPesos();
        $negados = array();
        $logLineas = array();
        $res = ExplosionHelper::procesarExplosionPedido($idPedido, $ctx, $negados, false, $logLineas);

        $this->addResponse("error", false);
        $this->addResponse("yaExplotado", false);
        $this->addResponse("commit", $res["commit"]);
        $this->addResponse("lineas", array_values($logLineas));
    }
}


$api = new APIcolocarpedido();
$api->checkSecurity = true;
$api->run();
