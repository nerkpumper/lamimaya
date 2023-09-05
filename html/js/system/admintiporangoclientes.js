
var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		seleccionandoCliente: true,
		
		selTipoCliente: 'CTENORMAL',
		chkListaNegra: false,
		chkPagaParaVale: false,	
		selRangoCliente: 'REGULAR',
		
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
		
		// if (typeof param1 !== 'undefined') {
		// 	this.idCliente = param1;
		// 	this.seleccionandoCliente = false;
		// 	setTimeout(function(){ app.seleccionarCliente(app.idCliente);}, 500);
		// }
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
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "El titulillo", "El subtitulillo", 1);
			
		},
		setearTipoRangoCliente: function(index){
			this.indexClienteSeleccionado = index;
			
			if (this.indexClienteSeleccionado >= 0)
			{
				
				this.clienteSeleccionado = this.clientesFiltradosPorNombre[this.indexClienteSeleccionado].nombre;
				
				this.selRangoCliente = this.clientesFiltradosPorNombre[this.indexClienteSeleccionado].rangoCliente;
								
				$('#modalSetPropiedadesCliente').modal('show');	
			}
		},
		savePropiedadesCliente: function(){
					
				
				$('#modalSetPropiedadesCliente').modal('hide');
				swal({
						title: "¿Seguro que deseas continuar?",
						text: "Se cambiarán el Tipo de Cliente.",
						type: "warning",
						showCancelButton: true,
						cancelButtonText: "NO",
						cancelButtonColor: "#ed5565",
						confirmButtonColor: "#1c84c6",
						confirmButtonText: "¡Adelante!",
						closeOnConfirm: false },
	
						function(){

							swal.close();

							xajax_savePropiedadesCliente(app.clientesFiltradosPorNombre[app.indexClienteSeleccionado].idCliente, app.selRangoCliente, app.indexClienteSeleccionado);
						
					});
			

		},
		
		
	}
});


