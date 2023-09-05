<?php
$titlePage = "Dashboard Pedidos";
$breadCum = "Promotor/Dashboard Pedidos";
$_lugar = LUGAR_PROMOTOR_DASHBOARDPEDIDOS;

?>



<div class="wrapper wrapper-content  animated fadeInRight">

    <div class="row m-xs-b">
        <div v-show="<?php echo $mostrarListado;?>">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <!-- <label class="control-label" for="promotor">Promotor</label> -->
                        <select id="selPromotor"  v-model="filtro.promotor" class="form-control">

                            <?php

                                echo $lstPromotores;

                            ?>
                        </select>
                    </div>
                </div>

        </div>
        <div v-show="!<?php echo $mostrarListado;?>">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <h3><?php echo $nombrePromotor; ?></h3>
            </div>

        </div>
        <div>
            <button @click.prevent="cargarDatos" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Pedidos en Producci&oacute;n</h3>
                    <span class="badge badge-primary">Cliente Recoge</span>
                    <span class="badge badge-warning">Se entrega al Cliente</span>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">

                                <li v-for="item in pedidosproduccion1" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i class="fa fa-tag"></i> {{ item.id }} <strong v-show="item.saldada == 'NO'"><span class="text-danger"> NO Saldada</span></strong>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">
                                <li v-for="item in pedidosproduccion2" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i class="fa fa-tag"></i> {{ item.id }} <strong v-show="item.saldada == 'NO'"><span class="text-danger"> NO Saldada</span></strong>
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
                    <h3>Pedidos Terminados</h3>
                    <span class="badge badge-primary">Cliente Recoge</span>
                    <span class="badge badge-warning">Se entrega al Cliente</span>

                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">

                                <li v-for="item in pedidosterminados1" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i class="fa fa-tag"></i> {{ item.id }} <strong v-show="item.saldada == 'NO'"><span class="text-danger"> NO Saldada</span></strong>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">
                                <li v-for="item in pedidosterminados2" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i class="fa fa-tag"></i> {{ item.id }} <strong v-show="item.saldada == 'NO'"><span class="text-danger"> NO Saldada</span></strong>
                                    </div>
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
                    <h3>Pedidos Entregados <small>Solo se muestran Entregados el d&iacute;a de hoy</small></h3>
                    <span class="badge badge-primary">Cliente Recoge</span>
                    <span class="badge badge-warning">Se entrega al Cliente</span>

                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">

                                <li v-for="item in pedidosentregados1" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i class="fa fa-tag"></i> {{ item.id }} <strong v-show="item.saldada == 'NO'"><span class="text-danger"> NO Saldada</span></strong>
                                    </div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="sortable-list connectList agile-list" id="todo">
                                <li v-for="item in pedidosentregados2" :class="(item.recogeentrega == 'ENTREGA' ? 'warning' : 'success') + '-element'" >
                                    {{ item.nombreCliente }}
                                    <div class="agile-detail">
                                        <a target="_blank" :href="'<?php echo URL_BASE?>pedidodetalleview/' + item.id" :class="'pull-right btn btn-xs btn-' + (item.recogeentrega == 'ENTREGA' ? 'warning' : 'primary')"><i class="fa fa-eye"></i></a>
                                        <i class="fa fa-tag"></i> {{ item.id }} <strong v-show="item.saldada == 'NO'"><span class="text-danger"> NO Saldada</span></strong>
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
