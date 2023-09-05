<?php
// $_showPageHeading = false;

$titlePage = "Pedido";
// $breadCum = "Ventas/Pedido/Nuevo";
$_lugar = LUGAR_VENTAS_NUEVOPEDIDO;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/toastr/toastr.min.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/clockpicker/clockpicker.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
 				
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>
 		";
?>




<div v-show="seleccionaCliente" :class="claseTotalClienteSegunPantalla">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5>Cliente</h5>
		</div>
		<div class="ibox-content ibox-heading">
			<h3>
				<i class="fa fa-user"></i> {{ clienteSeleccionado }}
				<button v-show="idClienteSeleccionado > 0" @click.prevent="dejarClienteSeleccionado" class="btn btn-warning pull-right"><i class="fa fa-check-square-o"> Conservar</i></button>
			</h3>
			<small><i class="fa fa-tim"></i> {{ promotorClienteSeleccionado }}</small>
		</div>
		<div class="ibox-content">

			<div>
				<button v-show="!seleccionandoCliente"
					@click.prevent="seleccionarCliente"
					class="btn btn-primary pull-right">Seleccionar Cliente</button>
				<button v-show="seleccionandoCliente" @click.prevent="cancelarSeleccionarCliente"
					class="btn btn-danger pull-right ">Cancelar</button>
			</div>

			<div v-show="seleccionandoCliente">
				<div>
					<input type="text" id="default" v-model="filtroNombreCliente"
						placeholder="Cliente" class="form-control input-lg">
				</div>

				<div class="hr-line-dashed"></div>

				<div class="feed-activity-list">
					<div v-for="cte in clientesFiltradosPorNombre" class="feed-element">
						<div>
							<!-- 									<small class="pull-right text-navy">1m ago</small>-->
							<strong>{{ cte.nombre }}</strong>
							<div>{{ cte.promotor }}</div>
							<small class="text-muted pull-right"><button
									@click.prevent="setClienteSelected(cte.id);"
									class="btn btn-primary btn-xs">Seleccionar</button></small>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>

		</div>
	</div>
</div>

<!-- <div v-if="imprimirPedido"> -->
<div id="secImprimirONuevo">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="ibox">
				<div class="ibox-title">
					<h2>
						<i class="fa fa-thumbs-up fa-2x"></i> Pedido Generado
					</h2>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<h1>Folio {{ pedidoFolio }}</h1>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a
								:href="'<?php echo URL_BASE;?>pedidopdf?id=' + pedidoFolio"
								target="_blank" class="btn btn-success btn-lg"><i
								class="fa fa-print"></i> Imprimir</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<button @click.prevent="sendPedidoACliente"
								class="btn btn-success btn-lg">
								<i class="fa fa-envelope"></i> Enviar a Cliente
							</button>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a href="<?php echo URL_BASE?>pedidonuevo"
								class="btn btn-primary btn-lg"><i class="fa fa-shopping-cart"></i>
								Nuevo Pedido</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
							style="padding-top: 10px">
							<a href="pedido" class="btn btn-warning btn-lg"><i
								class="fa fa-list"></i> Ir a Listado de Pedidos</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- <h1>Pedidos</h1> -->

<!-- <div class="ibox "> -->
<!-- 	<div class="ibox-title"> -->
<!-- 		<h5>Inspinia modal window</h5> -->

<!-- 	</div> -->
<!-- 	<div class="ibox-content"> -->
		
