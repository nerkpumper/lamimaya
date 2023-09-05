<?php
$titlePage = "Cr&eacute;dito a Clientes";
$breadCum = "Cliente/Cr&eacute;dito a Cliente";
$_lugar = LUGAR_ADMINISTRACION_CREDITOCLIENTES;


// $ar = array();

// $ar[] = array("tipo" => "eltipo1", "value" => "elvalue1");
// $ar[] = array("tipo" => "eltipo2", "value" => "elvalue2");
// $ar[] = array("tipo" => "eltipo3", "value" => "elvalue3");
// $ar[] = array("tipo" => "eltipo4", "value" => "elvalue4");
// $ar[] = array("tipo" => "eltipo5", "value" => "elvalue5");
// $ar[] = array("tipo" => "eltipo6", "value" => "elvalue6");
// $ar[] = array("tipo" => "eltipo7", "value" => "elvalue7");
// $ar[] = array("tipo" => "eltipo8", "value" => "elvalue8");
// $ar[] = array("tipo" => "eltipo9", "value" => "elvalue9");


// // echo "<pre>";
// // print_r($ar);
// // echo "</pre>";

// foreach($ar as $item)
// {
//     echo "<br>Tipo: ". $item["tipo"] . " Value: ". $item["value"];
// }









// return;


// require_once FOLDER_MODEL. "model.configuracion.inc.php";
// require_once FOLDER_MODEL. "model.pedido.inc.php";




// $c = new ModeloConfiguracion();

// echo "<br><br>". $c->lastCheckUpdatePrecios();

// echo "<br><br>". substr($c->lastCheckUpdatePrecios(), 0, 16);


// echo "<br><br> ha cambiado fechas = " . ($c->haCambiadoPreciosEnProductosORollos() ? "si" : "no");

// echo "<br><br>";

// echo "<br>last: " . $c->getLastCheckUpdatePrecios();
// echo "<br>rolloprodmod: " . $c->getRolloprodlastupdate();


// $c->updateLastCheckUpdatePrecios();


// echo "<br><br>".$c->lastCheckUpdatePrecios();


// echo "<br><br>".$c->lastIdPedidoChecked();



// return;

// require_once FOLDER_MODEL. "model.viewproductos.inc.php";

// $viewProducto = new ModeloViewproductos();

// $viewProducto->getViewSucursal(448, 0);

// echo "<br><br>";
// $viewProducto->dumpObj();
// echo "<br><br>";

// $viewProducto->getViewSucursal(448, 1);

// echo "<br><br>";
// $viewProducto->dumpObj();
// echo "<br><br>";


// $viewProducto->getViewSucursal(448, 2);

// echo "<br><br>";
// $viewProducto->dumpObj();
// echo "<br><br>";

// return;


PedidoTrackingManager::init();

PedidoTrackingManager::add(1, PedidoTrackingManager::$INFO, "esto es un msg1");
PedidoTrackingManager::add(1, PedidoTrackingManager::$WARNING, "esto es un msg2");
PedidoTrackingManager::add(2, PedidoTrackingManager::$INFO, "esto es un msg3");
PedidoTrackingManager::add(2, PedidoTrackingManager::$WARNING, "esto es un msg4");
PedidoTrackingManager::add(3, PedidoTrackingManager::$INFO, "esto es un msg5");
PedidoTrackingManager::add(3, PedidoTrackingManager::$SUCCESS, "esto es un msg6");
PedidoTrackingManager::add(1, PedidoTrackingManager::$ERROR, "esto es un msg7");
PedidoTrackingManager::add(2, PedidoTrackingManager::$WARNING, "esto es un msg8");
PedidoTrackingManager::add(3, PedidoTrackingManager::$ERROR, "esto es un msg9");
PedidoTrackingManager::add(3, PedidoTrackingManager::$WARNING, "esto es un msg10");
PedidoTrackingManager::add(2, PedidoTrackingManager::$SUCCESS, "esto es un msg11");

PedidoTrackingManager::flush();

return;

require_once FOLDER_MODEL. "model.cotizacion.inc.php";
require_once FOLDER_MODEL. "model.pedido.inc.php";

$idPedido = 1041;

$pedido = new ModeloPedido();

// $pedido->__isDebugging = true;

$result = $pedido->verificarSiPedidoPuedeSurtirse($idPedido);

echo "<pre>";
print_r($result);
echo "</pre>";

return;
// $eee =  '{"c":"06","t":null,"n":null,"D":""}';

// $obj = json_decode($eee);

// echo "<pre>";
// print_r($eee);
// echo "</pre>";


// echo "<pre>";
// print_r($obj, true);
// echo "</pre>";

// echo "<pre>";
// echo $obj->c;
// echo "</pre>";


     

$url = "https://aiidia.com/safetycash/html/app.php";

$fields = array(
    "a"      => "R", //Accion R corresponde a una recarga (siempre mandar)    
    "n"      => "4777998180", //n es el numero celular que recibe la recarga
    "s"      => "133", //s es el IdServicio -> Columna idServicio
    "p"      => "582", //p es el IdProducto -> Columna idProducto
    "o"      => "TEST_CAJON" //o es el origen de donde se genera la peticion //Se puede usar ese dispositivo
);

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

//execute post
// $result = curl_exec($ch);
echo $result;

echo "<pre>";
print_r($result);
echo "</pre>";

echo "<pre>";
var_dump($result);
echo "</pre>";

$objResult = json_decode($result, true);

echo "<pre>";
print_r($objResult);
echo "</pre>";

echo "<pre>";
var_dump($objResult);
echo "</pre>";

echo "<br><br>";
echo $objResult["c"];



return;




// $pedido = new ModeloPedido();

// 		$pedido->setIdPedido(1047);
        
//         echo "Pedido = " . $pedido->getIdPedido() ;

//                 $pedido->NotificaAutorizacionAutomaticaPedido();
                
// NotificationManager::SendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 
// 2, 
// "Pedido 12235". 
// " AUTORIZADO Automático", 
// "El pedido 1254 ha sido Autorizado de manera automática para su producción.");



?>