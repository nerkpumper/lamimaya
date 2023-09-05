<?php
$titlePage = "Surtir Pedido En Obra";
$breadCum = "Producci&oacute;n/Surtir";
$_lugar = LUGAR_PRODUCCION_DESPACHARPEDIDO;

$_addHead="
    
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
 		";

$_addScript="
    
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		";

?>

<div class="modal inmodal fade" id="modalNoRollos" tabindex="-1" role="dialog" aria-hidden="true">
<!-- <div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Seleccione Numero de Rollo</h4>
				
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-1 m-t">
						# Rollo
					</div>
					<div class="col-lg-5">
						<input type="text" class="form-control "
                	 		v-model="filtroNoRollo">
					</div>                	
				</div>
				<hr>
				<div class="table-responsive">
					<table id="tblNoRollos"
						class="table table-stripped toggle-arrow-tiny" data-page-size="5">
						<thead>
							<tr>
								<th data-sort-ignore="true"># Rollo</th>
								<th data-sort-ignore="true" >Remisi&oacute;n</th>
								<th data-sort-ignore="true" >Almac&eacute;n</th>
								<th data-sort-ignore="true" >Kilos</th>
								<th data-sort-ignore="true" >Disponible</th>
								
								<!-- 							<th data-sort-ignore="true" data-hide="phone">Disponible KG</th>							 -->
								<th data-sort-ignore="true" class="">Seleccione</th>
							</tr>
						</thead>
						<tbody id="tblNoRollosBody">
							<tr v-for="(norollos, index) in rollosParaAnadirFiltrados">
								<td>{{ norollos.noRollo }}</td>
								<td>{{ norollos.remision }}</td>
								<td>{{ norollos.almacen }}</td>
								<td>{{ norollos.kilos }}</td>
								<td>{{ norollos.existencia }}</td>
								<td><button @click.prevent="asignarRolloAObra(norollos.idRemisionRollo, index)" class="btn btn-primary btn-xs">Agregar a Obra</button></td>
							</tr>

						</tbody>
						
					</table>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div v-show="seleccionarPedido">
	<h2 class="m-l">No. Pedido:</h2>
	<div class="col-sm-3 m-b-xs">
	 	<div class="input-group">
	 		<input type="text" class="form-control input-lg"
	 		v-model="idPedido"
	 		v-on:keypress.enter="cargarDatosPedido"
			oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
			maxlength='8'>
			<span class="input-group-btn">
				<button @click.prevent="cargarDatosPedido"
					class="btn btn-primary btn-lg " type="button">
					<i class="fa fa-check"></i><span class="bold"></span>
				</button>
			</span>
	 	</div>
	 </div>



</div>

<div v-show="!seleccionarPedido">
	<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar Otro Pedido</button>
	<button @click.prevent="refresh" class="btn btn-primary"><i class="fa fa-refresh"></i> Refrescar Datos </button>
	<br>
	<div class="row m-b-lg m-t-lg">

	    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<div class="file-manager">
						
                	                    
    					<h2>Pedido <strong class="pull-right" style="font-size: 38px;">{{ idPedido }}</strong></h2>
						<div>Tipo Obra</div>
						
						<div class="hr-line-dashed"></div>						
                        
						<h5 v-show="pedidoDespieceTerminado == 'NO'">Rollos en esta Obra</h5>
						<ul v-for="ro in rollosObra" class="folder-list" style="padding: 0">
							<li ><a @click.prevent="seleccionarNoRemision(ro.idRemisionRollo)" href="#"><i class="fa fa-database"></i> {{ ro.noRollo }} - {{ ro.disponible }} Kg </a></li>
							
						</ul>
						<div class="hr-line-dashed"></div>
						<button v-show="pedidoDespieceTerminado == 'NO'" @click.prevent="agregarRolloAObra" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>  Rollo a Esta Obra</button>
						<button v-show="pedidoDespieceTerminado == 'NO'" @click.prevent="quitarRolloAObra" class="btn btn-danger btn-block"><i class="fa fa-minus"></i>  Rollo a Esta Obra</button>
						<div class="hr-line-dashed"></div>
						<!-- <ul class="list-group clear-list m-t">
							<li v-for="ro in rollosObra" class="list-group-item fist-item">
                                <span class="pull-right">
									<button class="btn btn-primary btn-xs pull-right"><i class="fa fa-check"></i></button>
                                </span>
                                <i class="fa fa-database"></i> {{ ro.noRollo }} - {{ ro.disponible }} Kg
                            </li>
						</ul>			 -->

