<?php
$titlePage = "Transferencia de Rollos entre Almacenes";
$breadCum = "Productos/Transferencias";

$_lugar = LUGAR_PRODUCTOS_TRANSFERENCIAROLLOS;


?>


<!-- <pre>{{ $data.rollosOrigen }}</pre> -->
<!-- <pre>{{ $data.rollosDestino }}</pre> -->

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
            <div class="ibox-title">
                <h2>Almacénes</h2>
            </div>
			<div class="ibox-content">
				
                <div class="row">

                    
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>Origen</h3>
                            </div>
                            <div class="col-lg-10">
                                <select :disabled="almacenOrigen != 'SN'" class="form-control m-b" v-model="almacenOrigen">
                                    <option value="SN" select>-- Seleccione Origen</option>                                
                                    <option value="ALMACEN PRINCIPAL" select>Almacen Principal</option>
                                    <option value="MCM" select>MCM</option>
                                    <option value="ALPES" select>ALPES</option>
                                    <option value="CASA" select>CASA</option>
                                    <option value="NARCISO" select>NARCISO</option>
                                    <option value="DELTA" select>DELTA</option>
                                    <!-- <option value="OBRA" select>OBRA</option> -->
                                    <option value="LAGOS" select>LAGOS</option>
                                </select>
                                <button @click.prevent="cambiarOrigen" v-show="almacenOrigen != 'SN'" class="btn btn-warning btn-block">Cambiar Origen</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>Destino</h3>
                            </div>
                            <div class="col-lg-10">
                                <select :disabled="almacenOrigen == 'SN'" class="form-control m-b" v-model="almacenDestino">
                                    <option value="SN" select>-- Seleccione Destino</option>                                
                                    <option v-show="almacenOrigen != 'ALMACEN PRINCIPAL'" value="ALMACEN PRINCIPAL" select>Almacen Principal</option>
                                    <option v-show="almacenOrigen != 'MCM'" value="MCM" select>MCM</option>
                                    <option v-show="almacenOrigen != 'ALPES'" value="ALPES" select>ALPES</option>
                                    <option v-show="almacenOrigen != 'CASA'" value="CASA" select>CASA</option>
                                    <option v-show="almacenOrigen != 'NARCISO'" value="NARCISO" select>NARCISO</option>
                                    <option v-show="almacenOrigen != 'DELTA'" value="DELTA" select>DELTA</option>
                                    <!-- <option v-show="almacenOrigen != 'OBRA'" value="OBRA" select>OBRA</option> -->
                                    <option v-show="almacenOrigen != 'LAGOS'" value="LAGOS" select>LAGOS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            <hr>

            <!-- transferencia -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Origen
                        </div>
                        <div class="panel-body">
                            <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-search"></i></span> <input type="text" placeholder="remisión o rollo" v-model="filtroRollo" class="form-control"></div>
                            <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>Remisi&oacute;n</th>
                                        <th>Rollo</th>
                                        <th>Material</th>
                                        <th>Existencia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(r, index) in rollosOrigenFiltered" v-show="!r.added">
                                        <td>{{ r.remision }}</td>
                                        <td>{{ r.norollo }}</td>
                                        <td>{{ r.rollo }}</td>
                                        <td>{{ r.existencia }}</td>
                                        <td><button @click.prevent="addToTarget(r.idRemisionRollo)" class="btn btn-primary btn-xs"><i class="fa fa-arrow-right"></i></button></td>
                                        
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Destino
                        </div>
                        <div class="panel-body">
                        <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>Remisi&oacute;n</th>
                                        <th>Rollo</th>
                                        <th>Material</th>
                                        <th>Existencia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(r, index) in rollosDestino">
                                        <td>{{ r.remision }}</td>
                                        <td>{{ r.norollo }}</td>
                                        <td>{{ r.rollo }}</td>
                                        <td>{{ r.existencia }}</td>
                                        <td><button @click.prevent="removeFromTarget(r.idRemisionRollo, index)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
                                        
                                    </tr>
                                
                                </tbody>
                            </table>
                            
                        </div>
                        
                    </div>
                    <button @click.prevent="tryGenerarTransferencia" v-show="rollosDestino.length > 0" class="btn btn-primary pull-right">Generar Transferencia</button>
                </div>
            </div>
            <!-- fin transferencia -->


			</div>
		</div>
	</div>
</div>






