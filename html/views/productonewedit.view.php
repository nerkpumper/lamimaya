<?php
$titlePage = "Producto";
$breadCum = "Productos/Producto/Editar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_PRODUCTO;


$_addHead = "
		     <link href='".URL_BASE."assets/inspinia/css/plugins/iCheck/custom.css' rel='stylesheet'>
		     <link href='".URL_BASE."assets/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css' rel='stylesheet'>
		     		
     		";

$_addScript = "
		<script src='".URL_BASE."assets/inspinia/js/plugins/iCheck/icheck.min.js'></script>";
// "		<script>
//             $(document).ready(function () {
//                 $('.i-checks').iCheck({
//                     checkboxClass: 'icheckbox_square-green',
//                     radioClass: 'iradio_square-green',
//                 });
//             });
//         </script>       
		
// 		";

?>




<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Producto <small>{{ accionModulo }}</small></h5>				
			</div>
			<div class="ibox-content">
				<h2>Producto</h2>
<!-- 				<div class="row"> -->
<!-- 				<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'> -->

<!-- 					<div class='form-group' -->
<!-- 						v-bind:class="{'has-error': errDescripcion2}"> -->
<!-- 						<label class='col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label'>Descripcion2</label> -->
<!-- 						<div class='col-lg-8 col-md-8 col-sm-12 col-xs-12 '> -->


<!-- 							<textarea rows='4' cols='10' v-model='descripcion2' -->
<!-- 								id='descripcion2' name='descripcion' class='form-control' -->
<!-- 								maxlength='250'></textarea> -->

<!-- 							<span v-if='errDescripcion2' class='help-block'> <strong>{{ -->
<!-- 									errDescripcion2 }}</strong> -->
<!-- 							</span> -->

<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
<!-- 				</div> -->
				<?php
// 				Form::textarea("descripcion2", "Descripci&oacute;n", "4", "", "250", true);

				
					Form::setColsLabel("l3|m3|s12|x12");
					
					Form::open("frmLamina");
					
					Form::line();
					Form::hidden("idProducto");
				?>
				
				<div v-if="!esAccesorio && !esRollo">
					<?php 
						Form::labelH("h1","codigo", "C&oacute;digo", (!$disableSelect ? "text-warning" : "text-success"), true, true, false, " <small v-if=\"longitud == 'cvcvfv'\"> Longitud {{ longitud }} {{ longitudmof}}.</small>");
					?>
				</div>
				
				
				
				<?php 
					
 					
 					Form::labelH("h1","codigoGenerado", "", "", false, false, true);
 					
 					Form::setColsInput("l4|m4|s12|x12");
 					Form::select("tipoProducto", "Tipo Producto", $lstTiposProducto, "0=>", "", false, $disableSelect);
					
 					Form::labelH("h1","codigoGenerado", "", "", false, false, true);
 					
 					
 					Form::select("aplicacion", "Aplicaci&oacute;n", $lstModelosLamina, "0=>", "", false, $disableSelect, "claveTipoProducto == \"L\"");
 					
 				?>
 				
 				<div v-if="esAccesorio">
					<?php 
					
						Form::text("codigoAccesorio", "C&oacute;digo", "48", true);						
					
					?>					
				</div>
 				
 				<?php 
 					
 					Form::select("unidad", "Unidad", $lstUnidades, "0", "", false, $disableSelect);
 				?>
				
 				<?php 
 					
 					 Form::select("tipoRango", "Tipo Rango", $lstListaTipoRango, "0", "", false, $disableSelect, "claveTipoProducto != \"R\"");
 					//Form::select("tipoRango", "Tipo Rango", $lstListaTipoRango, "0", "", false, $disableSelect);
 				?>
 				
 				<div v-if="!esRollo && !esAccesorio">
 					<div v-if="esPieza">
 				
	 					<?php 
							
	 						Form::alignTextRight();
	 						Form::text("longitud", "Longitud Mts","18", true, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\" " . ($disableSelect ? " disabled " : "" ) );
	 						//Form::text("mlpieza", "ML Pieza","8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\" " );
// 	 						replace(/(\..*)\./g, '$1').
	 					?>
	 					
	 				</div>
<!-- 	 				<div v-else> -->
	 					
		 				
<!-- 		 				<div v-show="unidad == 4"> -->
 						<div v-show="false"> 
							<?php 
							    //Form::select("calibre", "Calibre", $lstCalibres, "666", "Seleccione", false, $disableSelect);
// 								Form::select("calibre", "Calibre", $lstCalibres, "", "Seleccione", false, true, "false");
							?>		 				
		 				</div>
		 				
