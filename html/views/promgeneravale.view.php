<?php
$titlePage = "Generaci&oacute;n de Vales de Salida";
$breadCum = "Promotor/Vale de Salida";
$_lugar = LUGAR_PROMOTOR_VALESALIDA;

$_addHead="
    
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
        <link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		";

$_addScript="
    
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
        <script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
		<script src=\"".URL_BASE."js/components/pedido-tracking-estatus-vale.vue.js\"></script>
 		";

?>

<div class="modal inmodal fade" id="modalTracking" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Tracking de Pedido</h4>
				
			</div>
			<div class="modal-body">
				<pedido-tracking-estatus-vale ref="trackingPedido">
				</pedido-tracking-estatus-vale>
				
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>				
			</div>
		</div>
	</div>
</div>	

<!-- Capturar Motivo aun no -->
<div class="modal inmodal fade" id="modalIndicaMotivoAunNo" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique el por qu&eacute; aun no se permite Imprimir Vale Salida</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							<input type="text"
								v-model="auxAunNo"								
								maxlength="250" class="form-control">
							<label v-if="!auxAunNo" class="text-danger">Ingrese Observaci&oacute;n</label>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="setValeSalidaAunNo" class="btn btn-success"> Guardar</button>
					</div>
					
					<div class="clearfix"></div>
				
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

<div v-show="!seleccionarPedido && pedidoColocado == 'NO' ">
	<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar Otro Pedido</button>
	<br>
	<br>
	<div class="alert alert-danger">
		<h2>El Pedido aun no est&aacute; Asignado.  <button class='btn btn-success btn-xs m-r-xs' @click.prevent='mostrarTracking'><i class='fa fa-pagelines'></i></button></h2>
	</div>
</div>


<div v-show="!seleccionarPedido && pedidoColocado == 'SI' ">
	<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar Otro Pedido</button>
	<button @click.prevent="cargarDatosPedido" class="btn btn-primary"><i class="fa fa-refresh"></i> Refrescar Datos </button>
	<br>
	<div class="row m-b-lg m-t-lg">

	    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<div class="file-manager">
						
                	                    
    					<h2>Pedido <button class='btn btn-success btn-xs m-r-xs' @click.prevent='mostrarTracking'><i class='fa fa-pagelines'></i></button> <strong class="pull-right" style="font-size: 38px;">{{ idPedido }}</strong></h2>
    					<br>
    					<h3>{{ pedidoCliente }}</h3>
						<h3>Credito: ${{ formatNumber(cteCredito) }} <span class="pull-right" >D&iacute;as: 30 </span></h3>						
						<hr>
						<h5 ><small>Promotor: </small> <strong class="pull-right" >{{ promoNombre }}</strong></h5>
						<h6 v-show="promoNombre != vendeNombre"><small>Vendedor: </small> <strong class="pull-right" >{{ vendeNombre }}</strong></h5>
						<hr>
						<h3 ><small>Subtotal: </small> <strong class="pull-right" >$ {{ formatNumber(pedidoSubtotal) }}</strong></h3>
						<h3><small>Otros Cargos: </small> <strong class="pull-right" >$ {{ formatNumber(pedidoOtrosCargos) }}</strong></h3>
						<h3><small>Total: </small> <strong class="pull-right" >$ {{ formatNumber(pedidoTotal) }}</strong></h3>
						<h3><small>Saldo de Este Pedido: </small> <strong class="pull-right" >$ {{ formatNumber(pedidoSaldo) }}</strong></h3>
						<h3><small>Saldo Global Total: </small> <strong class="pull-right text-navy" >$ {{ formatNumber(pedidoSaldoTotal) }}</strong></h3>
						<h3><small>Saldo > 30 D&iacute;as: </small> <strong class="pull-right " :class="pedidoSaldoTotalMas30Dias >= 0 ? 'text-danger' : 'text-navy'" >$ {{ formatNumber(pedidoSaldoTotalMas30Dias) }}</strong></h3>
						<h3><small>Saldo del Cr&eacute;dito de Pedidos Entregados: </small> <strong class="pull-right " :class="saldoCredito >= 0 ? 'text-navy' : 'text-danger'" >$ {{ formatNumber(saldoCredito) }}</strong></h3>
						<h3><small>Saldo Capacidad Pago de Pedidos Entregados: </small> <strong class="pull-right " :class="saldoCapacidadPago >= 0 ? 'text-navy' : 'text-danger'" >$ {{ formatNumber(saldoCapacidadPago) }}</strong></h3>
						
						<div v-if="!pedidoSurtiraCompleto">
							<br>
							<div  class="alert alert-danger">Para completar este pedido se debe realizar compra de material/producto, por lo que <strong>deber&aacute; solicitar el 50% de abono/anticipo.</strong></div>
						</div>
						
						
