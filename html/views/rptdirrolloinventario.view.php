<?php

$titlePage = "Reportes";
$breadCum = "Costo de Inventario de Rollos";
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


<!-- modal grafico -->
<div class="modal inmodal" id="modalChart" tabindex="-1" role="dialog"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
<!-- 				<i class="fa fa-shopping-cart modal-icon"></i> -->
				<h4 class="modal-title">{{ strRollo }}</h4>
				
			</div>
			<div class="modal-body">
				<div  id="chartRollos" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
				
			</div>
			<div class="modal-footer">		
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>		
				
			</div>
		</div>
	</div>
</div>
<!-- fin modal grafico -->




<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-title">
				<h3>Costo de Inventarios de Rollos</h3>	
			</div>
			<div class="ibox-content">
				
				
				<div class="row">
					<div class="col-lg-5">
                        <div class="widget style1 navy-bg">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-cubes fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Total KG</span>
                                    <h2 class="font-bold">{{ formatNumber(totalExistencia) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="widget style1 navy-bg">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-dollar fa-5x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <span> Costo Inventario Total con IVA</span>
                                    <h2 class="font-bold">{{ formatNumber(totalCostoInventario) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
				
				</div>
				<div class="row">
				
					<?php Form::btnExportarExcel("sendToExcel"); ?>
				</div>
				<div class="table-responsive">
					<table id="tblReporte" class="table table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Codigo</th>
								<th>Rollo</th>
								<th class="text-right">CU con IVA</th>
								<th class="text-right">Existencia</th>
								<th class="text-right">Costo Inventario</th>
								<th class="text-right">Total Rollos</th>
<!-- 								<th class="text-right">Rollos En Producci&oacute;n</th> -->
<!-- 								<th class="text-right">Rollos Terminados</th> -->
<!-- 								<th class="text-right">Rollos por Terminar</th> -->
								<th></th>								
							</tr>
						</thead>
						<tbody id="tblReporteBody">
							<tr v-for="(item, index) in rollos">
								<td>{{item.id}}</td>
								<td>{{item.codigo}}</td>
								<td class="text-navy"><h4>{{ item.desc }}</h4></td>
								<td class="text-right">$ {{ formatNumber(item.cu) }}</td>
								<td class="text-right">{{ item.existencia }}</td>
								<td class="text-right">$ {{ formatNumber(item.costoInventario) }}</td>
								<td class="text-right">{{ item.rollosTotal }}</td>
<!-- 								<td class="text-right">{{ item.rollosRP }}</td> -->
<!-- 								<td class="text-right">{{ item.rollosTerminados }}</td> -->
<!-- 								<td class="text-right">{{ item.rollosPorTerminar }}</td> -->
								<td>
<!-- 									<button class="btn btn-primary btn-xs"><i class="fa fa-bars"></i></button> -->
									<button @click.prevent="mostrarGraficoRollos(index)" class="btn btn-primary btn-xs"><i class="fa fa-bar-chart-o"></i></button>
								</td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php Form::frmExportarExcel();?>