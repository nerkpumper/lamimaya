
var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		seleccionandoCliente: true,
		
		queEstoyListando: 'Por Saldar',
		quePedidosParam: '',

		//disponible cliente
		verificandoDisponibleParaPagarPedido: false,
		rdDisponible: 0,
		rdTotalPedido: 0,
		rdAbonoMonto: '',
		rdErrAbonoMonto: '',
		rdCliente: '',
		rdIdPedido: 0 ,

		//paginator
		totalReg: 0,
		page: 0,	
		pageSize: 10,
		pageSizeAux: 10,
		loading: false,
		yaSeCargaronPedidos: false,

		//paginator
		totalCliReg: 0,
		cliPage: 0,	
		cliPageSize: 10,

		
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
		this.loadCliPage();
		
		if (typeof param1 !== 'undefined') {
			this.idCliente = param1;
			this.seleccionandoCliente = false;
			setTimeout(function(){ app.seleccionarCliente(app.idCliente);}, 500);
		}
	},	
	watch: {
		rdAbonoMonto: function(value){

			this.rdErrAbonoMonto = '';

			if (this.rdAbonoMonto == '')
			{
				this.rdErrAbonoMonto = '';
				return;
			}

			if (this.rdAbonoMonto == 0)
			{
				this.rdErrAbonoMonto = 'El monto debe ser mayor a cero.';
				return;
			}
			
			if (this.rdAbonoMonto > this.rdDisponible)
			{
				this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Disponible del Cliente.';			
				return;
			}

			if (this.rdAbonoMonto > this.rdTotalPedido)
			{
				this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Saldo del Pedido.';
				return;
			}

		},
		filtroNombreCliente: function(val){
			this.filtroNombreCliente = val.toUpperCase();
		}
	},
	computed: {
		pages: function(){
			var noPages = parseInt(this.totalReg / this.pageSize);

			if (this.totalReg % this.pageSize > 0)
				noPages++;

			return noPages;
		},
		cliPages: function(){
			var noPages = parseInt(this.totalCliReg / this.cliPageSize);

			if (this.totalCliReg % this.cliPageSize > 0)
				noPages++;

			return noPages;
		},
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
		deseoSaldarTodo: function(){
			this.rdAbonoMonto = this.rdTotalPedido;
			this.pagarConReciboDinero();
		},
		pagarConReciboDinero: function(){
		
			if (this.rdAbonoMonto == 0)
			{
				this.rdErrAbonoMonto = 'El monto debe ser mayor a cero.';
				return;
			}
			
			if (this.rdAbonoMonto > this.rdDisponible)
			{
				this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Disponible del Cliente.';			
				return;
			}

			if (this.rdAbonoMonto > this.rdTotalPedido)
			{
				this.rdErrAbonoMonto = 'El monto debe ser menor o igual al Saldo del Pedido.';
				return;
			}

			swal({
		        title: "Atención",
		        text: "Se realizará el Abono al Pedido utilizando el Disponible del Cliente por el Monto que ha indicado.",
		        type: "warning",
		        showCancelButton: true,
		        confirmButtonColor: "#DD6B55",
		        confirmButtonText: "Continuar",
		        cancelButtonText: "Cancelar",
		        closeOnConfirm: true
		    }, function () {
				
				// alert("vamos");
				$("#modalPagarConReciboDinero").modal('toggle');
				mdlShowWait();
				xajax_pagarConReciboDinero(app.rdIdPedido, app.rdAbonoMonto);

		    });
			
		},
		verificarDisponiblePagoPedido: function(idPedido){
			mdlShowWait("Por favor espere", "Verificando Disponible del Cliente");
			this.rdDisponible = 0;
			this.rdTotalPedido = 0;
			this.rdAbonoMonto = '';
			this.rdErrAbonoMonto = '';
			this.rdCliente = '';
			this.rdIdPedido = idPedido;

			// $("#modalPagarConReciboDinero").modal();

			// this.verificandoDisponibleParaPagarPedido = true;
			xajax_verificarDisponiblePagoPedido(this.rdIdPedido);
			// setTimeout(function() { mdlExitWait(); }, 1000);
		},
		loadCliPage: function(){
			xajax_cargarClientes(this.cliPage, this.cliPageSize, this.filtroNombreCliente);
		},
		seleccionarCliente: function(idCliente){
			this.seleccionandoCliente = false;
			this.idCliente = idCliente;
			
			xajax_cargarCliente (this.idCliente);
		},
		seleccionarOtroCliente: function(){
			this.seleccionandoCliente = true;
		},
		refreshCliente: function(){
			
			xajax_cargarCliente (this.idCliente);
		},
		dejarCliente: function(){
			this.seleccionandoCliente = false;
		},		
		cargarPedidosTodos: function(){
			this.yaSeCargaronPedidos = true;			
			this.queEstoyListando = "Todos";
			this.quePedidosParam = "TODOS";
			this.page = 0;
			this.loadPage();
		},
		cargarPedidosSaldados: function(){
			this.queEstoyListando = "Saldados";
			this.quePedidosParam = "SALDADOS";
			this.page = 0;
			this.loadPage();
		},
		cargarPedidosPorSaldar: function(){
			this.queEstoyListando = "Por Saldar";
			this.quePedidosParam = "PORSALDAR";
			this.page = 0;
			this.loadPage();
		},
		loadPage: function(){
			app.loading = true;
			this.pageSize = this.pageSizeAux;
			xajax_cargarPedidos(this.idCliente, this.quePedidosParam, this.page, this.pageSize);
		},
		sendToExcel: function(){
			
			sendToExcel("tablaToExcel", "Reporte", "El titulillo", "El subtitulillo", 1);
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
		previousCliPage: function(){
			this.cliPage--;
			this.loadCliPage();
		},
		nextCliPage: function(){
			this.cliPage++;
			this.loadCliPage();

		}, 
		filtrarCliente: function(){
			this.cliPage = 0;
			this.loadCliPage();
		},
		filtrar: function(){
			
			this.yaSeCargaronPedidos = true;			
			this.page = 0;
			
			this.loadPage();				
		}
		
		
	}
});




$(document).ready(function(){
	
		
		$("#collapseLeftMenu").click();	
	
		
	
	});
	