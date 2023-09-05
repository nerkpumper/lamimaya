<?php
$titlePage = "Precios en Cascada";
$breadCum = "Productos/Precios en Cascada";

// $_lugar = LUGAR_PRODUCCION_VALESALIDAGENERAR;



$_addHead=" 		
 		<link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		 		
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>
 		";

?>


<!-- <div v-show="seleccionarPedido"> -->
<div v-show="seleccionarRollo">

	<div class="ibox-content m-b-sm border-bottom">
		<div class="row">
			
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="form-group">			
					<label class="control-label" for="status">Material</label> 
					
					<select v-model="seleccionado.material" class="form-control">
						<option value='0'>-- Todos --</option>
						
						<?php echo $opcionesMateriales; ?>
						
					</select>
				</div>
			</div>			
			
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="form-group">			
					<label class="control-label" for="status">Proveedor</label> 
					
					<select v-model="seleccionado.proveedor" class="form-control">
						<option value='0'>-- Todos --</option>
						
						<?php echo $opcionesProveedores; ?>
						
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<button @click.prevent="filtrar" class="btn btn-primary">Filtrar</button>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>IdRollo</th>
							<th>C&oacute;digo</th>
							<th>Descripci&oacute;n</th>
							<th>Origen</th>
							<th>Acci&oacute;n</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in rollos">
							<td>{{ item.id }}</td>
							<td><h4 class="text-navy">{{ item.codigo }}</h4></td>
							<td><h4>{{ item.desc }}</h4></td>
							<td>{{ item.origen }}</td>
							<td><button class="btn btn-primary btn-sm" @click.prevent="cargarDatosRollo(item.id)">Obtener Costo Fab. y P.V.</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	
	</div>


</div>


