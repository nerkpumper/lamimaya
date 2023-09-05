

var app = new Vue({
	el: '#app',
	data: {
		idUsuario: '',
		seleccionandoPromotor: true,
		yaSeCargaronPedidos : false,
				
		isPromotor: false,
		
		quePedidosParam: '',

		//paginator
		totalReg: 0,
		page: 0,	
		pageSize: 10,
		pageSizeAux: 10,
		loading: false,

		
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
		pedidosSinSaldarEntregados: 0,
		pedidosSinSaldarNoEntregados: 0,
		pedidosCancelados: 0,
		
		//totales montos
		totalCargos: 0,
		totalAbonos: 0,
		totalSaldosPorEntregar: 0,
		totalSaldosEntregados: 0,

	    
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
		queEstoyListando: function(){
			
			if(this.quePedidosParam == "SALDADOS"){
				return "Saldados";
			}
			else if (this.quePedidosParam == "PORSALDAR"){
				return"Saldos Pedidos Por Entregar";
			}
			else if(this.quePedidosParam == "PORSALDARENTREGADOS"){
				return "Saldos Pedidos Entregados";
			}
			else if (this.quePedidosParam == "TODOS"){
				return "Todos";
			}
			return "";
		},
		pages: function(){
			var noPages = parseInt(this.totalReg / this.pageSize);

			if (this.totalReg % this.pageSize > 0)
				noPages++;

			return noPages;
		},
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
			this.pedidos.splice(0, this.pedidos.length);
			this.queEstoyListando ='';
			this.yaSeCargaronPedidos = false;
			this.seleccionandoPromotor = false;
			this.idUsuario = idUsuario;
			
			xajax_cargarPromotor (this.idUsuario);
		},
		seleccionarOtroPromotor: function(){
			this.seleccionandoPromotor = true;
		},
		dejarPromotor: function(){
			this.seleccionandoPromotor = false;
		},		
		cargarPedidosTodos: function(){
			this.yaSeCargaronPedidos = true;			
			this.quePedidosParam = "TODOS";
			this.page = 0;
			this.loadPage();
		},
		cargarPedidosSaldados: function(){
			this.yaSeCargaronPedidos = true;			
			this.quePedidosParam = "SALDADOS";
			this.page = 0;
			this.loadPage();
		},
		cargarPedidosPorSaldar: function(){
			this.yaSeCargaronPedidos = true;			
			this.quePedidosParam = "PORSALDAR";
			this.page = 0;
			this.loadPage();
		},
		cargarPedidosYaEntregadosPorSaldar: function(){
			this.yaSeCargaronPedidos = true;
			this.quePedidosParam = "PORSALDARENTREGADOS";
			this.page = 0;
			this.loadPage();
		},		
		loadPage: function(){
			app.loading = true;
			this.pageSize = this.pageSizeAux;
			xajax_cargarPedidos(this.idUsuario, this.quePedidosParam, this.page, this.pageSize);
		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "Pedidos Por Promotor", this.promotorNombre, 1);
			//alert("enviamos");
		},
		previousPage: function(){
			this.page--;
			this.loadPage();
		},
		nextPage: function(){
			this.page++;
			this.loadPage();

		},  
		filtrar: function(){
			
			this.yaSeCargaronPedidos = true;			
			this.page = 0;
			
			this.loadPage();				
		}

		
		
	}
});