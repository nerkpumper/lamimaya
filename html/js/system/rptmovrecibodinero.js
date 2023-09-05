var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		idPedido: '',
		seleccionandoCliente: true,

		queEstoyListando: '',

		chkConSaldo: false,

		//datos cliente
	    nombre: '',
	    empresa: '',
	    domicilio1: '',
	    domicilio2: '',
	    numero: '',
	    colonia: '',
	    ciudad: '',
	    telefonos: '',
	    rfc: '',
	    estado: '',
		promotor: '',
		cteCredito: 0,

		//anticipo clientes
		idMovReciboDinero: 0,
		monto: 0,
		idReciboDinero: 0,
		idPedido: '',
		movimiento: '',
		observaciones: '',

		filtroNombreCliente: '',

		abonoReferencia: '',
		errreferencia: '',

		ingresarMovimiento: false,

		pruebaHeader: '',
		pruebaBody: '',
		movimiento: '',

		clientes: [],
		pedidos: [],
		movimientos: []
	},
	mounted: function(){
		this.cargarClientes();

		if (typeof param1 !== 'undefined') {
			this.idCliente = param1;
			this.seleccionandoCliente = false;
			setTimeout(function(){ app.seleccionarCliente(app.idCliente);}, 500);
		}
		//xajax_cargarTotales(this.idCliente);
	},
	watch: {
		filtroNombreCliente: function(val){
			this.filtroNombreCliente = val.toUpperCase();
		}
	},
	computed: {

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
			xajax_cargarClientes(this.chkConSaldo);
		},
		seleccionarCliente: function(idCliente){
			this.seleccionandoCliente = false;
			this.idCliente = idCliente;
            xajax_cargarRecibos(this.idCliente); 
			xajax_cargarCliente (this.idCliente);
		},
		seleccionarOtroCliente: function(){
			this.seleccionandoCliente = true;
		},
		dejarCliente: function(){
			this.seleccionandoCliente = false;
		},

		guardarMovimiento: function(){
			if (seguir)
			{
				
				xajax_guardarReciboDinero(this.idCliente, this.monto, this.saldoactual, this.formapago, this.referencia);
			
				window.location = URL_BASE +  "rptmovrecibodinero";
			}	
			
		},

	}
});




