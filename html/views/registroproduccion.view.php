<?php
$titlePage = "Registro de producci&oacute;n";
$breadCum = "Producci&oacute;n/Registro de producci&oacute;n";
//$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCCION_REGISTROPRODUCCION;
?>

<!-- 2A431467JGP04 -->

<div v-show="showListadoRollos">

	<div>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<h2>No. Rollo</h2>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="m-b-xs">
					<div class="input-group" style="padding-top: 10px;">
						<input type="text" class="form-control input-lg" v-model="noRollo"
							v-on:keypress.enter="app.cargarDatosNoRollo();"> <span
							class="input-group-btn">
							<button @click.prevent="cargarDatosNoRollo"
								class="btn btn-primary btn-lg " type="button">
								<i class="fa fa-search"></i><span class="bold"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div v-if="msgError">
		<div class="text-center animated fadeInRight alert alert-danger">{{
			msgError }}</div>
	</div>



	<div v-for="(r, indexrollo) in rollos" class="panel-rec m-b">
		<h2>
			<span class="text-navy"> {{ r.codigo }}</span> {{
			r.descripcion }}
		</h2>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th># Rollo</th>
<!-- 						<th>Registro</th> -->
						<th>Remisi&oacute;n</th>
						<th>Almacen</th>
						<th>Kilos</th>
						<th>Disponible</th>
						<th>Seleccionar</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(remi, indexnorollo) in r.noRollos">
						<td><h3>{{ remi.noRollo }}</h3></td>
<!-- 						<td>{{ remi.fecha }}</td> -->
						<td>{{ remi.remision }}</td>
						<td>{{ remi.almacen }}</td>
						<td>{{ formatNumber(remi.kilos) }}</td>
						<td>{{ formatNumber(remi.disponible) }}</td>
						<td><button class="btn btn-primary btn-xs" @click.prevent="seleccionarNoRemision(indexrollo, indexnorollo)">Seleccionar</button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div v-if="showRolloSeleccionado" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<!-- 	<div class="panel-rec m-b"> -->
		<div>
		<h2>
			<button class="btn btn-warning" @click.prevent="seleccionarOtroNoRollo">Seleccionar otro # Rollo</button> <span class="text-navy"> {{ codigoRolloSeleccionado }}</span> {{
			rolloSeleccionado }} # Rollo <span class="text-navy"> {{
				noRolloSeleccionado }}</span>
		</h2>


		<div v-show="registrosProduccion.length > 0">
<!-- 		<div > -->
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Fecha Creaci&oacute;n</th>
							<th>Kilos</th>
							<th>Kilos Maquilados</th>
							<th>Total ML</th>
							<th>Fecha T&eacute;rmino</th>
							<th>Acci&oacute;n</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="rp in registrosProduccion">
							<td>{{ rp.fechaCreacion }}</td>
							<td>{{ rp.kilos }}</td>
							<td>{{ rp.kilosMaquilados }}</td>
							<td>{{ rp.totalML }}</td>
							<td>{{ rp.fechaTermino }}</td>
							<td>
								<a class="btn btn-primary" :href="getRutaReporteProduccion(rp.idRegistroProduccion)">Obtener Registro Producci&oacute;n</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div v-show="showBotonCrearRegistroProduccion && kilosNoRolloSeleccionado > 0">
			<div class="text-center animated fadeInRight alert alert-warning">
				<h3>Kilos disponibles en el N&uacute;mero de Rollo {{ kilosNoRolloSeleccionado }}</h3>
				No existe <strong>Registro de Producci&oacute;n</strong> abierto
				para el # de Rollo. &nbsp;&nbsp;
				<button @click.prevent="crearRegistroProduccion"
					class="btn btn-primary">Crear Registro de Producci&oacute;n</button>
			</div>
		</div>
	</div>
</div>


<div v-show="showRegistroDeProduccion" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
<!-- 			<span class="label label-warning pull-right">Data has changed</span> -->
			<h5>REGISTRO DE PRODUCCI&Oacute;N DE ROLLOS</h5>
			<div class="ibox-tools">
				<button class="btn btn-success" @click.prevent="concluirRegistroProduccion"><i class="fa fa-check"></i> Concluir Registro de Producci&oacute;n</button>
			</div>
		</div>
		<div class="ibox-content">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<small class="stats-label">KILOS DE ROLLO</small>
					<h4>{{ rpKilosRollo }}</h4>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<small class="stats-label">KILOS MAQUILADOS</small>
					<h4>{{ rpKilosMaquilados }}</h4>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<small class="stats-label">KILOS FALTANTES</small>
					<h4>{{ formatNumber( rpKilosFaltantes )}} </h4>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<small class="stats-label">TOTAL DE ML</small>
					<h4>{{ rpTotalML }}</h4>
				</div>
			</div>
		</div>
		<div class="ibox-content">
			<div v-show="registroProduccionDetalle.length > 0" class="table-responsive ">
