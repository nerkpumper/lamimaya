
Vue.component('cliente-dirfiscales-new-edit', {
  data: function () {
    return {
        idDatosFacturacion: 0,
        idCliente: 0,
        nombreCliente: '',
        
        listidUsoCfdi: [],
        listRegimen:[],
        
        rfc: '',
        email: '',
        razonSocial: '',
        domicilio: '',
        numero: '',
        colonia: '',
        ciudad: '',
        codigoPostal: '',
        idUsoCfdi: 0,
        idRegimenFiscal: 1,
        credito: '0',
        capacidadPago: '0',
        privado: 'SI',

        errRfc: '',
        errEmail: '',
        errRazonSocial: '',
        errDomicilio: '',
        errNumero: '',
        errColonia: '',
        errCiudad: '',
        errCodigoPostal: '',
        errIdUsoCfdi: '',
        errCredito: '',
        errCapacidadPago: '',

        manejarCreditos: false,

        msgs: '',

      
    }
  },
  template: `
        <div class="modal inmodal fade" id="mdlClienteNuevaDirFiscal" tabindex="-1" style="z-index: 2300 !important;"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Agregar direcci&oacute;n fiscal<br>{{ nombreCliente }}</h4>
                        

                    </div>
                    <div class="modal-body">                        
                        <div class="row">			
                            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errRfc}">
                                    <label class="control-label">RFC</label> 
                                    <input type="text" v-model="rfc" ref="rfc" placeholder="" maxlength="20" class="form-control">
                                    <span class="text-danger">{{ errRfc }}</span>                                    
                                </div>
                            </div>	
                        
                            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errEmail}">
                                    <label class="control-label">Email</label> 
                                    <input type="email" v-model="email" placeholder="" maxlength="70" class="form-control">
                                    <span class="text-danger">{{ errEmail }}</span>                                    
                                </div>
                            </div>	
                        </div>
                        <div class="row">			
                            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errRazonSocial}">
                                    <label class="control-label">Razon Social</label> 
                                    <input type="text" v-model="razonSocial" placeholder="" maxlength="250" class="form-control">
                                    <span class="text-danger">{{ errRazonSocial }}</span>                                    
                                </div>
                            </div>	
                        
                            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errIdUsoCfdi}">
                                    <label class="control-label">Uso Cfdi</label> 
                                    <select class="form-control" v-model="idUsoCfdi">                                    
                                        <option value="0">-- Seleccione --</option>
                                        <option v-for="o in listidUsoCfdi" :value="o.idUsoCfdi">{{ o.clave }} - {{ o.descripcion }}</option>
                                    </select>
                                    <span class="text-danger">{{ errIdUsoCfdi }}</span>
                                </div>
                            </div>	
                        </div>
                        <div class="row">			
                            <div  class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errDomicilio}">
                                    <label class="control-label">Domicilio</label> 
                                    <input type="text" v-model="domicilio" placeholder="" maxlength="250" class="form-control">
                                    <span class="text-danger">{{ errDomicilio }}</span>
                                </div>
                            </div>	
                        
                            <div  class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errNumero}">
                                    <label class="control-label">N&uacute;mero</label> 
                                    <input type="text" v-model="numero" placeholder="" maxlength="20" class="form-control">
                                    <span class="text-danger">{{ errNumero }}</span>
                                </div>
                            </div>	                        
                            <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errColonia}">
                                    <label class="control-label">Colonia</label> 
                                    <input type="text" v-model="colonia" placeholder="" maxlength="70" class="form-control">
                                    <span class="text-danger">{{ errColonia }}</span>
                                </div>
                            </div>	
                        </div>
                        <div class="row">			
                            <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errCiudad}">
                                    <label class="control-label">Ciudad</label> 
                                    <input type="text" v-model="ciudad" placeholder="" maxlength="70" class="form-control">
                                    <span class="text-danger">{{ errCiudad }}</span>
                                </div>
                            </div>	
                        	
                            <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errCodigoPostal}">
                                    <label class="control-label">Codigo Postal</label> 
                                    <input type="text" v-model="codigoPostal" placeholder="" maxlength="20" class="form-control">
                                    <span class="text-danger">{{ errCodigoPostal }}</span>
                                </div>
                            </div>	

                            <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errIdUsoCfdi}">
                                    <label class="control-label">R&eacute;gimen</label> 
                                    <select class="form-control" v-model="idRegimenFiscal">                                    
                                        <option value="1">-- Seleccione --</option>
                                        <option v-for="o in listRegimen" :value="o.id">{{ o.codigo }} - {{ o.descripcion }}</option>
                                    </select>
                                    <span class="text-danger">{{ errIdUsoCfdi }}</span>
                                </div>
                            </div>	
                        
                          
                        </div>
                        <div class="row">
                            <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  >
                                    <label class="control-label">Este RFC le pertenece al cliente?</label> 
                                    <select
                                        v-model="privado"
										class="form-control">
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                    <span v-if="privado == 'SI'" class="text-info"><i class="fa fa-lock"></i> Uso exclusivo del cliente</span>
                                    <span v-if="privado == 'NO'" class="text-info"><i class="fa fa-unlock"></i> Puede agregarlo cualquier cliente</span>
                                </div>
                            </div>
                            <div v-show="manejarCreditos && privado == 'NO'"  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errCredito}">
                                    <label class="control-label">Cr&eacute;dito</label> 
                                    <input                                    
                                        v-model="credito"
										type="text"  class="form-control text-right"
                                        onkeypress="return isNumberKey(event)"
										maxlength="9" 
										>
                                    <span class="text-danger">{{ errCredito }}</span>
                                </div>
                            </div>	
                            <div v-show="manejarCreditos && privado == 'SI'"  class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                Si el RFC es privado del Cliente, entonces el Cr&eacute;dito y la Capacidad de Pago se determinan por el Cliente.
                            </div>
                            <div v-show="manejarCreditos && privado == 'NO'"  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errCapacidadPago}">
                                    <label class="control-label">Cr&eacute;dito</label> 
                                    <input                                    
                                        v-model="capacidadPago"
										type="text"  class="form-control text-right"
                                        onkeypress="return isNumberKey(event)"
										maxlength="9" 
										>
                                    <span class="text-danger">{{ errCapacidadPago }}</span>
                                </div>
                            </div>	
                        
                        </div>
                                                    
                        <div class="clearfix"></div>
                        
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="button" @click.prevent="guardarDireccion" class="btn btn-primary pull-right">Guardar</button>				
                    </div>
                </div>
            </div>
        </div>
  
  `,
    mounted: function() {

        if (_IDROL == __rol_ROOT ||
            _IDROL == __rol_ADMINISTRADOR ||
            _IDROL == __rol_CXC ||
            _IDROL == __rol_CXCVENTAS
            ){
                
                this.manejarCreditos = true;
            }

        var vm = this;
        $.ajax({	
            dataType: "json",
            headers: getAxiosHeaders(),   
            url: URL_BASE + 'api/usocfdi.getall.php',
                success:function(response){
                    vm.listidUsoCfdi = response.list;   
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log("error");
                }
            });
        // axios.get(URL_BASE + 'api/usocfdi.getall.php', getAxiosHeaders())
		// 	.then(function (response) {
				
        //         vm.listidUsoCfdi = response.data.list;
                
		// 	})
		// 	.catch(function (error) {
		// 		console.log(error);
		// 	});

        $.ajax({	
            dataType: "json",
            headers: getAxiosHeaders(),   
            url: URL_BASE + 'api/regimenfiscal.api.php?method=getall',
                success:function(response){
                    // console.log(response.data);
                    vm.listRegimen =  response.list.filter(o => o.id > 1);
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log("error");
                }
            });
        // axios.get(URL_BASE + 'api/regimenfiscal.api.php?method=getall', getAxiosHeaders())
        //         .then(function (response) {
        //             console.log(response.data);
        //             vm.listRegimen =  response.data.list.filter(o => o.id > 1);	
                    
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });
    },
    watch: {            
            codigoPostal: function(value){
                this.codigoPostal = value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');
            },
            numero: function(value){
                this.numero = value.replace(/[^0-9.\t]/g, '').replace(/(\..*)\./g, '$1');
            },
            rfc: function(value) {
                this.rfc = value.toUpperCase();
            },

            domicilio: function(value) {
                this.domicilio = value.toUpperCase();
            },
            colonia: function(value) {
                this.colonia = value.toUpperCase();
            },
            ciudad: function(value) {
                this.ciudad = value.toUpperCase();
            },
            email: function(value) {
                this.email = value.toUpperCase();
            },
            razonSocial: function(value) {
                this.razonSocial = value.toUpperCase();
            }
    },
    methods: {  
        clearData: function(){
            this.rfc = '';
            this.email = '';
            this.razonSocial = '';
            this.domicilio = '';
            this.numero = '';
            this.colonia = '';
            this.ciudad = '';
            this.codigoPostal = '';
            this.idUsoCfdi = 0;
            this.credito = '0';
            this.capacidadPago = '0';
            this.privado = 'SI';
        },   
        clearErrors: function(){
            this.errRfc = '';
            this.errEmail = '';
            this.errRazonSocial = '';
            this.errDomicilio = '';
            this.errNumero = '';
            this.errColonia = '';
            this.errCiudad = '';
            this.errCodigoPostal = '';
            this.errIdUsoCfdi = '';
            this.errCredito = '';
            this.errCapacidadPago = '';
        },   
        show: function(idCliente, nombreCliente, idDatosFacturacion = 0){        
            this.idCliente = idCliente;
            this.nombreCliente = nombreCliente;
            this.idDatosFacturacion = idDatosFacturacion;
            this.clearData();
            if (this.idDatosFacturacion > 0 )
            {
                
                var vm = this;
                
                $.ajax({	
                    dataType: "json",
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/datosfacturacion.api.php?method=get&idDatosFacturacion=' + this.idDatosFacturacion,
                        success:function(response){
                            if (!response.error)
                            {                        
                                vm.rfc = response.datosfacturacion.rfc;
                                vm.email = response.datosfacturacion.email;
                                vm.razonSocial = response.datosfacturacion.razonSocial;
                                vm.domicilio = response.datosfacturacion.domicilio;
                                vm.numero = response.datosfacturacion.numero;
                                vm.colonia = response.datosfacturacion.colonia;
                                vm.ciudad = response.datosfacturacion.ciudad;
                                vm.codigoPostal = response.datosfacturacion.codigoPostal;
                                vm.idUsoCfdi = response.datosfacturacion.idUsoCfdi;
                                vm.idRegimenFiscal = response.datosfacturacion.idRegimenFiscal;
                                vm.credito = response.datosfacturacion.credito;
                                vm.capacidadPago = response.datosfacturacion.capacidadPago;
                                vm.privado = response.datosfacturacion.privado;
                                
                                vm.$refs.rfc.focus();                        
                                $('#mdlClienteNuevaDirFiscal').modal('show');
                            }
                            else
                            {
                                saError(response.msg);
                                return;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });
                
                // axios.get(URL_BASE + 'api/datosfacturacion.api.php?method=get&idDatosFacturacion=' + this.idDatosFacturacion, getAxiosHeaders())
                // .then(function (response) {
                //     // console.log(response.data);
                //     if (!response.data.error)
                //     {                        
                //         vm.rfc = response.data.datosfacturacion.rfc;
                //         vm.email = response.data.datosfacturacion.email;
                //         vm.razonSocial = response.data.datosfacturacion.razonSocial;
                //         vm.domicilio = response.data.datosfacturacion.domicilio;
                //         vm.numero = response.data.datosfacturacion.numero;
                //         vm.colonia = response.data.datosfacturacion.colonia;
                //         vm.ciudad = response.data.datosfacturacion.ciudad;
                //         vm.codigoPostal = response.data.datosfacturacion.codigoPostal;
                //         vm.idUsoCfdi = response.data.datosfacturacion.idUsoCfdi;
                //         vm.idRegimenFiscal = response.data.datosfacturacion.idRegimenFiscal;
                //         vm.credito = response.data.datosfacturacion.credito;
                //         vm.capacidadPago = response.data.datosfacturacion.capacidadPago;
                //         vm.privado = response.data.datosfacturacion.privado;
                        
                //         vm.$refs.rfc.focus();                        
                //         $('#mdlClienteNuevaDirFiscal').modal('show');
                //     }
                //     else
                //     {
                //         saError(response.data.msg);
                //         return;
                //     }
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });
                
            }
            else
            {
                this.$refs.rfc.focus();                        
                $('#mdlClienteNuevaDirFiscal').modal('show');
            }
            
            
        },
        guardarDireccion: function(){
            
            if (this.validarDatos()){
                
                var form_data = new FormData();
                form_data.append('idCliente', this.idCliente);
		        form_data.append('idDatosFacturacion', this.idDatosFacturacion);
                form_data.append('rfc', this.rfc);
                form_data.append('email', this.email);
                form_data.append('razonSocial', this.razonSocial);
                form_data.append('domicilio', this.domicilio);
                form_data.append('numero', this.numero);
                form_data.append('colonia', this.colonia);
                form_data.append('ciudad', this.ciudad);
                form_data.append('codigoPostal', this.codigoPostal);
                form_data.append('idUsoCfdi', this.idUsoCfdi);
                form_data.append('idRegimenFiscal', this.idRegimenFiscal);
                form_data.append('credito', this.credito);
                form_data.append('capacidadPago', this.capacidadPago);
                form_data.append('privado', this.privado);
                
                var vm = this;

                var objData = {
                    idCliente: this.idCliente,
                    idDatosFacturacion: this.idDatosFacturacion,
                    rfc: this.rfc,
                    email: this.email,
                    razonSocial: this.razonSocial,
                    domicilio: this.domicilio,
                    numero: this.numero,
                    colonia: this.colonia,
                    ciudad: this.ciudad,
                    codigoPostal: this.codigoPostal,
                    idUsoCfdi: this.idUsoCfdi,
                    idRegimenFiscal: this.idRegimenFiscal,
                    credito: this.credito,
                    capacidadPago: this.capacidadPago,
                    privado: this.privado,
                }

                $.ajax({	
                    type: 'POST',
                    dataType: "json",
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/datosfacturacion.api.php?method=save',
                    data: objData,
                        success:function(response){
                            if (!response.error)
                            {                        
                                vm.rfc = response.datosfacturacion.rfc;
                                vm.email = response.datosfacturacion.email;
                                vm.razonSocial = response.datosfacturacion.razonSocial;
                                vm.domicilio = response.datosfacturacion.domicilio;
                                vm.numero = response.datosfacturacion.numero;
                                vm.colonia = response.datosfacturacion.colonia;
                                vm.ciudad = response.datosfacturacion.ciudad;
                                vm.codigoPostal = response.datosfacturacion.codigoPostal;
                                vm.idUsoCfdi = response.datosfacturacion.idUsoCfdi;
                                vm.idRegimenFiscal = response.datosfacturacion.idRegimenFiscal;
                                vm.credito = response.datosfacturacion.credito;
                                vm.capacidadPago = response.datosfacturacion.capacidadPago;
                                vm.privado = response.datosfacturacion.privado;
                                
                                vm.$refs.rfc.focus();                        
                                $('#mdlClienteNuevaDirFiscal').modal('show');
                            }
                            else
                            {
                                saError(response.msg);
                                return;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });
                
                // axios.post(URL_BASE + 'api/datosfacturacion.api.php?method=save', form_data, getAxiosHeaders())
                // .then(function (response) {
                    
                //     if (!response.data.error)
                //     {
                //         var obj = {
                //             idCliente: vm.idCliente,
                //             idDatosFacturacion: response.data.idDatosFacturacion,
                //             idClienteDatosFacturacion: response.data.idClienteDatosFacturacion,
                //             rfc: vm.rfc,
                //             email: vm.email,
                //             razonSocial: vm.razonSocial,
                //             domicilio: vm.domicilio,
                //             numero: vm.numero,
                //             colonia: vm.colonia,
                //             ciudad: vm.ciudad,
                //             codigoPostal: vm.codigoPostal,
                //             idUsoCfdi: vm.idUsoCfdi,
                //             idRegimenFiscal: vm.idRegimenFiscal,
                //             credito: 0,
                //             backcredito: 0,
                //             capacidadpago: 0,
                //             backcapacidadpago: 0,
                //         }
                //         vm.$emit("on-save", obj);
                //         $('#mdlClienteNuevaDirFiscal').modal('toggle');
                //         saSuccess("Datos fiscales almacenados con éxito");
                //     }
                //     else
                //     {
                //         saError(response.data.msg);
                //     }
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });
                
                               
            }
            
            
        },
        validarDatos: function(){
            
            var valid = true;
                        
            this.clearErrors();
            
            if (this.rfc == '')
            {
                this.errRfc = "* Debe ingresar RFC";
                valid = false;
            }

            if (this.razonSocial == '')
            {
                this.errRazonSocial = "* Debe ingresar la Razón Social";
                valid = false;
            }

            if (this.email == '')
            {
                this.errEmail = "* Debe ingresar Email";
                valid = false;
            }

            if (!isEmail(this.email))
            {
                this.errEmail = this.errEmail +  " * El formato del Email es inválido";
                valid = false;
            }

            if (this.domicilio == '')
            {
                this.errDomicilio = "* Debe ingresar Domicilio";
                valid = false;
            }

            if (this.numero == '')
            {
                this.errNumero = "* Debe ingresar Número";
                valid = false;
            }

            if (this.colonia == '')
            {
                this.errColonia = "* Debe ingresar Colonia";
                valid = false;
            }

            if (this.ciudad == '')
            {
                this.errCiudad = "* Debe ingresar Ciudad";
                valid = false;
            }

            if (this.codigoPostal == '')
            {
                this.errCodigoPostal = "* Debe ingresar C.P.";
                valid = false;
            }

            if (this.idUsoCfdi == 0)
            {
                this.errIdUsoCfdi = "* Debe seleccionar el Uso del idUsoCfdi";
                valid = false;
            }

            if (this.credito === '')
            {
                this.errCredito = "* Ingrese Monto de Crédito";
                valid = false;
            }

            if (this.capacidadPago === '' || parseFloat(this.capacidadPago) < parseFloat(this.credito))
            {
                this.capacidadPago = this.credito;                
            }


            return valid;
        },
        mostrarInfo: function(){
            console.log(this.nombreCliente);
        },
        
    }
});
