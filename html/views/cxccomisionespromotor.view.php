<?php

$titlePage = "CxC";
$breadCum = "Promotores/Manejo de Comisiones";
 $_lugar = LUGAR_CXC_PROMOCOMISIONES;

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript = "

		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>

		";

?>

<!-- <pre>{{ incentivos }} </pre> -->





<div v-show="seleccionandoPromotor">



	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel-rec">
				<h3>Seleccione Promotor</h3>
				<!-- <div class="row">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<input type="text" class="form-control"	v-model="filtroNombreCliente">
					</div>
				</div> -->

				<br>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tbody>
							<tr v-for="(item, index) in promotores">
								<td class="client-avatar"><img alt="image" :src="item.img" style="width: 52px; height: 52px;"> </td>
								<td><h2>{{ item.nombre }}</h2></td>
								<td><button @click.prevent="preparePromotor(index)" class="btn btn-primary m-t">Comisiones</button></td>
							</tr>

						</tbody>
					</table>
				</div>

			</div>

		</div>
	</div>

</div>

<div v-show="!seleccionandoPromotor">
	<button @click.prevent="seleccionarOtroPromotor" class="btn btn-warning">Seleccionar Otro Promotor</button>
	<br>
	<div class="row m-b-lg m-t-lg">

	    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

	        <div class="profile-image">
	            <img :src="filtro.img" class="img-circle circle-border m-b-md" alt="profile">
	        </div>
	        <div class="profile-info">
	            <div class="">
	                <div>
	                    <h2 class="no-margins">
	                       {{ filtro.nombrePromotor }}
	                    </h2>
	                    <!-- <h4>Founder of Groupeq</h4> -->
	                    <!-- <small>
	                    There are many variations of passages of Lorem Ipsum available, but the majority
	                    have suffered alteration in some form Ipsum available.
	                </small> -->
					</div>
	            </div>
	        </div>
	    </div>

		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
			<div class="ibox-content m-b-sm border-bottom">

				<div  class="row">										
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label class="control-label">Tipo de C&aacute;lculo</label>
							<select v-model="tipoComision" class="form-control">
								<option value="NOSEL">-- Seleccione --</option>
								<option value="MENSUAL">MENSUAL</option>
								<option value="TRIMESTRAL">TRIMESTRAL</option>
								<option value="ANUAL">ANUAL</option>
							</select>
							
						</div>
					</div>
				</div>
				<div  v-if="tipoComision != 'NOSEL'" class="row">										
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div  class="form-group">
							<label class="control-label">A&ntilde;o</label>
							<select v-model="anio" class="form-control">
								<option value="0">-- Seleccione --</option>
								<?php
								$anioActual = date('Y');

								for ($anio = $anioActual; $anio >= $anioActual - 3; $anio--){
									echo "<option value='".$anio."'>".$anio."</option>";
								}
								?>								
							</select>							
						</div>
						
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div v-if="tipoComision == 'MENSUAL'" class="form-group">
							<label class="control-label">Mes</label>
							<select v-model="mes" class="form-control">
								<option value="0">-- Seleccione --</option>
								<option value="1">ENERO</option>
								<option value="2">FEBRERO</option>
								<option value="3">MARZO</option>
								<option value="4">ABRIL</option>
								<option value="5">MAYO</option>
								<option value="6">JUNIO</option>
								<option value="7">JULIO</option>
								<option value="8">AGOSTO</option>
								<option value="9">SEPTIEMBRE</option>
								<option value="10">OCTUBRE</option>
								<option value="11">NOVIEMBRE</option>
								<option value="12">DICIEMBRE</option>								
							</select>							
						</div>
						<div v-if="tipoComision == 'TRIMESTRAL'" class="form-group">
							<label class="control-label">Trimestre</label>
							<select v-model="trimestre" class="form-control">
								<option value="0">-- Seleccione --</option>
								<option value="1">ENERO-MARZO</option>
								<option value="2">ABRIL-JUNIO</option>
								<option value="3">JULIO-SEPTIEMBRE</option>
								<option value="4">OCTUBRE-DICIEMBRE</option>								
							</select>							
						</div>
					</div>
				</div>
				
				<div v-show="false"  class="row">										
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
						<button @click.prevent="obtenerReporte" class="btn btn-primary">Obtener Comisiones Generadas y Comisiones Adelantadas</button>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-9">
						<div class="ibox float-e-margins" style="background: #f9f2f4f8">
							<div class="row text-left">

								<div class="col-xs-3 text-navy">
									<div class=" m-l-md">
									<span class="h4 font-bold m-t block">$ {{ formatNumber(netoAPagar) }}</span>
									<small class="text-muted m-b block">Neto a Pagar</small>
									</div>
								</div>
								
			<!-- 					<div class="col-xs-2 text-warning"> -->
			<!-- 						<span class="h4 font-bold m-t block">$ {{ formatNumber(comisionTotalPagadas) }}</span> -->
			<!-- 						<small class="text-muted m-b block">Comisi&oacute;n Pagada</small> -->
			<!-- 					</div> -->
								
								<div class="col-xs-3 text-success">
									<span class="h4 font-bold m-t block">$ {{ formatNumber(comisionTotalPorPagarPorPeriodo) }}</span>
									<small class="text-muted m-b block">Comisi&oacute;n</small>
								</div>

								<div class="col-xs-3 text-success">
									<span class="h4 font-bold m-t block">$ {{ formatNumber(incentivoNeto) }}</span>
									<small class="text-muted m-b block">Incentivo </small>
								</div>


								<div class="col-xs-3 text-danger">
									<span class="h4 font-bold m-t block">$ {{ formatNumber(totalDeducciones) }}</span>
									<small class="text-muted m-b block">Deducciones</small>
								</div>




							</div>	
						</div>
					</div>
					<div class="col-lg-3">
						<div class="row text-left">

							<div class="col-lg-12 text-danger">
								<span class="h4 font-bold m-t block">$ {{ formatNumber(comisionTotalPendiente) }}</span>
								<small class="text-muted m-b block">Comisi&oacute;n Pendiente</small>
							</div>
						</div>
					</div>
				
				</div>
				

			</div>
		</div>


	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    <div class="ibox float-e-margins">
		        <div class="ibox-title">
		            <h5>Comisiones de Pedidos Saldados <small class="m-l-sm">{{ filtro.fechaInicio }} - {{ filtro.fechaFin }}</small></h5>
		            <div class="ibox-tools">
		                <!-- <a class="collapse-link">
		                    <i class="fa fa-chevron-up"></i>
		                </a> -->
		                <!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		                    <i class="fa fa-wrench"></i>
		                </a>
		                <ul class="dropdown-menu dropdown-user">
		                    <li><a href="#">Config option 1</a>
		                    </li>
		                    <li><a href="#">Config option 2</a>
		                    </li>
		                </ul>
		                <a class="close-link">
		                    <i class="fa fa-times"></i>
		                </a> -->
		            </div>
		        </div>

		        <div  class="ibox-content">
					<button @click.prevent="toogleGrafico" class="btn btn-primary btn-xs"><span v-show="mostrarGrafico"> Ocultar Gr&aacute;fico</span><span v-show="!mostrarGrafico"> Mostrar Gr&aacute;fico</span></button>
					<div v-show="mostrarGrafico">
						<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
					</div>

					<div class="row">


						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php Form::btnExportarExcel("sendToExcel"); ?>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h3>Listado Pedidos Saldados/Comisi&oacute;n</h3>
							<div class="table-responsive">
								<table id="tblReporte" class="table table-striped">
									<thead>
										<tr>
											<th>Pedido</th>
											<th></th>
											<th>Id Cliente</th>
											<th>Nombre Cliente</th>
											<th>Total</th>
											<th>Comisiones</th>
											<th>Estado</th>
											<th>Fecha Captura</th>
											<th>Saldada</th>
											<th>Fecha Saldada</th>
                                            <th>Corte Comisi&oacute;n</th>
                                            <th>Corte Comisi&oacute;n Venta</th>
