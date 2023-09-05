<?php
$titlePage = "Reportes";
$breadCum = "Inventario de Productos en Stock en Sucursales";
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
	<!-- <div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">						
				<label class="control-label" for="tipoProducto">Tipo Producto</label>			
				<select v-model="filtro.semaforo" class="form-control">
					<option value="ALL">-- Todos --</option>
					<option value="ALERTA">Productos requeridos de surtir (rojo)</option>
					<option value="ATENCION">Productos usando reserva (amarillo)</option>
					<option value="OK">Productos que no se ocupa surtir (verde)</option>
				</select>
			</div>
		</div>			
	</div> -->
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<button @click.prevent="obtenerReporte" class="btn btn-primary">Obtener</button>
		</div>
	</div>
</div>
<!-- 
<pre>
    {{ $data.columns }}
</pre> -->
<!-- 
<pre>
    {{ $data.rows }}
</pre> -->

<!-- 
<pre>
    {{ $data.filtro }}
</pre>  -->

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<div class="row">
				
					<?php Form::btnExportarExcel("sendToExcel"); ?>
				</div>
				
				
				<div class="table-responsive">
					<table id="tblReporte" class="table table-striped table-bordered">
						<thead>
							<tr>
                                <th v-for="c in columns">{{ c.col }}</th>
								
							</tr>
						</thead>
						<tbody id="tblReporteBody">
                            <tr v-for="r in rows">
                                <td v-for="d in r.data">{{ d.dato }}</td>
								
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php Form::frmExportarExcel();?>