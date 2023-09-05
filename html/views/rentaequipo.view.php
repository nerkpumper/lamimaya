<?php
$titlePage = "Renta de Equipo";
$breadCum = "Renta de Equipo";

//$_lugar = LUGAR_PRODUCCION_RENTAEQUIPO;



     ?>    

        <div class="row" >
        
            <div class="col-xs-4"  >
            <h1>Renta de equipo</h1>
            <h4>Folio</h4>
            <input type="number" v-model="folio" class="form-control" min = 0 required >
            <h4>Fecha</h4>
            <input type="date" v-model="fecha_captura" class="form-control" min = 0  required> 
            <h4>Importe Renta de equipo</h4>
            <input type="number"v-model="totalRentaEquipo" class="form-control" min = 0  required>
            <h4>Total renta Equipo</h4>
            <h4>${{ totalRentaEquipo }}</h4>
        </div>

        
        <div class="col-xs-4" >
            <h1>Operario</h1>
            <h4>Operario 1</h4>
            <select class="form-control" v-model="nombreOperario1" >
            <option value="0">---Seleccione opcion--</option>
            <option value="Alejandro Olaes Fraga">Alejandro Olaes Fraga</option>
            <option value="Pedro Antonio Ponce Contreras">Pedro Antonio Ponce Contreras</option>
            </select>
            <h4>Sueldo Hora</h4>
            <input type="number" class="form-control" v-model="sueldoHr1" disabled="disabled" >
            <h4 v-show = "!otroOperador" > operario 2</h4>
            <input type="text" class="form-control" v-model="nombreOperario2" v-show = "!otroOperador"  >
            <h4 v-show = "!otroOperador">Sueldo Hora</h4>
            <input type="number" class="form-control" v-model="sueldoHr2" v-show = "!otroOperador">
            <h4>Horas Trabajadas</h4>
            <input type="number" class="form-control" v-model="horasTrabajadas">  
            <h4 v-show = "!otroOperador">Sueldo total de ayudante Extra </h4>
            <input type="number" class="form-control" v-show = "!otroOperador" v-model="sueldoAyudante">
            <div class="col-xs-6" > 
            <h4>Total Operario</h4>
            <h4>${{ totalOperario= (sueldoHr1 * horasTrabajadas)+(sueldoHr2 * horasTrabajadas)+parseFloat(sueldoAyudante)  }}</h4>
            </div>
            <div class="col-xs-6" >           
            <small>Agregar Operador</small>
            <div class="switch" v-show = "otroAyudante" >
                    <div class="onoffswitch">
                        <input type="checkbox" class="onoffswitch-checkbox"
                            id="chkImprimirPedidoNoSaldado" v-model="otroOperador"> <label class="onoffswitch-label" for="chkImprimirPedidoNoSaldado">  
                            <span
                            class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            </div>
       

        
        <div class="col-xs-4" >
            <h1>Consumo combustible</h1>
            <h4>Tipo de combustible</h4>
            <select class="form-control" v-model="tipoCombustible">
            <option value="">---Seleccione opcion--</option>
            <option value="Diesel">Diesel</option>
            <option value="Gasolina">Gasolina</option>
            </select>
            <h4>Costo litro</h4>
            <input type="number" class="form-control" v-model="costoLitro">
            <h4>lts. cosumidos</h4>
            <input type="number" class="form-control" v-model="litrosConsumidos">
            <h4>Total combustible</h4>
            <h4>${{ totalCombustible = litrosConsumidos *costoLitro  }}</h4>
        </div>
    </div>

    <h2>Total ${{ total = parseFloat(totalRentaEquipo) - parseFloat(totalOperario) - parseFloat(totalCombustible) }}</h2>
    
    <button @click.prevent="guardarRentaEquipo" class="btn btn-primary pull-right"> Guardar</button>
					<div class="clearfix"></div>







