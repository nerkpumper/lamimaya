

var app = new Vue({
	el: '#app',
	data: {
		idUsuario: '',
		seleccionandoPromotor: true,
		
		queEstoyListando: '',
		
		//datos Promotor
		promotorNombre: '',
		promotorUsuario: '',
		promotorImg: '',
		
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

	    
		filtroNombrePromotor: '',
		
		promotores: [],
		pedidos: []
	},
	mounted: function(){
		this.cargarPromotores();
		
		if (typeof param1 !== 'undefined') {
			this.idUsuario = param1;
			this.seleccionandoPromotor = false;
			setTimeout(function(){ app.seleccionarPromotor(app.idUsuario);}, 500);
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
		seleccionarPromotor: function(idUsuario){
			this.seleccionandoPromotor = false;
			this.idUsuario = idUsuario;
			
			xajax_cargarPromotor (this.idUsuario);
		},
		refrescarDatos: function(){
			xajax_cargarPromotor (this.idUsuario);
		},
		seleccionarOtroPromotor: function(){
			this.seleccionandoPromotor = true;
		},
		dejarPromotor: function(){
			this.seleccionandoPromotor = false;
		},		
		cargarPedidosTodos: function(){
			this.queEstoyListando = "Todos";
			xajax_cargarPedidos(this.idUsuario, "TODOS");
		},
		cargarPedidosSaldados: function(){
			this.queEstoyListando = "Saldados";
			xajax_cargarPedidos(this.idUsuario, "SALDADOS");
		},
		cargarPedidosPorSaldar: function(){
			this.queEstoyListando = "Por Saldar";
			xajax_cargarPedidos(this.idUsuario, "PORSALDAR");
		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "Pedidos Por Promotor", this.promotorNombre, 1);
			//alert("enviamos");
		}
		
		
	}
});