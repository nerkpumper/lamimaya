<?php
$titlePage = "Surtir Pedido";
$breadCum = "Producci&oacute;n/Surtir";
$_lugar = LUGAR_PRODUCCION_DESPACHARPEDIDO;

$_addHead="

 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'>
 		";

$_addScript="

 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		";

$debugRenglones = true;

?>


<!-- Modal Listado de Registros de Produccion -->
<div class="modal inmodal fade" id="modalRegistrosProduccion" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Selecci&oacute;n de Registros de Producci&oacute;n</h4>				
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-stripped toggle-arrow-tiny" data-page-size="5">
						<thead>
							<tr>
								<th>Material</th>
								<th># Rollo</th>
								<th>Kilos</th>
								<th>Maquilados</th>
								<th>Almacen</th>
								<th>Seleccione </th>
							</tr>
						</thead>
						<tbody >
							<tr v-for="(rp, index) in rpRegistrosDeProduccion">
								<td><h3>{{rp.rollo}}</h3></td>
								<td><h3>{{rp.noRollo}}</h3></td>
								<td>{{rp.kilos}}</td>
								<td>{{rp.kilosMaquilados}}</td>
								<td>{{rp.almacen}}</td>
<td><button v-show="rp.almacen != 'OBRA' && rp.idSucursal == idSucursal" @click.prevent="seleccionarRegistroProduccion(rp.idRegistroProduccion, rp.rpIdRemisionRollo, index)" class="btn btn-primary btn-xs">Seleccionar<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT)): ?> {{rp.idRegistroProduccion}} <?php endif; ?></button></td>
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<ul class="pagination pull-right"></ul>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fin Modal Listado de Registros de Produccion -->


<div class="modal inmodal fade" id="modalNoRollos" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Seleccione Numero de Rollo</h4>
				<small class="font-bold">{{ descripcionRollo }}</small>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="tblNoRollos"
						class="table table-stripped toggle-arrow-tiny" data-page-size="5">
						<thead>
							<tr>
								<th data-sort-ignore="true"># Rollo</th>
								<th data-sort-ignore="true" data-hide="phone">Remisi&oacute;n</th>
								<!-- 							<th data-sort-ignore="true" data-hide="phone">Disponible KG</th>							 -->
								<th data-sort-ignore="true" class="">Seleccione</th>
							</tr>
						</thead>
						<tbody id="tblNoRollosBody">


						</tbody>
						<tfoot>
							<tr>
								<td colspan="7">
									<ul class="pagination pull-right"></ul>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="modalStockNoRollos" tabindex="-1"
	role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Seleccione Stock Numero de Rollo</h4>
<!-- 				<small class="font-bold">{{ descripcionRollo }}</small> -->
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="tblStockNoRollos"
						class="table table-stripped toggle-arrow-tiny" data-page-size="5">
						<thead>
							<tr>
								<th data-sort-ignore="true"># Rollo</th>
								<th data-sort-ignore="true">Existencia</th>
								<!-- 							<th data-sort-ignore="true" data-hide="phone">Disponible KG</th>							 -->
								<th data-sort-ignore="true" class="">Seleccione</th>
							</tr>
						</thead>
						<tbody id="tblStockNoRollosBody">


						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<ul class="pagination pull-right"></ul>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div v-show="seleccionarPedido">
	<h2 class="m-l">No. Pedido:</h2>
	<div class="col-sm-3 m-b-xs">
	 	<div class="input-group">
	 		<input type="text" class="form-control input-lg"
	 		v-model="idPedido"
	 		v-on:keypress.enter="cargarDatosPedido"
			oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
			maxlength='8'>
			<span class="input-group-btn">
				<button @click.prevent="cargarDatosPedido"
					class="btn btn-primary btn-lg " type="button">
					<i class="fa fa-check"></i><span class="bold"></span>
				</button>
			</span>
	 	</div>
	 </div>



</div>

