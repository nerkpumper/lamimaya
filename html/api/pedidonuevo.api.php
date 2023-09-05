<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.clientedatosfacturacion.inc.php";


class APIPedidoNuevo extends APIBase{

    public function getRFCsCliente(){

        $idCliente = $_GET["idCliente"];

        $query = "SELECT idClienteDatosFacturacion
                    FROM clientedatosfacturacion 
                   WHERE idCliente = ".$idCliente."
                   ORDER BY idClienteDatosFacturacion";

        $count = 0;
        $idClienteDatosFacturacion = 0;

        $cdf = new ModeloClientedatosfacturacion();

        $rs = $cdf->getDataSet($query);

        if (count($rs) > 0)
        {
            $count = count($rs);
            $idClienteDatosFacturacion = $rs[0]["idClienteDatosFacturacion"];
        }
        
        $this->addResponse("error", false);
        $this->addResponse("count", $count);
        $this->addResponse("idClienteDatosFacturacion", $idClienteDatosFacturacion);
    }

}

$api = new APIPedidoNuevo();
$api->run();