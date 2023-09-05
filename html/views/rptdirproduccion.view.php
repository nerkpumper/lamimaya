<?php


$titlePage = "Reportes";
$breadCum = "Producci&oacute;n de Rollos Anual";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

// $_addHead="
//  			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
//  		";

$_addScript = "
    
		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
	        
	        
		";

?>

<style>
#container {
	height: 400px;
	max-width: 800px;
	margin: 0 auto;
}

.highcharts-tooltip-box {
	fill: black;
	fill-opacity: 0.6;
	stroke-width: 0;
}

.highcharts-tooltip text {
	fill: white;
	text-shadow: 0 0 3px black;
}
</style>

<div class="ibox-content m-b-sm border-bottom">
	<?php Form::btnExportarExcel("exportar");?>
	<div v-show="showAnio" id="chartAnio" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
</div>

<div v-show="false" class="table-responsive">
	<table id="tablaToExcel" class="table table-bordered table-hover ">
		<thead>
			<tr>				
				<th>ID Rollo</th>
				<th>Codigo</th>
				<th>Descripci&oacute;n</th>
				<th>Mes</th>
				<th>Total</th>				
			</tr>
		</thead>
		<tbody>
			<tr v-for="r in datosTabla">
				<td>{{ r.idRollo }}</td>
				<td>{{ r.codigo }}</td>
				<td>{{ r.descripcion }}</td>
				<td>{{ r.mes }}</td>
				<td>{{ r.total }}</td>
			</tr>
		</tbody>
	</table>
</div>


<?php Form::frmExportarExcel();?>

<!-- <button v-show="!showAnio" @click.prevent="mostrarAnio" class="btn btn-primary" > Regresar</button> 
<div v-show="!showAnio" id="chartMes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->

