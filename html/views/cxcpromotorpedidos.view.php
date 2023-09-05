<?php

if(Permisos::userIsThisRol(Permisos::$rol_PROMOTOR)  || Permisos::userIsThisRol(Permisos::$rol_PROMOTORPRODUCCION))
{

	$titlePage = "Pedidos de Promotor";
	$breadCum = "Promotor/Pedidos Promotor";
	$_lugar = LUGAR_PROMOTOR_PEDIDOSPROMOTOR;
}
else
{

	$titlePage = "Pedidos de Promotor";
	$breadCum = "CXC/Pedidos Promotor";
	$_lugar = LUGAR_CXC_PEDIDOSPROMOTOR;
}

?>



<!-- Buscar Cliente -->
<div v-show="seleccionandoPromotor">

	<div v-show="idUsuario > 0" >
		<button @click.prevent="dejarPromotor" class="btn btn-warning">Conservar este Promotor</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">
				<h3>Promotor:</h3>
				<div class="profile-image">
					<img :src="promotorImg"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ promotorNombre }}</h2>
							<h4>{{ promotorUsuario }}</h4>							
						</div>
					</div>
				</div>
			</div>			

		</div>
	</div>


	<div class="panel-rec">
		<h3>Seleccione Promotor</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombrePromotor"	 		
		 		placeholder="filtrar">
			</div>			
		</div>
		
		<br>
		
	
		
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				
				<tbody>
					<tr v-for="(promo, index) in promotoresFiltradosPorNombre">

						<td>{{ promo.usuario }}</td>
						<td>{{ promo.nombre }}</td>
						
						<td class="client-status"><button @click.prevent="seleccionarPromotor(promo.idUsuario)" class="btn btn-primary btn-xs">Seleccionar</button></td>
					</tr>					

				</tbody>
			</table>
		</div>
	</div>
	
</div>

<!-- Datos Cliente -->
<div v-show="!seleccionandoPromotor">

	<div>
		<button v-show="!isPromotor" @click.prevent="seleccionarOtroPromotor" class="btn btn-warning">Seleccionar otro Promotor</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">
				<h3>Promotor:</h3>
				<div class="profile-image">
					<img :src="promotorImg"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ promotorNombre }}</h2>
							<h4>{{ promotorUsuario }}</h4>
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
								<td><strong>{{ pedidosSinSaldarEntregados }}</strong> Por saldar Entregados</td>
							</tr>
							<tr>								
								<td colspan="2"><strong>{{ pedidosSinSaldarNoEntregados }}</strong> Por saldar Por Entregar</td>
								<td></td>
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

					<small>Total</small>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox float-e-margins">

				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6 text-center">
							<span @click.prevent="cargarPedidosPorSaldar" class="btn btn-danger m-l btn-xs pull-right">Ver Pedidos Por Entregar Por Saldar</span> 
						</div>
						<div class="col-lg-6 text-center">
							<span @click.prevent="cargarPedidosYaEntregadosPorSaldar" class="btn btn-danger btn-xs pull-right">Ver Pedidos Ya Entregados Por Saldar</span> 
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-6 text-center">
							<h1 class="no-margins">$ {{ formatNumber(totalSaldosPorEntregar) }}</h1>
        					<div class="stat-percent font-bold text-navy">
        						{{ formatNumber(totalSaldosPorEntregar * 100 / totalSaldo) }}% 

        					</div>
							<small>Saldos Pedidos Por Entregar</small>
						</div>
						<div class="col-lg-6 text-center">
							<h1 class="no-margins">$ {{ formatNumber(totalSaldosEntregados) }}</h1>
        					<div class="stat-percent font-bold text-navy">
        						{{ formatNumber(totalSaldosEntregados * 100 / totalSaldo) }}%
        					</div>
							<small>Saldos Pedidos Entregados</small>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="text-center">
							<h1 class="no-margins">$ {{ formatNumber(totalSaldo) }}</h1>

							<small>Total</small>
						</div>
						
					</div>
					
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
						<option value="PORSALDAR">POR SALDAR SIN ENTREGAR</option>
						<option value="PORSALDARENTREGADOS">POR SALDAR ENTREGADOS</option>
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
				</div>
				<div class="ibox-content">
					<h4 v-show="pedidos.length == 0 && yaSeCargaronPedidos && !loading" >No se han encontrado Pedidos.</h4>
					<!-- <h4 v-show="pedidos.length == 0 && !yaSeCargaronPedidos" >.</h4> -->
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
							<table v-show="!loading" id="tablaToExcel" class="table table-hover margin bottom">
								<thead>
									<tr>
										<th style="width: 1%" class="text-center">No. Pedido</th>
										<th class="text-center">Fecha Captura</th>
										<th class="text-center">Fecha Entrega</th>
										<th class="text-left">Cliente</th>
										<th class="text-left">diasVencido</th>
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
										<td class="text-left"><strong>{{ ped.nombreCliente }}</strong> </td>
										<td class="text-left"><strong>{{ ped.diasVencido }}</strong> </td> 
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