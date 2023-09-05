<?php
$titlePage = "Pedidos de Cliente";
$breadCum = "Promotor/Pedidos Cliente";
$_lugar = LUGAR_CXC_ABONOXRECIBODINERO;

?>

<!-- Modal pagar con recibo de dinero -->
<div class="modal inmodal" id="modalPagarConReciboDinero" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
<!-- <div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-credit-card modal-icon"></i>
				<h4 class="modal-title">Disponible de Cliente</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-10">
						<h2>{{ rdCliente }}</h2>
						<strong>Folio Pedido:</strong>: <span class="text-success"> {{ rdIdPedido }}</span><br><br>
						<strong>Saldo Pedido:</strong>: <span class="text-navy">$ {{ formatNumber(rdTotalPedido) }}</span> &nbsp;&nbsp;&nbsp; <button @click.prevent="deseoSaldarTodo" v-if="rdDisponible >= rdTotalPedido" class="btn btn-primary btn-xs"> Deseo Saldar Todo</button> <br/><br/>
						<strong>Disponible Cliente:</strong>: <span class="text-navy">$ {{ formatNumber(rdDisponible) }}</span>

						<p class="m-t">
							Se ha detectado un Disponible del Cliente del Pedido. Usted puede saldar o abonar al pedido mediante este Disponible.
							
						</p>

						<!-- <p class="m-t"> -->
							
							
						<!-- </p> -->
					</div>

					<div class="col-md-10">
						<div class="form-group"
							v-bind:class="{'has-error': rdErrAbonoMonto}">
							<label class="control-label" for="rdAbonoMonto">Indique la cantidad a utilizar del Disponible del Cliente para abonar al Pedido.</label> 
								<div class="input-group m-b">
									<span class="input-group-addon">$</span> 
									<input
									type="text" v-model="rdAbonoMonto" class="form-control"
									maxlength="9" ref="rdAbonoMonto"
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
								</div>
							<span class='help-block'> <strong>{{ rdErrAbonoMonto }}</strong>
							</span>
						</div>
					</div>
					
					<div class="col-md-10">
						<button @click.prevent="pagarConReciboDinero" class="btn btn-success">
							<i class="fa fa-credit-card">
								Pagar Pedido con Disponible del Cliente
							</i>
						</button>

					</div>

				</div>
			</div>
			<div class="modal-footer">		
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>		
				
			</div>
		</div>
	</div>
</div>

<!-- fin modal pagar con recibo de dinero -->


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
		<h3>Seleccione Cliente</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" @keyup.enter="filtrarCliente" class="form-control"	v-model="filtroNombreCliente"	 		
		 		placeholder="filtrar">
			</div>
			<div class="col-lg-2 col-md- col-sm-12 col-xs-12">
				<div class="checkbox checkbox-primary">
					<input id="chkconsaldo" type="checkbox" v-model="chkConSaldo" value ='false'>
						<label for="chkConSaldo">
							Mostrar solo con saldo en Recibo de dinero 
						</label>
				</div> 
			</div>	
			<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
				<button @click.prevent="filtrarCliente()" class="btn btn-primary ">Filtrar</button>
			</div>
		</div>
					

		<div class="table-responsive">
			<div class="row">
				<div  class="col-sm-3">
					<div class="input-group m-b">
						<span class="input-group-btn">
							<button @click.prevent="previousCliPage" type="button" class="btn btn-white" :disabled="cliPage == 0"><i class="fa fa-chevron-left"></i></button> 
						</span> 
						<input type="text" :value="'(' + totalCliReg + ' Regs.)  Pag. ' + (cliPage + 1) + ' / ' + cliPages" class="form-control text-center" style="width: 250px" disabled>
						<span class="input-group-btn">
							<button @click.prevent="nextCliPage" type="button" class="btn btn-white" :disabled="cliPage == (cliPages - 1)"><i class="fa fa-chevron-right"></i></button> 
						</span>  
							
					</div>                                                            
				</div>
				
			</div>
			
			<table class="table table-bordered table-striped table-hover">
			<thead>
					<tr>
						<th>Id</th>
						<th>Cliente</th>
						
						<!-- <th>Empresa</th>
						<th></th>
						<th>Email</th>
						<th></th>
						<th>Telefono</th> -->
						<th>Saldo Pedidos Entregados</th>
						<th>Saldo Recibo Dinero</th>
						<th>Accion</th>
					</tr>
				</thead>
				
				<tbody>
					<tr v-for="(cli, index) in clientes">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td>{{ cli.idCliente }}</td>
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td>
						<td v-show='cli.saldoEntregado == 0' class='text-right text-success' >$ {{ cli.saldoEntregado }}</td>
						<td v-show='cli.saldoEntregado > 0' class=" text-right text-danger"><b>$ {{ cli.saldoEntregado }}</b></td>
						<td v-show='cli.saldoReciboDinero == 0' class='text-right text-success' >$ {{ cli.saldoReciboDinero }}</td>
						<td v-show='cli.saldoReciboDinero > 0' class=" text-right text-info"><b>$ {{ cli.saldoReciboDinero }}</b></td>
						<td class="client-status"><button @click.prevent="seleccionarCliente(cli.idCliente)" class="btn btn-primary btn-xs">Seleccionar</button></td>
					</tr>					
