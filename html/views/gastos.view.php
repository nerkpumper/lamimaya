<?php
$titlePage = "Clientes";
$breadCum = "Cat&aacute;logos/Cliente/Editar";
$_lugar = LUGAR_GASTOS_GASTOS;

$_addScript ="
    
			<script src=\"".URL_BASE."js/components/concepto-gasto-selector.vue.js\"></script>
            <script src=\"".URL_BASE."js/components/concepto-gasto-new-edit.vue.js\"></script>
			
            ";



?>

<concepto-gasto-selector @on-select="onSelectConceptoGasto($event)" ref="gastoConceptoSelector"></concepto-gasto-selector> 
<div v-if="!hasSucursal && !isAdmin">
    <span class="alert alert-danger">
        Su Usuario no tiene una Sucursal asignada, favor de contactar a su Administrador.   
    </span>
</div>
<div v-if="hasSucursal || isAdmin">    

    <div class="ibox">
        <div class="ibox-title">
            <h5>Registrar nuevo gasto</h5>
           
        </div>
        <div class="ibox-content m-b-sm border-bottom">   

            <div class="row">
                <div v-if="isAdmin" class="col-sm-4">
                    <div class="form-group" v-bind:class="{'has-error': errSucursal}">
                        <label class="control-label" for="product_name">Sucursal</label>
                        <select class="form-control" v-model="idSucursal">
                            <option value="0">--Seleccione Sucursal--</option>
                            <option v-for="s in lstSucursales" :value="s.idSucursal">{{ s.nombre }}</option>
                        </select> 
                        <span class='help-block'> <strong>{{ errSucursal }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group"
                        v-bind:class="{'has-error': errConcepto}">
                        <label class="control-label" for="product_name">Concepto</label>
                        <div class="input-group">
                            <input type="text" @click="seleccionaConcepto" v-model="conceptoGasto" class="form-control" readonly="true">  
                            <span class="input-group-btn"> 
                                <button type="button"  @click.prevent="seleccionaConcepto" class="btn btn-primary"><i class="fa fa-search"></i></button> 
                            </span>
                        </div>
                        <span class='help-block'> <strong>{{ errConcepto }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group"
                        v-bind:class="{'has-error': errMonto}">
                        <label class="control-label" for="price">Monto</label> 
                        <input
                            type="text" v-model="monto" class="form-control"
                            maxlength="9" ref="monto"
                            oninput="this.value = this.value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');">
                        <span class='help-block'> <strong>{{ errMonto }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <div class="form-group"
                        v-bind:class="{'has-error': errDetalle}">
                        <label class="control-label" for="price">Referencia</label> <input
                            type="text" v-model="detalle" class="form-control"
                            maxlength="69" ref="detalle">
                        <span class='help-block'> <strong>{{ errDetalle }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">                        
                        <button @click.prevent="guardarGasto" class="btn btn-primary m-t-md">Registrar Gasto</button>
                    </div>
                </div>
                
            </div>

        </div>
    </div>


    <div class="ibox">
        <div class="ibox-title">
            <h5>Gastos Registrados</h5>
           
        </div>
        <div class="ibox-content m-b-sm border-bottom">   
            <div v-if="pageTotalRegs > 0" class="row">
                <div class="col-sm-2">
                    <div class="input-group m-b">
                        <span class="input-group-btn">
                            <button @click.prevent="previousPage" type="button" class="btn btn-white" :disabled="page == 0"><i class="fa fa-chevron-left"></i></button> 
                        </span> 
                        <input type="text" :value="'(' + pageTotalRegs + ' Regs.)  Pag. ' + (page + 1) + ' / ' + (pages)" class="form-control text-center" style="width: 300px" disabled>
                        <span class="input-group-btn">
                            <button @click.prevent="nextPage" type="button" class="btn btn-white" :disabled="page == (pages-1)"><i class="fa fa-chevron-right"></i></button> 
                        </span>     
                    </div>                                                            
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Sucursal</th>
                            <th>Concepto</th>
                            <th>Detalle</th>
                            <th>Monto</th>
                            <th>Usuario</th>
                        </tr>                    
                    </thead>
                    <tbody>
                        <tr v-for="g in lstGastos">
                            <td>{{ changeDateToDMY(g.fecha_insert) }}</td>                            
                            <td>{{ g.sucursal }} </td>
                            <td>{{ g.concepto }}</td>
                            <td>{{ g.detalle }}</td>
                            <td>{{ g.monto }}</td>
                            <td>{{ g.insertedBy}}</td>
                        </tr>                    
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    
</div>
