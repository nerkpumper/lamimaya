<?php
$titlePage = "Descuentos a Clientes";
$breadCum = "Descuentos/Pedidos Cliente";
 $_lugar = LUGAR_ADMINISTRACION_DESCTOSCTES;

?>


<!-- Buscar Cliente -->
<div v-show="seleccionandoCliente">

	<div v-show="idCliente > 0" >
		<button @click.prevent="dejarCliente" class="btn btn-warning">Conservar este Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">

				<div class="profile-image">
					<img src="<?php echo URL_BASE;?>img/noimage.png"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ nombre }}</h2>
							<h4>{{ empresa }}</h4>
							<small> {{ domicilio1}} {{ domicilio2 }} </small> <br> <small> {{ telefonos }} </small>
						</div>
					</div>
				</div>
			</div>			

		</div>
	</div>


	<div class="panel-rec">
		<h3>Seleccione Cliente</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombreCliente"	 		
		 		placeholder="filtrar">
			</div>			
		</div>
		
		<br>
		
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<th>Cliente</th>
					<th>Empresa</th>
					<th></th>
					<th>Correo</th>
					<th></th>
					<th>Telefonos</th>
					<th></th>
				</thead>
				<tbody>
					<tr v-for="(cli, index) in clientesFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td>
						<td>{{ cli.empresa }}</td>
						<td class="contact-type">
							<i v-show="cli.email" class="fa fa-envelope"></i>
						</td>
						<td>{{ cli.email }}</td>
						<td class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></td>
						<td>{{ cli.telefonos }}</td>
						<td class="client-status"><button @click.prevent="seleccionarCliente(cli.idCliente)" class="btn btn-primary btn-xs">Seleccionar</button></td>
					</tr>					
<!-- 					<tr> -->
<!-- <!-- 						<td class="client-avatar"><img alt="image" src="img/a4.jpg"></td> --> 
<!-- 						<td><a data-toggle="tab" href="#contact-3" class="client-link">Lionel -->
<!-- 								Mcmillan</a></td> -->
<!-- 						<td>Et Industries</td> -->
<!-- 						<td class="contact-type"><i class="fa fa-phone"> </i></td> -->
<!-- 						<td>+432 955 908</td> -->
<!-- 						<td class="client-status"></td> -->
<!-- 					</tr>					 -->
				</tbody>
			</table>
		</div>
	</div>
	
</div>

<!-- Datos Cliente -->
<div v-show="!seleccionandoCliente">

	<div>
		<button @click.prevent="seleccionarOtroCliente" class="btn btn-warning">Seleccionar otro Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">

				<div class="profile-image">
					<img src="<?php echo URL_BASE;?>img/noimage.png"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ nombre }}</h2>
							<h4>{{ empresa }}</h4>
							<small> {{ domicilio1}} {{ domicilio2 }} </small> <br> <small> {{ telefonos }} </small>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel-rec">
					<table class="table  m-b-xs">
						<tbody>
							<tr>
								<td><strong>{{ pedidosTotal }}</strong> Pedidos</td>
								<td><strong>{{ pedidosCancelados }}</strong> Cancelados</td>

							</tr>
							<tr>
								<td><strong>{{ pedidosSaldados }}</strong> Saldados</td>
								<td><strong>{{ pedidosSinSaldar }}</strong> Por saldar</td>
							</tr>

						</tbody>
					</table>
				</div>

			</div>



		</div>
	</div>


	<div class="row">
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span @click.prevent="cargarPedidosTodos" class="btn btn-success btn-xs pull-right">Ver Todos Pedidos</span>
					<h5>Cargos</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(totalCargos) }}</h1>
<!-- 					<div class="stat-percent font-bold text-success"> -->
<!-- 						98% <i class="fa fa-bolt"></i> -->
<!-- 					</div> -->
					<small>Total</small>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span @click.prevent="cargarPedidosSaldados" class="btn btn-info btn-xs pull-right">Ver Pedidos Saldados</span>
					<h5>Abonos</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(totalAbonos) }}</h1>
