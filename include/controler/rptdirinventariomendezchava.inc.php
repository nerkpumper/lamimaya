<?php



// ----------------------------------------------------------------------------------------------------------------------#

// -------------------------------------------------------Includes-------------------------------------------------------#

// ----------------------------------------------------------------------------------------------------------------------#



require_once FOLDER_MODEL. "model.pedido.inc.php";

require_once FOLDER_MODEL. "model.viewrollos.inc.php";





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
    
//     $r->starDebug();
    
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
    
    $query = "select getInventarioInicialMendez() inventarioinicialmendez, 
                     getInventarioMendezHasta('".$desde."') inventarioRollosHastaInicio,
                     getTotalPedidosMendezHasta('".$desde."') pedidosHastaInicio,
                     getInventarioMendezEntre('".$desde."', '".$hasta."') inventarioRollosFechas,
                     getTotalPedidosMendezEntre('".$desde."','".$hasta."') pedidosFechas                     
";

	$r->mostrarAviso($query);
    
    $ds = $pedido->getDataSet($query);
    
//     var_dump($ds);
    
    $r->script("
                
                app.inventarioInicialMendez = ".$ds[0]["inventarioinicialmendez"].";
		        app.inventarioRollosHastaInicio = ".$ds[0]["inventarioRollosHastaInicio"].";
		        app.pedidosHastaInicio = ".$ds[0]["pedidosHastaInicio"].";
		        app.inventarioRollosFechas = ".$ds[0]["inventarioRollosFechas"].";
		        app.pedidosFechas = ".$ds[0]["pedidosFechas"].";
            

            ");
    
//     $r->endDegug();
    return $r;
}
$xajax->registerFunction("obtenerDatos");








$xajax->processRequest();



$strTablaListado2 = "";



$rollo = new ModeloViewrollos();



$rollo->__fillable=array("codigo","calibre", "pies", "descauto", "existencia");

$rollo->__fillableHeader=array("Codigo", "Calibre", "Pies", "Descripcion", "Existencia KG");

$lst = $rollo->getAll("codigo,material, calibre, pies, descauto, FORMAT(existencia,2) as existencia", "", "idRollo > 1 AND estado <> 'BAJA' 	" );





//$rollo->addExtraButton("rolloinspdf", "Inspección PDF", "fa-file-pdf-o", "btn-primary", "target='_blank'");



//var_dump($rollo->__moreButtons);



$strTablaListado2 = $rollo->getTableHTML($lst, "tblListado2", false, false,"Rollo");







#----------------------------------------------------------------------------------------------------------------------#

#---------------------------------------------Procesamiento de formulario----------------------------------------------#

#----------------------------------------------------------------------------------------------------------------------#





#----------------------------------------------------------------------------------------------------------------------#

#---------------------------------------------Inicializacion de variables----------------------------------------------#

#----------------------------------------------------------------------------------------------------------------------#





#----------------------------------------------------------------------------------------------------------------------#

#-------------------------------------------------Salida de Javascript-------------------------------------------------#

#----------------------------------------------------------------------------------------------------------------------#





