<?php
$titlePage = "Cotizaciones";
$breadCum = "Ventas/Cotizaciones";
$_lugar = LUGAR_VENTAS_LISTADOCOTIZACION;
//$_useDataTable = true;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'> 		
 		";

$_addScript=" 		
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		";
?>

<?php  
//echo obtenerTabla(1); ?>

<!-- <p><span class='label label-warning'>CAPTURADO</span></p> -->
<!-- <p><span class='label'>AUTORIZA CxC</span></p> -->
<!-- <p><span class='label label-info'>PRODUCCI&Oacute;N</span></p> -->
<!-- <p><span class='label label-primary'>TERMINADO</span></p> -->
<!-- <p><span class='label label-success'>ENTREGADO</span></p> -->
<!-- <p><span class='label label-danger'>CANCELADO</span></p> -->

<!-- <pre>{{ $data }}</pre> -->

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
<div class="modal inmodal fade" id="modalCambiarRangoCliente" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique El nuevo Rango de Cliente</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							<select v-model="rangoClienteEdit" class="form-control">
								<option value="REGULAR">REGULAR</option>
								<option value="DISTINGUIDO">DISTINGUIDO</option>
								<option value="SELECT">SELECT</option>
								<option value="PLATINO">PLATINO</option>
							</select>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="editarRangoCliente" class="btn btn-success"> Cambiar Rango de Cliente en esta Cotizaci&oacute;n</button>
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
				<label class="control-label" for="order_id">No Cotizaci&oacute;n</label> 
				<input v-model="noPedido"
					type="text" id="order_id" name="order_id" value=""
					placeholder="-- TODOS --" class="form-control">
			</div>
		</div>
		<!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				
				
			
				<label class="control-label" for="status">Estatus</label> 
				
				<select v-model="estatus" class="form-control">
					<option value='0'>-- Todos --</option>
					
					<?php //echo $listaEstatus; ?>
					
					
					
										
					
					
				</select>
			</div>
		</div> -->
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


</div>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<div style="overflow-x:auto;">
					<div class="col-sm-2">
						<div class="input-group m-b">
							<span class="input-group-btn">
								<button @click.prevent="previousPage" type="button" class="btn btn-white" :disabled="page == 0"><i class="fa fa-chevron-left"></i></button> 
							</span> 
							<input type="text" :value="'(' + pageTotalRegs + ' Regs.)  Pag. ' + (page + 1) + ' / ' + (pages + 1)" class="form-control text-center" style="width: 300px" disabled>
							<span class="input-group-btn">
								<button @click.prevent="nextPage" type="button" class="btn btn-white" :disabled="page == (pages-1)"><i class="fa fa-chevron-right"></i></button> 
							</span>     
						</div>                                                            
					</div>
					<div id="listadoPedidos">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

