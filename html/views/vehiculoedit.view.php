<?php
$titlePage = "Vehiculos";
$breadCum = "Cat&aacute;logos/Vehiculos/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_RUTAS_VEHICULOS;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Vehiculo <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
														
				<?php
					
					Form::open("frmVehiculo");
							
					Form::hidden("idVehiculo");
					
					Form::text("placa", "Placas", "45", true);
					
					// Form::setColsInput("l2|m2|s6|x6");
					Form::text("descripcion", "Descripcion", "150", true);
					 
					
					Form::buttonPrimary("Guardar", "guardarVehiculo");
								
							
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