<!--                                             <th>Comisi&oacute;n Pagada</th> -->
											<!-- <th>Saldo</th> -->
										</tr>
									</thead>
									<tbody >


											<tr v-for='item in pedidos' >
												<td>{{ item.idPedido }}</td>
												<td class="client-status">
													<span v-show="item.miCliente == 'SI'" class="badge badge-primary">Mi Cliente</span>
													<span v-show="item.miCliente == 'NO'" class="badge badge-warning">De Otro</span>
												</td>
												<td>{{ item.idCliente }}</td>
												<td>{{ item.nombreCliente }}</td>
												<td :class="'text-right ' + (item.comisionpagada == 'NO' ? 'text-navy' : 'text-success')">{{ (item.total) }}</td>
												<td :class="'text-right ' + (item.comisionpagada == 'NO' ? 'text-navy' : 'text-success')">{{ (item.comisiones) }} 
<!-- 													<button class="btn btn-info btn-xs"><i class="fa fa-list-ol"></i></button>  -->
												</td>
												<td>{{ item.estado }}</td>
												<td>{{ item.fechaCaptura }}</td>
												<td>{{ item.saldada }}</td>
												<td>{{ item.fechaSaldada }}</td>
                                                <td>{{ item.idCorteComision }}</td>
                                                <td>{{ item.idCorteComisionVendedor }}</td>
