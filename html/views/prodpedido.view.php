<?php
$titlePage = "Pedidos Producci&oacute;n";
$breadCum = "Producci&oacute;n/Pedidos en Producci&oacute;n";
$_lugar = LUGAR_PRODUCCION_PEDIDOSPRODUCCION;
//$_useDataTable = true;

?>


<!-- FILTRO Y PEDIDOS -->
<div v-show="showSELECCIONAPEDIDO">

	<div class="ibox-content m-b-sm border-bottom">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="control-label" for="order_id">No Pedido</label> 
					<input v-model="filtro.noPedido"
						type="text" id="order_id" name="order_id" value=""
						placeholder="" class="form-control">
				</div>
			</div>
<!-- 			<div class="col-lg-8	 col-md-8 col-sm-12 col-xs-12">  -->
<!--  				<div class="form-group"> -->
									
<!--  					<label class="control-label" for="filIdCliente">Cliente</label>  -->
				
<!--  					<select id="filIdCliente" v-model="filtro.idCliente" class="form-control"> -->
<!--  						<option value='0'>-- Todos Mis Clientes --</option>  -->
						
						<?php 
//  						echo $lstClientes; 
//  						?>
						
<!-- 					</select>  -->
<!--  				</div>  -->
<!--  			</div> -->

		</div>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<button @click.prevent="filtrar" class="btn btn-primary">Filtrar</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<th>Pedido</th>
								<th>Cliente</th>
								<th>Total</th>
<!-- 								<th>Fecha</th>								 -->
								<th>Acci&oacute;n</th>
							</thead>
							<tbody>
							
								<tr v-for="ped in pedidos">
									<td>{{ ped.idPedido }}</td>
									<td>{{ ped.nombreCliente }} </td>
<!-- 									<td>$ {{ ped.total }}</td> -->
									<td>{{ ped.fecha }}</td>
									<td>
										<a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + ped.idPedido" class="btn btn-info btn-sm">
											<i class="fa fa-eye"></i>
										</a>
										<a target="_blank" :href="'<?php echo URL_BASE?>pedidoprintdata?id=' + ped.idPedido" class="btn btn-info btn-sm">
												<i class="fa fa-print"></i> 
											</a>
									
									</td>
								</tr>
							
							
<!-- 								<tr v-for="(cli, index) in clientesFiltradosPorNombre"> -->

<!-- 									<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td> -->
<!-- 									<td>{{ cli.empresa }}</td> -->
<!-- 									<td class="contact-type"> -->
<!-- 										<i v-show="cli.email" class="fa fa-envelope"></i> -->
<!-- 									</td> -->
<!-- 									<td>{{ cli.email }}</td> -->
<!-- 									<td class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></td> -->
<!-- 									<td>{{ cli.telefonos }}</td> -->
<!-- 									<td class="client-status"><button @click.prevent="seleccionarCliente(cli.idCliente)" class="btn btn-primary btn-xs">Seleccionar</button></td> -->
<!-- 								</tr>					 -->

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- END FILTRO Y PEDIDOS -->



<!-- <div v-show="showFORMAUTH" class="row"> -->
<!-- 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 		<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar otro Pedido</button> -->
<!-- 		<div class="ibox float-e-margins"> -->
<!-- 			<div class="ibox-title"> -->
<!-- 				<h5>Proceso de Autorizaci&oacute;n de Pedido <small></small></h5>				 -->
<!-- 			</div> -->
<!-- 			<div class="ibox-content"> -->
			
<!-- 				<div class="row"> -->
<!-- 					<div class="col-lg-6"> 
						<h4>Pedido No.<strong style="font-size: 2em" class="text-navy"> {{ idPedido }}</strong><span style="font-size: 1.2em" class="text-navy">&nbsp;&nbsp;&nbsp;{{ nombreCliente }}</span></h4>-->
<!-- 					</div> -->
<!-- 					<div class="col-lg-6"> -->
<!-- 						<div v-show="estado == 'CAPTURADO' && autorizaCXC == 'NO'"> -->
<!-- 							<h3 class="font-bold">Opciones de Autorizaci&oacute;n</h3> -->
<!-- 							<div class="btn-group"> -->
<!-- 								<button @click.prevent="cargarPedidoCreditos" class="btn btn-primary btn-outline" type="button">Autorizaci&oacute;n por cr&eacute;dito</button> -->
<!-- 								<button @click.prevent="solicitaAuthCXC" class="btn btn-primary btn-outline" type="button">Solicitar Autorizaci&oacute;n a CxC</button> -->
								
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 						<div v-show="estado == 'CAPTURADO' && autorizaCXC == 'SI'"> 
							<h3 class="font-bold">Pedido <span style="font-size: 1.5em" class="text-navy"> &nbsp;&nbsp;&nbsp; {{ estado }}</span></h3>-->