<!-- 						<div class="hr-line-dashed"></div>						 -->
<!--                         <button v-show="pedidoDespieceTerminado == 'NO'" @click.prevent="agregarRolloAObra" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>  Rollo a Esta Obra</button> -->
						<div class="hr-line-dashed"></div>
						<h5 >Vales de Salida</h5>
						<ul v-for="vs in valessalida" class="folder-list" style="padding: 0">
							<li ><a @click.prevent="seleccionarValeSalida(vs.idValeSalidaPromotor)" href="#"><i class="fa fa-tags"></i> S{{ vs.idValeSalidaPromotor }} - {{ vs.sucursal }} <span class="badge badge-info"> V - {{ vs.idValeSalida }} </span></a></li>
						</ul>
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
<!-- 						<div class="hr-line-dashed"></div> -->
						<div class="hr-line-dashed"></div>
<!-- 						<button v-show="pedidoDespieceTerminado == 'NO'" @click.prevent="terminarDespiece" class="btn btn-success btn-block"><i class="fa fa-check"></i>  Terminar Despiece de Pedido</button> -->
						
						<div class="clearfix"></div>
					</div>
					
				</div>
			</div>

			
	    </div>

		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
		
			
		
			<div v-show="mostrandoVale" class="ibox float-e-margins">
				<div class="ibox-content">
					<button @click.prevent="hideMostrarVale" class="btn btn-danger btn-xs pull-right"> X</button>
					<h2>Productos en Vale de Salida <small>S {{ idValeSalidaPromotorSeleccionado }}</small> <div class="badge badge-primary"> V {{ idValeSalidaSeleccionado }}</div></h2>
					
					<h3>Sucursal: <strong>{{ sucursalValeSalidaSeleccionado }}</strong></h3>
					
					<table id="tablaToExcel" class="table table-bordered table-hover ">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Pzas en Vale</th>																
							</tr>
						</thead>
						<tbody>	
							<tr v-for="item in mercanciaEnVale">
								<td>
									{{ item.producto }}
								</td>
								<td>{{ item.partidaenvale }}</td>								
								
							</tr>						
						</tbody>
					</table>					
					<hr>
					<!-- <div v-if="idValeSalidaSeleccionado > 0 " class="row">
						<div class="col-lg-4">
							<div class="col-sm-10">
								Pago vs Entrega
							</div>	
							<div class="col-sm-2">
								<div v-show="yaimpreso == 'SI'">
									<span v-if="chkPagoVSEntrega">SI</span>
									<span v-else>NO</span>
								</div>
								<div v-show="yaimpreso == 'NO'" class="switch">
									<div class="onoffswitch">
										<input type="checkbox" class="onoffswitch-checkbox"
											id="chkPagoVSEntrega" v-model="chkPagoVSEntrega"> <label class="onoffswitch-label" for="chkPagoVSEntrega"> 
											<span
											class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div> -->
					<div class="pull-right"><h2>Total Vale: <strong>$ {{ formatNumber(valeSalidaTotal) }}</strong></h2></div>
					<div class="clearfix"></div>
					<hr>
					<button v-if="idValeSalidaSeleccionado == 0" @click.prevent="BorrarValeSalida" class="btn btn-danger pull-right"> Deshacer Vale de Salida</button>
					<button v-if="idValeSalidaSeleccionado == 0" @click.prevent="ConfirmarValeSalida" class="btn btn-primary "> Confirmar Vale de Salida</button>
					
					<div v-show="idValeSalidaSeleccionado > 0">
						<h2>Datos Vale de Salida</h2>
						<hr>
