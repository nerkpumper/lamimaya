<?php 







if (isset($_SERVER['HTTP_HOST']))

    define("isCONSOLE",false);

else

    define("isCONSOLE",true);



//     define('FOLDER_INCLUDE', '../');

//     define('FOLDER_INCLUDE', '../../include/');

    //define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

  //   define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');

    require_once 'configinclude.cron.php';

    

    define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");

    define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

    define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

    define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");

    

    require_once LIB_CONEXION;   

    require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';



    



function myLog($msg = "")

{

    

    

    if (isCONSOLE)

    {

        

        

        $msg = str_replace("<i class='fa fa-check'></i>", "", $msg);

        $msg = str_replace("<div class='col-lg-6'><span class='text-success '>", "", $msg);

        $msg = str_replace("<div class='col-lg-7'><span class='text-success '>", "", $msg);

        

        $msg = str_replace("<div class='col-lg-6'><span class='text-danger '>", "", $msg);

        $msg = str_replace("<div class='col-lg-7'><span class='text-danger '>", "", $msg);

        

        $msg = str_replace("<div class='col-lg-1'><span class='text-info pull-right'><h4>", "", $msg);

        $msg = str_replace("<div class='col-lg-1'><span class='text-warning pull-right'><h4>", "", $msg);

        $msg = str_replace("<div class='col-lg-1'><span class='text-success pull-right", "", $msg);

        

        

        $msg = str_replace("<div class='col-lg-7'><span class=''><h4>", "", $msg);

        $msg = str_replace("<div class='col-lg-6'><span class=''><h4>", "", $msg);

        $msg = str_replace("</h4></span></div>", "", $msg);

        

        

        $msg = str_replace("<div class='col-lg-1'><span class=' pull-right'><h4>", "", $msg);

        

        $msg = str_replace("<h2>", "", $msg);

        $msg = str_replace("</h2>", "", $msg);

        

        $msg = str_replace("<br>", "", $msg);

        $msg = str_replace("<h4>", "", $msg);

        $msg = str_replace("</h4>", "", $msg);

        

        $msg = str_replace("<div class='row'>", "", $msg);

        $msg = str_replace("</div>", "", $msg);

        $msg = str_replace("'>", "", $msg);

    }

    

    

    

    

    

    echo (isCONSOLE ? "\n" : "").$msg;

}



if (isset($param1))

{

    myLog("Parametro recibido: " . $param1);

}

else

{

    $param1 = "elnerkpumper";

}



$error = false;



myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");



myLog("<h2>Apartados Fixed</h2>");

myLog("<br>");



require_once FOLDER_MODEL. "model.viewrollos.inc.php";

require_once FOLDER_MODEL. "model.rollo.inc.php";

require_once FOLDER_MODEL. "model.viewproductos.inc.php";

require_once FOLDER_MODEL. "model.producto.inc.php";

require_once FOLDER_MODEL. "model.inventariosucursal.inc.php";





$rollo = new ModeloViewrollos();



$lstRollos = $rollo->getAll("idRollo, codigo,material, calibre, pies, existencia, descauto, apartado, ifnull(getRolloApartado(idRollo),0) as apartadoRollo", "", "idRollo > 1 AND estado <> 'BAJA' 	", "idRollo" );



// myLog("<div class='row'>");

// myLog("<div class='col-lg-7'><span class=''><h4>");



// myLog("Rollo");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Existencia");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Apartado Sys");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Apartado Calc");



// myLog("</h4></span></div>");





// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");

// myLog("Check");







// myLog("</h4></span></div>");



// myLog("</div>");





foreach ($lstRollos as $r)

{

    $exis = $r["existencia"];

    $apartado = $r["apartado"];

    $apartadoFunc = $r["apartadoRollo"];

    

    $modificar = false;

    

//     myLog("<div class='row'>");

    

    

//     if ($apartado != $apartadoFunc)

//     {

//         myLog("<div class='col-lg-7'><span class='text-danger '><h4>");

        

//     }

//     else

//     {

//         myLog("<div class='col-lg-7'><span class='text-success '><h4>");

        

//     }

//     echo $r["idRollo"] . " - " . $r["descauto"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-info pull-right'><h4>");

    

//     echo $r["existencia"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-warning pull-right'><h4>");

    

//     echo $r["apartado"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

    

//     echo $r["apartadoRollo"];

    

//     myLog("</h4></span></div>");

    

    

    

    if ($apartado != $apartadoFunc)

    {

        $modificar = true;

//         myLog("<div class='col-lg-1'><span class='text-danger pull-right'><h4>");

//         myLog("<i class='fa fa-pencil'></i>");

    }

//     else

//     {

//         myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

//         myLog("<i class='fa fa-check'></i>");

//     }

    

    

//     myLog("</h4></span></div>");

    

//     myLog("</div>");

    

    if ($param1 == "elnerkpumper" && $modificar)

    {

        myLog("<br>Modificando");

        $rolloMod = new ModeloRollo();

        

        $rolloMod->setIdRollo($r["idRollo"]);

        

        if ($rolloMod->getIdRollo() > 1)

        {

            myLog("Cambiando el rollo -> " . $r["idRollo"]);

            

            $rolloMod->setApartado($apartadoFunc);

            

            $rolloMod->Guardar();

            

            if (!$rolloMod->getError())

            {

                myLog(" BIEN");

            }

            else

            {

                $error = false;

                myLog(" E R R O R: " . $rolloMod->getStrError());

            }

        }

        

        

        myLog("<br>");

    }

}







