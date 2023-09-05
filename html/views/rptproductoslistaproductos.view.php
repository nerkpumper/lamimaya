<?php
$titlePage = "Reportes";
$breadCum = "Lista de Productos";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'> 		
 		";

$_addScript=" 		
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
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

<!-- <pre>{{ $data.filtro }}</pre> -->

<div class="ibox-content m-b-sm border-bottom">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">						
				<label class="control-label" for="tipoProducto">Tipo Producto</label>			
				<select v-model="filtro.tipoProducto" class="form-control">
					
					<?php 
					
						echo $lstTiposProducto;
					
					?>
				</select>
			</div>
		</div>	
		<div v-show="filtro.tipoProducto != 5" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">		
				<label class="control-label" for="aplicacion">Aplicaci&oacute;n</label>			
				<select v-model="filtro.aplicacion" class="form-control">
					<?php 
						echo $lstModelosLamina;
					?>
				</select>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">		
				<label class="control-label" for="material">Material</label>			
				<select v-model="filtro.material" class="form-control">
					<?php 
						echo $lstMateriales;					
					?>
				</select>
			</div>
		</div>
		<div v-show="filtro.tipoProducto != 5" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">		
				<label class="control-label" for="unidad">Unidad</label>			
				<select v-model="filtro.unidad" class="form-control">
					<?php 
						echo $lstUnidades;
					?>
				</select>
			</div>
		</div>
		<div v-show="filtro.tipoProducto == 5" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">		
				<label class="control-label" for="unidad">Proveedor</label>			
				<select v-model="filtro.proveedor" class="form-control">
					<?php 
						echo $lstProveedor;
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
								<th><span v-if="filtro.tipoProducto == 5">Id Rollo</span><span v-else>Id Producto</span></th>
								
								<th>C&oacute;digo</th>
								<th>Tipo Producto</th>
								<th>Aplicaci&oacute;n</th>
								<th>Material</th>
								<th>Unidad</th>
								<th>Calibre</th>
								<th>Pies</th>
								<th>Descripci&oacute;n</th>
								<th>Existencia Fisica</th>
								<th>Existencia Disponible</th>
								<th>Precio R1</th>
								<th>Precio R2</th>
								<th>Precio R3</th>
								<th>Precio R4</th>
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