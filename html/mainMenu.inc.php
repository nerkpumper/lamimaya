<?php
    	if (!isset($_lugar))
    	{
    		$_lugar = "";
    	}
    
    	$_oLugar=new Routes();
    	$_oLugar->setLugar($_lugar);




//	if (file_exists ("/home/galvamex/public_html/aplis/img/" . ModeloUsuario::getObjSession()->getIdUsuario() . ".jpg"))
//	{
//	    echo "<br>SI existe imagem";
//	}
//	else
//	{
//	    echo "<br>No existe imagen";
//	}

// if ( file_exists ("/home/galvamex/public_html/aplis/img/" . ModeloUsuario::getObjSession()->getIdUsuario() . ".jpg"))
// {
// 	echo "http://app.galvamex.com.mx/img/" . 	ModeloUsuario::getObjSession()->getIdUsuario() . ".jpg";
// }
// else
// {
// 	echo 'http://app.galvamex.com.mx/img/noimage.png';
// }
// if (file_exists(realpath(FOLDER_IMG . ModeloUsuario::getObjSession()->getIdUsuario() . ".jpg")))
// {
// 	echo "SI existe img";
// }
// else
// {
// 	echo "NO existe img";
// }

/*
<span> <img alt="image" class="img-circle" style="width: 64px; height: 64px;"
		src="<?php

								if ( file_exists (realpath(FOLDER_IMG . ModeloUsuario::getObjSession()->getIdUsuario() . ".jpg")))
								{
									echo URL_BASE . "img/" . ModeloUsuario::getObjSession()->getIdUsuario() . ".jpg";
								}
								else
								{
									echo FOLDER_IMG . 'noimage.png';
								}
						?>" />
						</span> <a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<span class="clear"> <span class="block m-t-xs"> <strong
						class="font-bold"><?php if(isset($objSession)) echo $objSession->getUserName()?></strong>
						</span> <span class="text-muted text-xs block">
						        <?php

						        echo ModeloUsuario::getRol()->getNombre();


						        ?>
						      <b class="caret"></b></span>
					</span>
					</a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a href="<?php echo URL_BASE;?>miperfil">Mi Perfil</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo URL_BASE;?>salir">Salir</a></li>
					</ul>*/

/*
<li <?php echo $_lugar=="salir"?'class="active"':""?>><a
				href="<?php echo URL_BASE . "salir";?>"><i class="fa fa-sign-out"></i><span class="hidden-sm">
						Salir</span></a></li>
*/
?>

