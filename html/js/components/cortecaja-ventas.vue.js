
Vue.component('cortecaja-ventas', {
        data: function () {
            return {
                idSucursal: 0,
                fechaApertura: '',
                fechaCorte: '',

                list: [],
                //paginacion
                page: 0,
                pageSize: 10,
                pageTotalRegs: 0,
            }
        },
        computed: {
            pages: function(){
                var noPages = parseInt(this.pageTotalRegs / this.pageSize);

                if (this.pageTotalRegs % this.pageSize > 0)
                    noPages++;

                return noPages;
            }
        },       
        methods: {
            start: function(idSucursal, fechaApertura, fechaCorte){
                this.idSucursal = idSucursal;
                this.fechaApertura = fechaApertura;
                this.fechaCorte = fechaCorte;
                this.loadPage();
            },
            loadPage: function(){
                var vm = this;

                axios.get(URL_BASE + 'api/cortecaja.api.php?method=getVentasPage&idSucursal=' + this.idSucursal +  '&page=' + this.page + "&pageSize=" + this.pageSize + "&fechaApertura=" + this.fechaApertura + "&fechaCorte=" + this.fechaCorte, getAxiosHeaders())
                .then(function (response) {
					
                    vm.pageTotalRegs = response.data.totalregs;
                                       
                    vm.list = response.data.list;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
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
        template: `
            <div>                
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
                                <th>Pedido</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Usuario</th>                                                                
                            </tr>                    
                        </thead>
                        <tbody>
                            <tr v-for="item in list">                                
                                <td>{{ item.idPedido }}</td>
                                <td>{{ formatNumber(item.monto) }}</td>
                                <td>{{ item.fecha}}</td>
                                <td>{{ item.cliente}}</td>
                                <td>{{ item.usuario }}</td>                                
                            </tr>                    
                        
                        </tbody>
                    </table>
                </div>
            </div>
        
        `
        });