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

?>



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
					<a href="#" class="product-name"> {{ pd.codigo }}</a>
					<div class=" m-t-xs">
						{{ pd.fullName }}
					</div>
					<div class="small m-t-xs">
						<i>
							{{ pd.unidad }}
						</i>

					</div>

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
<!-- 	    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 		    				<h1 class="text-navy">{{ proCodigo }}</h2> -->
<!-- 		    			</div> -->
		    			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    				<h2 style="padding-top: 5px;">{{ detPartida }} <span class='text-navy' style="font-size: 28px;">{{ proCodigo }}</span> {{ proFullname }}</h3>
		    			</div>
	    			</div>
	    			<div v-if="!detProductoDetalleDespachado && !isMoldura && !isMaquilaMoldura" class="alert alert-info">
                        Se descontar&aacute;n <strong>{{ queSeSaca }} </strong> de <strong>{{ deDondeSeSaca }} </strong> para este producto.
                    </div>
                    
                    <div v-if="!detProductoDetalleDespachado && isMoldura && !isMaquilaMoldura && !molIsScrap" class="alert alert-info">
                        Las <strong>Molduras</strong> se surten a partir de <strong>L&aacute;minas Lisas del Calibre, Material y Pies</strong> que se ha especificado. As&iacute; mismo, pueden ser desarrolladas mediante <strong>Scrap</strong> . 
                    </div>
                    
                    <div v-if="!detProductoDetalleDespachado && isMoldura && !isMaquilaMoldura && molIsScrap" class="alert alert-info">
                        Estas <strong>Molduras</strong> se realizan solo de <strong>Scrap</strong> . 
                    </div>
                    
                    <div v-if="!detProductoDetalleDespachado && !isMoldura && isMaquilaMoldura" class="alert alert-info">
                        Las <strong>Maquilas NO</strong> se surten, solo se marcan como <strong> Realizadas</strong> . 
                    </div>

	    			<div class="row m-t">
	    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	    					<h4>Cantidad <span v-if="deDondeSeSaca == 'ROLLO'">estimada</span> a Surtir:&nbsp;<strong style="font-size: 24px;"> {{ totalExplotar }}</strong></h4>
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

<!-- 	    			SACAR DE ROLLOS -->

	    			<div v-if="deDondeSeSaca == 'ROLLO' && !detProductoDetalleDespachado">
	    				<hr>
	    				<button type="button" class="btn btn-primary m-b" @click.prevent="showModalNoRollos">
<!-- 	    				 data-toggle="modal" data-target="#modalNoRollos" -->
                            Seleccionar No Rollo
                        </button>
                        <div class="row">
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

	    			<div v-if="deDondeSeSaca == 'INVENTARIO' && !detProductoDetalleDespachado">
	    				<hr>
	    				
	    				<div v-if="!molIsScrap && !detProductoDetalleDespachado && isMoldura && !isMaquilaMoldura && molIdProductoLisa == 0" class="alert alert-warning">
                            No existe un Producto de Aplicaci&oacute;n LISA, con las especificaciones de la Moldura para descontar, solo podr&aacute; Surtir indicando que tom&oacute; <strong> Scrap</strong>.
                        </div>
	    				
	    				<button v-show="!isMoldura && !isMaquilaMoldura" type="button" class="btn btn-primary m-b" @click.prevent="showModalStockNoRollos">
<!-- 	    				 data-toggle="modal" data-target="#modalNoRollos" -->
                            Seleccionar Stock
                        </button>
                        

<!-- 						O P C I O N   S U R T I R -->

                        <div v-show="isMoldura && molIdProductoLisa != 0">
                        
                        	
                        	<h3>L&aacute;mina a Utilizar</h3>
                        	<div class="row">
                        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		    				<h2 style="padding-top: 5px;"><span class='text-navy' style="font-size: 24px;">{{ molCodigoLisa }}</span> {{ molDescripcionLisa }}</h3>
        		    			</div>
                        	</div>
                        	<div class="row">
                        		<button v-show="isMoldura" type="button" class="btn btn-primary m-b" @click.prevent="showModalStockNoRollosParaMoldura">
        <!-- 	    				 data-toggle="modal" data-target="#modalNoRollos" -->
                                    Seleccionar Stock de L&aacute;mina Lisa
                                </button>
                        	</div>
                        	<hr>
                            
                        </div>
                        
