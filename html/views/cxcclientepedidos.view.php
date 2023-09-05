<?php
$titlePage = "Pedidos de Cliente";
$breadCum = "CXC/Pedidos Cliente";
$_lugar = LUGAR_CXC_PEDIDOSCLIENTES;

?>



<!-- Buscar Cliente -->
<div v-show="seleccionandoCliente">

	<div v-show="idCliente > 0" >
		<button @click.prevent="dejarCliente" class="btn btn-warning">Conservar este Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">
				<h3>Cliente:</h3>
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
		<h3>Buscar Cliente del siguiente Pedido</h3>
		<div class="row">
			<div class="col-sm-3 m-b-xs">
			<div class="input-group">
				<input type="text" class="form-control " v-model="idPedido"
					v-on:keypress.enter="cargarClienteDePedido"
					oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
					maxlength='8'> <span class="input-group-btn">
					<button @click.prevent="cargarClienteDePedido"
						class="btn btn-primary " type="button">
						<i class="fa fa-check"></i><span class="bold"></span>
					</button>
				</span>
			</div>
		</div>
		</div>
		<hr>
		<h3>Seleccione Cliente</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombreCliente"	 		
		 		placeholder="filtrar">
			</div>	
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-primary">
					<input id="chkconsaldo" type="checkbox" v-model="chkConSaldo" value ='false'>
					<label for="chkConSaldo">
						Mostrar solo con saldo de Pedidos Entregados
					</label>
				</div> 
			</div>	
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
					<button @click.prevent="cargarClientes(app.chkconsaldo)" class="btn btn-primary ">Filtrar</button>
			</div>				
		</div>
		
		<br>
		<hr>
	
	
		<div class="table-responsive">
			<table id="tablaToExcelTotales" class="table table-bordered table-striped table-hover">
			<?php Form::btnExportarExcel("sendToExcelTotales"); ?>
			<thead>
					<tr>
						<th>Id</th>
						<th>Cliente</th>
						<!-- <th>Empresa</th>
						<th></th>
						<th>Email</th>
						<th></th>
						<th>Telefono</th> -->
						<th>Promotor</th>
						<th>Saldo Pedidos Entregados</th>
						<th>Saldo Pedidos Sin Entregar</th>
						<th>Saldo Total</th>
						<th>Accion</th>
					</tr>
				</thead>
				
				<tbody>
					<tr v-for="(cli, index) in clientesFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td>{{ cli.idCliente }}</td>
						<td><b>{{ cli.nombre }}</b></td>
						<!-- <td>{{ cli.empresa }}</td>
						 <td class="contact-type">
							<i v-show="cli.email" class="fa fa-envelope"></i>
						</td>
						<td>{{ cli.email }}</td>
						<td class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></td>
						<td>{{ cli.telefonos }}</td>  -->
						<td>{{ cli.promotor }}</td>
						<td v-show='cli.saldoPedidosEntregados == 0' class='text-right text-success' >$ {{ cli.saldoPedidosEntregados }}</td>
						<td v-show='cli.saldoPedidosEntregados > 0' class=" text-right text-danger"><b>$ {{ cli.saldoPedidosEntregados }}</b></td>
						<td v-show='cli.saldoPedidosSinEntregar == 0'  class='text-right text-success'>$ {{ cli.saldoPedidosSinEntregar }}</td>
						<td v-show='cli.saldoPedidosSinEntregar > 0' class="text-right text-danger"><b>$ {{ cli.saldoPedidosSinEntregar }}</b></td>
						<td v-show='cli.saldoTotal == 0' class='text-right text-success'><b>$ {{ cli.saldoTotal }}</b></td>
						<td v-show='cli.saldoTotal > 0' class="text-right text-danger"><b>$ {{ cli.saldoTotal }}</b></td>
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
					</tr>					
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
				<h3>Cliente:</h3>
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
			<div class="col-md-6">
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
							<tr>
								<td colspan="2">
									<div class="row text-left">
										<div class="col-xs-4 text-navy">
											<div class=" m-l-md">
											<span class="h4 font-bold m-t block">$ {{ formatNumber(cteCredito) }}</span>
											<small class="text-muted m-b block">CR&Eacute;DITO</small>
											</div>
										</div>
										<div class="col-xs-4 text-warning">
											<span class="h4 font-bold m-t block">$ {{ formatNumber(totalCreditoUtilizado) }}</span>
											<small class="text-muted m-b block">UTILIZADO</small>
										</div>
										<div class="col-xs-4" :class="cteDisponible >= 0 ? 'text-success' : 'text-danger'">
											<span class="h4 font-bold m-t block">$ {{ formatNumber(cteDisponible) }}</span>
											<small class="text-muted m-b block">DISPONIBLE</small>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="col-xs-12 ">
											<span class="h3 font-bold m-t block">$ {{ formatNumber(totaSaldosCliente) }}</span>
											<small class="text-muted m-b block">DISPONIBLE EN RECIBO DE DINERO </small>
									</div>
								</td>
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
					<span @click.prevent="cargarPedidosPorSaldar" class="btn btn-warning btn-xs pull-right">Ver Pedidos Por Saldar</span>
					
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
		<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span @click.prevent="cargarPedidosPorSaldarEntregados" class="btn btn-danger btn-xs pull-right">Ver Pedidos Pagados Entregados</span>
					<h4>Entregados</h4>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(saldoEntregadosCliente) }}</h1>
<!-- 					<div class="stat-percent font-bold text-navy"> -->
<!-- 						44% <i class="fa fa-level-up"></i> -->
<!-- 					</div> -->
					<small>Total</small>
				</div>
			</div>
		</div>
		<!-- <div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Saldo de recibo de dinero </h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(totaSaldosCliente) }}</h1>

					<small>Total</small>
				</div>
			</div>
		</div> -->
		
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
										<th class="text-center">Fecha Entrega</th>
										<th style="width: 1%" class="text-center">Dias Cuenta Vencida</th>
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
										<td class="text-center small">{{ ped.fecha_entregado }}</td>
										<td class="text-right text-primary"> {{ ped.diasVencido }}</td>
										<td class="text-right text-primary">$ {{ formatNumber(ped.cargos) }}</td>
										<td class="text-right text-success">$ {{ formatNumber(ped.abonos) }}</td>
										<td class="text-right text-danger">$ {{ formatNumber(ped.saldo) }}</td>
										<td class="text-center" v-html="ped.lblEstado"></td>
										<td>
											<a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + ped.idPedido" class="btn btn-info btn-sm">
												<i class="fa fa-eye"></i>
											</a>
											<a  :href="'<?php echo URL_BASE?>cxcabonopedido/' + ped.idPedido" class="btn btn-primary btn-sm">
												<i class="fa fa-dollar"></i> Cargo/Abono
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
<!-- <pre>{{ $data.clientes }}</pre> -->