<!-- 		<div class="text-center"> -->
<!-- 			<button id="btnModalLauncher" type="button" class="btn btn-primary" -->
<!-- 				data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->
<!-- 			<button @click.prevent="lanzaModal" class="btn btn-success">Lanza -->
<!-- 				Modal</button> -->
<!-- 		</div> -->
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-shopping-cart modal-icon"></i>
				<h4 class="modal-title">{{ descripcionModal }}</h4>
				<small class="font-bold">{{ codigoModal }}</small> <br> 
				<small>
					Unidad <strong>{{ unidadModal }}</strong>
					<span v-show="shortUnidadModal == 'M2'" class="text-danger"><br>Ingrese en Metros Lineales, el sistema realizar&aacute; la conversi&oacute;n a M2.</span>
				</small>
				<!-- 						<br> -->
				<!-- 						tp {{ tipoPrecioModal }} su {{ shortUnidadModal }} Cant {{ cantidadModal }} dT {{ desarrolloTModal }} dI {{ desarrolloIModal }} do {{ doblecesModal }} -->
			</div>
			<div class="modal-body">

				<div class="row m-b-xs">
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">Cantidad</label> <input type="text"
									v-model="cantidadModal" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
					<div v-show="mostrarUnidadEnModal"
						class="col-lg-6 col-md-12 col-sm-12 col-xs-12 m-b">
						<!-- 											metros cuad piezas (int) kg ml -->
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="control-label">{{ labelUnidadEnModal }}</label> <input
									type="text" v-model="cantUnidadModal" placeholder=""
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
									maxlength="9" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="row m-b-xs">
					<div v-show="tipoPrecioModal != 'G'"
						class="col-lg-6  col-md-12 col-sm-12 col-xs-12 m-b">
						<div v-show="tipoPrecioModal == 'T'">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label">Desarrollo</label> <select
										v-model="desarrolloTModal" class="form-control">
										<option value="0">--Seleccione--</option>
										<option v-for="des in desarrollosTernium"
											:value="des.desarrollo">{{ des.desarrollo }}</option>
									</select>
								</div>
							</div>
						</div>
						<div v-show="tipoPrecioModal == 'I'">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label">Desarrollo</label> <select
										v-model="desarrolloIModal" class="form-control">
										<option value="0">--Seleccione--</option>
										<option v-for="des in desarrollosImportados"
											:value="des.desarrollo">{{ des.desarrollo }}</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div v-show="tipoPrecioModal != 'G'"
						class="col-lg-6 col-md-12 col-sm-12 col-xs-12  m-b">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="control-label">Dobleces</label> <select
									v-model="doblecesModal" class="form-control">
									<option value="0">--Seleccione--</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div v-show="errorModal" class="row m-b-xs">
					<div v-html="errorModal" class="alert alert-danger"></div>
				</div>
				
				<div v-show="modalMostrarMsgAgregarMas" class="row m-b-xs">
					<div class="alert alert-info">
						Producto Agregado, puede agregar el mismo producto con otras cantidades si lo desea.
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">{{ textBotonCancelModal }}</button>
				<button @click.prevent="enlistaProductoDeModal" type="button"
					class="btn btn-primary">{{ textBotonAddModal }}</button>
			</div>
		</div>
	</div>
</div>

<!-- 	</div> -->
<!-- </div> -->





<div v-if="debugging" class="well" v-html="debug"></div>



