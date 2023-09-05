<?php
$titlePage = "Listado de Transferencias";
$breadCum = "Productos/Transferencias";

$_lugar = LUGAR_PRODUCTOS_LISTADOTRANSFERENCIAS ;


?>


<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
            <div class="ibox-title">
                <h2>Transferencias</h2>
            </div>
			<div class="ibox-content">
				
                <div class="row">                    
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>De</h3>
                            </div>
                            <div class="col-lg-10">
                                <select  class="form-control m-b" v-model="almacenOrigen">
                                    <option value="SN" select>Cualquier Almac&eacute;n</option>                                
                                    <option value="ALMACEN PRINCIPAL" select>ALMACEN PRINCIPAL</option>
                                    <option value="MCM" select>MCM</option>
                                    <option value="ALPES" select>ALPES</option>
                                    <option value="CASA" select>CASA</option>
                                    <option value="NARCISO" select>NARCISO</option>
                                    <option value="DELTA" select>DELTA</option>
                                    <!-- <option value="OBRA" select>OBRA</option> -->
                                    <option value="LAGOS" select>LAGOS</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3>A</h3>
                            </div>
                            <div class="col-lg-10">
                                <select  class="form-control m-b" v-model="almacenDestino">
                                    <option value="SN" select>Cualquier Almac&eacute;n</option>                                
                                    <option value="ALMACEN PRINCIPAL" select>ALMACEN PRINCIPAL</option>
                                    <option value="MCM" select>MCM</option>
                                    <option value="ALPES" select>ALPES</option>
                                    <option value="CASA" select>CASA</option>
                                    <option value="NARCISO" select>NARCISO</option>
                                    <option value="DELTA" select>DELTA</option>
                                    <!-- <option value="OBRA" select>OBRA</option> -->
                                    <option value="LAGOS" select>LAGOS</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary pull-right">Obtener Listado</button>
                    </div>
                </div> -->
                <hr>
                <table class="table table-hover no-margins">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="t in transferenciasFiltered" >
                            <td>{{ t.folio }}</td>
                            <td>{{ t.origen }}</td>
                            <td>{{ t.destino }}</td>
                            <td>{{ t.fecha }}</td>
                            <td>{{ t.crea }}</td>                            
                            <td><a :href="URL_BASE + 'transferenciaview/' + t.folio" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                            <a :href="URL_BASE + 'transferenciapdf?id=' + t.folio" class="btn btn-info btn-xs"><i class="fa fa-print"></i></button></td>
                            
                        </tr>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>