<!--                                                 <td>{{ item.comisionpagada }}</td> -->
												<!-- <td>{{ item.saldo }}</td> -->
											</tr>

									</tbody>
								</table>
							</div>
							<div v-show="pedidos.length == 0 " class="alert alert-info">
                                No hay Pedidos para mostrar
                            </div>
						</div>


					</div>
					<div class="row">
					    <div class="col-lg-6">
							<div class="panel panel-primary">
	                            <div class="panel-heading">
    								OBJETIVO ALCANZADO
                                </div>
                                <div class="panel-body">
								<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<td>TIPO :</td>
													<td><h3 class="font-bold text-success">{{ strTipoObjetivo}}</h3></td>
												</tr>
												<tr>
													<td>OBJETIVO VENTA :</td>
													<td><h3 class="font-bold  text-success">$ {{ formatNumber(objetivoParaIncentivo) }}</h3></td>
												</tr>
												<tr>
													<td>VENTAS LOGRADAS AUTORIZADAS :</td>
													<td><h3 class="font-bold text-success">$ {{ formatNumber(totalPedidosDatoVenta) }}</h3></td>
												</tr>

												<tr>
													<td>OBJETIVO A ALCANZAR :</td>
													<td><h3 v-show="this.tipoComision == 'MENSUAL'" class="font-bold text-success">$ {{ formatNumber(incentivo) }}</h3> <h6 v-if="incentivoTopado"  class="text-navy"> OBJETIVO TOPADO</h6></td>
												</tr>

												<tr>
													<td>% VENTA LOGRADO :</td>
													<td><h3 class="font-bold text-success">{{ formatNumber(objetivoPorcentaje) }}%</h3></td>
												</tr>
												
											

												
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-primary">
	                            <div class="panel-heading">
    								COMISI&Oacute;N E INCENTIVO
                                </div>
                                <div class="panel-body">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												
												<tr>
													<td>PEDIDOS SALDADOS :</td>
													<td><h4 class="font-bold  text-success">$ {{ formatNumber(totalPedidos) }}</h4></td>
												</tr>

												<tr>
													<td><strong>COMISI&Oacute;N GENERADA :</strong></td>
													<td><h3 class="font-bold ">$ {{ formatNumber(comisionTotalPorPagarPorPeriodo) }}</h3></td>
												</tr>
												<!-- <tr>
													<td><strong>INCENTIVO ALCANZADO :</strong></td>
													<td><h2 class="font-bold">$ {{ formatNumber(incentivo) }}</h2></td>
												</tr> -->
												<tr>
													<td><strong>INCENTIVO ALCANZADO :</strong></td>
													<td><h3 class="font-bold ">$ {{ formatNumber(incentivoNeto) }}</h3></td>
												</tr>

												<tr>
													<td><h2><strong>INGRESO TOTAL :</strong></h2></td>
													<td><h2 class="font-bold ">$ {{ formatNumber(incentivoNeto + comisionTotalPorPagarPorPeriodo)}}</h2></td>
												</tr>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
                    
                    <hr>
                    
                   
    				<div class="row">
    					<h3>Deducciones {{ filtro.fechaInicio }} - {{ filtro.fechaFin }}</h3>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-hover margin bottom">
    								<thead>
    									<tr>										
    										<th></th>
    										<th>Concepto</th>
    										<th>Fecha</th>
    										<th>Observaci&oacute;n</th>
    										<th class="text-right">Monto</th>
    										
    									</tr>
    								</thead>
    								<tbody>
    									<tr v-for="item in comisionesanticipadas">
    										<td class="text-center"><span v-show="item.tipo == 'DEDUCIR' " class="label label-warning">{{ item.tipo }}</span></td>
    										<td>{{ item.concepto }}</td>
    										<td>{{ item.fecha }}</td>										
    										<td>{{ item.observacion }}</td>
    										<td class="text-right text-success">$ {{ formatNumber(item.monto) }} </td>
    
    									</tr>
    									
    								</tbody>
    							</table>
							</div>
							<div v-show="comisionesanticipadas.length == 0 " class="alert alert-info">
                                No hay Comisiones Anticipadas para mostrar
                            </div>
							
						</div>
					</div>
					<div class="row">
                        <div class="table-responsive">
                            <table class="table invoice-total">
                                <tbody>
                                    <tr>
                                        <td><h2><strong>DEDUCCIONES :</strong></h2></td>
                                        <td><h2 class="font-bold">$ {{ formatNumber(totalDeducciones) }}</h2></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table invoice-total">
                                <tbody>
                                    <tr>
                                        <td><h2><strong>NETO A PAGAR :</strong></h2></td>
                                        <td><h2 class="font-bold">$ {{ formatNumber(netoAPagar) }}</h2></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <button v-show=" mostrarBotonGeneraCorteComision" @click.prevent="generaCorteComision" class="btn btn-primary btn-block">Generar Corte de Comisi&oacute;n de los Pedidos Listados</button>
                        </div>
                    </div>

		        </div>
		    </div>
		</div>

	</div>


</div>

<?php Form::frmExportarExcel();?>


<!-- <pre>{{ $data }}</pre> -->
<!-- <pre>{{ $data.pedidos }}</pre> -->