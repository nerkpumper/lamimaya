<?php

require_once FOLDER_MODEL. "model.pedido.inc.php";
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







$anio = 2019;
$pedido1 = new ModeloPedido();

        $lstDatosPedido = $pedido1->getAll(
        "date_format(pedido.fecha_capturado, '%m')as mes,SUM(otrosCargos) AS otrosCargos ,SUM(descuento) as descuento,SUM(total)as totalpedidos",
        "",
        "date_format(pedido.fecha_capturado, '%Y') = ".$anio." and estado <> 'CANCELADO'",
        "",
        "mes");
        foreach($lstDatosPedido as $row){
        $lst1[$row["mes"]]=$row;
        }
        // echo "<pre>";
        // print_r($lst1);
        // echo "</pre>";
           
            
        $lstDetallePedido = $pedido1->getAll("date_format(pedido.fecha_capturado, '%m') as mes,
        sum(if(pedidodetalle.idRolloBase<>1 AND pedidodetalle.idProducto <>9 AND pedidodetalle.idProducto <>10,pedidodetalle.partida*pedidodetalle.precioUnitario*pedidodetalle.cantidad,0))as ventaDeRollo,
        sum(if(pedidodetalle.idRolloBase=1,pedidodetalle.partida*pedidodetalle.precioUnitario*pedidodetalle.cantidad,0))as ventaStock,
        sum(if(pedidodetalle.idProducto= 9,pedidodetalle.partida*pedidodetalle.precioUnitario,0))as ventaMoldura,
        sum(if(pedidodetalle.idProducto= 10,pedidodetalle.partida*pedidodetalle.precioUnitario,0))as ventaMaquila
        ",
        "INNER JOIN pedidodetalle ON pedido.idPedido = pedidodetalle.IdPedido  ",
        "date_format(pedido.fecha_capturado, '%Y') = ".$anio."
        and pedido.estado <> 'CANCELADO'",
        "",
        "mes");    
     
        foreach($lstDetallePedido as $row){
        $lst2[$row["mes"]]=$row;
        }
        
        for($i=1;$i<count($lst1)+1;$i++){
        $x=0;
         if($i<10){
        
        $x=$x.$i;
         }else{
         $x=$i;        
         }
         $lst2[$x]["otrosCargos"]=$lst1[$x]["otrosCargos"];
         $lst2[$x]["descuento"]=$lst1[$x]["descuento"];
         $lst2[$x]["totalpedidos"]=$lst1[$x]["totalpedidos"];
         $lst2[$x]["totaldetalle"]=$lst2[$x]["ventaDeRollo"]+$lst2[$x]["ventaStock"]+$lst2[$x]["ventaMoldura"]+$lst2[$x]["ventaMaquila"]+$lst2[$x]["otrosCargos"]-$lst2[$x]["descuento"];
         $lst2[$x]["dif"]=$lst2[$x]["totalpedidos"]-$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeRollo"]=$lst2[$x]["ventaDeRollo"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeStock"]=$lst2[$x]["ventaStock"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeMoldura"]=$lst2[$x]["ventaMoldura"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeMaquila"]=$lst2[$x]["ventaMaquila"]/$lst2[$x]["totaldetalle"];
         $lst2[$x]["porcentajeOtrosCargos"]=$lst2[$x]["otrosCargos"]/$lst2[$x]["totaldetalle"];
         //$lst2[$x]["porcentajeTotal"]=$lst2[$x]["porcentaje1"]+$lst2[$x]["porcentaje2"]+$lst2[$x]["porcentaje3"]+$lst2[$x]["porcentaje4"]+$lst2[$x]["porcentaje5"];
         $lst2[$x]["agregarRollo"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeRollo"];
         $lst2[$x]["agregarStock"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeStock"];
         $lst2[$x]["agregarMoldura"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeMoldura"];
         $lst2[$x]["agregarMaquila"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeMaquila"];
         $lst2[$x]["agregarOtrosCargos"]=$lst2[$x]["dif"]*$lst2[$x]["porcentajeOtrosCargos"];
         $lst2[$x]["TotalAgregar"]=$lst2[$x]["agregarStock"]+$lst2[$x]["agregarRollo"]+$lst2[$x]["agregarMoldura"]+$lst2[$x]["agregarMaquila"]+$lst2[$x]["agregarOtrosCargos"];
         $lst2[$x]["ventaDeRollonuevo"]=$lst2[$x]["ventaDeRollo"]+$lst2[$x]["agregarRollo"];
         $lst2[$x]["ventaStocknuevo"]=$lst2[$x]["ventaStock"]+$lst2[$x]["agregarStock"];
         $lst2[$x]["ventaMolduranuevo"] = $lst2[$x]["ventaMoldura"]+$lst2[$x]["agregarMoldura"];
         $lst2[$x]["ventaMaquilanuveo"] = $lst2[$x]["ventaMaquila"]+$lst2[$x]["porcentajeMaquila"];
         $lst2[$x]["otrosCargosnuevo"]= $lst2[$x]["otrosCargos"]+$lst2[$x]["agregarOtrosCargos"];
         $lst2[$x]["totalNuevo"] =$lst2[$x]["ventaStocknuevo"]+ $lst2[$x]["ventaDeRollonuevo"]+$lst2[$x]["ventaMolduranuevo"]+$lst2[$x]["ventaMaquilanuveo"]+$lst2[$x]["otrosCargosnuevo"]-$lst2[$x]["descuento"];

        }
        echo "<pre>";
        print_r($lst2);
        echo "</pre>";
  
        

        
        