<?php


class NotificationManager
{
    public static $NOTIFICACIONES_NOTIFICACION = 1;
    public static $NOTIFICACIONES_PEDIDO = 2;
    public static $NOTIFICACIONES_MSG = 3;
    public static $NOTIFICACIONES_PRODUCTO = 4;
    public static $NOTIFICACIONES_PETICION = 5;
    public static $NOTIFICACIONES_FACTURA = 6;

    // public static $WATEMPLATE_PEDIDONUEVO = "Se ha creado un nuevo *Pedido*\n\n📋 Folio: *{{1}}*\n Cliente: *{{2}}*\n👤 Usuario: *{{3}}*\n\n_Nuevo Pedido_";
    public static $WATEMPLATE_PEDIDONUEVO = "Se ha creado un nuevo *Pedido*\n\nFolio: *{{1}}*\nCliente: *{{2}}*\nUsuario: *{{3}}*\n\n_Nuevo Pedido_";
    //                                      "Se ha creado un nuevo *Pedido*\n\n📋 Folio: *{{1}}*\n Cliente: *{{2}}*\n👤 Usuario: *{{3}}*\n\n_Nuevo Pedido_"
    // 	                                    "Se ha creado un nuevo *Pedido*\n\nFolio: *{{1}}*\nCliente: *{{2}}*\nUsuario: *{{3}}*\n\n_Nuevo Pedido_
    public static $WATEMPLATE_PEDIDOESTATUS = "El *Pedido* con folio 📋 *{{1}}*, del cliente *{{2}}*, ha sido 📌 *{{3}}* por 👤 *{{4}}*.\n\n_Estatus del Pedido_";
    public static $WATEMPLATE_PEDIDOASIGNADO = "El *Pedido* con folio 📋 *{{1}}*, del cliente *{{2}}*, ha sido 📌 *ASIGNADO* a la(s) sucursal(es): {{3}}, por 👤*{{4}}*.\n\n_Estatus del Pedido_";
    public static $WATEMPLATE_PEDIDOTOTALCAMBIADO = "Importe de *Pedido* con folio 📋 *{{1}}* ha cambiado, de *{{2}}* a *{{3}}*, factura asignada 📓 *{{4}}*.\n\n_Importe del Pedido_";
    public static $WATEMPLATE_CORTECAJA = "La Sucursal 🏭 *{{1}}* cuenta con la cantidad de *$ {{2}}* en 💰 Efectivo. Es sugerible para esta cantidad pasar a realizar un corte de caja.\n\n_Corte Caja_";

    public static function WA_GetPayloads($ids)
    {
        $payloadList = array();
        foreach($ids as $id)
        {
            $usuario = new ModeloUsuario();
        
            $usuario->setIdUsuario($id);

            if ($usuario->getIdUsuario()>0)
            {
                if ($usuario->getWhatsappStatus() == 'ACTIVO')
                {
                    $payload = new stdClass();
                    $payload->WaId = $usuario->getWhatsapp();
                    $payload->Body = "";
                    
                    array_push($payloadList, $payload);
                }
            }
        }
        // echo "<br>";
        // echo count($payloadList);
        // echo "Payloads: <br>";
        // echo "<br>";
        // print_r($payloadList);
        return $payloadList;
    }

    public static function WA_PedidoNuevo($idList, $idPedido = 0)
    {
        $payloadList = NotificationManager::WA_GetPayloads($idList);
        if (count($payloadList) > 0)
        {

            $query = "SELECT p.idPedido, CONCAT(c.nombre, ' ' , c.apellidos) nombreCliente, CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) usuarioCaptura
                        FROM pedido p
                        INNER JOIN cliente c ON p.idCliente = c.idCliente
                        INNER JOIN usuario u ON p.id_usuario_capturado = u.idUsuario
                        WHERE p.idPedido = " . $idPedido;
            // echo $query;
            $obj = new ModeloUsuario();            
            $ds = $obj->getDataSet($query);

            if ($ds == null){
                return;
            }

            $tmpBody = NotificationManager::$WATEMPLATE_PEDIDONUEVO;
            $tmpBody = str_replace("{{1}}", $ds[0]["idPedido"], $tmpBody);
            $tmpBody = str_replace("{{2}}", $ds[0]["nombreCliente"], $tmpBody);
            $tmpBody = str_replace("{{3}}", $ds[0]["usuarioCaptura"], $tmpBody);
            // echo "<br>".$tmpBody."<br>";
            foreach($payloadList as $pl)
            {
                $pl->Body = $tmpBody;
            }

            NotificationManager::WA_Send(($payloadList));
        }
    }

