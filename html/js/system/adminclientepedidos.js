
var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		seleccionandoCliente: true,
		
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
		cargarPedidosTodos: function(){
			this.queEstoyListando = "Todos";
			xajax_cargarPedidos(this.idCliente, "TODOS");
		},
		cargarPedidosSaldados: function(){
			this.queEstoyListando = "Saldados";
			xajax_cargarPedidos(this.idCliente, "SALDADOS");
		},
		cargarPedidosPorSaldar: function(){
			this.queEstoyListando = "Por Saldar";
			xajax_cargarPedidos(this.idCliente, "PORSALDAR");
		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "El titulillo", "El subtitulillo", 1);
			//alert("enviamos");
		}
		
		
	}
});