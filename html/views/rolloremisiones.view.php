<?php

$titlePage = "Rollo";

$breadCum = "Productos/Rollo/Inventario No Rollo";

$buttonAction = "Regresar al Listado/fnRegresarAListado";

$_lugar = LUGAR_PRODUCTOS_ROLLO;



$_addHead="

 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>

<link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'> 		

 		";



$_addScript="

 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script> 		

 		";





?>



<h2><span class="text-navy"> {{ codigo }}</span> Rollo {{ material }} Calibre {{ calibre }} {{ pies }} Pies {{ proveedor }}</h2>

<h3>Existencia Actual: <strong style="font-size: 26px;">  {{ existencia.toLocaleString() }}</strong></h3>



<div v-show="mostrarRollo" class="row">	

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<div class="tabs-container">

			<ul class="nav nav-tabs">

				<li class="active"><a data-toggle="tab" href="#tab-1"> No Rollos</a></li>

				<li class=""><a data-toggle="tab" href="#tab-2">Movimientos de Rollo</a></li>

			</ul>

			<div class="tab-content">

				<div id="tab-1" class="tab-pane active">

					<div class="panel-body">

						<div class="row">

			                <div class="col-sm-3 m-b-xs">

			                	<div class="input-group">

			                	<input type="text" v-model="filtroNoRollo" placeholder="Filtrar No. Rollo" class="input-sm form-control"> 

<!-- 			                		<span class="input-group-btn"> -->

<!-- 			                			<button type="button" class="btn btn-sm btn-primary"> Go! -->

<!-- 			                			</button>  -->

<!-- 			                		</span> -->

			                    </div>

<!-- 			                    <div data-toggle="buttons" class="btn-group"> -->

<!-- 			                        <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label> -->

<!-- 			                        <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label> -->

<!-- 			                        <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label> -->

<!-- 			                    </div> -->

			                </div>

			                <div class="col-sm-3">

			                  <div class="checkbox checkbox-primary">

                                            <input id="chkTerminado" type="checkbox" v-model="chkTerminado">

                                            <label for="chkTerminado">

                                                Mostrar Terminados

                                            </label>

                                        </div>  

			                </div>

			            </div>

			            <div class="table-responsive">

			                <table class="table table-striped">

			                    <thead>

				                    <tr>	

				                    	<th># Rollo</th>

				                    	<th>Registro</th>			

				                        <th>Remisi&oacute;n</th>

				                        <th>Almacen</th>				                        

				                        <th>Kilos</th>

				                        <th>Disponible</th>		

				                        <th>Estatus</th>		                        

				                        <th>Action</th>

				                    </tr>

			                    </thead>

			                    <tbody>

				                    <tr v-for="(remi, index) in noRollosFiltrados" v-if="remi.estado != 'TERMINADO' || (chkTerminado && remi.estado == 'TERMINADO')">

				                    	<td><h3>{{ remi.noRollo }}</h3></td>

				                    	<td>{{ remi.fecha }}</td>

				                        <td>{{ remi.remision }}</td>

				                        <td>{{ remi.almacen }}</td>					                        

				                        <td>{{ remi.kilos.toLocaleString() }}</td>
				                        <td>{{ remi.disponible.toLocaleString() }}</td>

				                        <td>{{ remi.estado }}</td>

				                        <td>

				                        	<button class="btn btn-primary btn-sm" @click.prevent="inventarioRemisionRollo(remi.idRemisionRollo, index);" ><i class="fa fa-list-ol"></i></button>

				                        	

				                        	

				                        	<?php if (Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || Permisos::userIsThisRol(Permisos::$rol_ROOT) ): ?>

				                        	

				                        	

				                        	<button v-show="remi.disponible > 0" class="btn btn-danger btn-sm" @click.prevent="borrarRemisionRollo(remi.idRemisionRollo, index);"><i class="fa fa-trash-o"></i></button>

				                        	

				                        	<?php endif;?>

				                        	

				                        </td>

				                    </tr>

			                    </tbody>

			                </table>

			            </div>

					</div>

				</div>

				<div id="tab-2" class="tab-pane">

					<div class="panel-body">

						<div class="panel-rec">

							<div class="row">

								<div class="col-sm-3">

									<div class="form-group">

										<label class="control-label" for="status">Movimientos</label> 

										<select v-model="reportMovimiento"	class="form-control">

											<option value="ES" selected="">Entradas/Salidas</option>

											<option value="E">Entradas</option>

											<option value="S">Salidas</option>

										</select>

									</div>

								</div>

								<div class="col-sm-3">

									<div class="form-group" v-bind:class="{'has-error': errFechaInicio}">

		                                <label class="control-label">Desde</label>

		                                <div class="input-group date">

		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

		                                    <input id="dtFechaInicio" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>">		                                    

		                                </div>

		                                <span v-if='errFechaInicio' class='help-block'>

												<strong>{{ errFechaInicio }} </strong>

										</span>

		                            </div>

								</div>

								<div class="col-sm-3">

									<div class="form-group"  v-bind:class="{'has-error': errFechaFin}">

		                                <label class="control-label">Hasta</label>

		                                <div class="input-group date">

		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

		                                    <input id="dtFechaFin" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>">

		                                </div>

		                                <span v-if='errFechaFin' class='help-block'>

												<strong>{{ errFechaFin }} </strong>

										</span>

		                            </div>

								</div>

								<div class="col-sm-3">

									<div class="form-group">

										<button @click.prevent="obtenerReporte" class="btn btn-primary m-t-md">Obtener</button>										

										<button @click.prevent="exportarReporte" class="btn btn-outline btn-success m-t-md"><i class="fa fa-file-excel-o"></i> Exportar</button>

									</div>

								</div>

								

							</div>

						</div>



						<div class="table-responsive">

							<table class="table table-striped">

								<thead>

									<tr>

										<th>Fecha Movimiento</th>

										<th>Empleado</th>

										<th>Referencia</th>

										<th>Existencia Anterior</th>

										<th>Cantidad</th>

										<th>Existencia</th>

										<th>Observaciones</th>

									</tr>

								</thead>

								<tbody id="tblMovimientosTodosBody">



								</tbody>

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>





