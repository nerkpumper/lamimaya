<?php
$titlePage = "Cliente";
$breadCum = "Cat&aacute;logos/Cliente/Eliminar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_CLIENTE;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Cliente <small>Eliminar</small></h5>				
			</div>
			<div class="ibox-content">
				
				<div class="alert alert-danger">
                     Se eliminar&aacute; la siguiente informaci&oacute;n
                </div>
					
														
				<?php
				// 	`idCliente` INT NOT NULL AUTO_INCREMENT,
				// 	`nombre` VARCHAR(70) NULL DEFAULT '',
				// 	`apellidos` VARCHAR(70) NULL DEFAULT '',
				// 	`empresa` VARCHAR(70) NULL DEFAULT '',
				// 	`domicilio1` VARCHAR(70) NULL DEFAULT '',
				// 	`domicilio2` VARCHAR(70) NULL DEFAULT '',
				// 	`telefonos` VARCHAR(70) NULL DEFAULT '',
				// 	`email` VARCHAR(70) NULL DEFAULT '',
				// 	`rfc` VARCHAR(20) NULL DEFAULT '',
																
					Form::hidden("idCliente");
					
					Form::label("nombre", "Nombre");
					Form::label("apellidos", "Apellidos");
					Form::label("empresa", "Empresa");
					Form::label("domicilio1", "Domicilio1");
					Form::label("domicilio2", "Domicilio2");
					Form::label("telefonos", "Telefonos");
					Form::label("email", "EMail");
					Form::label("rfc", "R.F.C.");
					Form::label("estado", "Estatus");
					
				
					Form::buttonDanger("Eliminar", "eliminarCliente", "", "push-left");
								
				?>	
				
				<div class="clearfix"></div>				
			</div>
		</div>
	</div>
</div>

<!--  <pre>  -->
<!--  	{{ $data}}  -->
<!--  </pre> -->