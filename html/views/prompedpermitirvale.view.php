<?php
$titlePage = "Permitir Imprimir Vales de Salida";
$breadCum = "Promotor/Permitir Imprimir Vale Salida";
$_lugar = LUGAR_PROMOTOR_PERMITEVALESALIDA;
//$_useDataTable = true;

?>

<!-- checklist permitir vale -->

<div class="modal inmodal fade" id="modalCheckList" tabindex="-1"
	role="dialog" aria-hidden="true">
<!-- 	<div> -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Permitir Vale de Salida</h4>
				<h3>Pedido: {{ idPedido }}</h3>

			</div>
			<div class="modal-body">
			
			
				<div class="row">
					<div class="col-md-6">
						<div class="row">
<!-- 							<h2 class="text-navy">{{ idPedido }}</h2> -->
                                    <h2 class="text-navy">{{ estado }}</h2>
                                    <h2 class="text-navy">{{ recogeentrega }} <small v-show="recogeentrega == 'OBRA'" class="text-navy">{{ tipoObra }}</small></h2>
                                    
                                    <div v-show="recogeentrega == 'ENTREGA' || recogeentrega == 'OBRA'">
                                    	<span>Consignacinaci&oacute;n:</span>
	                                    <address>
	                                        <strong>{{ personaEntrega }}</strong><br>
	                                        {{ domicilioEntrega }}<br>
	                                        {{ numeroEntrega }} {{ coloniaEntrega }}<br>
	                                        {{ ciudadEntrega }}<br>	                                        
	                                    </address>
	                                    
                                    </div>
<!--                                     <div v-show="recogeentrega == 'RECOGE'"> -->
<!--                                     	<span>Preferentemente en:</span> -->
<!-- 	                                    <address> -->
<!-- 	                                        <h2 class="text-success" >{{ sucursalPreferente }}</h2> -->
	                                        	                                        
<!-- 	                                    </address> -->
<!--                                     </div> -->
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
                        	<div class="col-sm-10">
        						Pedido Saldado?
                        	</div>	
                        	<div class="col-sm-2">
                        		{{ chkPedidoSaldado }}
                        	</div>
                        	
                        	
                        </div>
                        <hr>
                        <?php if (Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR) || ModeloUsuario::amIRoot() ): ?>
                        <div v-show="chkPedidoSaldado == 'NO' ">
                            
                            
                            <div class="row">
                            	<div class="col-sm-10">
            						Permitir Imprimir aun cuando Pedido no esta Saldado (Administrador)
                            	</div>	
                            	<div class="col-sm-2">
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
                            	
                            	
                            </div>
                        </div>
                        <hr>
                        
                        <?php else: ?>
                        
                        	<div class="row">
                            	<div class="col-sm-10">
            						Es la direcci&oacute;n correcta?
                            	</div>	
                            	<div class="col-sm-2">
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
                            	
                            	
                            </div>
                            <hr>
                            <div class="row">
                            	
                            	<div class="col-sm-10">
                            		Es el d&iacute;a correcto?
                            	</div>
                            	
                            	<div class="col-sm-2">
                            		<div class="switch">
                                		<div class="onoffswitch">
                                			<input type="checkbox" class="onoffswitch-checkbox"
                                				id="chkDiaCorrecto" v-model="chkDiaCorrecto"> <label class="onoffswitch-label" for="chkDiaCorrecto"> <span
                                				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                			</label>
                                		</div>
                                	</div>
                            	</div>
                            	
                            </div>
                            <hr>
                            
                            <div class="row">
                            	
                            	<div class="col-sm-10">
                            		Es el horario correcto?
                            	</div>
                            	
                            	<div class="col-sm-2">
                            		<div class="switch">
                                		<div class="onoffswitch">
                                			<input type="checkbox" class="onoffswitch-checkbox"
                                				id="chkHorarioCorrecto" v-model="chkHorarioCorrecto"> <label class="onoffswitch-label" for="chkHorarioCorrecto"> <span
                                				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                			</label>
                                		</div>
                                	</div>
                            	</div>
                            	
                            </div>
                            <hr>
                            
                            <div class="row">
                            	
                            	<div class="col-sm-10">
                            		Esta listo el equipo adecuado para la descarga?
                            	</div>
                            	
                            	<div class="col-sm-2">
                            		<div class="switch">
                                		<div class="onoffswitch">
                                			<input type="checkbox" class="onoffswitch-checkbox"
                                				id="chkEquipoListo" v-model="chkEquipoListo"> <label class="onoffswitch-label" for="chkEquipoListo"> <span
                                				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                			</label>
                                		</div>
                                	</div>
                            	</div>
                            	
                            </div>
                            <hr>
                            
                            <div class="row">
                            	
                            	<div class="col-sm-10">
                            		Estan correctos los datos de la persona que recibe?
                            	</div>
                            	
                            	<div class="col-sm-2">
                            		<div class="switch">
                                		<div class="onoffswitch">
                                			<input type="checkbox" class="onoffswitch-checkbox"
                                				id="chkPersonaCorrecta" v-model="chkPersonaCorrecta"> <label class="onoffswitch-label" for="chkPersonaCorrecta"> <span
                                				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                			</label>
                                		</div>
                                	</div>
                            	</div>
                            	
                            </div>
                            <hr>
                            
                            
                            <div class="row">
                            	
                            	<div class="col-sm-10">
                            		Hay el espacio para descargar?
                            	</div>
                            	
                            	<div class="col-sm-2">
                            		<div class="switch">
                                		<div class="onoffswitch">
                                			<input type="checkbox" class="onoffswitch-checkbox"
                                				id="chkHayEspacio" v-model="chkHayEspacio"> <label class="onoffswitch-label" for="chkHayEspacio"> <span
                                				class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                                			</label>
                                		</div>
                                	</div>
                            	</div>
                            	
                            </div>
                            <br>
                        
                        <?php endif;?>
                        
                        
                        
                        
                        
                        
                        
					</div>
				</div>
				
