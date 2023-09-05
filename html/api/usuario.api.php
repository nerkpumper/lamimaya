<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.usuario.inc.php";

class APIusuario extends APIBase{

    public function getUsuario(){

        $query = "SELECT * FROM `usuario` where estatus='ACTIVO'";

        $motivo = new ModeloUsuario();

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
    public function getUsuarioCapturaPedido(){

        $query = "SELECT * FROM `usuario` where estatus='ACTIVO' and capturaPedido = 'SI'";

        $motivo = new ModeloUsuario();

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

$api = new APIusuario();
$api->run();