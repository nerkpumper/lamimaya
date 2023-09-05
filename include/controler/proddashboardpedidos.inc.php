<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

	require_once FOLDER_MODEL. "model.pedido.inc.php";
    require_once FOLDER_MODEL. "model.usuario.inc.php";

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

    function setIdPromotor()
    {
        global $objSession;
        $r = new xajaxResponse();

        // $r->mostrarMsgs($objSession->getIdUsuario());
        if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
        {
            $r->script("app.filtro.promotor = ". $objSession->getIdUsuario() ." ;");
        }


        return $r;
    }
    $xajax->registerFunction("setIdPromotor");

	function cargarDatos($SucursalSeleccionada)
	{
		global $objSession;
		$r = new xajaxResponse();
        //$SucursalSeleccionada ='TORRES LANDA';

		$pedido = new ModeloPedido();

        $lst = $pedido->getDataSet("select 
        p.idpedido, 
        p.idcliente, 
        concat(c.nombre,' ' , c.apellidos) as cliente,
        p.estado, 
        p.total, 
        p.saldo, 
        p.saldada, 
        p.recogeentrega,concat(u.nombre,' ',u.apellidoPaterno) as promotor 
        from pedido as p 
        inner join cliente as c on c.idcliente = p.idcliente 
        inner join usuario as u on u.idusuario = c.idusuariopromotor 
        where p.estado = 'PRODUCCION' and 
        p.recogeentrega <> 'OBRA' and 
        getPedidoSucursalesAsignadas(p.idPedido) like '%".$SucursalSeleccionada."%';");

        $pushes = "";
        $lista1 = false;
        foreach ($lst as $item)
        {
            $lista1 = !$lista1;
            $pushes .= "
                    app.pedidosproduccion".($lista1 ? "1" : "2" ).".push({
                        id: ".$item["idpedido"].",
                        nombreCliente: '".$item["cliente"]."',
                        recogeentrega: '".$item["recogeentrega"]."',
                        promotor: '".$item["promotor"]."',
                        total: '".$item["total"]."',
                        saldada: '".$item["saldada"]."',
                    });
            ";

        }

        $lst = $pedido->getDataSet("select 
        p.idpedido, 
        p.idcliente, 
        concat(c.nombre,' ' , c.apellidos) as cliente,
        p.estado, 
        p.total, 
        p.saldo, 
        p.saldada, 
        p.recogeentrega,concat(u.nombre,' ',u.apellidoPaterno) as promotor 
        from pedido as p 
        inner join cliente as c on c.idcliente = p.idcliente 
        inner join usuario as u on u.idusuario = c.idusuariopromotor 
        where p.estado = 'TERMINADO' and 
        p.recogeentrega <> 'OBRA' and 
        getPedidoSucursalesAsignadas(p.idPedido) like '%".$SucursalSeleccionada."%';");


        $lista1 = false;
        foreach ($lst as $item)
        {
            $lista1 = !$lista1;
            $pushes .= "
                    app.pedidosterminados".($lista1 ? "1" : "2" ).".push({
                        id: ".$item["idpedido"].",
                        nombreCliente: '".$item["cliente"]."',
                        recogeentrega: '".$item["recogeentrega"]."',
                        promotor: '".$item["promotor"]."',
                        total: '".$item["total"]."',
                        saldada: '".$item["saldada"]."',
                    });
            ";
        }

        $lst = $pedido->getDataSet("select  
        p.idpedido, 
        p.idcliente, 
        concat(c.nombre,' ' , c.apellidos) as cliente, 
        p.total, 
        p.saldo, .
        p.saldada,
        p.recogeentrega,
        concat(u.nombre,' ',u.apellidoPaterno) as promotor, 
        p.recogeentrega
        from pedido as p
        inner join cliente as c
        on c.idcliente = p.idcliente
        inner join usuario as u
        on u.idusuario = c.idusuariopromotor
        where p.estado = 'ENTREGADO' and date_format(p.fecha_entregado, '%Y-%m-%d') = curdate() and
        getPedidoSucursalesAsignadas(p.idPedido) like '%".$SucursalSeleccionada."%';");


        $lista1 = false;
        foreach ($lst as $item)
        {
            $lista1 = !$lista1;
            $pushes .= "
                    app.pedidosentregados".($lista1 ? "1" : "2" ).".push({
                        id: ".$item["idpedido"].",
                        nombreCliente: '".$item["cliente"]."',
                        recogeentrega: '".$item["recogeentrega"]."',
                        promotor: '".$item["promotor"]."',
                        total: '".$item["total"]."',
                        saldada: '".$item["saldada"]."',
                    });
            ";
        }

        $r->script(" app.pedidosproduccion1.splice(0, app.pedidosproduccion1.length);
                     app.pedidosproduccion2.splice(0, app.pedidosproduccion2.length);
                     app.pedidosterminados1.splice(0, app.pedidosterminados1.length);
                     app.pedidosterminados2.splice(0, app.pedidosterminados2.length);
                     app.pedidosentregados1.splice(0, app.pedidosentregados1.length);
                     app.pedidosentregados2.splice(0, app.pedidosentregados2.length);


                     app.mostrarEspera = false;     
                        
                     " . $pushes);

		//$r->mostrarAviso("cargamos pedido");
		// $r->script();

		return $r;
	}
	$xajax->registerFunction("cargarDatos");


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

     $promotor = new ModeloUsuario();

 	$lstPromotores = $promotor->getOptionForSelect($promotor->getForSelect("idUsuario", "upper(concat(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno))", "idrol IN (2,4, 8) AND estatus = 'activo' "), "0", "-- SELECCIONE PROMOTOR --");

 	$mostrarListado = (Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) ? "false" : "true");

     $nombrePromotor = $objSession->getNombre() . ' ' . $objSession->getApellidoPaterno() . ' ' . $objSession->getApellidoMaterno();
