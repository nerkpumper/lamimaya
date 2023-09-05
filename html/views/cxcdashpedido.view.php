<?php
$titlePage = "Autorización de Pedidos";
$breadCum = "CXC/Dashboard de Autorizaciones";
$_lugar = LUGAR_CXC_DASHAUTORIZACIONES;

?>

<button v-if="!seleccionandoCliente" class="btn btn-warning" @click.prevent="seleccionandoCliente = true"> Seleccionar otro cliente</button>

<!-- Buscar Cliente -->
<div v-show="seleccionandoCliente">

	<div v-show="idCliente > 0" >
		<button @click.prevent="dejarCliente" class="btn btn-warning">Conservar este Cliente</button>
		<div class="row m-b-lg m-t-lg">
			<div class="col-md-6">
				<h3>Cliente:</h3>
				<div class="profile-image">
					<img src="<?php echo URL_BASE;?>img/noimage.png"
						class="img-circle circle-border m-b-md" alt="profile">
				</div>
				<div class="profile-info">
					<div class="">
						<div>
							<h2 class="no-margins">{{ nombre }}</h2>
							<!-- <h4>{{ empresa }}</h4>
							<small> {{ domicilio1}} {{ domicilio2 }} </small> <br> <small> {{ telefonos }} </small> -->
						</div>
					</div>
				</div>
			</div>			

		</div>
	</div>


	<div class="panel-rec">		
		<h3>Buscar Cliente del siguiente Pedido</h3>
		<div class="row">
			<div class="col-sm-3 m-b-xs">
                <div class="input-group">
                    <input type="text" class="form-control " v-model="idPedido"
                        v-on:keypress.enter="cargarClienteDePedido"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                        maxlength='8'> <span class="input-group-btn">
                        <button @click.prevent="cargarClienteDePedido"
                            class="btn btn-primary " type="button">
                            <i class="fa fa-check"></i><span class="bold"></span>
                        </button>
                    </span>
                </div>
		    </div>
		</div>
		<hr>
		<h3>Seleccione Cliente</h3>
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<input type="text" class="form-control"	v-model="filtroNombreCliente"	 		
		 		placeholder="filtrar">
			</div>			
		</div>
		
		<br>
		<hr>
	
	
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				
				<tbody>
					<tr v-for="(cli, index) in clientesFiltradosPorNombre">
<!-- 						<td class="client-avatar"><img alt="image" src="img/a2.jpg"></td> -->
						<td>{{ cli.idCliente }}</td>
						<td><a data-toggle="tab" href="#contact-1" class="client-link">{{ cli.nombre }}</a></td>
						<td>{{ cli.empresa }}</td>
						<td class="contact-type">
							<i v-show="cli.email" class="fa fa-envelope"></i>
						</td>
						<td>{{ cli.email }}</td>
						<td class="contact-type"><i v-show="cli.telefonos" class="fa fa-phone"> </i></td>
						<td>{{ cli.telefonos }}</td>
						<td class="client-status"><button @click.prevent="seleccionarCliente(cli.idCliente)" class="btn btn-primary btn-xs">Seleccionar</button></td>
					</tr>					
<!-- 					<tr> -->
<!-- <!-- 						<td class="client-avatar"><img alt="image" src="img/a4.jpg"></td> --> 
<!-- 						<td><a data-toggle="tab" href="#contact-3" class="client-link">Lionel -->
<!-- 								Mcmillan</a></td> -->
<!-- 						<td>Et Industries</td> -->
<!-- 						<td class="contact-type"><i class="fa fa-phone"> </i></td> -->
<!-- 						<td>+432 955 908</td> -->
<!-- 						<td class="client-status"></td> -->
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	
</div>

