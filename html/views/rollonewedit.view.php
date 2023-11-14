<?php
$titlePage = "Rollo";
$breadCum = "Productos/Rollo/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_ROLLO;

?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Rollos <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
																				
				<?php
					
					Form::open("frmRollo");
							
					Form::hidden("idRollo");
					
					Form::labelH("h1","codigo", "C&oacute;digo", (!$disableSelect ? "text-warning" : "text-success"), true, true);
					Form::labelH("h1","codigoGenerado", "", "", false, false, true);
										
					Form::select("material", "Material", $lstMateriales, "0=>", "", false, $disableSelect);
					
					Form::setColsInput("l3|m3|s12|x12");
					
					
					
					Form::select("calibre", "Calibre", $lstCalibres, "", "Seleccione", false, $disableSelect);
					
					Form::select("pies", "Pies", $lstPies, "", "Seleccione", false, $disableSelect);
					
					Form::select("origen", "Origen", $lstOrigen, "", "Seleccione", false, $disableSelect);
					
					Form::setColsDefault();
					Form::select("proveedor", "Proveedor", $lstProveedores, "0=>", "", false, $disableSelect);
					
					Form::select("color", "Color", $lstColores, "0=>", "", false, $disableSelect);
					
					Form::setColsInput("l3|m3|s12|x12");
					Form::text("grado", "Grado","3", true, false, "oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\" " . ($disableSelect ? " disabled " : "" ) );
					
					Form::setColsDefault();
					
					Form::textarea("descripcion", "Descripci&oacute;n", "4", "", "250", true);
					
					Form::textarea("observaciones", "Observaciones", "4", "", "250", true);

				?>
				<div  class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2>Precios Metro Lineal</h2>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 1</label>
							<label v-else class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio</label>
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								
								<div class="input-group">
									<span class="input-group-addon">$</span> <input type="text" v-model="precio1"
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
										maxlength="8"
										class="form-control text-right">
										
								</div>
								<span  class="help-block m-b-lg">{{ rangoPrecio1 }}</span>
								
							</div>
							<div >
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 2</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group ">
										<span class="input-group-addon">$</span> <input type="text" v-model="precio2"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
											maxlength="8"
											class="form-control  text-right">
									</div>
									<span class="help-block m-b-lg">{{ rangoPrecio2 }}</span>
									
								</div>
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 3</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group ">
										<span class="input-group-addon">$</span> <input type="text" v-model="precio3"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
											maxlength="8"
											class="form-control  text-right">
									</div>
									<span class="help-block m-b-lg">{{ rangoPrecio3 }}</span>
									
								</div>
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 4</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group ">
										<span class="input-group-addon">$</span> <input type="text" v-model="precio4"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
											maxlength="8"
											class="form-control  text-right">
									</div>
									<span class="help-block m-b-lg">{{ rangoPrecio4 }}</span>
									
								</div>
								
							</div>
						</div>
					</div>
										
				</div>
				<div  class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h2>Precios KG</h2>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 1</label>
							<label v-else class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio</label>
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
								
								<div class="input-group">
									<span class="input-group-addon">$</span> <input type="text" v-model="preciokg1"
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
										maxlength="8"
										class="form-control text-right">
										
								</div>
								<span  class="help-block m-b-lg">{{ rangoPrecio1 }}</span>
								
							</div>
							<div >
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 2</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group ">
										<span class="input-group-addon">$</span> <input type="text" v-model="preciokg2"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
											maxlength="8"
											class="form-control  text-right">
									</div>
									<span class="help-block m-b-lg">{{ rangoPrecio2 }}</span>
									
								</div>
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 3</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group ">
										<span class="input-group-addon">$</span> <input type="text" v-model="preciokg3"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
											maxlength="8"
											class="form-control  text-right">
									</div>
									<span class="help-block m-b-lg">{{ rangoPrecio3 }}</span>
									
								</div>
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio 4</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group ">
										<span class="input-group-addon">$</span> <input type="text" v-model="preciokg4"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
											maxlength="8"
											class="form-control  text-right">
									</div>
									<span class="help-block m-b-lg">{{ rangoPrecio4 }}</span>
									
								</div>
							</div>
						</div>
					</div>
										
				</div>
				<?php
										
					//Form::buttonPrimary("Guardar", "guardarRollo", "showSave");
					Form::buttonPrimary("Guardar", "guardarRollo");
												
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>



<pre>	{{ $data}}</pre>