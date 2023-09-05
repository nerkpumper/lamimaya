<?php
$titlePage = "Autorización de Pedidos";
$breadCum = "CXC/Dashboard de Tracking Pedidos";
$_lugar = LUGAR_CXC_DASHTRACKING;

$_addHead=" 		
 		<link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'>
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/toastr/toastr.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script>
 		
		<script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>
        <script src=\"".URL_BASE."assets/inspinia/js/plugins/clockpicker/clockpicker.js\"></script>


        <script src=\"".URL_BASE."js/components/pedido-tracking-estatus-vale.vue.js\"></script>
 		";


?>


<h2>En esta pantalla puede visualizar el tracking del Pedido, referente a su Autorizaci&oacute;n autom&aacute;tica y Liberaci&oacute;n de Vales de Salida</h2>
<br>

<div v-show="seleccionarPedido">
	<h2 class="m-l">No. Pedido:</h2>
	<div class="col-sm-3 m-b-xs">
		<div class="input-group">
			<input type="text" class="form-control input-lg" v-model="idPedido"
				v-on:keypress.enter="cargarDatosPedido"
				oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
				maxlength='8'> <span class="input-group-btn">
				<button @click.prevent="cargarDatosPedido"
					class="btn btn-primary btn-lg " type="button">
					<i class="fa fa-check"></i><span class="bold"></span>
				</button>
			</span>
		</div>
	</div>
	
	<div class="clearfix"></div>
</div>

<div v-show="!seleccionarPedido">
	<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning">Seleccionar otro Pedido</button>
	<pedido-tracking-estatus-vale ref="trackingPedido">
	</pedido-tracking-estatus-vale>
</div>