<!--						<ul v-for="cc in cortescomision" class="folder-list" style="padding: 0"> -->
<!-- 							<li ><a @click.prevent="manejarCorteComision(cc.idcortecomision)" href="#"><i class="fa fa-calendar"></i> {{ cc.idcortecomision }} - {{ cc.fecha }} <span v-show="cc.pagada == 'SI'" class="badge badge-success">PAGADA</span><span v-show="cc.pagada == 'NO' && cc.neto >0" class="badge badge-danger">PENDIENTE PAGAR</span><span v-show="cc.pagada == 'NO' && cc.neto < 0" class="badge badge-warning">NO REQUIERE PAGO</span></a></li>							 -->
<!-- 						</ul> -->
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
						<br><br><br>
						<div class="hr-line-dashed"></div>
						<div class="hr-line-dashed"></div>
						<button v-show="pedidoDespieceTerminado == 'NO'" @click.prevent="terminarDespiece" class="btn btn-success btn-block"><i class="fa fa-check"></i>  Terminar Despiece de Pedido</button>
						
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			
	    </div>

		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
		
			<div v-show="pedidoDespieceTerminado == 'SI'">
				<div class="alert alert-info">
            		<h2>El despiece del Pedido ya ha sido realizado</h2>
            		<a target="_blank" :href="'<?php echo URL_BASE;?>pedidodespiece?id=' + idPedido" class="btn btn-primary"><i class="fa fa-printer"></i> Imprimir Despiece de Pedido</a>            		
            	</div>
			</div>
		
			<div v-show="pedidoEstado != 'PRODUCCION'">
				<div class="alert alert-danger">
            		El Pedido tiene estatus de <strong> <h1> {{ pedidoEstado }} </h1></strong> 
            		<br>
            		Para generar despiece, el pedido debe tener estatus de <strong>PRODUCCI&Oacute;N</strong>
            	</div>
			</div>
			
			<div v-show="pedidoRecogeEngrega != 'OBRA'">
				<div class="alert alert-warning">
            		El Pedido NO es para una Obra, actualmente esta indicado como<strong> <h1> {{ pedidoRecogeEngrega }} </h1></strong> 
            		<br>
            		Para generar despiece, el pedido debe estar en <strong>OBRA</strong>
            	</div>
			</div>
			
			
		
		
			<div v-show="nrNoRolloSeleccionado && nrIdRegistroProduccion == 0">
<!--     		<div> -->
    			<div class="text-center animated fadeInRight alert alert-warning">
    				<h3>Kilos disponibles en el N&uacute;mero de Rollo {{ nrExistencia }}</h3>
    				No existe <strong>Registro de Producci&oacute;n</strong> abierto
    				para el # de Rollo <strong>{{ nrCodigoRollo }}</strong>. &nbsp;&nbsp;
    				<button @click.prevent="crearRegistroProduccion"
    					class="btn btn-primary">Crear Registro de Producci&oacute;n</button>
    			</div>
			</div>
			
			<div v-show="retirarRollosDeObra">
    			<div class="ibox float-e-margins">
            		<div class="ibox-title">
						Retirar Rollos de Obra
					</div>
				</div>
				<div class="ibox-content">
					<div v-show="rollosObra.length == 0">No hay rollos para retirar de la Obra</div>
					<div v-show="rollosObra.length > 0">
						<h4>Indique a donde desea mover los Rollos</h4>
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead>
								<tr>
									<th># Rollo</th>
									<th>Almacen Anterior</th>								
									<th>Almacen destino</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
									<tr v-for="(ro, index) in rollosObra">
										<td>{{ index }} - {{ ro.noRollo }}</td>
										<td>{{ ro.almacenOriginal }}</td>								
										<td>
											<select class="form-control m-b" v-model="ro.almacendestino">
												<option value="SN" select>-- Seleccione Almac&eacute;n Destino</option>                                
												<option v-show="ro.almacen != 'ALMACEN PRINCIPAL'" value="ALMACEN PRINCIPAL" select>Almacen Principal</option>
												<option v-show="ro.almacen != 'MCM'" value="MCM" select>MCM</option>
												<option v-show="ro.almacen != 'ALPES'" value="ALPES" select>ALPES</option>
												<option v-show="ro.almacen != 'CASA'" value="CASA" select>CASA</option>
												<option v-show="ro.almacen != 'NARCISO'" value="NARCISO" select>NARCISO</option>
												<option v-show="ro.almacen != 'DELTA'" value="DELTA" select>DELTA</option>											
												<option v-show="ro.almacen != 'LAGOS'" value="LAGOS" select>LAGOS</option>											
											</select>
										</td>
										<td><button @click.prevent="moverAAlmacen(ro.idRemisionRollo, index, ro.almacendestino)" :disabled="ro.almacendestino == 'SN'" class="btn btn-primary"><i class="fa fa-exchange"></i> Mover</button></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
    		
    		
    		<div v-show="nrNoRolloSeleccionado && nrIdRegistroProduccion > 0">
    			<div class="ibox float-e-margins">
            		<div class="ibox-title">
