<?php
$titlePage = "Pedidos";
$breadCum = "Colocaci&oacute;n de Pedidos";

$_lugar = LUGAR_VENTAS_ASIGNARPEDIDO;

$_addScript="
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/peity/jquery.peity.min.js\"></script>
 		<script src=\"".URL_BASE."assets/inspinia/js/demo/peity-demo.js\"></script>
 		
            
 		";


// $_lugar = LUGAR_ADMINISTRACION_CONFIGURACION;


$buttonCustom = "
            
<button id='btnColocados' name='btnColocados' class=\"btn btn-primary right-sidebar-toggle\">
                        <i class=\"fa fa-tasks\"> Reasignar Pedidos</i>
                    </button>
";

?>


<div class="row">
			<div class="col-sm-3 m-b-xs">
				<div class="input-group">
					<input type="text" class="form-control "
						v-model="idPedidoFiltro"
						placeholder="Filtrar Pedido"
						oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
						maxlength='8'>

				</div>
			</div>



		</div>


<div id="wrapper">
<!-- <a href="https://www.google.com/maps?q=astro+205+cosmos" target="_blank">aqui</a> -->

<!-- <iframe  
src="https://www.google.com/maps/embed?s=LAS AMALIAS LEON GUANAJUATO" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->

<!--  <iframe src="https://www.google.com/ma    ps?q=LOS+OLIVOS" height="450" width="600"></iframe>  -->

<!-- <iframe 
src="https://www.google.com/maps/embed?q=LOS OLIVOS LEON GUANAJUATO" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

<iframe src="http://maps.google.com/?q=LOS OLIVOS" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
-->

<!-- <div v-show="seleccionarPedido"> -->
<!-- 	<h2 class="m-l">No. Pedido:</h2> -->
<!-- 	<div class="col-sm-3 m-b-xs"> -->
<!-- 	 	<div class="input-group"> -->
<!-- 	 		<input type="text" class="form-control input-lg" -->
<!-- 	 		v-model="idPedido" -->
<!-- 	 		v-on:keypress.enter="cargarDatosPedido" -->
<!-- 			oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" -->
<!-- 			maxlength='8'> -->
<!-- 			<span class="input-group-btn">  -->
<!-- 				<button @click.prevent="cargarDatosPedido" -->
<!-- 					class="btn btn-primary btn-lg " type="button"> -->
<!-- 					<i class="fa fa-check"></i><span class="bold"></span> -->
<!-- 				</button>		                		  -->
<!-- 			</span> -->
<!-- 	 	</div> -->
<!-- 	 </div> -->
			          
	
	
<!-- </div> -->




<div >

		

		<!-- 	<button class="btn btn-warning" @click.prevent="seleccionarOtroPedido">Seleccionar otro Pedido</button>  -->