<div v-show="pedidoTerminado" id="secDespachado">
	<div class="text-center animated fadeInDown alert alert-success" >
        <h1 style="font-size: 70px; ">PEDIDO TERMINADO</h1>
        <h3 class="font-bold">El Pedido no puede Surtirse</h3>

        <div class="error-desc">
            El Pedido ya ha sido surtido y no puede volver a surtirse.
            <br/><a href="<?php  echo URL_BASE;?>pedidos" class="btn btn-primary m-t">Ir a Listado de Pedidos</a>
            <button @click.prevent="seleccionarOtroPedido" class="btn btn-warning m-t">
	    			 Seleccionar otro Pedido
	    		</button>
	    		
	    	
	    		
	    		
        </div>
    </div>
</div>

<div v-show="pedidoNoProduccion" id="secNo">
	<div class="text-center animated fadeInDown alert alert-danger" >
        <h1 style="font-size: 70px; ">PEDIDO {{ pedidoEstado }}</h1>
        <h3 class="font-bold">El Pedido debe estar en estatus de Producci&oacute;n para poder surtirlo.</h3>

        <div class="error-desc">
            El Pedido ya ha sido surtido y no puede volver a surtirse.
            <br/><a href="<?php  echo URL_BASE;?>pedidos" class="btn btn-danger m-t">Ir a Listado de Pedidos</a>
            <button @click.prevent="seleccionarOtroPedido" class="btn btn-warning m-t">
	    			 Seleccionar otro Pedido
	    		</button>
	    		
	    	
        </div>
    </div>
</div>

<div v-show="pedidoProduccion" id="secPedido">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="ibox">
	    	<div class="ibox-content">
	    		<button @click.prevent="seleccionarOtroPedido" class="btn btn-warning btn-sm">
	    			<i class="fa fa-angle-double-left"></i> Seleccionar otro Pedido
	    		</button>
	    		<button @click.prevent="cargarDatosPedido" class="btn btn-primary btn-sm pull-right">
	    			 <i class="fa fa-refresh"></i>
	    		</button>
	    		<hr>
	    		<h2>Pedido <strong class="pull-right" style="font-size: 38px;">{{ idPedido }}</strong></h2>
				<hr>
				<div v-for="(pd, index) in pedidoDetalle" >
					<a href="#" class="product-name">{{ pd.codigo }}</a>
					<div class=" m-t-xs">
						<span class="h4 bagde badge-info m-r">{{ pd.partida }} </span> {{ pd.fullName }} <span v-show="pd.ml > 0 &&  pd.shortUnidad == 'ML'">[{{ pd.ml}} ML]</span>
					</div>
					<div class="small m-t-xs">
						<i>
							{{ pd.unidad }}
						</i>

					</div>
					
<!-- 					<address> -->
						<h2><small>A surtir: </small><span class="text-success">{{ pd.colocaCantidad }}</span><small> pzas. de </small><span class="text-success">{{ pd.sucursalNombre }}</span></h2>	                		                                        	                                        
