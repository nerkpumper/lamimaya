
<?php
$_lugar = LUGAR_HOME;
$titlePage = "Inicio";
$_showPageHeading = false;


// echo "hola index";

// global $dbLink;

// 	$objSession=new ModeloUsuario($dbLink);
// 	$objSession->setIdUsuario(3);

// 	$objSession->dumpObj();

// 	$_SESSION['_lmobjSession']=serialize($objSession);
$_addStyle = "<style>
		.btn-file {
	        position: relative;
	        overflow: hidden;
	    }
	    .btn-file input[type=file] {
	        position: absolute;
	        top: 0;
	        right: 0;
	        min-width: 100%;
	        min-height: 100%;
	        font-size: 100px;
	        text-align: right;
	        filter: alpha(opacity=0);
	        opacity: 0;
	        outline: none;
	        background: white;
	        cursor: inherit;
	        display: block;
	    }
	</style>	";
$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/slick/slick.css' rel='stylesheet'>
			<link href='".URL_BASE."assets/inspinia/css/plugins/slick/slick-theme.css' rel='stylesheet'>
			<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
        <link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/clockpicker/clockpicker.css' rel='stylesheet'> 	
 		";

$_addScript = "

		<script src=\"".URL_BASE."assets/inspinia/js/plugins/slick/slick.min.js\"></script>
		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
        <script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>
		

		";

// $_addScript .= " <script type=\"text/javascript\">saInfo(\"Promotor... Se ha agregado un Reporte para que consultes Tus Comisiones.\"); </script>";



//  ------------------------VENTAS----------------------------

?>

<?php if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_CXCVIEW)): ?>


<div class="wrapper wrapper-content">
<?php else: ?>

	<div class="row">
		<div class="col-lg-4">
			<div class="widget-head-color-box navy-bg p-lg text-center">
				<div class="m-b-md">
					<h2 class="font-bold no-margins"><?php if(isset($objSession)) echo $objSession->getFullName()?></h2>
					<small><?php

							        echo ModeloUsuario::getRol()->getNombre();


							        ?></small>
				</div>
				<img src="<?php
									if (file_exists ("img/" . ModeloUsuario::getObjSession ()->getIdUsuario () . ".jpg" )) {
										echo  "img/" . ModeloUsuario::getObjSession ()->getIdUsuario () . ".jpg";
									} else {
										echo 'img/noimage.png';
									}

									?>" class="img-circle circle-border m-b-md" style="width: 128px; height: 128px;"
					alt="profile">
	<!-- 			<div> -->
	<!-- 				<span>100 Tweets</span> | <span>350 Following</span> | <span>610 -->
	<!-- 					Followers</span> -->
	<!-- 			</div> -->
			</div>
			<div class="widget-text-box">
				<h4 class="media-heading"><?php if(isset($objSession)) echo $objSession->getFullName()?></h4>
				<p>Bienvenido al Sistema Galvamex</p>
				<div class="text-right">
	<!-- 				<a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like -->
	<!-- 				</a> -->
					 <a class="btn btn-xs btn-primary" href="<?php echo URL_BASE;?>miperfil"><i class="fa fa-pencil"></i>
						</a>
				</div>
			</div>
		</div>

	</div>
<?php endif;?>


 <?php if (Permisos::userIsThisRol(Permisos::$rol_ROOT) ||
			Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) ): ?>
<div class="wrapper wrapper-content">
 
 	<h3 class="text-center m">Venta del dia</h3>
   
	 <div class="row">
        <div class="col-lg-9">
			<div class="col-lg-3" v-for="(mov, index) in movimientos">
				<div class="ibox ">
					<div class="ibox-title">
						<span class="label label-success float-right">{{ mov.usuarioCaptura }}</span>		
					</div>
					<div class="ibox-content">
						<h3 class="no-margins">${{ formatNumber(mov.pedidoTotal) }}</h3>
						<div class="stat-percent font-bold text-success">{{ formatNumber(mov.porcentaje*100) }}%</div>
						<small>Total</small>
					</div>
				</div>
			</div>
		</div>    
        <div class="col-lg-3">
			<div class="ibox ">
                <div class="ibox-title" >
                        <h3 class="no-margins label label-primary float-right">Total Dia</h3>
				</div>
				
                <div class="ibox-content"  >
                    <div class="row">

							<h1   class="no-margins">$ {{ formatNumber(totalDia) }}</h1>
						</div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>	