<div v-show="mostrarDetalle" class="row">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<div  class="ibox">		

			<div class="ibox-content">

				<button @click.prevent="noMostrarDetalle" class="btn btn-warning m-t-md"><i class="fa fa-angle-double-left"></i></button>

				<h2>Movimientos # Rollo: <span class="text-navy"> {{ noRollo }}</span></h2>

				<h4>Existencia Actual: <strong style="font-size: 26px;">  {{ existenciaNoRollo }}</strong></h4>

				<div class="panel-rec">

							<div class="row">

								<div class="col-sm-3">

									<div class="form-group">

										<label class="control-label" for="status">Movimientos</label> 

										<select v-model="reportMovimientoRemisionRollo"	class="form-control">

											<option value="ES" selected="">Entradas/Salidas</option>

											<option value="E">Entradas</option>

											<option value="S">Salidas</option>

										</select>

									</div>

								</div>

								<div class="col-sm-3">

									<div class="form-group" v-bind:class="{'has-error': errFechaInicioRemisionRollo}">

		                                <label class="control-label">Desde</label>

		                                <div class="input-group date">

		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

		                                    <input id="dtFechaInicioRemisionRollo" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>">		                                    

		                                </div>

		                                <span v-if='errFechaInicioRemisionRollo' class='help-block'>

												<strong>{{ errFechaInicioRemisionRollo }} </strong>

										</span>

		                            </div>

								</div>

								<div class="col-sm-3">

									<div class="form-group"  v-bind:class="{'has-error': errFechaFinRemisionRollo}">

		                                <label class="control-label">Hasta</label>

		                                <div class="input-group date">

		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

		                                    <input id="dtFechaFinRemisionRollo" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>">

		                                </div>

		                                <span v-if='errFechaFinRemisionRollo' class='help-block'>

												<strong>{{ errFechaFinRemisionRollo }} </strong>

										</span>

		                            </div>

								</div>

								<div class="col-sm-3">

									<div class="form-group">

										<button @click.prevent="obtenerReporteRemisionRollo" class="btn btn-primary m-t-md">Obtener</button>										

										<button @click.prevent="exportarReporteRemisionRollo" class="btn btn-outline btn-success m-t-md"><i class="fa fa-file-excel-o"></i> Exportar</button>

									</div>

								</div>

								

							</div>

						</div>



						<div class="table-responsive">

							<table class="table table-striped">

								<thead>

									<tr>

										<th>Fecha Movimiento</th>

										<th>Empleado</th>

										<th>Referencia</th>

										<th>Existencia Anterior</th>

										<th>Cantidad</th>

										<th>Existencia</th>

										<th>Observaciones</th>

									</tr>

								</thead>

								<tbody id="tblMovimientosRemisionRolloTodosBody">



								</tbody>

							</table>

						</div>

			</div>

		</div>

	</div>	

</div>

<!-- <pre>{{ $data }}</pre> -->