<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.cotizacionrechazada.inc.php";

class APImotivorechazo extends APIBase{

    public function getCotizacionRechazada(){

        $query = "SELECT * FROM `cotizacionrechazada`";

        $cotizacion = new ModeloCotizacionRechazada();

        $lst = $cotizacion->getDataSet($query);
        
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
    public function guardarMotivoRechazoCotizacion(){
        $cotizacionRechazada = new ModeloCotizacionRechazada();
        $idCotizacion = $_GET["idCotizacion"];
        $fecha_rechazo = date("Y-m-d H:i:s");
        $idMotivoRechazo = $_GET["idMotivoRechazo"];
        //$idCotizacion = 19202;
        //$fecha_rechazo='2022-08-11 17:39:00';
        //$idMotivoRechazo = 3;

        if ($idCotizacion> 0 ){
           
            $cotizacionRechazada->setIdCotizacion($idCotizacion);
            $cotizacionRechazada->setFecha_rechazo($fecha_rechazo);
            $cotizacionRechazada->setIdMotivoRechazo($idMotivoRechazo);
            $cotizacionRechazada->Guardar();
		
            if (!$cotizacionRechazada->getError())
            {
                $this->addResponse("error", false); 
            }
            else{
                $this->throwError("Error al Insertar registro.");
            }
        }
    }
}

$api = new APImotivorechazo();
$api->run();