<div class="row">
    <div class="col-lg-12">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
				<div id="grPedidosExplotadosPie" ></div>		
		</div>
		<div class="col-lg-6" >
				<div class="ibox " >
					<div class="ibox-title" >
						<span ><strong>Venta acumulada por Promotor año actual</strong></span>		
					</div>
					<div class="ibox-content" >
					<table class="table">
					<thead>
					<tr>
					<th scope="col">N°</th>
					<th scope="col">Promotor</th>

					<th scope="col">Total</th>
					</tr>
					</thead>
					<tbody v-for="(acumulado, index) in acumuladoPromotor">
					<tr>
					<td>{{acumulado.posicion}}</td>	
					<td>{{acumulado.usuarioCaptura}}</td>
					<td scope="row">${{formatNumber(acumulado.total)}}</td>
					</tr>
					</tbody>
					</table>	
				</div>
			</div>			
		</div>			
	</div>
</div>
<hr>

<div class="row">
	<div class="col-lg-12">
		<?php 
		$anioActual = date("Y");
		?>

		<form method="get" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">Seleccione A&ntilde;o</label>
			
				<div class="col-sm-2">
					<select v-model="year" class="form-control m-b" name="account">
						<option value="<?php echo $anioActual; ?>" select><?php echo $anioActual?></option>
						<?php 
						
						for($anio = $anioActual - 1 ; $anio >=2018 ; $anio --)
						{
							echo "<option value=\"". $anio."\" >".$anio."</option>";
						}
						?>
					</select>
				</div>
			<div class="col-sm-2"> 
				<button @click.prevent="cargarVentasAnuales" class="btn btn-primary" >Obtener informaci&oacute;n</button> </div>
			</div>
		</form>
		<div class="ibox-content m-b-sm border-bottom">
			<div v-show="showAnio" id="chartAnio" style="min-width: 310px; height: 470px; margin: 0 auto"></div>
		</div>	
	</div>
</div>	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
			<div class="ibox " >
				<div class="ibox-title" >
						<span ><strong>Pedidos del Dia</strong></span>		
				</div>
				<div class="ibox-content" >
					<table class="table">
				<thead>
					<tr>
					<th scope="col">Pedido</th>
					<th scope="col">Promotor</th>
					<th scope="col">Cliente</th> 
					<th scope="col">Hora</th>
					<th scope="col">Estado</th>
					<th scope="col">Total</th>
					</tr>
				</thead>
				<tbody v-for="(pedidos, index) in pedidosDelDia"  >
					<tr>
					<td scope="row">{{pedidos.idPedido}}</td>
					<td>{{pedidos.usuarioCaptura}}</td>
					<td>{{pedidos.cliente}}</td> 
					<td>{{pedidos.hora_captura}}</td>
					<td class=' text-success'>{{pedidos.estado}}</td>
					<td scope="row">${{formatNumber(pedidos.total)}}</td>
					</tr>
				</tbody>
				</table>	
			</div>
		</div>			
	</div>
</div>	
<?php endif;?>
	


<!------------------------ PRODUCCION ------------------------>

<?php if (Permisos::userIsThisRol(Permisos::$rol_ROOT) ||
			Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) ||
			Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) ||
			Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) ||
			Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION)): ?>