<!-- 					<tr> -->
<!-- 						<td class="client-avatar"><img alt="image" src="img/a4.jpg"></td> --> 
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
		<h4>Atendido por :</h4>
		<h2 class="text-danger" >{{ promotor }}</h2>
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
				<br>
				<button @click.prevent="refreshCliente" class="btn btn-primary"><i class="fa fa-refresh"></i> Refrescar Datos del Cliente</button>
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
			<div class="col-lg-3">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<!-- <span @click.prevent="cargarPedidosTodos" class="btn btn-success btn-xs pull-right">Ver Todos Pedidos</span> -->
					<h5>Disponible Recibo Dinero</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">$ {{ formatNumber(rdDisponible) }}</h1>
<!-- 					<div class="stat-percent font-bold text-success"> -->
<!-- 						98% <i class="fa fa-bolt"></i> -->
<!-- 					</div> -->
					<!-- <small>Total</small> -->
				</div>
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


	<div class="ibox-content m-b-sm border-bottom">
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label" for="order_id">Consultar</label>
					<select class="form-control" v-model="quePedidosParam">
						<option value="">-- Seleccione --</option>
						<option value="TODOS">TODOS</option>
						<option value="SALDADOS">SALDADOS</option>
						<option value="PORSALDAR">POR SALDAR</option>						
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label" for="status">Pedidos por P&aacute;gina</label>
					<select class="form-control" v-model="pageSizeAux">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
						
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">					
					<button @click.prevent="filtrar" :disabled="quePedidosParam === ''" class="btn btn-primary m-t-md"><i class="fa fa-search"></i></button>
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
					<h4 v-show="pedidos.length == 0 && yaSeCargaronPedidos && !loading" >No se han encontrado Pedidos.</h4>
					<div class="row">
						
						<div v-if="pedidos.length == 0 && loading" class="sk-spinner sk-spinner-wave">
							<div class="sk-rect1"></div>
							<div class="sk-rect2"></div>
							<div class="sk-rect3"></div>
							<div class="sk-rect4"></div>
							<div class="sk-rect5"></div>
						</div>
						<div v-show="pedidos.length > 0" class="col-lg-12">
							
							<?php Form::btnExportarExcel("sendToExcel"); ?>
							<div class="row">
								<div  class="col-sm-3">
									<div class="input-group m-b">
										<span class="input-group-btn">
											<button @click.prevent="previousPage" type="button" class="btn btn-white" :disabled="page == 0"><i class="fa fa-chevron-left"></i></button> 
										</span> 
										<input type="text" :value="'(' + totalReg + ' Regs.)  Pag. ' + (page + 1) + ' / ' + pages" class="form-control text-center" style="width: 250px" disabled>
										<span class="input-group-btn">
											<button @click.prevent="nextPage" type="button" class="btn btn-white" :disabled="page == (pages - 1)"><i class="fa fa-chevron-right"></i></button> 
										</span>  
										 
									</div>                                                            
								</div>
								
							</div>
							<div v-if="loading" class="sk-spinner sk-spinner-wave">
								<div class="sk-rect1"></div>
								<div class="sk-rect2"></div>
								<div class="sk-rect3"></div>
								<div class="sk-rect4"></div>
								<div class="sk-rect5"></div>
							</div>
							<table  v-show="!loading" id="tablaToExcel" class="table table-hover margin bottom">
								<thead>
									<tr>
										<th style="width: 1%" class="text-center">No. Pedido</th>
										<th class="text-center">Fecha Captura</th>
										<th class="text-center">Fecha Entregado</th>
										<th class="text-center">Factura</th>
										<th class="text-right">Cargos Cte.</th>
										<th class="text-right">Abonos Cte.</th>
										<th class="text-right">Saldo Cte.</th>
										<th class="text-center">Estatus</th>
										<th>Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(ped, index) in pedidos">
										<td class="text-center">{{ ped.idPedido }}</td>
										<td class="text-center small">{{ ped.fecha_capturado }}</td>
										<td class="text-center small">{{ ped.fecha_entregado }}</td>
										<td class="text-center">{{ ped.factura }}</td>
										<td class="text-right text-primary">$ {{ formatNumber(ped.cargos) }}</td>
										<td class="text-right text-success">$ {{ formatNumber(ped.abonos) }}</td>
										<td class="text-right text-danger">$ {{ formatNumber(ped.saldo) }}</td>
										<td class="text-center" v-html="ped.lblEstado"></td>
										<td>
											<a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + ped.idPedido" class="btn btn-info btn-sm">
												<i class="fa fa-eye"></i>
											</a>
											<a  :href="'<?php echo URL_BASE?>promomovscxcpedido/' + ped.idPedido" class="btn btn-primary btn-sm">
												<i class="fa fa-dollar"></i> Ver Movimientos CXC
											</a>
											<button v-if="ped.saldo > 0 && rdDisponible > 0" @click.prevent="verificarDisponiblePagoPedido(ped.idPedido)" class="btn btn-primary btn-sm"><i class="fa fa-credit-card"></i> Pagar con Recibo Dinero</button>
										</td>

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