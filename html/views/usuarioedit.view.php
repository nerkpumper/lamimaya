<?php
$titlePage = "Usuarios";
$breadCum = "Usuario/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_ADMINISTRACION_USUARIO;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Usuarios <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
							
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
														
				<?php
					
					Form::open("frmUsuario");
							
					Form::hidden("idUsuario");
					
					Form::text("username", "Usuario", "30", true);
					Form::email("email", "EMail","48", true);
					Form::text("nombre", "Nombre", "98", true);
					Form::text("apellidoPaterno", "A. Paterno","98", true);
					Form::text("apellidoMaterno", "A. Materno","98", true);
					
					Form::select("estatus", "Estatus", $lstEstatus);
					Form::select("idRol", "Rol", $lstRol);
					
					Form::select("tipoComision", "Tipo Comisi&oacute;n", $lstComisiones);
					Form::select("cobraComision", "Cobra Comision", $lstCobraComision);
								

					
				?>
				
				<div v-if="idUsuario == 0">
					<?php 
					
						Form::password("password", "Password", "30", true);
						Form::password("confirmar", "Confirmar", "30", true);
					
					?>					
				</div>
				<div v-else>
					<?php 
					
						if (ModeloUsuario::amIRoot())
						{
							Form::password("password", "Password", "30", true);
							Form::password("confirmar", "Confirmar", "30", true);
						}
						
					?>
				</div>
				
				
				
				
				<?php 
					
					Form::buttonPrimary("Guardar", "guardarUsuario");
								
							
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

