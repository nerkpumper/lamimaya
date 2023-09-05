var app = new Vue({
    el: '#app',
    data: {
        fechaApertura: '',
        fechaCorte: '',
        strFechaCorte: '',
        idSucursal: 0,
        dejarEnCaja: 0,
        idCorteCaja: 0,
        idSucursalSeleccionada: 0,
        isAdmin:false, 
        
       

        detalle: '',

        corteRealizado: false,

        dineroCaja: [
            {
                concepto: 'Fondo de Caja',
                monto: 0,
                signo: '+'
            },
            {
                concepto: 'Ventas en Efectivo',
                monto: 0,
                signo: '+'
            },
            {
                concepto: 'Abonos en Efectivo',
                monto: 0,
                signo: '+'
            },
            {
                concepto: 'Entradas',
                monto: 0,
                signo: '+'
            },
            {
                concepto: 'Salidas',
                monto: 0,
                signo: '-'
            },
        ],

        lstCortes: [],
       
        lstVentas: [],
        lstAbonos: [],
        lstSalidas: [],
        lstEntradas: [],
        lstSucursales: [],

        sucursal: {}


    },
    mounted: function(){
        if(_IDROL == 1 || _IDROL == 6 || _IDROL == 2 )
		{
			this.isAdmin = true;
		}

		if (this.isAdmin)
		{
			var vm = this;

			axios.get(URL_BASE + 'api/sucursal.api.php?method=getSucursales')
			.then(function (response) {
			
				vm.lstSucursales = response.data.list;				

			})
			.catch(function (error) {
				console.log(error);
			}); 		 
		}else{ 
            this.idSucursal = _IDSUCURSAL;
            this.fechaCorte = getDateTime("-");
            this.strFechaCorte = changeDateToDMY(this.fechaCorte);
            this.cargarDatosCorteEnCurso();
            this.getSucursal();
            this.$refs.cortesRealizados.start(this.idSucursal);
         
        
        }  
    },
    computed: {
        getTotal: function(){
            var total = 0;

            this.dineroCaja.forEach(element => {
                if (element.signo == '+')
                    total += parseFloat(element.monto || 0);
                else if (element.signo == '-')
                    total -= parseFloat(element.monto || 0);
            });

            return total;
        },
        getTotalARetirar: function(){
            return this.getTotal - this.dejarEnCaja;
        }
    },
    methods: {
        verDetalle: function(concepto){
            
            switch(concepto)
            {
                case 'Ventas en Efectivo':                    
                    this.detalle = "Ventas";
                    this.$refs.ccVentas.start(this.idSucursal, this.fechaApertura, this.fechaCorte);
                    break;
                case 'Abonos en Efectivo':                    
                    this.detalle = "Abonos";
                    this.$refs.ccAbonos.start(this.idSucursal, this.fechaApertura, this.fechaCorte);
                    break;
                case 'Entradas':                    
                    this.detalle = "Entradas";
                    this.$refs.ccEntradas.start(this.idSucursal, this.fechaApertura, this.fechaCorte);
                    break;
                case 'Salidas':                    
                    this.detalle = "Salidas";
                    this.$refs.ccSalidas.start(this.idSucursal, this.fechaApertura, this.fechaCorte);
                    break;
            }
        },
        cargarDatosCorteEnCurso: function(){
            if (this.idSucursal > 0)
            {
                var vm = this;

                axios.get(URL_BASE + 'api/cortecaja.api.php?method=currentCorte&idSucursal=' + this.idSucursal + "&fechaCorte=" + this.fechaCorte)
                .then(function (response) {
                   
                    vm.fechaApertura = response.data.corteCaja.fecha_apertura;
                    vm.idCorteCaja = response.data.corteCaja.idCorteCaja;
                                 
                    vm.dineroCaja[0].monto = response.data.corteCaja.fondoCajaApertura;  
                    vm.dineroCaja[1].monto = response.data.efectivos.venta;  
                    vm.dineroCaja[2].monto = response.data.efectivos.abono;  
                    vm.dineroCaja[3].monto = response.data.efectivos.recibodinero;  
                    vm.dineroCaja[4].monto = response.data.efectivos.gastos; 

                })
                .catch(function (error) {
                    console.log(error);
                });  
            }
        },
        getSucursal: function(){
            if (this.idSucursal > 0)
            {
                var vm = this;

                axios.get(URL_BASE + 'api/sucursal.api.php?method=get&idSucursal=' + this.idSucursal)
                .then(function (response) {
                   
                    vm.sucursal = response.data.sucursal;
                })
                .catch(function (error) {
                    console.log(error);
                });  
            }
        },
        cargarCorteSucursal: function(){
                this.limpiarDatos();
              
             if(this.idSucursalSeleccionada > 0 ){
                this.idSucursal = this.idSucursalSeleccionada;
                this.fechaCorte = getDateTime("-");
                this.strFechaCorte = changeDateToDMY(this.fechaCorte);
                this.cargarDatosCorteEnCurso();
                this.getSucursal();
                this.$refs.cortesRealizados.start(this.idSucursal);
             }
        },
        crearCorte: function(){
            var form_data = new FormData();
            form_data.append('idCorteCaja', this.idCorteCaja);
            form_data.append('fondoApertura', this.dineroCaja[0].monto);
            form_data.append('ventas', this.dineroCaja[1].monto);
            form_data.append('abonos', this.dineroCaja[2].monto);
            form_data.append('entradas', this.dineroCaja[3].monto);
            form_data.append('salidas', this.dineroCaja[4].monto);
            form_data.append('dejaEnFondo', this.dejarEnCaja);
            form_data.append('idSucursal', this.idSucursal);
            
            var vm = this;
            axios.post(URL_BASE + 'api/cortecaja.api.php?method=save', form_data, getAxiosHeaders())
            .then(function (response) {
                console.log(response.data);
                if (!response.data.error)
                {
                    var obj = {
                        idCorteCaja: response.data.idCorteCaja,
                        
                    }
                    vm.$emit("on-save", obj);                    
                    saSuccess("Corte realizado con éxito");
                    vm.corteRealizado = true;
                    vm.$refs.cortesRealizados.loadPage();
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

        limpiarDatos: function(){

            this.dineroCaja[0].monto = 0;  
            this.dineroCaja[1].monto = 0;  
            this.dineroCaja[2].monto = 0;  
            this.dineroCaja[3].monto = 0;  
            this.dineroCaja[4].monto = 0; 
            this.lstAbonos.splice(0, this.lstAbonos.length);
            this.lstEntradas.splice(0, this.lstEntradas.length);
            this.lstSalidas.splice(0, this.lstSalidas.length);
            this.lstCortes.splice(0, this.lstCortes.length);
            this.lstVentas.splice(0, this.lstVentas.length);

        },
        realizarCorte: function(){
            if (this.getTotal <= 0){
                saInfo("No se cuenta con Efectivo para hacer corte");
                return;
            }

            if (this.dejarEnCaja === ""){
                saInfo("El Monto a dejar en Caja debe ser mayor o igual a cero.");
                return;
            }
            
            swal({
					title: "Atención",
					text: "Se realizará el Corte de Caja, dejando para Caja Chica:  $" + formatNumber(this.dejarEnCaja) + ". Lo que usted retirará será la cantidad de $" + formatNumber(this.getTotalARetirar) + " ¿Desea Continuar?",
					type: "info",					
					showCancelButton: true,
					confirmButtonColor: "#1ab394",
					confirmButtonText: "SI, hacer el corte",
					cancelButtonText: "NO",
					closeOnConfirm: false,
				}, function (resp) {
                    // swal.close();
					if (resp){
                        app.crearCorte();
					}					
				});


        }
    }    
});