<?php
$titlePage = "Reportes";
$breadCum = "Listado de Ventas X Promotor Agrupadas por Cliente";
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
	

	<div  class="row">
		<div v-show="<?php echo $mostrarListado;?>">
		
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="control-label col-lg-2" for="promotor">Promotor</label>
						<div class="col-lg-10">
						<select id="selPromotor"  v-model="filtro.promotor" class="form-control ">

							<?php

								echo $lstPromotores;

							?>
							</select>
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
<!--         <div class="col-lg-3"> -->
<!--             <h1 class="no-margins">$ {{ formatNumber(totalCalculado) }}</h1> -->
<!--             <small>Total</small> -->
<!-- 		</div> -->
	</div>
	<div v-show="filtro.promotor != 0" class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group ">					
				<div class="m-l-lg">
					<div class="radio radio-info">
						<input type="radio" id="inlineRadio1" value="O" name="radioInline" v-model="filtro.tipo">
						<label for="inlineRadio1"> Solo Ventas de mis Clientes</label>
					</div>
					<div class="radio radio-info ">
						<input type="radio" id="inlineRadio2" value="A" v-model="filtro.tipo" name="radioInline">
						<label for="inlineRadio2"> Todas las Ventas que he realizado</label>
					</div>
				</div>
			</div>

		</div>
	</div>
	<hr>

	<div class="row text-left">
		<div class="col-xs-3 text-success">
			<div class=" m-l-md ">
				<span class="h3 font-bold m-t block">$ {{ formatNumber(totalCalculado) }}</span> <small
					class="text-success m-b block">Ventas Totales</small>
			</div>
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
								<!-- <th>Pedido</th> -->
								<th>Id Cliente</th>
								<th>Nombre Cliente</th>
								<th>Total</th>
								<th>%</th>
								<th>% Acumulado</th>
                                <!-- <th>Saldada</th> -->
                                <!-- <th>Saldo</th> -->
                                <!-- <th>Estado</th> -->
								<!-- <th>Fecha Captura</th> -->
								<!-- <th>Recoge/Entrega</th> -->
								<!-- <th>Nombre Promotor</th> -->
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
