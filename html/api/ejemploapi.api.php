<?php

require_once "baseapi.inc.php";

class APIEjemplo extends APIBase{

    public function metodo1(){
        
        $this->addResponse("error", false);  
        $this->addResponse("algunavariable", "algun valor");     
        $this->addResponse("retorno1", "este es un valor asignado a la variable retorno 1 desde la api");
    }

    public function metodo2(){

        $dato = $_POST["dato"];
        
        $this->addResponse("error", false);
        $this->addResponse("retorno2", "Ejemplo Post, recivi en llamada POST el dato: ".$dato);        
    }

    public function regresaarreglo(){

        $arreglo = array();

        $arreglo[] = array(
            "dato1" => "1",
            "dato2" => "uno"
        );

        $arreglo[] = array(
            "dato1" => "2",
            "dato2" => "dos"
        );

        $arreglo[] = array(
            "dato1" => "3",
            "dato2" => "tres"
        );

        $arreglo[] = array(
            "dato1" => "4",
            "dato2" => "cuatro"
        );

        $arreglo[] = array(
            "dato1" => "5",
            "dato2" => "cinco"
        );

                
        $this->addResponse("error", false);
        $this->addResponse("elarreglo", ($arreglo));        
    }
}

$api = new APIEjemplo();
$api->checkSecurity = true;
$api->run();