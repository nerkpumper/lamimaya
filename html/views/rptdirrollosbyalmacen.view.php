<?php

$titlePage = "Reportes";
$breadCum = "Inventario de Rollos Por Almac&eacute;n";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

$_addHead="
 			
            <link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'>
 		";

$_addScript = "
   
		
	    <script src=\"".URL_BASE."assets/inspinia/js/plugins/iCheck/icheck.min.js\"></script>
	        
	        
		";

?>

<div class="ibox-content m-b-sm border-bottom">
	
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">						
				<label class="control-label" for="tipoProducto">Almacen</label>			
				<select v-model="filtro.almacen" class="form-control">
					<option value="ALL">-- TODOS --</option>					
					<option value="ALMACEN PRINCIPAL">ALMACEN PRINCIPAL</option>
					<option value="MCM">MCM</option>
					<option value="ALPES">ALPES</option>
					<option value="CASA">CASA</option>
					<option value="NARCISO">NARCISO</option>
					<option value="DELTA">DELTA</option>
					<option value="OBRA">OBRA</option>
					<option value="LAGOS">LAGOS</option>
				</select>
			</div>
		</div>			
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding-top: 25px">
			<div class="checkbox checkbox-primary">
                                            <input id="checkbox3" type="checkbox" v-model="detallado">
                                            <label for="checkbox3">
                                                Obtener reporte detallado
                                            </label>
                                        </div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding-top: 25px">
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
				
				<h2 >
					<small>Total Existencia</small>&nbsp;&nbsp;&nbsp;&nbsp; {{ formatNumber(totalExistencia) }} KG
				</h2>
				<div class="table-responsive">
					<table id="tblReporte" class="table table-striped">
						<thead>
							<tr id="tblReporteHead">
								
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

<!-- <pre> {{ $data }}</pre> -->