<div v-show="vistaPedido">

	<div class="ibox-content ibox-heading">
		
		<h3>
			<button @click.prevent="refreshDatosClienteSeleccionado" v-show="idClienteSeleccionado > 0" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
			<i class="fa fa-user"></i> {{ clienteSeleccionado }}
			<button @click.prevent="seleccionarOtroCliente" class="btn btn-warning pull-right"><i class="fa fa-users"></i> Seleccionar otro Cliente</button>
		</h3>
		<small><i class="fa fa-tim"></i> {{ promotorClienteSeleccionado }}</small>
		
		
	</div>

	<div class="ibox-content p-xl" id="tablero">



		<div v-show="mostrarTiposProducto">
			<h3>Selecciona Tipo de Producto</h3>

			<div v-show="isPantallaGrande">
				<div v-for="tipo in tiposProducto"
					class="col-lg-4 col-md-4 col-sm-12 col-xs-12"
					style="cursor: pointer;" v-on:click="listarProductos(tipo.id);">
					<!-- 			<div class="widget navy-bg text-center" > -->
					<!-- 				<div class="m-b-md"> -->
					<!-- 					<i class="fa fa-cubes fa-4x"></i> -->
					<!-- 					<h1 class="m-xs">{{ tipo.nombre }}</h1> -->
					<!-- 				</div> -->
					<!-- 			</div> -->
					<div class="widget style1 navy-bg">
						<div class="row vertical-align">
							<div class="col-xs-3">
								<i class="fa fa-tags fa-3x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<h2 class="font-bold">{{ tipo.nombre }}</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div v-show="!isPantallaGrande">
				<div v-for="tipo in tiposProducto"
					class="col-lg-2 col-md-2 col-sm-12 col-xs-12"
					style="cursor: pointer;" v-on:click="listarProductos(tipo.id);">
					<!-- 			<div class="widget navy-bg text-center" > -->
					<!-- 				<div class="m-b-md"> -->
					<!-- 					<i class="fa fa-cubes fa-4x"></i> -->
					<!-- 					<h1 class="m-xs">{{ tipo.nombre }}</h1> -->
					<!-- 				</div> -->
					<!-- 			</div> -->
					<div class="widget navy-bg">
						<div class="row vertical-align">
							<div class="col-xs-3">
								<i class="fa fa-tags"></i>
							</div>
							<div class="col-xs-9 text-right">
								<strong>{{ tipo.nombre }}</strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div v-show="!mostrarTiposProducto">
			<h3>Selecciona Producto</h3>
			<div v-show="isPantallaGrande">
				<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12"
					style="cursor: pointer;" @click.prevent="showSectionTiposProductos">
					<div class="widget yellow-bg p-lg text-center">
						<div class="m-b-md">
							<i class="fa fa-angle-double-left fa-3x"></i>
							<h3 class="font-bold no-margins m-xs">Regresar</h3>

						</div>
					</div>

				</div>
				<div v-for="(prod, index) in productosFiltradosPorTipo"
					class="col-lg-3 col-md-12 col-sm-12 col-xs-12"
					style="cursor: pointer;">
					<!-- 			<div class="widget blue-bg text-center"> -->
					<!-- 			<div class=""> -->

					<!-- 				<h2 class="font-bold">{{ prod.codigo }}</h2> -->
					<!-- 				<h3 class="font-bold">{{ prod.descripcion }}</h3>				 -->
					<!-- 			</div> -->
					<div class="widget lazur-bg p-lg text-center"
						v-on:click="prepararProductoDesdeGrid(prod.codigo);">
						<div class="m-b-md">
							<!--                             <i class="fa fa-cubes fa-2x"></i> -->
							<h2 class="font-bold no-margins m-xs">
								{{ prod.codigo }}
								<!-- 					 <span v-if="prod.longitud"> * {{ -->
								<!-- 						prod.longitud }} ML</span> -->
							</h2>
							<h4 class="">{{ prod.fullDescripcion }}</h4>
							<h4 class="">{{ prod.shortUnidad }}</h4>

						</div>
					</div>

				</div>
			</div>
			<div v-show="!isPantallaGrande">				
				<div class="col-lg-2 col-md-2 col-sm-12 col-xm-12">
					<div class="btn btn-warning"
						@click.prevent="showSectionTiposProductos">
						<i class="fa fa-angle-double-left"></i> Regresar
					</div>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xm-12">
					<input type="text" 
								v-model="filtroDescripcion" placeholder="Filtrar Descripci&oacute;n"
								class="form-control ">
				</div>
				<br>
				
				<!-- 				<button class="btn btn-primary" @click.prevent="addElement">add</button> -->

				<table id="tblProductosFiltrados"
					class="table table-stripped table-bordered toggle-arrow-tiny" data-page-size="10">
					<thead>
						<tr>
							<th data-sort-ignore="true">C&oacute;digo</th>
							<th data-sort-ignore="true" data-hide="phone">Descripi&oacute;n</th>
							<th data-sort-ignore="true" data-hide="phone">Unidad</th>
							<th data-sort-ignore="true" data-hide="phone">Tpo. Precio</th>

							<th data-sort-ignore="true" class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(prod, index) in productosFiltradosPorTipo">
							<td>{{ prod.codigo }}</td>
							<td>{{ prod.fullDescripcion }} <span v-if="prod.shortUnidad == 'PZA'" class="badge badge-info "> ~ {{ prod.existenciaEstimada }} </span></td>
							<td>{{ prod.shortUnidad }}</td>
							<td>
								<span v-show="prod.tipoPrecio == 'G'">GALVAMEX</span> 
								<span v-show="prod.tipoPrecio == 'I'">IMPORTADOS</span> 
								<span v-show="prod.tipoPrecio == 'T'">TERNIUM</span></td>
							<td class="text-right">
								<!-- 																<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);" class="btn btn-outline btn-primary dim btn-xs" type="button"><i class="fa fa-pencil"></i></button> -->
								<button @click.prevent="prepararProductoDesdeGrid(prod.codigo);"
									class="btn btn-outline btn-primary " type="button">
									<i class="fa fa-plus"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<ul class="pagination pull-right"></ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>

		</div>



		<div class="clearfix"></div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="ibox">
				<div class="ibox-title">
					<!-- 				<span class="pull-right">(<strong>5</strong>) items -->
					<!-- 				</span> -->
					<h5>Seleccionar Productos</h5>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-group">
							<!-- 				<label for="default">Pick a programming language</label> -->
							<input type="text" id="default" list="lstProductos"
								v-model="productoAEnlistar" placeholder="Producto"
								class="form-control input-lg"
								v-on:keypress.enter="app.prepararProducto();">

							<datalist id="lstProductos">
								<option v-for="item in productos"
									:value="item.fullDescripcionCode"
									:label="item.fullDescripcionCode">{{item.idProducto}}
									{{item.fullDescripcion}}</option>
							</datalist>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<button @click.prevent="prepararProducto"
								class="btn btn-primary btn-lg " type="button">
								<i class="fa fa-check"></i><span class="bold"></span>
							</button>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<button @click.prevent="showHideGrid"
								class="btn btn-primary btn-lg " type="button">
								<i class="fa fa-th-large"></i>&nbsp;&nbsp;<span class="bold">{{
									textShowGrid }}</span>
							</button>
						</div>
					</div>



				</div>
			</div>
		</div>
	</div>


	<!-- <div class="row"> -->
	<!-- 	<div class="col-md-9"> -->
	<!-- 		<div class="ibox"> -->
	<!-- 			<div class="ibox-title"> -->
	<!-- <!-- 				<span class="pull-right">(<strong>5</strong>) items -->
	<!-- <!-- 				</span> -->
	<!-- 				<h5>Items in your cart</h5> -->
	<!-- 			</div> -->
	<!-- 			<div class="ibox-content"> -->
	<!-- 			</div> -->
	<!-- 		</div> -->
	<!-- 	</div> -->
	<!-- </div> -->




	<div class="row">
		<div :class="clasePedidoSegunPantalla">

			<div class="ibox">
				<div class="ibox-title">
					<span class="pull-right">(<strong>{{ noElementosEnPedido }}</strong>)
						Elementos
					</span>
					<h5 style="margin-top: 7px">Productos Pedido</h5>
					<div v-show="false">
						
						<div class="col-lg-3 col-md-3 col-sm-8 col-xs-8" >
							<select v-model="selTipoPedido" class="form-control">
								<option value="0">-- Seleccione Tipo --</option>
								<option value="AT">AT</option>
								<option value="D">D</option>
							</select>
						</div>
					</div>
					
					<div class="clearfix"></div>
					
				</div>
				<div class="ibox-content">
					<div v-show="isPantallaGrande">
						<div class="table-responsive">
							<table class="table shoping-cart-table">
								<tbody>
									<tr v-for="(item, index) in listadoPedido">
										<!-- 								<td width="90"> -->
										<!-- 									<div class="cart-product-imitation"></div> -->
										<!-- 								</td> -->
										<td class="desc">
											<h3 class="text-navy">
												{{ item.codigo }}
												<!-- 											<span v-if="item.longitud"> * {{ -->
												<!-- 													item.longitud }} ML</span> -->
												<!-- 										<a href="#" class="text-navy"> Codigo + longitud </a> -->
											</h3>
											<p>{{ item.fullDescripcion }}</p>

											<div class="row m-b-xs">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 m-b">
													<!-- 											metros cuad piezas (int) kg ml -->
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label class="control-label">Cantidad</label>
															<h2 class="text-navy">{{ item.cantidad }}</h2>
															<!-- 													<input -->
															<!-- 														type="text" v-model="item.cantidad" -->
															<!-- 														placeholder="" maxlength="9"													 -->
															<!-- 														class="form-control">  -->
														</div>
													</div>
												</div>
												<div v-show="item.shortUnidad != 'PZA'"
													class="col-lg-5 col-md-12 col-sm-12 col-xs-12 m-b">
													<!-- 											metros cuad piezas (int) kg ml -->
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label class="control-label">{{ item.lblUnidad }}</label>
															<h2 class="text-navy">{{ item.cantUnidad }}</h2>
															<!-- 													<input -->
															<!-- 														type="text" v-model="item.cantidad" -->
															<!-- 														placeholder="" maxlength="9"													 -->
															<!-- 														class="form-control">  -->
														</div>
													</div>
												</div>
												<div v-show="item.tipoPrecio != 'G'"
													class="col-lg-3 col-md-12 col-sm-12 col-xs-12 m-b">
													<div v-show="item.tipoPrecio == 'T'">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="form-group">
																<label class="control-label">Desarrollo</label>
																<h2 class="text-navy">{{ item.desarrolloT }}</h2>
																<!-- 														<select v-model="item.desarrolloT" class="form-control"> -->
																<!-- 															<option value="0">--Seleccione--</option> -->
																<!-- 															<option v-for="des in desarrollosTernium" :value="des.desarrollo">{{ des.desarrollo }}</option>															 -->
																<!-- 														</select>  -->
															</div>
														</div>
													</div>
													<div v-show="item.tipoPrecio == 'I'">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="form-group">
																<label class="control-label">Desarrollo</label>
																<h2 class="text-navy">{{ item.desarrolloI }}</h2>
																<!-- 														<select v-model="item.desarrolloI" class="form-control"> -->
																<!-- 															<option value="0">--Seleccione--</option> -->
																<!-- 															<option v-for="des in desarrollosImportados" :value="des.desarrollo">{{ des.desarrollo }}</option>															 -->
																<!-- 														</select>  -->
															</div>
														</div>
													</div>
												</div>
												<div v-show="item.tipoPrecio != 'G'"
													class="col-lg-2 col-md-12 col-sm-12 col-xs-12  m-b">
													<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
														<div class="form-group">
															<label class="control-label">Dobleces</label>
															<h2 class="text-navy">{{ item.dobleces }}</h2>
															<!-- 													<select v-model="item.dobleces" class="form-control"> -->
															<!-- 														<option value="0">--Seleccione--</option> -->
															<!-- 														<option value="1">1</option> -->
															<!-- 														<option value="2">2</option> -->
															<!-- 														<option value="3">3</option> -->
															<!-- 														<option value="4">4</option> -->
															<!-- 														<option value="5">5</option> -->
															<!-- 														<option value="6">6</option> -->
															<!-- 														<option value="7">7</option> -->
															<!-- 														<option value="8">8</option> -->
															<!-- 														<option value="9">9</option> -->
															<!-- 														<option value="10">10</option> -->
															<!-- 													</select>  -->
														</div>
													</div>
												</div>

												<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 m-b"
													style="padding-top: 10px;">

													<button @click.prevent="updateProductoLista(index)"
														class="btn btn-outline btn-primary dim" type="button">
														<i class="fa fa-pencil"></i>
													</button>

													<!-- 											<button @click.prevent="testButton" class="btn btn-outline btn-primary" type="button"><i class="fa fa-pencil"></i></button> -->
												</div>
											</div>


											<dl class="small m-b-none">
												<dt>Unidad</dt>
												<dd>{{ item.unidad }}</dd>
											</dl>

											<dl class="small m-b-none">
												<dt>Tipo Precio</dt>
												<dd v-show="item.tipoPrecio == 'G'">GALVAMEX</dd>
												<dd v-show="item.tipoPrecio == 'I'">IMPORTADOS</dd>
												<dd v-show="item.tipoPrecio == 'T'">TERNIUM</dd>
											</dl>

											<dl v-if="debugging" class="small m-b-none">
												<dt>Debug</dt>
												<dd>{{ item.debug }}</dd>
											</dl>

											<div class="m-t-sm">
												<!-- 										<a @click.prevent="alert('gift');" href="#" class="text-muted"><i class="fa fa-gift"></i> Add -->
												<!-- 											gift package</a> |  -->
												<a @click.prevent="quitarElementoDePedido(index);" href="#"
													class="text-muted"><i class="fa fa-trash"></i> Quitar del
													Pedido</a>
											</div>
										</td>

										<td>$ {{ item.precioRenglon }}</td>

										<!-- 								<td>$180,00 <s class="small text-muted">$230,00</s> -->
										<!-- 								</td> -->
										<!-- 								<td width="65"><input type="text" class="form-control" -->
										<!-- 									placeholder="1"></td> -->
										<td>
											<h3 class="font-bold">$ {{ item.totalRenglon }}</h3>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>

					<div v-show="!isPantallaGrande">
						<div class="table-responsive">
							<table id="tblPedidoShort"
								class="table table-stripped table-bordered toggle-arrow-tiny"
								data-page-size="100">
								<thead>
									<tr>
										<th data-sort-ignore="true">C&oacute;digo</th>
										<th data-sort-ignore="true" data-hide="phone">Descripci&oacute;n</th>
										<th data-sort-ignore="true" data-hide="phone">Cnt.</th>
										<th data-sort-ignore="true" data-hide="phone">M/KG</th>
										<th data-sort-ignore="true" data-hide="phone">Des</th>
										<th data-sort-ignore="true" data-hide="phone">Dobles</th>
										<th data-sort-ignore="true" data-hide="phone,tablet">Unidad</th>
										<th data-sort-ignore="true" data-hide="phone,tablet">Tpo Precio</th>
										<th data-sort-ignore="true" data-hide="phone,tablet">P/U</th>
										<th data-sort-ignore="true">Subtotal</th>
	
										<th data-sort-ignore="true" class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in listadoPedido">
										<td>
											<h3 class="text-navy">{{ item.codigo }}</h3>
										</td>
	
										<td>{{ item.fullDescripcion }}</td>
	
										<td>{{ item.cantidad }}</td>
	
										<td>
											<span v-if="item.shortUnidad != 'PZA'"> {{ item.cantUnidad }} <span v-if="item.shortUnidad == 'M2'">ML ({{ formatNumber(item.cantUnidadReal) }} M2)</span> </span> 
