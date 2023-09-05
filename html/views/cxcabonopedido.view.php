<?php
$titlePage = "Abono Pedido";
$breadCum = "CXC/Abono a Pedido";
$buttonAction = "Ir a Listado de Notas del Cliente/fnRegresarAListado";
$_lugar = LUGAR_CXC_ABONOPEDIDO;

// echo "<pre>{{ \$data.sucursal }}</pre>";
?>

<div v-show="idSucursal == 0">
    <span class="alert alert-danger">
        No tiene asignada una sucursal en sus datos de Usuario. No puede realizar actividades en esta pantalla.
    </span>

</div>

<div v-show="idSucursal > 0">

	<h2>El movimiento aqu&iacute; generado se registr&aacute; para la sucursal: <strong>{{sucursal.nombre}}</strong></h2>

	<div v-show="seleccionarPedido">
		<h2 class="m-l">No. Pedido:</h2>
		<div class="col-sm-3 m-b-xs">
			<div class="input-group">
				<input type="text" class="form-control input-lg" v-model="idPedido"
					v-on:keypress.enter="cargarDatosPedido"
					oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
					maxlength='8'> <span class="input-group-btn">
					<button @click.prevent="cargarDatosPedido"
						class="btn btn-primary btn-lg " type="button">
						<i class="fa fa-check"></i><span class="bold"></span>
					</button>
				</span>
			</div>
		</div>



	</div>



	<!-- Datos Cliente -->
	<div v-show="!seleccionarPedido">
		<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar otro Pedido</button>
		<div class="row m-b-lg m-t-lg">
			<h3>Cliente:</h3>
			<div class="col-md-6">
						<div class="profile-image">
							<img src="<?php echo URL_BASE;?>img/noimage.png" class="img-circle circle-border m-b-md" alt="profile">
						</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ cteNombre }} {{ cteApellidos }}</h2>
							<h4>{{ cteEmpresa }}</h4>
							<small> {{ cteDomicilio1 }} {{ cteDomicilio2 }} </small> <br>
							<small> {{ cteTelefonos }} </small><br>
							<small> <strong>Promotor: </strong> {{ ctePromotor }} </small>
						</div>
					</div>
				</div>
				<br>
				<button @click.prevent="refreshMovimientos" class="btn btn-primary"><i class="fa fa-refresh"></i> Refrescar Datos del Cliente</button>
			</div>
			<div class="col-md-6">
				<div class="panel-rec">
					<table class="table small m-b-xs">
						<tbody>
							<tr>
								<td><strong>No Pedido</strong>
									<h2 class="text-navy">{{ idPedido }}</h2></td>

								<td><strong>Estatus</strong>
									<h2 class="text-navy">{{ estado }}</h2></td>
								<td><strong>Total</strong>
									<h2 class="text-navy">$ {{ formatNumber(totalPedido) }}</h2></td>
							</tr>

						</tbody>
					</table>
				</div>

			</div>



		</div>

		<div class="row">
			<div class="col-lg-3 ">
				<div class="ibox float-e-margins text-danger">
					<div class="ibox-title ">
						<!-- 					<span class="label label-success pull-right">Ver Todos Pedidos</span> -->
						<h5>Cargos</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">$ {{ formatNumber(cargos) }}</h1>
						<!-- 					<div class="stat-percent font-bold text-success"> -->
						<!-- 						98% <i class="fa fa-bolt"></i> -->
						<!-- 					</div> -->
						<small>Total</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins text-success">
					<div class="ibox-title " >
						<!-- 					<span class="label label-info pull-right">Ver Pedidos Saldados</span> -->
						<h5>Abonos</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">$ {{ formatNumber(abonos) }}</h1>
						<!-- 					<div class="stat-percent font-bold text-info"> -->
						<!-- 						20% <i class="fa fa-level-up"></i> -->
						<!-- 					</div> -->
						<small>Total</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins text-navy">
					<div class="ibox-title">
						<!-- 					<span class="label label-danger pull-right">Ver Pedidos Por Saldar</span> -->
						<h5>Por Saldar</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">$ {{ formatNumber(saldo) }}</h1>
						<!-- 					<div class="stat-percent font-bold text-navy"> -->
						<!-- 						44% <i class="fa fa-level-up"></i> -->
						<!-- 					</div> -->
						<small>Total</small>
					</div>
				</div>
			</div>

			<div v-show="desctoAplicado > 0" class="col-lg-3">
				<div class="ibox float-e-margins text-navy">
					<div class="ibox-title">
						<!-- 					<span class="label label-danger pull-right">Ver Pedidos Por Saldar</span> -->
						<h5>Descuento Aplicado</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">$ {{ formatNumber(desctoAplicado) }}</h1>
						<div class="stat-percent font-bold text-navy">
							{{ porDesctoAplicado }} % </i>
						</div>
						<small>Total</small>
					</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Movimientos</h5>
	<!-- 					<div class="ibox-tools"> -->
	<!-- 						<a class="collapse-link"> <i class="fa fa-chevron-up"></i> -->
	<!-- 						</a> <a class="close-link"> <i class="fa fa-times"></i> -->
	<!-- 						</a> -->
	<!-- 					</div> -->
					</div>
					<div class="ibox-content">

						<div v-show="ingresarMovimiento">
							<div class="row">
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group"
										v-bind:class="{'has-error': errAbonoMovimiento}">
										<label class="control-label" for="price">Movimiento</label> <select
											class="form-control" v-model="abonoMovimiento">
											<option value="ABONO">ABONO</option>
											<option value="CARGO">CARGO</option>
										</select> <span class='help-block'> <strong>{{
												errAbonoMovimiento }}</strong>
										</span>
									</div>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group"
										v-bind:class="{'has-error': errAbonoMonto}">
										<label class="control-label" for="price">Monto</label> <input
											type="text" v-model="abonoMonto" class="form-control"
											maxlength="9" ref="abonoMonto"
											oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
										<span class='help-block'> <strong>{{ errAbonoMonto }}</strong>
										</span>
									</div>
								</div>
								<div v-show="abonoMovimiento == 'ABONO'" class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
									<div class="form-group"
										v-bind:class="{'has-error': errAbonoFormaPago}">
										<label class="control-label" for="price">Forma Pago</label> <select
											class="form-control" v-model="abonoFormaPago">
											<option value="0">--Seleccione--</option>
										
											<option v-for="lst in lstFormaPago" :value="lst.idFormaPago">{{ lst.descripcion }}</option>
																	
	<!-- 									<option value="ABONO">ABONO</option> -->
											<!-- 									<option value="CARGO">CARGO</option> -->
										</select> <span class='help-block'> <strong>{{
												errAbonoFormaPago }}</strong>
										</span>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group"
										v-bind:class="{'has-error': errAbonoReferencia}">
										<label class="control-label" for="price">Referencia</label> <input
											type="text" v-model="abonoReferencia" class="form-control"
											maxlength="65" ref="abonoReferencia">
										<span class='help-block'> <strong>{{ errAbonoReferencia }}</strong>
										</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button class="btn btn-success pull-right m-l" @click.prevent="guardarMovimiento">Guardar</button>
									<button class="btn btn-danger pull-right" @click.prevent="cancelarMovimiento">Cancelar</button>
								</div>
							</div>
						</div>


						<div v-show="!ingresarMovimiento">
							<div v-show="saldada == 'SI'" class="col-lg-3 col-md3 col-sm-6 col-xs-6">
								<div class="alert alert-success">
										<h3>Pedido Saldado</h3>
								</div>
							</div>

							<button v-show="saldada == 'NO'" class="btn btn-primary" @click.prevent="generarMovimiento">Generar Movimiento</button>
							<button @click.prevent="sendToExcel" class="btn btn-outline btn-primary dim pull-right" type="button"><i class="fa fa-file-excel-o"></i> Exportar</button>
	<!-- 						<button class="btn btn-primary pull-right" @click.prevent="sendToExcel">Enviar a Excel</button> -->
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive">
										<table id="tablaToExcel" class="table table-bordered table-hover ">
											<thead>
												<tr>

													<th>Fecha</th>
													<th>Movimiento</th>
													<th class="text-right">Saldo Actual</th>
													<th class="text-right">Monto</th>
													<th class="text-right">Saldo Nuevo</th>
													<th>Forma de Pago</th>
													<th>Referencia</th>
													<th>Usuario</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="item in movimientos">
													<td>{{ item.fecha }}</td>
													<td>{{ item.movimiento }}</td>
													<td class="text-right">$ {{ formatNumber(item.saldoactual) }}</td>
													<td class="text-right"
														v-bind:class="['text-navy', item.movimiento == 'CARGO' ? 'text-danger' : '']">
														<strong>$ {{ formatNumber(item.monto) }}</strong>
													</td>
													<td class="text-right text-success">$ {{ formatNumber(item.saldonuevo) }}</td>
													<td>{{ item.formadepago }}</td>
													<td>{{ item.referencia }}</td>
													<td>{{ item.usuario }}</td>
												</tr>

											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>

	<form action="<?php echo URL_BASE;?>reporteadorbytabla" method="post" target="_blank" id="FormularioExportacion">
		<input type="hidden" id="ptituloReporte" name="ptituloReporte" />
		<input type="hidden" id="psubTituloReporte" name="psubTituloReporte"/>

		<input type="hidden" id="pTableHeader" name="pTableHeader" />
		<input type="hidden" id="pTableBody" name="pTableBody" />
	</form>

	<!-- <pre>{{ $data }}</pre> -->

	<!-- <pre>{{ $data.movimientos }}</pre> -->
</div>