<!-- 					</address> -->
					
					<i v-show="pd.isParcial == 'SI'">"Esta Partida tiene un complemento que se surtir&aacute; en otra sucursal"</i>
					
					<h5 v-show="pd.ml > 12.2 && pedidoRecogeEntrega == 'OBRA'" class="text-info">Este Producto se surte mediante un Registro de Producci&oacute;n</h5>
					
					<?php 
    					if (Permisos::userIsThisRol(Permisos::$rol_ROOT))
    					{
    					 echo "<br>";
    					 echo "idProducto {{ pd.idProducto}}";
    					 echo "<br>";
    					}
					
					?>
					
					<div v-if="pd.despachado == 'SI'" class="pull-right text-navy">
					    <h4>Producto Surtido <button class="btn btn-info" @click.prevent="viewDespachoPedidoDetalle(index)"><i class="fa fa-eye"></i></button> </h4>

					</div>
					<div v-else class="m-t text-right">

						<div v-if="!pd.despachando">
							<div v-if="pd.shortUnidad == 'PZA'  || (pd.shortUnidad == 'ML' && pd.idrollo == 1) || pd.codigo == 'MOL' || pd.codigo == 'MAQ' ">
								<button  @click.prevent="despacharPedidoDetalle(index)" class="btn btn-md btn-primary">Surtir <i
										class="fa fa-flag-checkered"></i>
								</button>
							</div>
							<div v-else>
								<h5 class="text-info">Este Producto se surte mediante un Registro de Producci&oacute;n</h5>
								<button  @click.prevent="despacharPedidoRPDeStock(index)" class="btn btn-md btn-success">Surtir de Stock <i
										class="fa fa-flag-checkered"></i>
								</button>
								
							</div>

						</div>
						<div v-else>
							<h3>Surtiendo...</h3>
						</div>
					</div>

					<div class="clearfix"></div>
					<hr />
				</div>




			</div>	
	    </div>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="ibox">
	    	<div class="ibox-content">
	    		<h4>Surtiendo</h4>
	    		<hr>
	    		<div v-show="despachandoAlgo">
	    			<div class="row">
	    					<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
<!-- 	    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 		    				<h1 class="text-navy">{{ proCodigo }}</h2> -->
<!-- 		    			</div> -->
		    			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    				<h2 style="padding-top: 5px;"><span class="h2 bagde badge-info m-r">{{ detPartida }} </span> <span class='text-navy' style="font-size: 28px;">{{ proCodigo }}</span> {{ proFullname }} <span v-show="detCantidadReal > 0 && proShortUnidad == 'ML'">[{{ detCantidadReal}} ML]</span></h3>
		    			</div>
	    			</div>
	    			<div v-if="!detProductoDetalleDespachado && totalPorDespachar > 0 && !isMoldura && !isMaquilaMoldura" class="alert alert-info">
	    					<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        Se descontar&aacute;n <strong>{{ queSeSaca }} </strong> de <strong>{{ deDondeSeSaca }} </strong> para este producto.
                    </div>
                    
                    <div v-if="!detProductoDetalleDespachado && totalPorDespachar > 0 && isMoldura && !isMaquilaMoldura && !molIsScrap" class="alert alert-info">
                        	<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        Las <strong>Molduras</strong> se surten a partir de <strong>L&aacute;minas Lisas del Calibre, Material y Pies</strong> que se ha especificado. As&iacute; mismo, pueden ser desarrolladas mediante <strong>Scrap</strong> . 
                    </div>
                    
                    <div v-if="!detProductoDetalleDespachado && totalPorDespachar > 0 && isMoldura && !isMaquilaMoldura && molIsScrap" class="alert alert-info">
                        	<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        Estas <strong>Molduras</strong> se realizan solo de <strong>Scrap</strong> . 
                    </div>
                    
                    <div v-if="!detProductoDetalleDespachado && totalPorDespachar > 0 && !isMoldura && isMaquilaMoldura" class="alert alert-info">
                        	<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        Las <strong>Maquilas NO</strong> se surten, solo se marcan como <strong> Realizadas</strong> . 
                    </div>

<!-- 					Total a Surtir y surdito a nivel renglon -->
	    			<div class="row m-t">
	    					<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
	    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	    					<h4>	<span v-if="deDondeSeSaca == 'ROLLO'">estimada</span> a Surtir TOTAL:&nbsp;<strong style="font-size: 24px;"> {{ totalExplotar }}</strong></h4>
	    					<!-- <h4>Cantidad <span v-if="deDondeSeSaca == 'ROLLO'">estimada</span> a despachar:&nbsp;<strong style="font-size: 24px;"> {{ detPartida }}</strong></h4>-->

	    				</div>
	    				<div v-if="deDondeSeSaca == 'INVENTARIO'" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	    					<h4>Cantidad <span v-if="deDondeSeSaca == 'ROLLO'">real</span> Surtida:&nbsp;<strong style="font-size: 24px;"> {{ explotadoReal  }}</strong></h4>
	    				</div>
	    			</div>	    			
	    			
	    			<div v-if="remisionHistorial" class="row">
	    				<div v-html="remisionHistorial" class="well">

	    				</div>
	    			</div>
	    			
