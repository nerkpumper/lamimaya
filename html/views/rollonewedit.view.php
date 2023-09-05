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
										
					//Form::buttonPrimary("Guardar", "guardarRollo", "showSave");
					Form::buttonPrimary("Guardar", "guardarRollo");
												
					Form::close();
				?>					
			</div>
		</div>
	</div>
</div>

<!-- <pre>	{{ $data}}</pre> -->