<!-- 		 				<div v-show="unidad != 4">  -->
                        <div>
			 				<?php
			 					Form::setCols("l12", "l2|m2|s12|x12", "l10|m10|s12|x12");
			 					//Form::setColsInput("l8|m8|s12|x12");
			 					Form::select("rollo", "Rollo", $lstRollos, "0", "", false, $disableSelect);
			 					
			 				?>
		 				</div>
<!-- 	 				</div> -->

						<!-- 		 				<div v-show="unidad == 4"> -->
						<div v-show="rollo == 1">
 							<?php
 							
 								Form::setColsInput("l4|m4|s12|x12");
	 					
			 					Form::select("material", "Material", $lstMateriales, "0=>0", "", false, $disableSelect);
			 					
			 					Form::setColsInput("l3|m3|s12|x12");
			 				?>
 												
							<?php
								Form::setColsInput("l3|m3|s12|x12");
							    Form::select("calibre", "Calibre", $lstCalibres, "666", "Seleccione", false, $disableSelect);
// 								Form::select("calibre", "Calibre", $lstCalibres, "", "Seleccione", false, true, "false");
							?>		 				
		 				</div>

						<div v-show="rollo == 1">				
							<?php 
							
							    Form::select("pies", "Pies", $lstPies, "0", "NO APLICA", false, $disableSelect);
// 								Form::select("calibre", "Calibre", $lstCalibres, "", "Seleccione", false, true, "false");

							    Form::selectNOTCERO("origen", "Origen", $lstOrigen,false, $disableSelect);
							?>
										 				
		 				</div>

 				
 				</div>
 				<div v-else>
 					<div v-if="!esAccesorio">
 						<?php 
 							Form::setCols("l12", "l2|m2|s12|x12", "l10|m10|s12|x12");
		 					//Form::setColsInput("l8|m8|s12|x12");
		 					Form::select("productoRollo", "Rollo", $lstRollosRollo, "0", "", false, $disableSelect);
	 					?>
 					</div> 					
 				</div>
 				
 				 				 				
 				<?php 
 					
 					//Form::setColsInput("l4|m4|s12|x12");
 					//Form::select("listaPrecio", "Lista Precios", $lstListaPrecio, "", "Seleccione", false, false);
 					//Form::check("isRango", "Rango de Precios", "listaPrecio == \"G\" && !esRollo && !esAccesorio && !esPieza");
 				?>
 					 				 				
 				<?php

 					Form::row();
 					Form::setColsDefault();
 					Form::setColsLabel("l3|m12|s12|x12");
 					Form::textarea("descripcion", "Descripci&oacute;n", "4", "", "250", true);
 					Form::endRow();
//  					Form::text("descripcion", "Descripci&oacute;n","250", true, false, "oninput=\"this.value = this.value.replace(/[^0-9.Xx]/g, '').replace(/(\XX*)\X/g, '$1');\" " . ($disableSelect ? " " : "" ) );

 					Form::row();
 					Form::setColsLabel("l3|m3|s12|x12");
 					Form::setColsInput("l3|m3|s12|x12");
 					Form::alignTextRight();
 					Form::text("medidaespecial", "Medida Especial", "18", false, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\\./g, '$1');\"");
 					Form::endRow();

 					Form::line();
 				?>

				
				
				<?php if (Permisos::userIsThisRol(Permisos::$idROOTUSER) || Permisos::userIsThisRol(Permisos::$rol_ADMINISTRADOR)):?>
				
				
					<div  class="row" v-if="idProducto > 0">
						<div class="col-lg-12">
								<h2>Precios</h2>
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
									<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Precio Rango Mendez</label>
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
										
										<div class="input-group ">
											<span class="input-group-addon">$</span> <input type="text" v-model="precioMendez"
												oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
												maxlength="8"
												class="form-control  text-right">
										</div>
										<span class="help-block m-b-lg">{{ rangoPrecioMendez }}</span>
										
									</div>
								</div>
							</div>
						</div>
											
					</div>
					<div  class="row" v-if="idProducto > 0">
						<div class="col-lg-12">
								<h2>Costo</h2>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Costo</label>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									
									<div class="input-group">
										<span class="input-group-addon">$</span> <input type="text" v-model="costo"
										    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
										    maxlength="8"
											class="form-control text-right">
											
									</div>
									<span  class="help-block m-b-lg">Costo sin I.V.A</span>
									
								</div>
								
							</div>
						</div>
											
					</div>
				<?php endif;?>
				

				<?php
				
				// //Form::buttonPrimary("Guardar", "guardarLamina", "showSave");
				Form::buttonPrimary ( "Guardar", "guardarProducto" );
				
				Form::close ();
				?>					
			</div>
		</div>
	</div>
</div>

<pre>
	{{ $data.rollo}}
</pre>