<!-- 											<span v-else>-</span></td> -->
											<span v-else-if="item.longitud">{{ item.longitud }}</span>
											<span v-else>-</span>
	
										<td><span v-if="item.tipoPrecio != 'G'">
												<div v-if="item.tipoPrecio == 'T'">{{ item.desarrolloT }}</div>
												<div v-else>{{ item.desarrolloI }}</div>
										</span> <span v-else>-</span></td>
	
										<td><span v-if="item.tipoPrecio != 'G'"> {{ item.dobleces }} </span>
											<span v-else>-</span></td>
	
										<td>{{ item.unidad }}</td>
	
										<td><span v-if="item.tipoPrecio == 'G'">GALVAMEX</span> <span
											v-else-if="item.tipoPrecio == 'I'">IMPORTADOS</span> <span
											v-else>TERNIUM</span></td>
	
										<td>$ {{ formatNumber(item.precioRenglon) }}</td>
	
										<td><strong>$ {{ formatNumber(item.totalRenglon) }}</strong></td>
	
										<td>
											<button @click.prevent="updateProductoLista(index)"
												class="btn btn-primary btn-xs" type="button">
												<i class="fa fa-pencil"></i>
											</button>
											<button @click.prevent="quitarElementoDePedido(index);"
												class="btn btn-danger btn-xs" type="button">
												<i class="fa fa-trash-o"></i>
											</button> <!-- 									<div class="btn btn-warning" @click.prevent="showSectionTiposProductos"><i class="fa fa-angle-double-left"></i> Regresar</div> -->
										</td>
	
									</tr>
								</tbody>
	<!-- 							<tfoot> -->
	<!-- 								<tr> -->
	<!-- 									<td colspan="11"> -->
	<!-- 										<ul class="pagination pull-right"></ul> -->
	<!-- 									</td> -->
	<!-- 								</tr> -->
	<!-- 							</tfoot> -->
							</table>
						</div>
						
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
										<h3>Descuento Individual</h3>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
										<select v-html="getOptionsDescuentoIndividual()" v-model="selDescuentoIndividual" class="form-control">
										</select>		
									</div>
								</div>					
							</div>	
							<div  v-show="maxTipoPrecioGalvamex > 1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
										<h3>Rango Precios</h3>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
										<select v-model="tipoPrecioGalvamex" class="form-control">
											<option value="1">Rango 1</option>
											<option v-show="maxTipoPrecioGalvamex > 1  " value="2">Rango 2</option>
											<option v-show="maxTipoPrecioGalvamex > 2 " value="3">Rango 3</option>
										</select>		
									</div>
								</div>
							</div>
						</div>
						
						<div class="table-responsive">
									<table class="table invoice-total">
										<tbody>
											<tr v-show="porDescuento > 0">
												<td><strong>SUBTOTAL :</strong></td>
												<td><h3>${{ formatNumber(subtotalPedido) }}</h3></td>
											</tr>
											<tr v-show="porDescuento > 0">
												<td><strong>DESCUENTO {{ porDescuento }} %:</strong></td>
												<td><h3>${{ formatNumber(descuentoPedido) }}</h3></td>
											</tr>
											<tr>
												<td><strong>TOTAL :</strong></td>
												<td><h1 class="font-bold">${{ formatNumber(totalPedido) }}</h1></td>
											</tr>
										</tbody>
									</table>
								</div>
						
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group has-success">
									<label class="control-label" for="observacionPedido"> Observaci&oacute;n </label>									
									<input type="text" v-model="observacionPedido" class="form-control"
											maxlength="200" /> <span class='help-block'> Si lo desea, capture alguna Observaci&oacute;n del Pedido
										</span>
									

								</div>
							</div>
						</div>
						
						<button v-show="mostrarBotonGuardar" @click.prevent="levantarPedido"
											class="btn btn-primary btn-lg pull-right">
											<i class="fa fa-shopping-cart"></i> Levantar Pedido
										</button>
						<div class="clearfix"></div>
					</div>
				</div>

				<!-- 			<div class="ibox-content"> -->

				<!-- 				<button class="btn btn-primary pull-right"> -->
				<!-- 					<i class="fa fa fa-shopping-cart"></i> Checkout -->
				<!-- 				</button> -->
				<!-- 				<button class="btn btn-white"> -->
				<!-- 					<i class="fa fa-arrow-left"></i> Continue shopping -->
				<!-- 				</button> -->

				<!-- 			</div> -->
			</div>

		</div>
		<div :class="claseTotalAndClienteSegunPantalla">

			<div id="secIzquierda"></div>
			<div id="secDerecha"></div>

			<div class="row">
