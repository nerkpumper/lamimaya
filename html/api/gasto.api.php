<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.gasto.inc.php";


class APIGasto extends APIBase{    

    public function save(){
        $g = new ModeloGasto();

        $idTipoGasto = $_POST["idTipoGasto"];
        $idSucursal = $_POST["idSucursal"];
        $monto = $_POST["monto"];
        $detalle = $_POST["detalle"];
        $idUsuario = $_POST["idUsuario"];

        $g->setIdTipoGasto($idTipoGasto);
        $g->setIdSucursal($idSucursal);
        $g->setMonto($monto);
        $g->setDetalle($detalle);
        $g->setDateAndUser("insert", $idUsuario);
        $g->setDateAndUser("update", $idUsuario);

        
        $g->Guardar();

        if ($g->getError())
        {
            $this->throwError($g->getStrError());
            
        }       

        
        $this->addResponse("error", false);
        $this->addResponse("idGasto", $g->getIdGasto());           
    }

    public function getGastosPage(){
        $idSucursal = $_GET["idSucursal"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];

        $query = "
            SELECT COUNT(*) total
            FROM gasto
            INNER JOIN sucursal ON gasto.idSucursal = sucursal.idSucursal
            INNER JOIN tipogasto ON gasto.idTipoGasto = tipogasto.idTipoGasto
            INNER JOIN usuario ON gasto.id_usuario_insert = usuario.idUsuario
            ORDER BY gasto.fecha_insert DESC
        ";

        $g = new ModeloGasto();

        $rs = $g->getDataSet($query)[0];

        $totalReg = $rs["total"];

        $query = "
            SELECT sucursal.nombre sucursal, tipogasto.descripcion concepto, gasto.monto, gasto.detalle,
                    CONCAT(usuario.nombre, ' ', usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) insertedBy,
                    gasto.fecha_insert
            FROM gasto
            INNER JOIN sucursal ON gasto.idSucursal = sucursal.idSucursal
            INNER JOIN tipogasto ON gasto.idTipoGasto = tipogasto.idTipoGasto
            INNER JOIN usuario ON gasto.id_usuario_insert = usuario.idUsuario
            ORDER BY gasto.fecha_insert DESC
              LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $list = $g->getDataSet($query);
                
        $this->addResponse("error", false);  
        
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $list);          
    }
}

$api = new APIGasto();
$api->run();