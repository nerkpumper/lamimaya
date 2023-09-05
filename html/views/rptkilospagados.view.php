<?php
$titlePage = "Reporte Kilos Pagados";
$breadCum = "Reportes/Reporte Kilos Pagados";
$_lugar = LUGAR_REPORTES;
$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript = "

		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>

		";
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="ibox-content m-b-sm border-bottom">

				<div  class="row">
	
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
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    							<button  @click.prevent="obtenerReporte" class="btn btn-primary" >Obtener Informacion</button>
    					</div>
					</div>

				</div>
            </div>
</div>

<div class="row">
	




	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Kilos pagados por Departamento</h5>				
			</div>
            <div class="ibox-content">	
                <h1></h1>														
                <div class="row">
                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                		<table class="table table-bordered table-striped table-hover">
               				
                    	<thead>
                        <tr >
                            <th class="text-center">Id</th>
                            <th class="text-center">C&oacutedigo </th>
							<th class="text-center">Descripcion </th>
                            <th class="text-center">Venta de Rollos</th>
							<th class="text-center">Venta de kilos Acanalados</th>
							<th class="text-center">Venta de kilos Molduras</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in lstRollo">
                        <td>{{ row.idRollo }}</td>
                        <td>{{ row.codigo }}</td> 
						<td>{{ row.descripcion }}</td>  
                        <td class="text-right">{{ formatNumber(row.kilosRollo) }}</td>
                        <td class="text-right">{{ formatNumber(row.kilosAcanalado) }}</td>
                        <td class="text-right">{{ formatNumber(row.kilosMoldura) }}</td>                     
                    </tr>
					<tr>
						<td></td>
						<td></td>
						<td class="text-right"><strong>TOTAL</strong></td>
						<td class="text-right"><strong>{{ formatNumber(totalRollo) }}</strong></td>
						<td class="text-right"><strong>{{formatNumber(totalAcanalado) }}</strong></td>
						<td class="text-right"><strong>{{formatNumber(totalMoldura) }}</strong></td>
					</tr>
                    </tbody>
                </table>     							
            </div>
		</div>
	</div>
</div>