<!-- 	<br> -->
<!-- 	<br> -->

	<div class="row">
		
		<div  class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="">
				<div class="">
				
					<div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Por Colocar  <span v-show="pedidosPorColocar.length > 0" class="badge badge-success">{{ pedidosPorColocar.length }}</span></a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Sin Material <span v-show="pedidosSinMaterial.length > 0" class="badge badge-warning">{{ pedidosSinMaterial.length }}</span></a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">No Explosionados <span v-show="pedidosNoExplotados.length > 0" class="badge badge-danger">{{ pedidosNoExplotados.length }}</span></a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">Sin Definir Fecha Entrega <span v-show="pedidosPorColocarFechaEntregaPorDefinir.length > 0" class="badge badge-danger">{{ pedidosPorColocarFechaEntregaPorDefinir.length }}</span></a></li>
                            <li class=""><a data-toggle="tab" href="#tab-5">Colocados Automatico <span v-show="pedidosColocadosAutomaticoFiltrados.length > 0" class="badge badge-primary">{{ pedidosColocadosAutomaticoFiltrados.length }}</span></a></li>
                        </ul>
                        <div class="tab-content"> 
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <ul class="sortable-list connectList agile-list" id="todo">

                						<li v-for="item in pedidosPorColocar"
                							:class="(item.idPedido == idPedido ? 'success' : 'warning') + '-element'">
                							{{ item.nombreCliente }}
                							<br>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span>
                							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span>
                														
                							<div class="agile-detail">
                								<button
                								 v-show="(item.explotado == 'SI' && item.explotadook == 'SI') || (item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' )"
                								 class="pull-right btn btn-xs btn-primary"
                								 @click.prevent="cargarPedido(item.idPedido)"><i class="fa fa-sliders"></i></button>
                								<i class="fa fa-tag"></i> {{ item.idPedido }} 
                							</div>
                						</li>
                
                
                					</ul>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <ul class="sortable-list connectList agile-list" id="todo">

                						<li v-for="item in pedidosSinMaterial"
                							:class="(item.idPedido == idPedido ? 'success' : 'warning') + '-element'">
                							{{ item.nombreCliente }}
                							<br>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span>
                							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span>
                														
                							<div class="agile-detail">
                								<button                								 
                								 class="pull-right btn btn-xs btn-primary"
                								 @click.prevent="cargarPedidoSoloMostrar(item.idPedido)"><i class="fa fa-eye"></i></button>
                								<i class="fa fa-tag"></i> {{ item.idPedido }} 
                							</div>
                						</li>
                
                
                					</ul>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <ul class="sortable-list connectList agile-list" id="todo">

                						<li v-for="item in pedidosNoExplotados"
                							:class="(item.idPedido == idPedido ? 'success' : 'warning') + '-element'">
                							{{ item.nombreCliente }}
                							<br>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span>
                							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span>
                														
                							<div class="agile-detail">
                								<button                								 
                								 class="pull-right btn btn-xs btn-primary"
                								 @click.prevent="cargarPedidoSoloMostrar(item.idPedido)"><i class="fa fa-eye"></i></button>
                								<i class="fa fa-tag"></i> {{ item.idPedido }} 
                							</div>
                						</li>
                
                
                					</ul>
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <ul class="sortable-list connectList agile-list" id="todo">

                						<li v-for="item in pedidosPorColocarFechaEntregaPorDefinir"
                							:class="(item.idPedido == idPedido ? 'success' : 'warning') + '-element'">
                							{{ item.nombreCliente }}
                							<br>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span>
                							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span>
                							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span>
                														
                							<div class="agile-detail">
                								<button                								 
                								 class="pull-right btn btn-xs btn-primary"
                								 @click.prevent="cargarPedidoSoloMostrar(item.idPedido)"><i class="fa fa-eye"></i></button>
                								<i class="fa fa-tag"></i> {{ item.idPedido }} 
                							</div>
                						</li>
                
                
                					</ul>
                                </div>
                            </div>
                            <div id="tab-5" class="tab-pane">
                                <div class="panel-body">
                                    <ul class="sortable-list connectList agile-list" id="todo">

                						<li v-for="(item,index) in pedidosColocadosAutomaticoFiltrados"
                							:class="(item.idPedido == idPedido ? 'success' : 'warning') + '-element'">
                							{{ item.nombreCliente }}
                							<br>
<!--                 							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span> -->
<!--                 							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span> -->
<!--                 							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span> -->
<!--                 							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span> -->
                														
                							<div class="agile-detail">
                								<button v-if="item.estado == 'AUTORIZADO'"               								 
                								 class="pull-right btn btn-xs btn-danger"
                								 @click.prevent="reAsignarPedidoAutomatico(item.idPedido, index)"><i class="fa fa-refresh"></i></button>
                								 <button                								 
                								 class="pull-right btn btn-xs btn-primary"
                								 @click.prevent="cargarPedidoSoloMostrar(item.idPedido)"><i class="fa fa-eye"></i></button>
                								 
                								<i class="fa fa-tag"></i> {{ item.idPedido }} <span class="small">{{item.estado}}</span>
                								
                							</div>
                						</li>
                
                
                					</ul>
                                </div>
                            </div>
                        </div>


                    </div>
				
				
				
<!-- 					<h3>Pedidos sin Colocar</h3> -->


<!-- 					<ul class="sortable-list connectList agile-list" id="todo"> -->

<!-- 						<li v-for="item in pedidos" -->
<!-- 							:class="(item.idPedido == idPedido ? 'success' : 'warning') + '-element'"> -->
<!-- 							{{ item.nombreCliente }} -->
<!-- 							<br> -->
<!-- 							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span> -->
<!-- 							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span> -->
<!-- 							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span> -->
<!-- 							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span> -->
														
