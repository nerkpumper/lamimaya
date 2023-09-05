<?php
// $_showPageHeading = false;

$titlePage = "Monitor Existencias Rollos/Productos ";
$breadCum = "Administraci&oacute;n/Monitor/Existencias Rollos-Productos";
$_lugar = LUGAR_ADMINISTRACION_DASHBOARDS_MONITOREXISTENCIAS;

$_addScript="
 		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
 		<script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
 		";
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="tabs-container">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab-1"> Rollos</a></li>
				<li class=""><a data-toggle="tab" href="#tab-2"> Productos Stock</a></li>
			</ul>
			<div class="tab-content">
				<div id="tab-1" class="tab-pane active">
					<div class="panel-body">
						<h3>Relaci&oacute;n de Existencia/Apartado por Rollo</h3>
						<div>
							<button @click.prevent="obtenerInfoRollos" class="btn btn-primary">Obtener/Refrescar</button>
							<?php Form::btnExportarExcel("sendToExcelRollos");?>
						</div>
						
						<br>
						<br>
						<div class="table-responsive">
							<table id="tblRollos" class="table table-bordered table-striped">
								<thead>
									<th>Rollo</th>
									<th>Material</th>
									<th>Proveedor</th>
									<th>Calibre</th>
									<th>Pies</th>									
									<th class="text-right">KG Existencia</th>
									<th style="display:none;" class="text-right">Apartados</th>
									<th style="display:none;" class="text-right">Porcentaje Apartado</th>
									<th class="text-right">KG Apartados</th>
								</thead>
								<tbody>
									<tr v-for="(rollo,index) in infoRollos">
										<td class="text-navy"><h3>{{ rollo.descripcion }}</h3></td>
										<td>{{ rollo.material }}</td>
										<td>{{ rollo.proveedor }}</td>
										<td>{{ rollo.calibre }}</td>
										<td>{{ rollo.pies }}</td>
										<td class="text-right"><h3>{{ formatNumber(rollo.existencia) }}</h3></td>
										<td style="display:none;" class="text-right">{{ formatNumber(rollo.apartado) }}</td>
										<td style="display:none;" class="text-right">{{ formatNumber(rollo.porcentajeapartado) }}</td>
										<td >
											<div>
		                                        <span><strong>{{ formatNumber(rollo.apartado) }}</strong></span>
		                                        <small class="pull-right">{{ formatNumber(rollo.porcentajeapartado) }} %</small>
		                                    </div>
		                                    <div v-html="getProgressBarRollo(index)" class="progress progress-small">
		                                        <!-- <div style="width: 0.004%;" class="progress-bar"></div>-->
		                                    </div>
										</td>
									</tr>
									
									
									
								</tbody>
							</table>
						</div>					
					</div>
				</div>
				<div id="tab-2" class="tab-pane">
					<div class="panel-body">
						<h3>Relaci&oacute;n de Existencia/Apartado por Producto de Stock</h3>
						<div>
							<button @click.prevent="obtenerInfoProductos" class="btn btn-primary">Obtener/Refrescar</button>
							<?php Form::btnExportarExcel("sendToExcelProductos");?>
						</div>
                                                
						<br>
						<br>
						<div class="table-responsive">
							
							<table id="tblProductos" class="table table-bordered table-striped">
								<thead>
									<th>Producto</th>
									<th>Aplicacion</th>
									<th>Material</th>									
									<th>Calibre</th>
									<th>Pies</th>									
									<th class="text-right">Existencia</th>
									<th style="display:none;" class="text-right">Apartados</th>
									<th style="display:none;" class="text-right">Porcentaje Apartado</th>
									<th class="text-right">Apartados</th>
								</thead>
								<tbody>
									<tr v-for="(producto,index) in infoProductos">
										<td class="text-navy"><h3>{{ producto.descripcion }}</h3></td>
										<td>{{ producto.aplicacion }}</td>
										<td>{{ producto.material }}</td>										
										<td>{{ producto.calibre }}</td>
										<td>{{ producto.pies }}</td>
										<td class="text-right"><h3>{{ formatNumber(producto.existencia) }}</h3></td>
										<td style="display:none;" class="text-right">{{ formatNumber(producto.apartado) }}</td>
										<td style="display:none;" class="text-right">{{ formatNumber(producto.porcentajeapartado) }}</td>										
										<td >
											<div>
		                                        <span><strong>{{ formatNumber(producto.apartado) }}</strong></span>
		                                        <small class="pull-right">{{ formatNumber(producto.porcentajeapartado) }} %</small>
		                                    </div>		                                    
		                                    <div v-html="getProgressBarProducto(index)" class="progress progress-small">
		                                        <!-- <div style="width: 0.004%;" class="progress-bar"></div>-->
		                                    </div>
										</td>
									</tr>
									
									
									
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
			</div>


		</div>
	</div>
</div>


<?php Form::frmExportarExcel();?>