<?php
$titlePage = "Cancelar Pedido";
$breadCum = "Pedidos/Cancelar";
 $_lugar = LUGAR_CXC_CANCELARPEDIDO;

// $_addHead="
 		
//  		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
//  		";

// $_addScript="
 		
//  		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
//  		";

?>


<div v-show="seleccionarPedido">
	<h2 class="m-l">No. Pedido a Cancelar:</h2>
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

	<button class="btn btn-warning" @click.prevent="seleccionarOtroPedido">Seleccionar otro Pedido</button> 
	<br>
	<br>

	<div class="row">
<!-- 		<div v-if="mostrarEstatus" :class="claseEstatus"> -->
<!-- 			<div class="panel-rec"> -->

<!-- 				<div id="vertical-timeline" -->
<!-- 					class="vertical-container light-timeline no-margins"> -->
<!-- 					<div v-show="capturadoPor" class="vertical-timeline-block"> -->
<!-- 						<div class="vertical-timeline-icon yellow-bg"> -->
<!-- 							<i class="fa fa-check"></i> -->
<!-- 						</div> -->

<!-- 						<div class="vertical-timeline-content"> -->
<!-- 							<div class="user-friends"> -->
<!-- 								<a href=""><img alt="image" class="img-circle" :src="capturadoImage"></a> -->

<!-- 							</div> -->
<!-- 							<h2>CAPTURADO</h2> -->
<!-- 							<h5>{{ capturadoPor }}</h5> -->
<!-- 							<h5>{{ capturadoFecha }}</h5> -->
							
							
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div v-show="autorizadoPor" class="vertical-timeline-block"> -->
<!-- 						<div class="vertical-timeline-icon gray-bg"> -->
<!-- 							<i class="fa fa-check"></i> -->

<!-- 						</div> -->

<!-- 						<div class="vertical-timeline-content"> -->
<!-- 							<div class="user-friends"> -->
<!-- 								<a href=""><img alt="image" class="img-circle" :src="autorizadoImage"></a> -->

<!-- 							</div> -->
<!-- 							<h2>AUTORIZADO CXC</h2> -->
<!-- 							<h5>{{ autorizadoPor }}</h5> -->
<!-- 							<h5>{{ autorizadoFecha }}</h5> -->
<!-- 							<span>{{ autorizadoObservacion }}</span> -->
							
							
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div v-show="produccionPor" class="vertical-timeline-block"> -->
<!-- 						<div class="vertical-timeline-icon lazur-bg"> -->
<!-- 							<i class="fa fa-check"></i> -->

<!-- 						</div> -->

<!-- 						<div class="vertical-timeline-content"> -->
<!-- 							<div class="user-friends"> -->
<!-- 								<a href=""><img alt="image" class="img-circle" :src="produccionImage"></a> -->

<!-- 							</div> -->
<!-- 							<h2>PRODUCCI&Oacute;N</h2> -->
<!-- 							<h5>{{ produccionPor }}</h5> -->
<!-- 							<h5>{{ produccionFecha }}</h5> -->
							
							
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div v-show="terminadoPor" class="vertical-timeline-block"> -->
<!-- 						<div class="vertical-timeline-icon blue-bg"> -->
<!-- 							<i class="fa fa-check"></i> -->

<!-- 						</div> -->

<!-- 						<div class="vertical-timeline-content"> -->
<!-- 							<div class="user-friends"> -->
<!-- 								<a href=""><img alt="image" class="img-circle" :src="terminadoImage"></a> -->

<!-- 							</div> -->
<!-- 							<h2>TERMINADO</h2> -->
<!-- 							<h5>{{ terminadoPor }}</h5> -->
<!-- 							<h5>{{ terminadoFecha }}</h5> -->
							
							
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div v-show="entregadoPor" class="vertical-timeline-block"> -->
<!-- 						<div class="vertical-timeline-icon navy-bg"> -->
<!-- 							<i class="fa fa-check"></i> -->