<!-- 							<div class="agile-detail"> -->
<!-- 								<button -->
<!-- 								 v-show="(item.explotado == 'SI' && item.explotadook == 'SI') || (item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' )" -->
<!-- 								 class="pull-right btn btn-xs btn-primary" -->
<!-- 								 @click.prevent="cargarPedido(item.idPedido)"><i class="fa fa-sliders"></i></button> -->
<!-- 								<i class="fa fa-tag"></i> {{ item.idPedido }}  -->
<!-- 							</div> -->
<!-- 						</li> -->


<!-- 					</ul> -->

				</div>
			</div>
		</div>
		
		<div v-show="idPedido == 0"  class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
			Seleccione un Pedido para Asignar Sucursal	
		</div>
		<div v-show="idPedido > 0"  class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="ibox">
                    <div class="ibox-content p-xl">
                    		
                            <div class="row">
                                <div class="col-sm-3">
                                    <h5>Cliente</h5>
                                    <address>
                                        <strong>{{ cteNombre }} {{ cteApellidos }}</strong><br>
                                        <strong>{{ cteEmpresa }}</strong><br>
                                        {{ cteDomicilio1 }} {{ cteDomicilio2 }}<br>
                                        {{ cteNumero }} {{ cteColonia }}<br>
                                        {{ cteCiudad }}<br>
                                        <abbr title="Phone"></abbr>{{ cteTelefonos }}<br>
                                        {{ cteEMail }}
                                    </address>
                                </div>
                                
                                <div class="col-sm-3">
                                    <h5>Atendido por</h5>
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" :src="promotorImage">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                {{ promoNombre }} {{ promoAPaterno }} {{ promoAMaterno }} 
                                            </a>
<!--                                             <small class="text-muted">Today 4:21 pm - 12.06.2014</small> -->
                                        </div>
                                    </div>  
                                          <br>      
                                          <br>                      
                                    <h5>Vendido por</h5>
                                    <div class="social-avatar">
                                        <a href="" class="pull-left">
                                            <img alt="image" :src="capturadoImage">
                                        </a>
                                        <div class="media-body">
                                            <a href="#">
                                                {{ capturadoPor }}
                                            </a>
<!--                                             <small class="text-muted">Today 4:21 pm - 12.06.2014</small> -->
                                        </div>
                                    </div>  
                                </div>

								<div class="col-sm-3">
                                	<span>Fecha Entrega: </span>
	                                <h5 v-show="fechaEntregaPorDefinir != 'SI'">{{ fechaEntrega }}</h5>
	                                <h5 v-show="fechaEntregaPorDefinir == 'SI'"> Por Definir</h5>
	                                <span>Fecha Abierta: </span>
	                                <h5>{{ fechaAbierta }}</h5>	                                
	                                
                                </div>    

                                <div class="col-sm-3 text-right">
                                    <h4>Pedido No.</h4>
                                    <h2 class="text-navy">{{ idPedido }}</h2>
                                    <h2 class="text-navy">{{ estado }}</h2>
                                    <h2 class="text-navy">{{ recogeentrega }} <small v-show="recogeentrega == 'OBRA'" class="text-navy">{{ tipoObra }}</small></h2>
                                    
                                    <div v-show="recogeentrega == 'ENTREGA' || recogeentrega == 'OBRA'">
                                    	<span>Consignacinaci&oacute;n:</span>
	                                    <address>
	                                        <strong>{{ personaEntrega }}</strong><br>
	                                        {{ domicilioEntrega }}<br>
	                                        {{ numeroEntrega }} {{ coloniaEntrega }}<br>
	                                        {{ ciudadEntrega }}<br>	                                        
	                                    </address>
	                                    
                                    </div>
                                    <div v-show="recogeentrega == 'RECOGE'">
                                    	<span>Preferentemente en:</span>
	                                    <address>
	                                        <h2 class="text-success" >{{ sucursalPreferente }}</h2>
	                                        	                                        
	                                    </address>
                                    </div>
                                    
                                    <p>
