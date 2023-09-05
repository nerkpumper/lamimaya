<?php


$titlePage = "Reportes";
$breadCum = "Descuento Cliente";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript = "
    
		
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
		    
		";

// <script src=\"".URL_BASE."assets/highcharts/highstock.js\"></script>
// 	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>


?>

<!--<div id="container" style="height: 400px; min-width: 310px"></div> -->
<!-- <br><br> -->

<h2>Descuento a pedidos</h2>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="ibox-content m-b-sm border-bottom">

		<div class="row">
			
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="form-group" v-bind:class="{'has-error': errFechaInicio}">
					<label class="control-label">Desde</label>
					<div class="input-group date">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input id="dtFechaInicio" type="text" class="form-control"
							value="<?php echo date("d/m/Y");?>">
					</div>
					<span v-if='errFechaInicio' class='help-block'> <strong>{{
							errFechaInicio }} </strong>
					</span>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="form-group" v-bind:class="{'has-error': errFechaFin}">
					<label class="control-label">Hasta</label>
					<div class="input-group date">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input id="dtFechaFin" type="text" class="form-control"
							value="<?php echo date("d/m/Y");?>">
					</div>
					<span v-if='errFechaFin' class='help-block'> <strong>{{ errFechaFin
							}} </strong>
					</span>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<button @click.prevent="obtenerReporte" class="btn btn-primary">Obtener
					Informaci&oacute;n</button>
			</div>
		</div>


	</div>








<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
			
				<thead>
					<th>N° Pedido</th>		
					<th>Cliente</th>
					<th>Fecha pedido</th>
					<th>Descuento</th>
					<th>Total</th>
				
				</thead>
				<tbody>
					<tr v-for="(dat, index) in datos">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td>{{ dat.idPedido }} </td>
						<td>{{ dat.nombre}} {{ dat.apellidos}}</td>
						<td> {{ dat.fechacapturado}}  </td>
						<td> {{ dat.descuento }}</td>
						<td> {{ dat.total }}</td>

					</tr>					
				</tbody>
			</table>
		</div>
		</div>

<!-- <pre>{{ $data }}</pre>  -->