<!-- 					Total a Surtir y surdito a nivel sucursal-->
					
					
					<div class="panel panel-info">
                    	<div class="panel-heading">
                    		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        	<h2>{{ sucursalNombre }}</h2>
                        </div>
                        <div class="panel-body">
                        	<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        	<div class="row m-t">
        	    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        	    					<h4>Cantidad <span v-if="deDondeSeSaca == 'ROLLO'">estimada</span> a Surtir:&nbsp;<strong style="font-size: 24px;"> {{ colocaCantidad }}</strong></h4>
        	    					<!-- <h4>Cantidad <span v-if="deDondeSeSaca == 'ROLLO'">estimada</span> a despachar:&nbsp;<strong style="font-size: 24px;"> {{ detPartida }}</strong></h4>-->
        
        	    				</div>
        	    				<div v-if="deDondeSeSaca == 'INVENTARIO'" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        	    					<h4>Cantidad <span v-if="deDondeSeSaca == 'ROLLO'">real</span> Surtida:&nbsp;<strong style="font-size: 24px;"> {{ colocaCantidadSurtida  }}</strong></h4>
        	    				</div>
        	    			</div>
                        </div>
                    </div>
					
					
	    			

	    			

<!-- 	    			SACAR DE ROLLOS -->
<!-- 					en INC manda llamar darSalidaARollo y usa ModeloInvzmovrollo -->
	    			<div v-if="deDondeSeSaca == 'ROLLO' && !detProductoDetalleDespachado && totalPorDespachar > 0">
	    				<hr>
	    				<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
	    				<button type="button" class="btn btn-primary m-b" @click.prevent="showModalNoRollos">
<!-- 	    				 data-toggle="modal" data-target="#modalNoRollos" -->
                            Seleccionar No Rollo
                        </button>
                        <div class="row">
                        		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        	<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision">Remisi&oacute;n</label>
									<h4><strong style="font-size: 24px;">{{ remisionRemision }}</strong></h4>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision"># Rollo</label>
									<h4><strong style="font-size: 24px;">{{ remisionNoRollo }}</strong></h4>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision">Existencia</label>
									<h4><strong style="font-size: 24px;">{{ remisionExistencia }}</strong></h4>
								</div>
							</div>
							<div v-if="remisionNoRollo != ''" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision">Cantidad</label>
									<input v-model="remisionCantidadSacar" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
									<label class="control-label" for="remision">Por Surtir: {{ totalPorDespachar }}</label>
								</div>
							</div>
<!--                         	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        		<h4>Remisi&oacute;n: <strong style="font-size: 24px;"> {{ remisionRemision }}</strong></h4>-->
<!--                         	</div> -->
<!--                         	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        		<h4># Rollo: <strong style="font-size: 24px;"> {{ remisionNoRollo }}</strong></h4>-->
<!--                         	</div> -->
<!--                         	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        		<h4>Existencia: <strong style="font-size: 24px;"> {{ remisionExistencia }}</strong></h4>-->
<!--                         	</div> -->
                        </div>
                        <div v-if="remisionNoRollo != ''" class="row">
                        		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                        	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                        		<button class="btn btn-primary pull-right" @click.prevent="descontarDeRollo">Descontar de Rollo</button>
                        	</div>
                        </div>
<!--                         <div class="row"> -->
<!--                         	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">                        		 -->
<!--                         		<h4>Cantidad:</h4>        -->
<!--                         	</div> -->
<!--                         	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">                 		 -->
<!--                         		<input type="text" class="form-control " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'> -->

