<?php


$titlePage = "Reportes";
$breadCum = "Inventario Mendez";
$_lugar = LUGAR_REPORTES;
$_useDataTable = true;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

// $_addHead="
//  			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
//  		";

// $_addScript = "
    
// 		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
// 	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
	        
	        
// 		";

?>


<div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
<!--                                 <span class="label label-success pull-right">Monthly</span> -->
                                <h5>Total</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">$ <strong>{{ formatNumber(totalNeto) }}</strong></h1>
<!--                                 <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
<!--                                 <small>Total income</small> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
<!--                                 <span class="label label-info pull-right">Annual</span> -->
                                <h5>Inventario Inicial</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">$ {{ formatNumber(inventarioInicialMendez) }}</h1>
<!--                                 <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
<!--                                 <small>New orders</small> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
<!--                                 <span class="label label-primary pull-right">Today</span> -->
                                <h5>Compras</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">$ {{ formatNumber(inventarioRollos) }}</h1>
<!--                                 <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> -->
<!--                                 <small>New visits</small> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
<!--                                 <span class="label label-danger pull-right">Low value</span> -->
                                <h5>Pedidos</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">$ {{ formatNumber(pedidos) }}</h1>
<!--                                 <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div> -->
<!--                                 <small>In first month</small> -->
                            </div>
                        </div>
            		</div>
        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Listado</h5>				
			</div>
			<div class="ibox-content">
			
				<div style="overflow-x:auto;">
				
						
					<?php			
					
					echo $strTablaListado2;?>
				</div>
			</div>
		</div>
	</div>