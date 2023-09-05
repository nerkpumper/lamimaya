<?php
$titlePage = "Producto";
$breadCum = "Productos/Producto/Eliminar";
$buttonAction = "Regresar al Listado/fnRegresarAListado";
$_lugar = LUGAR_PRODUCTOS_PRODUCTO;
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Producto <small>Eliminar</small></h5>				
			</div>
			<div class="ibox-content">
				
				<div v-if="productoEliminado">
					<div class="alert alert-danger">
	                     <h2>El Producto ya esta en estado de Baja.</h2>	                     
	                </div>
				</div>
				<div v-else>
					<div class="alert alert-danger">
	                     Se eliminar&aacute; la siguiente informaci&oacute;n
	                </div>
															
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
						
					Form::label("existencia", "Cantidad Actual");
									
					?>
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<button @click.prevent="eliminarProducto" class="btn btn-danger  m-t-md ">Eliminar</button>
						</div>
					</div>	
				</div>
				
				
				
				<div class="clearfix"></div>				
			</div>
		</div>
	</div>
</div>

<!--  <pre>  -->
<!--  	{{ $data}}  -->
<!--  </pre> -->