<!--                         	</div> -->
<!--                         </div>	    					    				 -->
	    			</div>

<!-- 	    			FIN SACAR DE ROLLOS -->

<!-- 	    			SACAR DE INVENTARIO -->

	    			<div v-if="deDondeSeSaca == 'INVENTARIO' && !detProductoDetalleDespachado && totalPorDespachar > 0">
	    				<hr>
	    					<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
	    					
	    				<div v-show="!isMaquilaMoldura && !molIsScrap" class="panel panel-info">
                        	<div class="panel-heading">
                        		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                            	<h3>Surtir Mercancia de Inventario</h3>
                            </div>
                            <div class="panel-body">
                            	<div v-if="!molIsScrap && !detProductoDetalleDespachado && totalPorDespachar > 0 && isMoldura && !isMaquilaMoldura && molIdProductoLisa == 0" class="alert alert-warning">
                                    	<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                    No existe un Producto de Aplicaci&oacute;n LISA, con las especificaciones de la Moldura para descontar, solo podr&aacute; Surtir indicando que tom&oacute; <strong> Scrap</strong>.
                                </div>
        	    				
        <!-- 	    				<button v-show="!isMoldura && !isMaquilaMoldura" type="button" class="btn btn-primary m-b" @click.prevent="showModalStockNoRollos"> -->
        <!-- 	    				 data-toggle="modal" data-target="#modalNoRollos" -->
        <!--                             Seleccionar Stock -->
        <!--                         </button> -->
                                
        
        <!-- 						O P C I O N   S U R T I R -->
        <!-- 						en INC manda llamar cargarStockNoRollos, ahorita lee de invmzstocknorollos, hay que -->
        <!-- 						leer el inventariosucursal para el idproducto de la molIdProductoLisa -->
                                <div v-show="isMoldura && molIdProductoLisa != 0">
                                
                                	
                                	<h3>L&aacute;mina a Utilizar</h3>
                                	<div class="row">
                                		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                		    				<h2 style="padding-top: 5px;"><span class='text-navy' style="font-size: 24px;">{{ molCodigoLisa }}</span> {{ molDescripcionLisa }}</h3>
                		    			</div>
                                	</div>
                                	<div class="row">
                                		<button v-show="isMoldura && false" type="button" class="btn btn-primary m-b" @click.prevent="showModalStockNoRollosParaMoldura">
                <!-- 	    				 data-toggle="modal" data-target="#modalNoRollos" -->
                                            Seleccionar Stock de L&aacute;mina Lisa
                                        </button>
                                	</div>
                                	<hr>
                                    
                                </div>
                                
        <!-- 						O P C I O N   S U R T I R -->
                                
                                <div  v-show="(!isMoldura && !isMaquilaMoldura) || (isMoldura && molIdProductoLisa != 0)"  class="row">
                                		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
        							<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        								<div class="form-group">
        									<label class="control-label" for="remision">Sucursal</label>
        									<h4><strong style="font-size: 24px;">{{ sucursalNombre }}</strong></h4>
        								</div>
        							</div>
        							<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
        								<div class="form-group">
        									<label class="control-label" for="remision">Existencia</label>
        									<h4><strong style="font-size: 24px;">{{ sucursalExistencia }}</strong></h4>
        								</div>	
        							</div>
        							<div v-if="sucursalExistencia > 0" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        								<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
        								<div class="form-group">
        									<label class="control-label" for="remision"><span v-show="!isMoldura">Cantidad</span><span v-show="isMoldura">L&aacute;minas a Tomar</span></label>
        									<input v-model="sucursalCantidadSacar" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
        									<label v-show="isMoldura && molLaminasATomar > 0" class="control-label" for="remision">Se deben utilizar: {{ molLaminasATomar }}</label>
        									<label v-show="!isMoldura" class="control-label" for="remision">Por Surtir: {{ totalPorDespachar }}</label>
        								</div>
        							</div>
        							<div v-if="sucursalExistencia > 0 && isMoldura" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        								<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
        								<div class="form-group">
        									<label class="control-label" for="remision">Molduras A Surtir</label>
        									<input v-model="molCantidadSurtir" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
        									<label class="control-label" for="remision">Por Surtir: {{ totalPorDespachar }}</label>
        								</div>
        							</div>
        <!--                         	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                		<h4>Remisi&oacute;n: <strong style="font-size: 24px;"> {{ remisionRemision }}</strong></h4>-->
        <!--                         	</div> -->
        <!--                         	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                		<h4># Rollo: <strong style="font-size: 24px;"> {{ remisionNoRollo }}</strong></h4>-->
        <!--                         	</div> -->
        <!--                         	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                		<h4>Existencia: <strong style="font-size: 24px;"> {{ remisionExistencia }}</strong></h4>-->
        <!--                         	</div> -->
                                </div>
                                
                                
        <!-- 						O P C I O N   S U R T I R -->                        
                                
                                <div v-if="sucursalExistencia > 0" class="row">
                                		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
        <!--                         	en INC llama a darSalidaAInventarioFromStockNoRollo y usa ModeloInvzmov -->
                                	<div v-show="!isMoldura && !isMaquilaMoldura" class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                                			<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                		<button class="btn btn-primary pull-right" @click.prevent="descontarDeStockNoRollo">
        <!--                         			Surtir de este Stock No Rollo -->
        										Surtir
                                		</button>
                                	</div>
        <!--                         	en INC llama a darSalidaAInventarioFromStockNoRolloLaminaYScrap e inserta 2 INVZMOV uno para la lamina lisa y otro para la moldura,  -->
        <!--                         	solo la Lisa lleva inventario -->
                                	<div v-show="isMoldura && !isMaquilaMoldura" class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                                			<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                		<button class="btn btn-primary pull-right" @click.prevent="descontarDeStockNoRolloLaminaYScrap">Descontar L&aacute;minas y Surtir Molduras</button>
                                	</div>
                                	
                                	
                                </div>
                            </div>
                        </div>
	    				
                        
