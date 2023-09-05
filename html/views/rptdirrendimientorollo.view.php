<?php
$titlePage = "Reportes";
$breadCum = "Rendimiento de Rollos";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
 		";

?>




<div class="ibox-content m-b-sm border-bottom">
	

	<h5>Las Fechas indican cu&aacute;ndo el Rollo fue terminado.</h5>
	<hr>
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
								<th>Rollo</th>
								<th>Remisi&oacute;n</th>
								<th>No Rollo</th>
								<th>Total Kilos</th>
                                <th>Total Maquilados</th>
								<th>Total Pyc</th>
                                <th>Factor</th>
                                <th style="display: none;">Rendimiento</th>
                                <th style="display: none;">Rendimiento Ponderado</th>
                                <th style="display: none;">Fecha T&eacute;rmino</th>
                                <th style="display: none;">Usuario</th>
                                <th>Rendimiento</th>
                                <th>Rendimiento Ponderado</th>                                
								<th>Fecha T&eacute;rmino</th>
								<th>Usuario</th>								
								<th></th>
							</tr>
						</thead>
						<tbody id="tblReporteBody">

						</tbody>
						<tfoot id="tblReporteFoot">

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