// ****************************************************************************

// ****************************************************************************

// ****************************************************************************

// ****************************************************************************

//    PRODUCTOS

// // ****************************************************************************

// ****************************************************************************

// ****************************************************************************

// ****************************************************************************



$producto = new ModeloViewproductos();



 $lstProductos = $producto->getAll("idProducto, codigo, existencia, descauto, apartado, apartadoReal, ifnull(getProductoApartado(idProducto),0) as apartadoSys, ifnull(getProductoApartadoReal(idProducto),0) as apartadoRealSys", "", "estado <> 'BAJA' and ((idUnidad = (4)) OR (idUnidad = 1 and idRollo = 1))", "descauto" );



// myLog("<hr>");

// myLog("<hr>");

// myLog("<hr>");



// myLog("<div class='row'>");

// myLog("<div class='col-lg-6'><span class=''><h4>");



// myLog("Producto");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Existencia");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Apartado Sys");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Apartado Calc");



// myLog("</h4></span></div>");



// //  r e a l e s



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("ApartadoReal Sys");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("ApartadoReal Calc");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");

// myLog("Check");







// myLog("</h4></span></div>");



// myLog("</div>");





foreach ($lstProductos as $r)

{

    $modificar = false;

    

    $exis = $r["existencia"];

    $apartado = $r["apartado"];

    $apartadoFunc = $r["apartadoSys"];

    $apartadoReal = $r["apartadoReal"];

    $apartadoRealFunc = $r["apartadoRealSys"];

    

    myLog("<div class='row'>");

    

    

    if ($apartado != $apartadoFunc  || $apartadoReal != $apartadoRealFunc)

    {

        $modificar = true;

//         myLog("<div class='col-lg-6'><span class='text-danger '><h4>");

        

    }

//     else

//     {

//         myLog("<div class='col-lg-6'><span class='text-success '><h4>");

        

//     }

//     echo $r["idProducto"] . " - " . $r["descauto"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-info pull-right'><h4>");

    

//     echo $r["existencia"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-warning pull-right'><h4>");

    

//     echo $r["apartado"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

    

//     echo $r["apartadoSys"];

    

//     myLog("</h4></span></div>");

    

//     //     R e a l e s

    

//     myLog("<div class='col-lg-1'><span class='text-warning pull-right'><h4>");

    

//     echo $r["apartadoReal"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

    

//     echo $r["apartadoRealSys"];

    

//     myLog("</h4></span></div>");

    

    

    

//     if ($apartado != $apartadoFunc  || $apartadoReal != $apartadoRealFunc)

//     {

//         myLog("<div class='col-lg-1'><span class='text-danger pull-right'><h4>");

//         myLog("<i class='fa fa-pencil'></i>");

//     }

//     else

//     {

//         myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

//         myLog("<i class='fa fa-check'></i>");

//     }

    

    

//     myLog("</h4></span></div>");

    

//     myLog("</div>");

    

    if ($param1 == "elnerkpumper" && $modificar)

    {

        myLog("<br>Modificando");

        $productoMod = new ModeloProducto();

        

        $productoMod->setIdProducto($r["idProducto"]);

        

        if ($productoMod->getIdProducto() > 0)

        {

            $apartadoFunc = $r["apartadoSys"];

            $apartadoReal = $r["apartadoReal"];

            $apartadoRealFunc = $r["apartadoRealSys"];

            myLog("Cambiando el producto -> " . $r["idProducto"] ) ;

            

            $productoMod->setApartado($apartadoFunc);

            $productoMod->setApartadoReal($apartadoRealFunc);

            

            

            $productoMod->Guardar();

            

            if (!$productoMod->getError())

            {

                myLog(" BIEN");

            }

            else

            {

                $error = false;

                myLog(" E R R O R: " . $productoMod->getStrError());

            }

        }

        

        

        myLog("<br>");

    }

}






// ****************************************************************************

// ****************************************************************************

