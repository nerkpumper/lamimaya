<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.usuariovistasmovil.inc.php";

class APImenumovil extends APIBase{
   
public function getMenuMovil(){
        $mv = new ModeloUsuariovistasmovil();
   
        $query = "SELECT vistasmovil.nombre, usuario.username, vistasmovil.icono FROM `usuariovistasmovil` INNER JOIN usuario on usuario.idUsuario = usuariovistasmovil.idUsuario INNER JOIN vistasmovil on vistasmovil.idVistasMovil = usuariovistasmovil.idVistaMovil   where usuario.username = 'Zeus'";

        $lst = $mv->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("lst", $lst);  
    }
}    
$api = new APImenumovil();
$api->run();