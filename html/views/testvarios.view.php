<?php


// declara un arreglo 

$miarreglo = array();

//obten tu consulta, y recorrela llenando el arreglo, con una llave unica para luego obtenerla sin problema

$miarreglo["llave1"] =  array ( 
        "llave" => "llave1",
        "campo1" => "dato 1",
        "campo2" => "dato 2",
        "campo3" => "dato 3",
        "datoenotratabla" => ""    
);

$miarreglo["llave2"] = array (
        "llave" => "llave2",
        "campo1" => "dato 1",
        "campo2" => "dato 2",
        "campo3" => "dato 3",
        "datoenotratabla" => ""
    
);

$miarreglo["llave3"] = array (
        "llave" => "llave3",
        "campo1" => "dato 1",
        "campo2" => "dato 2",
        "campo3" => "dato 3",
        "datoenotratabla" => ""
    
);

$miarreglo["llave4"] = array (
        "llave" => "llave4",
        "campo1" => "dato 1",
        "campo2" => "dato 2",
        "campo3" => "dato 3",
        "datoenotratabla" => ""
    
);

echo "<pre>";
print_r($miarreglo);
echo "</pre>";

echo "<br><br> Para obtener un item del arreglo en base a una llave variable[\"tullave\"] <br><br>";

$unitem = $miarreglo["llave3"];

echo "<pre>";
print_r($unitem);
echo "</pre>";

echo "<br><br>si modificas el item solito, no modifica el arreglo esto solo es para que veas como se referencia, para complementar datos debes acceder al arreglo mismo <br><br>";

$miarreglo["llave3"]["datoenotratabla"] = "aqui el dato obtenido despues"; //recuerda que si quieres modificar el arreglo, la variable de arriba no sirve,
//pues es una copia, debes hacerlo directo en el arreglo

echo "<pre>";
print_r($miarreglo);
echo "</pre>";


return;

$mes = date('n');
$anio = date('Y'); 
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


$mes -= 1;

if ($mes == 0)
{
    $mes = 12;
    $anio--;
}

echo $mes;
echo "<br>";
echo $anio;
echo "<br>";
echo $meses[$mes-1];