// ****************************************************************************

// ****************************************************************************

//    P R O D U C T O S    B  Y     S   U   C   U   R   S   A   L

// // ****************************************************************************

// ****************************************************************************

// ****************************************************************************

// ****************************************************************************






$lstProductos = $producto->getAll("viewproductos.idProducto, viewproductos.descauto, inv.idInventarioSucursal, inv.idSucursal, inv.apartado,
                                    getProductoApartadoSucursal(viewproductos.idProducto, inv.idSucursal) apartadoSucursal", 
                                "inner join inventariosucursal inv on viewproductos.idproducto = inv.idproducto
                                inner join sucursal s on inv.idsucursal = s.idsucursal", 
                                "viewproductos.estado <> 'BAJA' and s.visible = 'SI' and ((viewproductos.idUnidad = (4)) OR (viewproductos.idUnidad = 1 and viewproductos.idRollo = 1))", "descauto" );


// echo $producto->getAllQUERY("viewproductos.idProducto, viewproductos.descauto, inv.idInventarioSucursal, inv.idSucursal, inv.apartado,
// getProductoApartadoSucursal(viewproductos.idProducto, inv.idSucursal) apartadoSucursal", 
// "inner join inventariosucursal inv on viewproductos.idproducto = inv.idproducto
// inner join sucursal s on inv.idsucursal = s.idsucursal", 
// "viewproductos.estado <> 'BAJA' and s.visible = 'SI' and ((viewproductos.idUnidad = (4)) OR (viewproductos.idUnidad = 1 and viewproductos.idRollo = 1))", "descauto" );


// myLog("<hr>");

// myLog("<hr>");

// myLog("<hr>");



// myLog("<div class='row'>");

// myLog("<div class='col-lg-6'><span class=''><h4>");



// myLog("Producto");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Existencia");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Apartado Sys");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("Apartado Calc");



// myLog("</h4></span></div>");



// //  r e a l e s



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("ApartadoReal Sys");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");



// myLog("ApartadoReal Calc");



// myLog("</h4></span></div>");



// myLog("<div class='col-lg-1'><span class=' pull-right'><h4>");

// myLog("Check");







// myLog("</h4></span></div>");



// myLog("</div>");



$idInventarioSucursal = 0;

foreach ($lstProductos as $r)

{

    $modificar = false;
    
    $idInventarioSucursal = $r["idInventarioSucursal"];

    $apartado = $r["apartado"];

    $apartadoReal = $r["apartadoSucursal"];

    myLog("<div class='row'>");

    

    

    if ($apartado != $apartadoReal)

    {

        $modificar = true;

//         myLog("<div class='col-lg-6'><span class='text-danger '><h4>");

        

    }

//     else

//     {

//         myLog("<div class='col-lg-6'><span class='text-success '><h4>");

        

//     }

//     echo $r["idProducto"] . " - " . $r["descauto"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-info pull-right'><h4>");

    

//     echo $r["existencia"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-warning pull-right'><h4>");

    

//     echo $r["apartado"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

    

//     echo $r["apartadoSys"];

    

//     myLog("</h4></span></div>");

    

//     //     R e a l e s

    

//     myLog("<div class='col-lg-1'><span class='text-warning pull-right'><h4>");

    

//     echo $r["apartadoReal"];

    

//     myLog("</h4></span></div>");

    

//     myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

    

//     echo $r["apartadoRealSys"];

    

//     myLog("</h4></span></div>");

    

    

    

//     if ($apartado != $apartadoFunc  || $apartadoReal != $apartadoRealFunc)

//     {

//         myLog("<div class='col-lg-1'><span class='text-danger pull-right'><h4>");

//         myLog("<i class='fa fa-pencil'></i>");

//     }

//     else

//     {

//         myLog("<div class='col-lg-1'><span class='text-success pull-right'><h4>");

//         myLog("<i class='fa fa-check'></i>");

//     }

    

    

//     myLog("</h4></span></div>");

    

//     myLog("</div>");

    

    if ($param1 == "elnerkpumper" && $modificar)

    {

        myLog("<br>Modificando");

        $invSucursal = new ModeloInventariosucursal();

        $invSucursal->setIdInventarioSucursal($idInventarioSucursal);

        if ($invSucursal->getIdInventarioSucursal() > 0)
        {
            
            myLog("Actualizando el inventario -> " . $idInventarioSucursal ) ;

            $invSucursal->setApartado($apartadoReal);
            

            $invSucursal->Guardar();

            

            if (!$invSucursal->getError())

            {

                myLog(" BIEN");

            }

            else

            {

                $error = false;

                myLog(" E R R O R: " . $invSucursal->getStrError());

            }

        }

        

        

        myLog("<br>");

    }

}