<div class="wrapper wrapper-content">
	<div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Selecciona Sucursal</h5>                
    	</div>
        <div class="ibox-content">
            <div class="row">
            	<div  class="col-lg-6" >
					<select class="form-control" v-model="idSucursalSeleccionada">
						<option value="0">--Seleccione Sucursal--</option>
						<option v-for="s in lstSucursales" :value="s.idSucursal">{{ s.nombre }}</option>
					</select>                 
                </div>  
				<div  class="col-sm-6">
					<button  @click.prevent="cargarProduccionSucursal" class="btn btn-primary">Consultar</button>
				</div>
				<hr>
			</div>
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" >
					<div class="ibox " >
						<div class="ibox-title" >
							<span ><strong>Produccion Acanalado Mensual - Sucursal {{ nombreSucursal  }} </strong></span>		
						</div>
						<div class="ibox-content" >
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Mes</th>
										<th scope="col">R-101</th>
										<th scope="col">RN-100</th> 
										<th scope="col">OG-100</th>
										<th scope="col">LOSACERO</th>
										<th scope="col">R-72</th>
										<th scope="col">TOTAL</th>
									</tr>
								</thead>
								<tbody v-for="(lst, index) in produccionAcanalado"  >
									<tr>
										<td scope="row">{{lst.mesDes}}</td>
										<td>{{lst.R_101}}</td>
										<td>{{lst.RN_100}}</td> 
										<td>{{lst.OG_100}}</td>
										<td>{{lst.LOSACERO}}</td>
										<td >{{lst.R_72}}</td>
										<td >{{lst.KR_18}}</td>
										<td >{{lst.GALVATEJA}}</td>
										<td class=' text-success'><b>{{formatNumber(parseInt(lst.R_72)+parseInt(lst.R_101)+parseInt(lst.RN_100)+parseInt(lst.LOSACERO)+parseInt(lst.OG_100)+parseInt(lst.KR_18)+parseInt(lst.GALVATEJA))}}</b></td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
				</div>	
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" >
					<div class="ibox " >
						<div class="ibox-title" >
							<span ><strong>Produccion Moldura Mensual - Sucursal {{ nombreSucursal }}</strong></span>		
						</div>
					<div class="ibox-content" >
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Mes</th>
									<th scope="col">Cantidad</th>
									<th scope="col">Total ml</th> 
									<th scope="col">Total dobleces</th>
								</tr>
							</thead>
							<tbody v-for="(lstmoldura, index) in produccionMoldura">
								<tr>
									<td scope="row"><b>{{lstmoldura.mes}}</b></td>
									<td>{{lstmoldura.cant}}</td>
									<td>{{lstmoldura.totalml}}</td>
									<td class=' text-success'><b>{{lstmoldura.totaldobl}}</b></td>
								</tr>
							</tbody>
						</table>	
					</div>
				</div>	
			</div>
        </div>       
    </div>    	
</div>						
<?php endif;?>

<?php if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR)  ): ?>

	<div class="ibox">
    	<div class="ibox-title">
    		Accesos directos 
    	</div>    	
		<div class="ibox-content">
			
			<div class="row">
        		<div class="col-lg-4 text-center">
        			<a class="btn btn-primary" href="<?php echo URL_BASE; ?>pedidonuevo" >pedidonuevo</a>
        		</div>
        		<div class="col-lg-4 text-center">
        			<a class="btn btn-primary" href="<?php echo URL_BASE; ?>ro" >Registro de Producci&oacute;n</a>
        		</div>
        		<div class="col-lg-4 text-center">
        			<a class="btn btn-primary" href="<?php echo URL_BASE; ?>valesalidagenerar" >Vales de Salida</a>
        		</div>
        	
        	</div>
    	</div>
		
    	
    	
    </div>
	


<?php endif;?>



