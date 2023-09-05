<?php
$titlePage = "Reportes";
$breadCum = "Listado de Ventas X Cliente";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
 		";

?>



<!-- Seleccionar Cliente -->
<div class="modal inmodal" id="modalSelCliente" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<i class="fa fa-users modal-icon"></i>
				<h4 class="modal-title">Seleccionar Cliente</h4>

			</div>
			<div class="modal-body">
				
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
			<div class="modal-footer">		
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>		
				
			</div>
		</div>
	</div>
</div>
<!-- Fin Seleccionar Cliente -->


<div class="ibox-content m-b-sm border-bottom">
	

	<div  class="row">
		<div >
		
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="control-label col-lg-1" for="promotor">Cliente</label>
						<div class="col-lg-9">
    						<div class="input-group">
    							<input type="text" class="form-control" v-model="clienteSeleccionado" readonly> 
    								<span class="input-group-btn">
    								<button @click.prevent="seleccionarCliente" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
    							</span>
    						</div>
						</div>


					</div>
				</div>
				
            	<br>
            	<br>	
            	
            	<hr>
		</div>

    </div>
	<div class="row"> 

		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<div class="form-group" v-bind:class="{'has-error': errFechaInicio}">
				<label class="control-label col-lg-2">Desde</label>
				<div class="input-group date col-lg-10">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input id="dtFechaInicio" type="text" class="form-control"
						value="<?php echo date("d/m/Y");?>">
				</div>
				<span v-if='errFechaInicio' class='help-block'> <strong>{{
						errFechaInicio }} </strong>
				</span>
			</div>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
			<div class="form-group" v-bind:class="{'has-error': errFechaFin}">
				<label class="control-label col-lg-2">Hasta</label>
				<div class="input-group date col-lg-10">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input id="dtFechaFin" type="text" class="form-control"
						value="<?php echo date("d/m/Y");?>">
				</div>
				<span v-if='errFechaFin' class='help-block'> <strong>{{ errFechaFin
						}} </strong>
				</span>
			</div>
		</div>

	
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<button @click.prevent="obtenerReporte" class="btn btn-primary">Obtener</button>
		</div>
	</div>

<!-- 	<hr> -->
<!-- 	<div class="row"> -->
<!-- 		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> -->
<!-- 			<button @click.prevent="obtenerReportePendientesSaldar" class="btn btn-primary">Obtener todos los Pedidos sin Saldar </button> -->
<!-- 		</div> -->
<!-- 	</div> -->


</div>


<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<div class="row">

					<?php Form::btnExportarExcel("sendToExcel"); ?>
				</div>


				<div class="table-responsive">
					<table id="tblReporte" class="table table-striped">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Estado</th>
								<th class='text-right'>Pedido</th>
								<th class='text-right'>Rengl&oacute;n</th>
								<th>Descripci&oacute;n</th>
								<th class='text-right'>Total Pedido</th>
                                <th class='text-right'>Saldo Pedido</th>
                                <th>Saldada</th>
                                <th class='text-right'>Pzas</th>
								
								<th class='text-right'>ML</th>
								<th class='text-right'>Precio X Pieza</th>
								<th class='text-right'>Precio X ML</th>
								<th class='text-right'>Total</th>
							</tr>
						</thead>
						<tbody id="tblReporteBody">

						</tbody>
						<tfoot  id="tblReporteFoot">
							
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php Form::frmExportarExcel();?>

<!-- <pre> -->
<!-- {{ $data }} -->
<!-- </pre> -->