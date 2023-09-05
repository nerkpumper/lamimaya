
var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		idPedido: '',
		totalPedido: 0,
		desctoAplicado: 0,
		porDesctoAplicado: 0,
		estado: '',
		saldada: 'NO',
		
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
						
			this.cargarDatosPedido();	
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
		cargarDatosPedido: function(){
			
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
			
			xajax_cargarDatosPedido(this.idPedido);	
			xajax_cargarMontos(this.idPedido);
			
			this.seleccionarPedido = false;			
		},
		cargarMovimientos: function(){
			xajax_cargarMontos(this.idPedido);
		},
		seleccionarOtroPedido: function(){
			this.idPedido = '';
			this.seleccionarPedido = true;
		},
		generarMovimiento: function(){
			this.desctoMovimiento = 'MONTO';
			this.errdesctoMovimiento = '';
			
			this.desctoMonto = '';
			this.errDesctoMonto = '';
			
			this.abonoFormaPago = '0';
			this.errAbonoFormaPago = '';	
			
			this.abonoReferencia = '';
			this.errAbonoReferencia = '';			
			
			this.ingresarMovimiento = true;
		},
		cancelarMovimiento: function(){
			this.ingresarMovimiento = false;
		},
		guardarMovimiento: function(){
			
			var seguir = true;
			
			this.errdesctoMovimiento = '';			
			this.errDesctoMonto = '';			
			this.errAbonoFormaPago = '';			
			this.errAbonoReferencia = '';
			
			if (this.desctoMovimiento == '0')
			{
				this.errdesctoMovimiento = "Movimiento requerido";
				seguir = false;
			}
			
			if (this.desctoMonto == '0' || this.desctoMonto == "")
			{
				this.errDesctoMonto = "Ingrese Monto mayor a cero";
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
			
			
				if (this.desctoAAplicar > this.saldo)
				{
					if (this.desctoMovimiento == "MONTO")
					{
						this.errDesctoMonto = "Monto debe ser menor o igual al Saldo";	
					}
					else
					{
						this.errDesctoMonto = "Monto debe ser menor o igual al Saldo. Disminuya el porcentaje.";
					}
					
					seguir = false;
				}
			
			
//			if(this.desctoMovimiento == 'CARGO')
//			{
//				this.abonoFormaPago = '0';
//			}
						
			if (seguir)
			{
				swal({
					title: "¿Seguro que deseas continuar?",
					text: "Se aplicará el Descuento indicado al Pedido.",
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
						xajax_registrarDescuento(app.idPedido, app.desctoAAplicar, app.porDesctoAAplicar);
					
				});
				
//				xajax_registrarMovimiento(this.idPedido, this.cteIdCliente, this.desctoMovimiento, this.desctoMonto, this.abonoFormaPago, this.abonoReferencia);
			}
		},
		sendToExcel: function(){
			
			var tableHeader = "";
			var tableBody = "";
			
			$("#tablaToExcel thead tr").each(function (index) {
				 $(this).children("th").each(function (index2) {
					 tableHeader = tableHeader + $(this).text() + "|"; 
				 });
			});
			
			$("#tablaToExcel tbody tr").each(function (index) {
				 $(this).children("td").each(function (index2) {
					 tableBody = tableBody + $(this).text() + "|"; 
				 });
				 
				 tableBody = tableBody +  "^";
			});
			
			tableHeader = tableHeader.substr(0, tableHeader.length - 1);
			tableBody = tableBody.substr(0, tableBody.length - 1);
			
			$("#pTableHeader").val(tableHeader);
			$("#pTableBody").val(tableBody);
			
			$("#ptituloReporte").val("Movimientos CxC");
			$("#psubTituloReporte").val("Pedido No:" + this.idPedido);
			
            $("#FormularioExportacion").submit();
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE +  "adminclientepedidos/" + this.cteIdCliente; 
		}
	}
	
});