<!-- 				<div id="secTotalPedido"> -->
<!-- 					<div :class="claseTotalClienteSegunPantalla"> -->
<!-- 						<div class="ibox"> -->
<!-- 							<div class="ibox-title"> -->
<!-- 								<h5>Total Pedido</h5> -->
<!-- 							</div> -->
<!-- 							<div class="ibox-content"> -->
								<!-- 						<span> Total </span> -->
<!-- 								<h1 class="font-bold">$ {{ totalPedido }}</h1> --> 


<!-- 								<hr /> -->
								<!-- 						<span class="text-muted small"> *For United States, France and -->
								<!-- 							Germany applicable sales tax will be applied </span> -->
<!-- 								<div class="m-t-sm"> -->
<!-- 									<div class="btn-group"> -->
<!-- 										<button @click.prevent="levantarPedido" -->
<!-- 											class="btn btn-primary btn-lg"> -->
<!-- 											<i class="fa fa-shopping-cart"></i> Levantar Pedido -->
<!-- 										</button> -->
										<!-- 									<a href="#" -->
										<!-- 									class="btn btn-white btn-sm"> Cancel</a> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->

			</div>

			<div class="row">
				<div id="zsecCliente">
<!-- 					<div :class="claseTotalClienteSegunPantalla"> -->
<!-- 						<div class="ibox float-e-margins"> -->
<!-- 							<div class="ibox-title"> -->
<!-- 								<h5>Cliente</h5> -->
<!-- 							</div> -->
<!-- 							<div class="ibox-content ibox-heading"> -->
<!-- 								<h3> -->
<!-- 									<i class="fa fa-user"></i> {{ clienteSeleccionado }} -->
<!-- 								</h3> -->
<!-- 								<small><i class="fa fa-tim"></i> {{ promotorClienteSeleccionado -->
<!-- 									}}</small> -->
<!-- 							</div> -->
<!-- 							<div class="ibox-content"> -->