<div v-show="!seleccionandoCliente">
    <div class="col-lg-9">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <!-- <a href="#" class="btn btn-white btn-xs pull-right">Edit project</a> -->
                                <h2>{{ nombre }}</h2>
                            </div>
                        
                        </div>
                    </div>
                    
                    <div class="row text-left">
                        <div class="col-xs-3">
                            <div class=" m-l-md">
                            <span class="h4 font-bold m-t block">$ {{ formatNumber(cteCredito) }}</span>
                            <small class="text-muted m-b block">Cr&eacute;dito</small>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <span class="h4 font-bold m-t block">$ {{ formatNumber(cteCapacidadPago) }}</span>
                            <small class="text-muted m-b block">Capacidad de Pago</small>
                        </div>
                        <div class="col-xs-3">
                            <span class="h4 font-bold m-t block">$ {{ formatNumber(disponibleRD) }}</span>
                            <small class="text-muted m-b block">Recibo Dinero Disponible</small>
                        </div>
                        <div class="col-xs-3">
                            <span class="h4 font-bold m-t block">$ {{ formatNumber(creditousado) }}</span>
                            <small class="text-muted m-b block">Saldo Total</small>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-10">
                            <dl class="dl-horizontal">
                                <dt>Cr&eacute;dito:</dt>
                                <dd>
                                    <div class="progress progress-striped active m-b-sm">
                                        <div :style="'width: ' + barcredito + '%;'" :class="'progress-bar ' + csscredito"></div>
                                    </div>
                                    <small>Project completed in <strong>{{ formatNumber(barcredito) }}%</strong>. Remaining close the project, sign a contract and invoice.</small>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-lg-10">
                            <dl class="dl-horizontal">
                                <dt>Capacidad de Pago:</dt>
                                <dd>
                                    <div class="progress progress-striped active m-b-sm">
                                        <div :style="'width: ' + barcapacidadpago + '%;'" :class="'progress-bar ' + csscapacidadpago"></div>
                                    </div>
                                    <small>Project completed in <strong>{{ formatNumber(barcapacidadpago) }}%</strong>. Remaining close the project, sign a contract and invoice.</small>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-lg-12">
                        <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Tracking de Pedidos</a></li>                                
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                        <div class="tab-content">
                        <div class="tab-pane active" id="tab-1">
                            
                          <h3>Filtrar Pedido</h3>
                            <div class="row">
                                <div class="col-sm-3 m-b-xs">
                                    <div class="input-group">
                                        <input type="text" class="form-control " v-model="idPedidoFilter"                                            
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                            maxlength='8'> <span class="input-group-btn">
                                            
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- timeline -->

                            <div v-show="trackingFiltrado.length <= 0 && tracking.length > 0">
                                <div class="alert alert-danger">No se ha encontrado informaci&oacute;n del Pedido solicitado</div>
                            </div>
                            <div v-show="tracking.length == 0">
                                <div class="alert alert-danger">No existe informaci&oacute;n de tracking de Pedidos.</div>
                            </div>
                            <!-- <div>
                            jjj
                                <div v-show="trackingFiltrado.length > 0">
                                    <div class="col-lg-12 m-b-lg">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Pedido</th>
                                                    <th>Fecha</th>
                                                    <th>Msg</th>                                            
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="track in trackingFiltrado">
                                                        <td>{{ track.idPedido }}</td>
                                                        <td>{{ track.fecha }}</td>
                                                        <td><i :class="getIconByTipo(track.tipo)"></i> {{ track.msg }}</td>
                                                        
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                             -->
                            <div v-show="trackingFiltrado.length > 0" class="well">
                            
                                <div >
                                    <div  class="col-lg-12 m-b-lg">
                                        <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                                        
                                            <div v-for="track in trackingFiltrado" class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon " :class="getClassByTipo(track.tipo)">
                                                    <i :class="getIconByTipo(track.tipo)"></i>
                                                </div>

                                                <div class="vertical-timeline-content">
                                                    <h2><small>Pedido: </small>{{ track.idPedido }}</h2>
                                                    <p>{{ track.msg }}
                                                    </p>
                                                    
                                                        <span class="vertical-date pull-right">
                                                    
                                                            <small>{{ track.fecha }}</small>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="clearfix"></div>     
                            </div>


                    </div>
                            <!-- fin timeline -->

                        </div>
                        
                        </div>

                        </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="wrapper wrapper-content project-manager">
            <h4>Pedidos</h4>
            <ul class="list-group clear-list m-t">
                <li class="list-group-item fist-item">
                    
                    <span class="label label-primary">{{ pedidostotal }}</span> <strong>Total Pedidos</strong>
                </li>
                <li class="list-group-item fist-item">
                    
                    <span class="label label-default">{{ pedidoscapturado }}</span> Capturados 
                </li>
                <li class="list-group-item fist-item">
                    
                    <span class="label label-info">{{ pedidosautorizado }}</span> Autorizados
                </li>
                <li class="list-group-item fist-item">
                    
                    <span class="label label-warning">{{ pedidosproduccion }}</span> En Producci&oacute;n
                </li>
                <li class="list-group-item fist-item">
                    
                    <span class="label label-danger">{{ pedidosterminado }}</span> Por Entregar
                </li>
                
            </ul>
        </div>
    </div>
</div>