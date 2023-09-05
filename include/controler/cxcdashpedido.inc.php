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

	function cargarPedidos($idCliente)
	{
		$r = new xajaxResponse();

		

		return $r;
	}
	$xajax->registerFunction("cargarPedidos");

	

    function cargarClienteDePedido($idPedido)
	{
		$r = new xajaxResponse();

		$pedido = new ModeloPedido();

		$pedido->getPedido($idPedido, " LIMIT 1");

		if (count($pedido->__rsPedidoWDetalle) <= 0)
		{
			$r->saError("No se pudo obtener información del Pedido.");
			// $r->script("app.seleccionarOtroPedido();");
			return $r;
		}

		$datosCliente = "";

		
		$datosCliente .= "app.filtroNombreCliente = '".$pedido->getPedidoDato("cteNombre"). " ". $pedido->getPedidoDato("cteApellidos") ."';";
		
		//$r->mostrarAviso("cargamos pedido");
		$r->script($datosCliente);

		return $r;
	}
	$xajax->registerFunction("cargarClienteDePedido");

	function cargarCliente($idCliente)
	{
		$r = new xajaxResponse();
	// $r->starDebug();
		$clientes = new ModeloCliente();
	
		$lst = $clientes->getAll("cliente.credito,  cliente.capacidadpago, cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.email, cliente.estado, cliente.rfc, u.nombre as nombrePromotor, u.apellidoPaterno, u.apellidoMaterno,
                                 domicilio1, domicilio2, numero, colonia, ciudad, telefonos, pordescuento,
                                 getCreditoUsadoCliente(cliente.idcliente) creditousadogetCreditoUsadoCliente,
                                 getSaldoReciboDinero(cliente.idcliente) saldoRD ",
				" INNER JOIN usuario AS u ON u.idUsuario = idUsuarioPromotor",
				" cliente.idCliente = " . $idCliente);
	
		$strClientes = "";
		
		$idClienteFromDB = "0";
		
	
		foreach ($lst as $row)
		{
	
			$idClienteFromDB = $row["idCliente"];
			$strClientes .= "
		                     app.nombre = '".mb_strtoupper($row["nombre"]). " "  . mb_strtoupper($row["apellidos"])."';
		                     app.domicilio1 = '".mb_strtoupper($row["domicilio1"]). "';
		                     app.domicilio2 = '".mb_strtoupper($row["domicilio2"]). "';
		                     app.numero = '".mb_strtoupper($row["numero"]). "';
		                     app.colonia = '".mb_strtoupper($row["colonia"]). "';
		                     app.ciudad = '".mb_strtoupper($row["ciudad"]). "';
		                     app.telefonos = '".mb_strtoupper($row["telefonos"]). "';		                     
		                     app.email = '".($row["email"]). "';
		                     app.estado = '".$row["estado"]. "';
		                     app.rfc = '".mb_strtoupper($row["rfc"]). "';
							 app.promotor = '".mb_strtoupper($row["nombrePromotor"]). " "  . mb_strtoupper($row["apellidoPaterno"]) . " " . mb_strtoupper($row["apellidoMaterno"]) ."';
                             app.cteCredito = ".$row["credito"]. ";
                             app.cteCapacidadPago = ".$row["capacidadpago"]. ";
                             app.disponibleRD = ".$row["saldoRD"]. ";
                             app.creditousado = ".$row["creditousadogetCreditoUsadoCliente"]. ";
					                                      ";
		}
		
		if ($strClientes == "")
		{
			$r->script("app.idCliente = 0; app.seleccionandoCliente = true;");
			$r->saError("No se ha podido obtener la información del Cliente. Verifique o seleccione algun otro.");
			return $r;
		}
		
		//ahora obtenemos totales en pedidos
		$query = "select lower(estado) estado, count(*) cantidad from pedido
                        where idcliente = ".$idCliente."
                        and estado not in ('CANCELADO', 'ENTREGADO')
                        group by estado;";
		
				
        $datosPedidos = $clientes->getDataSet($query);

        $todosPedidos = 0;
        $totalespedidos = "";
        foreach ($datosPedidos as $row)
        {
            $totalespedidos .= " app.pedidos". $row["estado"] ." = ". $row["cantidad"] .";";
            $todosPedidos += $row["cantidad"] ;
        }
        
        $r->script($strClientes . $totalespedidos . " app.pedidostotal = " . $todosPedidos . "; app.cargarTracking(); ");

        $r->script(" mdlExitWait(); ");
		// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarCliente");
		
		
	function cargarClientes()
	{
		$r = new xajaxResponse();
		
		$cliente = new ModeloCliente();
		
		$lst = $cliente->getAll("cliente.idCliente, cliente.nombre, cliente.apellidos, cliente.empresa, cliente.domicilio1, cliente.domicilio2, cliente.email, cliente.telefonos", 
				"", 
				"", 
				" idCliente desc");
		
		$pushes = "";
		
		foreach ($lst as $c)
		{
			$pushes .= "
					
						app.clientes.push({
							idCliente: ".$c["idCliente"].",
							nombre: '". mb_strtoupper( $c["nombre"]). " " . mb_strtoupper( $c["apellidos"])."',							
							empresa: '".$c["empresa"]."', 
							domicilio1: '".$c["domicilio1"]."', 
							domicilio2: '".$c["domicilio2"]."', 
							email: '".$c["email"]."', 
							telefonos: '".$c["telefonos"]."'
						});
					
					";
		}
		
		$r->script("
					app.clientes.splice(0, app.clientes.length);
							
				" . $pushes);
		
		return $r;
	}	
	$xajax->registerFunction("cargarClientes");

	function cargarTracking($idCliente)
	{
		$r = new xajaxResponse();
// $r->starDebug();
		$pedido = new ModeloPedido();

		$query = "select pt.idPedido, pt.msg, pt.tipo, pt.fecha 
					from pedido p
					inner join pedidostracking pt on p.idpedido = pt.idpedido
					where p.idcliente = ". $idCliente ."
					and p.estado not in ('CANCELADO')
					order by pt.idPedidosTracking desc
				";

		$lst = $pedido->getDataSet($query);
		
		$pushes = "";
		foreach($lst as $row)
		{
			$pushes .= "
				app.tracking.push({
					idPedido: ".$row["idPedido"].",
					msg: '".$row["msg"]."',
					fecha: '".$row["fecha"]."',
					tipo: '".$row["tipo"]."',
				});
			";
		}
		
		
		$r->script(" app.tracking.splice (0, app.tracking.lenght);  " . $pushes);
// $r->endDegug();
		return $r;
	}
	$xajax->registerFunction("cargarTracking");

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
