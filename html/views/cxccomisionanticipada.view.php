<?php

echo "hola";return;

$titlePage = "CxC";
$breadCum = "Promotores/Manejo de Comisiones";
 $_lugar = LUGAR_CXC_COMISIONESANTICIPADAS;

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript = "
    
		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
		    
		";

?>

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
	<button @click.prevent="refresh" class="btn btn-primary"><i class="fa fa-refresh"></i> Refrescar Datos del Cliente</button>
	<br>
	<div class="row m-b-lg m-t-lg">

	    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<div class="file-manager">
						
						<div class="row">
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
						
						
						<div class="hr-line-dashed"></div>
                        <button @click.prevent="nuevoRegistro" class="btn btn-primary btn-block">Registrar Pago Comisi&oacute;n Anticipada</button>
						<div class="hr-line-dashed"></div>
						<h5>Corte Comisiones</h5>
						<ul v-for="cc in cortescomision" class="folder-list" style="padding: 0">
							<li ><a @click.prevent="manejarCorteComision(cc.idcortecomision)" href="#"><i class="fa fa-calendar"></i> {{ cc.idcortecomision }} - {{ cc.fecha }} <span v-show="cc.pagada == 'SI'" class="badge badge-success">PAGADA</span><span v-show="cc.pagada == 'NO' && cc.neto >0" class="badge badge-danger">PENDIENTE PAGAR</span><span v-show="cc.pagada == 'NO' && cc.neto < 0" class="badge badge-warning">NO REQUIERE PAGO</span></a></li>							
						</ul>
<!-- 						<h5 class="tag-title">Tags</h5> -->
<!-- 						<ul class="tag-list" style="padding: 0">-->
<!-- 							<li><a href="">Family</a></li> -->
<!-- 							<li><a href="">Work</a></li> -->
<!-- 							<li><a href="">Home</a></li> -->
<!-- 							<li><a href="">Children</a></li> -->
<!-- 							<li><a href="">Holidays</a></li> -->
<!-- 							<li><a href="">Music</a></li> -->
<!-- 							<li><a href="">Photography</a></li> -->
<!-- 							<li><a href="">Film</a></li> -->
<!-- 						</ul> -->
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			
	    </div>

		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
			<div v-if="!mostrarNuevoRegistro && !mostrarCorteComision">
				<h3>Selecciona un Corte de Comisi&oacute;n o Registrar Nuevo Pago</h3>
			</div>
		
			<div v-show="mostrarNuevoRegistro" >
				<div class="ibox-title"><h3>Pago de Comisi&oacute;n Anticipada</h3></div>
				<div class="ibox-content m-b-sm border-bottom">
					<div class="row">					
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group"
								v-bind:class="{'has-error': errConcepto}">
								<label class="control-label" for="price">Concepto</label> <select
									class="form-control" v-model="filtro.concepto">
									<option value="0">--Seleccione--</option>

									<?php
                                        foreach ($lstConceptos as $fp) {
                                            echo "<option value='" . $fp["idConceptoGasto"] . "'>" . $fp["nombre"] . "</option>";
                                        }
                                        
                                    ?>

