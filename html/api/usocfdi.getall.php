<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.usocfdi.inc.php";

$cfdi = new ModeloUsocfdi();
$query = "SELECT idUsoCfdi, clave, descripcion FROM usocfdi";
$lst = $cfdi->getDataSet($query);

$result = array();

foreach($lst as $r)
{
    $result[] = array("idUsoCfdi" => $r["idUsoCfdi"],
                    "clave" => $r["clave"],
                    "descripcion" => $r["descripcion"]);
}

$respuesta = array("error" => false, "list" => $result);

header('Content-type: application/json');
echo json_encode($respuesta);