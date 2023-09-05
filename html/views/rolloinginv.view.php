<?php
$titlePage = "Recepci&oacute;n de Rollos";
$breadCum = "Productos/Rollo/Recibir";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_ROLLO;

?>





<div class="ibox-content m-b-sm border-bottom">
	<div class="p-xs">
		<div class="pull-left m-r-md">
			<i class="fa fa-suitcase text-navy mid-icon"></i>
		</div>
		<h2 class="text-success">{{ codigo }}</h2>
		<span><strong>Descripci&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;</strong>{{ descripcion }}</span>
<!-- 		<br> -->
<!-- 		<span><strong>Proveedor:&nbsp;&nbsp;&nbsp;&nbsp;</strong>{{ proveedor }}</span> -->
	</div>
</div>



<div class="row" v-if="!blnProcesado">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox-content m-b-sm border-bottom">
		
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group" v-bind:class="{'has-error': errRemision}">
						<label class="control-label" for="price">Remisi&oacute;n</label> <input
							type="text" id="remision" name="remision" v-model="remision"
							ref="remision" placeholder="Remisi&oacute;n" class="form-control"
							maxlength="20" v-on:keypress.enter="app.$refs.noRollo.focus();"
							onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
						<span class='help-block'> <strong>{{ errRemision }}</strong>
						</span>
					</div>
				</div>
		
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
					<div class="form-group" v-bind:class="{'has-error': errNoRollo}">
						<label class="control-label" for="price">Rollo</label> <input
							type="text" id="noRollo" name="noRollo" v-model="noRollo"
							ref="noRollo" placeholder="# Rollo" maxlength="20"
							v-on:keypress.enter="app.$refs.kilos.focus();"
							v-on:keyup.esc="app.noRollo = ''; app.remision = ''; app.$refs.remision.focus();"
							class="form-control"> <span class='help-block'> <strong>{{
								errNoRollo }}</strong>
						</span>
					</div>
				</div>
		
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group" v-bind:class="{'has-error': errKilos}">
						<label class="control-label" for="price">Kilos</label> <input
							type="text" id="kilos" name="kilos" v-model="kilos" ref="kilos"
							placeholder="Kilos" v-on:keypress.enter="listarIngreso"
							oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
							class="form-control" maxlength="5"> <span class='help-block'> <strong>{{
								errKilos }}</strong>
						</span>
					</div>
				</div>
		
				<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
					<div class="form-group" style="margin-top: 20px;">				
								<?php
								
								Form::buttonPrimary ( "Enlistar", "listarIngreso" );
								
								?>
							</div>
				</div>
				
				
		
			</div>
		
		</div>
				
	</div>
	
</div>

<div v-if="blnProcesado">
	<?php
								
		Form::buttonPrimary ( "Nueva Recepci&oacute;n", "nuevaRecepcion" );
								
	?>
	<br>	
	<br>
</div>


<div class="ibox">
	<div class="ibox-content">
		<div style="overflow-x: auto;">
			<div v-if="blnNoRegistrados" class="alert alert-danger">
            	No se han registrado la recepci&oacute;n de los rollos. Favor de verificar.
            </div>

			<table class="table table-hover no-margins">
				<thead>
					<tr>
						<th>Estatus</th>
						<th>Remisi&oacute;n</th>
						<th>Numero Rollo</th>
						<th>Kilos</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in ingresos">
						<td v-html="getEstatusLabel(index)"></td> 
						<td>{{ item.remision }}</td>
						<td>{{ item.noRollo }}</td>
						<td>{{ item.kilos }}</td>
						<td >							
							<?php Form::singleButtonDanger("X", "quitarIngreso(index)", "!blnProcesado", "btn-xs");?>
							<div v-if="blnProcesado" v-html="getIconProceso(index)">
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<div style="margin-top: 3%;">
				<hr>
						<?php
						
						Form::openGroupForButtons ();
						Form::singleButtonPrimary ( "Registrar Ingresos", "registrarIngreso", "ingresos.length > 0 && !blnProcesado", "", "l2" );
						Form::closeGroupForButtons ();
						
						?>
					</div>
		</div>
	</div>
</div>


<pre>
	{{ $data }}
</pre>