    public static function WA_Send($payloadList) 
    {
        // return;
        $headers = array
                    (
                        'Authorization: AC96ced0f04479a7361b6c35c5d0440bc725',
                        'Content-Type: application/json'
                    );

        foreach($payloadList as $payload)
        {
            // var_dump($payload);
            // echo "<br>";
            $ch = curl_init();
            // curl_setopt( $ch,CURLOPT_URL, 'http://localhost:3001/v1/wa/send' );
            // curl_setopt( $ch,CURLOPT_URL, 'https://whatsapp.galvamexservices.xyz/v1/wa/send' );
            // curl_setopt( $ch,CURLOPT_URL, 'http://localhost/wasender/s3ud612.php' );
            curl_setopt( $ch,CURLOPT_URL, 'https://wasender.galvamex.com/s3ud612.php' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
            // curl_setopt( $ch,CURLOPT_POSTFIELDS, $post );
            $result = curl_exec($ch );
            curl_close( $ch );

            // var_dump(json_decode($result));
        }


        // #Send Reponse To FireBase Server

    }

    public static function WA_EstatusPedido($idList, $idPedido = 0, $status, $txtAutomatico = "")
    {
        global $objSession;
        $user = $objSession->getNombre()." ".$objSession->getApellidoPaterno()." ".$objSession->getApellidoMaterno();
        $payloadList = NotificationManager::WA_GetPayloads($idList);
        if (count($payloadList) > 0)
        {
            $haSido = "CAPTURADO";                
            switch($status){
                case "AUTORIZADO": 
                    $usuario_estado = "id_usuario_autorizado";
                    $haSido = "AUTORIZADO";
                    if ($txtAutomatico != "")
                    {
                        $haSido .= $txtAutomatico;
                    }
                    break;
                case "PRODUCCION": 
                    $usuario_estado = "id_usuario_produccion";
                    $haSido = "asignado a PRODUCCIÓN";
                    break;
                case "TERMINADO": 
                    $usuario_estado = "id_usuario_terminado";
                    $haSido = "SURTIDO";
                    break;
                case "ENTREGADO": 
                    $usuario_estado = "id_usuario_entregado";
                    $haSido = "ENTREGADO";
                    break;
                case "CANCELADO": 
                    $usuario_estado = "id_usuario_cancelado";
                    $haSido = "CANCELADO";
                    break;
                case "SALDADO": 
                    $usuario_estado = "";
                    $haSido = "SALDADO";
                    break;
                case "ASIGNADOAUTOMATICO": 
                    $usuario_estado = "";
                    $haSido = "ASIGNADO Automáticamente";
                    break;
                default: 
                    $usuario_estado = "id_usuario_capturado";
            }
            // $id_usuario_capturado
            // $id_usuario_autorizado
            // $id_usuario_produccion
            // $id_usuario_terminado
            // $id_usuario_entregado
            // $id_usuario_cancelado

            if ($status != "SALDADO" && $status != "ASIGNADOAUTOMATICO")
            {
                $query = "SELECT p.idPedido, CONCAT(c.nombre, ' ' , c.apellidos) nombreCliente, CONCAT(u.nombre, ' ', u.apellidoPaterno, ' ', u.apellidoMaterno) usuario
                            FROM pedido p
                            INNER JOIN cliente c ON p.idCliente = c.idCliente
                            INNER JOIN usuario u ON p.".$usuario_estado." = u.idUsuario
                            WHERE p.idPedido = " . $idPedido;
            }
            else
            {
                $query = "SELECT p.idPedido, CONCAT(c.nombre, ' ' , c.apellidos) nombreCliente
                            FROM pedido p
                            INNER JOIN cliente c ON p.idCliente = c.idCliente
                            WHERE p.idPedido = " . $idPedido;
            }
            
            $obj = new ModeloUsuario();            
            $ds = $obj->getDataSet($query);
            if ($ds == null){
                return;
            }

            $tmpBody = NotificationManager::$WATEMPLATE_PEDIDOESTATUS;
            $tmpBody = str_replace("{{1}}", $ds[0]["idPedido"], $tmpBody);
            $tmpBody = str_replace("{{2}}", trim($ds[0]["nombreCliente"], " "), $tmpBody);
            $tmpBody = str_replace("{{3}}", $haSido, $tmpBody);
            if ($status != "SALDADO" && $status != "ASIGNADOAUTOMATICO")
            {
                $tmpBody = str_replace("{{4}}", trim($ds[0]["usuario"]," "), $tmpBody);
            }
            else
            {
                $tmpBody = str_replace("{{4}}", $user, $tmpBody);
            }

            // echo "<br>Noti ". __LINE__;
            foreach($payloadList as $pl)
            {
                $pl->Body = $tmpBody;
            }

            NotificationManager::WA_Send(($payloadList));
        }
    }

    public static function WA_PedidoAsignado($idList, $idPedido = 0, $sucursales)
    {
        global $objSession;
        $user = $objSession->getNombre()." ".$objSession->getApellidoPaterno()." ".$objSession->getApellidoMaterno();

        $payloadList = NotificationManager::WA_GetPayloads($idList);
        
        if (count($payloadList) > 0)
        {
            $query = "SELECT p.idPedido, CONCAT(c.nombre, ' ' , c.apellidos) nombreCliente
                        FROM pedido p
                        INNER JOIN cliente c ON p.idCliente = c.idCliente
                        WHERE p.idPedido = " . $idPedido;
            
            $obj = new ModeloUsuario();            
            $ds = $obj->getDataSet($query);

            if ($ds == null){
                return;
            }

            $tmpBody = NotificationManager::$WATEMPLATE_PEDIDOASIGNADO;
            $tmpBody = str_replace("{{1}}", $ds[0]["idPedido"], $tmpBody);
            $tmpBody = str_replace("{{2}}", trim($ds[0]["nombreCliente"], " "), $tmpBody);
            $tmpBody = str_replace("{{3}}", $sucursales, $tmpBody);
            $tmpBody = str_replace("{{4}}", $user, $tmpBody);

            foreach($payloadList as $pl)
            {
                $pl->Body = $tmpBody;
            }

            NotificationManager::WA_Send(($payloadList));
        }
    }

    public static function WA_CorteCaja($idList, $sucursal, $monto)
    {
        $payloadList = NotificationManager::WA_GetPayloads($idList);
        
        if (count($payloadList) > 0)
        {

            $tmpBody = NotificationManager::$WATEMPLATE_CORTECAJA;
            $tmpBody = str_replace("{{1}}", $sucursal, $tmpBody);
            $tmpBody = str_replace("{{2}}", $monto, $tmpBody);

            foreach($payloadList as $pl)
            {
                $pl->Body = $tmpBody;
            }

            NotificationManager::WA_Send(($payloadList));
        }
    }

    public static function WA_SendMessage($idList, $msg)
    {
        $payloadList = NotificationManager::WA_GetPayloads($idList);
        
        if (count($payloadList) > 0)
        {
            foreach($payloadList as $pl)
            {
                $pl->Body = $msg;
            }

            NotificationManager::WA_Send(($payloadList));
        }
    }
    
    
    public static function saludar(){
        global $objSession;
        
        
    }
    
    public static function testSendNotification($tipoNotificacion,$idUsuarioDestino, $titulo, $body)
    {
        global $objSession;
        
        $titulo = utf8_encode($titulo);
        $body = utf8_encode($body);
        
        $usuario = new ModeloUsuario();
        
        $usuario->setIdUsuario($idUsuarioDestino);
        
        if ($usuario->getIdUsuario()>0)
        {
            
            $registrationIds = $usuario->getTokendevice();
//             echo $registrationIds."<br>";
            
            $values = array();
            
            
            $values ['tipo'] = $tipoNotificacion;
//             $values ['subtitulo'] = "subtitulo";
            
            $values ['genera'] = $objSession->getNombre()." ".$objSession->getApellidoPaterno()." ".$objSession->getApellidoMaterno();
            
            $values ['refint'] = "0";
            $values ['refstr'] = "";
            //         $values ['param2'] = $link;
            $msg = array
            (
//                      'message' 	=> 'here is a message. message',
                'title'		=> $titulo,
                'subtitle'	=> "Subtitulo dd",
                'body'	=> $body,
                    'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate'	=> 1,
                'sound'		=> 1,
                'largeIcon'	=> 'large_icon',
                'smallIcon'	=> 'small_icon'
            );
            $fields = array
            (
                'to'		=> $registrationIds,
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
            
//             var_dump( $result);
            
//             echo "<br><br>";

            $pn = new ModeloPushnotifica();
            
            $pn->setIdProvoca($objSession->getIdUsuario());
            $pn->setIdPara($idUsuarioDestino);
            $pn->setTipo($tipoNotificacion);
            $pn->setTema($titulo);
            $pn->setContenido($body);
            
            
            if (json_decode($result, true)["success"] == "1")
            {
                $pn->setEnviadoSI();
            }
            else
            {
                $pn->setEnviadoNO();
            }
            
            $pn->Guardar();
            
            
//             echo "Success: " . json_decode($result, true)["success"];
//             echo "<br><br>";
//             var_dump(json_decode($result));
            
//             echo "<br><br>";
            
//             var_dump(json_decode($result, true));
            
        }        
    }
    
    public static function SendNotification($tipoNotificacion,$idUsuarioDestino, $titulo, $body, $refint = 0, $refstr = "")
    {
        global $objSession;
        
        // echo "<br><br>";

        // echo " titulo:" . $titulo . " <br> Titulo encode: " . utf8_encode($titulo);
        // echo "<br>";
        // echo " body:" . $body . " <br> body encode: " . utf8_encode($body);
               

        // $titulo = utf8_encode($titulo);
        // $body = utf8_encode($body);
        
        // echo "<br><br>";

        // echo "<br><br>";
        $usuario = new ModeloUsuario();
        
        $usuario->setIdUsuario($idUsuarioDestino);
        
        if ($usuario->getIdUsuario()>0)
        {
            
            $registrationIds = $usuario->getTokendevice();
            //             echo $registrationIds."<br>";
            
            $values = array();
            
            
            $values ['tipo'] = $tipoNotificacion;
            //             $values ['subtitulo'] = "subtitulo";
            if (isset($objSession))
            {
                $values ['genera'] = $objSession->getNombre()." ".$objSession->getApellidoPaterno()." ".$objSession->getApellidoMaterno();
            }
            else
            {
                $values ['genera'] = "SYSTEM GALVAMEX";
            }
            
            
            $values ['refint'] = $refint;
            $values ['refstr'] = $refstr;
            //         $values ['param2'] = $link;
            $msg = array
            (
            //                      'message' 	=> 'here is a message. message',
                'title'		=> $titulo,
                'subtitle'	=> "Subtitulo dd",
                'body'	=> $body,
                'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate'	=> 1,
                'sound'		=> 1,
                'largeIcon'	=> 'large_icon',
                'smallIcon'	=> 'small_icon'
            );
            $fields = array
            (
                'to'		=> $registrationIds,
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
            
            // echo "<br><br>";

            //             var_dump( $result);
            
            //             echo "<br><br>";
            
            $pn = new ModeloPushnotifica();
            if (isset($objSession))
            {
                $pn->setIdProvoca($objSession->getIdUsuario());
            }
            else
            {
                $pn->setIdProvoca(2);
            }


            $pn->setIdPara($idUsuarioDestino);
            $pn->setTipo($tipoNotificacion);
            $pn->setTema($titulo);
            $pn->setContenido($body);
            
            
            if (json_decode($result, true)["success"] == "1")
            {
                $pn->setEnviadoSI();
            }
            else
            {
                $pn->setEnviadoNO();
            }
            
            $pn->Guardar();
            
            
                        // echo "Success: " . json_decode($result, true)["success"];
                        // echo "<br><br>";
                        // var_dump(json_decode($result));
            
                        // echo "<br><br>";
            
                        // var_dump(json_decode($result, true));
            
        }
    }
    
    public static function SendNotificationMySelf($tipoNotificacion,$titulo, $body, $refint = 0, $refstr = "")
    {
        global $objSession;
        
        $titulo = ($titulo);
        $body = ($body);
        
        $usuario = new ModeloUsuario();
        
        $idUsuarioDestino = $objSession->getIdUsuario();
        
        $usuario->setIdUsuario($idUsuarioDestino);
        
        
        
        if ($usuario->getIdUsuario()>0)
        {
            
            $registrationIds = $usuario->getTokendevice();
            //             echo $registrationIds."<br>";
            
            $values = array();
            
            
            $values ['tipo'] = $tipoNotificacion;
            //             $values ['subtitulo'] = "subtitulo";
            
            $values ['genera'] = $objSession->getNombre()." ".$objSession->getApellidoPaterno()." ".$objSession->getApellidoMaterno();
            
            $values ['refint'] = $refint;
            $values ['refstr'] = $refstr;
            //         $values ['param2'] = $link;
            $msg = array
            (
                //                      'message' 	=> 'here is a message. message',
                'title'		=> $titulo,
                'subtitle'	=> "Subtitulo dd",
                'body'	=> $body,
                'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate'	=> 1,
                'sound'		=> 1,
                'largeIcon'	=> 'large_icon',
                'smallIcon'	=> 'small_icon'
            );
            $fields = array
            (
                'to'		=> $registrationIds,
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
            
            //                         var_dump( $result);
            
            //             echo "<br><br>";
            
            $pn = new ModeloPushnotifica();
            
            $pn->setIdProvoca($objSession->getIdUsuario());
            $pn->setIdPara($idUsuarioDestino);
            $pn->setTipo($tipoNotificacion);
            $pn->setTema($titulo);
            $pn->setContenido($body);
            
            
            if (json_decode($result, true)["success"] == "1")
            {
                $pn->setEnviadoSI();
            }
            else
            {
                $pn->setEnviadoNO();
            }
            
            $pn->Guardar();
            
            
            //             echo "Success: " . json_decode($result, true)["success"];
            //             echo "<br><br>";
            //             var_dump(json_decode($result));
            
            //             echo "<br><br>";
            
            //             var_dump(json_decode($result, true));
            
        }
    }
    
    public static function sendNotificationBySystem($tipoNotificacion,$idUsuarioDestino, $titulo, $body)
    {
        
        
        $titulo = ($titulo);
        $body = ($body);
        
        $usuario = new ModeloUsuario();
        
        $usuario->setIdUsuario($idUsuarioDestino);
        
        if ($usuario->getIdUsuario()>0)
        {
            
            $registrationIds = $usuario->getTokendevice();
            //             echo $registrationIds."<br>";
            
            $values = array();
            
            
            $values ['tipo'] = $tipoNotificacion;
            //             $values ['subtitulo'] = "subtitulo";
            
            $values ['genera'] = "SYSTEMA GALVAMEX";
            
            $values ['refint'] = "0";
            $values ['refstr'] = "";
            //         $values ['param2'] = $link;
            $msg = array
            (
            //                      'message' 	=> 'here is a message. message',
                'title'		=> $titulo,
                'subtitle'	=> "Subtitulo dd",
                'body'	=> $body,
                'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate'	=> 1,
                'sound'		=> 1,
                'largeIcon'	=> 'large_icon',
                'smallIcon'	=> 'small_icon'
            );
            $fields = array
            (
                'to'		=> $registrationIds,
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
            
//                         var_dump( $result);
            
            //             echo "<br><br>";
            $pn = new ModeloPushnotifica();
            
            $pn->setIdProvoca(2);
            $pn->setIdPara($idUsuarioDestino);
            $pn->setTipo($tipoNotificacion);
            $pn->setTema($titulo);
            $pn->setContenido($body);
            
            
            if (json_decode($result, true)["success"] == "1")
            {
                $pn->setEnviadoSI();
            }
            else
            {
                $pn->setEnviadoNO();
            }
            
            
            $pn->Guardar();
            
            
            //             echo "Success: " . json_decode($result, true)["success"];
            //             echo "<br><br>";
            //             var_dump(json_decode($result));
            
            //             echo "<br><br>";
            
            //             var_dump(json_decode($result, true));
            
        }
    }
    
    public static function sendNotificationBySystemUsingToken($tipoNotificacion, $token,$idUsuarioDestino, $titulo, $body)
    {
        
        
        $titulo = utf8_encode($titulo);
        $body = utf8_encode($body);
        
//         $usuario = new ModeloUsuario();
        
//         $usuario->setIdUsuario($idUsuarioDestino);
        
//         if ($usuario->getIdUsuario()>0)
//         {
            
//             $registrationIds = $usuario->getTokendevice();
            //             echo $registrationIds."<br>";
            
            $values = array();
            
            
            $values ['tipo'] = $tipoNotificacion;
            //             $values ['subtitulo'] = "subtitulo";
            
            $values ['genera'] = "SYSTEMA GALVAMEX";
            
            $values ['refint'] = "0";
            $values ['refstr'] = "";
            //         $values ['param2'] = $link;
            $msg = array
            (
                //                      'message' 	=> 'here is a message. message',
                'title'		=> $titulo,
                'subtitle'	=> "Subtitulo dd",
                'body'	=> $body,
                'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
                'vibrate'	=> 1,
                'sound'		=> 1,
                'largeIcon'	=> 'large_icon',
                'smallIcon'	=> 'small_icon'
            );
            $fields = array
            (
                'to'		=> $token,
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
            
            //             var_dump( $result);
            
            //             echo "<br><br>";
            
            $pn = new ModeloPushnotifica();
            
            $pn->setIdProvoca(2);
            $pn->setIdPara($idUsuarioDestino);
            $pn->setTipo($tipoNotificacion);
            $pn->setTema($titulo);
            $pn->setContenido($body);
            
            
            if (json_decode($result, true)["success"] == "1")
            {
                $pn->setEnviadoSI();
            }
            else
            {
                $pn->setEnviadoNO();
            }
            
            $pn->Guardar();
            
            
            //             echo "Success: " . json_decode($result, true)["success"];
            //             echo "<br><br>";
            //             var_dump(json_decode($result));
            
            //             echo "<br><br>";
            
            //             var_dump(json_decode($result, true));
            
//         }
    }
    
    public static function onlySendNotification($tipoNotificacion,$idUsuarioDestino, $titulo, $body, $refint, $refstr, $de, $para)
    {
        
        if ($para != "")
        {
            
            $registrationIds = $para;
            //             echo $registrationIds."<br>";
            
            $values = array();
            
            
            $values ['tipo'] = $tipoNotificacion;
            //             $values ['subtitulo'] = "subtitulo";
            
            $values ['genera'] = $de;
            
            $values ['refint'] = $refint;
            $values ['refstr'] = $refstr;
            //         $values ['param2'] = $link;
            $msg = array
            (
                //                      'message' 	=> 'here is a message. message',
                'title'		=> $titulo,
                'subtitle'	=> $titulo,
                'body'	=> $body,
                'tickerText'	=> '',
                'vibrate'	=> 1,
                'sound'		=> 1,
                'largeIcon'	=> 'large_icon',
                'smallIcon'	=> 'small_icon'
            );
            $fields = array
            (
                'to'		=> $registrationIds,
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
            
        }
    }
}