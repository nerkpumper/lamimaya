<?php

// NotificationManager::saludar();

// NotificationManager::testSendNotification(NotificationManager::$NOTIFICACIONES_NOTIFICACION, 2 , "Notificacion", "Esto es una notificacion. La Notificaci�n es para recibir mensajitos, en los que puede poner muchisimas cosas, como por ejemplo este texto grande, que espero se vea bien, sino para hacer pruebas entonces y acomodarlas. Buno pues.");
// NotificationManager::testSendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 2 , "Pedidos", "a e i o u � � � � �");

// NotificationManager::testSendNotification(NotificationManager::$NOTIFICACIONES_PEDIDO, 2 , "Pedidos",  "a e i o u � � � � �");
// NotificationManager::testSendNotification(NotificationManager::$NOTIFICACIONES_PRODUCTO, 2 , "Producto", "Esto es algo relativo a los productos");

// public static $NOTIFICACIONES_NOTIFICACION = 1;
// public static $NOTIFICACIONES_PEDIDO = 2;
// public static $NOTIFICACIONES_MSG = 3;
// public static $NOTIFICACIONES_PRODUCTO = 4;
// public static $NOTIFICACIONES_PETICION = 5;

NotificationManager::WS_PedidoNuevo(2);

// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_NOTIFICACION, 2, "Notificacion", "Notificaciones Notificacion");

// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PEDIDO, 2, "Pedido", "Notificaciones Pedido");
// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_MSG, 2, "Msg", "Notificaciones Msg");
// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PRODUCTO, 2, "Producto", "Notificaciones Producto");
// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_PETICION, 2, "Peticion", "Notificaciones Petici�n");
// NotificationManager::sendNotificationBySystem(NotificationManager::$NOTIFICACIONES_FACTURA, 2, "Factura", "Notificaciones Factura");

// NotificationManager::testSendNotification(17, "Prueba 123", "Prueba desde NotificationManager");


return;


#API access key from Google API's Console
// define( 'API_ACCESS_KEY', 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA' );

// $registrationIds = array(
// "cZUHtgk-avk:APA91bEl-X9haekof8OTTs35Vv6Zm8NggVDlJCJ-k21f4yzDnrUVD05DSqV8cSimwS5_Z_HWVdO7FmPcxOOmMFPWRZencos9zBY6n38nSCsXYszrXawelG101uSlFgqlhYRMD-WNjOqi");

$registrationIds = "cZUHtgk-avk:APA91bEl-X9haekof8OTTs35Vv6Zm8NggVDlJCJ-k21f4yzDnrUVD05DSqV8cSimwS5_Z_HWVdO7FmPcxOOmMFPWRZencos9zBY6n38nSCsXYszrXawelG101uSlFgqlhYRMD-WNjOqi";


// $registrationIds = array(
//     "cZUHtgk-avk:APA91bEl-X9haekof8OTTs35Vv6Zm8NggVDlJCJ-k21f4yzDnrUVD05DSqV8cSimwS5_Z_HWVdO7FmPcxOOmMFPWRZencos9zBY6n38nSCsXYszrXawelG101uSlFgqlhYRMD-WNjOqi",
//     "ez72xRgmNh8:APA91bHujuwNAlrTkSac3r_j8k7IfFsydJ-vFMfWIUxMA_xS5dssHxbgFgwgX5RUJ75uwZr4XX-SfwA38fqDjJVwqMWwTBJpTbaBucw_rd2XGAE_VGbkgqPpEvUYrjU80Fe31Uj7Bu5_");


//mio
//cZUHtgk-avk:APA91bEl-X9haekof8OTTs35Vv6Zm8NggVDlJCJ-k21f4yzDnrUVD05DSqV8cSimwS5_Z_HWVdO7FmPcxOOmMFPWRZencos9zBY6n38nSCsXYszrXawelG101uSlFgqlhYRMD-WNjOqi
//mago
//ez72xRgmNh8:APA91bHujuwNAlrTkSac3r_j8k7IfFsydJ-vFMfWIUxMA_xS5dssHxbgFgwgX5RUJ75uwZr4XX-SfwA38fqDjJVwqMWwTBJpTbaBucw_rd2XGAE_VGbkgqPpEvUYrjU80Fe31Uj7Bu5_

#prep the bundle
// $msg = array
// (
//     'body' 	=> 'Body  Of Notification',
//     'title'	=> 'Title Of Notification',
//     'icon'	=> 'myicon',/*Default Icon*/
//     'sound' => 'mySound'/*Default sound*/
// );
        $values = array();
        
        $values ['tipo'] = "1";        
        $values ['subtitulo'] = "subtitulo";
       
        $values ['genera'] = "Juan Urrutia";
        
        $values ['refint'] = "0";
        $values ['refstr'] = "";
        
        
        
        