<!-- 								<div> -->
<!-- 									<button v-if="!seleccionandoCliente" -->
<!-- 										@click.prevent="seleccionarCliente" -->
<!-- 										class="btn btn-primary pull-right">Seleccionar Cliente</button> -->
<!-- 									<button v-else @click.prevent="cancelarSeleccionarCliente" -->
<!-- 										class="btn btn-danger pull-right ">Cancelar</button> -->
<!-- 								</div> -->

<!-- 								<div v-if="seleccionandoCliente"> -->
<!-- 									<div> -->
<!-- 										<input type="text" id="default" v-model="filtroNombreCliente" -->
<!-- 											placeholder="Cliente" class="form-control input-lg"> -->
<!-- 									</div> -->

<!-- 									<div class="hr-line-dashed"></div> -->

<!-- 									<div class="feed-activity-list"> -->
<!-- 										<div v-for="cte in clientesFiltradosPorNombre" -->
<!-- 											class="feed-element"> -->
<!-- 											<div> -->
												<!-- 									<small class="pull-right text-navy">1m ago</small>-->
<!-- 												<strong>{{ cte.nombre }}</strong> -->
<!-- 												<div>{{ cte.promotor }}</div> -->
<!-- 												<small class="text-muted pull-right"><button -->
<!-- 														@click.prevent="setClienteSelected(cte.id);" -->
<!-- 														class="btn btn-primary btn-xs">Seleccionar</button></small> -->
<!-- 											</div> -->
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 								<div class="clearfix"></div> -->

