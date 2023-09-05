var app = new Vue ({
	el: '#app',
	data: {
		seleccionarCotizacion: true,
		
		idCotizacion: '',
		totalCotizacion: 0,
		desctoAplicado: 0,
		porDesctoAplicado: 0,
		estado: '',
		saldada: 'NO',
		subtotal: 0,
		
		desctoAAplicar: 0,
		porDesctoAAplicar: 0,
		
		
		cteIdCliente: 0,
		cteNombre: '',
		cteApellidos: '',
		cteEmpresa: '',
		cteDomicilio1: '',
		cteDomicilio2: '',
		cteNumero: '',
		cteColonia: '',
		cteCiudad: '',
		cteTelefonos: '',
		cteEMail: '',
		cteRFC: '',
		ctePromotor: '',
		
		//movimientos
		movimientos: [],
		
		cargos: 0,
		abonos: 0,
		total: 0,
		//abonos
		desctoMovimiento: 'MONTO',
		errdesctoMovimiento: '',
		
		desctoMonto: '',
		errDesctoMonto: '',
		
		
		
		abonoFormaPago: '0',
		errAbonoFormaPago: '',	
		
		abonoReferencia: '',
		errAbonoReferencia: '',
		
		ingresarMovimiento: false,
		
		pruebaHeader: '',
		pruebaBody: '',
		
	},
	mounted: function(){
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;
						
			this.cargarDatosCotizacion();	
			this.cargarMovimientos();
		}
			
	},
	computed: {
		saldo: function(){
			return Math.round((this.cargos - this.abonos) * 100) / 100;
		}
	},
	watch: {
		abonoReferencia: function(value){
			this.abonoReferencia = value.toUpperCase();
		},
		desctoMovimiento: function(value){
			this.errDesctoMonto = '';
			this.calcularDesctos();
		},		
		desctoMonto: function(value){
			
			this.errDesctoMonto = '';
			this.calcularDesctos();
		}
	},
	methods: {
		
		calcularDesctos: function(){
			if (this.desctoMovimiento == "MONTO")
			{
				this.desctoAAplicar = this.desctoMonto;
				
				this.porDesctoAAplicar = formatNumber((this.desctoMonto * 100) / this.totalPedido);
				
			}
			else
			{
				this.porDesctoAAplicar = this.desctoMonto;
				
				this.desctoAAplicar = (this.desctoMonto * this.totalPedido) / 100;
			}	
		},
		cargarDatosCotizacion: function(){
			
			if (this.idCotizacion == "")
			{
				saTexto("Ingrese algun valor");
				return;
			}
			if (this.idCotizacion == 0)
			{
				saTexto("Ingrese cantidad mayor a cero ");
				return;
			}						
			xajax_cargarDatosCotizacion(this.idCotizacion);	
			xajax_cargarMontos(this.idCotizacion);
			this.ingresarMovimiento = false;
			this.seleccionarCotizacion = false;			
		},
		cargarMovimientos: function(){
			xajax_cargarMontos(this.idCotizacion);
		},
		seleccionarOtraCotizacion: function(){
			this.idCotizacion = '';
			this.seleccionarCotizacion = true;
		},
		generarMovimiento: function(){
			this.ingresarMovimiento = true;
		},
		cancelarMovimiento: function(){
			this.ingresarMovimiento = false;
		},
		guardarMovimiento: function(){
			
			var seguir = true;
			
			// this.errdesctoMovimiento = '';			
			// this.errDesctoMonto = '';			
			// this.errAbonoFormaPago = '';			
			// this.errAbonoReferencia = '';
			
			// if (this.desctoMovimiento == '0')
			// {
			// 	this.errdesctoMovimiento = "Movimiento requerido";
			// 	seguir = false;
			// }
			
			if (this.desctoMonto == '0' || this.desctoMonto == "")
			{
				this.errDesctoMonto = "Ingrese Algun Valor ";
				seguir = false;
			}
			
//			if (this.abonoFormaPago == '0' && this.desctoMovimiento == 'ABONO')
//			{
//				this.errAbonoFormaPago = "Forma de Pago requerido";
//				seguir = false;
//			}

//			if (this.abonoReferencia == '')
//			{
//				this.errAbonoReferencia = "Referencia requerida";
//				seguir = false;
//			}
			
			
				// if (this.desctoAAplicar > this.saldo)
				// {
				// 	if (this.desctoMovimiento == "MONTO")
				// 	{
				// 		this.errDesctoMonto = "Monto debe ser menor o igual al Saldo";	
				// 	}
				// 	else
				// 	{
				// 		this.errDesctoMonto = "Monto debe ser menor o igual al Saldo. Disminuya el porcentaje.";
				// 	}
					
				// 	seguir = false;
				// }
			
			
//			if(this.desctoMovimiento == 'CARGO')
//			{
//				this.abonoFormaPago = '0';
//			}
						
			if (seguir)
			{
				
				swal({
					title: "¿Seguro que deseas continuar?",
					text: "Se aplicará el Descuento indicado a la cotizacion ",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "NO",
					cancelButtonColor: "#ed5565",
					confirmButtonColor: "#1c84c6",
					confirmButtonText: "¡Adelante!",
					closeOnConfirm: false },

					function(){
//						swal("¡Hecho!",
//								"Acabas de vender tu alma al diablo.",
//								"success");
						
						swal.close();
//						alert("a autorizar: " + idPedido + '  ' + observacion);
						xajax_registrarDescuento(app.idCotizacion, app.desctoAAplicar, app.porDesctoAAplicar);
						
					
				});
				
//				xajax_registrarMovimiento(this.idPedido, this.cteIdCliente, this.desctoMovimiento, this.desctoMonto, this.abonoFormaPago, this.abonoReferencia);
			}
		},
		
		fnRegresarAListado: function(){
			window.location = URL_BASE +  "adminclientepedidos/" + this.cteIdCliente; 
		}
	}
	
});