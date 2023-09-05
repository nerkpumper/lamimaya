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



function cargarDatosRollos()

{

    $r = new xajaxResponse();

//     $r->starDebug();

    $pedido = new ModeloPedido();

    

    $query = "select idrollo, material, calibre, pies, origen,codigo, descauto as descripcion, CUSinIva, ifnull(existencia, 0) existencia, ifnull(cast((CUSinIva * existencia) as decimal(15,2)),0) as costoinventario,  

                    totalRollos, totalInventario, rollosEnRP, rollosEnRPTerminados, (rollosEnRP-rollosEnRPTerminados) rollosEnRPNoTerminados

                    from (

                    select idrollo, cast((pesocu * 1.16) as decimal(15,2)) CUSinIva, getExistenciasRollo(idrollo) as existencia, material, calibre, pies, origen, descauto,codigo,

                    getNoRollosTotal(idrollo) as totalRollos,

                    getNoRollosEnAlmacen(idrollo) as totalInventario,

                    getNoRollosEnRegistroProduccion(idrollo) as rollosEnRP,

                    getNoRollosEnRegistroProduccionTerminados(idrollo) as rollosEnRPTerminados

                     from viewrollos 

                     where estado <> 'BAJA') as datos

                    where idrollo > 1 

                    order by material, origen desc, calibre, pies";

   

    $lst = $pedido->getDataSet($query);

    

//     echo $query;

    

    $pushes = "";

    $totalCosto = 0;

    $totalExistencia = 0;

    foreach ($lst as $row)

    {

        $totalCosto += $row["costoinventario"];

        $totalExistencia += $row["existencia"];

        

        $pushes .= "



                    app.rollos.push (

				{

                    id: ".$row["idRollo"].",
                    
                    codigo: '".$row["codigo"]."',

					desc: '".$row["descripcion"]."',

					cu: ".$row["CUSinIva"].",

					existencia: ".$row["existencia"].",

					costoInventario: ".$row["costoinventario"].",

					rollosTotal: ".$row["totalRollos"].",

                    rollosInventario: ".$row["totalInventario"].",

					rollosRP: ".$row["rollosEnRP"].",

					rollosTerminados: ".$row["rollosEnRPTerminados"].",

					rollosPorTerminar: ".$row["rollosEnRPNoTerminados"]."

				});



                ";

    }

    

    $r->script(" app.rollos.splice(0, app.rollos.length); " . $pushes . " app.totalCostoInventario = ".$totalCosto." ; app.totalExistencia = ".$totalExistencia." ;");

//     $r->endDegug();

    return $r;

}

$xajax->registerFunction("cargarDatosRollos");





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