<!-- 			<div  class="table-responsive "> -->
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>NUM. DE PEDIDO</th>
							<th>NOMBRE DEL CLIENTE</th>
							<th>PIEZAS</th>
							<th>ML</th>
							<th>TOTAL DE ML</th>
							<th>TOTAL KG</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in registroProduccionDetalle">
							<td>{{ item.nopedido }}</td>
							<td>{{ item.nombrecliente }}</td>
							<td>{{ item.partida }}</td>
							<td>{{ item.longitud }}</td>
							<td>{{ item.totalml }}</td>
							<td>{{ item.totalkg }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div v-show="showBotonesAddRegistro">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="ingresarRPStock" class="btn btn-primary"><i class="fa fa-plus"></i> Registro Stock</button>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="ingresarRPPedido" class="btn btn-primary"><i class="fa fa-plus"></i> Pedido</button>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="ingresarRPPYC" class="btn btn-primary"><i class="fa fa-plus"></i> P Y C</button>
					</div>
				</div>
			</div>
			<div v-show="showFormByPedido">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<button class="btn btn-danger btn-xs pull-right" @click.prevent="cancelarIngresoRegistro">Cancelar</button>
							Registrar Producci&oacute;n por Pedido
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<h4>No. Pedido</h4>
								</div>

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="m-b-xs">
										<div class="input-group" >
											<input type="text" class="form-control " v-model="pedidoIdPedido"
												v-on:keypress.enter="app.cargarPedidoDetalle();"
												oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');">
												 <span	class="input-group-btn">
												<button @click.prevent="cargarPedidoDetalle"
													class="btn btn-primary  " type="button">
													<i class="fa fa-search"></i><span class="bold"></span>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div v-if="pedidoMsgPedido" class="text-center animated fadeInRight alert alert-info">
								{{ pedidoMsgPedido }}
							</div>
							<div v-if="pedidoCliente">
								<h3>
									Cliente: <span class="text-navy m-l">{{ pedidoCliente }} </span>
								</h3>
								<div v-show="!pedidoDespachando" class="table-responsive">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>C&oacute;digo</th>
												<th>Descripci&oacute;n</th>
												<th>Pzas/Kg</th>
												<th>ML</th>
												<th>Pzas/Kg Despachadas</th>
												<th>Despachado</th>
												<th>Acci&oacute;n</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index) in pedidoPedidoDetalle">
												<td>{{ item.proCodigo }}</td>
												<td>{{ item.proDescripcion }}</td>
												<td>{{ item.partida }}</td>
												<td>
													<div v-show="item.shortUnidad != 'KG'">
														{{ item.cantidadReal}} <span v-show="item.shortUnidad == 'M2'">({{ item.cantidad }} M2)</span>
													</div>
													<div v-show="item.shortUnidad == 'KG'">
														KG
													</div>
												</td>
												<td>{{ item.partidaDespachada }}</td>
												<td>{{ item.despachado }}</td>
												<td><span v-if="item.proIdRollo == idRolloSeleccionado && (item.partida - item.partidaDespachada) > 0 && item.shortUnidad != 'PZA'">
														<button @click.prevent="pedidoDespacharPedidoDetalle(index)" class="btn btn-primary btn-xs">Despachar</button>
													</span  >
