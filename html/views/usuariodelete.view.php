<?php
$titlePage = "Usuarios";
$breadCum = "Usuario/Eliminar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_ADMINISTRACION_USUARIO;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Usuarios <small>Eliminar</small></h5>				
			</div>
			<div class="ibox-content">
				
				<div class="alert alert-danger">
                     Se eliminar&aacute; la siguiente informaci&oacute;n
                </div>
														
				<?php
																
					Form::hidden("idUsuario");
					
					Form::label("username", "Usuario");
					Form::label("email", "EMail");
					Form::label("nombre", "Nombre");
					Form::label("apellidoPaterno", "A. Paterno");
					Form::label("apellidoMaterno", "A. Materno");
					
				
					Form::buttonDanger("Eliminar", "eliminarUsuario", "push-left");
								
				?>	
				
				<div class="clearfix"></div>				
			</div>
		</div>
	</div>
</div>

<!--  <pre>  -->
<!--  	{{ $data}}  -->
<!--  </pre> -->