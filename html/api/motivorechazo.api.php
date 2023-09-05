<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.motivorechazo.inc.php";

class APImotivorechazo extends APIBase{

    public function getMotivoRechazo(){

        $query = "SELECT * FROM `motivorechazo`";

        $motivo = new ModeloMotivoRechazo();

        $lst = $motivo->getDataSet($query);
        
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

$api = new APImotivorechazo();
$api->run();