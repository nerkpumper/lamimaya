
var app = new Vue({
	el: '#app',
	data: {		
		idTipoGasto: 0,
		errConcepto: '',

		conceptoGasto: '',
		idSucursal: 0,
		errSucursal: '',

		hasSucursal: false,
        isAdmin: false,
		idUsuario:'',

		// form
		monto: 0,
		errMonto: '',
		detalle: '',
		errDetalle: '',

		//paginacion
		page: 0,
		pageSize: 10,
		pageTotalRegs: 0,

		lstSucursales: [],
		lstGastos: []
	},	
	mounted: function(){
		if (_IDSUCURSAL > 0)
		{
			this.hasSucursal = true;
			this.idSucursal = _IDSUCURSAL;	
			this.idUsuario= _IDUSUARIO;	
		}
				
		if(_IDROL == 1)
		{
			this.isAdmin = true;
		}

		if (this.hasSucursal || this.isAdmin)
		{
			var vm = this;
			
			$.ajax({				
                    headers: getAxiosHeaders(),   
                    url: URL_BASE + 'api/sucursal.api.php?method=getSucursales',
                        success:function(response){
                            // console.log(response.list);
							vm.lstSucursales = response.list;
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });

			// axios.get(URL_BASE + 'api/sucursal.api.php?method=getSucursales')
			// .then(function (response) {
			
			// 	vm.lstSucursales = response.data.list;				

			// })
			// .catch(function (error) {
			// 	console.log(error);
			// });  

			this.loadPage();
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
	watch: {	
		detalle: function(value){
			this.detalle = value.toUpperCase();
		}
	},
	methods:{
		seleccionaConcepto: function(){
            this.$refs.gastoConceptoSelector.show();
        },
		onSelectConceptoGasto: function(event){
			console.log(event.idTipoGasto);
			this.idTipoGasto = event.idTipoGasto;
			this.conceptoGasto = event.descripcion;
		},
		guardarGasto: function(){
			
			if (this.datosValidos())
			{
				var form_data = new FormData();
                // form_data.append('idTipoGasto', this.idTipoGasto);		        
                // form_data.append('idSucursal', this.idSucursal);
                // form_data.append('monto', this.monto);
				// form_data.append('detalle', this.detalle);
				
				var objData = {
                    idTipoGasto: this.idTipoGasto,
                    idSucursal: this.idSucursal,
					monto: this.monto,
					detalle: this.detalle, 
					idUsuario: this.idUsuario
                }                           
                var vm = this;

				$.ajax({
					type: 'POST',
					dataType:  "json",				
                    headers: getAxiosHeaders(),   					
                    url: URL_BASE + 'api/gasto.api.php?method=save',
					data: objData,
                        success:function(response){
                            // console.log(response.list);
							if (!response.error)
							{
								var obj = {
									idGasto: vm.idTipoGasto,
									idSucursal: vm.idSucursal,
									monto: vm.idSucursal,
									detalle: vm.detalle,
									idUsuario: vm.idUsuario 
									
								}
								vm.$emit("on-save", obj);
								vm.limpiaForm();
								vm.loadPage();
								
								saSuccess("Gasto almacenado con éxito");
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


                // axios.post(URL_BASE + 'api/gasto.api.php?method=save', form_data, getAxiosHeaders())
                // .then(function (response) {
                    
                //     if (!response.data.error)
                //     {
                //         var obj = {
                //             idGasto: response.data.idGasto,
                            
                //         }
                //         vm.$emit("on-save", obj);
				// 		vm.limpiaForm();
				// 		vm.loadPage();
                        
                //         saSuccess("Gasto almacenado con éxito");
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
		loadPage: function(){
                var vm = this;

				$.ajax({				
                    headers: getAxiosHeaders(),   					
                    url: URL_BASE + 'api/gasto.api.php?method=getGastosPage&idSucursal=' + this.idSucursal +  '&page=' + this.page + "&pageSize=" + this.pageSize,
                        success:function(response){
                    			vm.pageTotalRegs = response.totalregs;
                                       
                    			vm.lstGastos = response.list;
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            console.log("error");
                        }
                    });

                // axios.get(URL_BASE + 'api/gasto.api.php?method=getGastosPage&idSucursal=' + this.idSucursal +  '&page=' + this.page + "&pageSize=" + this.pageSize, getAxiosHeaders())
                // .then(function (response) {
				// 	console.log(response.data);
                //     vm.pageTotalRegs = response.data.totalregs;
                                       
                //     vm.lstGastos = response.data.list;
                    
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });
            },            
		previousPage: function(){
			this.page--;
			this.loadPage();
		},
		nextPage: function(){
			this.page++;
			this.loadPage();
		},
		limpiaErrores: function(){
			this.errConcepto = "";
			this.errDetalle = "";
			this.errMonto = "";
			this.errSucursal = "";
			
		},
		limpiaForm: function(){
			this.conceptoGasto = "";
			this.idTipoGasto = 0;
			this.detalle = "";
			this.monto = "";
			this.sucursal = "";
			
		},
		datosValidos: function(){
			var result = true;
			this.limpiaErrores();
			if (this.idSucursal == 0)
			{
				this.errSucursal = "Debe indicar la sucursal";
				result = false;
			}

			if (this.idTipoGasto == 0)
			{
				this.errConcepto = "Especifique un concepto";
				result = false;
			}

			if (this.monto === "" || parseFloat(this.monto) <= 0)
			{
				this.errMonto = "El monto debe ser mayor a cero";
				result = false;
			}

			if (this.detalle == "")
			{
				this.errDetalle = "Especifique un detalle (referencia, dato extra que desee.)";
				result = false;
			}

			return result;

		}

	}
  
});