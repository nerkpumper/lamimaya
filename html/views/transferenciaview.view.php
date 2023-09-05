<?php
$titlePage = "Visor Transferencia";
$breadCum = "Productos/Transferencias";

$buttonAction = "Regresar a Transferencias/frRegresarATransferencias";

$_lugar = LUGAR_PRODUCTOS_TRANSFERENCIAROLLOS;


?>


<!-- <pre>{{ $data.rollosOrigen }}</pre> -->
<!-- <pre>{{ $data.rollosDestino }}</pre> -->

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
            <div class="ibox-title">
                <h2>Transferencia <strong>{{ idTransferencia }}</strong> por <strong>{{ generadaPor }}</strong></h2>
            </div>
			<div class="ibox-content">
				
                <div class="row">

                    
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>Origen</h3>
                            </div>
                            <div class="col-lg-10">
                                <h2>{{ almacenOrigen }}</h2>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>Destino</h3>
                            </div>
                            <div class="col-lg-10">
                                <h2>{{ almacenDestino }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

            <hr>

            <!-- transferencia -->
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <h2>Estatus: <strong>{{ estatus }}</strong></h2>
                        <h3 v-show="aceptadaPor">Aceptada por <strong>{{ aceptadaPor }}</strong></h3>
                        <div class="panel-heading">
                            Rollos en la transferencia
                        </div>
                        <div class="panel-body">
                        <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>Remisi&oacute;n</th>
                                        <th>Rollo</th>
                                        <th>Material</th>
                                        <th>Existencia</th>
                                        <!-- <th></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(r, index) in rollos">
                                        <td>{{ r.remision }}</td>
                                        <td>{{ r.norollo }}</td>
                                        <td>{{ r.rollo }}</td>
                                        <td>{{ r.existencia }}</td>
                                        <!-- <td><button @click.prevent="removeFromTarget(r.index, index)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td> -->
                                        
                                    </tr>
                                
                                </tbody>
                            </table>
                            
                        </div>
                        
                    </div>
                    <button @click.prevent="tryAceptaTransferencia" v-show="rollos.length > 0 && estatus == 'CREADA'" class="btn btn-primary pull-right">Aceptar Transferencia</button>
                </div>
            </div>
            <!-- fin transferencia -->


			</div>
		</div>
	</div>
</div>






