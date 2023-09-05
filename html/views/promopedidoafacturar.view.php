<?php
$titlePage = "Solicitar Facturas";
$breadCum = "Pedidos/Solicitar Factura de Pedido";
$_lugar = LUGAR_PROMOTOR_PEDIDOSAFACTURAR;
//$_useDataTable = true;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'> 		
 		";

$_addScript=" 		
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		";
?>

<!-- <p><span class='label label-warning'>CAPTURADO</span></p> -->
<!-- <p><span class='label'>AUTORIZA CxC</span></p> -->
<!-- <p><span class='label label-info'>PRODUCCI&Oacute;N</span></p> -->
<!-- <p><span class='label label-primary'>TERMINADO</span></p> -->
<!-- <p><span class='label label-success'>ENTREGADO</span></p> -->
<!-- <p><span class='label label-danger'>CANCELADO</span></p> -->

<!-- <pre>{{ $data }}</pre> -->


<!-- Capturar Motivo Autorización -->
<div class="modal inmodal fade" id="modalIndicaMotivoAutorizacion" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique Observaci&oacute;n de Autorizaci&oacute;n</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
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

<!-- Actualizar Motivo Autorización -->
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