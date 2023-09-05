<?php
$titlePage = "Mi Perfil";
$breadCum = "Mi Perfil";
$_lugar = LUGAR_PERFIL;	
$_addStyle = "<style>
		.btn-file {
	        position: relative;
	        overflow: hidden;
	    }
	    .btn-file input[type=file] {
	        position: absolute;
	        top: 0;
	        right: 0;
	        min-width: 100%;
	        min-height: 100%;
	        font-size: 100px;
	        text-align: right;
	        filter: alpha(opacity=0);
	        opacity: 0;
	        outline: none;
	        background: white;
	        cursor: inherit;
	        display: block;
	    }
	</style>	";

?>

<div class="row m-b-lg m-t-lg">
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

		<div class="tabs-container">

			<div class="tabs-left">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#tab-6"> Mis datos</a></li>
					<li class=""><a data-toggle="tab" href="#tab-7"> Contrase&ntilde;a</a></li>
				</ul>
				<div class="tab-content ">
					<div id="tab-6" class="tab-pane active">
						<div class="panel-body">
							<div class="profile-image">
								<img src="<?php
								if (file_exists ( "img/" . ModeloUsuario::getObjSession ()->getIdUsuario () . ".jpg" )) {
									echo "img/" . ModeloUsuario::getObjSession ()->getIdUsuario () . ".jpg";
								} else {
									echo 'img/noimage.png';
								}
								
								?>" class="img-circle circle-border m-b-md"
									alt="profile">
									
									<a id="btnCancelUpload" name="btnCancelUpload" @click.prevent="prepareSubir" v-if="cambiaFoto == false"
													class="btn btn-danger btn-sm">Cambiar Foto</a>
							</div>
							<div class="profile-info">
								<div v-if="cambiaFoto == false" class="">
									<div>
										<h2 class="no-margins"><?php echo $objSession->getFullName();?></h2>
										<h4><?php echo ModeloUsuario::getRol()->getNombre();?></h4>
										<h4><?php echo ModeloUsuario::getObjSession()->getEMail(); ?></h4>
										
									</div>
								</div>
					
								<div v-if="cambiaFoto == true" >
									<form id="frmBuscarFoto" class="form-horizontal" method="post"
										enctype="multipart/form-data">
										
										<input type="hidden" value="<?php echo ModeloUsuario::getObjSession()->getIdUsuario(); ?>" id="txtIdUsuario" name="txtIdUsuario">
										
										<div>
											<div class="row">
												<div class="col-md-9">
													<div class="input-group">
														<span class="input-group-btn"> <span
															class="btn btn-primary btn-file"> Buscar<input type="file"
																id="archivo" name="archivo" multiple="multiple">
														</span>
														</span> <input id="filename" name="filename" type="text"
															class="form-control" placeholder="Imagen ..." disabled>
													</div>
												</div>
					
												<div class="col-md-3">
													<br>
													<!-- <button id="btnUpload" name="btnUpload" class="btn btn-primary">Obtener Nombres de Columna</button> -->
													<button id="btnUpload" name="btnUpload" v-on:click.prevent="subirArchivo" class="btn btn-primary">Aceptar</button>
					
												</div>
											</div>
										</div>
					
										<div class="row">
											<div class="col-md-2 col-md-offset-9">
												<a id="btnCancelUpload" name="btnCancelUpload" @click.prevent="cancelSubir"
													class="btn btn-danger">Cancelar</a>
											</div>
										</div>
									</form>
								</div>
								
					
							</div>
						</div>
					</div>
					<div id="tab-7" class="tab-pane">
						<div class="panel-body">
							Para cambiar su contrase&ntilde;a, llene la siguiente informaci&oacute;n<br><br>
								
							<?php 
							
								Form::open("frmUsuario");
								
								Form::setCols("", "l4|m4|s12|x12", "l8|m8|s12|x12");
								Form::password("passActual", "Password Actual", "20", true);
								Form::password("passNuevo", "Password Nuevo", "20", true);
								Form::password("passConfirma", "Confirmar", "20", true);
								
								
							?>
							
							<div v-if="passActual && passConfirmed">
								<?php 
									Form::buttonPrimary("Cambiar", "cambiaPassword", "", "", "l12");
									
								?>
							</div>
							
							<?php 	
								
								Form::close();
							
							
							?>
							
						</div>
					</div>
				</div>

			</div>

		</div>

		
	</div>
	

</div>