<!-- 													<span v-if="(item.partida - item.partidaDespachada) <= 0" class='label label-success'>DESPACHADO</span> -->
													<span v-if="(item.partida - item.partidaDespachada) <= 0" class='text-success'>DESPACHADO</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div v-show="pedidoDespachando" class="panel-rec">
									<div class="row">
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<button @click.prevent="pedidoNoDespachar" class="btn btn-warning btn-xs">Regresar</button>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<h3>
												Despachando: <span class="text-navy m-l">{{ pedidoDespachandoProducto }} </span>
											</h3>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<div class="form-group">
												<label class="control-label" for="price">PIEZAS</label>
												<h3>{{ pedidoTotalPiezas }}</h3>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<div class="form-group">
												<label v-show="pedidoShortUnidad != 'KG'" class="control-label" for="price">ML</label>
												<label v-show="pedidoShortUnidad == 'KG'" class="control-label" for="price">KG</label>
												<h3 v-show="pedidoShortUnidad != 'KG'">{{ pedidoML }}</h3>
												<h3 v-show="pedidoShortUnidad == 'KG'">KG</h3>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<div class="form-group">
												<label class="control-label" for="price">POR DESPACHAR</label>
												<h3>{{ pedidoPorDespachar }}</h3>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errPedidoPiezas}">
												<label class="control-label" for="price">DESPACHAR</label>
												<input type="text" v-model="pedidoPiezas"
												       class="form-control" maxlength="9"
												       oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');">
												<span class='help-block'>
													<strong>{{ errPedidoPiezas }}</strong>
												</span>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<div class="form-group">
												<label v-show="pedidoShortUnidad != 'KG'" class="control-label" for="price">ML DESPACHAR</label>
												<h3 v-show="pedidoShortUnidad != 'KG'">{{ pedidoMLDespachar }}</h3>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<div class="form-group">
												<label class="control-label" for="price">KG DESPACHAR</label>
												<h3>{{ pedidoKGDespachar }}</h3>
											</div>
										</div>

									</div>
									<div class="row">
										<button v-show="showButtonRegistrarRPPedido" @click.prevent="registrarRPPedido" class="btn btn-success pull-right m-r">Registrar</button>
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div v-show="showFormByStock">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<button class="btn btn-danger btn-xs pull-right" @click.prevent="cancelarIngresoRegistro">Cancelar</button>
							Registrar Producci&oacute;n Stock
						</div>
						<div class="panel-body">
							<div class="row">
								<h3>
									<span class="text-navy m-l">STOCK GALVAMEX</span>
								</h3>
							</div>
							<div class="row m-b">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div class="form-group" v-bind:class="{'has-error': errStockIdProducto}">
										<select v-model="stockIdProducto" id="selStockProducto" class="form-control">
											<option value="0">-- Seleccione Producto --</option>
										</select>
										<span class='help-block'>
											<strong>{{ errStockIdProducto }}</strong>
										</span>
									</div>

								</div>
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<select v-show="false" v-model="stockIdProducto" id="selLongitudStockProducto" class="form-control">
										<option value="0">-- Seleccione Producto --</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group" v-bind:class="{'has-error': errStockPiezas}">
										<label class="control-label" for="price">Piezas</label>
										<input type="text" v-model="stockPiezas"
										       class="form-control" maxlength="9"
										       ref="stockPiezas"
											   v-on:keypress.enter="app.$refs.stockML.focus();"
										       oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
										<span class='help-block'>
											<strong>{{ errStockPiezas }}</strong>
										</span>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group" v-bind:class="{'has-error': errStockML}">
										<label class="control-label" for="price">ML</label>
										<h3>{{ stockML }}</h3>
<!-- 										<input type="text" v-model="stockML"  -->
<!-- 										       class="form-control" maxlength="9" -->
<!-- 										       ref="stockML" -->
<!-- 											   v-on:keypress.enter="app.$refs.stockML.focus();" -->
<!-- 										       oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"> -->
<!-- 										<span class='help-block'>  -->
<!-- 											<strong>{{ errStockML }}</strong> -->
<!-- 										</span> -->
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="control-label" for="price">TOTAL ML</label>
										<h3>{{ stockTotalML }}</h3>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group text-navy">
										<label class="control-label" for="price">TOTAL KG</label>
										<h3>{{ stockTotalKG }}</h3>
									</div>
								</div>
							</div>
							<div class="row">
								<button v-show="showButtonRegistrarRPStock" @click.prevent="registrarRPStock" class="btn btn-success pull-right m-r">Registrar</button>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div v-show="showFormByPYC">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<button class="btn btn-danger btn-xs pull-right" @click.prevent="cancelarIngresoRegistro">Cancelar</button>
							Registrar Producci&oacute;n P Y C
						</div>
						<div class="panel-body">
							<div class="row">
								<h3>
									<span class="text-navy m-l">P Y C</span>
								</h3>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group" v-bind:class="{'has-error': errPycPiezas}">
										<label class="control-label" for="price">Piezas</label>
										<h3>{{ pycPiezas }}</h3>
<!-- 										<input type="text" v-model="pycPiezas"  -->
<!-- 										       class="form-control" maxlength="9" -->
<!-- 										       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">										        -->
<!-- 										<span class='help-block'>  -->
<!-- 											<strong>{{ errPycPiezas }}</strong> -->
<!-- 										</span> -->
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group" v-bind:class="{'has-error': errPycML}">
										<label class="control-label" for="price">ML</label>
										<input type="text" v-model="pycML"
										       class="form-control" maxlength="9"
										       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										<span class='help-block'>
											<strong>{{ errPycML }}</strong>
										</span>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="control-label" for="price">TOTAL ML</label>
										<h3>{{ pycTotalML }}</h3>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group text-navy">
										<label class="control-label" for="price">TOTAL KG</label>
										<h3>{{ pycTotalKG }}</h3>
									</div>
								</div>
							</div>
							<div class="row">
								<button v-show="showButtonRegistrarRPPyc" @click.prevent="registrarRPPyc" class="btn btn-success pull-right m-r">Registrar</button>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<!-- <pre>{{ $data.pedidoPedidoDetalle }}</pre> -->

<!-- <pre>{{ $data }}</pre> -->
