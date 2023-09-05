<?php
$titlePage = "Pedidos";
$breadCum = "Ventas/Pedidos";
$_lugar = LUGAR_VENTAS_LISTADOPEDIDOS;
//$_useDataTable = true;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'> 		
 		";

$_addScript=" 		
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>

		 <script src=\"".URL_BASE."js/components/pedido-tracking-estatus-vale.vue.js\"></script>
 		";
?>

<!-- <p><span class='label label-warning'>CAPTURADO</span></p> -->
<!-- <p><span class='label'>AUTORIZA CxC</span></p> -->
<!-- <p><span class='label label-info'>PRODUCCI&Oacute;N</span></p> -->
<!-- <p><span class='label label-primary'>TERMINADO</span></p> -->
<!-- <p><span class='label label-success'>ENTREGADO</span></p> -->
<!-- <p><span class='label label-danger'>CANCELADO</span></p> -->

<!-- <pre>{{ $data }}</pre> -->



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

<!-- Impresion de pedido -->
<div class="modal inmodal fade" id="modalImprimir" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Imprimir Pedido {{ noPedidoImprimir }}</h4>
				<i class="fa fa-print modal-icon"></i>
				
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div id="divImpresiones" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
								
						
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


<!-- Capturar Motivo Autorizaci�n -->
<div class="modal inmodal fade" id="modalIndicaMotivoAutorizacion" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Autorizaci&oacute;n de Pedido</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="col-lg-12">

			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<div class="file-manager">
						
                	                    
    					<h3>Pedido<strong class="pull-right">{{ pedidoAAutorizar }}</strong></h3>
    					
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
						<h3><small>Saldo del Cr&eacute;dito: </small> <strong class="pull-right " :class="saldoCredito >= 0 ? 'text-navy' : 'text-danger'" >$ {{ formatNumber(saldoCredito) }}</strong></h3>
						<h3><small>Saldo Capacidad Pago: </small> <strong class="pull-right " :class="saldoCapacidadPago >= 0 ? 'text-navy' : 'text-danger'" >$ {{ formatNumber(saldoCapacidadPago) }}</strong></h3>
						
						<div v-if="!pedidoSurtiraCompleto">
							<br>
							<div  class="alert alert-danger">Para completar este pedido se debe realizar compra de material/producto, por lo que <strong>deber&aacute; solicitar el 50% de abono/anticipo.</strong></div>
						</div>
						
						<div class="hr-line-dashed"></div>
<!-- 						<button v-show="pedidoDespieceTerminado == 'NO'" @click.prevent="terminarDespiece" class="btn btn-success btn-block"><i class="fa fa-check"></i>  Terminar Despiece de Pedido</button> -->
						
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			
	    </div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							<input type="text"
								v-model="observacionAutorizar"								
								maxlength="250" class="form-control">
							<label v-if="!observacionAutorizar" class="text-danger">Ingrese Observaci&oacute;n</label>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="autorizarPedido" class="btn btn-success"> Autorizar Pedido</button>
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

<!-- Actualizar Motivo Autorizaci�n -->
<div class="modal inmodal fade" id="modalActualizaMotivoAutorizacion" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Actualizar Observaci&oacute;n de Autorizaci&oacute;n</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							<input type="text"
								v-model="observacionAutorizarActualizar"								
								maxlength="250" class="form-control">
							<label v-if="observacionAutorizarActualizar" class="text-danger">Ingrese Observaci&oacute;n</label>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="actualizarAutorizacionPedido" class="btn btn-success"> Cambiar</button>
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


<div class="ibox-content m-b-sm border-bottom">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="order_id">No Pedido</label> 
				<input v-model="noPedido"
					type="text" id="order_id" name="order_id" value=""
					placeholder="-- TODOS --" class="form-control">
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				
				
			
				<label class="control-label" for="status">Estatus</label> 
				
				<select v-model="estatus" class="form-control">
					<option value='0'>-- Todos --</option>
					
					<?php echo $listaEstatus; ?>
					
					
					
										
					
					
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				<label  class="control-label" for="customer">Cliente</label> 
				<input v-model="cliente"
					type="text" id="customer" name="customer" value=""
					placeholder="-- Todos --" class="form-control">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<button @click.prevent="filtrar" class="btn btn-primary">Filtrar</button>
		</div>
	</div>
<!-- 	<div class="row"> -->
<!-- 		<div class="col-sm-4"> -->
<!-- 			<div class="form-group"> -->
<!-- 				<label class="control-label" for="date_added">Date added</label> -->
<!-- 				<div class="input-group date"> -->
<!-- 					<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input -->
<!-- 						id="date_added" type="text" class="form-control" -->
<!-- 						value="03/04/2014"> -->
<!-- 				</div> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="col-sm-4"> -->
<!-- 			<div class="form-group"> -->
<!-- 				<label class="control-label" for="date_modified">Date modified</label> -->
<!-- 				<div class="input-group date"> -->
<!-- 					<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input -->
<!-- 						id="date_modified" type="text" class="form-control" -->
<!-- 						value="03/06/2014"> -->
<!-- 				</div> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 		<div class="col-sm-4"> -->
<!-- 			<div class="form-group"> -->
<!-- 				<label class="control-label" for="amount">Amount</label> <input -->
<!-- 					type="text" id="amount" name="amount" value="" placeholder="Amount" -->
<!-- 					class="form-control"> -->
<!-- 			</div> -->
<!-- 		</div> -->
<!-- 	</div> -->

</div>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<div style="overflow-x:auto;">
					<div id="listadoPedidos">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>