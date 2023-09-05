<?php
$titlePage = "Producto";
$breadCum = "Productos/Producto/Inventario";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_PRODUCTO;

$_addHead="
 			<link href='".URL_BASE."assets/inspinia/css/plugins/datapicker/datepicker3.css' rel='stylesheet'> 		
 		";

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/datapicker/bootstrap-datepicker.js\"></script> 		
 		";


?>

<div v-show="(unidad != 'PZA' && idrollo != 1 )" id="secNo">
	<div class="text-center animated fadeInDown alert alert-danger" >
        <h1 style="font-size: 50px; ">PEDIDO SIN INVENTARIO</h1>
        <h3 class="font-bold">Este producto no maneja inventario de stock, el inventario para este tipo de producto es mediante los N&uacute;meros de Rollo, la materia prima.</h3>

        <div class="error-desc m-t">
            Si desea regresar al Listado de Productos, pulse el siguiente bot&oacute;n
            <br/><a href="productos" class="btn btn-danger m-t">Ir a Listado de Productos</a>
        </div>
        <div class="error-desc m-t">
            Si desea ir al listado de rollos para seleccionar algun N&uacute;mero de Rollo, pulse el siguiente bo&oacute;n
            <br/><a href="rollos" class="btn btn-danger m-t">Ir a Listado de Rollos</a>
        </div>
    </div>
</div>

<div class="row m-b" >
	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
		<select class="form-control" v-model="idSucursal">
			<option value="0">-- Seleccione Sucursal --</option>
			<?php 
			     foreach ($lstSucursales as $suc)
			     {
			         echo "<option value=\"".$suc["idSucursal"]."\">".$suc["nombre"]."</option>";
			     }	         
			
			?>
		</select>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<button class="btn btn-primary" @click.prevent="obtenerInformacion">Obtener informaci&oacute;n</button>
	</div>
	
</div>