<!--             			<span class="label label-warning pull-right">Data has changed</span> -->
            			<h5>REGISTRO DE PRODUCCI&Oacute;N DE ROLLOS <span class="text-navy">{{ nrCodigoRollo }} </span></h5>
            			<br>
            			<div v-bind:class="{'alert alert-info' : 'nrFactor <= 100', 'alert alert-danger': 'nrFactor >100'}">
            				<strong>Factor estimado: </strong> {{ nrFactor }}, <strong> Rendimiento estimado: </strong> {{ nrRendimiento }}
            			</div>
            			<div class="ibox-tools" >
            				
            				
            			</div>
            		</div>
            		<div class="ibox-content">
            			<div class="row">
            				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            					<small class="stats-label">KILOS DE ROLLO</small>
            					<h4>{{ nrKilos }}</h4>
            				</div>
            
            				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            					<small class="stats-label">KILOS MAQUILADOS</small>
            					<h4>{{ nrKilosMaquilados }}</h4>
            				</div>
            				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            					<small class="stats-label">KILOS FALTANTES</small>
            					<h4>{{ formatNumber( nrExistencia )}} </h4>
            				</div>
            				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            					<small class="stats-label">TOTAL DE ML</small>
            					<h4>{{ nrTotalML }}</h4>
            				</div>
            				
            				
            				
            			</div>
            		</div>
            		<div class="ibox-content">
            			<div v-show="registroProduccionDetalle.length > 0" class="table-responsive ">
<!--             			<div  class="table-responsive ">  -->
            				<table class="table table-striped table-bordered">
            					<thead>
            						<tr>
            							<th>NUM. DE PEDIDO</th>
            							<th>NOMBRE DEL CLIENTE</th>
            							<th>PIEZAS</th>
            							<th>ML</th>
            							<th>TOTAL DE ML</th>
            							<th>TOTAL KG</th>
            						</tr>
            					</thead>
            					<tbody>
            						<tr v-for="item in registroProduccionDetalle">
            							<td>{{ item.nopedido }}</td>
            							<td>{{ item.nombrecliente }}</td>
            							<td>{{ item.partida }}</td>
            							<td>{{ item.longitud }}</td>
            							<td>{{ item.totalml }}</td>
            							<td>{{ item.totalkg }}</td>
            						</tr>
            					</tbody>
            				</table>
            			</div>
            		</div>
            		<div class="ibox-content">
            			<!--     		Datos del Pedido -->
            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            					<div class="panel panel-primary">
            						<div class="panel-heading">
<!--             							<button class="btn btn-danger btn-xs pull-right" @click.prevent="cancelarIngresoRegistro">Cancelar</button> -->
            							Registrar Producci&oacute;n por Pedido
            						</div>
            						<div class="panel-body">
            <!-- 							<div class="row"> -->
            <!-- 								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"> -->
            <!-- 									<h4>No. Pedido</h4> -->
            <!-- 								</div> -->
            
            <!-- 								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"> -->
            <!-- 									<div class="m-b-xs"> -->
            <!-- 										<div class="input-group" > -->
            <!-- 											<input type="text" class="form-control " v-model="pedidoIdPedido" -->
            <!-- 												v-on:keypress.enter="app.cargarPedidoDetalle();" -->
            <!-- 												oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');"> -->
            <!-- 												 <span	class="input-group-btn"> -->
            <!-- 												<button @click.prevent="cargarPedidoDetalle" -->
            <!-- 													class="btn btn-primary  " type="button"> -->
            <!-- 													<i class="fa fa-search"></i><span class="bold"></span> -->
            <!-- 												</button> -->
            <!-- 											</span> -->
            <!-- 										</div> -->
            <!-- 									</div> -->
            <!-- 								</div> -->
            <!-- 							</div> -->
            							<div v-if="pedidoMsgPedido" class="text-center animated fadeInRight alert alert-info">
             								{{ pedidoMsgPedido }}
             							</div>
            							<div >
            <!-- 								<h3> -->
            <!-- 									Cliente: <span class="text-navy m-l">{{ pedidoCliente }} </span> -->
            <!-- 								</h3> -->
            <!-- 								<div v-show="!pedidoDespachando" class="table-responsive"> -->
            								<div>
            									<table class="table table-striped table-bordered">
            										<thead>
            											<tr>
            												<th>C&oacute;digo</th>
            												<th>Descripci&oacute;n</th>
            												<th>Sucursal</th>
            												<th>Pzas/Kg</th>
            												<th>ML ESTIMADO</th>
            												<th>ML Despachados</th>
