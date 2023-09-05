
Vue.component('concepto-gasto-new-edit', {
  data: function () {
    return {
        idTipoGasto: 0,
                
        descripcion: '',
        
        errDescripcion: '',
    }
  },
  template: `
        <div class="modal inmodal fade" id="mdlNuevoConceptoGasto" tabindex="-1" style="z-index: 2600 !important;"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Concepto de Gasto</h4>
                        

                    </div>
                    <div class="modal-body">                        
                        <div class="row">			
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group "  :class="{'has-error': errDescripcion}">
                                    <label class="control-label">Descripci&oacute;n</label> 
                                    <input type="text" @keyup.enter="guardarConceptoGasto" v-model="descripcion" ref="descripcion" placeholder="" maxlength="20" class="form-control">
                                    <span class="text-danger">{{ errDescripcion }}</span>                                    
                                </div>
                            </div>	
                           
                        </div>
                                                    
                        <div class="clearfix"></div>                        
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="button" @click.prevent="guardarConceptoGasto" class="btn btn-primary pull-right">Guardar</button>				
                    </div>
                </div>
            </div>
        </div>
  
  `,
    
    watch: {
        descripcion: function(value){
            this.descripcion = value.toUpperCase();
        }
    },
    methods: {  
        clearData: function(){
            this.descripcion = '';
            
        },   
        clearErrors: function(){
            this.errDescripcion = '';
            
        },   
        show: function(idTipoGasto = 0){
            
            
            this.idTipoGasto = idTipoGasto;

            if (this.idTipoGasto > 0 )
            {
                
                var vm = this;

                $.ajax({				
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/tipogasto.api.php?method=get&idTipoGasto=' + this.idTipoGasto,
                        success:function(response){
                            if (!response.error)
                            {                        
                                vm.descripcion = response.datosfacturacion.descripcion;
                            }
                            else
                            {
                                saError(response.msg);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });
                
                // axios.get(URL_BASE + 'api/tipogasto.api.php?method=get&idTipoGasto=' + this.idTipoGasto,)
                // .then(function (response) {
                    
                //     if (!response.data.error)
                //     {                        
                //         vm.descripcion = response.data.datosfacturacion.descripcion;
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
            
            var vm=this;
            setTimeout(function() { vm.$refs.descripcion.focus(); }, 1000);    
            
            $('#mdlNuevoConceptoGasto').modal('show');
        },
        guardarConceptoGasto: function(){
            
            if (this.validarDatos()){
                
                var form_data = new FormData();                
		        form_data.append('idTipoGasto', this.idTipoGasto);
                form_data.append('descripcion', this.descripcion);

                var objData = {
                    idTipoGasto: this.idTipoGasto,
                    descripcion: this.descripcion
                
                }
                
                var vm = this;
                
                $.ajax({	
                    type: 'POST',			
                    dataType: "json",
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/tipogasto.api.php?method=save',
                    // data: form_data,
                    data: objData,
                        success:function(response){
                            if (!response.error)
                            {
                                var obj = {                            
                                    idTipoGasto: response.idTipoGasto,
                                    descripcion: vm.descripcion,                            
                                }
                                vm.$emit("on-save", obj);
                                $('#mdlNuevoConceptoGasto').modal('toggle');
                                saSuccess("Concepto Gasto almacenado con éxito");
                            }
                            else
                            {
                                saError(response.msg);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });
                
                // axios.post(URL_BASE + 'api/tipogasto.api.php?method=save', form_data)
                // .then(function (response) {
                    
                //     if (!response.data.error)
                //     {
                //         var obj = {                            
                //             idTipoGasto: response.data.idTipoGasto,
                //             descripcion: vm.descripcion,                            
                //         }
                //         vm.$emit("on-save", obj);
                //         $('#mdlNuevoConceptoGasto').modal('toggle');
                //         saSuccess("Concepto Gasto almacenado con éxito");
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
            
            if (this.descripcion == '')
            {
                this.errDescripcion = "* Debe ingresar descripcion";
                valid = false;
            }

            
            return valid;
        }        
    }
});