<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<img alt="Lamimaya" src="<?php echo URL_BASE . "img/lamimayalogoshort.png";?>" style="width: 100%;">

				</div>
				<div class="logo-element">
                        <img alt="Lamimaya" src="<?php echo URL_BASE . "img/lamimayalogoshort.png";?>" style="width: 100%;">
                </div>
			</li>

			<?php if (Permisos::userIsThisRol(Permisos::$idROOTUSER)):?>

				<li >
					<a href="#"><i class="fa fa-unlock-alt"></i> <span class="nav-label">Cron</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">

						<?php if (Permisos::userIsThisRol(Permisos::$idROOTUSER)):?>
							<li ><a href="<?php echo URL_BASE . "runcronexplosion";?>">Explosi&oacute;n</a></li>
						<?php endif;?>
						<?php if (Permisos::userIsThisRol(Permisos::$idROOTUSER)):?>
							<li ><a href="<?php echo URL_BASE . "runcronapartadosfix";?>">Fix Apartados</a></li>
						<?php endif;?>
						<?php if (Permisos::userIsThisRol(Permisos::$idROOTUSER)):?>
							<li ><a href="<?php echo URL_BASE . "runcronprocesapedidos";?>">Procesar Pedidos </a></li>
						<?php endif;?>
						

					</ul>
				</li>
			<?php endif;?>


			<li class="<?php echo $_oLugar->isPrimero(LUGAR_HOME)?"active":""?>"><a
				href="<?php echo URL_BASE . "index";?>"><i class="fa fa-home"></i><span class="nav-label">
						Inicio</span></a></li>


			<?php if(Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR)): ?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_ADMINISTRACION)?"active":""?>">
						<a href="#"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboards</span><span
							class="fa arrow"></span></a>
						<ul class="nav nav-second-level collapse">


								<li class=""><a href="<?php echo URL_BASE . "dash1";?>">Dashboard 1</a></li>
								<li class=""><a href="<?php echo URL_BASE . "dash2";?>">Dashboard 2</a></li>




						</ul>
				</li>
			<?php endif;?>


			<!-- Administraci�n -->

			<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION)):?>

				<li class="<?php echo $_oLugar->isPrimero(LUGAR_ADMINISTRACION)?"active":""?>">
					<a href="#"><i class="fa fa-gavel"></i> <span class="nav-label">Administraci&oacute;n</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">

						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_USUARIO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_USUARIO)?"active":""?>"><a href="<?php echo URL_BASE . "usuario";?>">Usuarios</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_CONFIGURACION)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_CONFIGURACION)?"active":""?>"><a href="<?php echo URL_BASE . "configuracion";?>">Configuraciones</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_DESCTOSCTES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_DESCTOSCTES)?"active":""?>"><a href="<?php echo URL_BASE . "adminclientepedidos";?>">Desctos. Clientes</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_DESCTOPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_DESCTOPEDIDO)?"active":""?>"><a href="<?php echo URL_BASE . "admindescuentopedido";?>">Descuento a Pedido</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_DESCTOCOTIZACION)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_DESCTOCOTIZACION)?"active":""?>"><a href="<?php echo URL_BASE . "admindescuentocotizacion";?>">Descuento a Cotizacion</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_CREDITOCLIENTES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_CREDITOCLIENTES)?"active":""?>"><a href="<?php echo URL_BASE . "admincreditoclientes";?>">Cr&eacute;dito Clientes</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_CREDITOPROMOTORES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_CREDITOPROMOTORES)?"active":""?>"><a href="<?php echo URL_BASE . "admincreditopromotores";?>">Cr&eacute;dito Promotores</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_CATEGORIZARCLIENTES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_CATEGORIZARCLIENTES)?"active":""?>"><a href="<?php echo URL_BASE . "admintiporangoclientes";?>">Categorizar Clientes</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINNISTRACION_APORTACIONESMENDEZ)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINNISTRACION_APORTACIONESMENDEZ)?"active":""?>"><a href="<?php echo URL_BASE . "aportacionesmendez";?>">Aportaciones Mendez</a></li>
						<?php endif;?>





						<!-- Monitores -->
						<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_DASHBOARDS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_ADMINISTRACION_DASHBOARDS)?"active":""?>">
								<a href="#"><i class="fa fa-dashboard"></i> <span class="nav-label">Monitores</span><span
									class="fa arrow"></span></a>
								<ul class="nav nav-third-level collapse">
									<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_DASHBOARDS_MONITORESTATUS)):?>
										<li class="<?php echo $_oLugar->isTercero(LUGAR_ADMINISTRACION_DASHBOARDS_MONITORESTATUS)?"active":""?>"><a href="<?php echo URL_BASE . "dash2";?>">Estatus Pedidos</a></li>
									<?php endif;?>
									<?php if ($_oLugar->lugarVisible(LUGAR_ADMINISTRACION_DASHBOARDS_MONITOREXISTENCIAS)):?>
										<li class="<?php echo $_oLugar->isTercero(LUGAR_ADMINISTRACION_DASHBOARDS_MONITOREXISTENCIAS)?"active":""?>"><a href="<?php echo URL_BASE . "adminexistencias";?>">Existencias</a></li>
									<?php endif;?>
								</ul>
							</li>
						<?php endif;?>

					</ul>
				</li>
			<?php endif;?>

			<!-- Promotor -->
			<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR)):?>

				<li class="<?php echo $_oLugar->isPrimero(LUGAR_PROMOTOR)?"active":""?>">
					<a href="#"><i class="fa fa-angellist"></i> <span class="nav-label">Promotores</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">

						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_AUTORIZAPEDIDOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_AUTORIZAPEDIDOS)?"active":""?>"><a href="<?php echo URL_BASE . "prompedxauth";?>">Autorizar Pedidos</a></li>
						<?php endif;?>
						
						<?php if (false && $_oLugar->lugarVisible(LUGAR_PROMOTOR_PERMITEVALESALIDA)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_PERMITEVALESALIDA)?"active":""?>"><a href="<?php echo URL_BASE . "prompedpermitirvale";?>">Permitir Imprimir Vales Salida</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_VALESALIDA)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_VALESALIDA)?"active":""?>"><a href="<?php echo URL_BASE . "promgeneravale";?>">Vales Salida</a></li>
						<?php endif;?>
						
						

						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_PEDIDOSCLIENTES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_PEDIDOSCLIENTES)?"active":""?>"><a href="<?php echo URL_BASE . "promoclientepedidos";?>">Pedidos Mis Clientes</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_PEDIDOSPROMOTOR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_PEDIDOSPROMOTOR)?"active":""?>"><a href="<?php echo URL_BASE . "cxcpromotorpedidos";?>">Mis Pedidos (CxC)</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_MOVTOSCXCPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_MOVTOSCXCPEDIDO)?"active":""?>"><a href="<?php echo URL_BASE . "promomovscxcpedido";?>">Movs. CxC Pedido</a></li>
						<?php endif;?>

						<?php if (false && $_oLugar->lugarVisible(LUGAR_PROMOTOR_PEDIDOSAFACTURAR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_PEDIDOSAFACTURAR)?"active":""?>"><a href="<?php echo URL_BASE . "promopedidoafacturar";?>">Pedidos a Facturar</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_PEDIDOSAFACTURAR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_PEDIDOSAFACTURAR)?"active":""?>"><a href="<?php echo URL_BASE . "promopedidoafacturar";?>">Solicitar Factura de Pedido</a></li>
						<?php endif;?>
						
						

						<?php if ($_oLugar->lugarVisible(LUGAR_PROMOTOR_DASHBOARDPEDIDOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PROMOTOR_DASHBOARDPEDIDOS)?"active":""?>"><a href="<?php echo URL_BASE . "promodashboardpedidos";?>">Dashboard Mis Pedidos</a></li>							
						<?php endif;?>


					</ul>
				</li>
			<?php endif;?>


			<!-- Cat�logos -->
			<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_CATALOGOS)?"active":""?>">
					<a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Cat&aacute;logos</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS_MATERIAL)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CATALOGOS_MATERIAL)?"active":""?>"><a href="<?php echo URL_BASE . "material";?>">Materiales</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS_PROVEEDOR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CATALOGOS_PROVEEDOR)?"active":""?>"><a href="<?php echo URL_BASE . "proveedor";?>">Proveedores</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS_TIPOPRODUCTO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CATALOGOS_TIPOPRODUCTO)?"active":""?>"><a href="<?php echo URL_BASE . "tipoproducto";?>">Tipos Producto</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS_APLICACION)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CATALOGOS_APLICACION)?"active":""?>"><a href="<?php echo URL_BASE . "aplicacion";?>">Aplicaciones</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS_CLIENTE)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CATALOGOS_CLIENTE)?"active":""?>"><a href="<?php echo URL_BASE . "cliente";?>">Clientes</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_CATALOGOS_REGIMENFISCAL)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CATALOGOS_REGIMENFISCAL)?"active":""?>"><a href="<?php echo URL_BASE . "regimenfiscal";?>">Regimen Fiscal</a></li>
						<?php endif;?>
					</ul>
				</li>
			<?php endif;?>

			<!-- CXC -->
			<?php if ($_oLugar->lugarVisible(LUGAR_CXC)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_CXC)?"active":""?>">
					<a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">CxC</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_PEDIDOSCLIENTES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_PEDIDOSCLIENTES)?"active":""?>"><a href="<?php echo URL_BASE . "cxcclientepedidos";?>">Pedidos x Cliente</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_PEDIDOSPROMOTOR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_PEDIDOSPROMOTOR)?"active":""?>"><a href="<?php echo URL_BASE . "cxcpromotorpedidos";?>">Pedidos x Promotor</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_ABONOPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_ABONOPEDIDO)?"active":""?>"> <a href="<?php echo URL_BASE . "cxcabonopedido";?>">Abonar a Pedido</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_ABONOXRECIBODINERO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_ABONOXRECIBODINERO)?"active":""?>"> <a href="<?php echo URL_BASE . "cxcabonorecibodinero";?>">Abonar x Recibo Dinero</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_RECIBODINERO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_RECIBODINERO)?"active":""?>"><a href="<?php echo URL_BASE . "anticipocliente";?>">Recibo dinero</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_RPTMOVRECIBODINERO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_RPTMOVRECIBODINERO)?"active":""?>"><a href="<?php echo URL_BASE . "rptmovrecibodinero";?>">Reporte Mov. Recibo Dinero</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_CANCELARPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_CANCELARPEDIDO)?"active":""?>"><a href="<?php echo URL_BASE . "cancelarpedido";?>">Cancelar Pedido</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_PROMOCOMISIONES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_PROMOCOMISIONES)?"active":""?>"><a href="<?php echo URL_BASE . "cxccomisionespromotor";?>">Comisiones Promotor</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_COMISIONESANTICIPADAS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_COMISIONESANTICIPADAS)?"active":""?>"><a href="<?php echo URL_BASE . "cxccomisionesanticipadas";?>">Comisiones Anticipadas</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_DASHAUTORIZACIONES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_DASHAUTORIZACIONES)?"active":""?>"><a href="<?php echo URL_BASE . "cxcdashpedido";?>">Dashboard Autorizaciones</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_DASHTRACKING)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_DASHTRACKING)?"active":""?>"><a href="<?php echo URL_BASE . "cxcdashtrackingpedido";?>">Dashboard Tracking Pedidos</a></li>
						<?php endif;?>

						
						
						
						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_PEDIDOSACEPTAFACTURAR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_PEDIDOSACEPTAFACTURAR)?"active":""?>"><a href="<?php echo URL_BASE . "promopedidoaceptafacturar";?>">Asignar Factura a Pedido</a></li>
						<?php endif;?>

						

						<?php if ($_oLugar->lugarVisible(LUGAR_CXC_CORTECAJA)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CXC_CORTECAJA)?"active":""?>"><a href="<?php echo URL_BASE . "cortecaja";?>">Corte Caja</a></li>
						<?php endif;?>

						
					</ul>
				</li>
			<?php endif;?>

			<!-- Gastos -->
			<?php if ($_oLugar->lugarVisible(LUGAR_GASTOS)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_GASTOS)?"active":""?>">
					<a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">Gastos</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_GASTOS_GASTOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_GASTOS_GASTOS)?"active":""?>"><a href="<?php echo URL_BASE . "gastos";?>">Gastos</a></li>
						<?php endif;?>
					

					</ul>
				</li>
			<?php endif;?>

			<!-- Productos -->
			<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_PRODUCTOS)?"active":""?>">
					<a href="#"><i class="fa fa-barcode"></i> <span class="nav-label">Productos</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_ROLLO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_ROLLO)?"active":""?>"><a href="<?php echo URL_BASE . "rollo";?>">Rollos</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_PRODUCTO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_PRODUCTO)?"active":""?>"><a href="<?php echo URL_BASE . "producto";?>">Articulos</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_ROLLOSTRASPASOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_ROLLOSTRASPASOS)?"active":""?>"><a href="<?php echo URL_BASE . "rollotraspaso";?>">Traspaso de Rollos</a></li>
						<?php endif;?>


						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_LISTADOTRANSFERENCIAS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_LISTADOTRANSFERENCIAS)?"active":""?>"><a href="<?php echo URL_BASE . "transferenciaslistado";?>">Transferencias Rollos</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_TRANSFERENCIAROLLOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_TRANSFERENCIAROLLOS)?"active":""?>"><a href="<?php echo URL_BASE . "transferenciasrollos";?>">Transferir Rollos entre Almac&eacute;nes</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_LISTADOTRANSFERENCIASSTOCK )):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_LISTADOTRANSFERENCIASSTOCK)?"active":""?>"><a href="<?php echo URL_BASE . "transferenciasstocklistado";?>">Transferencias Stock</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCTOS_TRANSFERENCIASTOCK )):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCTOS_TRANSFERENCIASTOCK)?"active":""?>"><a href="<?php echo URL_BASE . "transferenciasstock";?>">Transferir Stock entre Sucursales</a></li>
						<?php endif;?>

						<!-- Precios -->
						<?php if (false && $_oLugar->lugarVisible(LUGAR_PRECIOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRECIOS)?"active":""?>">
								<a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">Precios</span><span
									class="fa arrow"></span></a>
								<ul class="nav nav-third-level collapse">
									<?php if ($_oLugar->lugarVisible(LUGAR_PRECIOS_IMPORTADOS)):?>
										<li class="<?php echo $_oLugar->isTercero(LUGAR_PRECIOS_IMPORTADOS)?"active":""?>"><a href="<?php echo URL_BASE . "precioimportados";?>">Importados</a></li>
									<?php endif;?>
									<?php if ($_oLugar->lugarVisible(LUGAR_PRECIOS_TERNIUM)):?>
										<li class="<?php echo $_oLugar->isTercero(LUGAR_PRECIOS_TERNIUM)?"active":""?>"><a href="<?php echo URL_BASE . "precioternium";?>">Ternium</a></li>
									<?php endif;?>
								</ul>
							</li>
						<?php endif;?>
					</ul>
				</li>
			<?php endif;?>

			<!-- Precios -->
			<?php if ($_oLugar->lugarVisible(LUGAR_PRECIOS) && false):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_PRECIOS)?"active":""?>">
					<a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">Precios</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_PRECIOS_IMPORTADOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRECIOS_IMPORTADOS)?"active":""?>"><a href="<?php echo URL_BASE . "precioimportados";?>">Importados</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_PRECIOS_TERNIUM)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRECIOS_TERNIUM)?"active":""?>"><a href="<?php echo URL_BASE . "precioternium";?>">Ternium</a></li>
						<?php endif;?>
					</ul>
				</li>
			<?php endif;?>

			<!-- Pedidos -->
			<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_VENTAS)?"active":""?>">
					<a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Pedidos</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_LISTADOPEDIDOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_LISTADOPEDIDOS)?"active":""?>"><a href="<?php echo URL_BASE . "pedido";?>">Pedidos</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_NUEVOPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_NUEVOPEDIDO)?"active":""?>"><a href="<?php echo URL_BASE . "pedidonuevo";?>">Capturar Cotizaci&oacute;n / Pedido</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_DASHBOARDPEDIDOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_DASHBOARDPEDIDOS)?"active":""?>"><a href="<?php echo URL_BASE . "proddashboardpedidos";?>">Dashboard Pedidos</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_LISTADOCOTIZACION)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_LISTADOCOTIZACION)?"active":""?>"><a href="<?php echo URL_BASE . "cotizacion";?>">Cotizaciones</a></li>
						<?php endif;?>
						<?php if (false && $_oLugar->lugarVisible(LUGAR_VENTAS_NUEVACOTIZACION)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_NUEVACOTIZACION)?"active":""?>"><a href="<?php echo URL_BASE . "cotizacionnueva";?>">Capturar Cotizaci&oacuten</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_FECHACOMPROMISO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_FECHACOMPROMISO)?"active":""?>"><a href="<?php echo URL_BASE . "promopedidofechacompromiso";?>">Fecha Entrega Pedido</a></li>
						<?php endif;?>
						
						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_ASIGNARPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_ASIGNARPEDIDO)?"active":""?>"><a href="<?php echo URL_BASE . "colocarpedido";?>">Asignar Pedidos</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_VENTAS_FACTURASFILES)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_VENTAS_FACTURASFILES)?"active":""?>"><a href="<?php echo URL_BASE . "pedidoaddfactura";?>">Facturas de Pedidos</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PEDIDO_PEDIDOSPORENTREGAR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PEDIDO_PEDIDOSPORENTREGAR)?"active":""?>"><a href="<?php echo URL_BASE . "pedidoproximoaentrega";?>">Pedidos x Entregar</a></li>
							 </a>
						<?php endif;?>



					</ul>
				</li>
			<?php endif;?>

			<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_PRODUCCION)?"active":""?>">
					<a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Producci&oacute;n</span><span
						class="fa arrow"></span>  </a>
					<ul class="nav nav-second-level collapse">

						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION_PEDIDOSPRODUCCION)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCCION_PEDIDOSPRODUCCION)?"active":""?>"><a href="<?php echo URL_BASE . "prodpedido";?>">Pedidos Producci&oacute;n</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION_REGISTROPRODUCCION) ):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCCION_REGISTROPRODUCCION)?"active":""?>"><a href="<?php echo URL_BASE . "registroproduccionsucursal";?>">Registro Producci&oacute;n </a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION_DESPACHARPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCCION_DESPACHARPEDIDO)?"active":""?>"><a href="<?php echo URL_BASE . "despacharpedidosucursal";?>">Surtir Pedido </a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION_DESPACHARPEDIDO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCCION_DESPACHARPEDIDOOBRA)?"active":""?>"><a href="<?php echo URL_BASE . "pedidoobra";?>">Surtir Pedido Obra </a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION_VALESALIDAGENERAR)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCCION_VALESALIDAGENERAR)?"active":""?>"><a href="<?php echo URL_BASE . "valesalidagenerarsucursal";?>">Vales de Salida </a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_PRODUCCION_PEDIDOOTROSCARGOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_PRODUCCION_PEDIDOOTROSCARGOS)?"active":""?>"><a href="<?php echo URL_BASE . "pedidootroscargos";?>">Pedido Otros Cargos </a></li>
						<?php endif;?>
						
						



						<?php if (Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$idROOTUSER)):?>
							<li class=""><a href="<?php echo URL_BASE . "reportenorollos";?>" target="_blank">Reporte # Rollos</a></li>
							<li class=""><a href="<?php echo URL_BASE . "reportenorollosxrollo";?>" target="_blank">Reporte # Rollos X Rollo</a></li>
							<li class=""><a href="<?php echo URL_BASE . "reportenorollosalmacen";?>" target="_blank">Reporte # Rollos X Almacen</a></li>

						<?php endif;?>

					</ul>
				</li>
			<?php endif;?>

			<!-- RUTAS -->
			<?php if ($_oLugar->lugarVisible(LUGAR_RUTAS)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_RUTAS)?"active":""?>">
					<a href="#"><i class="fa fa-map-marker"></i> <span class="nav-label">Rutas</span><span
						class="fa arrow"></span> <span class="label label-info pull-right">NUEVO</span> </a>
					<ul class="nav nav-second-level collapse">

						<?php if ($_oLugar->lugarVisible(LUGAR_RUTAS_VEHICULOS)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_RUTAS_VEHICULOS)?"active":""?>"><a href="<?php echo URL_BASE . "vehiculo";?>">Vehiculos</a></li>
						<?php endif;?>

						<?php if ($_oLugar->lugarVisible(LUGAR_RUTAS_RUTAS) ):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_RUTAS_RUTAS)?"active":""?>"><a href="<?php echo URL_BASE . "ruta";?>">Zonas</a></li>
						<?php endif;?>
						<?php if ($_oLugar->lugarVisible(LUGAR_RUTAS_RUTASENVIO)):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_RUTAS_RUTASENVIO)?"active":""?>"><a href="<?php echo URL_BASE . "asignarruta";?>">Asignar Rutas</a></li>
						<?php endif;?>
						

					</ul>
				</li>
			<?php endif;?>

			<!-- Reportes -->
			<li class="<?php echo $_lugar == LUGAR_REPORTES ?"active":""?>"><a
				href="<?php echo URL_BASE . "rptmanager";?>"><i class="fa fa-pie-chart"></i><span class="nav-label">
						Reportes</span></a></li>



			<?php if ($_oLugar->lugarVisible(LUGAR_REPORTES) && false):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_REPORTES)?"active":""?>">
					<a href="#"><i class="fa fa-pie-chart"></i> <span class="nav-label">Reportes</span><span
						class="fa arrow"></span></a>