<!-- 					<div class="stat-percent font-bold text-info"> -->
<!-- 						20% <i class="fa fa-level-up"></i> -->
<!-- 					</div> -->
					<small>Total</small>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span @click.prevent="cargarPedidosPorSaldar" class="btn btn-danger btn-xs pull-right">Ver Pedidos Por Saldar</span>
					<h5>Saldo</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(totalSaldo) }}</h1>
<!-- 					<div class="stat-percent font-bold text-navy"> -->
<!-- 						44% <i class="fa fa-level-up"></i> -->
<!-- 					</div> -->
					<small>Total</small>
				</div>
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h3>Listado de Pedidos <small> &nbsp;{{ queEstoyListando }}</small></h3>
<!-- 					<div class="ibox-tools"> -->
<!-- 						<a class="collapse-link"> <i class="fa fa-chevron-up"></i> -->
<!-- 						</a> <a class="close-link"> <i class="fa fa-times"></i> -->
<!-- 						</a> -->
<!-- 					</div> -->
				</div>
				<div class="ibox-content">
					<h4 v-show="pedidos.length == 0" >No se han encontrado Pedidos.</h4>
					<div class="row">
						
						<div v-show="pedidos.length > 0" class="col-lg-12">
							
							<?php Form::btnExportarExcel("sendToExcel"); ?>
							<table id="tablaToExcel" class="table table-hover margin bottom">
								<thead>
									<tr>
										<th style="width: 1%" class="text-center">No. Pedido</th>
										<th class="text-center">Fecha Captura</th>
										<th class="text-right">Total</th>
										<th class="text-right">Descto.</th>
										<th class="text-right">Cargos</th>
										<th class="text-right">Abonos</th>
										<th class="text-right">Saldo</th>
										<th class="text-center">Estatus</th>
										<th>Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(ped, index) in pedidos">
										<td class="text-center">{{ ped.idPedido }}</td>
										<td class="text-center small">{{ ped.fecha_capturado }}</td>
										<td class="text-right text-primary">$ {{ formatNumber(ped.total) }}</td>
										<td class="text-right text-primary">$ {{ formatNumber(ped.descuento) }}</td>
										<td class="text-right text-primary">$ {{ formatNumber(ped.cargos) }}</td>
										<td class="text-right text-success">$ {{ formatNumber(ped.abonos) }}</td>
										<td class="text-right text-danger">$ {{ formatNumber(ped.saldo) }}</td>
										<td class="text-center" v-html="ped.lblEstado"></td>
										<td>
											<a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + ped.idPedido" class="btn btn-info btn-sm">
												<i class="fa fa-eye"></i>
											</a>
											<a  :href="'<?php echo URL_BASE?>admindescuentopedido/' + ped.idPedido" class="btn btn-primary btn-sm">
												<i class="fa fa-gift"></i> Aplicar Descuento
											</a>
										</td>

									</tr>
<!-- 									<tr> -->
<!-- 										<td class="text-center">2</td> -->
<!-- 										<td class="text-center small">16 Jun 2014</td> -->
<!-- 										<td class="text-center text-primary">$ 500</td> -->
<!-- 										<td class="text-center text-success">$483.00</td> -->
<!-- 										<td class="text-center text-danger">$ 17.00</td> -->
<!-- 										<td class="text-center"><span class="label label-default">CAPTURADO</span></td> -->
<!-- 										<td> -->
<!-- 											<button class="btn btn-info btn-sm"> -->
<!-- 												<i class="fa fa-eye"></i> -->
<!-- 											</button> -->
<!-- 											<button class="btn btn-primary btn-sm"> -->
<!-- 												<i class="fa fa-dollar"></i> Abonar -->
<!-- 											</button> -->
<!-- 										</td> -->

