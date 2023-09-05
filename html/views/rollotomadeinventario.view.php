<?php
$titlePage = "Toma de Inventario de Rollos";
$breadCum = "Productos/Rollo/Toma de Inventario de Rollos";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_ROLLO;



$_addHead=" 		
 		<link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'>
 		";

?>

<div class="row">
	<div class="col-lg-12">
          <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Inventario Rollos</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2"> Inventario Productos Stock</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    
									<div class="row" >
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="ibox">
												<div class="ibox-content m-b-sm border-bottom">
													<div class="p-xs">
														<div class="col-lg-2 ">
															<div class="pull-left m-r-md">
																<i class="fa fa-barcode text-navy mid-icon"></i>
															</div>
														</div>
														<div class="col-lg-6">            		            		
															<div class="form-group" v-bind:class="{'has-error': errNoRollo}">
																<label class="control-label" for="noRollo"># Rollo</label> 
																	<input
																			type="text" id="noRollo" name="noRollo" v-model="noRollo"
																			ref="noRollo" placeholder="# rollo" maxlength="40"
																			v-on:keypress.enter="enlistarNoRollo"
																			class="form-control "> 
																	<span class='help-block'> 
																		<strong>{{ errNoRollo }}</strong>
																	</span>
																</label>
															</div>
														</div>
														
														
														
													</div>
													
													<div class="clearfix"></div>
												</div>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="ibox">
												<div class="ibox-content m-b-sm border-bottom">
													<div class="row">

														<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
															<h2>Toma Inventario: <strong>{{ tomaInventario }}</strong></h2>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
															<div class="form-group" v-bind:class="{'has-error': errAlmacen}">
																<label class="control-label" for="almacen">Almac&eacute;n</label> 
																<select class="form-control" v-model="almacen">
																	<option value="NS">-- Seleccione --</option>
																	<option value="ALMACEN PRINCIPAL">ALMACEN PRINCIPAL</option>
																	<option value="MCM">MCM</option>
																	<option value="ALPES">ALPES</option>
																	<option value="CASA">CASA</option>
																	<option value="NARCISO">NARCISO</option>  
																	<option value="LAGOS">LAGOS</option>    							
																</select>
																<span class='help-block'> <strong>{{ errAlmacen }}</strong>
																</span>
															</div>
														</div>

													</div>

												</div>
											</div>
										</div>
									</div>

									<div v-if="blnProcesado">
										<?php
																	
											Form::buttonPrimary ( "Nueva Recepci&oacute;n", "nuevaRecepcion" );
																	
										?>
										<br>	
										<br>
									</div>

									<!-- <button @click.prevent="addForTest" class="btn btn-primary">add for test</button> -->
									<div class="ibox"> 
										<div class="ibox-content">
											<div style="overflow-x: auto;">
												<div v-if="blnNoRegistrados" class="alert alert-danger">
													No se han registrado la recepci&oacute;n de los rollos. Favor de verificar.
												</div>

												<div class="checkbox checkbox-primary">
													<input id="chkVerCapturados" type="checkbox" v-model="chkVerCapturados" > 
													<label for="chkVerCapturados">Visualizar Inventario ya Capturado</label>
												</div>

												<table class="table table-hover no-margins">
													<thead>
														<tr>
															<th></th>
															<th># Rollo</th>
															<th>C&oacute;digo</th>
															<th>Almac&eacute;n Actual</th>
															<th>Peso Original</th>
															