<!--             												<th>Despachado</th> -->
            												<th>Acci&oacute;n</th>
            											</tr>
            										</thead>
            										<tbody>
            											<tr v-for="(item, index) in pedidoPedidoDetalle">
            												<td>{{ item.proCodigo }}</td>
            												<td>{{ item.proDescripcion }}</td>
            												<td class="text-navy">{{ item.sucursalNombre }}</td>
            												<td>{{ item.partida }}</td>
            												<td>
            													<div v-show="item.shortUnidad != 'KG'">
            														{{ item.cantidadReal}} <span v-show="item.shortUnidad == 'M2'">({{ item.cantidad }} M2)</span>
            													</div>
            													<div v-show="item.shortUnidad == 'KG'">
            														KG
            													</div>
            												</td>
            												<td>{{ item.partidaDespachada }}</td>
<!--             												<td>{{ item.despachado }} <span v-show="item.isParcial == 'SI'" class="badge badge-info"> Parcial</span></td> -->
            												<td>
<!--             													<span v-if="item.proIdRollo == nrNoRollo && (item.totalamldespachar - item.partidaDespachada) > 0 && item.shortUnidad != 'PZA'"> -->
																<span v-if="item.proIdRollo == nrNoRollo &&  item.shortUnidad != 'PZA' && item.despachado == 'NO'" >
            														<button @click.prevent="pedidoDespacharPedidoDetalle(index)" class="btn btn-primary btn-xs">Despachar</button>
            													</span  >
            <!-- 													<span v-if="(item.partida - item.partidaDespachada) <= 0" class='label label-success'>DESPACHADO</span> -->
<!--             													<span v-if="(item.totalamldespachar - item.partidaDespachada) <= 0" class='text-success'>DESPACHADO</span> -->
            													<span v-if="item.despachado == 'SI'" class='text-success'>DESPACHADO</span>
            												</td>
            											</tr>
            										</tbody>
            									</table>
            								</div>
             								<div v-show="pedidoDespachando" class="panel-rec"> 
             									<div class="row"> 
             										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"> 
             											<button @click.prevent="pedidoNoDespachar" class="btn btn-warning btn-xs">Regresar</button> 
             										</div> 
             										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
             											<h3> 
             												Despachando: <span class="text-navy m-l">{{ pedidoDespachandoProducto }} </span> 
             											</h3> 
             										</div> 
             									</div> 
             									<div class="row"> 
             										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"> 
             											<div class="form-group" v-bind:class="{'has-error': errPedidoTotalPiezas}"> 
             												<label class="control-label" for="price">PIEZAS</label> 
<!--              												<h3>{{ pedidoTotalPiezas }}</h3>  -->
             												<input type="text" v-model="pedidoTotalPiezas" 
             												       class="form-control" maxlength="9" 
             												       oninput="this.value = this.value.replace(/[^0-9\t]/g, '').replace(/(\..*)\./g, '$1');">
             												  <span class='help-block'> 
             													<strong>{{ errPedidoTotalPiezas }}</strong> 
             												</span>     
             											</div> 
             										</div> 
<!--              										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">  -->
<!--              											<div class="form-group">  -->
<!--              												<label v-show="pedidoShortUnidad != 'KG'" class="control-label" for="price">ML ESTIMADO</label>  -->
<!-- <!--              												<label v-show="pedidoShortUnidad == 'KG'" class="control-label" for="price">KG</label>  --> 
<!--              												<h3 v-show="pedidoShortUnidad != 'KG'">{{ pedidoML }}</h3>  -->
<!-- <!--              												<h3 v-show="pedidoShortUnidad == 'KG'">KG</h3>  --> 
<!--              											</div>  -->
<!--              										</div>  -->
<!--              										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">  -->
<!--              											<div class="form-group">  -->
<!--              												<label class="control-label" for="price">POR DESPACHAR</label>  -->
<!--              												<h3>{{ pedidoPorDespachar }}</h3>  -->
<!--              											</div>  -->
<!--              										</div>  -->
             										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"> 
             											<div class="form-group" v-bind:class="{'has-error': errPedidoPiezas}"> 
             												<label class="control-label" for="price">ML DESPACHAR</label> 
             												<input type="text" v-model="pedidoPiezas" 
             												       class="form-control" maxlength="9" 
             												       oninput="this.value = this.value.replace(/[^0-9\t.]/g, '').replace(/(\..*)\./g, '$1');"> 
             												<span class='help-block'> 
             													<strong>{{ errPedidoPiezas }}</strong> 
             												</span> 
             											</div> 
             										</div> 
