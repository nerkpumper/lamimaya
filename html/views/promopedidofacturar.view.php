<?php
$titlePage = "Facuturaci&oacute;n de Pedido";
$breadCum = "Pedidos/Facturar";
$_lugar = LUGAR_PROMOTOR_PEDIDOSAFACTURAR;

// $_addHead="
 		
//  		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
//  		";

$_addScript="
 		
		<script src=\"".URL_BASE."js/components/cliente-dirfiscales-selector.vue.js\"></script>
 		";

?>

<cliente-dirfiscales-selector @on-select="onDirSelected($event)" 
							ref="nuevaDireccionExistente"
							shownombrecliente="true"
							seleccionarsinrfcs="true"
							leyendashow="Seleccione RFC para asignarlo al Pedido">
</cliente-dirfiscales-selector>


<div v-show="seleccionarPedido">
	<h2 class="m-l">No. Pedido a Facturar:</h2>
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

	<a href="../promopedidoafacturar" class="btn btn-warning" >Seleccionar otro Pedido</a> 
	<br>
	<br>

	<div class="row">
		

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>
						Datos de Facturaci&oacute;n del Cliente
					</h5>
<!-- 					<div class="ibox-tools"> -->
<!-- 						<a class="collapse-link"> <i class="fa fa-chevron-up"></i> -->
<!-- 						</a> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i -->
<!-- 							class="fa fa-wrench"></i> -->
<!-- 						</a> -->
<!-- 						<ul class="dropdown-menu dropdown-user"> -->
<!-- 							<li><a href="#">Config option 1</a></li> -->
<!-- 							<li><a href="#">Config option 2</a></li> -->
<!-- 						</ul> -->
<!-- 						<a class="close-link"> <i class="fa fa-times"></i> -->
<!-- 						</a> -->
<!-- 					</div> -->
				</div>
				<div class="ibox-content">
				<h5 v-show="idClienteDatoFacturacion == 0" >El Pedido no tiene un RFC asignado</h5>
				<form v-show="idClienteDatoFacturacion > 0" id='frmFacturacion' method='post'>
					<input type="hidden" v-model="idCliente" id="idCliente" name="idCliente" ref="idCliente" >
						<div class="row">

							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacRazonSocial}">
									<label class="control-label" for="facRazonSocial">Raz&oacute;n
										Social</label> <input v-model='facRazonSocial'
										ref='facRazonSocial' type="text" id="facRazonSocial"
										name="facRazonSocial" class="form-control" disabled="disabled">
									<span v-if='errFacRazonSocial' class='help-block'> <strong> {{
											errFacRazonSocial }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group" v-bind:class="{'has-error': errFacRFC}">
									<label class="control-label" for="facRFC">R. F. C.</label> <input
										v-model='facRFC' ref='facRFC' maxlength="13" type="text"
										id="facRFC" name="facRFC" class="form-control"
										disabled="disabled"> <span v-if='errFacRFC' class='help-block'>
										<strong> {{ errFacRFC }}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacDomicilio }">
									<label class="control-label" for="facDomicilio">Domicilio
										Fiscal</label> <input v-model="facDomicilio"
										ref="facDomicilio" type="text" id="facDomicilio"
										name="facDomicilio" class="form-control" disabled="disabled">
									<span v-if='errFacDomicilio' class='help-block'> <strong> {{
											errFacDomicilio }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacNumero}">
									<label class="control-label" for="facNumero">No.</label> <input
										v-model="facNumero" ref="facNumero" type="text" id="facNumero"
										name="facNumero" class="form-control" disabled="disabled"> <span
										v-if='errFacNumero' class='help-block'> <strong> {{
											errFacNumero }}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacColonia}">
									<label class="control-label" for="facColonia">Colonia</label> <input
										v-model="facColonia" ref="facColonia" type="text"
										id="facColonia" name="facColonia" class="form-control"
										disabled="disabled"> <span v-if='errFacColonia'
										class='help-block'> <strong> {{ errFacColonia }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacCiudad}">
									<label class="control-label" for="facCiudad">Ciudad</label> <input
										v-model="facCiudad" ref="facCiudad" type="text" id="facCiudad"
										name="facCiudad" class="form-control" disabled="disabled"> <span
										v-if='errFacCiudad' class='help-block'> <strong> {{
											errFacCiudad }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								<div class="form-group" v-bind:class="{'has-error': errFacCP}">
									<label class="control-label" for="facCP">C.P.</label> <input
										v-model="facCP" ref="facCP" maxlength="9"
										oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
										type="text" id="facCP" name="facCP" class="form-control"
										disabled="disabled"> <span v-if='errFacCP' class='help-block'>
										<strong> {{ errFacCP }}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacTelefono}">
									<label class="control-label" for="Telefonos">Telefono</label> <input
										v-model="facTelefono" ref="facTelefono" type="text"
										id="facTelefono" name="facTelefono" class="form-control"
										disabled="disabled"> <span v-if='errFacTelefono'
										class='help-block'> <strong> {{ errFacTelefono }}</strong>
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group"
									v-bind:class="{'has-error': errFacEmail}">
									<label class="control-label" for="facEmail">EMail</label> <input
										v-model="facEmail" ref="facEmail" type="email" id="facEmail"
										name="facEmail" class="form-control" disabled="disabled"
										pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required> <span
										v-if='errFacEmail' class='help-block'> <strong> {{ errFacEmail
											}}</strong>
									</span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<label class="control-label" for="facCFDI">Uso CFDI</label> <select
									id="facCFDI" name="facCFDI" class="form-control"
									v-model="facCFDI" disabled="disabled">
									<option value="0">-- Seleccione Uso CFDI --</option>
								<?php
									foreach ($lstUsoCFDI as $u) {
										echo "<option value=\"" . $u["value"] . "\">" . $u["theoption"] . "</option>";
									}
									
									?> 
							</select> <span v-if='errFacCFDI' class='help-block'> <strong> {{
										errFacCFDI }}</strong>
								</span>

							</div>

						</div>
						<div class="row">
							<div class="col-lg-12">
								<label class="control-label" for="facRegimenFiscal">R&eacute;gimen</label> <select
									id="facRegimenFiscal" name="facRegimenFiscal" class="form-control"
									v-model="facRegimenFiscal" disabled="disabled">									
								<?php
									foreach ($lstRegimenFiscal as $u) {
										echo "<option value=\"" . $u["value"] . "\">" . $u["theoption"] . "</option>";
									}
									
									?> 
							</select> 

							</div>

						</div>


					</form>
				</div>
				<div class="ibox-footer">
					<span  class="pull-right">
						<button id ="guardarEdicionFactura"  @click.prevent="guardarEdicionFactura"
							class="btn btn-success" style="display:none">Guardar</button>
					</span>
				<button id="desactivarEdicionFactura" style="display:none"
 						@click.prevent="desactivarEdicionFactura" class="btn btn-warning">Cancelar Edici&oacute;n</button> 
				 <button id="activarEdicionFactura"
				 @click.prevent="seleccionarDirFiscal" class="btn btn-primary">Seleccionar/Cambiar un RFC para este Pedido</button>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

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
                                        <td v-if="verDespachado" class="text-center"><i v-show="item.despachado == 'SI'" class="fa fa-check text-navy"></i><i v-show="item.despachado == 'NO'" class="fa fa-warning text-warning"></i>{{ item.despachado }} <span v-show="item.despachado == 'NO'" class="text-warning">({{ item.detPartidaDespachada }}/{{ item.detPartida }})</span></td>
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
<!-- 						<div v-show="estatusIncorrecto"> -->
<!-- 							<div class="alert alert-warning text-center">Para cancelar un Pedido, su estatus debe ser CAPTURADO o AUTORIZADO CXC</div> -->
<!-- 						</div> -->
						 <h2 class="text-navy">	{{ facturaSolicitada }}</h2>
						<div v-show="mostrarSolfactura">
<!-- 							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 								<div class="form-group has-error"> -->
<!-- 									<label class="control-label" for="observacionCancelacion"> Motivo Cancelacion </label>									 -->
<!-- 									<input type="text" v-model="observacionCancelacion" class="form-control" -->
<!-- 											maxlength="200" /> <span class='help-block'> Capture Motivo de Cancelaci&oacute;n -->
<!-- 										</span> -->
									

<!-- 								</div> -->
<!-- 							</div> -->
							<button id="solicitarFactura" @click.prevent="solicitarFactura" class="btn btn-success btn-lg btn-block" >Solicitar Factura de este Pedido</button>
						</div>
					</div>
				</div>
                      
              </div>
          </div>
	</div>

</div>

<!-- <pre>{{ $data }}</pre> -->