<?php
$titlePage = "Transferencia de Stock entre Almacenes";
$breadCum = "Productos/Transferencias";

$_lugar = LUGAR_PRODUCTOS_TRANSFERENCIASTOCK;


?>


<!-- <pre>{{ $data.rollosOrigen }}</pre> -->
<!-- <pre>{{ $data.rollosDestino }}</pre> -->

<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
            <div class="ibox-title">
                <h2>Sucursales</h2>
            </div>
			<div class="ibox-content">
				
                <div class="row">

                    
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>Origen</h3>
                            </div>
                            <div class="col-lg-10">
                                <select :disabled="sucursalOrigen != 0" class="form-control m-b" v-model="sucursalOrigen">
                                    <option value="0" select>-- Seleccione Origen</option>      
                                    <?php foreach($sucursales as $s): ?>
                                        <option value="<?php echo $s["idSucursal"] ?>"><?php echo $s["nombre"] ?></option>
                                    <?php endforeach; ?>
                                    
                                </select>
                                <button @click.prevent="cambiarOrigen" v-show="sucursalOrigen != 'SN'" class="btn btn-warning btn-block">Cambiar Origen</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>Destino</h3>
                            </div>
                            <div class="col-lg-10">
                                <select :disabled="sucursalOrigen == 0" class="form-control m-b" v-model="sucursalDestino">
                                    <option value="0" select>-- Seleccione Destino</option>                                

                                    <?php foreach($sucursales as $s): ?>
                                        <option v-show="sucursalOrigen != '<?php echo $s["idSucursal"] ?>'" value="<?php echo $s["idSucursal"] ?>"><?php echo $s["nombre"] ?></option>
                                    <?php endforeach; ?>

                                    <!-- <option v-show="sucursalOrigen != 'ALMACEN PRINCIPAL'" value="ALMACEN PRINCIPAL" select>Almacen Principal</option>
                                    <option v-show="sucursalOrigen != 'MCM'" value="MCM" select>MCM</option>
                                    <option v-show="sucursalOrigen != 'ALPES'" value="ALPES" select>ALPES</option>
                                    <option v-show="sucursalOrigen != 'CASA'" value="CASA" select>CASA</option>
                                    <option v-show="sucursalOrigen != 'NARCISO'" value="NARCISO" select>NARCISO</option>
                                    <option v-show="sucursalOrigen != 'DELTA'" value="DELTA" select>DELTA</option>
                                    
                                    <option v-show="sucursalOrigen != 'LAGOS'" value="LAGOS" select>LAGOS</option> -->
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
                            <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-search"></i></span> <input type="text" placeholder="producto" v-model="filtroProducto" class="form-control"></div>
                            <table class="table table-hover no-margins">
                                <thead>
                                    <tr>
                                        <th>ID Producto</th>
                                        <th>Producto</th>
                                        <th>Existencia</th>
                                        <th>Apartado</th>
                                        <th>Disponible para Transferir</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(s, index) in stockOrigenFiltered" >
                                        <td>{{ s.idProducto }}</td>
                                        <td>{{ s.producto }}</td>
                                        <td>{{ s.existencia }} <span v-show="s.porTransferir > 0" class="text-danger">- {{ s.porTransferir }}</span></td>
                                        <td>{{ s.apartado }}</td>
                                        <td>
                                            {{ (s.disponible - s.porTransferir) }}
                                            <button v-show="(s.disponible - s.porTransferir) > 0" @click.prevent="addToTarget(s.idProducto)" class="btn btn-primary btn-xs" alt="Transferir 1"><i class="fa fa-angle-right"></i></button>
                                        </td>
                                        <td>
                                            
                                            <button v-show="(s.disponible - s.porTransferir) > 0" @click.prevent="addAllToTarget(s.idProducto)" class="btn btn-primary btn-xs" alt="Transferir Todos"><i class="fa fa-arrow-right"></i></button>
                                        </td>
                                        
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
                                        <th>ID Producto</th>
                                        <th>Producto</th>
                                        <th>Transferir</th>                                        
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(s, index) in stockDestino">
                                        <td><button @click.prevent="removeOneFromTarget(s.idProducto, index)" class="btn btn-danger btn-xs" alt="Quitar 1"><i class="fa fa-angle-left"></i></button></td>
                                        <td>{{ s.idProducto }}</td>
                                        <td>{{ s.producto }}</td>
                                        <td>{{ s.porTransferir }}</td>                                        
                                        <td><button @click.prevent="removeFromTarget(s.idProducto, index)" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
                                        
                                    </tr>
                                
                                </tbody>
                            </table>
                            
                        </div>
                        
                    </div>
                    <button @click.prevent="tryGenerarTransferencia" v-show="stockDestino.length > 0" class="btn btn-primary pull-right">Generar Transferencia</button>
                </div>
            </div>
            <!-- fin transferencia -->


			</div>
		</div>
	</div>
</div>






