<?php
$titlePage = "Aplicaci&oacute;n";
$breadCum = "Cat&aacute;logos/Aplicaci&oacute;n/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_APLICACION;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Aplicaci&oacute;n <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
														
				<?php
					
					Form::open("frmModeloLamina");
							
					Form::hidden("idAplicacion");
					
					Form::text("nombreAplicacion", "Nombre Aplicaci&oacute;n", "68", true);				 
					
					Form::buttonPrimary("Guardar", "guardarAplicacion");
								
							
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

