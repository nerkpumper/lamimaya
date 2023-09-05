<?php 







if (isset($_SERVER['HTTP_HOST']))

    define("isCONSOLE",false);

else

    define("isCONSOLE",true);



    function myLog($msg = "")

{

	echo (isCONSOLE ? "\n" : "<br>").$msg;

}

//     define('FOLDER_INCLUDE', '../');

//     define('FOLDER_INCLUDE', '../../include/');

    //define('FOLDER_INCLUDE', '/home/nerkpump/includeappgalvamex/');

//     define('FOLDER_INCLUDE', '/home/galvamex/appgalvamex/include/');

  require_once 'configinclude.cron.php';  

    

    define("FOLDER_MODEL_BASE",FOLDER_INCLUDE . "model/base/");

    define("FOLDER_MODEL",FOLDER_INCLUDE . "model/extend/");

    define("LIB_CONEXION",FOLDER_INCLUDE . "lib/Conexion/Conexion.inc.php");

    define("LIB_CONEXION_MYSQL",FOLDER_INCLUDE . "lib/Conexion/ConexionMySQL.inc.php");

    define("NOTIFICATION_MANAGER",FOLDER_INCLUDE . "lib/app/class.notificationmanager.inc.php");

    

    define( 'API_ACCESS_KEY', 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA' );

    

    require_once LIB_CONEXION;   

    require_once FOLDER_INCLUDE . 'model/clsBasicCommon.inc.php';   

    require_once NOTIFICATION_MANAGER;

    

    require_once FOLDER_MODEL. "model.usuario.inc.php";

    

    require_once FOLDER_MODEL. "model.pushnotifica.inc.php";


    myLog();

myLog(date("Y-m-d H:i:s"). "    -              -- C O M I E N Z A ---------------------------------------------");



    $pn = new ModeloPushnotifica();

    

    $lst = $pn->getAll("idPushNotifica, idProvoca, idPara, tipo, tema, contenido, refint, refstr, concat(de.nombre,' ', de.apellidopaterno,' ', de.apellidomaterno) as gene,

                        para.tokendevice",

                        "inner join usuario as de on de.idUsuario = idProvoca

                         inner join usuario as para on para.idUsuario = idPara",

                        "enviado = 'NO'",

                        "idPushNotifica asc");

    

    foreach ($lst as $item)

    {

        $idPN = $item["idPushNotifica"];

        

        NotificationManager::onlySendNotification($item["tipo"], //tipo 

            $item["idPara"] , // para 

            $item["tema"],  //tema

            $item["contenido"], //contenido 

            $item["refint"], //refint 

            $item["refstr"], //refstr 

            $item["gene"], //genera

            $item["tokendevice"]); //token

        

       $pn->setIdPushNotifica($idPN);

       

       if ($pn->getIdPushNotifica() > 0 )

       {

           $pn->setEnviadoSI();

           $pn->Guardar();

       }

    }

    
    myLog(date("Y-m-d H:i:s"). "    -              -- F I N  ---------------------------------------------");

    myLog();


    

//     NotificationManager::onlySendNotification(NotificationManager::$NOTIFICACIONES_NOTIFICACION, 2 , "el tema aqui 6", "El cuerpo de este lado", 0, "", "Juan Urrutia Ramirez", "cZUHtgk-avk:APA91bEl-X9haekof8OTTs35Vv6Zm8NggVDlJCJ-k21f4yzDnrUVD05DSqV8cSimwS5_Z_HWVdO7FmPcxOOmMFPWRZencos9zBY6n38nSCsXYszrXawelG101uSlFgqlhYRMD-WNjOqi");