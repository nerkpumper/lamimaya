var app = new Vue({
	el: '#app',
	data: {
		idCliente: '',
		idPedido: '',
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
	    rfc: '',
	    estado: '',
		promotor: '',
		cteCredito: 0,
		// cteDisponible: 0,

	    //totales pedidos
	    totalRecibos: 0,
		totalSaldo: 0,
		totalUtilizado: 0,
		

		//totales montos
		totalCargos: 0,
		totalAbonos: 0,
		
		//anticipo clientes
		idReciboDinero: 0,
		movimiento: '',
		monto: 0,
		disponible: 0,
		formapago: '',
		referencia: '',
		idusuariomovimiento: '',
		saldada: 'NO',
		fecha:'',
		usuario:'',
		acum: 0,


		filtroNombreCliente: '',
		//abonos
		abonoMovimiento: 'ABONO',
		errmovimiento: '',

		abonoMonto: '',
		errmonto: '',

		
		errformapago: '',

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
		/* cteDisponible: function(){
			var result = 0;

			result = this.cteCredito - this.totalCargos;
			

			return (result >= 0 ? result : 0);
		},
		totalSaldo: function(){
			return this.totalCargos - this.totalAbonos;
		},*/
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
		
		cargarRecibos: function(idCliente){
		
		xajax_cargarRecibos(this.idCliente);
		},
		cargarClientes: function(){
			xajax_cargarClientes();
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
	
	
		
		generarMovimiento: function(){
			this.movimiento = 'ABONO';
			this.emovimiento = '';

			this.monto = '';
			this.monto = '';

			this.formapago = '0';
			this.errformapago = '';

			this.referencia = '';
			this.errreferencia = '';

			this.ingresarMovimiento = true;
		},
		cancelarMovimiento: function(){
			this.ingresarMovimiento = false;
		},
		generarMovimiento: function(){
			this.ingresarMovimiento = true;
			//xajax_cargarTotales(this.idCliente);
		},
		
		guardarMovimiento: function(){

			var seguir = true;
			this.errmovimiento = '';
			this.errmonto = '';
			this.errformaPago = '';
			this.errreferencia = '';
			
			if (this.monto == '0' || this.monto == "")
			{
				this.errmonto = "Ingrese Monto mayor a cero";
				seguir = false;
			}
			if (this.formapago == '0' && this.movimiento == 'ANTICIPO')
			{
				this.errformapago = "Forma de Pago requerido";
				seguir = false;
			}

			if (this.referencia == '')
			{
				this.errreferencia = "Referencia requerida";
				seguir = false;
			}
			if(this.abonoMovimiento == 'CARGO')
			{
				this.formapago = '0';
			}

			if (seguir)
			{
				
				xajax_guardarReciboDinero(this.idCliente, this.monto, this.saldoactual, this.formapago, this.referencia);
			
				// window.location = URL_BASE +  "anticipocliente";
			}	
			
		},
		clearForm: function(){
			this.formapago = 0;
			this.referencia = '';
			this.monto = 0;
		}

	}
});

