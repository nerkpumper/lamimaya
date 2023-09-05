<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.cotizacion.inc.php";

class APICotizacion extends APIBase{

    public function getCotizacion(){
      $id_Usuario_Capturado = $_GET["idUsuarioCaptura"];

        //$id_Usuario_Capturado = 18;
        

        $query = "SELECT cotizacion.idCotizacion, concat(cliente.nombre,' ',cliente.apellidos)as cliente , cotizacion.total, cotizacion.fecha_capturado, cotizacion.estado FROM `cotizacion`
         INNER JOIN cliente on cotizacion.idCliente = cliente.idCliente
         where cotizacion.idCotizacion > 17052 and  cotizacion.fecha_capturado > '2022-06-01'and cotizacion.estado='CAPTURADO'and cotizacion.idPedido=0 and cotizacion.id_Usuario_Capturado =".$id_Usuario_Capturado;

        $cotizacion = new ModeloCotizacion();

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


    public function updateCotizacionEstado(){
        $cotizacion = new ModeloCotizacion();
        $idCotizacion = $_GET["idCotizacion"];
 

        $cotizacion->setIdCotizacion($idCotizacion);
        

        if ($cotizacion->getIdCotizacion() > 0 ){
           

            $cotizacion->setEstado('CANCELADO');
            $cotizacion->Guardar();
		
            if (!$cotizacion->getError())
            {
                $this->addResponse("error", false); 
            }
            else{
                $this->throwError("Parece que la cotizacion que ha indicado no existe.");
            }
        }
    }
}

$api = new APICotizacion();
$api->run();