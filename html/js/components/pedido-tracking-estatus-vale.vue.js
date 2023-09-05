
Vue.component('pedido-tracking-estatus-vale', {
        
        data: function () {
            return {
                estatusTotalReg: 0,
                estatusPageSize: 7,
                estatusPage: 0,
                estatusTrack: [],

                pedidoTotal: 0,
                pedidoSaldo: 0,
                pedidoCliente: '',

                valesTotalReg: 0,
                valesPageSize: 7,
                valesPage: 0,
                valesTrack: [],

                idPedido: 0,
                
            }
        },    
        mounted: function(){
            
        },
        methods: {
            show: function(idPedido){
                this.idPedido = idPedido;
                this.loadPedido();
                this.loadEstatusPage();
                this.loadValesPage();
            },
            loadPedido: function(){
                var vm = this;
                axios.get(URL_BASE + 'api/cxcdashtrackingpedido.api.php?method=loadPedido&idPedido=' + this.idPedido, getAxiosHeaders())
                .then(function (response) {
                    
                    if (!response.data.error)
                    {
                        vm.pedidoTotal = response.data.pedido.total;
                        vm.pedidoSaldo = response.data.pedido.saldo;
                        vm.pedidoCliente = response.data.pedido.nombreCliente;
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
            loadEstatusPage: function(){
                var vm = this;
                axios.get(URL_BASE + 'api/cxcdashtrackingpedido.api.php?method=getEstatusPage&idPedido=' + this.idPedido +  '&page=' + this.estatusPage + "&pageSize=" + this.estatusPageSize, getAxiosHeaders())
                .then(function (response) {
                    vm.estatusTotalReg = response.data.totalregs;
                                       
                    // vm.estatusTrack = response.data.track;
                    vm.estatusTrack = [];
                    response.data.track.forEach( v => {
                        v.jsonparse = "";
                        if (v.tipo != 'INFO' && v.json != ""){
                            v.jsonparse = JSON.parse(v.json);
                        }
                        v.viewValues = false;

                        vm.estatusTrack.push (v);
                    });
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },            
            previousEstatusPageTrack: function(){
                this.estatusPage--;
                this.loadEstatusPage();
            },
            nextEstatusPageTrack: function(){
                this.estatusPage++;
                this.loadEstatusPage();

            },
            loadValesPage: function(){
                var vm = this;
                axios.get(URL_BASE + 'api/cxcdashtrackingpedido.api.php?method=getValesPage&idPedido=' + this.idPedido +  '&page=' + this.valesPage + "&pageSize=" + this.valesPageSize, getAxiosHeaders())
                .then(function (response) {
                    
                    vm.valesTotalReg = response.data.totalregs;
                                       
                    // vm.valesTrack = response.data.track;
                    vm.valesTrack = [];
                    response.data.track.forEach( v => {
                        v.jsonparse = "";
                        if (v.tipo != 'INFO' && v.json != ""){
                            v.jsonparse = JSON.parse(v.json);
                        }
                        v.viewValues = false;

                        vm.valesTrack.push (v);
                    });
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },  
            previousValesPageTrack: function(){
                this.valesPage--;
                this.loadValesPage();
            },
            nextValesPageTrack: function(){
                this.valesPage++;
                this.loadValesPage();

            },            
            valesViewDetail: function(index, value){
               
                this.valesTrack[index].viewValues = value;
               
            },
            estatusViewDetail: function(index, value){
               
                this.estatusTrack[index].viewValues = value;
               
            }
        },
        computed: {
            estatusPages: function(){
                var noPages = parseInt(this.estatusTotalReg / this.estatusPageSize);

                if (this.estatusTotalReg % this.estatusPageSize > 0)
                    noPages++;

                return noPages;
            },
            valesPages: function(){
                var noPages = parseInt(this.valesTotalReg / this.valesPageSize);

                if (this.valesTotalReg % this.valesPageSize > 0)
                    noPages++;

                return noPages;
            }
        },
        template: `
            <div v-if="idPedido > 0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">

                                <div class="row text-left">
                                    <div class="col-xs-4">
                                        <div class=" m-l-md">
                                        <span class="h4 font-bold m-t block">{{ idPedido }}</span>
                                        <small class="text-muted m-b block">Pedido</small>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <span class="h4 font-bold m-t block">{{ pedidoCliente }}</span>
                                        <small class="text-muted m-b block">Cliente</small>
                                    </div>                                    

                                </div>
                                <div class="row text-left">
                                    <div class="col-xs-4">
                                        <div class=" m-l-md">
                                        <span class="h4 font-bold m-t block">$ {{ formatNumber(pedidoTotal) }}</span>
                                        <small class="text-muted m-b block">Total</small>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <span class="h4 font-bold m-t block">$ {{ formatNumber(pedidoSaldo) }}</span>
                                        <small class="text-muted m-b block">Saldo</small>
                                    </div>                                    

                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tabs-container">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#tabAutoriza">Autorizaci&oacute;n</a></li>
                                                <li class=""><a data-toggle="tab" href="#tabLiberaVales">Liberaci&oacute;n de Vales</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="tabAutoriza" class="tab-pane active">
                                                    <div class="panel-body">
                                                        <h5 v-if="estatusTrack.length == 0">No se encontraron registros de Autorizaci&oacute;n para mostrar</h5>                                                        
                                                        <ul class="list-group clear-list m-t">
                                                            <li v-for="(et, index) in estatusTrack" class="list-group-item fist-item">
                                                                <span class="pull-right">
                                                                    {{ changeDateToDMY(et.fecha) }}
                                                                </span>
                                                                <span v-if="et.tipo == 'INFO'" class="text-info"><i class="fa fa-comment fa-2x"></i></span> 
                                                                <span v-if="et.tipo == 'WARNING'" class="text-warning"><i class="fa fa-exclamation-triangle fa-2x"></i></span> 
                                                                <span v-if="et.tipo == 'ERROR'" class="text-danger"><i class="fa fa-times-circle fa-2x"></i></span> 
                                                                <span v-if="et.tipo == 'SUCCESS'" class="text-navy"><i class="fa fa-check-square-o fa-2x"></i></span> 
                                                                &nbsp;{{ et.trace }}
                                                                                                                                
                                                                <span v-show="et.tipo != 'INFO' && et.json != '' && !et.viewValues">&nbsp;<button @click.prevent="estatusViewDetail(index, true)" class="btn btn-info btn-xs m-r-xs"><i class="fa fa-ellipsis-h"></i></button></span>
                                                                <span  v-show="et.viewValues" >&nbsp;<button @click.prevent="estatusViewDetail(index, false)" class="btn btn-danger btn-xs m-r-xs"><i class="fa fa-ellipsis-h"></i></button></span>
                                                                
                                                                <div v-show="et.viewValues">
                                                                    <br>
                                                                    <pre >
                                                                        {{ et.jsonparse }}
                                                                    </pre>                                                                
                                                                </div>
                                                            </li>
                                                                                                                  
                                                        </ul>
                                                        
                                                        <div v-if="estatusTrack.length > 0" class="col-sm-2">
                                                            <div class="input-group m-b">
                                                                <span class="input-group-btn">
                                                                    <button @click.prevent="previousEstatusPageTrack" type="button" class="btn btn-white" :disabled="estatusPage == 0"><i class="fa fa-chevron-left"></i></button> 
                                                                </span> 
                                                                <input type="text" :value="'(' + estatusTotalReg + ' Regs.)  Pag. ' + (estatusPage + 1) + ' / ' + estatusPages" class="form-control text-center" style="width: 200px" disabled>
                                                                <span class="input-group-btn">
                                                                    <button @click.prevent="nextEstatusPageTrack" type="button" class="btn btn-white" :disabled="estatusPage == (estatusPages - 1)"><i class="fa fa-chevron-right"></i></button> 
                                                                </span>     
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tabLiberaVales" class="tab-pane">
                                                    <div class="panel-body">
                                                        <h5 v-if="estatusTrack.length == 0">No se encontraron registros de Vales para mostrar</h5>                                                        
                                                        <ul class="list-group clear-list m-t">                                                            
                                                            <li v-for="(et, index) in valesTrack" class="list-group-item fist-item">
                                                                <span class="pull-right">
                                                                    {{ changeDateToDMY(et.fecha) }}
                                                                </span>
                                                                <span v-if="et.tipo == 'INFO'" class="text-info"><i class="fa fa-comment fa-2x"></i></span> 
                                                                <span v-if="et.tipo == 'WARNING'" class="text-warning"><i class="fa fa-exclamation-triangle fa-2x"></i></span> 
                                                                <span v-if="et.tipo == 'ERROR'" class="text-danger"><i class="fa fa-times-circle fa-2x"></i></span> 
                                                                <span v-if="et.tipo == 'SUCCESS'" class="text-navy"><i class="fa fa-check-square-o fa-2x"></i></span> 
                                                                &nbsp;{{ et.trace }}                                                                
                                                                <span v-show="et.tipo != 'INFO' && et.json != '' && !et.viewValues">&nbsp;<button @click.prevent="valesViewDetail(index, true)" class="btn btn-info btn-xs m-r-xs"><i class="fa fa-ellipsis-h"></i></button></span>
                                                                <span  v-show="et.viewValues" >&nbsp;<button @click.prevent="valesViewDetail(index, false)" class="btn btn-danger btn-xs m-r-xs"><i class="fa fa-ellipsis-h"></i></button></span>
                                                                
                                                                <div v-show="et.viewValues">
                                                                    <br>
                                                                    <pre >
                                                                        {{ et.jsonparse }}
                                                                    </pre>                                                                
                                                                </div>
                                                            </li>
                                                                                                                  
                                                        </ul>


                                                        <div v-if="valesTrack.length > 0" class="col-sm-2">
                                                            <div class="input-group m-b">
                                                                <span class="input-group-btn">
                                                                    <button @click.prevent="previousValesPageTrack" type="button" class="btn btn-white" :disabled="valesPage == 0"><i class="fa fa-chevron-left"></i></button> 
                                                                </span> 
                                                                <input type="text" :value="'(' + valesTotalReg + ' Regs.)  Pag. ' + (valesPage + 1) + ' / ' + valesPages" class="form-control text-center" style="width: 200px" disabled>
                                                                <span class="input-group-btn">
                                                                    <button @click.prevent="nextValesPageTrack" type="button" class="btn btn-white" :disabled="valesPage == (valesPages - 1)"><i class="fa fa-chevron-right"></i></button> 
                                                                </span>     
                                                            </div>                                                            
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        
        `
        });