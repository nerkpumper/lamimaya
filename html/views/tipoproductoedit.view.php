<?php
$titlePage = "Tipo Producto";
$breadCum = "Cat&aacute;logos/Tipo Producto/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_TIPOPRODUCTO;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Tipo Producto <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
														
				<?php
					
					Form::open("frmTipoProducto");
							
					Form::hidden("idTipoProducto");
					
					Form::text("nombre", "Nombre", "68", true);
					
					Form::setColsInput("l2|m2|s6|x6");
					Form::text("clave", "Clave", "3", true);
					 
					
					Form::buttonPrimary("Guardar", "guardarTipoProducto");
								
							
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

