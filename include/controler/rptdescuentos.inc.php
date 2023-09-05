<?php

// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Includes-------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#

require_once FOLDER_MODEL. "model.pedido.inc.php";


// ----------------------------------------------------------------------------------------------------------------------#
// -------------------------------------------------------Funciones------------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#


// ----------------------------------------------------------------------------------------------------------------------#
// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
// ----------------------------------------------------------------------------------------------------------------------#
$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
//$xajax->de decodeUTF8InputOn();

//  	ob_start();
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);


function obtenerDatos($filtro)
{
    $r = new xajaxResponse();
    
    //$r->starDebug();
    
    $pedido = new ModeloPedido();
    
    $desde = $filtro["fechaInicio"];
    $hasta = $filtro["fechaFin"];
    
    if ($desde != "" && $hasta != "")
    {
        $desde = substr($desde, 6, 10) . "-" . substr($desde, 3, 2) . "-" . substr($desde, 0, 2);
        $hasta = substr($hasta, 6, 10) . "-" . substr($hasta, 3, 2) . "-" . substr($hasta, 0, 2);    
    }
    else
    {
        $r->saError("Fechas no validas - fi: ".$desde." ff:" . $hasta);
    }
    
    $query = "select pedido.idPedido, cliente.nombre, pedido.fecha_capturado,
    cliente.apellidos, pedido.descuento, pedido.total
    FROM `pedido` 
    INNER JOIN cliente ON pedido.idCliente = cliente.idCliente 
    WHERE pedido.fecha_capturado BETWEEN '".$desde."' AND '".$hasta."'
    AND pedido.descuento <> 0
    ; 
          
                                     
         ";   
    
         $datosPedidos = $pedido->getDataSet($query);
   
       
    $pushes = "";
    $totalPedidos=0;
    foreach ($datosPedidos as $row)
		{
            $totalPedidos= $row["total"]+$totalPedidos;
			$pushes .= "
					
						app.datos.push({
                            idPedido: ".$row["idPedido"].",
                            fechacapturado: '".$row["fecha_capturado"]."',
							
                            nombre: '".$row["nombre"]."', 
                            apellidos: '".$row["apellidos"]."', 
							descuento: '".$row["descuento"]."', 
							
							total: '".$row["total"]."'
                        });
                        
					
					";
		}
		//$r->mostrarAviso("hola"); return $r;
		$r->script("
					app.datos.splice(0, app.datos.length);
							
				" . $pushes);
             
		
    
    // $r->script("
                
    //             app.idPedido = ".$ds[0]["idPedido"].";
    //             app.descuento = ".$ds[0]["descuento"].";
    //             app.total = ".$ds[0]["total"].";

    //             setTimeout(function(){ mdlExitWait(); }, 200);

    //         ");
    
    //$r->endDegug();
    return $r;
}
$xajax->registerFunction("obtenerDatos");

    



$xajax->processRequest();

#----------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------Procesamiento de formulario----------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#


#----------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------Inicializacion de variables----------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#


#----------------------------------------------------------------------------------------------------------------------#
#-------------------------------------------------Salida de Javascript-------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#