<div v-show=mostrarDatos>
	<div v-show="unidad == 'PZA' || (unidad == 'ML' && idrollo == 1 )" class="row">	
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    		<div class="tabs-container">
    			<ul class="nav nav-tabs">
    				<li class="active"><a data-toggle="tab" href="#tab-1"> Inventario Producto</a></li>
    				<li class=""><a data-toggle="tab" href="#tab-2">Movimientos de Producto</a></li>
    			</ul>
    			<div class="tab-content">
    				<div id="tab-1" class="tab-pane active">
    					<div class="panel-body">
    						
    						<div class="row">
    							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    						
    						<?php
    						Form::hidden ( "idProducto" );
    						
    						Form::setColsGroup ( "l12|m12|s12|x12" );
    						Form::setColsLabel ( "l2|m2|s12|x12" );
    						Form::setColsInput ( "l10|m10|s12|x12" );
    						Form::setMargin ( "m-t-xs" );
    						
    						Form::label ( "codigo", "C&oacute;digo" );
    						
    						Form::label ( "tipoProducto", "Tipo Producto");
    							
    							Form::label("aplicacion", "Aplicaci&oacute;n");
    							
    							Form::label("material", "Material");
    							
    							Form::label("rollo", "Rollo");
    							
    							Form::label("calibre", "Calibre");
    							
    							Form::label("descripcion", "Descripci&oacute;n");
    							
    // 							Form::label("existencia", "Cantidad Actual");
    							
    							Form::setColsInput("l6|m6|s12|x12");
    							Form::select("movimiento", "Movimiento", $lstMovimientos, "0", "--Seleccione--");
    							
    							
    							Form::text("cantidad", "Cantidad {{ lblSumaResta }}","8", true, false, "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');\" "  );
    							Form::setColsInput("l8|m18|s12|x12");
    							Form::setMargin("m-t");
    							
    							Form::textarea("observaciones", "Observaciones", "4", "", "250", true);
    		// 					Form::singleButtonDanger("Eliminar", "eliminarMaterial", "", "","l12");
    										
    						?>	
    						
    						
    								
    							</div>
    							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    								<h1>Existencia Actual</h1>
    								<h1 class="font-bold">{{  existencia }}</h1>
    							</div>
    						</div>
    						
    						<div class="row">
    							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    								<button @click.prevent="generarMovimiento" class="btn btn-primary  m-t-md pull-right">Realizar Movimiento</button>
    							</div>
    						</div>
    <!-- 						<div class='hr-line-dashed'></div> -->
    						<div class="">
    							<h3>&Uacute;ltimos Movimientos</h3>
    							<div class="panel-rec">
    								<div class="table-responsive">
    					                <table class="table table-striped">
    					                    <thead>
    						                    <tr>		
    						                        <th>Fecha Inventario</th>
    						                        <th>Empleado</th>
    						                        <th>Existencia Anterior</th>
    						                        <th>Cantidad E/S</th>
    						                        <th>Existencia Actual</th>
    						                        <th>Sucursal</th>
    						                        <th>Observaciones</th>		                        
    						                    </tr>
    					                    </thead>
    					                    <tbody id="tblMovimientosBody">
    					                    
    					                    </tbody>
    					                </table>
    					            </div>
    							</div>						
    						</div>
    						
    					</div>
    				</div>
    				<div id="tab-2" class="tab-pane">
    					<div class="panel-body">
    						<h4>Producto</h4>
    						<h2>{{ codigo}} - {{ fullDescripcion }}</h2>
    						<div class="panel-rec">
    							<div class="row">
    								<div class="col-sm-3">
    									<div class="form-group">
    										<label class="control-label" for="status">Movimientos</label> 
    										<select v-model="reportMovimiento"	class="form-control">
    											<option value="ES" selected="">Entradas/Salidas</option>
    											<option value="E">Entradas</option>
    											<option value="S">Salidas</option>
    										</select>
    									</div>
    								</div>
    								<div class="col-sm-3">
    									<div class="form-group" v-bind:class="{'has-error': errFechaInicio}">
    		                                <label class="control-label">Desde</label>
    		                                <div class="input-group date">
    		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    		                                    <input id="dtFechaInicio" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>">		                                    
    		                                </div>
    		                                <span v-if='errFechaInicio' class='help-block'>
    												<strong>{{ errFechaInicio }} </strong>
    										</span>
    		                            </div>
    								</div>
    								<div class="col-sm-3">
    									<div class="form-group"  v-bind:class="{'has-error': errFechaFin}">
    		                                <label class="control-label">Hasta</label>
    		                                <div class="input-group date">
    		                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    		                                    <input id="dtFechaFin" type="text" class="form-control"  value="<?php echo date("d/m/Y");?>">
    		                                </div>
    		                                <span v-if='errFechaFin' class='help-block'>
    												<strong>{{ errFechaFin }} </strong>
    										</span>
    		                            </div>
    								</div>
    								<div class="col-sm-3">
    									<div class="form-group">
    										<button @click.prevent="obtenerReporte" class="btn btn-primary m-t-md">Obtener</button>
    										<!-- <button @click.prevent="exportarReporte" class="btn btn-outline btn-success m-t-md"><i class="fa fa-file-excel-o"></i> Exportar</button> -->
    										<?php Form::btnExportarExcel("exportarReporte"); ?>										
    									</div>
    								</div>
    								
    							</div>
    						</div>
    
    						<div class="table-responsive">
    							<table id="tblReporte" class="table table-striped">
    								<thead>
    									<tr>
    										<th>Fecha Inventario</th>
    										<th>Empleado</th>
    										<th>Existencia Anterior</th>
    						                <th>Cantidad E/S</th>
    						                <th>Existencia Actual</th>
    						                <th>Sucursal</th>
    						                <th>Observaciones</th>	
    									</tr>
    								</thead>
    								<tbody id="tblMovimientosTodosBody">
    
    								</tbody>
    							</table>
    						</div>
    					</div>
    				</div>
    			</div>
    
    
    		</div>
    	</div>
    </div>
    <?php Form::frmExportarExcel();?>
</div>



 <!-- <pre> 
 	{{ $data}} 
 </pre> -->