<div v-show="!seleccionarRollo">	
	<button @click.prevent="seleccionarNuevoRollo" class="btn btn-warning">Seleccionar Otro Rollo</button>	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>COSTO DE FABRICACION Y PRECIO DE VENTA</h5>
	<!-- 				<span class="label label-primary">IN+</span> -->
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
	<!-- 					</a> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i -->
	<!-- 						class="fa fa-wrench"></i> -->
	<!-- 					</a> -->
	<!-- 					<ul class="dropdown-menu dropdown-user"> -->
	<!-- 						<li><a href="#">Config option 1</a></li> -->
	<!-- 						<li><a href="#">Config option 2</a></li> -->
	<!-- 					</ul> -->
	<!-- 					<a class="close-link"> <i class="fa fa-times"></i> -->
						</a>
					</div>
				</div>
				<div class="ibox-content">
	
					<h2 class="text-navy">{{ seleccionado.rollo }}</h2>
	
	
					<div class="row">
					
						<!-- Características del Rollo -->
						<div class="col-lg-3">
							<div class="panel panel-default">
								<div class="panel-heading">Caracter&iacute;sticas</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table ">					
											<tbody>
												<tr>
													<td>
														RECUBRIMIENTO
													</td>
													<td>
														<h3>{{ campos.recubrimiento }}</h3>
													</td>
												</tr>
												<tr>
													<td>
														CALIBRE
													</td>
													<td>
														<h3>{{ campos.calibre }}</h3>
													</td>
												</tr>
												<tr>
													<td>
														ANCHO (PIES)
													</td>
													<td>
														<h3>{{ campos.pies }}</h3>
													</td>
												</tr>
												<tr>
													<td>
														ORIGEN
													</td>
													<td>
														<h3>{{ campos.origen }}</h3>
													</td>
												</tr>
												<tr>
													<td>
														PROVEEDOR
													</td>
													<td>
														<h3>{{ campos.proveedor }}</h3>												
													</td>
												</tr>
																					
											</tbody>
										</table>
									</div>
								</div>
	
							</div>
						</div>
						<!-- Fin Características del Rollo -->
					
						<!-- Rollo 1-->
						<div class="col-lg-3">
							<div class="panel panel-default">
								<div class="panel-heading">Rollo</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table ">					
											<tbody>
												<tr>
													<td>
														IVA %
													</td>
													<td class="text-right"> 
														<h3 v-show="!editing">{{ campos.iva }} %</h3> 
														<div v-show="editing">
															<input v-model="campos.iva" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
															
														</div>
													</td>
												</tr>
												<tr>
													<td>
														PROD./MES (kg)
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.prodmes }}</h3> 
														<div v-show="editing">
															<input v-model="campos.prodmes" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
												</tr>
												<tr>
													<td>
														PORC. DE UTILIDAD %
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.porutilidad }} %</h3> 
														<div v-show="editing">
															<input v-model="campos.porutilidad" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
																
														</div>
													</td>
												</tr>
												<tr>
													<td>
														PORC. DE COMISION %
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.porcomision }} %</h3> 
														<div v-show="editing">
															<input v-model="campos.porcomision" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
																
														</div>
													</td>
												</tr>
												<tr>
													<td>
														DESCUENTO %
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.descuento }} %</h3> 
														<div v-show="editing">
															<input v-model="campos.descuento" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
																
														</div>
													</td>
												</tr>
												<tr>
													<td>
														COSTO FLETE/KG
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.costoflete }}</h3> 
														<div v-show="editing">
															<input v-model="campos.costoflete" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
												</tr>
												<tr>
													<td>
														COSTO/KG (SIN IVA)
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.costokg }}</h3> 
														<div v-show="editing">
															<input v-model="campos.costokg" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
												</tr>										
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- Fin Rollo 1-->
						
						
						
						<!-- Datos Rollo 2-->					
						<div class="col-lg-6">
							<div class="panel panel-default">
								<div class="panel-heading">Rollo</div>
								<div class="panel-body">
									<div class=" table-responsive">
									
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>CONCEPTO</th>
													<th>PESO (kg/mt.)</th>
													<th>C.U. (con IVA)</th>
													<th>IMPORTE</th>
													<th>% PARTICIP.</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th>L&Aacute;MINA</th>
													<td class="text-right">
														<h3>{{ campos.pesokgmt }}</h3>	
														<span v-show="pesokgmtDeTabla != campos.pesokgmt " class="text-danger">El valor de <strong>PESO (kg/mt.) </strong> almacenado no coincide con la TABLA DE PESO/MT. Pulse <button @click.prevent="swappesokgmt" class="btn btn-primary btn-xs">aqu&iacute;</button> para cambiarlo temporalmente al valor de la tabla, deber&aacute; Guardar para que el valor quede almacenado.</span>
														<span v-show="debeGuardarPesoKgMt" class="text-danger">Recuerde que debe <strong>Guardar</strong> para que el cambio de este valor quede registrado.</span>
													</td>
													<td class="text-right">
														<h3>{{ campos.pesocu }}</h3>	
													</td>
													<td class="text-right">
														<h3>{{ campos.pesoimporte }}</h3>	
													</td>
													<td class="text-right">
														<h3>{{ campos.pesoparti }} %</h3>	
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									
								    <div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>CONCEPTO</th>
													<th>$/MES sin IVA</th>
													<th>$/kg con IVA</th>	
													<th></th>										
													<th>% PARTICIP.</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														M.O.D.
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.mod }} </h3> 
														<div v-show="editing">
															<input v-model="campos.mod" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
													<td class="text-right">
														<h3>{{ campos.modiva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.modparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
														M.O.I.
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.moi }} </h3> 
														<div v-show="editing">
															<input v-model="campos.moi" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
													<td class="text-right">
														<h3>{{ campos.moiiva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.moiparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
														GASTOS DE FAB.
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.gastosfab }} </h3> 
														<div v-show="editing">
															<input v-model="campos.gastosfab" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
													<td class="text-right">
														<h3>{{ campos.gastosfabiva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.gastosfabparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
														COMISIONES
													</td>
													<td class="text-right">
														<h3>{{ campos.comisiones }}</h3>
													</td>
													<td class="text-right">
														<h3>{{ campos.comisionesiva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.comisionesparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
														GASTOS DE VENTA
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.gastosventa }} </h3> 
														<div v-show="editing">
															<input v-model="campos.gastosventa" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
													<td class="text-right">
														<h3>{{ campos.gastosventaiva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.gastosventaparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
														GASTOS FINANCIEROS
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.gastosfinancieros }} </h3> 
														<div v-show="editing">
															<input v-model="campos.gastosfinancieros" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
													<td class="text-right">
														<h3>{{ campos.gastosfinancierosiva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.gastosfinancierosparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
														GASTOS DE ADMON
													</td>
													<td class="text-right">
														<h3 v-show="!editing">{{ campos.gastosadmon }} </h3> 
														<div v-show="editing">
															<input v-model="campos.gastosadmon" type="text"
																class="form-control text-right" maxlength="10"
																oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
														</div>
													</td>
													<td class="text-right">
														<h3>{{ campos.gastosadmoniva }}</h3>												
													</td>
													<td></td>
													<td class="text-right">
														<h3>{{ campos.gastosadmonparti }} %</h3>												
													</td>
												</tr>
												<tr>
													<td>
													</td>
													<td class="text-right">
														<h3>{{ campos.totalessummes }}</h3>
													</td>
													<td class="text-right">
														<h3>{{ campos.totalessumkg }}</h3>
													</td>
													<td></td>
													<td>
													</td>
													
												</tr>
												<tr>
													<td>
													</td>
													<td>
														
													</td>
													<td>
														
													</td>
													<td class="text-right"><h3>{{ campos.totalespeso }}</h3></td>
													<td class="text-right">
														<h3>{{ campos.totalesfab }} %</h3>
													</td>
													
												</tr>
												
												<tr>
<!-- 													<td> -->
<!-- 													</td> -->
													<td  class="text-right" colspan="3">
														<h3>COSTO DE FAB (CON IVA)</h3>
														
													</td>
													
													<td class="text-right"><h3>{{ campos.totalcostofab }}</h3></td>
													<td>
													</td>
													
												</tr>
												<tr v-show="editing" >
<!-- 													<td> -->
<!-- 													</td> -->
													<td  class="text-right" colspan="3">
														<h3>PRECIO DE VENTA (CON IVA)</h3>
														
													</td>
														
													</td>
													<td class="text-right"><h3>{{ formatNumber(campos.totalpreciovta) }}</h3></td>
													<td>
													</td>
													
												</tr>
												<tr v-show="editing" >
<!-- 													<td> -->
<!-- 													</td> -->
													<td  class="text-right" colspan="3">
														<h3>PRECIO DE VENTA (CON IVA) Rango 2</h3>
														
													</td>
														
													</td>
													<td class="text-right"><h3>{{ formatNumber( campos.totalpreciovtaR2) }}</h3></td>
													<td>
													</td>
													
												</tr>
												<tr v-show="editing" >
<!-- 													<td> -->
<!-- 													</td> -->
													<td  class="text-right" colspan="3">
														<h3>PRECIO DE VENTA (CON IVA) Rango 3</h3>
														
													</td>
														
													</td>
													<td class="text-right"><h3>{{ formatNumber(campos.totalpreciovtaR3) }}</h3></td>
													<td>
													</td>
													
												</tr>
												
											</tbody>
										</table>							
									</div>
								</div>
							</div>
						</div>	
						<!-- Fin Datos Rollo 2-->				
					</div>
					
<!-- 					Botones activar edición -->
					<div class="row">
						<div class="col-xs-6">
							<button v-show="!editing" @click.prevent="activarEdicion" class="btn btn-primary btn-block btn-lg">Activar Edici&oacute;n</button>
							<button v-show="editing" @click.prevent="cancelarEdicion"class="btn btn-warning btn-block btn-lg">Cancelar Edici&oacute;n</button>
						</div>
						<div class="col-xs-6">							
							<button v-show="editing" @click.prevent="simularValores" class="btn btn-success btn-block btn-lg">Simular</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
			
	<div v-show="!editing" class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Productos Derivados del Rollo</h5>
	<!-- 				<span class="label label-primary">IN+</span> -->
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
	<!-- 					</a> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i -->
	<!-- 						class="fa fa-wrench"></i> -->
	<!-- 					</a> -->
	<!-- 					<ul class="dropdown-menu dropdown-user"> -->
	<!-- 						<li><a href="#">Config option 1</a></li> -->
	<!-- 						<li><a href="#">Config option 2</a></li> -->
	<!-- 					</ul> -->
	<!-- 					<a class="close-link"> <i class="fa fa-times"></i> -->
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<!-- 	Precios calculados -->
					<div class="row">
						<div class="col-lg-3">
							<div class="widget style1 navy-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-dollar fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Precio 1</span>
										<h2 class="font-bold">{{ formatNumber(campos.totalpreciovta) }}</h2>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="widget style1 navy-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-dollar fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Precio 2 </span>
										<h2 class="font-bold">{{ formatNumber(campos.totalpreciovtaR2) }}</h2>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="widget style1 navy-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-dollar fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Precio 3 </span>
										<h2 class="font-bold">{{ formatNumber(campos.totalpreciovtaR3 )}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					
<!-- 					Productos -->

					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="panel panel-info ">
									<div class="panel-heading">Productos Derivados del Rollo</div>
									<div class="panel-body">
										<div class=" table-responsive">
										
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>Id</th>
														<th>C&oacute;digo</th>
														<th>Descripci&oacute;n</th>
														<th>Unidad</th>
														<th>M (KG)</th>
														<th>Heredar</th>
														<th>Precio 1</th>
														<th>Precio 2</th>
														<th>Precio 3</th>
													</tr>
												</thead>
												<tbody>
													<tr v-for="(item, index) in productos">
														<td class="text-right">
															<h3>{{ item.idProducto }}</h3>
														</td>
														<td><h3 class="text-navy">{{ item.codigo }}</h3></td>
														<td><h3>{{ item.descripcion }}</h3></td>
														<td>{{ item.shortunidad }}</td>
														<td class="text-right">
															<span v-show="item.unidad != 4">-</span>
															<span v-show="item.unidad == 4">{{ item.ml }}</span>
														</td>
														<td>
															<div class="checkbox checkbox-primary" @click.prevent="clickHeredar(index)">
																<input :id="'chk' + item.idProducto " type="checkbox"  v-model="item.heredarPrecio" > 
																<label :for="'chk' + item.idProducto">  </label>
															</div>
														</td>
														<td style="width: 10%" class="text-right">
															<h3 v-show="item.heredarPrecio">{{ item.precio1 }} </h3> 
															<div v-show="!item.heredarPrecio">
																<input v-model="item.precio1" type="text"
																	class="form-control text-right" maxlength="10"
																	oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
															</div>
															<span  class="text-navy">Actual: <strong>{{ item.originalprecio1 }}</strong></span>
														</td>
														<td style="width: 10%" class="text-right">
															<div v-show="!item.isRango">-
															</div>
															<div v-show="item.isRango">
																<h3 v-show="item.heredarPrecio">{{ item.precio2 }} </h3> 
																<div v-show="!item.heredarPrecio">
																	<input v-model="item.precio2" type="text"
																		class="form-control text-right" maxlength="10"
																		oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
																</div>
																<span  class="text-navy">Actual: <strong>{{ item.originalprecio2 }}</strong></span>
															</div>
															
														</td>
														<td style="width: 10%" class="text-right">
															<div v-show="!item.isRango">-
															</div>
															<div v-show="item.isRango">
																<h3 v-show="item.heredarPrecio">{{ item.precio3 }} </h3> 
																<div v-show="!item.heredarPrecio">
																	<input v-model="item.precio3" type="text"
																		class="form-control text-right" maxlength="10"
																		oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
																</div>
																<span  class="text-navy">Actual: <strong>{{ item.originalprecio3 }}</strong></span>
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
					
<!-- 					<div class="row"> -->
<!-- 						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 							<div class="panel panel-info "> -->
<!-- 									<div class="panel-heading">Productos Stock</div> -->
<!-- 									<div class="panel-body"> -->
<!-- 									</div> -->
<!-- 							</div> -->
<!-- 						</div> -->
						
<!-- 					</div> -->
					
<!-- 					<div class="row"> -->
<!-- 						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 							<div class="panel panel-info "> -->
<!-- 									<div class="panel-heading">Producto Rollo</div> -->
<!-- 									<div class="panel-body"> -->
<!-- 									</div> -->
<!-- 							</div> -->
<!-- 						</div> -->
						
<!-- 					</div> -->
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button  @click.prevent="guardarTodo" class="btn btn-success btn-block btn-lg">Guardar Cambios a Variables de Rollos y Precios</button>
					</div>
				</div>
				
				
				
			</div>
		</div>
	</div>
	
	

	

</div>

<!-- <pre> -->
	
	
<!-- 	{{ $data.campos }} -->

<!-- </pre> -->

<!-- <pre> -->
<!-- {{ $data.productos }} -->
<!-- </pre> -->