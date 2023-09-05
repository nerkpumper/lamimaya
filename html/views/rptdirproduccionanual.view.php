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


<div class="modal" tabindex="-1" role="dialog" id="modalWait">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cargando informaci&oacuten</h4>
      </div>
      <div class="modal-body">
        <p>Por favor espere</p>
        <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    <span class="sr-only">100% Complete (danger)</span>
  </div>
</div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php 
$anioActual = date("Y");

?>
<form v-show="showAnio" method="get" class="form-horizontal">
    <div class="form-group">
    	<label class="col-sm-2 control-label">Seleccione A&ntilde;o</label>
    
    	<div class="col-sm-2">
    		<select v-model="year" class="form-control m-b" name="account">
    			<option value="<?php echo $anioActual; ?>" select><?php echo $anioActual?></option>
    			<?php 
    			 
    			for($anio = $anioActual - 1 ; $anio >=2018 ; $anio --)
    			{
    			    echo "<option value=\"". $anio."\" >".$anio."</option>";
    			}
    			 
    			
    			?>
    		</select>
    		
    	</div>
    	<div class="col-sm-2"> <button @click.prevent="cargarProduccionAnual" class="btn btn-primary" >Obtener informaci&oacute;n</button> </div>
    </div>
</form>	


<div v-show="showAnio" class="ibox-content m-b-sm border-bottom">
	<div  id="chartAnio" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
	<hr>
	<div class="row">				
		<?php Form::btnExportarExcel("sendToExcelAnio"); ?>
	</div>
	
	
	<div class="table-responsive">
		<table id="tblReporteAnio" class="table table-striped">
			<thead>
				<tr>
					<th>ID Rollo</th>
					<th>C&oacute;digo</th>
					<th>Descripci&oacute;n</th>
					<th v-if="month >= 1">Enero</th>
					<th v-if="month >= 2">Febrero</th>
					<th v-if="month >= 3">Marzo</th>
					<th v-if="month >= 4">Abril</th>
					<th v-if="month >= 5">Mayo</th>
					<th v-if="month >= 6">Junio</th>
					<th v-if="month >= 7">Julio</th>
					<th v-if="month >= 8">Agosto</th>
					<th v-if="month >= 9">Septiembre</th>
					<th v-if="month >= 10">Octubre</th>
					<th v-if="month >= 11">Noviembre</th>
					<th v-if="month >= 12">Diciembre</th>
					<th>Total</th>								
				</tr>
			</thead>
			<tbody id="tblReporteBodyAnio">
				<tr v-for="r in rollosyear">
					<td>{{ r.idRollo }}</td>
					<td>{{ r.codigo }}</td>
					<td>{{ r.descauto }}</td>
					<td v-if="month >= 1">{{ r.m01 }}</td>
					<td v-if="month >= 2">{{ r.m02 }}</td>
					<td v-if="month >= 3">{{ r.m03 }}</td>
					<td v-if="month >= 4">{{ r.m04 }}</td>
					<td v-if="month >= 5">{{ r.m05 }}</td>
					<td v-if="month >= 6">{{ r.m06 }}</td>
					<td v-if="month >= 7">{{ r.m07 }}</td>
					<td v-if="month >= 8">{{ r.m08 }}</td>
					<td v-if="month >= 9">{{ r.m09 }}</td>
					<td v-if="month >= 10">{{ r.m10 }}</td>
					<td v-if="month >= 11">{{ r.m11 }}</td>
					<td v-if="month >= 12">{{ r.m12 }}</td>
					<td>{{ r.total }}</td>								
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div v-show="!showAnio" class="ibox-content m-b-sm border-bottom">
	<button @click.prevent="showAnio = true" class="btn btn-primary"> <i class="fa fa-return"></i> Mostrar Gr&aacute;fica Anual</button>
	<div  id="chartMes" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
	<hr>
	<div class="row">				
		<?php Form::btnExportarExcel("sendToExcel"); ?>
	</div>
	
	
	<div class="table-responsive">
		<table id="tblReporte" class="table table-striped">
			<thead>
				<tr>
					<th>ID Rollo</th>
					<th>C&oacute;digo</th>
					<th>Descripci&oacute;n</th>
					<th>Total</th>								
				</tr>
			</thead>
			<tbody id="tblReporteBody">
				<tr v-for="r in rollos">
					<td>{{ r.idRollo }}</td>
					<td>{{ r.codigo }}</td>
					<td>{{ r.descauto }}</td>
					<td>{{ r.total }}</td>								
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php Form::frmExportarExcel();?>
<!-- <button v-show="!showAnio" @click.prevent="mostrarAnio" class="btn btn-primary" > Regresar</button> 
<div v-show="!showAnio" id="chartMes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->

