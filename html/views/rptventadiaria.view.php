
<?php
$titlePage = "Venta del dia";
$breadCum = "rpt/Venta del dia";
$_lugar = LUGAR_REPORTES;
//$_useDataTable = true;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-9">
			<div class="col-lg-3" v-for="(mov, index) in movimientos">
				<div class="ibox ">
					<div class="ibox-title">
						<span class="label label-success float-right">{{ mov.usuarioCaptura }}</span>		
					</div>
					<div class="ibox-content">
						<h3 class="no-margins">${{ formatNumber(mov.pedidoTotal) }}</h3>
						<div class="stat-percent font-bold text-success">{{ formatNumber(mov.porcentaje*100) }}%</div>
						<small>Total</small>
					</div>
				</div>
			</div>
		</div>
        	
           
        <div class="col-lg-3">
			<div class="ibox ">
                <div class="ibox-title">
                        <h3 class="no-margins label label-success float-right">Total Dia</h3>
                </div>
                <div class="ibox-content" >
                    <div class="row">

							<h1 class="no-margins">$ {{ movimientos[0].totalDia }}</h1>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
           

			



                          
                       

<div  class="ibox-content">
		<h3>Venta diaria por promotor</h3><br>
		<h4 v-show="movimientos.length == 0" >No existen pedidos capturados hoy.</h4>
		<div class="row">
		<div v-show="movimientos.length > 0" class="col-lg-12">							
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center">ID</th>					
					<th class="text-center">Promotor</th>
                    <th class="text-center">Venta por Promotor</th>
					
					<th class="text-center">%</th>
					<th class="text-center">Num. Pedidos</th>
					<th class="text-center">Num. Clientes</th>
					<th class="text-center">Promedio por Pedido</th>
					
					
				</tr>
			</thead>
				<tbody>
					<tr v-for="(mov, index) in movimientos">
						<td class="text-center ">{{ mov.idUsuarioCaptura }}</td>
						<td class="text-center ">{{ mov.usuarioCaptura }}</td>
						<td class="text-center ">${{ formatNumber(mov.pedidoTotal) }}</td>
						
						<td class="text-center ">{{ formatNumber(mov.porcentaje*100) }}%</td>
						<td class="text-center ">{{ (mov.numPedidos) }}</td>
						<td class="text-center ">{{ (mov.numClientes) }}</td>
						<td class="text-center ">${{ formatNumber(mov.pedidoTotal/mov.numPedidos) }}</td>
						
							
								
					</tr>
				</tbody>

		</table>
		</div>
		</div>
		
	</div>	
									 