//         $values ['param2'] = $link;
$msg = array
(
//     'message' 	=> 'here is a message. message',
    'title'		=> 'This is a title. title',
    'subtitle'	=> 'This is a subtitle. subtitle',
    'body'	=> 'Ticker text here...Ticker text here...Ticker text here',
//     'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
    'vibrate'	=> 1,
    'sound'		=> 1,
    'largeIcon'	=> 'large_icon',
    'smallIcon'	=> 'small_icon'    
);
$fields = array
(
    'registration_ids'		=> $registrationIds,
    'notification'	=> $msg,
    'data'	=> $values
);


$headers = array
(
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
);
#Send Reponse To FireBase Server
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
#Echo Result Of FireBase Server
// echo $result;

// // API access key from Google API's Console
// define( 'API_ACCESS_KEY', 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA' );
// $registrationIds = array( "fpdpeVNXfTo:APA91bHdF8Ip1q1D-_AdOhJjol91TXaxJfcPbs_zZ8cHrXoMWqJc-LMaAxQRqR0PyY19LbR9VqNFPfdgSVHKWs7RXXh6GCnYCugQzamZ4yzJgv-zx0F1NzeJosYCFkN8NFLS3YAaje6m" );
// // prep the bundle
// $msg = array
// (
//     'message' 	=> 'here is a message. message',
//     'title'		=> 'This is a title. title',
//     'subtitle'	=> 'This is a subtitle. subtitle',
//     'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
//     'vibrate'	=> 1,
//     'sound'		=> 1,
//     'largeIcon'	=> 'large_icon',
//     'smallIcon'	=> 'small_icon'
// );
// $fields = array
// (
//     'registration_ids' 	=> $registrationIds,
//     'data'			=> $msg
// );

// $headers = array
// (
//     'Authorization: key=' . API_ACCESS_KEY,
//     'Content-Type: application/json'
// );

// $ch = curl_init();
// curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
// curl_setopt( $ch,CURLOPT_POST, true );
// curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
// curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
// curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
// curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
// $result = curl_exec($ch );
// curl_close( $ch );
// echo $result;


//*************************************************************


// function app_sabes_notificaciones( ) {
    
//     if ( true) {
        
//         //KEY generada en el servicio de firebase. Esta Key no cambia.
//         $FIREBASE_API_KEY = 'AAAA2VtNpQU:APA91bGN3E_QxomaE7QTkSq7fJ4tDcOq7N9GrfIj5_WIdlDm9J2bGJS4nyyzCK-a5xsf7YEEcIfHo2Dt-Gtq16aLGzQ01Lp7gv3Z7f479fk2n6nqRu899Ja6BK1sz9yTVhcqgLm6Wx6Q28LzjbjvSnsc5_qjNIcZeA';
        
//         $url = "https://fcm.googleapis.com/fcm/send";
        
// //         $link = get_post_permalink($post);
//         $values = array();
//         $values ['topico'] = "noticias";
//         $values ['param1'] = "Alta Pedido";
// //         $values ['param2'] = $link;
        
        
//         $data = array();
//         $data ['to'] = "/topics/noticias";
// // $data['to'] = "fpdpeVNXfTo:APA91bHdF8Ip1q1D-_AdOhJjol91TXaxJfcPbs_zZ8cHrXoMWqJc-LMaAxQRqR0PyY19LbR9VqNFPfdgSVHKWs7RXXh6GCnYCugQzamZ4yzJgv-zx0F1NzeJosYCFkN8NFLS3YAaje6m";
//         $data['registration_keys'] = array("fpdpeVNXfTo:APA91bHdF8Ip1q1D-_AdOhJjol91TXaxJfcPbs_zZ8cHrXoMWqJc-LMaAxQRqR0PyY19LbR9VqNFPfdgSVHKWs7RXXh6GCnYCugQzamZ4yzJgv-zx0F1NzeJosYCFkN8NFLS3YAaje6m");
//         $data ['notification']['title'] = "Alta Pedido";
//         $data ['notification']['body'] = "Se ha dado de alta un pedido " . date("Y-m-d H:i:s");
//         $data ['data'] = $values;
        
//         $content = json_encode($data);
        
//         $curl = curl_init($url);
//         curl_setopt($curl, CURLOPT_HEADER, false);
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($curl, CURLOPT_HTTPHEADER,
//             array(
//                 "Content-type: application/json",
//                 "Authorization: key=".$FIREBASE_API_KEY
//             ));
//         curl_setopt($curl, CURLOPT_POST, true);
//         curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        
//         $json_response = curl_exec($curl);
        
//         $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
//         curl_close($curl);
//         $response = json_decode($json_response, true);
//         print_r ($response);
//     }
// }



// app_sabes_notificaciones();
