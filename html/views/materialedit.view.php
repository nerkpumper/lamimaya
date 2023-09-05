<?php
$titlePage = "Material";
$breadCum = "Cat&aacute;logos/Material/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_MATERIAL;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Material <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
														
				<?php
					
					Form::open("frmMaterial");
							
					Form::hidden("idMaterial");
					
					Form::text("nombre", "Nombre", "68", true);
					
					Form::setColsInput("l2|m2|s6|x6");
					Form::text("clave", "Clave", "3", true);
					 
					
					Form::buttonPrimary("Guardar", "guardarMaterial");
								
							
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