<!-- 						Datos del Vale de Salida -->
						<div class="row">
							
        					<div class="col-md-6">
        						<div class="row">
        <!-- 							<h2 class="text-navy">{{ idPedido }}</h2> -->
        									<h3>Datos Pedido</h3>
                                            <h2 class="text-navy">{{ estado }}</h2>
                                            <h2 class="text-navy">{{ recogeentrega }} <small v-show="recogeentrega == 'OBRA'" class="text-navy">{{ tipoObra }}</small></h2>
                                            
                                            <div v-show="recogeentrega == 'ENTREGA' || recogeentrega == 'OBRA'">
<!--                                             	<span>Consignacinaci&oacute;n:</span> -->
<!--         	                                    <address> -->
<!--         	                                        <strong>{{ personaEntrega }}</strong><br> -->
<!--         	                                        {{ domicilioEntrega }}<br> -->
<!--         	                                        {{ numeroEntrega }} {{ coloniaEntrega }}<br> -->
<!--         	                                        {{ ciudadEntrega }}<br>	  -->
        	                                        
<!--         	                                        {{ fechaEntrega }}                                        -->
<!--         	                                    </address> -->
													<div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            Consignaci&oacute;n
                                                        </div>
                                                        <div class="panel-body">
                          	<!--         	                                    Inicio Domicilio consignacion -->
                        									<div class="row" >
                        										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        											<div class="form-group" v-bind:class="{'has-error': personaEntregaErr}">
                        												<label class="control-label" for="price">
                        													Persona
                        												</label>
                        												<div v-show="keepInfoEntregaVale">
                        													{{ personaEntrega }}
                        												</div>
                        												<div v-show="!keepInfoEntregaVale">
                        													<input type="text" v-model="personaEntregaAux"
                        													       class="form-control" maxlength="200"/>
                        													<span class='help-block'>
                        														<strong>{{ personaEntregaErr }}</strong>
                        													</span>
                        												</div>
                        
                        
                        											</div>
                        										</div>
                        									</div>
                        									<div class="row" >
                        										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        											<div class="form-group" v-bind:class="{'has-error': domicilioEntregaErr}">
                        												<label class="control-label" for="price">
                        													Direci&oacute;n
                        												</label>
                        												<div v-show="keepInfoEntregaVale">
                        													{{ domicilioEntrega }} 
                        												</div>
                        												<div v-show="!keepInfoEntregaVale">
                        													<input type="text" v-model="domicilioEntregaAux"
                        													       class="form-control" maxlength="60"/>
                        													<span class='help-block'>
                        														<strong>{{ domicilioEntregaErr }}</strong>
                        													</span>
                        												</div>
                        
                        
                        											</div>
                        										</div>
                        									</div>
                        									<div class="row" >
                        										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        											<div class="form-group" v-bind:class="{'has-error': numeroEntregaErr}">
                        												<label class="control-label" for="price">
                        													N&uacute;mero
                        												</label>
                        												<div v-show="keepInfoEntregaVale">
                        													{{ numeroEntrega }}
                        												</div>
                        												<div v-show="!keepInfoEntregaVale">
                        													<input type="text" v-model="numeroEntregaAux"
                        													       class="form-control" maxlength="60"/>
                        													<span class='help-block'>
                        														<strong>{{ numeroEntregaErr }}</strong>
                        													</span>
                        												</div>
                        
                        											</div>
                        										</div>
                        										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        											<div class="form-group" v-bind:class="{'has-error': coloniaEntregaErr}">
                        												<label class="control-label" for="price">
                        													Colonia
                        												</label>
                        												<div v-show="keepInfoEntregaVale">
                        													{{ coloniaEntrega }}
                        												</div>
                        												<div v-show="!keepInfoEntregaVale">
                        													<input type="text" v-model="coloniaEntregaAux"
                        													       class="form-control" maxlength="60"/>
                        													<span class='help-block'>
                        														<strong>{{ coloniaEntregaErr }}</strong>
                        													</span>
                        												</div>
                        
                        											</div>
                        										</div>
                        										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        											<div class="form-group" v-bind:class="{'has-error': ciudadEntregaErr}">
                        												<label class="control-label" for="price">
                        													Ciudad
                        												</label>
                        												<div v-show="keepInfoEntregaVale">
                        													{{ ciudadEntrega }}
                        												</div>
                        												<div v-show="!keepInfoEntregaVale">
                        													<input type="text" v-model="ciudadEntregaAux"
                        													       class="form-control" maxlength="60"/>
                        													<span class='help-block'>
                        														<strong>{{ ciudadEntregaErr	 }}</strong>
                        													</span>
                        												</div>
                        
                        											</div>
                        										</div>
                        									</div>
                        									<div class="row">
                        										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"  >
                        											<div class="form-group" v-bind:class="{'has-error': fechaEntregaErr}">
                        				                                <label class="control-label">Fecha Entrega</label>
                        				                                
                        				                                <div v-show="keepInfoEntregaVale">
                        													{{ fechaEntrega }}
                        												</div>
                        				                                <div v-show="!keepInfoEntregaVale" class="input-group date">
                        				                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        				                                    <input v-modal="fechaEntregaAux" id="dtFechaEntrega" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>
                        				                                    ">
                        				                                    
                        				                                </div>
                        				                                
                        				                                <span class='help-block'>
                        														<strong>{{ fechaEntregaErr }} </strong>
                        												</span>
                        				                            </div>
                        										</div>
                        										
                        									</div>
                        									<div class="row" >
                        										
                        										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        											<label class="control-label">Hora Entrega</label>
                        											<div v-show="keepInfoEntregaVale">
                        													{{ horaEntrega }}
                        												</div>
                        											<select v-show="!keepInfoEntregaVale" v-model="horaEntregaAux" class="form-control">
                        												<option value="NOSEL">-</option>
                        												<option value="MATUTINO">MATUTINO</option>
                        												<option value="VESPERTINO">VESPERTINO</option>
                        											</select>
                        										</div>
                        									</div>
                        									<div v-show="generarValeSalida != 'SI' " class="row" >
                        										<br>
                        										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            										<button v-show="keepInfoEntregaVale" @click.prevent="editarConsignacion" class="btn btn-primary">Editar</button>
                            										<button v-show="!keepInfoEntregaVale" @click.prevent="saveConsignacion" class="btn btn-primary pull-right">Guardar</button>
                            										<button v-show="!keepInfoEntregaVale" @click.prevent="calcelarEdicionConsignacion" class="btn btn-danger">Cancelar</button>
                        										</div>
                        										
                        									</div>
        <!--                  									<div class="row">  -->
        <!--                  										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">  -->
                        											
                        											
        <!--                  												<input type="text" v-model="horaEntrega"  id="txtHoraEntrega"  -->
        <!--                  													       class="form-control" maxlength="45"/>  -->
        <!--                  											<div class="input-group clockpicker" data-autoclose="true">												  -->
        <!--                  				                                <input id="txtHoraEntrega" type="text" class="form-control" v-model='horaEntrega' >  -->
        <!--                  				                                <span class="input-group-addon">  -->
        <!--                  				                                    <span class="fa fa-clock-o"></span>  -->
        <!--                  				                                </span>  -->
        <!--                  				                            </div>  -->
        <!--                  										</div>  -->
        <!--                  										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> --> 
                        											
        <!--                  										</div> -->
                        
        <!--                  									</div>  -->
                        
                        								
        <!--         	                                    fin domicilio consignacion -->
                                                            
                                                        </div>
                
                                                    </div>



        	                                    
                                            </div>
                                            
                                            
                                            <hr>
                                            <button v-if="generarValeSalida != 'SI' " @click.prevent="pedidoAunNoValeSalida(idValeSalidaSeleccionado)" class="btn btn-warning ">A&Uacute;N NO IMPRIMIR</button>
                                            <br>
                                            <div v-show="aunno.length > 0 && generarValeSalida != 'SI' "  class="well">
                                            	{{ aunno }}
                                            </div>
        <!--                                     <div v-show="recogeentrega == 'RECOGE'"> -->
        <!--                                     	<span>Preferentemente en:</span> -->
        <!-- 	                                    <address> -->
        <!-- 	                                        <h2 class="text-success" >{{ sucursalPreferente }}</h2> -->
        	                                        	                                        
        <!-- 	                                    </address> -->
        <!--                                     </div> -->
        						</div>
        					</div>
        					<div class="col-md-5">
        						<div class="row">
                                	<div class="col-sm-10">
                						Pedido Saldado?
                                	</div>	
                                	<div class="col-sm-2">
                                		{{ chkPedidoSaldado }}
                                	</div>
                                	
                                	
                                </div>
                                <hr>
                                <?php if (Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || ModeloUsuario::amIRoot() || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS)): ?>
                                <div  v-show="chkPedidoSaldado == 'NO' ">
                                    
                                    
                                    <div class="row">
                                    	<div class="col-sm-10">
                    						Permitir Imprimir aun cuando Pedido no esta Saldado (Administrador, Cobranza)
                                    	</div>	
