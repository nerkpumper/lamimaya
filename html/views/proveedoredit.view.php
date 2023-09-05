<?php
$titlePage = "Proveedores";
$breadCum = "Cat&aacute;logos/Proveedor/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_PROVEEDOR;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Proveedor <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
														
				<?php
					
					Form::open("frmProveedor");
							
					Form::hidden("idProveedor");
					
					Form::text("nombre", "Nombre", "68", true);
					
					Form::setColsInput("l2|m2|s6|x6");
					Form::text("clave", "Clave", "5", true);
															 					
					Form::buttonPrimary("Guardar", "guardarProveedor");
								
							
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

