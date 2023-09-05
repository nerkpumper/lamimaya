<?php


$titlePage = "Reportes";
$breadCum = "Cobranza Anual Galvamex";
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
    	<div class="col-sm-2"> <button @click.prevent="cargarCobranzaAnual" class="btn btn-primary" >Obtener informaci&oacute;n</button> </div>
    </div>
</form>	


<div class="ibox-content m-b-sm border-bottom">
	<div v-show="showAnio" id="chartAnio" style="min-width: 310px; height: 600px; margin: 0 auto"></div>
</div>



<!-- <button v-show="!showAnio" @click.prevent="mostrarAnio" class="btn btn-primary" > Regresar</button> 
<div v-show="!showAnio" id="chartMes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->