<!-- 					<ul class="nav nav-second-level collapse"> -->
						<?php if ($_oLugar->lugarVisible(LUGAR_REPORTES_INGRESOROLLOS) && false):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_REPORTES_INGRESOROLLOS)?"active":""?>"><a href="<?php echo URL_BASE . "rollo";?>">Recepci&oacute;n Rollos</a></li>
						<?php endif;?>


<!-- 					</ul> -->
				</li>
			<?php endif;?>

			<?php if ($_oLugar->lugarVisible(LUGAR_CONSULTAS)):?>
				<li class="<?php echo $_oLugar->isPrimero(LUGAR_CONSULTAS)?"active":""?>">
					<a href="#"><i class="fa fa-eye"></i> <span class="nav-label">Consultas</span><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<?php if ($_oLugar->lugarVisible(LUGAR_CONSULTAS_NOROLLO) ):?>
							<li class="<?php echo $_oLugar->isSegundo(LUGAR_CONSULTAS_NOROLLO)?"active":""?>"><a href="<?php echo URL_BASE . "connorollo";?>"># de Rollo</a></li>
						<?php endif;?>


					</ul>
				</li>
			<?php endif;?>

			<li class="<?php echo $_lugar == LUGAR_PERFIL ?"active":""?>"><a
				href="<?php echo URL_BASE . "miperfil";?>"><i class="fa fa-user"></i><span class="nav-label">
						Perfil</span></a></li>





		</ul>

	</div>
</nav>
