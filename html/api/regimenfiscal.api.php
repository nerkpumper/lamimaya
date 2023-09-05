<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.regimenfiscal.inc.php";


class APIRegimenFiscal extends APIBase{

    
    public function getall(){
        $rf = new ModeloRegimenFiscal();
                
        $query = "SELECT idRegimenFiscal id, codigo, descripcion
                FROM regimenfiscal 
                ";

        $lst = $rf->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("list", $lst);
    }

    public function save(){
        $rf = new ModeloRegimenFiscal();

        $idRegimenFiscal = $_POST["idRegimenFiscal"];
        $codigo = $_POST["codigo"];
        $descripcion = $_POST["descripcion"];

        $continuar = true;

        if ($rf->existeField("codigo", $codigo, $rf->getIdRegimenFiscal()))
        {
            $this->addResponse("error", true);
            $this->addResponse("msg", "El Código que desea almacenar ya existe. No puede haber duplicados");
            $continuar = false;
        }

        if ($idRegimenFiscal > 0)
        {
            $rf->setIdRegimenFiscal($idRegimenFiscal);
            $rf->setDateAndUser("update", $this->idUsuario);
        }
        else
        {
            $rf->setDateAndUser("insert", $this->idUsuario);
            $rf->setDateAndUser("update", $this->idUsuario);
        }

        $rf->setCodigo($codigo);
        $rf->setDescripcion($descripcion);

        if ($continuar)
        {
            $rf->Guardar();

            if ($rf->getError())
            {
                $this->addResponse("error", true);
                $this->addResponse("msg", "Error al insertar la información");
            }       

            
            $this->addResponse("error", false);
            $this->addResponse("idRegimenFiscal", $rf->getIdRegimenFiscal());
        }
           
    }
}

$api = new APIRegimenFiscal();
$api->run();