<!-- 							<div class="alert alert-danger text-left"> -->
<!--                                 <strong>Se ha solicitado a CXC que Autorice este Pedido.</strong> -->
<!--                             </div> -->
<!-- 						</div> -->
<!-- 						<div v-show="estado != 'CAPTURADO'"> 
							<h3 class="font-bold">Pedido <span style="font-size: 1.5em" class="text-navy"> &nbsp;&nbsp;&nbsp; {{ estado }}</span></h3>-->
<!-- 							Este proceso de Autorizaci&oacute;n es para Pedidos en estado CAPTURADO							 -->
<!-- 						</div> -->
						
<!-- 					</div> -->
<!-- 				</div>			 -->

				

				<!-- 				SECAUTHCTE -->
<!-- 				<div v-show="showSECAUTHCTE && estado == 'CAPTURADO' && autorizaCXC == 'NO' "> -->
<!-- 					<hr> -->
<!-- 					<h2>Autorizaci&oacute;n por Cr&eacute;dito</h2> -->
<!-- 					<div class="row"> -->
<!-- 						<div class="col-lg-2"> -->
<!-- 							<div class="ibox float-e-margins panel-rec"> -->
<!-- 			                    <div class="ibox-title"> -->
<!-- 			                        <span class="label label-info pull-right"><h3 class="no-margins">{{ frmXCredito.idPedido }} </h3></span> -->
<!-- 			                        <h5>Pedido</h5> -->
<!-- 			                    </div> -->
<!-- 			                    <div class="ibox-content"> -->
<!-- 			                        <h2 class="no-margins">$ {{ formatNumber(frmXCredito.totalPedido) }}</h2> -->
<!-- 			                        <a :href="'pedidodetalleview/' + idPedido" target="_blank" class="stat-percent font-bold text-info">ver <i class="fa fa-eye"></i></a> -->
<!-- 			                        <small>Total</small> -->
<!-- 			                    </div> -->
<!-- 			                </div> -->
<!-- 						</div> -->
<!-- 						<div class="col-lg-5"> -->
<!-- 							<div class="ibox float-e-margins panel-rec"> -->
<!-- 			                    <div class="ibox-title"> -->
<!-- 			                        <span class="label label-primary pull-right"><h3 class="no-margins">$ {{ formatNumber(frmXCredito.cteCredito) }}</h3></span> -->
<!-- 			                        <h5>Cr&eacute;dito CLIENTE</h5> -->
<!-- 			                    </div> -->
<!-- 			                    <div class="ibox-content"> -->
			
<!-- 			                        <div class="row"> -->
<!-- 			                            <div class="col-md-6"> -->
<!-- 			                                <h2 class="no-margins">$ {{ formatNumber(frmXCredito.cteUsado) }}</h2>			                                 -->
<!-- 			                                <div class="font-bold text-danger"><small>Usado</small></div> -->
<!-- 			                            </div> -->
<!-- 			                            <div class="col-md-6"> -->
<!-- 			                                <h2 class="no-margins">$ {{ formatNumber(frmXCredito.cteDisponible) }}</h2> -->
<!-- 			                                <div class="font-bold text-success"><small>Disponible</small></div> -->
<!-- 			                            </div> -->
<!-- 			                        </div> -->
			
			
<!-- 			                    </div> -->
<!-- 			                </div> -->
<!-- 						</div> -->
<!-- 						<div class="col-lg-5"> -->
<!-- 							<div class="ibox float-e-margins panel-rec"> -->
<!-- 			                    <div class="ibox-title"> -->
<!-- 									<span class="label label-primary pull-right"><h3 class="no-margins">$ {{ formatNumber(frmXCredito.promoCredito) }}</h3></span>									 -->
<!-- 			                        <h5>Cr&eacute;dito PROMOTOR</h5> -->
			                        
<!-- 			                    </div> -->
<!-- 			                    <div class="ibox-content">			 -->
<!-- 			                        <div class="row"> -->
<!-- 			                            <div class="col-md-6"> -->
<!-- 			                                <h2 class="no-margins">$ {{ formatNumber(frmXCredito.promoUsado) }}</h2>			                                 -->
<!-- 			                                <div class="font-bold text-danger"><small>Usado</small></div> -->
<!-- 			                            </div> -->
<!-- 			                            <div class="col-md-6"> -->
<!-- 			                                <h2 class="no-margins">$ {{ formatNumber(frmXCredito.promoDisponible) }}</h2> -->
<!-- 			                                <div class="font-bold text-success"><small>Disponible</small></div> -->
<!-- 			                            </div> -->
<!-- 			                        </div>			 -->
			