<!--                                     	<div v-if="generarValeSalida != 'SI' || !chkImprimirPedidoNoSaldado " class="col-sm-2"> -->
										<div  class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkImprimirPedidoNoSaldado" v-model="chkImprimirPedidoNoSaldado"> <label class="onoffswitch-label" for="chkImprimirPedidoNoSaldado"> 
                                        				<span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
<!--                                     	<div v-if="generarValeSalida == 'SI' && chkImprimirPedidoNoSaldado" class="col-sm-2"> -->
<!--                                     		{{ (chkImprimirPedidoNoSaldado ? 'SI' : 'NO') }} -->
<!--                                     	</div> -->
                                    	
                                    	
                                    </div>
                                </div>
                                <hr>
                                
                                <?php endif; ?>
                                
                                	<div class="row">
                                    	<div class="col-sm-10">
                    						Es la direcci&oacute;n correcta?
                                    	</div>	
                                    	<div v-if="generarValeSalida != 'SI' " class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkDireccionCorrecta" v-model="chkDireccionCorrecta"> <label class="onoffswitch-label" for="chkDireccionCorrecta"> 
                                        				<span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
                                    	<div v-if="generarValeSalida == 'SI' " class="col-sm-2">                                    		
                                    		{{ (chkDireccionCorrecta ? 'SI' : 'NO') }}
                                    	</div>
                                    	
                                    	
                                    </div>
                                    <hr>
                                    <div class="row">
                                    	
                                    	<div class="col-sm-10">
                                    		Es el d&iacute;a correcto?
                                    	</div>
                                    	
                                    	<div v-if="generarValeSalida != 'SI' " class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkDiaCorrecto" v-model="chkDiaCorrecto"> <label class="onoffswitch-label" for="chkDiaCorrecto"> <span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
                                    	<div v-if="generarValeSalida == 'SI' " class="col-sm-2">                                    		
                                    		{{ (chkDiaCorrecto ? 'SI' : 'NO') }}
                                    	</div>
                                    	
                                    </div>
                                    <hr>
                                    
                                    <div class="row">
                                    	
                                    	<div class="col-sm-10">
                                    		Es el horario correcto?
                                    	</div>
                                    	
                                    	<div v-if="generarValeSalida != 'SI' " class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkHorarioCorrecto" v-model="chkHorarioCorrecto"> <label class="onoffswitch-label" for="chkHorarioCorrecto"> <span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
                                    	<div v-if="generarValeSalida == 'SI' " class="col-sm-2">                                    		
                                    		{{ (chkHorarioCorrecto ? 'SI' : 'NO') }}
                                    	</div>
                                    	
                                    </div>
                                    <hr>
                                    
                                    <div class="row">
                                    	
                                    	<div class="col-sm-10">
                                    		Esta listo el equipo adecuado para la descarga?
                                    	</div>
                                    	
                                    	<div v-if="generarValeSalida != 'SI' " class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkEquipoListo" v-model="chkEquipoListo"> <label class="onoffswitch-label" for="chkEquipoListo"> <span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
                                    	<div v-if="generarValeSalida == 'SI' " class="col-sm-2">                                    		
                                    		{{ (chkEquipoListo ? 'SI' : 'NO') }}
                                    	</div>
                                    	
                                    </div>
                                    <hr>
                                    
                                    <div class="row">
                                    	
                                    	<div class="col-sm-10">
                                    		Estan correctos los datos de la persona que recibe?
                                    	</div>
                                    	
                                    	<div v-if="generarValeSalida != 'SI' " class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkPersonaCorrecta" v-model="chkPersonaCorrecta"> <label class="onoffswitch-label" for="chkPersonaCorrecta"> <span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
                                    	<div v-if="generarValeSalida == 'SI' " class="col-sm-2">                                    		
                                    		{{ (chkPersonaCorrecta ? 'SI' : 'NO') }}
                                    	</div>
                                    	
                                    </div>
                                    <hr>
                                    
                                    
                                    <div class="row">
                                    	
                                    	<div class="col-sm-10">
                                    		Hay el espacio para descargar?
                                    	</div>
                                    	
                                    	<div v-if="generarValeSalida != 'SI' " class="col-sm-2">
                                    		<div class="switch">
                                        		<div class="onoffswitch">
                                        			<input type="checkbox" class="onoffswitch-checkbox"
                                        				id="chkHayEspacio" v-model="chkHayEspacio"> <label class="onoffswitch-label" for="chkHayEspacio"> <span
                                        				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                        			</label>
                                        		</div>
                                        	</div>
                                    	</div>
                                    	<div v-if="generarValeSalida == 'SI' " class="col-sm-2">                                    		
                                    		{{ (chkHayEspacio ? 'SI' : 'NO') }}
                                    	</div>
                                    	
                                    </div>
                                    
                                
                                <?php //endif;?>
                                
                                
                                
                                <hr>
                                <?php if (Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || ModeloUsuario::amIRoot() || Permisos::userIsThisRol(Permisos::$rol_CXCVENTAS) ): ?>
                                	<button  @click.prevent="permitirImprimirVale" class="btn btn-success"> Guardar Valores del Vale</button>
                                <?php else:?>
                                	<button v-if="generarValeSalida != 'SI'" @click.prevent="permitirImprimirVale" class="btn btn-success"> Guardar Valores del Vale</button>
                                <?php endif;?>

								<hr>

								<div v-show="pedidoSaldoTotal > 26250 || pedidoSaldoTotalMas30Dias > 0" class="row">
									<div class="col-sm-12">
										
										<div >
											
											<span class="alert-danger">Pago VS Entrega No permitido en este Vale, el SALDO Global del Cliente excede la cantidad permitida ($25, 000) para esta opci&oacute;n</span>
										</div>
									</div>
								</div>

								

								<div v-if="pedidoSaldoTotal <=26250 && pedidoSaldoTotalMas30Dias <= 0"  class="row">
									
									<div class="col-sm-10">
										<span v-if="recogeentrega == 'RECOGE'">
											Liberado por Promotor
										</span>
										<span v-else>
											Pago VS Entrega
										</span>
										
										
									</div>
									
									<div class="col-sm-2">
										<div v-show="yaimpreso == 'SI'">
											<span v-if="chkPagoVSEntrega">SI</span>
											<span v-else>NO</span>
										</div>
										<div v-show="yaimpreso == 'NO'" class="switch">
											
											<div class="onoffswitch">
												<input type="checkbox" class="onoffswitch-checkbox"
													id="chkPagoVSEntrega" v-model="chkPagoVSEntrega"> <label class="onoffswitch-label" for="chkPagoVSEntrega"> 
													<span
													class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
												</label>
											</div>
											
										</div>
									</div>
									
								</div>
								<br>
								<!-- Chofer recibe dinero -->
								<div v-if="valeSalidaTotal <=26250 && pedidoSaldoTotalMas30Dias <= 0 && recogeentrega != 'RECOGE'"  class="row">
									
									<div class="col-sm-10">
										Chofer recibe dinero
										
									</div>
									
									<div class="col-sm-2">
										<div v-show="yaimpreso == 'SI'">
											<span v-if="chkRecibeDinero">SI</span>
											<span v-else>NO</span>
										</div>
										<div v-show="yaimpreso == 'NO'" class="switch">
											
											<div class="onoffswitch">
												<input type="checkbox" class="onoffswitch-checkbox"
													id="chkRecibeDinero" v-model="chkRecibeDinero"> <label class="onoffswitch-label" for="chkRecibeDinero"> 
													<span
													class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
												</label>
											</div>
											
										</div>
									</div>
									
								</div>
								<!-- Fin Chofer recibe dinero -->
                                
                                
        					</div>
        					<div class="col-md-1"></div>
        				</div>
