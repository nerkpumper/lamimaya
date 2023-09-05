
var app = new Vue ({
	el: '#app',
	data: {
		seleccionarPedido: true,
		idPedido: '',
		estado: '',
		observacionCancelacion: '',
		
		//banderas
		pedidoCancelado: false,
		estatusIncorrecto: false,
		puedeCancelarse: false,
		
		//visibilidad
		mostrarEstatus: false,
		mostrarPedido: true,
		
		verMontos: true,
		verExplosionado: false,
		verListoProducit: true,
		verDespachado: true,
		
		//clases
		claseEstatus: '',
		clasePedido: '',
		
		//
		mostrarFactura: true,
		
		//Datos de Estatus
		capturadoImage: '',
		capturadoPor: '',
		capturadoFecha: '',
		capturaObservacion: '',
		
		autorizadoImage: '',
		autorizadoPor: '',
		autorizadoFecha: '',
		autorizadoObservacion: '',
		
		produccionImage: '',
		produccionPor: '',
		produccionFecha: '',
		
		terminadoImage: '',
		terminadoPor: '',
		terminadoFecha: '',
		
		entregadoImage: '',
		entregadoPor: '',
		entregadoFecha: '',
		
		canceladoImage: '',
		canceladoPor: '',
		canceladoFecha: '',
		cancelaObservacion: '',
		
		//Clientes
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
        
        //consignacion
        personaEntrega: '',
        recogeentrega: '',
        domicilioEntrega: '',
        numeroEntrega: '',
        coloniaEntrega: '',
        ciudadEntrega: '',
        
        //detalle productos
        productos: [],

		//totales
		subtotal: '',
		descuento: '',
		total: ''
		
	},
	mounted: function(){
		if (typeof param1 !== 'undefined') {
			this.idPedido = param1;
						
			this.cargarDatosPedido();					
		}
		
		if (this.mostrarEstatus && this.mostrarPedido)
		{
			this.claseEstatus = "col-lg-3 col-md-3 col-sm-12 col-xs-12";
			this.clasePedido = "col-lg-9 col-md-9 col-sm-12 col-xs-12";
		}
		else
		{
			this.claseEstatus = "";
			this.clasePedido = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
		}
			
	},	
	watch: {
		observacionCancelacion: function (val){
			this.observacionCancelacion = val.toUpperCase();
		}
	},
	methods: {
		cargarDatosPedido: function(){
	//		alert("cargamos");
			
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
						
			this.pedidoCancelado = false;
			this.estatusIncorrecto = false;
			this.puedeCancelarse = false;
			
			xajax_cargarPedido(this.idPedido);	
			this.seleccionarPedido = false;
	//		this.pedidoProduccion = true;			
		},
		seleccionarOtroPedido: function(){
			this.pedidoCancelado = false;
			this.estatusIncorrecto = false;
			this.puedeCancelarse = false;
			this.seleccionarPedido = true;
		},
		cancelarPedido: function(){
			if (this.observacionCancelacion == "")
			{
				saInfo("Debe agregar un motivo de Cancelación");
				return false;
			}
			
			swal({
				title: "¿Seguro que deseas continuar?",
				text: "Se Cancelará el Pedido.",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "NO",
				cancelButtonColor: "#ed5565",
				confirmButtonColor: "#1c84c6",
				confirmButtonText: "¡Adelante!",
				closeOnConfirm: false },

				function(){
//					swal("¡Hecho!",
//							"Acabas de vender tu alma al diablo.",
//							"success");
					
					swal.close();
//					alert("a autorizar: " + idPedido + '  ' + observacion);
					
					xajax_cancelarPedido(app.idPedido, app.observacionCancelacion);
				
			});
			
			
		}
		
	}
	
});