<!-- 						</div> -->

<!-- 						<div class="vertical-timeline-content"> -->
<!-- 							<div class="user-friends"> -->
<!-- 								<a href=""><img alt="image" class="img-circle" :src="entregadoImage"></a> -->

<!-- 							</div> -->
<!-- 							<h2>ENTREGADO</h2> -->
<!-- 							<h5>{{ entregadoPor }}</h5> -->
<!-- 							<h5>{{ entregadoFecha }}</h5> -->
							
							
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 					<div v-show="canceladoPor" class="vertical-timeline-block"> -->
<!-- 						<div class="vertical-timeline-icon red-bg"> -->
<!-- 							<i class="fa fa-check"></i> -->

<!-- 						</div> -->

<!-- 						<div class="vertical-timeline-content"> -->
<!-- 							<div class="user-friends"> -->
<!-- 								<a href=""><img alt="image" class="img-circle" :src="canceladoImage"></a> -->

<!-- 							</div> -->
<!-- 							<h2>CANCELADO</h2> -->
<!-- 							<h5>{{ canceladoPor }}</h5> -->
<!-- 							<h5>{{ canceladoFecha }}</h5> -->
							
							
<!-- 						</div> -->
<!-- 					</div> -->

					
<!-- 				</div> -->
<!-- 			</div> -->
<!-- 		</div> -->
		

		<div v-if="mostrarPedido" :class="clasePedido">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="ibox-content p-xl">
                    
                    	<div v-if="pedidoCancelado" class="row">                    		
							<h1 class="text-center text-navy">P E D I D O  &nbsp;&nbsp;&nbsp;  C A N C E L A D O </h1>
							<h3 class="text-center">{{ cancelaObservacion }}</h3>
							<hr>
						</div>
                    
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Cliente</h5>
                                    <address>
                                        <strong>{{ cteNombre }} {{ cteApellidos }}</strong><br>
                                        <strong>{{ cteEmpresa }}</strong><br>
                                        {{ cteDomicilio1 }} {{ cteDomicilio2 }}<br>
                                        {{ cteNumero }} {{ cteColonia }}<br>
                                        {{ cteCiudad }}<br>
                                        <abbr title="Phone"></abbr>{{ cteTelefonos }}<br>
                                        {{ cteEMail }}
                                    </address>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Pedido No.</h4>
                                    <h2 class="text-navy">{{ idPedido }}</h2>
                                    <h2 class="text-navy">{{ estado }}</h2>
                                    <div v-show="recogeentrega == 'ENTREGA'">
                                    	<span>Consignacinaci&oacute;n:</span>
	                                    <address>
	                                        <strong>{{ personaEntrega }}</strong><br>
	                                        {{ domicilioEntrega }}<br>
	                                        {{ numeroEntrega }} {{ coloniaEntrega }}<br>
	                                        {{ ciudadEntrega }}<br>	                                        
	                                    </address>
                                    </div>
                                    
                                    <p>
<!--                                     	<span><strong>Estatus Actual : </strong> {{ estado }}</span><br/> -->
<!--                                         <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br/> -->
<!--                                         <span><strong>Due Date:</strong> March 24, 2014</span> -->
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>                                    	
                                        <th>Producto</th>
                                        <th>Cnt.</th>
                                        <th>ML/KG</th>
                                        <th>Des.</th>
                                        <th>Dbl.</th>
                                        <th v-if="verMontos">P.U.</th>
                                        <th v-if="verMontos">Total</th>
                                        <th v-if="verExplosionado">Explosionado</th>
                                        <th v-if="verListoProducit">Listo Producir</th>
                                        <th v-if="verDespachado">Despachado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in productos">                                    	
                                        <td><div><strong>{{ item.proDescripcion }}</strong></div>
