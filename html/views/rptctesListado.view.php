<?php
$titlePage = "Reportes";
$breadCum = "Listado de Clientes X Promotor";
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

{{ filtro.nombrePromotor}} 

<div class="ibox-content m-b-sm border-bottom">
	
		<div v-show="<?php echo $mostrarListado;?>" class="row">
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="form-group">						
					<label class="control-label" for="promotor">Promotor</label>			
					<select id="selPromotor"  v-model="filtro.promotor" class="form-control">
						
						<?php 
						
							echo $lstPromotores;
						
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
								<th>Promotor</th>
								<th>Id Cliente</th>
								<th>Nombre</th>
								<th>Apellidos</th>
								<th>Empresa</th>
								<th>Domicilio1</th>
								<th>Domicilio2</th>
								<th>Numero</th>
								<th>Colonia</th>
								<th>Ciudad</th>
								<th>Telefonos</th>
								<th>EMail</th>
								<th>RFC</th>
								<th>Estatus</th>								
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