<!--                                     	<span><strong>Estatus Actual : </strong> {{ estado }}</span><br/> -->
<!--                                         <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br/> -->
<!--                                         <span><strong>Due Date:</strong> March 24, 2014</span> -->
                                    </p>
                                </div>
                            </div>
                            
    					<?php 
                            foreach ($lstSucursales as $suc)
                            {
                                echo "<button v-show='sePuedeAsignar' class='btn btn-primary m-l' @click.prevent='asignarTodoA(".$suc["idSucursal"].")'>Asignar todo a ".$suc["nombre"]."</button>";
                            }
                            
                        ?> 
                        
					<br>
					<br>

					<ul class="list-group">
						<li class="list-group-item" v-for="(item, index) in productos">
							<p style="font-size: 120%">
								<a class="text-info" href="#">{{ item.codigo }}</a> {{
								item.proDescripcion }} 
								
									<span v-show="item.sesacade == 'ROLLO'" class="pull-right label label-info m-l" style="font-size: 120%">
										{{ formatNumber(item.pesokiloml * item.detPartida * item.detCantidadReal) }} KG
									</span>
								
									<span class="pull-right label label-primary" style="font-size: 120%">
										{{ item.detPartida }} PZAS 
									</span>
									
									
									
							</p>
							
							<div v-show="item.molidproductolisa > 0 && item.detIdProducto == 9" class="alert alert-info">
								Para esta Moldura se ocupar&aacute;n 
								<strong>{{ item.molLaminasATomar }}</strong> 
								{{ item.molcodigolisa }}<a class="alert-link" href="#"> {{ item.moldescripcionlisa }}</a>.
								<br>
								<div v-show="item.inventarioinformativo.length > 0" class="row">
									<div class="col-sm-2">
									</div>
									<div class="col-sm-5">
                                        <h3>Existencias <strong>{{ item.molcodigolisa }}</strong></h3>                                        
                                        <ul class="clear-list">
                                            <li class="" v-for="invinfo in item.inventarioinformativo">
                                                <span class="pull-right">
                                                    <strong>{{ invinfo.inventarioexistencia }} PZAS</strong>
                                                </span>
                                                {{ invinfo.nombre }}
                                            </li>                                            
                                        </ul>
                                    </div>
								</div>
								
                                <div class="clearfix"></div>
                            </div>
                            
                            <div v-show="item.molidproductolisa == 0 && item.detIdProducto == 9" class="alert alert-warning">
								Para esta Moldura no se cuenta con L&aacute;minas Lisas
								<br>
								<div v-show="item.inventarioinformativo.length > 0" class="row">
									<div class="col-sm-2">
									</div>
									<div class="col-sm-5">
                                        <h3>Existencias Rollo <strong>{{ item.molcodigorollo }}</strong></h3>                                        
                                        <ul class="clear-list">
                                            <li class="" v-for="invinfo in item.inventarioinformativo">
                                                <span class="pull-right">
                                                    <strong>{{ invinfo.inventarioexistencia }} KG</strong>
                                                </span>
                                                {{ invinfo.nombre }}
                                            </li>                                            
                                        </ul>
                                    </div>
								</div>
								
                                <div class="clearfix"></div>
                            </div>

							<div v-show="item.inventariosucursal.length > 0"  class="row">
								<div class="col-lg-1"></div>
								<div class="col-lg-10">
									<div class="panel panel-info">
                                        <div class="panel-heading">
                                            Asignar Sucursal
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-hover">
        										<thead>
        											<tr>
        												<th>Sucursal</th>
        												<th v-show="item.detIdProducto != 9 && item.detIdProducto != 10">
        													Existencia
        													<span v-show="item.sesacade == 'INVENTARIO'"> PZAS</span>
        												    <span v-show="item.sesacade == 'ROLLO'"> KG</span>
        												</th>
        												<th v-show="sePuedeAsignar && item.sesacade == 'INVENTARIO' && item.detIdProducto != 9 && item.detIdProducto != 10">Apartado</th>
        												<th v-show="sePuedeAsignar">Asignar</th>
        												<th v-show="sePuedeAsignar && item.sesacade == 'ROLLO'">Kilos</th>
        											</tr>
        										</thead>
        										<tbody>
        											<tr v-for="(invs, invsindex) in item.inventariosucursal">
        												<td>{{ invs.nombre }}</td>
        												<td  v-show="item.detIdProducto != 9 && item.detIdProducto != 10">{{ invs.inventarioexistencia }} 
        												    
        												</td>
        												<td v-show="sePuedeAsignar && item.sesacade == 'INVENTARIO'  && item.detIdProducto != 9 && item.detIdProducto != 10">{{ invs.inventarioapartado }}</td>
        												<td v-show="sePuedeAsignar"><input type="text"
        													v-model="invs.asignar"
        													oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1'); "
        													maxlength="9" class="form-control text-right"></td>
        												<td v-show="sePuedeAsignar && item.sesacade == 'ROLLO'">{{ formatNumber(item.pesokiloml * invs.asignar * item.detCantidadReal) }}</td>
        												
        											</tr>
        
        										</tbody>
        									</table>
        									<div v-show="sePuedeAsignar && item.errInventarioSucursal != ''" class="alert alert-danger">
                								{{ item.errInventarioSucursal }}
                                            </div>
                                        </div>

                                    </div>
									
								</div>
								<div class="col-lg-1"></div>
							</div> 
							
							
							