<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
					<div :class="claseRecepcionSegunPantalla">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Recepci&oacute;n</h5>
							</div>							
							<div class="ibox-content">
								<div class="row">
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
										El Pedido
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<select v-model="selRecogeRecibe" class="form-control">
											<option value="NOSEL">-- Seleccione --</option>
											<option value="RECOGE">RECOGE EL CLIENTE</option>
											<option value="ENTREGA">SE ENVIA AL CLIENTE</option>
										</select>
									</div>
									<div v-show="selRecogeRecibe == 'ENTREGA'" class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
										    <div class="checkbox" >
	                                            <input id="checkbox1" type="checkbox" v-model="chkUsarInformacionCliente">
	                                            <label for="checkbox1">
	                                                Utilizar la registrada en Cliente.
	                                            </label>
	                                        </div>
										</div>		
								</div>
								<div v-show="selRecogeRecibe == 'ENTREGA'">
									<hr>																			
									<div class="row">										
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteDireccion}">
												<label class="control-label" for="price">
													Persona
												</label> 
												<div v-show="chkUsarInformacionCliente">
													{{ clienteSeleccionado }} 
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="ctePersona" 
													       class="form-control" maxlength="200"/>
													<span class='help-block'> 
														<strong>{{ errCtePersona }}</strong>
													</span>
												</div>
												
												
											</div>
										</div>
									</div>
									<div class="row">										
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteDireccion}">
												<label class="control-label" for="price">
													Direci&oacute;n
												</label> 
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelDomicilio1 }} {{ cteSelDomicilio2 }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteDireccion" 
													       class="form-control" maxlength="60"/>
													<span class='help-block'> 
														<strong>{{ errCteDireccion }}</strong>
													</span>
												</div>
												
												
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteNumero}">
												<label class="control-label" for="price">
													N&uacute;mero
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelNumero }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteNumero" 
													       class="form-control" maxlength="60"/>
													<span class='help-block'> 
														<strong>{{ errCteNumero }}</strong>
													</span>
												</div> 
												
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteColonia}">
												<label class="control-label" for="price">
													Colonia
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelColonia }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteColonia" 
													       class="form-control" maxlength="60"/>
													<span class='help-block'> 
														<strong>{{ errCteColonia }}</strong>
													</span>												
												</div> 
												
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errCteCiudad}">
												<label class="control-label" for="price">
													Ciudad
												</label>
												<div v-show="chkUsarInformacionCliente">
													{{ cteSelCiudad }}
												</div>
												<div v-show="!chkUsarInformacionCliente">
													<input type="text" v-model="cteCiudad" 
													       class="form-control" maxlength="60"/>
													<span class='help-block'> 
														<strong>{{ errCteCiudad	 }}</strong>
													</span>
												</div> 
												
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<label class="control-label">Hora Entrega</label>
												<input type="text" v-model="horaEntrega"  id="txtHoraEntrega"
													       class="form-control" maxlength="45"/>