<!-- 									</tr> -->
<!-- 									<tr> -->
<!-- 										<td class="text-center">3</td> -->
<!-- 										<td class="text-center small">16 Jun 2014</td> -->
<!-- 										<td class="text-center text-primary">$ 500</td> -->
<!-- 										<td class="text-center text-success">$483.00</td> -->
<!-- 										<td class="text-center text-danger">$ 17.00</td> -->
<!-- 										<td class="text-center"><span class="label label-default">CAPTURADO</span></td> -->
<!-- 										<td> -->
<!-- 											<button class="btn btn-info btn-sm"> -->
<!-- 												<i class="fa fa-eye"></i> -->
<!-- 											</button> -->
<!-- 											<button class="btn btn-primary btn-sm"> -->
<!-- 												<i class="fa fa-dollar"></i> Abonar -->
<!-- 											</button> -->
<!-- 										</td> -->

<!-- 									</tr> -->
<!-- 									<tr> -->
<!-- 										<td class="text-center">4</td> -->
<!-- 										<td class="text-center small">16 Jun 2014</td> -->
<!-- 										<td class="text-center text-primary">$ 500</td> -->
<!-- 										<td class="text-center text-success">$483.00</td> -->
<!-- 										<td class="text-center text-danger">$ 17.00</td> -->
<!-- 										<td class="text-center"><span class="label label-default">CAPTURADO</span></td> -->
<!-- 										<td> -->
<!-- 											<button class="btn btn-info btn-sm"> -->
<!-- 												<i class="fa fa-eye"></i> -->
<!-- 											</button> -->
<!-- 											<button class="btn btn-primary btn-sm"> -->
<!-- 												<i class="fa fa-dollar"></i> Abonar -->
<!-- 											</button> -->
<!-- 										</td> -->

<!-- 									</tr> -->
<!-- 									<tr> -->
<!-- 										<td class="text-center">5</td> -->
<!-- 										<td class="text-center small">16 Jun 2014</td> -->
<!-- 										<td class="text-center text-primary">$ 500</td> -->
<!-- 										<td class="text-center text-success">$483.00</td> -->
<!-- 										<td class="text-center text-danger">$ 17.00</td> -->
<!-- 										<td class="text-center"><span class="label label-default">CAPTURADO</span></td> -->
<!-- 										<td> -->
<!-- 											<button class="btn btn-info btn-sm"> -->
<!-- 												<i class="fa fa-eye"></i> -->
<!-- 											</button> -->
<!-- 											<button class="btn btn-primary btn-sm"> -->
<!-- 												<i class="fa fa-dollar"></i> Abonar -->
<!-- 											</button> -->
<!-- 										</td> -->

<!-- 									</tr> -->
<!-- 									<tr> -->
<!-- 										<td class="text-center">6</td> -->
<!-- 										<td class="text-center small">16 Jun 2014</td> -->
<!-- 										<td class="text-center text-primary">$ 500</td> -->
<!-- 										<td class="text-center text-success">$483.00</td> -->
<!-- 										<td class="text-center text-danger">$ 17.00</td> -->
<!-- 										<td class="text-center"><span class="label label-default">CAPTURADO</span></td> -->
<!-- 										<td> -->
<!-- 											<button class="btn btn-info btn-sm"> -->
<!-- 												<i class="fa fa-eye"></i> -->
<!-- 											</button> -->
<!-- 											<button class="btn btn-primary btn-sm"> -->
<!-- 												<i class="fa fa-dollar"></i> Abonar -->
<!-- 											</button> -->
<!-- 										</td> -->

<!-- 									</tr> -->

								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php Form::frmExportarExcel();?>

<!-- <form action=" -->
<?php //echo URL_BASE;?>
<!-- reporteadorbytabla" method="post" target="_blank" id="FormularioExportacion"> -->
<!-- 	<input type="hidden" id="ptituloReporte" name="ptituloReporte" /> -->
<!-- 	<input type="hidden" id="psubTituloReporte" name="psubTituloReporte"/> -->
<!-- 	<input type="hidden" id="pexcluir" name="pexcluir"/> -->
<!-- 	<input type="hidden" id="pnombreReporte" name="pnombreReporte"/> -->

<!-- 	<input type="hidden" id="pTableHeader" name="pTableHeader" />     -->
<!-- 	<input type="hidden" id="pTableBody" name="pTableBody" /> -->
<!-- </form> -->


<!-- <pre>{{ $data }}</pre> -->
<!-- <pre>{{ $data.pedidos }}</pre> -->