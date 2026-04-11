
var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		
		idPedido: '',
		totalPedido: 0,
		saldo: 0,
		desctoAplicado: 0,
		porDesctoAplicado: 0,
		estado: '',
		saldada: 'NO',

		idSucursal: 0,
		sucursal: {},


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
		lstFormaPago: [],

		cargos: 0,
		abonos: 0,

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
		this.idSucursal = _IDSUCURSAL;
		this.getSucursal();
		this.getLstFormaPago();
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;

			this.cargarDatosPedido();
			this.cargarMovimientos();
			
		}
		
	},
	computed: {
		// saldo: function(){
		// 	return this.cargos - this.abonos;
		// }
	},
	watch: {
		abonoReferencia: function(value){
			this.abonoReferencia = value.toUpperCase();
		}
	},
	methods: {
		getSucursal: function(){
			

			$.ajax({
				headers:{  				
			"Accept":"application/json",//depends on your api
			"Content-type":"application/x-www-form-urlencoded"//depends on your api
				},   url:URL_BASE + 'api/sucursal.api.php?method=get&idSucursal=' + this.idSucursal,
				success:function(response){
					app.sucursal = response.sucursal;
					console.log(response.sucursal);
				}
			});
			
			// console.log("vsmoa a sucursalapi");
			// fetch(URL_BASE + 'api/sucursal.api.php?method=get&idSucursal=' + this.idSucursal, {
            
            // headers: {
            //     "Content-type": "application/json"
            // }})
			// .then(response => {
			
			// 	console.log(response.json());
			// })
			// .then(json => console.log(json))

			
            // if (this.idSucursal > 0)
            // {
            //     var vm = this;

            //     axios.get(URL_BASE + 'api/sucursal.api.php?method=get&idSucursal=' + this.idSucursal)
            //     .then(function (response) {
            //        console.log(response);
            //         vm.sucursal = response.data.sucursal;
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });  
            // }
        },
		getLstFormaPago: function(){
			
            if (this.idSucursal > 0)
            {
              
				$.ajax({
				type: "POST",
				headers:{  				
				"Accept":"application/json",
				"Content-type":"application/x-www-form-urlencoded"
					},   url: URL_BASE + 'api/formadepago.api.php?method=getFormaDePagoSucursal&idSucursal=' + this.idSucursal,
					success:function(response){
						app.lstFormaPago = response.list;
						console.log(response.list);
					}
				});

                // axios.get(URL_BASE + 'api/formadepago.api.php?method=getFormaDePagoSucursal&idSucursal=' + this.idSucursal)
                // .then(function (response) {
                //    console.log(response);
                //     app.lstFormaPago = response.data.list;
                // })
                // .catch(function (error) {
                //     console.log(error);
                // });  
            }
        },
		refreshMovimientos: function(){
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
					// alert(this.saldo);
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
				// alert("guarda");
				mdlShowWait();
				xajax_registrarMovimiento(this.idPedido, this.cteIdCliente, this.abonoMovimiento, this.abonoMonto, this.abonoFormaPago, this.abonoReferencia, this.idSucursal);
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
			window.location = URL_BASE +  "cxcclientepedidos/" + this.cteIdCliente;
		}
	}

});
