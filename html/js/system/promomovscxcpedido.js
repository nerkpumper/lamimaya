
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
		fecha_descuento: '',
		
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
		movimientospromotor: [],
		
		cargos: 0,
		abonos: 0,
		
		cargosPromotor: 0,
		abonosPromotor: 0,
		
		//abonos
		abonoMovimiento: 'ABONO',
		errAbonoMovimiento: '',
		
		abonoMonto: '',
		errAbonoMonto: '',
		
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
			return this.cargos - this.abonos;
		},
		saldoPromotor: function(){
			return this.cargosPromotor - this.abonosPromotor;
		}
	},
	watch: {
		abonoReferencia: function(value){
			this.abonoReferencia = value.toUpperCase();
		}
	},
	methods: {
		refreshMovtos: function(){
			this.cargarDatosPedido();	
			this.cargarMovimientos();
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
			this.abonoMovimiento = 'ABONO';
			this.errAbonoMovimiento = '';
			
			this.abonoMonto = '';
			this.errAbonoMonto = '';
			
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
			
			this.errAbonoMovimiento = '';			
			this.errAbonoMonto = '';			
			this.errAbonoFormaPago = '';			
			this.errAbonoReferencia = '';
			
			if (this.abonoMovimiento == '0')
			{
				this.errAbonoMovimiento = "Movimiento requerido";
				seguir = false;
			}
			
			if (this.abonoMonto == '0' || this.abonoMonto == "")
			{
				this.errAbonoMonto = "Ingrese Monto mayor a cero";
				seguir = false;
			}
			
			if (this.abonoFormaPago == '0' && this.abonoMovimiento == 'ABONO')
			{
				this.errAbonoFormaPago = "Forma de Pago requerido";
				seguir = false;
			}

			if (this.abonoReferencia == '')
			{
				this.errAbonoReferencia = "Referencia requerida";
				seguir = false;
			}
			
			if (this.abonoMovimiento == 'ABONO')
			{
				if (this.abonoMonto > this.saldo)
				{
					this.errAbonoMonto = "Abono debe ser menor o igual al Saldo";
					seguir = false;
				}
			}
			
			if(this.abonoMovimiento == 'CARGO')
			{
				this.abonoFormaPago = '0';
			}
						
			if (seguir)
			{
				xajax_registrarMovimiento(this.idPedido, this.cteIdCliente, this.abonoMovimiento, this.abonoMonto, this.abonoFormaPago, this.abonoReferencia);
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
			
			$("#ptituloReporte").val("Movimientos CxC Cliente");
			$("#psubTituloReporte").val("Pedido No:" + this.idPedido);
			
            $("#FormularioExportacion").submit();
		},
		sendToExcelPromotor: function(){
			
			var tableHeader = "";
			var tableBody = "";
			
			$("#tablaToExcelPromotor thead tr").each(function (index) {
				 $(this).children("th").each(function (index2) {
					 tableHeader = tableHeader + $(this).text() + "|"; 
				 });
			});
			
			$("#tablaToExcelPromotor tbody tr").each(function (index) {
				 $(this).children("td").each(function (index2) {
					 tableBody = tableBody + $(this).text() + "|"; 
				 });
				 
				 tableBody = tableBody +  "^";
			});
			
			tableHeader = tableHeader.substr(0, tableHeader.length - 1);
			tableBody = tableBody.substr(0, tableBody.length - 1);
			
			$("#pTableHeader").val(tableHeader);
			$("#pTableBody").val(tableBody);
			
			$("#ptituloReporte").val("Movimientos CxC Promotor");
			$("#psubTituloReporte").val("Pedido No:" + this.idPedido);
			
            $("#FormularioExportacion").submit();
		},
		fnRegresarAListado: function(){
			window.location = URL_BASE +  "promoclientepedidos/" + this.cteIdCliente; 
		}
	}
	
});