<!--                         <div class="row"> -->
<!--                         	<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">                        		 -->
<!--                         		<h4>Cantidad:</h4>        -->
<!--                         	</div> -->
<!--                         	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">                 		 -->
<!--                         		<input type="text" class="form-control " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'> -->

<!--                         	</div> -->
<!--                         </div>	    					    				 -->

						<hr>

						<div v-show="molIdRollo > 1 " class="panel panel-info">
							<div class="panel-heading">
                        		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                            	<h3>Registrar Produci&oacute;n L&aacute;mina <span class="pull-right">Utilice esta opci&oacute;n para no usar Stock</span></h3>                            	
                            </div>
                            <div class="panel-body">
								<div class="alert alert-info">
                                    	<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                    Se recomienda utilizar esta secci&oacute;n cuando va a fabricar L&aacute;minas en Lugar de tomar mercanc&iacute; de Stock.
								</div>
								<div v-show="rpIdRegistroProduccion == 0" class="text text-danger">No ha seleccionado un Registro de Producci&oacute;n</div>
								<button @click.prevent="showModalRegistrosProduccion" class="btn btn-primary pull-right">Seleccionar Registro de Producci&oacute;n</button>
								<div v-show="rpIdRegistroProduccion > 0" >
									<h3>Registro Producci&oacute;n: <strong>{{rpIdRegistroProduccion}}</strong></h3>
									<h3>Kilos: <strong>{{rpKilos}}</strong></h3>
									<h3>Kilos Maquilados: <strong>{{rpKilosMaquilados}}</strong></h3>
									<h3>KG estimado X ML: <strong>{{rpPesoEstimadoXKiloRolloSeleccionado}}</strong></h3>
									
									<hr>
									<div class="well">
										<h4>Detalle de Registro de Producci&oacute;n</h4>
										<table class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>NUM. DE PEDIDO</th>
													<th>NOMBRE DEL CLIENTE</th>
													<th>PIEZAS</th>
													<th>ML</th>
													<th>TOTAL DE ML</th>
													<th>TOTAL KG</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="item in rpRegistroProduccionDetalle">
													<td>{{ item.nopedido }}</td>
													<td>{{ item.nombrecliente }}</td>
													<td>{{ item.partida }}</td>
													<td>{{ item.longitud }}</td>
													<td>{{ formatNumber(item.totalml) }}</td>
													<td>{{ formatNumber(item.totalkg) }}</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr>
									<div class="row">
									
										<div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
											<div class="form-group">
												<label class="control-label" for="remision"><span>Laminas a fabricar</label>
												<input v-model="rpSucursalCantidadSacar" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>										
												<label v-show="isMoldura" class="control-label" for="remision">[{{detCantidadReal }} ML] ~ [{{formatNumber(rpSucursalCantidadSacar*detCantidadReal*rpPesoEstimadoXKiloRolloSeleccionado)}}] KG</label>
												<label v-show="!isMoldura" class="control-label" for="remision">[{{proLongitud }} ML] ~ [{{formatNumber(rpSucursalCantidadSacar*proLongitud*rpPesoEstimadoXKiloRolloSeleccionado)}}] KG</label>
												<!-- <label v-show="isMoldura && molLaminasATomar > 0" class="control-label" for="remision">Se deben utilizar: {{ molLaminasATomar }}</label> -->
												<!-- <label v-show="!isMoldura" class="control-label" for="remision">Por Surtir: {{ totalPorDespachar }}</label> -->
												<!-- <div class="form-group"> -->
        									<!-- <label class="control-label" for="remision"><span v-show="!isMoldura">Cantidad</span><span v-show="isMoldura">L&aacute;minas a Tomar</span></label>
        									<input v-model="sucursalCantidadSacar" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
        									<label v-show="isMoldura && molLaminasATomar > 0" class="control-label" for="remision">Se deben utilizar: {{ molLaminasATomar }}</label> -->
        										<br>
												<label v-show="!isMoldura" class="control-label" for="remision">L&aacute;minas Por Surtir: {{ totalPorDespachar }}</label>	
												<br>
												<div v-show="!isMoldura" class="text text-danger">{{ errRpSucursalCantidad }}</div>
												

        								<!-- </div> -->
											</div>
										</div>
										<!-- {{ colocaCantidadSurtida  }} -->
										<div v-show="!isMoldura"  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
												<h4>L&aacute;minas surtidas/fabricadas: <strong>{{colocaCantidadSurtida}}</strong></h4>									
												
											
										</div>
									
										<div v-if="isMoldura" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
											<div class="form-group">
												<label class="control-label" for="remision">Molduras A Surtir</label>
												<input v-model="rpmolCantidadSurtir" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
												<label class="control-label" for="remision">Molduras Por Surtir: {{ totalPorDespachar }}</label>
											</div>
										</div>
									</div>

									<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                                			<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                		<button class="btn btn-primary pull-right" @click.prevent="registrarProduccionYDescontarMolduras">Registrar Producci&oacute;n y Surtir Molduras</button>
                                	</div>
								</div>
								
                            </div>
						</div>

						<hr>
						
