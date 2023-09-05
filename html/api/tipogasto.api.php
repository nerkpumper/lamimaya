<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.tipogasto.inc.php";


class APIConceptoGasto extends APIBase{

    
    public function getConceptos(){
        $cg = new ModeloTipoGasto();

        $query = "SELECT idTipoGasto, descripcion FROM tipogasto ORDER BY idTipoGasto";

        $lst = $cg->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("list", $lst);
    }

    public function save(){
        $cg = new ModeloTipoGasto();

        $idTipoGasto = $_POST["idTipoGasto"];
        $descripcion = $_POST["descripcion"];

        $continuar = true;

        if ($cg->existeField("descripcion", $descripcion, $cg->getIdTipoGasto()))
        {
            $this->addResponse("error", true);
            $this->addResponse("msg", "El Concepto Gasto que desea almacenar ya existe. No puede haber duplicados");
            $continuar = false;
        }

        $cg->setDescripcion($descripcion);
        $cg->setDateAndUser("insert", $this->idUsuario);
        $cg->setDateAndUser("update", $this->idUsuario);

        if ($continuar)
        {
            $cg->Guardar();

            if (!$cg->getError())
            {
                $this->addResponse("error", true);
                $this->addResponse("msg", "Error al insertar la información");
            }       

            
            $this->addResponse("error", false);
            $this->addResponse("idTipoGasto", $cg->getIdTipoGasto());
        }
           
    }
}

$api = new APIConceptoGasto();
$api->run();