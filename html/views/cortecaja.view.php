<?php
$titlePage = "CxC";
$breadCum = "CxC/Corte Caja";
$_lugar = LUGAR_CXC_CORTECAJA;



$_addScript ="
    
			<script src=\"".URL_BASE."js/components/cortecaja-cortes.vue.js\"></script>
            <script src=\"".URL_BASE."js/components/cortecaja-ventas.vue.js\"></script>
            <script src=\"".URL_BASE."js/components/cortecaja-abonos.vue.js\"></script>
            <script src=\"".URL_BASE."js/components/cortecaja-entradas.vue.js\"></script>
            <script src=\"".URL_BASE."js/components/cortecaja-salidas.vue.js\"></script>
            
			
            ";


?>

<div v-show="idSucursal == 0 && !isAdmin">
    <span class="alert alert-danger">
        No tiene asignada una sucursal en sus datos de Usuario. No puede realizar actividades en esta pantalla.
    </span>

</div>

<div class="row" v-show="isAdmin" >
    <div class="col-lg-12" >
        <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Selecciona Sucursal</h5>                
                </div>
                    <div class="ibox-content">
                        <div class="row">
                        <div  class="col-lg-6" >
                                        <select class="form-control" v-model="idSucursalSeleccionada">
                                            <option value="0">--Seleccione Sucursal--</option>
                                            <option v-for="s in lstSucursales" :value="s.idSucursal">{{ s.nombre }}</option>
                                        </select>                 
                        </div>  
                        <div  class="col-sm-6">
                            <button  @click.prevent="cargarCorteSucursal" class="btn btn-primary">Consultar Corte</button>
                        </div>
                        </div>
                    </div>       
            </div>    
        </div>
    </div>
</div>
   

                    
                      
                    


<div v-show="idSucursal > 0">

    <h2>Corte de Caja para la sucursal: <strong>{{sucursal.nombre}}</strong>
        &nbsp;&nbsp;<a target="_blank" :href="URL_BASE+'reportedetallecorte?idCorteCaja=' + idCorteCaja  + '&fechaFinal=' + fechaCorte" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> Previsualizar Corte</a>
    </h2>

    <div v-if="corteRealizado" class="alert alert-info">
        <h3>El corte se ha realizado, si recarga esta pantalla, verá la información con el corte nuevo que se ha abierto.</h3>
    </div>

    <div v-if="!corteRealizado" class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Dinero en Caja</h5>                
                </div>
                <div class="ibox-content">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-t">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span class="h5">Fecha Apertura: &nbsp;&nbsp;&nbsp;<strong class="text-navy">{{ changeDateToDMY(fechaApertura) }}</strong> </span> 
                                    </div>
                                    <div class="col-lg-6">
                                        
                                        <span class="h5">Fecha Corte: &nbsp;&nbsp;&nbsp;<strong class="text-navy">{{ changeDateToDMY(fechaCorte) }}</strong> </span> 
                                    </div>
                                </div>
                                <table class="table invoice-table table-striped">                                
                                    <tbody>
                                        <!-- <tr >
                                            <td><h5>Fecha Apertura</h5></td>
                                            <td><h4 class="text-navy">{{ changeDateToDMY(fechaApertura) }}</h4></td>
                                        </tr>                                
                                        <tr >
                                            <td><h5>Fecha Corte</h5></td>
                                            <td><h4 class="text-navy">{{ changeDateToDMY(fechaCorte) }}</h4></td>
                                        </tr>  -->
                                        <tr v-for="dc in dineroCaja">
                                            <td><h5>{{ dc.concepto }}&nbsp;<button v-if="dc.concepto != 'Fondo de Caja'" class="btn btn-primary btn-xs" @click.prevent="verDetalle(dc.concepto)"><i class="fa fa-list-alt"></i></button>  </h5></td>
                                            <td><h5 :class="dc.signo == '+' ? 'text-success' : 'text-danger'">$ {{ formatNumber(dc.monto) }}</h5></td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>                            
                                    <tr>
                                        <td><strong>TOTAL EFECTIVO:</strong></td>
                                        <td><h3>$ {{ formatNumber(getTotal) }}</h3></td>
                                    </tr>           
                                    <tr>
                                        <td><strong>DEJAR EN CAJA CHICA :</strong></td>
                                        <td>
                                            <input
                                            type="text" v-model="dejarEnCaja" class="form-control text-right"
                                            maxlength="9" ref="dejarEnCaja"
                                            oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>TOTAL A RETIRAR:</strong></td>
                                        <td><h3>$ {{ formatNumber(getTotalARetirar) }}</h3></td>
                                    </tr>           
                                    <tr>
                                        <td></td>
                                        <td><button v-if="idSucursal > 0" @click.prevent="realizarCorte" class="btn btn-primary">Realizar Corte</button></td>
                                    </tr>                                
                                </tbody>
                            </table>                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <span v-show="detalle == ''">Seleccione el detalle que desea visualizar</span>
                        <span v-show="detalle == 'Ventas'">Detalle de Ventas</span>
                        <span v-show="detalle == 'Abonos'">Detalle de Abonos</span>
                        <span v-show="detalle == 'Entradas'">Detalle de Entradas</span>
                        <span v-show="detalle == 'Salidas'">Detalle de Salidas</span>
                    </h5>                
                </div>
                <div class="ibox-content">
                    <span v-show="detalle == 'Ventas'"><cortecaja-ventas ref="ccVentas"></cortecaja-ventas></span>
                    <span v-show="detalle == 'Abonos'"><cortecaja-abonos ref="ccAbonos"></cortecaja-abonos></span>
                    <span v-show="detalle == 'Entradas'"><cortecaja-entradas ref="ccEntradas"></cortecaja-entradas></span>
                    <span v-show="detalle == 'Salidas'"><cortecaja-salidas ref="ccSalidas"></cortecaja-salidas></span>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Cortes Realizados</h5>                
                </div>
                <div class="ibox-content">
                    <cortecaja-cortes ref="cortesRealizados"></cortecaja-cortes>
                </div>
            </div>
        </div>
    </div>
</div>