<!-- Actualizar fecha compromiso -->
<div class="modal inmodal fade" id="modalUpdateFechaCompromiso" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique Fecha de Entrega</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							<label class="control-label">Fecha Entrega</label>
				                                <div class="input-group date">
				                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                    <input v-modal="fechaEntrega" id="dtFechaEntrega" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>
				                                    ">
				                                    
				                                </div>
							<label v-show="errFechaEntrega" class="text-danger">{{ errFechaEntrega }}</label>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="updateFechaCompromiso" class="btn btn-success"> Asignar Fecha de Entrega</button>
					</div>
					
					<div class="clearfix"></div>
				
				</div>
				
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>				
			</div>
		</div>
	</div>
</div>

<!-- Rechazo cotizacion -->
<div class="modal inmodal fade" id="modalRechazoCotizacion" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique motivo rechazo</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div  class="col-lg-12" >
							<select class="form-control" v-model="idMotivoSeleccionado">
								<option value="0">--Seleccione Motivo--</option>
								<option v-for="motivo in lstMotivoRechazo" :value="motivo.idMotivoRechazo">{{ motivo.motivo }}</option>
							</select>                 
						</div>  
							<label v-show="errMotivoRechazo" class="text-danger">{{ errMotivoRechazo }}</label>
							<hr>
						<div v-show='idMotivoSeleccionado != 10 || idMotivoSeleccionado != 10 ' class="col-lg-12" >
							<label  class='text-primary'> {{motivoRechazoDescripcion }} </label>
						</div>
						<div v-show='idMotivoSeleccionado == 10 ' class="col-lg-12" >
							<label>Ingrese motivo de rechazo</label>
							<textarea   cols="64" rows="10" v-model ='motivoRechazoDescripcion' > {{motivoRechazoDescripcion }} </textarea>
						</div>
						<!-- 					
						<div v-show='idMotivoSeleccionado == 1'>
							<form id="frmBuscarFoto" class="form-horizontal" method="post" enctype="multipart/form-data">
								<div>
									<div class="row">
										<div class="col-md-10">
											<div class="input-group">
												<span class="input-group-btn"> <span class="btn btn-primary btn-file"> Buscar<input
															type="file" id="" name="" multiple="multiple">
													</span>
												</span> <input id="filename" name="filename" type="text" class="form-control"
													placeholder="Archivo..." disabled>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div> -->
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="guardarMotivoRechazoCotizacion()" v-on:click.prevent="uploadFile" class="btn btn-success"> Guardar</button>
					</div>
					
					<div class="clearfix"></div>
				
				</div>
				
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>				
			</div>
		</div>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<span>listados de pedidos próximo a entrega</span>
				<div style="overflow-x:auto;">
					<div id="listadoPedidos">
					<table class='footable table table-stripped toggle-arrow-tiny' data-page-size='50'>
						<thead>
								<tr>		
									<th>Pedido</th>
									<th >Cliente</th>
									<th >Total</th>
									<th >Fecha Captura</th>
									<th >Estatus</th>
									<th >Fecha Entrega</th>
									<th class='text-left'>Acci&oacute;n</th>
								</tr>
						</thead>
						<tbody v-for="(lstPedidosPorVencer, index) in pedidosPorVencer">
							<tr>
								<td> <b>{{lstPedidosPorVencer.idPedido}}</b></td>
								<td>{{lstPedidosPorVencer.cliente}}</td>
								<td>${{lstPedidosPorVencer.total}}</td>
								<td>{{lstPedidosPorVencer.fecha_capturado}}</td>
								<td v-show="lstPedidosPorVencer.estado == 'AUTORIZADO'"> <p><span class='text-info'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td v-show="lstPedidosPorVencer.estado == 'CAPTURADO'"> <p><span class='text-succes'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td v-show="lstPedidosPorVencer.estado == 'PRODUCCION'"> <p><span class='text-warning'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td v-show="lstPedidosPorVencer.estado == 'TERMINADO'"> <p><span class='text-danger'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td><b>{{lstPedidosPorVencer.fechaCompromiso}}</b></td>
								<td class='text-left'>
									<a class='btn btn-info btn-xs' v-bind:href="'pedidodetalleview/' + lstPedidosPorVencer.idPedido" alt='Ver detalle' target='_blank'><span class='fa fa-eye'></span></a>
									<button class='btn btn-primary btn-xs' @click.prevent="modalUpdateFechaCompromiso(lstPedidosPorVencer.idPedido)" ><i class='fa fa-calendar'></i> Fecha de Entrega</button>
								</td>
								
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<td colspan='7'>
								<ul class='pagination pull-right'></ul>
								</td>
							</tr>
						</tfoot>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<span>Listados de cotizaciones activas</span>
				<div style="overflow-x:auto;">
					<div id="listadoPedidos">
					<table class='footable table table-stripped toggle-arrow-tiny' data-page-size='50'>
						<thead>
								<tr>		
									<th>Cotizacion</th>
									<th data-hide='phone'>Cliente</th>
									<th data-hide='phone'>Total</th>
									<th data-hide='phone'>Fecha Captura</th>
									<th data-hide='phone'>Estatus</th>
									<th class='text-left'>Acci&oacute;n</th>
									</tr>
						</thead>
						<tbody v-for="(lstPedidos, index) in lstCotizacion">
							<tr>
								<td> <b>{{lstPedidos.idCotizacion}}</b></td>
								<td>{{lstPedidos.cliente}}</td>
								<td>${{lstPedidos.total}}</td>
								<td>{{lstPedidos.fecha_capturado}}</td>
								<td v-show="lstPedidos.estado == 'AUTORIZADO'"> <p><span class='text-info'>{{lstPedidos.estado}}</span></p></td>
								<td v-show="lstPedidos.estado == 'CAPTURADO'"> <p><span class='text-succes'>{{lstPedidos.estado}}</span></p></td>
								<td v-show="lstPedidos.estado == 'PRODUCCION'"> <p><span class='text-warning'>{{lstPedidos.estado}}</span></p></td>
								<td v-show="lstPedidos.estado == 'TERMINADO'"> <p><span class='text-danger'>{{lstPedidos.estado}}</span></p></td>
								<td class='text-left'>
									<a class='btn btn-info btn-xs' v-bind:href="'cotizacionpdf?id=' + lstPedidos.idCotizacion" alt='Ver detalle' target='_blank'><span class='fa fa-eye'></span></a>
									<button class='btn btn-danger btn-xs' @click.prevent="modalRechazoCotizacion(lstPedidos.idCotizacion)" ><i class='fa fa-remove'></i> Rechazada</button>
								</td>
								
								
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<td colspan='7'>
								<ul class='pagination pull-right'></ul>
								</td>
							</tr>
						</tfoot>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>

	
</div>	

	




<!-- ------------------PROMOTORES -------------------->

<?php if (false && Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) ): ?>

	


</div>
	
<?php endif; ?>
<br><br>

<?php if (Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR)): ?>

	<div class="row">
		<div class="col-lg-6 text-center">
			<a href="http://nerkpumper.com/zentao/www/index.php?m=project&f=task&projectID=1" target="_blank" class="btn btn-primary btn-lg"> Solicitar Modificaci&oacute;n, Nuevo Modulo al equipo de Desarrollo</a>
		</div>
		<div class="col-lg-6 text-center">
			<a href="http://nerkpumper.com/zentao/www/index.php?m=project&f=bug&projectID=1" target="_blank" class="btn btn-warning btn-lg"> Reportar Bug (error) al equipo de Desarrollo</a>

		
		</div>
	
	</div>
	
	


<?php endif;?>

<!-- ------------------------------COBRANZA -------------------------------->

<?php if (false && Permisos::userIsThisRol(Permisos::$rol_ROOT) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) ||  Permisos::userIsThisRol(Permisos::$rol_PRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPLUSPRODUCCION) || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION) ): ?>

<div class="wrapper wrapper-content">


</div>

<?php endif;?>