<!--              										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">  -->
<!--              											<div class="form-group">  -->
<!--              												<label v-show="pedidoShortUnidad != 'KG'" class="control-label" for="price">ML DESPACHAR</label>  -->
<!--              												<h3 v-show="pedidoShortUnidad != 'KG'">{{ pedidoMLDespachar }}</h3>  -->
<!--              											</div>  -->
<!--              										</div>  -->
             										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"> 
             											<div class="form-group"> 
             												<label class="control-label" for="price">KG DESPACHAR</label> 
             												<h3>{{ pedidoKGDespachar }}</h3> 
             											</div> 
             										</div> 
            
             									</div> 
             									<div class="row"> 
<!--              										<button v-show="showButtonRegistrarRPPedido" @click.prevent="registrarRPPedido" class="btn btn-success pull-right m-r">Registrar</button>  -->
													<button @click.prevent="registrarRPPedido" class="btn btn-success pull-right m-r">Registrar</button>
             									</div> 
            
             								</div> 
            							</div>
            
            						</div>
            					</div>
            				</div>
            <!--     		Fin Datos del Pedido -->
            
            			<hr>
            			<button v-show="!showPYC" @click.prevent="mostrarPYC" class="btn btn-warning">Registrar P Y C</button>
            
<!--             		Datos P Y C -->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        					<div v-show="showPYC" class="panel panel-primary">
        						<div class="panel-heading">
        							<button class="btn btn-danger btn-xs pull-right" @click.prevent="cancelarIngresoRegistro">Cancelar</button>
        							Registrar Producci&oacute;n P Y C
        						</div>
        						<div class="panel-body">
        							<div class="row">
        								<h3>
        									<span class="text-navy m-l">P Y C</span>
        								</h3>
        							</div>
        							<div class="row">
        								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        									<div class="form-group" v-bind:class="{'has-error': errPycPiezas}">
        										<label class="control-label" for="price">Piezas</label>
        										<h3>{{ pycPiezas }}</h3>
        <!-- 										<input type="text" v-model="pycPiezas"  -->
        <!-- 										       class="form-control" maxlength="9" -->
        <!-- 										       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">										        -->
        <!-- 										<span class='help-block'>  -->
        <!-- 											<strong>{{ errPycPiezas }}</strong> -->
        <!-- 										</span> -->
        									</div>
        								</div>
        								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        									<div class="form-group" v-bind:class="{'has-error': errPycML}">
        										<label class="control-label" for="price">ML</label>
        										<input type="text" v-model="pycML"
        										       class="form-control" maxlength="9"
        										       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
        										<span class='help-block'>
        											<strong>{{ errPycML }}</strong>
        										</span>
        									</div>
        								</div>
        								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        									<div class="form-group">
        										<label class="control-label" for="price">TOTAL ML</label>
        										<h3>{{ pycTotalML }}</h3>
        									</div>
        								</div>
        								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        									<div class="form-group text-navy">
        										<label class="control-label" for="price">TOTAL KG</label>
        										<h3>{{ pycTotalKG }}</h3>
        									</div>
        								</div>
        							</div>
        							<div class="row">
        								<button  @click.prevent="registrarRPPyc" class="btn btn-success pull-right m-r">Registrar</button>
        							</div>
        
        						</div>
        					</div>
        				</div>
	

<!--             		Fin Datos P Y C -->
            
            <hr>
            <hr>
            <hr>
            <div  id="terminaelrollo"  class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-t m-b">
            					<button class="btn btn-success" @click.prevent="concluirRegistroProduccion"><i class="fa fa-check"></i> El Rollo se ha terminado</button>	
            				</div>
            			<div class="clearfix"></div>
            		</div>
            	</div>
    		</div>
    		
    		

    		
		</div>
	</div>
</div>


    <pre>{{ $data }}</pre> 