<!--                 <br>                 -->
<!--                 <div class="row"> -->
<!--                 	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> -->
						
<!-- 					</div> -->
<!--                 </div> -->
				
			</div>

			<div class="modal-footer">
				<button @click.prevent="pedidoSiValeSalida" class="btn btn-success"> Permitir Impresi&oacute;n</button>
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>				
			</div>
		</div>
	</div>
</div>
<!-- fin checklist permitir vale -->

<!-- Capturar Motivo Autorización -->
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
								v-model="observacionAunNo"								
								maxlength="250" class="form-control">
							<label v-if="!observacionAunNo" class="text-danger">Ingrese Observaci&oacute;n</label>
						
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
			<div class="col-lg-8	 col-md-8 col-sm-12 col-xs-12"> 
 				<div class="form-group">
									
 					<label class="control-label" for="filIdCliente">Cliente</label> 
				
 					<select id="filIdCliente" v-model="filtro.idCliente" class="form-control">
 						<option value='0'>-- Todos Mis Clientes --</option> 
						
						<?php 
 						echo $lstClientes; 
 						?>
						
					</select> 
 				</div> 
 			</div>

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
					<h5>En el listado, s&oacute;lo aparecen pedidos que ocupan permitir la impresi&oacute;n de Vales de Salida</h5>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<th>Pedido</th>
								<th>Vale Salida</th>
								<th>Cliente</th>
								<th class="text-right">Total</th>
								<th>Fecha</th>	
								<th>Permitir Imprimir Vale Salida</th>	
								<th>A&uacute;n NO?</th>						
								<th>Acci&oacute;n</th>
							</thead>
							<tbody>
							
								<tr v-for="(ped, index) in pedidos">
									<td class="text-navy">{{ ped.idPedido }}</td>
									<td class="text-success">{{ ped.idValeSalida }}</td>
									<td>{{ ped.nombreCliente }} </td>
									<td class="text-right">$ {{ ped.total }}</td>
									<td>{{ ped.fecha }}</td>
									<td>{{ ped.generarVale }}</td>
									<td>{{ ped.observacionaunno }}</td>
									<td>
<!-- 										<button @click.prevent="seleccionaPedido(ped.idPedido)" class="btn btn-primary btn-xs">Procesa Autorizaci&oacute;n</button> -->

										<span v-show="ped.saldarpedidoparavalesalida == 'SI' && ped.saldada == 'NO'"><span class="badge badge-danger">Los Vales de Salida de este Pedido se podr&aacute;n Imprimir cuando sea saldado</span></span>
										
										<div v-show="(ped.saldarpedidoparavalesalida == 'SI' && ped.saldada == 'SI') || ped.saldarpedidoparavalesalida == 'NO'">
											<button @click.prevent="pedidoAunNoValeSalida(ped.idValeSalida, index)" class="btn btn-warning btn-xs">A&Uacute;N NO</button>
											<button @click.prevent="setPedidoSiValeSalida(ped.idPedido, ped.idValeSalida, index)" class="btn btn-primary btn-xs">PERMITIR Generar Vale Salida</button>
										</div>
	
										
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
						
						<span v-show="pedidos.length == 0 && yaSeFiltro">No se encontr&oacute; informaci&oacute;n, es posible que no haya Vales de Salida por permitir su Impresi&oacute;n</span>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- <pre>{{ $data.pedidos }}</pre> -->

<!-- END FILTRO Y PEDIDOS -->




<!-- <pre> -->
<!-- {{ $data }} -->
<!-- </pre> -->