<!--                                             <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td> -->
                                        <td>{{ item.detPartida }}</td>
                                        <td>{{ item.detCantidad }} <spam v-show="item.proShortUnidad == 'M2'">ML ({{ item.detCantidadReal }} M2)</spam> </td>
                                        <td><span v-show="item.detDesarrollo == 0">-</span><spam v-show="item.detDesarrollo > 0">{{ item.detDesarrollo }}</spam></td>
                                        <td><span v-show="item.detDobleces == 0">-</span><spam v-show="item.detDobleces > 0">{{ item.detDobleces }}</spam></td>
                                        <td v-if="verMontos">${{ formatNumber(item.detPrecioUnitario) }}</td>
                                        <td v-if="verMontos">${{ formatNumber(item.detTotal) }}</td>
                                        <td v-if="verExplosionado" class="text-center">
                                        	<i v-show="item.explotadook == 'SI'" class="fa fa-check text-navy"></i>
                                        	<span v-show="item.explotadook == 'SI'">SI</span>
                                        	<i v-show="item.explotado == 'SI' && item.explotadook == 'NO'" class="fa fa-warning text-warning"></i>                                        	
                                        	<span v-show="item.explotado == 'NO' && item.explotadook == 'SI'" class='label label-danger'>SIN &Eacute;XITO</span>
                                        	<i v-show="item.explotado == 'NO' && item.explotadook == 'NO'" class="fa fa-warning text-warning"></i>                                        	
                                        	<span v-show="item.explotado == 'NO' && item.explotadook == 'NO'">NO</span>
                                        </td>
                                        <td v-if="verListoProducit" class="text-center"><i v-show="item.listo_para_producir == 'SI'" class="fa fa-check text-navy"></i><i v-show="item.listo_para_producir == 'NO'" class="fa fa-warning text-warning"></i>{{ item.listo_para_producir }}</td>                                        
                                        <td v-if="verDespachado" class="text-center"><i v-show="item.despachado == 'SI'" class="fa fa-check text-navy"></i><i v-show="item.despachado == 'NO'" class="fa fa-warning text-warning"></i>{{ item.despachado }}</td>
                                    </tr>                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                            
                            <div>
								<h4>Observaci&oacute;n</h4>
								{{ capturaObservacion  }}
                            </div>

                            <table v-if="verMontos" class="table invoice-total">
                                <tbody>
                                <tr v-show="descuento > 0">
                                    <td><strong>Sub Total :</strong></td>
                                    <td>$ {{ subtotal }}</td>
                                </tr>
                                <tr v-show="descuento > 0">
                                    <td><strong>Descuento :</strong></td>
                                    <td>$ {{ descuento }}</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><h2>$ {{ formatNumber(total) }}</h2></td>
                                </tr>
                                </tbody>
                            </table>
<!--                             <div class="text-right"> -->
<!--                                 <button class="btn btn-primary"><i class="fa fa-dollar"></i> Make A Payment</button> -->
<!--                             </div> -->

<!--                             <div class="well m-t"><strong>Comments</strong> -->
<!--                                 It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less -->
<!--                             </div> -->

					
					

					<div class="row">
						<div v-show="estatusIncorrecto">
							<div class="alert alert-warning text-center">Para cancelar un Pedido, su estatus debe ser CAPTURADO o AUTORIZADO CXC</div>
						</div>
						<div v-show="puedeCancelarse">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group has-error">
									<label class="control-label" for="observacionCancelacion"> Motivo Cancelacion </label>									
									<input type="text" v-model="observacionCancelacion" class="form-control"
											maxlength="200" /> <span class='help-block'> Capture Motivo de Cancelaci&oacute;n
										</span>
									

								</div>
							</div>
							<button @click.prevent="cancelarPedido" class="btn btn-danger btn-lg btn-block">Cancelar Pedido</button>
						</div>
					</div>
				</div>
                      
                </div>
            </div>
	</div>

</div>

<!-- <pre>{{ $data }}</pre> -->