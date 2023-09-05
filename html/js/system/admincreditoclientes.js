
var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		seleccionandoCliente: true,
		
		indexClienteSeleccionado: -1,
		creditoAAsignar: 0,
		capacidadPagoAAsignar: 0,
		clienteSeleccionado: '',
		
		queEstoyListando: '',
		
		//datos cliente		
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

	    
		filtroNombreCliente: '',
		
		clientes: [],
		pedidos: []
	},
	mounted: function(){
		this.cargarClientes();
		
		if (typeof param1 !== 'undefined') {
			this.idCliente = param1;
			this.seleccionandoCliente = false;
			setTimeout(function(){ app.seleccionarCliente(app.idCliente);}, 500);
		}
	},	
	watch: {
		filtroNombreCliente: function(val){
			this.filtroNombreCliente = val.toUpperCase();
		}
	},
	computed: {
		totalSaldo: function(){
			return this.totalCargos - this.totalAbonos;
		},
		clientesFiltradosPorNombre:function(){
	    	
	    	 var self=this;
	    	 return this.clientes.filter(function(cust){
	    		 	    		 
	    		 var str = cust.nombre;
	    		 var find = self.filtroNombreCliente;
   		 	    		 
	    		 return str.includes(find);
	    		 
	    	 });
	      
	    }
	},
	methods: {
		cargarClientes: function(){
			xajax_cargarClientes();
		},
		seleccionarCliente: function(idCliente){
			this.seleccionandoCliente = false;
			this.idCliente = idCliente;
			
			xajax_cargarCliente (this.idCliente);
		},
		seleccionarOtroCliente: function(){
			this.seleccionandoCliente = true;
		},
		dejarCliente: function(){
			this.seleccionandoCliente = false;
		},		
		setearCreditoACliente: function(index){
			
			this.indexClienteSeleccionado = index;
			
			if (this.indexClienteSeleccionado >= 0)
			{
				this.creditoAAsignar = this.clientesFiltradosPorNombre[this.indexClienteSeleccionado].numericcredito;
				this.capacidadPagoAAsignar = this.clientesFiltradosPorNombre[this.indexClienteSeleccionado].numericcapacidadpago;
				this.clienteSeleccionado = this.clientesFiltradosPorNombre[this.indexClienteSeleccionado].nombre;
				
				$('#modalSetCredito').modal('show');	
			}
			
		},
		saveCreditoCliente: function(){
			
			
			if (this.creditoAAsignar > 0 || this.capacidadPagoAAsignar > 0)
			{
				
				$('#modalSetCredito').modal('hide');
				swal({
						title: "¿Seguro que deseas continuar?",
						text: "Se registrará el Crédito y Capacidad de pago indicado al Cliente.",
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
							this.indexClienteSeleccionado
							swal.close();
							// alert("simon guardar");
							xajax_saveCreditoCliente(app.clientesFiltradosPorNombre[app.indexClienteSeleccionado].idCliente, app.creditoAAsignar , app.capacidadPagoAAsignar, app.indexClienteSeleccionado);
						
					});
			}

			if (this.creditoAAsignar == 0 )
			{
				
				$('#modalSetCredito').modal('hide');
				swal({
						title: "¿Seguro que deseas continuar?",
						text: "Se quitara el Crédito al Cliente.",
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
							this.indexClienteSeleccionado
							swal.close();
							// alert("simon guardar");
							xajax_saveCreditoCliente(app.clientesFiltradosPorNombre[app.indexClienteSeleccionado].idCliente, app.creditoAAsignar , app.capacidadPagoAAsignar, app.indexClienteSeleccionado);
						
					});
			}
			if ( this.capacidadPagoAAsignar == 0)
			{
				
				$('#modalSetCredito').modal('hide');
				swal({
						title: "¿Seguro que deseas continuar?",
						text: "Se quitara la capacidad de pago indicada al Cliente.",
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
							this.indexClienteSeleccionado
							swal.close();
							// alert("simon guardar");
							xajax_saveCreditoCliente(app.clientesFiltradosPorNombre[app.indexClienteSeleccionado].idCliente, app.creditoAAsignar , app.capacidadPagoAAsignar, app.indexClienteSeleccionado);
						
					});
			}
			

		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "Reporte Credigo y capacidad de pago", "", 1);
			//alert("enviamos");
		}
		
		
	}
});/**
 * 
 */