<!-- 			                    </div> -->
<!-- 			                </div> -->
<!-- 						</div> -->
<!-- 					</div>			 -->
					
<!-- 					<div class="row"> -->
<!-- 						<div class="col-lg-6 text-center"> -->
<!-- 							<h2>Autorizaci&oacute;n Cr&eacute;ndito Cliente</h2> -->
<!-- 							<div v-show="showAUTHCTESuccess" class="alert alert-success text-left"> -->
<!--                                 El Pedido se puede Autorizar por Cr&eacute;dito del Cliente. -->
<!--                             </div> -->
<!--                             <div v-show="showAUTHCTEDanger" class="alert alert-danger text-left"> -->
<!--                                 El Cr&eacute;dito Disponible del Cliente no cubre el total del Pedido. -->
<!--                             </div> -->
<!--                             <div class="row">	                            	 -->
<!-- 	                            <div class="col-xs-12"> -->
<!-- 	                                <span class="stats-label">Cr&eacute;dito Cliente a Considerar</span> -->
<!-- 	                                <h3>$ {{ formatNumber(frmXCredito.cteATomar) }}</h3> -->
<!-- 	                            </div> -->
	                            
<!-- 	                        </div> -->
<!--                             <button @click.prevent="autorizarXCreditoCliente" v-show="showAUTHCTEAutorizar" class="btn btn-success btn-lg"> -->
<!--                             	Autorizar Pedido -->
<!--                             </button> -->
<!-- 						</div> -->
<!-- 						<div class="col-lg-6 text-center"> -->
<!-- 							<h2>Autorizaci&oacute;n Apoyo Promotor</h2> -->
<!-- 							<div v-show="showAUTHPROMOSuccess && frmXCredito.promoBloquedado == 'NO'" class="alert alert-success text-left"> -->
<!--                                 El Pedido se puede Autorizar con apoyo del Cr&eacute;dito del Promotor. -->
<!--                             </div> -->
<!--                             <div v-show="showAUTHPROMOWarning" class="alert alert-warning text-left"> -->
<!--                                 El Pedido puede Autorizarse con Cr&eacute;dito de Cliente. -->
<!--                             </div> -->
<!--                             <div v-show="showAUTHPROMODanger" class="alert alert-danger text-left"> -->
<!--                                 El Cr&eacute;dito Disponible del Cliente a&uacute;n con apoyo del Cr&eacute;dito Disponible de Promotor no cubre el total del Pedido. -->
<!--                             </div> -->
<!--                             <div v-show="showAUTHPROMOAutorizar && frmXCredito.promoBloquedado == 'NO'" class="row">	                            	 -->
<!-- 	                            <div class="col-xs-6"> -->
<!-- 	                                <span class="stats-label">Cr&eacute;dito Cliente a Considerar</span> -->
<!-- 	                                <h3>$ {{ formatNumber(frmXCredito.cteATomar) }}</h3> -->
<!-- 	                            </div> -->
<!-- 	                            <div class="col-xs-6"> -->
<!-- 	                                <span class="stats-label">Cr&eacute;dito Promotor a Considerar</span> -->
<!-- 	                                <h3>$ {{ formatNumber(frmXCredito.promoATomar) }}</h3> -->
<!-- 	                            </div> -->
<!-- 	                        </div> -->
<!--                             <button @click.prevent="autorizarXCreditoPromotor" v-show="showAUTHPROMOAutorizar && frmXCredito.promoBloquedado == 'NO'" class="btn btn-success btn-lg"> -->
<!--                             	Autorizar Pedido -->
<!--                             </button> -->
<!--                             <div v-show="frmXCredito.promoBloquedado == 'SI'" class="alert alert-danger text-left"> -->
<!--                                 <strong>Su Cr&eacute;dito esta BLOQUEADO. Favor de revisar Pagos pendientes de sus Clientes.</strong> -->
<!--                             </div> -->
                            
<!-- 						</div> -->
<!-- 					</div>		 -->
					

<!-- 				</div> -->


<!-- 				<div v-show="showSECAUTHTOADMIN && estado == 'CAPTURADO' && autorizaCXC == 'NO'"> -->
<!-- 					<hr> -->
<!-- 					<h2>Solicitar que CxC Autorice el Pedido.</h2> -->
<!-- 					<button @click.prevent="solicitarAuthPedidoCXC" v-show="showAUTHPROMOAutorizar && frmXCredito.promoBloquedado == 'NO'" class="btn btn-success btn-lg"> -->
<!--                      	Solicitar a CXC Autorice Pedido -->
<!--                     </button> -->
<!-- 				</div> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 	</div> -->
<!-- </div> -->


<!-- <pre> -->
<!-- {{ $data }} -->
<!-- </pre> -->