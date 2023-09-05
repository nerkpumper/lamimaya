<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.aportacionesmendez.inc.php";


class APIaportacionesmendez extends APIBase{

  

    public function getAll(){
        $s = new ModeloAportacionesMendez();

        $query = "SELECT aportacionesmendez.monto, aportacionesmendez.fecha_capturado, aportacionesmendez.referencia, concat(usuario.nombre,' ', usuario.apellidoPaterno )as usuario FROM aportacionesmendez inner join usuario on aportacionesmendez.idUsuario = usuario.idUsuario ORDER BY `aportacionesmendez`.`idAportacionMendez` DESC";

        $lst = $s->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("list", $lst);
    }
    
    public function save(){
        $a= new ModeloAportacionesMendez();

     
         $monto = $_POST["monto"];
         $fecha_capturado = date("Y-m-d H:i:s");
         $referencia = $_POST["referencia"];
         $idUsuario = $_POST["idUsuario"];
      
        $a->setMonto($monto);
        $a->setFecha_capturado($fecha_capturado);
        $a->setreferencia($referencia);
        $a->setidUsuario($idUsuario);
        
        $a->Guardar();

        if ($a->getError())
        {
            $this->throwError($a->getStrError());
            
        }       

        $msg ='Movimiento guardado correctamente';
        $this->addResponse("error", false);
        $this->addResponse("idAportacionMendez", $a->getIdAportacionMendez());
        $this->addResponse("msg", $msg);            
    }
}

$api = new APIaportacionesmendez();
$api->run();