<!-- 						Fin Datos del Vale de Salida -->
					</div>
					
					
					<div class="clearfix"></div>
				</div>
			</div>

			
			<div v-show="!mostrandoVale" class="ibox float-e-margins">
				<div class="ibox-content">
				
					<h2>Productos de Pedido no Incluidos en Vale de Salida</h2>
					<br>
					<div class="row">
						<div class="col-lg-4">
							<select v-model="idSucursal" class="form-control">
        						<option value="0">-- Seleccione Sucursal --</option>
        						<?php 
        						  
        						foreach ($lstSucursales as $s)
        						{
        						    echo "<option value=\"".$s["value"]."\">".$s["theoption"]."</option>";
        						}
        						
        						?>
        					</select>
						</div>
						<div class="col-lg-8">
							<div v-if="mercanciaSinVale.length > 0"	>
								
								<button @click.prevent="asignarTodoAVale" class="btn btn-primary"> incluir Todo</button>
								
							</div>
						</div>
					</div>
					
					<br>
					<table id="tablaToExcel" class="table table-bordered table-hover ">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Sucursal</th>
								<th>Pzas en Pedido</th>
								<th>Pzas Sin Vale</th>
								<th>Incluir en Vale</th>								
							</tr>
						</thead>
						<tbody>	
							<tr v-for="item in mercanciaSinVale" :style="'background: ' + (item.partidaaagregar > (item.partida - item.partidaenvale) ? '#ff0013'  : '')">
								<td>
									{{ item.producto }}
								</td>
								<td>{{ item.sucursal }}</td>
								<td>{{ item.partida }}</td>
								<td>{{ item.partida - item.partidaenvale }}</td>
								<td>
								
									<span  v-if=" (item.partida - item.partidaenvale) == 0" class="label label-info"> No hay mercancia para ingresar a Vale</span>
									<input v-if=" (item.partida - item.partidaenvale) > 0"
            									type="text" v-model="item.partidaaagregar" placeholder=""
            									oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"
            									maxlength="9" class="form-control">
								</td>
							</tr>						
						</tbody>
					</table>
					
					<div v-if="errCrearValeSalida">
						<hr>
							<div class="alert alert-danger" v-html="errCrearValeSalida">
								
							</div>
							
						<hr>
					</div>
					
					<button @click.prevent="crearValeSalida" class="btn btn-primary pull-right"> Crear Vale de Salida</button>
					<div class="clearfix"></div>
				
				</div>
			</div>
		
		
			    		
    		

    		
		</div>
	</div>
</div>


<!-- <pre>{{ $data }}</pre>  -->
    