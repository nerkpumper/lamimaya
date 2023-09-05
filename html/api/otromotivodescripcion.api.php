<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.otromotivodescripcion.inc.php";

class APIotromotivodescripcion extends APIBase{


    
    public function guardarOtromotivoDescripcion(){
        $otroMotivoRechazo = new ModeloOtroMotivoDescripcion();
        $idMotivoRechazo = $_GET["idCotizacion"];
        $descricion = $_GET["motivoRechazo"];
        //$idMotivoRechazo = 11;
        //$descricion='esta cotizacion se rechazo porque no me quieren hacer un descuento';
        //$idMotivoRechazo = 3;

        if ($idMotivoRechazo> 0 ){
           
            $otroMotivoRechazo->setIdCotizacionRechazada($idMotivoRechazo);
            $otroMotivoRechazo->setDescripcion($descricion);
            $otroMotivoRechazo->Guardar();
		
            if (!$otroMotivoRechazo->getError())
            {
                $this->addResponse("error", false); 
            }
            else{
                $this->throwError("Error al Insertar registro.");
            }
        }
    }
}

$api = new APIotromotivodescripcion();
$api->run();