<!-- 						O P C I O N   S U R T I R -->		

						<div v-show="isMoldura || (isMaquilaMoldura && !molIsScrap)" class="panel panel-info">
                        	<div class="panel-heading">
                        		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                            	<h3 v-show="!(isMaquilaMoldura && !molIsScrap)">Surtir Mercancia de Scrap <span class="pull-right">No se toma mercancia de Stock</span></h3>
								<h3 v-show="(isMaquilaMoldura && !molIsScrap)">Maquilas <span></h3>
                            	
                            </div>
                            <div class="panel-body">
                            	<h3 v-if="isMoldura">Molduras Producidas de Scrap</h3>
        						<h3 v-if="isMaquilaMoldura">Maquila de Molduras</h3>
        						<div class="row">
        							<div v-if="isMoldura && !molIsScrap" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        									<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
        								<div class="form-group">
        									<label class="control-label" for="remision"><span v-show="!isMoldura">Molduras A Surtir</span><span v-show="isMoldura">L&aacute;minas a Tomar</span></label>
        									<input v-model="molCantidadSurtirScrap" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
        									<label  class="control-label pull-right" for="remision">Por Surtir: {{ totalPorDespachar }}</label>
        								</div>
        							</div>
        						</div>
        						
        						<!-- 						O P C I O N   S U R T I R -->						
        <!-- 						en INC.PHP solo manda llamar a darSalidaAInventarioFromStockNoRolloScrap y da salida solo a molduras, no  -->
        <!-- 						se maneja inventario -->
        						<div v-if="isMoldura && !molIsScrap" class="row">
                                	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                                			<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                		<button class="btn btn-primary " @click.prevent="descontarDeStockNoRolloScrap">Surtir Moldura de Scrap</button>
                                	</div>
                                </div>
                                
                                <!-- 						O P C I O N   S U R T I R -->                        
        <!--                         INC.PHP solo se marca en pedidodetalle -->                        
                                <div v-if="isMoldura && molIsScrap" class="row">
                                	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                                		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                		<button class="btn btn-primary " @click.prevent="marcarMaquilaRealizada">Marcar Molduras de Scrap como Realizadas</button>
                                	</div>
                                </div>
                                
                                <!-- 						O P C I O N   S U R T I R -->                        
        <!--                         INC.PHP solo se marca en pedidodetalle -->
                                <div v-if="isMaquilaMoldura && !molIsScrap" class="row">
                                		<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                                			<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
                                		<button class="btn btn-primary " @click.prevent="marcarMaquilaRealizada">Marcar Maquilas como Realizadas</button>
                                	</div>
                                </div>
        	    			</div>
                            </div>
                        </div>				
						
						
						

                        




