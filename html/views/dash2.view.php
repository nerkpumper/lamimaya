<?php
// $_showPageHeading = false;

$titlePage = "Monitor Estatus Pedidos";
$breadCum = "Administraci&oacute;n/Monitor/Estatus Pedidos";
$_lugar = LUGAR_ADMINISTRACION_DASHBOARDS_MONITORESTATUS;

$_addScript="
 		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
 		<script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
 		";
?>


<div class="row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
		<div id="grPedidos" ></div>		
	</div>
	
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
		<div id="grPedidosPie" ></div>		
	</div>
</div>

<br>

<div class="row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
		<div id="grPedidosExplotados" ></div>		
	</div>
	
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
		<div id="grPedidosExplotadosPie" ></div>		
	</div>
</div>




<!-- <div id="grProductos" ></div> -->