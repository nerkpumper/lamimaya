<?php


$titlePage = "Reportes";
$breadCum = "Inventario Galvamex";
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

<h2>Los Saldos ya incluyen IVA</h2>

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
</div>


</div>





<div class="row">	
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-info pull-right">Annual</span> -->
				<h5>Inventario Inicial</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">$ {{ formatNumber(inventarioGalvamexHasta) }}</h1>
				<!--                                 <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
				<small v-if="fi != ''">Kilos {{ formatNumber(inventarioGalvamexKilosHasta) }}</small>
				<br>
				<small v-if="fi != ''">Hasta {{ fi }}</small>
			</div>
		</div>
	</div>
	
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-primary pull-right">Today</span> -->
				<h5>Compras</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">$ {{ formatNumber(inventarioGalvamexEntre) }}</h1>
				<!--                                 <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> -->
				<small v-if="fi != ''">Kilos {{ formatNumber(inventarioGalvamexKilosEntre) }}</small>
				<br>
				<small v-if="ff != '' && fi != ''">Del {{ fi }} al {{ ff }}</small>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-danger pull-right">Low value</span> -->
				<h5>Salidas</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">$ {{ formatNumber(inventarioGalvamexSalidaEntre) }}</h1>
				<!--                                 <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div> -->
				<small v-if="fi != ''">Kilos {{ formatNumber(inventarioGalvamexSalidaKilosEntre) }}</small>
				<br>
				<small v-if="ff != '' && fi != ''">Del {{ fi }} al {{ ff }}</small>
			</div>
		</div>
	</div>
</div>


<div class="row">	
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-info pull-right">Annual</span> -->
				<h5>Inventario Inicial Stock</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">$ {{ formatNumber(inventarioStockGalvamexHasta) }}</h1>
				<!--                                 <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->				
				<small v-if="fi != ''">Hasta {{ fi }}</small>
			</div>
		</div>
	</div>
	
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-primary pull-right">Today</span> -->
				<h5>Compras Stock</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">$ {{ formatNumber(inventarioStockEntradasGalvamexEntre) }}</h1>
				<!--                                 <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> -->
			
				<small v-if="ff != '' && fi != ''">Del {{ fi }} al {{ ff }}</small>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-danger pull-right">Low value</span> -->
				<h5>Salidas Stock</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">$ {{ formatNumber(inventarioStockSalidasGalvamexEntre) }}</h1>
				<!--                                 <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div> -->
				
				<small v-if="ff != '' && fi != ''">Del {{ fi }} al {{ ff }}</small>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-3">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!--                                 <span class="label label-success pull-right">Monthly</span> -->
				<h5>Total</h5>
			</div>
			<div class="ibox-content">
				<h1 class="no-margins">
					$ <strong>{{ formatNumber(totalNeto) }}</strong>
				</h1>
<!-- 				<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
				<small v-if="fi != ''">Kilos {{ formatNumber(totalKilosNeto) }}</small>
				<br>
				<small v-if="ff != '' && fi != ''">Del {{ fi }} al {{ ff }}</small>
			</div>
		</div>
	</div>
</div>


<!-- <pre>{{ $data }}</pre> -->