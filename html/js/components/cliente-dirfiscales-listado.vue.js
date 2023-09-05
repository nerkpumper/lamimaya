
Vue.component('cliente-dirfiscales-listado', {
        data: function () {
            return {
                count: 0,
                idCliente: 0,
                nombreCliente: '',
                creditoCliente: 0,                
                backCreditoCliente: 0,
                capacidadPagoCliente: 0,
                backCapacidadPagoCliente: 0,
                sumaCreditoCliente: 0,                
                backSumaCreditoCliente: 0,
                sumaCapacidadPagoCliente: 0,
                backSumaCapacidadPagoCliente: 0,
                editandoCreditos: false,

                showIdClienteDatosFacturacion: false,

                manejarCreditos: false,
                title: 'Direcciones Fiscales',

                editing: false,

                direcciones: [],
                
            }
        },
        mounted: function(){

            if (_IDROL == __rol_ROOT)
                this.showIdClienteDatosFacturacion = true;

            if (_IDROL == __rol_ROOT ||
                _IDROL == __rol_ADMINISTRADOR ||
                _IDROL == __rol_CXC ||
                _IDROL == __rol_CXCVENTAS
                ){
                this.title += " y Créditos"
                this.manejarCreditos = true;
            }
        },
        computed: {
            sumaCreditosRfcs: function(){
                var suma = 0;

                this.direcciones.forEach(element => {                        
                        suma = suma + parseFloat(element.credito);
                    });

                return suma;
            },
            sumaBackCreditosRfcs: function(){
                var suma = 0;

                this.direcciones.forEach(element => {                        
                        suma = suma + parseFloat(element.backcredito);
                    });

                return suma;
            },
            sumaCapacidadPagoRfcs: function(){
                var suma = 0;

                this.direcciones.forEach(element => {                        
                        suma = suma + parseFloat(element.capacidadpago);
                    });

                return suma;
            },
            sumaBackCapacidadPagoRfcs: function(){
                var suma = 0;

                this.direcciones.forEach(element => {                        
                        suma = suma + parseFloat(element.backcapacidadpago);
                    });

                return suma;
            }

        },
        methods: {
            start: function(idCliente, nombreCliente){
                this.idCliente = idCliente;
                this.nombreCliente = nombreCliente;
                this.refresh();
                
            },
            refresh: function(){
                this.editandoCreditos = false;
                this.loadDirecciones();
            },
            loadDirecciones: function(){
                var vm = this;
                axios.get(URL_BASE + 'api/datosfacturacion.api.php?method=getall&idCliente=' + this.idCliente, getAxiosHeaders())
                .then(function (response) {
                    
                    vm.creditoCliente = response.data.creditoCliente;
                    vm.backCreditoCliente = response.data.creditoCliente;
                    vm.capacidadPagoCliente = response.data.capacidadPagoCliente;
                    vm.backCapacidadPagoCliente = response.data.capacidadPagoCliente;

                    vm.sumaCreditoCliente = response.data.sumaCreditoCliente;
                    vm.backSumaCreditoCliente = response.data.sumaCeditoCliente;
                    vm.sumaCapacidadPagoCliente = response.data.sumaCapacidadPagoCliente;
                    vm.backSumaCapacidadPagoCliente = response.data.sumaCapacidadPagoCliente;
                    
                    vm.direcciones = response.data.list;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarCreditos: function(){

                this.backCreditoCliente = this.creditoCliente;
                this.backCapacidadPagoCliente = this.capacidadPagoCliente;
                // this.backSumaCreditoCliente = this.sumaCreditoCliente;
                // this.backSumaCapacidadPagoCliente = this.sumaCapacidadPagoCliente;
                this.direcciones.forEach(element => {                        
                        element.backcredito = element.credito;
                        element.backcapacidadPago = element.capacidadpago;
                    });
                this.editandoCreditos = true;
            },
            stopEditarCreditos: function(){
                this.editandoCreditos = false;
            },
            modalNuevaDireccion: function(){                
                this.editing = false;			
                this.$refs.nuevaDireccion.show(this.idCliente, this.nombreCliente); 
            },
            modalNuevaDireccionExistente: function(){
                this.editing = false;			
                this.$refs.nuevaDireccionExistente.show(this.idCliente, this.nombreCliente, true); 
            },
            modalUpdateDireccion: function(index){			
                this.editing = true;
                this.$refs.nuevaDireccion.show(this.idCliente, this.nombreCliente, this.direcciones[index].idDatosFacturacion); 
            },
            guardarMontosCreditos: function(){

                if (parseFloat(this.backCreditoCliente) > parseFloat(this.backCapacidadPagoCliente))
                {
                    this.backCapacidadPagoCliente = this.backCreditoCliente;
                }

                // if (parseFloat(this.backSumaCreditoCliente) > parseFloat(this.backSumaCapacidadPagoCliente))
                // {
                //     this.backSumaCapacidadPagoCliente = this.backSumaCreditoCliente;
                // }

                // if (this.direcciones.length > 0 && parseFloat(this.backSumaCreditoCliente) != parseFloat(this.sumaBackCreditosRfcs))
                // {
                //     saInfo("La Suma de los Créditos de los RFC del Cliente, debe ser exactamente igual al Monto asignado al Cliente.");
                //     return;
                // }

                // if (this.direcciones.length > 0 && parseFloat(this.backSumaCapacidadPagoCliente) != parseFloat(this.sumaBackCapacidadPagoRfcs))
                // {
                //     saInfo("La Suma de las Capacidades de Pago de los RFC del Cliente, debe ser exactamente igual a la Capacidad de Pago asignado al Cliente.");
                //     return;
                // }
                
                var continuar = true;
                this.direcciones.forEach(x => {
                    if (parseFloat(x.backcapacidadpago || 0) < parseFloat(x.backcredito || 0))
                    {
                        saInfo("Las Capacidades de Pago debe ser igual o mayor al Crédito asignado. Favor de verificar.");
                        continuar = false;
                        return;
                    }
                });
                
                if (!continuar) return;

                var form_data = new FormData();
                form_data.append("idCliente", this.idCliente);
                form_data.append("creditoCliente", this.backCreditoCliente);
                form_data.append("capacidadPagoCliente", this.backCapacidadPagoCliente);
                // form_data.append("sumaCreditoCliente", this.backSumaCreditoCliente);
                // form_data.append("sumaCapacidadPagoCliente", this.backSumaCapacidadPagoCliente);
                
                // var creditosClienteDatosFacturacion = this.direcciones.map(function(x){
                //     return { idClienteDatosFacturacion: x.idClienteDatosFacturacion, 
                //             credito: x.backcredito,
                //             capacidadpago: x.backcapacidadpago };
                // });
		        
                // form_data.append('creditosClienteDatosFacturacion', JSON.stringify(creditosClienteDatosFacturacion));

                var vm = this;                         
                axios.post(URL_BASE + 'api/datosfacturacion.api.php?method=saveRFCCreditos', form_data, getAxiosHeaders())
                .then(function (response) {
                    
                    if (!response.data.error)
                    {
                        vm.refresh();
                        saSuccess("Créditos almacenados con éxito");
                    }
                    else
                    {
                        saError(response.data.msg);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            onSave: function(event){
                
                if (!this.editing)
                {   
                    this.direcciones.push (event);
                }
                else
                {
                    var index = this.direcciones.findIndex(x => x.idDatosFacturacion == event.idDatosFacturacion);
                    
                    if (index >=0)
                    {                        
                        this.direcciones[index].rfc = event.rfc;
                        this.direcciones[index].email = event.email;
                        this.direcciones[index].razonSocial = event.razonSocial;
                        this.direcciones[index].domicilio = event.domicilio;
                        this.direcciones[index].numero = event.numero;
                        this.direcciones[index].colonia = event.colonia;
                        this.direcciones[index].ciudad = event.ciudad;
                        this.direcciones[index].codigoPostal = event.codigoPostal;
                        this.direcciones[index].idUsoCfdi = event.idUsoCfdi;                       
                        
                    }

                }
            },
            onDirSelected: function(event){
                console.log(event.idDatosFacturacion);
                var form_data = new FormData();
                form_data.append("idCliente", this.idCliente);
                form_data.append("idDatosFacturacion", event.idDatosFacturacion);
                
                var vm = this;                         
                axios.post(URL_BASE + 'api/datosfacturacion.api.php?method=addDatosFacturacion', form_data, getAxiosHeaders())
                .then(function (response) {
                    console.log(response.data);
                    if (!response.data.error)
                    {
                        vm.refresh();
                        saSuccess("RFC agregado al Cliente con éxito");
                    }
                    else
                    {
                        saError(response.data.msg);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        template: `
            <div>
                <cliente-dirfiscales-new-edit @on-save="onSave($event)" ref="nuevaDireccion"></cliente-dirfiscales-new-edit>                
                <cliente-dirfiscales-selector @on-select="onDirSelected($event)" ref="nuevaDireccionExistente" leyendashow="Seleccione RFC a asignar al Cliente"></cliente-dirfiscales-selector>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>{{ title }}</h5>				
                            </div>                        
                            <div class="ibox-content">

                                <div v-if="manejarCreditos">
                                    <div class="row">
                                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button v-if="!editandoCreditos" @click.prevent="editarCreditos" class="btn btn-warning pull-right"><i class="fa fa-pencil"></i> Editar Montos de Cr&eacute;dito del Cliente</button>
                                            <button v-if="editandoCreditos" @click.prevent="stopEditarCreditos" class="btn btn-danger pull-right"> Cancelar Edici&oacute;n de Cr&eacute;ditos</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    Cr&eacute;dito de <strong>{{ nombreCliente }}</strong>: 
                                                </div>
                                                <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <span v-if="!editandoCreditos" class="text-navy" style="font-size: 18px;"> $ {{ formatNumber(creditoCliente) }}</span>
                                                    <div v-if="editandoCreditos" class="form-group " >                                            
                                                        <input style="margin-top: -5px;"                                   
                                                        v-model="backCreditoCliente"
                                                        onkeypress="return isNumberKey(event)"
                                                        type="text"  class="form-control"
                                                        maxlength="9" 
                                                        >
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                            
                                            
                                                
                                        </div>
                                       
                                    
                                    
                                        <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    Capacidad de Pago</strong>: 
                                                </div>
                                                <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <span v-if="!editandoCreditos" class="text-navy" style="font-size: 18px;"> $ {{ formatNumber(capacidadPagoCliente) }}</span>
                                                    <div v-if="editandoCreditos" class="form-group " >                                            
                                                        <input style="margin-top: -5px;"                                   
                                                        v-model="backCapacidadPagoCliente"
                                                        onkeypress="return isNumberKey(event)"
                                                        type="text"  class="form-control"
                                                        maxlength="9" 
                                                        >
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>                                            
                                                
                                        </div>                                        
                                    
                                    </div>
                                </div>  

                                <hr v-if="manejarCreditos">

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button v-if="!editandoCreditos" @click="modalNuevaDireccionExistente" class="btn btn-primary pull-right m-l-xs" ><i class="fa fa-search"></i> Agregar RFC Existente</button>                                
                                        <button v-if="!editandoCreditos" @click="modalNuevaDireccion" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Nuevo RFC</button>

                                        
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        
                                        <div class="table-responsive" >
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th v-if="showIdClienteDatosFacturacion">idcdf</th>
                                                        <th>RFC</th>
                                                        <th>Email</th>
                                                        <th>Raz&oacute;n Social</th>
                                                        <th>Domicilio</th>
                                                       
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(dir, index) in direcciones" :key="dir.idClienteDatosFacturacion">
                                                        <td v-if="showIdClienteDatosFacturacion">{{ dir.idClienteDatosFacturacion }}</td>
                                                        <td><i :class="'fa fa-' + (dir.privado == 'SI' ? 'lock text-navy' : 'unlock text-danger')"></i> {{ dir.rfc }}</td>
                                                        <td>{{ dir.email }}</td>
                                                        <td>{{ dir.razonSocial }}</td>
                                                        <td>{{ dir.domicilio + ' ' + dir.numero + ' ' + dir.colonia + ' ' + dir.ciudad }}</td>
                                                        
                                                        <td>       
                                                            <span v-if="editandoCreditos && parseFloat(dir.backcapacidadpago || 0) < parseFloat(dir.backcredito || 0)"><i class="fa fa-minus-circle text-danger"></i></span>                                         
                                                            <button v-if="!editandoCreditos" class="btn btn-primary btn-xs" @click.prevent="modalUpdateDireccion(index)"><i class="fa fa-pencil"></i></button>
                                                            <!--<button v-if="!editandoCreditos" class="btn btn-danger btn-xs" @click.prevent=""><i class="fa fa-trash"></i></button>-->
                                                        </td>
                                                    </tr>
                                                    
                                                    
                                                </tbody>
                                            </table>
                                        </div>

                                        <button v-if="editandoCreditos" @click.prevent="guardarMontosCreditos" class="btn btn-primary pull-right"><i class="fa fa-disk"></i> Guardar los cambios en los montos de Cr&eacute;ditos y Capacidad Pago</button>
                                    
                                    </div>
                                </div>
                                

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        `
        });