<!-- 											<div class="input-group clockpicker" data-autoclose="true">												 -->
<!-- 				                                <input id="txtHoraEntrega" type="text" class="form-control" v-model='horaEntrega' > -->
<!-- 				                                <span class="input-group-addon"> -->
<!-- 				                                    <span class="fa fa-clock-o"></span> -->
<!-- 				                                </span> -->
<!-- 				                            </div> -->
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="form-group" v-bind:class="{'has-error': errFechaEntrega}">
				                                <label class="control-label">Fecha Entrega</label>
				                                <div class="input-group date">
				                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                    <input v-modal="fechaEntrega" id="dtFechaEntrega" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>
				                                    ">		                                    
				                                </div>
				                                <span v-if='errFechaEntrega' class='help-block'>
														<strong>{{ errFechaEntrega }} </strong>
												</span>
				                            </div>
										</div>
										
									</div>
									
								</div>
								


							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<div id="divdebug"></div>

<!-- <pre> -->
<!-- DescuentoPedido: {{ descuentoPedido }} -->


<!-- TotalML: {{ $data.totalML }} -->


<!-- ComisionR1: {{ comisionR1 }} -->
<!-- ComisionR2: {{ comisionR2 }} -->
<!-- ComisionR3: {{ comisionR3 }} -->

<!-- MaxTipoPrecioGalvamex {{ $data.maxTipoPrecioGalvamex }} -->
<!-- TipoPrecioGalvamex {{ $data.tipoPrecioGalvamex }} -->

<!-- Rango1Inicio: {{ $data.rango1Inicio }} -->
<!-- Rango1Fin: {{ $data.rango1Fin }} -->

<!-- Rango2Inicio: {{ $data.rango2Inicio }} -->
<!-- Rango2Fin: {{ $data.rango2Fin }} -->

<!-- Rango3Inicio: {{ $data.rango3Inicio }} -->

<!-- MaxDescuentoIndividual: {{ $data.maxDescuentoIndividual }} -->

<!-- DescuentoIndividual: {{ $data.selDescuentoIndividual }} -->

<!-- </pre> -->

<!-- <pre>{{ $data.listadoPedido }}</pre> -->
<!-- <pre>{{ $data }}</pre> -->

<!-- <pre>{{ $data.productos }}</pre> -->


<?php 

if (Permisos::userIsThisRol(Permisos::$idROOTUSER))
{
	echo "<pre>{{ \$data.listadoPedido }}</pre>";
}


?>