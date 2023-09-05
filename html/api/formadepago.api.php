<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.formapago.inc.php";


class APIformadepago extends APIBase{

    public function getFormaDePagoSucursal(){
        $formaPago = new ModeloFormaPago();
        $idSucursal =$_GET["idSucursal"];

        if($idSucursal == 1){

            $query = "SELECT * FROM formapago";

            $lst = $formaPago->getDataSet($query);
    
            $this->addResponse("error", false);
            $this->addResponse("list", $lst);
            
        }
        else{

            
        $query = "SELECT * FROM formapago where NOT idFormaPago in(3, 22) ";

        $lst = $formaPago->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("list", $lst);


        }

    }   

}




$api = new APIformadepago();
$api->run();