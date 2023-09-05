<?php
$titlePage = "Fecha Entrega Pedidos";
$breadCum = "Pedidos/Pedidos Próximos a entrega";
$_lugar = LUGAR_VENTAS_FECHACOMPROMISO;
//$_useDataTable = true;

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
        <link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
 		<link href='".URL_BASE."assets/inspinia/css/plugins/clockpicker/clockpicker.css' rel='stylesheet'> 		
 		";

$_addScript=" 		
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
        <script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>

		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>
 		";
?>
<div class="ibox-content m-b-sm border-bottom">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<div class="form-group">
				<label class="control-label" for="order_id">Promotor</label> 
				<select  class="form-control m-b" v-model="idPromotorSeleccionado">
                                    <option value="0">Seleccione Promotor</option>                             
                                    <option v-for="des in lstUsuario"
            									:value="des.idUsuario">{{ des.nombre }}                               
                                </select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<button @click.prevent="cargarPedidosFechaCompromisoPorVencer" class="btn btn-primary">Filtrar</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<span>listados de Pedidos Próximos a entregar</span>
				<div style="overflow-x:auto;">
					<div id="listadoPedidos">
					<table class='footable table table-stripped toggle-arrow-tiny' data-page-size='50'>
						<thead>
								<tr>		
									<th>Pedido</th>
									<th >Cliente</th>
									<th >Total</th>
									<th >Fecha Captura</th>
									<th >Estatus</th>
									<th >Fecha Entrega</th>
									<th class='text-left'>Acci&oacute;n</th>
								</tr>
						</thead>
						<tbody v-for="(lstPedidosPorVencer, index) in pedidosPorVencer">
							<tr>
								<td> <b>{{lstPedidosPorVencer.idPedido}}</b></td>
								<td>{{lstPedidosPorVencer.cliente}}</td>
								<td>${{lstPedidosPorVencer.total}}</td>
								<td>{{lstPedidosPorVencer.fecha_capturado}}</td>
								<td v-show="lstPedidosPorVencer.estado == 'AUTORIZADO'"> <p><span class='text-info'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td v-show="lstPedidosPorVencer.estado == 'CAPTURADO'"> <p><span class='text-succes'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td v-show="lstPedidosPorVencer.estado == 'PRODUCCION'"> <p><span class='text-warning'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td v-show="lstPedidosPorVencer.estado == 'TERMINADO'"> <p><span class='text-danger'>{{lstPedidosPorVencer.estado}}</span></p></td>
								<td><b>{{lstPedidosPorVencer.fechaCompromiso}}</b></td>
								<td class='text-left'>
									<a class='btn btn-info btn-xs' v-bind:href="'pedidodetalleview/' + lstPedidosPorVencer.idPedido" alt='Ver detalle' target='_blank'><span class='fa fa-eye'></span></a>
									<button class='btn btn-primary btn-xs' @click.prevent="modalUpdateFechaCompromiso(lstPedidosPorVencer.idPedido)" ><i class='fa fa-calendar'></i> Fecha de Entrega</button>
								</td>
								
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<td colspan='7'>
								<ul class='pagination pull-right'></ul>
								</td>
							</tr>
						</tfoot>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
    <!-- Actualizar fecha compromiso -->
<div class="modal inmodal fade" id="modalUpdateFechaCompromiso" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Indique Fecha de Entrega</h4>
<!-- 				<small class="font-bold"></small> -->
<!-- 				<br> -->
<!-- 				<small class="font-bold"></small> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							<label class="control-label">Fecha Entrega</label>
				                                <div class="input-group date">
				                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                    <input v-modal="fechaEntrega" id="dtFechaEntrega" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>
				                                    ">
				                                    
				                                </div>
							<label v-show="errFechaEntrega" class="text-danger">{{ errFechaEntrega }}</label>
						
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						&nbsp;
					</div>				
										
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<button @click.prevent="updateFechaCompromiso" class="btn btn-success"> Asignar Fecha de Entrega</button>
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