<!-- 									<option value="ABONO">ABONO</option> -->
									<!-- 									<option value="CARGO">CARGO</option> -->
								</select> <span class='help-block'> <strong>{{ errConcepto
										}}</strong>
								</span>
							</div>
						</div>
    					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<div class="form-group"
								v-bind:class="{'has-error': errMonto}">
								<label class="control-label" for="price">Monto</label> <input
									type="text" v-model="filtro.monto" class="form-control text-right"
									maxlength="9" ref="monto"
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
								<span class='help-block'> <strong>{{ errMonto }}</strong>
								</span>
							</div>
						</div>
						
					</div >
					<div class="row">
					
    					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    						<div class="form-group"
									v-bind:class="{'has-error': errObservacion}">
									<label class="control-label" for="price">Observaci&oacute;n</label> <input
										type="text" v-model="filtro.observacion" class="form-control"
										maxlength="200" ref="observacion">
									<span class='help-block'> <strong>{{ errObservacion }}</strong>
									</span>
								</div>
    					</div>
    
    				</div>
    
    
    				<div class="row">
    					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    						<button @click.prevent="registrarDeduccion" class="btn btn-primary">Registrar Comisi&oacute;n Anticipada</button>
    					</div>
    				</div>
    				<hr>
    				<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
					</div>
					<div class="row">
                        <div class="table-responsive">
                            <table class="table invoice-total">
                                <tbody>
                                    <tr>
                                        <td><strong>Total :</strong></td>
                                        <td><h1 class="font-bold">$ {{ formatNumber(totalComisiones) }}</h1></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
				</div>
			</div>
			
			<div v-show="mostrarCorteComision" >
				<div class="ibox-title"><h3>Corte de Comisi&oacute;n  {{ comision.idcortecomision }} : {{ comision.fechainicio }} - {{ comision.fechafin }} <a target="_blank" :href="'<?php echo URL_BASE; ?>pagocomision/'  + comision.idcortecomision" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> Imprimir</a></h3> </div>
				<div class="ibox-content m-b-sm border-bottom">
					
					<div class="row">
						<div class="col-sm-12">
						    aqui
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
                            
                            <div class="row text-left">
                                <div class="col-xs-3">
                                    <div class="text-success m-l-md">
                                    <span class="h4 font-bold m-t block">$ {{ formatNumber(comision.total) }}</span>
                                    <small class="text-muted m-b block">Comisi&oacute;n Generada</small>
                                    </div>
                                </div>
                                <div class="text-danger col-xs-3">
                                    <span class="h4 font-bold m-t block">$ {{ formatNumber(comision.comisionadelantada) }}</span>
                                    <small class="text-muted m-b block">Deducciones</small>
                                </div>
                                <div class="text-info col-xs-3">
                                    <span class="h4 font-bold m-t block">$ {{ formatNumber(comision.apagar) }}</span>
                                    <small class="text-muted m-b block">Total a Pagar</small>
                                </div>
                                <div class="text-navy col-xs-3">
                                    <span class="h4 font-bold m-t block">$ {{ formatNumber(comision.saldo) }}</span>
                                    <small class="text-muted m-b block">Pendiente de Pagar</small>
                                </div>
    
                            </div>
                        </div>
					</div>
					<hr>
					<div v-show="comision.pagada == 'SI'">
						<div class="alert alert-success">
                               CORTE COMISI&Oacute;N &nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size: 2em">PAGADA</strong>.
                        </div>
                    </div>
					<div v-show="comision.pagada == 'NO' && comision.apagar < 0">
						<div class="alert alert-warning">
                               CORTE COMISI&Oacute;N &nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size: 2em">NO REQUIERE PAGARSE, SALDO NEGATIVO</strong>.
                        </div>
					</div>
					<div v-show="comision.saldo > 0" class="row">					
						
    					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<div class="form-group"
								v-bind:class="{'has-error': errComisionMonto}">
								<label class="control-label" for="price">Pagar</label> <input
									type="text" v-model="comision.monto" class="form-control text-right"
									maxlength="9" ref="monto"
									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
								<span class='help-block'> <strong>{{ errComisionMonto }}</strong>
								</span>
							</div>
						</div>
						
						<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    						<div class="form-group"
									v-bind:class="{'has-error': errComisionObservacion}">
									<label class="control-label" for="price">Observaci&oacute;n</label> <input
										type="text" v-model="comision.observacion" class="form-control"
										maxlength="200" ref="observacion">
									<span class='help-block'> <strong>{{ errComisionObservacion }}</strong>
									</span>
								</div>
    					</div>
						
					</div >   
    
    				<div v-show="comision.saldo > 0" class="row">
    					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    						<button @click.prevent="registrarPagoComision" class="btn btn-primary">Registrar Pago</button>
    					</div>
    				</div>
    				<hr>
    				<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
									<table id="tablaToExcel" class="table table-bordered table-hover ">
										<thead>
											<tr>

												<th>Fecha</th>
												<th>Movimiento</th>
												<th class="text-right">Saldo Actual</th>
												<th class="text-right">Monto</th>
												<th class="text-right">Saldo Nuevo</th>
												
												<th>Observaci&oacute;n</th>
												<th>Usuario</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="item in movimientos">
												<td>{{ item.fecha }}</td>
												<td>{{ item.movimiento }}</td>
												<td class="text-right">$ {{ formatNumber(item.saldoactual) }}</td>
												<td class="text-right"
													v-bind:class="['text-navy', item.movimiento == 'CARGO' ? 'text-danger' : '']">
													<strong>$ {{ formatNumber(item.monto) }}</strong>
												</td>
												<td class="text-right text-success">$ {{ formatNumber(item.saldonuevo) }}</td>
												
												<td>{{ item.observacion }}</td>
												<td>{{ item.usuario }}</td>
											</tr>

										</tbody>
									</table>
							</div>
						</div>
					</div>
					<div class="row">
                        <div class="table-responsive">
                            <table class="table invoice-total">
                                <tbody>
                                    <tr>
                                        <td><strong>Total :</strong></td>
                                        <td><h1 class="font-bold">$ {{ formatNumber(comision.saldo) }}</h1></td>
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

<!-- <pre>{{ $data }}</pre> -->