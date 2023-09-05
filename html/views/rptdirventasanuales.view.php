<?php


$titlePage = "Reportes";
$breadCum = "Ventas Anuales Galvamex";
$_lugar = LUGAR_REPORTES;

$buttonAction = "Regresar a Reportes/fnRegresarAReportes";

// $_addHead="
//  			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'>
//  		";

$_addScript = "

		<script src=\"".URL_BASE."assets/highcharts/highcharts.js\"></script>
	    <script src=\"".URL_BASE."assets/highcharts/exporting.js\"></script>
		

		";

?>

<div class="modal" tabindex="-1" role="dialog" id="modalWait">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cargando informaci&oacuten</h4>
      </div>
      <div class="modal-body">
        <p>Por favor espere</p>
        <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    <span class="sr-only">100% Complete (danger)</span>
  </div>
</div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php 
$anioActual = date("Y");
?>
<form method="get" class="form-horizontal">
    <div class="form-group">
    	<label class="col-sm-2 control-label">Seleccione A&ntilde;o</label>
    
    	<div class="col-sm-2">
    		<select v-model="year" class="form-control m-b" name="account">
    			<option value="<?php echo $anioActual; ?>" select><?php echo $anioActual?></option>
    			<?php 
    			 
    			for($anio = $anioActual - 1 ; $anio >=2018 ; $anio --)
    			{
    			    echo "<option value=\"". $anio."\" >".$anio."</option>";
    			}
    			 
    			
    			?>
    		</select>
    		
    	</div>
    	<div class="col-sm-2"> <button @click.prevent="cargarVentasAnuales" class="btn btn-primary" >Obtener informaci&oacute;n</button> </div>
    </div>
</form>	


<div class="ibox-content m-b-sm border-bottom">
	<div v-show="showAnio" id="chartAnio" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
</div>
					

<div class="ibox-content">
		
		<h4  v-show="movimientos.length == 0">No se han encontrado Movimientos.</h4>
		<div class="row">
		<div class="col-lg-12">
		<h3>Detalle de costo de materia prima consumida</h3><br>							
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center" style="width:50px">N°</th>					
					<th class="text-center" style="width:100px">Mes</th>
					<th class="text-center">De Rollos</th>
					<th class="text-center" style="width:50px" >%</th>
					<th class="text-center"> Stock</th>
					<th class="text-center" style="width:50px">%</th>
					<th class="text-center">Molduras</th>
					<th class="text-center" style="width:50px">%</th>
					<th class="text-center">Total</th>
				</tr>
			</thead>
				<tbody>
					<tr v-for="(mov, index) in movimientos">
						<td class="text-center " style="width:50px">{{ mov.mes }}</td>
						<td class="text-center " style="width:90px">{{ mov.mesDes}}</td>
						<td class="text-center " >${{ formatNumber(mov.costoDerivados) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.costoDerivados)/(parseFloat(mov.costoDerivados)+parseFloat(mov.costoStock)+parseFloat(mov.costoMolduras))* 100) }}%</td>
						<td class="text-center " >${{ formatNumber(mov.costoStock) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.costoStock)/(parseFloat(mov.costoDerivados)+parseFloat(mov.costoStock)+parseFloat(mov.costoMolduras))* 100) }}%</td>
						<td class="text-center ">${{ formatNumber(mov.costoMolduras) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.costoMolduras)/(parseFloat(mov.costoDerivados)+parseFloat(mov.costoStock)+parseFloat(mov.costoMolduras))* 100) }}%</td>
						<td class="text-center "><strong>${{ formatNumber(mov.costoTotal) }}</td>				
					</tr>
				</tbody>

		</table>
		</div>
		<div class="col-lg-12">
		<h3>Detalle de venta por departamento</h3><br>						
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center"style="width:50px">N°</th>	
					<th class="text-center" style="width:90px" >Mes</th>				
					<th class="text-center" >De Rollos</th>
					<th class="text-center" style="width:50px" >%</th>
					<th class="text-center">Stock</th>
					<th class="text-center" style="width:50px" >%</th>
					<th class="text-center">Molduras</th>
					<th class="text-center" style="width:50px" >%</th>
					<th class="text-center">Maquilas</th>
					<th class="text-center" style="width:50px" >%</th>
					<th class="text-center">Otros Cargos</th>
					<th class="text-center" style="width:50px" >%</th>
					<th class="text-center">Descuentos</th>
					<th class="text-center">Total</th>
				</tr>
			</thead>
				<tbody>
					<tr v-for="(mov, index) in movimientos1">
						<td class="text-center " style="width:50px">{{ mov.mes }}</td>
						<td class="text-center " style="width:90px">{{ mov.mesDes }}</td>
						<td class="text-center " >${{ formatNumber(mov.ventaDeRollo) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.ventaDeRollo)/(parseFloat(mov.ventaDeRollo)+parseFloat(mov.ventaStock)+parseFloat(mov.ventaMoldura)+parseFloat(mov.ventaMaquila)+parseFloat(mov.ventaOtrosCargos))* 100) }}%</td>
						<td class="text-center " >${{ formatNumber(mov.ventaStock) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.ventaStock)/(parseFloat(mov.ventaDeRollo)+parseFloat(mov.ventaStock)+parseFloat(mov.ventaMoldura)+parseFloat(mov.ventaMaquila)+parseFloat(mov.ventaOtrosCargos))* 100) }}%</td>
						<td class="text-center " >${{ formatNumber(mov.ventaMoldura) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.ventaMoldura)/(parseFloat(mov.ventaDeRollo)+parseFloat(mov.ventaStock)+parseFloat(mov.ventaMoldura)+parseFloat(mov.ventaMaquila)+parseFloat(mov.ventaOtrosCargos))* 100) }}%</td>
						<td class="text-center ">${{ formatNumber(mov.ventaMaquila) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.ventaMaquila)/(parseFloat(mov.ventaDeRollo)+parseFloat(mov.ventaStock)+parseFloat(mov.ventaMoldura)+parseFloat(mov.ventaMaquila)+parseFloat(mov.ventaOtrosCargos))* 100) }}%</td>
						<td class="text-center ">${{ formatNumber(mov.ventaOtrosCargos) }}</td>
						<td class="text-center " style="width:50px"><strong>{{ formatNumber(parseFloat(mov.ventaOtrosCargos)/(parseFloat(mov.ventaDeRollo)+parseFloat(mov.ventaStock)+parseFloat(mov.ventaMoldura)+parseFloat(mov.ventaMaquila)+parseFloat(mov.ventaOtrosCargos))* 100) }}%</td>
						<td class="text-center ">${{ formatNumber(mov.descuento) }}</td>
						<td class="text-center "><strong>${{ formatNumber(mov.ventaTotal) }}</td>				
					</tr>
				</tbody>

		</table>
		</div>



		</div>
	</div>	
<!-- <button v-show="!showAnio" @click.prevent="mostrarAnio" class="btn btn-primary" > Regresar</button> 
<div v-show="!showAnio" id="chartMes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->

