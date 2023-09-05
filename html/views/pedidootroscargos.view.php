<?php
$titlePage = "Pedidos Otros Cargos";
$breadCum = "produccion/Pedidos Otros Cargos";
$_lugar = "LUGAR_PRODUCCION_PEDIDOOTROSCARGOS";
?>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-content">
				<span>listados de Pedidos Otros Cargos</span>
				<div style="overflow-x:auto;">
					<div id="listadoPedidos">
					<table class='footable table table-stripped toggle-arrow-tiny' data-page-size='50'>
						<thead>
								<tr>		
									<th>Pedido</th>
									<th >Cliente</th>
									<th >Promotor</th>
									<th >Fecha Captura</th>
									<th >Fecha Compromiso</th>
									<th >Estado</th>
									<th class='text-left'>Acci&oacute;n</th>
								</tr>
						</thead>
						<tbody v-for="(lstPedidosOtrosCargos, index) in pedidosOtrosCargos">
							<tr>
								<td><b>{{lstPedidosOtrosCargos.idPedido}} </b></td>
								<td> {{lstPedidosOtrosCargos.cliente}} </td>
								<td> {{lstPedidosOtrosCargos.promotor}} </td>
								<td> {{ lstPedidosOtrosCargos.fecha_capturado}} </td>
								<td> {{lstPedidosOtrosCargos.fechaCompromiso}} </td>
								<td v-show="lstPedidosOtrosCargos.estado == 'AUTORIZADO'"> <p><span class='text-info'>{{lstPedidosOtrosCargos.estado}}</span></p></td>
								<td v-show="lstPedidosOtrosCargos.estado == 'CAPTURADO'"> <p><span class='text-succes'>{{lstPedidosOtrosCargos.estado}}</span></p></td>
								<td v-show="lstPedidosOtrosCargos.estado == 'PRODUCCION'"> <p><span class='text-warning'>{{lstPedidosOtrosCargos.estado}}</span></p></td>
								<td v-show="lstPedidosOtrosCargos.estado == 'TERMINADO'"> <p><span class='text-danger'>{{lstPedidosOtrosCargos.estado}}</span></p></td>
								<td class='text-left'>
									<a class='btn btn-info btn-xs' v-bind:href="'pedidodetalleview/' + lstPedidosOtrosCargos.idPedido" alt='Ver detalle' target='_blank'><span class='fa fa-eye'></span></a>
									<button class='btn btn-primary btn-xs' @click.prevent="cerrarPedidoOtrosCargos(lstPedidosOtrosCargos.idPedido)" >ENTREGADO</button>
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