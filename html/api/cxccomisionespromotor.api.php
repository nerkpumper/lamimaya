<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.objetivopromotor.inc.php";

class APICxcComisionesPromotor extends APIBase{

    public function getObjetivo(){
        $tipo = $_GET["tipo"];
        $mes = $_GET["mes"];
        $anio = $_GET["anio"];
        $idPromotor = $_GET["idPromotor"];
        
        $op = new ModeloObjetivopromotor();

        $sql = "SELECT objetivo 
                from objetivopromotor
                WHERE tipo = '".$tipo."'
                AND idPromotor = ".$idPromotor." 
                AND anio = ".$anio;

        if ($tipo != "A") 
                $sql .= " AND mes = " . $mes;        
        
        $rs = $op->getDataSet($sql);

        if (!$rs)
        {
            $this->addResponse("error", false);                                
            $this->addResponse("objetivo", 0);                                       
            return;
        }

        $objetivo = $rs[0]["objetivo"];       

        $this->addResponse("error", false);        
        $this->addResponse("objetivo", $objetivo);                                       

        
    }

}

$api = new APICxcComisionesPromotor();
$api->run();