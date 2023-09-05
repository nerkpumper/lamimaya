
Vue.component('concepto-gasto-selector', {        
        data: function () {
            return {                
                filtro: '',            
                
                conceptos: [],
                
            }
        },
        watch: {
            filtro: function(value){
                this.filtro = value.toUpperCase();
            }
        },
        computed: {
            
            conceptosFiltrados: function(){
                var self=this;
				
				return this.conceptos.filter(function(cust){
				 
					var str = cust.descripcion;
					
					var find = self.filtro;
	
					str = str.toUpperCase();
					find = find.toUpperCase();
	
					return str.includes(find);
	
	
	
				});
            }
        },
        methods: {
            show: function(){           
                
                this.filtro = '';
                this.loadConceptos();
                $('#mdlConceptoGastoSelector').modal('show');
                
            },
            loadConceptos: function(){
                var vm = this;
                $.ajax({				
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/tipogasto.api.php?method=getConceptos',
                        success:function(response){
                            vm.conceptos = response.list;                    
                            setTimeout(function() { vm.$refs.buscar.focus(); }, 1000);   
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });


                // axios.get(URL_BASE + 'api/tipogasto.api.php?method=getConceptos', getAxiosHeaders())
                // .then(function (response) {
                    
                //     vm.conceptos = response.data.list;                    
                //     setTimeout(function() { vm.$refs.buscar.focus(); }, 1000);    
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });
            },   
            modalNuevoConcepto: function(){                                		
                this.$refs.nuevoConcepto.show(); 
            },
            onSelect: function(index){
                
                if (index >= 0 ){
                    
                    var { idTipoGasto, descripcion} = this.conceptosFiltrados[index];
                    var obj = {
                        idTipoGasto,
                        descripcion
                    }
                    
                    this.$emit("on-select", obj);
                    $('#mdlConceptoGastoSelector').modal('toggle');
                    
                }
            },            
            onSave: function(event){             
                console.log(event);     
                this.loadConceptos();
            },
        },
        template: `
            <div>
                <concepto-gasto-new-edit @on-save="onSave($event)" ref="nuevoConcepto"></concepto-gasto-new-edit>
            
                <div class="modal inmodal fade" id="mdlConceptoGastoSelector" tabindex="-1" style="z-index: 2200 !important;"
                    role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <h3 >
                                    Seleccione Concepto de Gasto
                                </h3>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                </button>
                                
                                

                            </div>
                            <div class="modal-body">                                   
                                <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-search"></i></span> <input type="text" v-model="filtro" ref="buscar" class="form-control"></div>   
                                <div v-if="conceptos.length > 0" class="table-responsive">
                                                  
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>                                                
                                                <th>Concepto</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(cg, index) in conceptosFiltrados">                                                
                                                <td>{{ cg.descripcion }}</td>
                                                <td>                                                
                                                    <button class="btn btn-primary btn-xs" @click.prevent="onSelect(index)"><i class="fa fa-check"></i> Seleccionar</button> 
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                

                                <div>
                                    
                                    <button  @click="modalNuevoConcepto" class="btn btn-primary btn-xs" ><i class="fa fa-plus"></i> Nuevo Concepto</button>
                                </div>

                                <div class="clearfix"></div>
                                
                                
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        
        `
        });