<!-- 	    			FIN SACAR DE INVENTARIO -->

	    			<div v-if="detProductoDetalleDespachado" class="text-center text-navy">
	    				<hr>
	    				<h2>Producto Surtido</h2>
	    			</div>
	    			<div v-if="totalPorDespachar == 0 && isParcial == 'SI'" class="text-center text-navy">
	    				<hr>
	    				<h2>Los Productos para esta Sucursal se han Surtido.</h2>
	    				<h4>Este Surtido es complemento de otra Sucursal.</h4>
	    			</div>
	    			<div v-else>
	    				<hr>
<!-- 	    				<div v-if="deDondeSeSaca == 'INVENTARIO'" class="text-center m-t-l" > -->
<!-- 		    				<button class="btn btn-success btn-lg" @click.prevent="darSalidaAInventario">Dar Salida a Inventario</button> -->
<!-- 		    			</div> -->
		    			<div v-if="deDondeSeSaca == 'ROLLO'" class="text-center m-t-l" >
		    					<?php if ($debugRenglones && Permisos::userIsThisRol(Permisos::$rol_ROOT))  echo "row: {".__LINE__."}"; ?>
		    				<button class="btn btn-success btn-lg" @click.prevent="marcarComoDespachado">Marcar como Surtido</button>
		    			</div>
	    			</div>




	    			<div class="clearfix"></div>

	    		</div>
	    		<div v-show="!despachandoAlgo">Seleccione Producto</div>

	    	</div>
	    </div>
	</div>



</div>


<?php

if (Permisos::userIsThisRol(Permisos::$idROOTUSER))
{

echo "<pre>{{ \$data  }}</pre>";

}

?>