<?php
$titlePage = "Clientes";
$breadCum = "Cat&aacute;logos/Cliente/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_CATALOGOS_CLIENTE;

$_addHead = "
    
            <link href=\"".URL_BASE."assets/inspinia/css/plugins/iCheck/custom.css\" rel=\"stylesheet\">
            <link href=\"".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css\" rel=\"stylesheet\">
                
            ";

$_addScript ="
    
            <script src=\"".URL_BASE."assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js\"></script>
            <script src=\"".URL_BASE."assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js\"></script>
            <script src=\"".URL_BASE."assets/inspinia/js/plugins/iCheck/icheck.min.js\"></script>
			<script src=\"".URL_BASE."js/components/cliente-dirfiscales-new-edit.vue.js\"></script>
			<script src=\"".URL_BASE."js/components/cliente-dirfiscales-listado.vue.js\"></script>
			<script src=\"".URL_BASE."js/components/cliente-dirfiscales-selector.vue.js\"></script>
			
            ";



?>
<!-- 
<button @click="modalNuevaDireccion">manda llamar la funcion</button>
<cliente-dirfiscales-new-edit @onde="onDireccionEdited" ref="nuevaDireccion"></cliente-dirfiscales-new-edit> -->

<!-- <button @click="modalSelector">llama selector</button>
<cliente-dirfiscales-selector @on-dir-selected="onSelect($event)" ref="dirfiscalesselector"></cliente-dirfiscales-selector> -->

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Cliente <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
			
										
<!-- 				<input type="hidden" v-model="id" class="form-control input-md" > -->
				<div class="row">
					<div class="col-lg-6">
						<?php
							
							Form::setColsInput("l12|m12|s12|x12");
							Form::open("frmCliente");
									
							
							Form::hidden("idCliente");
							
							Form::row();
							Form::text("nombre", "Nombre", "60", true);
							Form::endRow();
							
							Form::row();
							Form::text("apellidos", "Apellidos", "60", true);
							Form::endRow();
							
							Form::row();
							Form::text("telefonos", "Telefonos", "60", true);
							Form::endRow();
							
						?>
						
						
						<div v-show="accionModulo == 'Actualizar'">
							<?php 	
							
								Form::row();
								Form::setColsInput("l12|m12|s12|x12");
								Form::select("estado", "Estatus", $lstEstatus);
								Form::endRow();
								
							?>
						</div>
						
						
						<?php 
							
							Form::row();
							Form::select("usuarioPromotor", "Promotor", $lstPromotores, "", "", false, false, "mostrarUsuarioPromotor");
							Form::endRow();
							
						?>
					</div>
					<div class="col-lg-6">
						<h3>Datos Personales</h3>
						<?php 
							
							Form::row();
							// Form::setColsDefault();

							Form::setColsInput("l12|m12|s12|x12");
							//Form::text("empresa", "Empresa", "60", true,false," v-on:input= 'chkSameData && fnSameData()'");
							Form::text("empresa", "Empresa", "60", true,false," :disabled=chkSameData ");
							Form::endRow();
							
							Form::row();
							// Form::setColsDefault();
							//Form::text("domicilio1", "Domicilio 1", "60", true,false," v-on:input= 'chkSameData && fnSameData()'");
							Form::text("domicilio1", "Domicilio 1", "60", true,false," :disabled=chkSameData ");
							Form::endRow();
							
							Form::row();
							// Form::setColsDefault();
							Form::text("domicilio2", "Domicilio 2", "60", true);
							Form::endRow();
							
							Form::row();
							Form::setColsInput("l12|m12|s12|x12");
							//Form::text("CP", "C. P.", "5", true,false," v-on:input= 'chkSameData && fnSameData()'");
							Form::text("CP", "C. P.", "5", true,false," :disabled=chkSameData ");
							Form::endRow();
							
							Form::row();
							// Form::setColsInput("l6|m6|s12|x12");
							//Form::text("numero", "N&uacute;mero", "60", true,false," v-on:input= 'chkSameData && fnSameData()'");
							Form::text("numero", "N&uacute;mero", "60", true,false," :disabled=chkSameData ");
							Form::endRow();
							
							
							
							Form::row();
							Form::setColsInput("l12|m12|s12|x12");
							// Form::setColsDefault();
							//Form::text("colonia", "Colonia", "60", true,false," v-on:input= 'chkSameData && fnSameData()'");
							//Form::text("ciudad", "Ciudad", "60", true,false," v-on:input= 'chkSameData && fnSameData()'");
							Form::text("colonia", "Colonia", "60", true,false," :disabled=chkSameData ");
							Form::endRow();
							Form::row();
							Form::text("ciudad", "Ciudad", "60", true,false," :disabled=chkSameData ");
							Form::endRow();
							//Form::text("domicilio2", "Domicilio 2", "60", true);
							
							
						?>
					</div>
				</div>									
				
				
				
                
				
				<!-- </div> -->
				<?php 	
					
					Form::buttonPrimary("Guardar", "guardarCliente");
							
				    
					Form::close();
				?>		
				
				<div class="clearfix"></div>
							
			</div>

			
		</div>
	</div>
</div>

<cliente-dirfiscales-listado v-if="idCliente > 0" ref="direccionesListado"></cliente-dirfiscales-listado>



<!-- <pre> -->
<!-- 	{{ $data}} -->
<!-- </pre> -->