<th>Existencia</th>															<th>Registro Producci&oacute;n</th>						
															<th></th>
														</tr>
													</thead>
													<tbody>
												
														<tr v-for="(item, index) in ingresosCapturados" v-if="chkVerCapturados" >
														
															<td style="background: #c9f6CC !important">
																<span 
																	class="badge badge-success">
																	INVENTARIADO
																</span>	
															
															
																
															</td>
															<td class="text-navy">
																	
																<h2>{{ item.norollo }}</h2>
															</td>
															<td>
																<span class="text-success"><strong>{{ item.codigo }}</strong></span>							
																
															</td>
															<td>
																<span class="text-success"><strong>{{ item.almacenoriginal }}</strong></span>
																
																
															</td>						
															<td class="text-navy">
																<span  class="text-success"><strong>{{ item.kilosoriginal }}</strong></span>
																
															</td>	
															<td>{{ item.existencia }}</td>		
															<td>
																<div v-show="item.idregistroproduccion > 0">
																	<a v-show="item.idregistroproduccion > 0" class="btn btn-primary btn-xs" :href="getRutaReporteProduccion(item.idregistroproduccion)"><i class="fa fa-eye"></i> {{ item.idregistroproduccion }}</a>
																	

																	<span v-show="item.rpterminado == 'SI'"
																		class="badge badge-success">
																		Terminado
																	</span>

																	<span v-show="item.rpterminado == 'NO'"
																		class="badge badge-danger">
																		NO Terminado - kilos maquilados {{ item.rpmaquilados }} / {{ item.kilosoriginal }}
																	</span>
																</div>
																<div v-show="item.idregistroproduccion == 0">	
																	-
																</div>
																
															</td>		
															<td >							
																-
															</td>
														</tr>
														
														<tr v-for="(item, index) in ingresos"  >
														
															<td>

															
																<span v-show="item.idremisionrollo > 0"
																	class="badge badge-success">
																	En Sistema
																</span>
																<span v-show="item.idremisionrollo == 0"
																	class="badge badge-primary">
																	Nuevo Registro
																</span>
																<span v-show="item.oklista == 'NO'"
																	class="badge badge-warning">
																	Duplicado en Lista
																</span>
																<span v-show="item.idrollo == 1 || item.almacen == 'NS' || item.kilos <= 0"
																class="badge badge-info">
																	Complete Informaci&oacute;n
																</span>
																
															</td>
															<td class="text-navy">
																	<div v-if="!item.infosistemacargada" 
																		class="sk-spinner sk-spinner-fading-circle">
																		<div class="sk-circle1 sk-circle"></div>
																		<div class="sk-circle2 sk-circle"></div>
																		<div class="sk-circle3 sk-circle"></div>
																		<div class="sk-circle4 sk-circle"></div>
																		<div class="sk-circle5 sk-circle"></div>
																		<div class="sk-circle6 sk-circle"></div>
																		<div class="sk-circle7 sk-circle"></div>
																		<div class="sk-circle8 sk-circle"></div>
																		<div class="sk-circle9 sk-circle"></div>
																		<div class="sk-circle10 sk-circle"></div>
																		<div class="sk-circle11 sk-circle"></div>
																		<div class="sk-circle12 sk-circle"></div>
																	</div>
																<h2>{{ item.norollo }}</h2>
															</td>
															<td>
																<span v-show="item.idrollo != item.idrollooriginal && item.idrollooriginal > 1 || true" class="text-success">Actual: <strong>{{ item.codigo }}</strong></span>
																<select class="form-control" v-model="item.idrollo" :disabled="item.cargadoensistema || item.idregistroproduccion > 0">
																	<?php
																		echo $lstRollos;
																	?>
																</select>
																
															</td>
															<td>
																<span v-show="item.almacen != item.almacenoriginal || true" class="text-success"><strong>{{ item.almacenoriginal }}</strong></span>
																<!-- <select class="form-control" v-model="item.almacen" :disabled="item.cargadoensistema">
																	<option value="NS">-- Seleccione --</option>
																	<option value="ALMACEN PRINCIPAL">ALMACEN PRINCIPAL</option>
																	<option value="MCM">MCM</option>
																	<option value="ALPES">ALPES</option>
																	<option value="CASA">CASA</option>
																	<option value="NARCISO">NARCISO</option>    							
																</select> -->
																
															</td>						
															<td class="text-navy">
																<span v-show="item.kilos != item.kilosoriginal || true" class="text-success">Actual: <strong>{{ item.kilosoriginal }}</strong></span>
																<input
																	type="text"  v-model="item.kilos" 								
																	oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
																	class="form-control" maxlength="5"
																	:disabled="item.cargadoensistema  || item.idregistroproduccion > 0">
															</td>	
															<td>{{ item.existencia }}</td>		
															<td>
																<div v-show="item.idregistroproduccion > 0">
																	<a v-show="item.idregistroproduccion > 0" class="btn btn-primary btn-xs" :href="getRutaReporteProduccion(item.idregistroproduccion)"><i class="fa fa-eye"></i> {{ item.idregistroproduccion }}</a>
																	

																	<span v-show="item.rpterminado == 'SI'"
																		class="badge badge-success">
																		Terminado
																	</span>

																	<span v-show="item.rpterminado == 'NO'"
																		class="badge badge-danger">
																		NO Terminado - kilos maquilados {{ item.rpmaquilados }} / {{ item.kilosoriginal }}
																	</span>
																</div>
																<div v-show="item.idregistroproduccion == 0">	
																	-
																</div>
																
															</td>		
															<td :style="item.idrollo == 1 || item.almacen == 'NS' || item.kilos <= 0 || item.oklista == 'NO' ? 'background: #f6aaaa !important' : 'background: #c9f6aa !important'">							
																<?php Form::singleButtonDanger("X", "quitarIngreso(index)", "!blnProcesado", "btn-xs");?>
																<div v-if="blnProcesado" v-html="getIconProceso(index)">
																</div>
															</td>
														</tr>
													</tbody>
												</table>

												<div style="margin-top: 3%;">
													<hr>
															<?php
															
															Form::openGroupForButtons ();
															Form::singleButtonPrimary ( "Registrar Toma de Inventario", "registrarIngreso", "ingresos.length > 0 && !blnProcesado", "", "l2" );
															Form::closeGroupForButtons ();
															
															?>
														</div>
											</div>
										</div>
									</div>
                                </div>
                            </div>

							<!-- inventario P R O D U C T O S  -->


                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
									<div class="row" >
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="ibox">
												<div class="ibox-content m-b-sm border-bottom">
													<div class="p-xs">
														<div class="col-lg-2 ">
															<div class="pull-left m-r-md">
																<i class="fa fa-barcode text-navy mid-icon"></i>
															</div>
														</div>
														<div class="col-lg-6">            		            		
															<div class="form-group" v-bind:class="{'has-error': errProductoStock}">
																<label class="control-label" for="productoStock">C&oacute;digo Producto</label> 
																	<input
																			type="text" id="productoStock" name="productoStock" v-model="productoStock"
																			ref="productoStock" placeholder="Código Producto" maxlength="40"
																			v-on:keypress.enter="enlistarProductoStock"
																			class="form-control "> 
																	<span class='help-block'> 
																		<strong>{{ errProductoStock }}</strong>
																	</span>
																</label>
															</div>
														</div>
														
														
														
													</div>
													
													<div class="clearfix"></div>
												</div>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="ibox">
												<div class="ibox-content m-b-sm border-bottom">
													<div class="row">

														<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
															<h2>Toma Inventario: <strong>{{ tomaInventario }}</strong></h2>
														</div>
														<!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
															<div class="form-group" v-bind:class="{'has-error': errAlmacen}">
																<label class="control-label" for="almacen">Almac&eacute;n</label> 
																<select class="form-control" v-model="almacen">
																	<option value="NS">-- Seleccione --</option>
																	<option value="ALMACEN PRINCIPAL">ALMACEN PRINCIPAL</option>
																	<option value="MCM">MCM</option>
																	<option value="ALPES">ALPES</option>
																	<option value="CASA">CASA</option>
																	<option value="NARCISO">NARCISO</option>    							
																</select>
																<span class='help-block'> <strong>{{ errAlmacen }}</strong>
																</span>
															</div>
														</div> -->

													</div>

												</div>
											</div>
										</div>
									</div>

									<div v-if="blnProcesado">
										<?php
																	
											Form::buttonPrimary ( "Nueva Recepci&oacute;n", "nuevaRecepcion" );
																	
										?>
										<br>	
										<br>
									</div>

									<!-- <button @click.prevent="addForTest" class="btn btn-primary">add for test</button> -->
									<div class="ibox"> 
										<div class="ibox-content">
											<div style="overflow-x: auto;">
												<div v-if="blnNoRegistrados" class="alert alert-danger">
													No se ha registrado la toma de inventario. Favor de verificar.
												</div>

												<div class="checkbox checkbox-primary">
													<input id="chkVerCapturados2" type="checkbox" v-model="chkVerCapturados" > 
													<label for="chkVerCapturados2">Visualizar Inventario ya Capturado</label>
												</div>

												<table class="table table-hover table-bordered no-margins">
													<thead>
														<tr>
															<th></th>
															<th>C&oacute;ndigo</th>
															<th>Descripci&oacute;n</th>
															<th>Existencia Actual</th>
															<th>Inventario Tomado</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
												
														<tr v-for="(item, index) in productosCapturados" v-if="chkVerCapturados" >
														
															<td style="background: #c9f6CC !important">
																<span 
																	class="badge badge-success">
																	INVENTARIADO
																</span>	
															
															
																
															</td>
															<td class="text-navy">
																	
																<h2>{{ item.codigo }}</h2>
															</td>
															<td>
																<span class="text-success"><strong>{{ item.descripcion }}</strong></span>							
																
															</td>
															<td>
																<span class="text-success"><strong>{{ item.existencia }}</strong></span>																
															</td>						
															<td class="text-navy">
																<span  class="text-success"><strong>{{ item.inventario }}</strong></span>
																
															</td>			
															<td></td>
														</tr>
														
														<tr v-for="(item, index) in productos"  >
														
															<td>															
																<span v-show="item.idproducto > 0"
																	class="badge badge-success">
																	En Sistema
																</span>																
																
																<span v-show="item.idproducto == 0"
																class="badge badge-danger">
																	NO Existe producto en Sistema
																</span>

																<span v-show="!item.isstock"
																class="badge badge-danger">
																	NO es PRODUCTO STOCK
																</span>
																
															</td>
															<td class="text-navy">
																	<div v-if="!item.infosistemacargada" 
																		class="sk-spinner sk-spinner-fading-circle">
																		<div class="sk-circle1 sk-circle"></div>
																		<div class="sk-circle2 sk-circle"></div>
																		<div class="sk-circle3 sk-circle"></div>
																		<div class="sk-circle4 sk-circle"></div>
																		<div class="sk-circle5 sk-circle"></div>
																		<div class="sk-circle6 sk-circle"></div>
																		<div class="sk-circle7 sk-circle"></div>
																		<div class="sk-circle8 sk-circle"></div>
																		<div class="sk-circle9 sk-circle"></div>
																		<div class="sk-circle10 sk-circle"></div>
																		<div class="sk-circle11 sk-circle"></div>
																		<div class="sk-circle12 sk-circle"></div>
																	</div>
																<h2>{{ item.codigo }}</h2>
															</td>
															<td>
																{{ item.descripcion }}															
															</td>
															<td>
																{{ item.existencia }}
																
															</td>						
															<td>				
																

																<div class="col-sm-10">
																	<div class="input-group m-b">
																		<span class="input-group-btn">
																			<button type="button" class="btn btn-primary"><i class="fa fa-minus"></i></button> 
																		</span> 
																		<input
																		type="text"  v-model="item.inventario" 								
																		oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
																		class="form-control" maxlength="5">
																		<span class="input-group-btn">
																			<button type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button> 
																		</span> 
																	</div>
																	
																</div>

																
																
																	
															</td>																			
															<td :style="item.idproducto == 0 || item.inventario <= 0 || !item.isstock ? 'background: #f6aaaa !important' : 'background: #c9f6aa !important'">							
																<?php Form::singleButtonDanger("X", "quitarProducto(index)", "!blnProcesado", "btn-xs");?>
																<!-- <div v-if="blnProcesado" v-html="getIconProceso(index)">
																</div> -->
															</td>
														</tr>
													</tbody>
												</table>

												<div style="margin-top: 3%;">
													<hr>
															<?php
															
															Form::openGroupForButtons ();
															Form::singleButtonPrimary ( "Registrar Toma de Inventario Productos", "registrarProductos", "productos.length > 0 && !blnProcesado", "", "l2" );
															Form::closeGroupForButtons ();
															
															?>
														</div>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
</div>
																


<!-- 
<pre>
	{{ $data }}
</pre>
 -->