<!-- 							<small class="block text-muted"><i class="fa fa-clock-o"></i> -->
<!-- 								1 minuts ago</small> -->
						</li>

					</ul>

					<button v-show="sePuedeAsignar" type="button" class="btn btn-block btn-lg btn-primary" @click.prevent="asignarPedidoASucursal">Asignar Pedido a Sucursal</button>
					
					
                                </div><!-- /table-responsive -->
                                
                        </div>
                </div>
            </div>
	</div>

	
<div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-1">

                    <li class="active"><a data-toggle="tab" href="#tab-1">
                        Reasignaci&oacute;n de Pedidos
                    </a></li>
                    
                </ul>

                <div class="tab-content">


                    <div id="tab-1" class="tab-pane active">

                        <div class="sidebar-title">
<!--                             <h3> <i class="fa fa-comments-o"></i> Reasignaci&oacute;n de Pedidos</h3> -->
                            <small><i class="fa fa-tim"></i> Seleccione un Pedido para Reasignar.</small>
                        </div>

                        <div>
                        
                        	<ul class="sortable-list connectList agile-list" id="todo">

                						<li v-for="(item,index) in pedidosColocadosFiltrados"
                							:class="'danger-element'">
                							{{ item.nombreCliente }}
                							<br>
<!--                 							<span v-show="item.explotado == 'SI' && item.explotadook == 'SI' " class="badge badge-success">LISTO PRODUCIR COMPLETO</span> -->
<!--                 							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'SI' " class="badge badge-primary">LISTO PRODUCIR PARCIAL</span> -->
<!--                 							<span v-show="item.explotado == 'SI' && item.explotadook == 'NO' && item.puedeProducirse == 'NO' " class="badge badge-warning">A&Uacute;N NO PUEDE PRODUCIRSE</span> -->
<!--                 							<span v-show="item.explotado == 'NO' " class="badge badge-danger">NO EXPLOSIONADO</span> -->
                														
                							<div class="agile-detail">
                								<button               								 
                								 class="pull-right btn btn-xs btn-danger"
                								 @click.prevent="reAsignarPedido(item.idPedido, index)"><i class="fa fa-refresh"></i></button>
                								 <button                								 
                								 class="pull-right btn btn-xs btn-primary"
                								 @click.prevent="cargarPedidoSoloMostrar(item.idPedido)"><i class="fa fa-eye"></i></button>
                								 
                								<i class="fa fa-tag"></i> {{ item.idPedido }} <span class="small">{{item.estado}}</span>
                								
                							</div>
                						</li>
                
                
                					</ul>

<!--                             <div class="sidebar-message"> -->
<!--                                 <a href="#"> -->
<!--                                     <div class="pull-left text-center"> -->
<!--                                         <img alt="image" class="img-circle message-avatar" src="img/a1.jpg"> -->

<!--                                         <div class="m-t-xs"> -->
<!--                                             <i class="fa fa-star text-warning"></i> -->
<!--                                             <i class="fa fa-star text-warning"></i> -->
<!--                                         </div> -->
<!--                                     </div> -->
<!--                                     <div class="media-body"> -->

<!--                                         There are many variations of passages of Lorem Ipsum available. -->
<!--                                         <br> -->
<!--                                         <small class="text-muted">Today 4:21 pm</small> -->
<!--                                     </div> -->
<!--                                 </a> -->
<!--                             </div> -->
                            

                    </div>

                    

                </div>

            </div>



        </div>
 </div>
	


</div>

<?php if (Permisos::userIsThisRol(Permisos::$rol_ROOT) ): ?>
	<pre>{{ $data }}</pre> 	
<?php endif; ?>
