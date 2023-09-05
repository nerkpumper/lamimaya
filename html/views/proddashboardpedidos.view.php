<?php
$titlePage = "Dashboard Pedidos";
$breadCum = "Pedidos/Dashboard Pedidos  ";
$_lugar = LUGAR_VENTAS_DASHBOARDPEDIDOS;

?>



<div class="wrapper wrapper-content  animated fadeInRight">

<div class="row m-xs-b">
        <div v-show="<?php echo $mostrarListado;?>">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <!-- <label class="control-label" for="promotor">Promotor</label> -->
                        <select class="form-control" v-model="sucursalSeleccionada">
						<option v-for="s in lstSucursales" :value="s.nombre">{{ s.nombre }}</option>
					</select> 
                    </div>
                </div>

        </div>
        <div>
            <button @click.prevent="cargarDatos" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
        </div>
    </div>

	<div v-show="mostrarEspera">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h1><strong> Pedidos en Producci&oacute;n</strong></h1>
                    <span class="badge badge-primary">Cliente Recoge</span>
                    <span class="badge badge-warning">Se entrega al Cliente</span>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">

                                <li v-for="item in pedidosproduccion1" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <h1><strong>{{ item.id }}</strong> </h1>
                                    <h4 class="text-success"> {{item.promotor}} </h4>
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i v-show ="item.recogeentrega=='ENTREGA'" class="fa fa-truck"></i>
                                        <i v-show ="item.recogeentrega=='RECOGE'" class="fa fa-tag"></i>
                                        <strong><span v-show="item.recogeentrega=='ENTREGA'" class="text-warning"> {{ item.recogeentrega}} </span></strong>
                                       <strong><span v-show="item.recogeentrega=='RECOGE'" class="text-info">{{ item.recogeentrega}} </span></strong>
                                        <strong><span v-show="item.saldada == 'NO'" class="text-danger"> NO Saldada</span></strong>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">
                                <li v-for="item in pedidosproduccion2" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                        {{ item.nombreCliente }}
                                    <h1><strong>{{ item.id }} </strong> </h1>
                                    <h4 class="text-success"> {{item.promotor}} </h4>
                                    <div class="agile-detail">
                                    <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i v-show ="item.recogeentrega=='ENTREGA'" class="fa fa-truck"></i>
                                        <i v-show ="item.recogeentrega=='RECOGE'" class="fa fa-tag"></i>
                                        <strong><span v-show="item.recogeentrega=='ENTREGA'" class="text-warning"> {{ item.recogeentrega}} </span></strong>
                                       <strong><span v-show="item.recogeentrega=='RECOGE'" class="text-info">{{ item.recogeentrega}} </span></strong>
                                        <strong><span v-show="item.saldada == 'NO'" class="text-danger"> NO Saldada</span></strong>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div v-show="pedidosproduccion1.length == 0 && pedidosproduccion2.length == 0" class="alert alert-info">
                        No hay datos para mostrar
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h1><strong> Pedidos Terminados </strong></h1>
                    <span class="badge badge-primary">Cliente Recoge</span>
                    <span class="badge badge-warning">Se entrega al Cliente</span>

                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">

                                <li v-for="item in pedidosterminados1" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                        {{ item.nombreCliente }}
                                    <h1><strong>{{ item.id }}</strong> </h1>
                                    <h4 class="text-success"> {{item.promotor}} </h4>
                                    <div class="agile-detail">
                                        <i v-show ="item.recogeentrega=='ENTREGA'" class="fa fa-truck"></i>
                                        <i v-show ="item.recogeentrega=='RECOGE'" class="fa fa-tag"></i>
                                        <strong><span v-show="item.recogeentrega=='ENTREGA'" class="text-warning"> {{ item.recogeentrega}} </span></strong>
                                       <strong><span v-show="item.recogeentrega=='RECOGE'" class="text-info">{{ item.recogeentrega}} </span></strong>
                                        <strong><span v-show="item.saldada == 'NO'" class="text-danger"> NO Saldada</span></strong>
                                        <span><a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a></span>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">
                                <li v-for="item in pedidosterminados2" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                        {{ item.nombreCliente }}
                                    <h1><strong>{{ item.id }}</strong> </h1>
                                    <h4 class="text-success"> {{item.promotor}} </h4>
                                    <div class="agile-detail">
                                    <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i v-show ="item.recogeentrega=='ENTREGA'" class="fa fa-truck"></i>
                                        <i v-show ="item.recogeentrega=='RECOGE'" class="fa fa-tag"></i>
                                        <strong><span v-show="item.recogeentrega=='ENTREGA'" class="text-warning"> {{ item.recogeentrega}} </span></strong>
                                        <strong><span v-show="item.recogeentrega=='RECOGE'" class="text-info">{{ item.recogeentrega}} </span></strong>
                                        <span v-show="item.saldada == 'NO'" class="text-danger"> NO Saldada</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div v-show="pedidosterminados1.length == 0 && pedidosterminados2.length == 0" class="alert alert-info">
                        No hay datos para mostrar
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h1><strong> Pedidos Entregados </strong> <small>Solo se muestran Entregados el d&iacute;a de hoy</small></h1>
                    <span class="badge badge-primary">Cliente Recoge</span>
                    <span class="badge badge-warning">Se entrega al Cliente</span>

                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">

                                <li v-for="item in pedidosentregados1" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                        {{ item.nombreCliente }}
                                    <h1><strong>{{ item.id }}</strong> </h1>
                                    <h4 class="text-success"> {{item.promotor}} </h4>
                                    <div class="agile-detail">
                                    <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i v-show ="item.recogeentrega=='ENTREGA'" class="fa fa-truck"></i>
                                        <i v-show ="item.recogeentrega=='RECOGE'" class="fa fa-tag"></i>
                                        <strong><span v-show="item.recogeentrega=='ENTREGA'" class="text-warning"> {{ item.recogeentrega}} </span></strong>
                                       <strong><span v-show="item.recogeentrega=='RECOGE'" class="text-info">{{ item.recogeentrega}} </span></strong>
                                        <span v-show="item.saldada == 'NO'" class="text-danger"> NO Saldada</span>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">
                                <li v-for="item in pedidosentregados2" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                        {{ item.nombreCliente }}
                                    <h1><strong>{{ item.id }}</strong> </h1>
                                    <h4 class="text-success"> {{item.promotor}} </h4>
                                    <div class="agile-detail">
                                    <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i v-show ="item.recogeentrega=='ENTREGA'" class="fa fa-truck"></i>
                                        <i v-show ="item.recogeentrega=='RECOGE'" class="fa fa-tag"></i>
                                        <strong><span v-show="item.recogeentrega=='ENTREGA'" class="text-warning"> {{ item.recogeentrega}} </span></strong>
                                       <strong><span v-show="item.recogeentrega=='RECOGE'" class="text-info">{{ item.recogeentrega}} </span></strong>
                                       <span v-show="item.saldada == 'NO'" class="text-danger"> NO Saldada</span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div v-show="pedidosentregados1.length == 0 && pedidosentregados2.length == 0" class="alert alert-info">
                        No hay datos para mostrar
                    </div>
                </div>
            </div>
        </div>

    </div>



</div>

<!-- <pre>
    {{ $data.pedidosproduccion1 }}
</pre> -->
