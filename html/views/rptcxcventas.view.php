<?php
$titlePage = "Reportes";
$breadCum = "Listado de Ventas X Promotor";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
 		";

?>

<!-- <pre>{{ $data.cliente }}</pre> -->
<!-- <br>tipo producto -->
<!-- <br>aplicacion -->
<!-- <br>unidad -->
<!-- <br>material -->
<!-- <br>rollo -->
<!-- <br>calibre -->
<!-- <br>pies -->



<div class="ibox-content m-b-sm border-bottom">
	


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
								<th>Pedido</th>								
								<th>Nombre Cliente</th>
								<th>Promotor</th>
								<th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Surtido</th>
								<th>Saldado</th>
								<th>Saldo</th>
								<th>Facturas asignadas</th>								
							</tr>
						</thead>
						<tbody id="tblReporteBody">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php Form::frmExportarExcel();?>
