
var app = new Vue({
	el: '#app',
	data: {
		idPromotor: '',
		seleccionandoPromotor: true,
		
		indexPromotorSeleccionado: -1,
		creditoAAsignar: 0,
		promotorSeleccionado: '',
		
		queEstoyListando: '',
		
		//datos promotor		
	    nombre: '',	    
	    empresa: '',
	    domicilio1: '',
	    domicilio2: '',
	    numero: '',
	    colonia: '',
	    ciudad: '',
	    telefonos: '',
	    email: '',
	    rfc: '',	    
	    estado: '',
	    promotor: '',
	    
	    //totales pedidos
	    pedidosTotal: 0,
		pedidosSaldados: 0,
		pedidosSinSaldar: 0,
		pedidosCancelados: 0,
		
		//totales montos
		totalCargos: 0,
		totalAbonos: 0,

	    
		filtroNombrePromotor: '',
		
		promotores: [],
		pedidos: []
	},
	mounted: function(){
		this.cargarPromotores();
		
		if (typeof param1 !== 'undefined') {
			this.idPromotor = param1;
			this.seleccionandoPromotor = false;
			setTimeout(function(){ app.seleccionarPromotor(app.idPromotor);}, 500);
		}
	},	
	watch: {
		filtroNombrePromotor: function(val){
			this.filtroNombrePromotor = val.toUpperCase();
		}
	},
	computed: {
		totalSaldo: function(){
			return this.totalCargos - this.totalAbonos;
		},
		promotoresFiltradosPorNombre:function(){
	    	
	    	 var self=this;
	    	 return this.promotores.filter(function(cust){
	    		 	    		 
	    		 var str = cust.nombre;
	    		 var find = self.filtroNombrePromotor;
   		 	    		 
	    		 return str.includes(find);
	    		 
	    	 });
	      
	    }
	},
	methods: {
		cargarPromotores: function(){
			xajax_cargarPromotores();
		},
		seleccionarPromotor: function(idPromotor){
			this.seleccionandoPromotor = false;
			this.idPromotor = idPromotor;
			
			xajax_cargarPromotor (this.idPromotor);
		},
		seleccionarOtroPromotor: function(){
			this.seleccionandoPromotor = true;
		},
		dejarPromotor: function(){
			this.seleccionandoPromotor = false;
		},		
		cargarPedidosTodos: function(){
			this.queEstoyListando = "Todos";
			xajax_cargarPedidos(this.idPromotor, "TODOS");
		},
		cargarPedidosSaldados: function(){
			this.queEstoyListando = "Saldados";
			xajax_cargarPedidos(this.idPromotor, "SALDADOS");
		},
		cargarPedidosPorSaldar: function(){
			this.queEstoyListando = "Por Saldar";
			xajax_cargarPedidos(this.idPromotor, "PORSALDAR");
		},
		setearCreditoAPromotor: function(index){
			
			this.indexPromotorSeleccionado = index;
			
			if (this.indexPromotorSeleccionado >= 0)
			{
				this.creditoAAsignar = this.promotoresFiltradosPorNombre[this.indexPromotorSeleccionado].numericcredito;
				this.promotorSeleccionado = this.promotoresFiltradosPorNombre[this.indexPromotorSeleccionado].nombre;
				
				$('#modalSetCredito').modal('show');	
			}
			
		},
		saveCreditoPromotor: function(){
			
			
			if (this.creditoAAsignar > 0)				
			{
				
				$('#modalSetCredito').modal('hide');
				swal({
						title: "¿Seguro que deseas continuar?",
						text: "Se registrará el Crédito indicado al Promotor.",
						type: "warning",
						showCancelButton: true,
						cancelButtonText: "NO",
						cancelButtonColor: "#ed5565",
						confirmButtonColor: "#1c84c6",
						confirmButtonText: "¡Adelante!",
						closeOnConfirm: false },
	
						function(){
//							swal("¡Hecho!",
//									"Acabas de vender tu alma al diablo.",
//									"success");
							this.indexPromotorSeleccionado
							swal.close();
//							alert("simon guardar");
							xajax_saveCreditoPromotor(app.promotoresFiltradosPorNombre[app.indexPromotorSeleccionado].idPromotor, app.creditoAAsignar , app.indexPromotorSeleccionado);
						
					});
			}
			

		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "El titulillo", "El subtitulillo", 1);
			//alert("enviamos");
		}
		
		
	}
});/**
 * 
 */