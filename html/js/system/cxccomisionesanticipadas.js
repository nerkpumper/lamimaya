
var app = new Vue({
    el: '#app',
    data: {
        mostrarBotonGeneraCorteComision: true,
        mostrarNuevoRegistro: false,
        mostrarCorteComision: false,
        
        seleccionandoPromotor: true,
        filtroNombreCliente: '',

        filtro: {
			promotor: 0,
			nombrePromotor: '',
            img: '',
			monto: 0,
			concepto: 0,
			observacion: ''
			
		}		,
		
		comision: {
			idcortecomision: 0,
			fechainicio: '',
			fechafin: '',
			total: 0,
			comisionadelantada: 0,
			apagar: 0,
			totalpagado: 0,
			saldo: 0,
			pagada: 'NO',
			monto: 0,
			observacion: '',
			incentivo: 0,
			incentivoPorcentaje: 0,
			porcentajeVenta: 0
		},
		
		

		errMonto: '',
		errConcepto: '',
		errObservacion: '',

		errComisionMonto: '',		
		errComisionObservacion: '',

		movimientos: [],
		
        promotores: [],

        pedidos: [],
        
        cortescomision: [],
        comisionesanticipadas: [],
        totalComisiones: 0,

        mostrarGrafico: true,

        comisionTotalComisiones: 0,
        comisionTotalPagadas: 0,
        comisionTotalPorPagar: 0,
        comisionTotalPendiente: 0
    },    
    mounted: function(){
		// alert("montado");
        xajax_cargarPromotores();
        
	//        this.cortescomision.push (
	//        		{
	//        			idcortecomision: 1,
	//        			fecha: '',
	//        			total: 1,
	//        			anticipado: 1,
	//        			neto: 1,
	//        			pagada: 'SI'
	//        		});

    },
    computed: {
    	observacion() {
    		return this.filtro.observacion;	
    	},
    	ccobservacion() {
    		return this.comision.observacion;	
    	}
    },
    watch: {
    	observacion(){
    		this.filtro.observacion = this.filtro.observacion.toUpperCase();
    	},
    	ccobservacion(){
    		this.comision.observacion = this.comision.observacion.toUpperCase();
    	},
    	
    },
    methods: {     
    	registrarPagoComision: function(){
    		
    		var seguir = true;
        	
        	this.limpiarErrores();
        	
        	if (this.comision.monto > this.comision.saldo)
        	{
        		this.errComisionMonto = "El Monto debe ser menor o igual a lo pendiente de pagar.";
        		seguir = false;
        	}
        	
        	if (this.comision.monto <= 0)
        	{
        		this.errComisionMonto = "El Monto debe ser mayor a Cero.";
        		seguir = false;
        	}
        	
        	if (this.comision.observacion == "")
        	{
        		this.errComisionObservacion = "Ingrese una observación.";
        		seguir = false;
        	}
        	
        	if (seguir)
        	{
        		swal({
        			title: "¿Deseas continuar?",
        			text: "Se registrará el pago al Corte de Comisión.",
        			type: "warning",
        			showCancelButton: true,
        			cancelButtonText: "NO",
        			cancelButtonColor: "#ed5565",
        			confirmButtonColor: "#1c84c6",
        			confirmButtonText: "¡Adelante!",
        			closeOnConfirm: false },

        			function(){
        				
        				swal.close();
        				xajax_registrarPagoComision(app.comision.idcortecomision, app.filtro.promotor, app.comision.monto, app.comision.observacion);
        				
        			
        		});
        	}
    		
    		
    		
    		
    	},
    	manejarCorteComision: function(idcortecomision){
    		
    		this.comision.idcortecomision = idcortecomision;
    		this.mostrarNuevoRegistro = false;
        	this.mostrarCorteComision = true;
        	
        	xajax_obtenerCorteComision(this.comision.idcortecomision);
        	this.cargarcxccortecomision();
    	},
    	cargarcxccortecomision: function(){
    		
    		xajax_cargarcxccortecomision(this.comision.idcortecomision);
    	},
    	refresh: function(){
//    		this.nuevoRegistro();
            this.cargarComisionesAnticipadasSinComision();
            this.cargarCortesComision();
    	},
        preparePromotor: function(index){

            this.filtro.promotor = this.promotores[index].id;
            this.filtro.nombrePromotor = this.promotores[index].nombre;
            this.filtro.img = this.promotores[index].img;
			this.seleccionandoPromotor = false;
			
			this.mostrarNuevoRegistro = false;
        	this.mostrarCorteComision = false;            
            
//            this.nuevoRegistro();
            this.cargarComisionesAnticipadasSinComision();
            this.cargarCortesComision();
        },
        cargarComisionesAnticipadasSinComision: function(){
        	xajax_cargarComisionesAnticipadasSinComision(this.filtro.promotor);
        },
        cargarCortesComision: function(){
        	xajax_cargarCortesComision(this.filtro.promotor);
        },
        seleccionarOtroPromotor: function(){
                this.seleccionandoPromotor = true;
        },     
        nuevoRegistro: function(){
        	
        	this.filtro.monto = 0;
        	this.filtro.concepto = 0;
        	this.filtro.observacion = '';
        	
        	this.mostrarNuevoRegistro = true;
        	this.mostrarCorteComision = false;
        },
        registrarDeduccion: function(){
        	var seguir = true;
        	
        	this.limpiarErrores();
        	
        	if (this.filtro.concepto == 0)
        	{
        		this.errConcepto = "Debe seleccionar un Concepto";
        		seguir = false;
        	}
        	
        	if (this.filtro.monto <= 0)
        	{
        		this.errMonto = "El Monto debe ser mayor a cero.";
        		seguir = false;
        	}
        	
        	if (this.filtro.observacion <= 0)
        	{
        		this.errObservacion = "Ingrese alguna Observación.";
        		seguir = false;
        	}
        	
        	
        	
        	if (seguir)
        	{
        		swal({
        			title: "¿Deseas continuar?",
        			text: "Se registrará la Comisión Anticipada para el Promotor indicado.",
        			type: "warning",
        			showCancelButton: true,
        			cancelButtonText: "NO",
        			cancelButtonColor: "#ed5565",
        			confirmButtonColor: "#1c84c6",
        			confirmButtonText: "¡Adelante!",
        			closeOnConfirm: false },

        			function(){
        				
        				swal.close();
        				xajax_registrarDeduccion(app.filtro);
        				
        			
        		});
        		
        	}
        	
        },
        limpiarErrores: function(){
        	this.errMonto = '';
    		this.errConcepto = '';
    		this.errObservacion = '';
    		this.errComisionMonto = '';
    		this.errComisionObservacion = '';
        },
		sendToExcel: function(){

			sendToExcel("tblReporte", "Comisiones", "Listado de Comisiones " + this.filtro.nombrePromotor, "Del: " + this.filtro.fechaInicio + " al: " + this.filtro.fechaFin, 1);
			//alert("enviamos");
		}
    }


});
