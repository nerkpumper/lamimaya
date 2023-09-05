
Vue.component('cliente-dirfiscales-selector', {
        props: ['leyendashow', 'shownombrecliente', 'seleccionarsinrfcs'],
        data: function () {
            return {
                count: 0,
                idCliente: 0,
                nombreCliente: '',   

                idToExclude: 0,

                page: 0,
                totalReg: 0,
                pageSize: 5,


                filtro: '',            
                
                direcciones: [],
                deOtros: false,

                
                
            }
        },
        watch: {
            filtro: function(value){
                this.filtro = value.toUpperCase();
            }
        },     
        methods: {
            show: function(idCliente, nombreCliente, deotros = false, idToExclude = 0){
            
                this.idCliente = idCliente;
                this.nombreCliente = nombreCliente;
                this.filtro = '';
                this.deOtros = deotros;
                this.page = 0;
                this.idToExclude = idToExclude;
                this.loadPage();
                
                $('#mdlDirFiscalSelector').modal('show');
                
            },            
            filtrar: function(){
                this.page = 0;
                this.loadPage();
            },
            loadPage: function(){
                var vm = this;

                $.ajax({	
                    dataType: "json",
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/datosfacturacion.api.php?method=getDireccionesPage&idCliente=' + this.idCliente + '&page=' + this.page + "&pageSize=" + this.pageSize + "&filtro="+ this.filtro + (this.deOtros ? '&deotros=true' : ''),
                        success:function(response){
                            vm.totalReg = response.totalregs;
                            vm.direcciones = response.list;
                            setTimeout(function() { vm.$refs.buscar.focus(); }, 1000);    
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });

                // axios.get(URL_BASE + 'api/datosfacturacion.api.php?method=getDireccionesPage&idCliente=' + this.idCliente + '&page=' + this.page + "&pageSize=" + this.pageSize + "&filtro="+ this.filtro + (this.deOtros ? '&deotros=true' : ''), getAxiosHeaders())
                // .then(function (response) {
                //     vm.totalReg = response.data.totalregs;
                //     vm.direcciones = response.data.list;
                //     setTimeout(function() { vm.$refs.buscar.focus(); }, 1000);    
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });
            } ,
            modalNuevaDireccion: function(){                                		
                this.$refs.nuevaDireccion.show(this.idCliente, this.nombreCliente); 
            },
            onSelect: function(index){
                
                if (index >= 0 ){
                    
                    var selected = this.direcciones[index];
                    var obj = {
                            idCliente: selected.idCliente,
                            idClienteDatosFacturacion: selected.idClienteDatosFacturacion,
                            idDatosFacturacion: selected.idDatosFacturacion,
                            rfc: selected.rfc,
                            email: selected.email,
                            razonSocial: selected.razonSocial,
                            domicilio: selected.domicilio,
                            numero: selected.numero,
                            colonia: selected.colonia,
                            ciudad: selected.ciudad,
                            codigoPostal: selected.codigoPostal,
                            idUsoCfdi: selected.idUsoCfdi,
                            privado: selected.privado
                        }
                    this.$emit("on-select", obj);
                    $('#mdlDirFiscalSelector').modal('toggle');
                    
                }
            },
            onNoSelect: function(){
                
                var obj = {                        
                        idClienteDatosFacturacion: 0,                        
                        }
                this.$emit("on-select", obj);
                $('#mdlDirFiscalSelector').modal('toggle');
                    
                
            },
            onSave: function(event){
                this.loadPage();                
            },
            previousPage: function(){
                this.page--;
                this.loadPage();
            },
            nextPage: function(){
                this.page++;
                this.loadPage();
            },
        },
        computed: {
            pages: function(){
                var noPages = parseInt(this.totalReg / this.pageSize);

                if (this.totalReg % this.pageSize > 0)
                    noPages++;

                return noPages;
            }
        },
        template: `
            <div>
                <cliente-dirfiscales-new-edit @on-save="onSave($event)" ref="nuevaDireccion"></cliente-dirfiscales-new-edit>
            
                <div class="modal inmodal fade" id="mdlDirFiscalSelector" tabindex="-1" style="z-index: 2200 !important;"
                    role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <h4 v-if="shownombrecliente" class="modal-title">{{ nombreCliente }}</h4>
                                <h3 v-if="leyendashow">
                                    {{ leyendashow }}
                                </h3>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                </button>
                                
                                

                            </div>
                            <div class="modal-body">   
                                <div class="text-center" v-if="seleccionarsinrfcs">                                    
                                    <button @click.prevent="onNoSelect" class="btn btn-warning"> Asociar el Pedido al Cliente, no a alg&uacute;n RFC</button>
                                    <br><br>
                                </div>
                                <div v-if="direcciones.length > 0" class="table-responsive">
                                    <div class="input-group m-b">
                                        <!--<span class="input-group-addon"><i class="fa fa-search"></i></span> -->
                                        <input type="text" v-model="filtro" :keyup.enter="filtrar" ref="buscar" class="form-control">
                                        <span @click.prevent="filtrar"  class="input-group-addon btn btn-primary"><i class="fa fa-search"></i></span> 
                                    </div>   

                                    <div v-if="direcciones.length > 0" class="col-sm-2">
                                        <div class="input-group m-b">
                                            <span class="input-group-btn">
                                                <button @click.prevent="previousPage" type="button" class="btn btn-white" :disabled="page == 0"><i class="fa fa-chevron-left"></i></button> 
                                            </span> 
                                            <input type="text" :value="'(' + totalReg + ' Regs.)  Pag. ' + (page + 1) + ' / ' + pages" class="form-control text-center" style="width: 200px" disabled>
                                            <span class="input-group-btn">
                                                <button @click.prevent="nextPage" type="button" class="btn btn-white" :disabled="page == (pages - 1)"><i class="fa fa-chevron-right"></i></button> 
                                            </span>     
                                        </div>                                                            
                                    </div>        
                                    <div>
                                    
                                        <button  @click="modalNuevaDireccion" class="btn btn-primary btn-xs pull-right" ><i class="fa fa-plus"></i> Nuevo RFC</button>
                                    </div> 
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>RFC</th>
                                                <th>Email</th>
                                                <th>Raz&oacute;n Social</th>
                                                <th>Domicilio</th>
                                                <th>R&eacute;gimen</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(dir, index) in direcciones">
                                                <td><i :class="'fa fa-' + (dir.privado == 'SI' ? 'lock text-navy' : 'unlock text-danger')"></i> {{ dir.rfc }}</td>
                                                <td>{{ dir.email }}</td>
                                                <td>{{ dir.razonSocial }}</td>
                                                <td>{{ dir.domicilio + ' ' + dir.numero + ' ' + dir.colonia + ' ' + dir.ciudad }}</td>
                                                <td>{{ dir.regimenfiscal }}</td>
                                                <td>                                                
                                                    <button v-show="dir.idClienteDatosFacturacion != idToExclude" class="btn btn-primary btn-xs" @click.prevent="onSelect(index)"><i class="fa fa-check"></i> Seleccionar</button> 
                                                    <span v-show="dir.idClienteDatosFacturacion == idToExclude" class="badge badge-info">RFC Asignado</span>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
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