<!-- 						O P C I O N   S U R T I R -->
                        
                        <div  v-show="(!isMoldura && !isMaquilaMoldura) || (isMoldura && molIdProductoLisa != 0)"  class="row">
							<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision"># Rollo</label>
									<h4><strong style="font-size: 24px;">{{ stockNoRollo }}</strong></h4>
								</div>
							</div>
							<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision">Existencia</label>
									<h4><strong style="font-size: 24px;">{{ stockNoRolloExistencia }}</strong></h4>
								</div>	
							</div>
							<div v-if="stockNoRollo != ''" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision"><span v-show="!isMoldura">Cantidad</span><span v-show="isMoldura">L&aacute;minas a Tomar</span></label>
									<input v-model="stockNoRolloCantidadSacar" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
									<label v-show="isMoldura && molLaminasATomar > 0" class="control-label" for="remision">Se deben utilizar: {{ molLaminasATomar }}</label>
									<label v-show="!isMoldura" class="control-label" for="remision">Por Surtir: {{ totalPorDespachar }}</label>
								</div>
							</div>
							<div v-if="stockNoRollo != '' && isMoldura" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
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
                        
                        <div v-if="stockNoRollo != ''" class="row">
                        	<div v-show="!isMoldura && !isMaquilaMoldura" class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                        		<button class="btn btn-primary pull-right" @click.prevent="descontarDeStockNoRollo">Surtir de este Stock No Rollo</button>
                        	</div>
                        	
                        	<div v-show="isMoldura && !isMaquilaMoldura" class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                        		<button class="btn btn-primary pull-right" @click.prevent="descontarDeStockNoRolloLaminaYScrap">Descontar L&aacute;minas y Surtir Molduras</button>
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
						
<!-- 						O P C I O N   S U R T I R -->						
						
						<h3 v-if="isMoldura">Molduras Producidas de Scrap</h3>
						<h3 v-if="isMaquilaMoldura">Maquila de Molduras</h3>
						<div class="row">
							<div v-if="isMoldura && !molIsScrap" class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="control-label" for="remision"><span v-show="!isMoldura">Molduras A Surtir</span><span v-show="isMoldura">L&aacute;minas a Tomar</span></label>
									<input v-model="molCantidadSurtirScrap" type="text" class="form-control text-right" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength='8'>
									<label  class="control-label pull-right" for="remision">Por Surtir: {{ totalPorDespachar }}</label>
								</div>
							</div>
						</div>
						
<!-- 						O P C I O N   S U R T I R -->						
						
						<div v-if="isMoldura && !molIsScrap" class="row">
                        	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                        		<button class="btn btn-primary " @click.prevent="descontarDeStockNoRolloScrap">Surtir Moldura de Scrap</button>
                        	</div>
                        </div>
                        
<!-- 						O P C I O N   S U R T I R -->                        
                        
                        <div v-if="isMaquilaMoldura && !molIsScrap" class="row">
                        	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                        		<button class="btn btn-primary " @click.prevent="marcarMaquilaRealizada">Marcar Maquilas como Realizadas</button>
                        	</div>
                        </div>

<!-- 						O P C I O N   S U R T I R -->                        
                        
                        <div v-if="isMoldura && molIsScrap" class="row">
                        	<div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                        		<button class="btn btn-primary " @click.prevent="marcarMaquilaRealizada">Marcar Molduras de Scrap como Realizadas</button>
                        	</div>
                        </div>
	    			</div>

<!-- 	    			FIN SACAR DE INVENTARIO -->

	    			<div v-if="detProductoDetalleDespachado" class="text-center text-navy">
	    				<hr>
	    				<h2>Producto Surtido</h2>
	    			</div>
	    			<div v-else>
	    				<hr>
<!-- 	    				<div v-if="deDondeSeSaca == 'INVENTARIO'" class="text-center m-t-l" > -->
<!-- 		    				<button class="btn btn-success btn-lg" @click.prevent="darSalidaAInventario">Dar Salida a Inventario</button> -->
<!-- 		    			</div> -->
		    			<div v-if="deDondeSeSaca == 'ROLLO'" class="text-center m-t-l" >
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

<!-- <pre>{{ $data }}</pre> -->
<pre>{{ $data  }}</pre>