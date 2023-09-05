<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.sucursal.inc.php";


class APISucursal extends APIBase{

    public function get(){
        $idSucursal = $_GET["idSucursal"];

        $query = "SELECT idSucursal, nombre, visible FROM sucursal WHERE idSucursal = " .$idSucursal;

        $s = new ModeloSucursal();

        $rs = $s->getDataSet($query);
        
        if (count($rs) > 0 )
        {
            $this->addResponse("error", false);
            $this->addResponse("sucursal", $rs[0]);
        }
        else
        {
            $this->throwError("No se pudo obtener dato de la Sucursal");
        }

    }

    public function getSucursales(){
        $s = new ModeloSucursal();

        $query = "SELECT idSucursal, nombre FROM sucursal WHERE visible = 'SI'";

        $lst = $s->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("list", $lst);
    }

    
}

$api = new APISucursal();
$api->run();