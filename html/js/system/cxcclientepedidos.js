
var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		idPedido: '',
		seleccionandoCliente: true,

		queEstoyListando: '',
		chkConSaldo:false,

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
		cteCredito: 0,
		saldoPedidosEntregados:0,
		saldoPedidosSinEntregar:0,
		promotor:'',
		saldoTotal:'',
		filtro:'TODOS',
		
		// cteDisponible: 0,

	    //totales pedidos
	    pedidosTotal: 0,
		pedidosSaldados: 0,
		pedidosSinSaldar: 0,
		pedidosCancelados: 0,
		saldoEntregadosCliente:0,
	

		//totales montos
		totalCargos: 0,
		totalAbonos: 0,
		totaSaldosCliente: 0,
		totalSaldoPorEntregar: 1.99,
		totalSaldoEntregado: 1.3,


		filtroNombreCliente: '',
		chkconsaldo:false,

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
		cteDisponible: function(){
			

			return this.cteCredito - this.totalCreditoUtilizado;
		},
		totalSaldo: function(){
			return this.totalCargos - this.totalAbonos;
		},
		totalCreditoUtilizado: function(){
			return this.totalSaldo;
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
		cargarClienteDePedido: function(){

			if (this.idPedido == "")
			{
				saTexto("Indique el Número de Pedido");
				return;
			}


			if (this.idPedido == 0)
			{
				saTexto("Indique el Número de Pedido");
				return;
			}

			xajax_cargarClienteDePedido(this.idPedido);
			
			
			

			
		},
		cargarClientes: function(){
			xajax_cargarClientes(this.chkConSaldo);
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
		cargarPedidosPorSaldarEntregados: function(){
			this.queEstoyListando = "Por Saldar Entregados";
			xajax_cargarPedidos(this.idCliente, "PORSALDARENTREGADOS");
		},
		sendToExcel: function(){

			sendToExcel("tablaToExcel", "Reporte", "Listado de Pedidos del Cliente", "", 1);
			//alert("enviamos");
		},
		sendToExcelTotales: function(){

			sendToExcel("tablaToExcelTotales", "Reporte", "Listado de cxc clientes", "", 1);
			//alert("enviamos");
		}


	}
});
