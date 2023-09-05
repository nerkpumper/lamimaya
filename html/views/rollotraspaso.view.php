<?php
$titlePage = "rollotraspaso";
$breadCum = "Nueva/traspaso de Rollo";

$_lugar = LUGAR_PRODUCTOS_ROLLOSTRASPASOS;

?>
<!-- </div> -->

<div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <h2>No. Rollo</h2>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="m-b-xs">
                <div class="input-group" style="padding-top: 10px;">
                    <input type="text" class="form-control input-lg"
                           v-model="noRollo"
                           v-on:keypress.enter="app.cargarDatosNoRollo();"> <span class="input-group-btn">
						<button @click.prevent="cargarDatosNoRollo"
                                class="btn btn-primary btn-lg " type="button">
							<i class="fa fa-search"></i><span class="bold"></span>
						</button>
					</span>
                </div>
            </div>
        </div>
    </div>

</div>


<div v-if="msgError">
    <div class="text-center animated fadeInRight alert alert-danger" >
        {{ msgError }}
    </div>
</div>

<!-- <div > -->
<!-- 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!-- 		<div class="ibox"> -->
<!-- 	    	<div class="ibox-content"> -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="col-lg-12">
        <div  class="ibox-title">
            <h2>Origen</h2>
        </div>
        <div v-for="(r, indexrollo) in rollos" class="panel-rec m-b">
            <h2>
                <span class="text-navy"> {{ r.codigo }}</span> {{ r.descripcion }}
            </h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th># Rollo</th>
                        <th>Almacen</th>
                        <th>Kilos</th>
                        <th>Disponible</th>
                        <th>Almacen destino</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(remi, indexnorollo) in r.noRollos">
                        <td><h3>{{ remi.noRollo }}</h3></td>
                        <td>{{ remi.almacen }}</td>
                        <td>{{ remi.kilos.toLocaleString() }}</td>
                        <td>{{ remi.disponible.toLocaleString() }}</td>
                        <td>
                        	<span v-show="remi.almacencambiado" class="text-navy">El No Rollo ha sido cambiado de Almacen</span>
                        	<select :disabled="remi.almacencambiado" class="form-control m-b" v-model="remi.almacendestino">
                                <option value="SN" select>-- Seleccione Destino</option>                                
                                <option v-show="remi.almacen != 'ALMACEN PRINCIPAL'" value="ALMACEN PRINCIPAL" select>Almacen Principal</option>
                                <option v-show="remi.almacen != 'MCM'" value="MCM" select>MCM</option>
                                <option v-show="remi.almacen != 'ALPES'" value="ALPES" select>ALPES</option>
                                <option v-show="remi.almacen != 'CASA'" value="CASA" select>CASA</option>
                                <option v-show="remi.almacen != 'NARCISO'" value="NARCISO" select>NARCISO</option>
                                <option v-show="remi.almacen != 'DELTA'" value="DELTA" select>DELTA</option>
                                <option v-show="remi.almacen != 'OBRA'" value="OBRA" select>OBRA</option>
                                <option v-show="remi.almacen != 'LAGOS'" value="LAGOS" select>LAGOS</option>
                            </select>
                        </td>
                        <td><button v-show="!remi.almacencambiado" class="btn btn-primary" @click.prevent="cambiaralmacenByIndex(indexrollo, indexnorollo)" >Enviar</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
     </div>
    <!--
    <div class="col-lg-6">
        <div  class="ibox-title">
            <h2>Destino</h2>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th># Rollo</th>
                        <th>Almacen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr >
                        <td><h3 >{{ noRollo }}</h3></td>
                        <td>Remision almacen</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" >Enviar</button>
        </div>

<!-- </div>--> 
<!-- 	    	</div> -->
<!-- 	    </div> -->
<!-- 	</div> -->
</div> 

<!--     <pre>{{ $data }}</pre></div> -->
