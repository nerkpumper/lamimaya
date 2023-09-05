<?php
$titlePage = "Material";
$breadCum = "Cat&aacute;logos/Material/Eliminar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_MATERIAL;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Material <small>Eliminar</small></h5>				
			</div>
			<div class="ibox-content">
				
				<div class="alert alert-danger">
                     Se eliminar&aacute; la siguiente informaci&oacute;n
                </div>
														
				<?php
																
					Form::hidden("idMaterial");
					
					Form::label("nombre", "Nombre");
					Form::label("clave", "Clave");
				
					Form::buttonDanger("Eliminar", "eliminarMaterial", "", "push-left");
								
				?>	
				
				<div class="clearfix"></div>				
			</div>
		</div>
	</div>
</div>

<!--  <pre>  -->
<!--  	{{ $data}}  -->
<!--  </pre> -->